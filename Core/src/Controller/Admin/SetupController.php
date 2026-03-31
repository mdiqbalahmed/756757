<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class SetupController extends AppController {

    public function initialize() {
        parent::initialize();
    }

//FUNCTION FOR FACULTY
    public function faculty() {
        $data = TableRegistry::getTableLocator()->get('scms_faculty');
        $datas = $data->find();
        $paginate = $this->paginate($datas, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('faculties', $paginate);
    }

    public function addFaculty() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_faculty = TableRegistry::getTableLocator()->get('scms_faculty');
            $query = $get_faculty->query();
            $query
                    ->insert(['faculty_name'])
                    ->values($request_data)
                    ->execute();
//Set Flash
            $this->Flash->success('Faculty Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'Faculty']);
        }
    }
    
    
    
    public function renew()
    {
        if ($this->request->is('post')) {
            $result_data['created_by'] = $this->Auth->user('id');
            $request_data = $this->request->getData();
            $setting = TableRegistry::getTableLocator()->get('settings');
            $settings = $setting
                ->find()
                ->where(['id' => 90])
                ->toArray();
            $currentValue = $settings[0]['value'];

            // Add the renew value to the current value
            $newValue = $currentValue + $request_data['renew'];
            $data['date'] = date('Y-m-d H:i:s');
            $data['user_id'] = $this->Auth->user('id');
            $data['quantity'] = $request_data['renew'];
            // pr($data);
            // die;
            $sms_renew_log = TableRegistry::getTableLocator()->get('sms_renew_log');
            $query = $sms_renew_log->query();
            $query->insert(['date', 'user_id', 'quantity'])
                ->values($data)
                ->execute();

            // Update the value in the $settings array
            $settings[0]['value'] = $newValue;
            $query = $setting->query();
            $query
                ->update()
                ->set([
                    'value' => $newValue
                ])
                ->where(['id' => 90])
                ->execute();

            $this->Flash->success('Renew Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'renew']);
        }
    }
    
    
    public function renewReport()
    {
        // Set default values for the view
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            
            // Store the submitted dates to repopulate the form
            $this->request->data['start_date'] = $request_data['start_date'] ?? $startDate;
            $this->request->data['end_date'] = $request_data['end_date'] ?? $endDate;
            
            // Validate that both dates are provided
            if (empty($request_data['start_date']) || empty($request_data['end_date'])) {
                $this->Flash->error('Please select both start and end dates', [
                    'key' => 'negative'
                ]);
                return;
            }
            
            // Process dates
            $startDate = date('Y-m-d', strtotime($request_data['start_date']));
            $endDate = date('Y-m-d', strtotime($request_data['end_date']));
            
            // Validate date range
            if ($startDate > $endDate) {
                $this->Flash->error('End date must be after start date', [
                    'key' => 'negative'
                ]);
                return;
            }
            
            $where = [
                'DATE(sms_renew_log.date) >=' => $startDate,
                'DATE(sms_renew_log.date) <=' => $endDate
            ];
            
            $logsTable = TableRegistry::getTableLocator()->get('sms_renew_log');
            $logs = $logsTable->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'date',
                    'quantity',
                    'employee_name' => 'users.name',
                ])
                ->join([
                    'users' => [
                        'table' => 'users',
                        'type' => 'LEFT',
                        'conditions' => [
                            'sms_renew_log.user_id = users.id'
                        ]
                    ],
                ])
                ->order(['date' => 'DESC'])
                ->where($where)
                ->toArray();
                
            $this->set('smsLogs', $logs);
        }
        
        // Always set these so the view has the current dates (either submitted or default)
        $this->set('start_date', $this->request->data['start_date'] ?? $startDate);
        $this->set('end_date', $this->request->data['end_date'] ?? $endDate);
    }

    public function editFaculty($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $faculty = TableRegistry::getTableLocator()->get('scms_faculty');
            $query = $faculty->query();
            $query
                    ->update()
                    ->set($this->request->getData())
                    ->where(['faculty_id' => $data['faculty_id']])
                    ->execute();
//Set Flash
            $this->Flash->info('Faculty Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'faculty']);
        }
        $faculty = TableRegistry::getTableLocator()->get('scms_faculty'); //Execute First
        $faculties = $faculty
                ->find()
                ->where(['faculty_id' => $id])
                ->toArray();
        $this->set('faculties', $faculties);
    }

//FUNCTION FOR DEPARTMENTS
    public function department() {
        $data = TableRegistry::getTableLocator()->get('scms_departments');
        $result = $data
                ->find()
                ->enableAutoFields(true)
// ->enableHydration(false)
                ->order('scms_departments.department_id ASC')
                ->select([
                    'id' => 'scms_departments.department_id',
                    'department_name' => 'scms_departments.department_name',
                    'faculty_name' => 'f.faculty_name', //Short form of Faculty is f
                ])
                ->join([
            'f' => [
                'table' => 'scms_faculty',
                'type' => 'LEFT',
                'conditions' => ['f.faculty_id = scms_departments.faculty_id'],
            ],
        ]);
        $faculty = TableRegistry::getTableLocator()->get('scms_faculty'); //Execute First
        $faculties = $faculty->find()->toArray();
        $this->set('faculties', $faculties);

        $paginate = $this->paginate($result, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('results', $paginate);
    }

    public function addDepartment() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_departments = TableRegistry::getTableLocator()->get('scms_departments');
            $query = $get_departments->query();
            $query
                    ->insert(['department_name', 'faculty_id'])
                    ->values($request_data)
                    ->execute();
//Set Flash
            $this->Flash->success('Department Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'department']);
        }
        $faculty = TableRegistry::getTableLocator()->get('scms_faculty');
        $faculties = $faculty->find()->toArray();

        $this->set('faculties', $faculties);
    }

    public function editDepartment($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $departments = TableRegistry::getTableLocator()->get('scms_departments');
            $query = $departments->query();
            $query
                    ->update()
                    ->set($this->request->getData())
                    ->where(['department_id' => $data['department_id']])
                    ->execute();

//Set Flash
            $this->Flash->info('Department Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'department']);
        }
// Text Block Starts() {
        $department = TableRegistry::getTableLocator()->get('scms_departments'); //Execute First
        $departments = $department
                ->find()
                ->where(['department_id' => $id])
                ->toArray();
        $this->set('departments', $departments);
// Text Block End() }
        $faculty = TableRegistry::getTableLocator()->get('scms_faculty');
        $faculties = $faculty->find()->toArray();
        $this->set('faculties', $faculties);
    }

    public function level() {
        $data = TableRegistry::getTableLocator()->get('scms_levels');
        $datas = $data
                ->find()
                ->enableAutoFields(true)
                ->select([
                    'id' => 'scms_levels.department_id',
                    'level_name' => 'scms_levels.level_name',
                    'd_department_name' => 'd.department_name', //Short form of Faculty is f
                ])
                ->join([
            'd' => [
                'table' => 'scms_departments',
                'type' => 'LEFT',
                'conditions' => ['d.department_id = scms_levels.department_id'],
            ],
        ]);
        $paginate = $this->paginate($datas, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('datas', $paginate);
    }

    public function addLevel() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_levels = TableRegistry::getTableLocator()->get('scms_levels');
            $query = $get_levels->query();
            $query
                    ->insert(['level_name', 'department_id'])
                    ->values($request_data)
                    ->execute();
//Set Flash
            $this->Flash->success('Level Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);

            return $this->redirect(['action' => 'Level']);
        }
        $department = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $department->find()->toArray();
        $this->set('departments', $departments);
    }

    public function editLevel($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $level = TableRegistry::getTableLocator()->get('scms_levels');
            $query = $level->query();
            $query
                    ->update()
                    ->set($this->request->getData())
                    ->where(['level_id' => $data['level_id']])
                    ->execute();
//Set Flash
            $this->Flash->info('Level Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'level']);
        }
        $level = TableRegistry::getTableLocator()->get('scms_levels'); //Execute First
        $levels = $level
                ->find()
                ->where(['level_id' => $id])
                ->toArray();
        $this->set('levels', $levels);
        $department = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $department->find()->toArray();
        $this->set('departments', $departments);
    }

//FUNCTION FOR COURSES
    public function course() {
        $where = null;
        $request_data['course_type_id'] = null;
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if ($request_data['course_type_id']) {
                $where['ct.course_type_id'] = $request_data['course_type_id'];
            }
        }
        $data = TableRegistry::getTableLocator()->get('scms_courses');
        $result = $data
                ->find()
                ->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'course_id' => 'scms_courses.course_id',
                    'course_name' => 'scms_courses.course_name',
                    'department_name' => 'd.department_name',
                    'course_type_name' => 'ct.course_type_name',
                    'group_name' => 'g.group_name',
                ])
                ->join([
            'd' => [
                'table' => 'scms_departments',
                'type' => 'LEFT',
                'conditions' => ['d.department_id = scms_courses.department_id'],
            ],
            'ct' => [
                'table' => 'scms_course_type',
                'type' => 'LEFT',
                'conditions' => ['ct.course_type_id = scms_courses.course_type_id'],
            ],
            'g' => [
                'table' => 'scms_groups',
                'type' => 'LEFT',
                'conditions' => ['g.group_id = scms_courses.course_group_id'],
            ]
        ]);
        $course_type = TableRegistry::getTableLocator()->get('scms_course_type');
        $course_types = $course_type
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

        $this->set('course_types', $course_types);

        $paginate = $this->paginate($result, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('results', $paginate);
        $this->set('request_data', $request_data);
    }

    public function addCourse() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_courses = TableRegistry::getTableLocator()->get('scms_courses');
            $query = $get_courses->query();
            $query
                    ->insert(['course_name', 'course_code', 'department_id', 'course_type_id', 'course_group_id'])
                    ->values($request_data)
                    ->execute();

//Set Flash
            $this->Flash->success('Course Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'course']);
        }
        $department = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $department->find()->toArray();
        $this->set('departments', $departments);

        $course_type = TableRegistry::getTableLocator()->get('scms_course_type');
        $course_types = $course_type->find()->toArray();
        $this->set('course_types', $course_types);

        $scms_group = TableRegistry::getTableLocator()->get('scms_groups');
        $scms_groups = $scms_group->find()->toArray();
        $this->set('scms_groups', $scms_groups);
    }

    public function editCourse($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $get_courses = TableRegistry::getTableLocator()->get('scms_courses');
            $query = $get_courses->query();
            $query
                    ->update()
                    ->set($this->request->getData())
                    ->where(['course_id' => $id])
                    ->execute();
//Set Flash
            $this->Flash->info('Course Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'course']);
        }

        $course = TableRegistry::getTableLocator()->get('scms_courses'); //Execute First
        $courses = $course
                ->find()
                ->where(['course_id' => $id])
                ->toArray();
        $this->set('courses', $courses);

        $department = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $department->find()->toArray();
        $this->set('departments', $departments);

        $course_type = TableRegistry::getTableLocator()->get('scms_course_type');
        $course_types = $course_type->find()->toArray();
        $this->set('course_types', $course_types);

        $scms_group = TableRegistry::getTableLocator()->get('scms_groups');
        $scms_groups = $scms_group->find()->toArray();
        $this->set('scms_groups', $scms_groups);
    }

//FUNCTION FOR SESSIONS
    public function session() {
        $data = TableRegistry::getTableLocator()->get('scms_sessions');
        $datas = $data->find()->order(['session_name' => 'DESC']);
        $paginate = $this->paginate($datas, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('datas', $paginate);
    }

    public function addSession() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
            $query = $get_sessions->query();
            $query
                    ->insert(['session_name'])
                    ->values($request_data)
                    ->execute();

//Set Flash
            $this->Flash->success('Session Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'Session']);
        }
    }

    public function editSession($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $session = TableRegistry::getTableLocator()->get('scms_sessions');
            if ($data['active']) {
                $active_data['active'] = 0;
                $query = $session->query();
                $query
                        ->update()
                        ->set($active_data)
                        ->execute();
            }

            $query = $session->query();
            $query
                    ->update()
                    ->set($this->request->getData())
                    ->where(['session_id' => $data['session_id']])
                    ->execute();

            //Set Flash
            $this->Flash->info('Session Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'session']);
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions'); //Execute First
        $sessions = $session
                ->find()
                ->where(['session_id' => $id])
                ->toArray();
        $this->set('sessions', $sessions);
    }

    public function section() {
        $data = TableRegistry::getTableLocator()->get('scms_sections');
        $result = $data
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'id' => 'scms_sections.section_id',
                    'section_name' => 'scms_sections.section_name',
                    'shift_name' => 's.shift_name', //Short form of shift is s
                    'level_name' => 'l.level_name',
                ])
                ->join([
            's' => [
                'table' => 'hr_shift',
                'type' => 'LEFT',
                'conditions' => ['s.shift_id = scms_sections.shift_id'],
            ],
            'l' => [
                'table' => 'scms_levels',
                'type' => 'LEFT',
                'conditions' => ['l.level_id = scms_sections.level_id'],
            ],
        ]);
        $paginate = $this->paginate($result, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('results', $paginate);
    }

    public function addSection() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();

            $get_sections = TableRegistry::getTableLocator()->get('scms_sections');
            $query = $get_sections->query();
            $query
                    ->insert(['section_name', 'shift_id', 'level_id'])
                    ->values($request_data)
                    ->execute();

