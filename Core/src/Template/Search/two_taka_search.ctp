    <?php

    use Cake\Core\Configure;

    $this->Form->unlockField('session_id');
    $this->Form->unlockField('sid');
    $this->Form->unlockField('dob');

    ?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                    <?= __d('accounts', 'Two Taka Bank Information') ?>
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
                                            <p class="label-font13"><?= __d('contacts', 'SID') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="sid" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('contacts', 'Date Of Birth') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <input name="dob" type="date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('contacts', 'Session') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="session_id" id="session_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                <?php foreach ($sessions as $session) { ?>
                                                    <option value="<?php echo $session['session_id']; ?>"><?php echo $session['session_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4">

                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                        </div>
                                        <div class="col-lg-9 row2Field mt-5">
                                            <button type="submit" class="btn btn-info"><?= __d('contacts', 'Search') ?></button>
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


        <?php if (empty($students)) { ?>
            <center style="margin-top:50px; font-weight:bold; font-size:1.2em"></center>

        <?php } else { ?>


            <?php echo $this->Form->create(); ?>

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Voucher No</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $update = null;
                    foreach ($students as $student) { //pr($student);die;
                    ?>
                        <tr class="single_row">
                            <td><?php echo $student['voucher'];  ?></td>
                            <td><?php echo $student['name'];  ?></td>
                            <td><?php echo $student['date'];  ?></td>
                            <td><?php echo $student['amount']; ?></td>

                        </tr>
                    <?php } ?>

                </tbody>
            </table>
            <?php echo $this->Form->end(); ?>
            </div>
        <?php } ?>


    </body>

    </html>
    <script>
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
            console.log('data');
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
                success: function(data) {
                    data = JSON.parse(data);
                    console.log(data);
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
