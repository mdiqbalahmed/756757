<?php

$this->Form->unlockField('level_id');
$this->Form->unlockField('session_id');
$this->Form->unlockField('month');
$this->Form->unlockField('sid');
$this->Form->unlockField('purpose_name'); 
$this->Form->unlockField('hidden_purpose_name'); 
$this->Form->unlockField('month');
$this->Form->unlockField('total'); 
$this->Form->unlockField('discount_amount'); 


$level_id = isset($level_id) ? $level_id : '';
$session_id = isset($session_id) ? $session_id : '';

?>

<div class="container">
    <div class="header">
        <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
            <?= __d('accounts', 'Individual Voucher') ?>
        </h3>
    </div>

 <?php  echo  $this->Form->create('', ['type' => 'file']); ?>
    <div class="form">
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
                    <div class="row mb-1">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-5">
                            <div class="row">
                                <div class="col-lg-4 mt-3">
                                    <p class="label-font13"><?= __d('accounts', 'Student ID') ?></p>
                                </div>
                                <div class="col-lg-7 row2Field">
                                    <input type="text" id="sid" name="sid" class="" value="" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div style="height: 110px; width: 250px; background-color: #dbd7d7; padding: 5px;" id="student_info" class="hidden">
                                <img id="inner_Image"class="img-fluid" style="height:65px; width: 65px; margin-left: 90px;" src="">
                                <p  id="inner_name"style="text-align:center; font-size: 16px; font-weight: 600"></p>
                                <p id="inner_details" style="text-align:center; margin-top:0px;"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </section>
    </div>
    <p class="error_message_student_fees hidden" style="margin-left: -10px;" id="error_month">No months in this sessions, ! Please try again</p>
    <p class="error_message_student_fees hidden" style="margin-left: -10px;" id="error_student">No student found in this sessions, ! Please try again</p>
    <div class="month_form"  id="month_form" style="margin:10px; padding-bottom: 100px;">
        <div id="add_block">
        </div>
    </div>

    <div class="row hidden" id="proceed">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-6">
        </div>
        <div class="col-lg-1">
            <div style="text-align: right; margin-top: 20px;">
                <a onclick="getPurpose()" class="btn btn-info"><?= __d('setup', 'Proceed') ?></a>
            </div> 
        </div>
    </div>

    <div class="purpose_block" id="purpose_block">

    </div>
    <p class="error_message_student_fees hidden" id="no_month_error">No, Month is selected! Please select at least one month</p>
    <div class="text-right mt-2 hidden" id="submit" style="margin-right: 30px;">
        <button type="submit" disabled class="btn final_submit btn-info"><?= __d('accounts', 'Save') ?></button>
    </div>
 <?php  echo $this->Form->end(); ?>
</div>

