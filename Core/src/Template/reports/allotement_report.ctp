<style>
    .roomHeader {
        padding-left: 20px;
        font-size: 1.2em;
        background-color: #DCD4D4;
        line-height: 2.5em;
        margin: 20px;
        clear: both;
        margin-bottom: 0px;
    }

    .reportRoom div {
        border: 1px solid #8DAD50;
        width: 160px;
        height: 38px;
        padding: 8px 12px;
        margin: 10px 20px;
        background-color: #D1F983;
        float: left;
        text-align: center;
    }
</style>

<div class="formWrapper">
    <div class="parentwrapper">
        <div class="reportRoom">
            <?php
            if (empty($get_rooms)) { ?>
                <center style="margin-top:50px; font-weight:bold; font-size:1.2em">Please search above.</center>
                <?php } else {
                $displayedBuildings = [];
                foreach ($get_rooms as $buildingInfo) :
                    // echo '<pre>';
                    // print_r($buildingInfo);die;
                    $extraTotal = array();

                    foreach ($buildingInfo['Room'] as $roomName => $roomData) {
                        $extraTotal[$roomName] = 0;
                        foreach ($roomData as $room) {
                            // print_r($array['Room']);
                            $extraTotal[$roomName] += intval($room['extra']);
                        }
                    }
                endforeach;
                foreach ($buildingInfo['Room'] as $roomNumber => $roomData) {
                    if (!in_array($roomData[0]['building_name'], $displayedBuildings)) {
                        array_push($displayedBuildings, $roomData[0]['building_name']);
                ?>
                        <h3 class="roomHeader"><?php echo $roomData[0]['building_name'] ?></h3>
                        <?php
                    }
                    $displayedRooms = [];
                    foreach ($roomData as $student) {

                        if (!in_array($roomNumber, $displayedRooms)) {
                            array_push($displayedRooms, $roomNumber);
                        ?>
                            <div <?php if ($student['seat'] == $student['status']) echo 'style="background-color:#FDE8E1; border:1px solid #ECBEAE;"';
                                    else if (!isset($extraTotal[$roomNumber])) echo 'style="background-color:green"'; ?>>
                                <?php
                                if (isset($extraTotal[$roomNumber])) {
                                    echo $roomNumber . ' - ' . $student['status'] . ' / ' . $student['seat'] . '  E-' . $extraTotal[$roomNumber];
                                } else {
                                    echo $roomNumber . ' - ' . $student['status'] . ' / ' . $student['seat'];
                                }
                                ?>
                            </div>

            <?php
                        }
                    }
                };
            }
            ?>
        </div>
    </div>
</div>