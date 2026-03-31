<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
</head>

<body>

    <div class="rows">
        <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Courses', ['action' => 'addCourse'], ['class' => 'btn btn-info']) ?></span>
    </div>


    <?php
    $this->Form->unlockField('course_type_id');

    ?>
    <?php echo $this->Form->create(); ?>
    <section>
        <h4 class="mt-4"><?= __d('setup', 'Search Course') ?></h4>
        <div class="row mx-2 p-3">
            <div class="col-md-4 ">
                <label for="inputState" class="form-label"><?= __d('setup', 'Session') ?></label>
                <select id="inputState" class="form-select dropdown260" name="course_type_id">
                    <option value=""><?= __d('setup', 'Choose...') ?></option>
                    <?php foreach ($course_types as $course_type) { ?>
                        <option value="<?php echo $course_type['course_type_id']; ?>" <?php if ($course_type['course_type_id'] == $request_data['course_type_id']) {
                                                                                            echo 'Selected';
                                                                                        } ?>><?php echo $course_type['course_type_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </section>
    <div class="text-right mt-2">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
    </div>
    <?php echo $this->Form->end(); ?>

    <div class="table-responsive-sm">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('setup', 'ID') ?></th>
                    <th><?= __d('setup', 'Course Name') ?></th>
                    <th><?= __d('setup', 'Course Code') ?></th>
                    <th><?= __d('setup', 'Department Name') ?></th>
                    <th><?= __d('setup', 'Course Type') ?></th>
                    <th><?= __d('setup', 'Group') ?></th>
                    <th><?= __d('setup', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result) { ?>
                    <tr>
                        <td><?php echo $result['course_id'] ?></td>
                        <td><?php echo $result['course_name'] ?></td>
                        <td><?php echo $result['course_code'] ?></td>
                        <td><?php echo $result['department_name'] ?></td>
                        <td><?php echo $result['course_type_name'] ?></td>
                        <td><?php echo $result['group_name'] ?></td>
                        <td>
                            <?php echo $this->Html->link('Edit', ['action' => 'editCourse', $result['course_id']], ['class' => 'btn action-btn btn-warning']) ?>
                            <?php $this->Form->postLink('Delete', ['action' => 'editCourse', $result['course_id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination mt-5 custom-paginate justify-content-center">
            <li class="page-item"> <?= $this->Paginator->first("First") ?></li>
            <li class="page-item"><?= $this->Paginator->prev("<<") ?></li>
            <li class="page-item"><?= $this->Paginator->numbers() ?></li>
            <li class="page-item"><?= $this->Paginator->next(">>") ?></li>
            <li class="page-item"><?= $this->Paginator->last("Last") ?></li>
        </ul>
    </nav>
</body>

</html>
