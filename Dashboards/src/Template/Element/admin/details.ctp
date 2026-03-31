<!DOCTYPE html>
<html>

<head>
	<title>Overall Statistics</title>
</head>

<body>
	<table id="statistics-table" class="table table-bordered" border="1">
		<thead class="stat-head">
			<tr>
				<th rowspan="2">Title of the Class</th>
				<th rowspan="2">Shift</th>
				<th rowspan="2">Section</th>
				<th colspan="4">Students</th>
				<th colspan="4">Religion</th>
				<th colspan="3">Group</th>
				<th colspan="4">Quota</th>
			</tr>
			<tr class="stat-lvl-2">
				<th>Male</th>
				<th>Female</th>
				<th>Section Total</th>
				<th>Class Total</th>
				<th>Islam</th>
				<th>Hindu</th>
				<th>Christian</th>
				<th>Other</th>
				<th>Science</th>
				<th>Arts</th>
				<th>Commerce</th>
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
							<td><?= (isset($sectionData['gender']['Male']) ? $sectionData['gender']['Male'] :  '') ?></td>
							<td><?= (isset($sectionData['gender']['Female']) ? $sectionData['gender']['Female'] :  '') ?></td>
							<td><?= $sectionData['section_total'] ?></td>
							<td><?= $sectionData['class_total'] ?></td>
							<td><?= (isset($sectionData['religion']['Islam']) ? $sectionData['religion']['Islam'] :  '') ?></td>
							<td><?= (isset($sectionData['religion']['Hindu']) ? $sectionData['religion']['Hindu'] :  '') ?></td>
							<td><?= (isset($sectionData['religion']['Christian']) ? $sectionData['religion']['Christian'] :  '') ?></td>
							<td><?= (isset($sectionData['religion']['Other']) ? $sectionData['religion']['Other'] :  '') ?></td>
							<td><?= (isset($sectionData['group']['Science']) ? $sectionData['group']['Science'] :  '') ?></td>
							<td><?= (isset($sectionData['group']['Arts']) ? $sectionData['group']['Arts'] :  '') ?></td>
							<td><?= (isset($sectionData['group']['Commerce']) ? $sectionData['group']['Commerce'] : '') ?></td>
							<td><?= (isset($sectionData['quota']['freedom_fighter']) ? $sectionData['quota']['freedom_fighter'] : null) ?></td>
							<td><?= (isset($sectionData['quota']['tribal']) ? $sectionData['quota']['tribal'] : null) ?></td>
							<td><?= (isset($sectionData['quota']['orphan']) ? $sectionData['quota']['orphan'] : null) ?></td>
							<td><?= (isset($sectionData['quota']['disabled']) ? $sectionData['quota']['disabled'] : null) ?></td>

						</tr>
			<?php }
				}
			} ?>
		</tbody>
	</table>

</body>

</html>