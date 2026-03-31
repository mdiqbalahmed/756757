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
            <h3 class="text-center"><?= __d('accounts', 'Edit Unpaid School Fees Credits') ?></h3>
        </div>
<?php $this->Form->unlockField('date'); ?>
<?php $this->Form->unlockField('session_id'); ?>
<?php $this->Form->unlockField('purpose_id'); ?>
<?php $this->Form->unlockField('bank_id'); ?>
<?php $this->Form->unlockField('sid'); ?>
<?php $this->Form->unlockField('purpose_name'); ?>
<?php $this->Form->unlockField('hidden_purpose_name'); ?>
<?php $this->Form->unlockField('month'); ?>
<?php $this->Form->unlockField('total'); ?>
<?php $this->Form->unlockField('discount_amount'); ?>
<?php $this->Form->unlockField('id'); ?>
<?php $this->Form->unlockField('create_date'); ?>


        <?php  echo  $this->Form->create('', ['type' => 'file']); ?>
        <div class="form">
            <input type="hidden" name="id"  value="<?= $vouchers['id']; ?>">
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
                                        <input type="datetime-local" name="create_date" class="form-control" value="<?= date("Y-m-d H:i:s", strtotime($vouchers['create_date']) + 6 * 3600); ?>" required>

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
                                            <option value="<?= $session['session_id']; ?>" <?php if( $session['session_id']==$vouchers['session_id']){echo 'selected';} ?>><?= $session['session_name']; ?></option>
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
                                        <input type="text" id="sid" value="<?= $vouchers['sid'] ?>" name="sid" class=""  readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div style="height: 110px; width: 250px; background-color: #dbd7d7; padding: 5px;" class='student_info'>
                                    <div style="height:65px; width: 65px; margin-left: 90px; "><?php echo $this->Html->image('/webroot/uploads/students/thumbnail/' . $student_cycle['thumbnail']); ?></div>
                                    <p style="text-align:center; font-size: 16px; font-weight: 600"><?php echo $student_cycle['name']; ?></p>
                                    <p style="text-align:center; margin-top: -20px;"><?php echo $student_cycle['level_name'].'('.$student_cycle['section_name'].')'; if($student_cycle['group_name']){ echo '-'.$student_cycle['group_name'];} ?>  </p>
                                </div>
                            </div>
                        </div>



                        <div class="month_form"  id="month_form" style="margin:10px;">
                            <div id="add_block">

											<?php foreach ($months as $month) { ?>
                                <div class="checkbox" id="January">
                                    <label for="month1" class="<?php if(isset($month['select'])){echo 'checked';}?>"><?= $month['name'] ?></label>
                                    <input type="checkbox" id="month_January" name="month[]" value="1" disabled="" <?php if(isset($month['select'])){echo 'checked';}?>>
                                </div>
											<?php } ?>

                            </div>
                        </div>

                        </section>
                        <div  class="purpose_block mt-5" id="purpose_block">
                            <div class="table-responsive-sm" id="purpose_block_id">
                                <table class="table table-borderless table-striped table-dark">
                                    <tbody>
                                    <?php for($i=0;$i<count($purposes);$i++) { ?>
                                        <tr>
                                            <td colspan="2"><?= $purposes[$i]['purpose_name'] ?></td>
                                            <td class="text-center ">
                                                <input style="color: darkmagenta;font-size: large;font-weight: 600;text-align: right;" id="purpose_amount_<?= $purposes[$i]['purpose_id'] ?>" type="number" step="any" name="purpose_name[<?= $purposes[$i]['purpose_id'] ?>]" value="<?=  number_format((float)$purposes[$i]['amount'], 2, '.', ''); ?>" onchange="calculateTotal(this);">
                                            </td>
                                            <td class="text-center pt-3">
                                                <input type="hidden" id="hidden_purpose_amount_<?= $purposes[$i]['purpose_id'] ?>" name="hidden_purpose_name[<?= $purposes[$i]['purpose_id'] ?>]" value="<?=  number_format((float)$purposes[$i]['amount'], 2, '.', ''); ?>"></td>
                                       <?php if(isset($purposes[$i+1])) { ?>
                                            <td colspan="2"><?= $purposes[$i+1]['purpose_name'] ?></td>
                                            <td class="text-center ">
                                                <input style="color: darkmagenta;font-size: large;font-weight: 600;text-align: right;" id="purpose_amount_<?= $purposes[$i+1]['purpose_id'] ?>" type="number" step="any" name="purpose_name[<?= $purposes[$i+1]['purpose_id'] ?>]" value="<?=  number_format((float)$purposes[$i+1]['amount'], 2, '.', ''); ?>" onchange="calculateTotal(this);">
                                            </td>
                                            <td class="text-center pt-3"><input type="hidden" id="hidden_purpose_amount_<?= $purposes[$i+1]['purpose_id'] ?>" name="hidden_purpose_name[<?= $purposes[$i+1]['purpose_id'] ?>]" value="<?=  number_format((float)$purposes[$i+1]['amount'], 2, '.', ''); ?>"></td>
                                       <?php $i++; } ?>
                                        </tr>
                                    <?php } ?>

                                    </tbody> 
                                    <tr>
                                        <td>
                                        </td>
                                        <td class="text-center">Total Amount</td>
                                        <td class="text-center ">
                                            <input style="color: darkmagenta;font-size: large;font-weight: 600;text-align: right;" id="total" type="number" readonly="" step="any" name="total" value="<?=  number_format((float)$total, 2, '.', ''); ?>">
                                        </td>
                                        <td class="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td> 
                                        <td class="text-center">Discount Amount</td>
                                        <td class="text-center ">
                                            <input style="color: darkmagenta;font-size: large;font-weight: 600;text-align: right;" type="number" step="any" id="discount" name="discount_amount" value="<?=  number_format((float)0, 2, '.', ''); ?>" onchange="calculateTotal();">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                </fieldset>               
                <div class="text-right mt-2" id="submit" style="margin-right: 30px;">
                    <button type="submit" class="btn btn-info"><?= __d('accounts', 'Save') ?></button>
                </div>
        </div>
          <?php  echo $this->Form->end(); ?>
    </body>

</html>


<script type="text/javascript">
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
</script>

<script type="text/ja    vascript">
    config = {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    today
    };
    flatpickr("input[type=datetime-local]", config);
</script>