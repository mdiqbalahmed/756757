<!DOCTYPE html>
<html>

<head>
	<title>Group Statistics</title>
</head>
<style>

</style>

<body>
	<table id="statistics-table" class="table table-bordered" border="1">
		<thead class="stat-head">
			<tr>
				<th rowspan="2">Title of the Class</th>
				<th rowspan="2">Shift</th>
				<th rowspan="2">Section</th>
				<th colspan="3">Group</th>
			</tr>
			<tr class="stat-lvl-2">
				<th>Science</th>
				<th>Humanities</th>
				<th>Commerce</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($studentCounts as $class => $classData) {
				foreach ($classData as $shift => $sections) {
					foreach ($sections as $section => $sectionData) { ?>
						<tr>
							<td><?= $class ?></td>
							<td><?= $shift ?></td>
							<td><?= $section ?></td>
							<td><?= (isset($sectionData['group']['Science']) ? $sectionData['group']['Science'] :  '') ?></td>
							<td><?= (isset($sectionData['group']['Arts']) ? $sectionData['group']['Arts'] :  '') ?></td>
							<td><?= (isset($sectionData['group']['Commerce']) ? $sectionData['group']['Commerce'] : '') ?></td>

						</tr>
			<?php }
				}
			} ?>
		</tbody>
	</table>

</body>

</html>