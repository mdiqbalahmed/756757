<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class RoutineController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function index() {
        if ($this->request->is('post')) {
            $level = TableRegistry::getTableLocator()->get('scms_levels');
            $request_data = $this->request->getData();
            $this->set('data', $request_data);
            $day = strtolower(date('l', strtotime($request_data['date'])));
            $this->set('day', $day);
            $scms_timesheet = TableRegistry::getTableLocator()->get('scms_timesheet');
            $timesheets = $scms_timesheet
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['shift_id' => $request_data['shift_id']])
                    ->order(['order_by' => 'ASC'])
                    ->toArray();
            $filter_timesheets = array();
            foreach ($timesheets as $timesheet) {
                $filter_timesheets[$timesheet['scms_timesheet_id']] = $timesheet;
            }

            $this->set('timesheets', $timesheets);

            $levels = $level
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
            $filter_levels = array();
            foreach ($levels as $level) {
                $filter_levels[$level['level_id']] = $level;
            }
            $scms_sections = TableRegistry::getTableLocator()->get('scms_sections');
            $sections = $scms_sections
                    ->find()
                    ->where(['shift_id' => $request_data['shift_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
            $filter_section = array();
            $section_ids = array();
            foreach ($sections as $section) {
                $section['timesheet'] = $filter_timesheets;
                $filter_section[$section['section_id']] = $section;
                $section_ids[] = $section['section_id'];
            }
            $scms_timesheet_section = TableRegistry::getTableLocator()->get('scms_timesheet_section');
            $timesheet_sections = $scms_timesheet_section
                    ->find()
                    ->where(['scms_timesheet_section.shift_id' => $request_data['shift_id']])
                    ->where(['section_id IN' => $section_ids])
                    ->where(['session_id' => $request_data['session_id']])
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
            $timesheet_section_ids = array();
            foreach ($timesheet_sections as $timesheet_section) {
                $timesheet_section_ids[] = $timesheet_section['timesheet_section_id'];
            }
            $scms_timesheet_live_class = TableRegistry::getTableLocator()->get('scms_timesheet_live_class');
            $live_class = $scms_timesheet_live_class
                    ->find()
                    ->select([
                        'name' => "employee.name",
                    ])
                    ->where(['timesheet_section_id IN' => $timesheet_section_ids])
                    ->where(['date' => $request_data['date']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->join([
                        'employee' => [
                            'table' => 'employee',
                            'type' => 'LEFT',
                            'conditions' => [
                                'scms_timesheet_live_class.user_id = employee.user_id'
                            ]
                        ],
                    ])
                    ->toArray();
            foreach ($live_class as $class) {
                $filter_class[$class['timesheet_section_id']] = $class;
            }
            foreach ($timesheet_sections as $timesheet_section) {
                if (isset($timesheet_section['course_name'])) {
                    $name = $timesheet_section['course_name'];
                }
                if (isset($timesheet_section['name'])) {
                    if (isset($name)) {
                        $name = $name . '<br>' . $timesheet_section['name'];
                    } else {
                        $name = $timesheet_section['name'];
                    }
                }
                if (isset($filter_class[$timesheet_section['timesheet_section_id']])) {
                    $title = "Teacher: " . $filter_class[$timesheet_section['timesheet_section_id']]['name'] . " Start: " . $filter_class[$timesheet_section['timesheet_section_id']]['start_time'];
                    if ($filter_class[$timesheet_section['timesheet_section_id']]['end_time']) {
                        $title = $title . " End: " . $filter_class[$timesheet_section['timesheet_section_id']]['end_time'];
                        $name = '<div style=background-color:#44f261; title="' . $title . '">' . $name . '</div>';
                    } else {
                        $title = $title . " End: Running";
                        $name = '<div style=background-color:#f2a530; title="' . $title . '">' . $name . '</div>';
                    }
                }
                $filter_section[$timesheet_section['section_id']]['timesheet'][$timesheet_section['scms_timesheet_id']]['routine'][] = $name;
            }

            foreach ($filter_section as $section) {
                $filter_levels[$section['level_id']]['section'][$section['section_id']] = $section;
            }
            $this->set('levels', $filter_levels);
            $shift = TableRegistry::getTableLocator()->get('hr_shift');
            $shifts = $shift
                    ->find()
                    ->where(['shift_id' => $request_data['shift_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
            $this->set('shifts', $shifts);

            $session = TableRegistry::getTableLocator()->get('scms_sessions');
            $sessions = $session->find()->order(['session_name' => 'DESC'])->where(['session_id' => $request_data['session_id']])->enableAutoFields(true)->enableHydration(false)->toArray();
            $this->set('sessions', $sessions);
        }

        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        $this->set('shifts', $shifts);
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('sessions', $sessions);
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
            $shift = TableRegistry::getTableLocator()->get('hr_shift');
            $query = $shift->query();
            $query->insert(['shift_name', 'monday_in_time', 'monday_out_time', 'tuesday_in_time', 'tuesday_out_time', 'wednesday_in_time', 'wednesday_out_time', 'thursday_in_time', 'thursday_out_time', 'friday_in_time', 'friday_out_time', 'saturday_in_time', 'saturday_out_time', 'sunday_in_time', 'sunday_out_time', 'break_out_time', 'break_in_time'])
                    ->values($request_data)
                    ->execute();
            //Set Flash
            $this->Flash->success('Shift Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'shifts']);
        }
    }

    public function editShift($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $shift = TableRegistry::getTableLocator()->get('hr_shift');
            $query = $shift->query();
            $query
                    ->update()
                    ->set($this->request->getData())
                    ->where(['shift_id' => $data['shift_id']])
                    ->execute();
            //Set Flash
            $this->Flash->info('Shift Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'shifts']);
        }
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift->find()->where(['shift_id' => $id])->toArray();
        $this->set('shifts', $shifts);
    }

    public function timesheet($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            if (isset($data['holiday'])) {
                $shift_data['holidays'] = json_encode($data['holiday']);
            } else {
                $shift_data['holidays'] = null;
            }
            $shift = TableRegistry::getTableLocator()->get('hr_shift');
            $query = $shift->query();
            $query->update()->set($shift_data)->where(['shift_id' => $id])->execute();
            $this->delete_update_timesheet($data);
            $insert_rows = array();
            $single_row['shift_id'] = $data['shift_id'];
            if (isset($data['name'])) {
                $order = $this->get_order_for_day($data['shift_id']);
                foreach ($data['name'] as $key => $name) {
                    $single_row['order_by'] = $order + 1;
                    $order++;
                    $single_row['name'] = $name;
                    $single_row['in_time'] = $data['in'][$key];
                    $single_row['out_time'] = $data['out'][$key];
                    $insert_rows[] = $single_row;
                }
            }
            if (count($insert_rows)) {
                $scms_timesheet = TableRegistry::getTableLocator()->get('scms_timesheet');
                $columns = array_keys($insert_rows[0]);
                $insertQuery = $scms_timesheet->query();
                $insertQuery->insert($columns);
                // you must always alter the values clause AFTER insert
                $insertQuery->clause('values')->values($insert_rows);
                $insertQuery->execute();
            }
            $this->Flash->info('Timeshift Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            $this->redirect(['action' => 'timesheet', $id]);
        }
        $scms_timesheet = TableRegistry::getTableLocator()->get('scms_timesheet');
        $timesheets = $scms_timesheet->find()->enableAutoFields(true)->enableHydration(false)->where(['shift_id' => $id])->order(['order_by' => 'ASC'])->toArray();
        $this->set('timesheets', $timesheets);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift->find()->where(['shift_id' => $id])->toArray();
        $days['Monday'] = 'Monday';
        $days['Tuesday'] = 'Tuesday';
        $days['Wednesday'] = 'Wednesday';
        $days['Thursday'] = 'Thursday';
        $days['Friday'] = 'Friday';
        $days['Saturday'] = 'Saturday';
        $days['Sunday'] = 'Sunday';
        $this->set('days', $days);
        $this->set('shifts', $shifts);
        if ($shifts[0]->holidays) {
            $holiday = json_decode($shifts[0]->holidays);
        } else {
            $holiday = array();
        }
        $this->set('holiday', $holiday);
    }

    private function delete_update_timesheet($data) {
        $update_data = array();
        $scms_timesheet_ids = array();
        if (isset($data['set_id'])) {
            foreach ($data['set_id'] as $key => $id) {
                $scms_timesheet_ids[] = $id;
                $single_row['scms_timesheet_id'] = $id;
                $single_row['name'] = $data['set_name'][$key];
                $single_row['in_time'] = $data['set_in'][$key];
                $single_row['out_time'] = $data['set_out'][$key];
                $update_data[] = $single_row;
            }
        }
        $scms_timesheet = TableRegistry::getTableLocator()->get('scms_timesheet');
        $timesheets = $scms_timesheet->find()->enableAutoFields(true)->enableHydration(false)->where(['shift_id' => $data['shift_id']])->toArray();
        $ids = array();
        foreach ($timesheets as $timesheet) {
            $ids[] = $timesheet['scms_timesheet_id'];
        }
        $delete_ids = array_diff($ids, $scms_timesheet_ids);
        if (count($delete_ids)) {
            $query = $scms_timesheet->query();
            $query->delete()->where(['scms_timesheet_id IN' => $delete_ids])->execute();
            $scms_timesheet_section = TableRegistry::getTableLocator()->get('scms_timesheet_section');
            $query = $scms_timesheet_section->query();
            $query->delete()->where(['scms_timesheet_id IN' => $delete_ids])->execute();
        }
        foreach ($update_data as $update) {
            $query = $scms_timesheet->query();
            $query->update()->set($update)->where(['scms_timesheet_id' => $update['scms_timesheet_id']])->execute();
        }
    }

    private function get_order_for_day($shift_id) {
        $scms_timesheet = TableRegistry::getTableLocator()->get('scms_timesheet');
        $query = $scms_timesheet->find()->where(['shift_id' => $shift_id]);
        $query->select([
            'order' => $query->func()->max('order_by')
        ])->enableAutoFields(true)->enableHydration(false);
        foreach ($query as $row) {
            if ($row['order']) {
                return $row['order'];
            } else {
                return 1;
            }
        }
    }

    private function get_section_timesheet($where) {
        $scms_timesheet_section = TableRegistry::getTableLocator()->get('scms_timesheet_section');
        $timesheet_section = $scms_timesheet_section->find()->enableAutoFields(true)->enableHydration(false)->where($where)->toArray();
        return $timesheet_section;
    }

    public function setRoutine() {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            if (isset($data['save'])) {
                $updade_get_routines = array();
                $updade_get_routine_ids = array();
                $new_get_routines = array();
                $delete_timesheet_section_id = array();
                $single_get_routine['session_id'] = $data['session_id'];
                $single_get_routine['shift_id'] = $data['shift_id'];
                $single_get_routine['level_id'] = $data['level_id'];
                $single_get_routine['section_id'] = $data['section_id'];
                $where['level_id'] = $data['level_id'];
                $where['session_id'] = $data['session_id'];
                $where['shift_id'] = $data['shift_id'];
                $where['section_id'] = $data['section_id'];
                $timesheet_section = $this->get_section_timesheet($where);
                foreach ($data['course'] as $day => $single_day) {
                    $single_get_routine['day'] = $day;
                    foreach ($single_day as $scms_timesheet_id => $courses) {
                        $single_get_routine['scms_timesheet_id'] = $scms_timesheet_id;
                        foreach ($courses as $key => $course) {
                            $single_get_routine['course_id'] = $course;
                            $single_get_routine['employee_id'] = $data['teacher'][$day][$scms_timesheet_id][$key];
                            if (isset($data['timesheet_section_id'][$day][$scms_timesheet_id][$key])) {
                                $single_get_routine['timesheet_section_id'] = $data['timesheet_section_id'][$day][$scms_timesheet_id][$key];
                                if ($course || $single_get_routine['employee_id']) {
                                    $updade_get_routines[] = $single_get_routine;
                                    $updade_get_routine_ids[] = $single_get_routine['timesheet_section_id'];
                                    unset($single_get_routine['timesheet_section_id']);
                                } else {
                                    $delete_timesheet_section_id[] = $single_get_routine['timesheet_section_id'];
                                    unset($single_get_routine['timesheet_section_id']);
                                }
                            } else {
                                if ($course || $single_get_routine['employee_id']) {
                                    $new_get_routines[] = $single_get_routine;
                                    unset($single_get_routine['timesheet_section_id']);
                                }
                            }
                        }
                    }
                }
                $previous_ids = array();
                foreach ($timesheet_section as $section) {
                    $previous_ids[] = $section['timesheet_section_id'];
                }
                $delete_timesheet_section_id = array_merge($delete_timesheet_section_id, array_diff($previous_ids, $updade_get_routine_ids));
                $scms_timesheet_section = TableRegistry::getTableLocator()->get('scms_timesheet_section');
                if (count($updade_get_routines)) {
                    foreach ($updade_get_routines as $updade_get_routine) {
                        $query = $scms_timesheet_section->query();
                        $query
                                ->update()
                                ->set($updade_get_routine)
                                ->where(['timesheet_section_id' => $updade_get_routine['timesheet_section_id']])
                                ->execute();
                    }
                }
                if (count($delete_timesheet_section_id)) {
                    $query = $scms_timesheet_section->query();
                    $query->delete()->where(['timesheet_section_id IN' => $delete_timesheet_section_id])->execute();
                }
                if (count($new_get_routines)) {
                    $columns = array_keys($new_get_routines[0]);
                    $insertQuery = $scms_timesheet_section->query();
                    $insertQuery->insert($columns);
                    $insertQuery->clause('values')->values($new_get_routines);
                    $insertQuery->execute();
                }
//Set Flash
                $this->Flash->success('Timesheet Updated Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'setRoutine']);
            }
            $scms_timesheet = TableRegistry::getTableLocator()->get('scms_timesheet');
            $timesheets = $scms_timesheet->find()->enableAutoFields(true)->enableHydration(false)->where(['shift_id' => $data['shift_id']])->order(['order_by' => 'ASC'])->toArray();
            foreach ($timesheets as $timesheet) {
                $timesheet['previous_section_timesheet'] = array();
                $filter_timesheets[$timesheet['scms_timesheet_id']] = $timesheet;
            }
            $days['Monday'] = 'Monday';
            $days['Tuesday'] = 'Tuesday';
            $days['Wednesday'] = 'Wednesday';
            $days['Thursday'] = 'Thursday';
            $days['Friday'] = 'Friday';
            $days['Saturday'] = 'Saturday';
            $days['Sunday'] = 'Sunday';
            $shift = TableRegistry::getTableLocator()->get('hr_shift');
            $shifts = $shift->find()->where(['shift_id' => $data['shift_id']])->toArray();
            if ($shifts[0]->holidays) {
                $holidays = json_decode($shifts[0]->holidays);
                foreach ($holidays as $holiday) {
                    unset($days[$holiday]);
                }
            }
            $filter_days = array();
            foreach ($days as $key => $day) {
                $filter_days[$key]['name'] = $day;
                $filter_days[$key]['timesheets'] = $filter_timesheets;
            }
            $where['level_id'] = $data['level_id'];
            $where['session_id'] = $data['session_id'];
            $where['shift_id'] = $data['shift_id'];
            $where['section_id'] = $data['section_id'];
            $timesheet_section = $this->get_section_timesheet($where);
            foreach ($timesheet_section as $section) {
                if (isset($filter_days[$section['day']])) {
                    $filter_days[$section['day']]['timesheets'][$section['scms_timesheet_id']]['previous_section_timesheet'][] = $section;
                }
            }
            $this->set('days', $filter_days);
            $this->set('set_data', $data);
            $session = TableRegistry::getTableLocator()->get('scms_sessions');
            $sessions = $session->find()->enableAutoFields(true)->enableHydration(false)->where(['session_id' => $data['session_id']])->toArray();

            $level = TableRegistry::getTableLocator()->get('scms_levels');
            $levels = $level->find()->enableAutoFields(true)->enableHydration(false)->where(['level_id' => $data['level_id']])->toArray();

            $scms_sections = TableRegistry::getTableLocator()->get('scms_sections');
            $sections = $scms_sections->find()->where(['section_id' => $data['section_id']])->enableAutoFields(true)->enableHydration(false)->toArray();
            $head = 'Set Digital Routine for Session: ' . $sessions[0]['session_name'] . ' Level: ' . $levels[0]['level_name'] . ' Shift: ' . $shifts[0]['shift_name'] . ' Section: ' . $sections[0]['section_name'];
            $this->set('head', $head);
            $scms_courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
            $courses = $scms_courses_cycle->find()->enableAutoFields(true)->enableHydration(false)->select([
                        'course_name' => "scms_courses.course_name",
                    ])->where(['level_id' => $data['level_id']])->where(['session_id' => $data['session_id']])->join([
                        'scms_courses' => [
                            'table' => 'scms_courses',
                            'type' => 'LEFT',
                            'conditions' => [
                                'scms_courses_cycle.course_id = scms_courses.course_id'
                            ]
                        ],
                    ])->toArray();
            $this->set('courses', $courses);
            $user = TableRegistry::getTableLocator()->get('employee');
            $users = $user->find()->enableAutoFields(true)->enableHydration(false)->where(['usr.status' => '1'])->order(['employee_order' => 'ASC'])->join([
                        'usr' => [
                            'table' => 'users',
                            'type' => 'LEFT',
                            'conditions' => [
                                'usr.id = employee.user_id '
                            ]
                        ],
                    ])->toArray();
            $this->set('users', $users);
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();

        $this->set('levels', $levels);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift->find()->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('shifts', $shifts);
    }

    public function classRoutine() {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $scms_timesheet = TableRegistry::getTableLocator()->get('scms_timesheet');
            $timesheets = $scms_timesheet->find()->enableAutoFields(true)->enableHydration(false)->where(['shift_id' => $data['shift_id']])->order(['order_by' => 'ASC'])->toArray();
            $this->set('timesheets', $timesheets);
            $this->set('data', $data);
            $filter_timesheets = array();
            foreach ($timesheets as $timesheet) {
                $filter_timesheets[$timesheet['scms_timesheet_id']] = $timesheet;
            }
            $days['Monday']['name'] = 'Monday';
            $days['Tuesday']['name'] = 'Tuesday';
            $days['Wednesday']['name'] = 'Wednesday';
            $days['Thursday']['name'] = 'Thursday';
            $days['Friday']['name'] = 'Friday';
            $days['Saturday']['name'] = 'Saturday';
            $days['Sunday']['name'] = 'Sunday';
            foreach ($days as $key => $day) {
                $days[$key]['count'] = 0;
                $days[$key]['timesheets'] = $filter_timesheets;
            }
            $scms_timesheet_section = TableRegistry::getTableLocator()->get('scms_timesheet_section');
            $timesheet_sections = $scms_timesheet_section
                    ->find()
                    ->where(['scms_timesheet_section.shift_id' => $data['shift_id']])
                    ->where(['session_id' => $data['session_id']])
                    ->where(['scms_timesheet_section.level_id' => $data['level_id']])
                    ->where(['section_id' => $data['section_id']])
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

            foreach ($timesheet_sections as $timesheet_section) {
                if (isset($timesheet_section['course_name'])) {
                    $name = $timesheet_section['course_name'];
                }
                if (isset($timesheet_section['name'])) {
                    if (isset($name)) {
                        $name = $name . '<br>' . $timesheet_section['name'];
                    } else {
                        $name = $timesheet_section['name'];
                    }
                }
                $days[$timesheet_section['day']]['count']++;
                $days[$timesheet_section['day']]['timesheets'][$timesheet_section['scms_timesheet_id']]['routine'][] = $name;
            }
            $this->set('days', $days);
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();

        $this->set('levels', $levels);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift->find()->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('shifts', $shifts);
    }

}
