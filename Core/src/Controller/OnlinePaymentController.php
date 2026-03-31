<?php

namespace Croogo\Core\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Http\ResponseEmitter;
use Cake\Http\ServerRequest;
use Croogo\Core\Croogo;
use Cake\Datasource\ConnectionManager;
use DateTime;
use Croogo\Core\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;

class OnlinePaymentController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function cfGetFeeInfo() {
        $this->autoRender = false;
        header('Content-Type: application/json');
        echo json_encode(array('text' => 'omrele'));
        die;
        // $data = json_decode(file_get_contents('php://input'), true);
        $data = json_decode($_POST);
        $user_name = $this->get_settings_value('cf.Username');
        $password = hash("sha512", $this->get_settings_value('cf.Password'));
        if ($user_name == $data['userId'] && $password == $data['password']) {
            $sid = $data['referenceId'];
            $where['payment_status'] = 0;
            $where['transaction_type'] = 'Credit';
            $where['acc_transactions.deleted'] = 0;
            $where['acc_transactions.amount >'] = 0;
            $where['scms_students.sid'] = $sid;
            $acc_transactions = TableRegistry::getTableLocator()->get('acc_transactions');
            $transactions = $acc_transactions->find()->where($where)
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->select([
                                'student_sid' => "scms_students.sid",
                                'name' => "scms_students.name",
                                'student_id' => "scms_students.student_id",
                                'session_name' => "scms_sessions.session_name",
                                'level_name' => "scms_levels.level_name",
                                'section_name' => "scms_sections.section_name",
                                'shift_name' => "hr_shift.shift_name",
                                'father_name' => "scms_guardians.name",
                            ])
                            ->order(['acc_transactions.transaction_id' => 'ASC'])
                            ->join([
                                'scms_student_cycle' => [
                                    'table' => 'scms_student_cycle',
                                    'type' => 'LEFT',
                                    'conditions' => [
                                        'acc_transactions.student_cycle_id = scms_student_cycle.student_cycle_id'
                                    ]
                                ],
                                'scms_students' => [
                                    'table' => 'scms_students',
                                    'type' => 'LEFT',
                                    'conditions' => [
                                        'scms_students.student_id = scms_student_cycle.student_id'
                                    ]
                                ],
                                'scms_sessions' => [
                                    'table' => 'scms_sessions',
                                    'type' => 'LEFT',
                                    'conditions' => [
                                        'acc_transactions.session_id = scms_sessions.session_id'
                                    ]
                                ],
                                'scms_levels' => [
                                    'table' => 'scms_levels',
                                    'type' => 'LEFT',
                                    'conditions' => [
                                        'acc_transactions.level_id = scms_levels.level_id'
                                    ]
                                ],
                                'scms_sections' => [
                                    'table' => 'scms_sections',
                                    'type' => 'LEFT',
                                    'conditions' => [
                                        'scms_student_cycle.section_id = scms_sections.section_id'
                                    ]
                                ],
                                'hr_shift' => [
                                    'table' => 'hr_shift',
                                    'type' => 'LEFT',
                                    'conditions' => [
                                        'scms_student_cycle.shift_id = hr_shift.shift_id'
                                    ]
                                ],
                                'scms_guardians' => [
                                    'table' => 'scms_guardians',
                                    'type' => 'LEFT',
                                    'conditions' => [
                                        'scms_students.student_id = scms_guardians.student_id',
                                        'scms_guardians.rtype = "Father"'
                                    ]
                                ],
                            ])->toArray();
            if (count($transactions)) {
                $transaction = $transactions[0];
                $return_data["referenceId"] = $transaction['student_sid'];
                $return_data["dateTime"] = date('d/m/Y H:i A');
                $return_data["responseCode"] = 00;
                $return_data["responseMsg"] = "SUCCESS";
                $return_data["feeDetails"]["studentId"] = $transaction['student_sid'];
                $return_data["feeDetails"]["instituteName"] = '';
                $return_data["feeDetails"]["branchName"] = '';
                $return_data["feeDetails"]["className"] = $transaction['level_name'];
                $return_data["feeDetails"]["sectionName"] = $transaction['section_name'];
                $return_data["feeDetails"]["invoiceNo"] = $transaction['voucher_no'];
                $return_data["feeDetails"]["studentName"] = $transaction['name'];
                $return_data["feeDetails"]["fatherName"] = $transaction['father_name'];
                $return_data["feeDetails"]["month"] = $this->get_month_name($transaction['month_ids']);
                $return_data["feeDetails"]["academicYear"] = $transaction['session_name'];
                $return_data["feeDetails"]["fee"] = $transaction['amount'];
                $return_data["feeDetails"]["waiver"] = 0;
                $return_data["feeDetails"]["totalDue"] = $transaction['amount'];
            } else {
                $return_data["referenceId"] = null;
                $return_data["dateTime"] = date('d/m/Y H:i A');
                $return_data["responseCode"] = 90;
                $return_data["responseMsg"] = "Data not found";
                $return_data["feeDetails"]["studentId"] = null;
                $return_data["feeDetails"]["instituteName"] = null;
                $return_data["feeDetails"]["branchName"] = null;
                $return_data["feeDetails"]["className"] = null;
                $return_data["feeDetails"]["sectionName"] = null;
                $return_data["feeDetails"]["invoiceNo"] = null;
                $return_data["feeDetails"]["studentName"] = null;
                $return_data["feeDetails"]["fatherName"] = null;
                $return_data["feeDetails"]["month"] = null;
                $return_data["feeDetails"]["academicYear"] = null;
                $return_data["feeDetails"]["fee"] = null;
                $return_data["feeDetails"]["waiver"] = null;
                $return_data["feeDetails"]["totalDue"] = null;
            }
        } else {
            $return_data["referenceId"] = null;
            $return_data["dateTime"] = date('d/m/Y H:i A');
            $return_data["responseCode"] = 90;
            $return_data["responseMsg"] = "Username and Password do not match";
            $return_data["feeDetails"]["studentId"] = null;
            $return_data["feeDetails"]["instituteName"] = null;
            $return_data["feeDetails"]["branchName"] = null;
            $return_data["feeDetails"]["className"] = null;
            $return_data["feeDetails"]["sectionName"] = null;
            $return_data["feeDetails"]["invoiceNo"] = null;
            $return_data["feeDetails"]["studentName"] = null;
            $return_data["feeDetails"]["fatherName"] = null;
            $return_data["feeDetails"]["month"] = null;
            $return_data["feeDetails"]["academicYear"] = null;
            $return_data["feeDetails"]["fee"] = null;
            $return_data["feeDetails"]["waiver"] = null;
            $return_data["feeDetails"]["totalDue"] = null;
        }
        echo json_encode($return_data);
    }

    public function cfPaymentConfirmation() {
        $this->autoRender = false;
        // $data = json_decode(file_get_contents('php://input'), true);
        $return_data["responseCode"] = 90;
        $return_data["responseMsg"] = "Failed";
        $data = json_decode($_POST);
        if ($data['status'] == "APPROVED") {
            $return_data["responseCode"] = 00;
            $return_data["responseMsg"] = "success";
        }
        echo json_encode($return_data);
    }

    private function get_month_name($months) {
        $month_ids = json_decode($months);
        $month = TableRegistry::getTableLocator()->get('acc_months');
        $get_months = $month
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['id IN' => $month_ids])
                ->toArray();
        foreach ($get_months as $get_month) {
            if (isset($name)) {
                $name = $name . ', ' . substr($get_month['month_name'], 0, 3);
            } else {
                $name = substr($get_month['month_name'], 0, 3);
            }
        }
        return $name;
    }

}
