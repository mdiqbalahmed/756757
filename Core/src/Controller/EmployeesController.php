<?php

namespace Croogo\Core\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Http\ResponseEmitter;
use Cake\Http\ServerRequest;
use Croogo\Core\Croogo;

use Cake\ORM\TableRegistry;


class EmployeesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function employeesList($slug)
    {
        $rolesTable = TableRegistry::getTableLocator()->get('roles');
        $usersTable = TableRegistry::getTableLocator()->get('users');

        // Find the role based on the alias
        $role = $rolesTable->find()
            ->where(['alias' => $slug])
            ->first();

        if ($role) {
            $query = $usersTable->find()
                ->select([
                    'role_id' => "role.id",
                    'employee_id' => "emp.employee_id",
                    'employee_name' => "emp.name",
                    'image_name' => "emp.image_name",
                    'role_title' => "role.title",
                    'designation_title' => "designation.name",
                    'join_date' => "emp.join_date",
                    'end_date' => "emp.end_date",
                ])
                ->join([
                    'emp' => [
                        'table' => 'employee',
                        'type' => 'LEFT',
                        'conditions' => [
                            'emp.user_id = users.id',
                        ]
                    ],
                    'role' => [
                        'table' => 'roles',
                        'type' => 'LEFT',
                        'conditions' => [
                            'role.id = users.role_id',
                        ]
                    ],
                    'designation' => [
                        'table' => 'employees_designation',
                        'type' => 'LEFT',
                        'conditions' => [
                            'designation.id = emp.employees_designation_id',
                        ]
                    ],
                ])
                ->where([
                    'role_id' => $role->id,
                    'role.id !=' => 1,
                ]);
            $count = $query->count();
            $employees = $query->toArray();
        } else {
            $count = 0;
            $employees = [];
            
            // $employees = $usersTable->find()
            //     ->where(['users.status =' => 0])
            //     ->select([
            //         'employee_id' => "emp.employee_id",
            //         'employee_name' => "emp.name",
            //         'image_name' => "emp.image_name",
            //         'designation_title' => "designation.name",
            //         'status' => "users.status",
            //         'join_date' => "emp.join_date",
            //         'end_date' => "emp.end_date",
            //     ])
            //     ->join([
            //         'emp' => [
            //             'table' => 'employee',
            //             'type' => 'LEFT',
            //             'conditions' => [
            //                 'emp.user_id = users.id',
            //             ]
            //         ],
            //         'role' => [
            //             'table' => 'roles',
            //             'type' => 'LEFT',
            //             'conditions' => [
            //                 'role.id = users.role_id',
            //             ]
            //         ],
            //         'designation' => [
            //             'table' => 'employees_designation',
            //             'type' => 'LEFT',
            //             'conditions' => [
            //                 'designation.id = emp.employees_designation_id',
            //             ]
            //         ],
                    
            //     ])
            //     ->order(['employee_id' => 'DESC'])
            //     ->toArray();
                
          
        }
        $employees = array_filter($employees, function($emp) {
            return !empty($emp->employee_id);
        });
        //   echo '<pre>';
        //   print_r($employees);die;
        $this->set('count', $count);
        $this->set('employees', $employees);
        $this->set('role', $role);

    }



    public function employeesProfile($id)
    {
        $getProfile = TableRegistry::getTableLocator()->get('employee');
        $profiles = $getProfile->find()
            ->where(['employee_id' => $id])
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
            ])
            ->toArray();
        $this->set('profiles', $profiles);
    }

}
