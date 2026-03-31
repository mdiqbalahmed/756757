<?php

use Cake\ORM\TableRegistry;

$user = TableRegistry::getTableLocator()->get('employee');
$users = $user->find()
    ->enableAutoFields(true)
    ->enableHydration(false)
    ->order(['CAST(employee_order AS SIGNED)' => 'ASC'])
    ->where(['featured' => '1'])
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
    ->toArray(); ?>

<?php foreach ($users as $user) { ?>
    <div id="empSidebar" class="mb-2 accordianIn ">
        <h6 class="bg-success text-center"><?= $user['designation_name'] ?></h6>
        <div class="text-center p-2"><img src="<?= $this->Url->image('/webroot/uploads/employee_images/regularSize/' . $user['image_name']); ?>" alt="<?= $user['image_name'] ?>" width="200px"></div>
        <h3 class="empName mt-2"><?= $user['name'] ?></h3>
    </div>
<?php } ?>
