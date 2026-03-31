<?php

namespace Croogo\Core\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Http\ResponseEmitter;
use Cake\Http\ServerRequest;
use Croogo\Core\Croogo;

use Cake\ORM\TableRegistry;

class DepartmentsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $this->layout = 'marmc_dpt';
        $departmentsTable = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $departmentsTable->find()
            ->select(['department_id', 'department_name', 'parent_department'])
            ->where(['parent_department IS NULL'])
            ->toArray();

        $children = $departmentsTable->find()
            ->select(['department_id', 'department_name', 'parent_department'])
            ->where(['parent_department IS NOT NULL'])
            ->toArray();

        foreach ($departments as $department) {
            $department->children = $this->buildDepartmentTree($department->department_id, $children);
        }

        $this->set(compact('departments'));

        $employeeTable = TableRegistry::getTableLocator()->get('employee');
        $employees = $employeeTable->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->order('RAND()')
            ->select([
                'designation' => 'dsg.name'
            ])->join([
                'dsg' => [
                    'table' => 'employees_designation',
                    'type' => 'INNER',
                    'conditions' => [
                        'dsg.id = employee.employees_designation_id '
                    ]
                ]
            ])
            ->toArray();
        $this->set(compact('employees'));
    }

    protected function buildDepartmentTree($parentId, $children)
    {
        $tree = [];
        foreach ($children as $child) {
            if ($child->parent_department == $parentId) {
                $child->children = $this->buildDepartmentTree($child->department_id, $children);
                $tree[] = $child;
            }
        }
        return $tree;
    }

    public function getEmployeesAjax()
    {
        // $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;

        // Retrieve department_id from the request
        $department_id = $this->request->getQuery('department_id');

        // Fetch employees for the specified department
        $employeeTable = TableRegistry::getTableLocator()->get('employee');
        $employees = $employeeTable->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['employee.department_id' => $department_id])
            ->order(['CAST(employee_order AS SIGNED)' => 'ASC'])
            ->select([
                'designation' => 'dsg.name'
            ])->join([
                'dsg' => [
                    'table' => 'employees_designation',
                    'type' => 'INNER',
                    'conditions' => [
                        'dsg.id = employee.employees_designation_id '
                    ]
                ]
            ])
            ->toArray(); // Use toArray() to convert the result set to an array

        // Return the employees as JSON
        echo json_encode($employees);
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
                'department_name' => "dpt.department_name",
            ])
            ->join([
                'd' => [
                    'table' => 'employees_designation',
                    'type' => 'LEFT',
                    'conditions' => [
                        'd.id = employee.employees_designation_id '
                    ]
                ],
                'dpt' => [
                    'table' => 'scms_departments',
                    'type' => 'LEFT',
                    'conditions' => [
                        'dpt.department_id  = employee.department_id'
                    ]
                ],
            ])
            ->toArray();
        $this->set('profiles', $profiles[0]);
    }

    public function administration($slug)
    {

        $rolesTable = TableRegistry::getTableLocator()->get('roles');
        $usersTable = TableRegistry::getTableLocator()->get('users');

        // Find the role based on the alias
        $role = $rolesTable->find()
            ->where(['alias' => $slug])
            ->first();


        if ($role) {
            $query = $usersTable->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'employee_id' => "emp.employee_id",
                    'employee_name' => "emp.name",
                    'degree' => "emp.degree",
                    'note' => "emp.note",
                    'video_link' => "emp.video_link",
                    'job_institute' => "emp.job_institute",
                    'image_name' => "emp.image_name",
                    'role_title' => "role.title",
                    'designation_name' => "designation.name",
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
            $profile = $query->toArray();
        } else {
            $count = 0;
            $profile = [];
        }

        $this->set('count', $count);
        $this->set('profile', $profile[0]);
        $this->set('role', $role);
    }
}
