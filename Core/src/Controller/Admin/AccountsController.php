<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Croogo\Core\Controller\Admin\DateTime;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

I18n::setLocale('jp_JP');

class AccountsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Security');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }

    public function index()
    {

    }

    ##==============================
    ## SHIHAB CONTROLLER STARTS
    ##==============================

    public function banks()
    {
        $data = TableRegistry::getTableLocator()->get('acc_banks');
        $bank = $data->find()->where(['deleted' => 0]);
        $paginate = $this->paginate($bank, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('banks', $paginate);
    }

    public function addBank()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $request_data['created'] = date('Y-m-d');
            $request_data['created_by'] = $this->Auth->user('id');

            $get_banks = TableRegistry::getTableLocator()->get('acc_banks');
            $query = $get_banks->query();
            $query
                ->insert(['bank_code', 'bank_name', 'bank_branch', 'bank_balance', 'bank_acc_no', 'bank_address', 'created', 'created_by'])
                ->values($request_data)
                ->execute();

            //Set Flash
            $this->Flash->success('Course Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'banks']);
        }
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->toArray();
        $this->set('banks', $banks);
    }

    public function editBank($id)
    {
        if ($this->request->is(['post'])) {
            $get_banks = TableRegistry::getTableLocator()->get('acc_banks');
            $query = $get_banks->query();
            $query
                ->update()
                ->set($this->request->getData())
                ->where(['bank_id' => $id])
                ->execute();
            //Set Flash
            $this->Flash->info('Bank Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'banks']);
        }

        $request_data = TableRegistry::getTableLocator()->get('acc_banks'); //Execute First
        $get_banks = $request_data
            ->find()
            ->where(['bank_id' => $id])
            ->toArray();
        $this->set('get_banks', $get_banks);
    }

    public function deleteBank($id)
    {
        if ($this->request->is(['post'])) {
            $array['deleted'] = 1;
            $array['deleted_by'] = $this->Auth->user('id');
            $get_banks = TableRegistry::getTableLocator()->get('acc_banks');
            $query = $get_banks->query();
            $query
                ->update()
                ->set($array)
                ->where(['bank_id' => $id])
                ->execute();
            //Set Flash
            $this->Flash->error('Bank Deleted Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'banks']);
        }

        $request_data = TableRegistry::getTableLocator()->get('acc_banks'); //Execute First
        $get_banks = $request_data
            ->find()
            ->where(['bank_id' => $id])
            ->toArray();
        $this->set('get_banks', $get_banks);
    }

    public function purposes()
    {
        $data = TableRegistry::getTableLocator()->get('acc_purposes');
        $purpose = $data->find()->where(['deleted' => 0]);
        $paginate = $this->paginate($purpose, ['limit' => $this->Paginate_limit]);
        $purpose = $paginate->toArray();
        foreach ($purpose as $key => $value) {
            if ($value['parent'] != 0) {
                $request_data = TableRegistry::getTableLocator()->get('acc_purposes'); //Execute First
                $get_purposes = $request_data
                    ->find()
                    ->where(['purpose_id' => $value['parent']])
                    ->toArray();
                $purpose[$key]['parent_name'] = $get_purposes[0]['purpose_name'];
            } else {
                $purpose[$key]['parent_name'] = null;
            }
        }
        $this->set('purposes', $paginate);
    }

    public function addPurpose()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $request_data['created'] = date('Y-m-d');
            $request_data['created_by'] = $this->Auth->user('id');
            $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
            $query = $get_purposes->query();
            $query
                ->insert(['purpose_name', 'parent', 'created', 'created_by'])
                ->values($request_data)
                ->execute();

            //Set Flash
            $this->Flash->success('Purpose Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'purposes']);
        }
        $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $purpose->find()->toArray();

        //Sorting by Alphabatically
        usort($purposes, function ($a, $b) {
            return strcmp($a['purpose_name'], $b['purpose_name']);
        });
        // Build the multi-level parent-child structure
        $options = $this->buildOptions($purposes);
        $this->set(compact('options'));
    }

    public function editPurpose($id)
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
            $query = $get_purposes->query();
            $query
                ->update()
                ->set($request_data)
                ->where(['purpose_id' => $id])
                ->execute();

            //Set Flash
            $this->Flash->info('Purpose Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'purposes']);
        }

        $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $purpose->find()->toArray();

        usort($purposes, function ($a, $b) {
            return strcmp($a['purpose_name'], $b['purpose_name']);
        });
        $options = $this->buildOptions($purposes);
        $currentPurpose = $purpose->get($id);
        $this->set(compact('options', 'currentPurpose'));
    }

    public function deletePurpose($id)
    {
        if ($this->request->is(['post'])) {
            $array['deleted'] = 1;
            $array['deleted_by'] = $this->Auth->user('id');
            $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
            $query = $get_purposes->query();
            $query
                ->update()
                ->set($array)
                ->where(['purpose_id' => $id])
                ->execute();

            //Set Flash
            $this->Flash->error('Purpose Deleted Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'purposes']);
        }
    }

    public function debitList()
    { //Modified by @akash
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (isset($request_data['bank'])) {
                $where['b.bank_id IN'] = $request_data['bank'];
            }
            if ($request_data['user_id']) {
                $where['u.id'] = $request_data['user_id'];
            }
            if ($request_data['start_date']) {
                if ($request_data['end_date']) {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                } else {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                }
                $where['transaction_date >='] = $request_data['start_date'];
                $where['transaction_date <'] = $request_data['end_date'];
            }
        }
        $where['payment_status'] = 1;
        $where['transaction_type'] = 'Debit';
        $where['acc_transactions.deleted'] = 0;
        $transactions = $this->getTransactiondetails($where);

        $this->set('transactions', $transactions);
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank
            ->find()
            ->toArray();
        $this->set('banks', $banks);
        $role = TableRegistry::getTableLocator()->get('roles');
        $roles = $role
            ->find()
            ->toArray();
        $this->set('roles', $roles);
    }

    public function addDebit()
    { //Modified by @shovon
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if ($request_data['type'] == 'Student') {
                $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
                $student_cycle = $scms_student_cycle->find()
                    ->where(['scms_students.sid' => $request_data['sid']])
                    ->where(['scms_student_cycle.session_id' => $request_data['session_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->join([
                        'scms_students' => [
                            'table' => 'scms_students', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'scms_students.student_id = scms_student_cycle.student_id',
                            ]
                        ],
                    ])->toArray();
                if (count($student_cycle) == 0) {
                    $this->Flash->success('No student found in this session', [
                        'key' => 'negative',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'addCredit']);
                } else {
                    $request_data['student_cycle_id'] = $student_cycle[0]['student_cycle_id'];
                }
            }

            ##DABIT or CREDIT on the BANK BALANCE
            $get_banks = TableRegistry::getTableLocator()->get('acc_banks');
            $bank = $get_banks->get($request_data['bank_id']);

            $newBalance = $bank->bank_balance - $request_data['amount'];
            $newAmount = (-1) * ($request_data['amount']);

            $bank->bank_balance = $newBalance;
            $get_banks->save($bank);

            $request_data['trn_no'] = $this->genarate_transaction_name();
            $request_data['user_id'] = $this->Auth->user('id');
            $request_data['amount'] = $newAmount;
            $this->saveTransaction($request_data);

            //Set Flash
            $this->Flash->success('Debit Completed Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'addDebit']);
        }
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->where(['deleted !=' => '1'])->toArray();
        $this->set('banks', $banks);
        $employee = TableRegistry::getTableLocator()->get('employee');
        $employees = $employee->find()->toArray();
        $this->set('employees', $employees);
        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions->find()->toArray();
        $this->set('sessions', $sessions);

        $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $purpose->find()->toArray();
        usort($purposes, function ($a, $b) {
            return strcmp($a['purpose_name'], $b['purpose_name']);
        });
        // Build the multi-level parent-child structure
        $options = $this->buildOptions($purposes);
        $this->set(compact('options'));

        $active_sessions = $scms_sessions
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['active' => 1])
            ->toArray();

        $months = array();
        if (count($active_sessions) && $active_sessions[0]['start_date']) {
            $first_date = date("Y-m-d", strtotime($active_sessions[0]['start_date']));
            $last_day = date("Y-m-t", strtotime($active_sessions[0]['end_date']));
            $datediff = strtotime($last_day) - strtotime($first_date);
            $datediff = floor($datediff / (60 * 60 * 24));
            $months = array();
            $month_id = array();
            for ($i = 0; $i < $datediff + 1; $i++) {
                $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['name'] = date("F", strtotime($first_date . ' + ' . $i . 'day'));
                $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['id'] = (date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1;
                $i = $i + 28;
            }
            $months = array_values($months);
        }
        $this->set('months', $months);
    }

    public function editUnpaidVouchers($id)
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $change_voucher_purposes = array();
            $new_voucher_purposes = array();
            $total_change = 0;
            $AccDiscountId = Configure::read('Acc.Discount.Id');
            foreach ($request_data['purpose_name'] as $perpose_id => $amount) {
                if ($AccDiscountId != $perpose_id && $amount < 0) {
                    $amount = 0;
                }
                if ($request_data['hidden_purpose_name'][$perpose_id] != 0 && $amount != 0 && $request_data['hidden_purpose_name'][$perpose_id] != $amount) {
                    $change_voucher_purposes[$perpose_id] = $amount - $request_data['hidden_purpose_name'][$perpose_id];
                    $total_change = $total_change + $change_voucher_purposes[$perpose_id];
                } else if ($request_data['hidden_purpose_name'][$perpose_id] != 0 && $amount == 0) {
                    $change_voucher_purposes[$perpose_id] = -$request_data['hidden_purpose_name'][$perpose_id];
                    $total_change = $total_change + $change_voucher_purposes[$perpose_id];
                } else if ($request_data['hidden_purpose_name'][$perpose_id] == 0 && $amount != 0) {
                    $new_voucher_purposes[$perpose_id] = $amount;
                    $total_change = $total_change + $new_voucher_purposes[$perpose_id];
                }
            }
            $discount_amount = 0;
            if (isset($request_data['discount_amount']) && $request_data['discount_amount'] != 0) {
                $discount_amount = $request_data['discount_amount'];
                if (isset($change_voucher_purposes[$AccDiscountId]) || $request_data['hidden_purpose_name'][$AccDiscountId] != 0) {
                    $change_voucher_purposes[$AccDiscountId] = isset($change_voucher_purposes[$AccDiscountId]) ? $change_voucher_purposes[$AccDiscountId] - $request_data['discount_amount'] : -$request_data['discount_amount'];
                } else {
                    $new_voucher_purposes[$AccDiscountId] = isset($new_voucher_purposes[$AccDiscountId]) ? $new_voucher_purposes[$AccDiscountId] - $request_data['discount_amount'] : -$request_data['discount_amount'];
                }
            }
            $vouchers_details = array_values($this->get_vouchers_details($id, array())); //get vouchers info
            $months_ids = array_reverse(array_keys($vouchers_details[0]['purpose']));
            $purpose = array_reverse($vouchers_details[0]['purpose']);
            unset($vouchers_details[0]['purpose']);
            $update_v_purposes = array();
            $new_vouchers = array();
            $delete_ids = array();
            if ($vouchers_details[0]['payment_status'] == 0) {
                $vouchers_details[0]['amount'] = array_sum($request_data['purpose_name']) - $discount_amount;
                $vouchers_details[0]['discount_amount'] = $vouchers_details[0]['discount_amount'] + $discount_amount;
                foreach ($new_voucher_purposes as $purpose_id => $amount) {
                    $new_vouchers[$purpose_id]['voucher_id'] = $id;
                    $new_vouchers[$purpose_id]['purpose_id'] = $purpose_id;
                    $new_vouchers[$purpose_id]['month_id'] = $months_ids[0];
                    $new_vouchers[$purpose_id]['amount'] = $amount;
                    $new_vouchers[$purpose_id]['payment_amount'] = 0;
                    $new_vouchers[$purpose_id]['due'] = 0;
                    $new_vouchers[$purpose_id]['paid_transaction_id'] = 0;
                    $new_vouchers[$purpose_id]['payment_status'] = 0;
                }
                foreach ($change_voucher_purposes as $purpose_id => $amount) {
                    if ($amount > 0) {
                        if (isset($purpose[0][$purpose_id])) {
                            $purpose[0][$purpose_id]['amount'] = $purpose[0][$purpose_id]['amount'] + $amount;
                            $update_v_purposes[] = $purpose[0][$purpose_id];
                        } else {
                            $new_vouchers[$purpose_id]['voucher_id'] = $id;
                            $new_vouchers[$purpose_id]['purpose_id'] = $purpose_id;
                            $new_vouchers[$purpose_id]['month_id'] = $months_ids[0];
                            $new_vouchers[$purpose_id]['amount'] = $amount;
                            $new_vouchers[$purpose_id]['payment_amount'] = 0;
                            $new_vouchers[$purpose_id]['due'] = 0;
                            $new_vouchers[$purpose_id]['paid_transaction_id'] = 0;
                            $new_vouchers[$purpose_id]['payment_status'] = 0;
                        }
                    } else {
                        $amount = $amount * -1;
                        foreach ($purpose as $key => $month_purposes) {
                            if (isset($month_purposes[$purpose_id])) {
                                $old_amount = $month_purposes[$purpose_id]['amount'];
                                $month_purposes[$purpose_id]['amount'] = ($month_purposes[$purpose_id]['amount'] - $amount) < 0 ? 0 : $month_purposes[$purpose_id]['amount'] - $amount;
                                $amount = $amount - $old_amount;
                                if ($month_purposes[$purpose_id]['amount'] == 0) {
                                    $delete_ids[] = $month_purposes[$purpose_id]['voucher_purpose_id'];
                                } else {
                                    $update_v_purposes[] = $month_purposes[$purpose_id];
                                }
                            }
                            if ($amount < 0) {
                                break;
                            }
                        }
                    }
                }
            } else {
                $new_due_amount = array_sum($request_data['purpose_name']) - $discount_amount;
                $vouchers_details[0]['amount'] = $vouchers_details[0]['amount'] + $new_due_amount - $vouchers_details[0]['due_amount'];
                $vouchers_details[0]['due_amount'] = $new_due_amount;
                $vouchers_details[0]['discount_amount'] = $vouchers_details[0]['discount_amount'] + $discount_amount;
                foreach ($new_voucher_purposes as $purpose_id => $amount) {
                    if (isset($purpose[0][$purpose_id])) {
                        $amount_change = $amount - $purpose[0][$purpose_id]['due'];
                        $purpose[0][$purpose_id]['amount'] = $purpose[0][$purpose_id]['amount'] + $amount_change;
                        $purpose[0][$purpose_id]['due'] = $purpose[0][$purpose_id]['due'] + $amount_change;
                        if ($purpose[0][$purpose_id]['due'] == 0) {
                            $purpose[0][$purpose_id]['payment_status'] = 1;
                        } else {
                            $purpose[0][$purpose_id]['payment_status'] = 2;
                        }
                        $update_v_purposes[] = $purpose[0][$purpose_id];
                    } else {
                        $new_vouchers[$purpose_id]['voucher_id'] = $id;
                        $new_vouchers[$purpose_id]['purpose_id'] = $purpose_id;
                        $new_vouchers[$purpose_id]['month_id'] = $months_ids[0];
                        $new_vouchers[$purpose_id]['amount'] = $amount;
                        $new_vouchers[$purpose_id]['payment_amount'] = 0;
                        $new_vouchers[$purpose_id]['due'] = 0;
                        $new_vouchers[$purpose_id]['paid_transaction_id'] = 0;
                        $new_vouchers[$purpose_id]['payment_status'] = 0;
                    }
                }
                foreach ($change_voucher_purposes as $purpose_id => $amount) {
                    $AccDiscountId = $AccDiscountId * 1;
                    if ($AccDiscountId == $purpose_id) {
                        if ($purpose[0][$purpose_id]['payment_status']) {
                            $purpose[0][$purpose_id]['amount'] = $purpose[0][$purpose_id]['amount'] + $amount;
                            $purpose[0][$purpose_id]['due'] = $purpose[0][$purpose_id]['due'] + $amount;
                        } else {
                            $purpose[0][$purpose_id]['amount'] = $purpose[0][$purpose_id]['amount'] + $amount;
                        }
                        $update_v_purposes[] = $purpose[0][$purpose_id];
                    } else {
                        if ($amount > 0) {
                            if (isset($purpose[0][$purpose_id])) {
                                if ($purpose[0][$purpose_id]['payment_status']) {
                                    $amount_change = $amount - $purpose[0][$purpose_id]['due'];
                                    $purpose[0][$purpose_id]['amount'] = $purpose[0][$purpose_id]['amount'] + $amount_change;
                                    $purpose[0][$purpose_id]['due'] = $purpose[0][$purpose_id]['due'] + $amount_change;
                                    $purpose[0][$purpose_id]['payment_status'] = 2;
                                } else {
                                    $purpose[0][$purpose_id]['amount'] = $purpose[0][$purpose_id]['amount'] + $amount;
                                }
                                $update_v_purposes[] = $purpose[0][$purpose_id];
                            } else {
                                $new_vouchers[$purpose_id]['voucher_id'] = $id;
                                $new_vouchers[$purpose_id]['purpose_id'] = $purpose_id;
                                $new_vouchers[$purpose_id]['month_id'] = $months_ids[0];
                                $new_vouchers[$purpose_id]['amount'] = $amount;
                                $new_vouchers[$purpose_id]['payment_amount'] = 0;
                                $new_vouchers[$purpose_id]['due'] = 0;
                                $new_vouchers[$purpose_id]['paid_transaction_id'] = 0;
                                $new_vouchers[$purpose_id]['payment_status'] = 0;
                            }
                        } else {
                            $amount = $amount * -1;
                            foreach ($purpose as $key => $month_purposes) {
                                if (isset($month_purposes[$purpose_id])) {
                                    if ($month_purposes[$purpose_id]['payment_status']) {
                                        $change_amount = ($month_purposes[$purpose_id]['due'] > $amount) ? $amount : $month_purposes[$purpose_id]['due'];
                                        $amount = $amount - $change_amount;
                                        $month_purposes[$purpose_id]['amount'] = $month_purposes[$purpose_id]['amount'] - $change_amount;
                                        $month_purposes[$purpose_id]['due'] = $month_purposes[$purpose_id]['due'] - $change_amount;
                                        if ($month_purposes[$purpose_id]['due'] == 0) {
                                            $month_purposes[$purpose_id]['payment_status'] = 1;
                                        }
                                    } else {
                                        $change_amount = ($month_purposes[$purpose_id]['amount'] > $amount) ? $amount : $month_purposes[$purpose_id]['amount'];
                                        $amount = $amount - $change_amount;
                                        $month_purposes[$purpose_id]['amount'] = $month_purposes[$purpose_id]['amount'] - $change_amount;
                                    }
                                    if ($month_purposes[$purpose_id]['amount'] == 0) {
                                        $delete_ids[] = $month_purposes[$purpose_id]['voucher_purpose_id'];
                                    } else {
                                        $update_v_purposes[] = $month_purposes[$purpose_id];
                                    }
                                }
                                if ($amount < 0) {
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
            if (count($delete_ids)) {
                $deleteQuery = $acc_voucher_purposes->query();
                $deleteQuery
                    ->delete()
                    ->where(['voucher_purpose_id IN' => $delete_ids])
                    ->execute();
            }
            if (count($new_vouchers)) {
                $new_vouchers = array_values($new_vouchers);
                $insertQuery = $acc_voucher_purposes->query();
                $columns = array_keys($new_vouchers[0]);
                $insertQuery->insert($columns);
                $insertQuery->clause('values')->values($new_vouchers);
                $insertQuery->execute();
            }
            if (count($update_v_purposes)) {
                foreach ($update_v_purposes as $update_v_purpose) {
                    $query = $acc_voucher_purposes->query();
                    $query->update()
                        ->set($update_v_purpose)
                        ->where(['voucher_purpose_id' => $update_v_purpose['voucher_purpose_id']])
                        ->execute();
                }
            }
            $acc_vouchers = TableRegistry::getTableLocator()->get('acc_vouchers');
            $query = $acc_vouchers->query();
            $query->update()
                ->set($vouchers_details[0])
                ->where(['id' => $vouchers_details[0]['id']])
                ->execute();

            $this->Flash->success('Voucher Updated Successfully', [
                'key' => 'negative',
                'params' => [],
            ]);
            $this->redirect(['action' => 'editUnpaidVouchers', $id]);
        }
        $where['id'] = $id;
        $vouchers = $this->getVouchesInfo($where);
        if ($vouchers[0]['payment_status'] == 1) {
            $this->Flash->error('Vouchers Not Found', [
                'key' => 'negative',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'unpaidVouchers']);
        }
        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $student_cycle = $scms_student_cycle->find()
            ->where(['scms_student_cycle.student_cycle_id' => $vouchers[0]['student_cycle_id']])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'name' => "scms_students.name",
                'thumbnail' => "scms_students.thumbnail",
                'level_name' => "scms_levels.level_name",
                'section_name' => "scms_sections.section_name",
                'group_name' => "scms_groups.group_name",
            ])
            ->join([
                'scms_students' => [
                    'table' => 'scms_students', // from which table data is calling
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_students.student_id = scms_student_cycle.student_id',
                    ]
                ],
                'scms_levels' => [
                    'table' => 'scms_levels', // from which table data is calling
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_levels.level_id = scms_student_cycle.level_id',
                    ]
                ],
                'scms_sections' => [
                    'table' => 'scms_sections', // from which table data is calling
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_sections.section_id = scms_student_cycle.section_id',
                    ]
                ],
                'scms_groups' => [
                    'table' => 'scms_groups', // from which table data is calling
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_groups.group_id  = scms_student_cycle.group_id',
                    ]
                ],
            ])->toArray();

        $this->set('student_cycle', $student_cycle[0]);
        $this->set('vouchers', $vouchers[0]);
        $month_ids = json_decode($vouchers[0]['month_ids']);
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->where(['deleted' => 0])->toArray();
        $this->set('banks', $banks);
        $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $purpose->find()->where(['purpose_id' => 3])->toArray();
        $this->set('purposes', $purposes);
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['session_id' => $vouchers[0]['session_id']])
            ->toArray();
        $first_date = date("Y-m-d", strtotime($sessions[0]['start_date']));
        $last_day = date("Y-m-t", strtotime($sessions[0]['end_date']));
        $datediff = strtotime($last_day) - strtotime($first_date);
        $datediff = floor($datediff / (60 * 60 * 24));
        $months = array();

        for ($i = 0; $i < $datediff + 1; $i++) {
            $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['name'] = date("F", strtotime($first_date . ' + ' . $i . 'day'));
            $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['id'] = (date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1;
            $i = $i + 28;
        }
        $months[(date("m", strtotime($first_date . ' + ' . $datediff . 'day'))) * 1]['name'] = date("F", strtotime($first_date . ' + ' . $datediff . 'day'));
        $months[(date("m", strtotime($first_date . ' + ' . $datediff . 'day'))) * 1]['id'] = (date("m", strtotime($first_date . ' + ' . $datediff . 'day'))) * 1;
        foreach ($month_ids as $month_id) {
            $months[$month_id]['select'] = 1;
        }
        $this->set('months', $months);
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
            $filter_purposes[$purpose['purpose_id']]['amount'] = 0;
        }
        $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
        $voucher_purposes = $acc_voucher_purposes
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['voucher_id' => $vouchers[0]['id']])
            ->where(['payment_status != 1'])
            ->toArray();
        $total = 0;
        foreach ($voucher_purposes as $purpose) {
            if ($purpose['payment_status'] == 2) {
                $total = $total + $purpose['due'];
                $filter_purposes[$purpose['purpose_id']]['amount'] = $filter_purposes[$purpose['purpose_id']]['amount'] + $purpose['due'];
            }
            if ($purpose['payment_status'] == 0) {
                $total = $total + $purpose['amount'];
                $filter_purposes[$purpose['purpose_id']]['amount'] = $filter_purposes[$purpose['purpose_id']]['amount'] + $purpose['amount'];
            }
        }

        $this->set('total', $total);
        $filter_purposes = array_values($filter_purposes);
        $this->set('purposes', $filter_purposes);
    }

    public function editDebit($id)
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if ($request_data['type'] == 'Student') {
                $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
                $student_cycle = $scms_student_cycle->find()
                    ->where(['scms_students.sid' => $request_data['sid']])
                    ->where(['scms_student_cycle.session_id' => $request_data['session_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->join([
                        'scms_students' => [
                            'table' => 'scms_students', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'scms_students.student_id = scms_student_cycle.student_id',
                            ]
                        ],
                    ])->toArray();
                if (count($student_cycle) == 0) {
                    $this->Flash->success('No student found in this session', [
                        'key' => 'negative',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'addCredit']);
                } else {
                    $request_data['student_cycle_id'] = $student_cycle[0]['student_cycle_id'];
                    $request_data['other'] = null;
                    $request_data['employee_id'] = null;
                }
            } else {
                $request_data['student_cycle_id'] = null;
            }
            $request_data['amount'] = $request_data['amount'] * -1;
            $acc_transaction_purposes_data['amount'] = $request_data['amount'];
            $acc_transaction_purposes_data['transaction_id'] = $request_data['transaction_id'];
            $acc_transaction_purposes_data['purpose_id'] = $request_data['purpose_id'];
            unset($request_data['purpose_id']);

            $where['transaction_type'] = 'Debit';
            $where['acc_transactions.deleted'] = 0;
            $where['acc_transactions.transaction_id'] = $request_data['transaction_id'];

            $transactions = $this->getTransaction($where);
            $change_amount = $request_data['amount'] - ($transactions[0]['amount']);

            ##DABIT or CREDIT on the BANK BALANCE
            $get_banks = TableRegistry::getTableLocator()->get('acc_banks');
            $bank = $get_banks->get($transactions[0]['bank_id']);
            $newBalance = $bank->bank_balance + $transactions[0]['amount'];
            $bank->bank_balance = $newBalance;
            $get_banks->save($bank);

            $bank = $get_banks->get($request_data['bank_id']);
            $newBalance = $bank->bank_balance - $request_data['amount'];
            $bank->bank_balance = $newBalance;
            $get_banks->save($bank);
            $month_id[0] = $request_data['month_ids'];
            $request_data['month_ids'] = json_encode($month_id);
            $acc_transactions = TableRegistry::getTableLocator()->get('acc_transactions');
            $query = $acc_transactions->query();
            $query->update()
                ->set($request_data)
                ->where(['transaction_id' => $request_data['transaction_id']])
                ->execute();
            $acc_transaction_purposes = TableRegistry::getTableLocator()->get('acc_transaction_purposes');
            $query = $acc_transaction_purposes->query();
            $query->set($acc_transaction_purposes_data)
                ->where(['transaction_id' => $request_data['transaction_id']])
                ->execute();

            //Set Flash
            $this->Flash->success('Debit Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'debitList']);
        }
        $where['transaction_type'] = 'Debit';
        $where['acc_transactions.deleted'] = 0;
        $where['acc_transactions.transaction_id'] = $id;

        $transactions = $this->getTransaction($where);
        if (count($transactions) == 0) {
            $this->Flash->error('No Debit found for edit', [
                'key' => 'negative',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'debitList']);
        }
        $month = json_decode($transactions[0]['month_ids']);
        $transactions[0]['month_ids'] = $month[0];
        $this->set('transactions', $transactions[0]);
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->where(['deleted !=' => '1'])->toArray();
        $this->set('banks', $banks);
        $employee = TableRegistry::getTableLocator()->get('employee');
        $employees = $employee->find()->toArray();
        $this->set('employees', $employees);
        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions->find()->toArray();
        $this->set('sessions', $sessions);

        $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $purpose->find()->toArray();
        usort($purposes, function ($a, $b) {
            return strcmp($a['purpose_name'], $b['purpose_name']);
        });
        // Build the multi-level parent-child structure
        $options = $this->buildOptions($purposes);
        $this->set(compact('options'));

        $active_sessions = $scms_sessions
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['active' => 1])
            ->toArray();

        $months = array();
        if (count($active_sessions) && $active_sessions[0]['start_date']) {
            $first_date = date("Y-m-d", strtotime($active_sessions[0]['start_date']));
            $last_day = date("Y-m-t", strtotime($active_sessions[0]['end_date']));
            $datediff = strtotime($last_day) - strtotime($first_date);
            $datediff = floor($datediff / (60 * 60 * 24));
            $months = array();
            $month_id = array();
            for ($i = 0; $i < $datediff + 1; $i++) {
                $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['name'] = date("F", strtotime($first_date . ' + ' . $i . 'day'));
                $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['id'] = (date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1;
                $i = $i + 28;
            }
            $months = array_values($months);
        }
        $this->set('months', $months);
    }

    private function getTransaction($where)
    {
        $data = TableRegistry::getTableLocator()->get('acc_transactions');
        $transactions = $data->find()->where($where)
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'purpose_id' => "acc_transaction_purposes.purpose_id",
            ])
            ->group('acc_transactions.transaction_id')
            ->order(['acc_transactions.transaction_id' => 'DESC'])
            ->join([
                'acc_transaction_purposes' => [
                    'table' => 'acc_transaction_purposes',
                    'type' => 'LEFT',
                    'conditions' => [
                        'acc_transaction_purposes.transaction_id = acc_transactions.transaction_id'
                    ]
                ],
            ])->toArray();
        return $transactions;
    }

    private function saveTransaction($request_data)
    {
        $acc_transactions[0] = $request_data;
        unset($acc_transactions[0]['purpose_id']);
        unset($acc_transactions[0]['month_id']);
        $acc_transactions[0]['payment_status'] = 1;
        $month[0] = $request_data['month_id'];
        $acc_transactions[0]['month_ids'] = json_encode($month);

        $acc_transactions_columns = array_keys($acc_transactions[0]);
        $get_transaction = TableRegistry::getTableLocator()->get('acc_transactions');
        $query = $get_transaction->query();
        $query
            ->insert($acc_transactions_columns)
            ->values($acc_transactions[0])
            ->execute();

        $transaction_record = $get_transaction->find()->last(); //get the last student_cycle_id
        $transaction_id = $transaction_record->transaction_id;
        $data_purpose[0]['transaction_id'] = $transaction_id;
        $data_purpose[0]['purpose_id'] = $request_data['purpose_id'];
        $data_purpose[0]['month_id'] = $request_data['month_id'];
        $data_purpose[0]['amount'] = $request_data['amount'];
        $data_purpose[0]['created'] = $request_data['transaction_date'];

        if (count($data_purpose) > 0) {
            $acc_transaction_purposes = TableRegistry::getTableLocator()->get('acc_transaction_purposes');
            $insertQuery = $acc_transaction_purposes->query();
            $columns = array_keys($data_purpose[0]);
            $insertQuery->insert($columns);
            $insertQuery->clause('values')->values($data_purpose);
            $insertQuery->execute();
        }
        return $transaction_id;
    }

    public function creditList()
    { //Modified by @akash
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (isset($request_data['bank'])) {
                $where['acc_banks.bank_id IN'] = $request_data['bank'];
            }
            if ($request_data['user_id']) {
                $where['received.id'] = $request_data['user_id'];
            }
            if ($request_data['start_date']) {
                if ($request_data['end_date']) {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                } else {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                }
                $where['transaction_date >='] = $request_data['start_date'];
                $where['transaction_date <'] = $request_data['end_date'];
            }
        }
        $where['payment_status'] = 1;
        $where['transaction_type'] = 'Credit';
        $where['acc_transactions.deleted'] = 0;
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (!in_array($role_id, $roles)) {
            $id = $this->Auth->user('id');
            $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $permissions = $employees_permission->find()
                ->where(['user_id' => $id])
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
            $section_ids = array();
            foreach ($permissions as $permission) {
                $section_ids[$permission['section_id']] = $permission['section_id'];
            }
            if (count($section_ids)) {
                $section_ids = array_values($section_ids);
                $where['scms_student_cycle.section_id IN'] = $section_ids;
            } else {
                $where['scms_student_cycle.section_id'] = -1;
            }
        }
        $transactions = $this->getTransactiondetails($where);
        $this->set('transactions', $transactions);
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank
            ->find()
            ->toArray();
        $this->set('banks', $banks);
        $role = TableRegistry::getTableLocator()->get('roles');
        $roles = $role
            ->find()
            ->toArray();
        $this->set('roles', $roles);
    }
    public function addVoucher()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $where['scms_student_cycle.session_id'] = $request_data['session_id'];

            if ($request_data['level_id']) {
                $where['scms_student_cycle.level_id'] = $request_data['level_id'];
            }
            if ($request_data['section_id']) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if ($request_data['sid']) {
                $where['scms_students.sid'] = $request_data['sid'];
            }

            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $student_cycle = $scms_student_cycle->find()
                ->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'sid' => "scms_students.sid"
                ])
                ->join([
                    'scms_students' => [
                        'table' => 'scms_students', // from which table data is calling
                        'type' => 'LEFT',
                        'conditions' => [
                            'scms_students.student_id = scms_student_cycle.student_id',
                            'scms_students.level_id = scms_student_cycle.level_id',
                        ]
                    ],
                ])->toArray();
            if (count($student_cycle) == 0) {
                $this->Flash->success('No student found in this session', [
                    'key' => 'negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'addVoucher']);
            }
            $request_data['level_id'] = $student_cycle[0]['level_id'];
            $request_data['voucher_create_by'] = $this->Auth->user('id');
            $request_data['acc_voucher_create_log_id'] = 0;
            $month[] = $request_data['month_id'];
            $request_data['month_ids'] = json_encode($month);
            $voucher_purposes_data['purpose_id'] = $request_data['purpose_id'];
            $voucher_purposes_data['month_id'] = $request_data['month_id'];
            $voucher_purposes_data['amount'] = $request_data['amount'];

            unset($request_data['month_id']);
            unset($request_data['purpose_id']);
            unset($request_data['level_id']);
            unset($request_data['section_id']);
            unset($request_data['sid']);
            $acc_vouchers = TableRegistry::getTableLocator()->get('acc_vouchers');
            foreach ($student_cycle as $cycle) {
                $request_data['voucher_no'] = $this->genarate_vouchers_name();
                $request_data['student_cycle_id'] = $cycle['student_cycle_id'];
                $request_data['sid'] = $cycle['sid'];
                $request_data['level_id'] = $cycle['level_id'];
                $save_data[0] = $request_data;
                $insert = $acc_vouchers->query();
                $columns = array_keys($request_data);
                $insert->insert($columns);
                $insert->clause('values')->values($save_data);
                $insert->execute();
                $myrecords = $acc_vouchers->find()->last();
                $voucher_purposes_data['voucher_id'] = $myrecords->id;
                $save_voucher_purposes_data[] = $voucher_purposes_data;
            }
            $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
            $insert = $acc_voucher_purposes->query();
            $columns = array_keys($save_voucher_purposes_data[0]);
            $insert->insert($columns);
            $insert->clause('values')->values($save_voucher_purposes_data);
            $insert->execute();

            $this->Flash->success('Voucher Created Successfully', [
                'key' => 'negative',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'addVoucher']);

        }
        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->toArray();
        $this->set('levels', $levels);

        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions->find()->toArray();
        $this->set('sessions', $sessions);

        $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $purpose->find()->toArray();
        usort($purposes, function ($a, $b) {
            return strcmp($a['purpose_name'], $b['purpose_name']);
        });
        // Build the multi-level parent-child structure
        $options = $this->buildOptions($purposes);
        $this->set(compact('options'));

        $active_sessions = $scms_sessions
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['active' => 1])
            ->toArray();

        $months = array();
        if (count($active_sessions) && $active_sessions[0]['start_date']) {
            $first_date = date("Y-m-d", strtotime($active_sessions[0]['start_date']));
            $last_day = date("Y-m-t", strtotime($active_sessions[0]['end_date']));
            $datediff = strtotime($last_day) - strtotime($first_date);
            $datediff = floor($datediff / (60 * 60 * 24));
            $months = array();
            $month_id = array();
            for ($i = 0; $i < $datediff + 1; $i++) {
                $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['name'] = date("F", strtotime($first_date . ' + ' . $i . 'day'));
                $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['id'] = (date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1;
                $i = $i + 28;
            }
            $months = array_values($months);
        }
        $this->set('months', $months);
    }
    public function addCredit()
    { //Modified by @shovon
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if ($request_data['type'] == 'Student') {
                $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
                $student_cycle = $scms_student_cycle->find()
                    ->where(['scms_students.sid' => $request_data['sid']])
                    ->where(['scms_student_cycle.session_id' => $request_data['session_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->join([
                        'scms_students' => [
                            'table' => 'scms_students', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'scms_students.student_id = scms_student_cycle.student_id',
                            ]
                        ],
                    ])->toArray();
                if (count($student_cycle) == 0) {
                    $this->Flash->success('No student found in this session', [
                        'key' => 'negative',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'addCredit']);
                } else {
                    $request_data['student_cycle_id'] = $student_cycle[0]['student_cycle_id'];
                    $request_data['level_id'] = $student_cycle[0]['level_id'];
                }
            }
            ##DABIT or CREDIT on the BANK BALANCE
            $get_banks = TableRegistry::getTableLocator()->get('acc_banks');
            $bank = $get_banks->get($request_data['bank_id']);

            $newBalance = $bank->bank_balance + $request_data['amount'];
            $newAmount = $request_data['amount'];

            $bank->bank_balance = $newBalance;
            $get_banks->save($bank);
            $request_data['trn_no'] = $this->genarate_transaction_name();
            $request_data['user_id'] = $this->Auth->user('id');
            $request_data['amount'] = $newAmount;
            $transaction_id = $this->saveTransaction($request_data);

            $this->redirect(['action' => 'moneyRecpit', $transaction_id]);
        }
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->where(['deleted !=' => '1'])->toArray();
        $this->set('banks', $banks);
        $employee = TableRegistry::getTableLocator()->get('employee');
        $employees = $employee->find()->toArray();
        $this->set('employees', $employees);
        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions->find()->toArray();
        $this->set('sessions', $sessions);

        $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $purpose->find()->toArray();
        usort($purposes, function ($a, $b) {
            return strcmp($a['purpose_name'], $b['purpose_name']);
        });
        // Build the multi-level parent-child structure
        $options = $this->buildOptions($purposes);
        $this->set(compact('options'));

        $active_sessions = $scms_sessions
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['active' => 1])
            ->toArray();

        $months = array();
        if (count($active_sessions) && $active_sessions[0]['start_date']) {
            $first_date = date("Y-m-d", strtotime($active_sessions[0]['start_date']));
            $last_day = date("Y-m-t", strtotime($active_sessions[0]['end_date']));
            $datediff = strtotime($last_day) - strtotime($first_date);
            $datediff = floor($datediff / (60 * 60 * 24));
            $months = array();
            $month_id = array();
            for ($i = 0; $i < $datediff + 1; $i++) {
                $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['name'] = date("F", strtotime($first_date . ' + ' . $i . 'day'));
                $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['id'] = (date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1;
                $i = $i + 28;
            }
            $months = array_values($months);
        }
        $this->set('months', $months);
    }

    public function editTransaction($id)
    { //Modified by @shovon
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $get_transaction = TableRegistry::getTableLocator()->get('acc_transactions');
            $result = $get_transaction
                ->find()
                ->where(['transaction_id' => $id])
                ->toArray();

            if ($request_data['transaction_type'] == 'Debit') {
                $newAmount = (-1) * ($request_data['amount']);
            } else {
                $newAmount = $request_data['amount'];
            }
            $request_data_new['transaction_date'] = $request_data['transaction_date'];
            $request_data_new['transaction_type'] = $request_data['transaction_type'];
            $request_data_new['bank_id'] = $request_data['bank_id'];
            $request_data_new['amount'] = $newAmount;
            $request_data_new['note'] = $request_data['note'];

            // Update the transaction data
            $update_data = TableRegistry::getTableLocator()->get('acc_transactions');
            $query = $update_data->query();
            $query->update()
                ->set($request_data_new)
                ->where(['transaction_id' => $id])
                ->execute();

            if (!empty($request_data)) {
                $purpose_data['transaction_id'] = $result[0]['transaction_id'];
                $purpose_data['purpose_id'] = $request_data['purpose_id'];
                $purpose_data['modified'] = date("Y-m-d H:i:s", time() + 6 * 3600);
                $purpose_data['amount'] = $request_data['amount'];
                $purpose = TableRegistry::getTableLocator()->get('acc_transaction_purposes');
                $query = $purpose->query();
                $query->update()
                    ->set($purpose_data)
                    ->where(['transaction_id' => $purpose_data['transaction_id']])
                    ->execute();
            }
            // Update the bank balance
            $get_banks = TableRegistry::getTableLocator()->get('acc_banks');
            $bank = $get_banks->get($request_data['bank_id']);

            if ($request_data['transaction_type'] == 'Debit') {
                $newBalance = $bank->bank_balance - $request_data['amount'];
            } elseif ($request_data['transaction_type'] == 'Credit') {
                $newBalance = $bank->bank_balance + $request_data['amount'];
            } else {
                $newBalance = $bank->bank_balance;
            }

            $bank->bank_balance = $newBalance;
            $get_banks->save($bank);

            // Set Flash
            $this->Flash->info('Transaction Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);

            return $this->redirect(['action' => 'transactions']);
        }

        $get_transaction = TableRegistry::getTableLocator()->get('acc_transactions'); //Execute First
        $transactions = $get_transaction
            ->find()
            ->where(['transaction_id' => $id])
            ->toArray();

        $this->set('get_transaction', $transactions);
        $get_purpose = TableRegistry::getTableLocator()->get('acc_transaction_purposes'); //Execute First
        $get_purposes = $get_purpose
            ->find()
            ->where(['transaction_id' => $transactions[0]['transaction_id']])
            ->toArray();
        $p_id = $get_purposes[0]['purpose_id'];
        $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $purpose->find()->toArray();

        usort($purposes, function ($a, $b) {
            return strcmp($a['purpose_name'], $b['purpose_name']);
        });
        $options = $this->buildOptions($purposes);
        $currentPurpose = $purpose->get($p_id);
        $this->set(compact('options', 'currentPurpose'));

        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->where(['deleted !=' => '1'])->toArray();
        $this->set('banks', $banks);
    }

    public function deleteTransaction($id)
    {
        $acc_transactions = TableRegistry::getTableLocator()->get('acc_transactions');
        $deleteTransaction = $acc_transactions
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['transaction_id' => $id])
            ->where(['deleted' => 0])
            ->toArray();
        if (count($deleteTransaction) == 0) {
            $this->Flash->error('No Credit Found', [
                'key' => 'negative',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'creditList']);
        }
        $array['deleted'] = 1;
        $array['deleted_by'] = $this->Auth->user('id');

        if ($deleteTransaction[0]['type'] == 'school_fees') {
            $where['payment_status !='] = 0;
            $vouchers_details = $this->get_vouchers_details(json_decode($deleteTransaction[0]['voucher_ids']), $where); //get vouchers info
            $acc_transaction_purposes = TableRegistry::getTableLocator()->get('acc_transaction_purposes');
            $transaction_purposes = $acc_transaction_purposes
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['transaction_id' => $id])
                ->toArray();
            $deleted_voucher_purpose_ids = array();
            $update_voucher_purpose_data = array();
            $AccDiscountId = Configure::read('Acc.Discount.Id');
            foreach ($transaction_purposes as $transaction_purpose) {
                $vouchers[$transaction_purpose['voucher_id']] = $vouchers_details[$transaction_purpose['voucher_id']];
                unset($vouchers[$transaction_purpose['voucher_id']]['purpose']);
            }
            foreach ($transaction_purposes as $transaction_purpose) {
                if (isset($vouchers_details[$transaction_purpose['voucher_id']]['purpose'][$transaction_purpose['month_id']][$transaction_purpose['purpose_id']])) {
                    $v_purpose = $vouchers_details[$transaction_purpose['voucher_id']]['purpose'][$transaction_purpose['month_id']][$transaction_purpose['purpose_id']];
                    if ($v_purpose['amount'] == 0) {
                        if ($v_purpose['payment_amount'] == $transaction_purpose['amount']) {
                            $deleted_voucher_purpose_ids[] = $v_purpose['voucher_purpose_id'];
                        } else {
                            $v_purpose['payment_amount'] = $v_purpose['payment_amount'] - $transaction_purpose['amount'];
                        }

                        if ($v_purpose['purpose_id'] == $AccDiscountId) {
                            $vouchers[$transaction_purpose['voucher_id']]['payment_amount'] = $vouchers[$transaction_purpose['voucher_id']]['payment_amount'] - $transaction_purpose['amount'];
                            $vouchers[$transaction_purpose['voucher_id']]['discount_amount'] = $vouchers[$transaction_purpose['voucher_id']]['discount_amount'] + $transaction_purpose['amount'];
                        } else {
                            $vouchers[$transaction_purpose['voucher_id']]['payment_amount'] = $vouchers[$transaction_purpose['voucher_id']]['payment_amount'] - $transaction_purpose['amount'];
                        }
                    } else {
                        if ($v_purpose['purpose_id'] == $AccDiscountId) {
                            $vouchers[$transaction_purpose['voucher_id']]['discount_amount'] = $vouchers[$transaction_purpose['voucher_id']]['discount_amount'] + $transaction_purpose['amount'] - $v_purpose['amount'];
                        } else {
                            $v_purpose['payment_amount'] = $v_purpose['payment_amount'] - $transaction_purpose['amount'];
                            $v_purpose['due'] = $v_purpose['due'] + ($transaction_purpose['amount'] - $v_purpose['amount']) > 0 ? $transaction_purpose['amount'] : $v_purpose['amount'];
                            $v_purpose['payment_status'] = $v_purpose['due'] > 0 ? 2 : 1;
                            $vouchers[$transaction_purpose['voucher_id']]['payment_amount'] = $vouchers[$transaction_purpose['voucher_id']]['payment_amount'] - $transaction_purpose['amount'];
                        }
                    }
                    $update_voucher_purpose_data[] = $v_purpose;
                }
            }
            $total_due = array();
            $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
            foreach ($update_voucher_purpose_data as $update_voucher_purpose) {
                if ($update_voucher_purpose['amount']) {
                    $update_voucher_purpose['due'] = $update_voucher_purpose['due'] - $update_voucher_purpose['payment_amount'];
                    $total_due[$update_voucher_purpose['voucher_id']] = isset($total_due[$update_voucher_purpose['voucher_id']]) ? $total_due[$update_voucher_purpose['voucher_id']] + $update_voucher_purpose['due'] : $update_voucher_purpose['due'];
                }
                $query = $acc_voucher_purposes->query();
                $query->update()
                    ->set($update_voucher_purpose)
                    ->where(['voucher_purpose_id' => $update_voucher_purpose['voucher_purpose_id']])
                    ->execute();
            }

            $acc_vouchers = TableRegistry::getTableLocator()->get('acc_vouchers');
            foreach ($vouchers as $voucher) {
                if (isset($total_due[$voucher['id']])) {
                    $voucher['due_amount'] = $total_due[$voucher['id']];
                    if ($voucher['due_amount']) {
                        $voucher['payment_status'] = 2;
                    }
                }
                $query = $acc_vouchers->query();
                $query->update()
                    ->set($voucher)
                    ->where(['id' => $voucher['id']])
                    ->execute();
            }
            if (count($deleted_voucher_purpose_ids)) {
                $deleteQuery = $acc_voucher_purposes->query();
                $deleteQuery
                    ->delete()
                    ->where(['voucher_purpose_id IN' => $deleted_voucher_purpose_ids])
                    ->execute();
            }
        }
        //Bank Balance Update with Deletion
        $get_banks = TableRegistry::getTableLocator()->get('acc_banks');
        $bank = $get_banks->get($deleteTransaction[0]['bank_id']);
        if ($deleteTransaction[0]['transaction_type'] == 'Debit') {
            $newBalance = $bank->bank_balance + $deleteTransaction['amount'];
        } elseif ($deleteTransaction[0]['transaction_type'] == 'Credit') {
            $newBalance = $bank->bank_balance - $deleteTransaction[0]['amount'];
        } else {
            $newBalance = $bank->bank_balance;
        }
        $bank->bank_balance = $newBalance;
        $get_banks->save($bank);
        $query = $acc_transactions->query();
        $query->update()
            ->set($array)
            ->where(['transaction_id' => $id])
            ->execute();
        //Set Flash
        if ($deleteTransaction[0]['transaction_type'] == 'Debit') {
            $this->Flash->error('Debit Deleted Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'debitList']);
        } elseif ($deleteTransaction[0]['transaction_type'] == 'Credit') {
            $this->Flash->error('Credit Deleted Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'creditList']);
        }
    }

    private function buildOptions($data, $parentId = null, $prefix = '')
    {
        $options = [];

        foreach ($data as $row) {
            if ($row['parent'] == $parentId) {
                $options[$row['purpose_id']] = $prefix . $row['purpose_name'];

                // Recursively build child options
                $childOptions = $this->buildOptions($data, $row['purpose_id'], $prefix . '  -- ');

                if (!empty($childOptions)) {
                    $options += $childOptions;
                }
            }
        }
        return $options;
    }

    public function deletedBanks()
    {
        $data = TableRegistry::getTableLocator()->get('acc_banks');
        $bank = $data->find()->where(['deleted' => 1]);
        $paginate = $this->paginate($bank, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('banks', $paginate);
    }

    public function deletedPurposes()
    {
        $data = TableRegistry::getTableLocator()->get('acc_purposes');
        $purpose = $data->find()->where(['deleted' => 1]);
        $paginate = $this->paginate($purpose, ['limit' => $this->Paginate_limit]);
        $purpose = $paginate->toArray();
        foreach ($purpose as $key => $value) {
            if ($value['parent'] != 0) {
                $request_data = TableRegistry::getTableLocator()->get('acc_purposes'); //Execute First
                $get_purposes = $request_data
                    ->find()
                    ->where(['purpose_id' => $value['parent']])
                    ->toArray();
                $purpose[$key]['parent_name'] = $get_purposes[0]['purpose_name'];
            } else {
                $purpose[$key]['parent_name'] = null;
            }
        }

        $this->set('purposes', $paginate);
    }

    public function deletedTransactions()
    {
        $where['acc_transactions.deleted'] = 1;
        $transactions = $this->getTransactiondetails($where);
        $this->set('transactions', $transactions);
    }

    public function restoreBanks($id)
    {
        if ($this->request->is(['post'])) {
            $array['deleted'] = 0;
            $get_banks = TableRegistry::getTableLocator()->get('acc_banks');
            $query = $get_banks->query();
            $query
                ->update()
                ->set($array)
                ->where(['bank_id' => $id])
                ->execute();
            //Set Flash
            $this->Flash->warning('Bank Restored Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'banks']);
        }
    }

    public function restorePurposes($id)
    {
        if ($this->request->is(['post'])) {
            $array['deleted'] = 0;
            $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
            $query = $get_purposes->query();
            $query = $query
                ->update()
                ->set($array)
                ->where(['purpose_id' => $id])
                ->execute();
            //Set Flash
            $this->Flash->warning('Purpose Restored Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'purposes']);
        }
    }

    ## FEES KHAT PORTION ##

    public function additionalFees()
    {
        $get_additionals = TableRegistry::getTableLocator()->get('acc_additional_fees');
        $additionals = $get_additionals->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'p_purpose_name' => "p.purpose_name"
            ])
            ->join([
                'p' => [
                    'table' => 'acc_purposes', // from which table data is calling
                    'type' => 'INNER',
                    'conditions' => [
                        'p.purpose_id = acc_additional_fees.purpose_id' // in which table data is matching
                    ]
                ],
            ]);
        $paginate = $this->paginate($additionals, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('additionals', $paginate);
    }

    public function addAdditionalFees()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();

            $get_additionals = TableRegistry::getTableLocator()->get('acc_additional_fees');
            $query = $get_additionals->query();
            $query
                ->insert(['fees_title', 'value', 'purpose_id'])
                ->values($request_data)
                ->execute();

            //Set Flash
            $this->Flash->success('Additionals Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'additionalFees']);
        }
        $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $get_purposes->find()->enableAutoFields(true)->enableHydration(false)->where(['parent' => 3])->toArray();
        $this->set('options', $purposes);
    }

    public function editAdditionalFees($id)
    {
        if ($this->request->is(['post'])) {
            $get_additionals = TableRegistry::getTableLocator()->get('acc_additional_fees');
            $query = $get_additionals->query();

            $query
                ->update()
                ->set($this->request->getData())
                ->where(['id' => $id])
                ->execute();

            //Set Flash
            $this->Flash->info('Additionals Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'additionalFees']);
        }
        $get_additionals = TableRegistry::getTableLocator()->get('acc_additional_fees');
        $additionals = $get_additionals->find()->toArray();
        $this->set('additionals', $additionals[0]);

        $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $get_purposes->find()->enableAutoFields(true)->enableHydration(false)->where(['parent' => 3])->toArray();
        $this->set('options', $purposes);
        $this->insert_delete_update_log('Accounts', 'editAdditionalFees', 'update', json_encode($additionals[0]));
    }

    ##ADDITIONAL FEES CYCLE GENERATE

    public function generateAdditionalFees()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();

            if (isset($request_data['user_id'])) {
                $fees_value = array_filter($request_data['fees_value']);
                $student_additional_fees = TableRegistry::getTableLocator()->get('acc_student_additional_fees_cycle');
                $add_where['session_id'] = $request_data['session_id'];
                $add_where['level_id'] = $request_data['level_id'];
                $add_where['month_id'] = $request_data['month_id'];
                $add_where['additional_fees_id'] = $request_data['additional_fees_id'];

                $additional_fees_cycle_id = $this->check_and_update_additional_fees_cycle($add_where, $delete = 1);

                $acc_student_additional_fees_cycle = [];
                foreach ($fees_value as $key => $fees) {
                    $single_acc_student_additional_fees_cycle['additional_fees_cycle_id'] = $additional_fees_cycle_id;
                    $single_acc_student_additional_fees_cycle['student_cycle_id'] = $key;
                    $single_acc_student_additional_fees_cycle['fees_value'] = $fees;
                    $acc_student_additional_fees_cycle[] = $single_acc_student_additional_fees_cycle;
                }
                if (count($acc_student_additional_fees_cycle) > 0) {
                    $insertQueryStudent_additional_fees = $student_additional_fees->query();
                    $student_additional_fees_cycle_columns = array_keys($acc_student_additional_fees_cycle[0]);
                    $insertQueryStudent_additional_fees->insert($student_additional_fees_cycle_columns);
                    $insertQueryStudent_additional_fees->clause('values')->values($acc_student_additional_fees_cycle);
                    $insertQueryStudent_additional_fees->execute();
                }

                $this->Flash->info('Additional Fees Generated Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'generateAdditionalFees']);
            } else {
                $where['scms_student_cycle.session_id'] = $request_data['session_id'];
                $where['scms_student_cycle.level_id'] = $request_data['level_id'];

                $query2['additionals_fees.month_id'] = $request_data['month_id'];
                $query2['additionals_fees.level_id'] = $request_data['level_id'];
                $query2['additionals_fees.session_id'] = $request_data['session_id'];
                $query2['additionals_fees.additional_fees_id'] = $request_data['additional_fees_id'];

                $students = $this->searchAdditionals($where, $query2);

                $get_additionals = TableRegistry::getTableLocator()->get('acc_additional_fees');
                $additionals = $get_additionals->find()->where(['id' => $request_data['additional_fees_id']])->toArray();
                foreach ($students as $key => $student) {
                    $students[$key]['additional_fees_id'] = $additionals[0]['additional_fees_id'];
                    $students[$key]['fees_value'] = $additionals[0]['value'];
                }
                $this->set('students', $students);
                $this->set('month_id', $request_data['month_id']);
                $this->set('session_id', $request_data['session_id']);
                $this->set('level_id', $request_data['level_id']);
                $this->set('user_id', $this->Auth->user('id'));
                $this->set('additional_fees_id', $request_data['additional_fees_id']);
            }
        }

        $get_additionals = TableRegistry::getTableLocator()->get('acc_additional_fees');
        $additionals = $get_additionals->find()->toArray();
        $this->set('additionals', $additionals);

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

        $month = TableRegistry::getTableLocator()->get('acc_months');
        $months = $month
            ->find()
            ->toArray();
        $this->set('months', $months);
    }

    private function check_and_update_additional_fees_cycle($where, $delete)
    {
        $additionalFeesCycle = TableRegistry::getTableLocator()->get('acc_additional_fees_cycle');
        $student_additional_fees = TableRegistry::getTableLocator()->get('acc_student_additional_fees_cycle');
        $matchCheck = $additionalFeesCycle->find();
        $matchCheck->where($where);
        $hasRecord = $matchCheck->first();
        if ($hasRecord) {
            $additional_fees_cycle_id = $hasRecord->id;
            if ($delete) {
                $deleteQuery = $student_additional_fees->query();
                $deleteQuery
                    ->delete()
                    ->where(['additional_fees_cycle_id' => $additional_fees_cycle_id])
                    ->execute();
            }
        } else {
            $query = $additionalFeesCycle->query();
            $query
                ->insert(['session_id', 'level_id', 'additional_fees_id', 'month_id'])
                ->values($where)
                ->execute();

            $myrecords = $additionalFeesCycle->find()->last();
            $additional_fees_cycle_id = $myrecords->id;
        }
        return $additional_fees_cycle_id;
    }

    public function individualFees()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if (isset($request_data['student_cycle_id'])) {
                $student_additional_fees = TableRegistry::getTableLocator()->get('acc_student_additional_fees_cycle');
                $acc_student_additional_fees_cycle = TableRegistry::getTableLocator()->get('acc_student_additional_fees_cycle');
                $student_additional_fees_cycle_data = array();
                foreach ($request_data['fees_value'] as $month_id => $additional_values) {
                    foreach ($additional_values as $additional_fees_id => $additional_value) {
                        if ($additional_value) {
                            $where['session_id'] = $request_data['session_id'];
                            $where['level_id'] = $request_data['level_id'];
                            $where['month_id'] = $month_id;
                            $where['additional_fees_id'] = $additional_fees_id;
                            $additional_fees_cycle_id = $this->check_and_update_additional_fees_cycle($where, $delete = 0);
                            $student_additional_fees_cycle = $acc_student_additional_fees_cycle->find()
                                ->enableAutoFields(true)
                                ->enableHydration(false)
                                ->where(['additional_fees_cycle_id' => $additional_fees_cycle_id])
                                ->where(['student_cycle_id' => $request_data['student_cycle_id']])
                                ->toArray();
                            if (count($student_additional_fees_cycle)) {
                                $query = $acc_student_additional_fees_cycle->query();
                                $value['fees_value'] = $additional_value;
                                $query->update()->set($value)->where(['id' => $student_additional_fees_cycle[0]['id']])->execute();
                            } else {
                                $student_additional_fees_cycle_data_single['additional_fees_cycle_id'] = $additional_fees_cycle_id;
                                $student_additional_fees_cycle_data_single['student_cycle_id'] = $request_data['student_cycle_id'];
                                $student_additional_fees_cycle_data_single['fees_value'] = $additional_value;
                                $student_additional_fees_cycle_data[] = $student_additional_fees_cycle_data_single;
                            }
                        }
                    }
                }
                if (count($student_additional_fees_cycle_data) > 0) {
                    $insertQuery = $acc_student_additional_fees_cycle->query();
                    $columns = array_keys($student_additional_fees_cycle_data[0]);
                    $insertQuery->insert($columns);
                    $insertQuery->clause('values')->values($student_additional_fees_cycle_data);
                    $insertQuery->execute();
                }

                $this->Flash->success('Individual Additional Fees Upadted Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'individualFees']);
            } else {
                $where['scms_student_cycle.session_id'] = $request_data['session_id'];
                $where['scms_student_cycle.level_id'] = $request_data['level_id'];
                $where['sid'] = $request_data['sid'];
                $student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
                $students = $student_cycle->find()->enableAutoFields(true)->enableHydration(false)->select([
                    'student_name' => 'sc.name',
                    'section_name' => 'scms_sections.section_name',
                    'level_name' => 'scms_levels.level_name',
                    'sid' => 'sc.sid',
                ])->join([
                            'sc' => [
                                'table' => 'scms_students',
                                'type' => 'INNER',
                                'conditions' => [
                                    'sc.student_id = scms_student_cycle.student_id'
                                ]
                            ],
                            'scms_levels' => [
                                'table' => 'scms_levels',
                                'type' => 'INNER',
                                'conditions' => [
                                    'scms_levels.level_id = scms_student_cycle.level_id'
                                ]
                            ],
                            'scms_sections' => [
                                'table' => 'scms_sections',
                                'type' => 'INNER',
                                'conditions' => [
                                    'scms_sections.section_id = scms_student_cycle.section_id'
                                ]
                            ],
                        ])->where($where)->toArray();
                if (count($students) == 0) {
                    $this->Flash->error('No Student Found', [
                        'key' => 'positive',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'individualFees']);
                }
                $this->set('students', $students[0]);
                $head = 'Student Name: <b>' . $students[0]['student_name'] . ' </b>SID: <b>' . $students[0]['sid'] . ' </b>Level Name: <b>' . $students[0]['level_name'] . ' </b>Section Name: <b>' . $students[0]['section_name'] . ' </b>';
                $this->set('head', $head);
                $additional_fees = TableRegistry::getTableLocator()->get('acc_student_additional_fees_cycle');
                $additionalFees = $additional_fees->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['level_id' => $request_data['level_id']])
                    ->where(['session_id' => $request_data['session_id']])
                    ->where(['student_cycle_id' => $students[0]['student_cycle_id']])
                    ->select([
                        'month_id' => 'additionals_fees.month_id',
                        'additional_fees_id' => 'additionals_fees.additional_fees_id',
                    ])->join([
                            'additionals_fees' => [
                                'table' => 'acc_additional_fees_cycle',
                                'type' => 'INNER',
                                'conditions' => [
                                    'additionals_fees.id = acc_student_additional_fees_cycle.additional_fees_cycle_id'
                                ]
                            ],
                        ])
                    ->toArray();

                $filter_previous_fees = array();
                foreach ($additionalFees as $fees) {
                    $filter_previous_fees[$fees['month_id']][$fees['additional_fees_id']] = $fees['fees_value'];
                }
                $get_additionals = TableRegistry::getTableLocator()->get('acc_additional_fees');
                $additionals = $get_additionals->find()->enableAutoFields(true)->enableHydration(false)->toArray();

                $this->set('additionals', $additionals);

                $months = $this->getMonthsFromSession($request_data['session_id']);
                $filter_months = array();
                foreach ($months as $month) {
                    $filter_additionals = array();
                    foreach ($additionals as $additional) {
                        if (isset($filter_previous_fees[$month['id']][$additional['id']])) {
                            $additional['set_value'] = $filter_previous_fees[$month['id']][$additional['id']];
                        }
                        $filter_additionals[$additional['id']] = $additional;
                    }
                    $month['additional'] = $filter_additionals;
                    $filter_months[$month['id']] = $month;
                }
                $this->set('filter_months', $filter_months);
                $this->set('request_data', $request_data);
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);
    }

    private function getMonthsFromSession($session_id)
    {
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->enableAutoFields(true)->enableHydration(false)->where(['session_id' => $session_id])->toArray();
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

    public function multipleFeesKhat()
    {
        $month = TableRegistry::getTableLocator()->get('acc_months');
        $months = $month->find()->enableAutoFields(true)->enableHydration(false)->toArray();
        foreach ($months as $key => $month) {
            $months[$key]['selected'] = null;
        }
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if (isset($request_data['user_id'])) {
                $acc_fees_khat_cycle = [];
                $amounts = array_filter($request_data['amount']);
                $totalAmount = array_sum($request_data['amount']);
                $months = json_decode($request_data['month_id']);

                foreach ($months as $month) {
                    $fees_khats = TableRegistry::getTableLocator()->get('acc_fees_khats');
                    $insertion['user_id'] = $request_data['user_id'];
                    $insertion['session_id'] = $request_data['session_id'];
                    $insertion['level_id'] = $request_data['level_id'];
                    $insertion['shift_id'] = $request_data['shift_id'] ? $request_data['shift_id'] : 0;
                    $insertion['group_id'] = $request_data['group_id'] ? $request_data['group_id'] : 0;
                    $insertion['month_id'] = $month;
                    $insertion['amount'] = $totalAmount;

                    $query = $fees_khats->query();
                    $query->insert(['session_id', 'level_id', 'user_id', 'shift_id', 'group_id', 'amount', 'month_id'])->values($insertion)->execute();

                    $myrecords = $fees_khats->find()->last();
                    $fees_khats_id = $myrecords->id;
                    $single_acc_fees_khat_purpose_amount = [];

                    foreach ($amounts as $key => $amount) {
                        $single_acc_fees_khat_purpose_amount['fees_khat_id'] = $fees_khats_id;
                        $single_acc_fees_khat_purpose_amount['purpose_id'] = $key;
                        $single_acc_fees_khat_purpose_amount['amount'] = $amount;
                        $single_acc_fees_khat_purpose_amount['scholarship'] = isset($request_data['scholarship'][$key]) ? 1 : 0;
                        $acc_fees_khat_cycle[] = $single_acc_fees_khat_purpose_amount;
                    }
                }
                if (count($acc_fees_khat_cycle) > 0) {
                    $student_additional_fees = TableRegistry::getTableLocator()->get('acc_fees_khat_purpose_amount');
                    $insertQuery_fees_khat_purpose_amount = $student_additional_fees->query();
                    $student_fees_khat_purpose_cycle_columns = array_keys($acc_fees_khat_cycle[0]);
                    $insertQuery_fees_khat_purpose_amount->insert($student_fees_khat_purpose_cycle_columns);
                    $insertQuery_fees_khat_purpose_amount->clause('values')->values($acc_fees_khat_cycle);
                    $insertQuery_fees_khat_purpose_amount->execute();
                }

                //Set Flash
                $this->Flash->info('Fees Khat Saved Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'index']);
            } else {
                $parentPurposeId = $request_data['purpose_id'];
                $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
                $purposeChilds = $get_purposes->find()->where(['parent' => $parentPurposeId])->toArray();
                $this->set('purposeChilds', $purposeChilds);
                $this->set('month_id', json_encode($request_data['month_id']));
                $this->set('session_id', $request_data['session_id']);
                $this->set('level_id', $request_data['level_id']);
                $this->set('purpose_id', $request_data['purpose_id']);
                $this->set('shift_id', $request_data['shift_id']);
                $this->set('group_id', $request_data['group_id']);
                $this->set('user_id', $this->Auth->user('id'));

                $month = TableRegistry::getTableLocator()->get('acc_months');
                $months = $month->find()->where(['id IN' => $request_data['month_id']])->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($months as $key => $month) {
                    $months[$key]['selected'] = 'selected';
                }
            }
        }
        $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $get_purposes->find()->where(['purpose_id' => 3])->toArray();
        $this->set('purposes', $purposes);

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);

        $scms_groups = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $scms_groups->find()->toArray();
        $this->set('groups', $groups);

        $hr_shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $hr_shift->find()->toArray();
        $this->set('shifts', $shifts);

        $this->set('months', $months);
    }

    public function feesKhatSettings()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $fees_khats = TableRegistry::getTableLocator()->get('acc_fees_khats');
            if (isset($request_data['user_id'])) {
                $group_id = $request_data['group_id'] ? $request_data['group_id'] : 0;
                $shift_id = $request_data['shift_id'] ? $request_data['shift_id'] : 0;
                $amounts = array_filter($request_data['amount']);
                $totalAmount = array_sum($request_data['amount']);
                $month = $request_data['month_id'];

                $matchCheck = $fees_khats->find();
                $matchCheck->where([
                    'session_id' => $request_data['session_id'],
                    'level_id' => $request_data['level_id'],
                    'month_id' => $request_data['month_id'],
                    'group_id' => $group_id,
                    'shift_id' => $shift_id
                ]);
                $hasRecord = $matchCheck->first();
                if ($hasRecord) { // The data already exists
                    $this->set('month_id', $request_data['month_id']);
                    $this->set('session_id', $request_data['session_id']);
                    $this->set('level_id', $request_data['level_id']);
                    $this->set('purpose_id', $request_data['purpose_id']);
                    $this->set('group_id', $request_data['group_id']);
                    $this->set('shift_id', $request_data['shift_id']);
                    $this->set('user_id', $this->Auth->user('id'));

                    //Total Amount Updation on the Fees-Khat table
                    $updatedTotal = array_sum($request_data['amount']);
                    $amountQuery = $fees_khats->query();
                    $amountQuery->update()->where([
                        'id' => $hasRecord->id
                    ])->set(['amount' => $updatedTotal])->execute();

                    $acc_fees_khat_cycle = array();
                    foreach ($amounts as $key => $amount) {
                        $single_acc_fees_khat_purpose_amount['fees_khat_id'] = $hasRecord->id;
                        $single_acc_fees_khat_purpose_amount['purpose_id'] = $key;
                        $single_acc_fees_khat_purpose_amount['amount'] = $amount;
                        $single_acc_fees_khat_purpose_amount['scholarship'] = isset($request_data['scholarship'][$key]) ? 1 : 0;

                        $acc_fees_khat_cycle[$key] = $single_acc_fees_khat_purpose_amount;
                    }

                    $acc_fees_khat_purpose_amount = TableRegistry::getTableLocator()->get('acc_fees_khat_purpose_amount');
                    $purpose_amounts = $acc_fees_khat_purpose_amount->find()->enableAutoFields(true)->enableHydration(false)->where([
                        'fees_khat_id' => $hasRecord->id
                    ])->toArray();

                    $filter_purpose_amounts = array();
                    foreach ($purpose_amounts as $purpose_amount) {
                        $filter_purpose_amounts[$purpose_amount['purpose_id']] = $purpose_amount;
                    }
                    $newAmounts = array_diff_key($acc_fees_khat_cycle, $filter_purpose_amounts);
                    $updatedAmounts = array_intersect_key($acc_fees_khat_cycle, $filter_purpose_amounts);
                    $deletedAmounts = array_diff_key($filter_purpose_amounts, $acc_fees_khat_cycle);
                    //delete
                    if (count($deletedAmounts)) {
                        $deletedAmounts_ids = array_keys($deletedAmounts);
                        $deleteQuery = $acc_fees_khat_purpose_amount->query();
                        $deleteQuery->delete()->where(['fees_khat_id' => $hasRecord->id, 'purpose_id IN' => $deletedAmounts_ids])->execute();
                    }

                    //insert new data
                    if (count($newAmounts) > 0) {
                        $newAmounts = array_values($newAmounts);
                        $insertQuery_fees_khat_purpose_amount = $acc_fees_khat_purpose_amount->query();
                        $columns = array_keys($newAmounts[0]);
                        $insertQuery_fees_khat_purpose_amount->insert($columns);
                        $insertQuery_fees_khat_purpose_amount->clause('values')->values($newAmounts);
                        $insertQuery_fees_khat_purpose_amount->execute();
                    }
                    // Update existing records
                    foreach ($updatedAmounts as $key => $updatedAmount) {
                        $updateQuery = $acc_fees_khat_purpose_amount->query();
                        $updateQuery->update()->set($updatedAmount)->where(['fees_khat_id' => $updatedAmount['fees_khat_id'], 'purpose_id' => $key])->execute();
                    }
                    $month = TableRegistry::getTableLocator()->get('acc_months');
                    $months = $month->find()->where(['id' => $request_data['month_id']])->toArray();
                    $this->set('months', $months);
                    $this->Flash->warning('Fees Khat Updated for ' . $months[0]['month_name'] . ' Successfully', [
                        'key' => 'positive',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'index']);
                } else { // The data doesn't already exists
                    $amounts = array_filter($request_data['amount']);
                    $totalAmount = array_sum($request_data['amount']);

                    $insertion['user_id'] = $request_data['user_id'];
                    $insertion['session_id'] = $request_data['session_id'];
                    $insertion['level_id'] = $request_data['level_id'];
                    $insertion['month_id'] = $request_data['month_id'];
                    $insertion['group_id'] = $group_id;
                    $insertion['shift_id'] = $shift_id;
                    $insertion['amount'] = $totalAmount;

                    $query = $fees_khats->query();

                    $query->insert(['session_id', 'level_id', 'user_id', 'amount', 'group_id', 'shift_id', 'month_id'])->values($insertion)->execute();

                    $myrecords = $fees_khats->find()->last();
                    $fees_khats_id = $myrecords->id;
                    $acc_fees_khat_cycle = [];
                    $single_acc_fees_khat_purpose_amount = [];

                    foreach ($amounts as $key => $amount) {
                        $single_acc_fees_khat_purpose_amount['fees_khat_id'] = $fees_khats_id;
                        $single_acc_fees_khat_purpose_amount['purpose_id'] = $key;
                        $single_acc_fees_khat_purpose_amount['amount'] = $amount;
                        $single_acc_fees_khat_purpose_amount['scholarship'] = isset($request_data['scholarship'][$key]) ? 1 : 0;
                        $acc_fees_khat_cycle[] = $single_acc_fees_khat_purpose_amount;
                    }
                    if (count($acc_fees_khat_cycle) > 0) {
                        $acc_fees_khat_purpose_amount = TableRegistry::getTableLocator()->get('acc_fees_khat_purpose_amount');
                        $insertQuery_fees_khat_purpose_amount = $acc_fees_khat_purpose_amount->query();
                        $columns = array_keys($acc_fees_khat_cycle[0]);
                        $insertQuery_fees_khat_purpose_amount->insert($columns);
                        $insertQuery_fees_khat_purpose_amount->clause('values')->values($acc_fees_khat_cycle);
                        $insertQuery_fees_khat_purpose_amount->execute();
                    }
                    $month = TableRegistry::getTableLocator()->get('acc_months');
                    $months = $month->find()->where(['id' => $request_data['month_id']])->toArray();
                    $this->set('months', $months);
                    // Set Flash
                    $this->Flash->info('Fees Khat for ' . $months[0]['month_name'] . ' Successfully Saved', [
                        'key' => 'positive',
                        'params' => [],
                    ]);
                }
            } else {
                if ($request_data['session_id'] && $request_data['level_id'] && $request_data['month_id']) {
                    $where['acc_fees_khats.session_id'] = $request_data['session_id'];
                    $where['acc_fees_khats.level_id'] = $request_data['level_id'];
                    $where['acc_fees_khats.month_id'] = $request_data['month_id'];
                }
                if (isset($request_data['group_id']) && $request_data['group_id']) {
                    $where['acc_fees_khats.group_id'] = $request_data['group_id'];
                } else {
                    $where['acc_fees_khats.group_id'] = 0;
                }
                if (isset($request_data['shift_id']) && $request_data['shift_id']) {
                    $where['acc_fees_khats.shift_id'] = $request_data['shift_id'];
                } else {
                    $where['acc_fees_khats.shift_id'] = 0;
                }

                $return = $this->searchFessKhats($where, $request_data['purpose_id']);

                $this->set('purposeChilds', $return['filter_purposeChilds']);
                $this->set('total', $return['total']);
                $this->set('month_id', $request_data['month_id']);
                $this->set('session_id', $request_data['session_id']);
                $this->set('level_id', $request_data['level_id']);
                $this->set('purpose_id', $request_data['purpose_id']);
                $this->set('group_id', $request_data['group_id']);
                $this->set('shift_id', $request_data['shift_id']);
                $this->set('user_id', $this->Auth->user('id'));
            }
        }
        $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $get_purposes->find()->where(['purpose_id' => 3])->toArray();
        $this->set('purposes', $purposes);
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);

        $month = TableRegistry::getTableLocator()->get('acc_months');
        $months = $month->find()->toArray();
        $this->set('months', $months);

        $scms_groups = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $scms_groups->find()->toArray();
        $this->set('groups', $groups);

        $hr_shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $hr_shift->find()->toArray();
        $this->set('shifts', $shifts);
    }

    /* private function searchFessKhats($where, $purposeId)
     {
         $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
         $purposeChilds = $get_purposes
             ->find()
             ->where(['parent' => $purposeId, 'deleted' => 0])
             ->toArray();
         $filter_purposeChilds = array();
         foreach ($purposeChilds as $purpose) {
             $purpose->single_amount = null;
             $purpose->scholarship = null;
             $filter_purposeChilds[$purpose->purpose_id] = $purpose;
         }
         $feesKhatTable = TableRegistry::getTableLocator()->get('acc_fees_khats');
         $feesKhats = $feesKhatTable->find()->enableAutoFields(true)->enableHydration(false)->select([
             'single_amount' => 'fkp.amount',
             'purpose_id' => 'fkp.purpose_id',
             'scholarship' => 'fkp.scholarship'
         ])->join([
                     'fkp' => [
                         'table' => 'acc_fees_khat_purpose_amount',
                         'type' => 'INNER',
                         'conditions' => [
                             'fkp.fees_khat_id = acc_fees_khats.id'
                         ]
                     ],
                 ])->where($where)->toArray();
         $total = 0;
         // foreach ($feesKhats as $feesKhat) {
         //     // pr($feesKhat);die;
         //     $filter_purposeChilds[$feesKhat['purpose_id']]['single_amount'] = $feesKhat['single_amount'];
         //     $total = $total + $feesKhat['single_amount'];
         //     if ($feesKhat['scholarship']) {
         //         $filter_purposeChilds[$feesKhat['purpose_id']]->scholarship = 'checked';
         //     }
         // } 
         #this commented lines has a problem(need to recheck 16/2/2025 @shovon)
           foreach ($feesKhats as $feesKhat) {
          if (!isset($filter_purposeChilds[$feesKhat['purpose_id']])) {
              $filter_purposeChilds[$feesKhat['purpose_id']] = []; // Initialize as an array
          }
      
          $filter_purposeChilds[$feesKhat['purpose_id']]['single_amount'] = $feesKhat['single_amount'];
          $total += $feesKhat['single_amount'];
      
          if ($feesKhat['scholarship']) {
              $filter_purposeChilds[$feesKhat['purpose_id']]['scholarship'] = 'checked';
          }
      }
         // echo '<pre>';
         // print_r($filter_purposeChilds);die;
         $return['filter_purposeChilds'] = $filter_purposeChilds;
         $return['total'] = $total;
         return $return;
     } */


    private function searchFessKhats($where, $purposeId)
    {
        $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposeChilds = $get_purposes->find()->where(['parent' => $purposeId])->toArray();
        $filter_purposeChilds = array();
        foreach ($purposeChilds as $purpose) {
            $purpose->single_amount = null;
            $purpose->scholarship = null;
            $filter_purposeChilds[$purpose->purpose_id] = $purpose;
        }
        $feesKhatTable = TableRegistry::getTableLocator()->get('acc_fees_khats');
        $feesKhats = $feesKhatTable->find()->enableAutoFields(true)->enableHydration(false)->select([
            'single_amount' => 'fkp.amount',
            'purpose_id' => 'fkp.purpose_id',
            'scholarship' => 'fkp.scholarship'
        ])->join([
                    'fkp' => [
                        'table' => 'acc_fees_khat_purpose_amount',
                        'type' => 'INNER',
                        'conditions' => [
                            'fkp.fees_khat_id = acc_fees_khats.id'
                        ]
                    ],
                ])->where($where)->toArray();
        $total = 0;
        foreach ($feesKhats as $feesKhat) {
            $filter_purposeChilds[$feesKhat['purpose_id']]->single_amount = $feesKhat['single_amount'];
            $total = $total + $feesKhat['single_amount'];
            if ($feesKhat['scholarship']) {
                $filter_purposeChilds[$feesKhat['purpose_id']]->scholarship = 'checked';
            }
        }
        $return['filter_purposeChilds'] = $filter_purposeChilds;
        $return['total'] = $total;
        return $return;
    }

    private function searchAdditionals($where, $query2)
    {
        $student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $students = $student_cycle->find()->enableAutoFields(true)->enableHydration(false)->select([
            'student_name' => 'sc.name',
            'section_name' => 'scms_sections.section_name',
            'level_name' => 'scms_levels.level_name',
            'sid' => 'sc.sid',
        ])->join([
                    'sc' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            'sc.student_id = scms_student_cycle.student_id'
                        ]
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_levels.level_id = scms_student_cycle.level_id'
                        ]
                    ],
                    'scms_sections' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_sections.section_id = scms_student_cycle.section_id'
                        ]
                    ],
                ])->where($where)->toArray();

        $filterStudents = [];
        $studentsCycleIds = [];
        foreach ($students as $student) {
            $filterStudents[$student['student_cycle_id']] = $student;
            $studentsCycleIds[] = $student['student_cycle_id'];
        }

        $additional_fees = TableRegistry::getTableLocator()->get('acc_student_additional_fees_cycle');
        $additionalFees = $additional_fees->find()->enableAutoFields(true)->enableHydration(false)->select([
            'month_id' => 'additionals_fees.month_id',
            'additional_fees_id' => 'additionals_fees.additional_fees_id',
        ])->join([
                    'additionals_fees' => [
                        'table' => 'acc_additional_fees_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'additionals_fees.id = acc_student_additional_fees_cycle.additional_fees_cycle_id'
                        ]
                    ],
                ])->where($query2)->toArray();
        foreach ($additionalFees as $feesData) {
            $filterStudents[$feesData['student_cycle_id']]['set_value'] = $feesData['fees_value'];
        }
        return $filterStudents;
    }

    ##==============================