//Set Flash
            $this->Flash->success('Section Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);

            return $this->redirect(['action' => 'Section']);
        }

        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift->find()->toArray();
        $this->set('shifts', $shifts);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);
    }

    public function editSection($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $section = TableRegistry::getTableLocator()->get('scms_sections');
            $query = $section->query();
            $query
                    ->update()
                    ->set($data)
                    ->where(['section_id' => $id])
                    ->execute();
//Set Flash
            $this->Flash->info('Section Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'section']);
        }
        $section = TableRegistry::getTableLocator()->get('scms_sections'); //Execute First
        $sections = $section
                ->find()
                ->where(['section_id' => $id])
                ->toArray();
        $this->set('sections', $sections);

        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift->find()->toArray();
        $this->set('shifts', $shifts);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);
    }

    public function editShift($id) {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $get_shifts = TableRegistry::getTableLocator()->get('hr_shift');
            $query = $get_shifts->query();
            $query
                    ->update()
                    ->set($request_data)
                    ->where(['shift_id' => $id])
                    ->execute();

//Set Flash
            $this->Flash->info('Shift Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'Shift']);
        }
        $shift = TableRegistry::getTableLocator()->get('hr_shift'); //Execute First
        $shifts = $shift
                ->find()
                ->where(['shift_id' => $id])
                ->toArray();
        $this->set('shifts', $shifts);
    }

    public function shift() {
        $data = TableRegistry::getTableLocator()->get('hr_shift');
        $datas = $data->find();
        $paginate = $this->paginate($datas, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('datas', $paginate);
    }

    public function addShift() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_shifts = TableRegistry::getTableLocator()->get('hr_shift');
            $query = $get_shifts->query();
            $query
                    ->insert(['shift_name'])
                    ->values($request_data)
                    ->execute();
//Set Flash
            $this->Flash->success('Shift Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'Shift']);
        }
    }

    public function index() {
        /*
          $student = TableRegistry::getTableLocator()->get('scms_students');
          $students = $student
          ->find()
          ->select([
          'student_cycle_id' => 'sc.student_cycle_id',
          ])
          ->where(['thrid_subject is not NULL'])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->join([
          'sc' => [
          'table' => 'scms_student_cycle',
          'type' => 'LEFT',
          'conditions' => ['sc.student_id  = scms_students.student_id'],
          ],
          ])
          ->toArray();
          $scms_third_and_forth_subject_data = array();
          foreach ($students as $student) {
          $single_scms_third_and_forth_subject['student_cycle_id'] = $student['student_cycle_id'];
          if ($student['thrid_subject']) {
          $single_scms_third_and_forth_subject['course_id'] = $student['thrid_subject'];
          $single_scms_third_and_forth_subject['type'] = 'thrid';
          $scms_third_and_forth_subject_data[] = $single_scms_third_and_forth_subject;
          }
          if ($student['thrid_subject_1']) {
          $single_scms_third_and_forth_subject['course_id'] = $student['thrid_subject_1'];
          $single_scms_third_and_forth_subject['type'] = 'thrid';
          $scms_third_and_forth_subject_data[] = $single_scms_third_and_forth_subject;
          }
          if ($student['forth_subject']) {
          $single_scms_third_and_forth_subject['course_id'] = $student['forth_subject'];
          $single_scms_third_and_forth_subject['type'] = 'fourth';
          $scms_third_and_forth_subject_data[] = $single_scms_third_and_forth_subject;
          }
          if ($student['forth_subject_1']) {
          $single_scms_third_and_forth_subject['course_id'] = $student['forth_subject_1'];
          $single_scms_third_and_forth_subject['type'] = 'fourth';
          $scms_third_and_forth_subject_data[] = $single_scms_third_and_forth_subject;
          }
          }
          if (count($scms_third_and_forth_subject_data)) {
          $scms_third_and_forth_subject = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
          $insertQuery = $scms_third_and_forth_subject->query();
          $columns = array_keys($scms_third_and_forth_subject_data[0]);
          $insertQuery->insert($columns);
          $insertQuery->clause('values')->values($scms_third_and_forth_subject_data);
          $insertQuery->execute();
          }
          pr('done');
          die;
         *
         */
    }

    public function activityCycle() {
        $where = null;
        $request_data['department_id'] = null;
        $request_data['level_id'] = null;
        $request_data['session_id'] = null;

        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if ($request_data['department_id']) {
                $where['d.department_id'] = $request_data['department_id'];
            }
            if ($request_data['level_id']) {
                $where['l.level_id'] = $request_data['level_id'];
            }
            if ($request_data['session_id']) {
                $where['s.session_id'] = $request_data['session_id'];
            }
        }
        $where['scms_activity.deleted'] = 0;
        $data = TableRegistry::getTableLocator()->get('scms_activity_cycle');
        $result = $data
                ->find()
                ->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'level_name' => 'l.level_name',
                    'session_name' => 's.session_name',
                    'department_name' => 'd.department_name',
                    'activity_name' => 'scms_activity.name',
                ])
                ->join([
            'scms_activity' => [
                'table' => 'scms_activity',
                'type' => 'LEFT',
                'conditions' => ['scms_activity.activity_id  = scms_activity_cycle.activity_id'],
            ],
            'l' => [
                'table' => 'scms_levels',
                'type' => 'LEFT',
                'conditions' => ['l.level_id  = scms_activity_cycle.level_id'],
            ],
            's' => [
                'table' => 'scms_sessions',
                'type' => 'LEFT',
                'conditions' => ['s.session_id  = scms_activity_cycle.session_id'],
            ],
            'd' => [
                'table' => 'scms_departments',
                'type' => 'LEFT',
                'conditions' => ['d.department_id  = l.department_id'],
            ],
        ]);

        $paginate = $this->paginate($result, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();

        $this->set('results', $paginate);

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $department = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $department->find()->toArray();
        $this->set('departments', $departments);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
                ->find()
                ->enableAutoFields(true)
                ->toArray();
        $this->set('levels', $levels);
        $this->set('request_data', $request_data);
    }

    public function activity() {
        $data = TableRegistry::getTableLocator()->get('scms_activity');
        $datas = $data->find()->where(['deleted' => 0]);
        $paginate = $this->paginate($datas, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('datas', $paginate);
    }

    public function addActivity() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $scms_activity_data['name'] = $request_data['activity_name'];
            if (isset($request_data['comment'])) {
                $scms_activity_data['comment'] = $request_data['comment'];
            }
            if (isset($request_data['multiple'])) {
                $scms_activity_data['multiple'] = 1;
            }
            $columns = array_keys($scms_activity_data);
            $scms_activity = TableRegistry::getTableLocator()->get('scms_activity');
            $query = $scms_activity->query();
            $query
                    ->insert($columns)
                    ->values($scms_activity_data)
                    ->execute();

            $myrecords = $scms_activity->find()->last(); //get the last id
            $activity_id = $myrecords->activity_id;
            if (isset($request_data['new_remark_name'])) {
                $this->save_new_activity_remark($request_data, $activity_id);
            }
//Set Flash
            $this->Flash->success('Activity Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'Activity']);
        }
    }

    private function save_new_activity_remark($request_data, $activity_id) {
        foreach ($request_data['new_remark_name'] as $key => $new_remark_name) {
            $scms_activity_remark_single['activity_id'] = $activity_id;
            $scms_activity_remark_single['remark_name'] = $new_remark_name;
            if ($request_data['new_remark_default'][$key] == 'yes') {
                $scms_activity_remark_single['is_default'] = 1;
            } else {
                $scms_activity_remark_single['is_default'] = 0;
            }
            $scms_activity_remark_data[] = $scms_activity_remark_single;
        }
        $scms_activity_remark_data_columns = array_keys($scms_activity_remark_data[0]);

        $scms_activity_remark = TableRegistry::getTableLocator()->get('scms_activity_remark');
        $insertQueryActivityRemark = $scms_activity_remark->query();
        $insertQueryActivityRemark->insert($scms_activity_remark_data_columns);
        $insertQueryActivityRemark->clause('values')->values($scms_activity_remark_data);
        if ($insertQueryActivityRemark->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function editActivity($id) {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $scms_activity_data['name'] = $request_data['activity_name'];
            if (isset($request_data['multiple'])) {
                $scms_activity_data['multiple'] = 1;
            } else {
                $scms_activity_data['multiple'] = 0;
            }
            if (isset($request_data['comment'])) {
                $scms_activity_data['comment'] = $request_data['comment'];
            }
            $scms_activity = TableRegistry::getTableLocator()->get('scms_activity');
            $query = $scms_activity->query();
            $query
                    ->update()
                    ->set($scms_activity_data)
                    ->where(['activity_id' => $id])
                    ->execute();

            $scms_activity_remark = TableRegistry::getTableLocator()->get('scms_activity_remark');
            $activity_remark = $scms_activity_remark
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['activity_id' => $id])
                    ->toArray();

            $old_activity_remark_ids = array();
            foreach ($activity_remark as $remark) {
                $old_activity_remark_ids[] = $remark['activity_remark_id'];
            }
            if (isset($request_data['old_remark_id'])) {
                $delete_remark_ids = array_diff($old_activity_remark_ids, $request_data['old_remark_id']);
                $deleted['deleted'] = 1;

                foreach ($delete_remark_ids as $delete_remark_id) {
                    $query = $scms_activity_remark->query();
                    $query->update()
                            ->set($deleted)
                            ->where(['activity_remark_id' => $delete_remark_id])
                            ->execute();
                }
            }
            if (isset($request_data['new_remark_name'])) {
                $this->save_new_activity_remark($request_data, $id);
            }
            if (isset($request_data['old_remark_name'])) {
                foreach ($request_data['old_remark_name'] as $key => $old_remark_name) {
                    $old_remark_name_update_data['remark_name'] = $old_remark_name;
                    if ($request_data['old_remark_default'][$key] == 'yes') {
                        $old_remark_name_update_data['is_default'] = 1;
                    } else {
                        $old_remark_name_update_data['is_default'] = 0;
                    }
                    $query = $scms_activity_remark->query();
                    $query
                            ->update()
                            ->set($old_remark_name_update_data)
                            ->where(['activity_remark_id' => $request_data['old_remark_id'][$key]])
                            ->execute();
                }
            }

//Set Flash
            $this->Flash->success('Activity Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'Activity']);
        }
        $scms_activity = TableRegistry::getTableLocator()->get('scms_activity');
        $activity = $scms_activity
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['activity_id' => $id])
                ->toArray();
        $this->set('activity', $activity[0]);
        $scms_activity_remark = TableRegistry::getTableLocator()->get('scms_activity_remark');
        $activity_remark = $scms_activity_remark
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['activity_id' => $id])
                ->where(['deleted' => 0])
                ->toArray();

        $this->set('activity_remark', $activity_remark);
    }

    public function term() {
        $term = TableRegistry::getTableLocator()->get('scms_term');
        $terms = $term->find();
        $paginate = $this->paginate($terms, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('results', $paginate);
    }

    public function addTerm() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $term = TableRegistry::getTableLocator()->get('scms_term');
            $query = $term->query();
            $query
                    ->insert(['term_name'])
                    ->values($request_data)
                    ->execute();

//Set Flash
            $this->Flash->success('Term Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);

            return $this->redirect(['action' => 'term']);
        }
    }

    public function editTerm($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $term = TableRegistry::getTableLocator()->get('scms_term');
            $query = $term->query();
            $query
                    ->update()
                    ->set($this->request->getData())
                    ->where(['term_id' => $data['term_id']])
                    ->execute();
//Set Flash
            $this->Flash->info('Term Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'term']);
        }
        $term = TableRegistry::getTableLocator()->get('scms_term'); //Execute First
        $terms = $term
                ->find()
                ->where(['term_id' => $id])
                ->toArray();
        $this->set('terms', $terms);
    }

    public function termCycle()
    {
        $where = null;
        $request_data['level_id'] = null;
        $request_data['session_id'] = null;
        $request_data['term_cycle_id'] = null;

        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            
            if ($request_data['level_id']) {
                $where['l.level_id'] = $request_data['level_id'];
            }
            
            if ($request_data['session_id']) {
                $where['s.session_id'] = $request_data['session_id'];
            }
            if ($request_data['term_cycle_id']) {
                $where['scms_term_cycle.term_cycle_id'] = $request_data['term_cycle_id'];
            }
        }

        // if ($this->request->is('post')) {
        //     $request_data = $this->request->getData();
        //     if ($request_data['session_id']) {
        //         $where['s.session_id'] = $request_data['session_id'];
        //     }
        // }
        $data = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $result = $data
            ->find()
            ->where($where)
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'term_name' => 't.term_name',
                'level_name' => 'l.level_name',
                'session_name' => 's.session_name',
            ])
            ->join([
                't' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => ['t.term_id  = scms_term_cycle.term_id'],
                ],
            ])
            ->join([
                'l' => [
                    'table' => 'scms_levels',
                    'type' => 'LEFT',
                    'conditions' => ['l.level_id  = scms_term_cycle.level_id'],
                ],
            ])
            ->join([
                's' => [
                    'table' => 'scms_sessions',
                    'type' => 'LEFT',
                    'conditions' => ['s.session_id  = scms_term_cycle.session_id'],
                ],
            ]);

        $paginate = $this->paginate($result, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        
        $this->set('results', $paginate);
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);
       

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
                ->find()
                ->enableAutoFields(true)
                ->toArray();
        $this->set('levels', $levels);

        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $courses = $course
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        $this->set('courses', $courses);

        $term = TableRegistry::getTableLocator()->get('scms_term');
        $terms = $term
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

        $this->set('terms', $terms);

        $this->set('request_data', $request_data);
    }

   /* function addTermCycle() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();

            $level_ids = $request_data['level_id'];
            $count = 0;
            $scms_courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
            $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
            foreach ($level_ids as $level_id) {
                $request_data['level_id'] = $level_id;
                $terms = $term_cycle
                        ->find()
                        ->where(['term_id' => $request_data['term_id']])
                        ->where(['session_id' => $request_data['session_id']])
                        ->where(['level_id' => $request_data['level_id']])
                        ->toArray();

                if (count($terms) == 0) {
                    $count++;

                    $query = $term_cycle->query();
                    $query
                            ->insert(['term_id', 'level_id', 'session_id'])
                            ->values($request_data)
                            ->execute();

                    $myrecords = $term_cycle->find()->last(); //get the last id
                    $term_cycle_id = $term_course_cycle_data['term_cycle_id'] = $myrecords->term_cycle_id;

//insert scms_term_course_cycle
                    $term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
                    $courses_cycles = $scms_courses_cycle
                                    ->find()
                                    ->where(['session_id' => $request_data['session_id']])
                                    ->where(['level_id' => $level_id])
                                    ->enableAutoFields(true)
                                    ->enableHydration(false)
                                    ->select([
                                        'course_name' => 'c.course_name',
                                    ])
                                    ->join([
                                        'c' => [
                                            'table' => 'scms_courses',
                                            'type' => 'LEFT',
                                            'conditions' => ['c.course_id   = scms_courses_cycle.course_id'],
                                        ],
                                    ])->toArray();

                    foreach ($courses_cycles as $key => $courses_cycle) {
                        $term_course_cycle_data['courses_cycle_id'] = $courses_cycle['courses_cycle_id'];
                        $query = $term_course_cycle->query();
                        $query
                                ->insert(['courses_cycle_id', 'term_cycle_id'])
                                ->values($term_course_cycle_data)
                                ->execute();
                        $term_course_cycle_id = $term_course_cycle->find()->last(); //get the last id
                        $course_cycle_ids[$term_course_cycle_id->term_course_cycle_id] = $term_course_cycle_id->courses_cycle_id;
                    }


//end scms_term_course_cycle
//------***------
//insert scms_student_term_cycle
                    $student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
                    $student_cycles = $student_cycle->find()
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->where(['scms_student_cycle.level_id' => $level_id])
                            ->where(['session_id' => $request_data['session_id']])
                            ->toArray();

                    foreach ($student_cycles as $student) {
                        $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
                        $scms_student_term_cycle_data['student_cycle_id'] = $student['student_cycle_id'];
                        $scms_student_term_cycle_data['term_cycle_id'] = $term_cycle_id;
                        $query = $scms_student_term_cycle->query();
                        $query
                                ->insert(['student_cycle_id', 'term_cycle_id'])
                                ->values($scms_student_term_cycle_data)
                                ->execute();
                        $scms_student_term_cycle_last_data = $scms_student_term_cycle->find()->last(); //get the last id
                        $student_term_course_cycle_data['student_term_cycle_id'] = $scms_student_term_cycle_last_data->student_term_cycle_id;

//insert scms_student_term_course_cycle for single student
                        $get_student_all_course_cycles = $this->get_student_course_cycle($course_cycle_ids, $student['student_cycle_id']);

                        foreach ($get_student_all_course_cycles as $key => $get_student_all_course_cycle) {
                            $student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
                            $student_term_course_cycle_data['student_course_cycle_id'] = $get_student_all_course_cycle;
                            $query = $student_term_course_cycle->query();
                            $query
                                    ->insert(['student_term_cycle_id', 'student_course_cycle_id'])
                                    ->values($student_term_course_cycle_data)
                                    ->execute();
                        }
//end scms_student_term_course_cycle for single student
                    }
//end scms_student_term_cycle
//insert scms_term_activity_cycle start
                    $scms_term_activity_cycle_data = array();
                    $scms_activity_cycle = TableRegistry::getTableLocator()->get('scms_activity_cycle');
                    $activity_cycle = $scms_activity_cycle
                            ->find()
                            ->where(['session_id' => $request_data['session_id']])
                            ->where(['level_id' => $level_id])
                            ->where(['scms_activity.deleted' => 0])
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->join([
                                'scms_activity' => [
                                    'table' => 'scms_activity',
                                    'type' => 'LEFT',
                                    'conditions' => ['scms_activity.activity_id  = scms_activity_cycle.activity_id'],
                                ],
                            ])
                            ->toArray();
                    if (count($activity_cycle) > 0) {
                        $scms_term_activity_cycle_data_single['term_cycle_id'] = $term_cycle_id;
                        foreach ($activity_cycle as $activity_cycle_single) {
                            $scms_term_activity_cycle_data_single['activity_cycle_id'] = $activity_cycle_single['activity_cycle_id'];
                            $scms_term_activity_cycle_data[] = $scms_term_activity_cycle_data_single;
                        }

                        $columns = array_keys($scms_term_activity_cycle_data[0]);
                        $scms_term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_activity_cycle');
                        $insertQuery = $scms_term_course_cycle->query();
                        $insertQuery->insert($columns);
// you must always alter the values clause AFTER insert
                        $insertQuery->clause('values')->values($scms_term_activity_cycle_data);
                        $insertQuery->execute();
                    }
//insert scms_term_activity_cycle end
                }
            }
//Set Flash
            if ($count > 0) {
                $this->Flash->success($count . ' Term Cycle(s) Added Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
            } else {
                $this->Flash->warning('Term Cycle Cannot Be Added', [
                    'key' => 'positive',
                    'params' => [],
                ]);
            }

            return $this->redirect(['action' => 'termCycle']);
        }
        $term = TableRegistry::getTableLocator()->get('scms_term');
        $terms = $term->find()->toArray();
        $this->set('terms', $terms);

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
                        ->find()
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'department_name' => 'd.department_name',
                        ])
                        ->join([
                            'd' => [
                                'table' => 'scms_departments',
                                'type' => 'LEFT',
                                'conditions' => ['d.department_id  = scms_levels.department_id'],
                            ],
                        ])->toArray();
        $this->set('levels', $levels);
    } */
    
    function addTermCycle()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();

            $level_ids = $request_data['level_id'];
            $count = 0;
            $scms_courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
            $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
            foreach ($level_ids as $level_id) {
                $request_data['level_id'] = $level_id;
                $terms = $term_cycle
                    ->find()
                    ->where(['term_id' => $request_data['term_id']])
                    ->where(['session_id' => $request_data['session_id']])
                    ->where(['level_id' => $request_data['level_id']])
                    ->toArray();

                if (count($terms) == 0) {
                    $count++;

                    $query = $term_cycle->query();
                    $query
                        ->insert(['term_id', 'level_id', 'session_id'])
                        ->values($request_data)
                        ->execute();

                    $myrecords = $term_cycle->find()->last(); //get the last id
                    $term_cycle_id = $term_course_cycle_data['term_cycle_id'] = $myrecords->term_cycle_id;

                    //insert scms_term_course_cycle
                    $term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
                    $courses_cycles = $scms_courses_cycle
                        ->find()
                        ->where(['session_id' => $request_data['session_id']])
                        ->where(['level_id' => $level_id])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'course_name' => 'c.course_name',
                        ])
                        ->join([
                            'c' => [
                                'table' => 'scms_courses',
                                'type' => 'LEFT',
                                'conditions' => ['c.course_id   = scms_courses_cycle.course_id'],
                            ],
                        ])->toArray();

                    foreach ($courses_cycles as $key => $courses_cycle) {
                        $term_course_cycle_data['courses_cycle_id'] = $courses_cycle['courses_cycle_id'];
                        $query = $term_course_cycle->query();
                        $query
                            ->insert(['courses_cycle_id', 'term_cycle_id'])
                            ->values($term_course_cycle_data)
                            ->execute();
                        $term_course_cycle_id = $term_course_cycle->find()->last(); //get the last id
                        $course_cycle_ids[$term_course_cycle_id->term_course_cycle_id] = $term_course_cycle_id->courses_cycle_id;
                    }


                    //end scms_term_course_cycle
                    //------***------
                    //insert scms_student_term_cycle
                    $student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
                    $student_cycles = $student_cycle->find()
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->where(['scms_student_cycle.level_id' => $level_id])
                        ->where(['session_id' => $request_data['session_id']])
                        ->toArray();

                    foreach ($student_cycles as $student) {
                        $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
                        $scms_student_term_cycle_data['student_cycle_id'] = $student['student_cycle_id'];
                        $scms_student_term_cycle_data['term_cycle_id'] = $term_cycle_id;
                        $query = $scms_student_term_cycle->query();
                        $query
                            ->insert(['student_cycle_id', 'term_cycle_id'])
                            ->values($scms_student_term_cycle_data)
                            ->execute();
                        $scms_student_term_cycle_last_data = $scms_student_term_cycle->find()->last(); //get the last id
                        $student_term_course_cycle_data['student_term_cycle_id'] = $scms_student_term_cycle_last_data->student_term_cycle_id;

                        #added by @shovon
                        if (isset($student['group_id'])) {
                            $get_student_all_course_cycles = $this->get_student_course_cycle_with_group($course_cycle_ids, $student['student_cycle_id'], $student['group_id']);
                        } else {
                            //insert scms_student_term_course_cycle for single student
                            $get_student_all_course_cycles = $this->get_student_course_cycle($course_cycle_ids, $student['student_cycle_id']);
                        }
                        #end



                        foreach ($get_student_all_course_cycles as $key => $get_student_all_course_cycle) {
                            $student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
                            $student_term_course_cycle_data['student_course_cycle_id'] = $get_student_all_course_cycle;
                            $query = $student_term_course_cycle->query();
                            $query
                                ->insert(['student_term_cycle_id', 'student_course_cycle_id'])
                                ->values($student_term_course_cycle_data)
                                ->execute();
                        }
                        //end scms_student_term_course_cycle for single student
                    }
                    //end scms_student_term_cycle
                    //insert scms_term_activity_cycle start
                    $scms_term_activity_cycle_data = array();
                    $scms_activity_cycle = TableRegistry::getTableLocator()->get('scms_activity_cycle');
                    $activity_cycle = $scms_activity_cycle
                        ->find()
                        ->where(['session_id' => $request_data['session_id']])
                        ->where(['level_id' => $level_id])
                        ->where(['scms_activity.deleted' => 0])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->join([
                            'scms_activity' => [
                                'table' => 'scms_activity',
                                'type' => 'LEFT',
                                'conditions' => ['scms_activity.activity_id  = scms_activity_cycle.activity_id'],
                            ],
                        ])
                        ->toArray();
                    if (count($activity_cycle) > 0) {
                        $scms_term_activity_cycle_data_single['term_cycle_id'] = $term_cycle_id;
                        foreach ($activity_cycle as $activity_cycle_single) {
                            $scms_term_activity_cycle_data_single['activity_cycle_id'] = $activity_cycle_single['activity_cycle_id'];
                            $scms_term_activity_cycle_data[] = $scms_term_activity_cycle_data_single;
                        }

                        $columns = array_keys($scms_term_activity_cycle_data[0]);
                        $scms_term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_activity_cycle');
                        $insertQuery = $scms_term_course_cycle->query();
                        $insertQuery->insert($columns);
                        // you must always alter the values clause AFTER insert
                        $insertQuery->clause('values')->values($scms_term_activity_cycle_data);
                        $insertQuery->execute();
                    }
                    //insert scms_term_activity_cycle end
                }
            }
            //Set Flash
            if ($count > 0) {
                $this->Flash->success($count . ' Term Cycle(s) Added Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
            } else {
                $this->Flash->warning('Term Cycle Cannot Be Added', [
                    'key' => 'positive',
                    'params' => [],
                ]);
            }

            return $this->redirect(['action' => 'termCycle']);
        }
        $term = TableRegistry::getTableLocator()->get('scms_term');
        $terms = $term->find()->toArray();
        $this->set('terms', $terms);

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'department_name' => 'd.department_name',
            ])
            ->join([
                'd' => [
                    'table' => 'scms_departments',
                    'type' => 'LEFT',
                    'conditions' => ['d.department_id  = scms_levels.department_id'],
                ],
            ])->toArray();
        $this->set('levels', $levels);
    }

    public function coursesCycle() {
        $where = null;
        $request_data['department_id'] = null;
        $request_data['level_id'] = null;
        $request_data['session_id'] = null;

        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if ($request_data['department_id']) {
                $where['d.department_id'] = $request_data['department_id'];
            }
            if ($request_data['level_id']) {
                $where['l.level_id'] = $request_data['level_id'];
            }
            if ($request_data['session_id']) {
                $where['s.session_id'] = $request_data['session_id'];
            }
        }
        $data = TableRegistry::getTableLocator()->get('scms_courses_cycle');
        $result = $data
                ->find()
                ->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'level_name' => 'l.level_name',
                    'session_name' => 's.session_name',
                    'department_name' => 'd.department_name',
                    'course_name' => 'c.course_name',
                    'course_code' => 'c.course_code',
                    'course_type' => 'ct.course_type_name',
                    'group_name' => 'g.group_name'
                ])
                ->join([
                    'c' => [
                        'table' => 'scms_courses',
                        'type' => 'LEFT',
                        'conditions' => ['c.course_id  = scms_courses_cycle.course_id'],
                    ],
                ])
                ->join([
                    'l' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['l.level_id  = scms_courses_cycle.level_id'],
                    ],
                ])
                ->join([
                    's' => [
                        'table' => 'scms_sessions',
                        'type' => 'LEFT',
                        'conditions' => ['s.session_id  = scms_courses_cycle.session_id'],
                    ],
                ])
                ->join([
                    'd' => [
                        'table' => 'scms_departments',
                        'type' => 'LEFT',
                        'conditions' => ['d.department_id  = l.department_id'],
                    ],
                ])
                ->join([
                    'g' => [
                        'table' => 'scms_groups',
                        'type' => 'LEFT',
                        'conditions' => ['c.course_group_id  = g.group_id'],
                    ],
                ])
                ->join([
            'ct' => [
                'table' => 'scms_course_type',
                'type' => 'LEFT',
                'conditions' => ['ct.course_type_id  = c.course_type_id'],
            ],
        ]);

        $paginate = $this->paginate($result, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();

        $this->set('results', $paginate);

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $department = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $department->find()->toArray();
        $this->set('departments', $departments);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
                ->find()
                ->enableAutoFields(true)
                ->toArray();
        $this->set('levels', $levels);
        $this->set('request_data', $request_data);
    }

    public function addActivityCycle() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $activity_ids = $request_data['activity_id'];
            $count = count($activity_ids);
            $scms_activity_cycle = TableRegistry::getTableLocator()->get('scms_activity_cycle');
            foreach ($activity_ids as $activity_id) {
                $request_data['activity_id'] = $activity_id;
                $courses_cycle = $scms_activity_cycle
                        ->find()
                        ->where(['activity_id' => $request_data['activity_id']])
                        ->where(['level_id' => $request_data['level_id']])
                        ->where(['session_id' => $request_data['session_id']])
                        ->toArray();
                if (count($courses_cycle) == 0) {
                    $query = $scms_activity_cycle->query();
                    $query->insert(['activity_id', 'level_id', 'session_id'])
                            ->values($request_data)
                            ->execute();
                }
            }
