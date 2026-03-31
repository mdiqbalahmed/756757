<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class AdmitController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function index() {
        if (!empty($this->request->data)) {
            $this->layout = 'report';
            $request_data = $this->request->getData();
            // echo "<pre>";
            // print_r($request_data);die;
            if ($request_data['shift_id']) {
                $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
            }
            if ($request_data['level_id']) {
                $where['scms_student_cycle.level_id'] = $request_data['level_id'];
            }
            if ($request_data['section_id']) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if ($request_data['session_id']) {
                $where['scms_student_cycle.session_id'] = $request_data['session_id'];
            }

            $term = TableRegistry::getTableLocator()->get('scms_term_cycle');
            $terms = $term->find()
                            ->where(['scms_term_cycle.term_cycle_id' => $request_data['term_cycle_id']])
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->select([
                                'term' => "t.term_name",
                            ])
                            ->join([
                                't' => [
                                    'table' => 'scms_term',
                                    'type' => 'INNER',
                                    'conditions' => [
                                        't.term_id = scms_term_cycle.term_id'
                                    ]
                                ],
                            ])->toArray();
            $this->set('terms', $terms[0]['term']);

            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $scms_student_cycles = $scms_student_cycle->find()->where($where)
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->select([
                                'name' => "s.name",
                                'gender' => "s.gender",
                                'sid' => "s.sid",
                                'mobile' => 's.mobile',
                                'thumbnail' => 's.thumbnail',
                                'status' => "s.status",
                                'shift_name' => "shift.shift_name",
                                'level_name' => "level.level_name",
                                'section_name' => "section.section_name",
                                'session_name' => "session.session_name"
                            ])
                            ->order(['scms_student_cycle.level_id' => 'ASC', 'scms_student_cycle.section_id' => 'ASC', 'roll' => 'ASC'])
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
                                'session' => [
                                    'table' => 'scms_sessions',
                                    'type' => 'INNER',
                                    'conditions' => [
                                        'session.session_id  = scms_student_cycle.session_id'
                                    ]
                                ],
                            ])->toArray();
            if (count($scms_student_cycles) == 0) {
                $this->Flash->error('No Student Found', [
                    'key' => 'negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'index']);
            }
            $student = [];
            $student_cycle_ids = [];
            $date = [];
            foreach ($scms_student_cycles as $scms_student_cycle) {
                $student_cycle_id = $scms_student_cycle['student_cycle_id'];
                $scms_student_cycle['count'] = 0;
                $scms_student_cycle['percentage'] = 0;
                $student[$student_cycle_id] = $scms_student_cycle;
                $student_cycle_ids[] = $student_cycle_id;
            }

            $attendance = TableRegistry::getTableLocator()->get('scms_attendance');
            $attendances = $attendance->find()
                    ->where(['scms_attendance.student_cycle_id IN' => $student_cycle_ids])
                    ->where(['scms_attendance.term_cycle_id' => $request_data['term_cycle_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();

            foreach ($attendances as $attendance) {
                $date[(date('Y-m-d', strtotime($attendance['date'])))] = 1;

                $student[$attendance['student_cycle_id']]['count']++;
            }

            foreach ($student as $key => $stu) {
                if ($stu['count'] && count($date)) {
                    $student[$key]['percentage'] = ($student[$key]['count'] / count($date)) * 100;
                }
            }
            $this->set('total', count($date));
            $this->set('students', $student);
            $this->render('/reports/admit_card');
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
                ->find()
                ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        $this->set('groups', $groups);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        $this->set('shifts', $shifts);
    }

    public function slip() {
        if (!empty($this->request->data)) {
            $this->layout = 'report';
            $request_data = $this->request->getData();

            $level = $request_data['level_id'];
            $section = $request_data['section_id'];
            $session = $request_data['session_id'];
            $shift = $request_data['shift_id'];
            $term = $request_data['term'];

            $scms_term = TableRegistry::getTableLocator()->get('scms_term_cycle');
            $scms_terms = $scms_term->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->select([
                        'term_name' => 's.term_name'
                    ])
                    ->where(['scms_term_cycle.term_id =' => $term])
                    ->where(['scms_term_cycle.level_id =' => $level])
                    ->join([
                        's' => [
                            'table' => 'scms_term',
                            'type' => 'INNER',
                            'conditions' => [
                                's.term_id  = scms_term_cycle.term_id'
                            ]
                        ]
                    ])
                    ->toArray();
                    // echo '<pre>';
                    // print_r($scms_terms);die;
            $this->set('term', $scms_terms);

            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $students = $scms_student_cycle->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->select([
                        'sid' => 's.sid',
                        'name' => 's.name',
                        'class' => 'level.level_name',
                        'shift' => 'shift.shift_name',
                        'section' => 'section.section_name',
                        'session_name' => 'session.session_name'
                    ])
                    ->where(['scms_student_cycle.level_id =' => $level])
                    ->where(['scms_student_cycle.section_id =' => $section])
                    ->where(['scms_student_cycle.session_id =' => $session])
                    ->where(['scms_student_cycle.shift_id =' => $shift])
                    ->join([
                        's' => [
                            'table' => 'scms_students',
                            'type' => 'INNER',
                            'conditions' => [
                                's.student_id  = scms_student_cycle.student_id',
                                 's.status' => 1
                            ]
                        ],
                        'level' => [
                            'table' => 'scms_levels',
                            'type' => 'INNER',
                            'conditions' => [
                                'level.level_id  = scms_student_cycle.level_id'
                            ]
                        ],
                        'shift' => [
                            'table' => 'hr_shift',
                            'type' => 'INNER',
                            'conditions' => [
                                'shift.shift_id  = scms_student_cycle.shift_id'
                            ]
                        ],
                        'section' => [
                            'table' => 'scms_sections',
                            'type' => 'INNER',
                            'conditions' => [
                                'section.section_id  = scms_student_cycle.section_id'
                            ]
                        ],
                        'session' => [
                            'table' => 'scms_sessions',
                            'type' => 'INNER',
                            'conditions' => [
                                'session.session_id  = scms_student_cycle.session_id'
                            ]
                        ],
                    ])
                    ->toArray();
            $this->set('students', $students);
            $this->render('/reports/bench_slip');
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
                ->find()
                ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        $this->set('groups', $groups);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        $this->set('shifts', $shifts);
        $term = TableRegistry::getTableLocator()->get('scms_term');
        $terms = $term
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        $this->set('terms', $terms);
    }


}