## SHIHAB CONTROLLER ENDS
##==============================
##++++++++++++++++++++++++++++++
## SHOVON CONTROLLER STARTS
##++++++++++++++++++++++++++++++

    public function classwiseFeesCreditReport()
    {

        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            
            $where['acc_transactions.deleted !='] = 1;
            if (isset($request_data['session_id'])) {
                $where['acc_transactions.session_id IN'] = $request_data['session_id'];
            }
            // if ($request_data['purpose_id']) {
            //     $where['acc_purposes.parent'] = $request_data['purpose_id'];
            // }


            if (!empty($request_data['purpose_id'])) {
                if ($request_data['purpose_id'] === 'other') {
                    // Include records where acc_purposes.parent is NULL or not equal to 3
                    $where[] = [
                        'OR' => [
                            'acc_purposes.parent IS' => null,
                            'acc_purposes.parent !=' => 3
                        ]
                    ];
                } else {
                    // Otherwise, filter rows where parent matches the selected purpose_id
                    $where['acc_purposes.parent'] = $request_data['purpose_id'];
                }
            }




            if ($request_data['start_date']) {
                if ($request_data['end_date']) {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                } else {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                }
                $where['transaction_date >='] = $request_data['start_date'];
                $where['transaction_date <'] = $request_data['end_date'];
            }
            // echo '<pre>';
            // print_r($where);die;
            $data = TableRegistry::getTableLocator()->get('acc_transactions');
            $vouchers = $data->find()
                ->where($where)
                // ->where(['acc_transactions.level_id' => $request_data['level_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'name' => "scms_students.name",
                    'sid' => "scms_students.sid",
                    'level_name' => "scms_levels.level_name",
                    'section_name' => "scms_sections.section_name",
                    'session_name' => "scms_sessions.session_name",
                    'month' => "acc_months.month_name",
                    'purpose' => "acc_purposes.purpose_name",
                    'roll' => "scms_student_cycle.roll",
                    'amnt' => "acc_transaction_purposes.amount",
                ])
                ->join([
                    'acc_transaction_purposes' => [
                        'table' => 'acc_transaction_purposes',
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transaction_purposes.transaction_id = acc_transactions.transaction_id'
                        ]
                    ],
                    'acc_purposes' => [
                        'table' => 'acc_purposes',
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_purposes.purpose_id = acc_transaction_purposes.purpose_id'
                        ]
                    ],
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_transactions.student_cycle_id = scms_student_cycle.student_cycle_id'
                        ]
                    ],
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_students.student_id = scms_student_cycle.student_id'
                        ]
                    ],
                    'acc_months' => [
                        'table' => 'acc_months',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_transaction_purposes.month_id = acc_months.id'
                        ]
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_transactions.level_id = scms_levels.level_id'
                        ]
                    ],
                    'scms_sessions' => [
                        'table' => 'scms_sessions',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_transactions.session_id = scms_sessions.session_id'
                        ]
                    ],
                    'scms_sections' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_student_cycle.section_id = scms_sections.section_id'
                        ]
                    ],
                ])
                ->order(['scms_student_cycle.roll' => 'ASC'])
                ->toArray();
            // echo '<pre>';
            // print_r($vouchers);
            // die;

          /*  $levels = [];
            $purposes = [];
            $data = [];
            $levelNames = [];

            foreach ($vouchers as $voucher) {
                $levelId = trim($voucher['level_id'] ?? '');
                $levelName = trim($voucher['level_name'] ?? '');
                $purpose = trim($voucher['purpose'] ?? ''); 
                $amount = (float) ($voucher['amnt'] ?? 0);

                // Skip invalid data
                if (empty($levelId) || empty($purpose) || $amount <= 0) {
                    continue;
                }

                // Store unique levels and purposes
                $levels[$levelId] = true;
                $purposes[$purpose] = true;

                // Store level_name mapping
                if (!isset($levelNames[$levelId])) {
                    $levelNames[$levelId] = $levelName;
                }

                // Store amount per level and purpose
                if (!isset($data[$levelId][$purpose])) {
                    $data[$levelId][$purpose] = 0;
                }

                $data[$levelId][$purpose] += $amount;
            }
            // Sort levels in numerical order
            uksort($data, function ($a, $b) {
                return (int) $a - (int) $b; // Sort by level_id directly
            });

            // Sort purposes for consistent display order
            $purposes = array_keys($purposes);
            sort($purposes);
            $finalData = [];
            foreach ($data as $levelId => $values) {
                $levelName = $levelNames[$levelId] ?? $levelId; // Map to name or fallback to ID
                $finalData[$levelName] = $values;
            } */
            
            
            $levels = [];
            $purposes = [];
            $data = [];
            $levelSectionNames = [];
            
            foreach ($vouchers as $voucher) {
                $levelId     = trim($voucher['level_id'] ?? '');
                $levelName   = trim($voucher['level_name'] ?? '');
                $sectionName = trim($voucher['section_name'] ?? '');
                $purpose     = trim($voucher['purpose'] ?? ''); 
                $amount      = (float) ($voucher['amnt'] ?? 0);
            
                
                if (empty($levelId) || empty($sectionName) || empty($purpose) || $amount <= 0) {
                    continue;
                }
            
                
                $levelSectionKey = $levelId . '|' . $sectionName;
            
               
                $purposes[$purpose] = true;
            
                
                if (!isset($levelSectionNames[$levelSectionKey])) {
                    $levelSectionNames[$levelSectionKey] = $levelName . ' - ' . $sectionName;
                }
            
               
                if (!isset($data[$levelSectionKey][$purpose])) {
                    $data[$levelSectionKey][$purpose] = 0;
                }
                $data[$levelSectionKey][$purpose] += $amount;
            }
            
            
            uksort($data, function ($a, $b) {
                [$aLevel, $aSection] = explode('|', $a);
                [$bLevel, $bSection] = explode('|', $b);
            
                $cmp = (int)$aLevel <=> (int)$bLevel;
                if ($cmp !== 0) {
                    return $cmp;
                }
                return strcmp($aSection, $bSection);
            });
            
            
            $finalData = [];
            foreach ($data as $levelSectionKey => $values) {
                $displayName = $levelSectionNames[$levelSectionKey] ?? $levelSectionKey;
                $finalData[$displayName] = $values;
            }



            $this->set(compact('finalData', 'purposes'));

            $this->autoRender = false;
            $this->layout = 'report';
            $this->render('/reports/classwise_fees_report');
        }
        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);
        $get_purposes = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $get_purposes->find()->where(['purpose_id' => 3])->toArray();
        $this->set('purposes', $purposes);
    }

    public function purposeWise()
    {

        if ($this->request->is(['post'])) {
            $transformed_vouchers = array();
            $request_data = $this->request->getData();
            // echo '<pre>';
            // print_r($request_data);
            // die;
            $where['acc_transactions.deleted !='] = 1;
            if ($request_data['purpose_id']) {
                $where['acc_transaction_purposes.purpose_id'] = $request_data['purpose_id'];
            }
            if ($request_data['session_id']) {
                $where['acc_transactions.session_id'] = $request_data['session_id'];
            }
            if ($request_data['level_id']) {
                $where['acc_transactions.level_id'] = $request_data['level_id'];
            }
            if ($request_data['section_id']) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            
            // echo '<pre>';
            // print_r($where);
            // die;
            // pr($request_data);die;
            $data = TableRegistry::getTableLocator()->get('acc_transaction_purposes');
            $vouchers = $data->find()
                ->where($where)
                // ->where(['acc_transactions.deleted !=' => 1])
                
                // ->where(['acc_transaction_purposes.purpose_id' => $request_data['purpose_id']])
                // ->where(['acc_transactions.session_id' => $request_data['session']])
                // ->where(['acc_transactions.level_id' => $request_data['level_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'name' => "scms_students.name",
                    'sid' => "scms_students.sid",
                    'level_name' => "scms_levels.level_name",
                    'session_name' => "scms_sessions.session_name",
                    'month' => "acc_months.month_name",
                    'purpose' => "acc_purposes.purpose_name",
                    'roll' => "scms_student_cycle.roll",
                ])
                ->join([
                    'acc_transactions' => [
                        'table' => 'acc_transactions',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_transactions.transaction_id = acc_transaction_purposes.transaction_id',
                            'acc_transactions.deleted' => 0,
                        ]
                    ],
                    'acc_purposes' => [
                        'table' => 'acc_purposes',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_purposes.purpose_id = acc_transaction_purposes.purpose_id'
                        ]
                    ],
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_transactions.student_cycle_id = scms_student_cycle.student_cycle_id'
                        ]
                    ],
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_students.student_id = scms_student_cycle.student_id'
                        ]
                    ],
                    'acc_months' => [
                        'table' => 'acc_months',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_transaction_purposes.month_id = acc_months.id'
                        ]
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_transactions.level_id = scms_levels.level_id'
                        ]
                    ],
                    'scms_sessions' => [
                        'table' => 'scms_sessions',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_transactions.session_id = scms_sessions.session_id'
                        ]
                    ],
                    'scms_sections' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_sections.section_id = scms_student_cycle.section_id'
                        ]
                    ],
                ])
                ->order(['scms_student_cycle.roll' => 'ASC'])
                ->toArray();
            //     echo '<pre>';
            // print_r($vouchers);
            // die;
            foreach ($vouchers as $voucher) {
                // Extract relevant data
                $name = $voucher['name'];
                $sid = $voucher['sid'];
                $roll = $voucher['roll'];
                $amount = $voucher['amount'];
                $month = $voucher['month'];

                // Initialize an entry for this student if not already set
                if (!isset($transformed_vouchers[$name])) {
                    $transformed_vouchers[$name] = [
                        'name' => $name,
                        'sid' => $sid,
                        'roll' => $roll,
                        'amounts' => []
                    ];
                }

                // Set the amount for the corresponding month
                $transformed_vouchers[$name]['amounts'][$month] = $amount;
            }
            // pr($transformed_vouchers);die;

            $month = TableRegistry::getTableLocator()->get('acc_months');
            $months = $month->find()->toArray();
            $this->set('months', $months);

            if (isset($request_data['level_id']) && $request_data['level_id']) {
                $level = TableRegistry::getTableLocator()->get('scms_levels');
                $levels = $level->find()->where(['level_id' => $request_data['level_id']])->toArray();
                $head1 = $levels[0]['level_name'];
            }
            if (isset($request_data['section_id']) && $request_data['section_id']) {
                $scms_sections = TableRegistry::getTableLocator()->get('scms_sections');
                $section = $scms_sections->find()->where(['section_id' => $request_data['section_id']])->toArray();
                $head2 = $section[0]['section_name'];
            }

            $this->set('head1', $head1);
            $this->set('head2', $head2);
            $this->set('transformed_vouchers', $transformed_vouchers);
            $this->set('vouchers', $vouchers);
            $this->autoRender = false;
            $this->layout = 'report';
            $this->render('/reports/purposeWiseReport');
        }
        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions->find()->toArray();
        $this->set('sessions', $sessions);
        $levels = $this->get_levels('accounts');
        $this->set('levels', $levels);
        $month = TableRegistry::getTableLocator()->get('acc_months');
        $months = $month->find()->toArray();
        $this->set('months', $months);
        $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $purpose->find()->toArray();
        $this->set('purposes', $purposes);

        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);

        $sections = $this->get_sections('accounts', $levels[0]->level_id);
        $this->set('sections', $sections);
        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles)) {
            $required = '';
        }
        $this->set('required', $required);
    }

    public function transactionStatement()
    { //created by @shovon
        if ($this->request->is(['post'])) {
            $this->layout = 'report';
            $request_data = $this->request->getData();
            $where['acc_transactions.deleted'] = 0;
            if (isset($request_data['level_id']) && $request_data['level_id']) {
                $where['acc_transactions.level_id'] = $request_data['level_id'];
            }
            if (isset($request_data['bank']) && $request_data['bank']) {
                $where['b.bank_id IN'] = $request_data['bank'];
            }
            if (isset($request_data['trn_no']) && $request_data['trn_no']) {
                $where['acc_transactions.trn_no'] = $request_data['trn_no'];
            }
            if (isset($request_data['sid']) && $request_data['sid']) {
                $where['acc_transactions.sid'] = $request_data['sid'];
            }
            if (isset($request_data['user_id']) && $request_data['user_id']) {
                $where['acc_transactions.user_id'] = $request_data['user_id'];
            }
            if ($request_data['type'] != 'both') {
                $where['transaction_type'] = $request_data['type'];
            }
            if ($request_data['start_date']) {
                if ($request_data['end_date']) {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                } else {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                }
                $where['transaction_date >='] = $request_data['start_date'];
                $where['transaction_date <'] = $request_data['end_date'];
            }
            $role_id = $this->Auth->user('role_id');
            $roles[] = 1;
            $roles[] = 2;
            if (!in_array($role_id, $roles)) {
                $id = $this->Auth->user('id');
                $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
                $permissions = $employees_permission->find()
                    ->where(['user_id' => $id])
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
                $section_ids = array();
                foreach ($permissions as $permission) {
                    $section_ids[$permission['section_id']] = $permission['section_id'];
                }
                if (count($section_ids)) {
                    $section_ids = array_values($section_ids);
                    $where['scms_student_cycle.section_id IN'] = $section_ids;
                } else {
                    $where['scms_student_cycle.section_id'] = -1;
                }
            }
            $transactions = $this->getTransactiondetails($where);
            $total['amount'] = 0;
            $total['discount_amount'] = 0;
            $month = TableRegistry::getTableLocator()->get('acc_months');
            $months = $month->find()->enableAutoFields(true)->enableHydration(false)->toArray();
            foreach ($months as $month) {
                $filter_months[$month['id']] = $month['month_name'];
            }

            foreach ($transactions as $key => $transaction) {
                $month_ids = json_decode($transaction['month_ids']);
                foreach ($month_ids as $month_id) {
                    $month_id = (int) $month_id;
                    if (isset($transactions[$key]['month_name'])) {
                        $transactions[$key]['month_name'] = $transactions[$key]['month_name'] . ',' . substr($filter_months[$month_id], 0, 3);
                    } else {
                        $transactions[$key]['month_name'] = substr($filter_months[$month_id], 0, 3);
                    }
                }
                $total['amount'] = $total['amount'] + $transaction['amount'];
                $total['discount_amount'] = $total['discount_amount'] + $transaction['discount_amount'];
            }
            $head = $this->get_report_head('Transaction Statement', $request_data);
            $this->set('head', $head);
            $this->set('total', $total);
            $this->set('transactions', $transactions);
            $this->autoRender = false;
            $this->layout = 'report';
            $this->render('/reports/transactionStatement');
        }
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->toArray();
        $this->set('banks', $banks);

        $role = TableRegistry::getTableLocator()->get('roles');
        $roles = $role->find()->toArray();
        $this->set('roles', $roles);
        $levels = $this->get_levels('accounts');
        $this->set('levels', $levels);
        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        $roles = array();
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles)) {
            $required = '';
        }
        $this->set('required', $required);

    }

    private function getTransactiondetails($where)
    {
        $acc_transactions = TableRegistry::getTableLocator()->get('acc_transactions');
        $transactions = $acc_transactions->find()->enableAutoFields(true)->enableHydration(false)->where($where)->select([
            'received_by' => 'received.name',
            'bank_name' => 'acc_banks.bank_name',
            'student_name' => 'scms_students.name',
            'employee_name' => 'employee.name',
            'level_name' => "scms_levels.level_name",
            'session_name' => "scms_sessions.session_name",
        ])->order(['acc_transactions.transaction_id' => 'DESC'])->join([
                    'acc_banks' => [
                        'table' => 'acc_banks',
                        'type' => 'INNER',
                        'conditions' => ['acc_banks.bank_id  = acc_transactions.bank_id'],
                    ],
                    'employee' => [
                        'table' => 'users',
                        'type' => 'LEFT',
                        'conditions' => ['employee.id = acc_transactions.employee_id']
                    ],
                    'received' => [
                        'table' => 'users',
                        'type' => 'LEFT',
                        'conditions' => ['received.id = acc_transactions.user_id']
                    ],
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transactions.student_cycle_id = scms_student_cycle.student_cycle_id'
                        ]
                    ],
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'LEFT',
                        'conditions' => [
                            'scms_students.student_id = scms_student_cycle.student_id'
                        ]
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transactions.level_id = scms_levels.level_id'
                        ]
                    ],
                    'scms_sessions' => [
                        'table' => 'scms_sessions',
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transactions.session_id = scms_sessions.session_id'
                        ]
                    ],
                ])->order(['transaction_date' => 'ASC'])->toArray();
        return $transactions;
    }

   /* public function paymentDetails()
    { //created by @shovon
        if ($this->request->is(['post'])) {
            $this->layout = 'report';
            $request_data = $this->request->getData();
            $where['acc_transactions.deleted'] = 0;
            if (isset($request_data['level_id']) && $request_data['level_id']) {
                $where['acc_transactions.level_id'] = $request_data['level_id'];
            }
            if (isset($request_data['bank']) && $request_data['bank']) {
                $where['b.bank_id IN'] = $request_data['bank'];
            }
            if (isset($request_data['trn_no']) && $request_data['trn_no']) {
                $where['acc_transactions.trn_no'] = $request_data['trn_no'];
            }
            if (isset($request_data['sid']) && $request_data['sid']) {
                $where['acc_transactions.sid'] = $request_data['sid'];
            }
            if (isset($request_data['user_id']) && $request_data['user_id']) {
                $where['acc_transactions.user_id'] = $request_data['user_id'];
            }
            if ($request_data['type'] != 'both') {
                $where['transaction_type'] = $request_data['type'];
            }
            if ($request_data['start_date']) {
                if ($request_data['end_date']) {
                    $end_date = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                } else {
                    $end_date = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                }
                $where['transaction_date >='] = $request_data['start_date'];
                $where['transaction_date <'] = $end_date;
            }

            $role_id = $this->Auth->user('role_id');
            $roles[] = 1;
            $roles[] = 2;
            if (!in_array($role_id, $roles)) {
                $id = $this->Auth->user('id');
                $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
                $permissions = $employees_permission->find()
                    ->where(['user_id' => $id])
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
                $section_ids = array();
                foreach ($permissions as $permission) {
                    $section_ids[$permission['section_id']] = $permission['section_id'];
                }
                if (count($section_ids)) {
                    $section_ids = array_values($section_ids);
                    $where['scms_student_cycle.section_id IN'] = $section_ids;
                } else {
                    $where['scms_student_cycle.section_id'] = -1;
                }
            }

            $transactions = $this->getTransactiondetails($where);
            $filter_transection = array();
            $transection_ids = array();
            foreach ($transactions as $transaction) {
                $filter_transection[$transaction['transaction_id']] = $transaction;
                $transection_ids[] = $transaction['transaction_id'];
            }


            $purpose_whare = array();
            if (isset($request_data['month_id']) && $request_data['month_id']) {
                $purpose_whare['acc_transaction_purposes.month_id IN'] = $request_data['month_id'];
            }
            if (count($transection_ids)) {
                $acc_transaction_purposes = TableRegistry::getTableLocator()->get('acc_transaction_purposes');
                $t_purposes = $acc_transaction_purposes->find()->where(['acc_transaction_purposes.transaction_id IN' => $transection_ids])->where($purpose_whare)->enableAutoFields(true)->enableHydration(false)->select([
                    'month_name' => "acc_months.month_name",
                    'purpose_name' => "acc_purposes.purpose_name",
                ])->join([
                            'acc_months' => [
                                'table' => 'acc_months',
                                'type' => 'LEFT',
                                'conditions' => [
                                    'acc_transaction_purposes.month_id = acc_months.id'
                                ]
                            ],
                            'acc_purposes' => [
                                'table' => 'acc_purposes',
                                'type' => 'LEFT',
                                'conditions' => [
                                    'acc_transaction_purposes.purpose_id = acc_purposes.purpose_id'
                                ]
                            ],
                        ])->toArray();
            } else {
                $t_purposes = array();
            }
            $show_data = array();
            $total = 0;
            if ($request_data['report_type'] == 'Student') {
                $table_row[] = 'SID';
                $table_row[] = 'Name';
                $table_row[] = 'Session';
                $table_row[] = 'level';
                $table_row[] = 'Amount';
                foreach ($t_purposes as $t_purpose) {
                    if ($filter_transection[$t_purpose['transaction_id']]['student_name']) {
                        $total = $total + $t_purpose['amount'];
                        $sid = $filter_transection[$t_purpose['transaction_id']]['sid'];
                        if (isset($show_data[$sid])) {
                            $show_data[$sid][4] = $show_data[$sid][4] + $t_purpose['amount'];
                        } else {
                            $show_data_single[] = $filter_transection[$t_purpose['transaction_id']]['sid'];
                            $show_data_single[] = $filter_transection[$t_purpose['transaction_id']]['student_name'];
                            $show_data_single[] = $filter_transection[$t_purpose['transaction_id']]['session_name'];
                            $show_data_single[] = $filter_transection[$t_purpose['transaction_id']]['level_name'];
                            $show_data_single[] = $t_purpose['amount'];
                            $show_data[$sid] = $show_data_single;
                            unset($show_data_single);
                        }
                    }
                }
            } else if ($request_data['report_type'] == 'Month') {
                $table_row[] = '#';
                $table_row[] = 'Month Name';
                $table_row[] = 'Amount';
                $month = TableRegistry::getTableLocator()->get('acc_months');
                $months = $month->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($months as $month) {
                    $show_data_single[] = $month['id'];
                    $show_data_single[] = $month['month_name'];
                    $show_data_single[] = 0;
                    $show_data[$month['id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($t_purposes as $t_purpose) {
                    if ($t_purpose['month_id']) {
                        $total = $total + $t_purpose['amount'];
                        $show_data[$t_purpose['month_id']][2] = $show_data[$t_purpose['month_id']][2] + $t_purpose['amount'];
                    }
                }
            } else if ($request_data['report_type'] == 'Purpose') {
                $table_row[] = '#';
                $table_row[] = 'Purpose Name';
                $table_row[] = 'Amount';
                $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
                $purposes = $purpose->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($purposes as $purpose) {
                    $show_data_single[] = $purpose['purpose_id'];
                    $show_data_single[] = $purpose['purpose_name'];
                    $show_data_single[] = 0;
                    $show_data[$purpose['purpose_id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($t_purposes as $t_purpose) {
                    $total = $total + $t_purpose['amount'];
                    $show_data[$t_purpose['purpose_id']][2] = $show_data[$t_purpose['purpose_id']][2] + $t_purpose['amount'];
                }
            } else if ($request_data['report_type'] == 'Class') {
                $table_row[] = '#';
                $table_row[] = 'Class Name';
                $table_row[] = 'Amount';
                $scms_levels = TableRegistry::getTableLocator()->get('scms_levels');
                $levels = $scms_levels->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($levels as $level) {
                    $show_data_single[] = $level['level_id'];
                    $show_data_single[] = $level['level_name'];
                    $show_data_single[] = 0;
                    $show_data[$level['level_id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($t_purposes as $t_purpose) {
                    if (isset($filter_transection[$t_purpose['transaction_id']]['level_id'])) {
                        $total = $total + $t_purpose['amount'];
                        $level_id = $filter_transection[$t_purpose['transaction_id']]['level_id'];
                        $show_data[$level_id][2] = $show_data[$level_id][2] + $t_purpose['amount'];
                    }
                }
            }


            $head = $this->get_report_head('Payment Details', $request_data);
            $this->set('head', $head);
            $this->set('total', $total);
            $this->set('type', $request_data['report_type']);
            $this->set('show_data', $show_data);
            $this->set('table_row', $table_row);
            $this->autoRender = false;
            $this->layout = 'report';
            $this->render('/reports/paymentDetails');
        }
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->toArray();
        $this->set('banks', $banks);

        $role = TableRegistry::getTableLocator()->get('roles');
        $roles = $role->find()->toArray();
        $levels = $this->get_levels('accounts');
        $this->set('levels', $levels);


        $month = TableRegistry::getTableLocator()->get('acc_months');
        $months = $month->find()->toArray();
        $this->set('months', $months);
    } */
    
    public function paymentDetails()
    { //created by @shovon
        if ($this->request->is(['post'])) {
            $this->layout = 'report';
            $request_data = $this->request->getData();
            $where['acc_transactions.deleted'] = 0;
            if (isset($request_data['level_id']) && $request_data['level_id']) {
                $where['acc_transactions.level_id'] = $request_data['level_id'];
            }
            if (isset($request_data['session_id']) && $request_data['session_id']) {
                $where['acc_transactions.session_id'] = $request_data['session_id'];
            }
            if (isset($request_data['bank']) && $request_data['bank']) {
                $where['acc_banks.bank_id IN'] = $request_data['bank'];
            }
            if (isset($request_data['trn_no']) && $request_data['trn_no']) {
                $where['acc_transactions.trn_no'] = $request_data['trn_no'];
            }
            if (isset($request_data['sid']) && $request_data['sid']) {
                $where['acc_transactions.sid'] = $request_data['sid'];
            }
            if (isset($request_data['user_id']) && $request_data['user_id']) {
                $where['acc_transactions.user_id'] = $request_data['user_id'];
            }
            if ($request_data['type'] != 'both') {
                $where['transaction_type'] = $request_data['type'];
            }
            if ($request_data['start_date']) {
                if ($request_data['end_date']) {
                    $end_date = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                } else {
                    $end_date = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                }
                $where['transaction_date >='] = $request_data['start_date'];
                $where['transaction_date <'] = $end_date;
            }
            $transactions = $this->getTransactiondetails($where);
            $filter_transection = array();
            $transection_ids = array();
            foreach ($transactions as $transaction) {
                $filter_transection[$transaction['transaction_id']] = $transaction;
                $transection_ids[] = $transaction['transaction_id'];
            }


            $purpose_whare = array();
            if (isset($request_data['month_id']) && $request_data['month_id']) {
                $purpose_whare['acc_transaction_purposes.month_id IN'] = $request_data['month_id'];
            }
            if (count($transection_ids)) {
                $acc_transaction_purposes = TableRegistry::getTableLocator()->get('acc_transaction_purposes');
                $t_purposes = $acc_transaction_purposes->find()->where(['acc_transaction_purposes.transaction_id IN' => $transection_ids])->where($purpose_whare)->enableAutoFields(true)->enableHydration(false)->select([
                    'month_name' => "acc_months.month_name",
                    'purpose_name' => "acc_purposes.purpose_name",
                ])->join([
                            'acc_months' => [
                                'table' => 'acc_months',
                                'type' => 'LEFT',
                                'conditions' => [
                                    'acc_transaction_purposes.month_id = acc_months.id'
                                ]
                            ],
                            'acc_purposes' => [
                                'table' => 'acc_purposes',
                                'type' => 'LEFT',
                                'conditions' => [
                                    'acc_transaction_purposes.purpose_id = acc_purposes.purpose_id'
                                ]
                            ],
                        ])->toArray();
            } else {
                $t_purposes = array();
            }
            $show_data = array();
            $total = 0;
            if ($request_data['report_type'] == 'Student') {
                $table_row[] = 'SID';
                $table_row[] = 'Name';
                $table_row[] = 'Session';
                $table_row[] = 'level';
                $table_row[] = 'Amount';
                foreach ($t_purposes as $t_purpose) {
                    if ($filter_transection[$t_purpose['transaction_id']]['student_name']) {
                        $total = $total + $t_purpose['amount'];
                        $sid = $filter_transection[$t_purpose['transaction_id']]['sid'];
                        if (isset($show_data[$sid])) {
                            $show_data[$sid][4] = $show_data[$sid][4] + $t_purpose['amount'];
                        } else {
                            $show_data_single[] = $filter_transection[$t_purpose['transaction_id']]['sid'];
                            $show_data_single[] = $filter_transection[$t_purpose['transaction_id']]['student_name'];
                            $show_data_single[] = $filter_transection[$t_purpose['transaction_id']]['session_name'];
                            $show_data_single[] = $filter_transection[$t_purpose['transaction_id']]['level_name'];
                            $show_data_single[] = $t_purpose['amount'];
                            $show_data[$sid] = $show_data_single;
                            unset($show_data_single);
                        }
                    }
                }
            } else if ($request_data['report_type'] == 'Month') {
                $table_row[] = '#';
                $table_row[] = 'Month Name';
                $table_row[] = 'Amount';
                $month = TableRegistry::getTableLocator()->get('acc_months');
                $months = $month->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($months as $month) {
                    $show_data_single[] = $month['id'];
                    $show_data_single[] = $month['month_name'];
                    $show_data_single[] = 0;
                    $show_data[$month['id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($t_purposes as $t_purpose) {
                    if ($t_purpose['month_id']) {
                        $total = $total + $t_purpose['amount'];
                        $show_data[$t_purpose['month_id']][2] = $show_data[$t_purpose['month_id']][2] + $t_purpose['amount'];
                    }
                }
            } else if ($request_data['report_type'] == 'Purpose') {
                $table_row[] = '#';
                $table_row[] = 'Purpose Name';
                $table_row[] = 'Amount';
                $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
                $purposes = $purpose->find()->where(['deleted' => 0])->enableAutoFields(true)->enableHydration(false)->toArray();
                // echo '<pre>';
                // print_r($purposes);die;
                foreach ($purposes as $purpose) {
                    $show_data_single[] = $purpose['purpose_id'];
                    $show_data_single[] = $purpose['purpose_name'];
                    $show_data_single[] = 0;
                    $show_data[$purpose['purpose_id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($t_purposes as $t_purpose) {
                    $total = $total + $t_purpose['amount'];
                    $show_data[$t_purpose['purpose_id']][2] = $show_data[$t_purpose['purpose_id']][2] + $t_purpose['amount'];
                }
            } else if ($request_data['report_type'] == 'Purpose_wise_monthly') {
                $table_row[] = '#';
                $table_row[] = 'Purpose Name';
                $table_row[] = 'Amount';
                $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
                $purposes = $purpose->find()
                ->where(['deleted' => 0])
                ->where([
                        'deleted' => 0,
                        'purpose_id NOT IN' => [10, 22, 28]
                    ])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
                // echo '<pre>';
                // print_r($purposes);die;
                $excluded_ids = [10, 22, 28];

                foreach ($purposes as $purpose) {
                    if (in_array($purpose['purpose_id'], $excluded_ids)) {
                        continue; // Skip excluded purpose_ids
                    }
                    $show_data_single[] = $purpose['purpose_id'];
                    $show_data_single[] = $purpose['purpose_name'];
                    $show_data_single[] = 0;
                    $show_data[$purpose['purpose_id']] = $show_data_single;
                    unset($show_data_single);
                }
                
                foreach ($t_purposes as $t_purpose) {
                    if (in_array($t_purpose['purpose_id'], $excluded_ids)) {
                        continue; // Skip excluded purpose_ids
                    }
                    $total = $total + $t_purpose['amount'];
                    $show_data[$t_purpose['purpose_id']][2] = $show_data[$t_purpose['purpose_id']][2] + $t_purpose['amount'];
                }
            } else if ($request_data['report_type'] == 'Class') {
                $table_row[] = '#';
                $table_row[] = 'Class Name';
                $table_row[] = 'Amount';
                $scms_levels = TableRegistry::getTableLocator()->get('scms_levels');
                $levels = $scms_levels->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($levels as $level) {
                    $show_data_single[] = $level['level_id'];
                    $show_data_single[] = $level['level_name'];
                    $show_data_single[] = 0;
                    $show_data[$level['level_id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($t_purposes as $t_purpose) {
                    if (isset($filter_transection[$t_purpose['transaction_id']]['level_id'])) {
                        $total = $total + $t_purpose['amount'];
                        $level_id = $filter_transection[$t_purpose['transaction_id']]['level_id'];
                        $show_data[$level_id][2] = $show_data[$level_id][2] + $t_purpose['amount'];
                    }
                }
            }


            $head = $this->get_report_head('Payment Details', $request_data);
            $this->set('head', $head);
            $this->set('total', $total);
            $this->set('type', $request_data['report_type']);
            $this->set('show_data', $show_data);
            $this->set('table_row', $table_row);
            $this->autoRender = false;
            $this->layout = 'report';
            $this->render('/reports/paymentDetails');
        }
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->toArray();
        $this->set('banks', $banks);

        // $role = TableRegistry::getTableLocator()->get('roles');
        // $roles = $role->find()->where(['id NOT IN' => [1, 2]])->toArray();
        // $this->set('roles', $roles);
        
        $user_id = $this->Auth->user('id');
        if ($user_id == 1 || $user_id == 69) {
            $role = TableRegistry::getTableLocator()->get('roles');
            $roles = $role->find()->where(['roles.id NOT IN' => [1, 2]])->toArray();
            $this->set('roles', $roles);
        } else {
            $role = TableRegistry::getTableLocator()->get('roles');
            $roles = $role
                ->find()
                ->select([
                    'id' => 'roles.id',
                    'title' => 'roles.title',
                ])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['roles.id NOT IN' => [1, 2]])
                ->where(['users.id' => $user_id])
                ->join([
                    'users' => [
                        'table' => 'users',
                        'type' => 'LEFT',
                        'conditions' => [
                            'users.role_id = roles.id'
                        ]
                    ]
                ])->toArray();
            $this->set('roles', $roles);
        }
        
        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);
        $month = TableRegistry::getTableLocator()->get('acc_months');
        $months = $month->find()->toArray();
        $this->set('months', $months);
    }

    public function bankStatementReport()
    { //created by @shovon
        if ($this->request->is(['post'])) {
            $this->layout = 'report';
            $request_data = $this->request->getData();
            // pr($request_data);
            // die;
            $where['acc_transactions.deleted'] = 0;
            if (isset($request_data['level_id']) && $request_data['level_id']) {
                $where['acc_transactions.level_id'] = $request_data['level_id'];
            }
            if (isset($request_data['bank']) && $request_data['bank']) {
                $where['acc_banks.bank_id IN'] = $request_data['bank'];
            }
            if (isset($request_data['report_type']) && $request_data['report_type']) {
                $where['acc_purposes.report_type'] = $request_data['report_type'];
            }
            if ($request_data['type'] == 'Credit') {
                $where['transaction_type'] = $request_data['type'];
            }
            if ($request_data['start_date']) {
                if ($request_data['end_date']) {
                    $end_date = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                } else {
                    $end_date = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                }
                $where['transaction_date >='] = $request_data['start_date'];
                $where['transaction_date <'] = $end_date;
            }
            $role_id = $this->Auth->user('role_id');
            $roles[] = 1;
            $roles[] = 2;
            if (!in_array($role_id, $roles)) {
                $id = $this->Auth->user('id');
                $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
                $permissions = $employees_permission->find()
                    ->where(['user_id' => $id])
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
                $section_ids = array();
                foreach ($permissions as $permission) {
                    $section_ids[$permission['section_id']] = $permission['section_id'];
                }
                if (count($section_ids)) {
                    $section_ids = array_values($section_ids);
                    $where['scms_student_cycle.section_id IN'] = $section_ids;
                } else {
                    $where['scms_student_cycle.section_id'] = -1;
                }
            }


            $acc_transactions = TableRegistry::getTableLocator()->get('acc_transactions');
            $transactions = $acc_transactions->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where($where)
                ->select([
                    'received_by' => 'received.name',
                    'bank_name' => 'acc_banks.bank_name',
                    'amnt' => 'acc_transaction_purposes.amount',
                    'employee_name' => 'employee.name',
                    'level_name' => "scms_levels.level_name",
                    'session_name' => "scms_sessions.session_name",
                    'purpose_id' => "acc_purposes.purpose_id",
                    'report_type' => "acc_purposes.report_type",
                    'report_title' => "acc_purposes.report_title",
                    'account_no' => "acc_purposes.acc_no",
                ])
                ->join([
                    'acc_banks' => [
                        'table' => 'acc_banks',
                        'type' => 'INNER',
                        'conditions' => ['acc_banks.bank_id  = acc_transactions.bank_id'],
                    ],
                    'employee' => [
                        'table' => 'users',
                        'type' => 'LEFT',
                        'conditions' => ['employee.id = acc_transactions.employee_id']
                    ],
                    'received' => [
                        'table' => 'users',
                        'type' => 'LEFT',
                        'conditions' => ['received.id = acc_transactions.user_id']
                    ],
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transactions.student_cycle_id = scms_student_cycle.student_cycle_id'
                        ]
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transactions.level_id = scms_levels.level_id'
                        ]
                    ],
                    'scms_sessions' => [
                        'table' => 'scms_sessions',
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transactions.session_id = scms_sessions.session_id'
                        ]
                    ],
                    'acc_transaction_purposes' => [
                        'table' => 'acc_transaction_purposes',
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transaction_purposes.transaction_id = acc_transactions.transaction_id'
                        ]
                    ],
                    'acc_purposes' => [
                        'table' => 'acc_purposes',
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transaction_purposes.purpose_id = acc_purposes.purpose_id'
                        ]
                    ],
                ])
                ->order(['transaction_date' => 'ASC'])
                ->toArray();
            $this->set('transactions', $transactions);
            $this->set('request_data', $request_data);
            $this->autoRender = false;
            $this->layout = 'report';
            $this->render('/reports/bank_statement_report');
        }
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->toArray();
        $this->set('banks', $banks);

        $role = TableRegistry::getTableLocator()->get('roles');
        $roles = $role->find()->toArray();
        $this->set('roles', $roles);
        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);
        $levels = $this->get_levels('accounts');
        $this->set('levels', $levels);
    }

   /* public function balanceReport()
    { //created by @shovon
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $start_date = $request_data['start_date'];
            $end_date = $request_data['end_date'];
            $date1 = date("Y-m-d", strtotime($start_date));
            $date2 = date('Y-m-d', strtotime($end_date));
            $end_date1 = date('Y-m-d', strtotime($date2 . ' + 1 days'));
            $this->set(compact('date1', 'date2'));

            $balance_report = TableRegistry::getTableLocator()->get('acc_transactions');
            $query = $balance_report->find()->where(['transaction_date <' => $date1]);
            $query->select([
                'sum' => $query->func()->sum('amount')
            ])->enableAutoFields(true)->enableHydration(false);
            foreach ($query as $row) {
                $previous_balance = $row['sum'];
            }
            if (!$previous_balance) {
                $previous_balance = 0;
            }
            $this->set('previous_balance', $previous_balance);

            $balance_reports = $balance_report->find()->enableAutoFields(true)->enableHydration(false)->where(['transaction_date >=' => $date1])->where(['transaction_date <' => $end_date1])->toArray();
            $initial['debit'] = 0;
            $initial['credit'] = 0;
            $initial['balance'] = 0;
            $data = [];
            foreach ($balance_reports as $key => $balance) {
                $date = date("Y-m-d", strtotime($balance['transaction_date']));
                if (!isset($data[$date])) {
                    $data[$date] = $initial;
                }

                if ($balance['amount'] > 0) {
                    $data[$date]['credit'] = $data[$date]['credit'] + $balance['amount'];
                } else {
                    $data[$date]['debit'] = $data[$date]['debit'] - $balance['amount'];
                }
                $data[$date]['balance'] = $data[$date]['balance'] + $balance['amount'];
                $data[$date]['date'] = $date;
            }
            usort($data, function ($a, $b) {
                return [$a['date']] <=>
                    [$b['date']];
            });

            $data[0]['total_balance'] = $previous_balance + $data[0]['balance'];
            for ($i = 1; $i < count($data); $i++) {
                $data[$i]['total_balance'] = $data[$i - 1]['total_balance'] + $data[$i]['balance'];
            }
            foreach ($data as $val):
                $crVal[] = $val['credit'];
            endforeach;
            $totalCr = array_sum($crVal);
            $this->set('totalCr', $totalCr);
            foreach ($data as $val):
                $dbVal[] = $val['debit'];
            endforeach;
            $totalDb = array_sum($dbVal);
            $this->set('totalDb', $totalDb);
            $this->set('credits', $data);
            $this->layout = 'report';
            $this->render('/reports/balance_report');
        }
    } */
    
    public function balanceReport()
    { //created by @shovon
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $start_date = $request_data['start_date'];
            $end_date = $request_data['end_date'];
            $date1 = date("Y-m-d", strtotime($start_date));
            $date2 = date('Y-m-d', strtotime($end_date));
            $end_date1 = date('Y-m-d', strtotime($date2 . ' + 1 days'));
            $this->set(compact('date1', 'date2'));

            $balance_report = TableRegistry::getTableLocator()->get('acc_transactions');
            $balance_reports_credit = $balance_report->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['deleted' => 0])
                ->where(['amount !=' => 0])
                ->where(['transaction_type' => 'Credit'])
                ->where(['transaction_date <' => $date1])
                // ->where(['transaction_date <' => $end_date1])
                ->toArray();

            $balance_reports_debit = $balance_report->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['deleted' => 0])
                ->where(['amount !=' => 0])
                ->where(['transaction_type' => 'Debit'])
                ->where(['transaction_date <' => $date1])
                // ->where(['transaction_date <' => $end_date1])
                ->toArray();
            $credit_sum = 0;
            foreach ($balance_reports_credit as $credit) {
                $credit_sum += $credit['amount'];
            }

            $debit_sum = 0;
            foreach ($balance_reports_debit as $debit) {
                $debit_sum += $debit['amount'];
            }
            // pr($credit_sum);
            // pr($debit_sum);
            // die;

            // $credit_sum = array_sum(array_column($balance_reports_credit, 'amount'));
            // $debit_sum = array_sum(array_column($balance_reports_debit, 'amount'));
            $previous_balance = $credit_sum - (-$debit_sum);
            // pr($previous_balance);
            // die;
            $this->set('previous_balance', $previous_balance);

            $balance_reports = $balance_report->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['deleted' => 0])
                ->where(['amount !=' => 0])
                ->where(['transaction_date >=' => $date1])
                ->where(['transaction_date <' => $end_date1])
                ->toArray();
            $initial['debit'] = 0;
            $initial['credit'] = 0;
            $initial['balance'] = 0;
            $data = [];
            foreach ($balance_reports as $key => $balance) {
                $date = date("Y-m-d", strtotime($balance['transaction_date']));
                if (!isset($data[$date])) {
                    $data[$date] = $initial;
                }

                if ($balance['amount'] > 0) {
                    $data[$date]['credit'] = $data[$date]['credit'] + $balance['amount'];
                } else {
                    $data[$date]['debit'] = $data[$date]['debit'] - $balance['amount'];
                }
                $data[$date]['balance'] = $data[$date]['balance'] + $balance['amount'];
                $data[$date]['date'] = $date;
            }
            usort($data, function ($a, $b) {
                return [$a['date']] <=>
                    [$b['date']];
            });

            $data[0]['total_balance'] = $previous_balance + $data[0]['balance'];
            for ($i = 1; $i < count($data); $i++) {
                $data[$i]['total_balance'] = $data[$i - 1]['total_balance'] + $data[$i]['balance'];
            }
            foreach ($data as $val):
                $crVal[] = $val['credit'];
            endforeach;
            $totalCr = array_sum($crVal);
            $this->set('totalCr', $totalCr);
            foreach ($data as $val):
                $dbVal[] = $val['debit'];
            endforeach;
            $totalDb = array_sum($dbVal);
            $this->set('totalDb', $totalDb);
            $this->set('credits', $data);
            $this->layout = 'report';
            $this->render('/reports/balance_report');
        }
    }

    public function twoTakafund()
    { //@shovon
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if (isset($request_data['session_id'])) {
                $where['scms_student_cycle.session_id'] = $request_data['session_id'];
                if ($request_data['shift_id']) {
                    $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
                }
                if ($request_data['level_id']) {
                    $where['scms_student_cycle.level_id'] = $request_data['level_id'];
                }
                if ($request_data['section_id']) {
                    $where['scms_student_cycle.section_id'] = $request_data['section_id'];
                }

                $student = TableRegistry::getTableLocator()->get('scms_student_cycle');
                $students = $student->find()->where($where)->enableAutoFields(true)->enableHydration(false)->select([
                    'name' => "s.name",
                    'sid' => "s.sid",
                ])->join([
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
                $this->set('students', $students);
            } else {
                $tution_fees = $request_data['two_taka_fees'];

                $student = TableRegistry::getTableLocator()->get('acc_transactions');
                foreach ($tution_fees as $key => $tution_fee) {

                    $acc_transactions_data['amount'] = $tution_fee;
                    $acc_transactions_data['voucher_no'] = $this->genarate_vouchers_name();
                    $acc_transactions_data['bank_id'] = 1;
                    $acc_transactions_data['transaction_type'] = 'Credit';
                    $acc_transactions_data['student_cycle_id'] = $key;
                    $acc_transactions_data['note'] = 'Two Taka Fund Collection';
                    $acc_transactions_data['transaction_date'] = strtotime(date('d-m-Y'));
                    $acc_transactions_data_colums = array_keys($acc_transactions_data);

                    $acc_transactions = TableRegistry::getTableLocator()->get('acc_transactions');
                    $query = $acc_transactions->query();
                    $query->insert($acc_transactions_data_colums)->values($acc_transactions_data)->execute();
                }
                $this->Flash->info('Two Taka Collection has Received', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'twoTakafund']);
            }
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->orderDesc('session_name')->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels('accounts');
        $this->set('levels', $levels);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group->find()->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('groups', $groups);
        $shifts = $this->get_shifts('accounts');
        $this->set('shifts', $shifts);
        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);


        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);

        $sections = $this->get_sections('accounts', $levels[0]->level_id);
        $this->set('sections', $sections);
        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles)) {
            $required = '';
        }
        $this->set('required', $required);
    }
    ##++++++++++++++++++++++++++++++
