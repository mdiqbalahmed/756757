<?= $this->Form->unlockField('search_year_month'); ?>
<style>
    .spinner {
        border: 8px solid #f3f3f3;
        /* Light grey */
        border-top: 8px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>



<!-- Varient TOP Starts -->
<div class="row">
    <div id="detailsModal" class="modal"
        style="display:none; position:fixed; top:15%; left:20%; width:70%; height:70%; background:#fff; border:1px solid #ccc; padding:20px; overflow:auto; z-index:9999; position:fixed;">

        <div id="modalContent" style="padding-bottom: 50px;">
            <!-- AJAX-loaded content goes here -->
        </div>

        <!-- Close button at bottom right -->
        <button onclick="closePopup()" style="
        position: absolute;
        bottom: 20px;
        right: 20px;
        padding: 10px 20px;
        background: #333;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;">
            Close
        </button>
    </div>
</div>
<?php if (($filter_dashboards['Students Statistics'])) { ?>
    <div class="col-12">
        <div class="row">
            <div class="col-xl-3 mb-3">
                <div class="card db-card">
                    <div class="stat_title text-center">
                        <span>Students Statistics</span>
                    </div>
                    <div class="card-body dbc-body">
                        <canvas id="pie-chart" aria-level="chart" role="img"></canvas>
                    </div>
                    <div class="card-body text-center details-btn">
                        <a href="javascript:void(0);" onclick="openPopup()" class="btn btn-dark">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-3">
                <div class="card db-card">
                    <div class="stat_title text-center">
                        <span>Statistics by Religion</span>
                    </div>
                    <div class="card-body dbc-body">
                        <div class="chart-point">
                            <div class="check-point-area">
                                <canvas id="doughnut_chart1"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <a href="javascript:void(0);" onclick="openPopup1()" class="btn btn-dark">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-3">
                <div class="card db-card">
                    <div class="stat_title text-center">
                        <span>Statistics by Group</span>
                    </div>
                    <div class="card-body dbc-body">
                        <canvas id="polar_chart"></canvas>
                    </div>
                    <div class="card-body text-center">
                        <a href="javascript:void(0);" onclick="openPopup2()" class="btn btn-dark">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-3">
                <div class="card db-card">
                    <div class="stat_title text-center">
                        <span>Statistics by Quota</span>
                    </div>
                    <div class="card-body dbc-body">
                        <canvas id="pie-chart2" aria-level="chart" role="img"></canvas>
                    </div>
                    <div class="card-body text-center">
                        <a href="javascript:void(0);" onclick="openPopup3()" class="btn btn-dark">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (($filter_dashboards['Account Statistics'])) { ?>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-xl-3 mb-3">
                    <div class="card db-card">
                        <div class="stat_title text-center">
                            <span>Total Balance</span>
                        </div>
                        <div class="card-body dbc-body">
                            <canvas id="pie-chart3" aria-level="chart" role="img"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 mb-3">
                    <div class="card db-card">
                        <div class="stat_title text-center">
                            <span>Today's Billing Summary</span>
                        </div>
                        <div class="card-body dbc-body">
                            <canvas id="pie-chart5" aria-level="chart" role="img"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 mb-3">
                    <div class="card db-card">
                        <div class="stat_title text-center">
                            <span><?= date('F') ?>'s Billing Summary</span>
                        </div>
                        <div class="card-body dbc-body">
                            <canvas id="pie-chart6" aria-level="chart" role="img"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 mb-3">
                    <div class="card db-card">
                        <div class="stat_title text-center">
                            <span>Alltime Billing Summary</span>
                        </div>
                        <div class="card-body dbc-body">
                            <canvas id="pie-chart4" aria-level="chart" role="img"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php } ?>
<!-- Varient TOP Ends -->


<!-- Quick-Link Area Starts-->
<div class="row my-3">
    <?php if (($filter_dashboards['Accounts Report'])) { ?>
        <div class="col-md-<?= $col ?>" >
            <legend class="mt-3 dbc-card"> Accounts Report
                <div>
                    <canvas id="barChart_billing"></canvas>
                </div>
            </legend>
        </div>
    <?php } ?>
    <?php if (($filter_dashboards['Quick Links'])) { ?>
        <div class="col-md-<?= $col ?>" style="display:flex">
            <legend class="mt-3 dbc-card"> Quick Links
                <div class="row p-3">
                    <?php foreach ($buttons as $button) { ?>
                        <div class="col-md-3 my-2">
                            <button class="btn quicklinks"
                                style="background-color:<?= $button['button_color'] ?>; color:<?= $button['button_text_color'] ?>;">
                                <a href="<?= $button['button_link'] ?>"> <?= $button['button_title'] ?></a>
                            </button>
                        </div>
                    <?php } ?>
                </div>
            </legend>
        </div>
    <?php } ?>
</div>

<!-- Quick-Link Area Ends-->


<!-- Attendance Statistics Starts-->
<?php if (($filter_dashboards['Attendance Report'])) { ?>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-sm-12 mt-3">
            <div class="card db-card">
                <div class="card-header">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" data-target-canvas="canvas1" href="#">Attendance Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-target-canvas="canvas2" href="#">Daily Attendance</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body dbc-body">
                    <div class="canvas-container" id="canvas1">
                        <div class="text-right" id="dashboard-search">
                            <?php echo $this->Form->create(); ?>
                            <input name="search_year_month" id="search_month" type="month" value="<?= date('Y-m'); ?>">
                            <?php echo $this->Form->end(); ?>
                        </div>
                        <canvas class="full_height" id="lineChart"></canvas>
                    </div>
                    <div class="canvas-container" id="canvas2">
                        <canvas class="full_height" id="barChart"></canvas>
                    </div>
                </div>

            </div>
        </div>


    </div>
<?php } ?>
<!-- Attendance Statistics Start-->

<!-- < ?php $this->element('admin/stats'); ?> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    function openPopup() {
        $('#detailsModal').html(`
        <div style="display:flex; justify-content:center; align-items:center; height:100%;">
            <div class="spinner"></div>
        </div>
    `).fadeIn();
        $.ajax({
            url: 'admin/getTotalStudent',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            success: function (response) {
                $('#detailsModal').html(response).fadeIn();
            }
        });
    }


    function openPopup1() {
        $('#detailsModal').html(`
        <div style="display:flex; justify-content:center; align-items:center; height:100%;">
            <div class="spinner"></div>
        </div>
    `).fadeIn();
        $.ajax({
            url: 'admin/getReligions',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            success: function (response) {
                $('#detailsModal').html(response).fadeIn();
            }
        });
    }

    function openPopup2() {
        $('#detailsModal').html(`
        <div style="display:flex; justify-content:center; align-items:center; height:100%;">
            <div class="spinner"></div>
        </div>
    `).fadeIn();
        $.ajax({
            url: 'admin/getGroups',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            success: function (response) {
                $('#detailsModal').html(response).fadeIn();
            }
        });
    }

    function openPopup3() {
        $('#detailsModal').html(`
        <div style="display:flex; justify-content:center; align-items:center; height:100%;">
            <div class="spinner"></div>
        </div>
    `).fadeIn();
        $.ajax({
            url: 'admin/getQuata',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            success: function (response) {
                $('#detailsModal').html(response).fadeIn();
            }
        });
    }

    function closePopup() {
        document.getElementById('detailsModal').style.display = 'none';
    }

</script>

<script>
    <?php if (($filter_dashboards['Students Statistics'])) { ?>
        // TOP MOST 4 CHARTS SUMMARY
        let chart2;
        // Gender-Summary
        const genPie = document.getElementById('pie-chart');
        var genData = <?= $genderStats; ?>;
        var dataValues = Object.values(genData);
        var dataLabels = Object.keys(genData);

        // Combine labels with values
        var combinedLabels = dataLabels.map(function (label, index) {
            return `${label}: ${dataValues[index]}`;
        });

        new Chart(genPie, {
            type: 'pie',
            data: {
                defaultFontFamily: 'Poppins',
                datasets: [{
                    data: dataValues,
                    borderWidth: 2,
                }],
                labels: combinedLabels, // Use the combined labels
            },
            options: {
                plugins: {
                    legend: {
                        position: 'left',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10 // Adjust the font size as needed
                            }
                        }
                    }
                },
                maintainAspectRatio: false
            }
        });


        // Religion-Summary
        const relDonut = document.getElementById('doughnut_chart1');
        var relData = <?= $religionCounts; ?>;
        var dataValues = Object.values(relData);
        var dataLabels = Object.keys(relData);

        // Combine labels with values
        var combinedLabels = dataLabels.map(function (label, index) {
            return `${label}: ${dataValues[index]}`;
        });

        new Chart(relDonut, {
            type: 'doughnut',
            data: {
                defaultFontFamily: 'Poppins',
                datasets: [{
                    data: dataValues,
                    borderWidth: 2,
                }],
                labels: combinedLabels, // Use the combined labels
            },
            options: {
                plugins: {
                    legend: {
                        position: 'left',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10 // Adjust the font size as needed
                            }
                        }
                    }
                },
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return data.labels[tooltipItem.index]; // Display the combined label
                        }
                    }
                }
            }
        });




        // Group-Summary
        const grpPol = document.getElementById('polar_chart');
        var polData = <?= $groupCounts; ?>;
        var dataValues = Object.values(polData);
        var dataLabels = Object.keys(polData);

        // Combine labels with values
        var combinedLabels = dataLabels.map(function (label, index) {
            return `${label}: ${dataValues[index]}`;
        });

        new Chart(grpPol, {
            type: 'polarArea',
            data: {
                defaultFontFamily: 'Poppins',
                datasets: [{
                    data: dataValues,
                    borderWidth: 2,
                }],
                labels: combinedLabels, // Use the combined labels
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10 // Adjust the font size as needed
                            }
                        }
                    }
                },
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return data.labels[tooltipItem.index]; // Display the combined label
                        }
                    }
                }
            }
        });




        // Quota-Summary
        const quotPie = document.getElementById('pie-chart2');
        var quotData = <?= $quotaCounts; ?>;
        var dataValues = Object.values(quotData);
        var dataLabels = Object.keys(quotData);

        // Combine labels with values
        var combinedLabels = dataLabels.map(function (label, index) {
            return `${label}: ${dataValues[index]}`;
        });

        new Chart(quotPie, {
            type: 'pie',
            data: {
                defaultFontFamily: 'Poppins',
                datasets: [{
                    data: dataValues,
                    borderWidth: 2,
                }],
                labels: combinedLabels, // Use the combined labels
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10 // Adjust the font size as needed
                            }
                        }
                    }
                },
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return data.labels[tooltipItem.index]; // Display the combined label
                        }
                    }
                }
            }
        });
    <?php } ?>
