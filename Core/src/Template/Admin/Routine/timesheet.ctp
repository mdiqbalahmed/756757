<?php

$this->Form->unlockField('name');
$this->Form->unlockField('in');
$this->Form->unlockField('out');
$this->Form->unlockField('holiday');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('set_id');
$this->Form->unlockField('set_name');
$this->Form->unlockField('set_in');
$this->Form->unlockField('set_out');
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<head>
    <style>
        /* In styles.css */
        .timepicker {
            font-size: 12px;
        }
        .ui-timepicker-list li {
            font-size: 8px;
        }
    </style>
</hesd>
<div>
    <?php echo $this->Form->create(); ?>
    <section class="std_info">
        <h3 class="text-center"><?= __d('hrs', 'Timeshift of Shift ') ?><?= $shifts[0]['shift_name'] ?></h3>
        <div class="row mx-3 mt-2 p-3">
            <div class="col-md-12">
                <div  style="font-size: 18px; font-weight: 600;"> <input type="button" class="add_more" value="Add More"></div>
                <div class="col-md-12">
                    <div class="row mt-1" id="monday">
                        <?php if(isset($timesheets)) { ?>
                        <?php foreach($timesheets as $day) { ?>
                        <div class="col-md-3 single"  style="border: solid 3px black;">
                            <input name="set_id[]" type="hidden" value="<?php echo $day['scms_timesheet_id'] ?>">
                            <div class="text-center"><?= __d('hrs', 'Period') ?><span> <button  id="<?php echo $day['scms_timesheet_id'] ?>" onclick="delete_old_single(this)" class="btn-danger btn-sm" type="button" style="margin:3px; margin-left: 25px;"><i class="fa fa-minus"></i></button></span></div>                         
                            <div class="row">
                                <div class="col-md-3 text-sm-left" style='font-size: 14px;'>Name:</div>
                                <div class="col-md-8"> <input name="set_name[]" type="text" style='height: 22px;' class="form-control mb-2" id="inputSId" value="<?php echo $day['name'] ?>" required></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-left" style='font-size: 14px;'>Start:</div>
                                <div class="col-md-8"> <input name="set_in[]" type="text" style='height: 22px;' class="form-control timepicker mb-2" id="inputSId" value="<?php echo $day['in_time'] ?>" required></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-left" style='font-size: 14px;'>End:</div>
                                <div class="col-md-8"> <input name="set_out[]" type="text" style='height: 22px;' class="form-control timepicker mb-2" id="inputSId" value="<?php echo $day['out_time'] ?>" required></div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php } ?>

                    </div>
                </div>

                <div class="row mb-3 mt-5">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-3">
                                <h4 class="label-font13"><?= __d('students', 'Holiday') ?></h4>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select class="form-control" name="holiday[]" id="holiday" multiple>
                                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($days as $key => $day) { ?>
                                    <option value="<?= $key; ?>"  <?php if (in_array($key, $holiday)){echo "selected";} ?>><?= $day; ?></option>
                                            <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">

                    </div>

                </div>


                <input name="shift_id" type="hidden" class="form-control"  value="<?php echo $shifts[0]['shift_id'];?>">
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-info"><?= __d('hrs', 'Update') ?></button>
            <?php echo $this->Form->end(); ?>
                </div>
                </section>
                <div class="hidden" id="day">
                    <div class="col-md-3 single"  style="border: solid 3px black;">
                        <div class="text-center"><?= __d('hrs', 'Period') ?><span> <button id="delete" onclick="delete_single(this)" class="btn-danger btn-sm" type="button" style="margin:3px; margin-left: 25px;"><i class="fa fa-minus"></i></button></span></div>                         
                        <div class="row">
                            <div class="col-md-3 text-sm-left" style='font-size: 14px;'>Name:</div>
                            <div class="col-md-8"> <input name="name[]" type="text" style='height: 22px;' class="form-control mb-2" id="inputSId" value="" required></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-left" style='font-size: 14px;'>Start:</div>
                            <div class="col-md-8"> <input name="in[]" type="text" style='height: 22px;' class="form-control timepicker mb-2" id="inputSId" value="" required></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-left" style='font-size: 14px;'>End:</div>
                            <div class="col-md-8"> <input name="out[]" type="text" style='height: 22px;' class="form-control timepicker mb-2" id="inputSId" value=""  required></div>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function () {
                    $('#timepicker').timepicker({});
                });

                $('.timepicker').timepicker({
                    timeFormat: 'H:mm',
                    startTime: '10:00',
                    dynamic: true,
                    dropdown: true,
                    scrollbar: true
                });
                function delete_single(value) {
                    if (confirm('Are you sure you want to delete this?')) {
                        $(value).closest('.single').remove();
                    }
                }
                function delete_old_single(value) {
                    if (confirm('Are you sure you want to delete this?')) {
                        $(value).closest('.single').remove();
                    }
                }
                var day = $("#day").html();
                $('.add_more').click(function () {
                    $('#monday').append(day);
                });
            </script>