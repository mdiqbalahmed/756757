<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
<?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('term_cycle_id');

?>

        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Search Result') ?>
                </h3>
            </div>
        <?php  echo  $this->Form->create('', ['type' => 'file']); ?>
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
                                            <select class="form-control" name="session_id" id="session_id">
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
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Term Cycle') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="term_cycle_id" id="term_cycle_id">
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
          <?php  echo $this->Form->end(); ?>
        </div>




        <div class="rows">
            <h3 class="text-center"><?= __d('Result', 'List of Result') ?></h3>
            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Generate Result', ['action' => 'generateResult'], ['class' => 'btn btn-info']) ?></span>

        </div>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('Result', 'Level') ?></th>
                    <th><?= __d('Result', 'Session') ?></th>
                    <th><?= __d('Result', 'Term') ?></th>
                    <th><?= __d('Result', 'Template') ?></th>
                    <th><?= __d('Result', 'Grading') ?></th>
                    <th><?= __d('Result', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $result) { ?>
                <tr>
                    <td><?php echo $result['level_name'] ?></td>
                    <td><?php echo $result['session_name'] ?></td>
                    <td><?php echo $result['term_name'] ?></td>
                    <td><?php echo $result['template_name'] ?></td>
                    <td><?php echo $result['gradings_system_name'] ?></td>
                    <td>
                        <?php echo $this->Html->link('Merit', ['action' => 'resultMerit', $result['result_id']], ['class' => 'btn action-btn btn-warning', 'confirm' => 'Are you sure, You want do this?']) ?>
                        <?php echo $this->Html->link('Delete', ['action' => 'deleteResult', $result['result_id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
                     <?php echo $this->Html->link('SMS', ['action' => 'sendSMS', $result['result_id']], ['class' => 'btn action-btn btn-info', 'confirm' => 'Are you sure, You want to send sms?']) ?>
                    <?php
                        echo $this->Form->postLink(
                            $result['publish'] == 1 ? 'Unpublish' : 'Publish',
                            ['action' => 'publish', $result['result_id']],
                            [
                                'class' => $result['publish'] == 1 ? 'btn btn-danger' : 'btn btn-success',
                                'confirm' => $result['publish'] == 1
                                    ? 'Are you sure you want to unpublish this result?'
                                    : 'Are you sure you want to publish this result?'
                            ]
                        );
                        ?>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination mt-5 custom-paginate justify-content-center">
                <li class="page-item"> <?= $this->Paginator->first("First") ?></li>
                <li class="page-item"><?= $this->Paginator->prev("<<") ?></li>
                <li class="page-item"><?= $this->Paginator->numbers() ?></li>
                <li class="page-item"><?= $this->Paginator->next(">>") ?></li>
                <li class="page-item"><?= $this->Paginator->last("Last") ?></li>
            </ul>
        </nav>

    </body>

</html>
<script>
    $("#level_id").change(function () {
        getTermAjax();
    });
    $("#session_id").change(function () {
        getTermAjax();
    });
    function getTermAjax() {
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        $.ajax({
            url: 'getTermAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id,
                "session_id": session_id
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["term_name"];
                    var id = data[i]["term_cycle_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#term_cycle_id').html(text1);
            }
        });
    }
</script>