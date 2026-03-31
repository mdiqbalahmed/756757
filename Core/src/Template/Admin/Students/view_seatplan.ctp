<?php ?>
<table id="table1" class="seatPlan" width="100%" border="0" cellpadding="0" cellspacing="0">
    <thead>
    <th width="20">Room Name</th>
    <th>Roll</th>
    <th width="5">Total</th>
    <th width="20">Location</th>
    <th width="20">Send SMS</th>

</thead>

    <?php
   $roo = 1;
    foreach ($results as $resultInfo):
        $room =  $resultInfo[0]['room'];
        ?>

<tr>
    <td><?php echo $resultInfo[0]['room'] ;?></td>
    <td> 
                <?php
                $hasComma = false;
                foreach ($resultInfo as $result):
                    if ($hasComma) {
                        echo ", ";
                    }
                    echo $result['roll'];
                   $hasComma = true;
                endforeach;
                ?>
    </td>
    <td><?php  
           
               $cnt = count($resultInfo);
                echo $cnt;
           
            ?></td>
    <td><?php echo $resultInfo[0]['location'] ?></td>
    <td> 
        <div id="roomBtn<?php echo $roo; ?>">

            <?php echo $this->Html->image("/images/loader/loader.gif", array("alt" =>"",'class'=>'loader','id'=>"ajximg$roo")); ?>     

            <?php echo $this->Form->input('SMS Send', array('hiddenField' => false,'label'=>false,'type'=>'button','class' => 'submit1','id'=>"btn$roo", 'value' =>'', 'onclick'=>"room_sms('".$room."',$roo);")); ?>
        </div>
    </td>
</tr>

   <?php $roo++; ?>
    <?php endforeach; ?>

</table>
<style>
    #main {
        margin-top: 20px;
    }
    #content {
        margin-bottom: 20px;
        background: #fefefe;
        padding: 15px 20px 15px 20px;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-box-shadow: rgba(200,200,200,1) 0 4px 18px;
        -webkit-box-shadow: rgba(200,200,200,1) 0 4px 18px;
    }
    .striped {
        background-color: #f8f8f8;
    }

    table {
        width: 100%;
        border: 1px solid #fff;
        background-color: #fff;
        clear: both;
        border: 1px solid #ddd;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;

        border-collapse: separate;
        text-indent: initial;
        border-spacing: 2px;

    }
    table {
        border-collapse: separate;
        text-indent: initial;
        border-spacing: 2px;
    }
    tr, th, td {
        margin: 0;
        padding: 20px;
        border: 0;
        outline: 0;
        font-size: 100%;
        vertical-align: baseline;
        background: transparent;
    }
    tr, th, td {
        margin: 0;
        padding: 20px;
        border: 0;
        outline: 0;
        font-size: 100%;
        vertical-align: baseline;
        background: transparent;
    }
    td {
        display: table-cell;
        vertical-align: inherit;
    }
    body {
        font: 13px "Lucida Grande", Arial, sans-serif;
        background-color: #eee;
        line-height: 1.5;
        height: 100%;
    }
</style>