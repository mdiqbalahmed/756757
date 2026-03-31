<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>

        <div class="rows">
            <h3 class="text-center"><?= __d('accounts', 'Add School Fees Credits') ?></h3>
        </div>
<?php $this->Form->unlockField('date'); ?>
<?php $this->Form->unlockField('session_id'); ?>
<?php $this->Form->unlockField('purpose_id'); ?>
<?php $this->Form->unlockField('bank_id'); ?>
<?php $this->Form->unlockField('sid'); ?>
<?php $this->Form->unlockField('purpose_name'); ?>
<?php $this->Form->unlockField('voucher'); ?>
<?php $this->Form->unlockField('total'); ?>
<?php $this->Form->unlockField('discount_amount'); ?>

        <?php  echo  $this->Form->create('', ['type' => 'file']); ?>
        <div class="form">
            <section class="bg-light mt-1 p-2 m-auto" action="#">
                <fieldset>
                    <div class=" p-2">
                        <div class="row mb-1">
                            <div class="col-lg-5">
                                <div class="row">
                                    <div class="col-lg-3 mt-3">
                                        <p class="label-font13"><?= __d('accounts', ' Credit Date') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input type="datetime-local" name="date" class="form-control" value="<?= date("Y-m-d H:i:s", time() + 6 * 3600) ?>" required />
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3 mt-3">
                                        <p class="label-font13"><?= __d('accounts', 'Session') ?></p>
                                    </div>

                                    <div class="col-lg-9 row2Field">
                                       	<select class="form-control" name="session_id" id="session_id" required>
					<?php foreach ($sessions as $session) { ?>
                                            <option value="<?= $session['session_id']; ?>" ><?= $session['session_name']; ?></option>
					<?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-1">
                            <div class="col-lg-5">
                                <div class="row">
                                    <div class="col-lg-3 mt-3">
                                        <p class="label-font13"><?= __d('accounts', 'Fees') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="purpose_id" id="purpose_id" required>
					<?php foreach ($purposes as $purpose) { ?>
                                            <option value="<?= $purpose['purpose_id']; ?>"><?= $purpose['purpose_name']; ?></option>
					<?php } ?>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3 mt-3">
                                        <p class="label-font13"><?= __d('accounts', 'Bank') ?></p>
                                    </div>

                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="bank_id" id="bank_id" required>

											<?php foreach ($banks as $bank) { ?>
                                            <option value="<?= $bank['bank_id']; ?>"><?= $bank['bank_name']; ?></option>
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
                                    <p id="inner_details" style="text-align:center; margin-top: -20px;"></p>
                                </div>
                            </div>
                        </div>


                        <p class="error_message_student_fees hidden" style="margin-left: -10px;" id="error_message_student_fees">The student Id is not valid for that selected session! Please try again</p>
                        <p class="no_vn hidden" style="margin-left: -10px;" id="no_vn">This student has no unpaid Voucher.</p>

                        <div class="vn_form" id="vn_form" style="margin:10px;">

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
                    </div>
                    <div class="month_form" id="month_form" style="margin-top: 30px; margin-left: 20px;">

                    </div>
                    <div class="purpose_block" id="purpose_block" style="margin-top: 150px;">

                    </div>
                </fieldset>


            </section>
            <p class="error_message_student_fees hidden" id="no_voucher_error" style=" margin-top: -100px;">No, Voucher is selected! Please select at least one Voucher</p>
            <div class="text-right mt-2 hidden" id="submit" style="margin-right: 30px;">
                <button type="submit" class="btn btn-info"><?= __d('accounts', 'Save') ?></button>
            </div>
        </div>
          <?php  echo $this->Form->end(); ?>
    </body>

</html>


<script type="text/javascript">
    $("#sid").change(function () {
        getVouchersAjax();
    });
    $("#session_id").change(function () {
        getVouchersAjax();
    });
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
    function getVouchersAjax() {
        $("#vn_block").remove();
        $("#month_block").remove();
        $("#purpose_block_id").remove();
        var proceed = document.getElementById("proceed");
        var submit = document.getElementById("submit");
        var student_info = document.getElementById("student_info");
        var no_vn = document.getElementById("no_vn");
        var no_voucher_error = document.getElementById("no_voucher_error");

        no_voucher_error.classList.add("hidden");
        no_vn.classList.add("hidden");
        student_info.classList.add("hidden");
        proceed.classList.add("hidden");
        submit.classList.add("hidden");

        var sid = $("#sid").val();
        var session_id = $("#session_id").val();
        if (sid && session_id) {
            $.ajax({
                url: 'getVouchersAjax',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "sid": sid,
                    "session_id": session_id
                },
                success: function (return_data) {
                    return_data = JSON.parse(return_data);
                    var no_vn = document.getElementById("no_vn");
                    var error = document.getElementById("error_message_student_fees");
                    if (return_data == -1) {
                        error.classList.remove("hidden");
                    } else {
                        error.classList.add("hidden");
                        var student_name = return_data.student.name;
                        if (return_data.student.thumbnail) {
                            var img = "/webroot/uploads/students/thumbnail/" + return_data.student.thumbnail;
                            $("#inner_Image").src = img;
                        } else {
                            $("#inner_Image").remove();
                        }
                        if (return_data.student.group_name) {
                            var student_details = return_data.student.level_name + '(' + return_data.student.section_name + ') -' + return_data.student.group_name;
                        } else {
                            var student_details = return_data.student.level_name + '(' + return_data.student.section_name + ')';
                        }
                        document.getElementById("inner_name").innerHTML = student_name;
                        document.getElementById("inner_details").innerHTML = student_details;
                        student_info.classList.remove("hidden");
                        var vouchers = return_data.vouchers;
                        if (vouchers === -1) {
                            no_vn.classList.remove("hidden");
                        } else {
                            var main_text = '<div id="vn_block">';
                            for (let i = 0; i < vouchers.length; i++) {
                                var voucher_no = vouchers[i]["voucher_no"];
                                var due_amount = Number(vouchers[i]["due_amount"]).toFixed(2);
                                var amount = Number(vouchers[i]["amount"]).toFixed(2);
                                var month_name = vouchers[i]["month_name"];
                                var id = vouchers[i]["id"];

                                var id_name = 'vouchers_' + id;
                                if (due_amount > 0) {
                                    var class_name = 'due';
                                    var text = ' <div class="checkbox"><label for="voucher" class="' + class_name + '">VN: <b>' + voucher_no + '</b><br> Months:' + month_name + '<br>Due Amount: <b>' + due_amount + '</b></label><input type="checkbox" id="' + id_name + '" name="voucher[]" value="' + id + '"></div>';
                                } else {
                                    var class_name = 'unchecked';
                                    var text = ' <div class="checkbox"><label for="voucher" class="' + class_name + '">VN: <b>' + voucher_no + '</b><br> Months:' + month_name + '<br>Amount: <b>' + amount + '</b></label><input type="checkbox" id="' + id_name + '" name="voucher[]" value="' + id + '"></div>';
                                }

                                main_text += text;
                            }
                            main_text += '</div>';
                            $("#vn_form").append(main_text);
                            proceed.classList.remove("hidden");
                        }
                    }

                }});
        }
    }
    function getPurpose() {
        getPurposeAjax();
    }
    function getPurposeAjax() {
        $("#month_block").remove();
        var error = document.getElementById("no_voucher_error");
        error.classList.add("hidden");
        $("#purpose_block_id").remove();

        var submit = document.getElementById("submit");
        submit.classList.add("hidden");
        let voucher_ids = [];
        $("input[id^='vouchers']").each(function (i, el) {
            if (this.checked) {
                voucher_ids.push(this.value);
            }
        });

        if (voucher_ids.length == 0) {
            error.classList.remove("hidden");
        } else {
            var sid = $("#sid").val();
            var session_id = $("#session_id").val();
            if (sid && session_id) {
                $.ajax({
                    url: 'getPurposeMonthAjax',
                    cache: false,
                    type: 'GET',
                    dataType: 'HTML',
                    data: {
                        "sid": sid,
                        "session_id": session_id,
                        "voucher_ids": voucher_ids
                    },
                    success: function (return_data) {
                        return_data = JSON.parse(return_data);
                        var months = return_data.months;
                        $("#month_block").remove();

                        var month_text = '<div id="month_block">';
                        for (let i = 0; i < months.length; i++) {
                            var name = months[i]["name"];
                            var exist = months[i]["exist"];
                            var due = months[i]["due"];
                            var disabled = 'disabled';
                            if (due) {
                                var class_name = 'due';
                            } else if (exist) {
                                var class_name = 'checked';
                            } else {
                                var class_name = 'not_set';
                            }
                            var id_name = 'month_' + name;
                            var text = '<div class="checkbox" id="' + name + '"><label for="month1" class="' + class_name + '">' + name + '</label><input type="checkbox" id="' + id_name + '"  value="' + 1 + '"' + disabled + '></div>';
                            month_text += text;
                        }
                        month_text += '</div>';
                        $("#month_form").append(month_text);

                        $("#purpose_block_id").remove();
                        var data = return_data.filter_purposes;
                        var main_text = '<div class="table-responsive-sm" id="purpose_block_id"><table class="table table-borderless table-striped table-dark  mt-5"><tbody>';
                        let i = 0;
                        let sum = 0;
                        while (i < data.length) {

                            var purpose_name_1 = data[i]["purpose_name"];
                            var purpose_id_1 = data[i]["purpose_id"];
                            let amount_1 = data[i]["amount"];

                            var amount_name_1 = 'purpose_name[' + purpose_id_1 + ']';
                            if (amount_1) {
                                sum = sum + amount_1;
                            }

                            amount_1 = Number(amount_1);
                            amount_1 = amount_1.toFixed(2);
                            var text1 = ' <tr><td colspan="2">' + purpose_name_1 + '</td><td class="text-center "><input style="color: darkmagenta;font-size: large;font-weight: 600;text-align: right;"id="purpose_amount_' + purpose_id_1 + '" type="number" step="any" name="' + amount_name_1 + '" value="' + amount_1 + '" onchange=calculateTotal(this);></td><td class="text-center pt-3"></td>';

                            main_text += text1;
                            let j = i + 1;
                            if (data[j]) {
                                var purpose_name_2 = data[j]["purpose_name"];
                                var purpose_id_2 = data[j]["purpose_id"];
                                var amount_2 = data[j]["amount"];

                                var amount_name_2 = 'purpose_name[' + purpose_id_2 + ']';
                                if (amount_2) {
                                    sum = sum + amount_2;
                                }
                                amount_2 = Number(amount_2);
                                amount_2 = amount_2.toFixed(2);
                                var text2 = '<td colspan="2">' + purpose_name_2 + '</td><td class="text-center "><input style="color: darkmagenta;font-size: large;font-weight: 600;text-align: right;"id="purpose_amount_' + purpose_id_2 + '" type="number" step="any" name="' + amount_name_2 + '" value="' + amount_2 + '" onchange=calculateTotal(this);></td><td class="text-center pt-3"></td></tr>';
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
                        $("#purpose_block").append(main_text);
                        submit.classList.remove("hidden");
                    }
                });
            }

        }

    }

</script>

<script type="text/javascript">
    config = {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        today
    };
    flatpickr("input[type=datetime-local]", config);
</script>