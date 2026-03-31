<style>
    .result_table td {
        text-align: center;
    }

    .result_table td a {
        font-size: smaller;
    }
</style>

<div class="table-responsive-sm">
    <table class="table ">
        <thead class="thead-custom">
            <tr>
                <th>Session</th>
                <th>Class</th>
                <th>List of Results</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="result_table">
            <?php
            foreach ($result_students as $result_student) {
            ?>
                <tr>
                    <td><?php echo $result_student['session_name'] ?></td>
                    <td><?php echo $result_student['level_name'] ?></td>
                    <td><?php echo $result_student['term_name'] ?></td>
                    <td>
                        <?php echo $this->Html->link('View Result', ['action' => 'viewResult', $result_student['result_id']], ['class' => 'btn action-btn btn-success', 'target' => '_blank']) ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
