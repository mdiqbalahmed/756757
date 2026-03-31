<?php

use Cake\Core\Configure;

$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('roll');

$session_id = isset($session_id) ? $session_id : '';
$shift_id = isset($shift_id) ? $shift_id : '';
$level_id = isset($level_id) ? $level_id : '';
$section_id = isset($section_id) ? $section_id : '';
$roll = isset($roll) ? $roll : '';

$siteTemplate = Configure::read('Site.template');

?>

<style>
    .sidSearch {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<?= $this->Form->create('', ['type' => 'file']); ?>
<?php if($siteTemplate== 2){ ?>
<div class="container form my-3">
<?php } else { ?>
<div class="form">
<?php } ?>
    <section class="bg-light mt-1 p-2 m-auto">
        <fieldset>
            <div class="p-3">
                <div class="row mb-3">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-3">
                                <p class="label-font13"><?= __d('contacts', 'Session') ?></p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select class="form-control" name="session_id" id="session_id" required>
                                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                    <?php foreach ($sessions as $session) { ?>
                                        <option value="<?= $session['session_id']; ?>" <?php if ($session_id == $session['session_id']) echo 'selected'; ?>><?= $session['session_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>


                            <div class="col-lg-3">
                                <p class="label-font13"><?= __d('contacts', 'Shift') ?></p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select class="form-control" name="shift_id" id="shift_id" required>
                                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                    <?php foreach ($shifts as $shift) { ?>
                                        <option value="<?= $shift['shift_id']; ?>" <?php if ($shift_id == $shift['shift_id']) echo 'selected'; ?>><?= $shift['shift_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>


                            <div class="col-lg-3">
                                <p class="label-font13"><?= __d('contacts', 'Class') ?></p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select class="form-control" name="level_id" id="level_id" required>
                                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                    <?php foreach ($levels as $level) { ?>
                                        <option value="<?= $level['level_id']; ?>" <?php if ($level_id == $level['level_id']) echo 'selected'; ?>><?= $level['level_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>


                            <div class="col-lg-3">
                                <p class="label-font13"><?= __d('contacts', 'Section') ?></p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select class="form-control" name="section_id" id="section_id">
                                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                </select>
                            </div>


                            <div class="col-lg-3">
                                <p class="label-font13"><?= __d('contacts', 'Roll No') ?></p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <input name="roll" type="text" class="form-control" value="<?= $roll ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 text-center sidSearch">
                        <button type="submit" class="btn btn-lg btn-info"><?= __d('contacts', 'Search') ?></button>
                    </div>
                </div>
            </div>
        </fieldset>
    </section>
</div>
<?= $this->Form->end(); ?>

<style>
    @media screen and (min-width: 767px) {
        .sid_search_table th {
            max-width: 3em;
        }
    }
</style>


<?php if (isset($students)) { ?>
<?php if($siteTemplate== 2){ ?>
<div class="container my-3">
<?php } else { ?>
<div >
<?php } ?>
        <table class="bg-warning table mt-5 sid_search_table">
            <tbody>
                <tr>
                    <th>Student's Name:</th>
                    <td><?= $students['name'] ?></td>
                </tr>
                <tr>
                    <th>SID:</th>
                    <td><?= $students['sid'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
<?php } else if (isset($_POST['session_id']) && isset($_POST['shift_id']) && isset($_POST['level_id'])) { ?>
    <div id="search-error" class="text-center text-light bg-danger p-4 mt-5">No Student Found! Please Check your Submitted Information.</div>
<?php } ?>


<script>
    $("#level_id").change(function() {
        getLevelSectionAjax();
    });
    $("#shift_id").change(function() {
        getLevelSectionAjax();
    });

    function getLevelSectionAjax() {
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();

        $.ajax({
            url: 'Ajax/getLevelSectionAjax',
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
                    var isSelected = (id == '<?= $section_id ?>') ? 'selected' : '';
                    text1 += '<option value="' + id + '" ' + isSelected + '>' + name + '</option>';
                }
                $('#section_id').html(text1);
            },
        });
    }

    // Trigger the function on page load to handle pre-selection after searching
    $(document).ready(function() {
        getLevelSectionAjax();
    });

    // Bind the function to the change event of level_id and shift_id
    $("#level_id, #shift_id").change(function() {
        getLevelSectionAjax();
    });
</script>
