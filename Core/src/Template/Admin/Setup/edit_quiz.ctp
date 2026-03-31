<?php

$this->Form->unlockField('scms_quiz_id');  
$this->Form->unlockField('quiz_name'); 
$this->Form->unlockField('marks');  
$this->Form->unlockField('new_name'); 
$this->Form->unlockField('new_marks');  
?>


<div>
	<?php echo $this->Form->create();?>
    <section>
        <h4><?php echo $head;?></h4>
        <p class="col-lg-12 inner_heading mt-5">
            <input type="button" class="add_quiz" value="Add Quiz">
        </p>

         <?php foreach ($quizs as $quiz) { ?>
        <div class="old">
            <input id=""  name="scms_quiz_id[]" type="hidden" value="<?php echo $quiz['scms_quiz_id']; ?>">
            <div class="row mt-2" id="single_row">
                <div class="col-md-2">
                    <p><?= __d('setup', 'Quiz Name ') ?>:</p>
                </div>
                <div class="col-md-3">
                    <input id=""  name="quiz_name[<?php echo $quiz['scms_quiz_id']; ?>]" type="text" class="form-control" value="<?php echo $quiz['quiz_name']; ?>" required>
                </div>
                <div class="col-md-1">

                </div>
                <div class="col-md-2">
                    <p><?= __d('setup', 'Quiz Mark ') ?>:</p>
                </div>
                <div class="col-md-3">
                    <input id=""  name="marks[<?php echo $quiz['scms_quiz_id']; ?>]" type="text" class="form-control" value="<?php echo $quiz['marks']; ?>" required>
                </div>
                <div class="col-md-1">
                    <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        </div>
                <?php } ?>
        <div class="form">
            <div class="row mt-2" id="single_row">
                <div class="col-md-2">
                    <p><?= __d('setup', 'Quiz Name ') ?>:</p>
                </div>
                <div class="col-md-3">
                    <input id=""  name="new_name[]" type="text" class="form-control" value="" required>
                </div>
                <div class="col-md-1">

                </div>
                <div class="col-md-2">
                    <p><?= __d('setup', 'Quiz Mark ') ?>:</p>
                </div>
                <div class="col-md-3">
                    <input id=""  name="new_marks[]" type="text" class="form-control" value="" required>
                </div>
                <div class="col-md-1">
                    <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        </div>
    </section>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Update') ?></button>
		<?php echo $this->Form->end(); ?>
    </div>
</div>

<script type="text/javascript"> 
    
    var form = $(".form").html();
    $('.add_quiz').click(function () {
        $('.form').append(form);
    });
    $('.form').on('click', '#delete', function (eq) {
        $(this).closest('#single_row').remove();                        
    });
      $('.old').on('click', '#delete', function (eq) {
           alert("Are you sure, You want delete this?");
        $(this).closest('#single_row').remove();                        
    });
</script>