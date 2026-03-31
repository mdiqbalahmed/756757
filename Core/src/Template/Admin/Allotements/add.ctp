<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<div class="round_box">
    <div style="float: left">
        <?php $i = 0; ?>
        <?php $p = 0; ?>
        <div class="blockWrapper">
            <div class="rollwraper">
                <div id="drag" class="drag">
                    <h2>Non Resident Student(s) List</h2>
                    <table class="tblroll">
                        <tr>
                            <th style="width:11.5%"> Sl No</th>
                            <th style="width:18%">Student Id</th>
                            <th style="width:47%">Name</th>
                        </tr>
                    </table>
                    <table class="tblroll" id="stdsort">

                        <thead>
                            <tr>
                                <th> <input type="text" style="width:45px" placeholder="Sl No"></th>
                                <th> <input type="text" style="width:80px" placeholder="Student Id"></th>
                                <th><input type="text" style="width:200px" placeholder="Name"></th>
                            </tr>
                        </thead>


                        <?php
                        $i = 1;
                        foreach ($stdInfos as $student) {
                        ?>
                            <tr class="oddset" id="drag<?php echo $student['id']; ?>">
                                <td class="tdset1" id="tdset1"><?php echo $i ?></td>
                                <td class="tdset1" id="tdset1"><?php echo $student['sid'] ?></td>
                                <td class="tdset2" style="text-align:left" id="tdset2"><?php echo $student['name']; ?></td>

                            </tr>
                        <?php
                            $i++;
                        }
                        ?>

                    </table>
                </div><!-- end of drag-->

            </div><!-- end of rollwraper-->
        </div><!-- end of blockWrapper-->
    </div>
    <?php echo $this->Html->image('/img/exchange-icone.jpg', array('style' => 'position:fixed; margin:55px')); ?>
    <div id="room" style="float: right;">
        <div class="blockWrapper">
            <div class="rollwraper">

                <?php $i = 0; ?>
                <?php $p = 1; ?>

                <div id="drop" class="drop">
                    <h2>Room wise Seat Status</h2>
                    <table>
                        <tr>
                            <th class="tdset1" style="width:15%" id="tdset1">Sl No</th>
                            <th class="tdset1" style="width:40%" id="tdset1">Building Name</th>
                            <th class="tdset1" style="width:15%" id="tdset1">Room No</th>
                            <th class="tdset1" style="width:15%" id="tdset1">Seat</th>
                            <th class="tdset1" style="width:15%" id="tdset1">Extra</th>
                        </tr>
                    </table>
                    <table class="tblroll" id="dropSort">
                        <thead>
                            <tr>
                                <th> <input type="text" style="width:45px" placeholder="Sl No"></th>
                                <th> <input type="text" style="width:200px" placeholder="Building Name"></th>
                                <th><input type="text" style="width:45px" placeholder="Room No"></th>
                                <th><input type="text" style="width:45px" placeholder="Seat"></th>
                                <th><input type="text" style="width:45px" placeholder="Extra"></th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($validRoomInfos as $validRoomInfo) {
                            //pr($validRoomInfo);
                        ?>
                            <tr class="oddset" id="drop<?php echo $validRoomInfo['id'] ?>">
                                <td class="tdset1" id="tdset1"><?php echo $p ?></td>
                                <td class="tdset2" id="tdset2"><?php echo $validRoomInfo['building_name']; ?></td>
                                <td class="tdset2" id="tdset2"><?php echo $validRoomInfo['room_number']; ?></td>
                                <td class="tdset2" id="tdset2"><p style="margin-top: 0px;margin-bottom: 0rem;"><?php echo $validRoomInfo['seat'] - $validRoomInfo['status']; ?></p></td>
                                <td class="tdset2" id="tdset2"><span><?php echo $validRoomInfo['extra']; ?></span></td>
                            </tr>
                        <?php
                            $p++;
                        }
                        //die;
                        ?>
                    </table>
                </div><!-- end of drop-->

            </div><!-- end of rollwraper-->
            <div class="clear_both">&nbsp;</div>
            <div class="leftTop btmPrintwrapper">
            </div><!-- end of leftTop-->
        </div><!-- end of blockWrapper-->
    </div>
    <div style="clear:both"></div>
