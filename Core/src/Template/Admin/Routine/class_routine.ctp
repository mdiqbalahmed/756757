<?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
?>
<!doctype html>
<html lang="en">
    <body>
          <?php if(!isset($days)) { ?>
        <div class="container">

            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                    <?= __d('students', 'Search Section') ?>
                </h3>
            </div>
            <?php echo  $this->Form->create('', ['type' => 'file']); ?>
            <div class="form">
                <section class="bg-light mt-1 p-2 m-auto" action="#">
                    <fieldset>
                        <div class=" form_area p-2">
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Session') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="session_id" id="session_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                <?php foreach ($sessions as $session) { ?>
                                                <option value="<?= $session['session_id']; ?>"><?= $session['session_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Shift') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="shift_id" id="shift_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                <?php foreach ($shifts as $shift) { ?>
                                                <option value="<?= $shift['shift_id']; ?>"><?= $shift['shift_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Class') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="level_id" id="level_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                <?php foreach ($levels as $level) { ?>
                                                <option value="<?= $level['level_id']; ?>"><?= $level['level_name']; ?></option>
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
                                            <p class="label-font13"><?= __d('students', 'Section') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="section_id" id="section_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            </select>
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
          <?php } else{ ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" style="text-align: center;">Day</th>
                          <?php foreach ($timesheets as $timesheet) { ?>
                    <th scope="col" style="text-align: center;"><?= $timesheet['name'] ?> <br> <?= $timesheet['in_time'] ?> - <?= $timesheet['out_time'] ?> </th>
                          <?php } ?>
                </tr>
            </thead>
            <tbody>
                          <?php foreach ($days as $day) { ?>
                <?php if($day['count']) {?>
                <tr>
                    <td style="text-align: center;" > <?= $day['name'] ?></td>
                        <?php foreach ($day['timesheets'] as $timesheet) { ?>
                          <?php if(isset($timesheet['routine'])) { ?>
                    <td>
                             <?php foreach ($timesheet['routine'] as $key => $name) { ?>
                        <div style="text-align: center;"> <?= $name ?></div> 
                             <?php } ?>
                    </td>
                        <?php }else{ ?>
                    <td></td>
                     <?php } ?>
                     <?php } ?>
                 </tr>
                  <?php } ?>
                 <?php } ?>


            </tbody>

        </table>
         <?php }  ?>
    </body>
</html>
<script>
    $("#level_id").change(function () {
        getSectionAjax();
    });
    $("#shift_id").change(function () {
        getSectionAjax();
    });

    function getSectionAjax() {
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();
        $.ajax({
            url: 'getSectionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id,
                "shift_id": shift_id
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["section_name"];
                    var id = data[i]["section_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#section_id').html(text1);

            }
        });
    }
</script>
