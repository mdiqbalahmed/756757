<?php

$this->Form->unlockField('session');
$this->Form->unlockField('start_date');
$this->Form->unlockField('end_date');
$this->Form->unlockField('sid');
$this->Form->unlockField('level_id');

$sid=isset($request_data['sid']) ? $request_data['sid'] : null;
$session_id=isset($request_data['session']) ? $request_data['session'] : 0;
$start_date=isset($request_data['start_date']) ? $request_data['start_date'] : 0;
$end_date=isset($request_data['end_date']) ? $request_data['end_date'] : 0;
$level_id = isset($request_data['level_id']) ? $request_data['level_id'] : '';

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>

        <div class="container">
            <div class="header">

            </div>
        <?php echo $this->Form->create(); ?>
            <div class="form">
                <section>
                    <h4><?= __d('setup', 'Search Transaction') ?></h4>
                    <div class="row p-2">
                        <div class="col-md-6 ">
                            <label for="inputState" class="form-label"><?= __d('setup', 'Session') ?></label>
                            <select id=""  class="form-select option-class dropdown260 " name="session">
                             
                            <?php foreach ($sessions as $session) { ?>
                                <option value="<?php echo $session['session_id']; ?>" <?php if($session_id ==$session['session_id'] ){echo 'selected'; }?>><?php echo $session['session_name']; ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 ">
                            <label for="inputState" class="form-label"><?= __d('setup', 'Class') ?></label>
                            <select id="" class="form-select option-class dropdown260 " name="level_id">
                             
                                <?php foreach ($levels as $level) { ?>
                                    <option value="<?php echo $level['level_id']; ?>" <?php if ($level_id == $level['level_id']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $level['level_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 ">
                            <label for="inputState" class="form-label"><?= __d('setup', 'SID') ?></label>
                            <input type="text" id="sid" value="<?php echo $sid; ?>" class="form-select" name="sid" >
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="inputState" class="form-label"><?= __d('setup', 'Start Date') ?></label>
                            <input name="start_date" type="datetime-local" class="form-control" value="<?php if($start_date) {echo date("Y-m-d H:i:s", strtotime($start_date));} ?>">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="inputState" class="form-label"><?= __d('setup', 'End Date') ?></label>
                            <input name="end_date" type="datetime-local" class="form-control"value="<?php if($end_date) { echo date("Y-m-d H:i:s", strtotime($end_date)-1);} ?>">
                        </div>
                    </div>
                </section>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
            </div>
        <?php echo $this->Form->end(); ?>
        </div>
    <?php if (isset($vouchers)) { ?>


        <div class="rows">
            <h3 class="text-center"><?= __d('accounts', 'Unpaid Vouchers') ?></h3>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('accounts', 'Voucher No') ?></th>
                        <th><?= __d('accounts', 'SID') ?></th>
                        <th><?= __d('accounts', 'Name') ?></th>
                        <th><?= __d('accounts', 'Roll') ?></th>
                        <th><?= __d('accounts', 'Section') ?></th>
                        <th><?= __d('accounts', 'Session') ?></th>
                        <th><?= __d('accounts', 'Class') ?></th>
                        <th><?= __d('accounts', 'Month(s)') ?></th>
                        <th><?= __d('accounts', 'Amount') ?></th>
                        <th><?= __d('accounts', 'Status') ?></th>
                        <th><?= __d('accounts', 'Create Date') ?></th>
                        <th colspan="2"><?= __d('accounts', 'Action') ?></th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($vouchers as $voucher) { ?>
                    <tr>
                        <td><?php echo $voucher['voucher_no'] ?></td>
                        <td><?php echo $voucher['sid'] ?></td>
                        <td><?php echo $voucher['name'] ?></td>
                        <td><?php echo $voucher['roll'] ?></td>
                        <td><?php echo $voucher['section_name'] ?></td>
                        <td><?php echo $voucher['session_name'] ?></td>
                        <td><?php echo $voucher['level_name'] ?></td>
                        <td><?php echo $voucher['month_name'] ?></td>
                        <td style="text-align: right;"><?php echo number_format((float)$voucher['show_amount'], 2, '.', '')  ?></td>
                        <td><?php echo $voucher['status'] ?></td>
                        <td><?php echo $voucher['create_date'] ?></td>
                        <td colspan="2">
                                <?php echo $this->Html->link('Edit', ['action' => 'editUnpaidVouchers',  $voucher['id']], ['class' => 'btn action-btn btn-warning']) ?>
                        <?php if($voucher['payment_status']==0) { ?>       
                                <?php echo $this->Form->postLink('Delete', ['action' => 'deleteVoucher',  $voucher['id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
                        <?php } ?>    
                        </td>
                    </tr>
                <?php }
                } ?>

                </tbody>
            </table>
        </div>
    </body>

</html>

