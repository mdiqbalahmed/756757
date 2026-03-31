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


foreach ($employees as $employee) {
    if (isset($employee['role_title']) && $employee['role_title'] === 'xhead') {
        continue; // Skip 'xhead' roles
    }
?>
    <div class="col-md-4 teachers col-6 mb-4">
        <a href="<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'employeesProfile', $employee['employee_id']]); ?>">
            <?php
                echo $this->Html->image('/webroot/uploads/employee_images/regularSize/' . $employee['image_name'], [
                    'alt' => $employee['employee_name'],
                    'class' => 'custom_img'
                ]);
            ?>
            <span class="name_deg pt-2 pb-4 px-2">
                <?= h($employee['employee_name']) ?><br>
                <?= h($employee['designation_title']) ?>
            </span>
        </a>
    </div>
<?php
}

// Second: Conditionally show the 'xhead' table
$hasXhead = false;
foreach ($employees as $employee) {
    if (isset($employee['role_title']) && $employee['role_title'] === 'xhead') {
        $hasXhead = true;
        break;
    }
}

if ($hasXhead) {
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
            if (isset($head['role_title']) && $head['role_title'] === 'xhead') {
        ?>
            <tr>
                <td><?= $serial++ ?></td>
                <td><?php
                echo $this->Html->image('/webroot/uploads/employee_images/regularSize/' . $head['image_name'], [
                    'alt' => $head['employee_name'],
                    'class' => 'custom_img',
                    'style' => 'height: 86px; width: 86px;'
                ]);
            ?></td>
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
