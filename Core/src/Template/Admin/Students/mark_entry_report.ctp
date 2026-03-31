<?php

use Cake\Core\Configure;


$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
// $this->Form->unlockField('level_id');
// $this->Form->unlockField('section_id');
// $this->Form->unlockField('courses_cycle_id');
$this->Form->unlockField('term_id');


$session_id = isset($session_id) ? $session_id : '';
$shift_id = isset($shift_id) ? $shift_id : '';
// $level_id = isset($level_id) ? $level_id : '';
// $section_id = isset($section_id) ? $section_id : '';
// $courses_cycle_id = isset($courses_cycle_id) ? $courses_cycle_id : '';
$term_id = isset($term_id) ? $term_id : '';


function percentageMeta($p)
{
    if ($p == 100) {
        return ['color' => 'success', 'bar' => '#198754'];
    } elseif ($p >= 75) {
        return ['color' => 'primary', 'bar' => '#0d6efd'];
    } elseif ($p >= 50) {
        return ['color' => 'warning', 'bar' => '#ffc107'];
    }
    return ['color' => 'danger', 'bar' => '#dc3545'];
}

?>
<style>
.progress-sm {
    height: 4px;
    border-radius: 3px;
}

.progress-sm .progress-bar {
    border-radius: 3px;
}
</style>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Student Attendance Form</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('attendance', 'Term Exam Mark Entry Report') ?>
            </h3>
        </div>
        <?php echo $this->Form->create('', ['type' => 'file']); ?>
        <div class="form">
            <section class="bg-light mt-1 p-2 m-auto" action="#">
                <fieldset>
                    <div class=" p-3">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Session') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="session_id" id="session_id" required>
                                            <?php foreach ($sessions as $session) { ?>
                                                <option value="<?php echo $session['session_id']; ?>" <?php if ($data['session_id'] == $session['session_id']) {
                                                                                                            echo 'Selected';
                                                                                                        } ?>><?php echo $session['session_name']; ?> </option>
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
                                            <?php foreach ($shifts as $shift) { ?>
                                                <option value="<?php echo $shift['shift_id']; ?>" <?php if ($data['shift_id'] == $shift['shift_id']) {
                                                                                                        echo 'Selected';
                                                                                                    } ?>><?php echo $shift['shift_name']; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Term') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field position-relative">
                                        <div class="loader" style="display: none; position: absolute; left: -15px; top: 5px;">
                                            <?= $this->Html->image('/webroot/uploads/indicator.gif', ['style' => 'width: 20px; height: 20px;']) ?>
                                        </div>
                                        <select class="form-control" name="term_id" id="term_id" required>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($terms as $term) { ?>
                                                <option value="<?= $term['term_id'] ?>" <?php if ($data['term_id'] == $term['term_id']) {
                                                                                                    echo 'Selected';
                                                                                                } ?>><?= $term['term_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        

                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-3">
                                </div>
                                <div class="col-lg-9 row2Field mt-5">
                                    <button type="submit" class="btn btn-info"><?= __d('setup', 'Search Student') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        </fieldset>
        </section>
    </div>
    <?php echo $this->Form->end(); ?>
    </div>

    <?php if (!empty($groupedDatas)) { ?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h5 class="mb-0">
        Term Exam Mark Entry Status
        <small class="text-muted">(<?= h($termh['term']) ?>)</small>
    </h5>

    <div class="small">
        <span class="badge bg-success">100%</span>
        <span class="badge bg-primary">75–99%</span>
        <span class="badge bg-warning text-dark">50–74%</span>
        <span class="badge bg-danger">Below 50%</span>
    </div>
</div>

<?php foreach ($groupedDatas as $level): ?>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-success text-white fw-semibold">
        Class: <?= h($level['level_name']) ?>
    </div>

    <div class="card-body">

        <!-- ✅ SECTIONS ROW -->
        <div class="row">

        <?php foreach ($level['sections'] as $section): ?>

            <!-- ✅ ONE SECTION COLUMN -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">

                <div class="border rounded p-2 h-100">

                    <div class="fw-semibold text-secondary mb-2">
                        Section: <?= h($section['section_name']) ?>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Subject</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Entered</th>
                                    <th class="text-center">%</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($section['subjects'] as $subject): 
                                $percentage = (int)$subject['percentage'];
                                $meta = percentageMeta($percentage);
                            ?>
                                <tr>
                                    <td><?= h($subject['course_name']) ?></td>
                                    <td class="text-center"><?= $subject['total_students'] ?></td>
                                    <td class="text-center"><?= $subject['marked_students'] ?></td>
                                    <td class="text-center fw-bold text-<?= $meta['color'] ?>">
                                        <?= $percentage ?>%
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>

        </div> <!-- row -->

    </div>
</div>

<?php endforeach; ?>

<?php } else { ?>

<div class="alert alert-warning text-center mt-4">
    <?= __('No data found.') ?>
</div>

<?php } ?>



</html>
<script>
    function showLoader(id) {
        $("#" + id).show();
    }

    function hideLoader(id) {
        $("#" + id).hide();
    }
    $(document).ready(function() {
        $("#check_all").click(function() {
            var checkBoxes = $(".checkbox_attend");
            checkBoxes.prop("checked", !checkBoxes.prop("checked"));
        });
    })
    $("#level_id").change(function() {
        getSectionAjax();
        getTermAjax();
        getallSubjectAjax();
    });
    $("#shift_id").change(function() {
        getSectionAjax();
    });
    $("#session_id").change(function() {
        getTermAjax();
        getallSubjectAjax();
    });
    $("#term_cycle_id").change(function() {
        getallSubjectAjax();
    });



    function getSectionAjax() {
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();

        if (level_id && shift_id) {
            showLoader('loader-section');

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
                        text1 += '<option value="' + data[i]["section_id"] + '">' + data[i]["section_name"] + '</option>';
                    }
                    $('#section_id').html(text1);
                },
                complete: function() {
                    hideLoader('loader-section');
                }
            });
        }
    }

    function getallSubjectAjax() {
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        var term_cycle_id = $("#term_cycle_id").val();
        $.ajax({
            url: 'getallSubjectAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "session_id": session_id,
                "level_id": level_id,
                "term_cycle_id": term_cycle_id
            },
            success: function(data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["course_name"];
                    var id = data[i]["courses_cycle_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#courses_cycle_id').html(text1);

            }
        });
    }


    function getTermAjax() {
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();

        if (session_id && level_id) {
            showLoader('loader-term');

            $.ajax({
                url: 'getTermAjax',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "level_id": level_id,
                    "session_id": session_id
                },
                success: function(data) {
                    data = JSON.parse(data);
                    var text1 = '<option value="">-- Choose --</option>';
                    for (let i = 0; i < data.length; i++) {
                        text1 += '<option value="' + data[i]["term_cycle_id"] + '">' + data[i]["term_name"] + '</option>';
                    }
                    $('#term_cycle_id').html(text1);
                },
                complete: function() {
                    hideLoader('loader-term');
                }
            });
        }
    }
</script>