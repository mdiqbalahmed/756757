<?php

$this->Form->unlockField('gradings_system_name');
$this->Form->unlockField('grade_id');
$this->Form->unlockField('grade_name');
$this->Form->unlockField('point');
$this->Form->unlockField('percentage_down');
$this->Form->unlockField('percentage_top');
?>


<div>
    <?php echo $this->Form->create(); ?>
    <section class="std_info">
        <h4><?= __d('gradings', 'Edit Grading System') ?></h4>
        <div class="row mx-3 mt-2 p-3">
            <div class="col-md-12  mt-3">
                <div class="row">
                    <div class="col-md-3">
                        <label for="inputSId" class="form-label"><?= __d('gradings', 'Grading System Name:') ?></label>
                    </div>
                    <div class="col-md-7">
                        <input name="gradings_system_name" type="text" class="form-control" id="inputSId" value="<?php echo $gradings['0']->gradings_system_name;?>" required>
                    </div>
                </div>

                <div  class="mt-5">
                    <p class="col-lg-12 inner_heading mt-5">
                        <input type="button" class="add_more" value="Add More">
                    </p>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label for="inputSId" class="form-label"><?= __d('gradings', 'Grade Name') ?></label>
                        </div>
                        <div class="col-md-2">
                            <label for="inputSId" class="form-label"><?= __d('gradings', 'Point') ?></label>
                        </div>
                        <div class="col-md-2">
                            <label for="inputSId" class="form-label"><?= __d('gradings', 'Range(Bottom)') ?></label>
                        </div>
                        <div class="col-md-2">
                            <label for="inputSId" class="form-label"><?= __d('gradings', 'Range(top)') ?></label>
                        </div>

                    </div>

                   <?php foreach ($grades as $grade) { ?>
                    <div class="old">

                        <div class="row mt-2" id="single_row">
                            <input id="grade_id"  name="grade_id[<?php echo $grade['grade_id']; ?>]" type="hidden" value="<?php echo $grade['grade_id']; ?>">
                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                <input id=""  name="grade_name[<?php echo $grade['grade_id']; ?>]" type="text" class="form-control" value="<?php echo $grade['grade_name']; ?>" required>
                            </div>
                            <div class="col-md-2">
                                <input id=""  name="point[<?php echo $grade['grade_id']; ?>]" type="text"  class="form-control" value="<?php echo $grade['point']; ?>" required>
                            </div>
                            <div class="col-md-2">
                                <input id=""  name="percentage_down[<?php echo $grade['grade_id']; ?>]" type="text"  class="form-control" value="<?php echo $grade['percentage_down']; ?>" required>
                            </div>
                            <div class="col-md-2">
                                <input id=""  name="percentage_top[<?php echo $grade['grade_id']; ?>]" type="text" class="form-control" value="<?php echo $grade['percentage_top']; ?>" required>
                            </div>
                            <div class="col-md-1">
                                <button id="<?php echo $grade['grade_id']; ?>" class="btn-danger" onclick="delete_old(this)" type="button"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    </div>
                  <?php } ?>

                    <div class="form">
                        <div class="row mt-2" id="single_row">
                            <input id="grade_id"  name="grade_id[]" type="hidden" value="">
                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                <input id=""  name="grade_name[]" type="text" class="form-control" value="" required>
                            </div>
                            <div class="col-md-2">
                                <input id=""  name="point[]" type="number" max="5" min="0" class="form-control" value="" required>
                            </div>
                            <div class="col-md-2">
                                <input id=""  name="percentage_down[]" type="number" max="100" min="0" class="form-control" value="" required>
                            </div>
                            <div class="col-md-2">
                                <input id=""  name="percentage_top[]" type="number" max="100" min="0" class="form-control" value="" required>
                            </div>
                            <div class="col-md-1">
                                <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
</div>
<div class="text-right mt-5">
    <button type="submit" class="btn btn-info"><?= __d('gradings', 'Submit') ?></button>
            <?php echo $this->Form->end(); ?>
</div>
</section>
</div>
<script type="text/javascript"> 
$(document).ready(function() {
    var form = $(".form").html();
    $('.add_more').click(function () {
        $('.form').append(form);
      });
});
    $('.form').on('click', '#delete', function (eq) {
        $(this).closest('#single_row').remove();                        
    });
     function delete_old(value) {
        if (confirm('Are you sure you want to delete this?')) {
            var grade_id = parseInt(value.id);
              $.ajax({
                  url: 'deleteGradeAjax',
                  cache: false,
                  type: 'GET',
                  dataType: 'HTML',
                  data: {
                     "grade_id": grade_id
                  },
                  success: function(data) {
                       $(value).closest('#single_row').remove();                           
                  }
                 });
            
         }
        
     }
</script>
