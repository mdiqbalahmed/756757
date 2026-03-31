<?php

$this->Form->unlockField('required');
$this->Form->unlockField('exist');


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


    <div class="header">
        <h1 class="h1 text-center mb-5" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
            <?= __d('students', 'Student Registration Form') ?>
        </h1>
    </div>

        <?php
                foreach ($data_counts as $value) {
                ?>

    <div class="container  mt-5 mb-5">
        <div class="form-border">
            <section class="bg-light  p-4 m-auto" action="#">
                <div class="form_area p-3">
                    <div class="header">
                        <h1 class="h1 text-center mb-5" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                            <?= __d('students', $value['heading']) ?>
                        </h1>
                    </div>
                    <?php echo $this->Form->create('', ['type' => 'file']); ?>

                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Show or Not</th>
                                <th>Required</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    if ($value['type_id'] == 4) {
                        foreach ($value['field'] as $val) {
                            $newName = str_replace("_", " ", strtoupper($val['name'])); // Replace underscore with space and convert to uppercase
                            $newName = ucwords(strtolower($newName));
                            ?>
                            <tr style="padding: 10px;">
                                <td><?php echo $newName; ?></td>
                                <td>
                                    <input type="checkbox" class="form-check-input-data-set" readonly="true" checked disabled>
                                    <input name="exist[<?php echo $value['id'] ?>][<?php echo $val['name'] ?>]"
                                           type="hidden" value="1" class="form-check-input-data-set" readonly="true">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input-data-set" readonly="true" checked disabled>
                                    <input name="required[<?php echo $value['id'] ?>][<?php echo $val['name'] ?>]"
                                           type="hidden" value="1" class="form-check-input-data-set" readonly="true">
                                </td>
                            </tr>
                        <?php }
                    }else {
                    foreach ($value['field'] as $val) {
                        $newName = str_replace("_", " ", strtoupper($val['name'])); // Replace underscore with space and convert to uppercase
                        $newName = ucwords(strtolower($newName)); 
                ?>
                            <tr style="padding: 10px;">
                            <tr style="padding: 10px;">
                                <td><?php echo $newName;  ?></td>
                                <td>
                                    <input name="exist[<?php echo $value['id'] ?>][<?php echo $val['name']  ?>]" type="checkbox" value="1" class="form-check-input-data-set" readonly="true">
                                </td>
                                <td>
                                    <input name="required[<?php echo $value['id'] ?>][<?php echo $val['name']  ?>]" type="checkbox" value="1" class="form-check-input-data-set" readonly="true">
                                </td>
                            </tr>


                    <?php } }?>
                        </tbody>
                    </table>

                </div>
            </section>

        </div>
    </div>

<?php
                } 
                ?>
    <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
                                <?php echo $this->Form->end(); ?>

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
                "level_id": level_id, "shift_id": shift_id
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