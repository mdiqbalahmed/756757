<?php

$this->Form->unlockField('roll');
?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
        <title>Student</title>
    </head>

    <body>
         <?php  if(!isset($stu)) {?>
        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Search Students') ?>
                </h3>
            </div>
        <?php  echo  $this->Form->create('', ['type' => 'file']); ?>
            <div class="form">
                <section class="bg-light mt-1 p-2 m-auto" action="#">
                    <fieldset>
                        <div class=" form_area p-2">
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Roll') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="roll" type="text" class="form-control" placeholder="ROLL" id="roll">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </fieldset>
                </section>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
            </div>
          <?php  echo $this->Form->end(); ?>
        </div>
         <?php } ?>



          <?php  if(isset($stu)) { ?>
        <!DOCTYPE html>
    <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Explora&display=swap');

                @page {
                    size: landscape;
                }


                body {
                    margin: 0 auto;

                    background-repeat: no-repeat;
                    background-position: center;
                    font-family: 'Times New Roman', Times, serif;
                    font-size: 16px;
                    padding: 20px;
                    border: 15px double #cbbe24d6;
                    width: 800px;

                }
                .pic{
                    display: flex;
                    flex-direction: row;
                    justify-content: flex-end;
                }
                .pic img {
                    vertical-align: middle;
                    /* border-style: none; */
                    height: 100%;
                    width: 125px;
                    margin-top: -92px;

                }
                span.info{
                    display: block;
                }
                tr>td:nth-child(1) {
                    width: 1em  !important;
                }
                tr>td:nth-child(2) {
                    width: 10em  !important;
                }
                .serial {
                    top: 100px;
                    left: 38px;
                    font-size: 23px!important;
                    transform: rotate(-30deg);
                    font-weight: 700;
                    font-style: italic;
                }
                .font{
                    font-weight: 700;
                }


                .student-info div {
                    flex: 1;
                }

                .subject-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                .nested-table {
                    width: 100%;
                    border-collapse: collapse;
                }
                .nested-table th {
                    border-bottom: none!important;
                    border-left: none!important;
                    text-align: center !important;
                    width: 50%;
                }
                .nested-table th:nth-child(2) {
                    border-bottom: none!important;
                    border-right: none!important;
                }

                .subject-table th,
                .subject-table td {
                    border: 1px solid #000;
                    text-align: center;
                }



                .footer {
                    text-align: left;
                    margin-top: 20px;
                    display: flex;
                    justify-content: flex-start;
                    /* Adjust alignment to top left */
                    flex-wrap: wrap;
                    /* Allow boxes to wrap to a new line if needed */
                }

                .footer-box {
                    flex: 1;
                    border: 1px solid #000;
                    padding-bottom: 4em;
                    padding-top: 5px;
                    padding-left: 5px;
                    /* Add some spacing below boxes */
                }

                .footer-box span {
                    font-weight: 600;
                }

                .signature {
                    text-align: center;
                    font-style: italic;
                }

                .title-area {
                    display: flex;
                    justify-content: center;
                }

                .title-design {
                    padding: 0.5em;
                    border: 4px double #000;
                    /* Outer border with light effect */
                }

                .student-table {
                    border-collapse: collapse;
                    width: 100%;

                }

                .student-table th,
                .student-table td {
                    border: 1px solid #ccc;
                    text-align: left;
                    font-size: 26px;

                }

                .student-table th {
                    width: 25%;
                }

                .grade-table {
                    font-size: 12px;
                }

                .grade-table th,
                .grade-table td {
                    text-align: center !important;
                    border: 1px solid #000;
                }

                .grade-table th {
                    max-width: 4em;
                }

                .grade-area {
                    display: flex;
                    justify-content: end;
                }


                .attendance-table{
                    font-size: 14px;
                }
                .attendance-table th, .attendance-table td{
                    text-align: center !important;
                    border: 1px solid #000;
                }

                .institute-logo img {
                    width: 100%;
                }

                .institute-title {
                    display: flex;
                    justify-content: center;
                }

                .institute-title img {
                    width: 55%;
                    margin-left : -6px;
                    /* letter-spacing: ; */
                }

                .top-line-1 {
                    text-align: center;
                    font-weight: 600;
                    color: #000;
                    display: block;
                    font-size: 21px;
                    margin-left : 9px;
                }

                .top-line-2 {
                    display: block;
                    text-decoration: underline;
                    font-weight: 600;
                    text-align: center;
                }
                td.position-section{
                    vertical-align: top!important;
                }
                .footer-box:nth-child(2), 
                .footer-box:nth-child(3){
                    border-right: none;
                }
                #signature > div:nth-child(2){
                    padding-left: 5em;
                }
                #signature > div:nth-child(3){
                    padding-left: 7.5em;
                }
                #signature > div:nth-child(4){
                    padding-left: 5em;
                }

            </style>

        </head>

        <body>
        <?php
        $defaultPath = '/students_tmp_design/images/default-' . (empty($stdInfos['Student']['gender']) || $stdInfos['Student']['gender'] == 'Female' ? 'girl' : 'boy') . '.png';
	    $thumbPath = trim($stu['thumbnail']);
	    $thumbPath = empty($thumbPath) ? $defaultPath : '/scms_packet/webroot/uploads/Temp_students/thumbnail/' . $thumbPath; //THUMBNAIL_LOCATION4
	    
            ?>


            <div class="institute-title"><img src="https://i.ibb.co/ydk2SpT/logo.png" alt=""></div>
            <span class="top-line-1">Student's Information Form</span>
        </div>

        <div class="pic">
            <img src="<?php echo $thumbPath; ?>" />
            <!--<img src="/scms_packet/webroot/uploads/Temp_students/thumbnail/1693897981_656427_th.jpg">-->
    <!--        <img  src="<?php echo '<a href="' . $thumbPath . '"><img src="' . $thumbPath . '" class="img" /></a>'; ?>">-->
        </div>
        <table class="table table-bordered">
            <tbody>
            <label class="serial"><?php //echo $stu['serial']; ?></label>
            <tr>
                <td>
                    1
                </td>
                <td>
                    Session
                </td>
                <td class="font">
                    <?php echo $stu['session']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    2
                </td>
                <td>
                    Class
                </td>
                <td class="font">
                        <?php echo $stu['level']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    3
                </td>
                <td>
                    Shift
                </td>
                <td class="font">
                    <?php echo $stu['shift']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    4
                </td>
                <td>
                    Section
                </td>
                <td class="font">
                    <?php //echo $stu['shift_name']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    5
                </td>
                <td>
                    Student's ID
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    6
                </td>
                <td>
                    Class Roll No
                </td>
                <td class="font">
                    <?php //echo $stu['roll']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    7
                </td>
                <td>
                    Student's Name
                </td>
                <td class="font">
                        <?php echo $stu['name']; ?>

                </td>
            </tr>
            <tr>
                <td>
                    8
                </td>
                <td>
                    Father's Information
                </td>

                <td>
                    <span class="info">
                        Name: <?php echo $stu['fname']; ?>
                    </span>
                    <span class="info">
                        NID: <?php echo $stu['f_nid']; ?>
                    </span>
                    <span class="info">
                        Profession: <?php echo $stu['foccupation']; ?>
                    </span>
