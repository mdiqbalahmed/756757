<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\Date;

I18n::setLocale('jp_JP');

class HrsController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function index() {
        
    }

    public function shifts() {
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift->find();
        $paginate = $this->paginate($shifts, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('shifts', $paginate);
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

    public function config() {
        $hr_config_action = TableRegistry::getTableLocator()->get('hr_config_action');
        $hr_config_actions = $hr_config_action->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->select([
            'c_name' => "c.config_name"
          ])
          ->join([
          'c' => [
            'table' => 'hr_config',
            'type' => 'INNER',
            'conditions' => [
              'c.config_key = hr_config_action.config_key'
            ]
          ],
        ]);
        $paginate = $this->paginate($hr_config_actions, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('hr_config_actions', $paginate);
    }

    public function addConfig() {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $hr_config_action = TableRegistry::getTableLocator()->get('hr_config_action');
            $query = $hr_config_action->query();
            $query->insert(['config_action_name', 'config_key'])
              ->values($request_data)
              ->execute();
//Set Flash
            $this->Flash->success('Config Added Successfully', [
              'key' => 'positive',
              'params' => [],
            ]);
            return $this->redirect(['action' => 'config']);
        }
        $hr_config = TableRegistry::getTableLocator()->get('hr_config');
        $hr_configs = $hr_config->find()->toArray();
        $this->set('hr_configs', $hr_configs);
    }

    public function editConfig($id) {

        if ($this->request->is(['post'])) {
            $data = $this->request->getData();

            $hr_config_action = TableRegistry::getTableLocator()->get('hr_config_action');
            $query = $hr_config_action->query();
            $query
              ->update()
              ->set($this->request->getData())
              ->where(['config_action_id' => $data['config_action_id']])
              ->execute();
//Set Flash
            $this->Flash->info('Config Updated Successfully', [
              'key' => 'positive',
              'params' => [],
            ]);
            return $this->redirect(['action' => 'config']);
        }
        $hr_config = TableRegistry::getTableLocator()->get('hr_config');
        $hr_configs = $hr_config->find()->toArray();
        $this->set('hr_configs', $hr_configs);

        $hr_config_action = TableRegistry::getTableLocator()->get('hr_config_action');
        $hr_config_actions = $hr_config_action->find()->where(['config_action_id' => $id])->toArray();
        $this->set('hr_config_actions', $hr_config_actions);
    }

    public function configSetup() {
        $hr_config_action_setup = TableRegistry::getTableLocator()->get('hr_config_action_setup');
        $hr_config_action_setups = $hr_config_action_setup->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->select([
            'c_config_action_name' => "c.config_action_name",
            'u_name' => "u.name"
          ])
          ->join([
          'c' => [
            'table' => 'hr_config_action',
            'type' => 'INNER',
            'conditions' => [
              'c.config_action_id  = hr_config_action_setup.config_action_id'
            ]
          ],
          'u' => [
            'table' => 'users',
            'type' => 'INNER',
            'conditions' => [
              'u.id  = hr_config_action_setup.user_id'
            ]
          ],
        ]);
        $paginate = $this->paginate($hr_config_action_setups, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('hr_config_action_setups', $paginate);
    }

    public function addConfigSetup() {
        if ($this->request->is('post')) {

            $request_data = $this->request->getData();
            if (isset($request_data['months'])) {
                $request_data['months'] = json_encode($request_data['months']);
            } else {
                $request_data['months'] = null;
            }
            $hr_config_action_setup = TableRegistry::getTableLocator()->get('hr_config_action_setup');
            $query = $hr_config_action_setup->query();
            $query->insert(['config_action_id', 'user_id', 'year', 'months', 'value'])
              ->values($request_data)
              ->execute();
//Set Flash
            $this->Flash->success('Config-Setup Added Successfully', [
              'key' => 'positive',
              'params' => [],
            ]);
            return $this->redirect(['action' => 'configSetup']);
        }

        $hr_config_action = TableRegistry::getTableLocator()->get('hr_config_action');
        $hr_config_actions = $hr_config_action->find()->toArray();
        $this->set('hr_config_actions', $hr_config_actions);

        $user = TableRegistry::getTableLocator()->get('users');
        $users = $user->find()->toArray();
        $this->set('users', $users);

        $months['january'] = array('name' => 'January', 'has_access' => 0);
        $months['february'] = array('name' => 'February', 'has_access' => 0);
        $months['march'] = array('name' => 'March', 'has_access' => 0);
        $months['april'] = array('name' => 'April', 'has_access' => 0);
        $months['may'] = array('name' => 'May', 'has_access' => 0);
        $months['june'] = array('name' => 'June', 'has_access' => 0);
        $months['july'] = array('name' => 'July', 'has_access' => 0);
        $months['august'] = array('name' => 'August', 'has_access' => 0);
        $months['september'] = array('name' => 'September', 'has_access' => 0);
        $months['october'] = array('name' => 'October', 'has_access' => 0);
        $months['november'] = array('name' => 'November', 'has_access' => 0);
        $months['december'] = array('name' => 'December', 'has_access' => 0);
        $this->set('months', $months);
    }

    public function editConfigSetup($id) {

        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (isset($request_data['months'])) {
                $request_data['months'] = json_encode($request_data['months']);
            } else {
                $request_data['months'] = null;
            }
            $hr_config_action_setup = TableRegistry::getTableLocator()->get('hr_config_action_setup');
            $query = $hr_config_action_setup->query();
            $query
              ->update()
              ->set($request_data)
              ->where(['config_action_setup_id' => $request_data['config_action_setup_id']])
              ->execute();
//Set Flash
            $this->Flash->info('Config-Setup Updated Successfully', [
              'key' => 'positive',
              'params' => [],
            ]);
            return $this->redirect(['action' => 'configSetup']);
        }


        $hr_config_action = TableRegistry::getTableLocator()->get('hr_config_action');
        $hr_config_actions = $hr_config_action->find()->toArray();
        $this->set('hr_config_actions', $hr_config_actions);

        $user = TableRegistry::getTableLocator()->get('users');
        $users = $user->find()->toArray();
        $this->set('users', $users);

        $hr_config_action_setup = TableRegistry::getTableLocator()->get('hr_config_action_setup');
        $hr_config_action_setups = $hr_config_action_setup->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['config_action_setup_id' => $id])
          ->select([
            'c_config_action_name' => "c.config_action_name",
            'u_name' => "u.name"
          ])
          ->join([
            'c' => [
              'table' => 'hr_config_action',
              'type' => 'INNER',
              'conditions' => [
                'c.config_action_id  = hr_config_action_setup.config_action_id'
              ]
            ],
            'u' => [
              'table' => 'users',
              'type' => 'INNER',
              'conditions' => [
                'u.id  = hr_config_action_setup.user_id'
              ]
            ],
          ])
          ->toArray();

        $this->set('hr_config_action_setups', $hr_config_action_setups);

        $months['january'] = array('name' => 'January', 'has_access' => 0);
        $months['february'] = array('name' => 'February', 'has_access' => 0);
        $months['march'] = array('name' => 'March', 'has_access' => 0);
        $months['april'] = array('name' => 'April', 'has_access' => 0);
        $months['may'] = array('name' => 'May', 'has_access' => 0);
        $months['june'] = array('name' => 'June', 'has_access' => 0);
        $months['july'] = array('name' => 'July', 'has_access' => 0);
        $months['august'] = array('name' => 'August', 'has_access' => 0);
        $months['september'] = array('name' => 'September', 'has_access' => 0);
        $months['october'] = array('name' => 'October', 'has_access' => 0);
        $months['november'] = array('name' => 'November', 'has_access' => 0);
        $months['december'] = array('name' => 'December', 'has_access' => 0);

        if ($hr_config_action_setups[0]['months']) {
            $hr_config_action_setups[0]['months'] = json_decode($hr_config_action_setups[0]['months']);
            foreach ($hr_config_action_setups[0]['months'] as $month) {
                $months[strtolower($month)]['has_access'] = 1;
            }
        }

        $this->set('months', $months);
    }

    public function attendance() {

        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();

            if (isset($request_data['employee_id'])) {
                $shift = $this->get_all_shift();
                $timestamp = strtotime($request_data['date']);
                $day = strtolower(date('l', $timestamp));
                $in_time = $day . '_in_time';
                $out_time = $day . '_out_time';
                $attendance_count['date'] = $value['date'] = $request_data['date'];
                foreach ($request_data['employee_id'] as $key => $employee_id) {
                    $value['minute_late'] = 0;
                    $shift_id = $this->get_shift_id_for_employee($employee_id, $request_data['date']);
                    $attendance_count['employee_id'] = $value['employee_id'] = $request_data['employee_id'][$key];
                    $attendance_count['user_id'] = $value['user_id'] = $request_data['id'][$key];
                    $value['in_time'] = $request_data['in_time'][$key];
                    $value['out_time'] = $request_data['out_time'][$key];
                    $value['in_status'] = null;
                    $value['out_status'] = null;
                    if ($shift_id) {
                        if (isset($shift[$shift_id][$in_time]) && $value['in_time'] != null && $shift[$shift_id][$in_time] != null) {
                            $value['in_status'] = $this->find_late($shift[$shift_id]->$in_time, $request_data['in_time'][$key]);
                            if ($value['in_status'] < 0) {
                                $value['minute_late'] = ($value['in_status']) * -1;
                            }
                        }
                        if (isset($shift[$shift_id][$out_time]) && $value['out_time'] != null && $shift[$shift_id][$out_time] != null) {
                            $value['out_status'] = $this->find_late($shift[$shift_id]->$out_time, $request_data['out_time'][$key]);
                        }
                    }
                    $value['overtime_hours'] = $request_data['overtime_hours'][$key];
                    $value['overtime_amount'] = $request_data['overtime_amount'][$key];
                    $value['employee_attendance_id'] = $request_data['employee_attendance_id'][$key];

                    if ($value['in_time'] != null) {
                        $value['total_in'] = 1;
                        $attendance_count['type'] = $value['status'] = 'in';
                        $attendance_count['time'] = $value['in_time'];
                        $this->save_attendance_count($attendance_count);
                    }
                    if ($value['out_time'] != null) {
                        $value['total_out'] = 1;
                        $attendance_count['type'] = $value['status'] = 'out';
                        $attendance_count['time'] = $value['out_time'];
                        $this->save_attendance_count($attendance_count);
                    }
                    $employee_attendance = TableRegistry::getTableLocator()->get('employee_attendance');
                    $query = $employee_attendance->query();
                    if ($value['employee_attendance_id'] == null) {
                        if ($value['in_time']) {
                            $query->insert(['employee_id', 'in_status', 'out_status', 'user_id', 'in_time', 'date', 'out_time', 'minute_late', 'overtime_hours', 'overtime_amount', 'total_in', 'total_out', 'status'])
                              ->values($value)
                              ->execute();
                        }
                    } else {
                        $query->update()
                          ->set($value)
                          ->where(['employee_attendance_id' => $value['employee_attendance_id']])
                          ->execute();
                    }
                }
            }
        } else {
            $request_data['date'] = date("Y-m-d");
        }

        $this->set('date', $request_data['date']);
        $timestamp = strtotime($request_data['date']);
        $day = strtolower(date('l', $timestamp));
        $in_time = "s." . $day . '_in_time';
        $out_time = "s." . $day . '_out_time';

        $user = TableRegistry::getTableLocator()->get('users');
        $users = $user->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->select([
            'employee_id' => "e.employee_id",
            'sort_id' => 'e.sort_id',
          ])
          ->order(['e.sort_id' => 'ASC'])
          ->join([
            'e' => [
              'table' => 'employee',
              'type' => 'inner',
              'conditions' => [
                'e.user_id = users.id'
              ]
            ],
          ])
          ->toArray();

        $attendance = $this->get_all_attendance($request_data['date']);

        foreach ($users as $key => $user) {
            if (isset($attendance[$user['id']])) {
                $users[$key]['employee_attendance_id'] = $attendance[$user['id']]->employee_attendance_id;
                $users[$key]['in_time'] = $attendance[$user['id']]->in_time;
                $users[$key]['out_time'] = $attendance[$user['id']]->out_time;
                $users[$key]['overtime_hours'] = $attendance[$user['id']]->overtime_hours;
                $users[$key]['overtime_amount'] = $attendance[$user['id']]->overtime_amount;
            } else {
                $users[$key]['in_time'] = null;
                $users[$key]['out_time'] = null;
                $users[$key]['employee_attendance_id'] = null;
                $users[$key]['overtime_hours'] = null;
                $users[$key]['overtime_amount'] = null;
            }
        }

        $this->set('users', $users);
    }

    public function csvAttendanceProcess() {
        $this->autoRender = false;
        $date_filter = $this->get_settings_value('employee_attendance_csv_date');
        $settings_data['value'] = $date_filter;
        $filter_timestamp = 0;
        if ($date_filter) {
            $filter_timestamp = strtotime($date_filter) + 86399;
        }
        $employee_attendance_csv = TableRegistry::getTableLocator()->get('employee_attendance_csv');
        $finds = $employee_attendance_csv
          ->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['checked' => 0])
          ->order(['attendance_csv_id' => 'ASC'])
          ->select([
            'employee_id' => "e.employee_id",
            'user_id' => "e.user_id",
          ])
          ->join([
            'e' => [
              'table' => 'employee',
              'type' => 'inner',
              'conditions' => [
                'e.rf_id = employee_attendance_csv.number'
              ]
            ],
          ])
          ->toArray();

        $timestamp_1 = 0;
        $attendance_array = array();
        $employee_ids = array();

        foreach ($finds as $find) {
            $timestamp_2 = strtotime($find['date']);
            $date = date('Y/m/d', $timestamp_2);

            $employee_attendance_count_data['time'] = $find['time'] = date('H:i', strtotime($find['date']));
            $find['time_in_sceonds'] = date('H', strtotime($find['date'])) * 3600 + date('i', strtotime($find['date'])) * 60 + date('s', strtotime($find['date']));
            $employee_attendance_count_data['date'] = $find['date'] = $date;
            $employee_attendance_count_data['employee_id'] = $employee_ids[] = $find['employee_id'];
            $employee_attendance_count_data['user_id'] = $find['user_id'];
            $attendance_array[$date]['date'] = $date;

            //sorttng in and out time by punch time
            $check_find[] = $find;
            if (isset($attendance_array[$date]['attendance'][$find['employee_id']][0])) {
                $check_find[] = $attendance_array[$date]['attendance'][$find['employee_id']][0];
            }
            if (isset($attendance_array[$date]['attendance'][$find['employee_id']][1])) {
                $check_find[] = $attendance_array[$date]['attendance'][$find['employee_id']][1];
            }
            usort($check_find, function ($a, $b) {
                return $a['time_in_sceonds'] <=> $b['time_in_sceonds'];
            });
            $attendance_array[$date]['attendance'][$find['employee_id']][0] = $check_find[0];
            if (isset($check_find[2])) {
                $attendance_array[$date]['attendance'][$find['employee_id']][1] = $check_find[2];
            } else {
                if (isset($check_find[1])) {
                    $attendance_array[$date]['attendance'][$find['employee_id']][1] = $check_find[1];
                }
            }
            unset($check_find);
            //sorttng in and out time by punch time end

            $employee_attendance_count = TableRegistry::getTableLocator()->get('employee_attendance_count');
            $query = $employee_attendance_count->query();
            $query->insert(['employee_id', 'user_id', 'date', 'time'])
              ->values($employee_attendance_count_data)
              ->execute();

            //get the last date for settings value
            if ($timestamp_2 > $filter_timestamp) {
                if ($timestamp_2 > $timestamp_1) {
                    $settings_data['value'] = date('m/d/y', $timestamp_2);
                    $timestamp_1 = $timestamp_2;
                }
            }
        }
        $employee_ids = array_unique($employee_ids);
        if (count($employee_ids) > 0) {
            $shift = $this->get_all_shift();
            foreach ($attendance_array as $dates) {
                $employee_attendance_data['date'] = $dates['date'];
                $day = strtolower(date('l', strtotime($employee_attendance_data['date'])));
                $in_time = $day . '_in_time';
                $out_time = $day . '_out_time';
                foreach ($dates['attendance'] as $employee) {
                    $shift_id = $this->get_shift_id_for_employee($employee[0]['employee_id'], $employee_attendance_data['date']);
                    $employee_attendance_data['employee_id'] = $employee[0]['employee_id'];
                    $employee_attendance_data['user_id'] = $employee[0]['user_id'];
                    $employee_attendance_data['in_time'] = $employee[0]['time'];
                    $employee_attendance_data['status'] = 'in';
                    $employee_attendance_data['minute_late'] = 0;
                    $employee_attendance_data['out_time'] = null;
                    $employee_attendance_data['out_status'] = null;

                    if ($shift_id) {
                        if (isset($shift[$shift_id][$in_time]) && $employee_attendance_data['in_time'] != null && $shift[$shift_id][$in_time] != null) {
                            $employee_attendance_data['in_status'] = $this->find_late($shift[$shift_id]->$in_time, $employee_attendance_data['in_time']);
                            if ($employee_attendance_data['in_status'] < 0) {
                                $employee_attendance_data['minute_late'] = ($employee_attendance_data['in_status']) * -1;
                            }
                        }
                        if (isset($employee[1])) {
                            $employee_attendance_data['out_time'] = $employee[1]['time'];
                            $employee_attendance_data['status'] = 'out';
                            if (isset($shift[$shift_id][$out_time]) && $employee_attendance_data['out_time'] != null && $shift[$shift_id][$out_time] != null) {
                                $employee_attendance_data['out_status'] = $this->find_late($shift[$shift_id]->$out_time, $employee_attendance_data['out_time']);
                            }
                        }
                    }
                    $employee_attendance = TableRegistry::getTableLocator()->get('employee_attendance');
                    $query = $employee_attendance->query();
                    $query->insert(['employee_id', 'in_status', 'out_status', 'user_id', 'in_time', 'date', 'out_time', 'minute_late', 'status'])
                      ->values($employee_attendance_data)
                      ->execute();
                }
                unset($employee_attendance_data);
            }

            $this->Flash->info('Attendance Process Successfully Completed', [
              'key' => 'positive',
              'params' => [],
            ]);
        } else {
            $this->Flash->info('No Attendance to process', [
              'key' => 'negative',
              'params' => [],
            ]);
        }
        $settings = TableRegistry::getTableLocator()->get('settings');
        $query = $settings->query();
        $query->update()
          ->set($settings_data)
          ->where(['id' => 43])
          ->execute();
        $employee_attendance_csv_data['checked'] = 1;
        $query = $employee_attendance_csv->query();
        $query->update()
          ->set($employee_attendance_csv_data)
          ->execute();
        return $this->redirect(['action' => 'csvAttendance']);
    }

    public function csvAttendance() {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $name = $request_data['csv']['name'];
            $ext = strtolower(substr(strrchr($name, "."), 1));
            if ($ext == "csv") {
                $file = $request_data['csv']['tmp_name'];
                $handle = fopen($file, "r");
                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($row[0] == 'Department') {
                        continue;
                    }
                    $columns = [
                      'department' => $row[0],
                      'name' => $row[1],
                      'number' => $row[2],
                      'date' => $row[3],
                      'location' => $row[4],
                      'Cardno' => $row[7],
                    ];

                    $employee_attendance_csv = TableRegistry::getTableLocator()->get('employee_attendance_csv');
                    $query = $employee_attendance_csv->query();
                    $query->insert(['department', 'name', 'number', 'date', 'location', 'Cardno'])
                      ->values($columns)
                      ->execute();
                }
                fclose($handle);
                $this->Flash->info('CSV uploaded Successfully', [
                  'key' => 'positive',
                  'params' => [],
                ]);
            } else {
                $this->Flash->info('Wrong File', [
                  'key' => 'negative',
                  'params' => [],
                ]);
            }
        }
    }

    private function get_shift_id_for_employee($employee_id, $date) {
        $roster_employee = TableRegistry::getTableLocator()->get('hr_roster_employee');
        $roster_employees = $roster_employee->find()
            ->where(['employee_id in' => $employee_id])
            ->where(['r.start_date <=' => $date])
            ->where(['r.end_date >=' => $date])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
              'roster_name' => "r.roster_name",
              'shift_id' => "r.shift_id",
            ])
            ->join([
              'r' => [
                'table' => 'hr_roster',
                'type' => 'LEFT',
                'conditions' => [
                  'r.roster_id = hr_roster_employee.roster_id'
                ]
              ],
            ])->toArray();
        if (count($roster_employees) == 1) {
            return $roster_employees[0]['shift_id'];
        } else {
            return false;
        }
    }

    private function save_attendance_count($data) {
        $data['attendance_type'] = $search['attendance_type'] = 'admin';
        $search['user_id'] = $data['user_id'];
        $search['date'] = $data['date'];
        $search['type'] = $data['type'];
        $employee_attendance_count = TableRegistry::getTableLocator()->get('employee_attendance_count');
        $find = $employee_attendance_count
          ->find()
          ->where($search)
          ->toArray();

        $query = $employee_attendance_count->query();
        if (empty($find)) {
            $query->insert(['employee_id', 'user_id', 'date', 'time', 'type', 'attendance_type'])
              ->values($data)
              ->execute();
        } else {
            $query->update()
              ->set($data)
              ->where(['employee_attendance_count_id' => $find[0]->employee_attendance_count_id])
              ->execute();
        }
    }

    private function get_all_shift() {
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift->find()->toArray();
        foreach ($shifts as $shift) {
            $return[$shift->shift_id] = $shift;
        }
        return $return;
    }

    private function find_late($base_time, $time) {
        $base_time = explode(':', $base_time);
        $base_seconds = $base_time[0] * 3600 + $base_time[1] * 60;

        $time = explode(':', $time);
        $time_seconds = $time[0] * 3600 + $time[1] * 60;
        return floor(($base_seconds - $time_seconds) / 60);
    }

    private function get_all_attendance($date) {
        $return = array();
        $where['date'] = $date;
        $employee_attendance = TableRegistry::getTableLocator()->get('employee_attendance');
        $attendance = $employee_attendance
          ->find()
          ->where($where)
          ->toArray();
        foreach ($attendance as $attend) {
            $return[$attend->user_id] = $attend;
        }
        return $return;
    }

    public function calendar() {
        
    }

    public function loadCalendar() {
        $this->autoRender = false;
        $event = TableRegistry::getTableLocator()->get('hr_events');
        $events = $event
          ->find()
          ->toArray();

        foreach ($events as $row) {
            $data[] = array(
              'id' => $row->id,
              'title' => $row->title,
              'start' => $row->start_event,
              'end' => $row->end_event
            );
        }
        echo json_encode($data);
    }

    public function insertCalendar() {
        $this->autoRender = false;
        $data['title'] = $_GET['title'];
        $data['start_event'] = $_GET['start'];
        $data['end_event'] = $_GET['end'];

        $event = TableRegistry::getTableLocator()->get('hr_events');
        $query = $event->query();
        $query->insert(['title', 'start_event', 'end_event'])
          ->values($data)
          ->execute();
    }

    public function updateCalendar() {
        $this->autoRender = false;
        $id = $_GET['id'];
        $data['title'] = $_GET['title'];
        $data['start_event'] = $_GET['start'];
        $data['end_event'] = $_GET['end'];

        $event = TableRegistry::getTableLocator()->get('hr_events');
        $query = $event->query();
        $query->update()
          ->set($data)
          ->where(['id' => $id])
          ->execute();
    }

    public function deleteCalendar() {
        $this->autoRender = false;
        $id = $_GET['id'];
        $event = TableRegistry::getTableLocator()->get('hr_events');
        $query = $event->query();
        $query->delete()
          ->where(['id' => $id])
          ->execute();
    }

    public function payroll() {
        $payroll = TableRegistry::getTableLocator()->get('payroll');
        $payrolls = $payroll
          ->find()
          ->toArray();
        $this->set('payrolls', $payrolls);
    }

    public function payment($id) {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $ids = array_filter(explode(",", $request_data['id']));
            unset($request_data['all']);
            unset($request_data['id']);
            $request_data['payment_by'] = $this->Auth->user('id');
            $payroll_payment = TableRegistry::getTableLocator()->get('payroll_payments');
            $payroll_employee = TableRegistry::getTableLocator()->get('payroll_employee');
            $payroll_employees = $payroll_employee->find()
              ->enableAutoFields(true)
              ->enableHydration(false)
              ->where(['payroll_id' => $id])
              ->where(['payment' => 0])
              ->select([
                'name' => "u.name",
              ])
              ->join([
                'u' => [
                  'table' => 'users',
                  'type' => 'LEFT',
                  'conditions' => [
                    'u.id = payroll_employee.user_id'
                  ]
                ],
              ])
              ->toArray();
            $total = 0;
            foreach ($payroll_employees as $payroll_employee) {
                if ($payroll_employee['payment'] == 0) {
                    $total = $total + $payroll_employee['basic_salary'] + $payroll_employee['total_allowances'] + $payroll_employee['total_bonus'] + $payroll_employee['overtime_amount'] - $payroll_employee['total_penalty'] - $payroll_employee['late_cut'] - $payroll_employee['absent_cut'];
                }
            }
            if (round($total) > $request_data['amount']) {
                $payroll_data['payment'] = 'Partial Paid';
            } else {
                $payroll_data['payment'] = 'Paid';
            }
//update payroll table
            $payroll = TableRegistry::getTableLocator()->get('payroll');
            $query = $payroll->query();
            $query->update()
              ->set($payroll_data)
              ->where(['payroll_id' => $request_data['payroll_id']])
              ->execute();
//insert into payroll_payment
            $query = $payroll_payment->query();
            $query->insert(['payroll_id', 'amount', 'bank_id', 'date', 'comment', 'payment_by'])
              ->values($request_data)
              ->execute();
            $myrecords = $payroll_payment->find()->last(); //get the last id
            $payroll_employee_data['payment_id'] = $myrecords->payroll_payment_id;

//insert into payroll_employee
            $payroll_employee = TableRegistry::getTableLocator()->get('payroll_employee');
            $payroll_employee_data['payment'] = 1;
            foreach ($ids as $id) {
                $query = $payroll_employee->query();
                $query->update()
                  ->set($payroll_employee_data)
                  ->where(['payroll_employee_id' => $id])
                  ->execute();
            }
//insert into transactions
            $transactions = TableRegistry::getTableLocator()->get('acc_transactions');
            $transactions_data['month'] = $request_data['month'];
            $transactions_data['purpose_id'] = 3000;
            $transactions_data['reason'] = "Debit";
            $transactions_data['bank_id'] = $request_data['bank_id'];
            $transactions_data['transaction_type'] = "Debit";
            $transactions_data['user_id'] = $this->Auth->user('id');

            $query = $transactions->query();
            $query->insert(['month', 'purpose_id', 'reason', 'bank_id', 'transaction_type', 'user_id'])
              ->values($transactions_data)
              ->execute();

            $this->Flash->success('Payroll Payment Done Successfully', [
              'key' => 'positive',
              'params' => [],
            ]);
            return $this->redirect(['action' => 'payroll']);
        }

        $payroll = TableRegistry::getTableLocator()->get('payroll');
        $payrolls = $payroll
          ->find()
          ->where(['payroll_id ' => $id])
          ->toArray();

        $payrolls[0]->attandance = isset($payrolls[0]->attandance) ? "Yes" : "NO";
        $payrolls[0]->absent = isset($payrolls[0]->absent) ? "Yes" : "NO";
        $payrolls[0]->overtime = isset($payrolls[0]->overtime) ? "Yes" : "NO";
        $payrolls[0]->cut_from = isset($payrolls[0]->cut_from) ? ucfirst($payrolls[0]->cut_from) . " Salary" : null;
        $payrolls[0]->absent_cut_from = isset($payrolls[0]->absent_cut_from) ? ucfirst($payrolls[0]->absent_cut_from) . " Salary" : null;

        $this->set('payroll', $payrolls[0]);

        $config_action_id = json_decode($payrolls[0]->config_action_id);
        $hr_config = TableRegistry::getTableLocator()->get('hr_config_action');
        $hr_configs = $hr_config
          ->find()
          ->where(['config_action_id  in' => $config_action_id])
          ->toArray();
        $this->set('hr_configs', $hr_configs);

        $payroll_employee = TableRegistry::getTableLocator()->get('payroll_employee');
        $payroll_employees = $payroll_employee->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['payroll_id' => $id])
          ->select([
            'name' => "u.name",
          ])
          ->join([
            'u' => [
              'table' => 'users',
              'type' => 'LEFT',
              'conditions' => [
                'u.id = payroll_employee.user_id'
              ]
            ],
          ])
          ->toArray();
        $this->set('payroll_employees', $payroll_employees);
        $total = 0;
        $ids = null;
        foreach ($payroll_employees as $payroll_employee) {
            if ($payroll_employee['payment'] == 0) {
                $ids = $ids . ',' . $payroll_employee['payroll_employee_id'];
                $total = $total + $payroll_employee['basic_salary'] + $payroll_employee['total_allowances'] + $payroll_employee['total_bonus'] + $payroll_employee['overtime_amount'] - $payroll_employee['total_penalty'] - $payroll_employee['late_cut'] - $payroll_employee['absent_cut'];
            }
        }
        $this->set('sum', round($total));
        $this->set('ids', $ids);

        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->toArray();
        $this->set('banks', $banks);
    }

    public function addPayroll() {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $employees = $this->get_payroll_employee($request_data);
            if (empty($employees)) {
                $message = 'No Employee Seleted';
//Set Flash
                $this->Flash->error($message, [
                  'key' => 'negative',
                  'params' => [],
                ]);
                return $this->redirect(['action' => 'addPayroll']);
            }
            $date = $request_data['year'] . '-' . ucfirst($request_data['months']);
            $first_date = date("Y-m-d", strtotime($date));
            $last_day = date("Y-m-t", strtotime($first_date));
            $working_days = $this->get_working_day_for_all_shift($first_date, $last_day); //working days for all shift
            $no_duplicate = array();
            if (isset($request_data['config'])) {
                $no_duplicate = $this->no_duplicate_config($request_data['config']); //which should have no double configaration setup
            }
            foreach ($employees as $key => $employee) {
                if ($employee['shift_id']) {
                    $total_day = count($working_days[$employee['shift_id']]); //total working day
                } else {
                    $total_day = 0;
                }
                $late = 0;
                $value = array();
                if (isset($request_data['config'])) {
                    $all_config = $this->get_employee_wise_config_action($request_data['config'], $employee['id'], $request_data['year']); //all the configaration 
                    $value = $this->_filter_employee_wise_data_by_month($all_config, $request_data['months']); //filter cofigaration by month
                    if (!empty($value)) {
                        $return = $this->_cheak_multiple($value, $no_duplicate, $employee); //check whether there is any douplicate entry for no duplicate
                        if ($return == -1) {
                            return $this->redirect(['action' => 'addPayroll']);
                        }
                    }
                }
//initializing all the information 
                $payroll_employee_data[$key]['employee_user_id'] = $employee['id'];
                $payroll_employee_data[$key]['name'] = $employee['name'];
                $payroll_employee_data[$key]['basic_salary'] = 0;
                $payroll_employee_data[$key]['total_allowances'] = 0;
                $payroll_employee_data[$key]['total_bonus'] = 0;
                $payroll_employee_data[$key]['total_penalty'] = 0;
                $payroll_employee_data[$key]['late'] = 0;
                $payroll_employee_data[$key]['late_cut'] = 0;
                $payroll_employee_data[$key]['absent'] = 0;
                $payroll_employee_data[$key]['absent_cut'] = 0;
                $payroll_employee_data[$key]['leaves'] = 0;
                $payroll_employee_data[$key]['overtime_hours'] = 0;
                $payroll_employee_data[$key]['overtime_amount'] = 0;
                foreach ($value as $key2 => $val) {
                    $config_action[] = $val;
                    $enployee_config[$employee['name']][$key2]['config_action_id'] = $val['config_action_id'];
                    $enployee_config[$employee['name']][$key2]['id'] = $val['user_id'];
                    $enployee_config[$employee['name']][$key2]['value'] = $val['value'];
                    if ($val['config_key'] == 'allowances') {
                        $payroll_employee_data[$key]['total_allowances'] = $payroll_employee_data[$key]['total_allowances'] + $val['value'];
                    } else if ($val['config_key'] == 'basic_salary') {
                        $payroll_employee_data[$key]['basic_salary'] = $val['value'];
                    } else if ($val['config_key'] == 'bonus') {
                        $payroll_employee_data[$key]['total_bonus'] = $payroll_employee_data[$key]['total_bonus'] + $val['value'];
                    } else {
                        $payroll_employee_data[$key]['total_penalty'] = $payroll_employee_data[$key]['total_penalty'] + $val['value'];
                    }
                }
                if ($employee['shift_id']) {
                    if (isset($request_data['attandance']) || isset($request_data['absent'])) {
                        $leaves = $this->get_leaves($employee['id'], strtotime($first_date), strtotime($last_day)); //find all the leaves
                        $payroll_employee_data[$key]['leaves'] = count($leaves['full_leave']) + (count($leaves['half_leave'][1]['date']) + count($leaves['half_leave'][2]['date'])) / 2;
                        $working_days_for_employee = array_diff($working_days[$employee['shift_id']], array_merge($leaves['full_leave']));

                        if (isset($request_data['attandance'])) {
                            $attendance_days = array_diff($working_days_for_employee, $leaves['half_leave'][1]['date']);
                            $attendances = $this->get_attendance($employee['id'], $attendance_days);
                            foreach ($attendances as $attendance) {
                                if ($request_data['attandance_grace'] < $attendance['minute_late']) {
                                    $payroll_employee_data[$key]['late']++;
                                }
                            }
                            $late = floor($payroll_employee_data[$key]['late'] / $request_data['attandance_day']);
                            if ($request_data['attandance_cut_from'] == 'gross') {
                                $payroll_employee_data[$key]['late_cut'] = (($payroll_employee_data[$key]['basic_salary'] + $payroll_employee_data[$key]['total_allowances']) / $total_day) * $late;
                            } else {
                                $payroll_employee_data[$key]['late_cut'] = (($payroll_employee_data[$key]['basic_salary']) / $total_day) * $late;
                            }
                        }
                        if (isset($request_data['absent'])) {
                            $attendance_date = array();
                            $attendances = $this->get_attendance($employee['id'], $working_days_for_employee);
                            foreach ($attendances as $attendance) {
                                $attendance_date[] = $attendance['date'];
                            }
                            if (!empty($leaves['half_leave'][1]['date'])) {
                                foreach ($leaves['half_leave'][1]['date'] as $half_leave) {
                                    $half_leaves_days[] = $half_leave;
                                }
                            }
                            if (!empty($leaves['half_leave'][2]['date'])) {
                                foreach ($leaves['half_leave'][2]['date'] as $half_leave) {
                                    $half_leaves_days[] = $half_leave;
                                }
                            }
                            $attendances_half = array();
                            if (isset($half_leaves_days)) {
                                $attendances_half = $this->get_attendance($employee['id'], $half_leaves_days);
                            }
                            $payroll_employee_data[$key]['absent'] = $total_day - count($attendance_date) - $payroll_employee_data[$key]['leaves'] - count($attendances_half) / 2;
                            if ($request_data['absent_cut_from'] == 'gross') {
                                $payroll_employee_data[$key]['absent_cut'] = (($payroll_employee_data[$key]['basic_salary'] + $payroll_employee_data[$key]['total_allowances']) / $total_day) * $payroll_employee_data[$key]['absent'];
                            } else {
                                $payroll_employee_data[$key]['absent_cut'] = (($payroll_employee_data[$key]['basic_salary']) / $total_day) * $payroll_employee_data[$key]['absent'];
                            }
                        }
                    }
                }
                if (isset($request_data['overtime'])) {
                    $employee_attendance = TableRegistry::getTableLocator()->get('employee_attendance');
                    $overtimes = $employee_attendance
                      ->find()
                      ->enableAutoFields(true)
                      ->enableHydration(false)
                      ->where(['date >=' => $first_date])
                      ->where(['date <=' => $last_day])
                      ->where(['user_id' => $employee['id']])
                      ->toArray();
                    foreach ($overtimes as $overtime) {
                        $payroll_employee_data[$key]['overtime_hours'] = $payroll_employee_data[$key]['overtime_hours'] + $overtime['overtime_hours'];
                        $payroll_employee_data[$key]['overtime_amount'] = $payroll_employee_data[$key]['overtime_amount'] + $overtime['overtime_amount'];
                    }
                }
            }
//insert  into payroll
            $payroll_data['type'] = isset($request_data['full']) ? 'Full' : "Half";
            $payroll_data['year'] = $request_data['year'];
            $payroll_data['month'] = $request_data['months'];
            $payroll_data['user_ids'] = isset($request_data['user_id']) ? json_encode($request_data['user_id']) : null;
            $payroll_data['user_ids'] = isset($request_data['designation']) ? json_encode($request_data['designation']) : null;
            $payroll_data['attandance'] = isset($request_data['attandance']) ? 1 : null;
            $payroll_data['attandance_grace'] = $request_data['attandance_grace'];
            $payroll_data['late_cut'] = $request_data['attandance_day'];
            $payroll_data['cut_from'] = isset($request_data['attandance_cut_from']) ? $request_data['attandance_cut_from'] : null;
            $payroll_data['absent'] = isset($request_data['absent']) ? 1 : null;
            $payroll_data['absent_cut'] = $request_data['absent_cut'];
            $payroll_data['absent_cut_from'] = isset($request_data['absent_cut_from']) ? $request_data['absent_cut_from'] : null;
            $payroll_data['overtime'] = isset($request_data['overtime']) ? 1 : null;
            $payroll_data['created_by'] = $this->Auth->user('id');
            $payroll_data['create_date'] = date("Y-m-d h:i:sa");
            $payroll_data['config_action_id'] = isset($request_data['config']) ? json_encode($request_data['config']) : null;

            $payroll = TableRegistry::getTableLocator()->get('payroll');
            $query = $payroll->query();
            $query->insert(['type', 'year', 'month', 'user_ids', 'employees_designation_ids', 'attandance', 'attandance_grace', 'late_cut', 'cut_from', 'absent', 'absent_cut', 'absent_cut_from', 'overtime', 'created_by', 'create_date', 'config_action_id'])
              ->values($payroll_data)
              ->execute();
            $myrecords = $payroll->find()->last(); //get the last id
            $payroll_id = $myrecords->payroll_id;

//insert into payroll_employee
            $data_payroll_employee['payroll_id'] = $payroll_id;
            $payroll_employees = TableRegistry::getTableLocator()->get('payroll_employee');
            foreach ($payroll_employee_data as $employee_data) {
                $data_payroll_employee['user_id'] = $employee_data['employee_user_id'];
                $data_payroll_employee['basic_salary'] = $employee_data['basic_salary'];
                $data_payroll_employee['total_allowances'] = $employee_data['total_allowances'];
                $data_payroll_employee['total_bonus'] = $employee_data['total_bonus'];
                $data_payroll_employee['total_penalty'] = $employee_data['total_penalty'];
                $data_payroll_employee['late'] = $employee_data['late'];
                $data_payroll_employee['late_cut'] = $employee_data['late_cut'];
                $data_payroll_employee['absent'] = $employee_data['absent'];
                $data_payroll_employee['absent_cut'] = $employee_data['absent_cut'];
                $data_payroll_employee['leaves'] = $employee_data['leaves'];
                $data_payroll_employee['overtime_hours'] = $employee_data['overtime_hours'];
                $data_payroll_employee['overtime_amount'] = $employee_data['overtime_amount'];
                $query = $payroll_employees->query();
                $query->insert(['payroll_id', 'user_id', 'basic_salary', 'total_allowances', 'total_bonus', 'total_penalty', 'late', 'late_cut', 'absent', 'absent_cut', 'leaves', 'overtime_hours', 'overtime_amount'])
                  ->values($data_payroll_employee)
                  ->execute();
            }
//Set Flash
            $this->Flash->info('Payroll Genarated Successfully', [
              'key' => 'positive',
              'params' => [],
            ]);
            return $this->redirect(['action' => 'payroll']);
        }
        $months['january'] = array('name' => 'January', 'has_access' => 0);
        $months['february'] = array('name' => 'February', 'has_access' => 0);
        $months['march'] = array('name' => 'March', 'has_access' => 0);
        $months['april'] = array('name' => 'April', 'has_access' => 0);
        $months['may'] = array('name' => 'May', 'has_access' => 0);
        $months['june'] = array('name' => 'June', 'has_access' => 0);
        $months['july'] = array('name' => 'July', 'has_access' => 0);
        $months['august'] = array('name' => 'August', 'has_access' => 0);
        $months['september'] = array('name' => 'September', 'has_access' => 0);
        $months['october'] = array('name' => 'October', 'has_access' => 0);
        $months['november'] = array('name' => 'November', 'has_access' => 0);
        $months['december'] = array('name' => 'December', 'has_access' => 0);
        $this->set('months', $months);
        $employees_designation = TableRegistry::getTableLocator()->get('employees_designation');
        $designation = $employees_designation->find()->toArray();
        $this->set('designations', $designation);

        $user = TableRegistry::getTableLocator()->get('users');
        $users = $user->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->select([
            'employee_id' => "e.employee_id",
          ])
          ->join([
            'e' => [
              'table' => 'employee',
              'type' => 'LEFT',
              'conditions' => [
                'e.user_id = users.id'
              ]
            ]
          ])
          ->toArray();
        $this->set('users', $users);
        $config_key[] = 'allowances';
        $config_key[] = 'basic_salary';
        $config_key[] = 'bonus';
        $config_key[] = 'penalty';
        $hr_config_action = TableRegistry::getTableLocator()->get('hr_config_action');
        $hr_config_actions = $hr_config_action->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['config_key' => $config_key], ['config_key' => 'string[]'])
          ->toArray();
        $this->set('hr_config_actions', $hr_config_actions);
    }

    public function addLeaveAdmin() {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (isset($request_data['half_leave'])) {
                $count = 0.5;
            } else {
                $date1 = strtotime($request_data['date_from']);
                $date2 = strtotime($request_data['date_to']);
                if ($date2 == null) {
                    $count = 1;
                } else {
                    $datediff = $date2 - $date1;
                    $count = round($datediff / 86400) + 1;
                }
            }
            if ($request_data['approval'] == "Accepted") {
                $request_data['count'] = $count;
            } else {
                $request_data['count'] = 0;
            }

            $file = $request_data['file'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);
            $imageFileName = null;
            if (in_array($ext, $arr_ext)) {
                move_uploaded_file($file['tmp_name'], WWW_ROOT . '/uploads/leave_attachments/' . $setNewFileName . '.' . $ext);
                $imageFileName = $setNewFileName . '.' . $ext;
            }

            $employee = TableRegistry::getTableLocator()->get('employee');
            $employees = $employee->find()
              ->where(['employee_id' => $request_data['employee_id']])
              ->enableAutoFields(true)
              ->enableHydration(false)
              ->toArray();
            $request_data['user_id'] = $employees[0]['user_id'];

            $id = $this->Auth->user('id');
            $request_data['approved_by'] = $id;
            $request_data['submit_date'] = date('Y-m-d');
            $request_data['approved_date'] = date('Y-m-d');
            $request_data['file'] = $imageFileName;
            unset($request_data['employee_id']);
            $data = TableRegistry::getTableLocator()->get('hr_config_action_setup');
            $config = $data
              ->find()
              ->where(['config_action_setup_id' => $request_data['config_action_setup_id']])
              ->toArray();
            if ($request_data['approval'] == 'Accepted') {
                $hr_config_action_setup_data['value'] = $config[0]->value - $count;
            }
            if (isset($hr_config_action_setup_data)) {
                $query = $data->query();
                $query
                  ->update()
                  ->set($hr_config_action_setup_data)
                  ->where(['config_action_setup_id' => $request_data['config_action_setup_id']])
                  ->execute();
            }

            $leaves = TableRegistry::getTableLocator()->get('hr_leaves');
            $query = $leaves->query();
            $query
              ->insert(['config_action_setup_id', 'approval', 'count', 'approved_by', 'comment', 'date_from', 'date_to', 'half_leave', 'half_leave_type', 'body', 'user_id', 'submit_date', 'file'])
              ->values($request_data)
              ->execute();
            //Set Flash
            $this->Flash->success('Leave Aplication Submitted Successfully', []);
        }

        $approvals[] = "Accepted";
        $approvals[] = "Declined";
        $approvals[] = "Cancelled";
        $this->set('approvals', $approvals);

        $id = $this->Auth->user('id');
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
        $this->set('leave_type', $leave_type);

        $employee = TableRegistry::getTableLocator()->get('employee');
        $employees = $employee->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();

        $this->set('employees', $employees);
    }

    public function allLeaves() {
        $user = TableRegistry::getTableLocator()->get('hr_leaves');
        $users = $user->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->select([
            'u_username' => "u.username",
            'hc_config_action_setup_id' => "c.config_action_name",
          ])
          ->join([
            'u' => [
              'table' => 'users',
              'type' => 'INNER',
              'conditions' => [
                'u.id = hr_leaves.user_id'
              ]
            ],
          ])
          ->join([
          'h' => [
            'table' => 'hr_config_action_setup',
            'type' => 'LEFT',
            'conditions' => [
              'h.config_action_setup_id = hr_leaves.config_action_setup_id'
            ]
          ],
          'c' => [
            'table' => 'hr_config_action',
            'type' => 'LEFT',
            'conditions' => [
              'h.config_action_id = c.config_action_id'
            ]
          ],
        ]);
        $paginate = $this->paginate($users, ['limit' => $this->Paginate_limit]);
        $users = $paginate->toArray();
        foreach ($users as $key => $user) {
            if ($user['half_leave'] != null) {
                $users[$key]['half_leave'] = 'Yes';
            }
        }
        $this->set('users', $users);
    }

    public function roster() {
        $roster = TableRegistry::getTableLocator()->get('hr_roster');
        $rosters = $roster
          ->find()
          ->order(['roster_id' => 'DESC'])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->select([
            'shift_name' => "s.shift_name",
          ])
          ->join([
          's' => [
            'table' => 'hr_shift',
            'type' => 'LEFT',
            'conditions' => [
              's.shift_id = hr_roster.shift_id'
            ]
          ],
        ]);

        $paginate = $this->paginate($rosters, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('rosters', $paginate);
    }

    public function addRoster() {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();

            $roster_names = array();
            $warning_message = 'Employee and Time Collusion With';
            $roster_employee = TableRegistry::getTableLocator()->get('hr_roster_employee');
            $roster_employees_1 = $roster_employee->find()
                ->where(['employee_id in' => $request_data['employee_id']])
                ->where(['r.start_date <=' => $request_data['start_date']])
                ->where(['r.end_date >=' => $request_data['start_date']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                  'roster_name' => "r.roster_name",
                ])
                ->join([
                  'r' => [
                    'table' => 'hr_roster',
                    'type' => 'LEFT',
                    'conditions' => [
                      'r.roster_id = hr_roster_employee.roster_id'
                    ]
                  ],
                ])->toArray();

            $roster_employees_2 = $roster_employee->find()
                ->where(['employee_id in' => $request_data['employee_id']])
                ->where(['r.start_date <=' => $request_data['end_date']])
                ->where(['r.end_date >=' => $request_data['end_date']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                  'roster_name' => "r.roster_name",
                ])
                ->join([
                  'r' => [
                    'table' => 'hr_roster',
                    'type' => 'LEFT',
                    'conditions' => [
                      'r.roster_id = hr_roster_employee.roster_id'
                    ]
                  ],
                ])->toArray();
            $roster_employees = array_merge($roster_employees_1, $roster_employees_2);
            foreach ($roster_employees as $roster_employee) {
                $roster_names[$roster_employee['roster_name']] = $roster_employee['roster_name'];
            }
            foreach ($roster_names as $roster_name) {
                $warning_message = $warning_message . ', ' . $roster_name;
            }

            if (count($roster_names) > 0) {
                $warning_message = $warning_message . '.';
                $this->Flash->error($warning_message, [
                  'key' => 'Negative',
                  'params' => [],
                ]);
            } else {

                $roster_data['roster_name'] = $request_data['roster_name'];
                $roster_data['start_date'] = $request_data['start_date'];
                $roster_data['end_date'] = $request_data['end_date'];
                $roster_data['shift_id'] = $request_data['shift_id'];
                $roster_data['created_by'] = $this->Auth->user('id');
                $roster_data['created_date'] = date("Y-m-d");

                $roster = TableRegistry::getTableLocator()->get('hr_roster');
                $query = $roster->query();
                $query->insert(['roster_name', 'start_date', 'end_date', 'shift_id', 'created_by', 'created_date'])
                  ->values($roster_data)
                  ->execute();

                $myrecords = $roster->find()->last(); //get the last id
                $roster_employee_data['roster_id'] = $myrecords->roster_id;

                $roster_employee = TableRegistry::getTableLocator()->get('hr_roster_employee');
                foreach ($request_data['employee_id'] as $employee_id) {
                    $roster_employee_data['employee_id'] = $employee_id;
                    $query = $roster_employee->query();
                    $query->insert(['employee_id', 'roster_id'])
                      ->values($roster_employee_data)
                      ->execute();
                }

                $this->Flash->success('Roster Added Successfully', [
                  'key' => 'positive',
                  'params' => [],
                ]);
            }
            return $this->redirect(['action' => 'roster']);
        }
        $designation = TableRegistry::getTableLocator()->get('employees_designation');
        $designations = $designation
          ->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
        foreach ($designations as $key => $designation) {
            $employee = TableRegistry::getTableLocator()->get('employee');
            $employees = $employee->find()
                ->where(['employees_designation_id' => $designation['id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                  'designation_name' => "d.name",
                ])
                ->join([
                  'd' => [
                    'table' => 'employees_designation',
                    'type' => 'LEFT',
                    'conditions' => [
                      'd.id = employee.employees_designation_id '
                    ]
                  ],
                ])->toArray();
            if (count($employees) > 0) {
                $designation['employee'] = $employees;
                $employee_designation[$designation['id']] = $designation;
            }
        }
        $this->set('designations', $employee_designation);

        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
          ->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
        $this->set('shifts', $shifts);
    }

    public function editRoster($id) {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();

            $roster_names = array();
            $warning_message = 'Employee and Time Collusion With';
            $roster_employee = TableRegistry::getTableLocator()->get('hr_roster_employee');
            $roster_employees_1 = $roster_employee->find()
                ->where(['r.roster_id !=' => $id])
                ->where(['employee_id in' => $request_data['employee_id']])
                ->where(['r.start_date <=' => $request_data['start_date']])
                ->where(['r.end_date >=' => $request_data['start_date']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                  'roster_name' => "r.roster_name",
                ])
                ->join([
                  'r' => [
                    'table' => 'hr_roster',
                    'type' => 'LEFT',
                    'conditions' => [
                      'r.roster_id = hr_roster_employee.roster_id'
                    ]
                  ],
                ])->toArray();

            $roster_employees_2 = $roster_employee->find()
                ->where(['r.roster_id !=' => $id])
                ->where(['employee_id in' => $request_data['employee_id']])
                ->where(['r.start_date <=' => $request_data['end_date']])
                ->where(['r.end_date >=' => $request_data['end_date']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                  'roster_name' => "r.roster_name",
                ])
                ->join([
                  'r' => [
                    'table' => 'hr_roster',
                    'type' => 'LEFT',
                    'conditions' => [
                      'r.roster_id = hr_roster_employee.roster_id'
                    ]
                  ],
                ])->toArray();

            $roster_employees = array_merge($roster_employees_1, $roster_employees_2);

            foreach ($roster_employees as $roster_employee) {
                $roster_names[$roster_employee['roster_name']] = $roster_employee['roster_name'];
            }
            foreach ($roster_names as $roster_name) {
                $warning_message = $warning_message . ', ' . $roster_name;
            }
            $warning_message = $warning_message . '.';

            if (count($roster_names) > 0) {
                $warning_message = $warning_message . '.';
                $this->Flash->error($warning_message, [
                  'key' => 'Negative',
                  'params' => [],
                ]);
            } else {

                $roster_data['roster_name'] = $request_data['roster_name'];
                $roster_data['start_date'] = $request_data['start_date'];
                $roster_data['end_date'] = $request_data['end_date'];
                $roster_data['shift_id'] = $request_data['shift_id'];
                $roster_data['updated_by'] = $this->Auth->user('id');
                $roster_data['updated_date'] = date("Y-m-d");

                $roster = TableRegistry::getTableLocator()->get('hr_roster');
                $query = $roster->query();
                $query->update()
                  ->set($roster_data)
                  ->where(['roster_id' => $id])
                  ->execute();

                $roster_employee = TableRegistry::getTableLocator()->get('hr_roster_employee');
                $roster_employees = $roster_employee->find()
                    ->where(['r.roster_id' => $id])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->select([
                      'roster_name' => "r.roster_name",
                    ])
                    ->join([
                      'r' => [
                        'table' => 'hr_roster',
                        'type' => 'LEFT',
                        'conditions' => [
                          'r.roster_id = hr_roster_employee.roster_id'
                        ]
                      ],
                    ])->toArray();

                foreach ($roster_employees as $r_employee) {
                    $privious_ids[] = $r_employee['employee_id'];
                }
                $delete_ids = array_diff($privious_ids, $request_data['employee_id']);
                $new_ids = array_diff($request_data['employee_id'], $privious_ids);

                $roster_employee = TableRegistry::getTableLocator()->get('hr_roster_employee');
                foreach ($new_ids as $new_id) {
                    $roster_employee_data['employee_id'] = $new_id;
                    $roster_employee_data['roster_id'] = $id;
                    $query = $roster_employee->query();
                    $query->insert(['employee_id', 'roster_id'])
                      ->values($roster_employee_data)
                      ->execute();
                }
                foreach ($delete_ids as $delete_id) {
                    $query = $roster_employee->query();
                    $query->delete()
                      ->where(['roster_id' => $id])
                      ->where(['employee_id' => $delete_id])
                      ->execute();
                }
                $this->Flash->success('Roster Edited Successfully', [
                  'key' => 'positive',
                  'params' => [],
                ]);
            }
            return $this->redirect(['action' => 'roster']);
        }
        $roster = TableRegistry::getTableLocator()->get('hr_roster');
        $rosters = $roster
            ->find()
            ->where(['roster_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
              'shift_name' => "s.shift_name",
            ])
            ->join([
              's' => [
                'table' => 'hr_shift',
                'type' => 'LEFT',
                'conditions' => [
                  's.shift_id = hr_roster.shift_id'
                ]
              ]
            ])->toArray();
        $this->set('rosters', $rosters);

        $roster_employee = TableRegistry::getTableLocator()->get('hr_roster_employee');
        $roster_employees = $roster_employee
          ->find()
          ->where(['roster_id' => $id])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
        foreach ($roster_employees as $roster_employee) {
            $filter_roster[$roster_employee['employee_id']] = $roster_employee;
        }
        $designation = TableRegistry::getTableLocator()->get('employees_designation');
        $designations = $designation
          ->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
        foreach ($designations as $key => $designation) {
            $employee = TableRegistry::getTableLocator()->get('employee');
            $employees = $employee->find()
                ->where(['employees_designation_id' => $designation['id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                  'designation_name' => "d.name",
                ])
                ->join([
                  'd' => [
                    'table' => 'employees_designation',
                    'type' => 'LEFT',
                    'conditions' => [
                      'd.id = employee.employees_designation_id '
                    ]
                  ],
                ])->toArray();
            foreach ($employees as $key => $employee) {
                if (isset($filter_roster[$employee['employee_id']])) {
                    $employees[$key]['roster_id'] = $id;
                } else {
                    $employees[$key]['roster_id'] = 0;
                }
            }

            if (count($employees) > 0) {
                $designation['employee'] = $employees;
                $employee_designation[$designation['id']] = $designation;
            }
        }
        $this->set('designations', $employee_designation);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
          ->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
        $this->set('shifts', $shifts);
    }

    public function leaveAction($leave_id) {
        $data = TableRegistry::getTableLocator()->get('hr_leaves');
        $datas = $data
          ->find()
          ->where(['leave_id' => $leave_id])
          ->toArray();
        $count = null;
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (isset($request_data['half_leave'])) {
                $count = 0.5;
            } else {
                $date1 = strtotime($request_data['date_from']);
                $date2 = strtotime($request_data['date_to']);
                if ($date2 == null) {
                    $count = 1;
                } else {
                    $datediff = $date2 - $date1;
                    $count = round($datediff / 86400) + 1;
                }
            }
            if ($request_data['approval'] == "Accepted") {
                $request_data['count'] = $count;
            } else {
                $request_data['count'] = 0;
            }
            $id = $this->Auth->user('id');
            $request_data['approved_by'] = $id;
            $request_data['approved_date'] = date('Y-m-d');
            $data = TableRegistry::getTableLocator()->get('hr_leaves');
            $query = $data->query();
            $query
              ->update()
              ->set($request_data)
              ->where(['leave_id' => $leave_id])
              ->execute();

            $data = TableRegistry::getTableLocator()->get('hr_config_action_setup');
            $config = $data
              ->find()
              ->where(['config_action_setup_id' => $request_data['config_action_setup_id']])
              ->toArray();

            if ($request_data['approval'] == 'Accepted' && $datas[0]->approval != 'Accepted') {
                $hr_config_action_setup_data['value'] = $config[0]->value - $count;
            } else if ($request_data['approval'] != 'Accepted' && $datas[0]->approval == 'Accepted') {
                $hr_config_action_setup_data['value'] = $config[0]->value + $count;
            }
            if (isset($hr_config_action_setup_data)) {
                $query = $data->query();
                $query
                  ->update()
                  ->set($hr_config_action_setup_data)
                  ->where(['config_action_setup_id' => $request_data['config_action_setup_id']])
                  ->execute();
            }


//Set Flash
            $this->Flash->info('Leave Application Edited Successfully', [
              'key' => 'positive',
              'params' => [],
            ]);
            return $this->redirect(['action' => 'allLeaves']);
        }

        $this->set('datas', $datas[0]);
        $approvals[] = "Accepted";
        $approvals[] = "Declined";
        $approvals[] = "Cancelled";
        $this->set('approvals', $approvals);

        $id = $this->Auth->user('id');
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
        $this->set('leave_type', $leave_type);
    }

    public function monthlyAttendanceReport() {

        $value['month'] = null;
        $value['year'] = null;

        if ($this->request->is('post')) {
            $this->layout = 'report';
            $this->autoRender = false;
            $value = $request_data = $this->request->getData();

            //get all the day start
            $date = $request_data['year'] . '-' . ucfirst($request_data['month']);
            $first_date = date("Y-m-d", strtotime($date));
            $last_day = date("Y-m-t", strtotime($first_date));
            $datediff = strtotime($last_day) - strtotime($first_date);
            $datediff = floor($datediff / (60 * 60 * 24));
            for ($i = 0; $i < $datediff + 1; $i++) {
                $date = date("Y-m-d", strtotime($first_date . ' + ' . $i . 'day'));
                $day = strtolower(date('l', strtotime($first_date . ' + ' . $i . 'day')));
                $days[$date]['date'] = $date;
                $days[$date]['day'] = $day;
            }

            //get all the day end
            //get all the users
            $user = TableRegistry::getTableLocator()->get('users');
            $users = $user->find()
              ->enableAutoFields(true)
              ->enableHydration(false)
              ->select([
                'employee_id' => "e.employee_id",
                'sort_id' => 'e.sort_id',
              ])
              ->order(['e.sort_id' => 'ASC'])
              ->join([
                'e' => [
                  'table' => 'employee',
                  'type' => 'inner',
                  'conditions' => [
                    'e.user_id = users.id'
                  ]
                ],
              ])
              ->toArray();
            $filter_users = array();
            foreach ($users as $user) {
                $user['attendance_status']['late_in'] = 0;
                $user['attendance_status']['early_out'] = 0;
                $user['attendance_status']['proper_in'] = 0;
                $user['attendance_status']['proper_out'] = 0;
                $user['attendance'] = $days;
                $filter_users[$user['employee_id']] = $user;
            }

            $employees = $this->get_roster_with_employee($filter_users);

            //get weekend for all shift start
            $shift = TableRegistry::getTableLocator()->get('hr_shift');
            $shifts = $shift->find()
              ->enableAutoFields(true)
              ->enableHydration(false)
              ->toArray();
            $shift_weekend = array();
            foreach ($shifts as $shift) {
                $shift1 = array_filter($shift);
                $results = array_keys(array_diff($shift, $shift1));
                foreach ($results as $key => $result) {
                    $results[$key] = strstr($result, '_', true);
                    if ($results[$key] != "break") {
                        $weekend[] = $results[$key];
                    }
                }
                $weekend = array_unique($weekend);
                foreach ($weekend as $name) {
                    foreach ($days as $key2 => $day) {
                        if ($day['day'] == $name) {
                            $shift_weekend[$shift['shift_id']]['weekend'][$day['date']] = $day['date'];
                        }
                    }
                }
            }
            //get weekend for all shift end
            //get all event in this month
            $events = $this->get_all_events($first_date, $last_day);

            //set hollyday and event for every employee
            $employees = $this->set_holiday_and_event_for_attendance($employees, $events, $shift_weekend);

            $employee_attendance = TableRegistry::getTableLocator()->get('employee_attendance');
            $employee_attendances = $employee_attendance->find()
              ->where(['date >=' => $first_date])
              ->where(['date <=' => $last_day])
              ->enableAutoFields(true)
              ->enableHydration(false)
              ->toArray();
            foreach ($employee_attendances as $employee_attendance) {
                $date = date("Y-m-d", strtotime($employee_attendance['date']));
                if ($employee_attendance['in_time']) {
                    $employees[$employee_attendance['employee_id']]['attendance'][$date]['text'] = $employees[$employee_attendance['employee_id']]['attendance'][$date]['text'] . 'In: ' . $employee_attendance['in_time'] . '<br>';
                    //status 
                    if ($employee_attendance['in_status'] >= 0) {
                        $employees[$employee_attendance['employee_id']]['attendance_status']['proper_in'] = $employees[$employee_attendance['employee_id']]['attendance_status']['proper_in'] + 1;
                    } else {
                        $employees[$employee_attendance['employee_id']]['attendance_status']['late_in'] = $employees[$employee_attendance['employee_id']]['attendance_status']['late_in'] + 1;
                    }
                }
                if ($employee_attendance['minute_late'] != 0 && $employee_attendance['minute_late'] != null) {
                    $employees[$employee_attendance['employee_id']]['attendance'][$date]['text'] = $employees[$employee_attendance['employee_id']]['attendance'][$date]['text'] . 'LI: ' . $employee_attendance['minute_late'] . '<br>';
                }
                if ($employee_attendance['out_time']) {
                    $employees[$employee_attendance['employee_id']]['attendance'][$date]['text'] = $employees[$employee_attendance['employee_id']]['attendance'][$date]['text'] . 'Out: ' . $employee_attendance['out_time'] . '<br>';
                    //status
                    if ($employee_attendance['out_status'] > 0) {
                        $employees[$employee_attendance['employee_id']]['attendance_status']['early_out'] = $employees[$employee_attendance['employee_id']]['attendance_status']['early_out'] + 1;
                    } else {
                        $employees[$employee_attendance['employee_id']]['attendance_status']['proper_out'] = $employees[$employee_attendance['employee_id']]['attendance_status']['proper_out'] + 1;
                    }
                }
                if ($employee_attendance['out_status'] > 0) {
                    $employees[$employee_attendance['employee_id']]['attendance'][$date]['text'] = $employees[$employee_attendance['employee_id']]['attendance'][$date]['text'] . 'EO: ' . $employee_attendance['out_status'] . '<br>';
                }
            }
            $this->set('days', $days);
            $this->set('employees', $employees);
            $this->set('data', $value);
            $this->render('/reports/report');
        }

        $months['january'] = array('name' => 'January', 'has_access' => 0);
        $months['february'] = array('name' => 'February', 'has_access' => 0);
        $months['march'] = array('name' => 'March', 'has_access' => 0);
        $months['april'] = array('name' => 'April', 'has_access' => 0);
        $months['may'] = array('name' => 'May', 'has_access' => 0);
        $months['june'] = array('name' => 'June', 'has_access' => 0);
        $months['july'] = array('name' => 'July', 'has_access' => 0);
        $months['august'] = array('name' => 'August', 'has_access' => 0);
        $months['september'] = array('name' => 'September', 'has_access' => 0);
        $months['october'] = array('name' => 'October', 'has_access' => 0);
        $months['november'] = array('name' => 'November', 'has_access' => 0);
        $months['december'] = array('name' => 'December', 'has_access' => 0);
        $this->set('months', $months);

        $this->set('data', $value);
    }

    private function set_holiday_and_event_for_attendance($employees, $events, $shift_weekend) {
        foreach ($employees as $employee_id => $employee) {
            foreach ($employee['attendance'] as $date => $attendance) {
                $employees[$employee_id]['attendance'][$date]['text'] = null;
                if (isset($events[$date])) {
                    $employees[$employee_id]['attendance'][$date]['text'] = '<b>H.Day</b>' . '<br>';
                    $employees[$employee_id]['attendance'][$date]['event'] = 1;
                }
                $shift_id = null;
                foreach ($employee['roster'] as $roster) {
                    if ($roster['start_date'] <= $date && $roster['end_date'] >= $date) {
                        $shift_id = $roster['shift_id'];
                        $employees[$employee_id]['attendance'][$date]['shift_id'] = $shift_id;
                        break;
                    }
                }
                if ($shift_id) {
                    if (isset($shift_weekend[$shift_id]['weekend'][$date])) {
                        $employees[$employee_id]['attendance'][$date]['text'] = $employees[$employee_id]['attendance'][$date]['text'] . '<b>WKD</b><br>';
                        $employees[$employee_id]['attendance'][$date]['weekend'] = 1;
                    }
                }
            }
        }
        return $employees;
    }

    private function get_all_events($first_date, $last_day) {
        $event = TableRegistry::getTableLocator()->get('hr_events');
        $events = $event
          ->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['start_event >=' => $first_date])
          ->where(['start_event <=' => $last_day])
          ->toArray();
        foreach ($events as $key => $event) {
            unset($events[$key]);
            $events[$event['start_event']] = $event;
        }
        return $events;
    }

    private function get_roster_with_employee($users) {
        $roster_employee = TableRegistry::getTableLocator()->get('hr_roster_employee');
        $roster_employees = $roster_employee->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
              'start_date' => 'r.start_date',
              'end_date' => 'r.end_date',
              'shift_id' => "r.shift_id",
              'roster_name' => "r.roster_name",
            ])
            ->join([
              'r' => [
                'table' => 'hr_roster',
                'type' => 'LEFT',
                'conditions' => [
                  'r.roster_id = hr_roster_employee.roster_id'
                ]
              ],
            ])->toArray();

        foreach ($roster_employees as $roster_employee) {
            $users[$roster_employee['employee_id']]['roster'][] = $roster_employee;
        }
        return $users;
    }

    private function get_attendance($id, $date) {
        $employee_attendance = TableRegistry::getTableLocator()->get('employee_attendance');
        $attendances = $employee_attendance
          ->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['date in' => $date])
          ->where(['user_id' => $id])
          ->toArray();
        return $attendances;
    }

    private function get_leaves($id, $first_date, $last_day) {
        $dates['half_leave'][1]['date'] = array();
        $dates['half_leave'][2]['date'] = array();
        $dates['full_leave'] = array();
        $leave = TableRegistry::getTableLocator()->get('hr_leaves');
        $leaves = $leave->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['user_id' => $id])
          ->where(['approval' => 'Accepted'])
          ->toArray();
        foreach ($leaves as $key => $leave) {
            if ($leave['date_to'] == null) {
                if (strtotime($leave['date_from']) >= $first_date && strtotime($leave['date_from']) <= $last_day) {
                    if ($leave['half_leave'] == 1) {
                        if ($leave['half_leave_type'] == 1) {
                            $dates['half_leave'][1]['date'][] = $leave['date_from'];
                        } else {
                            $dates['half_leave'][2]['date'][] = $leave['date_from'];
                        }
                    } else {
                        $dates['full_leave'][] = $leave['date_from'];
                    }
                }
            } else {
                $startTime = strtotime($leave['date_from']);
                $endTime = strtotime($leave['date_to']);
                for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
                    if ($i >= $first_date && $i <= $last_day) {
                        $dates['full_leave'][] = date('Y-m-d', $i);
                    }
                }
            }
        }
        return $dates;
    }

    private function no_duplicate_config($id) {
        $config_key[] = 'basic_salary';
        $config_key[] = 'allowances';
        $hr_config_action_setup = TableRegistry::getTableLocator()->get('hr_config_action_setup');
        $hr_config_action_setups = $hr_config_action_setup->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['config_key  IN' => $config_key])
          ->where(['c.config_action_id  IN' => $id])
          ->select([
            'c_config_action_name' => "c.config_action_name",
            'u_name' => "u.name"
          ])
          ->join([
            'c' => [
              'table' => 'hr_config_action',
              'type' => 'INNER',
              'conditions' => [
                'c.config_action_id  = hr_config_action_setup.config_action_id'
              ]
            ],
            'u' => [
              'table' => 'users',
              'type' => 'INNER',
              'conditions' => [
                'u.id  = hr_config_action_setup.user_id'
              ]
            ],
          ])
          ->toArray();
        return $hr_config_action_setups;
    }

    private function _filter_employee_wise_data_by_month($all_config, $month) {
        $return = array();
        foreach ($all_config as $key => $val) {
            $months = json_decode($val['months']);
            if (in_array($month, $months)) {
                $return[] = $val;
            }
        }
        return $return;
    }

    private function _cheak_multiple($value, $no_duplicates, $employee) {
        foreach ($value as $key => $val) {
            $ids[] = $val['config_action_id'];
        }
        $id = array_count_values($ids);
        foreach ($no_duplicates as $no_duplicate) {
            if (isset($id[$no_duplicate['config_action_id']]) && $id[$no_duplicate['config_action_id']] > 1) {
                $hr_config_action_setup = TableRegistry::getTableLocator()->get('hr_config_action_setup');
                $hr_config_action_setups = $hr_config_action_setup->find()
                  ->enableAutoFields(true)
                  ->enableHydration(false)
                  ->where(['c.config_action_id' => $no_duplicate['config_action_id']])
                  ->select([
                    'c_config_action_name' => "c.config_action_name",
                    'u_name' => "u.name"
                  ])
                  ->join([
                    'c' => [
                      'table' => 'hr_config_action',
                      'type' => 'INNER',
                      'conditions' => [
                        'c.config_action_id  = hr_config_action_setup.config_action_id'
                      ]
                    ],
                    'u' => [
                      'table' => 'users',
                      'type' => 'INNER',
                      'conditions' => [
                        'u.id  = hr_config_action_setup.user_id'
                      ]
                    ],
                  ])
                  ->toArray();
                $message = $employee['name'] . " has multiple " . $hr_config_action_setups[0]['c_config_action_name'];
//Set Flash
                $this->Flash->error($message, [
                  'key' => 'negative',
                  'params' => [],
                ]);
                return -1;
            }
        }
        return 100;
    }

    private function get_employee_wise_config_action($config, $id, $year) {
        $hr_config_action_setup = TableRegistry::getTableLocator()->get('hr_config_action_setup');
        $hr_config_action_setups = $hr_config_action_setup->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['c.config_action_id  IN' => $config])
          ->where(['user_id' => $id])
          ->where(['year' => $year])
          ->select([
            'c_config_action_name' => "c.config_action_name",
            'u_name' => "u.name",
            'config_key' => "c.config_key",
          ])
          ->join([
            'c' => [
              'table' => 'hr_config_action',
              'type' => 'INNER',
              'conditions' => [
                'c.config_action_id  = hr_config_action_setup.config_action_id'
              ]
            ],
            'u' => [
              'table' => 'users',
              'type' => 'INNER',
              'conditions' => [
                'u.id  = hr_config_action_setup.user_id'
              ]
            ],
          ])
          ->toArray();
        return $hr_config_action_setups;
    }

    private function get_payroll_employee($data) {
        $user = TableRegistry::getTableLocator()->get('users');
        if (isset($data['full'])) {
            $users = $user->find()
              ->enableAutoFields(true)
              ->enableHydration(false)
              ->select([
                'employee_id' => "e.employee_id",
                'name' => "users.name",
                'shift_id' => "e.shift_id"
              ])
              ->join([
                'e' => [
                  'table' => 'employee',
                  'type' => 'LEFT',
                  'conditions' => [
                    'e.user_id = users.id'
                  ]
                ]
              ])
              ->toArray();
        } else if (isset($data['half'])) {
            $ids = array();
            if (isset($data['user_id'])) {
                foreach ($data['user_id'] as $user_id) {
                    $ids[] = $user_id;
                }
            }
            if (isset($data['designation'])) {
                $users_designation = $user->find()
                  ->enableAutoFields(true)
                  ->enableHydration(false)
                  ->where(['employees_designation_id  IN' => $data['designation']])
                  ->select([
                    'employee_id' => "e.employee_id",
                  ])
                  ->join([
                    'e' => [
                      'table' => 'employee',
                      'type' => 'LEFT',
                      'conditions' => [
                        'e.user_id = users.id'
                      ]
                    ]
                  ])
                  ->toArray();
                foreach ($users_designation as $designation) {
                    $ids[] = $designation['id'];
                }
            }
            $ids = array_unique($ids);
            if (!empty($ids)) {
                $users = $user->find()
                  ->enableAutoFields(true)
                  ->enableHydration(false)
                  ->where(['id  IN' => $ids])
                  ->select([
                    'employee_id' => "e.employee_id",
                    'shift_id' => "e.shift_id",
                  ])
                  ->join([
                    'e' => [
                      'table' => 'employee',
                      'type' => 'LEFT',
                      'conditions' => [
                        'e.user_id = users.id'
                      ]
                    ]
                  ])
                  ->toArray();
            } else {
                $users = null;
            }
        }

        return $users;
    }

    private function get_working_day_for_all_shift($first_date, $last_day) {
        $date1 = strtotime($first_date);
        $date2 = strtotime($last_day);
        $days_in_months = round(($date2 - $date1) / (60 * 60 * 24)) + 1;
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
        $event = TableRegistry::getTableLocator()->get('hr_events');
        $yearly_leaves = $event
          ->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['start_event >=' => $first_date])
          ->where(['start_event <=' => $last_day])
          ->toArray();
        $yearly = array();
        if (!empty($yearly_leaves)) {
            foreach ($yearly_leaves as $leaves) {
                $yearly[] = $leaves['start_event'];
            }
        }
        foreach ($shifts as $key => $shift) {
            $days = $this->get_weekend($shift);
            $shifts[$key]['weekend'] = array();
            foreach ($days as $day) {
                $startTime = strtotime($first_date);
                $endTime = strtotime($last_day);
                for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
                    $shifts[$key]['date'][] = date('Y-m-d', $i);
                    if (date('D', $i) == $day) {
                        $shifts[$key]['weekend'][] = date('Y-m-d', $i);
                    }
                }
            }
            $return[$shift['shift_id']] = array_diff($shifts[$key]['date'], $shifts[$key]['weekend']);
            $return[$shift['shift_id']] = array_diff($return[$shift['shift_id']], $yearly);
        }
        return $return;
    }

    private function get_weekend($shift) {
        $shift1 = array_filter($shift);
        $results = array_keys(array_diff($shift, $shift1));
        foreach ($results as $key => $result) {
            $results[$key] = ucfirst(substr($result, 0, 3));
            if ($results[$key] != "Bre") {
                $return[] = $results[$key];
            }
        }
        return array_unique($return);
    }

}
