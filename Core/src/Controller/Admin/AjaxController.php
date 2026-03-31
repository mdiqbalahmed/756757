<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class AjaxController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function getLevelsAjax()
    {
        $this->autoRender = false;
        $department_id = $this->request->getQuery('department_id');
        $level = TableRegistry::getTableLocator()->get('scms_levels'); //Execute First
        $levels = $level
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['department_id' => $department_id])
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($levels));
        return $this->response;
    }

    public function getBuildingAjax()
    { //@shovon 14/03/24
        $this->autoRender = false;
        $building_id = $_GET['building_id'];
        $hostel_room = TableRegistry::getTableLocator()->get('hostel_rooms');
        $hostel_rooms = $hostel_room
            ->find()
            ->where(['building_id' => $building_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        echo json_encode($hostel_rooms);
    }

    public function getRoomAjax()
    {
        $this->autoRender = false;

        $stdId = substr($_GET['sid'], 4);
        // pr($stdId);die;
        $student = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $stdInfos = $student
            ->find()
            ->where(['scms_student_cycle.student_cycle_id' => $stdId])
            ->select([
                'name' => 'c.name',
                'sid' => 'c.sid',
            ])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'c' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => ['c.student_id = scms_student_cycle.student_id'],
                ],
            ])
            ->toArray();
        $sid = $stdInfos[0]['sid'];
        $student_cycle_id = $stdInfos[0]['student_cycle_id'];
        // pr($stdInfos);die;


        $roomId = substr($_GET['room'], 4);
        $room = TableRegistry::getTableLocator()->get('hostel_rooms');
        $building = $room
            ->find()
            ->where(['id' => $roomId])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        $roomStatus = $building[0]['status'];
        $roomSeat = $building[0]['seat'];
        $roomExtra = $building[0]['extra'];
        $buildingId = $building[0]['building_id'];
        $insQuery = "INSERT INTO hostel_allotements " . "(std_id,building_id,room_id,student_cycle_id) " . "VALUES('$sid','$buildingId','$roomId','$student_cycle_id')";


        if ($insQuery) {
            if ($roomStatus < $roomSeat) {

                $data['std_id'] = $sid;
                $data['building_id'] = $buildingId;
                $data['room_id'] = $roomId;
                $data['student_cycle_id'] = $student_cycle_id;
                $data['extra'] = 0;

                $student_columns = array_keys($data);
                $student = TableRegistry::getTableLocator()->get('hostel_allotements');
                $insQuery = $student->query();
                $insQuery->insert($student_columns)
                    ->values($data)
                    ->execute();




                $rmSt = $roomStatus + 1;

                $room = TableRegistry::getTableLocator()->get('hostel_rooms');
                $updateRoomQuery = $room->query();

                $updateRoomQuery->update()
                    ->set([
                        'status' => $rmSt
                    ])
                    ->where(['id' => $roomId])
                    ->execute();


                $student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
                $updateSQuery = $student_cycle->query();

                $updateSQuery->update()
                    ->set([
                        'seat' => 1
                    ])
                    ->where(['student_cycle_id' => $student_cycle_id])
                    ->execute();

                $roomInfos = $room
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['id' => $roomId])
                    ->toArray();

                if ($roomInfos[0]['status'] < $roomInfos[0]['seat']) {
                    $romSt = $roomInfos[0]['seat'] - $roomInfos[0]['status'];
                } else {
                    $romSt = 0;
                }
                $rmEmt = 0;
                echo $romSt . '#' . $roomId . '#' . $rmEmt; //die;
            } else {
                // echo '2';die;


                $data['std_id'] = $sid;
                $data['building_id'] = $buildingId;
                $data['room_id'] = $roomId;
                $data['student_cycle_id'] = $student_cycle_id;
                $data['extra'] = 1;

                $student_columns = array_keys($data);
                $student = TableRegistry::getTableLocator()->get('hostel_allotements');
                $insertQuery = $student->query();
                $insertQuery->insert($student_columns)
                    ->values($data)
                    ->execute();



                $rmESt = 1;
                $rmExSt = $roomExtra + 1;


                $room = TableRegistry::getTableLocator()->get('hostel_rooms');
                $updateExRoomQuery = $room->query();

                $updateExRoomQuery->update()
                    ->set([
                        'extra' => $rmExSt
                    ])
                    ->where(['id' => $roomId])
                    ->execute();



                $student = TableRegistry::getTableLocator()->get('scms_student_cycle');
                $updateExStdQuery = $student->query();

                $updateExStdQuery->update()
                    ->set([
                        'seat' => 1
                    ])
                    ->where(['student_cycle_id' => $student_cycle_id])
                    ->execute();

                echo $rmExSt . '#' . $roomId . '#' . $rmESt;
            }
        }
    }


    public function getCodeAjax()
    { //@shovon 19/06/23
        $this->autoRender = false;
        $sid = $_GET['sid'];
        $section = TableRegistry::getTableLocator()->get('scms_students');
        $sectionss = $section
            ->find()
            ->where(['sid' => $sid])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $count = count($sectionss);

        echo json_encode($count);
    }


    public function getCoursesAjax()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
        $courses_cycles = $courses_cycle
            ->find()
            ->where(['level_id' => $Level_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'course_name' => 'c.course_name',
            ])
            ->join([
                'c' => [
                    'table' => 'scms_courses',
                    'type' => 'LEFT',
                    'conditions' => ['c.course_id  = scms_courses_cycle.course_id'],
                ],
            ])
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($courses_cycles));
        return $this->response;
    }

    public function getSectionAjax()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        if ($Level_id) {
            $where['level_id'] = $Level_id;
        }
        $shift_id = $this->request->getQuery('shift_id');
        if (isset($shift_id)&& $shift_id) {
            $where['shift_id'] = $shift_id;
        }
        $session_id = $this->request->getQuery('session_id');
        $session_where=array();
        if (isset($session_id)) {
            $session_where['session_id'] = $session_id;
        }else{
            $active_session=$this->get_active_session();
            $session_where['session_id'] = $active_session[0]['session_id'];
        }
        $type = $this->request->getQuery('type');
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles) || $type == false) {
            $section = TableRegistry::getTableLocator()->get('scms_sections');
            $sections = $section
                ->find()
                ->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        } else {
            $id = $this->Auth->user('id');
            $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $permissions = $employees_permission->find()
                ->where(['user_id' => $id])
                ->where(['level_id' => $Level_id])
                ->where($session_where)
                ->where(['employees_permission.type' => $type])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->join([
                    'employee' => [
                        'table' => 'employee',
                        'type' => 'INNER',
                        'conditions' => [
                            'employee.employee_id = employees_permission.employee_id'
                        ]
                    ],
                ])
                ->toArray();
            $section_ids = array();
            foreach ($permissions as $permission) {
                $section_ids[$permission['section_id']] = $permission['section_id'];
            }
            if (count($section_ids)) {
                $section_ids = array_values($section_ids);
                $section = TableRegistry::getTableLocator()->get('scms_sections');
                $sections = $section
                    ->find()
                    ->where(['section_id IN' => $section_ids])
                    ->where($where)
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
            } else {
                $sections = array();

            }
        }

        $this->response->type('application/json');
        $this->response->body(json_encode($sections));
        return $this->response;
    }

    public function getUserAjax()
    { //@shovon 10/06/23
        $this->autoRender = false;
        $role_id = $this->request->getQuery('role_id');
        $user = TableRegistry::getTableLocator()->get('users');
        $users = $user
            ->find()
            ->where(['role_id' => $role_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($users));
        return $this->response;
    }

    public function getSubjectAjax()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $group_id = $this->request->getQuery('group_id');
        $session_id = $this->request->getQuery('session_id');
        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $courses_all = $course
            ->find()
            ->where(['cs.session_id' => $session_id])
            ->where(['cs.level_id' => $Level_id])
            ->where(['course_type_id' => 3]) //static 
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'level_id' => 'cs.level_id',
            ])
            ->join([
                'cs' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['cs.course_id  = scms_courses.course_id'],
                ],
            ])
            ->toArray();
        $courses = array();
        foreach ($courses_all as $course_all) {
            if ($course_all['course_group_id'] == $group_id || $course_all['course_group_id'] == null) {
                $courses[] = $course_all;
            }
        }
        $this->response->type('application/json');
        $this->response->body(json_encode($courses));
        return $this->response;
    }

    public function getReligionSubjectAjax()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $session_id = $this->request->getQuery('session_id');
        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $courses_all = $course
            ->find()
            ->where(['cs.session_id' => $session_id])
            ->where(['cs.level_id' => $Level_id])
            ->where(['course_type_id' => 5]) //static 
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'level_id' => 'cs.level_id',
            ])
            ->join([
                'cs' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['cs.course_id  = scms_courses.course_id'],
                ],
            ])
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($courses_all));
        return $this->response;
    }
    
    public function getAdmitAjax()
    {
        $this->autoRender = false;
        $sid = $this->request->getQuery('sid');
        $session_id = $this->request->getQuery('session_id');
        $term_cycle = TableRegistry::getTableLocator()->get('scms_students');
        $term_cycle_all = $term_cycle
            ->find()
            ->where(['sc.session_id' => $session_id])
            ->where(['sid' => $sid])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'level_name' => 'scms_levels.level_name',
                'section_name' => 'scms_sections.section_name',
                'level_id' => 'scms_levels.level_id',
                'section_id' => 'scms_sections.section_id',
                'term_cycle_id' => 'stc.term_cycle_id',
                'term_name' => 't.term_name',
                'student_cycle_id' => 'sc.student_cycle_id',
            ])
            ->join([
                'sc' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['sc.student_id  = scms_students.student_id'],
                ],
                'tc' => [
                    'table' => 'scms_student_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['tc.student_cycle_id  = sc.student_cycle_id'],
                ],
                'stc' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['stc.term_cycle_id  = tc.term_cycle_id'],
                ],
                't' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => ['t.term_id  = stc.term_id'],
                ],
                'scms_sections' => [
                    'table' => 'scms_sections',
                    'type' => 'LEFT',
                    'conditions' => ['scms_sections.section_id  = sc.section_id'],
                ],
                'scms_levels' => [
                    'table' => 'scms_levels',
                    'type' => 'LEFT',
                    'conditions' => ['scms_levels.level_id  = sc.level_id'],
                ],
            ])
            ->toArray();
        $mergedData = [];
        $terms = [];

        if (!empty($term_cycle_all)) {
            foreach ($term_cycle_all as $index => $data) {
                if ($index === 0) {
                    // Take all student information from the first item
                    $mergedData = $data;
                }
                // Collect term_cycle_id and term_name together
                if (!empty($data['term_name']) && !empty($data['term_cycle_id'])) {
                    $terms[] = [
                        'term_cycle_id' => $data['term_cycle_id'],
                        'term_name' => trim($data['term_name']),
                    ];
                }
            }

            // Now, clean the merged data:
            unset($mergedData['term_name']);
            unset($mergedData['modified']);

            // Keep section_id and level_id separately
            $mergedData['section_id'] = $mergedData['section_id'] ?? null;
            $mergedData['section_name'] = $mergedData['section_name'] ?? '';
            $mergedData['level_id'] = $mergedData['level_id'] ?? null;
            $mergedData['level_name'] = $mergedData['level_name'] ?? '';

            // Remove duplicate terms based on 'term_cycle_id'
            $terms = array_unique($terms, SORT_REGULAR);

            // Add the collected terms
            $mergedData['terms'] = $terms;
        }

        $this->response = $this->response->withType('application/json');
        $this->response = $this->response->withStringBody(json_encode($mergedData));
        return $this->response;
    }
    
    public function getPromotionAjax()
    {
        $this->autoRender = false;
        $sid = $this->request->getQuery('sid');

        $student = TableRegistry::getTableLocator()->get('scms_students');
        $students = $student
            ->find()
            ->where(['sid' => $sid])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'level_name' => 'scms_levels.level_name',
                'section_name' => 'scms_sections.section_name',
                'section_id' => 'scms_sections.section_id',
                'session_name' => 'scms_sessions.session_name',

            ])
            ->join([

                'sc' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['sc.student_id  = scms_students.student_id', 'sc.session_id  = scms_students.session_id'],
                ],
                'scms_levels' => [
                    'table' => 'scms_levels',
                    'type' => 'LEFT',
                    'conditions' => ['scms_levels.level_id  = scms_students.level_id'],
                ],
                'scms_sections' => [
                    'table' => 'scms_sections',
                    'type' => 'LEFT',
                    'conditions' => ['scms_sections.section_id  = sc.section_id'],
                ],
                'scms_sessions' => [
                    'table' => 'scms_sessions',
                    'type' => 'LEFT',
                    'conditions' => ['scms_sessions .session_id  = sc.session_id'],
                ],
            ])
            ->toArray();
        // echo '<pre>';
        // print_r($students);
        // die;
        $this->response = $this->response->withType('application/json');
        $this->response = $this->response->withStringBody(json_encode($students));
        return $this->response;
    }

    public function getTermAjax()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $session_id = $this->request->getQuery('session_id');
        $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $term_cycle_all = $term_cycle
            ->find()
            ->where(['session_id' => $session_id])
            ->where(['level_id' => $Level_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'term_name' => 't.term_name',
            ])
            ->join([
                't' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => ['t.term_id  = scms_term_cycle.term_id'],
                ],
            ])
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($term_cycle_all));
        return $this->response;
    }

    public function getallSubjectAjax()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $session_id = $this->request->getQuery('session_id');
        $term_cycle_id = $this->request->getQuery('term_cycle_id');
        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $courses = $course
            ->find()
            ->where(['cc.session_id' => $session_id])
            ->where(['cc.level_id' => $Level_id])
            ->where(['tcc.term_cycle_id' => $term_cycle_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'courses_cycle_id' => 'tcc.courses_cycle_id',
            ])
            ->join([
                'cc' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['cc.course_id  = scms_courses.course_id'],
                ],
            ])
            ->join([
                'tcc' => [
                    'table' => 'scms_term_course_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['tcc.courses_cycle_id  = cc.courses_cycle_id'],
                ],
            ])
            ->toArray();

        $filter_course = array();
        foreach ($courses as $key => $course) {
            $filter_course[$key]['courses_cycle_id'] = $course['courses_cycle_id'];
            $filter_course[$key]['course_name'] = $course['course_name'];
            $filter_course[$key]['course_id'] = $course['course_id'];
        }
        $this->response->type('application/json');
        $this->response->body(json_encode($filter_course));
        return $this->response;
    }

    public function getPartType()
    {
        $this->autoRender = false;
        $term_cycle_id = $this->request->getQuery('term_cycle_id');
        $courses_cycle_id = $this->request->getQuery('courses_cycle_id');
        $term_course_cycle_part = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part');
        $parts = $term_course_cycle_part
            ->find()
            ->where(['tcc.courses_cycle_id' => $courses_cycle_id])
            ->where(['tcc.term_cycle_id' => $term_cycle_id])
            ->where(['scms_term_course_cycle_part.mark >' => 0])
            ->where(['tccpt.partable' => 'Yes'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'courses_cycle_id' => 'tcc.courses_cycle_id',
                'term_course_cycle_part_type_name' => 'tccpt.term_course_cycle_part_type_name',
            ])
            ->join([
                'tccpt' => [
                    'table' => 'scms_term_course_cycle_part_type',
                    'type' => 'LEFT',
                    'conditions' => ['tccpt.term_course_cycle_part_type_id  = scms_term_course_cycle_part.term_course_cycle_part_type_id'],
                ],
            ])
            ->join([
                'tcc' => [
                    'table' => 'scms_term_course_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['tcc.term_course_cycle_id   = scms_term_course_cycle_part.term_course_cycle_id'],
                ],
            ])
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($parts));
        return $this->response;
    }

    public function getLevelAjax()
    {
        $this->autoRender = false;
        $term_id = $this->request->getQuery('term_id');
        $session_id = $this->request->getQuery('session_id');
        $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $term_cycles = $term_cycle
            ->find()
            ->where(['scms_term_cycle.session_id' => $session_id])
            ->where(['scms_term_cycle.term_id' => $term_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'level_name' => 'l.level_name',
            ])
            ->join([
                'l' => [
                    'table' => 'scms_levels',
                    'type' => 'LEFT',
                    'conditions' => ['l.level_id  = scms_term_cycle.level_id'],
                ],
            ])
            ->toArray();
        foreach ($term_cycles as $cycle) {
            $term_cycle_level_id[] = $cycle['level_id'];
        }

        if (isset($term_cycle_level_id)) {
            $scms_level = TableRegistry::getTableLocator()->get('scms_levels');
            $scms_levels = $scms_level
                ->find()
                ->where(['level_id Not in' => $term_cycle_level_id])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        } else {
            $scms_level = TableRegistry::getTableLocator()->get('scms_levels');
            $scms_levels = $scms_level
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        }
        $this->response->type('application/json');
        $this->response->body(json_encode($scms_levels));
        return $this->response;
    }

    public function getConfigurationAjax()
    { //Function for Certificate generation
        $this->autoRender = false;
        $certificate_type_id = $this->request->getQuery('certificate_type_id');
        $config = TableRegistry::getTableLocator()->get('scms_certificate_config');
        $configs = $config
            ->find()
            ->where(['t.certificate_type_id' => $certificate_type_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'certificate_type_id' => 't.certificate_type_id',
                'certificate_title' => 't.certificate_title'
            ])
            ->join([
                't' => [
                    'table' => 'scms_certificate_type',
                    'type' => 'INNER',
                    'conditions' => ['t.certificate_type_id  = scms_certificate_config.certificate_type_id'],
                ],
            ])
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($configs));
        return $this->response;
    }

    public function deleteGradeAjax()
    {
        $this->autoRender = false;
        $grade_id = $this->request->getQuery('grade_id');
        $grade = TableRegistry::getTableLocator()->get('scms_grade');
        $query = $grade->query();
        $query->delete()
            ->where(['grade_id' => $grade_id])
            ->execute();
        $this->response->type('application/json');
        $this->response->body(json_encode($grade_id));
        return $this->response;
    }

    public function getLeaveAjax()
    {
        $this->autoRender = false;
        $employee_id = $this->request->getQuery('employee_id');
        $employee = TableRegistry::getTableLocator()->get('employee');
        $employees = $employee->find()
            ->where(['employee_id' => $employee_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        $id = $employees[0]['user_id'];
        $year = date("Y");
        $config_key[] = 'casual_leave';
        $config_key[] = 'sick_leave';

        $hr_config_action_setup = TableRegistry::getTableLocator()->get('hr_config_action_setup');
        $leave_type = $hr_config_action_setup->find()
            ->where(['user_id' => $id])
            ->where(['year' => $year])
            ->where(['config_key' => $config_key], ['config_key' => 'string[]'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'config_action_name' => "ca.config_action_name",
            ])
            ->join([
                'ca' => [
                    'table' => 'hr_config_action',
                    'type' => 'LEFT',
                    'conditions' => [
                        'ca.config_action_id = hr_config_action_setup.config_action_id'
                    ]
                ],
            ])
            ->toArray();

        $this->response->type('application/json');
        $this->response->body(json_encode($leave_type));
        return $this->response;
    }

    public function getSectionAjaxbylevelfrom()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $section = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $section
            ->find()
            ->where(['level_id' => $Level_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($sections));
        return $this->response;
    }

    public function getSectionAjaxbylevelto()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $section = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $section
            ->find()
            ->where(['level_id' => $Level_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($sections));
        return $this->response;
    }

    public function getSectionAjaxbylevel()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $section = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $section
            ->find()
            ->where(['level_id' => $Level_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($sections));
        return $this->response;
    }

    public function getSubjectAjaxbylevel()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $courses = array();
        $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $term_cycles = $term_cycle->find()->where(['level_id' => $Level_id])->toArray();
        foreach ($term_cycles as $term_cycle) {
            $term_cycle_ids[] = $term_cycle->term_cycle_id;
        }
        if (isset($term_cycle_ids)) {
            $scms_course = TableRegistry::getTableLocator()->get('scms_courses');
            $scms_courses = $scms_course
                ->find()
                ->where(['term_cycle_id  IN' => $term_cycle_ids])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->join([
                    'cc' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['cc.course_id  = scms_courses.course_id'],
                    ],
                ])
                ->join([
                    'tcc' => [
                        'table' => 'scms_term_course_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['tcc.courses_cycle_id  = cc.courses_cycle_id'],
                    ],
                ])
                ->toArray();
            foreach ($scms_courses as $scms_course) {
                $courses[$scms_course['course_id']]['course_id'] = $scms_course['course_id'];
                $courses[$scms_course['course_id']]['course_name'] = $scms_course['course_name'];
            }
        }
        $no_index_courses = array();
        foreach ($courses as $course) {
            $no_index_courses[] = $course;
        }
        $this->response->type('application/json');
        $this->response->body(json_encode($no_index_courses));
        return $this->response;
    }

    public function getGroupAjax()
    {
        $this->autoRender = false;
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($groups));
        return $this->response;
    }

    public function getThirdForthAjax()
    {
        $this->autoRender = false;
        $group_id = $this->request->getQuery('group_id');
        $session_id = $this->request->getQuery('session_id');
        $Level_id = $this->request->getQuery('level_id');
        $course = TableRegistry::getTableLocator()->get('scms_courses');
        if ($group_id) {
            $forth_and_third_subject_1 = $course
                ->find()
                ->where(['cs.session_id' => $session_id])
                ->where(['course_type_id' => 3])
                ->where(['cs.level_id' => $Level_id])
                ->where(['course_group_id' => $group_id])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->group('scms_courses.course_id')
                ->select([
                    'level_id' => 'cs.level_id',
                ])
                ->join([
                    'cs' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['cs.course_id  = scms_courses.course_id'],
                    ],
                ])
                ->toArray();
            $forth_and_third_subject_2 = $course
                ->find()
                ->where(['cs.session_id' => $session_id])
                ->where(['course_type_id' => 3])
                ->where(['cs.level_id' => $Level_id])
                ->where(['course_group_id is NULL'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->group('scms_courses.course_id')
                ->select([
                    'level_id' => 'cs.level_id',
                ])
                ->join([
                    'cs' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['cs.course_id  = scms_courses.course_id'],
                    ],
                ])
                ->toArray();
            $forth_and_third_subject = array_merge($forth_and_third_subject_2, $forth_and_third_subject_1);
        } else {
            $forth_and_third_subject_1 = $course
                ->find()
                ->where(['cs.session_id' => $session_id])
                ->where(['course_type_id' => 3])
                ->where(['cs.level_id' => $Level_id])
                ->where(['course_group_id is NULL'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->group('scms_courses.course_id')
                ->select([
                    'level_id' => 'cs.level_id',
                ])
                ->join([
                    'cs' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['cs.course_id  = scms_courses.course_id'],
                    ],
                ])
                ->toArray();
        }
        $this->response->type('application/json');
        $this->response->body(json_encode($forth_and_third_subject));
        return $this->response;
    }

    private function TermCourseCycleDelete($term_course_cycle_id)
    {
        $scms_term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
        $scms_term_course_cycles = $scms_term_course_cycle
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['term_course_cycle_id' => $term_course_cycle_id])
            ->toArray();

        $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
        $scms_student_term_course_cycles = $scms_student_term_course_cycle
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['scms_student_term_cycle.term_cycle_id' => $scms_term_course_cycles[0]['term_cycle_id']])
            ->where(['scms_student_course_cycle.courses_cycle_id' => $scms_term_course_cycles[0]['courses_cycle_id']])
            ->join([
                'scms_student_term_cycle' => [
                    'table' => 'scms_student_term_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_term_cycle.student_term_cycle_id  = scms_student_term_course_cycle.student_term_cycle_id'],
                ],
                'scms_student_course_cycle' => [
                    'table' => 'scms_student_course_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_course_cycle.student_course_cycle_id  = scms_student_term_course_cycle.student_course_cycle_id'],
                ]
            ])->toArray();

        $scms_student_term_course_cycles_ids = array();

        foreach ($scms_student_term_course_cycles as $student_term_course_cycle) {
            $scms_student_term_course_cycles_ids[] = $student_term_course_cycle['student_term_course_cycle_id'];
        }
        if (count($scms_student_term_course_cycles_ids) > 0) {
            //delete $scms_term_course_cycle_part_mark start
            $scms_term_course_cycle_part_mark = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_mark');
            $query = $scms_term_course_cycle_part_mark->query();
            $query->delete()
                ->where(['student_term_course_cycle_id IN' => $scms_student_term_course_cycles_ids])
                ->execute();
            //delete $scms_term_course_cycle_part_mark end
            //----***----//
            //delete scms_student_term_course_cycle start
            $query = $scms_student_term_course_cycle->query();
            $query->delete()
                ->where(['student_term_course_cycle_id IN' => $scms_student_term_course_cycles_ids])
                ->execute();
            //delete scms_student_term_course_cycle end
            //----***----//
        }

        //delete $scms_term_course_cycle_part start
        $scms_term_course_cycle_part = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part');
        $query = $scms_term_course_cycle_part->query();
        $query->delete()
            ->where(['term_course_cycle_id' => $term_course_cycle_id])
            ->execute();
        //delete $scms_term_course_cycle_part end
        //----***----//
        //delete $scms_term_course_cycle start
        $query = $scms_term_course_cycle->query();
        $query->delete()
            ->where(['term_course_cycle_id' => $term_course_cycle_id])
            ->execute();
        //delete $scms_term_course_cycle_part end
        //----***----//

        return true;
    }

    public function deleteTermCourseCycle()
    {
        $this->autoRender = false;
        $term_course_cycle_id = $this->request->getQuery('term_course_cycle_id');
        $this->TermCourseCycleDelete($term_course_cycle_id);
        $this->response->type('application/json');
        $this->response->body(json_encode(true));
        return $this->response;
    }

    public function deleteTermActivityCycle()
    {
        $this->autoRender = false;
        $term_activity_cycle_id = $this->request->getQuery('term_activity_cycle_id');
        //delete $scms_term_course_cycle start
        $scms_term_activity_cycle = TableRegistry::getTableLocator()->get('scms_term_activity_cycle');
        $query = $scms_term_activity_cycle->query();
        $query->delete()
            ->where(['term_activity_cycle_id' => $term_activity_cycle_id])
            ->execute();
        //delete $scms_term_course_cycle_part end
        $this->response->type('application/json');
        $this->response->body(json_encode(true));
        return $this->response;
    }

    public function deleteActivityCycle()
    {
        $this->autoRender = false;
        $activity_cycle_id = $this->request->getQuery('activity_cycle_id');
        $scms_activity_cycle = TableRegistry::getTableLocator()->get('scms_activity_cycle');
        $query = $scms_activity_cycle->query();
        $query->delete()
            ->where(['activity_cycle_id' => $activity_cycle_id])
            ->execute();
        $this->response->type('application/json');
        $this->response->body(json_encode(true));
        return $this->response;
    }

    public function getActivityAjax()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $session_id = $this->request->getQuery('session_id');
        $term_cycle_id = $this->request->getQuery('term_cycle_id');
        $scms_term_activity_cycle = TableRegistry::getTableLocator()->get('scms_term_activity_cycle');
        $term_activity_cycle = $scms_term_activity_cycle
            ->find()
            ->where(['a.deleted' => 0])
            ->where(['ac.level_id' => $Level_id])
            ->where(['ac.session_id' => $session_id])
            ->where(['scms_term_activity_cycle.term_cycle_id' => $term_cycle_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'activity_name' => 'a.name',
            ])
            ->join([
                'ac' => [
                    'table' => 'scms_activity_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['ac.activity_cycle_id  = scms_term_activity_cycle.activity_cycle_id'],
                ],
                'a' => [
                    'table' => 'scms_activity',
                    'type' => 'LEFT',
                    'conditions' => ['a.activity_id  = ac.activity_id'],
                ],
            ])
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($term_activity_cycle));
        return $this->response;
    }

    public function deleteCourseCycle()
    {
        $this->autoRender = false;
        $courses_cycle_id = $this->request->getQuery('courses_cycle_id');
        $scms_term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
        $scms_term_course_cycles = $scms_term_course_cycle
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['courses_cycle_id' => $courses_cycle_id])
            ->toArray();

        foreach ($scms_term_course_cycles as $term_course_cycle) {
            $this->TermCourseCycleDelete($term_course_cycle['term_course_cycle_id']);
        }
        //delete scms_student_course_cycle start
        $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
        $query = $scms_student_course_cycle->query();
        $query->delete()
            ->where(['courses_cycle_id' => $courses_cycle_id])
            ->execute();
        //delete scms_student_course_cycle end
        //----***----// 
        //delete scms_courses_cycle start
        $scms_courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
        $query = $scms_courses_cycle->query();
        $query->delete()
            ->where(['courses_cycle_id' => $courses_cycle_id])
            ->execute();
        //delete scms_courses_cycle end
        $this->response->type('application/json');
        $this->response->body(json_encode(true));
        return $this->response;
    }

    public function getQuizAjax()
    {
        $this->autoRender = false;
        $term_course_cycle_part_id = $this->request->getQuery('term_course_cycle_part_id');

        $quiz = TableRegistry::getTableLocator()->get('scms_quiz');
        $quizs = $quiz
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['term_course_cycle_part_id' => $term_course_cycle_part_id])
            ->order(['scms_quiz_id' => 'ASC'])
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($quizs));
        return $this->response;
    }

    public function getBtnOrderAjax()
    {
        $this->autoRender = false; //@Shihab
        // Get the data from the AJAX request
        $id1 = $this->request->getQuery('id1');
        $order1 = $this->request->getQuery('order1');
        $id2 = $this->request->getQuery('id2');
        $order2 = $this->request->getQuery('order2');

        // Update the order in the "cms_quicklink" table
        $cmsQuicklinkTable = TableRegistry::getTableLocator()->get('cms_quicklink');

        $quicklink1 = $cmsQuicklinkTable->get($id1);
        $quicklink2 = $cmsQuicklinkTable->get($id2);

        // Swap the button_order values
        $tempOrder = $quicklink1->button_order;
        $quicklink1->button_order = $quicklink2->button_order;
        $quicklink2->button_order = $tempOrder;

        $cmsQuicklinkTable->save($quicklink1);
        $cmsQuicklinkTable->save($quicklink2);

        // Assuming the update was successful
        $response = 'success';

        // Return the response
        echo $response;
    }

    public function getEmployeeOrderAjax()
    {
        $this->autoRender = false; //@Shihab
        // Get the data from the AJAX request
        $id1 = $this->request->getQuery('id1');
        $order1 = $this->request->getQuery('order1');
        $id2 = $this->request->getQuery('id2');
        $order2 = $this->request->getQuery('order2');

        // Update the order in the "cms_quicklink" table
        $empTable = TableRegistry::getTableLocator()->get('employee');

        $quicklink1 = $empTable->get($id1);
        $quicklink2 = $empTable->get($id2);

        // Swap the sort_id values
        $tempOrder = $quicklink1->sort_id;
        $quicklink1->sort_id = $quicklink2->sort_id;
        $quicklink2->sort_id = $tempOrder;

        $empTable->save($quicklink1);
        $empTable->save($quicklink2);

        $response = 'success';

        echo $response;
    }

    public function getBoxOrderAjax()
    {
        $this->autoRender = false; //@Shihab
        // Get the data from the AJAX request
        $id1 = $this->request->getQuery('id1');
        $order1 = $this->request->getQuery('order1');
        $id2 = $this->request->getQuery('id2');
        $order2 = $this->request->getQuery('order2');

        // Update the order in the "cms_quicklink" table
        $boxTable = TableRegistry::getTableLocator()->get('cms_boxes');

        $quicklink1 = $boxTable->get($id1);
        $quicklink2 = $boxTable->get($id2);

        // Swap the box_order values
        $tempOrder = $quicklink1->box_order;
        $quicklink1->box_order = $quicklink2->box_order;
        $quicklink2->box_order = $tempOrder;

        $boxTable->save($quicklink1);
        $boxTable->save($quicklink2);

        $response = 'success';

        echo $response;
    }

    public function getOnlySessionMonthsAjax()
    {
        $this->autoRender = false;
        $sessionId = $this->request->getQuery('sessionId');
        $levelId = $this->request->getQuery('levelId');
        $where['session_id'] = $sessionId;
        $where['level_id'] = $levelId;
        //$where['acc_fees_khats.month_id'] = $request_data['month_id'];


        $shiftId = $_GET['shiftId'];
        $groupId = $_GET['groupId'];

        $where['shift_id'] = $shiftId ? $shiftId : 0;
        $where['group_id'] = $groupId ? $groupId : 0;

        $sessionTable = TableRegistry::getTableLocator()->get('scms_sessions');
        $session = $sessionTable->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['session_id' => $sessionId])
            ->toArray();

        if ($session && !empty($session[0]['start_date']) && !empty($session[0]['end_date'])) {
            $start_date = new \DateTime($session[0]['start_date']);
            $end_date = new \DateTime($session[0]['end_date']);

            $months = array();

            while ($start_date <= $end_date) {
                // Check if there's a match in acc_additional_fees_cycle for fees_id
                $monthId = $start_date->format('n');

                $months[$monthId] = array(
                    'id' => $monthId,
                    'month_name' => $start_date->format('F')
                );
                $start_date->modify('+1 month');
            }

            $feesKhatTable = TableRegistry::getTableLocator()->get('acc_fees_khats');
            $feesKhats = $feesKhatTable->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where($where)
                ->toArray();
            foreach ($feesKhats as $feesKhat) {
                unset($months[$feesKhat['month_id']]);
            }
            $months = array_values($months);
            $this->response->type('application/json');
            $this->response->body(json_encode($months));
            return $this->response;
        } else {
            $this->response->type('application/json');
            $this->response->body(json_encode([]));
            return $this->response;
        }
    }

    public function getVouchersAjax()
    {
        $this->autoRender = false;
        $sid = $this->request->getQuery('sid');
        $session_id = $this->request->getQuery('session_id');
        $where['scms_student_cycle.session_id'] = $session_id;
        $where['sid'] = $sid;
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (!in_array($role_id, $roles)) {
            $id = $this->Auth->user('id');
            $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $permissions = $employees_permission->find()
                ->where(['user_id' => $id])
                ->where(['session_id' => $session_id])
                ->where(['employees_permission.type' => 'accounts'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->join([
                    'employee' => [
                        'table' => 'employee',
                        'type' => 'INNER',
                        'conditions' => [
                            'employee.employee_id = employees_permission.employee_id'
                        ]
                    ],
                ])
                ->toArray();
            $section_ids=array();
            foreach ($permissions as $permission) {
                $section_ids[$permission['section_id']] = $permission['section_id'];
            }
            if (count($section_ids)) {
                $section_ids = array_values($section_ids);
                $where['scms_student_cycle.section_id IN'] = $section_ids;
            } else {
                $empty = -1;
                $this->response->type('application/json');
                $this->response->body(json_encode($empty));
                return $this->response;
            }
        }

        $student = $this->getStudentInfo($where);
        if (count($student)) {
            $fresh_vouchers = array();
            $months = $this->getMonthsFromSession($session_id);
            $vouchers = $this->getVouchers($student[0]);
            foreach ($vouchers as $key => $voucher) {
                $fresh_vouchers[$key]['id'] = $voucher['id'];
                $fresh_vouchers[$key]['voucher_no'] = $voucher['voucher_no'];
                $fresh_vouchers[$key]['amount'] = $voucher['amount'];
                $fresh_vouchers[$key]['due_amount'] = $voucher['due_amount'];
                $voucher_months = json_decode($voucher['month_ids']);
                foreach ($voucher_months as $voucher_month) {
                    $fresh_vouchers[$key]['month_name'] = isset($fresh_vouchers[$key]['month_name']) ? $fresh_vouchers[$key]['month_name'] . ',' . substr($months[$voucher_month]['name'], 0, 3) : substr($months[$voucher_month]['name'], 0, 3);
                }
            }
            $data['student'] = $student[0];
            $data['vouchers'] = count($fresh_vouchers) ? $fresh_vouchers : -1;
            $this->response->type('application/json');
            $this->response->body(json_encode($data));
            return $this->response;
        } else {
            $empty = -1;
            $this->response->type('application/json');
            $this->response->body(json_encode($empty));
            return $this->response;
        }
    }

    private function getVouchers($student)
    {
        $acc_vouchers = TableRegistry::getTableLocator()->get('acc_vouchers');
        $vouchers = $acc_vouchers
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['session_id' => $student['session_id']])
            ->where(['deleted' => 0])
            ->where(['sid' => $student['sid']])
            ->where(['payment_status !=' => 1])
            ->toArray();
        return $vouchers;
    }

    private function find_Khats_months_for_studnet($student, $month_ids)
    {
        if ($student['group_id'] && $student['shift_id']) {
            $where['shift_id'] = $student['shift_id'];
            $where['group_id'] = $student['group_id'];
            $khats_months = $this->find_Khats_months($where, $student, $month_ids);
            if (count($khats_months) != 0) {
                return $khats_months;
            }
            $where['shift_id'] = 0;
            $where['group_id'] = $student['group_id'];
            $khats_months = $this->find_Khats_months($where, $student, $month_ids);
            if (count($khats_months) != 0) {
                return $khats_months;
            }

            $where['shift_id'] = $student['shift_id'];
            $where['group_id'] = 0;
            $khats_months = $this->find_Khats_months($where, $student, $month_ids);
            if (count($khats_months) != 0) {
                return $khats_months;
            }

            $where['shift_id'] = 0;
            $where['group_id'] = 0;
            $khats_months = $this->find_Khats_months($where, $student, $month_ids);
            if (count($khats_months) != 0) {
                return $khats_months;
            }
        } else if ($student['group_id']) {
            $where['shift_id'] = 0;
            $where['group_id'] = $student['group_id'];
            $khats_months = $this->find_Khats_months($where, $student, $month_ids);
            if (count($khats_months) != 0) {
                return $khats_months;
            }
            $where['shift_id'] = 0;
            $where['group_id'] = 0;
            $khats_months = $this->find_Khats_months($where, $student, $month_ids);
            if (count($khats_months) != 0) {
                return $khats_months;
            }
        } else if ($student['shift_id']) {
            $where['group_id'] = 0;
            $where['shift_id'] = $student['shift_id'];
            $khats_months = $this->find_Khats_months($where, $student, $month_ids);
            if (count($khats_months) != 0) {
                return $khats_months;
            }
            $where['shift_id'] = 0;
            $where['group_id'] = 0;
            $khats_months = $this->find_Khats_months($where, $student, $month_ids);
            if (count($khats_months) != 0) {
                return $khats_months;
            }
        } else {
            $where['shift_id'] = 0;
            $where['group_id'] = 0;
            $khats_months = $this->find_Khats_months($where, $student, $month_ids);
            if (count($khats_months) != 0) {
                return $khats_months;
            }
        }
    }

    private function find_Khats_months($where, $student, $month_ids)
    {
        $fees_khats = TableRegistry::getTableLocator()->get('acc_fees_khats');
        $khats_months = $fees_khats
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['level_id' => $student['level_id']])
            ->where(['session_id' => $student['session_id']])
            ->where(['month_id IN' => $month_ids])
            ->where($where)
            ->toArray();

        return $khats_months;
    }

    private function get_vouchers_months($voucher_ids)
    {
        $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
        $voucher_purposes = $acc_voucher_purposes
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['voucher_id IN' => $voucher_ids])
            ->where(['payment_status !=' => 1])
            ->toArray();

        $purposes = array();
        $due_month_amount = array();
        $all_month_ids = array();
        $return['month_ids'] = array();
        foreach ($voucher_purposes as $voucher_purpose) {
            $all_month_ids[] = $voucher_purpose['month_id'];
            if ($voucher_purpose['payment_status']) {
                if (isset($due_month_amount[$voucher_purpose['month_id']])) {
                    $due_month_amount[$voucher_purpose['month_id']] = $due_month_amount[$voucher_purpose['month_id']] + $voucher_purpose['due'];
                } else {
                    $due_month_amount[$voucher_purpose['month_id']] = $voucher_purpose['due'];
                }
                $amount = $voucher_purpose['due'];
            } else {
                $amount = $voucher_purpose['amount'];
            }
            if (isset($purposes[$voucher_purpose['purpose_id']])) {
                $purposes[$voucher_purpose['purpose_id']] = $purposes[$voucher_purpose['purpose_id']] + $amount;
            } else {
                $purposes[$voucher_purpose['purpose_id']] = $amount;
            }
        }
        $return['month_ids'] = array_values(array_diff(array_unique($all_month_ids), array_keys($due_month_amount)));
        $return['due_month'] = $due_month_amount;
        $return['set_purposes'] = $purposes;
        $return['all_month_ids'] = $all_month_ids;

        return $return;
    }

    public function getPurposeMonthAjax()
    {
        $this->autoRender = false;
        $session_id = $this->request->getQuery('session_id');
        $voucher_ids = $this->request->getQuery('voucher_ids');
        $receive = $this->get_vouchers_months($voucher_ids);

        $month_ids = $receive['month_ids'];
        $set_purposes = $receive['set_purposes'];
        $due_months = $receive['due_month'];

        $filter_purposes = array();
        $acc_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $acc_purposes
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['parent' => 3])
            ->toArray();
        foreach ($purposes as $purpose) {
            $filter_purposes[$purpose['purpose_id']]['purpose_name'] = $purpose['purpose_name'];
            $filter_purposes[$purpose['purpose_id']]['purpose_id'] = $purpose['purpose_id'];
            $filter_purposes[$purpose['purpose_id']]['amount'] = isset($set_purposes[$purpose['purpose_id']]) ? $set_purposes[$purpose['purpose_id']] : 0;
        }
        $filter_purposes[77]['amount'] = $this->calculate_penalty($month_ids, $session_id); //penalty for delay
        $months = $this->getMonthsFromSession($session_id);
        foreach ($months as $key => $month) {
            $months[$key]['exist'] = isset($due_months[$key]) || in_array($key, $month_ids) ? 1 : null;
            $months[$key]['due'] = isset($due_months[$key]) ? $due_months[$key] : null;
        }
        $return['months'] = array_values($months);
        $return['filter_purposes'] = array_values($filter_purposes);

        $this->response->type('application/json');
        $this->response->body(json_encode($return));
        return $this->response;
    }

    private function calculate_penalty($month_ids, $session_id)
    {
        $session = TableRegistry::getTableLocator()->get('scms_sessions'); //Execute First
        $sessions = $session
            ->find()
            ->where(['session_id' => $session_id])
            ->toArray();
        $startTime = strtotime($sessions[0]->start_date);
        $endTime = strtotime($sessions[0]->end_date);
        for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
            $months[date('m', $i)] = date('m', $i);
        }
        $current = date('m');
        $late_months = array();
        foreach ($months as $month) {
            if ($month == $current) {
                break;
            } else {
                if (in_array($month, $month_ids)) {
                    $late_months[] = $month;
                }
            }
        }
        if (in_array($current, $month_ids) && $this->get_settings_value('Account.Penalty.Day') < date('d')) {
            $late_months[] = $current;
        }
        if ($this->get_settings_value('Account.Penalty.Amount') > 0) {
            return $this->get_settings_value('Account.Penalty.Amount') * count($late_months);
        } else {
            return 0;
        }
    }

    public function getTermForPromotionAjax()
    {
        $this->autoRender = false;
        $session_from = $this->request->getQuery('session_from');
        $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $term_cycle_all = $term_cycle
            ->find()
            ->where(['session_id' => $session_from])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'term_name' => 't.term_name',
            ])
            ->group('scms_term_cycle.term_id')
            ->join([
                't' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => ['t.term_id  = scms_term_cycle.term_id'],
                ],
            ])
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($term_cycle_all));
        return $this->response;
    }

    public function getSectionForPromotionAjax()
    {
        $this->autoRender = false;

        $level = $this->request->getQuery('level');
        $scms_sections = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $scms_sections
            ->find()
            ->where(['level_id' => $level])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($sections));
        return $this->response;
    }

    private function getMonthsFromSession($session_id)
    {
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['session_id' => $session_id])
            ->toArray();
        $months = array();
        if ($sessions[0]['start_date'] && $sessions[0]['end_date']) {
            $first_date = date("Y-m-d", strtotime($sessions[0]['start_date']));
            $last_day = date("Y-m-t", strtotime($sessions[0]['end_date']));
            $datediff = strtotime($last_day) - strtotime($first_date);
            $datediff = floor($datediff / (60 * 60 * 24));
            $months = array();
            $month_id = array();
            for ($i = 0; $i < $datediff + 1; $i++) {
                $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['name'] = date("F", strtotime($first_date . ' + ' . $i . 'day'));
                $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['id'] = (date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1;
                $i = $i + 28;
            }
        }
        return $months;
    }

    public function getMonthsFrromSessionAjax()
    {
        $this->autoRender = false;
        $session_id = $this->request->getQuery('session_id');
        $months = array_values($this->getMonthsFromSession($session_id));
        $this->response->type('application/json');
        $this->response->body(json_encode($months));
        return $this->response;
    }

    public function getMonthsForIndivisulVoucherAjax()
    {
        $this->autoRender = false;
        $sid = $this->request->getQuery('sid');
        $level_id = $this->request->getQuery('levelId');
        $session_id = $this->request->getQuery('sessionId');
        $where['scms_student_cycle.session_id'] = $session_id;
        $where['scms_student_cycle.level_id'] = $level_id;
        $where['sid'] = $sid;
        $student = $this->getStudentInfo($where);
        if (count($student)) {
            $return['student'] = $student[0];
            $months = $this->getMonthsFromSession($session_id);
            if (count($months)) {
                foreach ($months as $id => $month) {
                    $month['set_month'] = null;
                    $month['exist'] = null;
                    $months[$id] = $month;
                }
                $acc_voucher_create_log = TableRegistry::getTableLocator()->get('acc_voucher_create_log');
                $voucher_logs = $acc_voucher_create_log
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['session_id' => $session_id])
                    ->where(['level_id' => $level_id])
                    ->toArray();

                foreach ($voucher_logs as $voucher_log) {
                    $setmonths = json_decode($voucher_log['months']);
                    foreach ($setmonths as $setmonth) {
                        $months[$setmonth]['set_month'] = 1;
                    }
                }
                $acc_vouchers = TableRegistry::getTableLocator()->get('acc_vouchers');
                $vouchers = $acc_vouchers
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['session_id' => $session_id])
                    ->where(['level_id' => $level_id])
                    ->where(['deleted' => 0])
                    ->where(['sid' => $sid])
                    ->toArray();
                foreach ($vouchers as $voucher) {
                    $existmonths = json_decode($voucher['month_ids']);
                    if ($existmonths) {
                        foreach ($existmonths as $existmonth) {
                            $months[$existmonth]['exist'] = 1;
                        }
                    }
                }
                $return['month'] = array_values($months);
            } else {
                $return['month'] = -1;
            }
        } else {
            $return['student'] = -1;
        }
        $this->response->type('application/json');
        $this->response->body(json_encode($return));
        return $this->response;
    }

    public function getMonthsForVoucherAjax()
    {
        $this->autoRender = false;
        $level_id = $this->request->getQuery('levelId');
        $session_id = $this->request->getQuery('sessionId');

        $months = $this->getMonthsFromSession($session_id);
        if (count($months)) {

            $acc_voucher_create_log = TableRegistry::getTableLocator()->get('acc_voucher_create_log');
            $voucher_logs = $acc_voucher_create_log
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['session_id' => $session_id])
                ->where(['level_id' => $level_id])
                ->toArray();

            foreach ($voucher_logs as $voucher_log) {
                $setmonths = json_decode($voucher_log['months']);
                foreach ($setmonths as $setmonth) {
                    $months[$setmonth]['checkd'] = 1;
                }
            }
            $fees_khats = TableRegistry::getTableLocator()->get('acc_fees_khats');
            $khats_months = $fees_khats
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['session_id' => $session_id])
                ->where(['level_id' => $level_id])
                ->toArray();
            foreach ($khats_months as $khat) {
                $months[$khat['month_id']]['set'] = 1;
            }
            $months = array_values($months);
        } else {
            $months = -1;
        }
        $this->response->type('application/json');
        $this->response->body(json_encode($months));
        return $this->response;
    }

    private function getStudentInfo($where)
    {
        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $student = $scms_student_cycle
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where($where)
            ->select([
                'sid' => 'scms_students.sid',
                'name' => 'scms_students.name',
                'thumbnail' => 'scms_students.thumbnail',
                'level_name' => 'scms_levels.level_name',
                'section_name' => 'scms_sections.section_name',
                'group_name' => "scms_groups.group_name",
            ])
            ->join([
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_student_cycle.student_id  = scms_students.student_id',
                        'scms_student_cycle.session_id  = scms_students.session_id'
                    ]
                ],
                'scms_levels' => [
                    'table' => 'scms_levels',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_levels.level_id   = scms_students.level_id',
                    ]
                ],
                'scms_sections' => [
                    'table' => 'scms_sections',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_sections.section_id   = scms_student_cycle.section_id',
                    ]
                ],
                'scms_groups' => [
                    'table' => 'scms_groups', // from which table data is calling
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_groups.group_id  = scms_student_cycle.group_id',
                    ]
                ],
            ])
            ->toArray();
        return $student;
    }

    public function getPurposeAjax()
    {
        $this->autoRender = false;
        $sid = $this->request->getQuery('sid');
        $session_id = $this->request->getQuery('session_id');
        $month_ids = $this->request->getQuery('month_ids');
        $filter_purposes = array();
        $acc_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $acc_purposes
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['parent' => 3])
            ->toArray();
        foreach ($purposes as $purpose) {
            $filter_purposes[$purpose['purpose_id']]['purpose_name'] = $purpose['purpose_name'];
            $filter_purposes[$purpose['purpose_id']]['purpose_id'] = $purpose['purpose_id'];
            $filter_purposes[$purpose['purpose_id']]['amount'] = '';
        }

        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $student = $scms_student_cycle
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['scms_student_cycle.session_id' => $session_id])
            ->where(['scms_students.sid' => $sid])
            ->join([
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_student_cycle.student_id  = scms_students.student_id'
                    ]
                ],
            ])
            ->toArray();

        $filter_purposes[77]['amount'] = $this->calculate_penalty($month_ids, $session_id);
        $id = array();
        foreach ($month_ids as $month_id) {
            $khat = $this->find_Khats_months_for_studnet($student[0], $month_id);
            if ($khat) {
                $id[] = $khat[0]['id'];
            }
        }
        $acc_fees_khat_purpose_amount = TableRegistry::getTableLocator()->get('acc_fees_khat_purpose_amount');
        $purpose_amounts_query = $acc_fees_khat_purpose_amount
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['fees_khat_id IN' => $id])
            ->toArray();
        $purpose_amounts = array();
        foreach ($purpose_amounts_query as $purpose) {
            if ($student[0]['tuition_fee_status'] && $purpose['scholarship']) {
                $purpose['amount'] = $purpose['amount'] - ($purpose['amount'] * $student[0]['tuition_fee_status']) / 100;
            }
            if (isset($purpose_amounts[$purpose['purpose_id']])) {
                $purpose_amounts[$purpose['purpose_id']]['amount'] = $purpose['amount'] + $purpose_amounts[$purpose['purpose_id']]['amount'];
            } else {
                $purpose_amounts[$purpose['purpose_id']] = $purpose;
            }
        }

        foreach ($purpose_amounts as $purpose_amount) {
            if ($filter_purposes[$purpose_amount['purpose_id']]['amount']) {
                $filter_purposes[$purpose_amount['purpose_id']]['amount'] = $filter_purposes[$purpose_amount['purpose_id']]['amount'] + $purpose_amount['amount'];
            } else {
                $filter_purposes[$purpose_amount['purpose_id']]['amount'] = $purpose_amount['amount'];
            }
        }
        $where['student_cycle_id'] = $student[0]['student_cycle_id'];
        $where['level_id'] = $student[0]['level_id'];
        $where['session_id'] = $student[0]['session_id'];
        $where['month_id IN'] = $month_ids;
        //additional fees start
        $additional_fees = $this->getStudnetAdditionalFess($where);
        foreach ($additional_fees as $additional_fee) {
            if ($filter_purposes[$additional_fee['purpose_id']]['amount']) {
                $filter_purposes[$additional_fee['purpose_id']]['amount'] = $filter_purposes[$additional_fee['purpose_id']]['amount'] + $additional_fee['fees_value'];
            } else {
                $filter_purposes[$additional_fee['purpose_id']]['amount'] = $additional_fee['fees_value'];
            }
        }
        //additional fees end
        $filter_purposes = array_values($filter_purposes);
        $this->response->type('application/json');
        $this->response->body(json_encode($filter_purposes));
        return $this->response;
    }

    private function getStudnetAdditionalFess($where)
    {
        $additional_fees = TableRegistry::getTableLocator()->get('acc_student_additional_fees_cycle');
        $additionalFees = $additional_fees->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where($where)
            ->select([
                'month_id' => 'acc_additional_fees_cycle.month_id',
                'additional_fees_id' => 'acc_additional_fees_cycle.additional_fees_id',
                'purpose_id' => 'acc_additional_fees.purpose_id',
            ])->join([
                    'acc_additional_fees_cycle' => [
                        'table' => 'acc_additional_fees_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_additional_fees_cycle.id = acc_student_additional_fees_cycle.additional_fees_cycle_id'
                        ]
                    ],
                    'acc_additional_fees' => [
                        'table' => 'acc_additional_fees',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_additional_fees.id = acc_additional_fees_cycle.additional_fees_id'
                        ]
                    ],
                ])
            ->toArray();
        return $additionalFees;
    }

    public function getAttendanceSectionAjax()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');

        $where['level_id'] = $Level_id;
        $shift_id = $this->request->getQuery('shift_id');
        if ($shift_id) {
            $where['shift_id'] = $shift_id;
        }
        $attendance_type = $this->get_settings_value('Attendance.Type');
        $employee = $this->get_login_employee();
        if ($attendance_type == 'day' && $employee['role_id'] != 1) {
            $session_id = $_GET['session_id'];
            $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $permission = $employees_permission
                ->find()
                ->where(['employee_id' => $employee['employee_id']])
                ->where(['session_id' => $session_id])
                ->where(['level_id' => $Level_id])
                ->where(['type' => 'attendance'])
                ->where(['course_id is NULL'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
            $sections = array();
            if (count($permission)) {
                foreach ($permission as $per) {
                    $section_ids[] = $per['section_id'];
                }
                $section = TableRegistry::getTableLocator()->get('scms_sections');
                $sections = $section
                    ->find()
                    ->where($where)
                    ->where(['section_id IN' => $section_ids])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
            }
        } else {
            $section = TableRegistry::getTableLocator()->get('scms_sections');
            $sections = $section
                ->find()
                ->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        }
        $this->response->type('application/json');
        $this->response->body(json_encode($sections));
        return $this->response;
    }

    private function get_login_employee()
    {
        $users = TableRegistry::getTableLocator()->get('users');
        $user = $users
            ->find()
            ->where(['id' => $this->Auth->user('id')])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'employee_id' => 'employee.employee_id',
            ])
            ->join([
                'employee' => [
                    'table' => 'employee',
                    'type' => 'LEFT',
                    'conditions' => ['employee.user_id = users.id'],
                ],
            ])
            ->toArray();
        return $user[0];
    }

    public function getAttandenceSubjectAjax()
    {
        $this->autoRender = false;

        $Level_id = $this->request->getQuery('level_id');
        $session_id = $this->request->getQuery('session_id');
        $term_cycle_id = $this->request->getQuery('term_cycle_id');
        $section_id = $this->request->getQuery('section_id');

        $attendance_type = $this->get_settings_value('Attendance.Type');
        $employee = $this->get_login_employee();
        if ($attendance_type != 'day' && $employee['role_id'] != 1) {
            $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $permission = $employees_permission
                ->find()
                ->where(['employee_id' => $employee['employee_id']])
                ->where(['session_id' => $session_id])
                ->where(['level_id' => $Level_id])
                ->where(['section_id' => $section_id])
                ->where(['type' => 'attendance'])
                ->where(['course_id is Not NULL'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
            $courses = array();
            if (count($permission)) {
                foreach ($permission as $per) {
                    $course_ids[] = $per['course_id'];
                }
                $course = TableRegistry::getTableLocator()->get('scms_courses');
                $courses = $course
                    ->find()
                    ->where(['cc.session_id' => $session_id])
                    ->where(['cc.level_id' => $Level_id])
                    ->where(['tcc.term_cycle_id' => $term_cycle_id])
                    ->where(['scms_courses.course_id IN' => $course_ids])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->select([
                        'courses_cycle_id' => 'tcc.courses_cycle_id',
                    ])
                    ->join([
                        'cc' => [
                            'table' => 'scms_courses_cycle',
                            'type' => 'LEFT',
                            'conditions' => ['cc.course_id  = scms_courses.course_id'],
                        ],
                    ])
                    ->join([
                        'tcc' => [
                            'table' => 'scms_term_course_cycle',
                            'type' => 'LEFT',
                            'conditions' => ['tcc.courses_cycle_id  = cc.courses_cycle_id'],
                        ],
                    ])
                    ->toArray();
            }
        } else {
            $course = TableRegistry::getTableLocator()->get('scms_courses');
            $courses = $course
                ->find()
                ->where(['cc.session_id' => $session_id])
                ->where(['cc.level_id' => $Level_id])
                ->where(['tcc.term_cycle_id' => $term_cycle_id])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'courses_cycle_id' => 'tcc.courses_cycle_id',
                ])
                ->join([
                    'cc' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['cc.course_id  = scms_courses.course_id'],
                    ],
                ])
                ->join([
                    'tcc' => [
                        'table' => 'scms_term_course_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['tcc.courses_cycle_id  = cc.courses_cycle_id'],
                    ],
                ])
                ->toArray();
        }

        $filter_course = array();
        foreach ($courses as $key => $course) {
            $filter_course[$key]['courses_cycle_id'] = $course['courses_cycle_id'];
            $filter_course[$key]['course_name'] = $course['course_name'];
            $filter_course[$key]['course_id'] = $course['course_id'];
        }
        $this->response->type('application/json');
        $this->response->body(json_encode($filter_course));
        return $this->response;
    }

    public function getResultSubjectAjax()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $session_id = $this->request->getQuery('session_id');
        $term_cycle_id = $this->request->getQuery('term_cycle_id');
        $section_id = $this->request->getQuery('section_id');
        $type = $this->request->getQuery('type');

        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles) || $type == false) {
            $course = TableRegistry::getTableLocator()->get('scms_courses');
            $courses = $course
                ->find()
                ->where(['cc.session_id' => $session_id])
                ->where(['cc.level_id' => $Level_id])
                ->where(['tcc.term_cycle_id' => $term_cycle_id])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'courses_cycle_id' => 'tcc.courses_cycle_id',
                ])
                ->join([
                    'cc' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['cc.course_id  = scms_courses.course_id'],
                    ],
                ])
                ->join([
                    'tcc' => [
                        'table' => 'scms_term_course_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['tcc.courses_cycle_id  = cc.courses_cycle_id'],
                    ],
                ])
                ->toArray();
        } else {
            $id = $this->Auth->user('id');
            $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $permission = $employees_permission->find()
                ->where(['user_id' => $id])
                ->where(['employees_permission.type' => $type])
                ->where(['session_id' => $session_id])
                ->where(['level_id' => $Level_id])
                ->where(['section_id' => $section_id])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->join([
                    'employee' => [
                        'table' => 'employee',
                        'type' => 'INNER',
                        'conditions' => [
                            'employee.employee_id = employees_permission.employee_id'
                        ]
                    ],
                ])
                ->toArray();
            if (count($permission)) {
                foreach ($permission as $per) {
                    $course_ids[] = $per['course_id'];
                }
                $course = TableRegistry::getTableLocator()->get('scms_courses');
                $courses = $course
                    ->find()
                    ->where(['cc.session_id' => $session_id])
                    ->where(['cc.level_id' => $Level_id])
                    ->where(['tcc.term_cycle_id' => $term_cycle_id])
                    ->where(['scms_courses.course_id IN' => $course_ids])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->select([
                        'courses_cycle_id' => 'tcc.courses_cycle_id',
                    ])
                    ->join([
                        'cc' => [
                            'table' => 'scms_courses_cycle',
                            'type' => 'LEFT',
                            'conditions' => ['cc.course_id  = scms_courses.course_id'],
                        ],
                    ])
                    ->join([
                        'tcc' => [
                            'table' => 'scms_term_course_cycle',
                            'type' => 'LEFT',
                            'conditions' => ['tcc.courses_cycle_id  = cc.courses_cycle_id'],
                        ],
                    ])
                    ->toArray();
            } else {
                $courses = array();
            }
        }
        $filter_course = array();
        foreach ($courses as $key => $course) {
            $filter_course[$key]['courses_cycle_id'] = $course['courses_cycle_id'];
            $filter_course[$key]['course_name'] = $course['course_name'];
            $filter_course[$key]['course_id'] = $course['course_id'];
        }
        $this->response->type('application/json');
        $this->response->body(json_encode($filter_course));
        return $this->response;
    }

    public function getTimesheetSectionAjax()
    {
        $this->autoRender = false;
        $Level_id = $this->request->getQuery('level_id');
        $session_id = $this->request->getQuery('session_id');
        $shift_id = $this->request->getQuery('shift_id');
        $section_id = $this->request->getQuery('section_id');
        $day = strtolower(date('l', time() + 6 * 3600));

        $scms_timesheet_section = TableRegistry::getTableLocator()->get('scms_timesheet_section');
        $timesheet_sections = $scms_timesheet_section
            ->find()
            ->where(['scms_timesheet_section.shift_id' => $shift_id])
            ->where(['section_id' => $section_id])
            ->where(['session_id' => $session_id])
            ->where(['level_id' => $Level_id])
            ->where(['day' => $day])
            ->order(['order_by' => 'ASC'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'course_name' => "scms_courses.course_name",
                'name' => "employee.name",
            ])
            ->join([
                'scms_courses' => [
                    'table' => 'scms_courses',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_timesheet_section.course_id = scms_courses.course_id'
                    ]
                ],
                'employee' => [
                    'table' => 'employee',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_timesheet_section.employee_id = employee.employee_id'
                    ]
                ],
                'scms_timesheet' => [
                    'table' => 'scms_timesheet',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_timesheet_section.scms_timesheet_id = scms_timesheet.scms_timesheet_id'
                    ]
                ],
            ])
            ->toArray();
        $filter_timesheet_sections = array();
        $timesheet_section_ids = array();
        foreach ($timesheet_sections as $timesheet_section) {
            $filter_timesheet_sections[$timesheet_section['timesheet_section_id']] = $timesheet_section;
            $timesheet_section_ids[] = $timesheet_section['timesheet_section_id'];
        }


        $scms_timesheet_live_class = TableRegistry::getTableLocator()->get('scms_timesheet_live_class');
        $live_class = $scms_timesheet_live_class
            ->find()
            ->where(['timesheet_section_id IN' => $timesheet_section_ids])
            ->where(['date' => date("Y-m-d")])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        foreach ($live_class as $live) {
            unset($filter_timesheet_sections[$live['timesheet_section_id']]);
        }
        $timesheet_section = array_values($filter_timesheet_sections);
        $this->response->type('application/json');
        $this->response->body(json_encode($timesheet_section));
        return $this->response;
    }

    //new refactor cycle 
    public function getTermCycleAjax()
    {
        $this->autoRender = false;
        $level_id = $this->request->getQuery('level_id');
        $session_id = $this->request->getQuery('session_id');
        $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $term_cycle = $scms_term_cycle
            ->find()
            ->where(['scms_term_cycle.level_id' => $level_id])
            ->where(['scms_term_cycle.session_id' => $session_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'term_name' => "scms_term.term_name",
            ])
            ->join([
                'scms_term' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_term_cycle.term_id  = scms_term.term_id '
                    ]
                ],
            ])
            ->toArray();
        $this->response->type('application/json');
        $this->response->body(json_encode($term_cycle));
        return $this->response;
    }
}