<script>
    function calculateTotal() {
        let discount = $("#discount").val();
        let total = 0;
        $("input[id^='purpose_amount_']").each(function (i, el) {
            if (this.value) {
                total = total + this.value * 1;
            }
        });
        if (discount) {
            total = total - discount;
        }
        total = total.toFixed(2);
        $("#total").val(total);


    }
    function fetchMonths() {
        var error_month = document.getElementById("error_month");
        var error_student = document.getElementById("error_student");
        var student_info = document.getElementById("student_info");
        student_info.classList.add("hidden");
        error_month.classList.add("hidden");
        error_student.classList.add("hidden");
        $("#add_block").remove();
        $("#student").remove();
        var proceed = document.getElementById("proceed");
        proceed.classList.add("hidden");
        var selectedSessionId = $('#sessionSelect').val();
        var levelId = $("#levelSelect").val();
        var sid = $("#sid").val();

        if (selectedSessionId && levelId && sid) {
            $.ajax({
                url: "getMonthsForIndivisulVoucherAjax",
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "sessionId": selectedSessionId,
                    "levelId": levelId,
                    "sid": sid
                },
                success: function (response) {
                    data = JSON.parse(response);
                    if (data.student == -1) {
                        error_student.classList.remove("hidden");
                    } else {
                        if (data.month == -1) {
                            error_month.classList.remove("hidden");
                        } else {
                            let month = data.month;
                            var student_name = data.student.name;
                            if (data.student.thumbnail) {
                                var img = "/new%20scms/scms_git/webroot/uploads/students/thumbnail/" + data.student.thumbnail;
                                document.getElementById('inner_Image').src = img;
                            } else {
                                document.getElementById("inner_Image").remove();
                            }
                            if (data.student.group_name) {
                                var student_details = data.student.level_name + '(' + data.student.section_name + ') -' + data.student.group_name;
                            } else {
                                var student_details = data.student.level_name + '(' + data.student.section_name + ')';
                            }
                            document.getElementById("inner_name").innerHTML = student_name;
                            document.getElementById("inner_details").innerHTML = student_details;
                            student_info.classList.remove("hidden");

                            var main_text = '<div id="add_block">';
                            for (let i = 0; i < month.length; i++) {
                                var name = month[i]["name"];
                                var id = month[i]["id"];
                                var disabled = '';
                                if (month[i]["set_month"] && month[i]["exist"]) {
                                    var class_name = 'due';
                                    var disabled = 'disabled';
                                } else if (month[i]["set_month"]) {
                                    var class_name = 'unchecked';
                                    var disabled = '';
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

                }
            });
        }
    }
    function getPurpose() {
        getPurposeAjax();
    }
    function getPurposeAjax() {
        $("#purpose_block_id").remove();
        var submit = document.getElementById("submit");
        submit.classList.add("hidden");
        $('.final_submit').prop('disabled', true);
        let month_ids = [];
        $("input[id^='month']").each(function (i, el) {
            if (this.checked) {
                month_ids.push(this.value);
            }
        });
        var error = document.getElementById("no_month_error");
        if (month_ids.length == 0) {
            error.classList.remove("hidden");
        } else {
            error.classList.add("hidden");
            var sid = $("#sid").val();
            var session_id = $("#sessionSelect").val();
            if (sid && session_id) {
                $.ajax({
                    url: 'getPurposeAjax',
                    cache: false,
                    type: 'GET',
                    dataType: 'HTML',
                    data: {
                        "sid": sid,
                        "session_id": session_id,
                        "month_ids": month_ids
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        var main_text = '<div class="table-responsive-sm" id="purpose_block_id"><table class="table table-borderless table-striped table-dark  mt-5"><tbody>';
                        let i = 0;
                        let sum = 0;
                        while (i < data.length) {

                            var purpose_name_1 = data[i]["purpose_name"];
                            var purpose_id_1 = data[i]["purpose_id"];
                            let amount_1 = data[i]["amount"];
                            var amount_name_1 = 'purpose_name[' + purpose_id_1 + ']';
                            var hidden_amount_name_1 = 'hidden_purpose_name[' + purpose_id_1 + ']';
                            if (amount_1) {
                                sum = sum + amount_1;
                            }
                            amount_1 = Number(amount_1);
                            amount_1 = amount_1.toFixed(2);
                            var text1 = ' <tr><td colspan="2">' + purpose_name_1 + '</td><td class="text-center "><input style="color: darkmagenta;font-size: large;font-weight: 600;text-align: right;"id="purpose_amount_' + purpose_id_1 + '" type="number" step="any" name="' + amount_name_1 + '" value="' + amount_1 + '" onchange=calculateTotal(this);></td><td class="text-center pt-3"><input type="hidden" id="hidden_purpose_amount_' + purpose_id_1 + '" name="' + hidden_amount_name_1 + '" value="' + amount_1 + '"></td>';

                            main_text += text1;
                            let j = i + 1;
                            if (data[j]) {
                                var purpose_name_2 = data[j]["purpose_name"];
                                var purpose_id_2 = data[j]["purpose_id"];
                                var amount_2 = data[j]["amount"];

                                var amount_name_2 = 'purpose_name[' + purpose_id_2 + ']';
                                var hidden_amount_name_2 = 'hidden_purpose_name[' + purpose_id_2 + ']';
                                if (amount_2) {
                                    sum = sum + amount_2;
                                }
                                amount_2 = Number(amount_2);
                                amount_2 = amount_2.toFixed(2);
                                var text2 = '<td colspan="2">' + purpose_name_2 + '</td><td class="text-center "><input style="color: darkmagenta;font-size: large;font-weight: 600;text-align: right;"id="purpose_amount_' + purpose_id_2 + '" type="number" step="any" name="' + amount_name_2 + '" value="' + amount_2 + '" onchange=calculateTotal(this);></td><td class="text-center pt-3"><input type="hidden" id="hidden_purpose_amount_' + purpose_id_2 + '" name="' + hidden_amount_name_2 + '" value="' + amount_2 + '"></td></tr>';
                            } else {
                                var text2 = '</tr>';
                            }
                            main_text += text2;
                            i = i + 2;
                        }
                        sum = sum.toFixed(2);
                        var total = '<tr><td></td><td class="text-center">Total Amount</td><td class="text-center "><input style="color: darkmagenta;font-size: large;font-weight: 600;text-align: right;"id="total" type="number" readonly step="any" name="total" value="' + sum + '"></td><td class=""></td></tr>';
                        main_text += total;
                        var discount = '<tr><td></td> <td class="text-center">Discount Amount</td><td class="text-center "><input style="color: darkmagenta;font-size: large;font-weight: 600;text-align: right;" type="number" step="any" id="discount" name="discount_amount" value="" onchange=calculateTotal();></td></tr>';
                        main_text += discount;
                        main_text += '</tbody> </table></div > ';
                        $("#purpose_block_id").remove();
                        $('.final_submit').prop('disabled', true);
                        $("#purpose_block").append(main_text);
                        submit.classList.remove("hidden");
                        $('.final_submit').prop('disabled', false);
                    }
                });
            }
        }




    }
    // Event handlers for session, level, and fees selection
    $("#sessionSelect").change(function () {
        fetchMonths();
    });
    $("#levelSelect").change(function () {
        fetchMonths();
    });
    $("#sid").change(function () {
        fetchMonths();
    });

</script>
