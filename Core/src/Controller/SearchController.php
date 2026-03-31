<?php

namespace Croogo\Core\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Http\ResponseEmitter;
use Cake\Http\ServerRequest;
use Croogo\Core\Croogo;

use Cake\ORM\TableRegistry;

class SearchController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }
    public function searchStudent()
    {
        $this->set('title_for_layout', __('Admission Form Search'));
        $this->layout = 'admission-form';
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if (!empty($request_data['roll'])) {

                $roll = $this->request->data['roll'];
                $student = TableRegistry::getTableLocator()->get('temp_students'); //Execute First
                $students = $student
                    ->find()
                    ->where(['temp_students.roll' => $roll])
                    ->toArray();
                if (!empty($students[0]['session'])) {
                    $student = TableRegistry::getTableLocator()->get('temp_students'); //Execute First
                    $students = $student
                        ->find()
                        ->where(['temp_students.roll' => $roll])
                        ->where(['temp_students.session' => $students[0]['session']])
                        ->toArray();
                    $this->set('stu', $students[0]);
                }
            }
        }
    }


    public function twoTakaSearch()
    {
        $this->set('title_for_layout', __('Two Taka Information'));
        $this->layout = 'no_sidebar';
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $sid = $request_data['sid'];
            $dob = $request_data['dob'];
            $session = $request_data['session_id'];
            if (!empty($sid) && !empty($dob) && !empty($session)) {

                $student = TableRegistry::getTableLocator()->get('scms_student_cycle'); //Execute First
                $students = $student
                    ->find()
                    ->where(['s.sid' => $sid])
                    ->where(['s.date_of_birth' => $dob])
                    ->where(['s.session_id' => $session])
                    ->where(['a.note' => 'Two Taka Fund Collection'])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->select([
                        "name" => "s.name",
                        "voucher" => "a.voucher_no",
                        "date" => "a.transaction_date",
                        "amount" => "a.amount"
                    ])
                    ->join([
                        'a' => [
                            'table' => ' acc_transactions',
                            'type' => 'INNER',
                            'conditions' => [
                                'a.student_cycle_id  = scms_student_cycle.student_cycle_id',
                                'a.note'  => 'Two Taka Fund Collection'
                            ],
                        ],
                    ])
                    ->join([
                        's' => [
                            'table' => ' scms_students',
                            'type' => 'INNER',
                            'conditions' => [' s.student_id  = scms_student_cycle.student_id'],
                        ],
                    ])
                    ->toArray();
                $this->set('students', $students);
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);
    }


    public function sidSearch()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();

            $where['scms_student_cycle.session_id'] = $request_data['session_id'];
            $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
            $where['scms_student_cycle.level_id'] = $request_data['level_id'];
            $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            $where['scms_student_cycle.roll'] = $request_data['roll'];

            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $scms_student_cycles = $scms_student_cycle
                ->find()
                ->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'name' => "s.name",
                    'sid' => "s.sid",
                ])
                ->join([
                    's' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            's.student_id = scms_student_cycle.student_id'
                        ]
                    ],
                ])
                ->toArray();
            $this->set('students', $scms_student_cycles[0]);
            $this->set('session_id', $request_data['session_id']);
            $this->set('shift_id', $request_data['shift_id']);
            $this->set('level_id', $request_data['level_id']);
            $this->set('section_id', $request_data['section_id']);
            $this->set('roll', $request_data['roll']);
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->toArray();
        $this->set('sessions', $sessions);
        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->toArray();
        $this->set('levels', $levels);
        $section = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $section
            ->find()
            ->toArray();
        $this->set('sections', $sections);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
    }

}
