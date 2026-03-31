<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class TeachersController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    private function get_teacher($id = false) {
        $where['role_id'] = 6;
        if ($id) {
            $where['employee_id'] = $id;
        }

        $employees = TableRegistry::getTableLocator()->get('employee');
        $teachers = $employees
                ->find()
                ->where($where)
                ->select([
                    'role_id' => 'u.role_id',
                ])
                ->join([
                    'u' => [
                        'table' => 'users',
                        'type' => 'LEFT',
                        'conditions' => ['employee.user_id = u.id'],
                    ],
                ])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        return $teachers;
    }

    public function index() {
        $teachers = $this->get_teacher();
        $this->set('teachers', $teachers);
    }

    public function assignTeacher() {
        $where = array();
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $where['teachers_user_id'] = $data['teachers_user_id'];
        }
        $this->set('where', $where);
        $teachers = $this->get_teacher();
        $this->set('teachers', $teachers);
        $scms_teaches_assign_courses = TableRegistry::getTableLocator()->get('scms_teaches_assign_courses');
        $assign_courses = $scms_teaches_assign_courses
                ->find()
                ->where($where)
                ->select([
                    'level_name' => 'l.level_name',
                    'section_name' => 's.section_name',
                    'course_name' => 'c.course_name',
                    'course_code' => 'c.course_code',
                    'name' => 'e.name',
                ])
                ->join([
                    'l' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['scms_teaches_assign_courses.level_id = l.level_id'],
                    ],
                    's' => [
                        'table' => 'scms_sections',
                        'type' => 'LEFT',
                        'conditions' => ['scms_teaches_assign_courses.section_id = s.section_id'],
                    ],
                    'c' => [
                        'table' => 'scms_courses',
                        'type' => 'LEFT',
                        'conditions' => ['scms_teaches_assign_courses.course_ids = c.course_id'],
                    ],
                    'e' => [
                        'table' => 'employee',
                        'type' => 'LEFT',
                        'conditions' => ['scms_teaches_assign_courses.teachers_user_id = e.user_id'],
                    ],
                ])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        $this->set('assign_courses', $assign_courses);
    }

    public function assignTeacherAdd() {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $teaches_assign_courses = TableRegistry::getTableLocator()->get('scms_teaches_assign_courses');
            $query = $teaches_assign_courses->query();
            $query
                    ->insert(['teachers_user_id', 'level_id', 'section_id', 'course_ids'])
                    ->values($data)
                    ->execute();
            //Set Flash
            $this->Flash->success('Teacher Successfully Added', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'assignTeacher']);
        }

        $teachers = $this->get_teacher();
        $this->set('teachers', $teachers);
        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);
    }

    public function deleteAssignTeacher($id) {
        $this->autoRender = false;
        $scms_teaches_assign_courses = TableRegistry::getTableLocator()->get('scms_teaches_assign_courses');
        $query = $scms_teaches_assign_courses->query();
        $query->delete()
                ->where(['teaches_assign_courses_id' => $id])
                ->execute();

        $this->Flash->success('Teacher Successfully Removed', [
            'key' => 'positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'assignTeacher']);
    }

    public function search() {
        
    }

    // FUNCTION FOR designations
    public function Designation() {
        $data = TableRegistry::getTableLocator()->get('employees_designation');
        $datas = $data->find()->toArray();
        $this->set('datas', $datas);
    }

    public function addDesignation() {
        /*
          //voucher change
          $xxacc_transactions = TableRegistry::getTableLocator()->get('xxacc_transactions');
          $old_transactions = $xxacc_transactions->find()
          ->where(['payment_status' => 1])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
          $paid_transactions = array();
          $acc_vouchers = TableRegistry::getTableLocator()->get('acc_vouchers');
          $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
          //data set
          foreach ($old_transactions as $old_transaction) {
          $vouchers = $acc_vouchers->find()
          ->where(['sid' => $old_transaction['sid']])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
          $paid_transection_single['amount'] = $old_transaction['amount'];
          $paid_transection_single['bank_id'] = $old_transaction['bank_id'];
          $paid_transection_single['transaction_type'] = $old_transaction['transaction_type'];
          $paid_transection_single['type'] = $old_transaction['type'];
          $paid_transection_single['transaction_date'] = $old_transaction['transaction_date'];
          $paid_transection_single['student_cycle_id'] = $old_transaction['student_cycle_id'];
          $paid_transection_single['level_id'] = $old_transaction['level_id'];
          $paid_transection_single['sid'] = $old_transaction['sid'];
          $paid_transection_single['session_id'] = $old_transaction['session_id'];
          $paid_transection_single['month_ids'] = $old_transaction['month_ids'];
          $paid_transection_single['payment_status'] = 1;
          $paid_transection_single['payment_date'] = $old_transaction['payment_date'];
          $paid_transection_single['payment_trID'] = $old_transaction['payment_trID'];
          $paid_transection_single['payment_tr_amount'] = $old_transaction['payment_tr_amount'];
          $paid_transection_single['payment_cr_amount'] = $old_transaction['payment_cr_amount'];
          $paid_transection_single['user_id'] = $old_transaction['user_id'];
          $paid_transection_single['employee_id'] = $old_transaction['employee_id'];
          $paid_transection_single['voucher_create_by'] = $old_transaction['voucher_create_by'];

          $data['transection'] = $paid_transection_single;

          $voucher_purposes = $acc_voucher_purposes->find()
          ->where(['voucher_id' => $vouchers[0]['id']])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
          $paid_voucher_purposes = array();
          $paid_transection_purposes = array();
          foreach ($voucher_purposes as $voucher_purpose) {
          $paid_voucher_purposes_single['voucher_purpose_id'] = $voucher_purpose['voucher_purpose_id'];
          $paid_voucher_purposes_single['payment_amount'] = $voucher_purpose['amount'];
          $paid_voucher_purposes_single['payment_status'] = 1;
          $paid_voucher_purposes[] = $paid_voucher_purposes_single;
          $paid_transection_purpose_single['purpose_id'] = $voucher_purpose['purpose_id'];
          $paid_transection_purpose_single['month_id'] = $voucher_purpose['month_id'];
          $paid_transection_purpose_single['voucher_id'] = $voucher_purpose['voucher_id'];
          $paid_transection_purpose_single['amount'] = $voucher_purpose['amount'];
          $paid_transection_purposes[] = $paid_transection_purpose_single;
          }
          $data['voucher_purposes'] = $paid_voucher_purposes;
          $data['transection_purposes'] = $paid_transection_purposes;
          $paid_transactions[] = $data;
          }
          $acc_transactions = TableRegistry::getTableLocator()->get('acc_transactions');

          //update and insert
          $all_acc_transaction_purposes = array();
          foreach ($paid_transactions as $paid_transaction) {
          $v_id = array();
          $vouchers = $acc_vouchers->find()
          ->where(['sid' => $paid_transaction['transection']['sid']])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
          $v_id[] = $vouchers[0]['id'];
          $transaction_data = array();
          $paid_transaction['transection']['trn_no'] = $this->genarate_transaction_name();
          $paid_transaction['transection']['voucher_ids'] = json_encode($v_id);
          $transaction_data[] = $paid_transaction['transection'];
          //insert transection
          $transection_coloums = array_keys($transaction_data[0]);
          $insertQuery = $acc_transactions->query();
          $insertQuery->insert($transection_coloums);
          $insertQuery->clause('values')->values($transaction_data);
          $insertQuery->execute();
          $transaction_record = $acc_transactions->find()->last();
          $transaction_id = $transaction_record->transaction_id;

          //update voucher
          $update_voucher_data['payment_amount'] = $vouchers[0]['amount'];
          $update_voucher_data['payment_status'] = 1;
          $query = $acc_vouchers->query();
          $query->update()
          ->set($update_voucher_data)
          ->where(['id' => $vouchers[0]['id']])
          ->execute();

          //update voucher purpose
          foreach ($paid_transaction['voucher_purposes'] as $voucher_purpose) {
          $voucher_purpose['paid_transaction_id'] = $transaction_id;
          $query = $acc_voucher_purposes->query();
          $query->update()
          ->set($voucher_purpose)
          ->where(['voucher_purpose_id' => $voucher_purpose['voucher_purpose_id']])
          ->execute();
          }
          foreach ($paid_transaction['transection_purposes'] as $transection_purpose) {
          $transection_purpose['transaction_id'] = $transaction_id;
          $all_acc_transaction_purposes[] = $transection_purpose;
          }
          }
          if (count($all_acc_transaction_purposes) > 0) {
          $acc_transaction_purposes = TableRegistry::getTableLocator()->get('acc_transaction_purposes');
          $insertQuery = $acc_transaction_purposes->query();
          $columns = array_keys($all_acc_transaction_purposes[0]);
          $insertQuery->insert($columns);
          $insertQuery->clause('values')->values($all_acc_transaction_purposes);
          $insertQuery->execute();
          }

          echo 'Happy';
          die;
         * 
         */

        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $articles = TableRegistry::getTableLocator()->get('employees_designation');
            $query = $articles->query();
            $query
                    ->insert(['name'])
                    ->values($request_data)
                    ->execute();

            //Set Flash
            $this->Flash->success('Designation Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'designation']);
        }
    }

    private function genarate_transaction_name() {
        ##GENERATE VOUCHER CODE for THE TRANSACTIONS
        $acc_transactions_name = TableRegistry::getTableLocator()->get('acc_transactions_name');
        $Prefix = 'TRN';
        $yearMonth = date('Ym');

        $trn = $acc_transactions_name->find()
                ->order(['id' => 'DESC'])
                ->first();
        if (empty($trn)) {
            // If there are no existing voucher records, start with 'VN000001'
            $TrnCode = $Prefix . $yearMonth . '000001';
        } else {
            // Extract the numeric part of the last voucher number and increment it
            $lastTrn = $trn->transactions_name;
            $numericPart = substr($lastTrn, -6);
            $datePart = substr($lastTrn, 3, 4);
            $currentYear = substr($yearMonth, 0, 4);
            $val = $numericPart + 1;
            if ($datePart != $currentYear) {
                $TrnCode = $Prefix . $yearMonth . '000001';
            } else {
                if ($val > 999999) {
                    // If it exceeds, simply append the numeric value after the prefix
                    $TrnCode = $Prefix . $yearMonth . $val;
                } else {
                    // If it doesn't exceed, format it with leading zeros
                    $TrnCode = $Prefix . $yearMonth . sprintf("%06d", $val);
                }
            }
        }
        $data['transactions_name'] = $TrnCode;
        $query = $acc_transactions_name->query();
        $query
                ->insert(['transactions_name'])
                ->values($data)
                ->execute();
        return $TrnCode;
    }

    public function editDesignation($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $designation = TableRegistry::getTableLocator()->get('employees_designation');
            $query = $designation->query();
            $query
                    ->update()
                    ->set($this->request->getData())
                    ->where(['id' => $data['id']])
                    ->execute();

            //Set Flash
            $this->Flash->info('Designation Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'designation']);
        }
        $designation = TableRegistry::getTableLocator()->get('employees_designation'); //Execute First
        $designations = $designation
                ->find()
                ->where(['id' => $id])
                ->toArray();
        $this->set('designations', $designations);
    }

}
