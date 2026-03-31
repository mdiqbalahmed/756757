    <?php

    use Cake\Core\Configure;
    $siteTemplate = Configure::read('Site.template');
    ?>
    
    <?php if ($siteTemplate == 2) { ?>
        <div class="container my-3">
            <h4 class="content_title">
                <?php if ($employees != null) {
                    echo $employees[0]['role_title'];
                } else {
                    echo "No Roles Found";
                } ?>
            </h4><!-- Title should be dynamic here -->
            <div class="row mt-3 grid_emp">
                <?php foreach ($employees as $employee) { ?>
                    <div class="col-md-4 teachers col-6 mb-4 ">
                        <a href="<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'employeesProfile', $employee['employee_id']]); ?>">
                            <?php echo $this->Html->image('/webroot/uploads/employee_images/regularSize/' . $employee['image_name'], ['alt' => $employee['employee_name'], 'class' => 'custom_img']); ?>
                            <span class="name_deg  pt-2 pb-4 px-2">
                                <?= $employee['employee_name'] ?><br>
                                <?= $employee['designation_title'] ?>
                            </span>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <h4 class="content_title">
            <?php if ($employees != null) {
                echo $employees[0]['role_title'];
            } else {
                echo "No Roles Found";
            } ?>
        </h4><!-- Title should be dynamic here -->
        <div class="row mt-3 grid_emp">
            <?php


// Define the role IDs that should be handled separately (like 'xhead')
$headRoleIds = [18, 19, 20];

// First: Show all employees except those with 'head' roles
foreach ($employees as $employee) {
    // Skip employees whose role_id is in $headRoleIds
    if (isset($employee['role_id']) && in_array($employee['role_id'], $headRoleIds)) {
        continue;
    }
?>
    <div class="col-md-4 teachers col-6 mb-4">
        <?php
        $imagePath = !empty($employee['image_name'])
            ? '/webroot/uploads/employee_images/regularSize/' . $employee['image_name']
            : '/webroot/img/demo.jpg'; 
        ?>
        
        <a href="<?= $this->Url->build(['controller' => 'Employees', 'action' => 'employeesProfile', $employee['employee_id']]) ?>">
            <?= $this->Html->image($imagePath, [
                'alt' => $employee['employee_name'],
                'class' => 'custom_img'
            ]) ?>
            <span class="name_deg pt-2 pb-4 px-2">
                <?= h($employee['employee_name']) ?><br>
                <?= h($employee['designation_title']) ?>
            </span>
        </a>

    </div>
<?php
}

// Second: Check if there are any 'head' roles
$hasHead = false;
foreach ($employees as $employee) {
    if (isset($employee['role_id']) && in_array($employee['role_id'], $headRoleIds)) {
        $hasHead = true;
        break;
    }
}

if ($hasHead) {
?>
    <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th>সিরিয়াল</th>
                <th>Photo</th>
                <th>নাম</th>
                <th>পদবি</th>
                <th>মেয়াদ</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $serial = 1;
        foreach ($employees as $head) {
            if (isset($head['role_id']) && in_array($head['role_id'], $headRoleIds)) {
        ?>
            <tr>
                <td><?= $serial++ ?></td>
                
                <?php
                $imagePath = !empty($head['image_name'])
                    ? '/webroot/uploads/employee_images/regularSize/' . $head['image_name']
                    : '/webroot/img/demo.jpg'; 
                ?>
                
                
                
                <td>
                    <?= $this->Html->image($imagePath, [
                        'alt' => $head['employee_name'],
                        'class' => 'custom_img',
                        'style' => 'height: 86px; width: 86px;'
                    ]) ?>
                </td>
                <td><?= h($head['employee_name']) ?></td>
                <td><?= h($head['designation_title']) ?></td>
                <td><?= h($head['join_date']) ?> To <?= h($head['end_date']) ?></td>
            </tr>
        <?php 
            }
        } 
        ?>
        </tbody>
    </table>
<?php } ?>



        </div>
    <?php } ?>