</div>
<style>
    .tblroll {
        width: 100%;
        padding: 0;
        margin: 0;
        border-collapse: collapse;
        border-spacing: 0;
        text-align: center;
    }

    .tblroll tr,
    .left_wrapper .tblroll tr th {
        border-bottom: 1px solid #c0c7c9;
    }

    .left_wrapper .tblroll tr {
        border-bottom: 0;
    }

    .tblroll tr th,
    .tblroll tr td {
        line-height: 18px;
        font-size: 12px;
        color: #4e5446;
    }

    .left_wrapper .tblroll tr th,
    .left_wrapper .tblroll tr td {
        line-height: 18px;
        font-size: 15px;
        font-family: 'MyriadProLightRegular';
        overflow: hidden;
    }

    .left_wrapper .tblroll tr:nth-child(even) td {
        background: #e9eaea
    }

    .left_wrapper .tblroll tr:hover td {
        background: #A3D2FB
    }

    .tblroll tr th {
        line-height: 18px;
        font-size: 14px;
        color: #161513;
        padding-top: 5px;
        background-color: #d9dbdc;
        background: -moz-linear-gradient(top, #d9dbdc, #dddddd);
        background: -webkit-gradient(linear, left top, left bottom, from(#d9dbdc), to(#dddddd));
        background: -o-linear-gradient(left top, #d9dbdc, #dddddd);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#d9dbdc', EndColorStr='#dddddd');
        -moz-border-radius: 8px 0 0 0;
        -webkit-border-radius: 8px 0 0 0;
        -o-border-radius: 8px 0 0 0;
        border-radius: 8px 0 0 0;
        border-right: 2px solid #d2d6d7;
        font-family: "Myriad Pro", Arial, Helvetica, sans-serif;
    }

    .attendenceWrapper .left_wrapper .tblroll th.tdset3 {
        -moz-border-radius: 0 0px 0 0;
        -webkit-border-radius: 0 0px 0 0;
        -o-border-radius: 0 0px 0 0;
        border-radius: 0 0px 0 0;
    }

    .left_wrapper .tblroll tr th {
        background-color: #e7e7e7;
        background: -moz-linear-gradient(top, #e7e7e7, #c0c7c9);
        background: -webkit-gradient(linear, left top, left bottom, from(#e7e7e7), to(#c0c7c9));
        background: -o-linear-gradient(left top, #e7e7e7, #c0c7c9);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#e7e7e7', EndColorStr='#c0c7c9');
        border-bottom: 1px solid #969696;
        border-right: 1px solid #969696;
        vertical-align: middle;
    }

    .left_wrapper .tblroll tr th:last-child {
        border-right: none
    }

    .left_wrapper .tblroll tr th.chidlast {
        border-right: none
    }

    .tblroll .tdset1 {
        /*width:22%;*/
        border-right: 2px solid #d2d6d7;
    }

    .tblroll .tdset2 {
        width: 78%;
        text-align: left;
        padding: 0 0 0 6px;
    }

    .attendenceWrapper .tblroll .tdset1 {
        width: 50%;
    }

    .attendenceWrapper .tblroll .tdset2 {
        width: 50%;
        text-align: center
    }

    .tblroll th.tdset2,
    .left_wrapper .tblroll tr th:last-child,
    .left_wrapper .tblroll tr th.tdset4 {
        -moz-border-radius: 0 8px 0 0;
        -webkit-border-radius: 0 8px 0 0;
        -o-border-radius: 0 8px 0 0;
        border-radius: 0 8px 0 0;
        border-right: 0;
    }

    .attendenceWrapper .left_wrapper .tblroll .tdset1,
    .attendenceWrapper .left_wrapper .tblroll .tdset3,
    .attendenceWrapper .left_wrapper .tblroll .tdset4 {
        width: 25%;
    }

    .attendenceWrapper .left_wrapper .tblroll .tdset2 {
        width: 50%;
        text-align: left;
        -moz-border-radius: 0 0px 0 0;
        -webkit-border-radius: 0 0px 0 0;
        -o-border-radius: 0 0px 0 0;
        border-radius: 0 0px 0 0;
    }

    #tdset1 {
        width: 12%
    }

    #tdset2 {
        width: 40%
    }

    #tdset3 {
        width: 5%
    }

    #tdset4 {
        width: 10%
    }

    #tdset5 {
        width: 10%
    }

    #tdset6 {
        width: 5%
    }

    #tdset7 {
        width: 10%
    }


    .attendenceWrapper .left_wrapper .tblroll tr.oddset {
        background: #f3f3f3
    }

    .attendenceWrapper .left_wrapper .tblroll tr.oddset td {
        color: #1a1a1a
    }

    .attendenceWrapper .left_wrapper .tblroll tr td {
        border-right: 1px dotted #e1e1e1
    }

    .attendenceWrapper .left_wrapper .tblroll tr td.tdset4 {
        border-right: none
    }

    .tblroll tr:last-child {
        border-bottom: none
    }

    .tblroll tr.chidFirst {
        background: #d8fbaf
    }

    .tblroll tr.chid2nd {
        background: #9ae048
    }

    .sxaks {
        width: 13px;
        height: 13px;
        background: #000
    }

    img.ajx-loading {
        display: none
    }

    .infofoset img.ajx-loading {
        position: absolute;
        top: 5px;
        right: -20px
    }

    .drag {
        cursor: pointer;
    }

    #stdsort_length {
        display: none;
    }

    #stdsort_filter {
        display: none;
    }

    #dropSort_filter {
        display: none;
    }

    #dropSort_length {
        display: none;
    }

    #stdsort_paginate {
        display: none;
    }

    #dropSort_paginate {
        display: none;
    }

    #stdsort_info {
        display: none;
    }

    #dropSort_info {
        display: none;
    }

    #reportSort_length {
        display: none;
    }

    #reportSort_filter {
        display: none;
    }

    #reportSort_paginate {
        display: none;
    }

    #reportSort_info {
        display: none;
    }

    .viewtd td {
        text-align: left !important;
        vertical-align: top;
    }

    table {
        width: 100%;
        border: 1px solid #fff;
        background-color: #F1EBF9;
        clear: both;
        border: 1px solid #ddd;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
    }

    table tr th {
        padding: 3px;
        background: #e5e5e5;
        color: #333;
        border-bottom: 0px;
        text-align: center;
        font-weight: bold;
    }

    table tr th a {
        color: #333;
        text-decoration: none;
    }

    table tr th a:hover {
        color: #333;
        text-decoration: underline;
    }

    table tr td {
        padding: 5px 10px;
        border-bottom: 1px solid #dfdfdf;
        vertical-align: middle;
        text-align: center
    }

    table tr td a {
        font-weight: normal;
        text-decoration: none;
        padding: 0px 5px 0px 0px;
    }

    table tr td a:hover {
        text-decoration: underline;
    }

    table tr td div.operations a {
        font-size: 12px;
        margin-right: 15px;
        text-decoration: none;
        text-transform: lowercase;
    }

    table tr td img {
        margin: 0px;
        padding: 0px;
        height: 30px
    }

    .striped {
        background-color: #f4f7fe;
    }