//Set Flash
            $this->Flash->success($count . ' Activity Cycle(s) Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'activityCycle']);
        }
        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $department = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $department->find()->toArray();
        $this->set('departments', $departments);

        $scms_activity = TableRegistry::getTableLocator()->get('scms_activity');
        $activity = $scms_activity->find()->where(['deleted' => 0])->toArray();

        $this->set('activity', $activity);
    }

    public function addCoursesCycle() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $course_ids = $request_data['course_id'];
            $count = count($course_ids);
            $scms_courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
            foreach ($course_ids as $course_id) {
                $request_data['course_id'] = $course_id;
                $courses_cycle = $scms_courses_cycle
                        ->find()
                        ->where(['course_id' => $request_data['course_id']])
                        ->where(['level_id' => $request_data['level_id']])
                        ->where(['session_id' => $request_data['session_id']])
                        ->toArray();
                if (count($courses_cycle) == 0) {
                    $query = $scms_courses_cycle->query();
                    $query->insert(['course_id', 'level_id', 'session_id'])
                            ->values($request_data)
                            ->execute();
                    $myrecords = $scms_courses_cycle->find()->last(); //get the last id

                    $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
                    $student_cycles = $scms_student_cycle
                            ->find()
                            ->where(['level_id' => $request_data['level_id']])
                            ->where(['session_id' => $request_data['session_id']])
                            ->toArray();

                    $scms_student_course_cycle_data = array();
                    foreach ($student_cycles as $student_cycle) {
                        $scms_student_course_cycle_data_single['student_cycle_id'] = $student_cycle['student_cycle_id'];
                        $scms_student_course_cycle_data_single['courses_cycle_id'] = $myrecords->courses_cycle_id;
                        $scms_student_course_cycle_data[] = $scms_student_course_cycle_data_single;
                    }
                    if (count($scms_student_course_cycle_data) > 0) {
                        $columns = array_keys($scms_student_course_cycle_data[0]);
                        $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
                        $insertQuery = $scms_student_course_cycle->query();
                        $insertQuery->insert($columns);
// you must always alter the values clause AFTER insert
                        $insertQuery->clause('values')->values($scms_student_course_cycle_data);
                        $insertQuery->execute();
                    }
                }
            }
