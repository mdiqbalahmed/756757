<!DOCTYPE html>
<html>

<head>
	<title>Qouta Statistics</title>
</head>

<body>
	<table id="statistics-table" class="table table-bordered" border="1">
		<thead class="stat-head">
			<tr>
				<th rowspan="2">Title of the Class</th>
				<th rowspan="2">Shift</th>
				<th rowspan="2">Section</th>
				<th colspan="4">Quota</th>
			</tr>
			<tr class="stat-lvl-2">

				<th>Freedom Fighter</th>
				<th>tribal</th>
				<th>orphan</th>
				<th>disabled</th>
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
							<td><?= (isset($sectionData['quota']['freedom_fighter']) ? $sectionData['quota']['freedom_fighter'] : 0) ?></td>
							<td><?= (isset($sectionData['quota']['tribal']) ? $sectionData['quota']['tribal'] : 0) ?></td>
							<td><?= (isset($sectionData['quota']['orphan']) ? $sectionData['quota']['orphan'] : 0) ?></td>
							<td><?= (isset($sectionData['quota']['disabled']) ? $sectionData['quota']['disabled'] : 0) ?></td>

						</tr>
			<?php }
				}
			} ?>
		</tbody>
	</table>

</body>

</html>