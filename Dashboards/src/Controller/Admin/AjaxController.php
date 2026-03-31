<?php

namespace Croogo\Dashboards\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class AjaxController extends AppController
{

	public function initialize()
	{
		parent::initialize();
	}
	public function updateStatus()
	{
		$this->autoRender = false;
		$id = $_GET['id'];
		$status = $_GET['status'];
		$dashboards = TableRegistry::getTableLocator()->get('dashboards');
		$query = $dashboards->query();
		$query->update()
			->set(['status' => $status])
			->where(['id' => $id])
			->execute();
	}

	public function getSearchMonth()
	{
		$this->autoRender = false;
		$search_month = $_GET['search_month'];
		$firstDayOfMonth = $search_month . '-01';
		$lastDayOfMonth = date("Y-m-t", strtotime($search_month));

		$studentAttendanceTable = TableRegistry::getTableLocator()->get('scms_attendance');
		$query = $studentAttendanceTable->find();
		$query
			->select([
				'date',
				'count' => $query->func()->count('*')
			])
			->where([
				'date >=' => $firstDayOfMonth,
				'date <=' => $lastDayOfMonth
			])
			->group('date')
			->enableAutoFields(true)
			->enableHydration(false)
			->count();
		$results = $query->toArray();


		// Create an associative array to hold the results, initialized with zeros for all days of the month
		$attendanceData = [];
		$currentDate = strtotime($firstDayOfMonth);

		while ($currentDate <= strtotime($lastDayOfMonth)) {
			$dateString = date('Y-m-d', $currentDate);
			$attendanceData[$dateString] = 0;
			$currentDate = strtotime('+1 day', $currentDate);
		}


		// Fill in the actual attendance counts from the query results
		foreach ($results as $result) {
			$date = $result['date']->format('Y-m-d'); // Convert the DateTime object to a string in the desired format
			$count = $result['count'];

			// Update the attendance count for the corresponding date in the $attendanceData array
			if (isset($attendanceData[$date])) {
				$attendanceData[$date] = $count;
			}
		}
		// $monthlyAjaxAttendance = json_encode($attendanceData);
		echo json_encode($attendanceData);
		// $this->set('monthlyAjaxAttendance', $monthlyAjaxAttendance);
	}
	public function getTotalStudent()
	{
		$scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
		$levelTable = TableRegistry::getTableLocator()->get('scms_levels');
		$levels = $levelTable->find()->toArray();
		$shiftsTable = TableRegistry::getTableLocator()->get('hr_shift');
		$shifts = $shiftsTable->find()->toArray();
		$sectionsTable = TableRegistry::getTableLocator()->get('scms_sections');
		$sections = $sectionsTable->find()->toArray();
		$setting = TableRegistry::getTableLocator()->get('settings');
		// 		$settings = $setting
		// 			->find()
		// 			->where(['`key`' => 'Site.selectedSession'])
		// 			->toArray();
		// 		$settingsEleven = $setting
		// 			->find()
		// 			->where(['`key`' => 'Site.ElevenSession'])
		// 			->toArray();
		// 		$settingsTwelve = $setting
		// 			->find()
		// 			->where(['`key`' => 'Site.TwelveSession'])
		// 			->toArray();

		$settings1to10 = json_decode(
			($setting->find()->where(['`key`' => 'Site.selectedSession'])->first()['value']) ?? '[]',
			true
		);

		$settings11 = json_decode(
			($setting->find()->where(['`key`' => 'Site.ElevenSession'])->first()['value']) ?? '[]',
			true
		);

		$settings12 = json_decode(
			($setting->find()->where(['`key`' => 'Site.TwelveSession'])->first()['value']) ?? '[]',
			true
		);

		// 		$selectedSessionsArray = json_decode($settings[0]['value']);
		$selectedSessionsArray = array_merge(
			json_decode($settings[0]['value'] ?? '[]', true),
			json_decode($settingsEleven[0]['value'] ?? '[]', true),
			json_decode($settingsTwelve[0]['value'] ?? '[]', true)
		);

		$studentCounts = [];
		$basic['section_total'] = 0;
		$basic['gender']['Male'] = 0;
		$basic['gender']['Female'] = 0;
		$basic['religion']['Islam'] = 0;
		$basic['religion']['Hindu'] = 0;
		$basic['religion']['Christian'] = 0;
		$basic['religion']['Other'] = 0;
		$basic['quota']['freedom_fighter'] = 0;
		$basic['quota']['tribal'] = 0;
		$basic['quota']['orphan'] = 0;
		$basic['quota']['disabled'] = 0;
		$basic['group']['SCIENCE'] = 0;
		$basic['group']['HUMANITIES'] = 0;
		$basic['group']['BUSINESS STUDIES'] = 0;

		foreach ($levels as $level) {
			foreach ($shifts as $shift) {
				foreach ($sections as $section) {
					$studentCounts[$level->level_name]['class_total'] = 0;
					$studentCounts[$level->level_name][$shift->shift_name][$section->section_name] = $basic;
				}
			}
		}
		$students = $scms_student_cycle
			->find()
			->select([
				'group_name' => 'scms_groups.group_name',
				'gender' => 'scms_students.gender',
				'religion' => 'scms_students.religion',
				'freedom_fighter' => 'scms_students.freedom_fighter',
				'tribal' => 'scms_students.tribal',
				'orphan' => 'scms_students.orphan',
				'disabled' => 'scms_students.disabled',
				'level_name' => 'scms_levels.level_name',
				'section_name' => 'scms_sections.section_name',
				'shift_name' => 'hr_shift.shift_name'
			])
			->join([
				'scms_students' => [
					'table' => 'scms_students',
					'type' => 'LEFT',
					'conditions' => ['scms_students.student_id = scms_student_cycle.student_id'],
				],
				'scms_groups' => [
					'table' => 'scms_groups',
					'type' => 'LEFT',
					'conditions' => ['scms_groups.group_id = scms_student_cycle.group_id'],
				],
				'scms_levels' => [
					'table' => 'scms_levels',
					'type' => 'LEFT',
					'conditions' => ['scms_levels.level_id = scms_student_cycle.level_id'],
				],
				'scms_sections' => [
					'table' => 'scms_sections',
					'type' => 'LEFT',
					'conditions' => ['scms_sections.section_id = scms_student_cycle.section_id'],
				],
				'hr_shift ' => [
					'table' => 'hr_shift',
					'type' => 'LEFT',
					'conditions' => ['hr_shift.shift_id = scms_student_cycle.shift_id'],
				],
			])
			->where(['scms_students.status' => 1])
			// 			->where(['scms_student_cycle.session_id IN' => $selectedSessionsArray])
			->where(function ($exp, $q) use ($settings1to10) {

				return $exp->or_([

					// SCHOOL LEVELS → selectedSession
					[
						'scms_levels.level_id IN' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 14, 90, 91, 92],
						'scms_student_cycle.session_id IN' => $settings1to10
					],



				]);
			})

