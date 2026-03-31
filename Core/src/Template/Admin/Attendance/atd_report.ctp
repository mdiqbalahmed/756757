<?php

$this->Form->unlockField('date');
$date = isset($date) ? $date : '';
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
    <div class="container">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Attendance Search') ?>
            </h3>
        </div>
        <?php echo  $this->Form->create(); ?>
        <div class="form">
            <section class="bg-light mt-1 p-2 m-auto" action="#">
                <fieldset>
                    <div class=" form_area p-2">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Date') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="date" type="date" class="form-control" value="<?php if (isset($data['date'])) {
                                                                                                        echo $data['date'];
                                                                                                    } ?>">
                                    </div>
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

    <?php if (isset($students)) { ?>
        <h5 class="report_title">Class-Wise Attendance Report of <?php echo $data['date']; ?> </h5>
        <table id="statistics-table" class="table table-bordered" border="1" style="font-size: 16px;">
            <thead class="stat-head">
                <tr>

                    <th rowspan="2">Class</th>
                    <th rowspan="2">Shift</th>
                    <th rowspan="2">Section</th>
                    <th>Present</th>
                    <th>Absent</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPresent = 0;
                $totalAbsent = 0;
                foreach ($students as $shift => $levels) {
                    foreach ($levels as $level => $sections) {
                        foreach ($sections as $section => $counts) {
                            echo '<tr>';

                            echo '<td>' . $level . '</td>';
                            echo '<td>' . $shift . '</td>';
                            echo '<td>' . $section . '</td>';
                            echo '<td>' . $counts['present'] . '</td>';
                            echo '<td>' . $counts['absent'] . '</td>';
                            echo '</tr>';
                            $totalPresent += $counts['present'];
                            $totalAbsent += $counts['absent'];
                        }
                    }
                } ?>
                <tr>
                    <td colspan="3">Total:</td>
                    <td><?php echo $totalPresent; ?></td>
                    <td><?php echo $totalAbsent; ?></td>
                </tr>
            </tbody>
        </table>




</body>

</html>
<?php } ?>


</body>

</html>

<style>
    .report_title {
        font-size: 19px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        width: 45%;
        margin: 14px auto;
        border: 1px dashed #727070;
        padding: 5px;
        height: 37px;
    }
</style>

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