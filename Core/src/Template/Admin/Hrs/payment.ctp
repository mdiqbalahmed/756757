<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>

        <div style="background-color: #f2f2f2; width: 100%; height: auto; padding: 5px;">
            <h5 style="" class="">Payroll configuration :</h5>
        </div>
        <div style=" width: 100%; height: auto; padding: 5px 10px;">
            <p style="font-size: 15px;"><span style="font-weight:600;">Payroll Type :</span> <?php echo $payroll['type'] ?></p>
            <div class="row">
                <div class="col-md-2">
                    <p style="font-size: 15px;"><span style="font-weight:600;">Attendance :</span> <?php echo $payroll['attandance'] ?></p>
                </div>
                <div class="col-md-3">
                    <?php if($payroll['attandance']== "Yes") {?>
                    <p style="font-size: 15px;"><span style="font-weight:600;">Attendance Grace: </span> <?php echo $payroll['attandance_grace']?> Minute(s)</p>
                   <?php   } ?>
                </div>
                <div class="col-md-4">
                <?php if($payroll['attandance']== "Yes") {?>
                    <p style="font-size: 15px;"><span style="font-weight:600;">One salary Deduction For : </span> <?php echo $payroll['late_cut']?> Day(s)</p>
                   <?php   } ?>
                </div>
                <div class="col-md-3">
                <?php if($payroll['attandance']== "Yes") {?>
                    <p style="font-size: 15px;"><span style="font-weight:600;">Cut From: </span> <?php echo $payroll['cut_from']?></p>
                   <?php   } ?>
                </div>
                <div class="col-md-2">
                    <p style="font-size: 15px;"><span style="font-weight:600;">Absent :</span> <?php echo $payroll['absent'] ?></p>
                </div>
                <div class="col-md-3">
                <?php if($payroll['absent']== "Yes") {?>
                    <p style="font-size: 15px;"><span style="font-weight:600;">Salary Cut: </span> <?php echo $payroll['absent_cut']?>%</p>
                   <?php   } ?>

                </div>
                <div class="col-md-4">
                   <?php if($payroll['absent']== "Yes") {?>
                    <p style="font-size: 15px;"><span style="font-weight:600;">Cut From: </span> <?php echo $payroll['absent_cut_from']?></p>
                   <?php   } ?>
                </div>
                <div class="col-md-3">

                </div>
                <div class="col-md-3">
                    <p style="font-size: 15px;"><span style="font-weight:600;">Overtime :</span> <?php echo $payroll['overtime'] ?></p>
                </div>


            </div>

        </div>

        <div style="background-color: #f2f2f2; width: 100%; height: auto; padding: 5px;">
            <h5 style="" class="">Configuration setup used in this payroll :</h5>
        </div>
        <div class="row" style="margin-bottom:10px;">
            <?php foreach($hr_configs as $hr_config) { ?>
            <div class="col-md-4">
                <p style="font-size: 15px; font-weight:600; margin-left: 10px; padding: 4px;"> <?php echo $hr_config['config_action_name'] ?></p>
            </div>
            <?php }?>
        </div>

        <div style="background-color: #f2f2f2; width: 100%; height: auto; padding: 5px;">
            <h5 style="" class="">Payroll of <?php echo $payroll['month'].', '.$payroll['year'] ?></h5>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <?php if($sum !=0) {?>
                    <th><input type="checkbox" value='<?php echo round($sum) ?>' id="select_all" /><label for="select_all"></label></th>
                    <?php  }else{?>
                    <th></th>
                     <?php  }?>
                    <th>Name</th>
                    <th>Basic</th>
                    <th>Allowance</th>
                    <th>Bonus</th>
                    <th>Overtime</th>
                    <th>Sub Total</th>
                    <th>Penalty</th>
                    <th>Late</th>
                    <th>Absent</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
 <?php foreach($payroll_employees as $payroll_employee) { 
      $sub_total=$total=0;
      $sub_total=$payroll_employee['basic_salary']+$payroll_employee['total_allowances']+$payroll_employee['total_bonus']+$payroll_employee['overtime_amount'];
      $total=$sub_total-$payroll_employee['total_penalty']-$payroll_employee['late_cut']-$payroll_employee['absent_cut'];
     ?>

                <tr>
                    <?php if($payroll_employee['payment']==0) {?>
                    <td><input type='checkbox' value='<?php echo round($total) ?>' id='<?php echo $payroll_employee['payroll_employee_id'] ?>' onchange='returnData(this.id)' /><label for=''><span></span></label></td>
                    <?php  }else{?>
                    <td></td>
                     <?php  }?>
                    <td><?php echo $payroll_employee['name'] ?></td>
                    <td><?php echo $payroll_employee['basic_salary'] ?></td>
                    <td><?php echo $payroll_employee['total_allowances'] ?></td>
                    <td><?php echo $payroll_employee['total_bonus'] ?></td>
                    <td><?php echo $payroll_employee['overtime_amount'] ?></td>
                    <td><?php echo  round($sub_total)?></td>
                    <td><?php echo $payroll_employee['total_penalty'] ?></td>
                    <td><?php echo round($payroll_employee['late_cut']) ?></td>
                    <td><?php echo round($payroll_employee['absent_cut']) ?></td>
                    <td><?php echo round($total) ?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>

         <?php if($sum !=0) {?>
         <?php echo $this->Form->create(); ?>

        <?php

$this->Form->unlockField('id');
$this->Form->unlockField('amount');
$this->Form->unlockField('payroll_id');
$this->Form->unlockField('all');
$this->Form->unlockField('bank_id');
$this->Form->unlockField('comment');
$this->Form->unlockField('date');
$this->Form->unlockField('month');
?>
        <input name="all" type="hidden" class="form-control" id="all" value="<?php echo $ids?>">
        <input name="id" type="hidden" class="form-control id" id="id" value="">
        <input name="month" type="hidden" class="form-control" value="<?php echo $payroll['month']?>">
        <input name="payroll_id" type="hidden" class="form-control" value="<?php echo $payroll['payroll_id']?>">
        <div class='row mt-3'>
            <div class='col-md-8'>

            </div>
            <div class='col-md-4'>
                <div class='row'>
                    <div class='col-md-6 mt-2'>
                        Total Amount
                    </div>
                    <div class='col-md-6'>
                        <input name="amount" type="text" class="form-control total" id="total" value="" required>
                    </div>
                </div>
            </div>
            <div class='col-md-8'>

            </div>
            <div class='col-md-4 mt-2'>
                <div class='row  mt-2'>
                    <div class='col-md-6'>
                        Bank
                    </div>
                    <div class='col-md-6'>
                        <select id="" class="form-select option-class dropdown260" name="bank_id" required>
                             <?php  foreach ($banks as $id => $bank) {  ?>
                            <option value="<?php echo $bank['bank_id']; ?>"><?php echo $bank['bank_name']; ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
            <div class='col-md-8'>

            </div>
            <div class='col-md-4'>
                <div class='row  mt-2'>
                    <div class='col-md-6'>
                        Date
                    </div>
                    <div class='col-md-6'>
                        <input name="date" type="date" class="form-control total" id="date" value="" required>
                    </div>
                </div>
            </div>
            <div class='col-md-8'>

            </div>
            <div class='col-md-4'>
                <div class='row  mt-2'>
                    <div class='col-md-6'>
                        Comment
                    </div>
                    <div class='col-md-6'>
                        <textarea class="form-control" id="comment" rows="3"  name="comment"></textarea>
                    </div>
                </div>
            </div>

        </div>
        <div class="text-right mt-5">
            <button type="submit" class="btn btn-info">Submit</button>
        </div>
         <?php echo $this->Form->end(); } ?>

    </body>

</html>

<script>


function returnData(val) {
      var id=document.getElementById("id").value;
      var total=document.getElementById("total").value; 
      var number=document.getElementById(val).value;  
      var checkBox = document.getElementById(val);
    if (checkBox.checked == true){
          next=id+','+val; 
          document.getElementById("id").value = next;
          var total = +total + +number;
          document.getElementById("total").value = total; //set total
    } else {
           val=','+val; 
           var next = id.replace(val,'');
            document.getElementById("id").value = next;
           var total = +total - +number;
           document.getElementById("total").value = total; //set total
    }
}

$('#select_all').click(function(event) { 
       var number=document.getElementById('select_all').value;
       console.log(number);
      
    if(this.checked) {
           document.getElementById("total").value = number;
           var ids=document.getElementById('all').value;
           document.getElementById("id").value = ids;
           
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    } else {
          document.getElementById("total").value = '';
          document.getElementById("id").value = '';
        $(':checkbox').each(function() {
           this.checked = false;                       
        });
    }
}); 


</script>