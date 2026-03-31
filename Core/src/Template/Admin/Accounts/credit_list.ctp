<?php

$this->Form->unlockField('bank');
$this->Form->unlockField('role_id');
$this->Form->unlockField('user_id');
$this->Form->unlockField('start_date');
$this->Form->unlockField('end_date');
$this->Form->unlockField('status');
$this->Form->unlockField('purpose');
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
        <?php echo $this->Form->create(); ?>
            <div class="form">
                <section>
                    <h4><?= __d('setup', 'Search Credit') ?></h4>
                    <div class="row p-2">
                        <div class="col-md-4 ">
                            <label for="inputState" class="form-label"><?= __d('setup', 'Bank') ?></label>
                            <select id="" size="5" class="form-select option-class dropdown260 " name="bank[]" multiple="multiple">
                                <option value=""><?= __d('accounts', '-- Choose --') ?></option>
                            <?php foreach ($banks as $bank) { ?>
                                <option value="<?php echo $bank['bank_id']; ?>"><?php echo $bank['bank_name']; ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4 ">
                            <label for="inputState" class="form-label"><?= __d('setup', 'Roles') ?></label>
                            <select class="form-control" name="role_id" id="role_id">
                                <option value=""><?= __d('accounts', '-- Choose --') ?></option>
                            <?php foreach ($roles as $role) { ?>
                                <option value="<?= $role['id']; ?>"><?= $role['title']; ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4 ">
                            <label for="inputState" class="form-label"><?= __d('setup', 'User') ?></label>
                            <select class="form-control" name="user_id" id="user_id">
                                <option value=""><?= __d('accounts', '-- Choose --') ?></option>
                            </select>
                        </div>


                        <div class="col-md-6 mt-2">
                            <label for="inputState" class="form-label"><?= __d('setup', 'Start Date') ?></label>
                            <input name="start_date" type="date" class="form-control">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="inputState" class="form-label"><?= __d('setup', 'End Date') ?></label>
                            <input name="end_date" type="date" class="form-control">
                        </div>
                    </div>
                </section>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
            </div>
        <?php echo $this->Form->end(); ?>
        </div>
    <?php if (isset($transactions)) { ?>
        <div class="rows">
            <h3 class="text-center"><?= __d('accounts', 'All Credit') ?></h3>
            <div class="flexButton mb-3" style="display:flex;justify-content: flex-end; margin-right: 10px;">
                <span class="text-center"><?php echo $this->Html->link('Add Credit', ['action' => 'addCredit'], ['class' => 'btn btn-success']) ?></span>
        </div>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;">TRN. No</th>
                        <th style="text-align: center;">Date</th>
                        <th style="text-align: center;">Student Name</th>
                        <th style="text-align: center;">SID</th>
                        <th style="text-align: center;">Session</th>
                        <th style="text-align: center;">Level</th>
                        <th style="text-align: center;">Employee</th>
                        <th style="text-align: right;">Bank</th>
                        <th style="text-align: right;">Amount</th>
                        <th style="text-align: right;">Discount</th>
                         <th style="text-align: right;">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($transactions as $transaction) { ?>
                    <tr>
                        <td style="font-size: 13px; text-align: center;"><?php echo $transaction['trn_no']; ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo date("d-m-Y h:i:A",strtotime($transaction['transaction_date'])); ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo $transaction['student_name']; ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo $transaction['sid']; ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo $transaction['session_name']; ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo $transaction['level_name']; ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo $transaction['employee_name']; ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo $transaction['bank_name']; ?></td>
                        <td style="font-size: 13px; text-align: right;"><?php echo number_format((float)$transaction['amount'], 2, '.', ''); ?></td>
                        <td style="font-size: 13px; text-align: right;"><?php echo number_format((float)$transaction['discount_amount'], 2, '.', ''); ?></td>

                        <td>
                            <?php echo $this->Html->link('Print', ['action' => 'moneyRecpit',  $transaction['transaction_id']], ['class' => 'btn action-btn btn-success']) ?>                               
                            <?php echo $this->Form->postLink('Delete', ['action' => 'deleteTransaction',  $transaction['transaction_id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
                        </td>
                    </tr>
                <?php }
                } ?>

                </tbody>
            </table>
        </div>

    </body>

</html>
<script type='text/javascript'>
    $(document).ready(function () {
        $("option:selected").map(function () {
            return this.value
        }).get().join(", ");
    });

    $("#role_id").change(function () {
        var role_id = $("#role_id").val();
        $.ajax({
            url: 'getUserAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "role_id": role_id,
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["name"];
                    var id = data[i]["id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#user_id').html(text1);

            }
        });
    });
</script>