</style>
<!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
<script>
    $(function() {
        $("#drag tr").draggable();
        //var stdInfo =  alert($(this).attr('id'));

        $("#drop tr").droppable({
            drop: function(event, ui) {
                var stdId = (ui.draggable).attr("id");
                var roomId = $(this).attr('id');
                // console.log(stdId);
                // console.log(roomId);
                // alert(stdId);
                $.ajax({
                    url: 'add/getRoomAjax',
                    cache: false,
                    type: 'GET',
                    dataType: 'HTML',
                    data: {
                        "sid": stdId,
                        "room": roomId
                    },
                    success: function(data) {
                        console.log(data);
                        var dt = data;
                        var roomSt = dt.split("#");
                        //var roomSt =  dt.find('#').remove();
                        if (roomSt[2] == 0) {
                            $("#drop" + roomSt[1])
                                .css({
                                    'background-color': 'green'
                                }).animate({
                                    'background-color': '#ffffff'
                                }, 3000);
                            $("#drop" + roomSt[1]).find('p').html(roomSt[0]);
                        } else if (roomSt[2] == 1) {
                            $("#drop" + roomSt[1])
                                .css({
                                    'background-color': 'green'
                                }).animate({
                                    'background-color': '#ffffff'
                                }, 3000);
                            $("#drop" + roomSt[1]).find('span').html(roomSt[0]);
                        }
                    }

                });
                ui.draggable.remove();
            }

        });
    });

    $(document).ready(function() {
        // console.log(hello);
        // var table = $('#stdsort').DataTable();
        var table = $('#stdsort').DataTable({
            paging: false
        });

        // console.log(table);
        // alert('here');
        // Apply the search
        table.columns().every(function() {
            var that = this;

            $('input', this.header()).on('keyup change', function() {
                // alert(this.value);
                that.search(this.value)
                    .draw();
            });
        });
    });

    $(document).ready(function() {
        // var tabl = $('#dropSort').DataTable();
        // paging: false
        var table = $('#dropSort').DataTable({
            paging: false
        });
        //alert('here');
        // Apply the search
        table.columns().every(function() {
            var that = this;
            $('input', this.header()).on('keyup change', function() {
                // alert(this.value);
                that.search(this.value)
                    .draw();
            });
        });
    });
</script>