</script>

<script>
    <?php if (($filter_dashboards['Account Statistics'])) { ?>
        // Balance Report
        const bankPie = document.getElementById('pie-chart3');
        var bankData = <?= $banks; ?>;
        var dataValues = Object.values(bankData);
        var dataLabels = Object.keys(bankData);

        // Combine labels with values
        var combinedLabels = dataLabels.map(function (label, index) {
            return `${label}: ${dataValues[index]}`;
        });

        new Chart(bankPie, {
            type: 'doughnut',
            data: {
                defaultFontFamily: 'Poppins',
                datasets: [{
                    data: dataValues,
                    borderWidth: 2,
                }],
                labels: combinedLabels, // Use the combined labels
            },
            options: {
                plugins: {
                    legend: {
                        position: 'left',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10 // Adjust the font size as needed
                            }
                        }
                    }
                },
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return data.labels[tooltipItem.index]; // Display the combined label
                        }
                    }
                }
            }
        });



        // Daily Billing Summary
        const dailyPie = document.getElementById('pie-chart5');
        var dailyData = <?= $dailyAmounts ?>;
        var dataValues = Object.values(dailyData);
        var dataLabels = Object.keys(dailyData);

        // Combine labels with values
        var combinedLabels = dataLabels.map(function (label, index) {
            return `${label}: ${dataValues[index]}`;
        });

        new Chart(dailyPie, {
            type: 'pie',
            data: {
                defaultFontFamily: 'Poppins',
                datasets: [{
                    data: dataValues,
                    borderWidth: 2,
                }],
                labels: combinedLabels, // Use the combined labels
            },
            options: {
                plugins: {
                    legend: {
                        position: 'left',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10 // Adjust the font size as needed
                            }
                        }
                    }
                },
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return data.labels[tooltipItem.index]; // Display the combined label
                        }
                    }
                }
            }
        });


        // Monthly Billing Summary
        const monthlyPie = document.getElementById('pie-chart6');
        var monthlyData = <?= $monthlyAmounts ?>;
        var dataValues = Object.values(monthlyData);
        var dataLabels = Object.keys(monthlyData);

        // Combine labels with values
        var combinedLabels = dataLabels.map(function (label, index) {
            return `${label}: ${dataValues[index]}`;
        });

        new Chart(monthlyPie, {
            type: 'doughnut',
            data: {
                defaultFontFamily: 'Poppins',
                datasets: [{
                    data: dataValues,
                    borderWidth: 2,
                }],
                labels: combinedLabels, // Use the combined labels
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10 // Adjust the font size as needed
                            }
                        }
                    }
                },
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return data.labels[tooltipItem.index]; // Display the combined label
                        }
                    }
                }
            }
        });

        /// Alltime Billing Summary
        const trnPie = document.getElementById('pie-chart4');
        var trnData = <?= $amounts ?>;
        var dataValues = Object.values(trnData);
        var dataLabels = Object.keys(trnData);

        // Combine labels with values
        var combinedLabels = dataLabels.map(function (label, index) {
            return `${label}: ${dataValues[index]}`;
        });

        new Chart(trnPie, {
            type: 'pie',
            data: {
                defaultFontFamily: 'Poppins',
                datasets: [{
                    data: dataValues,
                    borderWidth: 2,
                }],
                labels: combinedLabels, // Use the combined labels
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10 // Adjust the font size as needed
                            }
                        }
                    }
                },
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return data.labels[tooltipItem.index]; // Display the combined label
                        }
                    }
                }
            }
        });
    <?php } ?>