<!--                    <span class="info">
                        Profession Type:
                    </span>-->
                    <span class="info">
                        Yearly Income: <?php echo $stu['fincome']; ?>
                    </span>

                </td>
            </tr>
            <tr>
                <td>
                    9
                </td>
                <td>
                    Mother's Information
                </td>

                <td>
                    <span class="info">
                        Name: <?php echo $stu['mname']; ?>
                    </span>
                    <span class="info">
                        NID: <?php echo $stu['m_nid']; ?>
                    </span>
                    <span class="info">
                        Profession: <?php echo $stu['moccupation']; ?>
                    </span>
<!--                    <span class="info">
                        Profession Type:
                    </span>-->
                    <span class="info">
                        Yearly Income: <?php echo $stu['mincome']; ?>
                    </span>

                </td>
            </tr>
            <tr>
                <td>
                    10
                </td>
                <td class="font">
                    Date Of Birth: 
                </td>
                <td>
                    <?php echo $stu['dob']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    11
                </td>
                <td class="font">
                    Birth Registration No: 
                </td>
                <td>
                    <?php echo $stu['birth_reg']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    12
                </td>
                <td>
                    Religion
                </td>
                <td class="font">
                        <?php echo $stu['religion']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    13
                </td>
                <td>
                    Gender
                </td>
                <td class="font">
                    <?php echo $stu['gender']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    14
                </td>
                <td>
                    Blood Group
                </td>
                <td class="font">
                    <?php //echo $stu['blood_group']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    15
                </td>
                <td>
                    Group
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    16
                </td>
                <td>
                    3rd Paper
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    17
                </td>
                <td>
                    4th Paper
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    18
                </td>
                <td>
                    Present Address
                </td>
                <td class="font">
                    <?php echo $stu['current_address']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    19
                </td>
                <td>
                    Permanent Address
                </td>
                <td class="font">
                    <?php echo $stu['permanent_address']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    20
                </td>
                <td>
                    Guardian's Phone No
                </td>
                <td class="font">
                    <?php echo $stu['mobile']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    21
                </td>
                <td>
                    Previous School
                </td>
                <td class="font">
                    <?php echo $stu['pre_school']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    22
                </td>
                <td>
                    Quota
                </td>
                <td class="font">
                    <?php echo $stu['quota']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    23
                </td>
                <td>
                    PEC/JDC Examination Info
                </td>
                <td>
                    <span class="info">
                        Roll No: <?php //echo $edu['exam_roll']; ?>
                    </span>
                    <span class="info">
                        Board: <?php //echo $edu['exam_board']; ?>
                    </span>
                    <span class="info">
                        Reg No: <?php //echo $edu['exam_reg']; ?>
                    </span>
                    <span class="info">
                        Year: <?php //echo $edu['passing_year']; ?>
                    </span>
                    <span class="info">
                        GPA: <?php //echo $edu['exam_gpa']; ?>
                    </span>

                </td>

            </tr>
            <tr>
                <td>
                    24
                </td>
                <td>
                    Scholarship
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    25
                </td>
                <td>
                    Stipend
                </td>
                <td>
                    Stipend ID
                </td>
            </tr>
            <tr>
                <td>
                    26
                </td>
                <td>
                    Status
                </td>
                <td class="font">
                    <?php if($stu['status'] == 1) { echo "Regular";} else {} ?>
                </td>
            </tr>

        </tbody>

    </table>

    <div class="row" id="signature">

    </div>



    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
<!--<div style="margin-top: 100px;color: red;">
    <a href="javascript:window.print();">প্রিন্ট করুন</a>
</div>-->