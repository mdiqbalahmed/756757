<?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('sid');
$this->Form->unlockField('status');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Student</title>
</head>

<body>
    <?php if (!isset($students)) { ?>
        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                    <?= __d('students', 'Search Students') ?>
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
                                            <select class="form-control" name="shift_id" id="shift_id">
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
                                            <select class="form-control" name="level_id" id="level_id">
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
                                            <select class="form-control" name="section_id" id="section_id">
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Status') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="status" id="status">
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                <option value="1"><?= __d('students', 'Active') ?></option>
                                                <option value="-1"><?= __d('students', 'In-Active') ?></option>
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
    <?php   } ?>


    <?php if (isset($students)) { ?>
        <div class="table table-bordered table-striped">
            <div style="color: #3d7fd1; margin-right: 10px;">Total:<?php echo (count($students)); ?></div>
            <div class="left_wrapper">
                

                <?php //pr($students); //echo $this->Form->create('Student', array('type' => 'file', 'class'=>'mainform'));  
                ?>
                <div class="blockWrapper">
                    <div class="leftblock" style="width:100%">
                        <?php $class = $students[0]['level_name'];
                        $sec = $students[0]['section_name'];
                        $session = $students[0]['session_name'];
                        ?>
                        <div class="header">
                            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                                <?= __d('students', "Student's Image Download") ?>
                            </h3>
                        <h5 class=" text-center">Class:<?php echo $class; ?> ; Section:<?php echo $sec; ?> ; Session:<?php echo $session; ?> </h5>
                        </div>
                        <div class="leftTop">
                    <div class="editwraper">
                        <div style="float:left; margin-top:1px;">
                             <?php
                            if (!empty($downloadLink)) { ?>
                                <span class="text-center"><?php echo $this->Html->link('Image Download', '/' . $downloadLink,  ['class' => 'btn btn-success']) ?></span>
                            <?php     }
                            ?>
                        </div>
                        <div style="float:left; margin-left: 10px; margin-top:1px;">
                             <?php
                            if (!empty($downloadLink)) { ?>
                                <span class="text-center"><?php echo $this->Html->link('Delete Zip File', ['action' => 'deleteDownload', $downloadLink], ['class' => 'btn btn-danger']) ?></span>
                            <?php     }
                            ?>
                        </div>
                        <div class="clear_both">&nbsp;</div>
                    </div><!-- end of leftTop-->
                </div><!-- end of leftTop-->
                        <table class=" display_table table table-hover mt-5">
                            <tbody>
                                <tr>
                                    <th>Photo</th>
                                    <th>Roll</th>
                                </tr>
                            </tbody>
                            <?php
                            $rows = array();
                            foreach ($students as $student) {

                                // Works whether data is nested (Cake) or flat
                                $gender = $student['Student']['gender'] ?? ($student['gender'] ?? '');
                                $imageName = trim($student['Student']['regular_size'] ?? ($student['regular_size'] ?? ''));
                            
                                // Default (make sure these files exist in app/webroot/img/)
                                $defaultPath = '/img/default-' . ((empty($gender) || $gender === 'Female') ? 'girl' : 'boy') . '.jpg';
                            
                                // Your upload folder inside app/webroot/uploads/students/regularSize/
                                $relative = 'uploads' . DS . 'students' . DS . 'regularSize' . DS . $imageName;
                                $absolute = WWW_ROOT . $relative;
                            
                                if ($imageName !== '' && file_exists($absolute)) {
                                    // Web URL to show in <img>
                                    $thumbPath = '/uploads/students/regularSize/' . $imageName;
                                } else {
                                    $thumbPath = $defaultPath;
                                }
                            
                                $roll = $student['StudentCycle']['roll'] ?? ($student['roll'] ?? '');
                            
                                $rows[] = array(
                                    $this->Html->image($thumbPath, array('alt' => 'Photo', 'style' => 'width:40px')),
                                    $roll,
                                );
                            }

                            echo $this->Html->tableCells($rows);
                            ?>
                        </table>

                    </div><!-- end of leftblock-->

                    <div class="clear_both">&nbsp;</div>
                </div><!-- end of blockWrapper-->
            </div><!-- end of left_wrapper-->


            <div class="clear_both">&nbsp;</div>
        </div><!-- end of btm_wrapper-->


    <?php  } ?>


</body>

</html>
<script>
    $("#level_id").change(function() {
        getSectionAjax();
    });
    $("#shift_id").change(function() {
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
            success: function(data) {
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

    function confirmDelete() {
        return confirm("Are you sure you want to delete this file?");
    }
</script>