			->enableAutoFields(true)
			->enableHydration(false)
			->toArray();
		foreach ($students as $student) {
			$studentCounts[$student['level_name']]['class_total']++;
			$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['section_total']++;
			if ($student['gender'] == 'Male') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['gender']['Male']++;
			} else if ($student['gender'] == 'Female') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['gender']['Female']++;
			}
			if ($student['religion'] == 'Islam') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['religion']['Islam']++;
			} else if ($student['religion'] == 'Hindu') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['religion']['Hindu']++;
			} else if ($student['religion'] == 'Christian') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['religion']['Christian']++;
			} else {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['religion']['Other']++;
			}
			if ($student['group_name'] == 'SCIENCE') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['group']['SCIENCE']++;
			} else if ($student['group_name'] == 'HUMANITIES') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['group']['HUMANITIES']++;
			} else if ($student['group_name'] == 'BUSINESS STUDIES') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['group']['BUSINESS STUDIES']++;
			}

			if ($student['freedom_fighter']) {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['quota']['freedom_fighter']++;
			}
			if ($student['tribal']) {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['quota']['tribal']++;
			}
			if ($student['orphan']) {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['quota']['orphan']++;
			}
			if ($student['disabled']) {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['quota']['disabled']++;
			}
		}

		$this->set('studentCounts', $studentCounts);
	}

	public function getReligions()
	{
		$scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
		$levelTable = TableRegistry::getTableLocator()->get('scms_levels');
		$levels = $levelTable->find()->toArray();
		$shiftsTable = TableRegistry::getTableLocator()->get('hr_shift');
		$shifts = $shiftsTable->find()->toArray();
		$sectionsTable = TableRegistry::getTableLocator()->get('scms_sections');
		$sections = $sectionsTable->find()->toArray();
		$setting = TableRegistry::getTableLocator()->get('settings');
		// 		$settings = $setting
		// 			->find()
		// 			->where(['`key`' => 'Site.selectedSession'])
		// 			->toArray();
		// 		$selectedSessionsArray = json_decode($settings[0]['value']);

		$settings1to10 = json_decode(
			($setting->find()->where(['`key`' => 'Site.selectedSession'])->first()['value']) ?? '[]',
			true
		);

		$settings11 = json_decode(
			($setting->find()->where(['`key`' => 'Site.ElevenSession'])->first()['value']) ?? '[]',
			true
		);

		$settings12 = json_decode(
			($setting->find()->where(['`key`' => 'Site.TwelveSession'])->first()['value']) ?? '[]',
			true
		);

		$studentCounts = [];

		$basic['section_total'] = 0;
		$basic['religion']['Islam'] = 0;
		$basic['religion']['Hindu'] = 0;
		$basic['religion']['Christian'] = 0;
		$basic['religion']['Other'] = 0;
		foreach ($levels as $level) {
			foreach ($shifts as $shift) {
				foreach ($sections as $section) {
					$studentCounts[$level->level_name][$shift->shift_name][$section->section_name] = $basic;
				}
			}
		}
		$students = $scms_student_cycle
			->find()
			->select([
				'group_name' => 'scms_groups.group_name',
				'gender' => 'scms_students.gender',
				'religion' => 'scms_students.religion',
				'freedom_fighter' => 'scms_students.freedom_fighter',
				'tribal' => 'scms_students.tribal',
				'orphan' => 'scms_students.orphan',
				'disabled' => 'scms_students.disabled',
				'level_name' => 'scms_levels.level_name',
				'section_name' => 'scms_sections.section_name',
				'shift_name' => 'hr_shift.shift_name'
			])
			->join([
				'scms_students' => [
					'table' => 'scms_students',
					'type' => 'LEFT',
					'conditions' => ['scms_students.student_id = scms_student_cycle.student_id'],
				],
				'scms_groups' => [
					'table' => 'scms_groups',
					'type' => 'LEFT',
					'conditions' => ['scms_groups.group_id = scms_student_cycle.group_id'],
				],
				'scms_levels' => [
					'table' => 'scms_levels',
					'type' => 'LEFT',
					'conditions' => ['scms_levels.level_id = scms_student_cycle.level_id'],
				],
				'scms_sections' => [
					'table' => 'scms_sections',
					'type' => 'LEFT',
					'conditions' => ['scms_sections.section_id = scms_student_cycle.section_id'],
				],
				'hr_shift ' => [
					'table' => 'hr_shift',
					'type' => 'LEFT',
					'conditions' => ['hr_shift.shift_id = scms_student_cycle.shift_id'],
				],
			])
			->where(['scms_students.status' => 1])
			// 			->where(['scms_students.session_id IN' => $selectedSessionsArray])

			->where(function ($exp, $q) use ($settings1to10, $settings11, $settings12) {

				return $exp->or_([

					// SCHOOL LEVELS → selectedSession
					[
						'scms_levels.level_id IN' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 14, 90, 91, 92],
						'scms_student_cycle.session_id IN' => $settings1to10
					],

					// COLLEGE XI → ElevenSession (level 93)
					[
						'scms_levels.level_id' => 93,
						'scms_student_cycle.session_id IN' => $settings11
					],

					// COLLEGE XII → TwelveSession (level 94)
					[
						'scms_levels.level_id' => 94,
						'scms_student_cycle.session_id IN' => $settings12
					]

				]);
			})

			->enableAutoFields(true)
			->enableHydration(false)
			->toArray();
		foreach ($students as $student) {

			$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['section_total']++;

			if ($student['religion'] == 'Islam') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['religion']['Islam']++;
			} else if ($student['religion'] == 'Hindu') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['religion']['Hindu']++;
			} else if ($student['religion'] == 'Christian') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['religion']['Christian']++;
			} else {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['religion']['Other']++;
			}
		}
		$this->set('studentCounts', $studentCounts);
	}
	public function getGroups()
	{
		$scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
		$levelTable = TableRegistry::getTableLocator()->get('scms_levels');
		$levels = $levelTable->find()->toArray();
		$shiftsTable = TableRegistry::getTableLocator()->get('hr_shift');
		$shifts = $shiftsTable->find()->toArray();
		$sectionsTable = TableRegistry::getTableLocator()->get('scms_sections');
		$sections = $sectionsTable->find()->toArray();
		$setting = TableRegistry::getTableLocator()->get('settings');
		// 		$settings = $setting
		// 			->find()
		// 			->where(['`key`' => 'Site.selectedSession'])
		// 			->toArray();
		// 		$selectedSessionsArray = json_decode($settings[0]['value']);

		$settings1to10 = json_decode(
			($setting->find()->where(['`key`' => 'Site.selectedSession'])->first()['value']) ?? '[]',
			true
		);

		$settings11 = json_decode(
			($setting->find()->where(['`key`' => 'Site.ElevenSession'])->first()['value']) ?? '[]',
			true
		);

		$settings12 = json_decode(
			($setting->find()->where(['`key`' => 'Site.TwelveSession'])->first()['value']) ?? '[]',
			true
		);

		$studentCounts = [];
		$basic['section_total'] = 0;
		$basic['group']['SCIENCE'] = 0;
		$basic['group']['HUMANITIES'] = 0;
		$basic['group']['BUSINESS STUDIES'] = 0;

		// 		foreach ($levels as $level) {
		// 			foreach ($shifts as $shift) {
		// 				foreach ($sections as $section) {
		// 					$studentCounts[$level->level_name][$shift->shift_name][$section->section_name] = $basic;
		// 				}
		// 			}
		// 		}

		foreach ($levels as $level) {

			$levelName = $level->level_name;
			$levelId   = $level->level_id;

			foreach ($shifts as $shift) {

				$shiftName = $shift->shift_name;

				foreach ($sections as $section) {

					// FIX: Only add section if it belongs to this level
					if ($section->level_id == $levelId) {
						$studentCounts[$levelName][$shiftName][$section->section_name] = $basic;
					}
				}
			}
		}

		$students = $scms_student_cycle
			->find()
			->select([
				'group_name' => 'scms_groups.group_name',
				'gender' => 'scms_students.gender',
				'religion' => 'scms_students.religion',
				'freedom_fighter' => 'scms_students.freedom_fighter',
				'tribal' => 'scms_students.tribal',
				'orphan' => 'scms_students.orphan',
				'disabled' => 'scms_students.disabled',
				'level_name' => 'scms_levels.level_name',
				'section_name' => 'scms_sections.section_name',
				'shift_name' => 'hr_shift.shift_name'
			])
			->join([
				'scms_students' => [
					'table' => 'scms_students',
					'type' => 'LEFT',
					'conditions' => ['scms_students.student_id = scms_student_cycle.student_id'],
				],
				'scms_groups' => [
					'table' => 'scms_groups',
					'type' => 'LEFT',
					'conditions' => ['scms_groups.group_id = scms_student_cycle.group_id'],
				],
				'scms_levels' => [
					'table' => 'scms_levels',
					'type' => 'LEFT',
					'conditions' => ['scms_levels.level_id = scms_student_cycle.level_id'],
				],
				'scms_sections' => [
					'table' => 'scms_sections',
					'type' => 'LEFT',
					'conditions' => ['scms_sections.section_id = scms_student_cycle.section_id'],
				],
				'hr_shift ' => [
					'table' => 'hr_shift',
					'type' => 'LEFT',
					'conditions' => ['hr_shift.shift_id = scms_student_cycle.shift_id'],
				],
			])
			->where(['scms_students.status' => 1])
			// 			->where(['scms_students.session_id IN' => $selectedSessionsArray])

			->where(function ($exp, $q) use ($settings1to10, $settings11, $settings12) {

				return $exp->or_([

					// SCHOOL LEVELS → selectedSession
					[
						'scms_levels.level_id IN' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 14, 90, 91, 92],
						'scms_student_cycle.session_id IN' => $settings1to10
					],

					// COLLEGE XI → ElevenSession (level 93)
					[
						'scms_levels.level_id' => 93,
						'scms_student_cycle.session_id IN' => $settings11
					],

					// COLLEGE XII → TwelveSession (level 94)
					[
						'scms_levels.level_id' => 94,
						'scms_student_cycle.session_id IN' => $settings12
					]

				]);
			})

			->enableAutoFields(true)
			->enableHydration(false)
			->toArray();
		foreach ($students as $student) { //echo '<pre>';print_r($students);die;
			$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['section_total']++;
			if ($student['group_name'] == 'SCIENCE') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['group']['SCIENCE']++;
			} else if ($student['group_name'] == 'HUMANITIES') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['group']['HUMANITIES']++;
			} else if ($student['group_name'] == 'BUSINESS STUDIES') {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['group']['BUSINESS STUDIES']++;
			}
		}
		// 		echo '<pre>';print_r($studentCounts);die;
		$this->set('studentCounts', $studentCounts);
	}
	public function getQuata()
	{
		$scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
		$levelTable = TableRegistry::getTableLocator()->get('scms_levels');
		$levels = $levelTable->find()->toArray();
		$shiftsTable = TableRegistry::getTableLocator()->get('hr_shift');
		$shifts = $shiftsTable->find()->toArray();
		$sectionsTable = TableRegistry::getTableLocator()->get('scms_sections');
		$sections = $sectionsTable->find()->toArray();
		$setting = TableRegistry::getTableLocator()->get('settings');
		$settings = $setting
			->find()
			->where(['`key`' => 'Site.selectedSession'])
			->toArray();
		$selectedSessionsArray = json_decode($settings[0]['value']);
		$studentCounts = [];
		$basic['quota']['freedom_fighter'] = 0;
		$basic['quota']['tribal'] = 0;
		$basic['quota']['orphan'] = 0;
		$basic['quota']['disabled'] = 0;
		$basic['section_total'] = 0;

		foreach ($levels as $level) {
			foreach ($shifts as $shift) {
				foreach ($sections as $section) {
					$studentCounts[$level->level_name][$shift->shift_name][$section->section_name] = $basic;
				}
			}
		}
		$students = $scms_student_cycle
			->find()
			->select([
				'group_name' => 'scms_groups.group_name',
				'gender' => 'scms_students.gender',
				'religion' => 'scms_students.religion',
				'freedom_fighter' => 'scms_students.freedom_fighter',
				'tribal' => 'scms_students.tribal',
				'orphan' => 'scms_students.orphan',
				'disabled' => 'scms_students.disabled',
				'level_name' => 'scms_levels.level_name',
				'section_name' => 'scms_sections.section_name',
				'shift_name' => 'hr_shift.shift_name'
			])
			->join([
				'scms_students' => [
					'table' => 'scms_students',
					'type' => 'LEFT',
					'conditions' => ['scms_students.student_id = scms_student_cycle.student_id'],
				],
				'scms_groups' => [
					'table' => 'scms_groups',
					'type' => 'LEFT',
					'conditions' => ['scms_groups.group_id = scms_student_cycle.group_id'],
				],
				'scms_levels' => [
					'table' => 'scms_levels',
					'type' => 'LEFT',
					'conditions' => ['scms_levels.level_id = scms_student_cycle.level_id'],
				],
				'scms_sections' => [
					'table' => 'scms_sections',
					'type' => 'LEFT',
					'conditions' => ['scms_sections.section_id = scms_student_cycle.section_id'],
				],
				'hr_shift ' => [
					'table' => 'hr_shift',
					'type' => 'LEFT',
					'conditions' => ['hr_shift.shift_id = scms_student_cycle.shift_id'],
				],
			])
			->where(['scms_students.status' => 1])
			->where(['scms_students.session_id IN' => $selectedSessionsArray])
			->enableAutoFields(true)
			->enableHydration(false)
			->toArray();
		foreach ($students as $student) {

			$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['section_total']++;
			if ($student['freedom_fighter']) {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['quota']['freedom_fighter']++;
			}
			if ($student['tribal']) {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['quota']['tribal']++;
			}
			if ($student['orphan']) {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['quota']['orphan']++;
			}
			if ($student['disabled']) {
				$studentCounts[$student['level_name']][$student['shift_name']][$student['section_name']]['quota']['disabled']++;
			}
		}
		$this->set('studentCounts', $studentCounts);
	}
}
