<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <div class="rows">
            <h3 class=""><?= __d('setup', 'Course Cycle Mark Distribution') ?></h3>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p><?= __d('setup', 'Deparment ') ?>:<?php echo $result['department_name'] ?></p>
            </div>
            <div class="col-md-6">
                <p><?= __d('setup', 'Level ') ?>:<?php echo $result['level_name'] ?><p>
            </div>
            <div class="col-md-6">
                <p><?= __d('setup', 'Course Details ') ?>:<?php echo $result['course_name']." - ".$result['course_code']?><p>
            </div><div class="col-md-6">
                <p><?= __d('setup', 'Term ') ?>:<?php echo $result['session_name'].' - '.$result['term_name']; ?><p>
            </div>
        </div>
        <div class="rows">
            <h5 class=""><?= __d('setup', 'Mark Distribution') ?></h5>
        </div>
        <div class="row">
            <div class="col-md-2">
                <p><?= __d('setup', 'Name ') ?></p>
            </div>
            <div class="col-md-2">
                <p><?= __d('setup', 'Marks ') ?><p>
            </div>
            <div class="col-md-2">
                <p><?= __d('setup', 'Pass Mark') ?><p>
            </div>
            <div class="col-md-4">
                <p style="text-align: center;"><?= __d('setup', 'Quiz') ?><p>
            </div>
        </div>
        <?php echo $this->Form->create(); 
            $i=1;
            $this->Form->unlockField('term_course_cycle_id'); 
            $this->Form->unlockField('mark');
            $this->Form->unlockField('total'); 
            $this->Form->unlockField('pass_mark'); 
            $this->Form->unlockField('term_course_cycle_part_id'); 
             $this->Form->unlockField('partname'); 
            $this->Form->unlockField('partmark'); ?>

        <input name="term_course_cycle_id" type="hidden" value="<?php echo $result['term_course_cycle_id']?>">
        <input name="total" type="hidden" id="total" value="<?php echo count($merks_distrubutions);?>">
         <?php foreach ($merks_distrubutions as $mark_distrubation) { 
             $id1='mark_'.$i; $id2='pass_mark_'.$i;
             $i++;
              $value=isset($mark_distrubation['term_course_cycle_part_id']) ? $mark_distrubation['term_course_cycle_part_id'] : null;
             ?>

        <input name="term_course_cycle_part_id[<?php echo $mark_distrubation['term_course_cycle_part_type_id']?>]" type="hidden" value="<?php echo $value;?>">
        <div class="row">
            <div class="col-md-2">
                <p><?php echo $mark_distrubation['term_course_cycle_part_type_name']?></p>
            </div>
            <div class="col-md-2">
                <input id="<?php echo $id1?>"  <?php if($mark_distrubation['term_course_cycle_part_type_id']==9999){echo 'readonly';}?> name="mark[<?php echo $mark_distrubation['term_course_cycle_part_type_id']?>]" type="number" class="form-control" value="<?php echo $mark_distrubation['mark']?>" <?php echo $mark_distrubation['mark']?> onkeyup="gettotal()">
            </div>
            <div class="col-md-2">
                <input id="<?php echo $id2?>"  name="pass_mark[<?php echo $mark_distrubation['term_course_cycle_part_type_id']?>]" type="number" class="form-control" value="<?php echo $mark_distrubation['pass_mark']?>" onkeyup="getpasstotal(this.id)">
            </div>
            <div class="col-md-4">
                <?php if($mark_distrubation['partable'] == "Yes"){
                    $val=null;
                    foreach ($mark_distrubation['quiz'] as $quiz){
                       ($val!=null) ?  $val=$val.",".$quiz['quiz_name']  :  $val=$quiz['quiz_name'];
                     } ?>
                <input id="" readonly class="form-control" value="<?php echo $val;?>" >
                <?php } ?>
            </div>
            <div class="col-md-2">
                 <?php if($mark_distrubation['partable'] == "Yes"){
                      echo $this->Html->link('Edit', ['action' => 'editQuiz', $mark_distrubation['term_course_cycle_part_id']], ['class' => 'btn action-btn btn-warning']);
                 } ?>
            </div>
        </div>
          <?php } ?>
        <div class="text-right mt-5">
            <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?> </button>
		<?php echo $this->Form->end(); ?>
        </div>



    </body>

</html>




<script type="text/javascript">  
function gettotal(){  
    var number=document.getElementById("total").value;   
    var i=1;
    var total=0;
     for(i=1;i<number;i++){
       var id="mark_"+i;
       var marks=document.getElementById(id).value; 
       if(marks){
          total=parseInt(total)+parseInt(marks);
       }
     }
    var total_id="mark_"+number;
    document.getElementById(total_id).value=total;
}
function getpasstotal(id){  
    var ret = parseInt(id.replace('pass_mark_',''));
    var number=parseInt(document.getElementById("total").value); 
    var i=1;
    var total=0;
    for(i=1;i<number;i++){
       var id="pass_mark_"+i;
       var marks=document.getElementById(id).value; 
       if(marks){
          total=parseInt(total)+parseInt(marks);  
       }
     }
    var total_id="pass_mark_"+number;
      if(number != ret){
         document.getElementById(total_id).value=total;
      }

}
</script>