//Set Flash
            $this->Flash->success($count . ' Course Cycle(s) Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'coursesCycle']);
        }
        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $department = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $department->find()->toArray();
        $this->set('departments', $departments);

        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $courses = $course
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'course_type' => 'ct.course_type_name'
                ])
                ->join([
                    'ct' => [
                        'table' => 'scms_course_type',
                        'type' => 'LEFT',
                        'conditions' => ['ct.course_type_id  = scms_courses.course_type_id'],
                    ],
                ])
                ->toArray();
        $this->set('courses', $courses);
    }

    public function editCoursesCycle() {

    }

    public function termCoursesList() {
        $where = null;
        $request_data['department_id'] = null;
        $request_data['level_id'] = null;
        $request_data['course_id'] = null;
        $request_data['session_id'] = null;
        $request_data['term_id'] = null;

        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if ($request_data['department_id']) {
                $where['d.department_id'] = $request_data['department_id'];
            }
            if ($request_data['level_id']) {
                $where['cc.level_id'] = $request_data['level_id'];
            }
            if ($request_data['course_id']) {
                $where['c.course_id'] = $request_data['course_id'];
            }
            if ($request_data['session_id']) {
                $where['s.session_id'] = $request_data['session_id'];
            }
            if ($request_data['term_id']) {
                $where['t.term_id'] = $request_data['term_id'];
            }
        }

        $term_course_cycle_part_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
        $term_course_cycle_part_types = $term_course_cycle_part_type
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        $this->set('term_course_cycle_part_types', $term_course_cycle_part_types);
        foreach ($term_course_cycle_part_types as $key => $term_course_cycle_part_type) {
            $term_course_cycle_part_type['mark'] = 0;
            $term_course_cycle_part_type['pass_mark'] = 0;
//multi-dimension array indexing
            $merks[$term_course_cycle_part_type['term_course_cycle_part_type_id']] = $term_course_cycle_part_type;
        }

        $results = $this->get_term_course_cycle($where);

        $course_cycle = array();
        $term_course_cycle_ids = array();
        foreach ($results as $key2 => $result) {
            $result['mark_distrubation'] = $merks;
            $term_course_cycle_ids[] = $result['term_course_cycle_id'];
//multi-dimension array indexing
            $course_cycle[$result['term_course_cycle_id']] = $result;
        }

        if (count($term_course_cycle_ids) > 0) {
            $term_course_cycle_part = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part');
            $term_course_cycle_parts = $term_course_cycle_part
                    ->find()
                    ->where(['term_course_cycle_id IN' => $term_course_cycle_ids])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();

            foreach ($term_course_cycle_parts as $term_course_cycle_part) {
                if (isset($course_cycle[$term_course_cycle_part['term_course_cycle_id']])) {
//complex oparation for reduce time complexity. NB: Work Carefully
//multi-dimension array indexing
                    $course_cycle[$term_course_cycle_part['term_course_cycle_id']]['mark_distrubation'][$term_course_cycle_part['term_course_cycle_part_type_id']]['mark'] = $term_course_cycle_part['mark'];
                    $course_cycle[$term_course_cycle_part['term_course_cycle_id']]['mark_distrubation'][$term_course_cycle_part['term_course_cycle_part_type_id']]['pass_mark'] = $term_course_cycle_part['pass_mark'];
                }
            }
        }

        $this->set('results', $course_cycle);

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $department = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $department->find()->toArray();
        $this->set('departments', $departments);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
                ->find()
                ->enableAutoFields(true)
                ->toArray();
        $this->set('levels', $levels);

        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $courses = $course
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        $this->set('courses', $courses);

        $term = TableRegistry::getTableLocator()->get('scms_term');
        $terms = $term
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

        $this->set('terms', $terms);

        $this->set('request_data', $request_data);
    }

    public function marksDistribution() {

        $data = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
        $get_marks_type_table = $data
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false);

        $paginate = $this->paginate($get_marks_type_table, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('marks_types', $paginate);
    }

    public function addMarksDistribution() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_marks_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
            $get_marks_type_tascms_term_course_cycle_part_types = $get_marks_type->find()
                    ->where(['term_course_cycle_part_type_id !=' => 9999])
                    ->toArray();
            if (!empty($get_marks_type_tascms_term_course_cycle_part_types)) {
                $request_data['term_course_cycle_part_type_id'] = 0;
                foreach ($get_marks_type_tascms_term_course_cycle_part_types as $get_marks_type_tascms_term_course_cycle_part_type) {
                    if ($request_data['term_course_cycle_part_type_id'] < $get_marks_type_tascms_term_course_cycle_part_type->term_course_cycle_part_type_id) {
                        $request_data['term_course_cycle_part_type_id'] = $get_marks_type_tascms_term_course_cycle_part_type->term_course_cycle_part_type_id;
                    }
                }
                $request_data['term_course_cycle_part_type_id']++;
                $query = $get_marks_type->query();
                $query
                        ->insert(['term_course_cycle_part_type_id', 'term_course_cycle_part_type_name', 'partable', 'short_form'])
                        ->values($request_data)
                        ->execute();
            } else {
                $query = $get_marks_type->query();
                $query
                        ->insert(['term_course_cycle_part_type_name', 'partable', 'short_form'])
                        ->values($request_data)
                        ->execute();
            }