## SHOVON CONTROLLER ENDS
##++++++++++++++++++++++++++++++
##++++++++++++++++++++++++++++++
## AKASH CONTROLLER STARTS
##++++++++++++++++++++++++++++++

    private function find_Khats_months_for_student($student, $month_ids)
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
        $khats_months = $fees_khats->find()->enableAutoFields(true)->enableHydration(false)->where(['level_id' => $student['level_id']])->where(['session_id' => $student['session_id']])->where(['month_id IN' => $month_ids])->where($where)->toArray();
        return $khats_months;
    }

    private function get_vouchers_details($ids, $where = false)
    {
        $acc_vouchers = TableRegistry::getTableLocator()->get('acc_vouchers');
        $vouchers = $acc_vouchers->find()->enableAutoFields(true)->enableHydration(false)->where(['id IN' => $ids])->order(['id' => 'ASC'])->toArray();
        $filter_vouchers = array();
        foreach ($vouchers as $voucher) {
            $filter_vouchers[$voucher['id']] = $voucher;
        }

        $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
        $voucher_purposes = $acc_voucher_purposes->find()->enableAutoFields(true)->enableHydration(false)->where(['voucher_id IN' => $ids])->where($where)->toArray();
        foreach ($voucher_purposes as $voucher_purpose) {
            $filter_vouchers[$voucher_purpose['voucher_id']]['purpose'][$voucher_purpose['month_id']][$voucher_purpose['purpose_id']] = $voucher_purpose;
        }
        return $filter_vouchers;
    }

    public function schoolFees()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $total_amount = array_sum($request_data['purpose_name']);
            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $student = $scms_student_cycle->find()->enableAutoFields(true)->enableHydration(false)->where(['scms_student_cycle.session_id' => $request_data['session_id']])->where(['scms_students.sid' => $request_data['sid']])->join([
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_student_cycle.student_id  = scms_students.student_id'
                    ]
                ],
            ])->toArray();
            $where['payment_status !='] = 1;
            $vouchers_details = $this->get_vouchers_details($request_data['voucher'], $where); //get vouchers info
