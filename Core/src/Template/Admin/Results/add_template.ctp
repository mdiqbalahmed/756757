<?php

$this->Form->unlockField('result_template_name');
$this->Form->unlockField('merit');
$this->Form->unlockField('merge_subject');
$this->Form->unlockField('indivisul_pass_check');
$this->Form->unlockField('group_pass_check');
$this->Form->unlockField('group_pass');

$this->Form->unlockField('total_persentage_check');
$this->Form->unlockField('group_persentage_check');
$this->Form->unlockField('group_persentage');
$this->Form->unlockField('group_persentage_number');
$this->Form->unlockField('total_persentage_number');
$this->Form->unlockField('extra_sublect_calculation');
$this->Form->unlockField('activity');


?>

<div>
    <?php echo $this->Form->create(); ?>
    <section class="std_info">
        <h4><?= __d('Result', 'Add New Result Template') ?></h4>
        <div class="col-md-12  mx-3 p-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="inputSId" class="form-label"><?= __d('Result', 'Result Template Name:') ?></label>
                </div>
                <div class="col-md-6">
                    <input name="result_template_name" type="text" class="form-control" id="inputSId" placeholder="Result Template Name" required>
                </div>
            </div>
        </div>
        <div class="col-md-12  mx-3 p-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="inputSId" class="form-label"><?= __d('Result', 'Merit From:') ?></label>
                </div>
                <div class="col-md-6">
                    <select id="merit" class="form-select option-class" name="merit" >
                        <option value="section">Section</option>
                        <option value="shift">Shift</option>
                        <option value="level">Level</option>
                    </select>
                </div>
            </div>
        </div>
        <h5><?= __d('Result', '##Merge Subject') ?></h5>
        <div class="merge_subject">
            <div class="col-md-12 mx-3  p-3" id="single_row">
                <div class="row">
                    <div class="col-md-3">
                        <label for="my-input" class="form-label"><?= __d('Result', 'Merge Subject Set 1:') ?></label>
                    </div>
                    <div class="col-md-6">
                        <select id=""  size="5" class="userRequest_activity form-select option-class  " name="merge_subject[1][]" multiple="multiple" >
                             <?php foreach ($courses as $id => $course) {  ?>
                            <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mx-3  p-3" id="single_row">
                <div class="row">
                    <div class="col-md-3">
                        <label for="my-input" class="form-label"><?= __d('Result', 'Merge Subject Set 2:') ?></label>
                    </div>
                    <div class="col-md-6">
                        <select id=""  size="5" class="userRequest_activity form-select option-class  " name="merge_subject[2][]" multiple="multiple" >
                             <?php foreach ($courses as $id => $course) {  ?>
                            <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                            <?php }?>
                        </select>
                    </div>  
                    <div class="col-md-1">
                        <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mx-3  p-3" id="single_row">
                <div class="row">
                    <div class="col-md-3">
                        <label for="my-input" class="form-label"><?= __d('Result', 'Merge Subject Set 3:') ?></label>
                    </div>
                    <div class="col-md-6">
                        <select id=""  size="5" class="userRequest_activity form-select option-class  " name="merge_subject[3][]" multiple="multiple" >
                             <?php foreach ($courses as $id => $course) {  ?>
                            <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mx-3  p-3" id="single_row">
                <div class="row">
                    <div class="col-md-3">
                        <label for="my-input" class="form-label"><?= __d('Result', 'Merge Subject Set 4:') ?></label>
                    </div>
                    <div class="col-md-6">
                        <select id=""  size="5" class="userRequest_activity form-select option-class  " name="merge_subject[4][]" multiple="multiple" >
                             <?php foreach ($courses as $id => $course) {  ?>
                            <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                            <?php }?>
                        </select>
                    </div>  
                    <div class="col-md-1">
                        <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mx-3  p-3" id="single_row">
                <div class="row">
                    <div class="col-md-3">
                        <label for="my-input" class="form-label"><?= __d('Result', 'Merge Subject Set 5:') ?></label>
                    </div>
                    <div class="col-md-6">
                        <select id=""  size="5" class="userRequest_activity form-select option-class  " name="merge_subject[5][]" multiple="multiple" >
                             <?php foreach ($courses as $id => $course) {  ?>
                            <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mx-3  p-3" id="single_row">
                <div class="row">
                    <div class="col-md-3">
                        <label for="my-input" class="form-label"><?= __d('Result', 'Merge Subject Set 6:') ?></label>
                    </div>
                    <div class="col-md-6">
                        <select id=""  size="5" class="userRequest_activity form-select option-class  " name="merge_subject[6][]" multiple="multiple" >
                             <?php foreach ($courses as $id => $course) {  ?>
                            <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                            <?php }?>
                        </select>
                    </div>  
                    <div class="col-md-1">
                        <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <h5><?= __d('Result', '##Pass/Fail Check') ?></h5>
        <div class="persentage">
            <div class="col-md-12 mx-3  p-3">
                <div class="row">
                    <div class="col-md-1 ">
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="my-input" class="form-label"><?= __d('Result', 'Single :') ?></label>
                            </div>
                            <div class="col-md-3" style="margin-top: -30px;">
                                <input class="form-check-input " type="checkbox" name="indivisul_pass_check">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12 mx-3  p-3">
                <div class="row">
                    <div class="col-md-1 ">
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="my-input" class="form-label"><?= __d('Result', 'Group:') ?></label>
                            </div>
                            <div class="col-md-3" style="margin-top: -30px;">
                                <input class="form-check-input" type="checkbox" name="group_pass_check" id="show_group_1">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="group_pass mystyle_hidden" style="margin-left: 15px;" id="show_1">
                <div class="col-md-12 mx-3  p-3" id="single_row">
                    <div class="row">
                        <div class="col-md-1"> </div>
                        <div class="col-md-2">
                            <label for="my-input" class="form-label"><?= __d('Result', 'Group 1:') ?></label>
                        </div>
                        <div class="col-md-4">
                            <select id=""  style='width:100%; 'size="4" class="form-select option-class dropdown260" name="group_pass[1][]" multiple="multiple">
                             <?php foreach ($parts as $id => $part) {  ?>
                                <option value="<?php echo $part['term_course_cycle_part_type_id']; ?>"><?php echo $part['term_course_cycle_part_type_name']; ?></option>
                            <?php }?>
                            </select>
                        </div>
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-1">
                            <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mx-3  p-3" id="single_row">
                    <div class="row">
                        <div class="col-md-1"> </div>
                        <div class="col-md-2">
                            <label for="my-input" class="form-label"><?= __d('Result', 'Group 2:') ?></label>
                        </div>
                        <div class="col-md-4">
                            <select id=""  style='width:100%;' size="4" class="form-select option-class dropdown260" name="group_pass[2][]" multiple="multiple">
                             <?php foreach ($parts as $id => $part) {  ?>
                                <option value="<?php echo $part['term_course_cycle_part_type_id']; ?>"><?php echo $part['term_course_cycle_part_type_name']; ?></option>
                            <?php }?>
                            </select>
                        </div>
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-1">
                            <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mx-3  p-3" id="single_row">
                    <div class="row">
                        <div class="col-md-1"> </div>
                        <div class="col-md-2">
                            <label for="my-input" class="form-label"><?= __d('Result', 'Group 3:') ?></label>
                        </div>
                        <div class="col-md-4">
                            <select id=""  style='width:100%; 'size="4" class="form-select option-class dropdown260" name="group_pass[3][]" multiple="multiple">
                             <?php foreach ($parts as $id => $part) {  ?>
                                <option value="<?php echo $part['term_course_cycle_part_type_id']; ?>"><?php echo $part['term_course_cycle_part_type_name']; ?></option>
                            <?php }?>
                            </select>
                        </div>
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-1">
                            <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mx-3  p-3" id="single_row">
                    <div class="row">
                        <div class="col-md-1"> </div>
                        <div class="col-md-2">
                            <label for="my-input" class="form-label"><?= __d('Result', 'Group 4:') ?></label>
                        </div>
                        <div class="col-md-4">
                            <select id="" style='width:100%; 'size="4" class="form-select option-class dropdown260" name="group_pass[4][]" multiple="multiple">
                             <?php foreach ($parts as $id => $part) {  ?>
                                <option value="<?php echo $part['term_course_cycle_part_type_id']; ?>"><?php echo $part['term_course_cycle_part_type_name']; ?></option>
                            <?php }?>
                            </select>
                        </div>
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-1">
                            <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>



            </div>

        </div>



        <h5><?= __d('Result', '##Persentage of Marks') ?></h5>
        <div class="pass_fail">
            <div class="col-md-12 mx-3  p-3" id="persentage_total">
                <div class="row">
                    <div class="col-md-1 ">
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="my-input" class="form-label"><?= __d('Result', 'Total :') ?></label>
                            </div>
                            <div class="col-md-3" style="margin-top: -30px;">
                                <input class="form-check-input" type="checkbox" name="total_persentage_check" id="total_persentage_check">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3 mystyle_hidden" id="show_persentage_total_1">
                        <label for="my-input" class="form-label"><?= __d('Result', 'Persentage For Total(0 To 100):') ?></label>
                    </div>
                    <div class="col-md-2 mystyle_hidden"id="show_persentage_total_2">
                        <input name="total_persentage_number" type="number" class="form-control" id="inputSId" placeholder="Persentage" >
                    </div>
                </div>
            </div>


            <div class="col-md-12 mx-3  p-3" id="persentage_group">
                <div class="row">
                    <div class="col-md-1 mt-10">
                    </div>
                    <div class="col-md-2 mt-10">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="my-input" class="form-label"><?= __d('Result', 'Group :') ?></label>
                            </div>
                            <div class="col-md-3" style="margin-top: -30px;">
                                <input class="form-check-input" type="checkbox" name="group_persentage_check" id="show_group_2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group_pass mystyle_hidden" style="margin-left: 15px;" id="show_2">
                <div class="col-md-12 mx-3  p-3" id="single_row">
                    <div class="row">
                        <div class="col-md-1"> </div>
                        <div class="col-md-2">
                            <label for="my-input" class="form-label"><?= __d('Result', 'Group 1:') ?></label>
                        </div>
                        <div class="col-md-4">
                            <select id="group_pass_1"  style='width:100%; 'size="4" class="form-select option-class dropdown260" name="group_persentage[1][]" multiple="multiple" >
                             <?php foreach ($parts as $id => $part) {  ?>
                                <option value="<?php echo $part['term_course_cycle_part_type_id']; ?>"><?php echo $part['term_course_cycle_part_type_name']; ?></option>
                            <?php }?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input name="group_persentage_number[1][]" type="number" class="form-control" id="inputSId" placeholder="Persentage" >
                        </div>
                        <div class="col-md-1">
                            <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>




            </div>

        </div>

        <h5><?= __d('Result', '##Consider Extra Subject In Calculation') ?></h5>
        <div class="persentage">
            <div class="col-md-12 mx-3  p-3">
                <div class="row">
                    <div class="col-md-1 ">
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="my-input" class="form-label"><?= __d('Result', 'Yes :') ?></label>
                            </div>
                            <div class="col-md-3" style="margin-top: -30px;">
                                <input class="form-check-input " type="checkbox" name="extra_sublect_calculation">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <h5><?= __d('Result', '##Student Activity') ?></h5>
        <div class="col-md-12 mx-3  p-3" >
            <div class="row">
                <div class="col-md-3">
                    <label for="my-input" class="form-label"><?= __d('Result', 'Activiies:') ?></label>
                </div>
                <div class="col-md-6">
                    <select id=""  size="5" class="userRequest_activity form-select option-class  " name="activity[]" multiple="multiple" >
                             <?php foreach ($activities as $activity) {  ?>
                        <option value="<?php echo $activity['activity_id']; ?>"><?php echo $activity['name']; ?></option>
                            <?php }?>
                    </select>
                </div>
            </div>
        </div>
        <div class="text-right mt-5">
            <button type="submit" class="btn btn-info"><?= __d('Result', 'Submit') ?></button>
        </div>
           <?php echo $this->Form->end(); ?>
    </section>
</div>
<script type='text/javascript'>
    $(document).ready(function () {
        var last_valid_selection = null;
        $('.userRequest_activity').change(function (event) {
            if ($(this).val().length > 2) {
                $(this).val(last_valid_selection);
            } else {
                last_valid_selection = $(this).val();
            }
        });
        $('.merge_subject').on('click', '#delete', function (eq) {
            $(this).closest('#single_row').remove();
        });
        $('.group_pass').on('click', '#delete', function (eq) {
            $(this).closest('#single_row').remove();
        });
    });
    $('#show_group_1').click(function () {
        var element1 = document.getElementById("show_1");
        var checkBox = document.getElementById("show_group_1");
        if (checkBox.checked == true) {
            element1.classList.remove("mystyle_hidden");
        } else {
            element1.classList.add("mystyle_hidden");
        }
    });


    $('#show_group_2').click(function () {
        var element1 = document.getElementById("show_2");
        var element3 = document.getElementById("persentage_total");
        var checkBox = document.getElementById("show_group_2");
        if (checkBox.checked == true) {
            element1.classList.remove("mystyle_hidden");
            element3.classList.add("mystyle_hidden");
        } else {
            element1.classList.add("mystyle_hidden");
            element3.classList.remove("mystyle_hidden");
        }
    });

    $('#total_persentage_check').click(function () {
        var element1 = document.getElementById("show_persentage_total_1");
        var element2 = document.getElementById("show_persentage_total_2");
        var element3 = document.getElementById("persentage_group");

        var checkBox = document.getElementById("total_persentage_check");
        if (checkBox.checked == true) {
            element1.classList.remove("mystyle_hidden");
            element2.classList.remove("mystyle_hidden");
            element3.classList.add("mystyle_hidden");
        } else {
            element1.classList.add("mystyle_hidden");
            element2.classList.add("mystyle_hidden");
            element3.classList.remove("mystyle_hidden");
        }
    });



</script>