//Set Flash
            $this->Flash->success('Marks Distribution Type Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'marksDistribution']);
        }
    }

    public function editMarksDistribution($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $get_marks_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
            $query = $get_marks_type->query();
            $query
                    ->update()
                    ->set($this->request->getData())
                    ->where(['term_course_cycle_part_type_id' => $data['term_course_cycle_part_type_id']])
                    ->execute();

//Set Flash
            $this->Flash->info('Marks Distribution Type Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'marksDistribution']);
        }
        $get_marks_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type'); //Execute First
        $get_marks_types = $get_marks_type
                ->find()
                ->where(['term_course_cycle_part_type_id' => $id])
                ->toArray();
        $this->set('marks_types', $get_marks_types);
    }

    public function editTermCourse($id) {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $term_course_cycle_part = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part');
            $store['term_course_cycle_id'] = $request_data['term_course_cycle_id'];
            foreach ($request_data['mark'] as $key => $data) {
                $store['mark'] = $request_data['mark'][$key];
                $store['pass_mark'] = $request_data['pass_mark'][$key];
                $store['term_course_cycle_part_type_id'] = $key;
                $query = $term_course_cycle_part->query();
                $query
                        ->update()
                        ->set($store)
                        ->where(['term_course_cycle_part_id' => $request_data['term_course_cycle_part_id'][$key]])
                        ->execute();
            }
//Set Flash
            $this->Flash->success('Mark Distribution Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
        }

        $term_course_cycle_part_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
        $term_course_cycle_part_types = $term_course_cycle_part_type
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        $term_course_cycle_part = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part');
        foreach ($term_course_cycle_part_types as $term_course_cycle_part_type) {
            $term_course_cycle_parts = $term_course_cycle_part
                    ->find()
                    ->where(['term_course_cycle_id' => $id])
                    ->where(['term_course_cycle_part_type_id' => $term_course_cycle_part_type['term_course_cycle_part_type_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
            if (empty($term_course_cycle_parts)) {
//early inset but empty value
                $term_course_cycle_part_data['mark'] = 0;
                $term_course_cycle_part_data['pass_mark'] = 0;
                $term_course_cycle_part_data['term_course_cycle_id'] = $id;
                $term_course_cycle_part_data['term_course_cycle_part_type_id'] = $term_course_cycle_part_type['term_course_cycle_part_type_id'];
                $query = $term_course_cycle_part->query();
                $query
                        ->insert(['term_course_cycle_id', 'mark', 'pass_mark', 'term_course_cycle_part_type_id'])
                        ->values($term_course_cycle_part_data)
                        ->execute();
            }
        }

        $merks_distrubution = $term_course_cycle_part
                ->find()
                ->where(['term_course_cycle_id' => $id])
                ->select([
                    'term_course_cycle_part_type_name' => 'cp.term_course_cycle_part_type_name',
                    'partable' => 'cp.partable',
                ])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->join([
                    'cp' => [
                        'table' => 'scms_term_course_cycle_part_type',
                        'type' => 'LEFT',
                        'conditions' => ['scms_term_course_cycle_part.term_course_cycle_part_type_id  = cp.term_course_cycle_part_type_id'],
                    ],
                ])
                ->toArray();
        $quiz = TableRegistry::getTableLocator()->get('scms_quiz');
        foreach ($merks_distrubution as $key => $merks) {
            $merks_distrubution[$key]['quiz'] = array();
            if ($merks['partable'] == "Yes") {
                $quizs = $quiz
                        ->find()
                        ->where(['term_course_cycle_part_id' => $merks['term_course_cycle_part_id']])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->toArray();
                $merks_distrubution[$key]['quiz'] = $quizs;
                $quizs = array();
            }
        }
        $this->set('merks_distrubutions', $merks_distrubution);

        $term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
        $results = $term_course_cycle
                ->find()
                ->where(['term_course_cycle_id ' => $id])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'session_name' => 's.session_name',
                    'term_name' => 't.term_name',
                    'level_name' => 'l.level_name',
                    'department_name' => 'd.department_name',
                    'course_name' => 'c.course_name',
                    'course_code' => 'c.course_code',
                ])
                ->join([
                    'tc' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['tc.term_cycle_id  = scms_term_course_cycle.term_cycle_id'],
                    ],
                ])
                ->join([
                    't' => [
                        'table' => 'scms_term',
                        'type' => 'LEFT',
                        'conditions' => ['tc.term_id  = t.term_id'],
                    ],
                ])
                ->join([
                    'cc' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['cc.courses_cycle_id  = scms_term_course_cycle.courses_cycle_id'],
                    ],
                ])
                ->join([
                    's' => [
                        'table' => 'scms_sessions',
                        'type' => 'LEFT',
                        'conditions' => ['s.session_id  = cc.session_id'],
                    ],
                ])
                ->join([
                    'l' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['l.level_id  = cc.level_id'],
                    ],
                ])
                ->join([
                    'c' => [
                        'table' => 'scms_courses',
                        'type' => 'LEFT',
                        'conditions' => ['c.course_id  = cc.course_id'],
                    ],
                ])
                ->join([
                    'd' => [
                        'table' => 'scms_departments',
                        'type' => 'LEFT',
                        'conditions' => ['d.department_id  = c.department_id'],
                    ],
                ])
                ->toArray();
        $this->set('result', $results[0]);
    }

    public function editQuiz($id = false) {
        $quiz = TableRegistry::getTableLocator()->get('scms_quiz');
        $quizs = $quiz
                ->find()
                ->where(['term_course_cycle_part_id' => $id])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

        $term_course_cycle_part = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part');
        $term_course_cycle_parts = $term_course_cycle_part
                ->find()
                ->where(['term_course_cycle_part_id' => $id])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term_course_cycle_part_type_name' => 'tp.term_course_cycle_part_type_name',
                    'term_name' => 't.term_name',
                    'level_name' => 'l.level_name',
                    'department_name' => 'd.department_name',
                    'course_name' => 'c.course_name',
                    'course_code' => 'c.course_code',
                ])
                ->join([
                    'tp' => [
                        'table' => 'scms_term_course_cycle_part_type',
                        'type' => 'LEFT',
                        'conditions' => ['tp.term_course_cycle_part_type_id = scms_term_course_cycle_part.term_course_cycle_part_type_id'],
                    ],
                ])
                ->join([
                    'tcc' => [
                        'table' => 'scms_term_course_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['tcc.term_course_cycle_id = scms_term_course_cycle_part.term_course_cycle_id'],
                    ],
                ])
                ->join([
                    'tc' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['tc.term_cycle_id  = tcc.term_cycle_id'],
                    ],
                ])
                ->join([
                    't' => [
                        'table' => 'scms_term',
                        'type' => 'LEFT',
                        'conditions' => ['tc.term_id  = t.term_id'],
                    ],
                ])
                ->join([
                    'cc' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['cc.courses_cycle_id  = tcc.courses_cycle_id'],
                    ],
                ])
                ->join([
                    's' => [
                        'table' => 'scms_sessions',
                        'type' => 'LEFT',
                        'conditions' => ['s.session_id  = cc.session_id'],
                    ],
                ])
                ->join([
                    'l' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['l.level_id  = cc.level_id'],
                    ],
                ])
                ->join([
                    'c' => [
                        'table' => 'scms_courses',
                        'type' => 'LEFT',
                        'conditions' => ['c.course_id  = cc.course_id'],
                    ],
                ])
                ->join([
                    'd' => [
                        'table' => 'scms_departments',
                        'type' => 'LEFT',
                        'conditions' => ['d.department_id  = c.department_id'],
                    ],
                ])
                ->toArray();
        $head = __d('setup', 'Quiz(s) of ') . $term_course_cycle_parts[0]['course_name'] . '(' . $term_course_cycle_parts[0]['course_code'] . '),' . __d('setup', '  Term : ') . $term_course_cycle_parts[0]['term_name'] . ',' . __d('setup', '  Level : ') . $term_course_cycle_parts[0]['level_name'];
        $this->set('head', $head);
        $this->set('quizs', $quizs);

        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $ids = array();
            foreach ($quizs as $quiz) {
                $ids[] = $quiz['scms_quiz_id'];
            }
            $new_ids = array();
            if (isset($request_data['quiz_name'])) {
                foreach ($request_data['quiz_name'] as $key => $scms_quiz_id) {
                    $new_ids[] = $key;
                    $quiz_data['quiz_name'] = $request_data['quiz_name'][$key];
                    $quiz_data['marks'] = $request_data['marks'][$key];
                    $quiz = TableRegistry::getTableLocator()->get('scms_quiz');
                    $query = $quiz->query();
                    $query
                            ->update()
                            ->set($quiz_data)
                            ->where(['scms_quiz_id' => $key])
                            ->execute();
                }
            }
            $delete_ids = array_diff($ids, $new_ids);
            foreach ($delete_ids as $delete_id) {
                $quiz = TableRegistry::getTableLocator()->get('scms_quiz');
                $query = $quiz->query();
                $query->delete()
                        ->where(['scms_quiz_id' => $delete_id])
                        ->execute();
            }

            if (isset($request_data['new_name'])) {
                foreach ($request_data['new_name'] as $key => $name) {
                    $quiz_data['quiz_name'] = $name;
                    $quiz_data['marks'] = $request_data['new_marks'][$key];
                    $quiz_data['term_course_cycle_part_id'] = $id;
                    $query = $quiz->query();
                    $query
                            ->insert(['quiz_name', 'marks', 'term_course_cycle_part_id'])
                            ->values($quiz_data)
                            ->execute();
                }
            }
            $quiz = TableRegistry::getTableLocator()->get('scms_quiz');
            $quizs = $quiz
                    ->find()
                    ->where(['term_course_cycle_part_id' => $id])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
            $this->set('quizs', $quizs);
