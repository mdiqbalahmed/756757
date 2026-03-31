<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
$this->Form->unlockField('courses_cycle_id');
?>
<body>

    <div class="row">
        <div class="col-12">
            <h5 class="">
                <?= __d('setup', 'Add New Course For Student: ' . $head['name'] . ', Class: ' . $head['level_name'] . ', Term: ' . $head['session_name'] . ' - ' . $head['term_name']) ?>
            </h5>
        </div>
    </div>
    <?php echo  $this->Form->create('', ['type' => 'file']); ?>
        <div class="form">
            <section class="bg-light mt-4 p-4 m-auto" action="#">
                <fieldset>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <p class="label-font13"><?= __d('students', 'Course') ?></p>
                                    </div>
                                    <div class="col-lg-10 row2Field">
                                        <select class="form-control" name="courses_cycle_id[]" id="courses_cycle_id" multiple required>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                <?php foreach ($term_courses_filter as $term_course) { ?>
                                            <option value="<?= $term_course['courses_cycle_id']; ?>" ><?= $term_course['course_name']; ?></option>
                                                <?php } ?>
                                        </select>
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
</body>

</html>
