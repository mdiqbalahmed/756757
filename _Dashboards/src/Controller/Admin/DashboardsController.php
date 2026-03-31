<?php

namespace Croogo\Dashboards\Controller\Admin;

use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use DateTime;
use DateTimeZone;
use Cake\Datasource\ConnectionManager;


/**
 * Dashboards Controller
 *
 * @category Controller
 * @package  Croogo.Dashboards.Controller
 * @version  2.2
 * @author   Walther Lalk <emailme@waltherlalk.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class DashboardsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if ($event->getSubject()->request->getParam('action') === 'save') {
            $this->components()->unload('Security');
        }
    }

    /**
     * {@inheritDoc}
     *
     * Load the dashboards helper
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);

        $this->viewBuilder()->setHelpers([
            'Croogo/Dashboards.Dashboards',
        ]);
    }

    /**
     * Dashboard index
     *
     * @return void
     */
    public function index()
    {
        $dashboard = TableRegistry::getTableLocator()->get('dashboards');
        $dashboards = $dashboard
            ->find()
            ->toArray();
        $this->set('dashboards', $dashboards);
    }

    /**
     * Admin dashboard
     *
     * @return void
     */
    public function dashboard()
    {

        ## For students_log @shovon 9/4/2024 //start
        $setting = TableRegistry::getTableLocator()->get('settings');
        $settings = $setting
            ->find()
            ->where(['`key`' => 'Site.selectedSession'])
            ->toArray();
        $selectedSessionsArray = json_decode($settings[0]['value']);
        $studentsTable = TableRegistry::getTableLocator()->get('scms_students');
        $total_Students = $studentsTable
            ->find()
            ->where(['status' => 1])
            ->where(['session_id IN' => $selectedSessionsArray])
            ->count();
// echo '<pre>';
// print_r($total_Students);die;
        $timezone = new DateTimeZone('Asia/Dhaka'); // Replace with timezone
        $now = new DateTime('now', $timezone);
        $formattedDate = $now->format('Y-m-d H:i:s');
        
        $data['total_students'] = $total_Students;
        $data['date'] = $formattedDate;

        $today = $now->format('Y-m-d');
        $studentLog = TableRegistry::getTableLocator()->get('students_log');
        $existingRecord = $studentLog
            ->find()
            ->where(['DATE(date)' => $today])
            ->toArray();
        if (count($existingRecord) == 0) {
            $query = $studentLog->query();
            $query->insert(array_keys($data))
                ->values($data)
                ->execute();
        }
        //studnet log end
        $dashboard = TableRegistry::getTableLocator()->get('dashboards');
        $dashboards = $dashboard
            ->find()
            ->toArray();
        $filter_dashboards = array();
        foreach ($dashboards as $dashboard) {
            $filter_dashboards[$dashboard['name']] = $dashboard['status'];
        }
        $this->set('filter_dashboards', $filter_dashboards);


        if ($filter_dashboards['Students Statistics']) {
            // CUSTOM DASHBOARD STATISTICS FOR DASHBOARD @SHIHAB
            //modify by akash 28/7/2025 start

            ## Statistics by Group
            $students = $studentsTable
                ->find()
                ->select([
                    'group' => 'sc.group_id'
                ])
                ->join([
                    'sc' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['sc.student_id = scms_students.student_id'],
                    ]
                ])
                ->where(['status' => 1])
                ->where(['scms_students.session_id IN' => $selectedSessionsArray])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $students = $scms_student_cycle
                ->find()
                ->select([
                    'gender' => 'scms_students.gender',
                    'religion' => 'scms_students.religion',
                    'freedom_fighter' => 'scms_students.freedom_fighter',
                    'tribal' => 'scms_students.tribal',
                    'orphan' => 'scms_students.orphan',
                    'disabled' => 'scms_students.disabled',
                ])
                ->join([
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'LEFT',
                        'conditions' => ['scms_students.student_id = scms_student_cycle.student_id'],
                    ],
                ])
                ->where(['scms_students.status' => 1])
                ->where(['scms_students.session_id IN' => $selectedSessionsArray])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();


            $this->set('Students', $students);

            $countOp = $countDs = $countTb = $countFF = $othersCount = $christianCount = $hinduCount = $IslamCount = $totalStudents = $femaleCount = $maleCount = $countSc = $countHm = $countCm = 0;
            foreach ($students as $student) {
                if ($student['group_id'] == 1) {
                    $countSc++;
                } elseif ($student['group_id'] == 2) {
                    $countHm++;
                } elseif ($student['group_id'] == 3) {
                    $countCm++;
                }
                ##GenderWise
                if ($student['gender'] == 'Male') {
                    $maleCount++;
                } else if ($student['gender'] == 'Female') {
                    $femaleCount++;
                }
                ##Statistics By Religion
                if ($student['religion'] == 'Islam') {
                    $IslamCount++;
                } elseif ($student['religion'] == 'Hindu') {
                    $hinduCount++;
                } elseif ($student['religion'] == 'Christian') {
                    $christianCount++;
                } elseif ($student['religion'] == 'Others') {
                    $othersCount++;
                }
                ##Statistics by Quota
                if ($student['freedom_fighter'] == 'Yes') {
                    $countFF++;
                } elseif ($student['tribal'] == 'Yes') {
                    $countTb++;
                } elseif ($student['disabled'] == 'Yes') {
                    $countDs++;
                } elseif ($student['orphan'] == 'Yes') {
                    $countOp++;
                }
            }
            $groups = [
                'Science' => $countSc,
                'Humanities' => $countHm,
                'Commerce' => $countCm,
            ];
            $groupCounts = json_encode($groups); ##SHowing the values only
            $this->set('groupCounts', $groupCounts);

            $genders = [
                'Male' => $maleCount,
                'Female' => $femaleCount,
            ];

            $genderStats = json_encode($genders); ##SHowing the values only
            $this->set('genderStats', $genderStats);

            $religion = [
                'Islam' => $IslamCount,
                'Hindu' => $hinduCount,
                'Christian' => $christianCount,
                'Buddhist' => $othersCount,
            ];
            // $religionCounts = implode(',', $religion); ##SHowing the values only
            $religionCounts = json_encode($religion); ##SHowing the values only
            $this->set('religionCounts', $religionCounts);


            $countFF = $studentsTable
                ->find()
                ->where(['status' => 1])
                ->where(['freedom_fighter' => 'Yes'])
                ->where(['session_id IN' => $selectedSessionsArray])
                ->count();
            $countTb = $studentsTable
                ->find()
                ->where(['status' => 1])
                ->where(['tribal' => 'Yes'])
                ->where(['session_id IN' => $selectedSessionsArray])
                ->count();
            $countDs = $studentsTable
                ->find()
                ->where(['status' => 1])
                ->where(['disabled' => 'Yes'])
                ->where(['session_id IN' => $selectedSessionsArray])
                ->count();
            $countOp = $studentsTable
                ->find()
                ->where(['status' => 1])
                ->where(['orphan' => 'Yes'])
                ->where(['session_id IN' => $selectedSessionsArray])
                ->count();

            $quota = [
                'Freedom Fighter' => $countFF,
                'Tribal' => $countTb,
                'Disabled' => $countDs,
                'Orphan' => $countOp,
            ];
            $quotaCounts = json_encode($quota); ##SHowing the values only
            $this->set('quotaCounts', $quotaCounts);
        }
        //end;

        $temp = 0;
        ###QUICK LINK MANAGEMENT BOXES
        if ($filter_dashboards['Quick Links']) {
            $temp++;
            $buttonsTable = TableRegistry::getTableLocator()->get('cms_quicklink');
            $buttons = $buttonsTable->find()
                ->order(['button_order' => 'ASC'])
                ->toArray();

            // numeric sort order to the existing query result
            usort($buttons, function ($a, $b) {
                return $a->button_order - $b->button_order;
            });
            $this->set('buttons', $buttons);
        }

        //account details start
        if ($filter_dashboards['Account Statistics']) {

            $banksTable = TableRegistry::getTableLocator()->get('acc_banks');
            $banks = $banksTable
                ->find()
                ->order([
                    'bank_balance' => 'ASC',
                ])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

            $bankBalance = [];
            foreach ($banks as $bank) {
                if ($bank['bank_balance']) {
                    $bankBalance[$bank['bank_name']] = $bank['bank_balance'];
                }
            }
            $bankBalance = json_encode($bankBalance); // Showing the values only
            $this->set('banks', $bankBalance);


            $connection = ConnectionManager::get('default');
            $result = $connection->execute("
    SELECT 
        SUM(amount) AS total_amount,
        SUM(payment_amount) AS total_payment,
        SUM(discount_amount) AS total_discount
    FROM acc_vouchers
")->fetch('assoc');

            // Calculate derived totals
            $totalAmount = (float) ($result['total_amount'] ?? 0);
            $totalPayment = (float) ($result['total_payment'] ?? 0);
            $totalDiscount = (float) ($result['total_discount'] ?? 0);

            $totalDue = $totalAmount - $totalPayment;
            $totalPaid = $totalPayment - $totalDiscount;

            $totalsArray = [
                "Total Billed" => $totalAmount,
                "Total Paid" => $totalPaid,
                "Due" => $totalDue,
            ];

            if ($totalDiscount > 0) {
                $totalsArray['Discount'] = $totalDiscount;
            }

            $this->set('amounts', json_encode($totalsArray));

            $result = $connection->execute("
    SELECT 
        SUM(amount) AS total_amount,
        SUM(payment_amount) AS total_payment,
        SUM(discount_amount) AS total_discount
    FROM acc_vouchers
    WHERE DATE(create_date) = :today
", ['today' => date('Y-m-d')])->fetch('assoc');

            $totalAmountDay = (float) ($result['total_amount'] ?? 0);
            $totalPaymentDay = (float) ($result['total_payment'] ?? 0);
            $discount_amount = (float) ($result['total_discount'] ?? 0);

            $totalDueDay = $totalAmountDay - $totalPaymentDay;
            $totalPaymentDay = $totalPaymentDay - $discount_amount;
            $totalDaysArray = [
                "Total Billed" => $totalAmountDay,
                "Total Paid" => $totalPaymentDay,
                "Due" => $totalDueDay,
            ];
            if ($discount_amount) {
                $totalDaysArray['Discount'] = $discount_amount;
            }
            $totalDaysArray = json_encode($totalDaysArray); ##SHowing the values only
            $this->set('dailyAmounts', $totalDaysArray);



            $firstDayOfMonth = date('Y-m-01 00:00:00');
            $lastDayOfMonth = date('Y-m-t 23:59:59');

            $result = $connection->execute("
    SELECT 
        SUM(amount) AS total_amount,
        SUM(payment_amount) AS total_payment,
        SUM(discount_amount) AS total_discount
    FROM acc_vouchers
    WHERE create_date BETWEEN :start AND :end
", [
                'start' => $firstDayOfMonth,
                'end' => $lastDayOfMonth
            ])->fetch('assoc');

            $totalAmountMonth = (float) ($result['total_amount'] ?? 0);
            $totalPaymentMonth = (float) ($result['total_payment'] ?? 0);
            $totalDiscountMonth = (float) ($result['total_discount'] ?? 0);

            $totalDueMonth = $totalAmountMonth - $totalPaymentMonth;
            $totalPaymentMonth = $totalPaymentMonth - $totalDiscountMonth;

            $totalMonthArray = [
                "Total Billed" => $totalAmountMonth,
                "Total Paid" => $totalPaymentMonth,
                "Due" => $totalDueMonth,
            ];
            if ($totalDiscountMonth) {
                $totalMonthArray['Discount'] = $totalDiscountMonth;
            }
            $totalMonthArray = json_encode($totalMonthArray);
            $this->set('monthlyAmounts', $totalMonthArray);
        }

        // account details end
        if ($filter_dashboards['Accounts Report']) {
            $temp++;
            $voucherTable = TableRegistry::getTableLocator()->get('acc_vouchers');
            $query = $voucherTable->find();

            $query->select([
                'level_id',
                'level_name' => 'lvl.level_name',
                'total_amount' => $query->func()->sum('amount'),
                'total_payment' => $query->func()->sum('payment_amount'),
            ])
                ->where(['deleted' => 0])
                ->group(['acc_vouchers.level_id'])
                ->join([
                    'lvl' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['lvl.level_id = acc_vouchers.level_id'],
                    ]
                ]);

            $vouchers = $query->toArray();
            $totalBilled = [];
            $totalPaid = [];
            $totalDue = [];
            foreach ($vouchers as $voucher) {
                $levelId = $voucher['level_name'];
                $totalAmount = $voucher['total_amount'] ?: 0;
                $totalPayment = $voucher['total_payment'] ?: 0;
                $totaldue = $totalAmount - $totalPayment;

                $totalBilled[$levelId] = $totalAmount;
                $totalPaid[$levelId] = $totalPayment;
                $totalDue[$levelId] = $totaldue;
            }

            $totalBilled = json_encode($totalBilled);
            $this->set('totalBilled', $totalBilled);

            $totalPaid = json_encode($totalPaid);
            $this->set('totalPaid', $totalPaid);

            $totalDue = json_encode($totalDue);
            $this->set('totalDue', $totalDue);
        }
        if ($temp == 1) {
            $col = 12;
        } else {
            $col = 6;
        }
        $this->set('col', $col);

        //attendance start
        //todays attendance based on level strat
        if ($filter_dashboards['Attendance Report']) {
            $date = date('Y-m-d');
            $studentsTable = TableRegistry::getTableLocator()->get('scms_students');
            $query = $studentsTable->find();
            $query->select([
                'level_name' => 'scms_levels.level_name',
                'level_id' => 'scms_students.level_id',
                'student_count' => $query->func()->count('*')
            ])
                ->join([
                    's' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['s.student_id = scms_students.student_id'],
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['scms_levels.level_id  = scms_students.level_id'],
                    ],
                ])
                ->where(['status' => 1])
                ->where(['scms_students.session_id IN' => $selectedSessionsArray])
                ->group(['level_id']);
            $studentCount = $query->toArray();

            $classWiseTotal = array();
            foreach ($studentCount as $count) {
                $classWiseTotal[$count->level_name] = $count->student_count;
            }


            $classWiseTotal = json_encode($classWiseTotal);
            $this->set('classWiseTotal', $classWiseTotal);


            $studentAttendanceTable = TableRegistry::getTableLocator()->get('scms_attendance');
            $query = $studentAttendanceTable->find();
            $query->select([
                'level_name' => 'scms_levels.level_name',
                'level_id' => 'scms_student_cycle.level_id',
                'student_count' => $query->func()->count('*')
            ])
                ->join([
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_attendance.student_cycle_id = scms_student_cycle.student_cycle_id'],
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['scms_levels.level_id  = scms_student_cycle.level_id'],
                    ],
                ])
                ->where(['date' => $date])
                ->where(['scms_student_cycle.session_id IN' => $selectedSessionsArray])
                ->group(['level_id']);
            $attendanceCount = $query->toArray();

            $classWiseAttendance = array();
            foreach ($attendanceCount as $count) {
                $classWiseAttendance[$count->level_name] = $count->student_count;
            }
            $presentPerClass = json_encode($classWiseAttendance);
            $this->set('presentPerClass', $presentPerClass);
            //todays attendance based on level strat end

            //monthly attendance for full school strat
            $firstDayOfMonth = date('Y-m-01');
            $lastDayOfMonth = date('Y-m-t');

            $query = $studentAttendanceTable->find();
            $query
                ->select([
                    'date',
                    'count' => $query->func()->count('*')
                ])
                ->where([
                    'date >=' => $firstDayOfMonth,
                    'date <=' => $lastDayOfMonth
                ])
                ->group('date')
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->count();
            $results = $query->toArray();

            $attendanceData = [];
            $currentDate = strtotime($firstDayOfMonth);

            while ($currentDate <= strtotime($lastDayOfMonth)) {
                $dateString = date('Y-m-d', $currentDate);
                $attendanceData[$dateString] = 0;
                $currentDate = strtotime('+1 day', $currentDate);
            }

            foreach ($results as $result) {
                $date = $result['date']->format('Y-m-d');
                $count = $result['count'];
                if (isset($attendanceData[$date])) {
                    $attendanceData[$date] = $count;
                }
            }

            $monthlyAttendance = json_encode($attendanceData);
            $this->set('monthlyAttendance', $monthlyAttendance);
        }
        //monthly attendance for full school strat end
        //attendance end 
    }

    /**
     * Saves dashboard setting
     *
     * @throws \Cake\Core\Exception\Exception
     * @return void
     */
    public function save()
    {
        $userId = $this->Auth->user('id');
        if (!$userId) {
            throw new Exception('You must be logged in');
        }
        $data = Hash::insert($this->getRequest()->data['dashboard'], '{n}.user_id', $userId);
        $dashboardIds = array_filter(Hash::extract($data, '{n}.id'));
        $query = $this->Dashboards->find();
        if ($dashboardIds) {
            $query->where(['id IN' => $dashboardIds]);
        }
        $entities = $query->toArray();
        $patched = $this->Dashboards->patchEntities($entities, $data);
        $this->Dashboards->connection()->getDriver()->enableAutoQuoting();
        $results = $this->Dashboards->saveMany($patched);
        $this->set(compact('results'));
        $this->set('_serialize', 'results');
    }

    /**
     * Delete a dashboard
     *
     * @param int $id Dashboard id
     * @return \Cake\Http\Response|void
     */
    public function delete($id = null)
    {
        if (!$id) {
            $this->Flash->error(__d('croogo', 'Invalid id for Dashboard'));

            return $this->redirect(['action' => 'index']);
        }
        $entity = $this->Dashboards->get($id);
        if ($this->Dashboards->delete($entity)) {
            $this->Flash->success(__d('croogo', 'Dashboard deleted'));

            return $this->redirect($this->referer());
        }
    }

    /**
     * Toggle dashboard status
     *
     * @param int $id Dashboard id
     * @param int $status Status
     * @return void
     */
    public function toggle($id = null, $status = null)
    {
        $this->Croogo->fieldToggle($this->Dashboards, $id, $status);
    }

    /**
     * Admin moveup
     *
     * @param int $id Dashboard Id
     * @param int $step Step
     * @return \Cake\Http\Response|void
     */
    public function moveup($id, $step = 1)
    {
        $dashboard = $this->Dashboards->get($id);
        $dashboard->weight = $dashboard->weight - $step;
        if ($this->Dashboards->save($dashboard)) {
            $this->Flash->success(__d('croogo', 'Moved up successfully'));
        } else {
            $this->Flash->error(__d('croogo', 'Could not move up'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Admin movedown
     *
     * @param int $id Dashboard Id
     * @param int $step Step
     * @return \Cake\Http\Response|void
     */
    public function movedown($id, $step = 1)
    {
        $dashboard = $this->Dashboards->get($id);
        $dashboard->weight = $dashboard->weight + $step;
        if ($this->Dashboards->save($dashboard)) {
            $this->Flash->success(__d('croogo', 'Moved down successfully'));
        } else {
            $this->Flash->error(__d('croogo', 'Could not move down'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
