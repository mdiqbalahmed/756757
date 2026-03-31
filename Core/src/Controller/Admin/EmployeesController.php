<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class EmployeesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    // EMPLOYEE INDEX FUNCTION
   
    
    public function index()
    {
        $request_data = [];
        $where = [];
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            // echo '<pre>';
            // print_r($request_data);
            // die;
            if (!empty($request_data['name'])) {
                $where['employee.name LIKE'] = '%' . $request_data['name'] . '%';
            }

            if (!empty($request_data['mobile'])) {
                $where['employee.mobile'] = $request_data['mobile'];
            }
            if (!empty($request_data['designation_id'])) {
                $where['d.id'] = $request_data['designation_id'];
            }
            if (!empty($request_data['gender'])) {
                $where['employee.gender'] = $request_data['gender'];
            }
            if (!empty($request_data['type'])) {
                $where['employee.type'] = $request_data['type'];
            }
        }
        $user = TableRegistry::getTableLocator()->get('employee');
        $users = $user->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['status' => '1'])
            ->where($where)
            ->order(['employee_order' => 'ASC'])
            ->select([
                'designation_name' => "d.name",
                'status' => "usr.status",
            ])
            ->join([
                'd' => [
                    'table' => 'employees_designation',
                    'type' => 'LEFT',
                    'conditions' => [
                        'd.id = employee.employees_designation_id '
                    ]
                ],
                'usr' => [
                    'table' => 'users',
                    'type' => 'LEFT',
                    'conditions' => [
                        'usr.id = employee.user_id '
                    ]
                ],
            ])
            ->toArray();

        // $paginate = $this->paginate($users, ['limit' => $this->Paginate_limit]);
        // $paginate = $paginate->toArray();
        $this->set('employees', $users);
        $designation = TableRegistry::getTableLocator()->get('employees_designation');
        $designations = $designation
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $head = $this->set_head($request_data);
  
        $this->set('designations', $designations);
        $this->set('where', $where);
        $this->set('head', $head);
    }
    
    private function set_head($request_data)
    {


        if (isset($request_data['name']) && $request_data['name']) {

            $section = TableRegistry::getTableLocator()->get('employee');
            $section_display = $section
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['employee.name LIKE' => '%' . $request_data['name'] . '%'])
                ->where(['usr.status' => '1'])
                ->join([
                    'usr' => [
                        'table' => 'users',
                        'type' => 'LEFT',
                        'conditions' => [
                            'usr.id = employee.user_id '
                        ]
                    ],
                ])
                ->toArray();

            $head['name'] = $section_display[0]['name'];
        }
        // echo '<pre>';
        // print_r($section_display);
        // die;
        if (isset($request_data['mobile']) && $request_data['mobile']) {

            $section = TableRegistry::getTableLocator()->get('employee');
            $section_display = $section
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['mobile' => $request_data['mobile']])
                ->where(['usr.status' => '1'])
                ->join([
                    'usr' => [
                        'table' => 'users',
                        'type' => 'LEFT',
                        'conditions' => [
                            'usr.id = employee.user_id '
                        ]
                    ],
                ])
                ->toArray();
            $head['mobile'] = $section_display[0]['mobile'];
        }
        if (isset($request_data['designation_id']) && $request_data['designation_id']) {

            $section = TableRegistry::getTableLocator()->get('employees_designation');
            $section_display = $section
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['id' => $request_data['designation_id']])
                ->toArray();
            $head['designation'] = $section_display[0]['name'];
        }
        
        if (isset($request_data['type']) && $request_data['type']) {

            $section = TableRegistry::getTableLocator()->get('employee');
            $section_display = $section
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['type' => $request_data['type']])
                ->toArray();
            $head['type'] = $section_display[0]['type'];
        }
        
        if (isset($request_data['gender']) && $request_data['gender']) {

            $section = TableRegistry::getTableLocator()->get('employee');
            $section_display = $section
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['gender' => $request_data['gender']])
                ->toArray();
                
            $head['gender'] = $section_display[0]['gender'];
        }

        return $head;
    }

    public function permissions($id)
    {

        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (isset($request_data['saved'])) {
                $saved_data = array();
                foreach ($request_data['type'] as $key => $type) {
                    $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
                    $query = $employees_permission->query();
                    $query->delete()
                        ->where(['deparment_id' => $request_data['department_id'][$key]])
                        ->where(['session_id' => $request_data['session_id'][$key]])
                        ->where(['level_id' => $request_data['level_id'][$key]])
                        ->where(['type' => $request_data['slug'][$key]])
                        ->where(['employee_id' => $id])
                        ->execute();

                    $single['deparment_id'] = $request_data['department_id'][$key];
                    $single['session_id'] = $request_data['session_id'][$key];
                    $single['level_id'] = $request_data['level_id'][$key];
                    $single['type'] = $request_data['slug'][$key];
                    $single['employee_id'] = $id;
                    $single['section_id'] = '';
                    $single['course_id'] = '';

                    if ($request_data['type'][$key] == 'course') {
                        if (isset($request_data['course'][$key])) {
                            foreach ($request_data['course'][$key] as $section_id => $all_courses) {
                                foreach ($all_courses as $course_id => $all) {
                                    $single['section_id'] = $section_id;
                                    $single['course_id'] = $course_id;
                                    $saved_data[] = $single;
                                    $single['section_id'] = '';
                                    $single['course_id'] = '';
                                }
                            }
                        }

                    } else {
                        if (isset($request_data['section'][$key])) {
                            foreach ($request_data['section'][$key] as $section_id => $all) {
                                $single['section_id'] = $section_id;
                                $saved_data[] = $single;
                                $single['section_id'] = '';
                            }
                        }
                    }
                }

                if (count($saved_data)) {
                    $insertQuery = $employees_permission->query();
                    $columns = array_keys($saved_data[0]);
                    $insertQuery->insert($columns);
                    $insertQuery->clause('values')->values($saved_data);
                    $insertQuery->execute();
                }
                //Set Flash
                $this->Flash->info('Employee Permission has been updated successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'permissions', $id]);

            } else {
                $this->set('request_data', $request_data);
                $employee_permission_type = TableRegistry::getTableLocator()->get('employee_permission_type');
                $all_permissions_type = $employee_permission_type
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
                $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
                $select_sessions = $scms_sessions
                    ->find()
                    ->where(['session_id' => $request_data['session_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
                $scms_departments = TableRegistry::getTableLocator()->get('scms_departments');
                $select_departments = $scms_departments
                    ->find()
                    ->where(['department_id' => $request_data['department_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
                $scms_levels = TableRegistry::getTableLocator()->get('scms_levels');
                $select_levels = $scms_levels
                    ->find()
                    ->where(['level_id' => $request_data['level_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
                $data = array();
                foreach ($all_permissions_type as $permission_type) {
                    $data[$permission_type['id']]['permission'] = $permission_type;
                    $permission_title = 'Permission for Type:<b> ' . $permission_type["title"] . '</b>, Department:<b> ' . $select_departments[0]["department_name"] . '</b>, Session:<b> ' . $select_sessions[0]['session_name'] . '</b>, Level:<b> ' . $select_levels[0]['level_name'] . '</b>';
                    $data[$permission_type['id']]['permission_title'] = $permission_title;

                    $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
                    $permissions = $employees_permission
                        ->find()
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->where(['employee_id' => $id])
                        ->where(['deparment_id' => $request_data['department_id']])
                        ->where(['session_id' => $request_data['session_id']])
                        ->where(['level_id' => $request_data['level_id']])
                        ->where(['type' => $permission_type['slug']])
                        ->toArray();

                    $scms_sections = TableRegistry::getTableLocator()->get('scms_sections');
                    $sections = $scms_sections
                        ->find()
                        ->where(['level_id' => $request_data['level_id']])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->toArray();
                    $set_sections = array();
                    $set_levels = array();
                    if ($permission_type["type"] == 'section') {
                        foreach ($sections as $key => $section) {
                            $set_sections[$section['section_id']] = $section;
                        }
                        foreach ($permissions as $permission) {
                            $set_sections[$permission['section_id']]['checked'] = 1;
                        }

                    } else if ($permission_type["type"] == 'course') {
                        $scms_courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
                        $courses = $scms_courses_cycle->find()
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->where(['level_id' => $request_data['level_id']])
                            ->where(['session_id' => $request_data['session_id']])
                            ->select([
                                'course_name' => 'scms_courses.course_name',
                            ])
                            ->join([
                                'scms_courses' => [
                                    'table' => 'scms_courses',
                                    'type' => 'LEFT',
                                    'conditions' => ['scms_courses.course_id = scms_courses_cycle.course_id'],
                                ],
                            ])
                            ->toArray();

                        foreach ($courses as $key => $course) {
                            $set_course[$course['course_id']] = $course;
                        }
                        foreach ($sections as $key => $section) {
                            $section['courses'] = $set_course;
                            $set_sections[$section['section_id']] = $section;
                        }
                        foreach ($permissions as $permission) {
                            $set_sections[$permission['section_id']]['courses'][$permission['course_id']]['checked'] = 1;
                        }
                    } else {
                        foreach ($select_levels as $key => $level) {
                            $set_levels[$level['level_id']] = $level;
                        }
                        foreach ($permissions as $permission) {
                            $set_levels[$permission['level_id']]['checked'] = 1;
                        }
                    }
                    $data[$permission_type['id']]['set_levels'] = $set_levels;
                    $data[$permission_type['id']]['set_sections'] = $set_sections;
                }
                $this->set('data', $data);
            }

        }


        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('sessions', $sessions);

        $scms_departments = TableRegistry::getTableLocator()->get('scms_departments');
        $departments = $scms_departments
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('departments', $departments);

        $scms_levels = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $scms_levels
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('levels', $levels);


        $get_employee = TableRegistry::getTableLocator()->get('employee');
        $get_employees = $get_employee->find()->where(['employee_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'role_id' => 'u.role_id',
                'username' => 'u.username',
                'status' => 'u.status',
            ])
            ->join([
                'u' => [
                    'table' => 'users',
                    'type' => 'LEFT',
                    'conditions' => ['u.id = employee.user_id '],
                ],
            ])
            ->toArray();
        $this->set('employee', $get_employees[0]);
    }


    //UNIQUE ID UPDATION BASED ON THE EMPLOYEE_ID
    public function updateUniqueIds()
    {
        // Get the employee table
        $employeeTable = TableRegistry::getTableLocator()->get('employee');

        // Fetch all employees
        $employees = $employeeTable->find('all');

        // Iterate over each employee
        foreach ($employees as $employee) {
            // Manipulate the employee_unique_id
            $employee->employee_unique_id = 'E' . str_pad($employee->employee_id, 4, '0', STR_PAD_LEFT);
            $employeeTable->save($employee);
        }

        $employeeCount = $employeeTable->find('all')->count();
        $this->Flash->success("Updated {$employeeCount} Employee IDs.");

        // Redirect back to the employee index page (or any other page)
        return $this->redirect(['action' => 'index']);
    }

    // EMPLOYEE ADD FUNCTION
    public function addEmployee()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $file = $request_data['image_name'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);

            $thumbnailFileName = null;
            $regularSizeFileName = null;

            if (
                in_array(
                    $ext,
                    $arr_ext
                )
            ) {
                // Move uploaded file to original folder
                $originalFolderPath = WWW_ROOT . '/uploads/employee_images/large_version/'; // Specify original folder path
                if (!file_exists($originalFolderPath)) {
                    mkdir($originalFolderPath, 0777, true);
                }
                $originalImagePath = $originalFolderPath . $setNewFileName . '.' . $ext;
                move_uploaded_file($file['tmp_name'], $originalImagePath);

                // Open original image file
                $image = null;
                if ($ext == 'jpg' || $ext == 'jpeg') {
                    $image = imagecreatefromjpeg($originalImagePath);
                } elseif ($ext == 'png') {
                    $image = imagecreatefrompng($originalImagePath);
                }

                // Compress image and save thumbnail version
                if ($image) {
                    $thumbnailFolderPath = WWW_ROOT . '/uploads/employee_images/thumbnail/'; // Specify thumbnail folder path
                    if (!file_exists($thumbnailFolderPath)) {
                        mkdir($thumbnailFolderPath, 0777, true);
                    }
                    $thumbnailImagePath = $thumbnailFolderPath . $setNewFileName . '_th.' . $ext;
                    $thumbnailWidth = 300; // Change this value to adjust thumbnail width
                    $thumbnailHeight = 300; // Change this value to adjust thumbnail height
                    $thumbnailImage = imagescale($image, $thumbnailWidth, $thumbnailHeight);
                    imagejpeg($thumbnailImage, $thumbnailImagePath, 50);
                    $thumbnailFileName = $setNewFileName . '_th.' . $ext;
                    imagedestroy($thumbnailImage);
                }

                // Compress image and save regularSize version
                if ($image) {
                    $regularSizeFolderPath = WWW_ROOT . '/uploads/employee_images/regularSize/'; // Specify regularSize folder path
                    if (!file_exists($regularSizeFolderPath)) {
                        mkdir($regularSizeFolderPath, 0777, true);
                    }
                    $regularSizeImagePath = $regularSizeFolderPath . $setNewFileName . '_rs.' . $ext;
                    $regularSizeWidth = 600; // Change this value to adjust regularSize width
                    $regularSizeHeight = 800; // Change this value to adjust regularSize height
                    $regularSizeImage = imagescale($image, $regularSizeWidth, $regularSizeHeight);
                    imagejpeg($regularSizeImage, $regularSizeImagePath, 80);
                    $regularSizeFileName = $setNewFileName . '_rs.' . $ext;
                    imagedestroy($regularSizeImage);
                }
                // Delete original image
                unlink($originalImagePath);
            }

            $request_data['thumbnail'] = $thumbnailFileName;
            $request_data['image_name'] = $regularSizeFileName;

            $password = $request_data['password'];
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Data Declaration to insert in USERS table
            $user_data['username'] = $request_data['username'];
            $user_data['password'] = $hash;
            $user_data['name'] = $request_data['name'];
            $user_data['email'] = $request_data['email'];
            $user_data['status'] = $request_data['status'];
            $user_data['role_id'] = $request_data['role_id'];
            $user_data['image'] = $regularSizeFileName;

            $get_users = TableRegistry::getTableLocator()->get('users');
            $query = $get_users->query();
            $query
                ->insert(['username', 'password', 'name', 'email', 'status', 'role_id'])
                ->values($user_data)
                ->execute();
            $myrecords = $get_users->find()->last(); //get the last id
            $request_data['user_id'] = (int) $myrecords->id;
            
            #added by @shovon
            $user = TableRegistry::getTableLocator()->get('users');
            $users = $user->find()
            ->where(['id' => $myrecords->id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
            
            
            $get_aros = TableRegistry::getTableLocator()->get('aros');
            $maxRight = $get_aros->find()
                ->select(['max_right' => $get_aros->find()->func()->max('rght')])
                ->first()
                ->max_right;
            
            $aros = [
                    'parent_id'   => $users[0]['role_id'],
                    'model'       => 'Users',
                    'foreign_key' => $users[0]['id'],
                    'alias'       => $users[0]['username'],
                    'lft'         => $maxRight + 1,
                    'rght'        => $maxRight + 2
                ];
            
            // echo '<pre>';
            // print_r($aros);die;
            
            $query = $get_aros->query();
            $query->insert(['parent_id', 'model', 'foreign_key', 'alias', 'lft', 'rght'])
                  ->values($aros)
                  ->execute();

            $empTable = TableRegistry::getTableLocator()->get('employee')->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->order(['employee_unique_id' => 'DESC'])
                ->first();

            if (empty($empTable)) {
                $numeric_id = '0001';
            } else {
                $numeric_id = substr($empTable['employee_unique_id'], 1);
                $val = $numeric_id + 1;
                if ($val > 9999) {
                    $uniqueEmpId = 'E' . $val;
                } else {
                    $uniqueEmpId = 'E' . sprintf("%04d", $val);
                }
            }

            $emp_data['name'] = $request_data['name'];
            $emp_data['name_bn'] = $request_data['name_bn'];
            $emp_data['mobile'] = $request_data['mobile'];
            $emp_data['email'] = $request_data['email'];
            $emp_data['date_of_birth'] = $request_data['date_of_birth'];
            $emp_data['national_id'] = $request_data['national_id'];
            $emp_data['father_name'] = $request_data['father_name'];
            $emp_data['father_name_bn'] = $request_data['father_name_bn'];
            $emp_data['permanent_address'] = $request_data['permanent_address'];
            $emp_data['present_address'] = $request_data['present_address'];
            $emp_data['gender'] = $request_data['gender'];
            $emp_data['religion'] = $request_data['religion'];
            $emp_data['blood_group'] = $request_data['blood_group'];
            $emp_data['marital_status'] = $request_data['marital_status'];
            $emp_data['nationality'] = $request_data['nationality'];
            $emp_data['hobby'] = $request_data['hobby'];
            $emp_data['employees_designation_id'] = $request_data['employees_designation_id'];
            $emp_data['join_date'] = $request_data['join_date'];
            $emp_data['mpo_date'] = $request_data['mpo_date'];
            $emp_data['join_as'] = $request_data['join_as'];
            $emp_data['job_institute'] = $request_data['job_institute'];
            $emp_data['end_date'] = $request_data['end_date'];
            $emp_data['employee_order'] = $request_data['employee_order'];
            $emp_data['training'] = $request_data['training'];
            $emp_data['image_name'] = $request_data['image_name'];
            $emp_data['user_id'] = $request_data['user_id'];
            $emp_data['rf_id'] = $request_data['rf_id'];
            $emp_data['featured'] = isset($request_data['featured']) ? (bool) $request_data['featured'] : null;
            $emp_data['employee_unique_id'] = $uniqueEmpId;


            $get_employee = TableRegistry::getTableLocator()->get('employee');
            $query = $get_employee->query();
            $query
                ->insert(['name', 'name_bn', 'mobile', 'email', 'date_of_birth', 'national_id', 'father_name', 'father_name_bn', 'permanent_address', 'present_address', 'gender', 'religion', 'blood_group', 'marital_status', 'nationality', 'hobby', 'employees_designation_id', 'join_date', 'mpo_date', 'join_as', 'job_institute', 'end_date', 'employee_order', 'training', 'image_name', 'user_id', 'rf_id', 'featured', 'employee_unique_id'])
                ->values($emp_data)
                ->execute();

            $emp_record = $get_employee->find()->last(); //get the last employee id
            $request_data['employee_id'] = $emp_record->employee_id;

            if (isset($request_data['exam_name'])) {
                foreach ($request_data['exam_name'] as $key => $exam_name) { //Data Insert of Multi Dimentional Array to
                    $education_data['employee_id'] = $request_data['employee_id'];
                    $education_data['exam_name'] = $request_data['exam_name'][$key];
                    $education_data['exam_board'] = $request_data['exam_board'][$key];
                    $education_data['exam_session'] = $request_data['exam_session'][$key];
                    $education_data['exam_roll'] = $request_data['exam_roll'][$key];
                    $education_data['exam_registration'] = $request_data['exam_registration'][$key];
                    $education_data['institute'] = $request_data['institute'][$key];
                    $education_data['grade'] = $request_data['grade'][$key];
                    $education_data['group_name'] = $request_data['group_name'][$key];
                    $education_data['gpa'] = $request_data['gpa'][$key];
                    $education_data['passing_year'] = $request_data['passing_year'][$key];

                    $qualification = TableRegistry::getTableLocator()->get('scms_qualification');
                    $query = $qualification->query();
                    $query
                        ->insert(['employee_id', 'exam_name', 'exam_board', 'exam_session', 'exam_roll', 'exam_registration', 'institute', 'grade', 'group_name', 'gpa', 'passing_year'])
                        ->values($education_data)
                        ->execute();
                }
            }


            //Set Flash
            $this->Flash->success('Employee Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);

            return $this->redirect(['action' => 'index']);
        }
        $designation = TableRegistry::getTableLocator()->get('employees_designation');
        $designations = $designation
            ->find()
            ->toArray();
        $this->set('designations', $designations);

        $role = TableRegistry::getTableLocator()->get('roles');
        $roles = $role
            ->find()
            ->where(['alias !=' => 'superadmin', 'id !=' => '1'])
            ->toArray();
        $this->set('roles', $roles);

        $get_employee = TableRegistry::getTableLocator()->get('employee');
        $query = $get_employee->find();
        $employeeOrder = $query->select(['max_value' => $query->func()->max('employee_order')])
            ->first()
            ->toArray()['max_value'];

        if (isset($employeeOrder) && is_numeric($employeeOrder)) {
            $empOrder = $employeeOrder + 1;
        } else {
            $empOrder = 1;
        }
        $this->set('empOrder', $empOrder);
    }


    // EMPLOYEE EDIT FUNCTION
    public function edit($id)
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $file = $request_data['image_name'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);

            $thumbnailFileName = null;
            $regularSizeFileName = null;

            if (
                in_array(
                    $ext,
                    $arr_ext
                )
            ) {
                // Move uploaded file to original folder
                $originalFolderPath = WWW_ROOT . '/uploads/employee_images/large_version/'; // Specify original folder path
                if (!file_exists($originalFolderPath)) {
                    mkdir($originalFolderPath, 0777, true);
                }
                $originalImagePath = $originalFolderPath . $setNewFileName . '.' . $ext;
                move_uploaded_file($file['tmp_name'], $originalImagePath);

                // Open original image file
                $image = null;
                if ($ext == 'jpg' || $ext == 'jpeg') {
                    $image = imagecreatefromjpeg($originalImagePath);
                } elseif ($ext == 'png') {
                    $image = imagecreatefrompng($originalImagePath);
                }

                // Compress image and save thumbnail version
                if ($image) {
                    $thumbnailFolderPath = WWW_ROOT . '/uploads/employee_images/thumbnail/'; // Specify thumbnail folder path
                    if (!file_exists($thumbnailFolderPath)) {
                        mkdir($thumbnailFolderPath, 0777, true);
                    }
                    $thumbnailImagePath = $thumbnailFolderPath . $setNewFileName . '_th.' . $ext;
                    $thumbnailWidth = 300; // Change this value to adjust thumbnail width
                    $thumbnailHeight = 300; // Change this value to adjust thumbnail height
                    $thumbnailImage = imagescale($image, $thumbnailWidth, $thumbnailHeight);
                    imagejpeg($thumbnailImage, $thumbnailImagePath, 50);
                    $thumbnailFileName = $setNewFileName . '_th.' . $ext;
                    imagedestroy($thumbnailImage);
                }

                // Compress image and save regularSize version
                if ($image) {
                    $regularSizeFolderPath = WWW_ROOT . '/uploads/employee_images/regularSize/'; // Specify regularSize folder path
                    if (!file_exists($regularSizeFolderPath)) {
                        mkdir($regularSizeFolderPath, 0777, true);
                    }
                    $regularSizeImagePath = $regularSizeFolderPath . $setNewFileName . '_rs.' . $ext;
                    $regularSizeWidth = 600; // Change this value to adjust regularSize width
                    $regularSizeHeight = 800; // Change this value to adjust regularSize height
                    $regularSizeImage = imagescale($image, $regularSizeWidth, $regularSizeHeight);
                    imagejpeg($regularSizeImage, $regularSizeImagePath, 80);
                    $regularSizeFileName = $setNewFileName . '_rs.' . $ext;
                    imagedestroy($regularSizeImage);
                }
                // Delete original image
                unlink($originalImagePath);
            }
            // pr($request_data);die;
            $request_data['thumbnail'] = $thumbnailFileName;
            $request_data['image_name'] = $regularSizeFileName;

            $employee_id = $id;

            // Get the user_id from the "employee" table based on $employee_id
            $employeeTable = TableRegistry::getTableLocator()->get('employee');
            $employeeData = $employeeTable->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select(['user_id'])
                ->where(['employee_id' => $employee_id])
                ->first();

            if ($employeeData) {
                $user_id = $employeeData['user_id'];

                // Prepare data to update in the "users" table
                $user_data['name'] = $request_data['name'];
                $user_data['role_id'] = $request_data['role_id'];
                $user_data['status'] = $request_data['status'];
                $user_data['image'] = $regularSizeFileName;

                // Update the "users" table based on $user_id
                $usersTable = TableRegistry::getTableLocator()->get('users');
                $query = $usersTable->query();
                $query
                    ->update()
                    ->set($user_data)
                    ->where(['id' => $user_id])
                    ->execute();
            }


            $emp_data['name'] = $request_data['name'];
            $emp_data['name_bn'] = $request_data['name_bn'];
            $emp_data['mobile'] = $request_data['mobile'];
            $emp_data['email'] = $request_data['email'];
            $emp_data['date_of_birth'] = $request_data['date_of_birth'];
            $emp_data['national_id'] = $request_data['national_id'];
            $emp_data['father_name'] = $request_data['father_name'];
            $emp_data['father_name_bn'] = $request_data['father_name_bn'];
            $emp_data['permanent_address'] = $request_data['permanent_address'];
            $emp_data['present_address'] = $request_data['present_address'];
            $emp_data['gender'] = $request_data['gender'];
            $emp_data['religion'] = $request_data['religion'];
            $emp_data['blood_group'] = $request_data['blood_group'];
            $emp_data['marital_status'] = $request_data['marital_status'];
            $emp_data['nationality'] = $request_data['nationality'];
            $emp_data['hobby'] = $request_data['hobby'];
            $emp_data['employees_designation_id'] = $request_data['employees_designation_id'];
            $emp_data['join_date'] = $request_data['join_date'];
            $emp_data['mpo_date'] = $request_data['mpo_date'];
            $emp_data['join_as'] = $request_data['join_as'];
            $emp_data['job_institute'] = $request_data['job_institute'];
            $emp_data['end_date'] = $request_data['end_date'];
            $emp_data['employee_order'] = $request_data['employee_order'];
            $emp_data['training'] = $request_data['training'];
            $emp_data['image_name'] = $request_data['image_name'];
            $emp_data['rf_id'] = $request_data['rf_id'];
            $emp_data['featured'] = isset($request_data['featured']) ? (bool) $request_data['featured'] : null;

            if ($regularSizeFileName == null) {
                unset($emp_data['image_name']);
                unset($emp_data['thumbnail']);
            }

            $get_employee = TableRegistry::getTableLocator()->get('employee');
            $query = $get_employee->query();
            $query
                ->update()
                ->set($emp_data)
                ->where(['employee_id' => $id])
                ->execute();
            if (isset($request_data['exam_name'])) {
                foreach ($request_data['exam_name'] as $key => $name) {
                    $arrays['exam_name'] = $request_data['exam_name'][$key];
                    $arrays['exam_board'] = $request_data['exam_board'][$key];
                    $arrays['exam_session'] = $request_data['exam_session'][$key];
                    $arrays['exam_roll'] = $request_data['exam_roll'][$key];
                    $arrays['exam_registration'] = $request_data['exam_registration'][$key];
                    $arrays['institute'] = $request_data['institute'][$key];
                    $arrays['grade'] = $request_data['grade'][$key];
                    $arrays['group_name'] = $request_data['group_name'][$key];
                    $arrays['passing_year'] = $request_data['passing_year'][$key];
                    $arrays['gpa'] = $request_data['gpa'][$key];
                    $arrays['passing_year'] = $request_data['passing_year'][$key];
                    $arrays['employee_id'] = $id;

                    if (isset($request_data['qualification_id'][$key])) {
                        $get_edu = TableRegistry::getTableLocator()->get('scms_qualification');
                        $query = $get_edu->query();
                        $query
                            ->update()
                            ->set($arrays)
                            ->where(['qualification_id' => $request_data['qualification_id'][$key]])
                            ->execute();
                    } else {
                        $get_edu = TableRegistry::getTableLocator()->get('scms_qualification');
                        $query = $get_edu->query();
                        $query
                            ->insert(['employee_id', 'exam_name', 'exam_board', 'exam_session', 'exam_roll', 'exam_registration', 'institute', 'grade', 'group_name', 'gpa', 'passing_year'])
                            ->values($arrays)
                            ->execute();
                    }
                }
            }
            //Set Flash
            $this->Flash->success('Employees Edited Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'index']);
        }

        $get_employee = TableRegistry::getTableLocator()->get('employee');
        $get_employees = $get_employee->find()->where(['employee_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'role_id' => 'u.role_id',
                'username' => 'u.username',
                'status' => 'u.status',
            ])
            ->join([
                'u' => [
                    'table' => 'users',
                    'type' => 'LEFT',
                    'conditions' => ['u.id = employee.user_id '],
                ],
            ])
            ->toArray();
        $this->set('employees', $get_employees[0]);

        $get_education = TableRegistry::getTableLocator()->get('scms_qualification');
        $get_educations = $get_education->find()->where(['employee_id' => $get_employees[0]['employee_id']])->toArray();
        $this->set('educations', $get_educations);

        $get_user = TableRegistry::getTableLocator()->get('users');
        $get_users = $get_user->find()->where(['id' => $get_employees[0]['user_id']])->toArray();
        $this->set('users', $get_users[0]);

        $role = TableRegistry::getTableLocator()->get('roles');
        $roles = $role->find()->toArray();
        $this->set('roles', $roles);

        $get_designation = TableRegistry::getTableLocator()->get('employees_designation');
        $get_designations = $get_designation->find()->toArray();
        $this->set('designations', $get_designations);
    }

    // EMPLOYEE DELETE FUNCTION

    public function deleteEmployee($id)
    {

        $employee_id = trim($id);

        $get_employee = TableRegistry::getTableLocator()->get('employee');
        $employee = $get_employee->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['employee_id' => $employee_id])
            ->first();

        $employee_id = $employee['employee_id'];
        $user_id = $employee['user_id'];

        if ($id != 1) {
            $employee = TableRegistry::getTableLocator()->get('employee');
            $query = $employee->query();
            $query->delete()
                ->where(['employee_id' => $employee_id])
                ->execute();

            $employee_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $query = $employee_permission->query();
            $query->delete()
                ->where(['employee_id' => $employee_id])
                ->execute();

            $user = TableRegistry::getTableLocator()->get('users');
            $query = $user->query();
            $query->delete()
                ->where(['id' => $user_id])
                ->execute();
        }
        //Set Flash
        $this->Flash->error('Employee Deleted Successfully', [
            'key' => 'positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'index']);
    }

    /*public function deleteEmployee($id) {
        if ($id != 1) {
            $user = TableRegistry::getTableLocator()->get('users');
            $query = $user->query();
            $query->delete()
                    ->where(['id' => $id])
                    ->execute();

            $employee = TableRegistry::getTableLocator()->get('employee');
            $query = $employee->query();
            $query->delete()
                    ->where(['employee_id' => $id])
                    ->execute();
        }
        //Set Flash
        $this->Flash->error('Employee Deleted Successfully', [
            'key' => 'positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'index']);
    }*/

    // EMPLOYEE PERSONAL PROFILE FUNCTION
    public function profile()
    {
        $year = date("Y");
        $month = date('F');
        $id = $this->Auth->user('id');
        $hr_config_action_setup = TableRegistry::getTableLocator()->get('hr_config_action_setup');
        $config = $hr_config_action_setup->find()
            ->where(['user_id' => $id])
            ->where(['year' => $year])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'config_action_name' => "ca.config_action_name",
                'config_key' => "ca.config_key",
            ])
            ->join([
                'ca' => [
                    'table' => 'hr_config_action',
                    'type' => 'LEFT',
                    'conditions' => [
                        'ca.config_action_id  = hr_config_action_setup.config_action_id'
                    ]
                ],
            ])
            ->toArray();
        $value = $this->_filter_employee_wise_data_by_month($config, $month);
        $leave = $this->_filter_employee_wise_leave($config);
        $data['basic_salary'] = 0;
        $data['total_allowance'] = 0;
        $data['total_bonus'] = 0;
        $data['total_penalty'] = 0;
        foreach ($value as $val) {
            if ($val['config_key'] == 'basic_salary') {
                $data['basic_salary'] = $val['value'];
            } else if ($val['config_key'] == 'allowances') {
                $data['total_allowance'] = $data['total_allowance'] + $val['value'];
            } else if ($val['config_key'] == 'bonus') {
                $data['total_bonus'] = $data['total_bonus'] + $val['value'];
            } else if ($val['config_key'] == 'penalty') {
                $data['total_penalty'] = $data['total_penalty'] + $val['value'];
            }
        }
        $this->set('data', $data);
        $this->set('leave', $leave);
        $user = TableRegistry::getTableLocator()->get('users');
        $users = $user->find()
            ->where(['users.id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'employee_id' => "e.employee_id",
                'shift_id' => "e.shift_id",
                'role_title' => "r.title",
                'employees_designation_id' => "e.employees_designation_id",
                'image_name' => "e.image_name",
            ])
            ->join([
                'e' => [
                    'table' => 'employee',
                    'type' => 'LEFT',
                    'conditions' => [
                        'e.user_id = users.id'
                    ]
                ],
                'r' => [
                    'table' => 'roles',
                    'type' => 'LEFT',
                    'conditions' => [
                        'r.id = users.role_id'
                    ]
                ],
            ])
            ->toArray();

        $this->set('user', $users[0]);
    }

    private function _filter_employee_wise_data_by_month($all_config, $month)
    {
        $return = array();
        foreach ($all_config as $key => $val) {
            $months = json_decode($val['months']);
            if (isset($months)) {
                if (in_array($month, $months)) {
                    $return[] = $val;
                }
            }
        }
        return $return;
    }

    private function _filter_employee_wise_leave($all_config)
    {
        $return['casual_leave'] = 0;
        $return['sick_leave'] = 0;
        foreach ($all_config as $key => $val) {
            if ($val['config_key'] == 'casual_leave') {
                $return['casual_leave'] = $val['value'];
            } else if ($val['config_key'] == 'sick_leave') {
                $return['sick_leave'] = $val['value'];
            }
        }
        return $return;
    }

    // EMPLOYEE PERSONAL LEAVE FORM INDEX FUNCTION
    public function leave()
    {
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

    // EMPLOYEE PERSONAL ADD LEAVE APPLICATION FUNCTION
    public function addLeave()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $file = $request_data['file'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);
            $imageFileName = null;
            if (in_array($ext, $arr_ext)) {
                move_uploaded_file($file['tmp_name'], WWW_ROOT . '/uploads/leave_attachments/' . $setNewFileName . '.' . $ext);
                $imageFileName = $setNewFileName . '.' . $ext;
            }

            $id = $this->Auth->user('id');
            $request_data['user_id'] = $id;
            $request_data['submit_date'] = date('Y-m-d');
            $request_data['file'] = $imageFileName;

            $leaves = TableRegistry::getTableLocator()->get('hr_leaves');
            $query = $leaves->query();
            $query
                ->insert(['config_action_setup_id', 'date_from', 'date_to', 'half_leave', 'half_leave_type', 'body', 'user_id', 'submit_date', 'file'])
                ->values($request_data)
                ->execute();
            //Set Flash
            $this->Flash->success('Leave Aplication Submitted Successfully', []);
            return $this->redirect(['action' => 'leave']);
        }
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
                        'ca.config_action_id  = hr_config_action_setup.config_action_id'
                    ]
                ],
            ])
            ->toArray();
        $this->set('leave_type', $leave_type);
    }

    // EMPLOYEE PERSONAL LEAVE APPLICATION EDIT FUNCTION
    public function editLeave($leave_id)
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();

            $file = $request_data['file'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);
            $imageFileName = null;
            if (in_array($ext, $arr_ext)) {
                move_uploaded_file($file['tmp_name'], WWW_ROOT . '/uploads/leave_attachments/' . $setNewFileName . '.' . $ext);
                $imageFileName = $setNewFileName . '.' . $ext;
            }

            $data = TableRegistry::getTableLocator()->get('hr_leaves');
            $request_data['file'] = $imageFileName;
            if ($request_data['file'] == null) {
                unset($request_data['file']);
            }
            $query = $data->query();
            $query
                ->update()
                ->set($request_data)
                ->where(['leave_id' => $leave_id])
                ->execute();
            //Set Flash
            $this->Flash->info('Leave Application Edited Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'leave']);
        }

        $data = TableRegistry::getTableLocator()->get('hr_leaves');
        $datas = $data->find()->where(['leave_id' => $leave_id])->toArray();
        $this->set('datas', $datas[0]);

        $id = $this->Auth->user('id');
        $year = date("Y");
        $config_key[] = 'casual_leave';
        $config_key[] = 'sick_leave';

        $halfleaves[] = "1";
        $halfleaves[] = "2";
        $this->set('halfleaves', $halfleaves);

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
                        'ca.config_action_id  = hr_config_action_setup.config_action_id'
                    ]
                ],
            ])
            ->toArray();
        $this->set('leave_type', $leave_type);
    }

    public function calender()
    {

    }

    // EMPLOYEE DESIGNATION INDEX FUNCTION
    public function designation()
    {
        $data = TableRegistry::getTableLocator()->get('employees_designation');
        $datas = $data->find();
        $paginate = $this->paginate($datas, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('employees_designation', $paginate);
    }

    // EMPLOYEE DESIGNATION ADD FUNCTION
    public function addDesignation()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $articles = TableRegistry::getTableLocator()->get('employees_designation');
            $query = $articles->query();
            $query
                ->insert(['name'])
                ->values($request_data)
                ->execute();
            //Set Flash
            $this->Flash->success('Employees Designation Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'designation']);
        }
    }

    // EMPLOYEE DESIGNATION EDIT FUNCTION
    public function editDesignation($id)
    {
        if ($this->request->is(['post'])) {
            $data = TableRegistry::getTableLocator()->get('employees_designation');
            $query = $data->query();
            $query
                ->update()
                ->set($this->request->getData())
                ->where(['id' => $id])
                ->execute();
            //Set Flash
            $this->Flash->success('Employees Designation Edited Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'designation']);
        }

        $data = TableRegistry::getTableLocator()->get('employees_designation');
        $datas = $data->find()->where(['id' => $id])->toArray();
        $this->set('employees_designation', $datas[0]);
    }

    public function exEmployees()
    {
        $user = TableRegistry::getTableLocator()->get('employee');
        $users = $user->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where([
                'end_date IS NOT NULL',
                'status' => '0'
            ])
            ->order(['employee_order' => 'ASC'])
            ->select([
                'designation_name' => "d.name",
                'status' => "usr.status",
            ])
            ->join([
                'd' => [
                    'table' => 'employees_designation',
                    'type' => 'LEFT',
                    'conditions' => [
                        'd.id = employee.employees_designation_id '
                    ]
                ],
                'usr' => [
                    'table' => 'users',
                    'type' => 'LEFT',
                    'conditions' => [
                        'usr.id = employee.user_id '
                    ]
                ],
            ]);

        $paginate = $this->paginate($users, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('employees', $paginate);
    }

    public function inactiveEmployees()
    {
        $user = TableRegistry::getTableLocator()->get('employee');
        $users = $user->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where([
                'end_date IS NULL',
                'status' => '0'
            ])
            ->order(['employee_order' => 'ASC'])
            ->select([
                'designation_name' => "d.name",
                'status' => "usr.status",
            ])
            ->join([
                'd' => [
                    'table' => 'employees_designation',
                    'type' => 'LEFT',
                    'conditions' => [
                        'd.id = employee.employees_designation_id '
                    ]
                ],
                'usr' => [
                    'table' => 'users',
                    'type' => 'LEFT',
                    'conditions' => [
                        'usr.id = employee.user_id ',
                    ]
                ],
            ]);

        $paginate = $this->paginate($users, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('employees', $paginate);
    }

    public function liveClass()
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $save_data['start_by'] = $this->Auth->user('id');
            $save_data['date'] = date('Y-m-d', time() + 6 * 3600);
            $save_data['status'] = 1;
            $save_data['start_time'] = date('H:i', time() + 6 * 3600);
            $save_data['timesheet_section_id'] = $data['timesheet_section_id'];
            $save_data['user_id'] = $data['user_id'];
            $scms_timesheet_live_class = TableRegistry::getTableLocator()->get('scms_timesheet_live_class');
            $query = $scms_timesheet_live_class->query();
            $query
                ->insert(array_keys($save_data))
                ->values($save_data)
                ->execute();
            $this->Flash->info('Class Started', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'liveClass']);
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

        $user = TableRegistry::getTableLocator()->get('employee');
        $users = $user->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['status' => '1'])
            ->order(['employee_order' => 'ASC'])
            ->select([
                'designation_name' => "d.name",
                'status' => "usr.status",
            ])
            ->join([
                'd' => [
                    'table' => 'employees_designation',
                    'type' => 'LEFT',
                    'conditions' => [
                        'd.id = employee.employees_designation_id '
                    ]
                ],
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

    public function classList()
    {
        $scms_timesheet_live_class = TableRegistry::getTableLocator()->get('scms_timesheet_live_class');
        $live_class = $scms_timesheet_live_class
            ->find()
            ->where(['date' => date("Y-m-d")])
            ->where(['scms_timesheet_live_class.status' => 1])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'session_name' => "scms_sessions.session_name",
                'employee_name' => "employee.name",
                'level_name' => "scms_levels.level_name",
                'shift_name' => "hr_shift.shift_name",
                'section_name' => "scms_sections.section_name",
                'course_name' => "scms_courses.course_name",
            ])
            ->join([
                'scms_timesheet_section' => [
                    'table' => 'scms_timesheet_section',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_timesheet_section.timesheet_section_id = scms_timesheet_live_class.timesheet_section_id'
                    ]
                ],
                'scms_sessions' => [
                    'table' => 'scms_sessions',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_timesheet_section.session_id = scms_sessions.session_id'
                    ]
                ],
                'employee' => [
                    'table' => 'employee',
                    'type' => 'LEFT',
                    'conditions' => [
                        'employee.user_id = scms_timesheet_live_class.user_id'
                    ]
                ],
                'scms_levels' => [
                    'table' => 'scms_levels',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_timesheet_section.level_id = scms_levels.level_id'
                    ]
                ],
                'hr_shift' => [
                    'table' => 'hr_shift',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_timesheet_section.shift_id = hr_shift.shift_id'
                    ]
                ],
                'scms_sections' => [
                    'table' => 'scms_sections',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_timesheet_section.section_id = scms_sections.section_id'
                    ]
                ],
                'scms_courses' => [
                    'table' => 'scms_courses',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_timesheet_section.course_id = scms_courses.course_id'
                    ]
                ],
            ])->toArray();
        $this->set('live_classes', $live_class);
    }

    public function endClass($id)
    {
        $save_data['end_by'] = $this->Auth->user('id');
        $save_data['status'] = 0;
        $save_data['end_time'] = date('H:i', time() + 6 * 3600);
        $scms_timesheet_live_class = TableRegistry::getTableLocator()->get('scms_timesheet_live_class');
        $query = $scms_timesheet_live_class->query();
        $query
            ->update()
            ->set($save_data)
            ->where(['timesheet_live_class_id' => $id])
            ->execute();
        $this->Flash->info('Class Ended', [
            'key' => 'positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'classList']);
    }

}
