<!doctype html>
<html lang="en">


    <body>
        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Promotion Template Details') ?>
                </h3>
            </div>
            <div class="row mb-3">
                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Template Name:') ?></p>
                        </div>
                        <div class="col-lg-9">
                            <p class="label-font13"><?= $prmotion_templates['name'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Session From:') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <p class="label-font13"><?= $prmotion_templates['session_from_name'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Session To:') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <p class="label-font13"><?= $prmotion_templates['session_to_name'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Bases on Term:') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <p class="label-font13"><?= $prmotion_templates['term_name'] ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Result Type:') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <p class="label-font13"><?= $prmotion_templates['type'] ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Filter Non Islam:') ?></p>
                        </div>
                        <div class="col-lg-9">
                            <p class="label-font13">  <?php  if($prmotion_templates['non_islam']){echo "Yes";}else{echo "No";} ?></p>
                        </div>
                    </div>
                </div>


                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Change Roll:') ?></p>
                        </div>
                        <div class="col-lg-9">
                            <p class="label-font13">  <?php  if($prmotion_templates['chnage_roll']) {echo "Yes";}else{echo "No";}?></p>
                        </div>

                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Promote Fail Students:') ?></p>
                        </div>
                        <div class="col-lg-9">
                            <p class="label-font13">  <?php  if($prmotion_templates['promote_fail']) {echo "Yes";}else{echo "No";}?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Number of Course:') ?></p>
                        </div>
                        <div class="col-lg-9">
                            <p class="label-font13">  <?= $prmotion_templates['fail_course_count'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Fourth Subject:') ?></p>
                        </div>
                        <div class="col-lg-9">
                            <p class="label-font13">  <?php  if($prmotion_templates['fourth_subject']) {echo "Yes";}else{echo "No";}?></p>
                        </div>
                    </div>
                </div>
            </div>



        </div>



    </body>

</html>
<script>
    $("#session_from").change(function () {
        getTermForPromotionAjax();
    });
    function getTermForPromotionAjax() {
        var session_from = $("#session_from").val();
        $.ajax({
            url: 'getTermForPromotionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "session_from": session_from
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["term_name"];
                    var id = data[i]["term_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#term').html(text1);


            }
        });
    }
</script>