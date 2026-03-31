<?php

echo $this->Form->unlockField('level_id');
echo $this->Form->unlockField('session_id');
echo $this->Form->unlockField('month');


$level_id = isset($level_id) ? $level_id : '';
$session_id = isset($session_id) ? $session_id : '';

?>

<div class="container">
    <div class="header">
        <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
            <?= __d('accounts', 'Voucher Generate') ?>
        </h3>
    </div>

    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <div class="form ">
        <section class="bg-light mt-1 p-2 m-auto" action="#">
            <fieldset>
                <div class="p-2">
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p class="label-font13">
                                        <?= __d('accounts', 'Session') ?>
                                    </p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <select class="form-control" name="session_id" id="sessionSelect" required>
                                        <option value="">
                                            <?= __d('accounts', '-- Choose --') ?>
                                        </option>
                                        <?php foreach ($sessions as $session) { ?>
                                        <option value="<?= $session['session_id']; ?>" <?php if ($session_id == $session['session_id']) echo 'selected'; ?>><?= $session['session_name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p class="label-font13">
                                        <?= __d('accounts', 'Class') ?>
                                    </p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <select class="form-control" name="level_id" id="levelSelect" required>
                                        <option value="">
                                            <?= __d('accounts', '-- Choose --') ?>
                                        </option>
                                        <?php foreach ($levels as $level) { ?>
                                        <option value="<?= $level['level_id']; ?>" <?php if ($level_id == $level['level_id']) echo 'selected'; ?>><?= $level['level_name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </section>
    </div>
    <p class="error_message_student_fees hidden" style="margin-left: -10px;" id="error_message_student_fees">No months in this sessions, ! Please try again</p>
    <div class="month_form"  id="month_form" style="margin:10px; padding-bottom: 100px;">
        <div id="add_block">
             <?php if(isset($months)) {?>
             <?php foreach($months as $month) {
                 $class_name='';
                 $disable='';
                  $checked='';
                 if($month['checkd']){
                   $class_name='due';
                   $disable='disabled';
                 }else if($month['setup']){
                   $class_name='checked';
                   $checked='checked';
                 }else if($month['set']){
                   $class_name='unchecked';
                    $disable='disabled';
                 }else{
                   $class_name='not_set';
                   $disable='disabled';
                 }
                 
                 ?>
            <div class="checkbox" id="<?= $month['name']; ?>"><label for="month<?= $month['id']; ?>" class="<?= $class_name; ?>"><?= $month['name']; ?></label><input type="checkbox" id="month_<?= $month['name']; ?>" name="month[]" value="1" <?= $disable; ?> <?= $checked; ?>  ></div>     
             <?php } ?>        
     <?php } ?>
        </div>
    </div>

    <div class="row hidden" id="proceed">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-6">
        </div>
        <div class="col-lg-1 mt-4">
            <button type="submit" class="btn btn-info"><?= __d('accounts', 'Generate') ?></button>
        </div>
    </div>

    <div class="student_block"  id="student_block" style="margin:10px;">
        <div id="student">
             <?php if(isset($voucher_data)) { ?>

            <div class="table-responsive-sm">
                <table class="table table-bordered table-striped" style="margin-top:10px;">
                    <thead class="thead-dark">
                        <tr>
                            <th><?= __d('accounts', 'SID') ?></th>
                            <th><?= __d('accounts', 'Name') ?></th>
                            <th><?= __d('accounts', 'Roll') ?></th>
                            <th><?= __d('accounts', 'Level') ?></th>
                            <th><?= __d('accounts', 'Section') ?></th>
                            <th><?= __d('accounts', 'Group') ?></th>
                            <th align="right" ><?= __d('accounts', 'Amount') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach ($voucher_data as $voucher) { ?>
                        <tr>
                            <td><?php echo $voucher['view']['sid'] ?></td>
                            <td><?php echo $voucher['view']['name'] ?></td>
                            <td><?php echo $voucher['view']['roll'] ?></td>
                            <td><?php echo $voucher['view']['level_name'] ?></td>
                            <td><?php echo $voucher['view']['session_name'] ?></td>
                            <td><?php echo $voucher['view']['group_name'] ?></td>
                            <td align="right"> <?= number_format((float) $voucher['view']['amount'], 2, '.', '') ?></td>
                        </tr>
                <?php } ?>

                    </tbody>
                </table>
            </div>
             <?php } ?>
        </div>
    </div>

    <?php echo $this->Form->end(); ?>
</div>
<div>


 <?php if(isset($voucher_data)) { 
     echo $this->Form->unlockField('level_id');
     echo $this->Form->unlockField('session_id');
     echo $this->Form->unlockField('month');
     echo $this->Form->unlockField('save');
     ?>

    <?= $this->Form->create(); ?>
    <input type="hidden"  name="session_id"  value="<?php echo $session_id ?>" />
    <input type="hidden"  name="level_id"  value="<?php echo $level_id ?>" />
     <?php  foreach ($set_months as $key =>  $set_month) { ?>
    <input type="hidden"  name="<?php echo 'month['.$key.']' ?>"  value="<?php echo $set_month ?>" />
    <input type="hidden"  name="save"  value="1" />
    <?php } ?>
    <div class="text-right mt-5 save_voucher" id="save_voucher">
        <button type="submit" class="btn btn-info"><?= __d('accounts', 'Save Voucher') ?> </button>
    </div>
    <?= $this->Form->end(); ?>
 <?php } ?>
</div>

<script>
    function fetchMonths() {
        var error = document.getElementById("error_message_student_fees");
        var save_voucher = document.getElementById("save_voucher");
        if (save_voucher) {
            save_voucher.classList.add("hidden");
        }
        error.classList.add("hidden");
        $("#add_block").remove();
        $("#student").remove();
        var proceed = document.getElementById("proceed");
        proceed.classList.add("hidden");
        var selectedSessionId = $('#sessionSelect').val();
        var levelId = $("#levelSelect").val();

        if (selectedSessionId && levelId) {
            $.ajax({
                url: "getMonthsForVoucherAjax",
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "sessionId": selectedSessionId,
                    "levelId": levelId
                },
                success: function (response) {
                    data = JSON.parse(response);
                    if (data == -1) {
                        error.classList.remove("hidden");
                    } else {
                        var main_text = '<div id="add_block">';
                        for (let i = 0; i < data.length; i++) {
                            var name = data[i]["name"];
                            var id = data[i]["id"];
                            var disabled = '';
                            if (data[i]["checkd"]) {
                                var class_name = 'due';
                                var disabled = 'disabled';
                            } else if (data[i]["set"]) {
                                var class_name = 'unchecked';
                            } else {
                                var class_name = 'not_set';
                                var disabled = 'disabled';
                            }
                            var id_name = 'month_' + name;
                            var text = '<div class="checkbox" id="' + name + '"><label for="month1" class="' + class_name + '">' + name + '</label><input type="checkbox" id="' + id_name + '" name="month[]" value="' + id + '"' + disabled + '></div>';
                            main_text += text;
                        }
                        main_text += '</div>';
                        $("#month_form").append(main_text);
                        proceed.classList.remove("hidden");
                    }

                }
            });
        }
    }
    // Event handlers for session, level, and fees selection
    $("#sessionSelect").change(function () {
        fetchMonths();
    });
    $("#levelSelect").change(function () {
        fetchMonths();
    });

</script>
