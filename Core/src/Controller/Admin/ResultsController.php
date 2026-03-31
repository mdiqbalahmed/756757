<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

I18n::setLocale('jp_JP');

class ResultsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function mergeResult()
    {
        $where['scms_results.type'] = 'merge';
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if ($request_data['session_id']) {
                $where['scms_results.session_id'] = $request_data['session_id'];
            }
            if ($request_data['level_id']) {
                $where['scms_results.level_id'] = $request_data['level_id'];
            }
            if ($request_data['term_cycle_id']) {
                $where['scms_results.term_cycle_id'] = $request_data['session_id'];
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels('results');
        $this->set('levels', $levels);
        $scms_results = TableRegistry::getTableLocator()->get('scms_results');
        $results = $scms_results
            ->find()
            ->select([
                'session_name' => 'scms_sessions.session_name',
                'level_name' => 'scms_levels.level_name',
                'term_name' => 'scms_term.term_name',
                'template_name' => 'scms_result_template.name',
                'gradings_system_name' => 'scms_gradings.gradings_system_name',
            ])
            ->where($where)
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'scms_sessions' => [
                    'table' => 'scms_sessions',
                    'type' => 'LEFT',
                    'conditions' => ['scms_sessions.session_id  = scms_results.session_id'],
                ],
                'scms_levels' => [
                    'table' => 'scms_levels',
                    'type' => 'LEFT',
                    'conditions' => ['scms_levels.level_id = scms_results.level_id'],
                ],
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_cycle.term_cycle_id = scms_results.term_cycle_id'],
                ],
                'scms_term' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term.term_id = scms_term_cycle.term_id'],
                ],
                'scms_result_template' => [
                    'table' => 'scms_result_template',
                    'type' => 'LEFT',
                    'conditions' => ['scms_result_template.result_template_id = scms_results.result_template_id'],
                ],
                'scms_gradings' => [
                    'table' => 'scms_gradings',
                    'type' => 'LEFT',
                    'conditions' => ['scms_gradings.gradings_id = scms_results.gradings_id'],
                ],
            ]);
        $paginate = $this->paginate($results, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('results', $paginate);
    }

    public function index()
    {
        $where['scms_results.type'] = 'single';
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if ($request_data['session_id']) {
                $where['scms_results.session_id'] = $request_data['session_id'];
            }
            if ($request_data['level_id']) {
                $where['scms_results.level_id'] = $request_data['level_id'];
            }
            if ($request_data['term_cycle_id']) {
                $where['scms_results.term_cycle_id'] = $request_data['session_id'];
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels('results');
        $this->set('levels', $levels);
        $scms_results = TableRegistry::getTableLocator()->get('scms_results');
        $results = $scms_results
            ->find()
            ->select([
                'session_name' => 'scms_sessions.session_name',
                'level_name' => 'scms_levels.level_name',
                'term_name' => 'scms_term.term_name',
                'template_name' => 'scms_result_template.name',
                'gradings_system_name' => 'scms_gradings.gradings_system_name',
            ])
            ->where($where)
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'scms_sessions' => [
                    'table' => 'scms_sessions',
                    'type' => 'LEFT',
                    'conditions' => ['scms_sessions.session_id  = scms_results.session_id'],
                ],
                'scms_levels' => [
                    'table' => 'scms_levels',
                    'type' => 'LEFT',
                    'conditions' => ['scms_levels.level_id = scms_results.level_id'],
                ],
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_cycle.term_cycle_id = scms_results.term_cycle_id'],
                ],
                'scms_term' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term.term_id = scms_term_cycle.term_id'],
                ],
                'scms_result_template' => [
                    'table' => 'scms_result_template',
                    'type' => 'LEFT',
                    'conditions' => ['scms_result_template.result_template_id = scms_results.result_template_id'],
                ],
                'scms_gradings' => [
                    'table' => 'scms_gradings',
                    'type' => 'LEFT',
                    'conditions' => ['scms_gradings.gradings_id = scms_results.gradings_id'],
                ],
            ]);
        $paginate = $this->paginate($results, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('results', $paginate);
    }

    public function deleteResult($id)
    {
        $type = $this->get_result_type($id);
        $scms_result_students = TableRegistry::getTableLocator()->get('scms_result_students');
        $result_students = $scms_result_students
            ->find()
            ->where(['result_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        foreach ($result_students as $result_student) {
            $result_student_ids[] = $result_student['result_student_id'];
        }
        $this->delete_student_result($result_student_ids);

        $scms_results = TableRegistry::getTableLocator()->get('scms_results');
        $results = $scms_results
            ->find()
            ->where(['result_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        $query = $scms_results->query();
        $query->delete()
            ->where(['result_id' => $id])
            ->execute();

        $scms_result_attendance_month = TableRegistry::getTableLocator()->get('scms_result_attendance_month');
        $query = $scms_result_attendance_month->query();
        $query->delete()
            ->where(['result_id' => $id])
            ->execute();

        $this->insert_delete_update_log('result', 'deleteResult', 'delete', json_encode($results[0]));

        //Set Flash
        $this->Flash->success('Result Successfully Deleted', [
            'key' => 'positive',
            'params' => [],
        ]);
        if ($type == 'single') {
            return $this->redirect(['action' => 'index']);
        } else {
            return $this->redirect(['action' => 'mergeResult']);
        }
    }

    private function get_attendance_month_by_array()
    {
        $month[1]['count'] = 0;
        $month[2]['count'] = 0;
        $month[3]['count'] = 0;
        $month[4]['count'] = 0;
        $month[5]['count'] = 0;
        $month[6]['count'] = 0;
        $month[7]['count'] = 0;
        $month[8]['count'] = 0;
        $month[9]['count'] = 0;
        $month[10]['count'] = 0;
        $month[11]['count'] = 0;
        $month[12]['count'] = 0;
        $month[13]['count'] = 0;
        return $month;
    }

    private function get_studnet_attandance_by_term($student_cycle_ids, $term_cycle_id)
    {
        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $student_cycle = $scms_student_cycle
            ->find()
            ->where(['student_cycle_id' => $student_cycle_ids[0]])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $months = $this->get_attendance_month_by_array();
        $student_months = array();
        $data_months = array();
        $scms_attendance = TableRegistry::getTableLocator()->get('scms_attendance');
        $month_attendances = $scms_attendance
            ->find()
            ->where(['scms_student_cycle.level_id' => $student_cycle[0]['level_id']])
            ->where(['term_cycle_id IN' => $term_cycle_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->group('date')
            ->join([
                'scms_student_cycle' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_attendance.student_cycle_id = scms_student_cycle.student_cycle_id'],
                ],
            ])
            ->toArray();
        foreach ($month_attendances as $key => $month_attendance) {
            $month_attendances[$key]['month_number'] = (int) date("m", strtotime($month_attendance['date']));
            $months[$month_attendances[$key]['month_number']]['count']++;
            $months[$month_attendances[$key]['month_number']]['date'] = $month_attendance['date'];
            $months[13]['count']++;
        }
        foreach ($months as $key => $month) {
            if ($months[$key]['count'] && $key != 13) {
                $student_months[$key]['count'] = 0;
                $date = date("Y", strtotime($month['date'])) . '-' . ucfirst(date("F", strtotime($month['date'])));
                $month['first_day'] = date("Y-m-d", strtotime($date));
                $month['last_day'] = date("Y-m-t", strtotime($date));
                $data_months[$key] = $month;
                unset($months[$key]['date']);
            } else if ($key != 13) {
                $student_months[$key]['count'] = '--';
                $months[$key]['count'] = '--';
            }
        }
        $student_months[13]['count'] = 0;
        $studnet_attendance_data = array();
        foreach ($student_cycle_ids as $student_cycle_id) {
            $studnet_attendance_data[$student_cycle_id] = $student_months;
        }
        foreach ($data_months as $key => $data_month) {
            $where = array();
            $where['date >='] = $data_month['first_day'];
            $where['date <='] = $data_month['last_day'];
            $where['student_cycle_id in'] = $student_cycle_ids;
            $where['term_cycle_id'] = $term_cycle_id;
            $month_wise_attendances = $scms_attendance
                ->find()
                ->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
            foreach ($month_wise_attendances as $month_wise_attendance) {
                $studnet_attendance_data[$month_wise_attendance['student_cycle_id']][$key]['count']++;
                $studnet_attendance_data[$month_wise_attendance['student_cycle_id']][13]['count']++;
            }
        }
        $return['months_data'] = $months;
        $return['studnet_data'] = $studnet_attendance_data;
        return $return;
    }

    public function generateResult()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();

            $this->set('request_data', $request_data);
            //making of student array @start
// set the where clause depand on search
            if ($request_data['session_id']) {
                $where['sc.session_id'] = $request_data['session_id'];
            }
            if ($request_data['shift_id']) {
                $where['sc.shift_id'] = $request_data['shift_id'];
            }
            if ($request_data['level_id']) {
                $where['sc.level_id'] = $request_data['level_id'];
            }
            if ($request_data['section_id']) {
                $where['sc.section_id'] = $request_data['section_id'];
            }
            if ($request_data['sid']) {
                $where['scms_students.sid'] = $request_data['sid'];
            }
            if ($request_data['term_cycle_id']) {
                $where['stc.term_cycle_id'] = $request_data['term_cycle_id'];
            }
            if ($request_data['group_id']) {
                $where['sc.group_id'] = $request_data['group_id'];
            }
            //get the students
            $where['status'] = 1;
            $student = TableRegistry::getTableLocator()->get('scms_students');
            $nofilter_students = $student
                ->find()
                ->select([
                    'level_id' => 'sc.level_id',
                    'group_id' => 'sc.group_id',
                    'shift_id' => 'sc.shift_id',
                    'section_id' => 'sc.section_id',
                    'roll' => 'sc.roll',
                    'session_id' => 'sc.session_id',
                    'student_cycle_id' => 'sc.student_cycle_id',
                    'term_cycle_id' => 'stc.term_cycle_id',
                    'student_term_cycle_id' => 'stc.student_term_cycle_id',
                    'group_name' => 'scms_groups.group_name',
                    'level_name' => 'scms_levels.level_name',
                    'shift_name' => 'hr_shift.shift_name',
                    'section_name' => 'scms_sections.section_name',
                ])
                ->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->join([
                    'sc' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['sc.student_id  = scms_students.student_id'],
                    ],
                    'stc' => [
                        'table' => 'scms_student_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['stc.student_cycle_id = sc.student_cycle_id'],
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['scms_levels.level_id = sc.level_id'],
                    ],
                    'scms_groups' => [
                        'table' => 'scms_groups',
                        'type' => 'LEFT',
                        'conditions' => ['scms_groups.group_id = sc.group_id'],
                    ],
                    'hr_shift' => [
                        'table' => 'hr_shift',
                        'type' => 'LEFT',
                        'conditions' => ['hr_shift.shift_id = sc.shift_id'],
                    ],
                    'scms_sections' => [
                        'table' => 'scms_sections',
                        'type' => 'LEFT',
                        'conditions' => ['scms_sections.section_id = sc.section_id'],
                    ],
                ])
                ->toArray();
            if (count($nofilter_students) == 0) {
                $this->Flash->success('No Student Found', [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'generateResult']);
            }
            $students = array();
            //array indexing in students depand on "student_term_cycle_id"
            foreach ($nofilter_students as $key => $student) {
                $student = $this->get_guardians($student);
                $students[$student['student_term_cycle_id']] = $student;
                $student_term_cycle_ids[] = $student['student_term_cycle_id'];
                $student_cycle_ids[] = $student['student_cycle_id'];
            }
            $all_student_attandance = $this->get_studnet_attandance_by_term($student_cycle_ids, $request_data['term_cycle_id']);
            $student_third_fourth_subjects = $this->get_studnet_third_fourth_subjects($student_term_cycle_ids);

            //get course cycle of students
            $student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
            $nofilter_student_term_course_cycles = $student_term_course_cycle
                ->find()
                ->order(['course_code' => 'ASC'])
                ->select([
                    'course_id' => 'c.course_id',
                    'course_name' => 'c.course_name',
                    'course_type_id' => 'c.course_type_id',
                    'course_code' => 'c.course_code',
                    'course_code' => 'c.course_code',
                    'courses_cycle_id' => 'cc.courses_cycle_id',
                    'student_course_cycle_id' => 'scc.student_course_cycle_id'
                ])
                ->where(['student_term_cycle_id  in' => $student_term_cycle_ids])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->join([
                    'scc' => [
                        'table' => 'scms_student_course_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scc.student_course_cycle_id  = scms_student_term_course_cycle.student_course_cycle_id'],
                    ],
                ])
                ->join([
                    'cc' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['cc.courses_cycle_id = scc.courses_cycle_id'],
                    ],
                ])
                ->join([
                    'c' => [
                        'table' => 'scms_courses',
                        'type' => 'LEFT',
                        'conditions' => ['cc.course_id = c.course_id'],
                    ],
                ])
                ->toArray();
            //array indexing in course_cycles depand on "student_term_course_cycle_id"
            $student_term_course_cycles = array();
            foreach ($nofilter_student_term_course_cycles as $key2 => $student_term_course_cycle) {
                $student_term_course_cycles[$student_term_course_cycle['student_term_course_cycle_id']] = $student_term_course_cycle;
                $student_term_course_cycle_ids[] = $student_term_course_cycle['student_term_course_cycle_id'];
            }


            //get part marks of course cycle
            $term_course_cycle_part_mark = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_mark');
            $term_course_cycle_part_marks = $term_course_cycle_part_mark
                ->find()
                ->select([
                    'term_course_cycle_part_type_id' => 'tccpt.term_course_cycle_part_type_id',
                    'term_course_cycle_part_type_name' => 'tccpt.term_course_cycle_part_type_name',
                    'short_form' => 'tccpt.short_form',
                    'total_mark' => 'tccp.mark',
                    'pass_mark' => 'tccp.pass_mark'
                ])
                ->where(['student_term_course_cycle_id in' => $student_term_course_cycle_ids])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->join([
                    'tccp' => [
                        'table' => 'scms_term_course_cycle_part',
                        'type' => 'LEFT',
                        'conditions' => ['tccp.term_course_cycle_part_id  = scms_term_course_cycle_part_mark.term_course_cycle_part_id'],
                    ],
                ])
                ->join([
                    'tccpt' => [
                        'table' => 'scms_term_course_cycle_part_type',
                        'type' => 'LEFT',
                        'conditions' => ['tccpt.term_course_cycle_part_type_id = tccp.term_course_cycle_part_type_id'],
                    ],
                ])
                ->toArray();

            //assign part marks to course cycles depand on "student_term_course_cycle_id"
            foreach ($term_course_cycle_part_marks as $key => $term_course_cycle_part_mark) {
                $student_term_course_cycles[$term_course_cycle_part_mark['student_term_course_cycle_id']]['parts'][$term_course_cycle_part_mark['term_course_cycle_part_type_id']] = $term_course_cycle_part_mark;
            }
            //assign course cycles to student depand on "student_term_cycle_id"
            foreach ($student_term_course_cycles as $key => $student_term_course_cycle) {
                if (isset($students[$student_term_course_cycle['student_term_cycle_id']])) {
                    $students[$student_term_course_cycle['student_term_cycle_id']]['courses'][$student_term_course_cycle['course_id']] = $student_term_course_cycle;
                }
            }
            //making of student array @end
//get template configaration
            $template = $this->get_template($request_data['result_template_id']);
            $scms_activity_remarks = $this->default_activities();
            if (isset($template['activity'])) {
                unset($template['activity']['value']['activity_name']);
                $activities_return = $this->get_student_activity($student_term_cycle_ids, $template['activity']['value']);
                $studnet_activities = $activities_return['student_activities'];
                $return_scms_activity_remarks = array_values($activities_return['scms_activity_remarks']);
                if (isset($return_scms_activity_remarks[0])) {
                    $scms_activity_remarks[0] = $return_scms_activity_remarks[0];
                }
                if (isset($return_scms_activity_remarks[1])) {
                    $scms_activity_remarks[1] = $return_scms_activity_remarks[1];
                }
            }
            //merge subject

            $grade = TableRegistry::getTableLocator()->get('scms_grade');
            $grades = $grade
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->order(['point' => 'ASC'])
                ->where(['gradings_id' => $request_data['gradings_id']])
                ->toArray();

            $query = $grade->find()->where(['gradings_id' => $request_data['gradings_id']]);
            $query->select([
                'max_point' => $query->func()->max('point')
            ])
                ->enableAutoFields(true)
                ->enableHydration(false);
            foreach ($query as $row) {
                $max_point = $row['max_point'];
            }

            foreach ($students as $key => $student) {
                $filter_course = array();
                foreach ($student['courses'] as $key_course_id => $course) {
                    if (!$key_course_id) {
                        unset($students[$key]['courses'][$key_course_id]);
                        unset($student['courses'][$key_course_id]);
                    }
                }
                if (isset($student_third_fourth_subjects[$key])) {
                    $students[$key]['third_fourth_subjects'] = $student_third_fourth_subjects[$key];
                }
                if (isset($template['merge_subject'])) {
                    $students[$key] = $this->merge_subject($template['merge_subject'], $students[$key]);
                    if ($students[$key] == -1) {
                        return $this->redirect(['action' => 'generateResult']);
                    }
                }
                if (isset($template['indivisul_pass_check'])) {
                    //indivisul_pass_check subject +total pass check
                    $students[$key] = $this->indivisul_pass_check($students[$key]);
                } else {
                    //total pass check
                    $students[$key] = $this->total_pass_check($students[$key]);
                }
                //group_pass_check subject
                if (isset($template['group_pass_check'])) {
                    $students[$key] = $this->group_pass_check($students[$key], $template['group_pass_check']);
                }
                //group_persentage_check subject
                if (isset($template['group_persentage_check'])) {
                    $students[$key] = $this->group_persentage_and_calculate_total($students[$key], $template['group_persentage_check']);
                } //total_persentage_check subject
                else if (isset($template['total_persentage_check'])) {
                    $students[$key] = $this->total_persentage_and_calculate_total($students[$key], $template['total_persentage_check']['value']);
                } else {
                    //no persentage calculate total
                    $students[$key] = $this->total_persentage_and_calculate_total($students[$key]);
                }
                //calculate course  gpa
                $students[$key] = $this->calculate_gpa($students[$key], $grades);

                //calculate term total and gpa
                $students[$key] = $this->result_calculation($students[$key], $max_point, $template, $grades);

                $students[$key]['attandance_data'] = $all_student_attandance['studnet_data'][$students[$key]['student_cycle_id']];
                if (isset($template['activity']) && isset($studnet_activities[$key])) {
                    $students[$key]['activity_data'] = $studnet_activities[$key];
                }
            }
            usort($students, function ($a, $b) {
                return [$a['section_id'], $a['roll']] <=>
                    [$b['section_id'], $b['roll']];
            });

            if (isset($request_data['save']) && $request_data['save'] == 'yes') {
                $result_where['session_id'] = $request_data['session_id'];
                $result_where['level_id'] = $request_data['level_id'];
                $result_where['term_cycle_id'] = $request_data['term_cycle_id'];
                $result_where['type'] = 'single';
                $this->update_and_save_result($result_where, $request_data, $students, $all_student_attandance['months_data'], $template, 'single');

                $level = TableRegistry::getTableLocator()->get('scms_levels');
                $levels = $level
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['level_id' => $result_where['level_id']])
                    ->toArray();

                $this->Flash->success(__('Result Successfully Saved for Class {0}', $levels[0]['level_name']), [
                    'key' => 'positive',
                    'params' => [],
                ]);

                // $this->Flash->success('Result Successfully Saved', [
                //     'key' => 'positive',
                //     'params' => [],
                // ]);
                return $this->redirect(['action' => 'index']);
            }
            $heads = $this->genarate_marks_heads($template);
            $students = $this->filter_data_for_view($students, $heads, $template);
            $this->layout = 'result';
            $this->autoRender = false;
            $this->set('students', $students);
            $this->set('scms_activity_remarks', $scms_activity_remarks);
            $heads = $this->viewAbleHead($heads);
            $this->set('heads', $heads['heads']);
            $this->set('notes', $heads['notes']);
            $this->set('save', 'yes');
            $merit_from = $this->get_position($request_data['result_template_id']);
            $this->set('position', $merit_from);
            $exam_title = $this->get_exam_result_title($request_data['session_id'], $request_data['level_id'], $request_data['term_cycle_id']);
            $session = TableRegistry::getTableLocator()->get('scms_sessions');
            $sessions = $session
            ->find()
            ->where(['session_id' => $request_data['session_id']])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
            // echo '<pre>';
            // print_r($sessions);
            if ($section_id) { 
                $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $sessions[0]['session_name'];
            } else { 
                $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $sessions[0]['session_name'];
            }
            $this->set('exam_title', $exam_title);
            $last_row_colspan = $this->find_last_row_colspan($template);
            $this->set('last_row_colspan', $last_row_colspan);
            $this->set('total_attandance', $all_student_attandance['months_data']);
            $this->set('grades', $grades);
            $decemal_point = $this->get_settings_value('number_format_value_after_decimal');
            $this->set('decemal_point', $decemal_point);
            
            $settingTable = TableRegistry::getTableLocator()->get('settings');

            $settings = $settingTable->find()
                ->where(['`key`' => 'result.landscape'])
                ->enableHydration(false)
                ->first();

            if (!empty($settings) && $settings['value'] == 'ON') {
                $this->render('/result/landscape_markSheet');
            } else {
                $this->render('/result/markSheet');
            }

            // $this->render('/result/markSheet');
        }


        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);


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
        $result_template = TableRegistry::getTableLocator()->get('scms_result_template');
        $result_templates = $result_template
            ->find()
            ->where(['deleted' => 0])
            ->where(['type' => 'single'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('result_templates', $result_templates);
        $grading = TableRegistry::getTableLocator()->get('scms_gradings');
        $gradings = $grading
            ->find()
            ->toArray();
        $this->set('gradings', $gradings);

        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles)) {
            $required = '';
        }
        $this->set('required', $required);
        $levels = $this->get_levels('results');
        $this->set('levels', $levels);
    }

    private function viewAbleHead($heads)
    {
        $note = array();
        foreach ($heads as $key => $head) {
            $name = $head['name'];
            if (str_contains($name, 'Without')) {
                $part = substr($name, strpos($name, "Without") + 9);
                $parts = explode(" ", $part);
                $new_name = 'Tw';
                foreach ($parts as $single) {
                    $new_name = $new_name . $single;
                }
                $heads[$key]['name'] = $new_name;
                $single_note['new'] = '*' . $new_name;
                $single_note['old'] = $name;
                $note[] = $single_note;
            } else if (str_contains($name, '%')) {
                $heads[$key]['name'] = (substr($name, 0, strpos($name, "%"))) . '%';
            } else if (str_contains($name, 'With')) {
                $part = substr($name, strpos($name, "With") + 6);
                $parts = explode(" ", $part);
                $new_name = 'GTw';
                foreach ($parts as $single) {
                    $new_name = $new_name . $single;
                }
                $single_note['new'] = '*' . $new_name;
                $single_note['old'] = $name;
                $note[] = $single_note;
                $heads[$key]['name'] = $new_name;
            }
        }
        $return['heads'] = $heads;
        $return['notes'] = $note;
        return $return;
    }

    private function get_merge_studnet_result($terms, $request_data, $template)
    {
        $term_ids = $terms['term_id'];
        $scms_result = TableRegistry::getTableLocator()->get('scms_results');
        $base_results = $scms_result
            ->find()
            ->where(['scms_results.session_id' => $request_data['session_id']])
            ->where(['scms_results.level_id' => $request_data['level_id']])
            ->where(['scms_term_cycle.term_id' => $term_ids[0]])
            ->where(['type' => 'single'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'term_id' => 'scms_term_cycle.term_id',
            ])
            ->join([
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                ],
            ])
            ->toArray();
        unset($term_ids[0]);
        $results = array();
        if (count($terms['term_id'])) {
            $results = $scms_result
                ->find()
                ->where(['scms_results.session_id' => $request_data['session_id']])
                ->where(['scms_results.level_id' => $request_data['level_id']])
                ->where(['scms_term_cycle.term_id IN' => $term_ids])
                ->where(['type' => 'single'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term_id' => 'scms_term_cycle.term_id',
                ])
                ->join([
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                    ],
                ])
                ->toArray();
        }

        if (count($base_results) != count($term_ids)) {
            return -1;
        }
        $base_template = $this->get_template($base_results[0]['result_template_id']);
        $term_cycle_id = $base_results[0]['term_cycle_id'];
        $where['result_id'] = $base_results[0]['result_id'];
        if ($request_data['shift_id']) {
            $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
        }
        if ($request_data['level_id']) {
            $where['scms_student_cycle.level_id'] = $request_data['level_id'];
        }
        if ($request_data['section_id']) {
            $where['scms_student_cycle.section_id'] = $request_data['section_id'];
        }
        if ($request_data['group_id']) {
            $where['scms_student_cycle.group_id'] = $request_data['group_id'];
        }
        if ($request_data['sid']) {
            $where['scms_students.sid'] = $request_data['sid'];
        }

        $students = $this->get_scms_result_students($base_results[0]['result_id'], $where);

        $filter_students = array();
        $student_cycle_ids = array();
        $student_term_cycle_ids = array();
        foreach ($students as $student) {
            $filter_students[$student['student_cycle_id']][$student['term_id']] = $student;
            $student_cycle_ids[] = $student['student_cycle_id'];
            $student_term_cycle_ids[] = $student['student_term_cycle_id'];
        }
        $student_third_fourth_subjects = $this->get_studnet_third_fourth_subjects($student_term_cycle_ids);

        $result_ids = array();

        foreach ($results as $result) {
            $result_ids[] = $result['result_id'];
        }
        unset($where['result_id']);
        $where['result_id IN'] = $result_ids;
        $other_results = $this->get_other_scms_result_students_for_merge($result_ids, $where);

        foreach ($other_results as $other_result) {
            $filter_students[$other_result['student_cycle_id']][$other_result['term_id']] = $other_result;
        }
        $terms_perentage = array();
        foreach ($terms['term_id'] as $key => $term_id) {
            $terms_perentage[$term_id] = $terms['term_percentage'][$key];
        }

        $grade = TableRegistry::getTableLocator()->get('scms_grade');
        $grades = $grade
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->order(['point' => 'ASC'])
            ->where(['gradings_id' => $request_data['gradings_id']])
            ->toArray();

        $query = $grade->find()->where(['gradings_id' => $request_data['gradings_id']]);
        $query->select([
            'max_point' => $query->func()->max('point')
        ])
            ->enableAutoFields(true)
            ->enableHydration(false);
        foreach ($query as $row) {
            $max_point = $row['max_point'];
        }
        $student_cycle_ids = array();
        $seved_student_data = array();
        foreach ($filter_students as $key => $filter_student) {
            $filter_students[$key] = $this->term_merge_courses($filter_student, $terms_perentage, $student_third_fourth_subjects);
            if (isset($template['indivisul_pass_check'])) {
                //indivisul_pass_check subject +total pass check
                $filter_students[$key]['merge_term'] = $this->indivisul_pass_check($filter_students[$key]['merge_term']);
            } else {
                //total pass check
                $filter_students[$key]['merge_term'] = $this->total_pass_check($filter_students[$key]['merge_term']);
            }

            //group_pass_check subject
            if (isset($template['group_pass_check'])) {
                $filter_students[$key]['merge_term'] = $this->group_pass_check($filter_students[$key]['merge_term'], $template['group_pass_check']);
            }
            //group_persentage_check subject
            if (isset($template['group_persentage_check'])) {
                $filter_students[$key]['merge_term'] = $this->group_persentage_and_calculate_total($filter_students[$key]['merge_term'], $template['group_persentage_check']);
            } //total_persentage_check subject
            else if (isset($template['total_persentage_check'])) {
                $filter_students[$key]['merge_term'] = $this->total_persentage_and_calculate_total($filter_students[$key]['merge_term'], $template['total_persentage_check']['value']);
            } else {
                //no persentage calculate total
                $filter_students[$key]['merge_term'] = $this->total_persentage_and_calculate_total($filter_students[$key]['merge_term']);
            }
            if (isset($filter_students[$key]['merge_term']['merge_course'])) {
                foreach ($filter_students[$key]['merge_term']['merge_course'] as $fix_key => $fix_merge_course) {
                    $filter_students[$key]['merge_term']['merge_course'][$fix_key]['result'] = $fix_merge_course['total']['result'];
                }
            }

            //calculate course  gpa
            $filter_students[$key]['merge_term'] = $this->calculate_gpa($filter_students[$key]['merge_term'], $grades);
            //calculate term total and gpa
            $filter_students[$key]['merge_term'] = $this->result_calculation($filter_students[$key]['merge_term'], $max_point, $template, $grades);
            $student_cycle_ids[] = $filter_students[$key]['base_term']['student_cycle_id'];
            if (isset($request_data['save']) && $request_data['save'] == 'yes') {
                $seved_student_data_single = $filter_students[$key]['base_term'];
                unset($seved_student_data_single['guardians']);
                unset($seved_student_data_single['result']);
                unset($seved_student_data_single['attandance_data']);
                unset($seved_student_data_single['courses']);
                unset($seved_student_data_single['merge_course']);
                unset($seved_student_data_single['merge_course']);
                $seved_student_data_single['courses'] = $filter_students[$key]['merge_term']['courses'];
                $seved_student_data_single['merge_course'] = isset($filter_students[$key]['merge_term']['merge_course']) ? $filter_students[$key]['merge_term']['merge_course'] : array();
                $seved_student_data_single['result'] = $filter_students[$key]['merge_term']['result'];
                $seved_student_data[] = $seved_student_data_single;
            }
        }
        if (isset($request_data['save']) && $request_data['save'] == 'yes') {
            $result_where['session_id'] = $request_data['session_id'];
            $result_where['level_id'] = $request_data['level_id'];
            $result_where['term_cycle_id'] = $term_cycle_id;
            $result_where['type'] = 'merge';
            $request_data['term_cycle_id'] = $term_cycle_id;
            $this->update_and_save_result($result_where, $request_data, $seved_student_data, $all_student_attandance = array(), $template, 'merge');

            $this->Flash->success('Merge Result Successfully Saved', [
                'key' => 'positive',
                'params' => [],
            ]);
            return 2;
        }

        $attandance_data = $this->get_merge_attendances($student_cycle_ids, $terms['term_id'], $request_data['level_id'], $request_data['session_id']);

        $base_heads = $this->genarate_marks_heads($base_template);

        $view_base_heads = $base_heads;
        foreach ($results as $result) {
            $gp['name'] = 'GP-' . $result['term_id'];
            $gp['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($base_heads, $gp);
            $total['name'] = 'Total-' . $result['term_id'];
            $total['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($base_heads, $total);

            $view_gp['name'] = 'GP';
            $view_gp['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($view_base_heads, $view_gp);
            $view_total['name'] = 'Total';
            $view_total['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($view_base_heads, $view_total);
        }

        $merge_head = $this->genarate_marks_heads($template, 1);
        if (isset($base_template['merge_subject'])) {
            $template['merge_subject'] = 'yes';
        }

        foreach ($filter_students as $key => $filter_student) {
            $base_term[0] = $filter_students[$key]['base_term'];
            $return_base_term = $this->filter_data_for_view($base_term, $base_heads, $base_template);
            unset($return_base_term[0]['attandance_data']);
            $filter_students[$key]['base_term'] = $return_base_term[0];
            $merge_term[0] = $filter_students[$key]['merge_term'];
            $return_merge_term = $this->filter_data_for_view($merge_term, $merge_head, $template);
            $filter_students[$key]['merge_term'] = $return_merge_term[0];
        }
        foreach ($merge_head as $key => $vel) {
            if (isset($vel['type'])) {
                $merge_head[$key]['name'] = mb_substr($merge_head[$key]['name'], 0, 1);
            }
        }

        $this->layout = 'result';
        $this->autoRender = false;
        $this->set('request_data', $request_data);
        $this->set('students', $filter_students);

        $scms_activity_remarks = $this->default_activities();
        $this->set('scms_activity_remarks', $scms_activity_remarks);
        $view_base_heads = $this->viewAbleHead($view_base_heads);
        $this->set('heads', $view_base_heads['heads']);
        $merge_head = $this->viewAbleHead($merge_head);
        if (count($view_base_heads['notes']) > $merge_head['notes']) {
            $this->set('notes', $view_base_heads['notes']);
        } else {
            $this->set('notes', $merge_head['notes']);
        }
        $this->set('merge_heads', $merge_head['heads']);
        $this->set('save', 'yes');
        $merit_from = $this->get_position($request_data['result_template_id']);
        $this->set('position', $merit_from);
        $students = array_values($filter_students);
        $exam_title = $this->get_exam_result_title($request_data['session_id'], $request_data['level_id'], $term_cycle_id);
        if ($section_id) { 
            $exam_title[2] = $students[0]['base_term']['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['base_term']['session_name'];
        } else { 
            $exam_title[2] = $students[0]['base_term']['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['base_term']['session_name'];
        }
        $this->set('exam_title', $exam_title);
        $last_row_colspan = $this->find_last_row_colspan($base_template);
        $last_row_colspan += (count($template['term']['value']['term_name']) - 1) * 2;
        $this->set('last_row_colspan', $last_row_colspan);
        $last_row_colspan_merge_result = $this->find_last_row_colspan($template);
        $this->set('last_row_colspan_merge_result', $last_row_colspan_merge_result);
        $term_names = $this->find_merge_result_term_names($template['term']['value']['term_name']);
        $this->set('term_names', $term_names);
        $this->set('total_attandance', $attandance_data['months']);
        $this->set('studnet_attandance', $attandance_data['student_attendance_data']);

        $decemal_point = $this->get_settings_value('number_format_value_after_decimal');
        $this->set('decemal_point', $decemal_point);

        $this->render('/result/markSheet_merge');
    }

    private function get_merge_attendances($student_cycle_ids, $term_ids, $level_id, $session_id)
    {
        $scms_result_student_attendance_month = TableRegistry::getTableLocator()->get('scms_result_student_attendance_month');
        $result_attendance_months = $scms_result_student_attendance_month
            ->find()
            ->where(['scms_student_term_cycle.student_cycle_id IN' => $student_cycle_ids])
            ->where(['scms_term_cycle.term_id IN' => $term_ids])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'student_cycle_id' => 'scms_student_term_cycle.student_cycle_id',
            ])
            ->join([
                'scms_result_students' => [
                    'table' => 'scms_result_students',
                    'type' => 'LEFT',
                    'conditions' => ['scms_result_students.result_student_id = scms_result_student_attendance_month.result_student_id'],
                ],
                'scms_student_term_cycle' => [
                    'table' => 'scms_student_term_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_term_cycle.student_term_cycle_id = scms_result_students.student_term_cycle_id'],
                ],
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_term_cycle.term_cycle_id = scms_student_term_cycle.term_cycle_id'],
                ]
            ])->toArray();

        $month[1]['count'] = '--';
        $month[2]['count'] = '--';
        $month[3]['count'] = '--';
        $month[4]['count'] = '--';
        $month[5]['count'] = '--';
        $month[6]['count'] = '--';
        $month[7]['count'] = '--';
        $month[8]['count'] = '--';
        $month[9]['count'] = '--';
        $month[10]['count'] = '--';
        $month[11]['count'] = '--';
        $month[12]['count'] = '--';
        $month[13]['count'] = '--';
        $attendance_data = array();
        foreach ($student_cycle_ids as $student_cycle_id) {
            $attendance_data[$student_cycle_id] = $month;
        }
        foreach ($result_attendance_months as $attendance_month) {
            if ($attendance_data[$attendance_month['student_cycle_id']][$attendance_month['month_id']]['count'] == '--') {
                $attendance_data[$attendance_month['student_cycle_id']][$attendance_month['month_id']]['count'] = $attendance_month['count'];
            } else {
                $attendance_data[$attendance_month['student_cycle_id']][$attendance_month['month_id']]['count'] = +$attendance_month['count'];
            }
        }


        $scms_result_attendance_month = TableRegistry::getTableLocator()->get('scms_result_attendance_month');
        $attendance_months = $scms_result_attendance_month
            ->find()
            ->where(['scms_term_cycle.term_id IN' => $term_ids])
            ->where(['scms_results.session_id' => $session_id])
            ->where(['scms_results.level_id' => $level_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'scms_results' => [
                    'table' => 'scms_results',
                    'type' => 'LEFT',
                    'conditions' => ['scms_results.result_id = scms_result_attendance_month.result_id'],
                ],
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_term_cycle.term_cycle_id = scms_results.term_cycle_id'],
                ]
            ])->toArray();
        foreach ($attendance_months as $attendance_month) {
            if ($month[$attendance_month['month_id']]['count'] == '--') {
                $month[$attendance_month['month_id']]['count'] = $attendance_month['count'];
            } else {
                $month[$attendance_month['month_id']]['count'] = +$attendance_month['count'];
            }
        }
        $return['months'] = $month;
        $return['student_attendance_data'] = $attendance_data;
        return $return;
    }

    private function find_merge_result_term_names($names)
    {
        $return['base_term'] = $names[0];
        unset($names[0]);
        foreach ($names as $name) {
            $return['others'][] = $name;
        }
        return $return;
    }

    private function term_merge_courses($student, $terms, $student_third_fourth_subjects)
    {
        $merge_term = array();
        $return_studnet = array();
        foreach ($student as $term_id => $student_term) {
            if (count($merge_term)) {
                foreach ($student_term['courses'] as $course_id => $single_course) {
                    if (isset($single_course['parts'])) {
                        foreach ($single_course['parts'] as $part_id => $part) {
                            if (isset($merge_term['courses'][$course_id]['parts'][$part_id])) {
                                $merge_term['courses'][$course_id]['parts'][$part_id]['total_mark'] += ($part['total_mark'] * $terms[$term_id]) / 100;
                                $merge_term['courses'][$course_id]['parts'][$part_id]['pass_mark'] += ($part['pass_mark'] * $terms[$term_id]) / 100;
                                $merge_term['courses'][$course_id]['parts'][$part_id]['marks'] += ($part['marks'] * $terms[$term_id]) / 100;
                            } else {
                                $merge_term['courses'][$course_id]['parts'][$part_id]['total_mark'] = ($part['total_mark'] * $terms[$term_id]) / 100;
                                $merge_term['courses'][$course_id]['parts'][$part_id]['pass_mark'] = ($part['pass_mark'] * $terms[$term_id]) / 100;
                                $merge_term['courses'][$course_id]['parts'][$part_id]['marks'] = ($part['marks'] * $terms[$term_id]) / 100;
                            }
                        }
                    }

                    $return_studnet['base_term']['courses'][$course_id]['term'][$term_id]['Total-' . $term_id] = $single_course['result']['marks'];
                    $return_studnet['base_term']['courses'][$course_id]['term'][$term_id]['GP-' . $term_id] = $single_course['result']['point'];
                }
                if (isset($student_term['merge_course'])) {
                    foreach ($student_term['merge_course'] as $key => $merge_course) {
                        foreach ($merge_course as $key2 => $merge_course_single) {
                            if (isset($merge_course_single['parts'])) {
                                foreach ($merge_course_single['parts'] as $part_id => $part) {
                                    $merge_term['merge_course'][$key][$key2]['parts'][$part_id]['total_mark'] += ($part['total_mark'] * $terms[$term_id]) / 100;
                                    $merge_term['merge_course'][$key][$key2]['parts'][$part_id]['pass_mark'] += ($part['pass_mark'] * $terms[$term_id]) / 100;
                                    $merge_term['merge_course'][$key][$key2]['parts'][$part_id]['marks'] += ($part['marks'] * $terms[$term_id]) / 100;
                                }
                            }
                        }
                        $return_studnet['base_term']['merge_course'][$key]['total']['term'][$term_id]['Total-' . $term_id] = $merge_course['total']['result']['marks'];
                        $return_studnet['base_term']['merge_course'][$key]['total']['term'][$term_id]['GP-' . $term_id] = $merge_course['total']['result']['point'];
                    }
                }
            } else {
                $return_studnet['base_term'] = $student_term;
                $return = $this->set_initial_merge_course_for_single_studnet($student_term, $terms[$term_id]);
                $merge_term = $return['merge_term'];
                $merge_term['third_fourth_subjects'] = isset($student_third_fourth_subjects[$student_term['student_term_cycle_id']]) ? $student_third_fourth_subjects[$student_term['student_term_cycle_id']] : null;
            }
        }
        $return_studnet['merge_term'] = $merge_term;

        return $return_studnet;
    }

    private function set_initial_merge_course_for_single_studnet($term, $percentage)
    {
        foreach ($term['courses'] as $course_id => $single_course) {
            $new_term['courses'][$course_id]['course_name'] = $single_course['course_name'];
            $new_term['courses'][$course_id]['course_code'] = $single_course['course_code'];
            $new_term['courses'][$course_id]['course_id'] = $single_course['course_id'];
            $new_term['courses'][$course_id]['total_marks'] = $single_course['result']['total_marks'];
            $new_term['courses'][$course_id]['pass_marks'] = $single_course['result']['pass_marks'];
            $new_term['courses'][$course_id]['marks'] = $single_course['result']['marks'];
            $new_term['courses'][$course_id]['result'] = $single_course['result']['result'];
            $new_term['courses'][$course_id]['grade_name'] = $single_course['result']['grade_name'];
            $new_term['courses'][$course_id]['point'] = $single_course['result']['point'];

            $merge_term['courses'][$course_id]['course_name'] = $single_course['course_name'];
            $merge_term['courses'][$course_id]['student_term_course_cycle_id'] = $single_course['student_term_course_cycle_id'];
            $merge_term['courses'][$course_id]['course_code'] = $single_course['course_code'];
            $merge_term['courses'][$course_id]['course_id'] = $single_course['course_id'];
            $merge_term['courses'][$course_id]['course_type_id'] = $single_course['course_type_id'];

            if (isset($single_course['parts'])) {
                foreach ($single_course['parts'] as $part_id => $part) {
                    $merge_term['courses'][$course_id]['parts'][$part_id]['term_course_cycle_part_type_name'] = $part['term_course_cycle_part_type_name'];
                    $merge_term['courses'][$course_id]['parts'][$part_id]['term_course_cycle_part_type_id'] = $part['term_course_cycle_part_type_id'];
                    $merge_term['courses'][$course_id]['parts'][$part_id]['term_course_cycle_part_id'] = $part['term_course_cycle_part_id'];
                    $merge_term['courses'][$course_id]['parts'][$part_id]['total_mark'] = ($part['total_mark'] * $percentage) / 100;
                    $merge_term['courses'][$course_id]['parts'][$part_id]['pass_mark'] = ($part['pass_mark'] * $percentage) / 100;
                    $merge_term['courses'][$course_id]['parts'][$part_id]['marks'] = ($part['obtain_mark'] * $percentage) / 100;
                }
            } else {
                $merge_term['courses'][$course_id]['parts'] = array();
            }
        }
        if (isset($term['merge_course'])) {
            foreach ($term['merge_course'] as $key => $merge_course) {
                foreach ($merge_course as $key2 => $merge_course_single) {
                    if (is_int($key2)) {
                        $new_term['merge_course'][$key][$key2]['course_name'] = $merge_course_single['course_name'];
                        $new_term['merge_course'][$key][$key2]['course_code'] = $merge_course_single['course_code'];
                        $new_term['merge_course'][$key][$key2]['course_id'] = $merge_course_single['course_id'];
                        $merge_term['merge_course'][$key][$key2]['course_name'] = $merge_course_single['course_name'];
                        $merge_term['merge_course'][$key][$key2]['course_code'] = $merge_course_single['course_code'];
                        $merge_term['merge_course'][$key][$key2]['course_id'] = $merge_course_single['course_id'];
                        $merge_term['merge_course'][$key][$key2]['course_type_id'] = $merge_course_single['course_type_id'];
                        $merge_term['merge_course'][$key][$key2]['student_term_course_cycle_id'] = $merge_course_single['student_term_course_cycle_id'];
                    } else if ($key2 == 'total') {
                        $new_term['merge_course'][$key]['total']['total_marks'] = $merge_course_single['result']['total_marks'];
                        $new_term['merge_course'][$key]['total']['pass_marks'] = $merge_course_single['result']['pass_marks'];
                        $new_term['merge_course'][$key]['total']['marks'] = $merge_course_single['result']['marks'];
                        $new_term['merge_course'][$key]['total']['result'] = $merge_course_single['result']['result'];
                        $new_term['merge_course'][$key]['total']['grade_name'] = $merge_course_single['result']['grade_name'];
                        $new_term['merge_course'][$key]['total']['point'] = $merge_course_single['result']['point'];
                    }
                    if (isset($merge_course_single['parts'])) {
                        foreach ($merge_course_single['parts'] as $part_id => $part) {
                            $merge_term['merge_course'][$key][$key2]['parts'][$part_id]['term_course_cycle_part_type_name'] = $part['term_course_cycle_part_type_name'];
                            $merge_term['merge_course'][$key][$key2]['parts'][$part_id]['term_course_cycle_part_type_id'] = $part['term_course_cycle_part_type_id'];
                            $merge_term['merge_course'][$key][$key2]['parts'][$part_id]['total_mark'] = ($part['total_mark'] * $percentage) / 100;
                            $merge_term['merge_course'][$key][$key2]['parts'][$part_id]['pass_mark'] = ($part['pass_mark'] * $percentage) / 100;
                            $merge_term['merge_course'][$key][$key2]['parts'][$part_id]['marks'] = ($part['marks'] * $percentage) / 100;
                        }
                    }
                }
            }
        }

        $return['new_term'] = $new_term;
        $return['merge_term'] = $merge_term;
        return $return;
    }

    private function get_other_scms_result_students_for_merge($result_ids, $where)
    {
        $where['scms_students.status'] = 1;
        $scms_result_students = TableRegistry::getTableLocator()->get('scms_result_students');
        $result_students = $scms_result_students->find()->where($where)->enableAutoFields(true)->enableHydration(false)->select([
            'shift_id' => 'scms_student_cycle.shift_id',
            'section_ids' => 'scms_student_cycle.section_id',
            'student_cycle_id' => 'scms_student_cycle.student_cycle_id',
            'student_id' => 'scms_student_cycle.student_id',
            'level_id' => 'scms_student_cycle.level_id',
            'roll' => 'scms_student_cycle.roll',
            'term_id' => 'scms_term_cycle.term_id',
            'status' => 'scms_students.status',
        ])->join([
                    'scms_student_term_cycle' => [
                        'table' => 'scms_student_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_term_cycle.student_term_cycle_id = scms_result_students.student_term_cycle_id'],
                    ],
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_term_cycle.term_cycle_id = scms_term_cycle.term_cycle_id'],
                    ],
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_cycle.student_cycle_id  = scms_student_term_cycle.student_cycle_id'],
                    ],
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'LEFT',
                        'conditions' => ['scms_students.student_id  = scms_student_cycle.student_id'],
                    ],
                ])->toArray();

        $filter_result_studnets = array();
        $result_student_ids = array();
        foreach ($result_students as $result_student) {
            $filter_result_studnets[$result_student['result_student_id']] = $result_student;
            $result_student_ids[] = $result_student['result_student_id'];
        }
        $filter_result_studnets = $this->get_result_student_courses($result_student_ids, $filter_result_studnets);
        return $filter_result_studnets;
    }

    public function generateMergeResult()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $template = $this->get_template($request_data['result_template_id']);
            $result_students = $this->get_merge_studnet_result($template['term']['value'], $request_data, $template);
            if ($result_students == -1) {
                $this->Flash->success('Result not Found', [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'generateMergeResult']);
            }
            if ($result_students == 2) {
                return $this->redirect(['action' => 'mergeResult']);
            }
        }


        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->toArray();
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
        $result_template = TableRegistry::getTableLocator()->get('scms_result_template');
        $result_templates = $result_template
            ->find()
            ->where(['deleted' => 0])
            ->where(['type' => 'merge'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('result_templates', $result_templates);
        $grading = TableRegistry::getTableLocator()->get('scms_gradings');
        $gradings = $grading
            ->find()
            ->toArray();
        $this->set('gradings', $gradings);
    }

    private function get_studnet_third_fourth_subjects($student_term_cycle_ids)
    {
        $scms_third_and_forth_subject = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
        $students_third_and_forth_subjects = $scms_third_and_forth_subject
            ->find()
            ->where(['scms_student_term_cycle.student_term_cycle_id IN' => $student_term_cycle_ids])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'student_term_cycle_id' => 'scms_student_term_cycle.student_term_cycle_id',
            ])
            ->join([
                'scms_student_term_cycle' => [
                    'table' => 'scms_student_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_third_and_forth_subject.student_cycle_id  = scms_student_term_cycle.student_cycle_id'],
                ],
            ])
            ->toArray();

        $return = array();
        foreach ($students_third_and_forth_subjects as $students_third_and_forth_subject) {
            $return[$students_third_and_forth_subject['student_term_cycle_id']][$students_third_and_forth_subject['type']][$students_third_and_forth_subject['course_id']] = 1;
        }
        return $return;
    }

    private function default_activities()
    {
        $default_activity_single_1['activity_name'] = 'extra activities';
        $default_activity_single_1['remark'][0]['remark_name'] = 'Cultural Activity/Dramatic Performance';
        $default_activity_single_1['remark'][0]['activity_remark_id'] = null;
        $default_activity_single_1['remark'][1]['remark_name'] = 'Scout/BNCC/Red Crescent';
        $default_activity_single_1['remark'][1]['activity_remark_id'] = null;
        $default_activity_single_1['remark'][2]['remark_name'] = 'Games And Sports';
        $default_activity_single_1['remark'][2]['activity_remark_id'] = null;
        $default_activity_single_1['remark'][3]['remark_name'] = 'Math/Science Olympiad';
        $default_activity_single_1['remark'][3]['activity_remark_id'] = null;

        $default_activity[] = $default_activity_single_1;

        $default_activity_single_2['activity_name'] = 'ACHIEVEMENT';
        $default_activity_single_2['remark'][0]['remark_name'] = 'Outstanding';
        $default_activity_single_2['remark'][0]['activity_remark_id'] = null;
        $default_activity_single_2['remark'][1]['remark_name'] = 'Excellent';
        $default_activity_single_2['remark'][1]['activity_remark_id'] = null;
        $default_activity_single_2['remark'][2]['remark_name'] = 'Good';
        $default_activity_single_2['remark'][2]['activity_remark_id'] = null;
        $default_activity_single_2['remark'][3]['remark_name'] = 'Need To Improve';
        $default_activity_single_2['remark'][3]['activity_remark_id'] = null;
        $default_activity[] = $default_activity_single_2;
        return $default_activity;
    }

    private function get_student_activity($student_term_cycle_ids, $value)
    {
        $scms_activity_remark = TableRegistry::getTableLocator()->get('scms_activity_remark');
        $scms_activity_remarks = $scms_activity_remark
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['scms_activity_remark.activity_id IN' => $value])
            ->where(['scms_activity_remark.deleted' => 0])
            ->select([
                'activity_name' => 'scms_activity.name',
            ])
            ->join([
                'scms_activity' => [
                    'table' => 'scms_activity',
                    'type' => 'LEFT',
                    'conditions' => ['scms_activity.activity_id   = scms_activity_remark.activity_id'],
                ],
            ])
            ->toArray();
        $filter_scms_activity_remarks = array();
        foreach ($scms_activity_remarks as $activity_remark) {
            $filter_scms_activity_remarks[$activity_remark['activity_id']]['activity_name'] = $activity_remark['activity_name'];
            $filter_scms_activity_remarks[$activity_remark['activity_id']]['activity_id'] = $activity_remark['activity_id'];
            $filter_scms_activity_remarks[$activity_remark['activity_id']]['remark'][$activity_remark['activity_remark_id']]['remark_name'] = $activity_remark['remark_name'];
            $filter_scms_activity_remarks[$activity_remark['activity_id']]['remark'][$activity_remark['activity_remark_id']]['activity_remark_id'] = $activity_remark['activity_remark_id'];
        }
        $scms_student_activity = TableRegistry::getTableLocator()->get('scms_student_activity');
        $student_activities = $scms_student_activity
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['student_term_cycle_id IN' => $student_term_cycle_ids])
            ->select([
                'activity_id' => 'scms_activity_cycle.activity_id',
            ])
            ->join([
                'scms_term_activity_cycle' => [
                    'table' => 'scms_term_activity_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_activity_cycle.term_activity_cycle_id   = scms_student_activity.term_activity_cycle_id'],
                ],
                'scms_activity_cycle' => [
                    'table' => 'scms_activity_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_activity_cycle.activity_cycle_id  = scms_activity_cycle.activity_cycle_id'],
                ],
            ])
            ->toArray();
        $filter_student_activities = array();
        foreach ($student_activities as $activity) {
            $activity_remarks = json_decode($activity['remark_id']);
            $remark_ids = array();
            foreach ($activity_remarks as $activity_remark) {
                $remark_ids[$activity_remark] = 1;
            }
            $filter_student_activities[$activity['student_term_cycle_id']][$activity['activity_id']] = $remark_ids;
        }
        $return['scms_activity_remarks'] = $filter_scms_activity_remarks;
        $return['student_activities'] = $filter_student_activities;
        return $return;
    }

    private function find_last_row_colspan($template)
    {
        if (isset($template['group_persentage_check']) || isset($template['total_persentage_check'])) {
            $return = 11;
        } else {
            $return = 9;
        }
        return $return;
    }

    private function get_exam_result_title($session_id, $level_id, $term_cycle_id)
    {
        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->where(['level_id' => $level_id])
            ->toArray();

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->where(['session_id' => $session_id])
            ->toArray();

        $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $scms_term_cycles = $scms_term_cycle
            ->find()
            ->where(['term_cycle_id' => $term_cycle_id])
            ->select([
                'term_name' => 'scms_term.term_name',
            ])
            ->join([
                'scms_term' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term.term_id  = scms_term_cycle.term_id'],
                ],
            ])
            ->toArray();
        $title['title'] = $scms_term_cycles[0]->term_name;
        $title[0] = $scms_term_cycles[0]->term_name . '-' . $sessions[0]->session_name;
        $title[1] = $levels[0]->level_name . '/EQUIVALENT RESULT PUBLICATION ' . $sessions[0]->session_name;
        return $title;
    }

    private function delete_student_result($ids)
    {
        $scms_result_students = TableRegistry::getTableLocator()->get('scms_result_students');
        $query = $scms_result_students->query();
        $query->delete()
            ->where(['result_student_id IN' => $ids])
            ->execute();

        $scms_result_student_attendance_month = TableRegistry::getTableLocator()->get('scms_result_student_attendance_month');
        $query = $scms_result_student_attendance_month->query();
        $query->delete()
            ->where(['result_student_id IN' => $ids])
            ->execute();

        $scms_result_student_courses = TableRegistry::getTableLocator()->get('scms_result_student_courses');
        $result_student_courses = $scms_result_student_courses
            ->find()
            ->where(['result_student_id IN' => $ids])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        foreach ($result_student_courses as $result_student_course) {
            $result_student_course_ids[] = $result_student_course['result_student_course_id'];
        }
        if (isset($result_student_course_ids)) {
            $query = $scms_result_student_courses->query();
            $query->delete()
                ->where(['result_student_course_id IN' => $result_student_course_ids])
                ->execute();

            $scms_result_student_course_parts = TableRegistry::getTableLocator()->get('scms_result_student_course_parts');
            $query = $scms_result_student_course_parts->query();
            $query->delete()
                ->where(['result_student_course_id IN' => $result_student_course_ids])
                ->execute();

            $scms_result_student_course_persentage_groups = TableRegistry::getTableLocator()->get('scms_result_student_course_persentage_groups');
            $query = $scms_result_student_course_persentage_groups->query();
            $query->delete()
                ->where(['result_student_course_id IN' => $result_student_course_ids])
                ->execute();
        }


        return true;
    }

    private function find_previous_student_course_result($result_id, $student_term_cycle_id)
    {
        $student_term_cycle_id = $student_term_cycle_id * 1;
        $return = array();
        $scms_result_students = TableRegistry::getTableLocator()->get('scms_result_students');
        $previous_results = $scms_result_students
            ->find()
            ->where(['result_id' => $result_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        foreach ($previous_results as $previous_result) {
            $filer_previous_results[$previous_result['student_term_cycle_id']] = $previous_result;
        }

        if (isset($filer_previous_results[$student_term_cycle_id])) {
            return $filer_previous_results[$student_term_cycle_id];
        }

        return $return;
    }

    private function update_and_save_result($result_where, $request_data, $students, $attendance_months_data, $template, $type)
    {
        $result_data['session_id'] = $request_data['session_id'];
        $result_data['level_id'] = $request_data['level_id'];
        $result_data['term_cycle_id'] = isset($request_data['term_cycle_id']) ? $request_data['term_cycle_id'] : null;
        $result_data['result_template_id'] = $request_data['result_template_id'];
        $result_data['gradings_id'] = $request_data['gradings_id'];
        $result_data['type'] = $type;
        $result_data['created_by'] = $this->Auth->user('id');
        $result_data['created_date'] = date("Y-m-d h:i:sa");

        $scms_result = TableRegistry::getTableLocator()->get('scms_results');
        $previous_result = $scms_result
            ->find()
            ->where($result_where)
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        if (count($previous_result) > 0) {
            $query = $scms_result->query();
            $query->update()
                ->set($result_data)
                ->where(['result_id' => $previous_result[0]['result_id']])
                ->execute();
            $result_students_data['result_id'] = $previous_result[0]['result_id'];

            //save to update log
            $this->insert_delete_update_log('result', 'update_and_save_result', 'update', json_encode($previous_result[0]));
        } else {
            $query = $scms_result->query();
            $query->insert(['session_id', 'level_id', 'term_cycle_id', 'result_template_id', 'gradings_id', 'type', 'created_by', 'created_date'])
                ->values($result_data)
                ->execute();
            $myrecords = $scms_result->find()->last(); //get the last id
            $result_students_data['result_id'] = $myrecords->result_id;
        }
        if (isset($template['activity']['value'])) {
            $this->update_result_activity($template['activity']['value'], $result_students_data['result_id']);
        }

        $result_attendance_month = array();
        foreach ($attendance_months_data as $key => $months_data) {
            if ($months_data['count'] != '--') {
                $single_result_attendance_month['count'] = $months_data['count'];
                $single_result_attendance_month['month_id'] = $key;
                $single_result_attendance_month['result_id'] = $result_students_data['result_id'];
                $result_attendance_month[] = $single_result_attendance_month;
            }
        }
        $this->delete_and_save_scms_result_attendance_month($result_attendance_month, $result_students_data['result_id']);

        $result_students_data['section_id'] = $request_data['section_id'];
        $result_students_data['group_id'] = $request_data['section_id'];
        $result_id = $result_students_data['result_id'];
        $all_students = array();
        $all_filter_students = array();
        $student_term_cycle_ids = array();
        $scms_result_students = TableRegistry::getTableLocator()->get('scms_result_students');
        $scms_result_student_courses = TableRegistry::getTableLocator()->get('scms_result_student_courses');

        foreach ($students as $student) {
            $result_students_data['total_marks'] = $student['result']['total_marks'];
            $result_students_data['marks'] = $student['result']['marks'];
            $result_students_data['point'] = $student['result']['point'];
            $result_students_data['gpa'] = $student['result']['gpa'];
            $result_students_data['marks_with_forth_subject'] = $student['result']['marks_with_forth_subject'];
            $result_students_data['point_with_forth_subject'] = $student['result']['point_with_forth_subject'];
            $result_students_data['gpa_with_forth_subject'] = $student['result']['gpa_with_forth_subject'];
            $result_students_data['result'] = $student['result']['result'];
            $result_students_data['course_count'] = $student['result']['course_count'];
            $result_students_data['grade'] = $student['result']['grade'];
            $result_students_data['grade_with_forth_subject'] = $student['result']['grade_with_forth_subject'];
            $result_students_data['student_term_cycle_id'] = $student['student_term_cycle_id'];
            $all_students[] = $result_students_data;
            $student_term_cycle_ids[] = $student['student_term_cycle_id'];
            if (isset($student['merge_course'])) {
                foreach ($student['merge_course'] as $merge_course) {
                    $merge_courses[$merge_course[0]['course_id']] = $merge_course;
                    $student['merge_course'] = $merge_courses;
                }
            }
            $all_filter_students[$student['student_term_cycle_id']] = $student;
        }
        $privious_students = $scms_result_students
            ->find()
            ->where(['result_id' => $result_id])
            ->where(['student_term_cycle_id IN' => $student_term_cycle_ids])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $delete_students_ids = array();
        foreach ($privious_students as $privious_student) {
            $delete_students_ids[] = $privious_student['result_student_id'];
            if (count($delete_students_ids) > 0) {
                $this->delete_student_result($delete_students_ids);
            }
        }

        $result_student_columns = array_keys($all_students[0]);
        $insertQueryResultStudent = $scms_result_students->query();
        $insertQueryResultStudent->insert($result_student_columns);
        // you must always alter the values clause AFTER insert
        $insertQueryResultStudent->clause('values')->values($all_students);
        $insertQueryResultStudent->execute();

        $saved_students = $scms_result_students
            ->find()
            ->where(['result_id' => $result_id])
            ->where(['student_term_cycle_id IN' => $student_term_cycle_ids])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $result_students_course_data_all = array();
        $result_student_attendance = array();
        foreach ($saved_students as $saved_student) {
            //attandance_data start
            if (isset($all_filter_students[$saved_student['student_term_cycle_id']]['attandance_data'])) {
                foreach ($all_filter_students[$saved_student['student_term_cycle_id']]['attandance_data'] as $key => $attandance_data) {
                    if ($attandance_data['count'] != '--') {
                        $single_result_student_attendance['count'] = $attandance_data['count'];
                        $single_result_student_attendance['month_id'] = $key;
                        $single_result_student_attendance['result_student_id'] = $saved_student['result_student_id'];
                        $result_student_attendance[] = $single_result_student_attendance;
                    }
                }
            }

            //attandance_data end
//single course start
            if (isset($all_filter_students[$saved_student['student_term_cycle_id']]['courses'])) {
                foreach ($all_filter_students[$saved_student['student_term_cycle_id']]['courses'] as $courses) {
                    $result_students_course_data['student_term_course_cycle_id'] = $courses['student_term_course_cycle_id'];
                    $result_students_course_data['course_id'] = $courses['course_id'];
                    $result_students_course_data['total_mark'] = $courses['result']['total_marks'];
                    $result_students_course_data['pass_mark'] = $courses['result']['pass_marks'];
                    $result_students_course_data['obtain_mark'] = $courses['result']['marks'];
                    $result_students_course_data['grade'] = $courses['result']['grade_name'];
                    $result_students_course_data['grade_point'] = $courses['result']['point'];
                    $result_students_course_data['result'] = $courses['result']['result'];
                    $result_students_course_data['type'] = 'single';
                    $result_students_course_data['result_student_id'] = $saved_student['result_student_id'];
                    $result_students_course_data['first_course_id_of_merge_course'] = null;
                    $result_students_course_data['second_course_id_of_merge_course'] = null;
                    $result_students_course_data_all[] = $result_students_course_data;
                }
            }

            //single course end
//marge course start
            if (isset($all_filter_students[$saved_student['student_term_cycle_id']]['merge_course'])) {
                foreach ($all_filter_students[$saved_student['student_term_cycle_id']]['merge_course'] as $merge_course) {
                    $result_students_merge_course_data['result_student_id'] = $saved_student['result_student_id'];
                    $result_students_merge_course_data['student_term_course_cycle_id'] = 0;
                    $result_students_merge_course_data['course_id'] = 0;
                    $result_students_merge_course_data['total_mark'] = $merge_course['result']['total_marks'];
                    $result_students_merge_course_data['pass_mark'] = $merge_course['result']['pass_marks'];
                    $result_students_merge_course_data['obtain_mark'] = $merge_course['result']['marks'];
                    $result_students_merge_course_data['grade'] = $merge_course['result']['grade_name'];
                    $result_students_merge_course_data['grade_point'] = $merge_course['result']['point'];
                    $result_students_merge_course_data['result'] = $merge_course['result']['result'];
                    $result_students_merge_course_data['type'] = 'merge';
                    $result_students_merge_course_data['first_course_id_of_merge_course'] = $merge_course[0]['course_id'];
                    $result_students_merge_course_data['second_course_id_of_merge_course'] = $merge_course[1]['course_id'];
                    $result_students_course_data_all[] = $result_students_merge_course_data;
                }
            }

            //merge course end
        }



        if (count($result_student_attendance) > 0) {
            //insert scms_result_student_attendance_month start
            $scms_result_student_attendance_month = TableRegistry::getTableLocator()->get('scms_result_student_attendance_month');
            $insertQueryResultStudentAttendanceMonth = $scms_result_student_attendance_month->query();
            $result_student_attendance_month_columns = array_keys($result_student_attendance[0]);
            $insertQueryResultStudentAttendanceMonth->insert($result_student_attendance_month_columns);
            $insertQueryResultStudentAttendanceMonth->clause('values')->values($result_student_attendance);
            $insertQueryResultStudentAttendanceMonth->execute();
            //end  scms_result_student_attendance_month
        }


        $insertQueryResultStudentCourse = $scms_result_student_courses->query();
        $result_student_course_columns = array_keys($result_students_course_data_all[0]);
        $insertQueryResultStudentCourse->insert($result_student_course_columns);
        // you must always alter the values clause AFTER insert
        $insertQueryResultStudentCourse->clause('values')->values($result_students_course_data_all);
        $insertQueryResultStudentCourse->execute();

        $saved_single_courses = $scms_result_student_courses
            ->find()
            ->where(['scms_result_students.result_id' => $result_id])
            ->where(['scms_result_students.student_term_cycle_id IN' => $student_term_cycle_ids])
            ->where(['parent_result_student_course_id is NULL'])
            ->where(['type' => 'single'])
            ->select([
                'student_term_cycle_id' => 'scms_result_students.student_term_cycle_id'
            ])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'scms_result_students' => [
                    'table' => 'scms_result_students',
                    'type' => 'LEFT',
                    'conditions' => ['scms_result_students.result_student_id  = scms_result_student_courses.result_student_id'],
                ]
            ])
            ->toArray();

        $result_student_course_parts_data_all = array();
        $persentage_groups_data_all = array();
        foreach ($saved_single_courses as $saved_single_course) {
            if (isset($all_filter_students[$saved_single_course['student_term_cycle_id']]['courses'][$saved_single_course['course_id']]['parts'])) {
                foreach ($all_filter_students[$saved_single_course['student_term_cycle_id']]['courses'][$saved_single_course['course_id']]['parts'] as $parts) {
                    $result_student_course_parts_data['term_course_cycle_part_type_id'] = $parts['term_course_cycle_part_type_id'];
                    $result_student_course_parts_data['term_course_cycle_part_id'] = $parts['term_course_cycle_part_id'];
                    $result_student_course_parts_data['total_mark'] = $parts['total_mark'];
                    $result_student_course_parts_data['pass_mark'] = $parts['pass_mark'];
                    $result_student_course_parts_data['obtain_mark'] = $parts['marks'];
                    $result_student_course_parts_data['result_student_course_id'] = $saved_single_course['result_student_course_id'];
                    $result_student_course_parts_data_all[] = $result_student_course_parts_data;
                }
            }
            if (isset($all_filter_students[$saved_single_course['student_term_cycle_id']]['courses'][$saved_single_course['course_id']]['persentage_groups'])) {
                foreach ($all_filter_students[$saved_single_course['student_term_cycle_id']]['courses'][$saved_single_course['course_id']]['persentage_groups'] as $persentage_groups) {
                    $persentage_groups_data['total_mark'] = $persentage_groups['total_marks'];
                    $persentage_groups_data['pass_mark'] = $persentage_groups['pass_marks'];
                    $persentage_groups_data['mark'] = $persentage_groups['marks'];
                    $persentage_groups_data['result_student_course_id'] = $saved_single_course['result_student_course_id'];
                    $persentage_groups_data_all[] = $persentage_groups_data;
                }
            }
        }
        $saved_merge_courses = $scms_result_student_courses
            ->find()
            ->where(['scms_result_students.result_id' => $result_id])
            ->where(['scms_result_students.student_term_cycle_id IN' => $student_term_cycle_ids])
            ->where(['parent_result_student_course_id is NULL'])
            ->where(['type' => 'merge'])
            ->select([
                'student_term_cycle_id' => 'scms_result_students.student_term_cycle_id'
            ])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'scms_result_students' => [
                    'table' => 'scms_result_students',
                    'type' => 'LEFT',
                    'conditions' => ['scms_result_students.result_student_id  = scms_result_student_courses.result_student_id'],
                ]
            ])
            ->toArray();
        if (count($saved_merge_courses) > 0) {
            $result_students_course_data_single_all = array();
            foreach ($saved_merge_courses as $saved_merge_course) {
                //merge course parts
                if (isset($all_filter_students[$saved_merge_course['student_term_cycle_id']]['merge_course'][$saved_merge_course['first_course_id_of_merge_course']]['total']['parts'])) {
                    foreach ($all_filter_students[$saved_merge_course['student_term_cycle_id']]['merge_course'][$saved_merge_course['first_course_id_of_merge_course']]['total']['parts'] as $parts) {
                        $result_student_course_parts_data['term_course_cycle_part_type_id'] = $parts['term_course_cycle_part_type_id'];
                        $result_student_course_parts_data['term_course_cycle_part_id'] = 0;
                        $result_student_course_parts_data['total_mark'] = $parts['total_mark'];
                        $result_student_course_parts_data['pass_mark'] = $parts['pass_mark'];
                        $result_student_course_parts_data['obtain_mark'] = $parts['marks'];
                        $result_student_course_parts_data['result_student_course_id'] = $saved_merge_course['result_student_course_id'];
                        $result_student_course_parts_data_all[] = $result_student_course_parts_data;
                    }
                }
                //merge course percentage group
                if (isset($all_filter_students[$saved_merge_course['student_term_cycle_id']]['merge_course'][$saved_merge_course['first_course_id_of_merge_course']]['total']['persentage_groups'])) {
                    foreach ($all_filter_students[$saved_merge_course['student_term_cycle_id']]['merge_course'][$saved_merge_course['first_course_id_of_merge_course']]['total']['persentage_groups'] as $persentage_groups) {
                        $persentage_groups_data['total_mark'] = $persentage_groups['total_marks'];
                        $persentage_groups_data['pass_mark'] = $persentage_groups['pass_marks'];
                        $persentage_groups_data['mark'] = $persentage_groups['marks'];
                        $persentage_groups_data['result_student_course_id'] = $saved_merge_course['result_student_course_id'];
                        $persentage_groups_data_all[] = $persentage_groups_data;
                    }
                }
                unset($all_filter_students[$saved_merge_course['student_term_cycle_id']]['merge_course'][$saved_merge_course['first_course_id_of_merge_course']]['total']);
                unset($all_filter_students[$saved_merge_course['student_term_cycle_id']]['merge_course'][$saved_merge_course['first_course_id_of_merge_course']]['result']);
                if (isset($all_filter_students[$saved_merge_course['student_term_cycle_id']]['merge_course'][$saved_merge_course['first_course_id_of_merge_course']])) {
                    foreach ($all_filter_students[$saved_merge_course['student_term_cycle_id']]['merge_course'][$saved_merge_course['first_course_id_of_merge_course']] as $merge_single_course) {
                        $result_students_course_data_single['result_student_id'] = $saved_merge_course['result_student_id'];
                        $result_students_course_data_single['student_term_course_cycle_id'] = $merge_single_course['student_term_course_cycle_id'];
                        $result_students_course_data_single['course_id'] = $merge_single_course['course_id'];
                        $result_students_course_data_single['total_mark'] = $merge_single_course['result']['total_marks'];
                        $result_students_course_data_single['pass_mark'] = $merge_single_course['result']['pass_marks'];
                        $result_students_course_data_single['obtain_mark'] = $merge_single_course['result']['marks'];
                        $result_students_course_data_single['result'] = $merge_single_course['result']['result'];
                        $result_students_course_data_single['type'] = 'single';
                        $result_students_course_data_single['parent_result_student_course_id'] = $saved_merge_course['result_student_course_id'];
                        $result_students_course_data_single['first_course_id_of_merge_course'] = $saved_merge_course['first_course_id_of_merge_course'];
                        $result_students_course_data_single_all[] = $result_students_course_data_single;
                    }
                }
            }

            $insertQueryResultStudentSingleCourse = $scms_result_student_courses->query();
            $result_student_single_course_columns = array_keys($result_students_course_data_single_all[0]);
            $insertQueryResultStudentSingleCourse->insert($result_student_single_course_columns);
            // you must always alter the values clause AFTER insert
            $insertQueryResultStudentSingleCourse->clause('values')->values($result_students_course_data_single_all);
            $insertQueryResultStudentSingleCourse->execute();

            $saved_merge_single_courses = $scms_result_student_courses
                ->find()
                ->where(['scms_result_students.result_id' => $result_id])
                ->where(['scms_result_students.student_term_cycle_id IN' => $student_term_cycle_ids])
                ->where(['parent_result_student_course_id is Not NULL'])
                ->where(['type' => 'single'])
                ->select([
                    'student_term_cycle_id' => 'scms_result_students.student_term_cycle_id'
                ])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->join([
                    'scms_result_students' => [
                        'table' => 'scms_result_students',
                        'type' => 'LEFT',
                        'conditions' => ['scms_result_students.result_student_id  = scms_result_student_courses.result_student_id'],
                    ]
                ])
                ->toArray();

            foreach ($saved_merge_single_courses as $saved_merge_single_course) {
                foreach ($all_filter_students[$saved_merge_single_course['student_term_cycle_id']]['merge_course'][$saved_merge_single_course['first_course_id_of_merge_course']] as $merge_single_course) {
                    if ($merge_single_course['course_id'] == $saved_merge_single_course['course_id']) {
                        if (isset($merge_single_course['parts'])) {
                            foreach ($merge_single_course['parts'] as $parts) {
                                $result_student_course_parts_data['term_course_cycle_part_type_id'] = $parts['term_course_cycle_part_type_id'];
                                $result_student_course_parts_data['term_course_cycle_part_id'] = 0;
                                $result_student_course_parts_data['total_mark'] = $parts['total_mark'];
                                $result_student_course_parts_data['pass_mark'] = $parts['pass_mark'];
                                $result_student_course_parts_data['obtain_mark'] = $parts['marks'];
                                $result_student_course_parts_data['result_student_course_id'] = $saved_merge_single_course['result_student_course_id'];
                                $result_student_course_parts_data_all[] = $result_student_course_parts_data;
                            }
                        }

                        if (isset($merge_single_course['persentage_groups'])) {
                            foreach ($merge_single_course['persentage_groups'] as $persentage_groups) {
                                $persentage_groups_data['total_mark'] = $persentage_groups['total_marks'];
                                $persentage_groups_data['pass_mark'] = $persentage_groups['pass_marks'];
                                $persentage_groups_data['mark'] = $persentage_groups['marks'];
                                $persentage_groups_data['result_student_course_id'] = $saved_merge_single_course['result_student_course_id'];
                                $persentage_groups_data_all[] = $persentage_groups_data;
                            }
                        }
                    }
                }
            }
        }

        if (count($result_student_course_parts_data_all) > 0) {
            $scms_result_student_course_parts = TableRegistry::getTableLocator()->get('scms_result_student_course_parts');
            $insertQueryResultStudentParts = $scms_result_student_course_parts->query();
            $parts_columns = array_keys($result_student_course_parts_data_all[0]);
            $insertQueryResultStudentParts->insert($parts_columns);
            // you must always alter the values clause AFTER insert
            $insertQueryResultStudentParts->clause('values')->values($result_student_course_parts_data_all);
            $insertQueryResultStudentParts->execute();
        }

        if (count($persentage_groups_data_all) > 0) {
            $scms_result_student_course_persentage_groups = TableRegistry::getTableLocator()->get('scms_result_student_course_persentage_groups');
            $insertQueryResultStudentPersentage = $scms_result_student_course_persentage_groups->query();
            $persentage_columns = array_keys($persentage_groups_data_all[0]);
            $insertQueryResultStudentPersentage->insert($persentage_columns);
            // you must always alter the values clause AFTER insert
            $insertQueryResultStudentPersentage->clause('values')->values($persentage_groups_data_all);
            $insertQueryResultStudentPersentage->execute();
        }
    }

    private function delete_and_save_scms_result_attendance_month($result_attendance_month, $result_id)
    {
        $scms_result_attendance_month = TableRegistry::getTableLocator()->get('scms_result_attendance_month');
        $query = $scms_result_attendance_month->query();
        $query->delete()
            ->where(['result_id' => $result_id])
            ->execute();
        if (count($result_attendance_month) > 0) {
            $insertQueryResultAttendanceMonth = $scms_result_attendance_month->query();
            $result_attendance_month_columns = array_keys($result_attendance_month[0]);
            $insertQueryResultAttendanceMonth->insert($result_attendance_month_columns);
            // you must always alter the values clause AFTER insert
            $insertQueryResultAttendanceMonth->clause('values')->values($result_attendance_month);
            $insertQueryResultAttendanceMonth->execute();
        }
    }

    private function update_result_activity($activity_ids, $result_id)
    {
        $scms_result_activity = TableRegistry::getTableLocator()->get('scms_result_activity');
        $scms_result_activity_remark = TableRegistry::getTableLocator()->get('scms_result_activity_remark');
        $previous_result_activity = $scms_result_activity
            ->find()
            ->where(['result_id' => $result_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        if (count($previous_result_activity)) {
            $previous_result_activity_ids = array();
            foreach ($previous_result_activity as $previous_activity) {
                $previous_result_activity_ids[] = $previous_activity['result_activity_id'];
            }
            $query = $scms_result_activity_remark->query();
            $query->delete()
                ->where(['result_activity_id IN' => $previous_result_activity_ids])
                ->execute();

            $query = $scms_result_activity->query();
            $query->delete()
                ->where(['result_activity_id IN' => $previous_result_activity_ids])
                ->execute();
        }
        $scms_activity = TableRegistry::getTableLocator()->get('scms_activity'); //Execute First
        $scms_result_activity_data['result_id'] = $result_id;
        foreach ($activity_ids as $activity_id) {
            $activity = $scms_activity
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['activity_id' => $activity_id])
                ->toArray();
            $scms_result_activity_data['activity_id'] = $activity[0]['activity_id'];
            $scms_result_activity_data['activity_name'] = $activity[0]['name'];
            $column = array_keys($scms_result_activity_data);

            $query = $scms_result_activity->query();
            $query->insert($column)
                ->values($scms_result_activity_data)
                ->execute();
            $last_insert_result_activity = $scms_result_activity->find()->last(); //get the last id
            $result_activity_id = $last_insert_result_activity->result_activity_id;

            $scms_activity_remark = TableRegistry::getTableLocator()->get('scms_activity_remark');
            $scms_activity_remarks = $scms_activity_remark
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['scms_activity_remark.activity_id' => $activity_id])
                ->where(['scms_activity_remark.deleted' => 0])
                ->toArray();
            $scms_result_activity_remark_data = array();
            $scms_result_activity_remark_data_single['result_activity_id'] = $result_activity_id;
            foreach ($scms_activity_remarks as $scms_activity_remark) {
                $scms_result_activity_remark_data_single['activity_remark_id'] = $scms_activity_remark['activity_remark_id'];
                $scms_result_activity_remark_data_single['remark_name'] = $scms_activity_remark['remark_name'];
                $scms_result_activity_remark_data[] = $scms_result_activity_remark_data_single;
            }
            if (count($scms_result_activity_remark_data) > 0) {
                //insert scms_result_activity_remark start
                $scms_result_activity_remark = TableRegistry::getTableLocator()->get('scms_result_activity_remark');
                $insertQuery = $scms_result_activity_remark->query();
                $columns = array_keys($scms_result_activity_remark_data[0]);
                $insertQuery->insert($columns);
                $insertQuery->clause('values')->values($scms_result_activity_remark_data);
                $insertQuery->execute();
                //end  scms_result_activity_remark
            }
        }
    }

   /* private function result_calculation($student, $max_point, $template, $grades)
    {
        $student['result']['total_marks'] = 0;
        $student['result']['marks'] = 0;
        $student['result']['point'] = 0;
        $student['result']['gpa'] = 0;
        $student['result']['marks_with_forth_subject'] = 0;
        $student['result']['point_with_forth_subject'] = 0;
        $student['result']['gpa_with_forth_subject'] = 0;
        $student['result']['result'] = 'pass';
        $student['result']['course_count'] = 0;
        if (isset($student['merge_course'])) {
            foreach ($student['merge_course'] as $merge_course) {
                if (isset($merge_course['total']['forth'])) {
                    $fourth_subject = $merge_course;
                } else {
                    $student['result']['total_marks'] = $student['result']['total_marks'] + $merge_course['result']['total_marks'];
                    $student['result']['marks'] = $student['result']['marks'] + $merge_course['result']['marks'];
                    $student['result']['point'] = $student['result']['point'] + $merge_course['result']['point'];
                    $student['result']['course_count']++;
                    if ($merge_course['result']['result'] == 'fail') {
                        $student['result']['result'] = 'fail';
                    }
                }
            }
        }
        foreach ($student['courses'] as $course) {
            if (isset($template['extra_subject'])) {
                if (isset($student['third_fourth_subjects']['forth'][$course['course_id']])) {
                    $fourth_subject = $course;
                } else {
                    $student['result']['total_marks'] = $student['result']['total_marks'] + $course['result']['total_marks'];
                    $student['result']['marks'] = $student['result']['marks'] + $course['result']['marks'];
                    $student['result']['point'] = $student['result']['point'] + $course['result']['point'];

                    $student['result']['course_count']++;
                    if ($course['result']['result'] == 'fail') {
                        $student['result']['result'] = 'fail';
                    }
                }
            } else {
                if ($course['course_type_id'] != 2) {
                    if (isset($student['third_fourth_subjects']['forth'][$course['course_id']])) {
                        $fourth_subject = $course;
                    } else {
                        $student['result']['total_marks'] = $student['result']['total_marks'] + $course['result']['total_marks'];
                        $student['result']['marks'] = $student['result']['marks'] + $course['result']['marks'];
                        $student['result']['point'] = $student['result']['point'] + $course['result']['point'];

                        $student['result']['course_count']++;
                        if ($course['result']['result'] == 'fail') {
                            $student['result']['result'] = 'fail';
                        }
                    }
                }
            }
        }


        if (isset($fourth_subject)) {
            $cut_mark = ($fourth_subject['result']['total_marks'] * 40) / 100;
            if ($cut_mark <= $fourth_subject['result']['marks']) {
                $student['result']['marks_with_forth_subject'] = $student['result']['marks'] + $fourth_subject['result']['marks'] - $cut_mark;
                $student['result']['point_with_forth_subject'] = $student['result']['point'] + $fourth_subject['result']['point'] - 2;
            } else {
                $student['result']['marks_with_forth_subject'] = $student['result']['marks'];
                $student['result']['point_with_forth_subject'] = $student['result']['point'];
            }
            if ($student['result']['point_with_forth_subject'] > 0) {
                $student['result']['gpa_with_forth_subject'] = $student['result']['point_with_forth_subject'] / $student['result']['course_count'];
            } else {
                $student['result']['gpa_with_forth_subject'] = 0;
            }
        } else {
            $student['result']['marks_with_forth_subject'] = $student['result']['marks'];
            $student['result']['point_with_forth_subject'] = $student['result']['point'];
            $student['result']['gpa_with_forth_subject'] = $student['result']['point_with_forth_subject'] / $student['result']['course_count'];
        }
        if ($student['result']['course_count'] != 0) {
            $student['result']['gpa'] = $student['result']['point'] / $student['result']['course_count'];
        }
        $student['result']['grade'] = $this->get_total_gpa($student['result']['gpa'], $grades);
        $student['result']['grade_with_forth_subject'] = $this->get_total_gpa($student['result']['gpa_with_forth_subject'], $grades);
        if ($student['result']['result'] == 'fail') {
            $student['result']['grade'] = 'F';
            $student['result']['grade_with_forth_subject'] = 'F';
            $student['result']['gpa_with_forth_subject'] = 0.0;
            $student['result']['gpa'] = 0.0;
        }
        if ($student['result']['gpa_with_forth_subject'] > $max_point) {
            $student['result']['gpa_with_forth_subject'] = $max_point;
        }
        return $student;
    } */
    
    
    private function result_calculation($student, $max_point, $template, $grades)
    {
        $student['result']['total_marks'] = 0;
        $student['result']['marks'] = 0;
        $student['result']['point'] = 0;
        $student['result']['gpa'] = 0;
        $student['result']['marks_with_forth_subject'] = 0;
        $student['result']['point_with_forth_subject'] = 0;
        $student['result']['gpa_with_forth_subject'] = 0;
        $student['result']['result'] = 'pass';
        $student['result']['course_count'] = 0;
        if (isset($student['merge_course'])) {
            foreach ($student['merge_course'] as $merge_course) {
                if (isset($merge_course['total']['forth'])) {
                    $fourth_subject = $merge_course;
                } else {
                    $student['result']['total_marks'] = $student['result']['total_marks'] + $merge_course['result']['total_marks'];
                    $student['result']['marks'] = $student['result']['marks'] + $merge_course['result']['marks'];
                    $student['result']['point'] = $student['result']['point'] + $merge_course['result']['point'];
                    $student['result']['course_count']++;
                    if ($merge_course['result']['result'] == 'fail') {
                        $student['result']['result'] = 'fail';
                    }
                }
            }
        }
        foreach ($student['courses'] as $course) {
            if (isset($template['extra_subject'])) {
                if (isset($student['third_fourth_subjects']['forth'][$course['course_id']])) {
                    $fourth_subject = $course;
                } else {
                    $student['result']['total_marks'] = $student['result']['total_marks'] + $course['result']['total_marks'];
                    $student['result']['marks'] = $student['result']['marks'] + $course['result']['marks'];
                    $student['result']['point'] = $student['result']['point'] + $course['result']['point'];

                    $student['result']['course_count']++;
                    if ($course['result']['result'] == 'fail') {
                        $student['result']['result'] = 'fail';
                    }
                }
            } else {
                if ($course['course_type_id'] != 2) {
                    if (isset($student['third_fourth_subjects']['forth'][$course['course_id']])) {
                        $fourth_subject = $course;
                    } else {
                        $student['result']['total_marks'] = $student['result']['total_marks'] + $course['result']['total_marks'];
                        $student['result']['marks'] = $student['result']['marks'] + $course['result']['marks'];
                        $student['result']['point'] = $student['result']['point'] + $course['result']['point'];

                        $student['result']['course_count']++;
                        if ($course['result']['result'] == 'fail') {
                            $student['result']['result'] = 'fail';
                        }
                    }
                }
            }
        }
        if (isset($fourth_subject)) {
            $cut_mark = ($fourth_subject['result']['total_marks'] * 40) / 100;
            if ($cut_mark <= $fourth_subject['result']['marks']) {
                $student['result']['marks_with_forth_subject'] = $student['result']['marks'] + $fourth_subject['result']['marks'] - $cut_mark;
            } else {
                $student['result']['marks_with_forth_subject'] = $student['result']['marks'];
            }
            if (2 <= $fourth_subject['result']['point']) {
                $student['result']['point_with_forth_subject'] = $student['result']['point'] + $fourth_subject['result']['point'] - 2;
            } else {
                $student['result']['point_with_forth_subject'] = $student['result']['point'];
            }
            if ($student['result']['point_with_forth_subject'] > 0) {
                $student['result']['gpa_with_forth_subject'] = $student['result']['point_with_forth_subject'] / $student['result']['course_count'];
            } else {
                $student['result']['gpa_with_forth_subject'] = 0;
            }
        } else {
            $student['result']['marks_with_forth_subject'] = $student['result']['marks'];
            $student['result']['point_with_forth_subject'] = $student['result']['point'];
            $student['result']['gpa_with_forth_subject'] = $student['result']['point_with_forth_subject'] / $student['result']['course_count'];
        }
        if ($student['result']['course_count'] != 0) {
            $student['result']['gpa'] = $student['result']['point'] / $student['result']['course_count'];
        }
        $student['result']['grade'] = $this->get_total_gpa($student['result']['gpa'], $grades);
        $student['result']['grade_with_forth_subject'] = $this->get_total_gpa($student['result']['gpa_with_forth_subject'], $grades);
        if ($student['result']['result'] == 'fail') {
            $student['result']['grade'] = 'F';
            $student['result']['grade_with_forth_subject'] = 'F';
            $student['result']['gpa_with_forth_subject'] = 0.0;
            $student['result']['gpa'] = 0.0;
        }
        if ($student['result']['gpa_with_forth_subject'] > $max_point) {
            $student['result']['gpa_with_forth_subject'] = $max_point;
        }
        return $student;
    }

    private function get_total_gpa($gpa, $grades)
    {
        $max = count($grades) - 1;
        for ($i = 0; $i <= $max; $i++) {
            if ($i == $max) {
                if ($gpa >= $grades[$i]['point']) {
                    return $grades[$i]['grade_name'];
                }
            } else {
                if ($gpa >= $grades[$i]['point'] && $gpa < $grades[$i + 1]['point']) {
                    return $grades[$i]['grade_name'];
                }
            }
        }
    }

    private function course_gpa($grades, $result)
    {
        if ($result['result'] == 'pass') {
            $percentage_top = 0;
            foreach ($grades as $grade) {
                if ($percentage_top <= $grade['percentage_top']) {
                    $percentage_top = $grade['percentage_top'];
                    $top_grade = $grade;
                }
            }

            $marks_persentage = ($result['marks'] / $result['total_marks']) * 100;
            if ($marks_persentage == $percentage_top) {
                $course_gpa['grade_name'] = $top_grade['grade_name'];
                $course_gpa['point'] = $top_grade['point'];
            } else {
                foreach ($grades as $grade) {
                    if ($marks_persentage >= $grade['percentage_down'] && $marks_persentage < $grade['percentage_top']) {
                        $course_gpa['grade_name'] = $grade['grade_name'];
                        $course_gpa['point'] = $grade['point'];
                    }
                }
            }
        } else {
            $course_gpa['grade_name'] = 'F';
            $course_gpa['point'] = 0;
        }
        return $course_gpa;
    }

    private function calculate_gpa($student, $grades)
    {
        //single course start
        foreach ($student['courses'] as $key2 => $course) {
            $gpa_course = $this->course_gpa($grades, $course['result']);
            $student['courses'][$key2]['result']['grade_name'] = $gpa_course['grade_name'];
            $student['courses'][$key2]['result']['point'] = $gpa_course['point'];
            if ($gpa_course['point'] == 0) {
                $student['courses'][$key2]['result']['result'] = 'fail';
            }
        }
        //single course end
//merge course start
        if (isset($student['merge_course'])) {
            foreach ($student['merge_course'] as $key4 => $merge_course) {
                $gpa_course = $this->course_gpa($grades, $merge_course['result']);
                $student['merge_course'][$key4]['result']['grade_name'] = $gpa_course['grade_name'];
                $student['merge_course'][$key4]['result']['point'] = $gpa_course['point'];
                if ($gpa_course['point'] == 0) {
                    $student['merge_course'][$key4]['result']['result'] = 'fail';
                }
            }
        }

        //merge course end

        return $student;
    }

    private function total_persentage_and_calculate_total($student, $persentage = false)
    {
        //single course start
        foreach ($student['courses'] as $key2 => $course) {
            //initial total marks
            $result['total_marks'] = 0;
            $result['pass_marks'] = 0;
            $result['marks'] = 0;
            if (isset($course['parts'])) {
                $parts = $course['parts'];
            } else {
                $parts = array();
            }
            unset($parts['9999']);
            foreach ($parts as $part) {
                $result['total_marks'] = $result['total_marks'] + $part['total_mark'];
                $result['pass_marks'] = $result['pass_marks'] + $part['pass_mark'];
                $result['marks'] = $result['marks'] + $part['marks'];
            }


            //calculate the persentage of marks
            if ($persentage) {
                $result['total_marks'] = $result['total_marks'] * ($persentage / 100);
                $result['pass_marks'] = $result['pass_marks'] * ($persentage / 100);
                $result['marks'] = $result['marks'] * ($persentage / 100);
            }
            if (isset($student['courses'][$key2]['result']['result'])) {
                $result['result'] = $student['courses'][$key2]['result']['result'];
            } else {
                $result['result'] = null;
            }

            //assign total to the main array
            $student['courses'][$key2]['result'] = $result;
        }
        //single course end
//merge course start
        if (isset($student['merge_course'])) {
            foreach ($student['merge_course'] as $key4 => $merge_courses) {

                foreach ($merge_courses as $key5 => $merge_course) {
                    //initial total marks
                    $result['total_marks'] = 0;
                    $result['pass_marks'] = 0;
                    $result['marks'] = 0;
                    $parts = $merge_course['parts'];
                    unset($parts['9999']);
                    foreach ($parts as $part) {
                        $result['total_marks'] = $result['total_marks'] + $part['total_mark'];
                        $result['pass_marks'] = $result['pass_marks'] + $part['pass_mark'];
                        $result['marks'] = $result['marks'] + $part['marks'];
                    }
                    //calculate the persentage of marks
                    if ($persentage) {
                        $result['total_marks'] = $result['total_marks'] * ($persentage / 100);
                        $result['pass_marks'] = $result['pass_marks'] * ($persentage / 100);
                        $result['marks'] = $result['marks'] * ($persentage / 100);
                    }
                    $result['result'] = $student['merge_course'][$key4][$key5]['result']['result'];
                    //assign total to the main array
                    if ($key5 == 'total') {
                        $student['merge_course'][$key4]['result'] = $result;
                    } else {
                        $student['merge_course'][$key4][$key5]['result'] = $result;
                    }
                    if ($key5 == 0) {
                        $student['merge_course'][$key4][$key5]['result'] = $result;
                    }
                }
            }
        }

        //merge course end

        return $student;
    }

    private function group_persentage_and_calculate_total($student, $group_persentage_check)
    {
        //single course start
        foreach ($student['courses'] as $key2 => $course) {
            //initial total marks
            $result['total_marks'] = 0;
            $result['pass_marks'] = 0;
            $result['marks'] = 0;
            $result['result'] = 'fail';
            if (isset($course['parts'])) {
                foreach ($group_persentage_check['value'] as $group) {
                    $parts = $course['parts'];
                    unset($parts['9999']);
                    $part_ids = $group;
                    $persentage = $part_ids['persentage'];
                    unset($part_ids['persentage']);
                    unset($part_ids['view']);
                    //initial group marks
                    $group_marks['total_marks'] = 0;
                    $group_marks['pass_marks'] = 0;
                    $group_marks['marks'] = 0;
                    foreach ($part_ids as $part_id) {
                        if (isset($parts[$part_id])) {
                            //calculate group marks
                            $group_marks['total_marks'] = $group_marks['total_marks'] + $parts[$part_id]['total_mark'];
                            $group_marks['pass_marks'] = $group_marks['pass_marks'] + $parts[$part_id]['pass_mark'];
                            $group_marks['marks'] = $group_marks['marks'] + $parts[$part_id]['marks'];
                            unset($parts[$part_id]);
                        }
                    }
                    //calculate the persentage of group marks
                    $group_marks['total_marks'] = $group_marks['total_marks'] * ($persentage / 100);
                    $group_marks['pass_marks'] = $group_marks['pass_marks'] * ($persentage / 100);
                    $group_marks['marks'] = $group_marks['marks'] * ($persentage / 100);

                    //index group marks to main students array
                    $student['courses'][$key2]['persentage_groups'][] = $group_marks;

                    //calculate total marks
                    $result['total_marks'] = $result['total_marks'] + $group_marks['total_marks'];
                    $result['pass_marks'] = $result['pass_marks'] + $group_marks['pass_marks'];
                    $result['marks'] = $result['marks'] + $group_marks['marks'];

                    //add extra parts that are not in groups
                    foreach ($parts as $part) {
                        $result['total_marks'] = $result['total_marks'] + $part['total_mark'];
                        $result['pass_marks'] = $result['pass_marks'] + $part['pass_mark'];
                        $result['marks'] = $result['marks'] + $part['marks'];
                    }
                    $result['result'] = $student['courses'][$key2]['result']['result'];
                    //assign total to the main array
                    $student['courses'][$key2]['result'] = $result;
                }
            } else {
                $student['courses'][$key2]['result'] = $result;
            }
        }
        //single course end
//merge course start
        if (isset($student['merge_course'])) {
            foreach ($student['merge_course'] as $key4 => $merge_courses) {
                foreach ($merge_courses as $key5 => $merge_course) {
                    //initial total marks
                    $result['total_marks'] = 0;
                    $result['pass_marks'] = 0;
                    $result['marks'] = 0;
                    foreach ($group_persentage_check['value'] as $group) {
                        $parts = $merge_course['parts'];
                        unset($parts['9999']);
                        $part_ids = $group;
                        $persentage = $part_ids['persentage'];
                        unset($part_ids['persentage']);
                        unset($part_ids['view']);
                        //initial group marks
                        $group_marks['total_marks'] = 0;
                        $group_marks['pass_marks'] = 0;
                        $group_marks['marks'] = 0;
                        foreach ($part_ids as $part_id) {
                            if (isset($parts[$part_id])) {
                                //calculate group marks
                                $group_marks['total_marks'] = $group_marks['total_marks'] + $parts[$part_id]['total_mark'];
                                $group_marks['pass_marks'] = $group_marks['pass_marks'] + $parts[$part_id]['pass_mark'];
                                $group_marks['marks'] = $group_marks['marks'] + $parts[$part_id]['marks'];
                                unset($parts[$part_id]);
                            }
                        }

                        //calculate the persentage of group marks
                        $group_marks['total_marks'] = $group_marks['total_marks'] * ($persentage / 100);
                        $group_marks['pass_marks'] = $group_marks['pass_marks'] * ($persentage / 100);
                        $group_marks['marks'] = $group_marks['marks'] * ($persentage / 100);

                        //index group marks to main students array
                        $student['merge_course'][$key4][$key5]['persentage_groups'][] = $group_marks;

                        //calculate total marks
                        $result['total_marks'] = $result['total_marks'] + $group_marks['total_marks'];
                        $result['pass_marks'] = $result['pass_marks'] + $group_marks['pass_marks'];
                        $result['marks'] = $result['marks'] + $group_marks['marks'];

                        //add extra parts that are not in groups
                        foreach ($parts as $part) {
                            $result['total_marks'] = $result['total_marks'] + $part['total_mark'];
                            $result['pass_marks'] = $result['pass_marks'] + $part['pass_mark'];
                            $result['marks'] = $result['marks'] + $part['marks'];
                        }

                        $result['result'] = $student['merge_course'][$key4][$key5]['result']['result'];
                        //assign total to the main array
                        if ($key5 == 'total') {
                            $student['merge_course'][$key4]['result'] = $result;
                        } else {
                            $student['merge_course'][$key4][$key5]['result'] = $result;
                        }
                        if ($key5 == 0) {
                            $student['merge_course'][$key4][$key5]['result'] = $result;
                        }
                    }
                }
            }
        }

        return $student;
    }

    private function total_pass_check($student)
    {
        //single course start
        foreach ($student['courses'] as $key2 => $course) {
            if ($course['parts'][9999]['marks'] >= $course['parts'][9999]['pass_mark']) {
                $student['courses'][$key2]['result']['result'] = 'pass';
            } else {
                $student['courses'][$key2]['result']['result'] = 'fail';
                $student['courses'][$key2]['result']['check'] = 'total';
            }
        }
        //single course end
        if (isset($student['merge_course'])) {
            foreach ($student['merge_course'] as $key4 => $merge_courses) {
                foreach ($merge_courses as $key5 => $merge_course) {
                    if ($merge_course['parts'][9999]['marks'] >= $merge_course['parts'][9999]['pass_mark']) {
                        $student['merge_course'][$key4][$key5]['result']['result'] = 'pass';
                    } else {
                        $student['merge_course'][$key4][$key5]['result']['result'] = 'fail';
                        $student['merge_course'][$key4][$key5]['result']['check'] = 'total';
                    }
                }
            }
        }

        return $student;
    }

    private function group_pass_check($student, $group_pass_check)
    {
        foreach ($group_pass_check['value'] as $set => $groups) {
            unset($groups['view']);

            //single course start
            foreach ($student['courses'] as $key2 => $course) {
                $pass_mark = 0;
                $marks = 0;
                $total_marks = 0;
                foreach ($groups as $group) {
                    if (isset($course['parts'][$group])) {
                        $pass_mark = $pass_mark + $course['parts'][$group]['pass_mark'];
                        $marks = $marks + $course['parts'][$group]['marks'];
                        $total_marks = $total_marks + $course['parts'][$group]['total_mark'];
                    }
                }
                if ($marks >= $pass_mark) {
                    $student['courses'][$key2]['result']['result'] = 'pass';
                } else {
                    $student['courses'][$key2]['result']['result'] = 'fail';
                    $student['courses'][$key2]['result']['check'] = 'group';
                }
                if (count($groups) > 1) {
                    $student['courses'][$key2]['group_marks'][$set]['pass_mark'] = $pass_mark;
                    $student['courses'][$key2]['group_marks'][$set]['mark'] = $marks;
                    $student['courses'][$key2]['group_marks'][$set]['total_mark'] = $total_marks;
                }
            }
            //single course end
            if (isset($student['merge_course'])) {
                foreach ($student['merge_course'] as $key4 => $merge_courses) {
                    foreach ($merge_courses as $key5 => $merge_course) {
                        $pass_mark = 0;
                        $marks = 0;
                        $total_marks = 0;
                        foreach ($groups as $group) {
                            if (isset($merge_course['parts'][$group])) {
                                $pass_mark = $pass_mark + $merge_course['parts'][$group]['pass_mark'];
                                $marks = $marks + $merge_course['parts'][$group]['marks'];
                                $total_marks = $marks + $merge_course['parts'][$group]['total_mark'];
                            }
                        }
                        if ($marks >= $pass_mark) {
                            $student['merge_course'][$key4][$key5]['result']['result'] = 'pass';
                        } else {
                            $student['merge_course'][$key4][$key5]['result']['result'] = 'fail';
                            $student['merge_course'][$key4][$key5]['result']['check'] = 'group';
                        }
                        if (count($groups) > 1) {
                            $student['merge_course'][$key4][$key5]['group_marks'][$set]['pass_mark'] = $pass_mark;
                            $student['merge_course'][$key4][$key5]['group_marks'][$set]['mark'] = $marks;
                            $student['merge_course'][$key4][$key5]['group_marks'][$set]['total_mark'] = $total_marks;
                        }
                    }
                }
            }
        }
        return $student;
    }

    private function indivisul_pass_check($student)
    {

        //single course start
        foreach ($student['courses'] as $key2 => $course) {
            if (isset($course['parts'])) {
                foreach ($course['parts'] as $key3 => $part) {
                    if ($part['marks'] >= $part['pass_mark']) {
                        $student['courses'][$key2]['result']['result'] = 'pass';
                    } else {
                        $student['courses'][$key2]['result']['result'] = 'fail';
                        $student['courses'][$key2]['result']['check'] = 'indivisul';
                        $student['courses'][$key2]['result']['part_type_is'] = $key3;
                        break;
                    }
                }
            }
        }
        //single course end
        if (isset($student['merge_course'])) {
            foreach ($student['merge_course'] as $key4 => $merge_course) {
                foreach ($merge_course as $key5 => $courses) {
                    foreach ($courses['parts'] as $key6 => $part) {
                        if ($part['marks'] >= $part['pass_mark']) {
                            $student['merge_course'][$key4][$key5]['result']['result'] = 'pass';
                        } else {
                            $student['merge_course'][$key4][$key5]['result']['result'] = 'fail';
                            $student['merge_course'][$key4][$key5]['result']['check'] = 'indivisul';
                            $student['merge_course'][$key4][$key5]['result']['part_type_is'] = $key6;
                            break;
                        }
                    }
                }
            }
        }

        return $student;
    }

    private function merge_subject($merge_subject, $student)
    {
        //separate merge subject start
        foreach ($merge_subject['value'] as $group => $merge) {
           if(isset( $student['courses'][$merge[0]])){
            $student['merge_course'][$group][] = $student['courses'][$merge[0]]; //assgin course to merge_course
            $student['merge_course'][$group][] = $student['courses'][$merge[1]];
            $total = $this->merge_subject_total($student['courses'][$merge[0]], $student['courses'][$merge[1]]);   //get the sum of every part for merge course
            $student['merge_course'][$group]['total']['parts'] = $total;
            if (isset($student['third_fourth_subjects']['forth'][$merge[0]])) {
                if (isset($student['third_fourth_subjects']['forth'][$merge[1]])) {
                    $student['merge_course'][$group]['total']['forth'] = 1;
                } else {
                    $this->Flash->success('Template erroe!! Forth subject is marge with other subject', [
                        'key' => 'Negative',
                        'params' => [],
                    ]);
                    return -1;
                }
            }
            if (isset($student['third_fourth_subjects']['forth'][$merge[1]])) {
                if (isset($student['third_fourth_subjects']['forth'][$merge[0]])) {
                    $student['merge_course'][$group]['total']['forth'] = 1;
                } else {
                    $this->Flash->success('Template erroe!! Forth subject is marge with other subject', [
                        'key' => 'Negative',
                        'params' => [],
                    ]);
                    return -1;
                }
            }

            unset($student['courses'][$merge[0]]); //remove course from main array
            unset($student['courses'][$merge[1]]); //remove course from main array
        }
    }    
        //separate merge subject end
        return $student;
    }

    private function merge_subject_total($subject_1, $subject_2)
    {
        $part_ids = array();
        foreach ($subject_1['parts'] as $key => $part) {
            $part_ids[$part['term_course_cycle_part_type_id']]['id'] = $part['term_course_cycle_part_type_id'];
            $part_ids[$part['term_course_cycle_part_type_id']]['name'] = $part['term_course_cycle_part_type_name'];
        }
        foreach ($subject_2['parts'] as $key => $part) {
            $part_ids[$part['term_course_cycle_part_type_id']]['id'] = $part['term_course_cycle_part_type_id'];
            $part_ids[$part['term_course_cycle_part_type_id']]['name'] = $part['term_course_cycle_part_type_name'];
        }
        $total = array();
        foreach ($part_ids as $key => $part) {
            $total[$key]['term_course_cycle_part_type_id'] = $part['id'];
            $total[$key]['term_course_cycle_part_type_name'] = $part['name'];
            if (isset($subject_1['parts'][$key]) && isset($subject_2['parts'][$key])) {
                $total[$key]['total_mark'] = $subject_1['parts'][$key]['total_mark'] + $subject_2['parts'][$key]['total_mark'];
                $total[$key]['pass_mark'] = $subject_1['parts'][$key]['pass_mark'] + $subject_2['parts'][$key]['pass_mark'];
                $total[$key]['marks'] = $subject_1['parts'][$key]['marks'] + $subject_2['parts'][$key]['marks'];
                $total[$key]['type'] = 2;
            } else {
                if (isset($subject_1['parts'][$key])) {
                    $total[$key]['total_mark'] = $subject_1['parts'][$key]['total_mark'];
                    $total[$key]['pass_mark'] = $subject_1['parts'][$key]['pass_mark'];
                    $total[$key]['marks'] = $subject_1['parts'][$key]['marks'];
                    $total[$key]['type'] = 1;
                } else {
                    $total[$key]['total_mark'] = $subject_2['parts'][$key]['total_mark'];
                    $total[$key]['pass_mark'] = $subject_2['parts'][$key]['pass_mark'];
                    $total[$key]['marks'] = $subject_2['parts'][$key]['marks'];
                    $total[$key]['type'] = 1;
                }
            }
        }
        return $total;
    }

    public function editTemplate($id)
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $grading_data['gradings_system_name'] = $data['gradings_system_name'];
            $grading = TableRegistry::getTableLocator()->get('scms_gradings');
            $query = $grading->query();
            $query->update()->set($grading_data)->where(['gradings_id' => $id])->execute();
            foreach ($data['grade_id'] as $key => $grade_id) {
                $grade_data['gradings_id'] = $id;
                $grade_data['grade_name'] = $data['grade_name'][$key];
                $grade_data['point'] = $data['point'][$key];
                $grade_data['percentage_down'] = $data['percentage_down'][$key];
                $grade_data['percentage_top'] = $data['percentage_top'][$key];
                $grade = TableRegistry::getTableLocator()->get('scms_grade');
                if ($grade_id) {
                    $query = $grade->query();
                    $query->update()->set($grade_data)->where(['grade_id' => $grade_id])->execute();
                } else {
                    $query = $grade->query();
                    $query->insert(['gradings_id', 'grade_name', 'point', 'percentage_down', 'percentage_top'])->values($grade_data)->execute();
                }
            }
            //Set Flash
            $this->Flash->success('Grade Add/Edit Successfully Done', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'index']);
        }
        $grading = TableRegistry::getTableLocator()->get('scms_gradings');
        $gradings = $grading->find()->where(['gradings_id' => $id])->toArray();
        $this->set('gradings', $gradings);
        $grade = TableRegistry::getTableLocator()->get('scms_grade');
        $grades = $grade->find()->order(['point' => 'ASC'])->where(['gradings_id' => $id])->toArray();
        $this->set('grades', $grades);
    }

    public function deleteTemplate($id)
    {
        $this->autoRender = false;
        $data['deleted'] = 1;
        $result_template = TableRegistry::getTableLocator()->get('scms_result_template');
        $query = $result_template->query();
        $query->update()->set($data)->where(['result_template_id' => $id])->execute();
        //Set Flash
        $this->Flash->info('Template Deleted Successfully', [
            'key' => 'positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'indexTemplate']);
    }

    private function get_courses_name($values)
    {
        foreach ($values as $key => $value) {
            $course = TableRegistry::getTableLocator()->get('scms_courses');
            $courses = $course->find()->where(['course_id in' => $value])->enableAutoFields(true)->enableHydration(false)->toArray();
            foreach ($courses as $course) {
                if (isset($values[$key]['view'])) {
                    $values[$key]['view'] = $values[$key]['view'] . ', ' . $course['course_name'];
                } else {
                    $values[$key]['view'] = $course['course_name'];
                }
            }
        }
        return $values;
    }

    private function get_type_name($values)
    {
        foreach ($values as $key => $value) {
            $values[$key] = (array) $value;
        }

        foreach ($values as $key => $value) {

            if (isset($value['persentage'])) {
                $term_course_cycle_part_type_id = $value;
                unset($term_course_cycle_part_type_id['persentage']);
            } else {
                $term_course_cycle_part_type_id = $value;
            }
            $type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
            $types = $type->find()->where(['term_course_cycle_part_type_id  in' => $term_course_cycle_part_type_id])->enableAutoFields(true)->enableHydration(false)->toArray();
            foreach ($types as $type) {
                if (isset($values[$key]['view'])) {
                    $values[$key]['view'] = $values[$key]['view'] . ', ' . $type['term_course_cycle_part_type_name'];
                } else {
                    $values[$key]['view'] = $type['term_course_cycle_part_type_name'];
                }
            }
        }
        return $values;
    }

    private function get_template($id)
    {
        $result_template_rule = TableRegistry::getTableLocator()->get('scms_result_template_rule');
        $result_template_rules = $result_template_rule->find()->where(['result_template_id' => $id])->enableAutoFields(true)->enableHydration(false)->toArray();
        foreach ($result_template_rules as $key => $result_template_rule) {
            if ($result_template_rule['config_key'] == 'merge_subject' || $result_template_rule['config_key'] == 'group_pass_check' || $result_template_rule['config_key'] == 'group_persentage_check') {
                $result_template_rules[$key]['value'] = (array) json_decode($result_template_rules[$key]['value']);
            }
            if ($result_template_rule['config_key'] == 'merge_subject') {
                $result_template_rules[$key]['value'] = $this->get_courses_name($result_template_rules[$key]['value']);
            }
            if ($result_template_rule['config_key'] == 'group_pass_check' || $result_template_rule['config_key'] == 'group_persentage_check') {
                $result_template_rules[$key]['value'] = $this->get_type_name($result_template_rules[$key]['value']);
            }
            if ($result_template_rule['config_key'] == 'activity') {
                $result_template_rules[$key]['value'] = (array) json_decode($result_template_rules[$key]['value']);
                $result_template_rules[$key]['value'] = $this->get_activity_name($result_template_rules[$key]['value']);
            }
            if ($result_template_rule['config_key'] == 'term') {
                $result_template_rules[$key]['value'] = (array) json_decode($result_template_rules[$key]['value']);
                $result_template_rules[$key]['value'] = $this->get_term_name($result_template_rules[$key]['value']);
            }
        }
        $rules = array();
        foreach ($result_template_rules as $result_template_rule) {
            $rules[$result_template_rule['config_key']] = $result_template_rule;
        }
        $template = TableRegistry::getTableLocator()->get('scms_result_template');
        $templates = $template->find()->where(['result_template_id' => $id])->enableAutoFields(true)->enableHydration(false)->toArray();
        $rules['merit'] = $templates[0]['merit'] ? $templates[0]['merit'] : $this->get_settings_value('merit_and_highest_from');
        $this->get_settings_value('multiple_merit_position');
        return $rules;
    }

    private function get_term_name($value)
    {
        foreach ($value['term_id'] as $key => $term_id) {
            $term = TableRegistry::getTableLocator()->get('scms_term'); //Execute First
            $terms = $term
                ->find()
                ->where(['term_id' => $term_id])
                ->toArray();
            $value['term_name'][$key] = $terms[0]->term_name;
        }
        return $value;
    }

    private function get_activity_name($value)
    {
        foreach ($value as $key => $activity_id) {
            $scms_activity = TableRegistry::getTableLocator()->get('scms_activity'); //Execute First
            $activity = $scms_activity
                ->find()
                ->where(['activity_id' => $activity_id])
                ->toArray();
            $value['activity_name'][] = $activity[0]->name;
        }
        return $value;
    }

    public function viewTemplate($id)
    {
        $rules = $this->get_template($id);
        $this->set('rules', $rules);
        $template = TableRegistry::getTableLocator()->get('scms_result_template');
        $templates = $template->find()->where(['result_template_id' => $id])->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('result_templates', $templates);
    }

    public function addMergeTemplate()
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $result_template_configuration = TableRegistry::getTableLocator()->get('scms_result_template_configuration');
            $result_template_configurations = $result_template_configuration->find()->enableAutoFields(true)->enableHydration(false)->toArray();
            foreach ($result_template_configurations as $result_template_configuration) {
                $result_template_rule_data[$result_template_configuration['config_key']] = $result_template_configuration;
            }
            if (isset($data['term'])) {
                $term_data = array();
                foreach ($data['term'] as $key => $term) {
                    $term_data['term_id'][$key] = $term;
                    $term_data['term_percentage'][$key] = $data['term_percentage'][$key];
                }
                $result_template_rule_data['term']['value'] = json_encode($term_data);
            }
            if (isset($data['indivisul_pass_check'])) {
                $result_template_rule_data['indivisul_pass_check']['value'] = 'on';
            }
            if (isset($data['group_pass_check'])) {
                $result_template_rule_data['group_pass_check']['value'] = json_encode($data['group_pass']);
            }
            if (isset($data['total_persentage_check'])) {
                $result_template_rule_data['total_persentage_check']['value'] = $data['total_persentage_number'];
            }
            if (isset($data['group_persentage_check'])) {
                foreach ($data['group_persentage'] as $key => $group_persentage) {
                    $data['group_persentage'][$key]['persentage'] = $data['group_persentage_number'][$key][0];
                }
                $result_template_rule_data['group_persentage_check']['value'] = json_encode($data['group_persentage']);
            }
            $result_template_data['name'] = $data['result_template_name'];
            $result_template_data['merit'] = $data['merit'];
            $result_template_data['type'] = 'merge';
            $result_template = TableRegistry::getTableLocator()->get('scms_result_template');
            $query = $result_template->query();
            $query->insert(['name', 'type', 'merit'])->values($result_template_data)->execute();
            $myrecords = $result_template->find()->last(); //get the last id
            $result_template_id = $myrecords->result_template_id;
            foreach ($result_template_rule_data as $template_rule_data) {
                if (isset($template_rule_data['value'])) {
                    $template_rule_data['result_template_id'] = $result_template_id;
                    $result_template_rule = TableRegistry::getTableLocator()->get('scms_result_template_rule');
                    $query = $result_template_rule->query();
                    $query->insert(['result_template_id', 'result_template_configuration_type_id', 'config_key', 'value'])->values($template_rule_data)->execute();
                }
            }

            //Set Flash
            $this->Flash->success('Template Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'indexTemplate']);
        }

        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $courses = $course->find()->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('courses', $courses);

        $term_course_cycle_part_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
        $type = $term_course_cycle_part_type->find()->enableAutoFields(true)->enableHydration(false)->where(['term_course_cycle_part_type_id  !=' => '9999'])->toArray();
        $this->set('parts', $type);

        $term = TableRegistry::getTableLocator()->get('scms_term');
        $terms = $term->find()->toArray();
        $this->set('terms', $terms);

        $scms_activity = TableRegistry::getTableLocator()->get('scms_activity');
        $activities = $scms_activity->find()->where(['deleted' => 0])->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('activities', $activities);
    }

    public function addTemplate()
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $result_template_configuration = TableRegistry::getTableLocator()->get('scms_result_template_configuration');
            $result_template_configurations = $result_template_configuration->find()->enableAutoFields(true)->enableHydration(false)->toArray();
            foreach ($result_template_configurations as $result_template_configuration) {
                $result_template_rule_data[$result_template_configuration['config_key']] = $result_template_configuration;
            }
            if (isset($data['merge_subject'])) {
                $result_template_rule_data['merge_subject']['value'] = json_encode($data['merge_subject']);
            }

            if (isset($data['indivisul_pass_check'])) {
                $result_template_rule_data['indivisul_pass_check']['value'] = 'on';
            }
            if (isset($data['group_pass_check'])) {
                $result_template_rule_data['group_pass_check']['value'] = json_encode($data['group_pass']);
            }

            if (isset($data['total_persentage_check'])) {
                $result_template_rule_data['total_persentage_check']['value'] = $data['total_persentage_number'];
            }
            if (isset($data['group_persentage_check'])) {
                foreach ($data['group_persentage'] as $key => $group_persentage) {
                    $data['group_persentage'][$key]['persentage'] = $data['group_persentage_number'][$key][0];
                }
                $result_template_rule_data['group_persentage_check']['value'] = json_encode($data['group_persentage']);
            }
            if (isset($data['extra_sublect_calculation'])) {
                $result_template_rule_data['extra_subject']['value'] = 'on';
            }
            if (isset($data['activity'])) {
                $result_template_rule_data['activity']['value'] = json_encode($data['activity']);
            }
            $result_template_data['name'] = $data['result_template_name'];
            $result_template_data['merit'] = $data['merit'];
            $result_template_data['type'] = 'single';
            $result_template = TableRegistry::getTableLocator()->get('scms_result_template');
            $query = $result_template->query();
            $query->insert(['name', 'type', 'merit'])->values($result_template_data)->execute();
            $myrecords = $result_template->find()->last(); //get the last id
            $result_template_id = $myrecords->result_template_id;
            foreach ($result_template_rule_data as $template_rule_data) {
                if (isset($template_rule_data['value'])) {
                    $template_rule_data['result_template_id'] = $result_template_id;
                    $result_template_rule = TableRegistry::getTableLocator()->get('scms_result_template_rule');
                    $query = $result_template_rule->query();
                    $query->insert(['result_template_id', 'result_template_configuration_type_id', 'config_key', 'value'])->values($template_rule_data)->execute();
                }
            }

            //Set Flash
            $this->Flash->success('Template Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'indexTemplate']);
        }


        $term_course_cycle_part_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
        $type = $term_course_cycle_part_type->find()->enableAutoFields(true)->enableHydration(false)->where(['term_course_cycle_part_type_id  !=' => '9999'])->toArray();
        $this->set('parts', $type);

        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $courses = $course->find()->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('courses', $courses);

        $scms_activity = TableRegistry::getTableLocator()->get('scms_activity');
        $activities = $scms_activity->find()->where(['deleted' => 0])->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('activities', $activities);
    }

    public function indexTemplate()
    {
        $result_template = TableRegistry::getTableLocator()->get('scms_result_template');
        $result_templates_single = $result_template->find()->where(['deleted' => 0])->where(['type' => 'single'])->toArray();
        $this->set('single_result_templates', $result_templates_single);

        $result_templates_marge = $result_template->find()->where(['deleted' => 0])->where(['type' => 'merge'])->toArray();
        $this->set('result_templates_marge', $result_templates_marge);
    }

    private function get_guardians($student)
    {
        $scms_guardian = TableRegistry::getTableLocator()->get('scms_guardians');
        $scms_guardians = $scms_guardian->find()->enableAutoFields(true)->enableHydration(false)->where(['student_id' => $student['student_id']])->toArray();
        $guardians = array();
        foreach ($scms_guardians as $scms_guardian) {
            $guardians[strtolower($scms_guardian['rtype'])] = $scms_guardian;
        }
        $student['guardians'] = $guardians;
        return $student;
    }

    private function genarate_marks_heads($template, $merge = false)
    {
        $term_course_cycle_part_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
        $types = $term_course_cycle_part_type->find()->enableAutoFields(true)->enableHydration(false)->where(['term_course_cycle_part_type_id  !=' => '9999'])->toArray();
        foreach ($types as $type) {
            $single_head['name'] = $type['term_course_cycle_part_type_name'];
            $single_head['style'] = 'class="res7" colspan="2" colspan="1"';
            $single_head['type'] = 'part';
            $head[] = $single_head;
        }
        if (isset($template['total_persentage_check'])) {

            //single_head_for_total
            unset($single_head);
            $single_head['name'] = 'Total';
            $single_head['style'] = 'class="res5 colspan="1" rowspan="1"';
            $head[] = $single_head;

            //single_head_for_$template['total_persentage_check']['value'] . '% Of Total'
            unset($single_head);
            $single_head['name'] = $template['total_persentage_check']['value'] . '% Of Total';
            $single_head['style'] = 'class="res5 colspan="1" rowspan="1"';
            $head[] = $single_head;

            //single_head_for_Grand Total
            unset($single_head);
            $single_head['name'] = 'Grand Total';
            $single_head['style'] = 'class="res5 colspan="1" rowspan="1"';
            $head[] = $single_head;
        } else if (isset($template['group_persentage_check'])) {
            $withouts = $this->find_without_group_persentage_check($head, $template['group_persentage_check']['value']);
            if (count($withouts) > 0) {
                $unset_nmaes = '';
                foreach ($withouts as $key => $without) {
                    unset($head[$key]);
                    $unset_nmaes = $unset_nmaes . ', ' . $without;
                }
                $unset_nmaes = substr($unset_nmaes, 1);

                //single_head_for_"Total Without " . $unset_nmaes
                unset($single_head);
                $single_head['name'] = "Total Without " . $unset_nmaes;
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;

                $persentage_key = array_keys($template['group_persentage_check']['value']);
                //single_head_for_$template['group_persentage_check']['value'][$persentage_key[0]]['persentage'] . '% Of Total'
                unset($single_head);
                $single_head['name'] = $template['group_persentage_check']['value'][$persentage_key[0]]['persentage'] . '% Of Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';

                $head[] = $single_head;

                foreach ($withouts as $key => $without) {
                    unset($single_head);
                    $single_head['name'] = $without;
                    $single_head['style'] = 'class="res7" colspan="2" rowspan="1"';
                    $single_head['type'] = 'part';
                    $head[] = $single_head;
                }

                //single_head_for_'Grand Total With ' . $unset_nmaes
                unset($single_head);
                $single_head['name'] = 'Grand Total With ' . $unset_nmaes;
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;
            } else {
                //single_head_for_total
                unset($single_head);
                $single_head['name'] = 'Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;

                $persentage_key = array_keys($template['group_persentage_check']['value']);

                //single_head_for_ $template['group_persentage_check']['value'][$persentage_key[0]]['persentage'] . '% Of Total';
                unset($single_head);
                $single_head['name'] = $template['group_persentage_check']['value'][$persentage_key[0]]['persentage'] . '% Of Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;

                //single_head_for_'Grand Total'
                unset($single_head);
                $single_head['name'] = 'Grand Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;
            }
        } else {
            //single_head_for_total
            unset($single_head);
            $single_head['name'] = 'Total';
            $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
            $head[] = $single_head;
        }
        //single_head_for_Highest
        if (!$merge) {
            unset($single_head);
            $single_head['name'] = 'Highest';
            $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
            $head[] = $single_head;
        }

        //single_head_for_GP
        unset($single_head);
        $single_head['name'] = 'GP';
        $single_head['style'] = 'class="res4" colspan="1" rowspan="1"';
        $head[] = $single_head;

        //single_head_for_Grade
        if (!$merge) {
            unset($single_head);
            $single_head['name'] = 'Grade';
            $single_head['style'] = 'class="res4" colspan="1" rowspan="1"';
            $head[] = $single_head;
        }
        return $head;
    }
    
     private function genarate_marks_heads_custom($template, $merge = false)
    {
        $term_course_cycle_part_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
        $types = $term_course_cycle_part_type->find()->enableAutoFields(true)->enableHydration(false)->where(['term_course_cycle_part_type_id' => '1'])->toArray();
        foreach ($types as $type) {
            $single_head['name'] = $type['term_course_cycle_part_type_name'];
            $single_head['style'] = 'class="res7" colspan="2" colspan="1"';
            $single_head['type'] = 'part';
            $head[] = $single_head;
        }
        if (isset($template['total_persentage_check'])) {

            if (!$merge) {

                //single_head_for_total
                unset($single_head);
                $single_head['name'] = 'Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;

                //single_head_for_$template['total_persentage_check']['value'] . '% Of Total'
                unset($single_head);
                $single_head['name'] = $template['total_persentage_check']['value'] . '% Of Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;
            }


            //single_head_for_Grand Total
            unset($single_head);
            $single_head['name'] = 'Grand Total';
            $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
            $head[] = $single_head;
        } else if (isset($template['group_persentage_check'])) {
            $withouts = $this->find_without_group_persentage_check($head, $template['group_persentage_check']['value']);
            if (count($withouts) > 0) {
                $unset_nmaes = '';
                foreach ($withouts as $key => $without) {
                    unset($head[$key]);
                    $unset_nmaes = $unset_nmaes . ', ' . $without;
                }
                $unset_nmaes = substr($unset_nmaes, 1);

                //single_head_for_"Total Without " . $unset_nmaes
                unset($single_head);
                $single_head['name'] = "Total Without " . $unset_nmaes;
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;

                $persentage_key = array_keys($template['group_persentage_check']['value']);
                //single_head_for_$template['group_persentage_check']['value'][$persentage_key[0]]['persentage'] . '% Of Total'
                unset($single_head);
                $single_head['name'] = $template['group_persentage_check']['value'][$persentage_key[0]]['persentage'] . '% Of Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';

                $head[] = $single_head;

                foreach ($withouts as $key => $without) {
                    unset($single_head);
                    $single_head['name'] = $without;
                    $single_head['style'] = 'class="res7" colspan="2" rowspan="1"';
                    $single_head['type'] = 'part';
                    $head[] = $single_head;
                }

                //single_head_for_'Grand Total With ' . $unset_nmaes
                unset($single_head);
                $single_head['name'] = 'Grand Total With ' . $unset_nmaes;
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;
            } else {
                //single_head_for_total
                unset($single_head);
                $single_head['name'] = 'Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;

                $persentage_key = array_keys($template['group_persentage_check']['value']);

                //single_head_for_ $template['group_persentage_check']['value'][$persentage_key[0]]['persentage'] . '% Of Total';
                unset($single_head);
                $single_head['name'] = $template['group_persentage_check']['value'][$persentage_key[0]]['persentage'] . '% Of Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;

                //single_head_for_'Grand Total'
                unset($single_head);
                $single_head['name'] = 'Grand Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;
            }
        } else {

            if (!$merge) {
                //single_head_for_total
                unset($single_head);
                $single_head['name'] = 'Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;
            } else {
                //single_head_for_total
                unset($single_head);
                $single_head['name'] = 'Grand Total';
                $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
                $head[] = $single_head;
            }

        }
        //single_head_for_Highest
        if (!$merge) {
            unset($single_head);
            $single_head['name'] = 'Highest';
            $single_head['style'] = 'class="res5" colspan="1" rowspan="1"';
            $head[] = $single_head;
        }



        //single_head_for_Grade
        if (!$merge) {
            unset($single_head);
            $single_head['name'] = 'Grade';
            $single_head['style'] = 'class="res4" colspan="1" rowspan="1"';
            $head[] = $single_head;
        }

        //single_head_for_GP
        unset($single_head);
        $single_head['name'] = 'GP';
        $single_head['style'] = 'class="res4" colspan="1" rowspan="1"';
        $head[] = $single_head;
        return $head;

    }

    private function filter_data_for_view_single_course($students, $filter_heads, $template, $merit, $overall = false)
    {
        foreach ($students as $key => $student) {
            $filter_courses = array();
            foreach ($student['courses'] as $courses) {
                $new_course = array();
                $new_course['course_details']['course_name'] = $courses['course_name'];
                $new_course['course_details']['course_code'] = $courses['course_code'];
                $new_course['course_details']['course_id'] = $courses['course_id'];
                $table_data = $filter_heads;
                //term result add for merge result
                if (isset($courses['term'])) {
                    foreach ($courses['term'] as $term_id => $term) {
                        if ($term['GP-' . $term_id] == 0) {
                            $table_data['GP-' . $term_id]['result'] = 'F';
                            $table_data['Total-' . $term_id]['result'] = 'F';
                        }
                        $table_data['GP-' . $term_id]['value'] = $term['GP-' . $term_id];
                        $table_data['Total-' . $term_id]['value'] = $term['Total-' . $term_id];
                    }
                }
                //term result add for merge result  end
                if (isset($courses['parts'])) {
                    foreach ($courses['parts'] as $part_keys => $part) {
                        if ($part_keys != 9999) {
                            $table_data[$part['term_course_cycle_part_type_name']]['value'] = $part['marks'];
                            if ($part['marks'] < $part['pass_mark']) {
                                $table_data[$part['term_course_cycle_part_type_name']]['result'] = 'F';
                            } else {
                                $table_data[$part['term_course_cycle_part_type_name']]['result'] = null;
                            }
                            $table_data[$part['term_course_cycle_part_type_name']]['style'] = 'class="" colspan="2" rowspan="1"';
                        }
                    }
                }
                if (isset($template['total_persentage_check'])) {
                    $table_data['Total']['value'] = $courses['parts'][9999]['marks'];
                    if ($courses['parts'][9999]['marks'] < $courses['parts'][9999]['pass_mark']) {
                        $table_data['Total']['result'] = 'F';
                    } else {
                        $table_data['Total']['result'] = null;
                    }
                    $total_persentage_head = $template['total_persentage_check']['value'] . '% Of Total';
                    $table_data[$total_persentage_head]['value'] = ($courses['parts'][9999]['marks'] * $template['total_persentage_check']['value']) / 100;
                    //grand total with
                    $grand_total_head = 'Grand Total';
                    $table_data[$grand_total_head]['value'] = $table_data[$total_persentage_head]['value'];
                } else if (isset($template['group_persentage_check'])) {
                    $term_course_cycle_part_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
                    $types = $term_course_cycle_part_type->find()->enableAutoFields(true)->enableHydration(false)->where(['term_course_cycle_part_type_id  !=' => '9999'])->toArray();
                    $new_heads = array();
                    foreach ($types as $type) {
                        $new_heads[] = $type['term_course_cycle_part_type_name'];
                    }

                    $withouts = $this->find_without_group_persentage_check_single($new_heads, $template['group_persentage_check']['value']);

                    if (count($withouts) > 0) {
                        $seubtrac_marks = 0;
                        $unset_nmaes = '';
                        foreach ($withouts as $without) {
                            $unset_nmaes = $unset_nmaes . ', ' . $without;
                            $seubtrac_marks = $seubtrac_marks + $table_data[$without]['value'];
                        }
                        $unset_nmaes = substr($unset_nmaes, 1);
                        $withouts_head = "Total Without " . $unset_nmaes;
                        //total_without
                        if (isset($courses['parts'][9999]['marks'])) {
                            $table_data[$withouts_head]['value'] = $courses['parts'][9999]['marks'] - $seubtrac_marks;
                        } else {
                            $table_data[$withouts_head]['value'] = 0;
                        }
                        //persentage of total
                        $group_persentage_check = array_values($template['group_persentage_check']['value']);
                        $persentage = $group_persentage_check[0]['persentage'];
                        $persentage_head = $persentage . '% Of Total';
                        $table_data[$persentage_head]['value'] = ($table_data[$withouts_head]['value'] * $persentage) / 100;

                        //grand total with
                        $grand_total_head = 'Grand Total With ' . $unset_nmaes;
                        $table_data[$grand_total_head]['value'] = $table_data[$persentage_head]['value'] + $seubtrac_marks;
                    } else {
                        $table_data['Total']['value'] = $courses['parts'][9999]['marks'];
                        if ($courses['parts'][9999]['marks'] < $courses['parts'][9999]['pass_mark']) {
                            $table_data['Total']['result'] = 'F';
                        } else {
                            $table_data['Total']['result'] = null;
                        }

                        //persentage of total
                        $group_persentage_check = array_values($template['group_persentage_check']['value']);
                        $persentage = $group_persentage_check[0]['persentage'];
                        $persentage_head = $persentage . '% Of Total';
                        $table_data[$persentage_head]['value'] = ($table_data['Total']['value'] * $persentage) / 100;

                        //grand total with
                        $grand_total_head = 'Grand Total';
                        $table_data[$grand_total_head]['value'] = $table_data[$persentage_head]['value'];
                    }
                } else {
                    if (isset($courses['parts'])) {
                        $table_data['Total']['value'] = $courses['parts'][9999]['marks'];
                        if ($courses['parts'][9999]['marks'] < $courses['parts'][9999]['pass_mark']) {
                            $table_data['Total']['result'] = 'F';
                        } else {
                            $table_data['Total']['result'] = null;
                        }
                    }
                }



                $table_data['Grade']['value'] = $courses['result']['grade_name'];
                if ($courses['result']['grade_name'] == 'F' || $courses['result']['grade_name'] == 'f') {
                    $table_data['Grade']['result'] = 'F';
                } else {
                    $table_data['Grade']['result'] = null;
                }
                $table_data['GP']['value'] = $courses['result']['point'];
                $table_data['GP']['style'] = null;
                if ($courses['result']['point'] == 0) {
                    $table_data['GP']['result'] = 'F';
                } else {
                    $table_data['GP']['result'] = null;
                }

                if (isset($courses['result']['highest_in_' . $merit]) && !$overall) {
                    $table_data['Highest']['value'] = $courses['result']['highest_in_' . $merit];
                }
                if (isset($template['merge_subject']) && $template['merge_subject'] == 'yes') {
                    unset($table_data['Grade']);
                    unset($table_data['Highest']);
                }
                $new_course['table_data'] = $table_data;
                $filter_courses[$courses['course_code']] = $new_course;
            }
            unset($students[$key]['courses']);
            $students[$key]['single_filter_course'] = $filter_courses;
        }


        return $students;
    }

    private function filter_data_for_view_merge_course($students, $filter_heads, $template, $merit)
    {
        foreach ($students as $key => $student) {
            $new_merge_course = array();
            foreach ($student['merge_course'] as $merge_course_key => $merge_courses) {
                $term = isset($merge_courses['total']['term']) ? $merge_courses['total']['term'] : null;   //term result add for merge result
                $total = $merge_courses['total'];
                $total_result = $merge_courses['result'];
                unset($merge_courses['total']);
                unset($merge_courses['result']);
                foreach ($merge_courses as $merge_course) {
                    $new_merge_course_single['course_details']['course_name'] = $merge_course['course_name'];
                    $new_merge_course_single['course_details']['course_code'] = $merge_course['course_code'];
                    $table_data = $filter_heads;
                    foreach ($merge_course['parts'] as $part_keys => $part) {
                        if ($part_keys != 9999) {
                            $table_data[$part['term_course_cycle_part_type_name']]['value'] = $part['marks'];
                            if ($part['marks'] < $part['pass_mark']) {
                                $table_data[$part['term_course_cycle_part_type_name']]['result'] = 'F';
                            } else {
                                $table_data[$part['term_course_cycle_part_type_name']]['result'] = null;
                            }
                        }
                    }
                    $new_merge_course_single['table_data'] = $table_data;
                    $new_merge_course[$merge_course_key]['single'][$merge_course['course_code']] = $new_merge_course_single;
                    $new_merge_course[$merge_course_key]['term'] = $term;    //term result add for merge result
                }

                //merge_course_merge
                $table_data = $filter_heads;
                foreach ($total['parts'] as $part_keys => $part) {
                    if ($part_keys != 9999) {
                        $table_data[$part['term_course_cycle_part_type_name']]['value'] = $part['marks'];
                        if ($part['marks'] < $part['pass_mark']) {
                            $table_data[$part['term_course_cycle_part_type_name']]['result'] = 'F';
                        } else {
                            $table_data[$part['term_course_cycle_part_type_name']]['result'] = null;
                        }
                    }
                }
                if (isset($template['total_persentage_check'])) {
                    $table_data['Total']['value'] = $total['parts'][9999]['marks'];
                    if ($total['parts'][9999]['marks'] < $total['parts'][9999]['pass_mark']) {
                        $table_data['Total']['result'] = 'F';
                    } else {
                        $table_data['Total']['result'] = null;
                    }
                    $total_persentage_head = $template['total_persentage_check']['value'] . '% Of Total';
                    $table_data[$total_persentage_head]['value'] = ($total['parts'][9999]['marks'] * $template['total_persentage_check']['value']) / 100;
                    //grand total with
                    $grand_total_head = 'Grand Total';
                    $table_data[$grand_total_head]['value'] = $table_data[$total_persentage_head]['value'];
                } else if (isset($template['group_persentage_check'])) {
                    $term_course_cycle_part_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
                    $types = $term_course_cycle_part_type->find()->enableAutoFields(true)->enableHydration(false)->where(['term_course_cycle_part_type_id  !=' => '9999'])->toArray();
                    $new_heads = array();
                    foreach ($types as $type) {
                        $new_heads[] = $type['term_course_cycle_part_type_name'];
                    }
                    $withouts = $this->find_without_group_persentage_check_single($new_heads, $template['group_persentage_check']['value']);
                    if (count($withouts) > 0) {
                        $seubtrac_marks = 0;
                        $unset_nmaes = '';
                        foreach ($withouts as $without) {
                            $unset_nmaes = $unset_nmaes . ', ' . $without;
                            $seubtrac_marks = $seubtrac_marks + $table_data[$without]['value'];
                        }
                        $unset_nmaes = substr($unset_nmaes, 1);
                        $withouts_head = "Total Without " . $unset_nmaes;
                        //total_without
                        $table_data[$withouts_head]['value'] = $total['parts'][9999]['marks'] - $seubtrac_marks;

                        //persentage of total
                        $group_persentage_check = array_values($template['group_persentage_check']['value']);
                        $persentage = $group_persentage_check[0]['persentage'];
                        $persentage_head = $persentage . '% Of Total';
                        $table_data[$persentage_head]['value'] = ($table_data[$withouts_head]['value'] * $persentage) / 100;

                        //grand total with
                        $grand_total_head = 'Grand Total With ' . $unset_nmaes;
                        $table_data[$grand_total_head]['value'] = $table_data[$persentage_head]['value'] + $seubtrac_marks;
                    } else {
                        $table_data['Total']['value'] = $total['parts'][9999]['marks'];
                        if ($total['parts'][9999]['marks'] < $total['parts'][9999]['pass_mark']) {
                            $table_data['Total']['result'] = 'F';
                        } else {
                            $table_data['Total']['result'] = null;
                        }

                        //persentage of total
                        $group_persentage_check = array_values($template['group_persentage_check']['value']);
                        $persentage = $group_persentage_check[0]['persentage'];
                        $persentage_head = $persentage . '% Of Total';
                        $table_data[$persentage_head]['value'] = ($table_data['Total']['value'] * $persentage) / 100;

                        //grand total with
                        $grand_total_head = 'Grand Total';
                        $table_data[$grand_total_head]['value'] = $table_data[$persentage_head]['value'];
                    }
                } else {
                    $table_data['Total']['value'] = $total['parts'][9999]['marks'];
                    if ($total['parts'][9999]['marks'] < $total['parts'][9999]['pass_mark']) {
                        $table_data['Total']['result'] = 'F';
                    } else {
                        $table_data['Total']['result'] = null;
                    }
                }
                $table_data['GP']['value'] = $total_result['point'];
              
                       if ($total_result['point'] == 0) {
                    $table_data['GP']['result'] = 'F';
                } else {
                    $table_data['GP']['result'] = null;
                }

                $table_data['Grade']['value'] = $total_result['grade_name'];
             if ($total_result['grade_name'] == 'F' || $total_result['grade_name'] == 'f') {
                    $table_data['Grade']['result'] = 'F';
                } else {
                    $table_data['Grade']['result'] = null;
                }

                if (isset($total_result['highest_in_' . $merit])) {
                    $table_data['Highest']['value'] = $total_result['highest_in_' . $merit];
                }

                $new_merge_course[$merge_course_key]['merge'] = $table_data;
                unset($students[$key]['merge_course']);
            }
            $merge_course = $this->merge_course_set($new_merge_course);
            $students[$key]['merge_filter_course'] = $merge_course;
        }

        return $students;
    }

    private function merge_course_set($new_merge_course)
    {
        foreach ($new_merge_course as $key => $merge_course) {
            $single_courses = array_values($merge_course['single']);
            foreach ($single_courses[0]['table_data'] as $key => $unit) {
                if (isset($unit['type'])) {
                    $style = 'class="" colspan="1" rowspan="2"';
                    $unit['style'] = 'class="" colspan="1" rowspan="1"';
                    $merge_set1[$key] = $unit;
                    $merge_set1[$key . '_merge'] = $merge_course['merge'][$key];
                    $merge_set1[$key . '_merge']['style'] = $style;
                } else {
                    $style = 'class="" colspan="1" rowspan="2"';
                    $merge_set1[$key] = $merge_course['merge'][$key];
                    $merge_set1[$key]['style'] = $style;
                }
            }

            //term result add for merge result
            if (isset($merge_course['term'])) {
                foreach ($merge_course['term'] as $term_id => $term) {
                    $merge_set1['GP-' . $term_id]['value'] = $term['GP-' . $term_id];
                    $merge_set1['GP-' . $term_id]['style'] = 'class="" colspan="1" rowspan="2"';
                    $merge_set1['Total-' . $term_id]['value'] = $term['Total-' . $term_id];
                    $merge_set1['Total-' . $term_id]['style'] = 'class="" colspan="1" rowspan="2"';
                    if ($term['GP-' . $term_id] == 0) {
                        $merge_set1['GP-' . $term_id]['result'] = 'F';
                        $merge_set1['Total-' . $term_id]['result'] = 'F';
                    }
                }
            }
            //term result add for merge result end

            $set_merge_course['1st_course']['course_details'] = $single_courses[0]['course_details'];
            $set_merge_course['1st_course']['table_data'] = $merge_set1;

            foreach ($single_courses[1]['table_data'] as $key => $unit) {
                $style = 'class="" colspan="1" rowspan="2"';
                if (isset($unit['type'])) {
                    $unit['style'] = '';
                    $merge_set2[$key] = $unit;
                }
            }
            $set_merge_course['2st_course']['course_details'] = $single_courses[1]['course_details'];
            $set_merge_course['2st_course']['table_data'] = $merge_set2;
            $course[] = $set_merge_course;
        }
        return $course;
    }

    private function filter_data_for_view($students, $heads, $template, $overall = false)
    {
        $filter_heads = array();
        foreach ($heads as $head) {
            $filter_heads[$head['name']]['value'] = null;
            $filter_heads[$head['name']]['result'] = null;
            $filter_heads[$head['name']]['style'] = null;
            if (isset($head['type'])) {
                $filter_heads[$head['name']]['type'] = $head['type'];
                $filter_heads[$head['name']]['style'] = 'class="" colspan="2" rowspan="1"';
            }
        }
        $merit_from = $template['merit'];
        $students = $this->filter_data_for_view_single_course($students, $filter_heads, $template, $merit_from, $overall);
        if (isset($template['merge_subject'])) {
            $students = $this->filter_data_for_view_merge_course($students, $filter_heads, $template, $merit_from);
        }


        return $students;
    }

    private function find_without_group_persentage_check($heads, $group_persentage_check)
    {
        foreach ($heads as $key => $head) {
            $only_names[$key] = $head['name'];
        }
        $group_persentage_check = array_values($group_persentage_check);
        $parts = explode(", ", $group_persentage_check[0]['view']);
        $diff = array_diff($only_names, $parts);

        return $diff;
    }

    private function find_without_group_persentage_check_single($heads, $group_persentage_check)
    {
        $group_persentage_check = array_values($group_persentage_check);
        $parts = explode(", ", $group_persentage_check[0]['view']);
        $diff = array_diff($heads, $parts);

        return $diff;
    }

    public function resultMerit($id)
    {
        $scms_result_students = TableRegistry::getTableLocator()->get('scms_result_students');
        $result_students = $scms_result_students->find()->where(['result_id' => $id])->enableAutoFields(true)->enableHydration(false)->select([
            'shift_id_cycle' => 'scms_student_cycle.shift_id',
            'section_id_cycle' => 'scms_student_cycle.section_id',
            'level_id_cycle' => 'scms_student_cycle.level_id',
            'roll' => 'scms_student_cycle.roll',
        ])->join([
                    'scms_student_term_cycle' => [
                        'table' => 'scms_student_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_term_cycle.student_term_cycle_id  = scms_result_students.student_term_cycle_id'],
                    ],
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_cycle.student_cycle_id   = scms_student_term_cycle.student_cycle_id'],
                    ],
                ])->toArray();

        if (count($result_students) > 0) {
            usort($result_students, function ($a, $b) {
                return [$a['gpa_with_forth_subject'],$a['gpa'], $a['marks_with_forth_subject'], $b['roll'], $a['section_id']] <=>
                    [$b['gpa_with_forth_subject'],$b['gpa'], $b['marks_with_forth_subject'], $a['roll'], $b['section_id']];
            });

            foreach ($result_students as $key => $students) {
                $result_students[$key]['position_in_level'] = null;
                $result_students[$key]['position_in_shift'] = null;
                $result_students[$key]['position_in_section'] = null;
            }

            $students = array_reverse($result_students);
            $students_and_highest = $this->set_position($students, 'level');
            $students = $students_and_highest['students'];
            $this->save_highest($students_and_highest, 'level');
            $this->calculate_course_highest($students, 'level');

            //filter in shift
            foreach ($students as $result_student) {
                $shifts_students[$result_student['shift_id_cycle']][] = $result_student;
            }
            foreach ($shifts_students as $key => $shift_students) {
                $students_and_highest = $this->set_position($shift_students, 'shift');
                $shifts_students[$key] = $students_and_highest['students'];
                $this->save_highest($students_and_highest, 'shift');
                $this->calculate_course_highest($shifts_students[$key], 'shift');

                //filter in section
                foreach ($shifts_students[$key] as $shift_student) {
                    $sections_shifts_students[$key][$shift_student['section_id_cycle']][] = $shift_student;
                }
                foreach ($sections_shifts_students[$key] as $key2 => $section_shifts_students) {
                    $sections_shifts_students[$key][$key2] = $this->set_position($section_shifts_students, 'section');
                    $students_and_highest = $this->set_position($section_shifts_students, 'section');
                    $sections_shifts_students[$key][$key2] = $students_and_highest['students'];
                    $this->save_highest($students_and_highest, 'section');
                    $this->calculate_course_highest($sections_shifts_students[$key][$key2], 'section');
                }
            }

            //save position in database
            foreach ($sections_shifts_students as $sections_shift_students) {
                foreach ($sections_shift_students as $section_shift_students) {
                    foreach ($section_shift_students as $student) {
                        $position_data['position_in_level'] = $student['position_in_level'];
                        $position_data['position_in_shift'] = $student['position_in_shift'];
                        $position_data['position_in_section'] = $student['position_in_section'];
                        $query = $scms_result_students->query();
                        $query->update()->set($position_data)->where(['result_student_id' => $student['result_student_id']])->execute();
                    }
                }
            }
        }
        //Set Flash
        $type = $this->get_result_type($id);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['level_id' => $result_students[0]['level_id_cycle']])
            ->toArray();

        $this->Flash->success(__('Merit Successfully Generated for class {0}', $levels[0]['level_name']), [
            'key' => 'positive',
            'params' => [],
        ]);

        // $this->Flash->success('Meril Successfully Genarated', [
        //     'key' => 'positive',
        //     'params' => [],
        // ]);
        if ($type == 'single') {
            return $this->redirect(['action' => 'index']);
        } else {
            return $this->redirect(['action' => 'mergeResult']);
        }
    }

    private function get_result_type($id)
    {
        $scms_results = TableRegistry::getTableLocator()->get('scms_results');
        $results = $scms_results->find()->where(['result_id' => $id])->enableAutoFields(true)->enableHydration(false)->toArray();
        return $results[0]['type'];
    }

    private function calculate_course_highest($students, $type)
    {
        foreach ($students as $student) {
            $result_student_ids[] = $student['result_student_id'];
        }
        //highest for single course start
        $scms_result_student_courses = TableRegistry::getTableLocator()->get('scms_result_student_courses');
        $courses = $scms_result_student_courses->find()->where(['result_student_id  in' => $result_student_ids])->where(['course_id  !=' => 0])->group('course_id')->enableAutoFields(true)->enableHydration(false)->toArray();
        foreach ($courses as $course) {
            $query = $scms_result_student_courses->find()->where(['result_student_id  in' => $result_student_ids])->where(['course_id' => $course['course_id']]);
            $query->select([
                'highest' => $query->func()->max('obtain_mark')
            ])->enableAutoFields(true)->enableHydration(false);
            foreach ($query as $row) {
                $data['highest_in_' . $type] = $row['highest'];
            }

            $update_query = $scms_result_student_courses->query();
            $update_query->update()->set($data)->where(['result_student_id  in' => $result_student_ids])->where(['course_id' => $course['course_id']])->execute();
        }
        //highest for single course end
//----*------*------
//highest for merge course start
        $merge_courses = $scms_result_student_courses->find()->where(['result_student_id  in' => $result_student_ids])->where(['type' => 'merge'])->group('first_course_id_of_merge_course')->enableAutoFields(true)->enableHydration(false)->toArray();

        foreach ($merge_courses as $merge_course) {
            $query = $scms_result_student_courses->find()->where(['result_student_id  in' => $result_student_ids])->where(['first_course_id_of_merge_course' => $merge_course['first_course_id_of_merge_course']]);
            $query->select([
                'highest' => $query->func()->max('obtain_mark')
            ])->enableAutoFields(true)->enableHydration(false);
            foreach ($query as $row) {
                $data['highest_in_' . $type] = $row['highest'];
            }

            $update_query = $scms_result_student_courses->query();
            $update_query->update()->set($data)->where(['result_student_id  in' => $result_student_ids])->where(['first_course_id_of_merge_course' => $merge_course['first_course_id_of_merge_course']])->execute();
        }
        //highest for merge course end

        return true;
    }

    private function save_highest($students_and_highest, $type)
    {
        $scms_result_highest_data['result_id'] = $students_and_highest['students'][0]['result_id'];
        $scms_result_highest_data['highest_mark'] = $students_and_highest['highest']['highest_mark'];
        $scms_result_highest_data['highest_gpa'] = $students_and_highest['highest']['highest_gpa'];

        $scms_result_highest = TableRegistry::getTableLocator()->get('scms_result_highest');
        if ($type == 'level') {
            $scms_result_highest_data['level_id'] = $students_and_highest['students'][0]['level_id_cycle'];
            $previous_highest = $scms_result_highest->find()->where(['result_id' => $scms_result_highest_data['result_id']])->where(['level_id' => $scms_result_highest_data['level_id']])->where(['shift_id is NULL'])->where(['section_id is NULL'])->enableAutoFields(true)->enableHydration(false)->toArray();
            if (count($previous_highest) == 0) {
                $query = $scms_result_highest->query();
                $query->insert(['result_id', 'highest_mark', 'highest_gpa', 'level_id'])->values($scms_result_highest_data)->execute();
            } else {
                $query = $scms_result_highest->query();
                $query->update()->set($scms_result_highest_data)->where(['result_highest_id' => $previous_highest[0]['result_highest_id']])->execute();
            }
        } else if ($type == 'shift') {
            $scms_result_highest_data['level_id'] = $students_and_highest['students'][0]['level_id_cycle'];
            $scms_result_highest_data['shift_id'] = $students_and_highest['students'][0]['shift_id_cycle'];
            $previous_highest = $scms_result_highest->find()->where(['result_id' => $scms_result_highest_data['result_id']])->where(['level_id' => $scms_result_highest_data['level_id']])->where(['shift_id' => $scms_result_highest_data['shift_id']])->where(['section_id is NULL'])->enableAutoFields(true)->enableHydration(false)->toArray();
            if (count($previous_highest) == 0) {
                $query = $scms_result_highest->query();
                $query->insert(['result_id', 'highest_mark', 'highest_gpa', 'level_id', 'shift_id'])->values($scms_result_highest_data)->execute();
            } else {
                $query = $scms_result_highest->query();
                $query->update()->set($scms_result_highest_data)->where(['result_highest_id' => $previous_highest[0]['result_highest_id']])->execute();
            }
        } else if ($type == 'section') {
            $scms_result_highest_data['level_id'] = $students_and_highest['students'][0]['level_id_cycle'];
            $scms_result_highest_data['shift_id'] = $students_and_highest['students'][0]['shift_id_cycle'];
            $scms_result_highest_data['section_id'] = $students_and_highest['students'][0]['section_id_cycle'];
            $previous_highest = $scms_result_highest->find()->where(['result_id' => $scms_result_highest_data['result_id']])->where(['level_id' => $scms_result_highest_data['level_id']])->where(['shift_id' => $scms_result_highest_data['shift_id']])->where(['section_id' => $scms_result_highest_data['section_id']])->enableAutoFields(true)->enableHydration(false)->toArray();
            if (count($previous_highest) == 0) {
                $query = $scms_result_highest->query();
                $query->insert(['result_id', 'highest_mark', 'highest_gpa', 'level_id', 'shift_id', 'section_id'])->values($scms_result_highest_data)->execute();
            } else {
                $query = $scms_result_highest->query();
                $query->update()->set($scms_result_highest_data)->where(['result_highest_id' => $previous_highest[0]['result_highest_id']])->execute();
            }
        }
        return true;
    }

    private function set_position($students, $type)
    {
        $index = 'position_in_' . $type;
        $previous_gpa = 0;
        $previous_total = 0;
        $highest['highest_mark'] = 0;
        $highest['highest_gpa'] = 0;
        if ($this->get_settings_value('multiple_merit_position')) {
            $j = 1;
            for ($i = 0; $i < count($students); $i++) {
                if ($students[$i]['gpa_with_forth_subject']) {
                    if ($students[$i]['gpa_with_forth_subject'] == $previous_gpa && $students[$i]['marks_with_forth_subject'] == $previous_total) {
                        $students[$i][$index] = $this->ordinal($j - 1);
                    } else {
                        $students[$i][$index] = $this->ordinal($j);
                        $j++;
                    }
                    $previous_gpa = $students[$i]['gpa_with_forth_subject'];
                    $previous_total = $students[$i]['marks_with_forth_subject'];
                }
                if ($highest['highest_mark'] < $students[$i]['marks_with_forth_subject']) {
                    $highest['highest_mark'] = $students[$i]['marks_with_forth_subject'];
                }
                if ($highest['highest_gpa'] < $students[$i]['gpa_with_forth_subject']) {
                    $highest['highest_gpa'] = $students[$i]['gpa_with_forth_subject'];
                }
            }
        } else {
            for ($i = 0; $i < count($students); $i++) {
                if ($students[$i]['gpa_with_forth_subject']) {
                    $students[$i][$index] = $this->ordinal($i + 1);
                }
                if ($highest['highest_mark'] < $students[$i]['marks_with_forth_subject']) {
                    $highest['highest_mark'] = $students[$i]['marks_with_forth_subject'];
                }
                if ($highest['highest_gpa'] < $students[$i]['gpa_with_forth_subject']) {
                    $highest['highest_gpa'] = $students[$i]['gpa_with_forth_subject'];
                }
            }
        }
        $return['students'] = $students;
        $return['highest'] = $highest;
        return $return;
    }

    private function ordinal($number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . 'th';
        } else {
            return $number . $ends[$number % 10];
        }
    }

    private function result_summary($students, $results, $section_id = false)
    {
        $grade = TableRegistry::getTableLocator()->get('scms_grade');
        $grades = $grade->find()->enableAutoFields(true)->enableHydration(false)->order(['point' => 'ASC'])->where(['gradings_id' => $results['gradings_id']])->toArray();
        usort($grades, function ($a, $b) {
            return [$a['point']] <=>
                [$b['point']];
        });
        $grades = array_reverse($grades);
        $filter_grade = array();
        foreach ($grades as $grade) {
            $grade['count'] = 0;
            $filter_grade[$grade['grade_name']] = $grade;
        }
        $count['pass'] = 0;
        $count['total'] = 0;
        $count['fail'] = 0;
        foreach ($students as $key => $student) {
            $filter_grade[$student['result']['grade_with_forth_subject']]['count']++;
            $count['total']++;
            if ($student['result']['gpa_with_forth_subject'] == 0) {
                $count['fail']++;
            } else {
                $count['pass']++;
            }
            $students[$key]["failed_course"] = null;
            foreach ($student['courses'] as $course) {
                if ($course['result']['point'] == 0) {
                    if ($students[$key]["failed_course"]) {
                        $students[$key]["failed_course"] = $students[$key]["failed_course"] . ', ' . $course['course_code'];
                    } else {
                        $students[$key]["failed_course"] = $course['course_code'];
                    }
                }
            }
            if (isset($student['merge_course'])) {
                foreach ($student['merge_course'] as $merge_course) {
                    if ($merge_course['result']['point'] == 0) {
                        unset($merge_course['result']);
                        unset($merge_course['total']);
                        foreach ($merge_course as $merge_single_course) {
                            if ($students[$key]["failed_course"]) {
                                $students[$key]["failed_course"] = $students[$key]["failed_course"] . ', ' . $merge_single_course['course_code'];
                            } else {
                                $students[$key]["failed_course"] = $merge_single_course['course_code'];
                            }
                        }
                    }
                }
            }
            if (!$students[$key]["failed_course"]) {
                $students[$key]["failed_course"] = "N/A";
            }
        }
        $this->layout = 'result';
        $this->autoRender = false;
        $merit_from = $this->get_position($results['result_template_id']);
        $this->set('position', $merit_from);
        $exam_title = $this->get_exam_result_title($results['session_id'], $results['level_id'], $results['term_cycle_id']);
        if ($section_id) {
            $exam_title[2] = 'CLASS : ' . $students[$key]['level_name'] . '(' . $students[$key]['section_name'] . ')- SUMMERY SHEET ' . $students[$key]['session_name'] . ' (' . $students[$key]['shift_name'] . ')';
        } else {
            $exam_title[2] = 'CLASS : ' . $students[$key]['level_name'] . '- SUMMERY SHEET ' . $students[$key]['session_name'] . ' (' . $students[$key]['shift_name'] . ')';
        }
        $this->set('exam_title', $exam_title);
        $decemal_point = $this->get_settings_value('number_format_value_after_decimal');
        $this->set('decemal_point', $decemal_point);
        $this->set('students', $students);
        $this->set('filter_grade', $filter_grade);
        $this->set('count', $count);
        $this->render('/result/result_summary');
    }

    private function result_tabulation($students, $results, $section_id = false)
    {
        $grade = TableRegistry::getTableLocator()->get('scms_grade');
        $grades = $grade->find()->enableAutoFields(true)->enableHydration(false)->order(['point' => 'ASC'])->where(['gradings_id' => $results['gradings_id']])->toArray();

        foreach ($students as $student) {
            $result_student_ids[] = $student['result_student_id'];
        }
        $scms_result_student_course = TableRegistry::getTableLocator()->get('scms_result_student_courses');
        $scms_result_student_courses = $scms_result_student_course->find()->where(['result_student_id IN' => $result_student_ids])->where(['scms_result_student_courses.course_id !=' => 0])->enableAutoFields(true)->enableHydration(false)->group('scms_courses.course_code')->select([
            'course_name' => 'scms_courses.course_name',
            'course_code' => 'scms_courses.course_code',
        ])->join([
                    'scms_courses' => [
                        'table' => 'scms_courses',
                        'type' => 'LEFT',
                        'conditions' => ['scms_courses.course_id   = scms_result_student_courses.course_id'],
                    ],
                ])->toArray();
        $term_course_cycle_part_type = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_type');
        $types = $term_course_cycle_part_type->find()->enableAutoFields(true)->enableHydration(false)->where(['term_course_cycle_part_type_id  !=' => '9999'])->toArray();
        foreach ($types as $type) {
            $type['value'] = '-';
            $filter_types[$type['term_course_cycle_part_type_id']] = $type;
        }

        foreach ($scms_result_student_courses as $key => $scms_result_student_course) {
            $scms_result_student_course['view_name'] = $student['level_id'] . '-' . $scms_result_student_course['course_code'] . '<br>' . $scms_result_student_course['course_name'];
            $scms_result_student_course['parts'] = $filter_types;
            $scms_result_student_course['other_parts']['total']['name'] = 'Total';
            $scms_result_student_course['other_parts']['gp']['name'] = 'GP';
            $scms_result_student_course['other_parts']['letter_grade']['name'] = 'Letter Grade';
            $scms_result_student_course['other_parts']['total']['value'] = '-';
            $scms_result_student_course['other_parts']['gp']['value'] = '-';
            $scms_result_student_course['other_parts']['letter_grade']['value'] = '-';
            $filter_scms_result_student_courses[$scms_result_student_course['course_code']] = $scms_result_student_course;
        }
        $filter_scms_result_student_courses_initial = $filter_scms_result_student_courses;

        foreach ($students as $key => $student) {
            foreach ($student['courses'] as $courses) {
                $filter_scms_result_student_courses[$courses['course_code']]['other_parts']['total']['value'] = $courses['result']['marks'];
                $filter_scms_result_student_courses[$courses['course_code']]['other_parts']['gp']['value'] = $courses['result']['point'];
                $filter_scms_result_student_courses[$courses['course_code']]['other_parts']['letter_grade']['value'] = $courses['result']['grade_name'];
                if ($filter_scms_result_student_courses[$courses['course_code']]['other_parts']['letter_grade']['value'] == 'F') {
                    $filter_scms_result_student_courses[$courses['course_code']]['other_parts']['letter_grade']['value'] = '<span class="crsFailed">' . $filter_scms_result_student_courses[$courses['course_code']]['other_parts']['letter_grade']['value'] . '</span>';
                }

                unset($courses['parts'][9999]);
                if (isset($courses['parts'])) {
                    foreach ($courses['parts'] as $part) {
                        if ($part['pass_mark'] > $part['obtain_mark']) {
                            $filter_scms_result_student_courses[$courses['course_code']]['parts'][$part['term_course_cycle_part_type_id']]['value'] = '<span class="crsFailed">' . $part['obtain_mark'] . '</span>';
                        } else {
                            $filter_scms_result_student_courses[$courses['course_code']]['parts'][$part['term_course_cycle_part_type_id']]['value'] = $part['obtain_mark'];
                        }
                    }
                }
            }
            foreach ($student['merge_course'] as $merge_course) {
                unset($merge_course['total']);
                unset($merge_course['result']);
                foreach ($merge_course as $merge_single_course) {
                    $gpa_course = $this->course_gpa($grades, $merge_single_course['result']);
                    $filter_scms_result_student_courses[$merge_single_course['course_code']]['other_parts']['total']['value'] = $merge_single_course['result']['marks'];
                    $filter_scms_result_student_courses[$merge_single_course['course_code']]['other_parts']['gp']['value'] = $gpa_course['point'];
                    $filter_scms_result_student_courses[$merge_single_course['course_code']]['other_parts']['letter_grade']['value'] = $gpa_course['grade_name'];

                    if ($filter_scms_result_student_courses[$merge_single_course['course_code']]['other_parts']['letter_grade']['value'] == 'F') {
                        $filter_scms_result_student_courses[$merge_single_course['course_code']]['other_parts']['letter_grade']['value'] = '<span class="crsFailed">' . $filter_scms_result_student_courses[$merge_single_course['course_code']]['other_parts']['letter_grade']['value'] . '</span>';
                    }
                    unset($merge_single_course['parts'][9999]);
                    foreach ($merge_single_course['parts'] as $part) {
                        if ($part['pass_mark'] > $part['obtain_mark']) {
                            $filter_scms_result_student_courses[$merge_single_course['course_code']]['parts'][$part['term_course_cycle_part_type_id']]['value'] = '<span class="crsFailed">' . $part['obtain_mark'] . '</span>';
                        } else {
                            $filter_scms_result_student_courses[$merge_single_course['course_code']]['parts'][$part['term_course_cycle_part_type_id']]['value'] = $part['obtain_mark'];
                        }
                    }
                }
                if ($student['result']['result'] == 'pass') {
                    $students[$key]['result']['result'] = "Passed";
                } else {
                    $students[$key]['result']['result'] = '<span class="crsFailed">' . "Failed" . '</span>';
                }
            }
            $students[$key]['view'] = $filter_scms_result_student_courses;
            $filter_scms_result_student_courses = $filter_scms_result_student_courses_initial;
            unset($students[$key]['merge_course']);
            unset($students[$key]['courses']);
            unset($students[$key]['guardians']);
        }

        $this->layout = 'result';
        $this->autoRender = false;
        $merit_from = $this->get_position($results['result_template_id']);
        $this->set('position', $merit_from);

        $decemal_point = $this->get_settings_value('number_format_value_after_decimal');
        $this->set('decemal_point', $decemal_point);
        $this->set('students', $students);
        $this->set('course_heads', $filter_scms_result_student_courses_initial);
        $exam_title = $this->get_exam_result_title($results['session_id'], $results['level_id'], $results['term_cycle_id']);
        if ($section_id) {
            $exam_title[2] = 'CLASS : ' . $students[$key]['level_name'] . '(' . $students[$key]['section_name'] . ')- TABULATION SHEET ' . $students[$key]['session_name'];
        } else {
            $exam_title[2] = 'CLASS : ' . $students[$key]['level_name'] . '- TABULATION SHEET ' . $students[$key]['session_name'];
        }
        $this->set('exam_title', $exam_title);
        $this->render('/result/tabulation');
    }

    private function result_marksheet($students, $results, $section_id = false)
    {
        $template = $this->get_template($results['result_template_id']);
        $heads = $this->genarate_marks_heads($template);
        $students = $this->filter_data_for_view($students, $heads, $template);

        $scms_result_attendance_month = TableRegistry::getTableLocator()->get('scms_result_attendance_month');
        $result_attendance_month = $scms_result_attendance_month->find()->where(['result_id' => $results['result_id']])->enableAutoFields(true)->enableHydration(false)->toArray();
        $month[1]['count'] = '--';
        $month[2]['count'] = '--';
        $month[3]['count'] = '--';
        $month[4]['count'] = '--';
        $month[5]['count'] = '--';
        $month[6]['count'] = '--';
        $month[7]['count'] = '--';
        $month[8]['count'] = '--';
        $month[9]['count'] = '--';
        $month[10]['count'] = '--';
        $month[11]['count'] = '--';
        $month[12]['count'] = '--';
        $month[13]['count'] = '--';
        foreach ($result_attendance_month as $attendance_month) {
            $month[$attendance_month['month_id']]['count'] = $attendance_month['count'];
        }
        $scms_activity_remarks = $this->default_activities();
        $return_scms_activity_remarks = array_values($this->get_result_activity_names($results['result_id']));
        if (isset($return_scms_activity_remarks[0])) {
            $scms_activity_remarks[0] = $return_scms_activity_remarks[0];
        }
        if (isset($return_scms_activity_remarks[1])) {
            $scms_activity_remarks[1] = $return_scms_activity_remarks[1];
        }
        $this->layout = 'result';
        $this->autoRender = false;
        $this->set('students', $students);

        $this->set('scms_activity_remarks', $scms_activity_remarks);
        $heads = $this->viewAbleHead($heads);
        $this->set('heads', $heads['heads']);
        $this->set('notes', $heads['notes']);
        $merit_from = $this->get_position($results['result_template_id']);
        $this->set('position', $merit_from);
        $exam_title = $this->get_exam_result_title($results['session_id'], $results['level_id'], $results['term_cycle_id']);
        
        if ($section_id) { 
            $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['session_name'];
        } else { 
            $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['session_name'];
        }
        $this->set('exam_title', $exam_title);
        $last_row_colspan = $this->find_last_row_colspan($template);
        $this->set('last_row_colspan', $last_row_colspan);
        $decemal_point = $this->get_settings_value('number_format_value_after_decimal');
        $this->set('decemal_point', $decemal_point);
        $this->set('total_attandance', $month);
        $grade = TableRegistry::getTableLocator()->get('scms_grade');
        $grades = $grade
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->order(['point' => 'DESC'])
            ->where(['gradings_id' => $results['gradings_id']])
            ->toArray();
        $remarks = array();
        foreach ($grades as $grade) {
            $remarks[$grade['grade_name']] = $grade['remark'];
        }
        $this->set('grades', $grades);

        $settingTable = TableRegistry::getTableLocator()->get('settings');

        $settings = $settingTable->find()
            ->where(['`key`' => 'result.landscape'])
            ->enableHydration(false)
            ->first();

        if (!empty($settings) && $settings['value'] == 'ON') {
            $this->render('/result/landscape_markSheet');
        } else {
            $this->render('/result/markSheet');
        }
        // $this->render('/result/markSheet');
    }

    private function get_position($id)
    {
        $result_template = TableRegistry::getTableLocator()->get('scms_result_template');
        $result_templates = $result_template
            ->find()
            ->where(['result_template_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        return $result_templates[0]['merit'];
    }

    public function viewResult()
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $scms_results = TableRegistry::getTableLocator()->get('scms_results');
            $results = $scms_results->find()->where(['type' => 'single'])->where(['session_id' => $data['session_id']])->where(['level_id' => $data['level_id']])->where(['term_cycle_id' => $data['term_cycle_id']])->enableAutoFields(true)->enableHydration(false)->toArray();
            if (count($results) == 0) {
                $this->Flash->success('No Result To Show', [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'viewResult']);
            } else {
                $where['result_id'] = $results[0]['result_id'];
                if ($data['shift_id']) {
                    $where['scms_student_cycle.shift_id'] = $data['shift_id'];
                }
                if ($data['level_id']) {
                    $where['scms_student_cycle.level_id'] = $data['level_id'];
                }
                if ($data['section_id']) {
                    $where['scms_student_cycle.section_id'] = $data['section_id'];
                }
                if ($data['group_id']) {
                    $where['scms_student_cycle.group_id'] = $data['group_id'];
                }
                if ($data['sid']) {
                    $where['scms_students.sid'] = $data['sid'];
                }
                $students = $this->get_scms_result_students($results[0]['result_id'], $where);
                if (count($students) == 0) {
                    $this->Flash->success('No Student Found', [
                        'key' => 'Negative',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'viewResult']);
                }

                if ($data['sort'] == 'roll') {
                    usort($students, function ($a, $b) {
                        return [$a['section_id'], $a['roll']] <=>
                            [$b['section_id'], $b['roll']];
                    });
                } else {
                    usort($students, function ($a, $b) {
                        return [$b['gpa_with_forth_subject'],$b['gpa'], $b['marks_with_forth_subject'], $a['roll']] <=>
                            [$a['gpa_with_forth_subject'],$a['gpa'], $a['marks_with_forth_subject'], $b['roll']];
                    });
                }

                if ($data['type'] == 'result_summary') {
                    $this->result_summary($students, $results[0], $data['section_id']);
                } else if ($data['type'] == 'tabulation') {
                    $this->result_tabulation($students, $results[0], $data['section_id']);
                } else {
                    $this->result_marksheet($students, $results[0], $data['section_id']);
                }
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group->find()->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('groups', $groups);


        $view_type['mark_sheet'] = 'Mark Sheet';
        $view_type['tabulation'] = 'Tabulation';
        $view_type['result_summary'] = 'Result Summary';
        $this->set('view_type', $view_type);

        $sort_by['roll'] = 'Class Roll';
        $sort_by['merit'] = 'Merit Position';
        $this->set('sort_by', $sort_by);
        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles)) {
            $required = '';
        }
        $this->set('required', $required);
        $levels = $this->get_levels('results');
        $this->set('levels', $levels);

        $shifts = $this->get_shifts('results');
        $this->set('shifts', $shifts);
        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);

        $sections = $this->get_sections('results',$levels[0]->level_id);
        $this->set('sections', $sections);


    }

    private function get_result_total_highest($id)
    {
        $scms_result_highest = TableRegistry::getTableLocator()->get('scms_result_highest');
        $scms_result_highests = $scms_result_highest->find()->where(['result_id' => $id])->enableAutoFields(true)->enableHydration(false)->toArray();
        $return = array();
        foreach ($scms_result_highests as $scms_result_highest) {
            if ($scms_result_highest['level_id'] != null && $scms_result_highest['shift_id'] == null && $scms_result_highest['section_id'] == null) {
                $return['level'][$scms_result_highest['level_id']] = $scms_result_highest;
            } else if ($scms_result_highest['level_id'] != null && $scms_result_highest['shift_id'] != null && $scms_result_highest['section_id'] == null) {
                $return['shift'][$scms_result_highest['shift_id']] = $scms_result_highest;
            } else if ($scms_result_highest['level_id'] != null && $scms_result_highest['shift_id'] != null && $scms_result_highest['section_id'] != null) {
                $return['section'][$scms_result_highest['section_id']] = $scms_result_highest;
            }
        }
        return $return;
    }

    private function get_only_result_students($where)
    {
        $where['scms_students.status'] = 1;
        $scms_result_students = TableRegistry::getTableLocator()->get('scms_result_students');
        $result_students = $scms_result_students->find()->where($where)->enableAutoFields(true)->enableHydration(false)->select([
            'shift_id' => 'scms_student_cycle.shift_id',
            'section_ids' => 'scms_student_cycle.section_id',
            'student_cycle_id' => 'scms_student_cycle.student_cycle_id',
            'level_id' => 'scms_student_cycle.level_id',
            'roll' => 'scms_student_cycle.roll',
            'shift_name' => 'hr_shift.shift_name',
            'level_name' => 'scms_levels.level_name',
            'section_name' => 'scms_sections.section_name',
            'section_name' => 'scms_sections.section_name',
            'student_id' => 'scms_student_cycle.student_id',
            'name' => 'scms_students.name',
            'sid' => 'scms_students.sid',
            'thumbnail' => 'scms_students.thumbnail',
            'date_of_birth' => 'scms_students.date_of_birth',
            'group_name' => 'scms_groups.group_name',
            'session_id' => 'scms_sessions.session_id',
            'session_name' => 'scms_sessions.session_name',
            'term_id' => 'scms_term_cycle.term_id',
            'status' => 'scms_students.status',
        ])->join([
                    'scms_student_term_cycle' => [
                        'table' => 'scms_student_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_term_cycle.student_term_cycle_id = scms_result_students.student_term_cycle_id'],
                    ],
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_term_cycle.term_cycle_id = scms_term_cycle.term_cycle_id'],
                    ],
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_cycle.student_cycle_id  = scms_student_term_cycle.student_cycle_id'],
                    ],
                    'hr_shift' => [
                        'table' => 'hr_shift',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_cycle.shift_id = hr_shift.shift_id'],
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_cycle.level_id = scms_levels.level_id'],
                    ],
                    'scms_sections' => [
                        'table' => 'scms_sections',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_cycle.section_id = scms_sections.section_id'],
                    ],
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'LEFT',
                        'conditions' => ['scms_students.student_id  = scms_student_cycle.student_id'],
                    ],
                    'scms_groups' => [
                        'table' => 'scms_groups',
                        'type' => 'LEFT',
                        'conditions' => ['scms_groups.group_id = scms_student_cycle.group_id'],
                    ],
                    'scms_sessions' => [
                        'table' => 'scms_sessions',
                        'type' => 'LEFT',
                        'conditions' => ['scms_sessions.session_id  = scms_student_cycle.session_id'],
                    ],
                ])->toArray();
        return $result_students;
    }

    public function get_scms_result_students($id, $where)
    {
        $result_students = $this->get_only_result_students($where);
        if (count($result_students) == 0) {
            return $result_students;
        }

        $month[1]['count'] = '--';
        $month[2]['count'] = '--';
        $month[3]['count'] = '--';
        $month[4]['count'] = '--';
        $month[5]['count'] = '--';
        $month[6]['count'] = '--';
        $month[7]['count'] = '--';
        $month[8]['count'] = '--';
        $month[9]['count'] = '--';
        $month[10]['count'] = '--';
        $month[11]['count'] = '--';
        $month[12]['count'] = '--';
        $month[13]['count'] = '--';

        $filter_result_studnets = array();
        $result = array();
        $total_highest = $this->get_result_total_highest($id);
        foreach ($result_students as $result_student) {
            $result['total_marks'] = $result_student['total_marks'];
            $result['marks'] = $result_student['marks'];
            $result['point'] = $result_student['point'];
            $result['gpa'] = $result_student['gpa'];
            $result['marks_with_forth_subject'] = $result_student['marks_with_forth_subject'];
            $result['point_with_forth_subject'] = $result_student['point_with_forth_subject'];
            $result['gpa_with_forth_subject'] = $result_student['gpa_with_forth_subject'];
            $result['result'] = $result_student['result'];
            $result['grade'] = $result_student['grade'];
            $result['grade_with_forth_subject'] = $result_student['grade_with_forth_subject'];
            $result['position_in_level'] = $result_student['position_in_level'];
            $result['position_in_shift'] = $result_student['position_in_shift'];
            $result['position_in_section'] = $result_student['position_in_section'];

            $result['highest_total_in_level'] = isset($total_highest['level'][$result_student['level_id']]['highest_mark']) ? $total_highest['level'][$result_student['level_id']]['highest_mark'] : null;
            $result['highest_total_in_shift'] = isset($total_highest['shift'][$result_student['shift_id']]['highest_mark']) ? $total_highest['shift'][$result_student['shift_id']]['highest_mark'] : null;
            $result['highest_total_in_section'] = isset($total_highest['section'][$result_student['section_ids']]['highest_mark']) ? $total_highest['section'][$result_student['section_ids']]['highest_mark'] : null;
            $filter_result_studnets[$result_student['result_student_id']] = $this->get_guardians($result_student);
            unset($filter_result_studnets[$result_student['result_student_id']]['result']);
            $filter_result_studnets[$result_student['result_student_id']]['result'] = $result;
            $filter_result_studnets[$result_student['result_student_id']]['attandance_data'] = $month;
            $result_student_ids[] = $result_student['result_student_id'];
            $student_term_cycle_ids[] = $result_student['student_term_cycle_id'];
        }

        $filter_result_studnets = $this->get_result_student_attendance_month($filter_result_studnets, $result_student_ids);
        $filter_result_studnets = $this->get_result_student_courses($result_student_ids, $filter_result_studnets);
        $filter_result_studnets = $this->get_result_student_activity($id, $student_term_cycle_ids, $filter_result_studnets);
        $student_third_fourth_subjects = $this->get_studnet_third_fourth_subjects($student_term_cycle_ids);
        foreach ($filter_result_studnets as $key => $filter_result_studnet) {
            $filter_result_studnets[$key]['third_fourth_subjects'] = isset($student_third_fourth_subjects[$filter_result_studnet['student_term_cycle_id']]) ? $student_third_fourth_subjects[$filter_result_studnet['student_term_cycle_id']] : null;
        }
        return $filter_result_studnets;
    }

    private function get_result_activity_names($result_id)
    {
        $scms_result_activity_remark = TableRegistry::getTableLocator()->get('scms_result_activity_remark');
        $activity_remarks = $scms_result_activity_remark
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['scms_result_activity.result_id' => $result_id])
            ->select([
                'activity_name' => 'scms_result_activity.activity_name',
                'activity_id' => 'scms_result_activity.activity_id',
            ])
            ->join([
                'scms_result_activity' => [
                    'table' => 'scms_result_activity',
                    'type' => 'LEFT',
                    'conditions' => ['scms_result_activity.result_activity_id  = scms_result_activity_remark.result_activity_id'],
                ],
            ])
            ->toArray();

        $filter_scms_activity_remarks = array();
        foreach ($activity_remarks as $activity_remark) {
            $filter_scms_activity_remarks[$activity_remark['activity_id']]['activity_name'] = $activity_remark['activity_name'];
            $filter_scms_activity_remarks[$activity_remark['activity_id']]['activity_id'] = $activity_remark['activity_id'];
            $filter_scms_activity_remarks[$activity_remark['activity_id']]['remark'][$activity_remark['activity_remark_id']]['remark_name'] = $activity_remark['remark_name'];
            $filter_scms_activity_remarks[$activity_remark['activity_id']]['remark'][$activity_remark['activity_remark_id']]['activity_remark_id'] = $activity_remark['activity_remark_id'];
        }
        return $filter_scms_activity_remarks;
    }

    private function get_result_student_activity($result_id, $student_term_cycle_ids, $filter_result_studnets)
    {
        $scms_student_activity = TableRegistry::getTableLocator()->get('scms_student_activity');
        $student_activities = $scms_student_activity
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['scms_student_activity.student_term_cycle_id IN' => $student_term_cycle_ids])
            ->select([
                'activity_id' => 'scms_activity_cycle.activity_id',
                'result_student_id' => 'scms_result_students.result_student_id',
            ])
            ->join([
                'scms_term_activity_cycle' => [
                    'table' => 'scms_term_activity_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_activity_cycle.term_activity_cycle_id   = scms_student_activity.term_activity_cycle_id'],
                ],
                'scms_activity_cycle' => [
                    'table' => 'scms_activity_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_activity_cycle.activity_cycle_id  = scms_activity_cycle.activity_cycle_id'],
                ],
                'scms_result_students' => [
                    'table' => 'scms_result_students',
                    'type' => 'LEFT',
                    'conditions' => ['scms_result_students.student_term_cycle_id  = scms_student_activity.student_term_cycle_id'],
                ],
            ])
            ->toArray();
        $filter_scms_activity_remarks = $this->get_result_activity_names($result_id);

        foreach ($student_activities as $activity) {
            $activity_remarks = json_decode($activity['remark_id']);
            $remark_ids = array();
            foreach ($activity_remarks as $activity_remark) {
                $remark_ids[$activity_remark] = 1;
            }
            if (isset($filter_result_studnets[$activity['result_student_id']])) {
                $filter_result_studnets[$activity['result_student_id']]['activity_data'][$activity['activity_id']] = $remark_ids;
            }
        }
        return $filter_result_studnets;
    }

    private function get_result_student_attendance_month($filter_result_studnets, $result_student_ids)
    {
        $scms_result_student_attendance_month = TableRegistry::getTableLocator()->get('scms_result_student_attendance_month');
        $result_attendance_months = $scms_result_student_attendance_month->find()->where(['result_student_id IN' => $result_student_ids])->enableAutoFields(true)->enableHydration(false)->toArray();

        foreach ($result_attendance_months as $result_attendance_month) {
            $filter_result_studnets[$result_attendance_month['result_student_id']]['attandance_data'][$result_attendance_month['month_id']]['count'] = $result_attendance_month['count'];
        }
        return $filter_result_studnets;
    }

    private function get_result_student_courses($result_student_id, $result_students)
    {
        $single_courses = $this->get_result_student_single_courses($result_student_id);

        $merge_courses = $this->get_result_student_merge_courses($result_student_id);

        foreach ($single_courses as $single_course) {
            $result_students[$single_course['result_student_id']]['courses'][$single_course['course_id']] = $single_course;
        }

        foreach ($merge_courses as $merge_course) {
            $result_students[$merge_course['total']['result_student_id']]['merge_course'][] = $merge_course;
        }
        return $result_students;
    }

    private function get_result_student_single_courses($result_student_id)
    {
        $scms_result_student_course = TableRegistry::getTableLocator()->get('scms_result_student_courses');
        $scms_result_student_courses = $scms_result_student_course->find()->where(['result_student_id IN' => $result_student_id])->where(['type' => 'single'])->where(['parent_result_student_course_id is NULL'])->enableAutoFields(true)->enableHydration(false)->select([
            'course_name' => 'scms_courses.course_name',
            'course_code' => 'scms_courses.course_code',
            'course_type_id' => 'scms_courses.course_type_id',
        ])->join([
                    'scms_courses' => [
                        'table' => 'scms_courses',
                        'type' => 'LEFT',
                        'conditions' => ['scms_courses.course_id   = scms_result_student_courses.course_id'],
                    ],
                ])->toArray();
        $result = array();
        foreach ($scms_result_student_courses as $scms_result_student_course) {
            $result['total_marks'] = $scms_result_student_course['total_mark'];
            $result['pass_marks'] = $scms_result_student_course['pass_mark'];
            $result['marks'] = $scms_result_student_course['obtain_mark'];
            $result['result'] = $scms_result_student_course['result'];
            $result['grade_name'] = $scms_result_student_course['grade'];
            $result['point'] = $scms_result_student_course['grade_point'];
            $result['highest_in_level'] = $scms_result_student_course['highest_in_level'];
            $result['highest_in_shift'] = $scms_result_student_course['highest_in_shift'];
            $result['highest_in_section'] = $scms_result_student_course['highest_in_section'];
            unset($scms_result_student_course['result']);
            $scms_result_student_course['result'] = $result;
            $filter_scms_result_student_courses[$scms_result_student_course['result_student_course_id']] = $scms_result_student_course;
            $result_student_course_ids[] = $scms_result_student_course['result_student_course_id'];
        }
        $filter_scms_result_student_courses = $this->get_result_student_course_parts($result_student_course_ids, $filter_scms_result_student_courses);
        $filter_scms_result_student_courses = $this->get_result_student_course_persentage_groups($result_student_course_ids, $filter_scms_result_student_courses);
        return $filter_scms_result_student_courses;
    }

    private function get_result_student_merge_courses($result_student_id)
    {
        $scms_result_student_course = TableRegistry::getTableLocator()->get('scms_result_student_courses');
        $scms_result_student_merge_courses = $scms_result_student_course->find()->where(['result_student_id IN' => $result_student_id])->where(['type' => 'merge'])->enableAutoFields(true)->enableHydration(false)->toArray();

        $return = array();
        if (count($scms_result_student_merge_courses) > 0) {
            $scms_result_student_course = TableRegistry::getTableLocator()->get('scms_result_student_courses');
            $scms_result_student_merge_single_courses = $scms_result_student_course->find()->where(['result_student_id IN' => $result_student_id])->where(['type' => 'single'])->where(['parent_result_student_course_id is not NULL'])->enableAutoFields(true)->enableHydration(false)->select([
                'course_name' => 'scms_courses.course_name',
                'course_code' => 'scms_courses.course_code',
                'course_type_id' => 'scms_courses.course_type_id',
            ])->join([
                        'scms_courses' => [
                            'table' => 'scms_courses',
                            'type' => 'LEFT',
                            'conditions' => ['scms_courses.course_id   = scms_result_student_courses.course_id'],
                        ],
                    ])->toArray();
            $merge_courses = array_merge($scms_result_student_merge_courses, $scms_result_student_merge_single_courses);
            $result_student_course_ids = array();
            $filter_merge_courses = array();
            foreach ($merge_courses as $merge_course) {
                $result['total_marks'] = $merge_course['total_mark'];
                $result['pass_marks'] = $merge_course['pass_mark'];
                $result['marks'] = $merge_course['obtain_mark'];
                $result['result'] = $merge_course['result'];
                $result['grade_name'] = $merge_course['grade'];
                $result['point'] = $merge_course['grade_point'];
                $result['highest_in_level'] = $merge_course['highest_in_level'];
                $result['highest_in_shift'] = $merge_course['highest_in_shift'];
                $result['highest_in_section'] = $merge_course['highest_in_section'];
                unset($merge_course['result']);
                $merge_course['result'] = $result;
                $filter_merge_courses[$merge_course['result_student_course_id']] = $merge_course;
                $result_student_course_ids[] = $merge_course['result_student_course_id'];
            }

            $filter_merge_courses = $this->get_result_student_course_parts($result_student_course_ids, $filter_merge_courses);
            $filter_merge_courses = $this->get_result_student_course_persentage_groups($result_student_course_ids, $filter_merge_courses);
            $return = array();
            foreach ($filter_merge_courses as $filter_merge_course) {
                if ($filter_merge_course['type'] == 'merge') {
                    $return[$filter_merge_course['result_student_course_id']]['total'] = $filter_merge_course;
                    $return[$filter_merge_course['result_student_course_id']]['result'] = $filter_merge_course['result'];
                } else if ($filter_merge_course['type'] == 'single') {
                    $return[$filter_merge_course['parent_result_student_course_id']][] = $filter_merge_course;
                }
            }
        }


        return $return;
    }

    private function get_result_student_course_parts($result_student_course_ids, $filter_scms_result_student_courses)
    {
        $scms_result_student_course_part = TableRegistry::getTableLocator()->get('scms_result_student_course_parts');
        $scms_result_student_course_parts = $scms_result_student_course_part->find()->where(['result_student_course_id  IN' => $result_student_course_ids])->select([
            'term_course_cycle_part_type_name' => 'scms_term_course_cycle_part_type.term_course_cycle_part_type_name',
            'marks' => 'scms_result_student_course_parts.obtain_mark',
        ])->enableAutoFields(true)->enableHydration(false)->join([
                    'scms_term_course_cycle_part_type' => [
                        'table' => 'scms_term_course_cycle_part_type',
                        'type' => 'LEFT',
                        'conditions' => ['scms_result_student_course_parts.term_course_cycle_part_type_id   = scms_term_course_cycle_part_type.term_course_cycle_part_type_id'],
                    ]
                ])->toArray();

        foreach ($scms_result_student_course_parts as $scms_result_student_course_part) {
            $filter_scms_result_student_courses[$scms_result_student_course_part['result_student_course_id']]['parts'][$scms_result_student_course_part['term_course_cycle_part_type_id']] = $scms_result_student_course_part;
        }

        return $filter_scms_result_student_courses;
    }

    private function get_result_student_course_persentage_groups($result_student_course_ids, $filter_scms_result_student_courses)
    {
        $scms_result_student_course_persentage_group = TableRegistry::getTableLocator()->get('scms_result_student_course_persentage_groups');
        $scms_result_student_course_persentage_groups = $scms_result_student_course_persentage_group->find()->where(['result_student_course_id  IN' => $result_student_course_ids])->enableAutoFields(true)->enableHydration(false)->toArray();

        foreach ($scms_result_student_course_persentage_groups as $scms_result_student_course_persentage_group) {
            $filter_scms_result_student_courses[$scms_result_student_course_persentage_group['result_student_course_id']]['persentage_groups'][] = $scms_result_student_course_persentage_group;
        }

        return $filter_scms_result_student_courses;
    }

    public function tabulationView($id)
    {
        $scms_results = TableRegistry::getTableLocator()->get('scms_results');
        $results = $scms_results->find()->where(['result_id' => $id])->enableAutoFields(true)->enableHydration(false)->toArray();

        $template = $this->get_template($results[0]['result_template_id']);
        $where['result_id'] = $id;
        $students = $this->get_scms_result_students($id, $where);

        $heads = $this->genarate_marks_heads($template);

        $students = $this->filter_data_for_view($students, $heads, $template);

        $this->layout = 'result';
        $this->autoRender = false;
        $this->set('students', $students);
        $this->set('heads', $heads);
        $merit_from = $this->get_position($results['result_template_id']);
        $this->set('position', $merit_from);
        $exam_title = $this->get_exam_result_title($results[0]['session_id'], $results[0]['level_id'], $results[0]['term_cycle_id']);
        $this->set('exam_title', $exam_title);
        $last_row_colspan = $this->find_last_row_colspan($template);
        $this->set('last_row_colspan', $last_row_colspan);
        $decemal_point = $this->get_settings_value('number_format_value_after_decimal');
        $this->set('decemal_point', $decemal_point);
        $this->render('/result/tabulation');
    }

    public function viewMergeResult()
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $scms_results = TableRegistry::getTableLocator()->get('scms_results');
            $results = $scms_results->find()->where(['type' => 'merge'])->where(['session_id' => $data['session_id']])->where(['level_id' => $data['level_id']])->where(['term_cycle_id' => $data['term_cycle_id']])->enableAutoFields(true)->enableHydration(false)->toArray();

            if (count($results) == 0) {
                $this->Flash->success('No Merge Result To Show', [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'viewMergeResult']);
            } else {
                $where['result_id'] = $results[0]['result_id'];
                if ($data['shift_id']) {
                    $where['scms_student_cycle.shift_id'] = $data['shift_id'];
                }
                if ($data['level_id']) {
                    $where['scms_student_cycle.level_id'] = $data['level_id'];
                }
                if ($data['section_id']) {
                    $where['scms_student_cycle.section_id'] = $data['section_id'];
                }
                if ($data['group_id']) {
                    $where['scms_student_cycle.group_id'] = $data['group_id'];
                }
                if ($data['sid']) {
                    $where['scms_students.sid'] = $data['sid'];
                }
                $students = $this->get_scms_result_students($results[0]['result_id'], $where);
                if (count($students) == 0) {
                    $this->Flash->success('No Student Found', [
                        'key' => 'Negative',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'viewMergeResult']);
                }

                if ($data['sort'] == 'roll') {
                    usort($students, function ($a, $b) {
                        return [$a['section_id'], $a['roll']] <=>
                            [$b['section_id'], $b['roll']];
                    });
                } else {
                    usort($students, function ($a, $b) {
                        return [$b['gpa_with_forth_subject'],$b['gpa'], $b['marks_with_forth_subject'], $a['roll']] <=>
                            [$a['gpa_with_forth_subject'],$a['gpa'], $a['marks_with_forth_subject'], $b['roll']];
                    });
                }
                if ($data['type'] == 'result_summary') {
                    $this->result_summary($students, $results[0], $data['section_id']);
                } else if ($data['type'] == 'tabulation') {
                    $this->result_tabulation($students, $results[0], $data['section_id']);
                } else {
                    $this->result_merge_marksheet($students, $data, $results[0]);
                }
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group->find()->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('groups', $groups);


        $view_type['mark_sheet'] = 'Mark Sheet';
        $view_type['tabulation'] = 'Tabulation';
        $view_type['result_summary'] = 'Result Summary';
        $this->set('view_type', $view_type);

        $sort_by['roll'] = 'Class Roll';
        $sort_by['merit'] = 'Merit Position';
        $this->set('sort_by', $sort_by);

        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles)) {
            $required = '';
        }
        $this->set('required', $required);
        $levels = $this->get_levels('results');
        $this->set('levels', $levels);

        $shifts = $this->get_shifts('results');
        $this->set('shifts', $shifts);
        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);
        $sections = $this->get_sections('results',$levels[0]->level_id);
        $this->set('sections', $sections);
    }

    private function result_merge_marksheet($merge_students, $request_data, $results)
    {
        
        $template = $this->get_template($results['result_template_id']);
        $term_ids = $template['term']['value']['term_id'];
        $scms_result = TableRegistry::getTableLocator()->get('scms_results');
        $single_base_results = $scms_result
            ->find()
            ->where(['scms_results.session_id' => $request_data['session_id']])
            ->where(['scms_results.level_id' => $request_data['level_id']])
            ->where(['scms_term_cycle.term_id' => $term_ids[0]])
            ->where(['type' => 'single'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'term_id' => 'scms_term_cycle.term_id',
            ])
            ->join([
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                ],
            ])
            ->toArray();

        $base_template = $this->get_template($single_base_results[0]['result_template_id']);
        $term_cycle_id = $single_base_results[0]['term_cycle_id'];
        $where['result_id'] = $single_base_results[0]['result_id'];
        if ($request_data['shift_id']) {
            $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
        }
        if ($request_data['level_id']) {
            $where['scms_student_cycle.level_id'] = $request_data['level_id'];
        }
        if ($request_data['section_id']) {
            $where['scms_student_cycle.section_id'] = $request_data['section_id'];
        }
        if ($request_data['group_id']) {
            $where['scms_student_cycle.group_id'] = $request_data['group_id'];
        }
        if ($request_data['sid']) {
            $where['scms_students.sid'] = $request_data['sid'];
        }

        $students = $this->get_scms_result_students($single_base_results[0]['result_id'], $where);
        $filter_students = array();
        $student_cycle_ids = array();
        foreach ($students as $student) {
            unset($student['attandance_data']);
            $filter_students[$student['student_cycle_id']] = $student;
            $student_cycle_ids[] = $student['student_cycle_id'];
        }

        unset($term_ids[0]);
        $single_results = $scms_result
            ->find()
            ->where(['scms_results.session_id' => $request_data['session_id']])
            ->where(['scms_results.level_id' => $request_data['level_id']])
            ->where(['scms_term_cycle.term_id IN' => $term_ids])
            ->where(['type' => 'single'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'term_id' => 'scms_term_cycle.term_id',
            ])
            ->join([
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                ],
            ])
            ->toArray();
        $result_ids = array();

        foreach ($single_results as $result) {
            $result_ids[] = $result['result_id'];
        }
        unset($where['result_id']);
        $where['result_id IN'] = $result_ids;
        $other_results = $this->get_other_scms_result_students_for_merge($result_ids, $where);

        foreach ($other_results as $other_result) {
            $term_id = $other_result['term_id'];
            foreach ($other_result['courses'] as $course_id => $single_course) {
                $filter_students[$other_result['student_cycle_id']]['courses'][$course_id]['term'][$term_id]['Total-' . $term_id] = $single_course['result']['marks'];
                $filter_students[$other_result['student_cycle_id']]['courses'][$course_id]['term'][$term_id]['GP-' . $term_id] = $single_course['result']['point'];
            }
            if (isset($other_result['merge_course'])) {
                foreach ($other_result['merge_course'] as $key => $merge_course) {
                    $filter_students[$other_result['student_cycle_id']]['merge_course'][$key]['total']['term'][$term_id]['Total-' . $term_id] = $merge_course['total']['result']['marks'];
                    $filter_students[$other_result['student_cycle_id']]['merge_course'][$key]['total']['term'][$term_id]['GP-' . $term_id] = $merge_course['total']['result']['point'];
                }
            }
        }
        $view_students = array();
        foreach ($merge_students as $merge_student) {
            $view_students[$merge_student['student_cycle_id']]['base_term'] = $filter_students[$merge_student['student_cycle_id']];
            $view_students[$merge_student['student_cycle_id']]['merge_term']['courses'] = $merge_student['courses'];
            if (isset($merge_student['merge_course'])) {
                $view_students[$merge_student['student_cycle_id']]['merge_term']['merge_course'] = $merge_student['merge_course'];
            }

            $view_students[$merge_student['student_cycle_id']]['merge_term']['result'] = $merge_student['result'];
        }
        $attandance_data = $this->get_merge_attendances($student_cycle_ids, $template['term']['value']['term_id'], $request_data['level_id'], $request_data['session_id']);
        $base_heads = $this->genarate_marks_heads($base_template);
        $view_base_heads = $base_heads;
        foreach ($single_results as $result) {
            $gp['name'] = 'GP-' . $result['term_id'];
            $gp['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($base_heads, $gp);
            $total['name'] = 'Total-' . $result['term_id'];
            $total['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($base_heads, $total);

            $view_gp['name'] = 'GP';
            $view_gp['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($view_base_heads, $view_gp);
            $view_total['name'] = 'Total';
            $view_total['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($view_base_heads, $view_total);
        }
        $merge_head = $this->genarate_marks_heads($template, 1);
        if (isset($base_template['merge_subject'])) {
            $template['merge_subject'] = 'yes';
        }
        foreach ($view_students as $key => $view_student) {
            $base_term[0] = $view_student['base_term'];
            $return_base_term = $this->filter_data_for_view($base_term, $base_heads, $base_template);
            unset($return_base_term[0]['attandance_data']);
            $view_students[$key]['base_term'] = $return_base_term[0];
            $merge_term[0] = $view_student['merge_term'];
            $return_merge_term = $this->filter_data_for_view($merge_term, $merge_head, $template, 1);
            $view_students[$key]['merge_term'] = $return_merge_term[0];
        }
        foreach ($merge_head as $key => $vel) {
            if (isset($vel['type'])) {
                $merge_head[$key]['name'] = mb_substr($merge_head[$key]['name'], 0, 1);
            }
        }
        $this->layout = 'result';
        $this->autoRender = false;
        

        $this->set('students', $view_students);

        $scms_activity_remarks = $this->default_activities();
        $this->set('scms_activity_remarks', $scms_activity_remarks);
        $view_base_heads = $this->viewAbleHead($view_base_heads);
        $this->set('heads', $view_base_heads['heads']);
        $merge_head = $this->viewAbleHead($merge_head);
        $this->set('merge_heads', $merge_head['heads']);
        if (count($view_base_heads['notes']) > $merge_head['notes']) {
            $this->set('notes', $view_base_heads['notes']);
        } else {
            $this->set('notes', $merge_head['notes']);
        }
        $merit_from = $this->get_position($results['result_template_id']);
        $this->set('position', $merit_from);
        $students = array_values($students);
        $exam_title = $this->get_exam_result_title($request_data['session_id'], $request_data['level_id'], $term_cycle_id);
        
        if ($request_data['section_id']) { 
            $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['session_name'];
        } else { 
            $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['session_name'];
        }
        $this->set('exam_title', $exam_title);
        $last_row_colspan = $this->find_last_row_colspan($base_template);
        $last_row_colspan += (count($template['term']['value']['term_name']) - 1) * 2;
        $this->set('last_row_colspan', $last_row_colspan);
        $last_row_colspan_merge_result = $this->find_last_row_colspan($template);
        $this->set('last_row_colspan_merge_result', $last_row_colspan_merge_result);
        $term_names = $this->find_merge_result_term_names($template['term']['value']['term_name']);
        $this->set('term_names', $term_names);
        $this->set('total_attandance', $attandance_data['months']);
        $this->set('studnet_attandance', $attandance_data['student_attendance_data']);

        $decemal_point = $this->get_settings_value('number_format_value_after_decimal');
        $this->set('decemal_point', $decemal_point);

        $this->render('/result/markSheet_merge');
    }

    public function publish($id)
    {


        $this->request->allowMethod(['post', 'put']);
        $scmsResults = $this->getTableLocator()->get('scms_results');

        // Fetch the result record
        $result = $scmsResults->get($id);

        // Toggle the 'publish' value
        $result->publish = $result->publish == 1 ? 0 : 1;

        if ($scmsResults->save($result)) {
            if ($result->publish == 1) {
                $this->Flash->success(__('The result has been published successfully.'));
            } else {
                $this->Flash->success(__('The result has been unpublished successfully.'));
            }
        } else {
            $this->Flash->error(__('Failed to update the publish status. Please try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function mergePublish($id)
    {

        $this->request->allowMethod(['post', 'put']);
        $scmsResults = $this->getTableLocator()->get('scms_results');

        // Fetch the result record
        $result = $scmsResults->get($id);

        // Toggle the 'publish' value
        $result->merge_publish = $result->merge_publish == 1 ? 0 : 1;

        if ($scmsResults->save($result)) {
            if ($result->publish == 1) {
                $this->Flash->success(__('The result has been published successfully.'));
            } else {
                $this->Flash->success(__('The result has been unpublished successfully.'));
            }
        } else {
            $this->Flash->error(__('Failed to update the publish status. Please try again.'));
        }

        return $this->redirect(['action' => 'mergeResult']);
    }

    public function sendSMS($id)
    {
        $scms_result_students = TableRegistry::getTableLocator()->get('scms_result_students');
        $result_students = $scms_result_students->find()->where(['scms_result_students.result_id' => $id])->enableAutoFields(true)->enableHydration(false)->select([
            'level_id' => 'scms_student_cycle.level_id',
            'roll' => 'scms_student_cycle.roll',
            'shift_name' => 'hr_shift.shift_name',
            'level_name' => 'scms_levels.level_name',
            'section_name' => 'scms_sections.section_name',
            'section_name' => 'scms_sections.section_name',
            'name' => 'scms_students.name',
            'student_id' => 'scms_students.student_id',
            'active_guardian' => 'scms_students.active_guardian',
            'sid' => 'scms_students.sid',
            'group_name' => 'scms_groups.group_name',
            'session_name' => 'scms_sessions.session_name',
        ])->join([
                    'scms_student_term_cycle' => [
                        'table' => 'scms_student_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_term_cycle.student_term_cycle_id = scms_result_students.student_term_cycle_id'],
                    ],
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_term_cycle.term_cycle_id = scms_term_cycle.term_cycle_id'],
                    ],
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_cycle.student_cycle_id  = scms_student_term_cycle.student_cycle_id'],
                    ],
                    'hr_shift' => [
                        'table' => 'hr_shift',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_cycle.shift_id = hr_shift.shift_id'],
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_cycle.level_id = scms_levels.level_id'],
                    ],
                    'scms_sections' => [
                        'table' => 'scms_sections',
                        'type' => 'LEFT',
                        'conditions' => ['scms_student_cycle.section_id = scms_sections.section_id'],
                    ],
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'LEFT',
                        'conditions' => ['scms_students.student_id  = scms_student_cycle.student_id'],
                    ],
                    'scms_groups' => [
                        'table' => 'scms_groups',
                        'type' => 'LEFT',
                        'conditions' => ['scms_groups.group_id = scms_student_cycle.group_id'],
                    ],
                    'scms_sessions' => [
                        'table' => 'scms_sessions',
                        'type' => 'LEFT',
                        'conditions' => ['scms_sessions.session_id  = scms_student_cycle.session_id'],
                    ],
                ])->toArray();
        $filter_result_students = array();
        $student_ids = array();
        foreach ($result_students as $result_student) {
            $filter_result_students[$result_student['student_id']] = $result_student;
            $student_ids[] = $result_student['student_id'];
        }
        $guardian = TableRegistry::getTableLocator()->get('scms_guardians'); //Execute First
        $guardians = $guardian
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['student_id IN' => $student_ids])
            ->toArray();
        foreach ($guardians as $guardian) {
            if ($filter_result_students[$guardian['student_id']]['active_guardian'] == $guardian['rtype']) {
                if ($guardian['mobile']) {
                    $filter_result_students[$guardian['student_id']]['mobile'] = $guardian['mobile'];
                } else {
                    unset($filter_result_students[$guardian['student_id']]);
                }
            }
        }
        $scms_results = TableRegistry::getTableLocator()->get('scms_results');
        $results = $scms_results
            ->find()
            ->select([
                'term_name' => 'scms_term.term_name',
                'merit' => 'scms_result_template.merit',
            ])
            ->where(['result_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_cycle.term_cycle_id = scms_results.term_cycle_id'],
                ],
                'scms_term' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term.term_id = scms_term_cycle.term_id'],
                ],
                'scms_result_template' => [
                    'table' => 'scms_result_template',
                    'type' => 'LEFT',
                    'conditions' => ['scms_result_template.result_template_id = scms_results.result_template_id'],
                ],
            ])->toArray();
        $arg['recipients'] = array_values($filter_result_students);
        $arg['term_name'] = $results[0]['term_name'];
        $arg['merit'] = $results[0]['merit'];
        if ($this->send_sms('merit', $array = [], $arg)) {
            $this->Flash->success('Sms Sent Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
        } else {
            $this->Flash->success('SMS Service is Unavailable', [
                'key' => 'Negative',
                'params' => [],
            ]);
        }
        if ($results['0']['type'] == 'single') {
            return $this->redirect(['action' => 'index']);
        } else {
            return $this->redirect(['action' => 'generateMergeResult']);
        }
    }

    public function studentResultView($id, $where)
    {
        $scms_results = TableRegistry::getTableLocator()->get('scms_results');
        $results = $scms_results->find()->where(['result_id' => $id])->enableAutoFields(true)->enableHydration(false)->toArray();
        $students = $this->get_scms_result_students($results[0]['result_id'], $where);

        $template = $this->get_template($results[0]['result_template_id']);
        $heads = $this->genarate_marks_heads($template);
        $students = $this->filter_data_for_view($students, $heads, $template);

        $scms_result_attendance_month = TableRegistry::getTableLocator()->get('scms_result_attendance_month');
        $result_attendance_month = $scms_result_attendance_month->find()->where(['result_id' => $results[0]['result_id']])->enableAutoFields(true)->enableHydration(false)->toArray();
        $month[1]['count'] = '--';
        $month[2]['count'] = '--';
        $month[3]['count'] = '--';
        $month[4]['count'] = '--';
        $month[5]['count'] = '--';
        $month[6]['count'] = '--';
        $month[7]['count'] = '--';
        $month[8]['count'] = '--';
        $month[9]['count'] = '--';
        $month[10]['count'] = '--';
        $month[11]['count'] = '--';
        $month[12]['count'] = '--';
        $month[13]['count'] = '--';
        foreach ($result_attendance_month as $attendance_month) {
            $month[$attendance_month['month_id']]['count'] = $attendance_month['count'];
        }
        $scms_activity_remarks = $this->default_activities();
        $return_scms_activity_remarks = array_values($this->get_result_activity_names($results[0]['result_id']));
        if (isset($return_scms_activity_remarks[0])) {
            $scms_activity_remarks[0] = $return_scms_activity_remarks[0];
        }
        if (isset($return_scms_activity_remarks[1])) {
            $scms_activity_remarks[1] = $return_scms_activity_remarks[1];
        }
        $this->autoRender = false;
        $merit_from = $this->get_position($results[0]['result_template_id']);
        $exam_title = $this->get_exam_result_title($results[0]['session_id'], $results[0]['level_id'], $results[0]['term_cycle_id']);
        $last_row_colspan = $this->find_last_row_colspan($template);
        $decemal_point = $this->get_settings_value('number_format_value_after_decimal');

        //##// DATA Sending of ContactController of CONTACTS PLUGIN BLOCK
        return [
            'students' => $students,
            'scms_activity_remarks' => $scms_activity_remarks,
            'heads' => $heads,
            'position' => $merit_from,
            'exam_title' => $exam_title,
            'last_row_colspan' => $last_row_colspan,
            'decemal_point' => $decemal_point,
            'total_attandance' => $month,
        ];
        //##// DATA Sending of ContactController of CONTACTS PLUGIN BLOCK
    }
    
    private function result_merge_marksheet_single($merge_students, $request_data, $results)
    {
        $template = $this->get_template($results['result_template_id']);
        $term_ids = $template['term']['value']['term_id'];
        $scms_result = TableRegistry::getTableLocator()->get('scms_results');
        $single_base_results = $scms_result
            ->find()
            ->where(['scms_results.session_id' => $request_data['session_id']])
            ->where(['scms_results.level_id' => $request_data['level_id']])
            ->where(['scms_term_cycle.term_id' => $term_ids[0]])
            ->where(['type' => 'single'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'term_id' => 'scms_term_cycle.term_id',
            ])
            ->join([
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                ],
            ])
            ->toArray();

        $base_template = $this->get_template($single_base_results[0]['result_template_id']);
        $term_cycle_id = $single_base_results[0]['term_cycle_id'];
        $where['result_id'] = $single_base_results[0]['result_id'];
        if ($request_data['shift_id']) {
            $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
        }
        if ($request_data['level_id']) {
            $where['scms_student_cycle.level_id'] = $request_data['level_id'];
        }
        if ($request_data['section_id']) {
            $where['scms_student_cycle.section_id'] = $request_data['section_id'];
        }
        if ($request_data['group_id']) {
            $where['scms_student_cycle.group_id'] = $request_data['group_id'];
        }
        if ($request_data['sid']) {
            $where['scms_students.sid'] = $request_data['sid'];
        }

        $students = $this->get_scms_result_students($single_base_results[0]['result_id'], $where);
        $filter_students = array();
        $student_cycle_ids = array();
        foreach ($students as $student) {
            unset($student['attandance_data']);
            $filter_students[$student['student_cycle_id']] = $student;
            $student_cycle_ids[] = $student['student_cycle_id'];
        }

        unset($term_ids[0]);
        $single_results = $scms_result
            ->find()
            ->where(['scms_results.session_id' => $request_data['session_id']])
            ->where(['scms_results.level_id' => $request_data['level_id']])
            ->where(['scms_term_cycle.term_id IN' => $term_ids])
            ->where(['type' => 'single'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'term_id' => 'scms_term_cycle.term_id',
            ])
            ->join([
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                ],
            ])
            ->toArray();
        $result_ids = array();

        foreach ($single_results as $result) {
            $result_ids[] = $result['result_id'];
        }
        unset($where['result_id']);
        $where['result_id IN'] = $result_ids;
        $other_results = $this->get_other_scms_result_students_for_merge($result_ids, $where);

        foreach ($other_results as $other_result) {
            $term_id = $other_result['term_id'];
            foreach ($other_result['courses'] as $course_id => $single_course) {
                $filter_students[$other_result['student_cycle_id']]['courses'][$course_id]['term'][$term_id]['Total-' . $term_id] = $single_course['result']['marks'];
                $filter_students[$other_result['student_cycle_id']]['courses'][$course_id]['term'][$term_id]['GP-' . $term_id] = $single_course['result']['point'];
            }
            if (isset($other_result['merge_course'])) {
                foreach ($other_result['merge_course'] as $key => $merge_course) {
                    $filter_students[$other_result['student_cycle_id']]['merge_course'][$key]['total']['term'][$term_id]['Total-' . $term_id] = $merge_course['total']['result']['marks'];
                    $filter_students[$other_result['student_cycle_id']]['merge_course'][$key]['total']['term'][$term_id]['GP-' . $term_id] = $merge_course['total']['result']['point'];
                }
            }
        }
        $view_students = array();
        foreach ($merge_students as $merge_student) {
            $view_students[$merge_student['student_cycle_id']]['base_term'] = $filter_students[$merge_student['student_cycle_id']];
            $view_students[$merge_student['student_cycle_id']]['merge_term']['courses'] = $merge_student['courses'];
            if (isset($merge_student['merge_course'])) {
                $view_students[$merge_student['student_cycle_id']]['merge_term']['merge_course'] = $merge_student['merge_course'];
            }

            $view_students[$merge_student['student_cycle_id']]['merge_term']['result'] = $merge_student['result'];
        }
        $attandance_data = $this->get_merge_attendances($student_cycle_ids, $template['term']['value']['term_id'], $request_data['level_id'], $request_data['session_id']);
        $base_heads = $this->genarate_marks_heads($base_template);
        $view_base_heads = $base_heads;
        foreach ($single_results as $result) {
            $gp['name'] = 'GP-' . $result['term_id'];
            $gp['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($base_heads, $gp);
            $total['name'] = 'Total-' . $result['term_id'];
            $total['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($base_heads, $total);

            $view_gp['name'] = 'GP';
            $view_gp['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($view_base_heads, $view_gp);
            $view_total['name'] = 'Total';
            $view_total['style'] = 'class="res1" colspan="1" rowspan="1"';
            array_unshift($view_base_heads, $view_total);
        }
        $merge_head = $this->genarate_marks_heads($template, 1);
        if (isset($base_template['merge_subject'])) {
            $template['merge_subject'] = 'yes';
        }
        foreach ($view_students as $key => $view_student) {
            $base_term[0] = $view_student['base_term'];
            $return_base_term = $this->filter_data_for_view($base_term, $base_heads, $base_template);
            unset($return_base_term[0]['attandance_data']);
            $view_students[$key]['base_term'] = $return_base_term[0];
            $merge_term[0] = $view_student['merge_term'];
            $return_merge_term = $this->filter_data_for_view($merge_term, $merge_head, $template, 1);
            $view_students[$key]['merge_term'] = $return_merge_term[0];
        }
        foreach ($merge_head as $key => $vel) {
            if (isset($vel['type'])) {
                $merge_head[$key]['name'] = mb_substr($merge_head[$key]['name'], 0, 1);
            }
        }
        $this->layout = 'result';
        $this->autoRender = false;
        

        $this->set('students', $view_students);

        $scms_activity_remarks = $this->default_activities();
        $this->set('scms_activity_remarks', $scms_activity_remarks);
        $view_base_heads = $this->viewAbleHead($view_base_heads);
        $this->set('heads', $view_base_heads['heads']);
        $merge_head = $this->viewAbleHead($merge_head);
        $this->set('merge_heads', $merge_head['heads']);
        if (count($view_base_heads['notes']) > $merge_head['notes']) {
            $this->set('notes', $view_base_heads['notes']);
        } else {
            $this->set('notes', $merge_head['notes']);
        }
        $merit_from = $this->get_position($results['result_template_id']);
        $this->set('position', $merit_from);
        $students = array_values($students);
        $exam_title = $this->get_exam_result_title($request_data['session_id'], $request_data['level_id'], $term_cycle_id);
        
        if ($request_data['section_id']) { 
            $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['session_name'];
        } else { 
            $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['session_name'];
        }
        $this->set('exam_title', $exam_title);
        $last_row_colspan = $this->find_last_row_colspan($base_template);
        $last_row_colspan += (count($template['term']['value']['term_name']) - 1) * 2;
        $this->set('last_row_colspan', $last_row_colspan);
        $last_row_colspan_merge_result = $this->find_last_row_colspan($template);
        $this->set('last_row_colspan_merge_result', $last_row_colspan_merge_result);
        $term_names = $this->find_merge_result_term_names($template['term']['value']['term_name']);
        $this->set('term_names', $term_names);
        $this->set('total_attandance', $attandance_data['months']);
        $this->set('studnet_attandance', $attandance_data['student_attendance_data']);

        $decemal_point = $this->get_settings_value('number_format_value_after_decimal');
        $this->set('decemal_point', $decemal_point);

        return [
            'students' => $view_students,
            'scms_activity_remarks' => $scms_activity_remarks,
            'heads' => $view_base_heads['heads'],
            'merge_heads' => $merge_head['heads'],
            'notes' => $view_base_heads['notes'],
            'merge_heads' => $merge_head['heads'],
            'position' => $merit_from,
            'exam_title' => $exam_title,
            'last_row_colspan' => $last_row_colspan,
            'last_row_colspan_merge_result' => $last_row_colspan_merge_result,
            'term_names' => $term_names,
            'decemal_point' => $decemal_point,
            'grades' => $grades,
            'remarks' => $remarks,
            'total_attandance' => $attandance_data['months'],
            'studnet_attandance' => $attandance_data['student_attendance_data']
        ];

        // $this->render('/Students/merge_result');
    }
    
    // public function studentResultMerge($id, $where)
    // {
    //     $scms_results = TableRegistry::getTableLocator()->get('scms_results');
    //     $results = $scms_results->find()->where(['result_id' => $id])->enableAutoFields(true)->enableHydration(false)->toArray();
    //     $students = $this->get_scms_result_students($results[0]['result_id'], $where);

    //     $students = array_values($students);
    //     $data['session_id'] = $students[0]['session_id'];
    //     $data['shift_id'] = $students[0]['shift_id'];
    //     $data['level_id'] = $students[0]['level_id'];
    //     $data['section_id'] = $students[0]['section_ids'];
    //     $data['group_id'] = $students[0]['group_id'];
    //     $data['sid'] = $students[0]['sid'];
    //     $data['term_cycle_id'] = $results[0]['term_cycle_id'];
    //     $data['type'] = 'mark_sheet';
    //     $data['sort'] = 'roll';
    //     $this->autoRender = false;
    //     $data = $this->result_merge_marksheet_single($students, $data, $results[0]);
        

    //     return $data;


    // }
    
    public function studentResultMerge($id, $where, $term_cycle_id, $session)
    {

        $studentCycleTable = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $get_student = $studentCycleTable
            ->find()
            ->where(['scms_students.sid' => $where['scms_students.sid']])
            ->where(['scms_student_cycle.session_id' => $session])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'sid' => 'scms_students.sid',
            ])
            ->join([
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_students.student_id = scms_student_cycle.student_id '
                    ]
                ]
            ])

            ->toArray();

        if (isset($get_student[0]['level_id']) && (int)$get_student[0]['level_id'] !== 9) {
            $scms_results = TableRegistry::getTableLocator()->get('scms_results');
            $results = $scms_results->find()->where(['result_id' => $id])->enableAutoFields(true)->enableHydration(false)->toArray();


            $template = $this->get_template($results[0]['result_template_id']);
            $term_ids = $template['term']['value']['term_id'];

            $scms_result = TableRegistry::getTableLocator()->get('scms_results');
            $single_base_results = $scms_result
                ->find()
                ->where(['scms_results.session_id' => $results[0]['session_id']])
                ->where(['scms_results.level_id' => $results[0]['level_id']])
                ->where(['scms_results.term_cycle_id' => $term_cycle_id])
                ->where(['type' => 'merge'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term_id' => 'scms_term_cycle.term_id',
                ])
                ->join([
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                    ],
                ])
                ->toArray();


            $studentCycleTable = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $get_student = $studentCycleTable
                ->find()
                ->where(['sid' => $where['scms_students.sid']])
                ->where(['scms_student_cycle.session_id' => $single_base_results[0]['session_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'sid' => 'scms_students.sid',
                ])
                ->join([
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'LEFT',
                        'conditions' => [
                            'scms_students.student_id = scms_student_cycle.student_id '
                        ]
                    ]
                ])

                ->toArray();

            $base_template = $this->get_template($single_base_results[0]['result_template_id']);
            $term_cycle_id = $single_base_results[0]['term_cycle_id'];
            $where['result_id'] = $single_base_results[0]['result_id'];
            if ($get_student[0]['shift_id']) {
                $where['scms_student_cycle.shift_id'] = $get_student[0]['shift_id'];
            }
            if ($get_student[0]['level_id']) {
                $where['scms_student_cycle.level_id'] = $get_student[0]['level_id'];
            }
            if ($get_student[0]['section_id']) {
                $where['scms_student_cycle.section_id'] = $get_student[0]['section_id'];
            }
            if ($get_student[0]['group_id']) {
                $where['scms_student_cycle.group_id'] = $get_student[0]['group_id'];
            }
            if ($get_student[0]['sid']) {
                $where['scms_students.sid'] = $get_student[0]['sid'];
            }
            unset($where['scms_student_cycle.section_id']);
            unset($where['scms_student_cycle.group_id']);
            // echo '<pre>';
            // print_r($where);
            // die;
            $studentss = $this->get_scms_result_students($single_base_results[0]['result_id'], $where);

            if ($get_student['sort'] == 'roll') {
                usort($studentss, function ($a, $b) {
                    return [$a['section_id'], $a['roll']] <=>
                        [$b['section_id'], $b['roll']];
                });
            } else {
                usort($studentss, function ($a, $b) {
                    return [$b['gpa_with_forth_subject'], $b['gpa'], $b['marks_with_forth_subject'], $a['roll']] <=>
                        [$a['gpa_with_forth_subject'], $a['gpa'], $a['marks_with_forth_subject'], $b['roll']];
                });
            }

            $template = $this->get_template($results[0]['result_template_id']);
            $term_ids = $template['term']['value']['term_id'];

            $scms_result = TableRegistry::getTableLocator()->get('scms_results');
            $single_base_results = $scms_result
                ->find()
                ->where(['scms_results.session_id' => $get_student[0]['session_id']])
                ->where(['scms_results.level_id' => $get_student[0]['level_id']])
                ->where(['scms_term_cycle.term_id' => $term_ids[0]])
                ->where(['type' => 'single'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term_id' => 'scms_term_cycle.term_id',
                ])
                ->join([
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                    ],
                ])
                ->toArray();

            $base_template = $this->get_template($single_base_results[0]['result_template_id']);
            $term_cycle_id = $single_base_results[0]['term_cycle_id'];
            $where['result_id'] = $single_base_results[0]['result_id'];
            if ($get_student[0]['shift_id']) {
                $where['scms_student_cycle.shift_id'] = $get_student[0]['shift_id'];
            }
            if ($get_student[0]['level_id']) {
                $where['scms_student_cycle.level_id'] = $get_student[0]['level_id'];
            }
            // if ($get_student[0]['section_id']) {
            //     $where['scms_student_cycle.section_id'] = $get_student[0]['section_id'];
            // }
            // if ($get_student[0]['group_id']) {
            //     $where['scms_student_cycle.group_id'] = $get_student[0]['group_id'];
            // }
            if ($get_student[0]['sid']) {
                $where['scms_students.sid'] = $get_student[0]['sid'];
            }

            // echo '<pre>';
            // print_r($where);
            // die;
            $students = $this->get_scms_result_students($single_base_results[0]['result_id'], $where);

            $filter_students = array();
            $student_cycle_ids = array();
            foreach ($students as $student) {
                unset($student['attandance_data']);
                $filter_students[$student['student_cycle_id']] = $student;
                $student_cycle_ids[] = $student['student_cycle_id'];
            }

            unset($term_ids[0]);
            $single_results = $scms_result
                ->find()
                ->where(['scms_results.session_id' => $get_student[0]['session_id']])
                ->where(['scms_results.level_id' => $get_student[0]['level_id']])
                ->where(['scms_term_cycle.term_id IN' => $term_ids])
                ->where(['type' => 'single'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term_id' => 'scms_term_cycle.term_id',
                ])
                ->join([
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                    ],
                ])
                ->toArray();
            $result_ids = array();

            foreach ($single_results as $result) {
                $result_ids[] = $result['result_id'];
            }

            unset($where['result_id']);
            $where['result_id IN'] = $result_ids;
            unset($where['scms_student_cycle.section_id']);
            unset($where['scms_student_cycle.group_id']);
            // echo '<pre>';
            // print_r($result_ids);
            // echo '<pre>';
            // print_r($where);
            // die;
            $other_results = $this->get_other_scms_result_students_for_merge($result_ids, $where);

            foreach ($other_results as $other_result) {
                $term_id = $other_result['term_id'];

                foreach ($other_result['courses'] as $course_id => $single_course) {
                    $filter_students[$other_result['student_cycle_id']]['courses'][$course_id]['term'][$term_id]['Total-' . $term_id] = $single_course['result']['marks'];
                    $filter_students[$other_result['student_cycle_id']]['courses'][$course_id]['term'][$term_id]['GP-' . $term_id] = $single_course['result']['point'];
                }
                if (isset($other_result['merge_course'])) {
                    foreach ($other_result['merge_course'] as $key => $merge_course) {
                        $filter_students[$other_result['student_cycle_id']]['merge_course'][$key]['total']['term'][$term_id]['Total-' . $term_id] = $merge_course['total']['result']['marks'];
                        $filter_students[$other_result['student_cycle_id']]['merge_course'][$key]['total']['term'][$term_id]['GP-' . $term_id] = $merge_course['total']['result']['point'];
                    }
                }
            }

            $view_students = array();
            foreach ($studentss as $merge_student) {
                $view_students[$merge_student['student_cycle_id']]['base_term'] = $filter_students[$merge_student['student_cycle_id']];
                $view_students[$merge_student['student_cycle_id']]['merge_term']['courses'] = $merge_student['courses'];
                if (isset($merge_student['merge_course'])) {
                    $view_students[$merge_student['student_cycle_id']]['merge_term']['merge_course'] = $merge_student['merge_course'];
                }

                $view_students[$merge_student['student_cycle_id']]['merge_term']['result'] = $merge_student['result'];
            }
            // pr($student_cycle_ids);
            // die;
            $attandance_data = $this->get_merge_attendances($student_cycle_ids, $template['term']['value']['term_id'], $get_student[0]['level_id'], $get_student[0]['session_id']);
            $base_heads = $this->genarate_marks_heads($base_template);

            $view_base_heads = $base_heads;
            foreach ($single_results as $result) {
                $gp['name'] = 'GP-' . $result['term_id'];
                $gp['style'] = 'class="res1" colspan="1" rowspan="1"';
                array_unshift($base_heads, $gp);
                $total['name'] = 'Total-' . $result['term_id'];
                $total['style'] = 'class="res1" colspan="1" rowspan="1"';
                array_unshift($base_heads, $total);

                $view_gp['name'] = 'GP';
                $view_gp['style'] = 'class="res1" colspan="1" rowspan="1"';
                array_unshift($view_base_heads, $view_gp);
                $view_total['name'] = 'Total';
                $view_total['style'] = 'class="res1" colspan="1" rowspan="1"';
                array_unshift($view_base_heads, $view_total);
            }
            // echo '<pre>';
            // print_r($single_results);
            // die;
            $merge_head = $this->genarate_marks_heads($template, 1);

            if (isset($base_template['merge_subject'])) {
                $template['merge_subject'] = 'yes';
            }
            foreach ($view_students as $key => $view_student) {
                $base_term[0] = $view_student['base_term'];
                $return_base_term = $this->filter_data_for_view($base_term, $base_heads, $base_template);
                unset($return_base_term[0]['attandance_data']);
                $view_students[$key]['base_term'] = $return_base_term[0];
                $merge_term[0] = $view_student['merge_term'];
                $return_merge_term = $this->filter_data_for_view($merge_term, $merge_head, $template, 1);
                $view_students[$key]['merge_term'] = $return_merge_term[0];
            }
            foreach ($merge_head as $key => $vel) {
                if (isset($vel['type'])) {
                    $merge_head[$key]['name'] = mb_substr($merge_head[$key]['name'], 0, 1);
                }
            }
            $this->layout = 'result';
            $this->autoRender = false;

            // echo '<pre>';
            // print_r($view_students);
            // die;
            $this->set('students', $view_students);

            $scms_activity_remarks = $this->default_activities();
            $this->set('scms_activity_remarks', $scms_activity_remarks);
            $view_base_heads = $this->viewAbleHead($view_base_heads);
            $this->set('heads', $view_base_heads['heads']);
            $merge_head = $this->viewAbleHead($merge_head);
            $this->set('merge_heads', $merge_head['heads']);
            if (count($view_base_heads['notes']) > $merge_head['notes']) {
                $this->set('notes', $view_base_heads['notes']);
            } else {
                $this->set('notes', $merge_head['notes']);
            }
            $merit_from = $this->get_position($results[0]['result_template_id']);
            // echo '<pre>';
            // print_r($merit_from);
            // die;
            $this->set('position', $merit_from);
            $students = array_values($students);
            $exam_title = $this->get_exam_result_title($get_student[0]['session_id'], $get_student[0]['level_id'], $term_cycle_id);

            if ($get_student[0]['section_id']) {
                $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['session_name'];
            } else {
                $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['session_name'];
            }
            $this->set('exam_title', $exam_title);
            $last_row_colspan = $this->find_last_row_colspan($base_template);
            $last_row_colspan += (count($template['term']['value']['term_name']) - 1) * 2;
            $this->set('last_row_colspan', $last_row_colspan);
            $last_row_colspan_merge_result = $this->find_last_row_colspan($template);
            $this->set('last_row_colspan_merge_result', $last_row_colspan_merge_result);
            $term_names = $this->find_merge_result_term_names($template['term']['value']['term_name']);
            $this->set('term_names', $term_names);
            $this->set('total_attandance', $attandance_data['months']);
            $this->set('studnet_attandance', $attandance_data['student_attendance_data']);

            $decemal_point = $this->get_settings_value('number_format_value_after_decimal');
            $this->set('decemal_point', $decemal_point);


            return [
                'students' => $view_students,
                'scms_activity_remarks' => $scms_activity_remarks,
                'heads' => $view_base_heads['heads'],
                'merge_heads' => $merge_head['heads'],
                'notes' => $view_base_heads['notes'],
                'merge_heads' => $merge_head['heads'],
                'position' => $merit_from,
                'exam_title' => $exam_title,
                'last_row_colspan' => $last_row_colspan,
                'last_row_colspan_merge_result' => $last_row_colspan_merge_result,
                'term_names' => $term_names,
                'decemal_point' => $decemal_point,
                'grades' => $grades,
                'remarks' => $remarks,
                'total_attandance' => $attandance_data['months'],
                'studnet_attandance' => $attandance_data['student_attendance_data']
            ];
        } else {

            $scms_results = TableRegistry::getTableLocator()->get('scms_results');
            $results = $scms_results->find()->where(['result_id' => $id])->enableAutoFields(true)->enableHydration(false)->toArray();


            $template = $this->get_template($results[0]['result_template_id']);
            $term_ids = $template['term']['value']['term_id'];

            $scms_result = TableRegistry::getTableLocator()->get('scms_results');
            $single_base_results = $scms_result
                ->find()
                ->where(['scms_results.session_id' => $results[0]['session_id']])
                ->where(['scms_results.level_id' => $results[0]['level_id']])
                ->where(['scms_results.term_cycle_id' => $term_cycle_id])
                ->where(['type' => 'merge'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term_id' => 'scms_term_cycle.term_id',
                ])
                ->join([
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                    ],
                ])
                ->toArray();


            $studentCycleTable = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $get_student = $studentCycleTable
                ->find()
                ->where(['sid' => $where['scms_students.sid']])
                ->where(['scms_student_cycle.session_id' => $single_base_results[0]['session_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'sid' => 'scms_students.sid',
                ])
                ->join([
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'LEFT',
                        'conditions' => [
                            'scms_students.student_id = scms_student_cycle.student_id '
                        ]
                    ]
                ])

                ->toArray();

            $base_template = $this->get_template($single_base_results[0]['result_template_id']);
            $term_cycle_id = $single_base_results[0]['term_cycle_id'];
            $where['result_id'] = $single_base_results[0]['result_id'];
            if ($get_student[0]['shift_id']) {
                $where['scms_student_cycle.shift_id'] = $get_student[0]['shift_id'];
            }
            if ($get_student[0]['level_id']) {
                $where['scms_student_cycle.level_id'] = $get_student[0]['level_id'];
            }
            if ($get_student[0]['section_id']) {
                $where['scms_student_cycle.section_id'] = $get_student[0]['section_id'];
            }
            if ($get_student[0]['group_id']) {
                $where['scms_student_cycle.group_id'] = $get_student[0]['group_id'];
            }
            if ($get_student[0]['sid']) {
                $where['scms_students.sid'] = $get_student[0]['sid'];
            }
            unset($where['scms_student_cycle.section_id']);
            unset($where['scms_student_cycle.group_id']);
            // echo '<pre>';
            // print_r($where);
            // die;
            $studentss = $this->get_scms_result_students($single_base_results[0]['result_id'], $where);

            if ($get_student['sort'] == 'roll') {
                usort($studentss, function ($a, $b) {
                    return [$a['section_id'], $a['roll']] <=>
                        [$b['section_id'], $b['roll']];
                });
            } else {
                usort($studentss, function ($a, $b) {
                    return [$b['gpa_with_forth_subject'], $b['gpa'], $b['marks_with_forth_subject'], $a['roll']] <=>
                        [$a['gpa_with_forth_subject'], $a['gpa'], $a['marks_with_forth_subject'], $b['roll']];
                });
            }

            $template = $this->get_template($results[0]['result_template_id']);
            $term_ids = $template['term']['value']['term_id'];

            $scms_result = TableRegistry::getTableLocator()->get('scms_results');
            $single_base_results = $scms_result
                ->find()
                ->where(['scms_results.session_id' => $get_student[0]['session_id']])
                ->where(['scms_results.level_id' => $get_student[0]['level_id']])
                ->where(['scms_term_cycle.term_id' => $term_ids[0]])
                ->where(['type' => 'single'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term_id' => 'scms_term_cycle.term_id',
                ])
                ->join([
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                    ],
                ])
                ->toArray();

            $base_template = $this->get_template($single_base_results[0]['result_template_id']);
            $term_cycle_id = $single_base_results[0]['term_cycle_id'];
            $where['result_id'] = $single_base_results[0]['result_id'];
            if ($get_student[0]['shift_id']) {
                $where['scms_student_cycle.shift_id'] = $get_student[0]['shift_id'];
            }
            if ($get_student[0]['level_id']) {
                $where['scms_student_cycle.level_id'] = $get_student[0]['level_id'];
            }
            // if ($get_student[0]['section_id']) {
            //     $where['scms_student_cycle.section_id'] = $get_student[0]['section_id'];
            // }
            // if ($get_student[0]['group_id']) {
            //     $where['scms_student_cycle.group_id'] = $get_student[0]['group_id'];
            // }
            if ($get_student[0]['sid']) {
                $where['scms_students.sid'] = $get_student[0]['sid'];
            }

            // echo '<pre>';
            // print_r($where);
            // die;
            $students = $this->get_scms_result_students($single_base_results[0]['result_id'], $where);

            $filter_students = array();
            $student_cycle_ids = array();
            foreach ($students as $student) {
                unset($student['attandance_data']);
                $filter_students[$student['student_cycle_id']] = $student;
                $student_cycle_ids[] = $student['student_cycle_id'];
            }

            unset($term_ids[0]);
            $single_results = $scms_result
                ->find()
                ->where(['scms_results.session_id' => $get_student[0]['session_id']])
                ->where(['scms_results.level_id' => $get_student[0]['level_id']])
                ->where(['scms_term_cycle.term_id IN' => $term_ids])
                ->where(['type' => 'single'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term_id' => 'scms_term_cycle.term_id',
                ])
                ->join([
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'LEFT',
                        'conditions' => ['scms_term_cycle.term_cycle_id  = scms_results.term_cycle_id'],
                    ],
                ])
                ->toArray();
            $result_ids = array();

            foreach ($single_results as $result) {
                $result_ids[] = $result['result_id'];
            }

            unset($where['result_id']);
            $where['result_id IN'] = $result_ids;
            unset($where['scms_student_cycle.section_id']);
            unset($where['scms_student_cycle.group_id']);
            // echo '<pre>';
            // print_r($result_ids);
            // echo '<pre>';
            // print_r($where);
            // die;
            $other_results = $this->get_other_scms_result_students_for_merge($result_ids, $where);

            foreach ($other_results as $other_result) {
                $term_id = $other_result['term_id'];

                foreach ($other_result['courses'] as $course_id => $single_course) {
                    $filter_students[$other_result['student_cycle_id']]['courses'][$course_id]['term'][$term_id]['Total-' . $term_id] = $single_course['result']['marks'];
                    $filter_students[$other_result['student_cycle_id']]['courses'][$course_id]['term'][$term_id]['GP-' . $term_id] = $single_course['result']['point'];
                }
                if (isset($other_result['merge_course'])) {
                    foreach ($other_result['merge_course'] as $key => $merge_course) {
                        $filter_students[$other_result['student_cycle_id']]['merge_course'][$key]['total']['term'][$term_id]['Total-' . $term_id] = $merge_course['total']['result']['marks'];
                        $filter_students[$other_result['student_cycle_id']]['merge_course'][$key]['total']['term'][$term_id]['GP-' . $term_id] = $merge_course['total']['result']['point'];
                    }
                }
            }

            $view_students = array();
            foreach ($studentss as $merge_student) {
                $view_students[$merge_student['student_cycle_id']]['base_term'] = $filter_students[$merge_student['student_cycle_id']];
                $view_students[$merge_student['student_cycle_id']]['merge_term']['courses'] = $merge_student['courses'];
                if (isset($merge_student['merge_course'])) {
                    $view_students[$merge_student['student_cycle_id']]['merge_term']['merge_course'] = $merge_student['merge_course'];
                }

                $view_students[$merge_student['student_cycle_id']]['merge_term']['result'] = $merge_student['result'];
            }

            $attandance_data = $this->get_merge_attendances($student_cycle_ids, $template['term']['value']['term_id'], $get_student[0]['level_id'], $get_student[0]['session_id']);
            $base_heads = $this->genarate_marks_heads($base_template);

            $view_base_heads = $base_heads;
            foreach ($single_results as $result) {
                $gp['name'] = 'GP-' . $result['term_id'];
                $gp['style'] = 'class="res1" colspan="1" rowspan="1"';
                array_unshift($base_heads, $gp);
                $total['name'] = 'Total-' . $result['term_id'];
                $total['style'] = 'class="res1" colspan="1" rowspan="1"';
                array_unshift($base_heads, $total);

                $view_gp['name'] = 'GP';
                $view_gp['style'] = 'class="res1" colspan="1" rowspan="1"';
                array_unshift($view_base_heads, $view_gp);
                $view_total['name'] = 'Total';
                $view_total['style'] = 'class="res1" colspan="1" rowspan="1"';
                array_unshift($view_base_heads, $view_total);
            }
            // echo '<pre>';
            // print_r($single_results);
            // die;
            $merge_head = $this->genarate_marks_heads($template, 1);

            if (isset($base_template['merge_subject'])) {
                $template['merge_subject'] = 'yes';
            }
            foreach ($view_students as $key => $view_student) {
                $base_term[0] = $view_student['base_term'];
                $return_base_term = $this->filter_data_for_view($base_term, $base_heads, $base_template);
                unset($return_base_term[0]['attandance_data']);
                $view_students[$key]['base_term'] = $return_base_term[0];
                $merge_term[0] = $view_student['merge_term'];
                $return_merge_term = $this->filter_data_for_view($merge_term, $merge_head, $template, 1);
                $view_students[$key]['merge_term'] = $return_merge_term[0];
            }
            foreach ($merge_head as $key => $vel) {
                if (isset($vel['type'])) {
                    $merge_head[$key]['name'] = mb_substr($merge_head[$key]['name'], 0, 1);
                }
            }
            $this->layout = 'result';
            $this->autoRender = false;

            // echo '<pre>';
            // print_r($view_students);
            // die;
            $this->set('students', $view_students);

            $scms_activity_remarks = $this->default_activities();
            $this->set('scms_activity_remarks', $scms_activity_remarks);
            $view_base_heads = $this->viewAbleHead($view_base_heads);
            $this->set('heads', $view_base_heads['heads']);
            $merge_head = $this->viewAbleHead($merge_head);
            $this->set('merge_heads', $merge_head['heads']);
            if (count($view_base_heads['notes']) > $merge_head['notes']) {
                $this->set('notes', $view_base_heads['notes']);
            } else {
                $this->set('notes', $merge_head['notes']);
            }
            $merit_from = $this->get_position($results[0]['result_template_id']);
            // echo '<pre>';
            // print_r($merit_from);
            // die;
            $this->set('position', $merit_from);
            $students = array_values($students);
            $exam_title = $this->get_exam_result_title($get_student[0]['session_id'], $get_student[0]['level_id'], $term_cycle_id);

            if ($get_student[0]['section_id']) {
                $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['session_name'];
            } else {
                $exam_title[2] = $students[0]['level_name'] . ' / EQUIVALENT RESULT PUBLICATION ' . $students[0]['session_name'];
            }
            $this->set('exam_title', $exam_title);
            $last_row_colspan = $this->find_last_row_colspan($base_template);
            $last_row_colspan += (count($template['term']['value']['term_name']) - 1) * 2;
            $this->set('last_row_colspan', $last_row_colspan);
            $last_row_colspan_merge_result = $this->find_last_row_colspan($template);
            $this->set('last_row_colspan_merge_result', $last_row_colspan_merge_result);
            $term_names = $this->find_merge_result_term_names($template['term']['value']['term_name']);
            $this->set('term_names', $term_names);
            $this->set('total_attandance', $attandance_data['months']);
            $this->set('studnet_attandance', $attandance_data['student_attendance_data']);

            $decemal_point = $this->get_settings_value('number_format_value_after_decimal');
            $this->set('decemal_point', $decemal_point);


            return [
                'students' => $view_students,
                'scms_activity_remarks' => $scms_activity_remarks,
                'heads' => $view_base_heads['heads'],
                'merge_heads' => $merge_head['heads'],
                'notes' => $view_base_heads['notes'],
                'merge_heads' => $merge_head['heads'],
                'position' => $merit_from,
                'exam_title' => $exam_title,
                'last_row_colspan' => $last_row_colspan,
                'last_row_colspan_merge_result' => $last_row_colspan_merge_result,
                'term_names' => $term_names,
                'decemal_point' => $decemal_point,
                'grades' => $grades,
                'remarks' => $remarks,
                'total_attandance' => $attandance_data['months'],
                'studnet_attandance' => $attandance_data['student_attendance_data']
            ];
        }
    }

}
