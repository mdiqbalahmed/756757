<!DOCTYPE html>
<html>

<head>
	<title>Group Statistics</title>
</head>

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
				<th>Business Studies</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($studentCounts as $class => $classData): ?>
				<?php foreach ($classData as $shift => $sections): ?>
					<?php foreach ($sections as $section => $sectionData): ?>

						<?php if (!empty($sectionData['section_total'])): ?>
							<tr>
								<td><?= $class ?></td>
								<td><?= $shift ?></td>
								<td><?= $section ?></td>

								<td><?= $sectionData['group']['SCIENCE'] ?? 0 ?></td>
								<td><?= $sectionData['group']['HUMANITIES'] ?? 0 ?></td>
								<td><?= $sectionData['group']['BUSINESS STUDIES'] ?? 0 ?></td>
							</tr>
						<?php endif; ?>

					<?php endforeach; ?>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="text-right">
		<button onclick="closePopup()" class="btn btn-danger">Close</button>
	</div>

</body>
</html>
