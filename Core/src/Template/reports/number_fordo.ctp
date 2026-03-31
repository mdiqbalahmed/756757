<style>
    .infoNameFordo {
        width: 99px;
        padding: 0;
        margin: 0;
        font-size: 14px;
        line-height: 20px;
        color: #000;
        display: inline-block;
        color: #000;
        border-bottom: 1px dotted #000;
        margin-right: 34px;
        text-align:center;font-style:italic
    }
    .sign-teacher,.sign-head{
        width:222px;
        float:left;
        font-size: 16px;
        line-height: 22px;
        margin-left:2px;
        /*    border-top: 1px dashed #000000;*/
        display: block;
        font-weight: normal;
        text-align: center;
        font-family: 'libre-baskerville';
        color: #000;
    }
</style>
        <?php 
        
        use Cake\Core\Configure;
$instituteName = Configure::read('Result.instituteName');
        
        if (empty($students)) { ?>
<center style="margin-top:50px; font-weight:bold; font-size:1.2em"></center>

            <?php } else { ?> 
<div style ="text-align: center;">
    <div >
        <div><?php echo $instituteName;
                                ?></div>
        <p style="margin-top: -45px;"><b><?php echo $students[0]['term_name']; ?></b></p>
        <p ><b>Number Fordo</b></p>
    </div>

    <div style ="text-align: center;">
        <span  style ="margin-right: 8px;">Class:</span> <span class="infoNameFordo"><?php echo $students[0]['class']; ?></span>
        <span >Section:</span> <span class="infoNameFordo"><?php echo $students[0]['section']; ?></span>
    </div>
    <div style ="text-align: center;">
        <span >Subject:</span> <span class="infoNameFordo">&nbsp;</span>
        <span >Total:</span> <span class="infoNameFordo">&nbsp;</span>
    </div>
</div>

  <?php echo $this->Form->create(); ?>

<table class="table table-bordered table-striped">

    <thead class="thead-dark">
        <tr>
            <th  width ="10%">Sid</th>
            <th  width ="30%">Name</th>
            <th  width ="10%">Roll</th>
            <th  width ="10%">Written</th>
            <th  width ="10%">MCQ</th>
            <th  width ="10%">SBA</th>
            <th  width ="10%">Practical</th>
            <th  width ="10%">Total</th>
        </tr>
    </thead>
    <tbody>
            <?php
            foreach ($students as $student) { //pr($student);die;?>
        <tr>

            <td><?php echo $student['sid'];  ?></td>
            <td><?php echo $student['name']; ?></td>
            <td><?php echo $student['roll'];  ?></td>
            <td> &nbsp; </td>
            <td> &nbsp; </td>
            <td> &nbsp; </td>
            <td> &nbsp; </td>
            <td> &nbsp; </td>
        </tr>
                    <?php } ?>

    </tbody>
</table>
            <?php echo $this->Form->end(); ?>

<div class="sign-teacher" style="margin-top:60px">
    Signature (Class Teacher)
</div>
    <?php } ?>
    
