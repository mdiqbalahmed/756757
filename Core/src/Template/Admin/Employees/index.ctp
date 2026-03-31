<?php

$this->Form->unlockField('name');
$this->Form->unlockField('mobile');
$this->Form->unlockField('designation_id');
$this->Form->unlockField('gender');
$this->Form->unlockField('type');

$name = isset($request_data['name']) ? $request_data['name'] : null;
$fmobile = isset($request_data['mobile']) ? $request_data['mobile'] : null;
$desig = isset($request_data['designation_id']) ? $request_data['designation_id'] : null;
$gender = isset($request_data['gender']) ? $request_data['gender'] : null;
$type = isset($request_data['type']) ? $request_data['type'] : null;

?>
<style>
.report_title {
    font-size: 15px;
    font-family: Verdana,
        Arial,
        Helvetica,
        sans-serif;
    width: 85%;
    margin: 14px auto;
    border: 1px dashed #727070;
    padding: 5px;
    height: 60px;
    text-align: center;
}

.student-thumbnail {
    height: 80px;
    width: 80px;
}

.verified-status {
    color: green;
}
</style>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Student</title>
</head>

<body>
    <div class="container noprint">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Search Employees') ?>
            </h3>
        </div>
        <?php echo  $this->Form->create(); ?>
        <div class="form">
            <section class="bg-light mt-1 p-2 m-auto" action="#">
                <fieldset>
                    <div class=" form_area p-2">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('clients', 'Name') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input type="text" value="<?php echo $name; ?>" name="name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Mobile') ?></p>
                                    </div>

                                    <div class="col-lg-9 row2Field">
                                        <input type="text" value="<?php echo $fmobile; ?>" name="mobile">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Designation') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="designation_id">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>

                                            <?php foreach ($designations as $designation) { ?>
                                            <option value="<?php echo $designation['id']; ?>" <?php if (isset($data['designation_id']) && $data['designation_id'] == $designation['id']) {
                                                                                                        echo 'selected';
                                                                                                    } ?>>
                                                <?php echo $designation['name']; ?>
                                            </option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Gender') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                    <select class="form-control" name="gender">
                                        <option value=""><?= __d('students', '-- Choose --') ?></option>
                                        <option value="Male" <?= ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?= ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                        <option value="Other" <?= ($gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Type') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                    <select class="form-control" name="type">
                                        <option value=""><?= __d('students', '-- Choose --') ?></option>
                                        <option value="teacher" <?= ($type == 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                                        <option value="staff" <?= ($type == 'staff') ? 'selected' : ''; ?>>Staff</option>
                                    </select>
                                </div>

                                </div>
                            </div>
                        </div>

                        </div>

                    </div>
                </fieldset>
            </section>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>



    <?php if (empty($where)) { ?>
    <div class="rows">
        <h3 class="text-center"><?= __d('employees', 'List of Active Employees') ?></h3>

    </div>
    <?php } else { ?>
    <div class="report_title">
        <?php



            if (!empty($head['mobile'])) {
                $output[] = 'Mobile: ' . $head['mobile'];
            }
            
            if (!empty($head['type'])) {
                $output[] = 'Type: ' . $head['type'];
            }

            if (!empty($head['designation'])) {
                $output[] = 'Designation: ' . $head['designation'];
            }

            if (!empty($section_name)) {
                $output[] = 'Section: ' . $section_name;
            }
            
            if (!empty($head['gender'])) {
                $output[] = 'Gender: ' . $head['gender'];
            }

            echo implode(', ', $output);
            ?>
    </div>
    <?php } ?>
    <span style="margin-right: 120px;margin-top: -62px;"
        class="text-right float-right mb-3"><?= $this->Html->link('Add Employee', ['action' => 'addEmployee'], ['class' => 'btn btn-info']) ?></span>
    <div class="row" style="margin-right: 25px;height: auto;width: 112%;">
        <div class="col-11">
            <div class="horizontal_scroll table-responsive-sm">


                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>

                            <th><?= __d('employees', '#') ?></th>
                            <th><?= __d('employees', 'Name') ?></th>
                            <th><?= __d('employees', 'Photo') ?></th>
                            <!--<th><?= __d('employees', 'Email') ?></th>-->
                            <th><?= __d('employees', 'Mobile') ?></th>
                            <th><?= __d('employees', 'Designation') ?></th>
                            <th><?= __d('employees', 'RFID') ?></th>
                            <th><?= __d('employees', 'Featured') ?></th>
                            <th><?= __d('employees', 'Order') ?></th>
                            <th><?= __d('employees', 'Permission') ?></th>
                            <th><?= __d('employees', 'Action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $serialNumber = 1;
                        foreach ($employees as $key => $employee) { ?>
                        <tr data-id="<?= $employee['employee_id'] ?>">
                            <td><?= $serialNumber++  ?></td>
                            <td><?= $employee['name']  ?></td>
                            <!--<td><?php echo $this->Html->image('/webroot/uploads/employee_images/regularSize/' . $employee['image_name']); ?>-->
                            <td>
                                <?php
                                // Define paths
                                $imagePath = '/webroot/uploads/employee_images/regularSize/' . $employee['image_name'];
                                $defaultImage = '/webroot/uploads/default.png'; // Default image
                            
                                // Check if image exists (use $_SERVER['DOCUMENT_ROOT'] for absolute path check)
                                $imageToShow = !empty($employee['image_name']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)
                                    ? $imagePath
                                    : $defaultImage;
                            
                                // Display the image
                                echo $this->Html->image($imageToShow, [
                                    'alt' => 'Employee Image',
                                    'style' => 'width: 100px; height: auto;'
                                ]);
                                ?>
                            </td>
                            <!--<td><?= $employee['email'] ?></td>-->
                            <td><?= $employee['mobile'] ?></td>
                            <td><?= $employee['designation_name'] ?></td>
                            <td><?= $employee['rf_id'] ?></td>
                            <td><?php if ($employee['featured'] != null) {
                                        echo 'Yes';
                                    } else {
                                        echo 'No';
                                    } ?></td>
                            <td>
                                <button class="order_button move-up"><i class="fa fa-chevron-up"></i></button>
                                <button class="order_button move-down mr-2"><i class="fa fa-chevron-down"></i></button>
                            </td>
                            <td>
                                <?= $this->Html->link('Permission', ['action' => 'permissions', $employee['employee_id']], ['class' => 'btn action-btn btn-success']) ?>
                            </td>
                            <td>

                            <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $employee['employee_id']], ['class' => 'btn action-btn btn-warning', 'escape' => false, 'target' => '_blank']) ?>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'deleteEmployee', $employee['employee_id']], ['class' => 'btn action-btn btn-danger', 'escape' => false, 'confirm' => 'Are you sure, You want delete this?']) ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
            <ul class="pagination mt-5 custom-paginate justify-content-center">
                <li class="page-item"> <?= $this->Paginator->first("First") ?></li>
                <li class="page-item"><?= $this->Paginator->prev("<<") ?></li>
                <li class="page-item"><?= $this->Paginator->numbers() ?></li>
                <li class="page-item"><?= $this->Paginator->next(">>") ?></li>
                <li class="page-item"><?= $this->Paginator->last("Last") ?></li>
            </ul>
        </nav>
            </div>
        </div>
    </div>


</body>
<script>
$(document).ready(function() {
    function updateEmpOrder(id1, order1, id2, order2) {
        $.ajax({
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "id1": id1,
                "order1": order1,
                "id2": id2,
                "order2": order2
            },
            url: 'employees/getEmployeeOrderAjax/', // Adjust the URL to match your setup
            success: function(response) {
                if (response === 'success') {
                    location.reload(); // Reload the page to show updated data
                }
            }
        });
    }

    $('.move-up').click(function() {
        var row = $(this).closest('tr');
        var id = row.data('id');
        var order = row.data('order');
        var prevRow = row.prev('tr');
        if (prevRow.length > 0) {
            var prevId = prevRow.data('id');
            var prevOrder = prevRow.data('order');
            row.insertBefore(prevRow);
            updateEmpOrder(id, order, prevId, prevOrder);
        }
    });

    $('.move-down').click(function() {
        var row = $(this).closest('tr');
        var id = row.data('id');
        var order = row.data('order');
        var nextRow = row.next('tr');
        if (nextRow.length > 0) {
            var nextId = nextRow.data('id');
            var nextOrder = nextRow.data('order');
            row.insertAfter(nextRow);
            updateEmpOrder(id, order, nextId, nextOrder);
        }
    });
});
</script>