<?php
$img = 'Git_SCMS/uploads/certificate_image/' . $types['config_image'];

$transformedArray = [];
foreach ($values as $key => $subArray) {
    if (is_array($subArray) && isset($subArray['value'])) {
        $transformedArray[$key] = $subArray['value'];
    } else {
        $transformedArray[$key] = $subArray;
    }
}
$printValues = $transformedArray;
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Birthstone&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Charm:wght@400;700&display=swap');
    @import url('https://db.onlinewebfonts.com/c/9722ed7625833c0eec7f4d8979faf175?family=Shelley+Volante+BT+V1');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .certificate_body>span {
        font-family: "Shelley Volante BT V1", sans-serif;
        font-size: 26px;
        font-weight: 700;
        text-transform: capitalize;
        display: inline-block;
        border-bottom: 1px dotted;
        line-height: 18px;
        text-align: center;
    }

    .main_body>span {
        /*font-family: "Shelley Volante BT V1", sans-serif;*/
        font-family: "Times New Roman", Times, serif;
        font-style: italic;
        font-size: 20px;
        font-weight: 400;
        text-transform: capitalize;
        display: inline-block;
        border-bottom: 1px dotted;
        line-height: 18px;
        /*text-align: center;*/
    }

    .certificate_office_body>span {
        font-family: "Shelley Volante BT V1", sans-serif;
        font-size: 14pt;
        font-weight: 700;
        text-transform: capitalize;
    }

    .certificate_body {
        line-height: 180%;
        font-family: 'Charm', cursive;
        font-size: 18px;
        font-weight: 500;
        position: relative;
    }

    .main_body {
        /*margin-left: -86px;*/
        line-height: 180%;
        font-family: 'Charm', cursive;
        font-size: 18px;
        font-weight: 500;
        margin-top: 1rem;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .certificate_body_text {
        line-height: 150%;
        font-family: 'PT Sans Narrow', sans-serif !important;
        font-size: 15px;
        font-weight: 600;
    }

    .certificate_container {
        position: relative;
    }

    .certificate_inner_body {
        position: absolute;
        top: 25%;
        left: 10%;
        right: 10%;
    }

    .RctBtnWrap {
        position: fixed;
        top: 1.5em;
        right: 1.5em;
        z-index: 999;
    }

    .office_outer {
        padding-left: 2em;
        display: flex;
        justify-content: flex-end;
    }

    .office_outer img {
        width: 358px;
        height: 760px;
    }

    .office_inner {
        left: 20%;
        right: 12%;
    }

    .office_btex {
        font-size: 10pt !important;
    }

    .certificate_outer_body img {
        height: 760px;
    }

    @media print {
        #content {
            margin-top: 0 !important;
        }
    }
</style>

<div class="RctBtnWrap text-right">
    <button class="btn btn-danger no_print" onclick="window.print()">Print Certificate</button>
</div>
<div class="row">


    <!-- Side Cut Area -->
    <div class="col-md-4">
        <div class="certificate_container" id="certificate_area">
            <div class="certificate_outer_body office_outer">
                <?php echo $this->Html->image('/webroot/uploads/certificate_image/' . $types['office_copy_image']); ?>
            </div>
            <div class="row certificate_inner_body office_inner">
                <div class="col-md-6 text-left certificate_body_text office_btex mt-5">
                    <?php
                    $l_head = $types['office_left_head'];
                    $l_head = preg_replace('/\[[^\]]*\]/', '', $l_head);
                    $result = str_replace(array_keys($printValues), array_values($printValues), $l_head);
                    echo $result;
                    ?>
                </div>
                <div class="col-md-6 text-right certificate_body_text office_btex mt-5">
                    <?php
                    $tag_values_id = $tag_values[0]->tag_values_id;
                    $year = date('Y');
                    $formatted_id = str_pad($tag_values_id, 3, '0', STR_PAD_LEFT);
                    $sl = $year . $formatted_id;
                    echo "<strong>Sl No: {$sl}</strong>";
                    ?>
                </div>
                <div class="col-md-12 text-justify office_btex">
                    <?php
                    $main = $types['office_main_content'];
                    $main = preg_replace('/\[[^\]]*\]/', '', $main);
                    $result = str_replace(array_keys($printValues), array_values($printValues), $main);
                    echo $result;
                    ?>
                </div>
                <div class="col-md-6 text-left certificate_body_text office_btex">
                    <?php
                    $left_footer = $types['office_left_footer'];
                    $left_footer = preg_replace('/\[[^\]]*\]/', '', $left_footer);
                    $result = str_replace(array_keys($printValues), array_values($printValues), $left_footer);
                    echo $result;
                    ?>
                </div>
                <div class="col-md-6 text-right certificate_body_text office_btex">
                    <?php
                    $right_footer = $types['office_right_footer'];
                    $right_footer = preg_replace('/\[[^\]]*\]/', '', $right_footer);
                    $result = str_replace(array_keys($printValues), array_values($printValues), $right_footer);
                    echo $result;
                    ?>
                </div>
            </div>
        </div>
    </div>


    <!-- Main Certificate Area -->
    <div class="col-md-8">
        <div class="certificate_container" id="certificate_area">
            <div class="certificate_outer_body">
                <?php echo $this->Html->image('/webroot/uploads/certificate_image/' . $types['config_image']); ?>
            </div>
            <div class="row certificate_inner_body">
                <div class="col-md-6 text-left certificate_body_text mt-5">
                    <?php
                    $l_head = $types['left_head'];
                    $l_head = preg_replace('/\[[^\]]*\]/', '', $l_head);
                    $result = str_replace(array_keys($printValues), array_values($printValues), $l_head);
                    echo $result;
                    ?>
                </div>
                <div class="col-md-6 text-right certificate_body_text mt-5">
                    <?php
                    $tag_values_id = $tag_values[0]->tag_values_id;
                    $year = date('Y');
                    $formatted_id = str_pad($tag_values_id, 3, '0', STR_PAD_LEFT);
                    $sl = $year . $formatted_id;
                    echo "<strong>Sl No: {$sl}</strong>";
                    ?>
                </div>
                <div class="col-md-12 text-justify main_body">
                    <?php
                    $main = $types['main_content'];
                    $main = preg_replace('/\[[^\]]*\]/', '', $main);
                    $result = str_replace(array_keys($printValues), array_values($printValues), $main);
                    echo $result;
                    ?>
                </div>
                <div class="col-md-6 text-left certificate_body_text">
                    <?php
                    $left_footer = $types['left_footer'];
                    $left_footer = preg_replace('/\[[^\]]*\]/', '', $left_footer);
                    $result = str_replace(array_keys($printValues), array_values($printValues), $left_footer);
                    echo $result;
                    ?>
                </div>
                <div class="col-md-6 text-right certificate_body_text">
                    <?php
                    $right_footer = $types['right_footer'];
                    $right_footer = preg_replace('/\[[^\]]*\]/', '', $right_footer);
                    $result = str_replace(array_keys($printValues), array_values($printValues), $right_footer);
                    echo $result;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
