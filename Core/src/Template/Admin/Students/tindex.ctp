<?php

$this->Form->unlockField('name_english');
$this->Form->unlockField('fmobile');
$this->Form->unlockField('serial');

$name = isset($request_data['name_english']) ? $request_data['name_english'] : null;
$serial = isset($request_data['serial']) ? $request_data['serial'] : null;
$fmobile = isset($request_data['fmobile']) ? $request_data['fmobile'] : null;
?>
<html lang="en">

<style>
.student-thumbnail {
    height: 80px;
    width: 80px;
}

.verified-status {
    color: green;
}
.listBtn{
    font-size: 12px;
    border: 2px solid chocolate;
    border-radius: 5px;
    padding: 8px;
    background-color: crimson;
    color: cornsilk;
    font-style: oblique;
}
</style>

<body>
    <div class="container">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Search Students') ?>
            </h3>
        </div>
        <?php echo $this->Form->create('', ['type' => 'file']); ?>
        <div class="form">
            <section class="bg-light mt-1 p-2 m-auto" action="#">
                <fieldset>
                    <div class="form_area p-2">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('clients', 'Name') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input type="text" value="<?php echo $name; ?>" name="name_english">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'serial') ?></p>
                                    </div>

                                    <div class="col-lg-9 row2Field">
                                        <input type="text" value="<?php echo $serial; ?>" name="serial">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Mobile') ?></p>
                                    </div>

                                    <div class="col-lg-9 row2Field">
                                        <input type="text" value="<?php echo $fmobile; ?>" name="fmobile">
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


    <?php if (isset($students)) { ?>
        <div class="row" style="margin-right: 25px;">
            <div class="col-12">
                <div class="horizontal_scroll table-responsive-sm">
                    
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                    <th><?= __d('students', 'SL') ?></th>
                    <th><?= __d('students', 'Photo') ?></th>
                    <th><?= __d('students', '') ?></th>
                    <th><?= __d('students', 'GSA ID') ?></th>
                    <th><?= __d('students', 'Name') ?></th>
                    <th><?= __d('students', 'SID') ?></th>
                    <th><?= __d('students', 'Father') ?></th>
                    <th><?= __d('students', 'Mother') ?></th>
                    <th><?= __d('students', 'Mobile') ?></th>
                    <th><?= __d('students', 'Serial') ?></th>
                    <th><?= __d('students', 'Shift') ?></th>
                    <th><?= __d('students', 'DOB') ?></th>
                    <th><?= __d('students', 'Status') ?></th>
                    <th><?= __d('students', 'Update') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $serial_number = 1;
                            foreach ($students as $data) {
        
                            ?>
                        <tr>
                            
                            <td><?php echo $serial_number++ ?></td>
                            <td class="student-thumbnail">
                                <?php echo $this->Html->image('/webroot/uploads/students/thumbnail/' . $data['thumbnail']); ?>
                            </td>
                            <td>
                                <?php 
                                if ($data['status'] == 1) {
                                    echo $this->Html->link(
                                        'Change Status', 
                                        ['controller' => 'Students', 'action' => 'changeStatus', $data['id']], 
                                        ['class' => 'listBtn']
                                    ); 
                                }
                                ?>
                            </td>
        
                            <td><?php echo $data['gsa_id'] ?></td>
                            <td class="st_name"><?php echo $data['name_english'] ?></td>
                            <td><?php echo $data['sid'] ?></td>
                            <td><?php echo $data['fname'] ?></td>
                            <td><?php echo $data['mname'] ?></td>
                            <td><?php echo $data['fmobile'] ?></td>
                            <td><?php echo $data['serial'] ?></td>
                            <td><?php echo $data['shift'] ?></td>
                            <td><?php echo $data['date_of_birth'] ?></td>
                            <td>
                                <?php if (!empty($data['sid'])) { ?>
                                    <span style="color: green;">UPDATED</span>
                                <?php } else { ?>
                                    <span style="color: red;">NOT-UPDATED</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (empty($data['sid']) && isset($data['status']) && $data['status'] == 1) { ?>
                                    <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'tedit', $data['id']], ['class' => 'btn action-btn btn-warning', 'escape' => false, 'target' => '_blank']) ?>
                                <?php } else { ?>
                                    <span style="color: red;">X</span>
                                <?php } ?>
                            </td>

                        </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    <?php  } ?>
</body>

</html>