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
use Croogo\Core\Controller\Admin\ResultsController;
use Croogo\Core\Controller\Admin\AccountsController;
use Cake\ORM\TableRegistry;


class StudentsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    ##AJAX FUNCTION FOR USER_LOGIN @SHIHAB
    public function userLoginAjax()
    {
        $this->autoRender = false;
        $username = $_GET['username'];
        $password = $_GET['password'];
        $formattedPassword = date("Y-m-d", strtotime(substr($password, 4, 4) . '-' . substr($password, 2, 2) . '-' . substr($password, 0, 2)));

        $response = [];

        $studentsTable = TableRegistry::getTableLocator()->get('scms_students');
        $student = $studentsTable->find()
            ->where(['sid' => $username, 'date_of_birth' => $formattedPassword])
            ->first();

        if ($student) {
            $this->request->getSession()->write('sid', $username);
            $response['status'] = 'success';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Incorrect username or password';
        }

        echo json_encode($response);
    }



    public function userLogout()
    {
        $this->request->getSession()->destroy();

        // Redirect the user to a Homepage
        return $this->redirect([
            "plugin" => "Croogo/Nodes",
            "controller" => "Nodes",
            "action" => "promoted",
        ]);
    }



    public function getYearlyAttandanceAjax()
    {
        $this->autoRender = false;
        $search_year = $this->request->getQuery('search_year') ?: date('Y');

        $startDate = new DateTime("$search_year-01-01");
        $endDate = new DateTime("$search_year-12-31");

        $allDates = [];

        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $allDates[] = [
                'year' => $currentDate->format('Y'),
                'month' => $currentDate->format('F'),
                'date' => $currentDate->format('d'),
                'status' => '',
            ];
            $currentDate->modify('+1 day');
        }


        // Session Student Cycle ID
        $session_sid = $this->request->getSession()->read('sid');
        $studentCycleTable = TableRegistry::getTableLocator()->get('scms_students');
        $student_session = $studentCycleTable
            ->find()
            ->select([
                'student_cycle_id' => 'student_cycle.student_cycle_id',
            ])
            ->join([
                'student_cycle' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'LEFT',
                    'conditions' => [
                        'student_cycle.student_id = scms_students.student_id'
                    ]
                ]
            ])
            ->where(['sid' => $session_sid])
            ->first();
        $session_scid = $student_session->student_cycle_id;


        $attendanceTable = TableRegistry::getTableLocator()->get('scms_attendance');
        $attendance = $attendanceTable
            ->find()
            ->where(['student_cycle_id' => $session_scid])
            ->order(['date' => 'DESC'])
            ->toArray();

        $dateArray = [];
        foreach ($attendance as $entity) {
            $dateObject = $entity->date;
            $year = $dateObject->format('Y');
            $month = $dateObject->format('F');
            $date = $dateObject->format('d');

            // Add month and date to the array
            $dateArray[] = [
                'year' => $year,
                'month' => $month,
                'date' => $date,
                'status' => 'present',
            ];
        }

        // Combine $allDates and $dateArray into a new array
        $resultArray = [];

        foreach ($allDates as $allDate) {
            $year = $allDate['year'];
            $month = $allDate['month'];
            $date = $allDate['date'];
            $status = '';

            // Check if the date exists in $dateArray
            foreach ($dateArray as $dateItem) {
                if ($dateItem['year'] == $year && $dateItem['month'] == $month && $dateItem['date'] == $date) {
                    $status = $dateItem['status'];
                    break; // Stop searching once a match is found
                }
            }

            // Add the combined data to the result array
            $resultArray[] = [
                'year' => $year,
                'month' => $month,
                'date' => $date,
                'status' => $status,
            ];
        }

        $groupedResults = [];

        foreach ($resultArray as $result) {
            $month = $result['month'];
            if (!isset($groupedResults[$month])) {
                $groupedResults[$month] = [];
            }
            $groupedResults[$month][] = $result;
        }

        $this->response = $this->response->withType('application/json');
        echo json_encode($groupedResults);
    }



    public function sessionStudent()
    {
        $session_sid = $this->request->getSession()->read('sid');
        $studentCycleTable = TableRegistry::getTableLocator()->get('scms_students');
        $student_session = $studentCycleTable
            ->find()
            ->select([
                'student_cycle_id' => 'student_cycle.student_cycle_id',
            ])
            ->join([
                'student_cycle' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'LEFT',
                    'conditions' => [
                        'student_cycle.student_id = scms_students.student_id '
                    ]
                ]
            ])
            ->where(['sid' => $session_sid])
            ->first();
        $session_scid = $student_session['student_cycle_id'];
        return $session_scid;
    }



    public function studentDashboard()
    {
        $siteTemplate = Configure::read('Site.template');

        if($siteTemplate==2){
        $this->layout = 'marmc_dashboard_layout';
        }else{
        $this->layout = 'user_dashboard_layout';
        }


        $session_sid = $this->request->getSession()->read('sid');
        if (!$session_sid) {
            // Session does not exist or 'sid' is not set, redirect to the homepage
            return $this->redirect([
                "plugin" => "Croogo/Nodes",
                "controller" => "Nodes",
                "action" => "promoted",
            ]);
        }

        $studentTable = TableRegistry::getTableLocator()->get('scms_students');
        $student_session = $studentTable
            ->find()
            ->where(['sid' => $session_sid])
            ->first();
        $session_student_id = $student_session->student_id;

        $sscid = $this->sessionStudent(); //Student_cycle_id from session.

        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();

            $student_id = $session_student_id; //##// Will get session data where the id will be there
            $student_data['name'] = $request_data['name'];
            $student_data['mobile'] = $request_data['mobile'];
            $student_data['email'] = $request_data['email'];
            $student_data['date_of_birth'] = $request_data['date_of_birth'];
            $student_data['birth_registration'] = $request_data['birth_registration'];
            $student_data['gender'] = $request_data['gender'];
            $student_data['religion'] = $request_data['religion'];
            $student_data['permanent_address'] = $request_data['permanent_address'];

            $students = TableRegistry::getTableLocator()->get('scms_students');
            $query = $students->query();
            $query->update()
                ->set($student_data)
                ->where(['student_id' => $student_id])
                ->execute();
        }
        $basic = TableRegistry::getTableLocator()->get('scms_students'); //Execute First
        $basics = $basic
            ->find()
            ->where(['student_id' => $session_student_id]) //##// Will get session data where the id will be there
            ->toArray();
        $this->set('students', $basics[0]);

        $student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $student_cycles = $student_cycle
            ->find()
            ->where(['session_id' => $basics[0]->session_id])
            ->where(['student_id' => $basics[0]->student_id])
            ->toArray();
        $this->set('student_cycle', $student_cycles[0]);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->where(['level_id' => $student_cycles[0]->level_id])
            ->toArray();
        $this->set('levels', $levels[0]);

        $section = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $section
            ->find()
            ->where(['shift_id' => $student_cycles[0]->shift_id])
            ->where(['level_id' => $student_cycles[0]->level_id])
            ->toArray();
        $this->set('sections', $sections[0]);

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->where(['session_id' => $basics[0]->session_id])
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions[0]);


        // ByDefault ATTENDANCE Report
        $year = date('Y');
        $startDate = new DateTime("$year-01-01");
        $endDate = new DateTime("$year-12-31");

        $allDates = array();

        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $allDates[] = [
                'year' => $currentDate->format('Y'),
                'month' => $currentDate->format('F'),
                'date' => $currentDate->format('d'),
                'status' => '',
            ];

            $currentDate->modify('+1 day');
        }

        $attendanceTable = TableRegistry::getTableLocator()->get('scms_attendance');
        $attendance = $attendanceTable
            ->find()
            ->where(['student_cycle_id' => $sscid]) //##// STUDENT CYCLE ID FROM SESSION
            ->order(['date' => 'DESC'])
            ->toArray();

        $dateArray = [];

        foreach ($attendance as $entity) {
            $dateObject = $entity->date;

            $year = $dateObject->format('Y');
            $month = $dateObject->format('F');
            $date = $dateObject->format('d');

            // Add month and date to the array
            $dateArray[] = [
                'year' => $year,
                'month' => $month,
                'date' => $date,
                'status' => 'present',
            ];
        }

        // Combine $allDates and $dateArray into a new array
        $resultArray = [];

        foreach ($allDates as $allDate) {
            $year = $allDate['year'];
            $month = $allDate['month'];
            $date = $allDate['date'];
            $status = '';

            // Check if the date exists in $dateArray
            foreach ($dateArray as $dateItem) {
                if ($dateItem['year'] == $year && $dateItem['month'] == $month && $dateItem['date'] == $date) {
                    $status = $dateItem['status'];
                    break; // Stop searching once a match is found
                }
            }

            // Add the combined data to the result array
            $resultArray[] = [
                'year' => $year,
                'month' => $month,
                'date' => $date,
                'status' => $status,
            ];
        }
        $groupedResults = [];
        foreach ($resultArray as $result) {
            $month = $result['month'];
            if (!isset($groupedResults[$month])) {
                $groupedResults[$month] = [];
            }
            $groupedResults[$month][] = $result;
        }
        $this->set('groupedResults', $groupedResults);


        #RESULT LIST FOR STUDENT
        $result_student_table = TableRegistry::getTableLocator()->get('scms_result_students');
        $result_students = $result_student_table
            ->find()
            ->select([
                'term_name' => 'term.term_name',
                'sid' => 'students.sid',
                'level_name' => 'level.level_name',
                'session_name' => 'session.session_name',
            ])
            ->join([
                'stc' => [
                    'table' => 'scms_student_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => [
                        'stc.student_term_cycle_id = scms_result_students.student_term_cycle_id '
                    ]
                ],
                'sc' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'LEFT',
                    'conditions' => [
                        'sc.student_cycle_id = stc.student_cycle_id'
                    ],
                ],
                'students' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => [
                        'students.student_id = sc.student_id'
                    ],
                ],
                'level' => [
                    'table' => 'scms_levels',
                    'type' => 'LEFT',
                    'conditions' => [
                        'level.level_id = sc.level_id'
                    ],
                ],
                'session' => [
                    'table' => 'scms_sessions',
                    'type' => 'LEFT',
                    'conditions' => [
                        'session.session_id = sc.session_id'
                    ],
                ],
                'tc' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => [
                        'tc.term_cycle_id = stc.term_cycle_id'
                    ],
                ],
                'term' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => [
                        'term.term_id = tc.term_id'
                    ],
                ],

            'scms_results' => [
                    'table' => 'scms_results',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_results.term_cycle_id = tc.term_cycle_id',
                        // 'scms_results.term_cycle_id' => 1,
                    ],
                ],

            ])
            ->where(['sid' => $session_sid]) //##// STUDENT SID FROM SESSION
            ->where(['scms_results.publish' => 1])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('result_students', $result_students);



        #ACOUNTS
        $transactionsTable = TableRegistry::getTableLocator()->get('acc_transactions');
        $transactions = $transactionsTable
            ->find()
            ->where(['student_cycle_id' => $sscid])
            ->order(['voucher_no' => 'ASC'])
            ->select([
                'bank_name' => 'bank.bank_name',
                'session_name' => 'session.session_name'
            ])
            ->join([
                'bank' => [
                    'table' => 'acc_banks',
                    'type' => 'INNER',
                    'conditions' => [
                        'bank.bank_id = acc_transactions.bank_id '
                    ]
                ],
                'session' => [
                    'table' => 'scms_sessions',
                    'type' => 'INNER',
                    'conditions' => [
                    'session.session_id = acc_transactions.session_id '
                    ]
                ]
            ])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('transactions', $transactions);
        // pr($transactions);die;
    }
    
    public function studentResult()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $sid = $request_data['sid'];
            $term_id = $request_data['term_id'];
            $session = $request_data['session_id'];
            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $scms_student_cycles = $scms_student_cycle->find()
                ->where(['s.sid' => $sid])
                ->where(['scms_student_cycle.session_id' => $session])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'name' => "s.name",
                    'gender' => "s.gender",
                    'sid' => "s.sid",
                    'mobile' => 's.mobile',
                    'card_no' => 's.card_no',
                    'thumbnail' => 's.thumbnail',
                    'permanent_address' => "s.permanent_address",
                    'present_address' => "s.present_address",
                    'date_of_birth' => "s.date_of_birth",
                    'blood_group' => "s.blood_group",
                    'status' => "s.status",
                    'shift_name' => "shift.shift_name",
                    'level_name' => "level.level_name",
                    'section_name' => "section.section_name",
                ])
                ->join([
                    's' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            's.student_id = scms_student_cycle.student_id'
                        ]
                    ],
                    'shift' => [
                        'table' => 'hr_shift',
                        'type' => 'INNER',
                        'conditions' => [
                            'shift.shift_id = scms_student_cycle.shift_id'
                        ]
                    ],
                    'level' => [
                        'table' => 'scms_levels',
                        'type' => 'INNER',
                        'conditions' => [
                            'level.level_id = scms_student_cycle.level_id'
                        ]
                    ],
                    'section' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'section.section_id = scms_student_cycle.section_id'
                        ]
                    ],
                ])->toArray();
            $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle'); //Execute First
            $terms = $term_cycle
                ->find()
                ->where(['scms_term_cycle.term_id' => $term_id])
                ->where(['scms_term_cycle.session_id' => $session])
                ->where(['scms_term_cycle.level_id' => $scms_student_cycles[0]['level_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
                
            $term_cycle_id = $terms[0]['term_cycle_id'];
            $level_id = $terms[0]['level_id'];

            $scms_result = TableRegistry::getTableLocator()->get('scms_results'); //Execute First
            $scms_results = $scms_result
                ->find()
                ->where(['scms_results.session_id' => $session])
                ->where(['scms_results.level_id' => $level_id])
                ->where(['scms_results.term_cycle_id' => $term_cycle_id])
                // ->where(['scms_results.publish' => 1])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
                if (empty($scms_results)) {
                    $this->Flash->error(__('No results found.'));
                }

                
                
                foreach ($scms_results as $item) {
                    
                    
                if ($item['type'] === 'single' && $item['publish'] == 1) {
                    
                    $sid = $scms_student_cycles[0]['sid'];
                    $id = $item['result_id'];
    
                    $this->layout = 'result';
                    $this->autoRender = false;
                    $where['scms_students.sid'] = $sid; 
                    $where['result_id'] = $id;
    
                    ##ACCESS OTHER CONTRONER FROM OTHER PLUGIN
                    $resultsController = new ResultsController();
                    $resultData = $resultsController->studentResultView($id, $where);
    
                    $this->set('students', $resultData['students']);
                    $this->set('scms_activity_remarks', $resultData['scms_activity_remarks']);
                    $this->set('heads', $resultData['heads']);
                    $this->set('position', $resultData['position']);
                    $this->set('exam_title', $resultData['exam_title']);
                    $this->set('last_row_colspan', $resultData['last_row_colspan']);
                    $this->set('decemal_point', $resultData['decemal_point']);
                    $this->set('total_attandance', $resultData['total_attandance']);
                    $this->render('/Students/view_result');
                } elseif ($item['type'] === 'merge' && $item['merge_publish'] == 1) {
                    
                    $sid = $scms_student_cycles[0]['sid'];
                    $id = $item['result_id'];
    
                    $this->layout = 'result';
                    $this->autoRender = false;
                    $where['scms_students.sid'] = $sid; 
                    $where['result_id'] = $id;
    
                    ##ACCESS OTHER CONTRONER FROM OTHER PLUGIN
                    $resultsController = new ResultsController();
                    $resultData = $resultsController->studentResultMerge($id, $where);
                    
                    $this->set('students', $resultData['students']);
                    $this->set('scms_activity_remarks', $resultData['scms_activity_remarks']);
                    $this->set('heads', $resultData['heads']);
                    $this->set('merge_heads', $resultData['merge_heads']);
                    $this->set('position', $resultData['position']);
                    $this->set('exam_title', $resultData['exam_title']);
                    $this->set('last_row_colspan', $resultData['last_row_colspan']);
                    $this->set('last_row_colspan_merge_result', $resultData['last_row_colspan_merge_result']);
                    $this->set('term_names', $resultData['term_names']);
                    $this->set('decemal_point', $resultData['decemal_point']);
                    $this->set('total_attandance', $resultData['total_attandance']);
                    $this->set('studnet_attandance', $resultData['studnet_attandance']);
                    $this->render('/Students/merge_result');
                 } 
                    }
                
        }

        $term = TableRegistry::getTableLocator()->get('scms_term'); //Execute First
        $terms = $term
            ->find()
            ->toArray();
        $this->set('terms', $terms);
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);
    }



    public function viewResult($id)
    {
        $this->layout = 'result';
        $scms_result_students = TableRegistry::getTableLocator()->get('scms_results');
        $result_students = $scms_result_students->find()
            ->where(['scms_results.result_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        if ($result_students[0]['publish'] == 1) {
            $session_sid = $this->request->getSession()->read('sid');
            $this->layout = 'result';
            $this->autoRender = false;
            $where['scms_students.sid'] = $session_sid; //##// STUDENT SID FROM SESSION
            $where['result_id'] = $id;

            ##ACCESS OTHER CONTRONER FROM OTHER PLUGIN
            $resultsController = new ResultsController();
            $resultData = $resultsController->studentResultView($id, $where);

            $this->set('students', $resultData['students']);
            $this->set('scms_activity_remarks', $resultData['scms_activity_remarks']);
            $this->set('heads', $resultData['heads']);
            $this->set('position', $resultData['position']);
            $this->set('exam_title', $resultData['exam_title']);
            $this->set('last_row_colspan', $resultData['last_row_colspan']);
            $this->set('decemal_point', $resultData['decemal_point']);
            $this->set('total_attandance', $resultData['total_attandance']);
            $this->render('/Students/view_result');
        } else {
            $this->autoRender = true;
            $this->Flash->error(__('Result is not Published Yet.'));
        }
    }

    public function printRecipt($id)
    {
        $this->layout = 'report';
        $this->autoRender = false;

        ##ACCESS OTHER CONTRONER FROM OTHER PLUGIN
        $accountsController = new AccountsController();
        $reciptData = $accountsController->studentViewRecipt($id);
        // pr($reciptData);
        // die;
        $this->set('type', $reciptData['type']);
        $this->set('transactions', $reciptData['transactions']);
        $this->set('months', $reciptData['months']);
        $this->set('purpose', $reciptData['purpose']);
        $this->set('total', $reciptData['total']);
        $this->set('amount', $reciptData['amount']);
        $this->set('user_name', $reciptData['user_name']);
        $this->render('/reports/moneyRecpit');

    }

    public function payNow($id)
    {
        $this->layout = 'default';
        $this->autoRender = false;
        echo "<h3 class='text-center'> 'PAY NOW' is Under Construction</h3>";
    }

    public function loginForm()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $username = $request_data['username'];
            $password = $request_data['password'];
            $formattedPassword = date("Y-m-d", strtotime(substr($password, 4, 4) . '-' . substr($password, 2, 2) . '-' . substr($password, 0, 2)));

            $studentsTable = TableRegistry::getTableLocator()->get('scms_students');
            $student = $studentsTable->find()
                ->where(['sid' => $username, 'date_of_birth' => $formattedPassword])
                ->first();

            if ($student) {
                $this->request->getSession()->write('sid', $username);
                $this->Flash->success(__('Login successful!'), ['key' => 'auth']);
                return $this->redirect(['action' => 'studentDashboard']);
            } else {
                $this->Flash->error(__('Incorrect username or password'), ['key' => 'auth']);
            }
        }
    }


}
