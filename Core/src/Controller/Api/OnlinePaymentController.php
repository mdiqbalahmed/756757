<?php

namespace Croogo\Core\Controller\Api;

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

        if ($this->request->is('post')) {
            $return_data = [
                'referenceId' => null,
                'dateTime' => date('d/m/Y H:i A'),
                'responseCode' => 90,
                'responseMsg' => 'Username and Password do not match',
                'feeDetails' => [
                    'studentId' => null,
                    'instituteName' => null,
                    'branchName' => null,
                    'className' => null,
                    'sectionName' => null,
                    'invoiceNo' => null,
                    'studentName' => null,
                    'fatherName' => null,
                    'month' => null,
                    'academicYear' => null,
                    'fee' => null,
                    'waiver' => null,
                    'totalDue' => null,
                ]
            ];
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