//request data amount as voucher
            foreach ($request_data['purpose_name'] as $key => $purpose) {
                if ($purpose != 0) {
                    $set_purpose_data[$key] = $purpose;
                }
            }

            $index_voucher_purposes = array();
            $month_ids = array();
            $update_vouchers = array();
            $voucher_ids = array();
            foreach ($vouchers_details as $id => $vouchers_detail) {
                $update_vouchers[$vouchers_detail['id']]['id'] = $single_data['voucher_id'] = $voucher_ids[] = $vouchers_detail['id'];
                $update_vouchers[$vouchers_detail['id']]['payment_amount'] = $update_vouchers[$vouchers_detail['id']]['due_amount'] = $update_vouchers[$vouchers_detail['id']]['discount_amount'] = 0;
                $month_ids = array_merge($month_ids, json_decode($vouchers_detail['month_ids']));
                foreach ($vouchers_detail['purpose'] as $month_purposes) {
                    foreach ($month_purposes as $purposes) {
                        $single_data['purpose_id'] = $purposes['purpose_id'];
                        $single_data['voucher_purpose_id'] = $purposes['voucher_purpose_id'];
                        $single_data['payment_status'] = 1;
                        $single_data['month_id'] = $purposes['month_id'];
                        if ($purposes['payment_status']) {
                            $amount = $purposes['due'];
                        } else {
                            $amount = $purposes['amount'];
                        }
                        if (isset($set_purpose_data[$purposes['purpose_id']])) {
                            if ($amount > $set_purpose_data[$purposes['purpose_id']]) {
                                $single_data['payment_status'] = 2;
                                $single_data['due'] = $amount - $set_purpose_data[$purposes['purpose_id']];
                                $single_data['payment_amount'] = $set_purpose_data[$purposes['purpose_id']];
                                unset($set_purpose_data[$purposes['purpose_id']]);
                            } else {
                                $single_data['due'] = 0;
                                $single_data['payment_status'] = 1;
                                $single_data['payment_amount'] = $amount;
                                $set_purpose_data[$purposes['purpose_id']] = $set_purpose_data[$purposes['purpose_id']] - $amount;
                                if ($set_purpose_data[$purposes['purpose_id']] == 0) {
                                    unset($set_purpose_data[$purposes['purpose_id']]);
                                }
                            }
                        } else {
                            $single_data['payment_amount'] = 0;
                            $single_data['payment_status'] = 2;
                            $single_data['due'] = $amount;
                        }
                        $index_voucher_purposes[$purposes['voucher_id']][$purposes['month_id']][$purposes['purpose_id']] = $single_data;
                    }
                }
            }
            unset($single_data['voucher_purpose_id']);
            //extra amount calculation
            if (count($set_purpose_data)) {
                foreach ($set_purpose_data as $purpose_id => $remaning_amount) {
                    $single_data['purpose_id'] = $purpose_id;
                    if (isset($index_voucher_purposes[$single_data['voucher_id']][$single_data['month_id']][$single_data['purpose_id']])) {
                        $index_voucher_purposes[$single_data['voucher_id']][$single_data['month_id']][$single_data['purpose_id']]['payment_amount'] = $index_voucher_purposes[$single_data['voucher_id']][$single_data['month_id']][$single_data['purpose_id']]['payment_amount'] + $remaning_amount;
                    } else {
                        $single_data['payment_amount'] = $remaning_amount;
                        $single_data['payment_status'] = 1;
                        $single_data['due'] = 0;
                        $index_voucher_purposes[$single_data['voucher_id']][$single_data['month_id']][$single_data['purpose_id']] = $single_data;
                    }
                }
            }

            //discount_amount calculation
            if (isset($request_data['discount_amount']) && $request_data['discount_amount']) {
                $total_amount = $total_amount - $request_data['discount_amount'];
                $discount_amount = $request_data['discount_amount'];
                $AccDiscountId = Configure::read('Acc.Discount.Id');
                $update_vouchers[$vouchers_detail['id']]['discount_amount'] = $request_data['discount_amount'];
                if (isset($index_voucher_purposes[$single_data['voucher_id']][$single_data['month_id']][$AccDiscountId])) {
                    $index_voucher_purposes[$single_data['voucher_id']][$single_data['month_id']][$AccDiscountId]['payment_amount'] = $index_voucher_purposes[$single_data['voucher_id']][$single_data['month_id']][$AccDiscountId]['payment_amount'] - $request_data['discount_amount'];
                } else {
                    $single_data['purpose_id'] = $AccDiscountId;
                    $single_data['payment_amount'] = $request_data['discount_amount'] * -1;
                    $single_data['payment_status'] = 1;
                    $single_data['due'] = 0;
                    $index_voucher_purposes[$single_data['voucher_id']][$single_data['month_id']][$AccDiscountId] = $single_data;
                }
            } else {
                $discount_amount = 0;
            }

            //transection data
            $acc_transactions_data['trn_no'] = $this->genarate_transaction_name();
            $acc_transactions_data['voucher_ids'] = json_encode($voucher_ids);
            $acc_transactions_data['month_ids'] = json_encode($month_ids);
            $acc_transactions_data['amount'] = $total_amount;
            $acc_transactions_data['discount_amount'] = $discount_amount;
            $acc_transactions_data['bank_id'] = $request_data['bank_id'];
            $acc_transactions_data['transaction_type'] = 'Credit';
            $acc_transactions_data['payment_status'] = 1;
            $acc_transactions_data['student_cycle_id'] = $student[0]['student_cycle_id'];
            $acc_transactions_data['level_id'] = $student[0]['level_id'];
            $acc_transactions_data['sid'] = $request_data['sid'];
            $acc_transactions_data['session_id'] = $student[0]['session_id'];
            $acc_transactions_data['status'] = 1;
            $acc_transactions_data['payment_date'] = date("d/m/Y h:i:s A");
            $acc_transactions_data['user_id'] = $this->Auth->user('id');
            $acc_transactions_data['type'] = 'school_fees';

            $ransactions_colums = array_keys($acc_transactions_data);
            $acc_transactions = TableRegistry::getTableLocator()->get('acc_transactions');
            $query = $acc_transactions->query();
            $query->insert($ransactions_colums)->values($acc_transactions_data)->execute();
            $myrecords = $acc_transactions->find()->last();
            $transaction_id = $myrecords->transaction_id;

            $new_voucher_purpose_data = array();
            $transection_purpose_data = array();
            $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');

            //update and set purpose data
            $total_due = array();
            foreach ($index_voucher_purposes as $voucher_id => $month_purposes) {
                foreach ($month_purposes as $month_id => $purposes) {
                    foreach ($purposes as $purpose_id => $purpose) {
                        $transection_purpose_data_single['voucher_id'] = $voucher_id;
                        $transection_purpose_data_single['month_id'] = $month_id;
                        $transection_purpose_data_single['purpose_id'] = $purpose_id;
                        $transection_purpose_data_single['transaction_id'] = $transaction_id;
                        $transection_purpose_data_single['amount'] = $purpose['payment_amount'];
                        if ($transection_purpose_data_single['amount'] != 0) {
                            $transection_purpose_data[] = $transection_purpose_data_single;
                        }
                        $update_vouchers[$voucher_id]['payment_amount'] = $update_vouchers[$voucher_id]['payment_amount'] + $purpose['payment_amount'];
                        $update_vouchers[$voucher_id]['due_amount'] = $update_vouchers[$voucher_id]['due_amount'] + $purpose['due'];
                        if (isset($purpose['voucher_purpose_id'])) {
                            $old_purpose = $acc_voucher_purposes->find()->enableAutoFields(true)->enableHydration(false)->where(['voucher_purpose_id' => $purpose['voucher_purpose_id']])->toArray();
                            $new_data['payment_amount'] = $old_purpose[0]['payment_amount'] + $purpose['payment_amount'];
                            $new_data['due'] = $purpose['due'];
                            $total_due[$purpose['voucher_id']] = isset($total_due[$purpose['voucher_id']]) ? $total_due[$purpose['voucher_id']] + $new_data['due'] : $new_data['due'];
                            $new_data['paid_transaction_id'] = $transaction_id;
                            $new_data['payment_status'] = $purpose['payment_status'];

                            $query = $acc_voucher_purposes->query();
                            $query->update()->set($new_data)->where(['voucher_purpose_id' => $purpose['voucher_purpose_id']])->execute();
                        } else {
                            $new_voucher_purpose_data_single['payment_amount'] = $purpose['payment_amount'];
                            $new_voucher_purpose_data_single['due'] = $purpose['due'];
                            $new_voucher_purpose_data_single['paid_transaction_id'] = $transaction_id;
                            $new_voucher_purpose_data_single['payment_status'] = 1;
                            $new_voucher_purpose_data_single['amount'] = 0;
                            $new_voucher_purpose_data_single['voucher_id'] = $voucher_id;
                            $new_voucher_purpose_data_single['month_id'] = $month_id;
                            $new_voucher_purpose_data_single['purpose_id'] = $purpose_id;
                            $new_voucher_purpose_data[] = $new_voucher_purpose_data_single;
                        }
                    }
                }
            }
            //voucher update
            $acc_vouchers = TableRegistry::getTableLocator()->get('acc_vouchers');
            foreach ($update_vouchers as $voucher_id => $update_voucher) {
                $old_voucher = $acc_vouchers->find()->enableAutoFields(true)->enableHydration(false)->where(['id' => $voucher_id])->toArray();
                $new_voucher_data['payment_amount'] = $old_voucher[0]['payment_amount'] + $update_voucher['payment_amount'];
                $new_voucher_data['due_amount'] = $total_due[$voucher_id];
                $new_voucher_data['discount_amount'] = $old_voucher[0]['discount_amount'] + $update_voucher['discount_amount'];
                if ($new_voucher_data['due_amount']) {
                    $new_voucher_data['payment_status'] = 2;
                } else {
                    $new_voucher_data['payment_status'] = 1;
                }
                $query = $acc_vouchers->query();
                $query->update()->set($new_voucher_data)->where(['id' => $voucher_id])->execute();
            }
            //new purpose data saved
            if (count($new_voucher_purpose_data)) {
                //create acc_voucher_purposes
                $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
                $insertQuery = $acc_voucher_purposes->query();
                $colums = array_keys($new_voucher_purpose_data[0]);
                $insertQuery->insert($colums);
                $insertQuery->clause('values')->values($new_voucher_purpose_data);
                $insertQuery->execute();
            }
            //transection data
            if (count($transection_purpose_data)) {
                //create acc_voucher_purposes
                $acc_transaction_purposes = TableRegistry::getTableLocator()->get('acc_transaction_purposes');
                $insertQuery = $acc_transaction_purposes->query();
                $colums = array_keys($transection_purpose_data[0]);
                $insertQuery->insert($colums);
                $insertQuery->clause('values')->values($transection_purpose_data);
                $insertQuery->execute();
            }
            ##DABIT or CREDIT on the BANK BALANCE
            $get_banks = TableRegistry::getTableLocator()->get('acc_banks');
            $bank = $get_banks->get($request_data['bank_id']);
            $newBalance = $bank->bank_balance + $total_amount;
            $bank->bank_balance = $newBalance;
            $get_banks->save($bank);
            $this->sendCreditSMS($transaction_id);
            $this->redirect(['action' => 'moneyRecpit', $transaction_id]);
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->where(['deleted' => 0])->order(['bank_id' => 'DESC'])->toArray();
        $this->set('banks', $banks);
        $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
        $purposes = $purpose->find()->where(['purpose_id' => 3])->toArray();
        $this->set('purposes', $purposes);
    }

    private function sendCreditSMS($id)
    {
        $acc_transactions = TableRegistry::getTableLocator()->get('acc_transactions');
        $transactions = $acc_transactions->find()->where(['transaction_id' => $id])->enableAutoFields(true)->enableHydration(false)->select([
            'sid' => "scms_students.sid",
            'name' => "scms_students.name",
            'student_id' => "scms_students.student_id",
            'active_guardian' => "scms_students.active_guardian",
            'student_id' => "scms_students.student_id",
        ])->join([
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transactions.student_cycle_id = scms_student_cycle.student_cycle_id'
                        ]
                    ],
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'LEFT',
                        'conditions' => [
                            'scms_students.student_id = scms_student_cycle.student_id'
                        ]
                    ],
                ])->toArray();

        $scms_guardians = TableRegistry::getTableLocator()->get('scms_guardians');
        $guardians = $scms_guardians->find()->where(['student_id' => $transactions[0]['student_id']])->where(['rtype' => $transactions[0]['active_guardian']])->enableAutoFields(true)->enableHydration(false)->toArray();
        $return['name'] = $transactions[0]['name'];
        $return['amount'] = $transactions[0]['amount'];
        $return['mobile'] = $guardians[0]['mobile'];
        if ($return['mobile']) {
            if ($this->send_sms('credit', $array = [], $return)) {
                $this->Flash->success('Sms Sent Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
            }
        }
    }

    public function moneyRecpit($id)
    {
        $where['transaction_type'] = 'Credit';
        $where['acc_transactions.deleted'] = 0;
        $where['acc_transactions.transaction_id'] = $id;
        $checck_transactions = $this->getTransaction($where);
        $this->set('type', $checck_transactions[0]['type']);
        $acc_transactions = TableRegistry::getTableLocator()->get('acc_transactions');
        if ($checck_transactions[0]['type'] == 'school_fees' || $checck_transactions[0]['type'] == 'Student') {
            $transactions = $acc_transactions->find()->where(['transaction_id' => $id])->enableAutoFields(true)->enableHydration(false)->select([
                'student_sid' => "scms_students.sid",
                'name' => "scms_students.name",
                'student_id' => "scms_students.student_id",
                'session_name' => "scms_sessions.session_name",
                'level_name' => "scms_levels.level_name",
            ])->join([
                        'scms_student_cycle' => [
                            'table' => 'scms_student_cycle', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'acc_transactions.student_cycle_id = scms_student_cycle.student_cycle_id' // in which table data is matching
                            ]
                        ],
                        'scms_students' => [
                            'table' => 'scms_students', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'scms_students.student_id = scms_student_cycle.student_id' // in which table data is matching
                            ]
                        ],
                        'scms_sessions' => [
                            'table' => 'scms_sessions', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'acc_transactions.session_id = scms_sessions.session_id' // in which table data is matching
                            ]
                        ],
                        'scms_levels' => [
                            'table' => 'scms_levels', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'acc_transactions.level_id = scms_levels.level_id' // in which table data is matching
                            ]
                        ],
                    ])->toArray();
        } else {
            $transactions = $acc_transactions->find()->where(['transaction_id' => $id])->enableAutoFields(true)->enableHydration(false)->select([
                'name' => "employee.name",
                'session_name' => "scms_sessions.session_name",
            ])->join([
                        'employee' => [
                            'table' => 'employee', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'acc_transactions.employee_id = employee.employee_id' // in which table data is matching
                            ]
                        ],
                        'scms_sessions' => [
                            'table' => 'scms_sessions', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'acc_transactions.session_id = scms_sessions.session_id' // in which table data is matching
                            ]
                        ],
                    ])->toArray();
        }
        $this->set('transactions', $transactions[0]);
        $months = $this->get_months_name_for_Recpit((array) json_decode($transactions[0]['month_ids']), $transactions[0]['session_id']);
        $this->set('months', $months);

        $acc_transaction_purposes = TableRegistry::getTableLocator()->get('acc_transaction_purposes');
        $transaction_purposes = $acc_transaction_purposes->find()->where(['transaction_id' => $id])->enableAutoFields(true)->enableHydration(false)->select([
            'purpose_name' => "acc_purposes.purpose_name",
        ])->join([
                    'acc_purposes' => [
                        'table' => 'acc_purposes', // from which table data is calling
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transaction_purposes.purpose_id = acc_purposes.purpose_id' // in which table data is matching
                        ]
                    ],
                ])->toArray();
        $total = 0;
        $positive = $negative = array();
        foreach ($transaction_purposes as $transaction_purpose) {
            $total = $total + $transaction_purpose['amount'];
            if ($transaction_purpose['amount'] > 0) {
                if (isset($positive[$transaction_purpose['purpose_id']])) {
                    $positive[$transaction_purpose['purpose_id']]['amount'] = $transaction_purpose['amount'] + $positive[$transaction_purpose['purpose_id']]['amount'];
                } else {
                    $positive[$transaction_purpose['purpose_id']] = $transaction_purpose;
                }
            } else {
                if (isset($negative[$transaction_purpose['purpose_id']])) {
                    $negative[$transaction_purpose['purpose_id']]['amount'] = $transaction_purpose['amount'] + $negative[$transaction_purpose['purpose_id']]['amount'];
                } else {
                    $negative[$transaction_purpose['purpose_id']] = $transaction_purpose;
                }
            }
        }
        $purpose = array_merge($positive, $negative);
        $this->set('purpose', $purpose);
        $this->set('total', number_format((float) $total, 2, '.', ''));
        $amount = $this->convertNumberToWord($total) . ' Taka Only';
        $this->set('amount', $amount);

        $users = TableRegistry::getTableLocator()->get('users');
        $user = $users->find()->where(['id' => $transactions[0]['user_id']])->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('user_name', $user[0]['name']);
        $this->layout = 'report';
        $this->autoRender = false;
        $this->render('/reports/moneyRecpit');
    }

    function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array(
            '',
            'One',
            'Two',
            'Three',
            'Four',
            'Five',
            'Six',
            'Seven',
            'Eight',
            'Nine',
            'Ten',
            'Eleven',
            'Twelve',
            'Rhirteen',
            'Fourteen',
            'Fifteen',
            'Sixteen',
            'Seventeen',
            'Eighteen',
            'Nineteen'
        );
        $list2 = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety', 'Hundred');
        $list3 = array(
            '',
            'Thousand',
            'Million',
            'Billion',
            'Trillion',
            'Quadrillion',
            'Quintillion',
            'Sextillion',
            'Septillion',
            'Octillion',
            'Nonillion',
            'Decillion',
            'Undecillion',
            'Duodecillion',
            'Tredecillion',
            'Quattuordecillion',
            'Quindecillion',
            'Sexdecillion',
            'Septendecillion',
            'Octodecillion',
            'Novemdecillion',
            'Vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int) ($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }

    private function get_months_name_for_Recpit($month_ids, $session_id)
    {
        $session = TableRegistry::getTableLocator()->get('scms_sessions'); //Execute First
        $sessions = $session->find()->where(['session_id' => $session_id])->toArray();
        $startTime = strtotime($sessions[0]->start_date);
        $endTime = strtotime($sessions[0]->end_date);
        for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {

            $months[intval(date('m', $i))]['year'] = date('y', $i);
            $months[intval(date('m', $i))]['month'] = date('M', $i);
        }
        $return = null;
        foreach ($months as $id => $month) {
            if (in_array($id, $month_ids)) {
                if ($return) {
                    $return = $return . ', ' . $month['month'] . '-' . $month['year'];
                } else {
                    $return = $month['month'] . '-' . $month['year'];
                }
            }
        }
        return $return;
    }

    private function genarate_vouchers_name()
    {
        ##GENERATE VOUCHER CODE for THE TRANSACTIONS
        $VoucherTable = TableRegistry::getTableLocator()->get('acc_vouchers');
        $voucherPrefix = 'VN';
        $yearMonth = date('Ym');

        $vcd = $VoucherTable->find()->select(['voucher_no'])->order(['voucher_no' => 'DESC'])->first();
        if (empty($vcd)) {
            // If there are no existing voucher records, start with 'VN000001'
            $vCode = $voucherPrefix . $yearMonth . '000001';
        } else {
            // Extract the numeric part of the last voucher number and increment it
            $lastVoucherNo = $vcd->voucher_no;
            $numericPart = substr($lastVoucherNo, -6);
            $datePart = substr($lastVoucherNo, 2, 4);
            $currentYear = substr($yearMonth, 0, 4);
            $val = $numericPart + 1;
            if ($datePart != $currentYear) {
                $vCode = $voucherPrefix . $yearMonth . '000001';
            } else {
                if ($val > 999999) {
                    // If it exceeds, simply append the numeric value after the prefix
                    $vCode = $voucherPrefix . $yearMonth . $val;
                } else {
                    // If it doesn't exceed, format it with leading zeros
                    $vCode = $voucherPrefix . $yearMonth . sprintf("%06d", $val);
                }
            }
        }
        return $vCode;
    }

    public function individualVoucher()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $months = $request_data['month'];
            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $find_student = $scms_student_cycle->find()->enableAutoFields(true)->enableHydration(false)->where(['scms_student_cycle.session_id' => $request_data['session_id']])->where(['scms_students.sid' => $request_data['sid']])->join([
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_student_cycle.student_id  = scms_students.student_id'
                    ]
                ],
            ])->toArray();
            $student = $find_student[0];

            $set_khats = $this->find_purpose_khat($request_data);
            $purpose_data = array();
            foreach ($request_data['purpose_name'] as $key => $amount) {
                if ($amount > 0) {
                    $purpose_data[$key] = $amount;
                }
            }
            $total_amount = array_sum($purpose_data);
            $total_month = count($set_khats);
            $last = 1;
            $voucher_purpose_data = array();
            foreach ($set_khats as $month_id => $set_khat_months) {
                if ($last == $total_month) {
                    $voucher_purpose_single['month_id'] = $month_id;
                    foreach ($purpose_data as $purpose_id => $amount) {
                        $voucher_purpose_single['purpose_id'] = $purpose_id;
                        $voucher_purpose_single['amount'] = $amount;
                        $voucher_purpose_data[] = $voucher_purpose_single;
                    }
                } else {
                    $last++;
                    if ($student['group_id'] && $student['shift_id']) {
                        if (count($set_khat_months['shift_group'][$student['shift_id']][$student['group_id']])) {
                            $return_data = $this->purpose_total_for_indivisul_voucher($student, $purpose_data, $set_khat_months['shift_group'][$student['shift_id']][$student['group_id']], $month_id);
                        } else if (count($set_khat_months['group'][$student['group_id']])) {
                            $return_data = $this->purpose_total_for_indivisul_voucher($student, $purpose_data, $set_khat_months['group'][$student['group_id']], $month_id);
                        } else if (count($set_khat_months['shift'][$student['shift_id']])) {
                            $return_data = $this->purpose_total_for_indivisul_voucher($student, $purpose_data, $set_khat_months['shift'][$student['shift_id']], $month_id);
                        } else if (count($set_khat_months['level'][$student['level_id']])) {
                            $return_data = $this->purpose_total_for_indivisul_voucher($student, $purpose_data, $set_khat_months['level'][$student['level_id']], $month_id);
                        }
                    } else if ($student['group_id'] && $student['shift_id'] == null) {
                        if (count($set_khat_months['group'][$student['group_id']])) {
                            $return_data = $this->purpose_total_for_indivisul_voucher($student, $purpose_data, $set_khat_months['group'][$student['group_id']], $month_id);
                        } else if (count($set_khat_months['shift'][$student['shift_id']])) {
                            $return_data = $this->purpose_total_for_indivisul_voucher($student, $purpose_data, $set_khat_months['shift'][$student['shift_id']], $month_id);
                        } else if (count($set_khat_months['level'][$student['level_id']])) {
                            $return_data = $this->purpose_total_for_indivisul_voucher($student, $purpose_data, $set_khat_months['level'][$student['level_id']], $month_id);
                        }
                    } else if ($student['shift_id'] && $student['group_id'] == null) {
                        if (count($set_khat_months['shift'][$student['shift_id']])) {
                            $return_data = $this->purpose_total_for_indivisul_voucher($student, $purpose_data, $set_khat_months['shift'][$student['shift_id']], $month_id);
                        } else if (count($set_khat_months['level'][$student['level_id']])) {
                            $return_data = $this->purpose_total_for_indivisul_voucher($student, $purpose_data, $set_khat_months['level'][$student['level_id']], $month_id);
                        }
                    } else {
                        if (count($set_khat_months['level'][$student['level_id']])) {
                            $return_data = $this->purpose_total_for_indivisul_voucher($student, $purpose_data, $set_khat_months['level'][$student['level_id']], $month_id);
                        }
                    }
                    $voucher_purpose_data = array_merge($voucher_purpose_data, $return_data['set_purposes']);
                    $purpose_data = $return_data['purposes_data'];
                }
            }
            //discount calculation start
            if (isset($request_data['discount_amount']) && $request_data['discount_amount']) {
                $voucher_data['discount_amount'] = $request_data['discount_amount'];
                $AccDiscountId = Configure::read('Acc.Discount.Id');
                $voucher_purpose_single['month_id'] = $month_id;
                $voucher_purpose_single['purpose_id'] = $AccDiscountId;
                $voucher_purpose_single['amount'] = $request_data['discount_amount'] * -1;
                $voucher_purpose_data[] = $voucher_purpose_single;
                $total_amount = $total_amount - $request_data['discount_amount'];
            }
            $voucher_data['voucher_no'] = $this->genarate_vouchers_name();
            $voucher_data['amount'] = $total_amount;
            $voucher_data['student_cycle_id'] = $student['student_cycle_id'];
            $voucher_data['level_id'] = $student['level_id'];
            $voucher_data['sid'] = $request_data['sid'];
            $voucher_data['session_id'] = $student['session_id'];
            $voucher_data['month_ids'] = json_encode($months);
            $voucher_data['voucher_create_by'] = $this->Auth->user('id');

            $colums = array_keys($voucher_data);
            $acc_vouchers = TableRegistry::getTableLocator()->get('acc_vouchers');
            $query = $acc_vouchers->query();
            $query->insert($colums)->values($voucher_data)->execute();

            $myrecords = $acc_vouchers->find()->last();
            $id = $myrecords->id;

            foreach ($voucher_purpose_data as $key => $purpose) {
                $voucher_purpose_data[$key]['voucher_id'] = $id;
            }
            if (count($voucher_purpose_data) > 0) {
                //insert acc_transaction_purposes start
                $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
                $insertQuery = $acc_voucher_purposes->query();
                $acc_transaction_purposes_colums = array_keys($voucher_purpose_data[0]);
                $insertQuery->insert($acc_transaction_purposes_colums);
                $insertQuery->clause('values')->values($voucher_purpose_data);
                $insertQuery->execute();
                //end  acc_transaction_purposes
            }
            $this->Flash->success('Student Voucher Generate Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'unpaidVouchers']);
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);
    }

    public function voucherGenerate()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();

            if (!isset($request_data['month'])) {
                $this->Flash->error('No month is seleted!', [
                    'key' => 'Negative',
                    'params' => [],
                ]);

                return $this->redirect(['action' => 'voucherGenerate']);
            }
            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $students = $scms_student_cycle->find()->where(['scms_student_cycle.level_id' => $request_data['level_id']])->where(['scms_students.status' => 1])->where(['scms_student_cycle.session_id' => $request_data['session_id']])->enableAutoFields(true)->enableHydration(false)->select([
                'name' => "scms_students.name",
                'roll' => "scms_student_cycle.roll",
                'sid' => "scms_students.sid",
                'level_name' => "scms_levels.level_name",
                'session_name' => "scms_sessions.session_name",
                'group_name' => "scms_groups.group_name",
            ])->join([
                        'scms_students' => [
                            'table' => 'scms_students',
                            'type' => 'INNER',
                            'conditions' => [
                                'scms_student_cycle.student_id  = scms_students.student_id'
                            ]
                        ],
                        'scms_sessions' => [
                            'table' => 'scms_sessions',
                            'type' => 'INNER',
                            'conditions' => [
                                'scms_student_cycle.session_id  = scms_sessions.session_id'
                            ]
                        ],
                        'scms_levels' => [
                            'table' => 'scms_levels',
                            'type' => 'INNER',
                            'conditions' => [
                                'scms_student_cycle.level_id  = scms_levels.level_id'
                            ]
                        ],
                        'scms_groups' => [
                            'table' => 'scms_groups',
                            'type' => 'LEFT',
                            'conditions' => [
                                'scms_student_cycle.group_id  = scms_groups.group_id'
                            ]
                        ]
                    ])->toArray();

            $acc_voucher_create_log['level_id'] = $basic_info['level_id'] = $request_data['level_id'];
            $acc_voucher_create_log['session_id'] = $basic_info['session_id'] = $request_data['session_id'];
            $acc_voucher_create_log['months'] = $basic_info['month_ids'] = json_encode($request_data['month']);
            $acc_voucher_create_log['created_by'] = $basic_info['voucher_create_by'] = $this->Auth->user('id');
            $basic_info['payment_status'] = 0;
            $basic_info['amount'] = 0;
            $set_khats = $this->find_purpose_khat($request_data);
            $voucher_data = array();
            foreach ($students as $student) {
                if (!isset($voucher_data[$student['student_cycle_id']])) {
                    $basic_info['student_cycle_id'] = $student['student_cycle_id'];
                    $basic_info['sid'] = $student['sid'];
                    $voucher_data[$student['student_cycle_id']]['voucher'] = $basic_info;
                    $student['amount'] = 0;
                    $voucher_data[$student['student_cycle_id']]['view'] = $student;
                    $voucher_data[$student['student_cycle_id']]['purpose_data'] = array();
                    $voucher_data[$student['student_cycle_id']]['voucher_purpose_data'] = array();
                }
                foreach ($set_khats as $month_id => $set_khat_months) {
                    if ($student['group_id'] && $student['shift_id']) {
                        if (count($set_khat_months['shift_group'][$student['shift_id']][$student['group_id']])) {
                            $voucher_data[$student['student_cycle_id']] = $this->purpose_total_for_voucher($voucher_data[$student['student_cycle_id']], $set_khat_months['shift_group'][$student['shift_id']][$student['group_id']], $month_id);
                        } else if (count($set_khat_months['group'][$student['group_id']])) {
                            $voucher_data[$student['student_cycle_id']] = $this->purpose_total_for_voucher($voucher_data[$student['student_cycle_id']], $set_khat_months['group'][$student['group_id']], $month_id);
                        } else if (count($set_khat_months['shift'][$student['shift_id']])) {
                            $voucher_data[$student['student_cycle_id']] = $this->purpose_total_for_voucher($voucher_data[$student['student_cycle_id']], $set_khat_months['shift'][$student['shift_id']], $month_id);
                        } else if (count($set_khat_months['level'][$student['level_id']])) {
                            $voucher_data[$student['student_cycle_id']] = $this->purpose_total_for_voucher($voucher_data[$student['student_cycle_id']], $set_khat_months['level'][$student['level_id']], $month_id);
                        }
                    } else if ($student['group_id'] && $student['shift_id'] == null) {
                        if (count($set_khat_months['group'][$student['group_id']])) {
                            $voucher_data[$student['student_cycle_id']] = $this->purpose_total_for_voucher($voucher_data[$student['student_cycle_id']], $set_khat_months['group'][$student['group_id']], $month_id);
                        } else if (count($set_khat_months['shift'][$student['shift_id']])) {
                            $voucher_data[$student['student_cycle_id']] = $this->purpose_total_for_voucher($voucher_data[$student['student_cycle_id']], $set_khat_months['shift'][$student['shift_id']], $month_id);
                        } else if (count($set_khat_months['level'][$student['level_id']])) {
                            $voucher_data[$student['student_cycle_id']] = $this->purpose_total_for_voucher($voucher_data[$student['student_cycle_id']], $set_khat_months['level'][$student['level_id']], $month_id);
                        }
                    } else if ($student['shift_id'] && $student['group_id'] == null) {
                        if (count($set_khat_months['shift'][$student['shift_id']])) {
                            $voucher_data[$student['student_cycle_id']] = $this->purpose_total_for_voucher($voucher_data[$student['student_cycle_id']], $set_khat_months['shift'][$student['shift_id']], $month_id);
                        } else if (count($set_khat_months['level'][$student['level_id']])) {
                            $voucher_data[$student['student_cycle_id']] = $this->purpose_total_for_voucher($voucher_data[$student['student_cycle_id']], $set_khat_months['level'][$student['level_id']], $month_id);
                        }
                    } else {
                        if (count($set_khat_months['level'][$student['level_id']])) {
                            $voucher_data[$student['student_cycle_id']] = $this->purpose_total_for_voucher($voucher_data[$student['student_cycle_id']], $set_khat_months['level'][$student['level_id']], $month_id);
                        }
                    }
                }
            }
           /* if (isset($request_data['save'])) {
                //create acc_voucher_create_log
                $acc_voucher_create_log_data[0] = $acc_voucher_create_log;
                $acc_voucher_create_log = TableRegistry::getTableLocator()->get('acc_voucher_create_log');
                $insertQuery_acc_voucher_create_log = $acc_voucher_create_log->query();
                $colums = array_keys($acc_voucher_create_log_data[0]);
                $insertQuery_acc_voucher_create_log->insert($colums);
                $insertQuery_acc_voucher_create_log->clause('values')->values($acc_voucher_create_log_data);
                $insertQuery_acc_voucher_create_log->execute();
                $last = $acc_voucher_create_log->find()->last();
                $acc_voucher_create_log_id = $last->voucher_create_log_id;
                //Set Flash
                $voucher_purpose_array = array();
                foreach ($voucher_data as $voucher) {
                    $voucher['voucher']['voucher_no'] = $this->genarate_vouchers_name();
                    $voucher['voucher']['acc_voucher_create_log_id'] = $acc_voucher_create_log_id;
                    //insert $transection start
                    $acc_vouchers = TableRegistry::getTableLocator()->get('acc_vouchers');
                    $insertQuery = $acc_vouchers->query();
                    $single_voucher[0] = $voucher['voucher'];
                    $colums = array_keys($single_voucher[0]);
                    $insertQuery->insert($colums);
                    $insertQuery->clause('values')->values($single_voucher);
                    $insertQuery->execute();
                    $myrecords = $acc_vouchers->find()->last();
                    $voucher_purpose_array_single['voucher_id'] = $myrecords->id;

                    foreach ($voucher['voucher_purpose_data'] as $purpose) {
                        $voucher_purpose_array_single['purpose_id'] = $purpose['purpose_id'];
                        $voucher_purpose_array_single['amount'] = $purpose['amount'];
                        $voucher_purpose_array_single['month_id'] = $purpose['month_id'];
                        $voucher_purpose_array[] = $voucher_purpose_array_single;
                    }
                }
                if (count($voucher_purpose_array)) {
                    //create acc_voucher_purposes
                    $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
                    $insertQuery = $acc_voucher_purposes->query();
                    $colums = array_keys($voucher_purpose_array[0]);
                    $insertQuery->insert($colums);
                    $insertQuery->clause('values')->values($voucher_purpose_array);
                    $insertQuery->execute();
                }


                $this->Flash->success('Student Voucher Generated Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'voucherGenerate']);
            } else {
                $this->set('voucher_data', $voucher_data);
                $this->set('level_id', $request_data['level_id']);
                $this->set('session_id', $request_data['session_id']);
                $this->set('set_months', $request_data['month']);
                $months = $this->getMonthsForVoucher($request_data);
                $this->set('months', $months);
            } */
            
            if (isset($request_data['save'])) {
                //create acc_voucher_create_log
                $acc_voucher_create_log_data[0] = $acc_voucher_create_log;
                $acc_voucher_create_log = TableRegistry::getTableLocator()->get('acc_voucher_create_log');
                $insertQuery_acc_voucher_create_log = $acc_voucher_create_log->query();
                $colums = array_keys($acc_voucher_create_log_data[0]);
                $insertQuery_acc_voucher_create_log->insert($colums);
                $insertQuery_acc_voucher_create_log->clause('values')->values($acc_voucher_create_log_data);
                $insertQuery_acc_voucher_create_log->execute();
                $last = $acc_voucher_create_log->find()->last();
                $acc_voucher_create_log_id = $last->voucher_create_log_id;
                
                // Optimize: Get table registry once outside the loop
                $acc_vouchers = TableRegistry::getTableLocator()->get('acc_vouchers');
                
                // Optimize: Generate all voucher numbers upfront to reduce DB queries
                $voucher_numbers = array();
                $first_voucher_no = $this->genarate_vouchers_name();
                $voucherPrefix = 'VN';
                $yearMonth = date('Ym');
                
                // Extract base number from first voucher and generate subsequent ones in memory
                $numericPart = substr($first_voucher_no, -6);
                $baseNumber = intval($numericPart);
                $voucher_count = count($voucher_data);
                
                for ($i = 0; $i < $voucher_count; $i++) {
                    $num = $baseNumber + $i;
                    if ($num > 999999) {
                        $voucher_numbers[] = $voucherPrefix . $yearMonth . $num;
                    } else {
                        $voucher_numbers[] = $voucherPrefix . $yearMonth . sprintf("%06d", $num);
                    }
                }
                
                // Batch prepare all voucher data
                $batch_voucher_data = array();
                $voucher_purpose_array = array();
                $voucher_index = 0;
                
                foreach ($voucher_data as $student_cycle_id => $voucher) {
                    $voucher['voucher']['voucher_no'] = $voucher_numbers[$voucher_index];
                    $voucher['voucher']['acc_voucher_create_log_id'] = $acc_voucher_create_log_id;
                    $batch_voucher_data[] = $voucher['voucher'];
                    $voucher_index++;
                }
                
                // Batch insert all vouchers at once
                if (count($batch_voucher_data) > 0) {
                    $insertQuery = $acc_vouchers->query();
                    $colums = array_keys($batch_voucher_data[0]);
                    $insertQuery->insert($colums);
                    $insertQuery->clause('values')->values($batch_voucher_data);
                    $insertQuery->execute();
                    
                    // Get all inserted voucher IDs in one query
                    $inserted_vouchers = $acc_vouchers->find()
                        ->select(['id', 'student_cycle_id'])
                        ->where(['acc_voucher_create_log_id' => $acc_voucher_create_log_id])
                        ->toArray();
                    
                    // Create a mapping of student_cycle_id to voucher_id using the actual student_cycle_id
                    $voucher_id_map = array();
                    foreach ($inserted_vouchers as $inserted_voucher) {
                        $voucher_id_map[$inserted_voucher->student_cycle_id] = $inserted_voucher->id;
                    }
                    
                    // Build voucher purpose array with correct voucher_ids
                    foreach ($voucher_data as $student_cycle_id => $voucher) {
                        $voucher_id = $voucher_id_map[$student_cycle_id];
                        foreach ($voucher['voucher_purpose_data'] as $purpose) {
                            $voucher_purpose_array[] = array(
                                'voucher_id' => $voucher_id,
                                'purpose_id' => $purpose['purpose_id'],
                                'amount' => $purpose['amount'],
                                'month_id' => $purpose['month_id']
                            );
                        }
                    }
                }
                
                // Batch insert all voucher purposes
                if (count($voucher_purpose_array)) {
                    $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
                    $insertQuery = $acc_voucher_purposes->query();
                    $colums = array_keys($voucher_purpose_array[0]);
                    $insertQuery->insert($colums);
                    $insertQuery->clause('values')->values($voucher_purpose_array);
                    $insertQuery->execute();
                }


                $this->Flash->success('Student Voucher Generated Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'voucherGenerate']);
            } else {
                $this->set('voucher_data', $voucher_data);
                $this->set('level_id', $request_data['level_id']);
                $this->set('session_id', $request_data['session_id']);
                $this->set('set_months', $request_data['month']);
                $months = $this->getMonthsForVoucher($request_data);
                $this->set('months', $months);
            }
            
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->order(['session_name' => 'DESC'])->toArray();
        $this->set('sessions', $sessions);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level->find()->toArray();
        $this->set('levels', $levels);
    }

    public function getMonthsForVoucher($request_data)
    {
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session->find()->enableAutoFields(true)->enableHydration(false)->where(['session_id' => $request_data['session_id']])->toArray();
        $months = array();

        $first_date = date("Y-m-d", strtotime($sessions[0]['start_date']));
        $last_day = date("Y-m-t", strtotime($sessions[0]['end_date']));
        $datediff = strtotime($last_day) - strtotime($first_date);
        $datediff = floor($datediff / (60 * 60 * 24));
        $months = array();
        $month_id = array();
        for ($i = 0; $i < $datediff + 1; $i++) {
            $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['name'] = date("F", strtotime($first_date . ' + ' . $i . 'day'));
            $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['id'] = (date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1;
            $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['checkd'] = null;
            $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['set'] = null;
            $months[(date("m", strtotime($first_date . ' + ' . $i . 'day'))) * 1]['setup'] = null;
            $i = $i + 28;
        }
        $acc_voucher_create_log = TableRegistry::getTableLocator()->get('acc_voucher_create_log');
        $voucher_logs = $acc_voucher_create_log->find()->enableAutoFields(true)->enableHydration(false)->where(['session_id' => $request_data['session_id']])->where(['level_id' => $request_data['level_id']])->toArray();

        foreach ($voucher_logs as $voucher_log) {
            $setmonths = json_decode($voucher_log['months']);
            foreach ($setmonths as $setmonth) {
                $months[$setmonth]['checkd'] = 1;
            }
        }

        $fees_khats = TableRegistry::getTableLocator()->get('acc_fees_khats');
        $khats_months = $fees_khats->find()->enableAutoFields(true)->enableHydration(false)->where(['session_id' => $request_data['session_id']])->where(['level_id' => $request_data['level_id']])->toArray();
        foreach ($khats_months as $khat) {
            $months[$khat['month_id']]['set'] = 1;
        }
        if (isset($request_data['month'])) {
            foreach ($request_data['month'] as $id) {
                $months[$id]['setup'] = 1;
            }
        }

        return $months;
    }

    private function purpose_total_for_indivisul_voucher($student, $purposes, $set_khat, $month_id)
    {
        $voucher_purpose_single['month_id'] = $month_id;
        $return['set_purposes'] = array();
        $set_purpose = array();
        foreach ($set_khat as $set_khat_purpose) {
            if (isset($purposes[$set_khat_purpose['purpose_id']])) {
                $voucher_purpose_single['purpose_id'] = $set_khat_purpose['purpose_id'];
                if ($student['tuition_fee_status'] && $set_khat_purpose['scholarship']) {
                    $amount = $set_khat_purpose['amount'] - ($set_khat_purpose['amount'] * $student['tuition_fee_status']) / 100;
                } else {
                    $amount = $set_khat_purpose['amount'];
                }
                if ($amount < $purposes[$set_khat_purpose['purpose_id']]) {
                    $voucher_purpose_single['amount'] = $amount;
                    $purposes[$set_khat_purpose['purpose_id']] = $purposes[$set_khat_purpose['purpose_id']] - $amount;
                } else {
                    $voucher_purpose_single['amount'] = $amount;
                    unset($purposes[$set_khat_purpose['purpose_id']]);
                }
                $set_purposes[$set_khat_purpose['purpose_id']] = $voucher_purpose_single;
            }
        }
        $where['student_cycle_id'] = $student['student_cycle_id'];
        $where['level_id'] = $student['level_id'];
        $where['session_id'] = $student['session_id'];
        $where['month_id'] = $month_id;
        //additional fees start
        $additional_fees = $this->getStudnetAdditionalFess($where);
        foreach ($additional_fees as $additional_fee) {
            if (isset($purposes[$additional_fee['purpose_id']])) {
                $voucher_purpose_single['purpose_id'] = $additional_fee['purpose_id'];
                $amount = $additional_fee['fees_value'];
                if ($amount < $purposes[$additional_fee['purpose_id']]) {
                    $voucher_purpose_single['amount'] = $amount;
                    $purposes[$additional_fee['purpose_id']] = $purposes[$additional_fee['purpose_id']] - $amount;
                } else {
                    $voucher_purpose_single['amount'] = $amount;
                    unset($purposes[$additional_fee['purpose_id']]);
                }
                if (isset($set_purposes[$additional_fee['purpose_id']])) {
                    $set_purposes[$additional_fee['purpose_id']]['amount'] = $set_purposes[$additional_fee['purpose_id']]['amount'] + $voucher_purpose_single['amount'];
                } else {
                    $set_purposes[$additional_fee['purpose_id']] = $voucher_purpose_single;
                }
            }
        }
        //additional fees end
        $return['set_purposes'] = array_values($set_purposes);
        $return['purposes_data'] = $purposes;
        return $return;
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

    private function purpose_total_for_voucher($student, $purposes, $month_id)
    {
        $voucher_purpose_single['month_id'] = $month_id;
        $total = 0;
        foreach ($purposes as $purpose) {
            $single_purpose['purpose_id'] = $voucher_purpose_single['purpose_id'] = $purpose['purpose_id'];
            if ($student['view']['tuition_fee_status'] && $purpose['scholarship']) {
                $total = $total + $purpose['amount'] - ($purpose['amount'] * $student['view']['tuition_fee_status']) / 100;
                $voucher_purpose_single['amount'] = $single_purpose['amount'] = $purpose['amount'] - ($purpose['amount'] * $student['view']['tuition_fee_status']) / 100;
            } else {
                $total = $total + $purpose['amount'];
                $voucher_purpose_single['amount'] = $single_purpose['amount'] = $purpose['amount'];
            }
            if ($single_purpose['amount']) {
                if (isset($student['purpose_data'][$single_purpose['purpose_id']])) {
                    $student['purpose_data'][$single_purpose['purpose_id']]['amount'] = $student['purpose_data'][$single_purpose['purpose_id']]['amount'] + $purpose['amount'];
                } else {
                    $student['purpose_data'][$single_purpose['purpose_id']] = $single_purpose;
                }
            }
            $student['voucher_purpose_data'][] = $voucher_purpose_single;
        }
        $where['student_cycle_id'] = $student['view']['student_cycle_id'];
        $where['level_id'] = $student['view']['level_id'];
        $where['session_id'] = $student['view']['session_id'];
        $where['month_id'] = $month_id;
        //additional fees start
        $additional_fees = $this->getStudnetAdditionalFess($where);
        foreach ($additional_fees as $additional_fee) {
            $single_purpose['purpose_id'] = $voucher_purpose_single['purpose_id'] = $additional_fee['purpose_id'];
            $total = $total + $additional_fee['fees_value'];
            $voucher_purpose_single['amount'] = $single_purpose['amount'] = $additional_fee['fees_value'];
            if ($single_purpose['amount']) {
                if (isset($student['purpose_data'][$single_purpose['purpose_id']])) {
                    $student['purpose_data'][$single_purpose['purpose_id']]['amount'] = $student['purpose_data'][$single_purpose['purpose_id']]['amount'] + $purpose['amount'];
                } else {
                    $student['purpose_data'][$single_purpose['purpose_id']] = $single_purpose;
                }
            }
            $student['voucher_purpose_data'][] = $voucher_purpose_single;
        }
        //additional fees end
        $student['view']['amount'] = $student['view']['amount'] + $total;
        $student['voucher']['amount'] = $student['voucher']['amount'] + $total;
        return $student;
    }

    private function find_purpose_khat($request_data)
    {
        $where['session_id'] = $request_data['session_id'];
        $where['level_id'] = $request_data['level_id'];
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift->find()->toArray();
        $scms_group = TableRegistry::getTableLocator()->get('scms_groups');
        $scms_groups = $scms_group->find()->toArray();

        $purpose_data = array();
        foreach ($request_data['month'] as $month_id) {
            $where['month_id'] = $month_id;
            foreach ($shifts as $shift) {
                foreach ($scms_groups as $scms_group) {
                    $where['shift_id'] = $shift->shift_id;
                    $where['group_id'] = $scms_group->group_id;
                    $purpose_data[$month_id]['shift_group'][$shift->shift_id][$scms_group->group_id] = $this->find_all_setup_Khats_for_months($where);
                }
                $where['shift_id'] = $shift->shift_id;
                $where['group_id'] = 0;
                $purpose_data[$month_id]['shift'][$shift->shift_id] = $this->find_all_setup_Khats_for_months($where);
            }
            foreach ($scms_groups as $scms_group) {
                $where['shift_id'] = 0;
                $where['group_id'] = $scms_group->group_id;
                $purpose_data[$month_id]['group'][$scms_group->group_id] = $this->find_all_setup_Khats_for_months($where);
            }
            $where['shift_id'] = 0;
            $where['group_id'] = 0;
            $purpose_data[$month_id]['level'][$request_data['level_id']] = $this->find_all_setup_Khats_for_months($where);
        }
        return $purpose_data;
    }

    private function find_all_setup_Khats_for_months($where)
    {
        $fees_khats = TableRegistry::getTableLocator()->get('acc_fees_khats');
        $khats_months = $fees_khats->find()->enableAutoFields(true)->enableHydration(false)->where($where)->toArray();
        if (count($khats_months)) {
            $ids = array();
            foreach ($khats_months as $khats_month) {
                $ids[] = $khats_month['id'];
            }
            $acc_fees_khat_purpose_amount = TableRegistry::getTableLocator()->get('acc_fees_khat_purpose_amount');
            $purpose_amounts = $acc_fees_khat_purpose_amount->find()->enableAutoFields(true)->enableHydration(false)->where(['fees_khat_id IN' => $ids])->toArray();
            return $purpose_amounts;
        } else {
            return $khats_months;
        }
    }

    private function getVouchesInfo($where)
    {
        $data = TableRegistry::getTableLocator()->get('acc_vouchers');
        $vouchers = $data->find()->where($where)->enableAutoFields(true)->enableHydration(false)->order(['acc_vouchers.id' => 'DESC'])->toArray();
        return $vouchers;
    }

    public function deleteVoucher($id)
    {
        $where['id'] = $id;
        $vouchers = $this->getVouchesInfo($where);
        if ($vouchers[0]['payment_status'] == 0) {
            $voucher_data['deleted'] = 1;
            $voucher_data['deleted_by'] = $this->Auth->user('id');
            $data = TableRegistry::getTableLocator()->get('acc_vouchers');
            $query = $data->query();
            $query->update()->set($voucher_data)->where(['id' => $id])->execute();
            //Set Flash
            $this->Flash->success('Voucher Deleted Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
        } else {
            $this->Flash->error('No Voucher Found', [
                'key' => 'positive',
                'params' => [],
            ]);
        }
        return $this->redirect(['action' => 'unpaidVouchers']);
    }

    public function unpaidVouchers()
    {
        $request_data = array();
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (isset($request_data['session']) && $request_data['session']) {
                $where['acc_vouchers.session_id'] = $request_data['session'];
            }
            if (isset($request_data['sid']) && $request_data['sid']) {
                $where['acc_vouchers.sid'] = $request_data['sid'];
            }
            if (isset($request_data['level_id']) && $request_data['level_id']) {
                $where['acc_vouchers.level_id'] = $request_data['level_id'];
            }
            if ($request_data['start_date']) {
                if ($request_data['end_date']) {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                } else {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                }
                $where['create_date >='] = $request_data['start_date'];
                $where['create_date <'] = $request_data['end_date'];
            }
        }

        $where['deleted'] = 0;
        $payment_status[] = 0;
        $payment_status[] = 2;


        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (!in_array($role_id, $roles)) {
            $id = $this->Auth->user('id');
            $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $permissions = $employees_permission->find()
                ->where(['user_id' => $id])
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
            $section_ids = array();
            foreach ($permissions as $permission) {
                $section_ids[$permission['section_id']] = $permission['section_id'];
            }
            if (count($section_ids)) {
                $section_ids = array_values($section_ids);
                $where['scms_student_cycle.section_id IN'] = $section_ids;
            } else {
                $where['payment_status'] = -1;
            }
        }
        $data = TableRegistry::getTableLocator()->get('acc_vouchers');
        $vouchers = $data->find()->where($where)->where(['payment_status IN' => $payment_status])->enableAutoFields(true)->enableHydration(false)->select([
            'name' => "scms_students.name",
            'level_name' => "scms_levels.level_name",
            'session_name' => "scms_sessions.session_name",
            'roll' => "scms_student_cycle.roll",
            'section_name' => "scms_sections.section_name",
        ])->order(['acc_vouchers.id' => 'DESC'])->join([
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_vouchers.sid = scms_students.sid'
                        ]
                    ],
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
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
                            'acc_vouchers.level_id = scms_levels.level_id'
                        ]
                    ],
                    'scms_sessions' => [
                        'table' => 'scms_sessions',
                        'type' => 'INNER',
                        'conditions' => [
                            'acc_vouchers.session_id = scms_sessions.session_id'
                        ]
                    ],
                    'scms_sections' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_student_cycle.section_id = scms_sections.section_id'
                        ]
                    ],
                ])->toArray();
        $month = TableRegistry::getTableLocator()->get('acc_months');
        $months = $month->find()->enableAutoFields(true)->enableHydration(false)->toArray();
        foreach ($months as $month) {
            $filter_months[$month['id']] = $month['month_name'];
        }
        foreach ($vouchers as $key => $voucher) {
            if ($voucher['payment_status'] == 0) {
                $vouchers[$key]['status'] = 'Unpaid';
                $vouchers[$key]['show_amount'] = $voucher['amount'];
            } else {
                $vouchers[$key]['status'] = 'Partially paid';
                $vouchers[$key]['show_amount'] = $voucher['due_amount'];
            }
            $month_ids = json_decode($voucher['month_ids']);
            foreach ($month_ids as $month_id) {
                if (isset($vouchers[$key]['month_name'])) {
                    $vouchers[$key]['month_name'] = $vouchers[$key]['month_name'] . ',' . substr($filter_months[$month_id], 0, 3);
                } else {
                    $vouchers[$key]['month_name'] = substr($filter_months[$month_id], 0, 3);
                }
            }
        }
        $this->set('vouchers', $vouchers);
        $bank = TableRegistry::getTableLocator()->get('acc_banks');
        $banks = $bank->find()->toArray();
        $this->set('banks', $banks);
        $role = TableRegistry::getTableLocator()->get('roles');
        $roles = $role->find()->toArray();
        $this->set('roles', $roles);
        $levels = $this->get_levels('accounts');
        $this->set('levels', $levels);

        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions->find()->toArray();
        $this->set('sessions', $sessions);
        $this->set('request_data', $request_data);
    }

    private function genarate_transaction_name()
    {
        ##GENERATE VOUCHER CODE for THE TRANSACTIONS
        $acc_transactions_name = TableRegistry::getTableLocator()->get('acc_transactions_name');
        $Prefix = 'TRN';
        $yearMonth = date('Ym');

        $trn = $acc_transactions_name->find()->order(['id' => 'DESC'])->first();
        if (empty($trn)) {
            // If there are no existing voucher records, start with 'VN000001'
            $TrnCode = $Prefix . $yearMonth . '000001';
        } else {
            // Extract the numeric part of the last voucher number and increment it
            $lastTrn = $trn->transactions_name;
            $numericPart = substr($lastTrn, -6);
            $datePart = substr($lastTrn, 3, 4);
            $currentYear = substr($yearMonth, 0, 4);
            $val = $numericPart + 1;
            if ($datePart != $currentYear) {
                $TrnCode = $Prefix . $yearMonth . '000001';
            } else {
                if ($val > 999999) {
                    // If it exceeds, simply append the numeric value after the prefix
                    $TrnCode = $Prefix . $yearMonth . $val;
                } else {
                    // If it doesn't exceed, format it with leading zeros
                    $TrnCode = $Prefix . $yearMonth . sprintf("%06d", $val);
                }
            }
        }
        $data['transactions_name'] = $TrnCode;
        $query = $acc_transactions_name->query();
        $query->insert(['transactions_name'])->values($data)->execute();
        return $TrnCode;
    }

    private function get_report_head($name, $request_data)
    {
        $head = $name . " Report of";
        if (isset($request_data['sid']) && $request_data['sid']) {
            $scms_students = TableRegistry::getTableLocator()->get('scms_students');
            $students = $scms_students->find()->where(['sid' => $request_data['sid']])->toArray();
            $head = $head . 'Student Name: <b>' . $students[0]['name'] . '</b>';
        }
        if (isset($request_data['session']) && $request_data['session']) {
            $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
            $sessions = $scms_sessions->find()->where(['session_id' => $request_data['session']])->toArray();
            $head = $head . ' Session: <b>' . $sessions[0]['session_name'] . '</b>';
        }
        if (isset($request_data['level_id']) && $request_data['level_id']) {
            $level = TableRegistry::getTableLocator()->get('scms_levels');
            $levels = $level->find()->where(['level_id' => $request_data['level_id']])->toArray();
            $head = $head . ' Level: <b>' . $levels[0]['level_name'] . '</b>';
        }
        if (isset($request_data['section_id']) && $request_data['section_id']) {
            $scms_sections = TableRegistry::getTableLocator()->get('scms_sections');
            $section = $scms_sections->find()->where(['section_id' => $request_data['section_id']])->toArray();
            $head = $head . ' Section: <b>' . $section[0]['section_name'] . '</b>';
        }
        if (isset($request_data['month_id']) && $request_data['month_id']) {
            $month = TableRegistry::getTableLocator()->get('acc_months');
            $months = $month->find()->where(['id IN' => $request_data['month_id']])->enableAutoFields(true)->enableHydration(false)->toArray();
            foreach ($months as $month) {
                if (isset($month_name)) {
                    $month_name = $month_name . ',' . substr($month['month_name'], 0, 3);
                } else {
                    $month_name = substr($month['month_name'], 0, 3);
                }
            }
            $head = $head . ' Month(s): <b>' . $month_name . '</b>';
        }
        if (isset($request_data['type']) && $request_data['type']) {
            if ($request_data['type'] == 'both') {
                $request_data['type'] = 'Credit & Debit';
            }
            $head = $head . ' Transection Type: <b>' . $request_data['type'] . '</b>';
        }
        if (isset($request_data['sid']) && $request_data['sid']) {
            $head = $head . ' SID: <b>' . $request_data['sid'] . '</b>';
        }
        if ($request_data['start_date']) {
            $date = " Date:  <b>" . date('d-m-Y', strtotime($request_data['start_date'])) . "</b> To ";
            if ($request_data['end_date']) {
                $date = $date . "<b>" . date('d-m-Y', strtotime($request_data['end_date'])) . "</b>";
            } else {
                $date = $date . "<b>" . date('d-m-Y', strtotime($request_data['start_date'])) . "</b>";
            }
        } else {
            $date = " Date:  <b> Alltime </b>";
        }
        $head = $head . $date;
        return $head;
    }

    public function voucherStatement()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (isset($request_data['session']) && $request_data['session']) {
                $where['acc_vouchers.session_id'] = $request_data['session'];
            }
            if (isset($request_data['level_id']) && $request_data['level_id']) {
                $where['acc_vouchers.level_id'] = $request_data['level_id'];
            }
            if (isset($request_data['section_id']) && $request_data['section_id']) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if (isset($request_data['sid']) && $request_data['sid']) {
                $where['acc_vouchers.sid'] = $request_data['sid'];
            }
            if ($request_data['start_date']) {
                if ($request_data['end_date']) {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                } else {
                    $request_data['end_date'] = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                }
                $where['create_date >='] = $request_data['start_date'];
                $where['create_date <'] = $request_data['end_date'];
            }
            $where['deleted'] = 0;
            $data = TableRegistry::getTableLocator()->get('acc_vouchers');
            $vouchers = $data->find()->where($where)->enableAutoFields(true)->enableHydration(false)->select([
                'name' => "scms_students.name",
                'level_name' => "scms_levels.level_name",
                'session_name' => "scms_sessions.session_name",
            ])->order(['acc_vouchers.id' => 'DESC'])->join([
                        'scms_student_cycle' => [
                            'table' => 'scms_student_cycle',
                            'type' => 'INNER',
                            'conditions' => [
                                'acc_vouchers.student_cycle_id = scms_student_cycle.student_cycle_id'
                            ]
                        ],
                        'scms_students' => [
                            'table' => 'scms_students',
                            'type' => 'INNER',
                            'conditions' => [
                                'scms_students.student_id = scms_student_cycle.student_id'
                            ]
                        ],
                        'scms_levels' => [
                            'table' => 'scms_levels',
                            'type' => 'INNER',
                            'conditions' => [
                                'acc_vouchers.level_id = scms_levels.level_id'
                            ]
                        ],
                        'scms_sessions' => [
                            'table' => 'scms_sessions',
                            'type' => 'INNER',
                            'conditions' => [
                                'acc_vouchers.session_id = scms_sessions.session_id'
                            ]
                        ],
                    ])->toArray();

            $month = TableRegistry::getTableLocator()->get('acc_months');
            $months = $month->find()->enableAutoFields(true)->enableHydration(false)->toArray();
            foreach ($months as $month) {
                $filter_months[$month['id']] = $month['month_name'];
            }
            $total['amount'] = 0;
            $total['payment_amount'] = 0;
            $total['due_amount'] = 0;
            $total['discount_amount'] = 0;
            foreach ($vouchers as $key => $voucher) {
                if ($voucher['payment_status'] == 0) {
                    $vouchers[$key]['due_amount'] = $voucher['amount'];
                    $vouchers[$key]['status'] = 'Unpaid';
                    $vouchers[$key]['color'] = 'red';
                } else if ($voucher['payment_status'] == 1) {
                    $vouchers[$key]['status'] = 'Paid';
                    $vouchers[$key]['payment_amount'] = $voucher['payment_amount'];
                    $vouchers[$key]['color'] = 'green';
                } else {
                    $vouchers[$key]['status'] = 'Partially paid';
                    $vouchers[$key]['payment_amount'] = $voucher['payment_amount'];
                    $vouchers[$key]['color'] = 'yellow';
                }
                $month_ids = json_decode($voucher['month_ids']);
                foreach ($month_ids as $month_id) {
                    if (isset($vouchers[$key]['month_name'])) {
                        $vouchers[$key]['month_name'] = $vouchers[$key]['month_name'] . ',' . substr($filter_months[$month_id], 0, 3);
                    } else {
                        $vouchers[$key]['month_name'] = substr($filter_months[$month_id], 0, 3);
                    }
                }
                $total['amount'] = $total['amount'] + $vouchers[$key]['amount'];
                $total['payment_amount'] = $total['payment_amount'] + $vouchers[$key]['payment_amount'];
                $total['due_amount'] = $total['due_amount'] + $vouchers[$key]['due_amount'];
                $total['discount_amount'] = $total['discount_amount'] + $vouchers[$key]['discount_amount'];
            }
            $head = $this->get_report_head('Voucher Statement', $request_data);
            $this->set('head', $head);
            $this->set('total', $total);
            $this->set('vouchers', $vouchers);
            $this->autoRender = false;
            $this->layout = 'report';
            $this->render('/reports/voucherStatement');
        }

        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions->find()->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels('accounts');
        $this->set('levels', $levels);

        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);

        $sections = $this->get_sections('accounts', $levels[0]->level_id);
        $this->set('sections', $sections);
        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles)) {
            $required = '';
        }
        $this->set('required', $required);
    }

    /* public function dueReport() {
         if ($this->request->is(['post'])) {
             $request_data = $this->request->getData();
             if (isset($request_data['session']) && $request_data['session']) {
                 $where['acc_vouchers.session_id'] = $request_data['session'];
             }
             if (isset($request_data['level_id']) && $request_data['level_id']) {
                 $where['acc_vouchers.level_id'] = $request_data['level_id'];
             }
             if (isset($request_data['section_id']) && $request_data['section_id']) {
                 $where['scms_student_cycle.section_id'] = $request_data['section_id'];
             }
             if (isset($request_data['sid']) && $request_data['sid']) {
                 $where['acc_vouchers.sid'] = $request_data['sid'];
             }
             if ($request_data['start_date']) {
                 if ($request_data['end_date']) {
                     $end_date = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                 } else {
                     $end_date = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                 }
                 $where['create_date >='] = $request_data['start_date'];
                 $where['create_date <'] = $end_date;
             }
             $where['acc_vouchers.deleted'] = 0;
             $where['acc_vouchers.payment_status'] = 0;
             $data = TableRegistry::getTableLocator()->get('acc_vouchers');
             $vouchers = $data->find()->where($where)->enableAutoFields(true)->enableHydration(false)->select([
                         'name' => "scms_students.name",
                         'level_name' => "scms_levels.level_name",
                         'session_name' => "scms_sessions.session_name",
                         'section_name' => "scms_sections.section_name",
                     ])->join([
                         'scms_student_cycle' => [
                             'table' => 'scms_student_cycle',
                             'type' => 'INNER',
                             'conditions' => [
                                 'acc_vouchers.student_cycle_id = scms_student_cycle.student_cycle_id'
                             ]
                         ],
                         'scms_students' => [
                             'table' => 'scms_students',
                             'type' => 'INNER',
                             'conditions' => [
                                 'scms_students.student_id = scms_student_cycle.student_id'
                             ]
                         ],
                         'scms_sections' => [
                             'table' => 'scms_sections',
                             'type' => 'INNER',
                             'conditions' => [
                                 'scms_sections.section_id = scms_student_cycle.section_id'
                             ]
                         ],
                         'scms_levels' => [
                             'table' => 'scms_levels',
                             'type' => 'INNER',
                             'conditions' => [
                                 'acc_vouchers.level_id = scms_levels.level_id'
                             ]
                         ],
                         'scms_sessions' => [
                             'table' => 'scms_sessions',
                             'type' => 'INNER',
                             'conditions' => [
                                 'acc_vouchers.session_id = scms_sessions.session_id'
                             ]
                         ],
                     ])->toArray();
             $purpose_whare = array();
             if (isset($request_data['month_id']) && $request_data['month_id']) {
                 $purpose_whare['acc_voucher_purposes.month_id IN'] = $request_data['month_id'];
             }
             $ids = array();
             $filter_voucher = array();
             foreach ($vouchers as $voucher) {
                 $filter_voucher[$voucher['id']] = $voucher;
                 $ids[] = $voucher['id'];
             }
             if (count($ids)) {
                 $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
                 $v_purposes = $acc_voucher_purposes->find()->where(['acc_voucher_purposes.voucher_id IN' => $ids])->where(['acc_voucher_purposes.payment_status !=' => 1])->where($purpose_whare)->enableAutoFields(true)->enableHydration(false)->select([
                             'month_name' => "acc_months.month_name",
                             'purpose_name' => "acc_purposes.purpose_name",
                         ])->join([
                             'acc_months' => [
                                 'table' => 'acc_months',
                                 'type' => 'LEFT',
                                 'conditions' => [
                                     'acc_voucher_purposes.month_id = acc_months.id'
                                 ]
                             ],
                             'acc_purposes' => [
                                 'table' => 'acc_purposes',
                                 'type' => 'LEFT',
                                 'conditions' => [
                                     'acc_voucher_purposes.purpose_id = acc_purposes.purpose_id'
                                 ]
                             ],
                         ])->toArray();
             } else {
                 $v_purposes = array();
             }

             $show_data = array();
             $total = 0;
             if ($request_data['report_type'] == 'Student') {
                 $table_row[] = 'SID';
                 $table_row[] = 'Name';
                 $table_row[] = 'Session';
                 $table_row[] = 'level';
                 $table_row[] = 'Section';
                 $table_row[] = 'Due Amount';
                 foreach ($v_purposes as $v_purpose) {
                     $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                     $total = $total + $due;
                     $sid = $filter_voucher[$v_purpose['voucher_id']]['sid'];
                     if (isset($show_data[$sid])) {
                         $show_data[$sid][5] = $show_data[$sid][5] + $due;
                     } else {
                         $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['sid'];
                         $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['name'];
                         $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['session_name'];
                         $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['level_name'];
                         $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['section_name'];
                         $show_data_single[] = $due;
                         $show_data[$sid] = $show_data_single;
                         unset($show_data_single);
                     }
                 }
             } else if ($request_data['report_type'] == 'Month') {
                 $table_row[] = '#';
                 $table_row[] = 'Month Name';
                 $table_row[] = 'Due Amount';
                 $month = TableRegistry::getTableLocator()->get('acc_months');
                 $months = $month->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                 foreach ($months as $month) {
                     $show_data_single[] = $month['id'];
                     $show_data_single[] = $month['month_name'];
                     $show_data_single[] = 0;
                     $show_data[$month['id']] = $show_data_single;
                     unset($show_data_single);
                 }
                 foreach ($v_purposes as $v_purpose) {
                     $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                     $total = $total + $due;
                     $show_data[$v_purpose['month_id']][2] = $show_data[$v_purpose['month_id']][2] + $due;
                 }
             } else if ($request_data['report_type'] == 'Purpose') {
                 $table_row[] = '#';
                 $table_row[] = 'Purpose Name';
                 $table_row[] = 'Due Amount';
                 $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
                 $purposes = $purpose->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                 foreach ($purposes as $purpose) {

                     $show_data_single[] = $purpose['purpose_id'];
                     $show_data_single[] = $purpose['purpose_name'];
                     $show_data_single[] = 0;
                     $show_data[$purpose['purpose_id']] = $show_data_single;
                     unset($show_data_single);
                 }
                 foreach ($v_purposes as $v_purpose) {
                     $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                     $total = $total + $due;
                     $show_data[$v_purpose['purpose_id']][2] = $show_data[$v_purpose['purpose_id']][2] + $due;
                 }
             } else if ($request_data['report_type'] == 'Class') {
                 $table_row[] = '#';
                 $table_row[] = 'Class Name';
                 $table_row[] = 'Due Amount';
                 $scms_levels = TableRegistry::getTableLocator()->get('scms_levels');
                 $levels = $scms_levels->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                 foreach ($levels as $level) {

                     $show_data_single[] = $level['level_id'];
                     $show_data_single[] = $level['level_name'];
                     $show_data_single[] = 0;
                     $show_data[$level['level_id']] = $show_data_single;
                     unset($show_data_single);
                 }
                 foreach ($v_purposes as $v_purpose) {
                     $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                     $total = $total + $due;
                     $level_id = $filter_voucher[$v_purpose['voucher_id']]['level_id'];
                     $show_data[$level_id][2] = $show_data[$level_id][2] + $due;
                 }
             }
             $head = $this->get_report_head('Due', $request_data);
             $this->set('head', $head);
             $this->set('total', $total);
             $this->set('type', $request_data['report_type']);
             $this->set('show_data', $show_data);
             $this->set('table_row', $table_row);
             $this->autoRender = false;
             $this->layout = 'report';
             $this->render('/reports/dueReport');
         }
         $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
         $sessions = $scms_sessions->find()->toArray();
         $this->set('sessions', $sessions);
         $level = TableRegistry::getTableLocator()->get('scms_levels');
         $levels = $level->find()->toArray();
         $this->set('levels', $levels);
         $month = TableRegistry::getTableLocator()->get('acc_months');
         $months = $month->find()->toArray();
         $this->set('months', $months);
     } */

   /* public function dueReport()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (isset($request_data['session']) && $request_data['session']) {
                $where['acc_vouchers.session_id'] = $request_data['session'];
            }
            if (isset($request_data['level_id']) && $request_data['level_id']) {
                $where['acc_vouchers.level_id'] = $request_data['level_id'];
            }
            if (isset($request_data['section_id']) && $request_data['section_id']) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if (isset($request_data['sid']) && $request_data['sid']) {
                $where['acc_vouchers.sid'] = $request_data['sid'];
            }
            if ($request_data['start_date']) {
                if ($request_data['end_date']) {
                    $end_date = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                } else {
                    $end_date = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                }
                $where['create_date >='] = $request_data['start_date'];
                $where['create_date <'] = $end_date;
            }
            $where['acc_vouchers.deleted'] = 0;
            $data = TableRegistry::getTableLocator()->get('acc_vouchers');
            $vouchers = $data->find()->where($where)->enableAutoFields(true)->enableHydration(false)->select([
                'name' => "scms_students.name",
                'level_name' => "scms_levels.level_name",
                'session_name' => "scms_sessions.session_name",
                'section_name' => "scms_sections.section_name",
                'roll' => "scms_student_cycle.roll",
            ])->join([
                        'scms_student_cycle' => [
                            'table' => 'scms_student_cycle',
                            'type' => 'INNER',
                            'conditions' => [
                                'acc_vouchers.student_cycle_id = scms_student_cycle.student_cycle_id'
                            ]
                        ],
                        'scms_students' => [
                            'table' => 'scms_students',
                            'type' => 'INNER',
                            'conditions' => [
                                'scms_students.student_id = scms_student_cycle.student_id'
                            ]
                        ],
                        'scms_sections' => [
                            'table' => 'scms_sections',
                            'type' => 'INNER',
                            'conditions' => [
                                'scms_sections.section_id = scms_student_cycle.section_id'
                            ]
                        ],
                        'scms_levels' => [
                            'table' => 'scms_levels',
                            'type' => 'INNER',
                            'conditions' => [
                                'acc_vouchers.level_id = scms_levels.level_id'
                            ]
                        ],
                        'scms_sessions' => [
                            'table' => 'scms_sessions',
                            'type' => 'INNER',
                            'conditions' => [
                                'acc_vouchers.session_id = scms_sessions.session_id'
                            ]
                        ],
                    ])->toArray();

            $purpose_whare = array();
            if (isset($request_data['month_id']) && $request_data['month_id']) {
                $purpose_whare['acc_voucher_purposes.month_id IN'] = $request_data['month_id'];
            }
            $ids = array();
            $filter_voucher = array();
            foreach ($vouchers as $voucher) {
                $filter_voucher[$voucher['id']] = $voucher;
                $ids[] = $voucher['id'];
            }
            if (count($ids)) {
                $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
                $v_purposes = $acc_voucher_purposes->find()->where(['acc_voucher_purposes.voucher_id IN' => $ids])->where(['acc_voucher_purposes.payment_status !=' => 1])->where($purpose_whare)->enableAutoFields(true)->enableHydration(false)->select([
                    'month_name' => "acc_months.month_name",
                    'purpose_name' => "acc_purposes.purpose_name",
                ])->join([
                            'acc_months' => [
                                'table' => 'acc_months',
                                'type' => 'LEFT',
                                'conditions' => [
                                    'acc_voucher_purposes.month_id = acc_months.id'
                                ]
                            ],
                            'acc_purposes' => [
                                'table' => 'acc_purposes',
                                'type' => 'LEFT',
                                'conditions' => [
                                    'acc_voucher_purposes.purpose_id = acc_purposes.purpose_id'
                                ]
                            ],
                        ])->toArray();
            } else {
                $v_purposes = array();
            }

            $show_data = array();
            $total = 0;
            if ($request_data['report_type'] == 'Student') {
                $table_row[] = 'SID';
                $table_row[] = 'Roll';
                $table_row[] = 'Name';
                $table_row[] = 'Session';
                $table_row[] = 'level';
                $table_row[] = 'Section';
                $table_row[] = 'Due Amount';
                foreach ($v_purposes as $v_purpose) {
                    $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                    $total = $total + $due;
                    $sid = $filter_voucher[$v_purpose['voucher_id']]['sid'];
                    if (isset($show_data[$sid])) {
                        $show_data[$sid][6] = $show_data[$sid][6] + $due;
                    } else {
                        $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['sid'];
                        $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['roll'];
                        $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['name'];
                        $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['session_name'];
                        $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['level_name'];
                        $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['section_name'];
                        $show_data_single[] = $due;
                        $show_data[$sid] = $show_data_single;

                        unset($show_data_single);
                    }
                }
            } else if ($request_data['report_type'] == 'Month') {
                $table_row[] = '#';
                $table_row[] = 'Month Name';
                $table_row[] = 'Due Amount';
                $month = TableRegistry::getTableLocator()->get('acc_months');
                $months = $month->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($months as $month) {
                    $show_data_single[] = $month['id'];
                    $show_data_single[] = $month['month_name'];
                    $show_data_single[] = 0;
                    $show_data[$month['id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($v_purposes as $v_purpose) {
                    $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                    $total = $total + $due;
                    $show_data[$v_purpose['month_id']][2] = $show_data[$v_purpose['month_id']][2] + $due;
                }
            } else if ($request_data['report_type'] == 'Purpose') {
                $table_row[] = '#';
                $table_row[] = 'Purpose Name';
                $table_row[] = 'Due Amount';
                $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
                $purposes = $purpose->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($purposes as $purpose) {

                    $show_data_single[] = $purpose['purpose_id'];
                    $show_data_single[] = $purpose['purpose_name'];
                    $show_data_single[] = 0;
                    $show_data[$purpose['purpose_id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($v_purposes as $v_purpose) {
                    $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                    $total = $total + $due;
                    $show_data[$v_purpose['purpose_id']][2] = $show_data[$v_purpose['purpose_id']][2] + $due;
                }
            } else if ($request_data['report_type'] == 'Class') {
                $table_row[] = '#';
                $table_row[] = 'Class Name';
                $table_row[] = 'Due Amount';
                $scms_levels = TableRegistry::getTableLocator()->get('scms_levels');
                $levels = $scms_levels->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($levels as $level) {

                    $show_data_single[] = $level['level_id'];
                    $show_data_single[] = $level['level_name'];
                    $show_data_single[] = 0;
                    $show_data[$level['level_id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($v_purposes as $v_purpose) {
                    $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                    $total = $total + $due;
                    $level_id = $filter_voucher[$v_purpose['voucher_id']]['level_id'];
                    $show_data[$level_id][2] = $show_data[$level_id][2] + $due;
                }
            }
            $show_data = array_filter($show_data, function ($item) {
                return $item[6] != 0;
            });

            $head = $this->get_report_head('Due', $request_data);
            $this->set('head', $head);
            $this->set('total', $total);
            $this->set('type', $request_data['report_type']);
            $this->set('show_data', $show_data);
            $this->set('table_row', $table_row);
            $this->autoRender = false;
            $this->layout = 'report';
            $this->render('/reports/dueReport');
        }
        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions->find()->toArray();
        $this->set('sessions', $sessions);
        $levels = $this->get_levels('accounts');
        $this->set('levels', $levels);
        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);

        $sections = $this->get_sections('accounts', $levels[0]->level_id);
        $this->set('sections', $sections);
        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles)) {
            $required = '';
        }
        $this->set('required', $required);
        $month = TableRegistry::getTableLocator()->get('acc_months');
        $months = $month
            ->find()
            ->toArray();
        $this->set('months', $months);
    } */
    
    public function dueReport()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (isset($request_data['session']) && $request_data['session']) {
                $where['acc_vouchers.session_id'] = $request_data['session'];
            }
            if (isset($request_data['level_id']) && $request_data['level_id']) {
                $where['acc_vouchers.level_id'] = $request_data['level_id'];
            }
            if (isset($request_data['section_id']) && $request_data['section_id']) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if (isset($request_data['sid']) && $request_data['sid']) {
                $where['acc_vouchers.sid'] = $request_data['sid'];
            }
            if ($request_data['start_date']) {
                if ($request_data['end_date']) {
                    $end_date = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                } else {
                    $end_date = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                }
                $where['create_date >='] = $request_data['start_date'];
                $where['create_date <'] = $end_date;
            }
            $where['acc_vouchers.deleted'] = 0;
            $data = TableRegistry::getTableLocator()->get('acc_vouchers');
            $vouchers = $data->find()->where($where)->enableAutoFields(true)->enableHydration(false)->select([
                'name' => "scms_students.name",
                'level_name' => "scms_levels.level_name",
                'session_name' => "scms_sessions.session_name",
                'section_name' => "scms_sections.section_name",
                'roll' => "scms_student_cycle.roll",
                'month_name' => "acc_months.month_name",
            ])->order(['scms_student_cycle.level_id' => 'ASC', 'scms_student_cycle.section_id' => 'ASC', 'scms_student_cycle.roll' => 'ASC'])
            ->join([
                        'acc_months' => [
                                'table' => 'acc_months',
                                'type' => 'LEFT',
                                'conditions' => [
                                    "JSON_CONTAINS(acc_vouchers.month_ids, CONCAT('\"', acc_months.id, '\"'))"
                                ]
                            ],
                        'scms_student_cycle' => [
                            'table' => 'scms_student_cycle',
                            'type' => 'INNER',
                            'conditions' => [
                                'acc_vouchers.student_cycle_id = scms_student_cycle.student_cycle_id'
                            ]
                        ],
                        'scms_students' => [
                            'table' => 'scms_students',
                            'type' => 'INNER',
                            'conditions' => [
                                'scms_students.student_id = scms_student_cycle.student_id'
                            ]
                        ],
                        'scms_sections' => [
                            'table' => 'scms_sections',
                            'type' => 'INNER',
                            'conditions' => [
                                'scms_sections.section_id = scms_student_cycle.section_id'
                            ]
                        ],
                        'scms_levels' => [
                            'table' => 'scms_levels',
                            'type' => 'INNER',
                            'conditions' => [
                                'acc_vouchers.level_id = scms_levels.level_id'
                            ]
                        ],
                        'scms_sessions' => [
                            'table' => 'scms_sessions',
                            'type' => 'INNER',
                            'conditions' => [
                                'acc_vouchers.session_id = scms_sessions.session_id'
                            ]
                        ],
                    ])->toArray();

            $purpose_whare = array();
            if (isset($request_data['month_id']) && $request_data['month_id']) {
                $purpose_whare['acc_voucher_purposes.month_id IN'] = $request_data['month_id'];
            }
            $ids = array();
            $filter_voucher = array();
            foreach ($vouchers as $voucher) {
                $filter_voucher[$voucher['id']] = $voucher;
                $ids[] = $voucher['id'];
            }
            //echo '<pre>';print_r($filter_voucher);die;
            if (count($ids)) {
                $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
                $v_purposes = $acc_voucher_purposes->find()->where(['acc_voucher_purposes.voucher_id IN' => $ids])->where(['acc_voucher_purposes.payment_status !=' => 1])->where($purpose_whare)->enableAutoFields(true)->enableHydration(false)->select([
                    'month_name' => "acc_months.month_name",
                    'purpose_name' => "acc_purposes.purpose_name",
                ])
                ->order(['scms_student_cycle.level_id' => 'ASC', 'scms_student_cycle.section_id' => 'ASC', 'scms_student_cycle.roll' => 'ASC'])
                ->join([
                            'acc_vouchers' => [
                                'table' => 'acc_vouchers',
                                'type' => 'LEFT',
                                'conditions' => [
                                    'acc_vouchers.id = acc_voucher_purposes.voucher_id'
                                ]
                            ],
                            'scms_student_cycle' => [
                                'table' => 'scms_student_cycle',
                                'type' => 'INNER',
                                'conditions' => [
                                    'scms_student_cycle.student_cycle_id = acc_vouchers.student_cycle_id'
                                ]
                            ],
                            'acc_months' => [
                                'table' => 'acc_months',
                                'type' => 'LEFT',
                                'conditions' => [
                                    'acc_voucher_purposes.month_id = acc_months.id'
                                ]
                            ],
                            'acc_purposes' => [
                                'table' => 'acc_purposes',
                                'type' => 'LEFT',
                                'conditions' => [
                                    'acc_voucher_purposes.purpose_id = acc_purposes.purpose_id'
                                ]
                            ],
                        ])->toArray();
            } else {
                $v_purposes = array();
            }

            $show_data = array();
            $total = 0;
            if ($request_data['report_type'] == 'Student') {
                $table_row[] = 'SL.';
                $table_row[] = 'SID';
                $table_row[] = 'Roll';
                $table_row[] = 'Name';
                $table_row[] = 'Session';
                $table_row[] = 'level';
                $table_row[] = 'Section';
                $table_row[] = 'Month';
                $table_row[] = 'Due Amount';
                // First, collect month names and due amounts per student
                $student_months = [];
                $student_due = [];
                
                // First, collect months and due amounts
                foreach ($v_purposes as $v_purpose) {
                    $voucher_id = $v_purpose['voucher_id'];
                    $sid = $filter_voucher[$voucher_id]['sid'];
                
                    $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                    $total = $total + $due;
                    // Collect month names
                    if (!isset($student_months[$sid])) {
                        $student_months[$sid] = [];
                    }
                    if (!in_array($v_purpose['month_name'], $student_months[$sid])) {
                        $student_months[$sid][] = $v_purpose['month_name'];
                    }
                
                    // Sum due amounts
                    if (!isset($student_due[$sid])) {
                        $student_due[$sid] = 0;
                    }
                    $student_due[$sid] += $due;
                }
                
                // Build $show_data with serial
                $show_data = [];
                $serial = 1;
                
                foreach ($v_purposes as $v_purpose) {
                    $voucher_id = $v_purpose['voucher_id'];
                    $sid = $filter_voucher[$voucher_id]['sid'];
                
                    if (isset($show_data[$sid])) {
                        // Already exists, just update due amount
                        $show_data[$sid][8] = $student_due[$sid]; // index 8 because serial is at 0 now
                    } else {
                        $show_data_single = [];
                        $show_data_single[] = $serial++; // Serial number as first column
                        $show_data_single[] = $filter_voucher[$voucher_id]['sid'];
                        $show_data_single[] = $filter_voucher[$voucher_id]['roll'];
                        $show_data_single[] = $filter_voucher[$voucher_id]['name'];
                        $show_data_single[] = $filter_voucher[$voucher_id]['session_name'];
                        $show_data_single[] = $filter_voucher[$voucher_id]['level_name'];
                        $show_data_single[] = $filter_voucher[$voucher_id]['section_name'];
                        $show_data_single[] = implode(', ', $student_months[$sid]); // All months together
                        $show_data_single[] = $student_due[$sid]; // Total due
                        $show_data[$sid] = $show_data_single;
                        unset($show_data_single);
                    }
                }
                } else if ($request_data['report_type'] == 'Month') {
                $table_row[] = '#';
                $table_row[] = 'Month Name';
                $table_row[] = 'Due Amount';
                $month = TableRegistry::getTableLocator()->get('acc_months');
                $months = $month->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($months as $month) {
                    $show_data_single[] = $month['id'];
                    $show_data_single[] = $month['month_name'];
                    $show_data_single[] = 0;
                    $show_data[$month['id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($v_purposes as $v_purpose) {
                    $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                    $total = $total + $due;
                    $show_data[$v_purpose['month_id']][2] = $show_data[$v_purpose['month_id']][2] + $due;
                }
            } else if ($request_data['report_type'] == 'Purpose') {
                $table_row[] = '#';
                $table_row[] = 'Purpose Name';
                $table_row[] = 'Due Amount';
                $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
                $purposes = $purpose->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($purposes as $purpose) {

                    $show_data_single[] = $purpose['purpose_id'];
                    $show_data_single[] = $purpose['purpose_name'];
                    $show_data_single[] = 0;
                    $show_data[$purpose['purpose_id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($v_purposes as $v_purpose) {
                    $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                    $total = $total + $due;
                    $show_data[$v_purpose['purpose_id']][2] = $show_data[$v_purpose['purpose_id']][2] + $due;
                }
            } else if ($request_data['report_type'] == 'Class') {
                $table_row[] = '#';
                $table_row[] = 'Class Name';
                $table_row[] = 'Due Amount';
                $scms_levels = TableRegistry::getTableLocator()->get('scms_levels');
                $levels = $scms_levels->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                foreach ($levels as $level) {

                    $show_data_single[] = $level['level_id'];
                    $show_data_single[] = $level['level_name'];
                    $show_data_single[] = 0;
                    $show_data[$level['level_id']] = $show_data_single;
                    unset($show_data_single);
                }
                foreach ($v_purposes as $v_purpose) {
                    $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                    $total = $total + $due;
                    $level_id = $filter_voucher[$v_purpose['voucher_id']]['level_id'];
                    $show_data[$level_id][2] = $show_data[$level_id][2] + $due;
                }
            }
            
            if ($request_data['report_type'] == 'Month' || $request_data['report_type'] == 'Purpose' || $request_data['report_type'] == 'Class') {
                $show_data = array_filter($show_data, function ($item) {
                    return $item[2] != 0;
                });
            } else {
                $show_data = array_filter($show_data, function ($item) {
                return $item[8] != 0;
            });
            }
            
            

            $head = $this->get_report_head('Due', $request_data);
            $this->set('head', $head);
            $this->set('total', $total);
            $this->set('type', $request_data['report_type']);
            $this->set('show_data', $show_data);
            $this->set('table_row', $table_row);
            $this->autoRender = false;
            $this->layout = 'report';
            $this->render('/reports/dueReport');
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);
        $levels = $this->get_levels('accounts');
        $this->set('levels', $levels);

        $sections = $this->get_sections('students',$levels[0]->level_id);
        $this->set('sections', $sections);

        $this->set('data', $value);

        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles)) {
            $required = '';
        }
        $this->set('required', $required);

        // $shifts = $this->get_shifts('students');
        // $this->set('shifts', $shifts);
        $active_session=$this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);
        $month = TableRegistry::getTableLocator()->get('acc_months');
        $months = $month->find()->toArray();
        $this->set('months', $months);
    }
    
    public function dueSms()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();

            $this->set('request_data', $request_data);
            // pr($request_data);die;
            if (!isset($request_data['sms'])) {
                if (isset($request_data['session']) && $request_data['session']) {
                    $where['acc_vouchers.session_id'] = $request_data['session'];
                }
                if (isset($request_data['level_id']) && $request_data['level_id']) {
                    $where['acc_vouchers.level_id'] = $request_data['level_id'];
                }
                if (isset($request_data['department_id']) && $request_data['department_id']) {
                    $where['scms_departments.department_id'] = $request_data['department_id'];
                }
                if (isset($request_data['section_id']) && $request_data['section_id']) {
                    $where['scms_student_cycle.section_id'] = $request_data['section_id'];
                }
                if (isset($request_data['sid']) && $request_data['sid']) {
                    $where['acc_vouchers.sid'] = $request_data['sid'];
                }
                if ($request_data['start_date']) {
                    if ($request_data['end_date']) {
                        $end_date = date('Y-m-d', strtotime($request_data['end_date'] . ' + 1 days'));
                    } else {
                        $end_date = date('Y-m-d', strtotime($request_data['start_date'] . ' + 1 days'));
                    }
                    $where['create_date >='] = $request_data['start_date'];
                    $where['create_date <'] = $end_date;
                }
                $where['acc_vouchers.deleted'] = 0;
                $data = TableRegistry::getTableLocator()->get('acc_vouchers');
                $vouchers = $data->find()->where($where)->enableAutoFields(true)->enableHydration(false)->select([
                    'name' => "scms_students.name",
                    'level_name' => "scms_levels.level_name",
                    'session_name' => "scms_sessions.session_name",
                    'section_name' => "scms_sections.section_name",
                    'roll' => "scms_student_cycle.roll",
                ])->join([
                            'scms_student_cycle' => [
                                'table' => 'scms_student_cycle',
                                'type' => 'INNER',
                                'conditions' => [
                                    'acc_vouchers.student_cycle_id = scms_student_cycle.student_cycle_id'
                                ]
                            ],
                            'scms_students' => [
                                'table' => 'scms_students',
                                'type' => 'INNER',
                                'conditions' => [
                                    'scms_students.student_id = scms_student_cycle.student_id'
                                ]
                            ],
                            'scms_sections' => [
                                'table' => 'scms_sections',
                                'type' => 'INNER',
                                'conditions' => [
                                    'scms_sections.section_id = scms_student_cycle.section_id'
                                ]
                            ],
                            'scms_levels' => [
                                'table' => 'scms_levels',
                                'type' => 'INNER',
                                'conditions' => [
                                    'acc_vouchers.level_id = scms_levels.level_id'
                                ]
                            ],
                            'scms_sessions' => [
                                'table' => 'scms_sessions',
                                'type' => 'INNER',
                                'conditions' => [
                                    'acc_vouchers.session_id = scms_sessions.session_id'
                                ]
                            ],
                            'scms_departments' => [
                                'table' => 'scms_departments',
                                'type' => 'LEFT',
                                'conditions' => [
                                    'scms_departments.department_id = scms_levels.department_id'
                                ]
                            ],
                        ])->toArray();

                $purpose_whare = array();
                if (isset($request_data['month_id']) && $request_data['month_id']) {
                    $purpose_whare['acc_voucher_purposes.month_id IN'] = $request_data['month_id'];
                }
                $ids = array();
                $filter_voucher = array();
                foreach ($vouchers as $voucher) {
                    $filter_voucher[$voucher['id']] = $voucher;
                    $ids[] = $voucher['id'];
                }
                if (count($ids)) {
                    $acc_voucher_purposes = TableRegistry::getTableLocator()->get('acc_voucher_purposes');
                    $v_purposes = $acc_voucher_purposes->find()->where(['acc_voucher_purposes.voucher_id IN' => $ids])->where(['acc_voucher_purposes.payment_status !=' => 1])->where($purpose_whare)->enableAutoFields(true)->enableHydration(false)->select([
                        'month_name' => "acc_months.month_name",
                        'purpose_name' => "acc_purposes.purpose_name",
                    ])->join([
                                'acc_months' => [
                                    'table' => 'acc_months',
                                    'type' => 'LEFT',
                                    'conditions' => [
                                        'acc_voucher_purposes.month_id = acc_months.id'
                                    ]
                                ],
                                'acc_purposes' => [
                                    'table' => 'acc_purposes',
                                    'type' => 'LEFT',
                                    'conditions' => [
                                        'acc_voucher_purposes.purpose_id = acc_purposes.purpose_id'
                                    ]
                                ],
                            ])->toArray();
                } else {
                    $v_purposes = array();
                }

                $show_data = array();
                $total = 0;
                if ($request_data['report_type'] == 'Student') {
                    $table_row[] = 'SID';
                    $table_row[] = 'Name';
                    $table_row[] = 'Roll';
                    $table_row[] = 'Session';
                    $table_row[] = 'level';
                    $table_row[] = 'Section';
                    $table_row[] = 'Due Amount';
                    foreach ($v_purposes as $v_purpose) {
                        $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                        $total = $total + $due;
                        $sid = $filter_voucher[$v_purpose['voucher_id']]['sid'];
                        if (isset($show_data[$sid])) {
                            $show_data[$sid][6] = $show_data[$sid][6] + $due;
                        } else {
                            $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['sid'];
                            $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['name'];
                            $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['roll'];
                            $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['session_name'];
                            $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['level_name'];
                            $show_data_single[] = $filter_voucher[$v_purpose['voucher_id']]['section_name'];
                            $show_data_single[] = $due;
                            $show_data[$sid] = $show_data_single;

                            unset($show_data_single);
                        }
                    }
                } else if ($request_data['report_type'] == 'Month') {
                    $table_row[] = '#';
                    $table_row[] = 'Month Name';
                    $table_row[] = 'Due Amount';
                    $month = TableRegistry::getTableLocator()->get('acc_months');
                    $months = $month->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                    foreach ($months as $month) {
                        $show_data_single[] = $month['id'];
                        $show_data_single[] = $month['month_name'];
                        $show_data_single[] = 0;
                        $show_data[$month['id']] = $show_data_single;
                        unset($show_data_single);
                    }
                    foreach ($v_purposes as $v_purpose) {
                        $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                        $total = $total + $due;
                        $show_data[$v_purpose['month_id']][2] = $show_data[$v_purpose['month_id']][2] + $due;
                    }
                } else if ($request_data['report_type'] == 'Purpose') {
                    $table_row[] = '#';
                    $table_row[] = 'Purpose Name';
                    $table_row[] = 'Due Amount';
                    $purpose = TableRegistry::getTableLocator()->get('acc_purposes');
                    $purposes = $purpose->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                    foreach ($purposes as $purpose) {

                        $show_data_single[] = $purpose['purpose_id'];
                        $show_data_single[] = $purpose['purpose_name'];
                        $show_data_single[] = 0;
                        $show_data[$purpose['purpose_id']] = $show_data_single;
                        unset($show_data_single);
                    }
                    foreach ($v_purposes as $v_purpose) {
                        $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                        $total = $total + $due;
                        $show_data[$v_purpose['purpose_id']][2] = $show_data[$v_purpose['purpose_id']][2] + $due;
                    }
                } else if ($request_data['report_type'] == 'Class') {
                    $table_row[] = '#';
                    $table_row[] = 'Class Name';
                    $table_row[] = 'Due Amount';
                    $scms_levels = TableRegistry::getTableLocator()->get('scms_levels');
                    $levels = $scms_levels->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                    foreach ($levels as $level) {

                        $show_data_single[] = $level['level_id'];
                        $show_data_single[] = $level['level_name'];
                        $show_data_single[] = 0;
                        $show_data[$level['level_id']] = $show_data_single;
                        unset($show_data_single);
                    }
                    foreach ($v_purposes as $v_purpose) {
                        $due = $v_purpose['payment_status'] ? $v_purpose['due'] : $v_purpose['amount'];
                        $total = $total + $due;
                        $level_id = $filter_voucher[$v_purpose['voucher_id']]['level_id'];
                        $show_data[$level_id][2] = $show_data[$level_id][2] + $due;
                    }
                }
                // pr($show_data);die;
                $head = $this->get_report_head('Due', $request_data);
                $this->set('head', $head);
                $this->set('total', $total);
                $this->set('type', $request_data['report_type']);
                $this->set('show_data', $show_data);
                $this->set('table_row', $table_row);
            } else {
                $request_data = $this->request->getData();

                $inputArray = $request_data['inputValue'];
                $sids = array_keys($request_data['inputValue']);

                $student = TableRegistry::getTableLocator()->get('scms_students');

                $studentsData = $student->find()
                    ->where(['sid IN' => $sids])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->select([
                        'name' => "scms_students.name",
                        'sid' => "scms_students.sid",
                        'student_id' => "scms_students.student_id",
                        'relation' => "scms_students.active_guardian",
                        'guar_mobile' => "g.mobile",
                    ])
                    ->join([
                        's' => [
                            'table' => 'scms_student_cycle',
                            'type' => 'INNER',
                            'conditions' => [
                                's.student_id = scms_students.student_id'
                            ]
                        ],
                        'g' => [
                            'table' => 'scms_guardians',
                            'type' => 'INNER',
                            'conditions' => [
                                'g.student_id = scms_students.student_id',
                                'g.rtype = scms_students.active_guardian'
                            ]
                        ]
                    ])
                    ->toArray();

                // Format the result
                $studentInfo = [];
                $numbers = [];
                foreach ($studentsData as $student) {
                    $sid = $student['sid'];
                    $amount = isset($inputArray[$sid]) ? $inputArray[$sid] : null;

                    // All student data
                    $studentInfo[$sid] = [
                        'student_id' => $student['student_id'],
                        'name' => $student['name'],
                        'sid' => $student['sid'],
                        'amount' => $amount,
                        'mobile' => $student['guar_mobile']
                    ];

                    // Collect mobile numbers for SMS sending
                    if (!empty($student['guar_mobile'])) {
                        $numbers[] = $student['guar_mobile'];
                    }
                }

                if (!empty($studentInfo)) {
                    $arrg['students'] = array_values($studentInfo);
                    $type = "due_sms";

                    // Call send_sms only if there are numbers
                    if (!empty($numbers)) {
                        $absent = $this->send_sms($type, $numbers, $arrg);
                        $message = 'Successfully ' . $absent . ' due SMS sent';
                    } else {
                        $message = 'No SMS sent due to missing mobile numbers';
                    }

                    $this->Flash->success($message, [
                        'key' => 'positive',
                        'params' => [],
                    ]);
                } else {

                    $this->Flash->error('No student information available for sending SMS.', [
                        'key' => 'negative',
                        'params' => [],
                    ]);
                }
                $this->redirect(['action' => 'dueSms']);
            }
        }


        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions->find()->toArray();
        $this->set('sessions', $sessions);
        $department = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $department
            ->find()
            ->order(['department_name' => 'ASC'])
            ->toArray();
        $this->set('departments', $departments);

        $levels = $this->get_levels('accounts');
        $this->set('levels', $levels);

        $month = TableRegistry::getTableLocator()->get('acc_months');
        $months = $month->find()->toArray();
        $this->set('months', $months);

        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);


        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);

        $sections = $this->get_sections('accounts', $levels[0]->level_id);
        $this->set('sections', $sections);
        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles)) {
            $required = '';
        }
        $this->set('required', $required);

    }

    ##++++++++++++++++++++++++++++++
