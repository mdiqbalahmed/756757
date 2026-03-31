<?php
use Cake\Core\Configure;
$this->Form->unlockField('session_id');
$instituteName = Configure::read('Result.instituteName');
$instituteLogo = Configure::read('Result.instituteLogo');
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



 <?php
 
 $sectionTotals = [];

foreach ($students as $s) {
    $sid = $s['section_id'];
    if (!isset($sectionTotals[$sid])) {
        $sectionTotals[$sid] = 0;
    }
    $sectionTotals[$sid]++;
}



$sl = 1;
$prevSection = null;

foreach ($students as $student) {
    

    if ($prevSection !== $student['section_id']) {

        // reset SL for new section
        $sl = 1;

        if ($prevSection !== null) {
            echo '</tbody></table>';
            echo '<div class="page-break"></div>';
        }
        ?>
            <a href="javascript:window.print();"
                        class="btn btn-primary position-fixed d-print-none"
                        style="top: 120px; right: 20px; z-index: 1000;">
                        প্রিন্ট করুন
                    </a>

        <div class="print-header d-none d-print-block">
            <div class="d-flex justify-content-center align-items-center gap-2 w-100">
                <img src="<?= $this->Url->image($instituteLogo) ?>" style="height:60px;">
                <h2 style="margin:0;font-weight:900;font-size:40px;">
                    <?= h($instituteName) ?>
                </h2>
            </div>

            <p class="fs-4 fw-bold my-1">
                Promotion List Of <?= h($session) ?>
            </p>

            <p class="fw-bold">
                Class: <?= h($student['level_name']) ?> |
                Section: <?= h($student['section_name']) ?>
            </p>

            <p style="font-size:14px;">
                <b>Total Students: <?= $sectionTotals[$student['section_id']] ?></b>
            </p>
        </div>

        <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SL</th>
                <th>SID</th>
                <th>Name</th>
                <th>Class</th>
                <th>Section</th>
                <th>Roll</th>
            </tr>
        </thead>
        <tbody>

    <?php } ?>
    


    <tr>
        <td><?= $sl++; ?></td>
        <td><?= h($student['sid']) ?></td>
        <td><?= h($student['name']) ?></td>
        <td><?= h($student['level_name']) ?></td>
        <td><?= h($student['section_name']) ?></td>
        <td><?= h($student['roll']) ?></td>
    </tr>

<?php
    $prevSection = $student['section_id'];
}
?>
</tbody>
</table>
<style>
@media print {
    .page-break {
        display: block;
        page-break-before: always; /* for older browsers */
        break-before: page; /* modern CSS */
    }
    .d-print-none {
        display: none !important;
    }
    .d-print-block {
        display: block !important;
    }
}
</style>









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
</script>