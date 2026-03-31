<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use DateTime;

I18n::setLocale('jp_JP');

class AdmitController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }


  /*  public function index()
    {
        if (!empty($this->request->data)) {
            $this->layout = 'admit_card';
            $request_data = $this->request->getData();
            $where = [];

            // Apply 'sid' filter if provided
            if (isset($request_data['sid']) && !empty($request_data['sid'])) {
                $where['s.sid'] = $request_data['sid'];
            }

            // Apply other filters independently (even if 'sid' is not provided)
            if (isset($request_data['shift_id'])) {
                $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
            }
            if (isset($request_data['level_id'])) {
                $where['scms_student_cycle.level_id'] = $request_data['level_id'];
            }
            if (isset($request_data['section_id'])) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if (isset($request_data['session_id'])) {
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
                    'religion' => "s.religion",
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
                            's.student_id = scms_student_cycle.student_id',
                            's.status' => '1'
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
            

            $scms_admit_card = TableRegistry::getTableLocator()->get('scms_admit_card_students');
            $scms_admit_card_data = $scms_admit_card->find()
                ->where(['scms_admit_card_students.level_id' => $request_data['level_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term' => "scms_term.term_name",
                    'course_name' => "scms_admit_card.course_name",
                    'date_of_exam' => "scms_admit_card.date_of_exam",
                    'day' => "scms_admit_card.day",
                    'time_from' => "scms_admit_card.time_from",
                    'time_to' => "scms_admit_card.time_to"
                ])
                ->join([
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_term_cycle.term_cycle_id = scms_admit_card_students.term_cycle_id'
                        ]
                    ],
                    'scms_admit_card' => [
                        'table' => 'scms_admit_card',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_admit_card.term_cycle_id = scms_admit_card_students.term_cycle_id',
                            // 'scms_admit_card.level_id' => 'scms_admit_card_students.level_id'
                        ]
                    ],
                    'scms_term' => [
                        'table' => 'scms_term',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_term.term_id = scms_term_cycle.term_id'
                        ]
                    ],
                ])
                // ->order(['scms_admit_card.date_of_exam' => 'ASC'])admit_
                ->toArray();
            usort($scms_admit_card_data, function ($a, $b) {
                return strtotime($a['date_of_exam']) - strtotime($b['date_of_exam']);
            });

            $flag = Configure::read('Routine.show');
          
            if (($flag == 'ON')) {
                $merged_data = [];

                // Create a lookup table for admit card data based on level_id
                $admit_card_lookup = [];
                foreach ($scms_admit_card_data as $admit_card) {
                    $admit_card_lookup[$admit_card['sid']][] = $admit_card;
                }
               
                // Merge student cycles with corresponding admit card data
                foreach ($scms_student_cycles as $student_cycle) {
                    $level_id = $student_cycle['sid'];

                    // Initialize an empty array for the admit cards
                    $admit_cards = [];


                    if (isset($admit_card_lookup[$level_id])) {
                        $admit_cards = $admit_card_lookup[$level_id];
                    }

                    // Merge student cycle data with the associated admit card data
                    $merged_data[] = array_merge($student_cycle, ['admit_cards' => $admit_cards]);
                }


                foreach ($merged_data as &$student) {
                    $religion = strtolower($student['religion']);
                    $filtered_admit_cards = [];

                    foreach ($student['admit_cards'] as $card) {
                        $course = strtolower($card['course_name']);

                        // Always keep non-religion subjects
                        if (!str_contains($course, 'religion') && !str_contains($course, 'islam')) {
                            $filtered_admit_cards[] = $card;
                            continue;
                        }

                        // Only keep religion subjects that match the student's religion
                        if (($religion == 'islam' && str_contains($course, 'islam')) ||
                            ($religion == 'hindu' && str_contains($course, 'hindu')) ||
                            ($religion == 'christian' && str_contains($course, 'christian'))
                        ) {
                            $filtered_admit_cards[] = $card;
                        }
                    }

                    $student['admit_cards'] = $filtered_admit_cards;
                }
                unset($student);


                if (count($scms_student_cycles) == 0) {
                    $this->Flash->error('No Student Found', [
                        'key' => 'negative',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'index']);
                }

              
                $this->set('session_id', $request_data['session_id']);
                $this->set('level_id', $request_data['level_id']);
                $this->set('section_id', $request_data['section_id']);
                $this->set('shift_id', $request_data['shift_id']);
                $this->set('students', $merged_data);
                $this->render('/reports/admit_card');
            } else {
                
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
                
                $this->set('session_id', $request_data['session_id']);
                $this->set('level_id', $request_data['level_id']);
                $this->set('section_id', $request_data['section_id']);
                $this->set('shift_id', $request_data['shift_id']);
                $this->set('total', count($date));
                $this->set('students', $student);
                $this->render('/reports/admit_card');
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);
        
        $sections = $this->get_sections('students', $levels[0]->level_id);
        $this->set('sections', $sections);

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
    } */
    
    public function index()
    {
        if (!empty($this->request->data)) {
            $this->layout = 'admit_card';
            $request_data = $this->request->getData();
            $where = [];

            // Apply 'sid' filter if provided
            if (isset($request_data['sid']) && !empty($request_data['sid'])) {
                $where['s.sid'] = $request_data['sid'];
            }

            // Apply other filters independently (even if 'sid' is not provided)
            if (isset($request_data['shift_id'])) {
                $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
            }
            if (isset($request_data['level_id'])) {
                $where['scms_student_cycle.level_id'] = $request_data['level_id'];
            }
            if (isset($request_data['section_id'])) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if (isset($request_data['session_id'])) {
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
                    'religion' => "s.religion",
                    'gender' => "s.gender",
                    'sid' => "s.sid",
                    'mobile' => 's.mobile',
                    'thumbnail' => 's.thumbnail',
                    'status' => "s.status",
                    'shift_name' => "shift.shift_name",
                    'level_name' => "level.level_name",
                    'section_name' => "section.section_name",
                    'session_name' => "session.session_name",
                    'course_name' => "scms_courses.course_name"
                ])
                ->order(['scms_student_cycle.level_id' => 'ASC', 'scms_student_cycle.section_id' => 'ASC', 'roll' => 'ASC'])
                ->join([
                    's' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            's.student_id = scms_student_cycle.student_id',
                            's.status' => '1'
                        ]
                    ],
                    'scms_student_course_cycle' => [
                        'table' => 'scms_student_course_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_student_course_cycle.student_cycle_id = scms_student_cycle.student_cycle_id',
                        ]
                    ],
                    'scms_courses_cycle' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_courses_cycle.courses_cycle_id = scms_student_course_cycle.courses_cycle_id',
                        ]
                    ],
                    'scms_courses' => [
                        'table' => 'scms_courses',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_courses.course_id = scms_courses_cycle.course_id',
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

            $scms_admit_card = TableRegistry::getTableLocator()->get('scms_admit_card_students');
            $scms_admit_card_data = $scms_admit_card->find()
                ->where(['scms_admit_card_students.level_id' => $request_data['level_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term' => "scms_term.term_name",
                    'course_name' => "scms_admit_card.course_name",
                    'date_of_exam' => "scms_admit_card.date_of_exam",
                    'day' => "scms_admit_card.day",
                    'time_from' => "scms_admit_card.time_from",
                    'time_to' => "scms_admit_card.time_to"
                ])
                ->join([
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_term_cycle.term_cycle_id = scms_admit_card_students.term_cycle_id'
                        ]
                    ],
                    'scms_admit_card' => [
                        'table' => 'scms_admit_card',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_admit_card.term_cycle_id = scms_admit_card_students.term_cycle_id',
                            // 'scms_admit_card.level_id' => 'scms_admit_card_students.level_id'
                        ]
                    ],
                    'scms_term' => [
                        'table' => 'scms_term',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_term.term_id = scms_term_cycle.term_id'
                        ]
                    ],
                ])
                // ->order(['scms_admit_card.date_of_exam' => 'ASC'])admit_
                ->toArray();
            usort($scms_admit_card_data, function ($a, $b) {
                return strtotime($a['date_of_exam']) - strtotime($b['date_of_exam']);
            });
            $flag = Configure::read('Routine.show');

            if (($flag == 'ON')) {

                $matchedData = [];

                foreach ($scms_student_cycles as $student) {
                    foreach ($scms_admit_card_data as $exam) {
                        if (
                            $student['sid'] === $exam['sid'] &&
                            strtolower(trim($student['course_name'])) === strtolower(trim($exam['course_name']))
                        ) {
                            // Optional: merge data if needed
                            $matchedData[] = array_merge($student, $exam);
                        }
                    }
                }
                
                
                $groupedData = [];

                foreach ($matchedData as $item) {
                    $key = $item['sid'];
                
                    // If student not added yet, initialize
                    if (!isset($groupedData[$key])) {
                        $groupedData[$key] = $item;
                        $groupedData[$key]['admit_cards'] = [];
                    }
                
                    // Add current item to admit_cards
                    $groupedData[$key]['admit_cards'][] = $item;
                }
                
                // Now sort the admit_cards by date_of_exam for each student
                foreach ($groupedData as &$studentData) {
                    usort($studentData['admit_cards'], function ($a, $b) {
                        $dateA = DateTime::createFromFormat('d-m-Y', $a['date_of_exam']);
                        $dateB = DateTime::createFromFormat('d-m-Y', $b['date_of_exam']);
                        return $dateA <=> $dateB; // ascending order
                    });
                }
                unset($studentData);

                // Final output
                $finalData = array_values($groupedData);


                unset($student);

                if (count($scms_student_cycles) == 0) {
                    $this->Flash->error('No Student Found', [
                        'key' => 'negative',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'index']);
                }


                $this->set('session_id', $request_data['session_id']);
                $this->set('level_id', $request_data['level_id']);
                $this->set('section_id', $request_data['section_id']);
                $this->set('shift_id', $request_data['shift_id']);
                $this->set('students', $finalData);
                $this->render('/reports/admit_card');
            } else {
                
                $term = TableRegistry::getTableLocator()->get('scms_term_cycle');
                $terms = $term->find()
                    ->where(['scms_term_cycle.term_cycle_id' => $request_data['term_cycle_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->select([
                        'term' => "t.term_name",
                        'session' => "s.session_name",
                    ])
                    ->join([
                        't' => [
                            'table' => 'scms_term',
                            'type' => 'INNER',
                            'conditions' => [
                                't.term_id = scms_term_cycle.term_id'
                            ]
                        ],
                        's' => [
                            'table' => 'scms_sessions',
                            'type' => 'INNER',
                            'conditions' => [
                                's.session_id = scms_term_cycle.session_id'
                            ]
                        ],
                    ])->toArray();
                    
                $this->set('terms', $terms[0]['term']);
                $this->set('session', $terms[0]['session']);
                
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
// echo '<pre>';
// print_r($student);die;
                $this->set('session_id', $request_data['session_id']);
                $this->set('level_id', $request_data['level_id']);
                $this->set('section_id', $request_data['section_id']);
                $this->set('shift_id', $request_data['shift_id']);
                $this->set('total', count($date));
                $this->set('students', $student);
                $this->render('/reports/admit_card_normal');
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);

        $sections = $this->get_sections('students', $levels[0]->level_id);
        $this->set('sections', $sections);

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

    public function examAttendance()
    {
        if (!empty($this->request->data)) {
            $this->layout = 'admit_card';
            $request_data = $this->request->getData();
            
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
            if ($request_data['gender']) {
                $where['s.gender'] = $request_data['gender'];
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
                    'guardian_mobile' => 'scms_guardians.mobile',
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
                            's.student_id = scms_student_cycle.student_id',
                            's.status' => '1'
                        ]
                    ],
                    'scms_guardians' => [
                        'table' => 'scms_guardians',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_guardians.student_id  = scms_student_cycle.student_id',
                            'scms_guardians.rtype  = s.active_guardian',
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


            $scms_admit_card = TableRegistry::getTableLocator()->get('scms_admit_card_students');
            $scms_admit_card_data = $scms_admit_card->find()
                ->where(['scms_admit_card_students.level_id' => $request_data['level_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term' => "scms_term.term_name",
                    'course_name' => "scms_admit_card.course_name",
                    'date_of_exam' => "scms_admit_card.date_of_exam",
                    'day' => "scms_admit_card.day",
                    'time_from' => "scms_admit_card.time_from",
                    'time_to' => "scms_admit_card.time_to"
                ])
                ->join([
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_term_cycle.term_cycle_id = scms_admit_card_students.term_cycle_id'
                        ]
                    ],
                    'scms_admit_card' => [
                        'table' => 'scms_admit_card',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_admit_card.term_cycle_id = scms_admit_card_students.term_cycle_id',
                            // 'scms_admit_card.level_id' => 'scms_admit_card_students.level_id'
                        ]
                    ],
                    'scms_term' => [
                        'table' => 'scms_term',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_term.term_id = scms_term_cycle.term_id'
                        ]
                    ],
                ])
                ->toArray();
            usort($scms_admit_card_data, function ($a, $b) {
                return strtotime($a['date_of_exam']) - strtotime($b['date_of_exam']);
            });


            $merged_data = [];

            // Create a lookup table for admit card data based on level_id
            $admit_card_lookup = [];
            foreach ($scms_admit_card_data as $admit_card) {
                $admit_card_lookup[$admit_card['name']][] = $admit_card;
            }
            
            // Merge student cycles with corresponding admit card data
            foreach ($scms_student_cycles as $student_cycle) {
                $level_id = $student_cycle['name'];

                
                $admit_cards = [];

                
                if (isset($admit_card_lookup[$level_id])) {
                    $admit_cards = $admit_card_lookup[$level_id];
                }

                // Merge student cycle data with the associated admit card data
                $merged_data[] = array_merge($student_cycle, ['admit_cards' => $admit_cards]);
            }


            if (count($scms_student_cycles) == 0) {
                $this->Flash->error('No Student Found', [
                    'key' => 'negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'index']);
            }
           
            $this->set('students', $merged_data);
            $this->render('/reports/exam_attendance');
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

    public function admitCard()
    {
        if (!empty($this->request->getData())) {

            $value['session_id'] = null;
            $value['shift_id'] = null;
            $value['level_id'] = null;
            $value['section_id'] = null;
            $value['term_cycle_id'] = null;
            $request_data = $this->request->getData();

            if (isset($request_data['level_id']) && isset($request_data['section_id']) && isset($request_data['session_id'])) {
                $where = [];

                if ($request_data['level_id']) {
                    $where['scms_courses_cycle.level_id'] = $request_data['level_id'];
                }
                if ($request_data['section_id']) {
                    $where['scms_student_cycle.section_id'] = $request_data['section_id'];
                }
                if ($request_data['session_id']) {
                    $where['scms_courses_cycle.session_id'] = $request_data['session_id'];
                }

                // Unset the section_id filter from the where array if it's not needed
                // unset($where['scms_student_cycle.section_id']);


                unset($where['scms_student_cycle.section_id']);


                $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
                $scms_term_cycles = $scms_term_cycle->find()
                    ->where(['scms_term_cycle.term_cycle_id' => $request_data['term_cycle_id']])
                    ->select(['term_name' => "scms_term.term_name"])
                    ->join([
                        'scms_term' => [
                            'table' => 'scms_term',
                            'type' => 'INNER',
                            'conditions' => ['scms_term.term_id = scms_term_cycle.term_id']
                        ]
                    ])
                    ->enableAutoFields(true)
                    ->enableHydration(false)

                    ->toArray();
               
                $this->set('scms_term_cycles', $scms_term_cycles);
                $scms_admit_card = TableRegistry::getTableLocator()->get('scms_admit_card');
                $scms_admit_cards = $scms_admit_card->find()
                    ->where(['level_id' => $request_data['level_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
                
                if (!empty($scms_admit_cards)) { //echo '1';die;

                    foreach ($scms_admit_cards as &$card) {
                        // Convert date and time to the desired format
                        $datetime_from = DateTime::createFromFormat('d-m-Y h:i A', $card['date_of_exam'] . ' ' . $card['time_from']);
                        $datetime_to = DateTime::createFromFormat('d-m-Y h:i A', $card['date_of_exam'] . ' ' . $card['time_to']);

                        // Format the datetime objects
                        $card['datetime_from'] = $datetime_from->format('Y-m-d h:i:s A');
                        $card['datetime_to'] = $datetime_to->format('Y-m-d h:i:s A');
                    }
                    // echo '<pre>';
                    // print_r($scms_admit_cards);die;
                    $value = $request_data;
                    $this->set('value', $value);
                    $this->set('request_data', $request_data);
                    $this->set('scms_admit_cards', $scms_admit_cards);
                    $this->set('session_id', $request_data['session_id']);
                    $this->set('level_id', $request_data['level_id']);
                    $this->set('section_id', $request_data['section_id']);
                    $this->set('shift_id', $request_data['shift_id']);
                } else {
                    $where['scms_term_course_cycle.term_cycle_id'] = $request_data['term_cycle_id'];
                    
                    // Fetch student cycles data
                    $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
                    $scms_student_cycles = $scms_student_cycle->find()
                        ->where($where)
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'course_id' => "scms_courses.course_id",
                            'course_name' => "scms_courses.course_name"
                        ])
                        ->join([

                            'scms_courses_cycle' => [
                                'table' => 'scms_courses_cycle',
                                'type' => 'INNER',
                                'conditions' => ['scms_courses_cycle.courses_cycle_id = scms_term_course_cycle.courses_cycle_id']
                            ],
                            'scms_courses' => [
                                'table' => 'scms_courses',
                                'type' => 'INNER',
                                'conditions' => ['scms_courses.course_id = scms_courses_cycle.course_id']
                            ],
                        ])
                        ->toArray();


                    $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
                    $scms_term_cycles = $scms_term_cycle->find()
                        ->where(['scms_term_cycle.term_cycle_id' => $request_data['term_cycle_id']])
                        ->select(['term_name' => "scms_term.term_name"])
                        ->join([
                            'scms_term' => [
                                'table' => 'scms_term',
                                'type' => 'INNER',
                                'conditions' => ['scms_term.term_id = scms_term_cycle.term_id']
                            ]
                        ])
                        ->enableAutoFields(true)
                        ->enableHydration(false)

                        ->toArray();

                    

                    $filtered_scms_term_cycles = array_values($scms_student_cycles);

                    

                    // Check if no student cycles were found
                    if (count($scms_student_cycles) === 0) {
                        $this->Flash->error('No Student Found', [
                            'key' => 'negative'
                        ]);
                        return $this->redirect(['action' => 'index']);
                    }
                    
                    $this->set('scms_student_cycles', $filtered_scms_term_cycles);
                    $this->set('scms_term_cycles', $scms_term_cycles);
                    $this->set('request_data', $request_data);
                    $this->set('session_id', $request_data['session_id']);
                    $this->set('level_id', $request_data['level_id']);
                    $this->set('section_id', $request_data['section_id']);
                    $this->set('shift_id', $request_data['shift_id']);
                }
            } else {
                $request_data1 = $this->request->getData();

                $subjectsTable = TableRegistry::getTableLocator()->get('scms_admit_card');
                $successCount = 0;
                $errorCount = 0;
                $errorMessages = [];

                $data_to_save = [];

                // Extract data and process each subject
                foreach ($request_data1 as $key => $value) {
                    if (preg_match('/^subject(\d+)$/', $key, $matches)) {
                        $index = $matches[1];

                        $time_from_key = "time_from" . $index;
                        $time_to_key = "time_to" . $index;

                        if (isset($request_data1[$time_from_key]) && isset($request_data1[$time_to_key])) {
                            $time_from = new DateTime($request_data1[$time_from_key]);
                            $time_to = new DateTime($request_data1[$time_to_key]);

                            $data = [
                                'course_name' => $value,
                                'time_from' => $time_from->format('g:i A'), // 12-hour format with AM/PM
                                'time_to' => $time_to->format('g:i A'),
                                'day' => $time_from->format('l'),
                                'date_of_exam' => $time_from->format('d-m-Y'),
                                'level_id' => $request_data1['level_id'],
                                'term_cycle_id' => $request_data1['term_cycle_id']
                            ];

                            // Check if a record with the same level_id and term_cycle_id already exists
                            $existingRecord = $subjectsTable->find()
                                ->where(['level_id' => $data['level_id'], 'term_cycle_id' => $data['term_cycle_id'], 'course_name' => $value])
                                ->first();

                            if ($existingRecord) {
                                // Update the existing record
                                $subject = $subjectsTable->patchEntity($existingRecord, $data);
                            } else {
                                // Create a new record
                                $subject = $subjectsTable->newEntity($data);
                            }

                            // Attempt to save the record (whether new or updated)
                            if ($subjectsTable->save($subject)) {
                                $successCount++;
                            } else {
                                $errorCount++;
                                $errorMessages[] = "Error saving subject: " . $data['course_name'];
                            }
                        }
                    }
                }

                // Set flash messages
                if ($successCount > 0) {
                    $this->Flash->success("Successfully saved $successCount subjects.");
                }
                if ($errorCount > 0) {
                    $this->Flash->error("$errorCount errors occurred.");
                    foreach ($errorMessages as $message) {
                        $this->Flash->error($message);
                    }
                }
            }
            $value = $request_data;
            $this->set('value', $value);
        }

        $sessionTable = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $sessionTable->find()->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);

        $sections = $this->get_sections('students', $levels[0]->level_id);
        $this->set('sections', $sections);

        $groupTable = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $groupTable->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('groups', $groups);

        $shiftTable = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shiftTable->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
        $this->set('data', $value);
    }

    public function admitCardStudents()
    {
        if (!empty($this->request->getData())) {

            $value['session_id'] = null;
            $value['shift_id'] = null;
            $value['level_id'] = null;
            $value['section_id'] = null;
            $value['term_cycle_id'] = null;

            $request_data = $this->request->getData();
            // pr($request_data);die;
            if (isset($request_data['level_id']) && isset($request_data['session_id'])) {
                $where = [];

                if ($request_data['level_id']) {
                    $where['scms_courses_cycle.level_id'] = $request_data['level_id'];
                }
                if ($request_data['section_id']) {
                    $where['scms_student_cycle.section_id'] = $request_data['section_id'];
                }
                if ($request_data['session_id']) {
                    $where['scms_courses_cycle.session_id'] = $request_data['session_id'];
                }
                // if ($request_data['section_id']) {
                //     $where['scms_courses_cycle.section_id'] = $request_data['section_id'];
                // }

                // Unset the section_id filter from the where array if it's not needed
                // unset($where['scms_student_cycle.section_id']);
                $scms_admit_card_student = TableRegistry::getTableLocator()->get('scms_admit_card_students');
                $scms_admit_card_students = $scms_admit_card_student->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
                if (!empty($scms_admit_card_students)) {
                    
                    
                    $scms_student = TableRegistry::getTableLocator()->get('scms_student_cycle');
                    $students = $scms_student->find()
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
                        ->where(['scms_student_cycle.level_id =' => $request_data['level_id']])
                        ->where(['scms_student_cycle.section_id =' => $request_data['section_id']]) //scms_admit_card_students
                        ->where(['scms_student_cycle.session_id =' => $request_data['session_id']])
                        ->where(['scms_student_cycle.shift_id =' => $request_data['shift_id']])
                        ->join([
                            's' => [
                                'table' => 'scms_students',
                                'type' => 'INNER',
                                'conditions' => [
                                    's.student_id  = scms_student_cycle.student_id',
                                    's.status' => '1',
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

                    $admitCardMap = [];
                    foreach ($scms_admit_card_students as $student) {
                        $key = $student['name'] . '-' . $student['sid'] . '-' . $student['level_id'] . '-' . $student['section_id'];
                        $admitCardMap[$key] = $student['room'];
                    }

                    // Update $students array with room
                    foreach ($students as &$student) {
                        $key = $student['name'] . '-' . $student['sid'] . '-' . $student['level_id'] . '-' . $student['section_id'];
                        if (isset($admitCardMap[$key])) {
                            $student['room'] = $admitCardMap[$key];
                        }
                    }

                    $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
                    $scms_term_cycles = $scms_term_cycle->find()
                        ->where(['scms_term_cycle.term_cycle_id' => $request_data['term_cycle_id']])
                        ->select(['term_name' => "scms_term.term_name"])
                        ->join([
                            'scms_term' => [
                                'table' => 'scms_term',
                                'type' => 'INNER',
                                'conditions' => ['scms_term.term_id = scms_term_cycle.term_id']
                            ]
                        ])
                        ->enableAutoFields(true)
                        ->enableHydration(false)

                        ->toArray();
                        
                    $this->set('students1', $students);
                    $this->set('request_data', $request_data);
                    $this->set('scms_term_cycles', $scms_term_cycles);
                    $this->set('session_id', $request_data['session_id']);
                    $this->set('level_id', $request_data['level_id']);
                    $this->set('section_id', $request_data['section_id']);
                    $this->set('shift_id', $request_data['shift_id']);
                    
                } else {

                    $scms_student = TableRegistry::getTableLocator()->get('scms_student_cycle');
                    $students = $scms_student->find()
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
                        ->where(['scms_student_cycle.level_id =' => $request_data['level_id']])
                        // ->where(['scms_student_cycle.section_id =' => $request_data['section_id']]) scms_admit_card_students
                        ->where(['scms_student_cycle.session_id =' => $request_data['session_id']])
                        ->where(['scms_student_cycle.shift_id =' => $request_data['shift_id']])
                        ->join([
                            's' => [
                                'table' => 'scms_students',
                                'type' => 'INNER',
                                'conditions' => [
                                    's.student_id  = scms_student_cycle.student_id',
                                    's.status' => '1',
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

                    $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
                    $scms_term_cycles = $scms_term_cycle->find()
                        ->where(['scms_term_cycle.term_cycle_id' => $request_data['term_cycle_id']])
                        ->select(['term_name' => "scms_term.term_name"])
                        ->join([
                            'scms_term' => [
                                'table' => 'scms_term',
                                'type' => 'INNER',
                                'conditions' => ['scms_term.term_id = scms_term_cycle.term_id']
                            ]
                        ])
                        ->enableAutoFields(true)
                        ->enableHydration(false)

                        ->toArray();


                    $this->set('scms_term_cycles', $scms_term_cycles);
                    $this->set('students2', $students);
                    $this->set('request_data', $request_data);
                    $this->set('session_id', $request_data['session_id']);
                    $this->set('level_id', $request_data['level_id']);
                    $this->set('section_id', $request_data['section_id']);
                    $this->set('shift_id', $request_data['shift_id']);
                }
            } else {
                $request_data1 = $this->request->getData();
                $students = [];


                // Assuming you have a number of students with dynamic keys
                foreach ($request_data1 as $key => $value) {
                    if (preg_match('/^sid(\d+)$/', $key, $matches)) {
                        $index = $matches[1];
                        $students[] = [
                            'sid' => $request_data1['sid' . $index],
                            'name' => $request_data1['name' . $index],
                            'section' => $request_data1['section' . $index],
                            'section_id' => $request_data1['section_id' . $index],
                            'room' => $request_data1['room' . $index],
                            'level_id' => $request_data1['level_id'],
                            'term_cycle_id' => $request_data1['term_cycle_id']
                        ];
                    }
                }


                // Save data to the database
                $subjectsTable = TableRegistry::getTableLocator()->get('scms_admit_card_students');
                $successCount = 0;
                $errorCount = 0;
                $errorMessages = [];

                // Iterate through the data and save or update
                foreach ($students as $data) {
                    // Check if the student exists
                    $existingSubject = $subjectsTable->find()
                        ->where(['sid' => $data['sid']])
                        ->first();

                    if ($existingSubject) {
                        
                        // Update the existing record
                        $existingSubject = $subjectsTable->patchEntity($existingSubject, $data);
                        if ($subjectsTable->save($existingSubject)) {
                            $successCount++;
                        } else {
                            $errorCount++;
                            $errorMessages[] = "Error updating student: " . $data['name'];
                        }
                    } else {
                        
                        // Insert new record
                        $subject = $subjectsTable->newEntity($data);
                        if ($subjectsTable->save($subject)) {
                            $successCount++;
                        } else {
                            $errorCount++;
                            $errorMessages[] = "Error saving student: " . $data['name'];
                        }
                    }
                }

                // Optionally, handle success and error messages
                if ($errorCount > 0) {
                    $this->Flash->error(implode(', ', $errorMessages));
                } else {
                    $this->Flash->success(__('All students saved successfully.'));
                }
            }
            $value = $request_data;
            $this->set('value', $value);
        }

        $sessionTable = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $sessionTable->find()->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);
        
        $sections = $this->get_sections('students', $levels[0]->level_id);
        $this->set('sections', $sections);

        $groupTable = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $groupTable->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('groups', $groups);

        

        $term = TableRegistry::getTableLocator()->get('scms_term');
        $terms = $term->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('terms', $terms);

        $shiftTable = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shiftTable->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
        $value = $request_data;
        
        $this->set('data', $value);
    }

    public function individualAdmitCard()
    {
        if (!empty($this->request->getData())) {

            $value['session_id'] = null;
            $value['sid'] = null;
            $value['name'] = null;
            $value['section_id'] = null;
            $value['level_id'] = null;
            $value['term_cycle_id'] = null;
            $value['room'] = null;

            $request_data = $this->request->getData();

            unset($request_data['session_id']);


            $scms_admit_card_students = TableRegistry::getTableLocator()->get('scms_admit_card_students');
            $scms_admit_card_student = $scms_admit_card_students
                ->find()
                ->where(['sid' => $request_data['sid']])
                ->where(['level_id' => $request_data['level_id']])
                ->where(['term_cycle_id' => $request_data['term_cycle_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)

                ->toArray();


            if (empty($scms_admit_card_student)) {
                $query = $scms_admit_card_students->query();
                $query
                    ->insert(['name', 'sid', 'term_cycle_id', 'level_id', 'section_id', 'room'])
                    ->values($request_data)
                    ->execute();
                $this->Flash->success('Student Added Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'individualAdmitCard']);
            } else {
                $query = $scms_admit_card_students->query();
                $query->update()
                    ->set($request_data)
                    ->where(['sid' => $request_data['sid']])
                    ->where(['level_id' => $request_data['level_id']])
                    ->where(['term_cycle_id' => $request_data['term_cycle_id']])
                    ->execute();
                $this->Flash->success('Student Updated Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'individualAdmitCard']);
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->toArray();
        $this->set('sessions', $sessions);
    }



    public function slip()
    {
        if (!empty($this->request->data)) {
            $this->layout = 'admit_card';
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
                    'session_name' => 'session.session_name',
                    'room' => "scms_admit_card_students.room",
                    'guardian_mobile' => 'scms_guardians.mobile',
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
                    'scms_admit_card_students' => [
                        'table' => 'scms_admit_card_students',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_admit_card_students.sid = s.sid',
                        ]
                    ],
                    'scms_guardians' => [
                        'table' => 'scms_guardians',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_guardians.student_id  = scms_student_cycle.student_id',
                            'scms_guardians.rtype  = s.active_guardian',
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


    public function deleteAdmitCard()
    {
        if (!empty($this->request->data)) {

            $request_data = $this->request->getData();


            $scms_admit_card_students = TableRegistry::getTableLocator()->get('scms_admit_card_students');

            $query = $scms_admit_card_students->query();
            $deleteQuery = $query->delete()
                ->where([
                    'level_id' => $request_data['level_id'],
                    'section_id' => $request_data['section_id'],
                    'term_cycle_id' => $request_data['term_cycle_id']
                ])->execute();




            $this->Flash->success('Admitcard Deleted Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'deleteAdmitCard']);
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
    
    public function deleteRoutine()
    {
        if (!empty($this->request->data)) {

            $request_data = $this->request->getData();

            $scms_admit_card = TableRegistry::getTableLocator()->get('scms_admit_card');

            $query = $scms_admit_card->query();
            $deleteQuery = $query->delete()
                ->where([
                    'level_id' => $request_data['level_id'],
                    // 'session_id' => $request_data['session_id'],
                    'term_cycle_id' => $request_data['term_cycle_id']
                ])->execute();




            $this->Flash->success('Routine Deleted Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'deleteRoutine']);
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
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