## AKASH CONTROLLER END
##++++++++++++++++++++++++++++++


    public function studentViewRecipt($id)
    {
        $where['transaction_type'] = 'Credit';
        $where['acc_transactions.deleted'] = 0;
        $where['acc_transactions.transaction_id'] = $id;
        $checck_transactions = $this->getTransaction($where);
        $this->set('type', $checck_transactions[0]['type']);
        $acc_transactions = TableRegistry::getTableLocator()->get('acc_transactions');
        if ($checck_transactions[0]['type'] == 'school_fees' || $checck_transactions[0]['type'] == 'Student') {
            $transactions = $acc_transactions->find()->where(['transaction_id' => $id])->enableAutoFields(true)->enableHydration(false)->select([
                'student_sid' => "scms_students.sid",
                'name' => "scms_students.name",
                'student_id' => "scms_students.student_id",
                'session_name' => "scms_sessions.session_name",
                'level_name' => "scms_levels.level_name",
            ])->join([
                        'scms_student_cycle' => [
                            'table' => 'scms_student_cycle', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'acc_transactions.student_cycle_id = scms_student_cycle.student_cycle_id' // in which table data is matching
                            ]
                        ],
                        'scms_students' => [
                            'table' => 'scms_students', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'scms_students.student_id = scms_student_cycle.student_id' // in which table data is matching
                            ]
                        ],
                        'scms_sessions' => [
                            'table' => 'scms_sessions', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'acc_transactions.session_id = scms_sessions.session_id' // in which table data is matching
                            ]
                        ],
                        'scms_levels' => [
                            'table' => 'scms_levels', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'acc_transactions.level_id = scms_levels.level_id' // in which table data is matching
                            ]
                        ],
                    ])->toArray();
        } else {
            $transactions = $acc_transactions->find()->where(['transaction_id' => $id])->enableAutoFields(true)->enableHydration(false)->select([
                'name' => "employee.name",
                'session_name' => "scms_sessions.session_name",
            ])->join([
                        'employee' => [
                            'table' => 'employee', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'acc_transactions.employee_id = employee.employee_id' // in which table data is matching
                            ]
                        ],
                        'scms_sessions' => [
                            'table' => 'scms_sessions', // from which table data is calling
                            'type' => 'LEFT',
                            'conditions' => [
                                'acc_transactions.session_id = scms_sessions.session_id' // in which table data is matching
                            ]
                        ],
                    ])->toArray();
        }
        $this->set('transactions', $transactions[0]);
        $months = $this->get_months_name_for_Recpit((array) json_decode($transactions[0]['month_ids']), $transactions[0]['session_id']);
        $this->set('months', $months);

        $acc_transaction_purposes = TableRegistry::getTableLocator()->get('acc_transaction_purposes');
        $transaction_purposes = $acc_transaction_purposes->find()->where(['transaction_id' => $id])->enableAutoFields(true)->enableHydration(false)->select([
            'purpose_name' => "acc_purposes.purpose_name",
        ])->join([
                    'acc_purposes' => [
                        'table' => 'acc_purposes', // from which table data is calling
                        'type' => 'LEFT',
                        'conditions' => [
                            'acc_transaction_purposes.purpose_id = acc_purposes.purpose_id' // in which table data is matching
                        ]
                    ],
                ])->toArray();
        $total = 0;
        $positive = $negative = array();
        foreach ($transaction_purposes as $transaction_purpose) {
            $total = $total + $transaction_purpose['amount'];
            if ($transaction_purpose['amount'] > 0) {
                if (isset($positive[$transaction_purpose['purpose_id']])) {
                    $positive[$transaction_purpose['purpose_id']]['amount'] = $transaction_purpose['amount'] + $positive[$transaction_purpose['purpose_id']]['amount'];
                } else {
                    $positive[$transaction_purpose['purpose_id']] = $transaction_purpose;
                }
            } else {
                if (isset($negative[$transaction_purpose['purpose_id']])) {
                    $negative[$transaction_purpose['purpose_id']]['amount'] = $transaction_purpose['amount'] + $negative[$transaction_purpose['purpose_id']]['amount'];
                } else {
                    $negative[$transaction_purpose['purpose_id']] = $transaction_purpose;
                }
            }
        }
        $purpose = array_merge($positive, $negative);
        $this->set('purpose', $purpose);
        $this->set('total', number_format((float) $total, 2, '.', ''));
        $amount = $this->convertNumberToWord($total) . ' Taka Only';
        $this->set('amount', $amount);

        $users = TableRegistry::getTableLocator()->get('users');
        $user = $users->find()->where(['id' => $transactions[0]['user_id']])->enableAutoFields(true)->enableHydration(false)->toArray();
        $this->set('user_name', $user[0]['name']);

        return [
            'type' => $checck_transactions[0]['type'],
            'transactions' => $transactions[0],
            'months' => $months,
            'purpose' => $purpose,
            'total' => number_format((float) $total, 2, '.', ''),
            'amount' => $amount,
            'user_name' => $user[0]['name'],
        ];
    }

}