//Set Flash
            $this->Flash->success('Quiz(s) Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
        }
    }

    private function get_student_course_cycle($course_cycle_ids, $student_cycle_id) {
        $student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
        $student_course_cycles = $student_course_cycle
                ->find()
                ->where(['student_cycle_id' => $student_cycle_id])
                ->where(['courses_cycle_id  in' => $course_cycle_ids])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

        foreach ($student_course_cycles as $student_course_cycle) {
            $student_course_cycle_id[] = $student_course_cycle['student_course_cycle_id'];
        }
        return $student_course_cycle_id;
    }
    
    #added by @shovon
    private function get_student_religion($student_cycle_id)
    {
        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $student = $scms_student_cycle
            ->find()
            ->where(['student_cycle_id' => $student_cycle_id])
            ->select([
                'name' => 'scms_students.name',
                'religion_subject' => 'scms_students.religion_subject',
            ])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => ['scms_students.student_id  = scms_student_cycle.student_id'],
                ]
            ])
            ->toArray();
        $student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
        $student_course_cycles = $student_course_cycle
            ->find()
            ->where(['student_cycle_id' => $student_cycle_id])
            ->where(['c.course_id' => $student[0]['religion_subject']])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'cc' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['cc.courses_cycle_id  = scms_student_course_cycle.courses_cycle_id'],
                ],
                'c' => [
                    'table' => 'scms_courses',
                    'type' => 'LEFT',
                    'conditions' => ['c.course_id  = cc.course_id'],
                ]
            ])
            ->toArray();
        return $student_course_cycles;
    }

    #added by @shovon
    private function get_student_course_cycle_with_group($course_cycle_ids, $student_cycle_id, $group)
    {

        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');

        $cycles = $scms_student_cycle
            ->find()
            ->where(['student_cycle_id' => $student_cycle_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        $level_id = $cycles[0]['level_id'];
        $session_id = $cycles[0]['session_id'];

        $religion = $this->get_student_religion($student_cycle_id);
        // pr($religion);
        // die;
        $student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');

        $student_course_cycles = $student_course_cycle
            ->find()
            ->where(['student_cycle_id' => $student_cycle_id])
            ->where(['c.course_type_id IN' => [1, 2]])
            ->where(['scms_student_course_cycle.courses_cycle_id  in' => $course_cycle_ids])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'cc' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['cc.courses_cycle_id  = scms_student_course_cycle.courses_cycle_id'],
                ],
                'c' => [
                    'table' => 'scms_courses',
                    'type' => 'LEFT',
                    'conditions' => ['c.course_id  = cc.course_id'],
                ]
            ])
            ->toArray();

        $student_course_cycles_group = $student_course_cycle
            ->find()
            ->where(['student_cycle_id' => $student_cycle_id])
            ->where(['c.course_group_id' => $group])
            ->where(['c.course_type_id IN' => [4]])
            ->where(['scms_student_course_cycle.courses_cycle_id  in' => $course_cycle_ids])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'cc' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['cc.courses_cycle_id  = scms_student_course_cycle.courses_cycle_id'],
                ],
                'c' => [
                    'table' => 'scms_courses',
                    'type' => 'LEFT',
                    'conditions' => ['c.course_id  = cc.course_id'],
                ],

            ])
            ->toArray();

        $scms_third_and_forth_subject = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
        $student_course_cycles_third_forth = $scms_third_and_forth_subject
            ->find()
            ->where(['scms_third_and_forth_subject.student_cycle_id' => $student_cycle_id])
            ->where(['scms_courses_cycle.level_id' => $level_id])
            ->where(['scms_courses_cycle.session_id' => $session_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'courses_cycle_id' => 'scms_courses_cycle.courses_cycle_id',
                // 'student_course_cycle_id' => 'scms_student_course_cycle.student_course_cycle_id',
            ])
            ->join([
                'scms_student_cycle' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_student_cycle.student_cycle_id  = scms_third_and_forth_subject.student_cycle_id'],
                ],
                'scms_courses_cycle' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_courses_cycle.course_id  = scms_third_and_forth_subject.course_id'],
                ],
                // 'scms_student_course_cycle' => [
                //     'table' => 'scms_student_course_cycle',
                //     'type' => 'LEFT',
                //     'conditions' => ['scms_student_course_cycle.courses_cycle_id  = scms_courses_cycle.courses_cycle_id'],
                // ],
            ])
            ->toArray();


        $merged_assoc = [];


        foreach ($religion as $item) {
            if (!isset($merged_assoc[$item['courses_cycle_id']])) {
                $merged_assoc[$item['courses_cycle_id']] = $item;
            }
        }
        foreach ($student_course_cycles as $item) {
            $merged_assoc[$item['courses_cycle_id']] = $item;
        }


        foreach ($student_course_cycles_group as $item) {
            if (!isset($merged_assoc[$item['courses_cycle_id']])) {
                $merged_assoc[$item['courses_cycle_id']] = $item;
            }
        }


        $studentCourseCycleTable = TableRegistry::getTableLocator()->get('scms_student_course_cycle');


        $studentCourseCycleData = [];

        foreach ($student_course_cycles_third_forth as $item) {
            $record = $studentCourseCycleTable->find()
                ->where([
                    'courses_cycle_id' => $item['courses_cycle_id'],
                    'student_cycle_id' => $item['student_cycle_id']
                ])
                ->first();

            if ($record) {
                $studentCourseCycleData[] = [
                    'student_course_cycle_id' => $record->student_course_cycle_id,
                    'student_cycle_id' => $record->student_cycle_id,
                    'courses_cycle_id' => $record->courses_cycle_id,
                ];
            }
        }

        foreach ($studentCourseCycleData as $item) {
            if (!isset($merged_assoc[$item['courses_cycle_id']])) {
                $merged_assoc[$item['courses_cycle_id']] = $item;
            }
        }



        $merged = array_values($merged_assoc);




        foreach ($merged as $student_course_cycle) {
            $student_course_cycle_id[] = $student_course_cycle['student_course_cycle_id'];
        }

        return $student_course_cycle_id;
    }

    public function detailsTermCycle($id) {
        $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $result = $scms_term_cycle
                        ->find()
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'term_name' => 't.term_name',
                            'level_name' => 'l.level_name',
                            'session_name' => 's.session_name',
                            'department_name' => 'd.department_name',
                        ])
                        ->where(['term_cycle_id' => $id])
                        ->join([
                            't' => [
                                'table' => 'scms_term',
                                'type' => 'LEFT',
                                'conditions' => ['t.term_id  = scms_term_cycle.term_id'],
                            ],
                            'l' => [
                                'table' => 'scms_levels',
                                'type' => 'LEFT',
                                'conditions' => ['l.level_id  = scms_term_cycle.level_id'],
                            ],
                            's' => [
                                'table' => 'scms_sessions',
                                'type' => 'LEFT',
                                'conditions' => ['s.session_id  = scms_term_cycle.session_id'],
                            ],
                            'd' => [
                                'table' => 'scms_departments',
                                'type' => 'LEFT',
                                'conditions' => ['d.department_id  = l.department_id'],
                            ],
                        ])->toArray();
        $this->set('head', $result[0]);

        $where['scms_term_course_cycle.term_cycle_id'] = $id;
        $term_course_cycle_list = $this->get_term_course_cycle($where);
        unset($where);
        $this->set('term_course_cycle_lists', $term_course_cycle_list);
        $where['scms_term_activity_cycle.term_cycle_id'] = $id;
        $term_activity_cycle_list = $this->get_term_activity_cycle($where);
        $this->set('term_activity_cycle_list', $term_activity_cycle_list);
    }

    private function get_term_activity_cycle($where) {
        $scms_term_activity_cycle = TableRegistry::getTableLocator()->get('scms_term_activity_cycle');
        $term_activity_cycle = $scms_term_activity_cycle
                ->find()
                ->where($where)
                ->where(['a.deleted' => 0])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'session_name' => 's.session_name',
                    'term_name' => 't.term_name',
                    'level_name' => 'l.level_name',
                    'activity_name' => 'a.name',
                    'multiple' => 'a.multiple',
                ])
                ->join([
                    'tc' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['tc.term_cycle_id  = scms_term_activity_cycle.term_cycle_id'],
                    ],
                    't' => [
                        'table' => 'scms_term',
                        'type' => 'LEFT',
                        'conditions' => ['tc.term_id  = t.term_id'],
                    ],
                    'ac' => [
                        'table' => 'scms_activity_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['ac.activity_cycle_id  = scms_term_activity_cycle.activity_cycle_id'],
                    ],
                    's' => [
                        'table' => 'scms_sessions',
                        'type' => 'LEFT',
                        'conditions' => ['s.session_id  = ac.session_id'],
                    ],
                    'l' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['l.level_id  = ac.level_id'],
                    ],
                    'a' => [
                        'table' => 'scms_activity',
                        'type' => 'LEFT',
                        'conditions' => ['a.activity_id  = ac.activity_id'],
                    ],
                ])
                ->toArray();
        return $term_activity_cycle;
    }

    private function get_term_course_cycle($where) {
        $term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
        $results = $term_course_cycle
                ->find()
                ->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'session_name' => 's.session_name',
                    'term_name' => 't.term_name',
                    'level_name' => 'l.level_name',
                    'department_name' => 'd.department_name',
                    'course_name' => 'c.course_name',
                    'course_code' => 'c.course_code',
                    'course_id' => 'c.course_id',
                ])
                ->join([
                    'tc' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['tc.term_cycle_id  = scms_term_course_cycle.term_cycle_id'],
                    ],
                    't' => [
                        'table' => 'scms_term',
                        'type' => 'LEFT',
                        'conditions' => ['tc.term_id  = t.term_id'],
                    ],
                    'cc' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['cc.courses_cycle_id  = scms_term_course_cycle.courses_cycle_id'],
                    ],
                    's' => [
                        'table' => 'scms_sessions',
                        'type' => 'LEFT',
                        'conditions' => ['s.session_id  = cc.session_id'],
                    ],
                    'l' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['l.level_id  = cc.level_id'],
                    ],
                    'c' => [
                        'table' => 'scms_courses',
                        'type' => 'LEFT',
                        'conditions' => ['c.course_id  = cc.course_id'],
                    ],
                    'd' => [
                        'table' => 'scms_departments',
                        'type' => 'LEFT',
                        'conditions' => ['d.department_id  = c.department_id'],
                    ],
                ])
                ->toArray();
        return $results;
    }

    public function termCycleAddCourse($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            if (!isset($data['courses_cycle_id']) && !isset($data['activity_cycle_id'])) {
                $this->Flash->success('No Course or Activity to Add', [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'detailsTermCycle', $id]);
            }

            if (isset($data['courses_cycle_id'])) {
                $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
                $scms_student_term_cycle_data = $scms_student_term_cycle
                        ->find()
                        ->where(['scms_student_term_cycle.term_cycle_id' => $data['term_cycle_id']])
                        ->where(['scms_student_cycle.level_id' => $data['level_id']])
                        ->where(['scms_student_cycle.session_id' => $data['session_id']])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select(['group_id' => 'scms_student_cycle.group_id'])
                        ->join([
                            'scms_student_cycle' => [
                                'table' => 'scms_student_cycle',
                                'type' => 'INNER',
                                'conditions' => ['scms_student_cycle.student_cycle_id  = scms_student_term_cycle.student_cycle_id'],
                            ],
                        ])
                        ->toArray();

                $filter_scms_student_term_cycle_data = array();

                foreach ($scms_student_term_cycle_data as $scms_student_term_cycle_data_single) {
                    $filter_scms_student_term_cycle_data[$scms_student_term_cycle_data_single['student_cycle_id']] = $scms_student_term_cycle_data_single;
                }
                $scms_student_term_course_cycle_data = array();
                foreach ($data['courses_cycle_id'] as $courses_cycle_id) {
                    $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
                    $scms_student_course_cycle_data = $scms_student_course_cycle
                            ->find()
                            ->where(['scms_student_course_cycle.courses_cycle_id' => $courses_cycle_id])
                            ->where(['scms_student_cycle.level_id' => $data['level_id']])
                            ->where(['scms_student_cycle.session_id' => $data['session_id']])
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->join([
                                'scms_student_cycle' => [
                                    'table' => 'scms_student_cycle',
                                    'type' => 'INNER',
                                    'conditions' => ['scms_student_cycle.student_cycle_id  = scms_student_course_cycle.student_cycle_id'],
                                ],
                            ])
                            ->toArray();

                    $scms_courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
                    $scms_courses = $scms_courses_cycle
                            ->find()
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->select(['group_id' => 'scms_courses.course_group_id'])
                            ->where(['courses_cycle_id' => $courses_cycle_id])
                            ->join([
                                'scms_courses' => [
                                    'table' => 'scms_courses',
                                    'type' => 'INNER',
                                    'conditions' => ['scms_courses_cycle.course_id  = scms_courses.course_id'],
                                ],
                            ])
                            ->toArray();

                    foreach ($scms_student_course_cycle_data as $scms_student_course_cycle_data_single) {
                        $scms_student_course_cycle_data_single['student_term_cycle_id'] = $filter_scms_student_term_cycle_data[$scms_student_course_cycle_data_single['student_cycle_id']]['student_term_cycle_id'];
                        if ($scms_courses[0]['group_id']) {
                            if ($scms_courses[0]['group_id'] == $filter_scms_student_term_cycle_data[$scms_student_course_cycle_data_single['student_cycle_id']]['group_id']) {
                                unset($scms_student_course_cycle_data_single['student_cycle_id']);
                                unset($scms_student_course_cycle_data_single['courses_cycle_id']);
                                $scms_student_term_course_cycle_data[] = $scms_student_course_cycle_data_single;
                            }
                        } else {
                            unset($scms_student_course_cycle_data_single['student_cycle_id']);
                            unset($scms_student_course_cycle_data_single['courses_cycle_id']);
                            $scms_student_term_course_cycle_data[] = $scms_student_course_cycle_data_single;
                        }
                    }


                    //insert to scms_term_course_cycle
                    $term_course_cycle_data['courses_cycle_id'] = $courses_cycle_id;
                    $term_course_cycle_data['term_cycle_id'] = $data['term_cycle_id'];
                    $term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
                    $query = $term_course_cycle->query();
                    $query
                            ->insert(['courses_cycle_id', 'term_cycle_id'])
                            ->values($term_course_cycle_data)
                            ->execute();
                }


//insert to scms_student_term_course_cycle
                if (count($scms_student_term_course_cycle_data) > 0) {
                    $columns = array_keys($scms_student_term_course_cycle_data[0]);
                    $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
                    $insertQuery = $scms_student_term_course_cycle->query();
                    $insertQuery->insert($columns);
// you must always alter the values clause AFTER insert
                    $insertQuery->clause('values')->values($scms_student_term_course_cycle_data);
                    $insertQuery->execute();
                }

                $this->Flash->success('Course Added Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
            }


            if (isset($data['activity_cycle_id'])) {
                $scms_term_activity_cycle_data_single['term_cycle_id'] = $data['term_cycle_id'];
                $scms_term_activity_cycle_data = array();
                foreach ($data['activity_cycle_id'] as $activity_cycle_id) {
                    $scms_term_activity_cycle_data_single['activity_cycle_id'] = $activity_cycle_id;
                    $scms_term_activity_cycle_data[] = $scms_term_activity_cycle_data_single;
                }
                $columns = array_keys($scms_term_activity_cycle_data[0]);
                $scms_term_activity_cycle = TableRegistry::getTableLocator()->get('scms_term_activity_cycle');
                $insertQuery = $scms_term_activity_cycle->query();
                $insertQuery->insert($columns);
// you must always alter the values clause AFTER insert
                $insertQuery->clause('values')->values($scms_term_activity_cycle_data);
                $insertQuery->execute();
                $this->Flash->success('Activity Added Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
            }
            return $this->redirect(['action' => 'detailsTermCycle', $data['term_cycle_id']]);
        }

        $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $result = $scms_term_cycle
                        ->find()
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'term_name' => 't.term_name',
                            'level_name' => 'l.level_name',
                            'session_name' => 's.session_name',
                            'department_name' => 'd.department_name',
                            'department_id' => 'd.department_id',
                        ])
                        ->where(['term_cycle_id' => $id])
                        ->join([
                            't' => [
                                'table' => 'scms_term',
                                'type' => 'LEFT',
                                'conditions' => ['t.term_id  = scms_term_cycle.term_id'],
                            ],
                            'l' => [
                                'table' => 'scms_levels',
                                'type' => 'LEFT',
                                'conditions' => ['l.level_id  = scms_term_cycle.level_id'],
                            ],
                            's' => [
                                'table' => 'scms_sessions',
                                'type' => 'LEFT',
                                'conditions' => ['s.session_id  = scms_term_cycle.session_id'],
                            ],
                            'd' => [
                                'table' => 'scms_departments',
                                'type' => 'LEFT',
                                'conditions' => ['d.department_id  = l.department_id'],
                            ],
                        ])->toArray();

        $scms_courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
        $courses_cycles = $scms_courses_cycle
                        ->find()
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->where(['level_id' => $result[0]['level_id']])
                        ->where(['session_id' => $result[0]['session_id']])
                        ->select([
                            'course_type' => 'scms_course_type.course_type_name',
                            'course_name' => 'scms_courses.course_name',
                            'course_code' => 'scms_courses.course_code',
                        ])
                        ->join([
                            'scms_courses' => [
                                'table' => 'scms_courses',
                                'type' => 'LEFT',
                                'conditions' => ['scms_courses.course_id  = scms_courses_cycle.course_id'],
                            ],
                            'scms_course_type' => [
                                'table' => 'scms_course_type',
                                'type' => 'LEFT',
                                'conditions' => ['scms_course_type.course_type_id  = scms_courses.course_type_id'],
                            ],
                        ])->toArray();

        $index_courses_cycle = array();
        if (count($courses_cycles) > 0) {
            foreach ($courses_cycles as $courses_cycle) {
                $index_courses_cycle[$courses_cycle['courses_cycle_id']] = $courses_cycle;
            }
            $where['scms_term_course_cycle.term_cycle_id'] = $id;
            $term_course_cycle_lists = $this->get_term_course_cycle($where);

            foreach ($term_course_cycle_lists as $term_course_cycle_list) {
                unset($index_courses_cycle[$term_course_cycle_list['courses_cycle_id']]);
            }
        }
        $this->set('courses', $index_courses_cycle);
        $this->set('result', $result[0]);

        unset($where);
        $scms_activity_cycle = TableRegistry::getTableLocator()->get('scms_activity_cycle');
        $activity_cycle = $scms_activity_cycle
                        ->find()
                        ->where(['level_id' => $result[0]['level_id']])
                        ->where(['session_id' => $result[0]['session_id']])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'activity_name' => 'scms_activity.name',
                        ])
                        ->join([
                            'scms_activity' => [
                                'table' => 'scms_activity',
                                'type' => 'LEFT',
                                'conditions' => ['scms_activity.activity_id  = scms_activity_cycle.activity_id'],
                            ],
                        ])->toArray();
        $index_activity = array();
        if (count($activity_cycle) > 0) {
            $where['scms_term_activity_cycle.term_cycle_id'] = $id;
            $term_activity_cycle_list = $this->get_term_activity_cycle($where);

            foreach ($activity_cycle as $activity) {
                $index_activity[$activity['activity_cycle_id']] = $activity;
            }
            foreach ($term_activity_cycle_list as $term_activity_cycle_list_single) {
                unset($index_activity[$term_activity_cycle_list_single['activity_cycle_id']]);
            }
        }

        $this->set('index_activity', $index_activity);
    }

    private function get_course_cycle($session_id) {
        $scms_courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
        $courses_cycles = $scms_courses_cycle
                        ->find()
                        ->where(['scms_courses_cycle.session_id' => $session_id])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'session_name' => 'scms_sessions.session_name',
                        ])
                        ->join([
                            'scms_sessions' => [
                                'table' => 'scms_sessions',
                                'type' => 'LEFT',
                                'conditions' => ['scms_sessions.session_id  = scms_courses_cycle.session_id'],
                            ],
                        ])->toArray();
        return $courses_cycles;
    }

    private function get_activity_cycle($session_id) {
        $scms_activity_cycle = TableRegistry::getTableLocator()->get('scms_activity_cycle');
        $activity_cycles = $scms_activity_cycle
                        ->find()
                        ->where(['scms_activity_cycle.session_id' => $session_id])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'session_name' => 'scms_sessions.session_name',
                        ])
                        ->join([
                            'scms_sessions' => [
                                'table' => 'scms_sessions',
                                'type' => 'LEFT',
                                'conditions' => ['scms_sessions.session_id  = scms_activity_cycle.session_id'],
                            ],
                        ])->toArray();
        return $activity_cycles;
    }

    private function get_term_cycle($session_id) {
        $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $term_cycle = $scms_term_cycle
                        ->find()
                        ->where(['scms_term_cycle.session_id' => $session_id])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'session_name' => 'scms_sessions.session_name',
                        ])
                        ->join([
                            'scms_sessions' => [
                                'table' => 'scms_sessions',
                                'type' => 'LEFT',
                                'conditions' => ['scms_sessions.session_id  = scms_term_cycle.session_id'],
                            ],
                        ])->toArray();
        return $term_cycle;
    }

    public function courseCyclePromotion() {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $new_course_cycle = $this->get_course_cycle($data['session_to']);
            if (count($new_course_cycle)) {
                $message = 'Course cycle promotion unsuccessful. Already, ' . count($new_course_cycle) . ' Course Cycle is exist in ' . $new_course_cycle[0]['session_name'] . ' Session.';
                $this->Flash->success($message, [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'courseCyclePromotion']);
            }
            $old_course_cycle = $this->get_course_cycle($data['session_from']);
            $session = TableRegistry::getTableLocator()->get('scms_sessions'); //Execute First

            if (count($old_course_cycle) == 0) {
                $sessions = $session
                        ->find()
                        ->where(['session_id' => $data['session_from']])
                        ->toArray();
                $message = 'Course cycle promotion unsuccessful.  ' . $sessions[0]->session_name . ' Session has no Course Cycle.';
                $this->Flash->success($message, [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'courseCyclePromotion']);
            }
            $promotion_cycle = array();
            foreach ($old_course_cycle as $old_cycle) {
                $promotion_cycle_single['course_id'] = $old_cycle['course_id'];
                $promotion_cycle_single['level_id'] = $old_cycle['level_id'];
                $promotion_cycle_single['session_id'] = $data['session_to'];
                $promotion_cycle[] = $promotion_cycle_single;
            }
            $scms_courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
            $insertQuery = $scms_courses_cycle->query();
            $columns = array_keys($promotion_cycle[0]);
            $insertQuery->insert($columns);
            $insertQuery->clause('values')->values($promotion_cycle);
            $insertQuery->execute();
            $sessions = $session
                    ->find()
                    ->where(['session_id' => $data['session_to']])
                    ->toArray();
            $message = 'Course cycle promotion successful.  ' . count($promotion_cycle) . ' Course Cycle has been promoted to ' . $sessions[0]->session_name . " session";
            $this->Flash->success($message, [
                'key' => 'Positive',
                'params' => [],
            ]);
        }


        $scms_session = TableRegistry::getTableLocator()->get('scms_sessions');
        $scms_sessions = $scms_session
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->order(['session_name' => 'DESC'])
                ->toArray();
        $this->set('scms_sessions', $scms_sessions);
    }

    public function activityCyclePromotion() {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $new_activity_cycle = $this->get_activity_cycle($data['session_to']);
            if (count($new_activity_cycle)) {
                $message = 'Activity cycle promotion unsuccessful. Already, ' . count($new_activity_cycle) . ' Course Cycle is exist in ' . $new_activity_cycle[0]['session_name'] . ' Session.';
                $this->Flash->success($message, [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'courseCyclePromotion']);
            }
            $old_activity_cycle = $this->get_activity_cycle($data['session_from']);
            $session = TableRegistry::getTableLocator()->get('scms_sessions'); //Execute First

            if (count($old_activity_cycle) == 0) {
                $sessions = $session
                        ->find()
                        ->where(['session_id' => $data['session_from']])
                        ->toArray();
                $message = 'Activity cycle promotion unsuccessful.  ' . $sessions[0]->session_name . ' Session has no Activity Cycle.';
                $this->Flash->success($message, [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'courseCyclePromotion']);
            }
            $promotion_cycle = array();
            foreach ($old_activity_cycle as $old_cycle) {
                $promotion_cycle_single['activity_id'] = $old_cycle['activity_id'];
                $promotion_cycle_single['level_id'] = $old_cycle['level_id'];
                $promotion_cycle_single['session_id'] = $data['session_to'];
                $promotion_cycle[] = $promotion_cycle_single;
            }
            $scms_activity_cycle = TableRegistry::getTableLocator()->get('scms_activity_cycle');
            $insertQuery = $scms_activity_cycle->query();
            $columns = array_keys($promotion_cycle[0]);
            $insertQuery->insert($columns);
            $insertQuery->clause('values')->values($promotion_cycle);
            $insertQuery->execute();

            $sessions = $session
                    ->find()
                    ->where(['session_id' => $data['session_to']])
                    ->toArray();

            $message = 'Activity cycle promotion successful.  ' . count($promotion_cycle) . ' Activity Cycle has been promoted to ' . $sessions[0]->session_name . " session";
            $this->Flash->success($message, [
                'key' => 'Positive',
                'params' => [],
            ]);
        }
        $scms_session = TableRegistry::getTableLocator()->get('scms_sessions');
        $scms_sessions = $scms_session
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->order(['session_name' => 'DESC'])
                ->toArray();
        $this->set('scms_sessions', $scms_sessions);
    }

    private function get_term_activity_cycle_by_term_cycle_ids($term_cycle_id) {
        $scms_term_activity_cycle = TableRegistry::getTableLocator()->get('scms_term_activity_cycle');
        $term_activity_cycle = $scms_term_activity_cycle
                        ->find()
                        ->where(['scms_term_activity_cycle.term_cycle_id IN' => $term_cycle_id])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'activity_id' => 'scms_activity_cycle.activity_id',
                            'level_id' => 'scms_activity_cycle.level_id',
                            'term_id' => 'scms_term_cycle.term_id',
                        ])
                        ->join([
                            'scms_activity_cycle' => [
                                'table' => 'scms_activity_cycle',
                                'type' => 'LEFT',
                                'conditions' => ['scms_term_activity_cycle.activity_cycle_id  = scms_activity_cycle.activity_cycle_id'],
                            ],
                            'scms_term_cycle' => [
                                'table' => 'scms_term_cycle',
                                'type' => 'LEFT',
                                'conditions' => ['scms_term_activity_cycle.term_cycle_id  = scms_term_cycle.term_cycle_id'],
                            ],
                        ])->toArray();
        return $term_activity_cycle;
    }

    private function get_term_course_cycle_by_term_cycle_ids($term_cycle_id) {
        $scms_term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
        $term_course_cycles = $scms_term_course_cycle
                        ->find()
                        ->where(['scms_term_course_cycle.term_cycle_id IN' => $term_cycle_id])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'course_id' => 'scms_courses_cycle.course_id',
                            'level_id' => 'scms_courses_cycle.level_id',
                            'term_id' => 'scms_term_cycle.term_id',
                        ])
                        ->join([
                            'scms_courses_cycle' => [
                                'table' => 'scms_courses_cycle',
                                'type' => 'LEFT',
                                'conditions' => ['scms_term_course_cycle.courses_cycle_id  = scms_courses_cycle.courses_cycle_id'],
                            ],
                            'scms_term_cycle' => [
                                'table' => 'scms_term_cycle',
                                'type' => 'LEFT',
                                'conditions' => ['scms_term_course_cycle.term_cycle_id  = scms_term_cycle.term_cycle_id'],
                            ],
                        ])->toArray();
        return $term_course_cycles;
    }

    private function term_course_cycle_promotion($old_term_cycle, $filter_term_cycle, $data) {
        //new course cycle start
        $new_course_cycle = $this->get_course_cycle($data['session_to']);
        $course_cycles = array();
        foreach ($new_course_cycle as $new_course) {
            $course_cycles[$new_course['level_id']][$new_course['course_id']] = $new_course;
        }
        foreach ($filter_term_cycle as $term_id => $term_cycle) {
            foreach ($term_cycle as $level_id => $level) {
                if (isset($course_cycles[$level_id])) {
                    $filter_term_cycle[$term_id][$level_id]['courses'] = $course_cycles[$level_id];
                }
            }
        }
        //new course cycle  end
        //old course cycle with mark distrubtion start
        $filter_old_term_cycle = array();
        foreach ($old_term_cycle as $old_cycle) {
            $filter_old_term_cycle[$old_cycle['term_id']][$old_cycle['level_id']] = $old_cycle;
            $old_term_cycle_ids[] = $old_cycle['term_cycle_id'];
        }

        $term_course_cycles = $this->get_term_course_cycle_by_term_cycle_ids($old_term_cycle_ids);

        $filter_term_course_cycles = array();
        foreach ($term_course_cycles as $term_course_cycle) {
            $filter_term_course_cycles[$term_course_cycle['term_course_cycle_id']] = $term_course_cycle;
            $term_course_cycle_ids[] = $term_course_cycle['term_course_cycle_id'];
        }

        $scms_term_course_cycle_part = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part'); //Execute First
        $parts = $scms_term_course_cycle_part
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['term_course_cycle_id IN' => $term_course_cycle_ids])
                ->toArray();
        foreach ($parts as $part) {
            $filter_term_course_cycles[$part['term_course_cycle_id']]['parts'][] = $part;
        }

        foreach ($filter_term_course_cycles as $term_course_cycle) {
            $filter_old_term_cycle[$term_course_cycle['term_id']][$term_course_cycle['level_id']]['courses'][$term_course_cycle['course_id']] = $term_course_cycle;
        }
        //old course cycle with mark distrubtion end
        //mating old and new course cycle
        $term_course_cycle_array = array();
        foreach ($filter_term_cycle as $term_id => $term_cycle) {
            foreach ($term_cycle as $level_id => $level) {
                if (isset($level['courses'])) {
                    foreach ($level['courses'] as $course_id => $course) {
                        if (isset($filter_old_term_cycle[$term_id][$level_id]['courses'][$course_id])) {
                            $term_course_cycle_array_single['term_cycle_id'] = $filter_term_cycle[$term_id][$level_id]['term_cycle_id'];
                            $term_cycle_id[] = $filter_term_cycle[$term_id][$level_id]['term_cycle_id'];
                            $term_course_cycle_array_single['courses_cycle_id'] = $filter_term_cycle[$term_id][$level_id]['courses'][$course_id]['courses_cycle_id'];
                            $term_course_cycle_array[] = $term_course_cycle_array_single;
                            if (isset($filter_old_term_cycle[$term_id][$level_id]['courses'][$course_id]['parts'])) {
                                $filter_term_cycle[$term_id][$level_id]['courses'][$course_id]['parts'] = $filter_old_term_cycle[$term_id][$level_id]['courses'][$course_id]['parts'];
                            }
                        }
                    }
                }
            }
        }
        $term_cycle_id = array_unique($term_cycle_id);

        $scms_term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
        $insertQuery = $scms_term_course_cycle->query();
        $columns = array_keys($term_course_cycle_array[0]);
        $insertQuery->insert($columns);
        $insertQuery->clause('values')->values($term_course_cycle_array);
        $insertQuery->execute();

        $saved_term_course_cycle = $this->get_term_course_cycle_by_term_cycle_ids($term_cycle_id);
        $scms_term_course_cycle_part_data = array();
        foreach ($saved_term_course_cycle as $saved_term_course) {
            if (isset($filter_term_cycle[$saved_term_course['term_id']][$saved_term_course['level_id']]['courses'][$saved_term_course['course_id']]['parts'])) {
                foreach ($filter_term_cycle[$saved_term_course['term_id']][$saved_term_course['level_id']]['courses'][$saved_term_course['course_id']]['parts'] as $part) {
                    unset($part['term_course_cycle_part_id']);
                    $part['term_course_cycle_id'] = $saved_term_course['term_course_cycle_id'];
                    $scms_term_course_cycle_part_data[] = $part;
                }
            }
        }

        if (count($scms_term_course_cycle_part_data)) {
            $scms_term_course_cycle_part = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part');
            $insertQuery = $scms_term_course_cycle_part->query();
            $columns = array_keys($scms_term_course_cycle_part_data[0]);
            $insertQuery->insert($columns);
            $insertQuery->clause('values')->values($scms_term_course_cycle_part_data);
            $insertQuery->execute();
        }
    }

    private function term_activity_cycle_promotion($old_term_cycle, $filter_term_cycle, $data) {
        //new activitu cycle start
        $new_activity_cycle = $this->get_activity_cycle($data['session_to']);
        $activity_cycles = array();
        foreach ($new_activity_cycle as $new_activity) {
            $activity_cycles[$new_activity['level_id']][$new_activity['activity_id']] = $new_activity;
        }
        foreach ($filter_term_cycle as $term_id => $term_cycle) {
            foreach ($term_cycle as $level_id => $level) {
                $filter_term_cycle[$term_id][$level_id]['activity'] = $activity_cycles[$level_id];
            }
        }
        //new activitu cycle end
        //old activity cycle start
        $filter_old_term_cycle = array();
        foreach ($old_term_cycle as $old_cycle) {
            $filter_old_term_cycle[$old_cycle['term_id']][$old_cycle['level_id']] = $old_cycle;
            $old_term_cycle_ids[] = $old_cycle['term_cycle_id'];
        }
        $term_activity_cycles = $this->get_term_activity_cycle_by_term_cycle_ids($old_term_cycle_ids);
        //old activity cycle start end
        //matching activity cycle start
        $scms_term_activity_cycle_data = array();
        foreach ($term_activity_cycles as $term_activity_cycle) {
            if (isset($filter_term_cycle[$term_activity_cycle['term_id']][$term_activity_cycle['level_id']]['activity'][$term_activity_cycle['activity_id']])) {
                $scms_term_activity_cycle_data_single['term_cycle_id'] = $filter_term_cycle[$term_activity_cycle['term_id']][$term_activity_cycle['level_id']]['term_cycle_id'];
                $scms_term_activity_cycle_data_single['activity_cycle_id'] = $filter_term_cycle[$term_activity_cycle['term_id']][$term_activity_cycle['level_id']]['activity'][$term_activity_cycle['activity_id']]['activity_cycle_id'];
                $scms_term_activity_cycle_data[] = $scms_term_activity_cycle_data_single;
            }
        }
        //matching activity cycle end
        if (count($scms_term_activity_cycle_data)) {
            $scms_term_activity_cycle = TableRegistry::getTableLocator()->get('scms_term_activity_cycle');
            $insertQuery = $scms_term_activity_cycle->query();
            $columns = array_keys($scms_term_activity_cycle_data[0]);
            $insertQuery->insert($columns);
            $insertQuery->clause('values')->values($scms_term_activity_cycle_data);
            $insertQuery->execute();
        }
    }

    public function termCyclePromotion() {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $new_term_cycle = $this->get_term_cycle($data['session_to']);
            if (count($new_term_cycle)) {
                $message = 'Term cycle promotion unsuccessful. Already, ' . count($new_term_cycle) . ' Term Cycle is exist in ' . $new_term_cycle[0]['session_name'] . ' Session.';
                $this->Flash->success($message, [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'termCyclePromotion']);
            }
            $old_term_cycle = $this->get_term_cycle($data['session_from']);
            $session = TableRegistry::getTableLocator()->get('scms_sessions'); //Execute First

            if (count($old_term_cycle) == 0) {
                $sessions = $session
                        ->find()
                        ->where(['session_id' => $data['session_from']])
                        ->toArray();
                $message = 'Term cycle promotion unsuccessful.  ' . $sessions[0]->session_name . ' Session has no Term Cycle.';
                $this->Flash->success($message, [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'termCyclePromotion']);
            }
            $promotion_cycle = array();
            foreach ($old_term_cycle as $old_cycle) {
                $promotion_cycle_single['term_id'] = $old_cycle['term_id'];
                $promotion_cycle_single['level_id'] = $old_cycle['level_id'];
                $promotion_cycle_single['session_id'] = $data['session_to'];
                $promotion_cycle[] = $promotion_cycle_single;
            }

            $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
            $insertQuery = $scms_term_cycle->query();
            $columns = array_keys($promotion_cycle[0]);
            $insertQuery->insert($columns);
            $insertQuery->clause('values')->values($promotion_cycle);
            $insertQuery->execute();

            $new_term_cycle = $this->get_term_cycle($data['session_to']);
            $filter_term_cycle = array();
            foreach ($new_term_cycle as $new_term) {
                $filter_term_cycle[$new_term['term_id']][$new_term['level_id']] = $new_term;
            }
            $new_course_cycle = $this->get_course_cycle($data['session_to']);
            if (count($new_course_cycle)) {
                $this->term_course_cycle_promotion($old_term_cycle, $filter_term_cycle, $data);
            }
            $new_activity_cycle = $this->get_activity_cycle($data['session_to']);
            if (count($new_activity_cycle)) {
                $this->term_activity_cycle_promotion($old_term_cycle, $filter_term_cycle, $data);
            }


            $message = 'Term cycle, Term Course Cycle, Term Activity Cycle and Term Course Cycle Marks promotion successfully Completed.';
            $this->Flash->success($message, [
                'key' => 'Positive',
                'params' => [],
            ]);
        }


        $scms_session = TableRegistry::getTableLocator()->get('scms_sessions');
        $scms_sessions = $scms_session
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->order(['session_name' => 'DESC'])
                ->toArray();
        $this->set('scms_sessions', $scms_sessions);
    }


    public function selectSession(){
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $sessions_encoded = json_encode($request_data['session_id']);
            $settingTable = TableRegistry::getTableLocator()->get('Settings'); // 'Settings' should match the actual name of your settings table entity
            $query = $settingTable->query();

            $query
                ->update()
                ->set(['value' => $sessions_encoded]) // Assuming the field name to store the sessions is 'value'
                ->where(['`key`' => 'Site.selectedSession']) // No need for backticks in the condition
                ->execute();

            $this->Flash->success('Active Sessions Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'selectSession']);
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions'); //Execute First
        $sessions = $session
            ->find()
            ->toArray();
        $this->set('sessions', $sessions);

        $settingTable = TableRegistry::getTableLocator()->get('Settings'); // 'Settings' should match the actual name of your settings table entity
        $settings  = $settingTable->find()->toArray();
        foreach ($settings as &$value){
            switch ($value['key']){
                case "Site.selectedSession":
                    $selectedSessionID = $value;
                    break;
            }
        }
        $this->set("selectedSession", $selectedSessionID['value']);
    }

}
