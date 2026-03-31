<?php ?>
<table id="table1" class="table" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="90">Room Name</td>
        <td width="20">Roll</td>
        <td width="20">Quantity</td>
        <td width="20">Location</td>

    </tr>

    <?php
   
//pr($cnt); die;
    foreach ($results as $resultInfo):
//        pr($resultInfo);die;
        ?>

    <tr>
        <td><?php echo $resultInfo[0]['room'] ?></td>
        <td> 
                <?php
                $hasComma = false;
                foreach ($resultInfo as $result):
//                    pr($result);die;
                    if ($hasComma) {
                        echo ", &nbsp";
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
    </tr>


    <?php endforeach; ?>

</table>
<style> 
    table {
        width: 100%;
        border: 1px
            px
            solid #fff;
        background-color: #fff;
        clear: both;
        border: 1px solid #ddd;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;

        display: table;
        border-collapse: separate;
        box-sizing: border-box;
        text-indent: initial;

        font: 13px "Lucida Grande", Arial, sans-serif;
        background-color: #eee;
        line-height: 1.5;
    }
</style>