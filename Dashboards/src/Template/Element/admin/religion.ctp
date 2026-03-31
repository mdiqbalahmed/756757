<!DOCTYPE html>
<html>

<head>
	<title>Religion Statistics</title>
</head>
<table id="statistics-table" class="table table-bordered" border="1">
	<thead class="stat-head">
		<tr>
			<th rowspan="2">Title of the Class</th>
			<th rowspan="2">Shift</th>
			<th rowspan="2">Section</th>
			<th colspan="4">Religion</th>
		</tr>
		<tr class="stat-lvl-2">

			<th>Islam</th>
			<th>Hindu</th>
			<th>Christian</th>
			<th>Other</th>

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
						<td><?= (isset($sectionData['religion']['Islam']) ? $sectionData['religion']['Islam'] :  '') ?></td>
						<td><?= (isset($sectionData['religion']['Hindu']) ? $sectionData['religion']['Hindu'] :  '') ?></td>
						<td><?= (isset($sectionData['religion']['Christian']) ? $sectionData['religion']['Christian'] :  '') ?></td>
						<td><?= (isset($sectionData['religion']['Other']) ? $sectionData['religion']['Other'] :  '') ?></td>

					</tr>
		<?php }
			}
		} ?>
	</tbody>
</table>

</html>