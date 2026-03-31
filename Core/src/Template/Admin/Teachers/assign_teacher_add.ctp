<?php

$this->Form->unlockField('course_ids');
$this->Form->unlockField('teachers_user_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
?>


<div>
    <?php echo $this->Form->create();

    ?>
    <section>
        <h4><?= __d('setup', 'Assign Courses') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box"  >
            <div class="col-md-6  mt-2">
                <label for="inputState" class="form-label"><?= __d('setup', 'Teacher') ?></label>
                <select id="inputState" class="form-select dropdown260" name="teachers_user_id" required>
                    <option value=""><?= __d('setup', '-- Choose --') ?></option>
                    <?php foreach ($teachers as $teacher) { ?>
                    <option value="<?php echo $teacher['user_id']; ?>"><?php echo $teacher['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6  mt-2">
                <label for="inputState" class="form-label"><?= __d('setup', 'Class') ?></label>
                <select class="form-control" name="level_id" id="level_id" required>
                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($levels as $level) { ?>
                    <option value="<?php echo $level->level_id; ?>"><?php echo $level->level_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6  mt-2">
                <label for="inputState" class="form-label"><?= __d('setup', 'Section') ?></label>
                <select class="form-control" name="section_id" id="section_id" required>
                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                </select>
            </div>
            <div class="col-md-6  mt-2">
                <label for="inputState" class="form-label"><?= __d('setup', 'Course') ?></label>
                <select class="form-control" name="course_ids" id="course_id" required>
                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                </select>
            </div>

        </div>
    </section>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
        <?php echo $this->Form->end(); ?>
    </div>

</div>
<script>
    $("#level_id").change(function () {
        getSectionAjaxbylevel();
        getSubjectAjaxbylevel();
    });

    function getSubjectAjaxbylevel() {
        var level_id = $("#level_id").val();
        $.ajax({
            url: 'getSubjectAjaxbylevel',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["course_name"];
                    var id = data[i]["course_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#course_id').html(text1);
            }
        });
    }
    function getSectionAjaxbylevel() {
        var level_id = $("#level_id").val();
        $.ajax({
            url: 'getSectionAjaxbylevel',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id
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