<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\I18n\Time;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Croogo\Core\Utility\SmsLengthCalculator;
use Cake\Core\Configure;

I18n::setLocale('jp_JP');

class SmsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    private function get_sms_permission_data($id = false)
    {
        if (!$id) {
            $session = TableRegistry::getTableLocator()->get('scms_sessions'); //Execute First
            $sessions = $session
                ->find()
                ->where(['active' => 1])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
            $id = $sessions[0]['session_id'];
        }
        $scms_sms_permission = TableRegistry::getTableLocator()->get('scms_sms_permission');
        $permissions_level = $scms_sms_permission
            ->find()
            ->select([
                'level_name' => "scms_levels.level_name",
                'section_name' => "scms_sections.section_name"
            ])
            ->where(['session_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'scms_levels' => [
                    'table' => 'scms_levels',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_levels.level_id = scms_sms_permission.level_id'
                    ]
                ],
                'scms_sections' => [
                    'table' => 'scms_sections',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_sms_permission.section_id = scms_sections.section_id'
                    ]
                ],
            ])->toArray();
        $return['level'] = array();
        $return['selected'] = $id;
        foreach ($permissions_level as $level) {
            $return['level'][$level['level_id']]['level_name'] = $level['level_name'];
            $return['level'][$level['level_id']]['level_id'] = $level['level_id'];
            $return['level'][$level['level_id']]['section'][$level['section_id']]['section_id'] = $level['section_id'];
            $return['level'][$level['level_id']]['section'][$level['section_id']]['section_name'] = $level['section_name'];
        }


        $permission_roles = $scms_sms_permission
            ->find()
            ->select([
                'role_title' => "roles.title",
                'user_name' => "users.name",
            ])
            ->where(['sms_permission_type' => 'role'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'roles' => [
                    'table' => 'roles',
                    'type' => 'INNER',
                    'conditions' => [
                        'roles.id = scms_sms_permission.role_id',
                    ]
                ],
                'users' => [
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => [
                        'users.id = scms_sms_permission.user_id',
                    ]
                ],
            ])->toArray();

        $return['roles'] = array();
        foreach ($permission_roles as $role) {
            $return['roles'][$role['role_id']]['role_title'] = $role['role_title'];
            $return['roles'][$role['role_id']]['role_id'] = $role['role_id'];
            $return['roles'][$role['role_id']]['users'][$role['user_id']]['user_id'] = $role['user_id'];
            $return['roles'][$role['role_id']]['users'][$role['user_id']]['user_name'] = $role['user_name'];
        }
        return $return;
    }

    private function get_studnet_numbers($where, $sms_to)
    {
        $student = TableRegistry::getTableLocator()->get('scms_students');
        $students = $student->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'rtype' => "g.rtype",
                'relation' => "g.relation",
                'g_phone' => "g.mobile"
            ])
            ->where($where)
            ->where(['status' => 1])
            ->join([
                'g' => [
                    'table' => 'scms_guardians',
                    'type' => 'INNER',
                    'conditions' => [
                        'g.student_id = scms_students.student_id'
                    ]
                ],
            ])
            ->join([
                's' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'INNER',
                    'conditions' => [
                        's.student_id = scms_students.student_id'
                    ]
                ],
            ])
            ->toArray();

        $filter_student = array();
        foreach ($students as $student) {
            if (!isset($filter_student[$student['sid']])) {
                $filter_student[$student['sid']] = $student;
            }
            $filter_student[$student['sid']][$student['rtype']] = $student['g_phone'];

            if ($student['active_guardian'] == $student['rtype']) {
                $filter_student[$student['sid']]['active'] = $student['g_phone'];
            }
        }


        $numbers = array();
        foreach ($filter_student as $student) {
            $numbers[] = $student[$sms_to];
        }
        return $numbers;
    }

    public function index()
    {
        $additionalNumberLimit = Configure::read('SMS.additionalNumberLimit');
        $smsCalculator = new SmsLengthCalculator();
        $box_count = $this->get_settings_value('SMS.Sms_Box_Count');
        $return_data = $this->get_sms_permission_data();
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();

            if (isset($request_data['search_session'])) {
                $return_data = $this->get_sms_permission_data($request_data['search_session']);
            } else {
                $size = $smsCalculator->getPartCount($request_data['sms']);
                if ($box_count) {
                    if ($box_count < $size['part_count']) {
                        $message = 'SMS Could not be sent! \n SMS Size:' . $size['part_count'] . ' Permited Size ' . $box_count;
                        //Set Flash
                        $this->Flash->error($message, [
                            'key' => 'negative',
                            'params' => [],
                        ]);
                        return $this->redirect(['action' => 'index']);
                    }
                }
                $employee_mobile = array();
                $number = array();
                if (isset($request_data['section_id'])) {
                    $where['s.session_id'] = $request_data['session_id'];
                    $where['s.section_id IN'] = $request_data['section_id'];
                    $number = $this->get_studnet_numbers($where, $request_data['sms_to']);
                }

                if (isset($request_data['user_id'])) {
                    $users = $request_data['user_id'];
                    $getEmployees = TableRegistry::getTableLocator()->get('users');
                    $employees = $getEmployees
                        ->find()
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select(['employee_number' => 'emp.mobile'])
                        ->join([
                            'emp' => [
                                'table' => 'employee',
                                'type' => 'LEFT',
                                'conditions' => [
                                    'emp.user_id = users.id',
                                ]
                            ],
                        ])
                        ->where(['user_id' => $users], ['user_id' => 'integer[]'])
                        ->toArray();

                    foreach ($employees as $teacher_data) {
                        $employee_mobile[] = $teacher_data['employee_number'];
                    }
                    $number = array_merge($number, $employee_mobile);
                }
                
                if ($request_data['extra_number'] != null) {
                    $extra_number = explode(",", $request_data['extra_number']);
                    $number = array_merge($number, $extra_number);
                    $number = array_unique(array_filter($number));
                    // $number = array_slice($number, 0, $additionalNumberLimit);
                }
                if ($request_data['extra_sid'] != null) {
                    $extra_sid = explode(",", $request_data['extra_sid']);
                    $extra_where['sid IN'] = $extra_sid;
                    $extra_number = $this->get_studnet_numbers($extra_where, $request_data['sms_to']);
                    $number = array_merge($number, $extra_number);
                }
                $numbers = array_unique(array_filter($number));
                // echo '123444';
                // echo '<pre>';
                // print_r($numbers);die;
                $type = "general";
                $args['sms'] = $request_data['sms'];
                $return = $this->send_sms($type, $numbers, $args);

                // SMS Flash Structure
                if ($return > 0) {
                    if ($return > 1) {
                        $message = 'SMS Sent Successfully to ' . $return . ' Recipients';
                    } else {
                        $message = 'SMS Sent Successfully to' . $return . ' Recipient';
                    }
                    //Set Flash
                    $this->Flash->success($message, [
                        'key' => 'positive',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'index']);
                } else {
                    $message = 'SMS Could not be sent';
                    //Set Flash
                    $this->Flash->error($message, [
                        'key' => 'negative',
                        'params' => [],
                    ]);
                }
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions'); //Execute First
        $sessions = $session
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->order(['session_name' => 'DESC'])
            ->toArray();

        $student = TableRegistry::getTableLocator()->get('scms_students');
        $students = $student->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->order(['sid' => 'ASC'])
            ->select([
                'rtype' => "g.rtype",
                'relation' => "g.relation",
                'g_phone' => "g.mobile"
            ])
            ->where(['status' => 1])
            ->join([
                'g' => [
                    'table' => 'scms_guardians',
                    'type' => 'INNER',
                    'conditions' => [
                        'g.student_id = scms_students.student_id'
                    ]
                ],
            ])
            ->join([
                's' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'INNER',
                    'conditions' => [
                        's.student_id = scms_students.student_id'
                    ]
                ],
            ])
            ->toArray();

        $filter_student = array();
        foreach ($students as $student) {
            if (!isset($filter_student[$student['sid']])) {
                $filter_student[$student['sid']] = $student;
            }
            $filter_student[$student['sid']][$student['rtype']] = $student['g_phone'];

            if ($student['active_guardian'] == $student['rtype']) {
                $filter_student[$student['sid']]['active'] = $student['g_phone'];
            }
        }
// pr($filter_student);die;
        $this->set('all_sid', $filter_student);
        $this->set('sessions', $sessions);
        $this->set('levels', $return_data['level']);
        $this->set('selected', $return_data['selected']);
        $this->set('roles', $return_data['roles']);
        $sms_to['active'] = 'Active Guardian';
        $sms_to['Father'] = 'Father';
        $sms_to['Mother'] = 'Mother';
        $sms_to['mobile'] = 'Student';
        $this->set('sms_to', $sms_to);
        $this->set('box_count', $box_count);
        $char_count = ($box_count == 1) ? 70 : ($box_count * 67);
        $this->set('char_count', $char_count);
    }

    public function smsPermission()
    {
        if ($this->request->is('post')) {
            $scms_sms_permission = TableRegistry::getTableLocator()->get('scms_sms_permission');
            $query = $scms_sms_permission->query();
            $query->delete()->execute();
            $request_data = $this->request->getData();
            $scms_sms_permission_data_section = [];
            $scms_sms_permission_data_role = [];

            if (isset($request_data['section'])) {
                $scms_sms_permission_data_single['sms_permission_type'] = 'section';
                $scms_sms_permission_data_single['role_id'] = null;
                $scms_sms_permission_data_single['user_id'] = null;

                foreach ($request_data['section'] as $session_id => $sessions) {
                    $scms_sms_permission_data_single['session_id'] = $session_id;

                    foreach ($sessions as $level_id => $sections) {
                        $scms_sms_permission_data_single['level_id'] = $level_id;

                        foreach ($sections as $section_id => $section) {
                            $scms_sms_permission_data_single['section_id'] = $section_id;
                            $scms_sms_permission_data_section[] = $scms_sms_permission_data_single;
                        }
                    }
                }
            }

            if (isset($request_data['user'])) {
                foreach ($request_data['user'] as $role_id => $users) {
                    foreach ($users as $user_id => $value) {
                        $scms_sms_permission_data_single = [
                            'sms_permission_type' => 'role',
                            'role_id' => $role_id,
                            'user_id' => $user_id,
                            'session_id' => null,
                            'level_id' => null,
                            'section_id' => null,
                        ];

                        $scms_sms_permission_data_role[] = $scms_sms_permission_data_single;
                    }
                }
            }

            $scms_sms_permission_data = array_merge($scms_sms_permission_data_section, $scms_sms_permission_data_role);

            if (count($scms_sms_permission_data) > 0) {
                $insertQuery = $scms_sms_permission->query();
                $columns = array_keys($scms_sms_permission_data[0]);
                $insertQuery->insert($columns);
                $insertQuery->clause('values')->values($scms_sms_permission_data);
                $insertQuery->execute();
            }


            $this->Flash->success('Sms Permission Successfully Updated', [
                'key' => 'positive',
                'params' => [],
            ]);
        }
        $level = TableRegistry::getTableLocator()->get('scms_levels'); //Execute First
        $levels = $level
            ->find()
            ->toArray();
        $level_with_sessions = array();
        foreach ($levels as $level) {
            $level_with_sessions[$level->level_id]['level_id'] = $level->level_id;
            $level_with_sessions[$level->level_id]['level_name'] = $level->level_name;
        }

        $section = TableRegistry::getTableLocator()->get('scms_sections'); //Execute First
        $sections = $section
            ->find()
            ->toArray();
        foreach ($sections as $section) {
            $single_section['section_id'] = $section->section_id;
            $single_section['section_name'] = $section->section_name;
            $single_section['checked'] = null;
            $level_with_sessions[$section->level_id]['sections'][$single_section['section_id']] = $single_section;
        }

        foreach ($level_with_sessions as $key => $level_with_session) {
            if (!isset($level_with_session['sections'])) {
                unset($level_with_sessions[$key]);
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions'); //Execute First
        $sessions = $session
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $filter_sessions = array();
        foreach ($sessions as $key => $session) {
            $sessions[$key]['level_data'] = $level_with_sessions;
            $filter_sessions[$session['session_id']] = $sessions[$key];
        }

        $get_roles = TableRegistry::getTableLocator()->get('roles'); // Execute First
        $roles = $get_roles
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['alias NOT IN' => ['superadmin', 'public']])
            ->toArray();

        $filter_roles = array();
        foreach ($roles as $key => $role) {
            $usersTable = TableRegistry::getTableLocator()->get('Users');
            $users = $usersTable
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select(['employee_mobile' => 'emp.mobile'])
                ->join([
                    'emp' => [
                        'table' => 'employee',
                        'type' => 'INNER',
                        'conditions' => [
                            'emp.user_id = Users.id'
                        ]
                    ]
                ])
                ->where([
                    'Users.status' => 1,
                    'role_id' => $role['id'],
                    'emp.mobile IS NOT NULL',
                    'emp.mobile !=' => '' // Exclude users with empty employee_mobile
                ])
                ->toArray();

            foreach ($users as &$user) {
                $user['checked'] = null;
            }
            $users = array_column($users, null, 'id');
            $role['users'] = $users;
            $filter_roles[$role['id']] = $role;
        }

        $scms_sms_permission = TableRegistry::getTableLocator()->get('scms_sms_permission');
        $permissions = $scms_sms_permission
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        foreach ($permissions as $permission) {
            if ($permission['sms_permission_type'] == 'section') {
                $filter_sessions[$permission['session_id']]['level_data'][$permission['level_id']]['sections'][$permission['section_id']]['checked'] = 'checked';
            } else if ($permission['sms_permission_type'] == 'role') {
                $roleId = $permission['role_id'];
                $userId = $permission['user_id'];
                $filter_roles[$roleId]['users'][$userId]['checked'] = 'checked';
            }
        }
        $this->set('roles', $filter_roles);
        $this->set('sessions', $filter_sessions);
    }

    public function smsLogs()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $where = [];
            if ($request_data['sms_type'] != null) {
                if ($request_data['sms_type']) {
                    $where['sms_log.sms_type'] = $request_data['sms_type'];
                }
                if (!empty($request_data['start_date']) && !empty($request_data['end_date'])) {
                    $startDate = date('Y-m-d', strtotime($request_data['start_date']));
                    $endDate = date('Y-m-d', strtotime($request_data['end_date']));
                    $where['DATE(sms_log.date) >='] = $startDate;
                    $where['DATE(sms_log.date) <='] = $endDate;

                    $datetime['DATE(sms_log.date) >='] = $startDate;
                    $datetime['DATE(sms_log.date) <='] = $endDate;
                }
                if ($where['sms_log.sms_type'] == 'all') {
                    $logsTable = TableRegistry::getTableLocator()->get('sms_log');
                    $logs = $logsTable->find()
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->order(['date' => 'DESC'])
                        ->where($datetime)
                        ->toArray();
                    $this->set('smsLogs', $logs);
                } else {
                    $logsTable = TableRegistry::getTableLocator()->get('sms_log');
                    $logs = $logsTable->find()
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->order(['date' => 'DESC'])
                        ->where($where)
                        ->toArray();
                    $this->set('smsLogs', $logs);
                }
            } else {
                $this->Flash->error('Please select a correct "SMS Type" or Check the "Date-Range"', [
                    'key' => 'negative',
                    'params' => [],
                ]);
            }
        }

        $logsTable = TableRegistry::getTableLocator()->get('sms_log');
        $searchLogs = $logsTable->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('user_id', $this->Auth->user('id'));
        $this->set('searchLogs', $searchLogs);
    }



    public function sidFetchedNumberAjax(){
        $this->autoRender = false;
        $input_sid = $_GET['sid'];

        $student = TableRegistry::getTableLocator()->get('scms_students');
        $students = $student->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'rtype' => "g.rtype",
                'relation' => "g.relation",
                'g_phone' => "g.mobile"
            ])
            ->where($input_sid)
            ->where(['status' => 1])
            ->join([
                'g' => [
                    'table' => 'scms_guardians',
                    'type' => 'INNER',
                    'conditions' => [
                        'g.student_id = scms_students.student_id'
                    ]
                ],
            ])
            ->join([
                's' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'INNER',
                    'conditions' => [
                        's.student_id = scms_students.student_id'
                    ]
                ],
            ])
            ->toArray();

        $filter_student = array();
        foreach ($students as $student) {
            if (!isset($filter_student[$student['sid']])) {
                $filter_student[$student['sid']] = $student;
            }
            $filter_student[$student['sid']][$student['rtype']] = $student['g_phone'];

            if ($student['active_guardian'] == $student['rtype']) {
                $filter_student[$student['sid']]['active'] = $student['g_phone'];
            }
        }
    }
    
   

    public function otherSms()
    {
        $smsCalculator = new SmsLengthCalculator();
        $box_count = $this->get_settings_value('SMS.Sms_Box_Count');
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();


            $studentTable = TableRegistry::getTableLocator()->get('scms_students');


            if (isset($request_data['user_id'])) {



                $students = $studentTable->find()
                    ->where(['scms_students.student_id IN' => $request_data['student_id']])
                    ->join([
                        'ssc' => [
                            'table' => 'scms_student_cycle',
                            'type' => 'INNER',
                            'conditions' => 'ssc.student_id = scms_students.student_id'
                        ]
                    ])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
                $this->set('students', $students);


                $students_mobile = $this->get_guardians($students);

                $arrg['students'] = array_values($students_mobile);
                $arrg['text'] = $request_data['text'];

                if (($request_data['sms'] == 1) && $request_data['type'] == 'due_sms') {
                    // echo 'er';
                    // die;
                    $numbers = array();
                    $type = "sms_for_due";
                    $send = $this->send_sms($type, $numbers, $arrg);
                    $message = 'Successfully' . $send . 'SMS sent';
                    // pr($students_mobile);
                    // die;
                } elseif (($request_data['sms'] == 1) && $request_data['type'] == 'birthday') {
                    $numbers = array();
                    $type = "birthday";
                    $send = $this->send_sms($type, $numbers, $arrg);
                    $message = 'Successfully' . $send . 'SMS sent';
                } else {
                    $this->Flash->error(__('Please try again.'));
                }
            } else {

                if ($request_data['type'] == 'due_sms') {
                    
                    
                    $where['ssc.session_id'] = $request_data['session_id'];
                    if ($request_data['shift_id']) {
                        $where['ssc.shift_id'] = $request_data['shift_id'];
                    }
                    if ($request_data['level_id']) {
                        $where['ssc.level_id'] = $request_data['level_id'];
                    }
                    
                    $students = $studentTable->find()
                        ->where($where)
                        ->where([
                            'scms_students.status' => 1,
                            // 'ssc.session_id' => $request_data['session_id'],
                            // 'ssc.shift_id' => $request_data['shift_id'],
                            // 'ssc.level_id' => $request_data['level_id'],
                            // 'ssc.section_id' => $request_data['section_id'],
                        ])
                        ->join([
                            'ssc' => [
                                'table' => 'scms_student_cycle',
                                'type' => 'INNER',
                                'conditions' => 'ssc.student_id = scms_students.student_id'
                            ]
                        ])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->toArray();
// echo '<pre>';
// print_r($students);die;
                    $this->set('students', $students);
                } elseif ($request_data['type'] == 'birthday') {

                    $today = date('m-d'); // e.g., "07-19"
                    
                    $where['ssc.session_id'] = $request_data['session_id'];
                    if ($request_data['shift_id']) {
                        $where['ssc.shift_id'] = $request_data['shift_id'];
                    }
                    if ($request_data['level_id']) {
                        $where['ssc.level_id'] = $request_data['level_id'];
                    }
                    
                    
                    $students = $studentTable->find()
                        ->where($where)
                        ->where([
                            'scms_students.status' => 1,
                            "DATE_FORMAT(scms_students.date_of_birth, '%m-%d') =" => $today
                        ])
                        ->join([
                            'ssc' => [
                                'table' => 'scms_student_cycle',
                                'type' => 'INNER',
                                'conditions' => 'ssc.student_id = scms_students.student_id'
                            ]
                        ])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->toArray();


                    $this->set('students', $students);
                }

                $data = $request_data;
                $data['user_id'] = $this->Auth->user('id');
                $this->set('data', $data);
            }

            $this->set('request_data', $request_data);
        }
        $this->set('box_count', $box_count);
        $char_count = ($box_count == 1) ? 70 : ($box_count * 67);
        $this->set('char_count', $char_count);

        // Common data loading for form dropdowns
        $sessionTable = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $sessionTable->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);

        $groupTable = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $groupTable->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('groups', $groups);

        $shiftTable = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shiftTable->find()
            ->where(['shift_id IN' => [1, 2]])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);

        $attendance_type = $this->get_settings_value('Attendance.Type');
        $this->set('attendance_type', $attendance_type);
    }

    private function get_guardians($scms_student_cycles)
    {
        $scms_guardian_table = TableRegistry::getTableLocator()->get('scms_guardians');

        $student_ids = array_column($scms_student_cycles, 'student_id');

        $scms_guardians = $scms_guardian_table->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['student_id IN' => $student_ids])
            ->toArray();

        // Map guardians by student_id
        $guardians_map = [];
        foreach ($scms_guardians as $guardian) {
            $rtype = strtolower($guardian['rtype']);
            $guardians_map[$guardian['student_id']][$rtype] = $guardian;
        }

        // Add guardians to each student record
        foreach ($scms_student_cycles as &$student) {
            $student['guardians'] = $guardians_map[$student['student_id']] ?? [];

            $active = strtolower($student['active_guardian'] ?? '');
            $student['active_guardian_mobile'] = $student['guardians'][$active]['mobile'] ?? null;
        }


        return $scms_student_cycles;
    }
    
    
}
