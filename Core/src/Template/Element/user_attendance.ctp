<style>
    .present {
        background-color: lightgreen;
    }

    .absent {
        background-color: red;
    }

    .holiday {
        background-color: red;
    }

    .disabled {
        background-color: lightgray;
    }

    table {
        font-size: smaller;
    }

    #table-body-content td {
        border: 1px solid #71787e !important;
        vertical-align: middle !important;
    }

    thead.thead-custom th {
        border: 1.5px solid #2e353c !important;
        vertical-align: middle !important;
        text-align: center;
    }

    .thead-custom {
        background-color: lightskyblue;
    }

    .attendance_table {
        text-align: center;
        padding: 0 !important;
        width: 100px !important;
        vertical-align: middle;
    }

    thead.thead-custom tr th {
        width: 100px !important;
    }

    #search_year {
        padding: 0.5em;
        text-align: center;
        margin-bottom: 0.75em;
        border-radius: 10px;
        width: 100px;
        font-weight: 700;
    }

    .present_count {
        text-align: center;
        font-size: larger;
        font-weight: 700;
        color: darkred;
    }
</style>

<div class="w-100">
    <div class="text-right">
        <?= $this->Form->unlockField('search_year'); ?>
        <?= $this->Form->create(); ?>
        <select name="search_year" id="search_year">
            <?php
            $currentYear = date('Y');
            for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                echo '<option value="' . $year . '">' . $year . '</option>';
            }
            ?>
        </select>
        <?= $this->Form->end(); ?>
    </div>
    <table class="table table-sm table-bordered table-responsive " id="table-body">
        <thead class="thead-custom">
            <tr>
                <th>Month</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
                <th>11</th>
                <th>12</th>
                <th>13</th>
                <th>14</th>
                <th>15</th>
                <th>16</th>
                <th>17</th>
                <th>18</th>
                <th>19</th>
                <th>20</th>
                <th>21</th>
                <th>22</th>
                <th>23</th>
                <th>24</th>
                <th>25</th>
                <th>26</th>
                <th>27</th>
                <th>28</th>
                <th>29</th>
                <th>30</th>
                <th>31</th>
                <th>Total Present</th>
            </tr>
        </thead>
        <tbody id="table-body-content">
            <?php
            // Generate the HTML for the table
            $html = '';

            foreach ($groupedResults as $month => $results) {
                $html .= '<tr>';
                $html .= "<td>{$month}</td>";

                // Initialize the present count for the current month
                $presentCount = 0;

                foreach (range(1, 31) as $day) {
                    $status = '';

                    // Check if there is a record for the current day
                    foreach ($results as $result) {
                        if ((int)$result['date'] === $day) {
                            $status = $result['status'];
                            break;
                        }
                    }

                    // Count present days
                    if ($status === 'present') {
                        $presentCount++;
                    }
                    // Display attendance status
                    $html .= '<td class="attendance_table">' . ($status === 'present' ? 'P' : '.') . '</td>';
                }

                // Display the total present count for the month
                $html .= "<td class='present_count'>{$presentCount}</td>";
                $html .= '</tr>';
            }

            echo $html;
            ?>
        </tbody>
    </table>
</div>

<script>
    $("#search_year").change(function() {
        var search_year = $("#search_year").val();
        $.ajax({
            url: 'student_dashboard/getYearlyAttandanceAjax',
            type: 'GET',
            data: {
                "search_year": search_year
            },
            success: function(data) {
                const endIndex = data.indexOf('}]}'); // If '}]}' is found, extract the JSON substring up to that point

                if (endIndex !== -1) {
                    const jsonString = data.substring(0, endIndex + 3); // +3 to include '}]}' in the result
                    var groupedResults = JSON.parse(jsonString); // Assuming that the server-side action returns JSON

                    // Generate the HTML for the table
                    var html = '';

                    for (var month in groupedResults) {
                        html += '<tr>';
                        html += '<td>' + month + '</td>';

                        // Initialize the present count for the current month
                        var presentCount = 0;

                        for (var day = 1; day <= 31; day++) {
                            var status = '';

                            // Check if there is a record for the current day
                            for (var i = 0; i < groupedResults[month].length; i++) {
                                if (groupedResults[month][i]['date'] == day) {
                                    status = groupedResults[month][i]['status'];
                                    break;
                                }
                            }

                            // Count present days
                            if (status === 'present') {
                                presentCount++;
                            }
                            // Display attendance status
                            html += '<td class="attendance_table">' + (status === 'present' ? 'P' : '.') + '</td>';
                        }

                        // Display the total present count for the month
                        html += '<td class="present_count">' + presentCount + '</td>';
                        html += '</tr>';
                    }
                }
                // Append the generated HTML to the table body
                $('#table-body-content').html(html);
            }
        });
    });
</script>