</script>
<script>
    // Accounts Class-wise
    <?php if (($filter_dashboards['Accounts Report'])) { ?>
        $(document).ready(function () {
            var ctx3 = document.getElementById('barChart_billing').getContext('2d');

            var totalBilled = <?= $totalBilled; ?>;
            var totalPaid = <?= $totalPaid; ?>;
            var totalDue = <?= $totalDue; ?>;

            var data = {
                labels: Object.keys(totalBilled),
                datasets: [{
                    label: 'Billed',
                    borderWidth: 2,
                    fill: true,
                    backgroundColor: '#cb28daff',
                    data: Object.values(totalBilled),
                },
                {
                    label: 'Paid',
                    borderWidth: 2,
                    fill: true,
                    backgroundColor: '#1bd443ff',
                    data: Object.values(totalPaid)
                },
                {
                    label: 'Due',
                    borderWidth: 2,
                    fill: true,
                    backgroundColor: '#cc1f1fff',
                    data: Object.values(totalDue)
                }
                ]
            };
            var options = {
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            };
            var chart1 = new Chart(ctx3, {
                type: 'bar',
                data: data,
                options: options
            });

        });
    <?php } ?>
</script>


<script>
    <?php if (($filter_dashboards['Attendance Report'])) { ?>
        // TAB SWITCHING and ATTENDANCE SCRIPT
        var ctx2 = document.getElementById('lineChart').getContext('2d');
        var myFunction = function (allDate, ctx2) {
            if (chart2) {
                chart2.destroy(); // Clear previous chart if it exists
            }
            chart2 = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: Object.keys(allDate),
                    datasets: [{
                        label: 'Monthly Attendance Report',
                        data: Object.values(allDate),
                        fill: true,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0
                    }]
                },
            });
            myFunction(allDate, ctx2);
        };

        $(document).ready(function () {
            $('.canvas-container:not(:first)').hide();
            $('.nav-link').on('click', function (e) {
                e.preventDefault();
                const targetCanvas = $(this).attr('data-target-canvas');
                $('.canvas-container').hide();
                $('#' + targetCanvas).show();

                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });

            var ctx1 = document.getElementById('barChart').getContext('2d');
            var ctx2 = document.getElementById('lineChart').getContext('2d');

            var clsWise = <?= $classWiseTotal; ?>;
            var clsPresent = <?= $presentPerClass; ?>;

            var data = {
                labels: Object.keys(clsWise),
                datasets: [{
                    label: 'Total',
                    borderWidth: 2,
                    fill: true,
                    backgroundColor: '#005069',
                    data: Object.values(clsWise),
                },
                {
                    label: 'Present',
                    borderWidth: 2,
                    fill: true,
                    backgroundColor: '#4f0036',
                    data: Object.values(clsPresent)
                }
                ]
            };
            var options = {
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            };
            var chart1 = new Chart(ctx1, {
                type: 'bar',
                data: data,
                options: options
            });


            var allDate = <?= $monthlyAttendance; ?>;
            var ctx2 = document.getElementById('lineChart').getContext('2d');
            chart2 = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: Object.keys(allDate),
                    datasets: [{
                        label: 'Total Present',
                        data: Object.values(allDate),
                        fill: true,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0
                    }]
                },
            });


            $("#search_month").change(function () {

                var search_month = $("#search_month").val();
                $.ajax({
                    url: 'admin/getSearchMonth',
                    cache: false,
                    type: 'GET',
                    dataType: 'HTML',
                    data: {
                        "search_month": search_month,
                    },
                    success: function (data) {

                        var ctx2 = document.getElementById('lineChart').getContext('2d');
                        var allDate = data;
                        if (chart2) {
                            chart2.destroy(); // Clear previous chart if it exists
                        }

                        var jsonObj = JSON.parse(allDate);
                        var datas = Object.values(jsonObj);
                        var labels = Object.keys(jsonObj);

                        chart2 = new Chart(ctx2, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Total Present',
                                    data: datas,
                                    fill: true,
                                    borderColor: 'rgb(75, 192, 192)',
                                    tension: 0
                                }]
                            },
                        });
                    }
                });
            });
        });
    <?php } ?>
</script>