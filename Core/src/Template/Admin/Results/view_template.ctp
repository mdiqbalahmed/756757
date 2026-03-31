<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <h3>
            Template Name : <?php echo $result_templates[0]['name']?>
        </h3>

    </body>
     <?php if(isset($rules['merge_subject'])){?>
    <h5  style="margin-left:10px;" class="mt-3">Merge Subject</h5>
       <?php foreach($rules['merge_subject']['value'] as $key => $value){?>
    <p style="margin-top: -5px; margin-left:20px;"> Group  <?php echo $key; ?> :  <?php echo $value['view']; ?></p>
     <?php }?>
   <?php }?>
         <?php if(isset($rules['term'])){?>
    <h5  style="margin-left:10px;" class="mt-3">Merge Subject</h5>
       <?php foreach($rules['term']['value']['term_name'] as $key => $term_name){?>
    <p style="margin-top: -5px; margin-left:20px;"> Term  <?php echo $key+1; ?> :  <?php echo $term_name; ?>. Percentage :<b><?php echo $rules['term']['value']['term_percentage'][$key]."%";?></b></p>
     <?php }?>
   <?php }?>
    <h5 style="margin-left:10px;"  class="mt-3">Pass/Fail Check</h5>
    <p class="mt-2" style="margin-left:20px;">Total Pass Check: <b>Yes</b></p>
   <?php if(isset($rules['indivisul_pass_check']) || isset($rules['group_pass_check'])){?>
       <?php if(isset($rules['indivisul_pass_check'])){?>
    <p class="mt-2" style="margin-left:20px;">Individual Pass Check: <b>Yes</b></p>
     <?php }?>
     <?php if(isset($rules['group_pass_check'])){?>
    <p class="mt-2" style="margin-left:20px;"> Group Pass/Fail check: <b>Yes</b></p>
       <?php foreach($rules['group_pass_check']['value'] as $key => $value){?>
    <p style="margin-top: -13px; margin-left:30px;"> Group  <?php echo $key; ?> :  <?php echo $value['view']; ?></p>
     <?php }?>
     <?php }?>
   <?php }?>
       <?php if(isset($rules['total_persentage_check']) || isset($rules['group_persentage_check'])){?>
    <h5 style="margin-left:10px;"  class="mt-3">Percentage of Marks</h5>
       <?php if(isset($rules['total_persentage_check'])){?>
    <p class="mt-2" style="margin-left:20px;">Total Percentage <b> Yes,</b> Percentage:<b><?php echo $rules['total_persentage_check']['value']."%";?></b></p>
     <?php }?>
     <?php if(isset($rules['group_persentage_check'])){?>
    <p class="mt-2" style="margin-left:20px;"> Group Percentage check: <b>Yes</b></p>
       <?php foreach($rules['group_persentage_check']['value'] as $key => $value){?>
    <p style="margin-top: -13px; margin-left:30px;"> Group  <?php echo $key; ?> :  <?php echo $value['view']; ?>. Percentage :<b><?php echo $value['persentage']."%";?></b></p>
     <?php }?>
     <?php }?>
   <?php }?>

     <?php if(isset($rules['extra_subject'])){?>
    <h5  style="margin-left:10px;" class="mt-3">Extra Subject</h5>
    <p class="mt-2" style="margin-left:20px;">Consider Extra Subject In Calculation: <b>Yes</b></p>
     <?php }?>


     <?php if(isset($rules['activity'])){?>
    <h5  style="margin-left:10px;margin-bottom:15px;" class="mt-3">Student Activity</h5>
       <?php foreach($rules['activity']['value']['activity_name'] as $key=>  $activity_name){?>
    <p style="margin-top: -13px; margin-left:30px;"> Activity  <?php echo $key+1; ?> :  <?php echo $activity_name; ?></p>
     <?php }?>
     <?php }?>
</html>