<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

I18n::setLocale('jp_JP');

class StudentsController extends AppController
{

    public $paginate = [
        'order' => [
            'region_id' => 'asc',
            'weight' => 'asc',
        ],
    ];

    public function initialize()
    {
        parent::initialize();
    }

    public function employee() {}
    
    #image upload @shovon jan-2026
    
    private function processStudentImage($file, $useS3 = false)
    {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (!in_array($ext, $allowed)) {
            return false;
        }

        // SAME naming style as old code
        $setNewFileName = time() . '_' . rand(100000, 999999);

        /* ========== ORIGINAL ========= */
        $originalDir = WWW_ROOT . 'uploads/students/original/';
        if (!is_dir($originalDir)) {
            mkdir($originalDir, 0777, true);
        }

        $originalPath = $originalDir . $setNewFileName . '.' . $ext;

        // ZIP extracted files are not "uploaded files"
        if (is_uploaded_file($file['tmp_name'])) {
            move_uploaded_file($file['tmp_name'], $originalPath);
        } else {
            copy($file['tmp_name'], $originalPath);
        }

        /* ========== CREATE IMAGE ========= */
        if ($ext === 'png') {
            $image = imagecreatefrompng($originalPath);
        } else {
            $image = imagecreatefromjpeg($originalPath);
        }

        if (!$image) {
            unlink($originalPath);
            return false;
        }

        /* ========== THUMBNAIL ========= */
        $thumbDir = WWW_ROOT . 'uploads/students/thumbnail/';
        if (!is_dir($thumbDir)) {
            mkdir($thumbDir, 0777, true);
        }

        $thumbFileName = $setNewFileName . '_th.' . $ext;
        $thumbPath = $thumbDir . $thumbFileName;

        $thumbImg = imagescale($image, 300, 300);
        imagejpeg($thumbImg, $thumbPath, 50);
        imagedestroy($thumbImg);

        /* ========== REGULAR SIZE ========= */
        $regularDir = WWW_ROOT . 'uploads/students/regularSize/';
        if (!is_dir($regularDir)) {
            mkdir($regularDir, 0777, true);
        }

        $regularFileName = $setNewFileName . '_rs.' . $ext;
        $regularPath = $regularDir . $regularFileName;

        $regularImg = imagescale($image, 1020, 1200);
        imagejpeg($regularImg, $regularPath, 95);
        imagedestroy($regularImg);

        imagedestroy($image);
        unlink($originalPath);



        /* ========== RETURN (MATCH OLD STRUCTURE) ========= */
        return [
            'thumbnail'    => $thumbFileName,
            'regular_size' => $regularFileName
        ];
    }


    public function uploadImage()
    {
        $value = [
            'session_id' => null,
            'shift_id'   => null,
            'level_id'   => null,
            'section_id' => null
        ];


        // Sessions
        $sessionTbl = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $sessionTbl
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        // Levels
        $levels = $this->get_levels('students');
        $this->set('levels', $levels);

        // Sections (initial – based on first level if exists)
        if (!empty($levels)) {
            $sections = $this->get_sections('students', $levels[0]->level_id);
        } else {
            $sections = [];
        }
        $this->set('sections', $sections);

        // Shifts
        $shifts = $this->get_shifts('students');
        $this->set('shifts', $shifts);

        // Active session
        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id'] ?? null);

        // Required logic (role based)
        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        if (in_array($role_id, [1, 2])) {
            $required = '';
        }
        $this->set('required', $required);

        // Pass form data
        $this->set('data', $value);

        if (!$this->request->is('post')) {
            return;
        }

        $data  = $this->request->getData();
        $value = $data; // keep values on reload
        $this->set('data', $value);

        $file = $data['image_name'];

        $Students = TableRegistry::getTableLocator()->get('scms_students');
        $Cycles   = TableRegistry::getTableLocator()->get('scms_student_cycle');

        /* ===== VALIDATE ZIP ===== */
        if (empty($file) || $file['error'] !== 0 || strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) !== 'zip') {
            $this->Flash->error('Please upload a valid ZIP file.');
            return $this->redirect($this->referer());
        }

        /* ===== EXTRACT ZIP ===== */
        $tempDir = sys_get_temp_dir() . '/student_zip_' . uniqid();
        mkdir($tempDir, 0777, true);

        $zip = new \ZipArchive();
        if ($zip->open($file['tmp_name']) !== true) {
            $this->Flash->error('Unable to open ZIP file.');
            return $this->redirect($this->referer());
        }
        $zip->extractTo($tempDir);
        $zip->close();

        /* ===== ITERATE FILES ===== */
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($tempDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        $success = 0;
        $skipped = 0;
        $failed  = [];

        $replaceExisting = !empty($data['replace_existing']);

        foreach ($iterator as $fileInfo) {

            if (!$fileInfo->isFile()) {
                continue;
            }

            $fileName   = $fileInfo->getFilename();
            $identifier = pathinfo($fileName, PATHINFO_FILENAME);
            $ext        = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                continue;
            }

            /* ===== FIND STUDENT ===== */
            $cycle = null;
            $student = null;

            $cycle = $Cycles->find()
                ->where([
                    'student_id' => $identifier,
                    'session_id' => $data['session_id'],
                    'level_id'   => $data['level_id'],
                    'section_id' => $data['section_id']
                ])
                ->first();

            if (!$cycle) {
                $cycle = $Cycles->find()
                    ->where([
                        'roll'       => $identifier,
                        'session_id' => $data['session_id'],
                        'level_id'   => $data['level_id'],
                        'section_id' => $data['section_id']
                    ])
                    ->first();
            }

            if (!$cycle) {
                $student = $Students->find()
                    ->where(['sid' => $identifier])
                    ->first();

                if ($student) {
                    $cycle = $Cycles->find()
                        ->where([
                            'student_id' => $student->student_id,
                            'session_id' => $data['session_id'],
                            'level_id'   => $data['level_id'],
                            'section_id' => $data['section_id']
                        ])
                        ->first();
                }
            }

            if (!$cycle) {
                $failed[] = $fileName . ' (student not found)';
                continue;
            }

            if (!$student) {
                $student = $Students->get($cycle->student_id);
            }


            /* ===== SKIP / REPLACE ===== */
            if (
                !$replaceExisting &&
                (!empty($student->photo) || !empty($student->thumbnail))
            ) {
                $skipped++;
                continue;
            }

            /* ===== PROCESS IMAGE ===== */
            $result = $this->processStudentImage([
                'name'     => $fileName,
                'tmp_name' => $fileInfo->getPathname()
            ]);

            if ($result) {
                $student->thumbnail = $result['thumbnail'];
                $student->regular_size    = $result['regular_size'];
                $Students->save($student);
                $success++;
            } else {
                $failed[] = $fileName . ' (image error)';
            }
        }

        /* ===== CLEANUP ===== */
        $this->deleteDirectory($tempDir);

        // Fetch Session name
        $sessionName = '';
        if (!empty($data['session_id'])) {
            $sessionRow = $sessionTbl->find()
                ->select(['session_name'])
                ->where(['session_id' => $data['session_id']])
                ->first();
            $sessionName = $sessionRow ? $sessionRow->session_name : '';
        }

        // Fetch Class / Level name
        $levelName = '';
        foreach ($levels as $lvl) {
            if ($lvl->level_id == $data['level_id']) {
                $levelName = $lvl->level_name;
                break;
            }
        }

        // Fetch Section name
        $sectionName = '';
        if (!empty($data['section_id'])) {
            $sectionTbl = TableRegistry::getTableLocator()->get('scms_sections');
            $sectionRow = $sectionTbl->find()
                ->select(['section_name'])
                ->where(['section_id' => $data['section_id']])
                ->first();
            $sectionName = $sectionRow ? $sectionRow->section_name : '';
        }

        // Build message
        $message = '<b>Image Upload Summary:</b> ';
        $message .= 'Session <b>' . h($sessionName) . '</b> | ';
        $message .= 'Class <b>' . h($levelName) . '</b> | ';
        $message .= 'Section <b>' . h($sectionName) . '</b> | ';
        $message .= 'Uploaded: <b>' . $success . '</b>';

        if ($skipped > 0) {
            $message .= ' | Skipped: <b>' . $skipped . '</b>';
        }

        if (!empty($failed)) {
            $message .= ' | Failed: <b>' . count($failed) . '</b>';
        }

        $this->Flash->success($message, ['escape' => false]);


        // Optional: detailed failed list
        if (!empty($failed)) {
            $this->Flash->warning(
                'Failed files: ' . implode(', ', array_slice($failed, 0, 10))
            );
        }

        return $this->redirect($this->referer());
    }

    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        foreach (scandir($dir) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }
    
    #image upload end
    
    public function customRoll()
    { //@shovon jan-2026
    
        $value['session_id'] = null;
        $value['shift_id'] = null;
        $value['level_id'] = null;
        $value['section_id'] = null;
        
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if (isset($request_data['session_id'])) {
                $where['scms_student_cycle.session_id'] = $request_data['session_id'];
                if ($request_data['shift_id']) {
                    $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
                }
                if ($request_data['level_id']) {
                    $where['scms_student_cycle.level_id'] = $request_data['level_id'];
                }
                if ($request_data['section_id']) {
                    $where['scms_student_cycle.section_id'] = $request_data['section_id'];
                }

                $student = TableRegistry::getTableLocator()->get('scms_student_cycle');
                $students = $student->find()
                    ->where($where)
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->select([
                        'name' => "s.name",
                        'sid' => "s.sid",
                        'section_name' => "section.section_name",
                    ])
                    ->join([
                        's' => [
                            'table' => 'scms_students',
                            'type' => 'INNER',
                            'conditions' => [
                                's.student_id = scms_student_cycle.student_id'
                            ]
                        ],
                        'shift' => [
                            'table' => 'hr_shift',
                            'type' => 'INNER',
                            'conditions' => [
                                'shift.shift_id = scms_student_cycle.shift_id'
                            ]
                        ],
                        'level' => [
                            'table' => 'scms_levels',
                            'type' => 'INNER',
                            'conditions' => [
                                'level.level_id = scms_student_cycle.level_id'
                            ]
                        ],
                        'section' => [
                            'table' => 'scms_sections',
                            'type' => 'INNER',
                            'conditions' => [
                                'section.section_id = scms_student_cycle.section_id'
                            ]
                        ],
                        'session' => [
                            'table' => 'scms_sessions',
                            'type' => 'INNER',
                            'conditions' => [
                                'session.session_id  = scms_student_cycle.session_id'
                            ]
                        ],
                    ])
                    ->order(['scms_student_cycle.roll' => 'ASC'])
                    ->toArray();
                $value = $request_data;
                $this->set('value', $value);
                $this->set('students', $students);
            } else {
                
                $rolls = $request_data['roll'];

                $studentCycleTable = TableRegistry::getTableLocator()->get('scms_student_cycle');
                
                foreach ($rolls as $student_cycle_id => $roll_no) {
                
                    $studentCycleTable->query()
                        ->update()
                        ->set(['roll' => $roll_no])
                        ->where(['student_cycle_id' => $student_cycle_id])
                        ->execute();
                }

                
               /* $student = TableRegistry::getTableLocator()->get('scms_student_cycle');
                foreach ($roll as $key => $r) {
                    $value['roll'] = $r;
                    $query = $student->query();
                    $query
                        ->update()
                        ->set($value)
                        ->where(['student_cycle_id' => $key])
                        ->execute();
                } */
                $this->Flash->info('Student\'s Roll Updated Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'customRoll']);
            }
            $value = $request_data;
            $this->set('value', $value);
            $head = $this->set_head($request_data);
            $this->set('head', $head);
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->orderDesc('session_name')
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);
        
        $sections = $this->get_sections('students', $levels[0]->level_id);
        $this->set('sections', $sections);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('groups', $groups);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
        $this->set('data', $value);
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            //            pr($request_data);die;
            $file = $request_data['image_name'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);

            $thumbnailFileName = null;
            $regularSizeFileName = null;

            if (in_array($ext, $arr_ext)) {
                // Move uploaded file to original folder
                $originalFolderPath = WWW_ROOT . '/uploads/students/large_version/'; // Specify original folder path
                if (!file_exists($originalFolderPath)) {
                    mkdir($originalFolderPath, 0777, true);
                }
                $originalImagePath = $originalFolderPath . $setNewFileName . '.' . $ext;
                move_uploaded_file($file['tmp_name'], $originalImagePath);

                // Open original image file
                $image = null;
                if ($ext == 'jpg' || $ext == 'jpeg') {
                    $image = imagecreatefromjpeg($originalImagePath);
                } else if (
                    $ext == 'png'
                ) {
                    $image = imagecreatefrompng($originalImagePath);
                }

                // Compress image and save thumbnail version
                if ($image) {
                    $thumbnailFolderPath = WWW_ROOT . '/uploads/students/thumbnail/'; // Specify thumbnail folder path
                    if (!file_exists($thumbnailFolderPath)) {
                        mkdir($thumbnailFolderPath, 0777, true);
                    }
                    $thumbnailImagePath = $thumbnailFolderPath . $setNewFileName . '_th.' . $ext;
                    $thumbnailWidth = 300; // Change this value to adjust thumbnail width
                    $thumbnailHeight = 300; // Change this value to adjust thumbnail height
                    $thumbnailImage = imagescale($image, $thumbnailWidth, $thumbnailHeight);
                    imagejpeg($thumbnailImage, $thumbnailImagePath, 50);
                    $thumbnailFileName = $setNewFileName . '_th.' . $ext;
                    imagedestroy($thumbnailImage);
                }

                // Compress image and save regularSize version
                if ($image) {
                    $regularSizeFolderPath = WWW_ROOT . '/uploads/students/regularSize/'; // Specify regularSize folder path
                    if (!file_exists($regularSizeFolderPath)) {
                        mkdir($regularSizeFolderPath, 0777, true);
                    }
                    $regularSizeImagePath = $regularSizeFolderPath . $setNewFileName . '_rs.' . $ext;
                    $regularSizeWidth = 1020; // Change this value to adjust regularSize width
                    $regularSizeHeight = 1200; // Change this value to adjust regularSize height
                    $regularSizeImage = imagescale($image, $regularSizeWidth, $regularSizeHeight);
                    imagejpeg($regularSizeImage, $regularSizeImagePath, 95);
                    $regularSizeFileName = $setNewFileName . '_rs.' . $ext;
                    imagedestroy($regularSizeImage);
                }
                // Delete original image
                unlink($originalImagePath);
                $student_data['thumbnail'] = $thumbnailFileName;
            }
            $student_data['name'] = $request_data['name'];
            $student_data['name_bn'] = $request_data['name_bn'];
            $student_data['mobile'] = $request_data['mobile'];
            $student_data['email'] = $request_data['email'];
            $student_data['telephone'] = $request_data['telephone'];
            $student_data['date_of_birth'] = $request_data['date_of_birth'];
            $student_data['national_id'] = $request_data['national_id'];
            $student_data['birth_registration'] = $request_data['birth_registration'];
            $student_data['permanent_address'] = $request_data['permanent_address'];
            $student_data['present_address'] = $request_data['present_address'];
            $student_data['gender'] = $request_data['gender'];
            $student_data['religion'] = $request_data['religion'];
            $student_data['blood_group'] = $request_data['blood_group'];
            $student_data['marital_status'] = $request_data['marital_status'];
            $student_data['date_of_admission'] = $request_data['date_of_admission'];
            $student_data['nationality'] = $request_data['nationality'];
            $student_data['freedom_fighter'] = $request_data['freedom_fighter'];
            $student_data['tribal'] = $request_data['tribal'];
            $student_data['disabled'] = $request_data['disabled'];
            $student_data['orphan'] = $request_data['orphan'];
            $student_data['part_time_job'] = $request_data['part_time_job'];
            $student_data['job_type'] = $request_data['job_type'];
            $student_data['stipend'] = $request_data['stipend'];
            $student_data['scholership'] = $request_data['scholership'];
            $student_data['session_id'] = $request_data['session_id'];
            $student_data['level_id'] = $request_data['level_id'];
            $student_data['religion_subject'] = $request_data['religion_subject'];
            // $student_data['institute_name'] = $request_data['institute_name'];

            $student_data['status'] = $request_data['status'];
            $student_data['active_guardian'] = $request_data['active_guardian'];
            //            pr($student_data);die;
            foreach ($student_data as $key => $data) {
                if ($data == '-- Choose --') {
                    $student_data[$key] = null;
                }
            }

            $student_data['sid'] = $this->get_sid($student_data);
            //            pr($student_data);die;
            $student_columns = array_keys($student_data);
            $student = TableRegistry::getTableLocator()->get('scms_students');
            $query = $student->query();
            $query->insert($student_columns)
                ->values($student_data)
                ->execute();
            $student_record = $student->find()->last(); //get the last employee id
            $request_data['student_id'] = $student_record->student_id;
            //            die;
            //            pr($request_data['student_id']);die;
            foreach ($request_data['g_relation'] as $key => $relation) {
                $guardian_data[$key]['relation'] = $request_data['g_relation'][$key];
                $guardian_data[$key]['name'] = $request_data['g_name'][$key];
                $guardian_data[$key]['name_bn'] = $request_data['g_name_bn'][$key];
                $guardian_data[$key]['mobile'] = $request_data['g_mobile'][$key];
                $guardian_data[$key]['nid'] = $request_data['g_nid'][$key];
                $guardian_data[$key]['birth_reg'] = $request_data['g_birth_reg'][$key];
                $guardian_data[$key]['occupation'] = $request_data['g_occupation'][$key];
                $guardian_data[$key]['yearly_income'] = $request_data['g_income'][$key];
                $guardian_data[$key]['nationality'] = $request_data['g_nationality'][$key];
                $guardian_data[$key]['religion'] = $request_data['g_religion'][$key];
                $guardian_data[$key]['gender'] = $request_data['g_gender'][$key];
                $guardian_data[$key]['student_id'] = $request_data['student_id'];
                $guardian_data[$key]['rtype'] = $request_data['g_relation'][$key];
            }
            //            pr($guardian_data);//die;
            foreach ($guardian_data as $key1 => $guardians) {
                foreach ($guardians as $key2 => $data) {
                    if ($data == '-- Choose --') {
                        $guardian_data[$key1][$key2] = null;
                    }
                }
                $guardian = TableRegistry::getTableLocator()->get('scms_guardians');
                $query = $guardian->query();
                $query->insert(['student_id', 'relation', 'name', 'gender', 'name_bn', 'rtype', 'email', 'mobile', 'nid', 'birth_reg', 'occupation', 'yearly_income', 'nationality', 'religion'])
                    ->values($guardians)
                    ->execute();
            }


            if (isset($request_data['exam_name'])) {
                foreach ($request_data['exam_name'] as $key => $exam) {
                    $education_data['exam_name'] = $request_data['exam_name'][$key];
                    $education_data['exam_board'] = $request_data['exam_board'][$key];
                    $education_data['exam_session'] = $request_data['exam_session'][$key];
                    $education_data['exam_roll'] = $request_data['exam_roll'][$key];
                    $education_data['exam_registration'] = $request_data['exam_registration'][$key];
                    $education_data['institute'] = $request_data['institute'][$key];
                    $education_data['grade'] = $request_data['grade'][$key];
                    $education_data['group_name'] = $request_data['group_name'][$key];
                    $education_data['gpa'] = $request_data['gpa'][$key];
                    $education_data['passing_year'] = $request_data['passing_year'][$key];
                    $education_data['student_id'] = $request_data['student_id'];
                    //                    pr($education_data);die;

                    $qualification = TableRegistry::getTableLocator()->get('scms_qualification');
                    $query = $qualification->query();
                    $query
                        ->insert(['student_id', 'exam_name', 'exam_board', 'exam_session', 'exam_roll', 'exam_registration', 'institute', 'grade', 'group_name', 'gpa', 'passing_year'])
                        ->values($education_data)
                        ->execute();
                }
            } //die;



            $student_cycle_data['student_id'] = $request_data['student_id'];
            $student_cycle_data['level_id'] = $student_data['level_id'];
            $student_cycle_data['group_id'] = $request_data['group_id'];
            $student_cycle_data['shift_id'] = $request_data['shift_id'];
            $student_cycle_data['section_id'] = $request_data['section_id'];
            $student_cycle_data['session_id'] = $student_data['session_id'];
            $student_cycle_data['roll'] = $request_data['roll'];
            $student_cycle_data['resedential'] = $request_data['resedential'];
            //            pr($student_cycle_data);die;

            $student_cycles = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $query = $student_cycles->query();
            $query->insert(['student_id', 'level_id', 'group_id', 'shift_id', 'section_id', 'session_id', 'roll', 'resedential'])
                ->values($student_cycle_data)
                ->execute();
            //            die;

            $student_cycles_record = $student_cycles->find()->last(); //get the last student_cycle_id
            $student_cycle_id = $student_cycles_record->student_cycle_id;

            $optional_id = [];
            //3rd, 4th and religion subject (optional)
            if ($student_data['religion_subject']) {
                $optional_id[] = $student_data['religion_subject'];
            }
            $scms_third_and_forth_subject_data = array();
            if (isset($request_data['thrid_subject'])) {
                foreach ($request_data['thrid_subject'] as $thrid_subject) {
                    $optional_id[] = $thrid_subject;
                    $single_third_subject['type'] = 'third';
                    $single_third_subject['student_cycle_id'] = $student_cycle_id;
                    $single_third_subject['course_id'] = $thrid_subject;
                    $scms_third_and_forth_subject_data[] = $single_third_subject;
                }
            }
            if (isset($request_data['forth_subject'])) {
                foreach ($request_data['forth_subject'] as $forth_subject) {
                    $optional_id[] = $forth_subject;
                    $single_forth_subject['type'] = 'forth';
                    $single_forth_subject['student_cycle_id'] = $student_cycle_id;
                    $single_forth_subject['course_id'] = $forth_subject;
                    $scms_third_and_forth_subject_data[] = $single_forth_subject;
                }
            }

            $where['level_id'] = $student_data['level_id'];
            $where['session_id'] = $student_data['session_id'];
            $optional_courses = array();

            if (count($optional_id) > 0) {
                $where['c.course_id in'] = $optional_id;
                $optional_courses = $this->getCoursecycle($where);
            }
            unset($where['c.course_id in']);

            //Compulsory course
            $where['c.course_type_id'] = 1;
            $compulsory_courses = $this->getCoursecycle($where);

            //extra course
            $where['c.course_type_id'] = 2;
            $extra_courses = $this->getCoursecycle($where);

            //Selective course
            $selective_courses = array();
            if ($request_data['group_id']) {
                $where['c.course_type_id'] = 4;
                $where['c.course_group_id'] = $request_data['group_id'];
                $selective_courses = $this->getCoursecycle($where);
            }


            $student_course_cycles = array_merge($optional_courses, $compulsory_courses, $selective_courses, $extra_courses);

            //scms_student_course_cycle insert start
            $student_course_cycle_data['student_cycle_id'] = $student_cycle_id;
            foreach ($student_course_cycles as $student_course_cycle) {
                $student_course_cycle_data['courses_cycle_id'] = $student_course_cycle['courses_cycle_id'];
                $student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
                $query = $student_course_cycle->query();
                $query->insert(['student_cycle_id', 'courses_cycle_id'])
                    ->values($student_course_cycle_data)
                    ->execute();

                $student_course_cycle_record = $student_course_cycle->find()->last(); //get the last student_course_cycle_id
                $student_course_cycle_ids[] = $student_course_cycle_record->student_course_cycle_id;
            }
            //scms_student_course_cycle insert end
            //------***------
            //scms_student_term_cycle start
            $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
            $term_cycles = $term_cycle
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['session_id' => $request_data['session_id']])
                ->where(['level_id' => $student_data['level_id']])
                ->toArray();
            foreach ($term_cycles as $term_cycle) {
                $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
                $scms_student_term_cycle_data['student_cycle_id'] = $student_cycle_id;
                $scms_student_term_cycle_data['term_cycle_id'] = $term_cycle['term_cycle_id'];
                $query = $scms_student_term_cycle->query();
                $query
                    ->insert(['student_cycle_id', 'term_cycle_id'])
                    ->values($scms_student_term_cycle_data)
                    ->execute();
                $scms_student_term_cycle_last_data = $scms_student_term_cycle->find()->last(); //get the last id
                $student_term_course_cycle_data['student_term_cycle_id'] = $scms_student_term_cycle_last_data->student_term_cycle_id;

                //scms_student_term_course_cycle start
                foreach ($student_course_cycle_ids as $student_course_cycle_id) {
                    $student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
                    $student_term_course_cycle_data['student_course_cycle_id'] = $student_course_cycle_id;
                    $query = $student_term_course_cycle->query();
                    $query
                        ->insert(['student_term_cycle_id', 'student_course_cycle_id'])
                        ->values($student_term_course_cycle_data)
                        ->execute();
                }

                //scms_student_term_course_cycle end
            }
            //scms_student_term_cycle end
            //save third and forth subject
            if (count($scms_third_and_forth_subject_data)) {
                $scms_third_and_forth_subject = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
                $columns = array_keys($scms_third_and_forth_subject_data[0]);
                $insertQuery = $scms_third_and_forth_subject->query();
                $insertQuery->insert($columns);
                // you must always alter the values clause AFTER insert
                $insertQuery->clause('values')->values($scms_third_and_forth_subject_data);
                $insertQuery->execute();
            }
            //save third and forth subject end
            //Set Flash
            $this->Flash->info('Student Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);

            return $this->redirect(['action' => 'index']);
        }

        $scms_students_data_settings_value = TableRegistry::getTableLocator()->get('scms_students_data_settings_value');
        $values = $scms_students_data_settings_value
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                "name" => "s.name",
                "type_id" => "s.type_id",
                "heading" => "g.heading",
            ])
            ->join([
                's' => [
                    'table' => ' scms_students_data_settings',
                    'type' => 'INNER',
                    'conditions' => [' s.id  = scms_students_data_settings_value.scms_students_data_settings_id'],
                ],
            ])
            ->join([
                'g' => [
                    'table' => ' scms_students_data_settings_group',
                    'type' => 'INNER',
                    'conditions' => [' g.id  = scms_students_data_settings_value.scms_students_data_settings_group_id'],
                ],
            ])
            ->toArray();

        foreach ($values as $value) {
            //            pr($value);die;

            $filter_data[$value['heading']][$value['scms_students_data_settings_id']] = $value;
        }
        $data_count = TableRegistry::getTableLocator()->get('scms_students_data_settings_group');
        $data_counts = $data_count
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        //        pr($filter_data);die;
        //        pr($filter_data);
        //        die;
        $this->set('values', $filter_data);
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->toArray();
        $this->set('levels', $levels);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('groups', $groups);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);

        $religion_field = $this->get_settings_value(50);
        $this->set('religion_field', $religion_field);
    }

    public function print($id)
    {
        // $this->layout = 'admission-form';
        $where['scms_student_cycle.student_id'] = $id;
        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');

        $students = $scms_student_cycle->find()
            ->where(['scms_student_cycle.student_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'student_sid' => "scms_students.sid",
                'name' => "scms_students.name",
                'student_id' => "scms_students.student_id",
                'thumbnail' => "scms_students.thumbnail",
                'gender' => "scms_students.gender",
                'religion' => "scms_students.religion",
                'permanent_address' => "scms_students.permanent_address",
                'present_address' => "scms_students.present_address",
                'date_of_birth' => "scms_students.date_of_birth",
                'birth_registration' => "scms_students.birth_registration",
                'session_name' => "scms_sessions.session_name",
                'level_name' => "scms_levels.level_name",
                'section_name' => "scms_sections.section_name",
                'shift_name' => "hr_shift.shift_name",
                'father_name' => "father.name",
                'father_mobile' => "father.mobile",
                'father_nid' => "father.nid",
                'mother_name' => "mother.name",
                'mother_mobile' => "mother.mobile",
                'mother_nid' => "mother.nid",
            ])->join([
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_students.student_id = scms_student_cycle.student_id'
                    ]
                ],
                'father' => [
                    'table' => 'scms_guardians',
                    'type' => 'LEFT',
                    'conditions' => [
                        'father.student_id = scms_student_cycle.student_id',
                        'father.rtype' => 'Father'
                    ]
                ],
                'mother' => [
                    'table' => 'scms_guardians',
                    'type' => 'LEFT',
                    'conditions' => [
                        'mother.student_id = scms_student_cycle.student_id',
                        'mother.rtype' => 'mother'
                    ]
                ],
                'scms_sessions' => [
                    'table' => 'scms_sessions',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_student_cycle.session_id = scms_sessions.session_id'
                    ]
                ],
                'scms_levels' => [
                    'table' => 'scms_levels',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_student_cycle.level_id = scms_levels.level_id'
                    ]
                ],
                'scms_sections' => [
                    'table' => 'scms_sections',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_student_cycle.section_id = scms_sections.section_id'
                    ]
                ],
                'hr_shift' => [
                    'table' => 'hr_shift',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_student_cycle.shift_id = hr_shift.shift_id'
                    ]
                ],
            ])->toArray();
        //         echo '<pre>';
        // print_r($students);
        // die;

        $this->set('students', $students[0]);
    }

    // private function studnet_course_cycle_edit($data)
    // {
    //     $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
    //     $scms_student_course_cycles = $scms_student_course_cycle
    //         ->find()
    //         ->where(['student_cycle_id' => $data['student_cycle_id']])
    //         ->enableAutoFields(true)
    //         ->enableHydration(false)
    //         ->toArray();

    //     foreach ($scms_student_course_cycles as $student_course_cycle) {
    //         $current_student_course_cycles_ids[$student_course_cycle['student_course_cycle_id']] = $student_course_cycle['courses_cycle_id'];
    //     }

    //     $where['level_id'] = $data['level_id'];
    //     $where['session_id'] = $data['session_id'];

    //     //3rd, 4th and religion subject (optional)
    //     if (isset($data['religion_subject'])) {
    //         $optional_id[] = $data['religion_subject'];
    //     }
    //     $scms_third_subject_ids = array();
    //     $scms_forth_subject_ids = array();
    //     if (isset($data['thrid_subject'])) {
    //         foreach ($data['thrid_subject'] as $thrid_subject) {
    //             $scms_third_subject_ids[] = $optional_id[] = $thrid_subject;
    //         }
    //     }
    //     $this->upadte_third_forth_subject($scms_third_subject_ids, $data['student_cycle_id'], 'third');
    //     if (isset($data['forth_subject'])) {
    //         foreach ($data['forth_subject'] as $forth_subject) {
    //             $scms_forth_subject_ids[] = $optional_id[] = $forth_subject;
    //         }
    //     }
    //     $this->upadte_third_forth_subject($scms_forth_subject_ids, $data['student_cycle_id'], 'forth');
    //     $optional_courses = array();

    //     if (count($optional_id) > 0) {
    //         $where['c.course_id in'] = $optional_id;
    //         $optional_courses = $this->getCoursecycle($where);
    //     }


    //     unset($where['c.course_id in']);

    //     //Compulsory course
    //     $where['c.course_type_id'] = 1;
    //     $compulsory_courses = $this->getCoursecycle($where);

    //     //extra course
    //     $extra_courses = array();
    //     $where['c.course_type_id'] = 2;
    //     $extra_courses = $this->getCoursecycle($where);

    //     //Selective course
    //     $selective_courses = array();
    //     if ($data['group_id']) {
    //         $where['c.course_type_id'] = 4;
    //         $where['c.course_group_id'] = $data['group_id'];
    //         $selective_courses = $this->getCoursecycle($where);
    //     }


    //     $student_course_cycles = array_merge($optional_courses, $compulsory_courses, $selective_courses);
    //     foreach ($student_course_cycles as $student_course_cycle) {
    //         $requested_course_cycle[] = $student_course_cycle['courses_cycle_id'];
    //     }
    //     $new_course_cycle = array_diff($requested_course_cycle, $current_student_course_cycles_ids);
    //     $remove_course_cycle = array_diff($current_student_course_cycles_ids, $requested_course_cycle);

    //     //new_course_cycle start
    //     //scms_student_course_cycle insert start
    //     $student_course_cycle_data['student_cycle_id'] = $data['student_cycle_id'];
    //     $student_course_cycle_ids = array();
    //     foreach ($new_course_cycle as $student_course_cycle) {
    //         $student_course_cycle_data['courses_cycle_id'] = $student_course_cycle;
    //         $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
    //         $query = $scms_student_course_cycle->query();
    //         $query->insert(['student_cycle_id', 'courses_cycle_id'])
    //             ->values($student_course_cycle_data)
    //             ->execute();

    //         $student_course_cycle_record = $scms_student_course_cycle->find()->last(); //get the last student_course_cycle_id
    //         $student_course_cycle_ids[] = $student_course_cycle_record->student_course_cycle_id;
    //     }

    //     //scms_student_course_cycle insert end
    //     //------***------
    //     //------***------
    //     //scms_student_term_cycle start
    //     $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
    //     $term_cycles = $term_cycle
    //         ->find()
    //         ->enableAutoFields(true)
    //         ->enableHydration(false)
    //         ->where(['session_id' => $data['session_id']])
    //         ->where(['level_id' => $data['level_id']])
    //         ->toArray();
    //     foreach ($term_cycles as $term_cycle) {
    //         $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
    //         $scms_student_term_cycle_data['student_cycle_id'] = $data['student_cycle_id'];
    //         $scms_student_term_cycle_data['term_cycle_id'] = $term_cycle['term_cycle_id'];
    //         $scms_student_term_cycles = $scms_student_term_cycle
    //             ->find()
    //             ->where(['student_cycle_id' => $data['student_cycle_id']])
    //             ->where(['term_cycle_id' => $term_cycle['term_cycle_id']])
    //             ->enableAutoFields(true)
    //             ->enableHydration(false)
    //             ->toArray();

    //         $student_term_course_cycle_data['student_term_cycle_id'] = $scms_student_term_cycles[0]['student_term_cycle_id'];

    //         //scms_student_term_course_cycle insert start
    //         foreach ($student_course_cycle_ids as $student_course_cycle_id) {
    //             $student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
    //             $student_term_course_cycle_data['student_course_cycle_id'] = $student_course_cycle_id;
    //             $query = $student_term_course_cycle->query();
    //             $query
    //                 ->insert(['student_term_cycle_id', 'student_course_cycle_id'])
    //                 ->values($student_term_course_cycle_data)
    //                 ->execute();
    //         }
    //         //scms_student_term_course_cycle insert end
    //         //       //-----**------
    //         //scms_course_cycle remove start
    //       /*  foreach ($remove_course_cycle as $key => $course_cycle) {
    //             $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
    //             $scms_student_term_cycles = $scms_student_term_course_cycle
    //                 ->find()
    //                 ->where(['student_course_cycle_id' => $key])
    //                 ->where(['student_term_cycle_id' => $student_term_course_cycle_data['student_term_cycle_id']])
    //                 ->enableAutoFields(true)
    //                 ->enableHydration(false)
    //                 ->toArray();

    //             //delete scms_term_course_cycle_part_mark start
    //             $scms_term_course_cycle_part_mark = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_mark');
    //             $query = $scms_term_course_cycle_part_mark->query();
    //             $query->delete()
    //                 ->where(['student_term_course_cycle_id' => $scms_student_term_cycles[0]['student_term_course_cycle_id']])
    //                 ->execute();
    //             //delete scms_term_course_cycle_part_mark end
    //             //-----**------
    //             //delete scms_student_term_course_cycle start
    //             $query = $scms_student_term_course_cycle->query();
    //             $query->delete()
    //                 ->where(['student_term_course_cycle_id' => $scms_student_term_cycles[0]['student_term_course_cycle_id']])
    //                 ->execute();
    //             //delete scms_student_term_course_cycle end
    //             //-----**------
    //             //delete scms_student_course_cycle start
    //             $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
    //             $query = $scms_student_course_cycle->query();
    //             $query->delete()
    //                 ->where(['student_course_cycle_id' => $key])
    //                 ->execute();
    //             //delete scms_student_course_cycle end
    //         } */
    //         //scms_course_cycle remove end
    //     }

    //     return true;
    // }

    private function studnet_course_cycle_edit($data)
    {
        $student_cycle_id = $data['student_cycle_id'];
        $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
        $scms_student_course_cycles = $scms_student_course_cycle
            ->find()
            ->where(['student_cycle_id' => $data['student_cycle_id']])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        foreach ($scms_student_course_cycles as $student_course_cycle) {
            $current_student_course_cycles_ids[$student_course_cycle['student_course_cycle_id']] = $student_course_cycle['courses_cycle_id'];
        }

        $where['level_id'] = $data['level_id'];
        $where['session_id'] = $data['session_id'];

        //3rd, 4th and religion subject (optional)
        if (isset($data['religion_subject'])) {
            $optional_id[] = $data['religion_subject'];
        }
        $scms_third_subject_ids = array();
        $scms_forth_subject_ids = array();
        if (isset($data['thrid_subject'])) {
            foreach ($data['thrid_subject'] as $thrid_subject) {
                $scms_third_subject_ids[] = $optional_id[] = $thrid_subject;
            }
        }
        $this->upadte_third_forth_subject($scms_third_subject_ids, $data['student_cycle_id'], 'third');
        if (isset($data['forth_subject'])) {
            foreach ($data['forth_subject'] as $forth_subject) {
                $scms_forth_subject_ids[] = $optional_id[] = $forth_subject;
            }
        }
        $this->upadte_third_forth_subject($scms_forth_subject_ids, $data['student_cycle_id'], 'forth');
        $optional_courses = array();

        if (count($optional_id) > 0) {
            $where['c.course_id in'] = $optional_id;
            $optional_courses = $this->getCoursecycle($where);
        }


        unset($where['c.course_id in']);

        //Compulsory course
        $where['c.course_type_id'] = 1;
        $compulsory_courses = $this->getCoursecycle($where);

        //extra course
        $extra_courses = array();
        $where['c.course_type_id'] = 2;
        $extra_courses = $this->getCoursecycle($where);

        //Selective course
        $selective_courses = array();
        if ($data['group_id']) {
            $where['c.course_type_id'] = 4;
            $where['c.course_group_id'] = $data['group_id'];
            $selective_courses = $this->getCoursecycle($where);
        }


        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $student = $scms_student_cycle
            ->find()
            ->where(['student_cycle_id' => $student_cycle_id])
            ->select([
                'name' => 'scms_students.name',
                'religion_subject' => 'scms_students.religion_subject',
            ])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->join([
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => ['scms_students.student_id  = scms_student_cycle.student_id'],
                ]
            ])
            ->toArray();

        $student_course_cycles = array_merge($optional_courses, $compulsory_courses, $selective_courses, $extra_courses);
        foreach ($student_course_cycles as $student_course_cycle) {
            $requested_course_cycle[] = $student_course_cycle['courses_cycle_id'];
        }
        $new_course_cycle = array_diff($requested_course_cycle, $current_student_course_cycles_ids);
        $remove_course_cycle = array_diff($current_student_course_cycles_ids, $requested_course_cycle);



        //new_course_cycle start
        //scms_student_course_cycle insert start
        $student_course_cycle_data['student_cycle_id'] = $data['student_cycle_id'];
        $student_course_cycle_ids = array();
        foreach ($new_course_cycle as $student_course_cycle) {
            $student_course_cycle_data['courses_cycle_id'] = $student_course_cycle;
            $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
            $query = $scms_student_course_cycle->query();
            $query->insert(['student_cycle_id', 'courses_cycle_id'])
                ->values($student_course_cycle_data)
                ->execute();

            $student_course_cycle_record = $scms_student_course_cycle->find()->last(); //get the last student_course_cycle_id
            $student_course_cycle_ids[] = $student_course_cycle_record->student_course_cycle_id;
        }


        //scms_student_course_cycle insert end
        //------***------
        //------***------
        //scms_student_term_cycle start
        $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $term_cycles = $term_cycle
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['session_id' => $data['session_id']])
            ->where(['level_id' => $data['level_id']])
            ->toArray();
        foreach ($term_cycles as $term_cycle) {
            $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
            $scms_student_term_cycle_data['student_cycle_id'] = $data['student_cycle_id'];
            $scms_student_term_cycle_data['term_cycle_id'] = $term_cycle['term_cycle_id'];
            $scms_student_term_cycles = $scms_student_term_cycle
                ->find()
                ->where(['student_cycle_id' => $data['student_cycle_id']])
                ->where(['term_cycle_id' => $term_cycle['term_cycle_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

            $student_term_course_cycle_data['student_term_cycle_id'] = $scms_student_term_cycles[0]['student_term_cycle_id'];

            //scms_student_term_course_cycle insert start
            foreach ($student_course_cycle_ids as $student_course_cycle_id) {
                $student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
                $student_term_course_cycle_data['student_course_cycle_id'] = $student_course_cycle_id;
                $query = $student_term_course_cycle->query();
                $query
                    ->insert(['student_term_cycle_id', 'student_course_cycle_id'])
                    ->values($student_term_course_cycle_data)
                    ->execute();
            }
            //scms_student_term_course_cycle insert end
            //       //-----**------
            //scms_course_cycle remove start
            foreach ($remove_course_cycle as $key => $course_cycle) {
                $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
                $scms_student_term_cycles = $scms_student_term_course_cycle
                    ->find()
                    ->where(['student_course_cycle_id' => $key])
                    ->where(['student_term_cycle_id' => $student_term_course_cycle_data['student_term_cycle_id']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();

                //delete scms_term_course_cycle_part_mark start
                $scms_term_course_cycle_part_mark = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_mark');
                $query = $scms_term_course_cycle_part_mark->query();
                $query->delete()
                    ->where(['student_term_course_cycle_id' => $scms_student_term_cycles[0]['student_term_course_cycle_id']])
                    ->execute();
                //delete scms_term_course_cycle_part_mark end
                //-----**------
                //delete scms_student_term_course_cycle start
                $query = $scms_student_term_course_cycle->query();
                $query->delete()
                    ->where(['student_term_course_cycle_id' => $scms_student_term_cycles[0]['student_term_course_cycle_id']])
                    ->execute();
                //delete scms_student_term_course_cycle end
                //-----**------
                //delete scms_student_course_cycle start
                $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
                $query = $scms_student_course_cycle->query();
                $query->delete()
                    ->where(['student_course_cycle_id' => $key])
                    ->execute();
                //delete scms_student_course_cycle end
            }
            //scms_course_cycle remove end
        }

        return true;
    }

    private function upadte_third_forth_subject($course_ids, $studnet_cycle_id, $type)
    {
        $scms_third_and_forth_subject = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
        $subjects = $scms_third_and_forth_subject
            ->find()
            ->where(['student_cycle_id' => $studnet_cycle_id])
            ->where(['type' => $type])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $old_course_ids = array();
        foreach ($subjects as $subject) {
            $old_course_ids[] = $subject['course_id'];
        }
        $new_course_ids = array_diff($course_ids, $old_course_ids);
        $deleted_course_ids = array_diff($old_course_ids, $course_ids);

        if (count($new_course_ids)) {
            $new_subjects = array();
            $single_subject['type'] = $type;
            foreach ($new_course_ids as $new_course_id) {
                $single_subject['student_cycle_id'] = $studnet_cycle_id;
                $single_subject['course_id'] = $new_course_id;
                $new_subjects[] = $single_subject;
            }
            $columns = array_keys($new_subjects[0]);
            $insertQuery = $scms_third_and_forth_subject->query();
            $insertQuery->insert($columns);
            // you must always alter the values clause AFTER insert
            $insertQuery->clause('values')->values($new_subjects);
            $insertQuery->execute();
        }

        if (count($deleted_course_ids)) {
            $query = $scms_third_and_forth_subject->query();
            $query->delete()
                ->where(['course_id IN' => $deleted_course_ids])
                ->where(['student_cycle_id' => $studnet_cycle_id])
                ->execute();
        }

        return true;
    }

    private function getCoursecycle($where)
    {
        $courses_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
        $courses_cycles = $courses_cycle
            ->find()
            ->where($where)
            ->select([
                'course_name' => 'c.course_name',
            ])
            ->join([
                'c' => [
                    'table' => 'scms_courses',
                    'type' => 'LEFT',
                    'conditions' => ['c.course_id = scms_courses_cycle.course_id'],
                ],
            ])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        return $courses_cycles;
    }

    public function edit($id)
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $file = $request_data['image_name'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);

            $thumbnailFileName = null;
            $regularSizeFileName = null;

            if (in_array($ext, $arr_ext)) {
                $originalFolderPath = WWW_ROOT . '/uploads/students/large_version/'; // Specify original folder path
                if (!file_exists($originalFolderPath)) {
                    mkdir($originalFolderPath, 0777, true);
                }
                $originalImagePath = $originalFolderPath . $setNewFileName . '.' . $ext;
                move_uploaded_file($file['tmp_name'], $originalImagePath);
                $image = null;
                if ($ext == 'jpg' || $ext == 'jpeg') {
                    $image = imagecreatefromjpeg($originalImagePath);
                } else if (
                    $ext == 'png'
                ) {
                    $image = imagecreatefrompng($originalImagePath);
                }
                if ($image) {
                    $thumbnailFolderPath = WWW_ROOT . '/uploads/students/thumbnail/'; // Specify thumbnail folder path
                    if (!file_exists($thumbnailFolderPath)) {
                        mkdir($thumbnailFolderPath, 0777, true);
                    }
                    $thumbnailImagePath = $thumbnailFolderPath . $setNewFileName . '_th.' . $ext;
                    $thumbnailWidth = 300; // Change this value to adjust thumbnail width
                    $thumbnailHeight = 300; // Change this value to adjust thumbnail height
                    $thumbnailImage = imagescale($image, $thumbnailWidth, $thumbnailHeight);
                    imagejpeg($thumbnailImage, $thumbnailImagePath, 50);
                    $thumbnailFileName = $setNewFileName . '_th.' . $ext;
                    imagedestroy($thumbnailImage);
                }

                // Compress image and save regularSize version
                if ($image) {
                    $regularSizeFolderPath = WWW_ROOT . '/uploads/students/regularSize/'; // Specify regularSize folder path
                    if (!file_exists($regularSizeFolderPath)) {
                        mkdir($regularSizeFolderPath, 0777, true);
                    }
                    $regularSizeImagePath = $regularSizeFolderPath . $setNewFileName . '_rs.' . $ext;
                    $regularSizeWidth = 1020; // Change this value to adjust regularSize width
                    $regularSizeHeight = 1200; // Change this value to adjust regularSize height
                    $regularSizeImage = imagescale($image, $regularSizeWidth, $regularSizeHeight);
                    imagejpeg($regularSizeImage, $regularSizeImagePath, 95);
                    $regularSizeFileName = $setNewFileName . '_rs.' . $ext;
                    imagedestroy($regularSizeImage);
                    $student_data['thumbnail'] = $thumbnailFileName;
                    $student_data['regular_size'] = $regularSizeFileName;
                }

                unlink($originalImagePath);
            }

            if ($thumbnailFileName == null) {
                unset($request_data['thumbnail']);
                unset($request_data['regular_size']);
            }
            $student_id = $request_data['student_id'];
            $student_data['name'] = $request_data['name'];
            $student_data['name_bn'] = $request_data['name_bn'];
            $student_data['mobile'] = $request_data['mobile'];
            $student_data['email'] = $request_data['email'];
            $student_data['telephone'] = $request_data['telephone'];
            $student_data['date_of_birth'] = $request_data['date_of_birth'];
            $student_data['national_id'] = $request_data['national_id'];
            $student_data['birth_registration'] = $request_data['birth_registration'];
            $student_data['permanent_address'] = $request_data['permanent_address'];
            $student_data['present_address'] = $request_data['present_address'];
            $student_data['gender'] = $request_data['gender'];
            $student_data['religion'] = $request_data['religion'];
            $student_data['blood_group'] = $request_data['blood_group'];
            $student_data['marital_status'] = $request_data['marital_status'];
            $student_data['date_of_admission'] = $request_data['date_of_admission'];
            $student_data['nationality'] = $request_data['nationality'];
            $student_data['freedom_fighter'] = $request_data['freedom_fighter'];
            $student_data['tribal'] = $request_data['tribal'];
            $student_data['disabled'] = $request_data['disabled'];
            $student_data['orphan'] = $request_data['orphan'];
            $student_data['part_time_job'] = $request_data['part_time_job'];
            $student_data['job_type'] = $request_data['job_type'];
            $student_data['stipend'] = $request_data['stipend'];
            $student_data['scholership'] = $request_data['scholership'];
            $student_data['session_id'] = $request_data['session_id'];
            $student_data['religion_subject'] = $request_data['religion_subject'];
            $student_data['status'] = $request_data['status'];
            $student_data['active_guardian'] = $request_data['active_guardian'];
            // $student_data['institute_name'] = $request_data['institute_name'];

            if ($thumbnailFileName == null) {
                unset($student_data['thumbnail']);
                unset($student_data['regular_size']);
            }
            foreach ($student_data as $key => $data) {
                if ($data == '-- Choose --') {
                    $student_data[$key] = null;
                }
            }
            $students = TableRegistry::getTableLocator()->get('scms_students');
            $query = $students->query();
            $query->update()
                ->set($student_data)
                ->where(['student_id' => $student_id])
                ->execute();

            $student_cycle_id = $request_data['student_cycle_id'];
            $student_cycle_data['level_id'] = $request_data['level_id'];
            $student_cycle_data['group_id'] = isset($request_data['group_id']) ? $request_data['group_id'] : null;
            $student_cycle_data['shift_id'] = $request_data['shift_id'];
            $student_cycle_data['section_id'] = $request_data['section_id'];
            $student_cycle_data['session_id'] = $request_data['session_id'];
            $student_cycle_data['roll'] = $request_data['roll'];
            $student_cycle_data['resedential'] = $request_data['resedential'];

            foreach ($student_cycle_data as $key => $data) {
                if ($data == '-- Choose --') {
                    $student_cycle_data[$key] = null;
                }
            }

            $student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $query = $student_cycle->query();
            $query->update()
                ->set($student_cycle_data)
                ->where(['student_cycle_id' => $student_cycle_id])
                ->execute();

            if (isset($request_data['qualification_id'])) {
                foreach ($request_data['qualification_id'] as $key => $qualification_id) {
                    $education_data['exam_name'] = $request_data['exam_name'][$key];
                    $education_data['exam_board'] = $request_data['exam_board'][$key];
                    $education_data['exam_session'] = $request_data['exam_session'][$key];
                    $education_data['exam_roll'] = $request_data['exam_roll'][$key];
                    $education_data['exam_registration'] = $request_data['exam_registration'][$key];
                    $education_data['institute'] = $request_data['institute'][$key];
                    $education_data['grade'] = $request_data['grade'][$key];
                    $education_data['group_name'] = $request_data['group_name'][$key];
                    $education_data['gpa'] = $request_data['gpa'][$key];
                    $education_data['passing_year'] = $request_data['passing_year'][$key];
                    $education_data['student_id'] = $request_data['student_id'];

                    $qualification = TableRegistry::getTableLocator()->get('scms_qualification');
                    $query = $qualification->query();
                    $query->update()
                        ->set($education_data)
                        ->where(['qualification_id' => $qualification_id])
                        ->execute();
                }
            }


            foreach ($request_data['g_relation'] as $key => $relation) {
                $guardian_data[$key]['id'] = $request_data['g_id'][$key];
                $guardian_data[$key]['relation'] = $request_data['g_relation'][$key];
                $guardian_data[$key]['name'] = $request_data['g_name'][$key];
                $guardian_data[$key]['name_bn'] = $request_data['g_name_bn'][$key];
                $guardian_data[$key]['mobile'] = $request_data['g_mobile'][$key];
                $guardian_data[$key]['nid'] = $request_data['g_nid'][$key];
                $guardian_data[$key]['birth_reg'] = $request_data['g_birth_reg'][$key];
                $guardian_data[$key]['occupation'] = $request_data['g_occupation'][$key];
                $guardian_data[$key]['yearly_income'] = $request_data['g_income'][$key];
                $guardian_data[$key]['nationality'] = $request_data['g_nationality'][$key];
                $guardian_data[$key]['religion'] = $request_data['g_religion'][$key];
                $guardian_data[$key]['gender'] = $request_data['g_gender'][$key];
                $guardian_data[$key]['student_id'] = $request_data['student_id'];
                $guardian_data[$key]['rtype'] = $request_data['g_relation'][$key];
            }
            foreach ($guardian_data as $key1 => $guardians) {
                foreach ($guardians as $key2 => $data) {
                    if ($data == '-- Choose --') {
                        $guardian_data[$key1][$key2] = null;
                    }
                }
                $id = $guardians['id'];
                $guardian = TableRegistry::getTableLocator()->get('scms_guardians');
                $query = $guardian->query();
                $query->update()
                    ->set($guardians)
                    ->where(['id' => $id])
                    ->execute();
            }

            $this->studnet_course_cycle_edit($request_data);
            //Set Flash
            $this->Flash->info('Student Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);

            return $this->redirect(['action' => 'index']);
        }



        $scms_students_data_settings_value = TableRegistry::getTableLocator()->get('scms_students_data_settings_value');
        $values = $scms_students_data_settings_value
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                "name" => "s.name",
                "type_id" => "s.type_id",
                "heading" => "g.heading",
            ])
            ->join([
                's' => [
                    'table' => ' scms_students_data_settings',
                    'type' => 'INNER',
                    'conditions' => [' s.id  = scms_students_data_settings_value.scms_students_data_settings_id'],
                ],
            ])
            ->join([
                'g' => [
                    'table' => ' scms_students_data_settings_group',
                    'type' => 'INNER',
                    'conditions' => [' g.id  = scms_students_data_settings_value.scms_students_data_settings_group_id'],
                ],
            ])
            ->toArray();

        foreach ($values as $value) {
            //            pr($value);die;

            $filter_data[$value['heading']][$value['scms_students_data_settings_id']] = $value;
        }
        //        pr($filter_data);die;
        $this->set('values', $filter_data);
        $basic = TableRegistry::getTableLocator()->get('scms_students'); //Execute First
        $basics = $basic
            ->find()
            ->where(['student_id' => $id])
            ->toArray();

        if (count($basics) == 0) {
            $this->Flash->error('No Student Found', [
                'key' => 'positive',
                'params' => [],
            ]);

            return $this->redirect(['action' => 'index']);
        }
        // echo '<pre>';
        // print_r($basics);die;
        $this->set('student', $basics[0]);

        $guardian = TableRegistry::getTableLocator()->get('scms_guardians'); //Execute First
        $guardians = $guardian
            ->find()
            ->where(['student_id' => $id])
            ->toArray();
        foreach ($guardians as $key => $guardian) {
            $guardians_data[strtolower($guardian->rtype)] = $guardian;
        }

        $this->set('guardians', $guardians_data);



        $role_id = $this->Auth->user('role_id');
        if ($role_id == 1) {
            $student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $student_cycles = $student_cycle
                ->find()
                ->where(['session_id' => $basics[0]->session_id])
                ->where(['student_id' => $basics[0]->student_id])
                ->toArray();
        } else {
            $id = $this->Auth->user('id');
            $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $permissions = $employees_permission->find()
                ->where(['user_id' => $id])
                ->where(['employees_permission.type' => 'students'])
                ->where(['session_id' => $basics[0]->session_id])
                ->where(['level_id' => $basics[0]->level_id])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->join([
                    'employee' => [
                        'table' => 'employee',
                        'type' => 'INNER',
                        'conditions' => [
                            'employee.employee_id = employees_permission.employee_id'
                        ]
                    ],
                ])
                ->toArray();
            $section_ids = array();
            foreach ($permissions as $permission) {
                $section_ids[$permission['section_id']] = $permission['section_id'];
            }
            if (count($section_ids)) {
                $section_ids = array_values($section_ids);
                $student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
                $student_cycles = $student_cycle
                    ->find()
                    ->where(['session_id' => $basics[0]->session_id])
                    ->where(['student_id' => $basics[0]->student_id])
                    ->where(['section_id IN' => $section_ids])
                    ->toArray();
            } else {
                $student_cycles = array();
            }
        }
        if (count($student_cycles) == 0) {
            $this->Flash->error('No Student Found', [
                'key' => 'positive',
                'params' => [],
            ]);

            return $this->redirect(['action' => 'index']);
        }
        $this->set('student_cycle', $student_cycles[0]);

        //Academic information

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->where(['session_id' => $basics[0]->session_id])
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->toArray();
        $this->set('levels', $levels);

        $section = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $section
            ->find()
            ->where(['shift_id' => $student_cycles[0]->shift_id])
            ->where(['level_id' => $student_cycles[0]->level_id])
            ->toArray();
        $this->set('sections', $sections);

        $groups = array();
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        $this->set('groups', $groups);

        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $religion = $course
            ->find()
            ->where(['course_type_id' => 5])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('religion', $religion);

        if ($student_cycles[0]->group_id) {
            $forth_and_third_subject_1 = $course
                ->find()
                ->where(['course_type_id' => 3])
                ->where(['course_group_id' => $student_cycles[0]->group_id])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

            $forth_and_third_subject_2 = $course
                ->find()
                ->where(['course_type_id' => 3])
                ->where(['course_group_id is NULL'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
            $forth_and_third_subject = array_merge($forth_and_third_subject_1, $forth_and_third_subject_2);
        } else {
            $forth_and_third_subject = $course
                ->find()
                ->where(['course_type_id' => 3])
                ->where(['course_group_id is NULL'])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        }

        $third_subjects = array();
        $forth_subjects = array();

        foreach ($forth_and_third_subject as $forth_and_third) {
            $forth_and_third['selected'] = null;
            $third_subjects[$forth_and_third['course_id']] = $forth_and_third;
            $forth_subjects[$forth_and_third['course_id']] = $forth_and_third;
        }
        $scms_third_and_forth_subject = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
        $studnet_third_and_forth_subjects = $scms_third_and_forth_subject
            ->find()
            ->where(['student_cycle_id' => $student_cycles[0]->student_cycle_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        foreach ($studnet_third_and_forth_subjects as $studnet_third_and_forth_subject) {
            if ($studnet_third_and_forth_subject['type'] == 'third') {
                if (isset($third_subjects[$studnet_third_and_forth_subject['course_id']])) {
                    $third_subjects[$studnet_third_and_forth_subject['course_id']]['selected'] = 'selected';
                }
            } else if ($studnet_third_and_forth_subject['type'] == 'forth') {
                if (isset($forth_subjects[$studnet_third_and_forth_subject['course_id']])) {
                    $forth_subjects[$studnet_third_and_forth_subject['course_id']]['selected'] = 'selected';
                }
            }
        }
        $this->set('forth_subjects', $forth_subjects);
        $this->set('third_subjects', $third_subjects);
        $get_education = TableRegistry::getTableLocator()->get('scms_qualification');
        $get_educations = $get_education->find()->where(['student_id' => $basics[0]['student_id']])->toArray();
        //        pr($get_educations[0]->qualification_id);die;

        $this->set('educations', $get_educations);
    }

    private function deleteStudentCycle($ids)
    {
        $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
        $student_term_cycle = $scms_student_term_cycle->find()->where(['student_cycle_id IN' => $ids])->toArray();
        $student_term_cycle_ids = array();
        foreach ($student_term_cycle as $term_cycle) {
            $student_term_cycle_ids[] = $term_cycle['student_term_cycle_id'];
        }
        if (count($student_term_cycle_ids)) {
            $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
            $query = $scms_student_term_course_cycle->query();
            $query->delete()
                ->where(['student_term_cycle_id  IN' => $student_term_cycle_ids])
                ->execute();
            $query = $scms_student_term_cycle->query();
            $query->delete()
                ->where(['student_term_cycle_id  IN' => $student_term_cycle_ids])
                ->execute();
        }
        $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
        $query = $scms_student_course_cycle->query();
        $query->delete()
            ->where(['student_cycle_id IN' => $ids])
            ->execute();

        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $query = $scms_student_cycle->query();
        $query->delete()
            ->where(['student_cycle_id IN' => $ids])
            ->execute();
        return true;
    }

    public function deleteCycle($id)
    {
        $this->deleteStudentCycle($id);
        $this->Flash->success('Student Deleted', [
            'key' => 'Positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'index']);
    }

    // public function index() {

    //     if ($this->request->is(['post'])) {
    //         $request_data = $this->request->getData();

    //         $where['scms_student_cycle.session_id'] = $request_data['session_id'];
    //         if ($request_data['shift_id']) {
    //             $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
    //         }
    //         if ($request_data['level_id']) {
    //             $where['scms_student_cycle.level_id'] = $request_data['level_id'];
    //         }
    //         if ($request_data['section_id']) {
    //             $where['scms_student_cycle.section_id'] = $request_data['section_id'];
    //         }
    //         if ($request_data['sid']) {
    //             $where['s.sid'] = $request_data['sid'];
    //         }
    //         if ($request_data['status']) {
    //             if ($request_data['status'] == -1) {
    //                 $where['s.status'] = 0;
    //             } else {
    //                 $where['s.status'] = 1;
    //             }
    //         }
    //         $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
    //         $scms_student_cycles = $scms_student_cycle->find()->where($where)
    //                         ->enableAutoFields(true)
    //                         ->enableHydration(false)
    //                         ->select([
    //                             'name' => "s.name",
    //                             'gender' => "s.gender",
    //                             'sid' => "s.sid",
    //                             'mobile' => 's.mobile',
    //                             'thumbnail' => 's.thumbnail',
    //                             'permanent_address' => "s.permanent_address",
    //                             'present_address' => "s.present_address",
    //                             'date_of_birth' => "s.date_of_birth",
    //                             'blood_group' => "s.blood_group",
    //                             'status' => "s.status",
    //                             'shift_name' => "shift.shift_name",
    //                             'level_name' => "level.level_name",
    //                             'section_name' => "section.section_name",
    //                             'session_name' => "session.session_name",
    //                             'group_name' => "scms_groups.group_name",
    //                             'thrid_subject_name' => "course.course_name",
    //                             'forth_subject_name' => "course1.course_name",
    //                             'religion_subject' => "religion.course_name",
    //                         ])
    //                          ->group('sid')
    //                         ->order(['scms_student_cycle.level_id' => 'ASC', 'scms_student_cycle.section_id' => 'ASC', 'roll' => 'ASC'])
    //                         ->join([
    //                             's' => [
    //                                 'table' => 'scms_students',
    //                                 'type' => 'INNER',
    //                                 'conditions' => [
    //                                     's.student_id = scms_student_cycle.student_id'
    //                                 ]
    //                             ],
    //                             'shift' => [
    //                                 'table' => 'hr_shift',
    //                                 'type' => 'INNER',
    //                                 'conditions' => [
    //                                     'shift.shift_id = scms_student_cycle.shift_id'
    //                                 ]
    //                             ],
    //                             'level' => [
    //                                 'table' => 'scms_levels',
    //                                 'type' => 'INNER',
    //                                 'conditions' => [
    //                                     'level.level_id = scms_student_cycle.level_id'
    //                                 ]
    //                             ],
    //                             'section' => [
    //                                 'table' => 'scms_sections',
    //                                 'type' => 'INNER',
    //                                 'conditions' => [
    //                                     'section.section_id = scms_student_cycle.section_id'
    //                                 ]
    //                             ],
    //                             'session' => [
    //                                 'table' => 'scms_sessions',
    //                                 'type' => 'INNER',
    //                                 'conditions' => [
    //                                     'session.session_id  = scms_student_cycle.session_id'
    //                                 ]
    //                             ],
    //                             'scms_groups' => [
    //                                 'table' => 'scms_groups',
    //                                 'type' => 'LEFT',
    //                                 'conditions' => [
    //                                     'scms_student_cycle.group_id  = scms_groups.group_id'
    //                                 ]
    //                             ],
    //                             'scms_third_and_forth_subject' => [
    //                                 'table' => 'scms_third_and_forth_subject',
    //                                 'type' => 'LEFT',
    //                                 'conditions' => [
    //                                     'scms_third_and_forth_subject.student_cycle_id  = scms_student_cycle.student_cycle_id',
    //                                     'scms_third_and_forth_subject.type' => 'third',
    //                                 ]
    //                             ],
    //                             'scms_third_and_forth_subject_1' => [
    //                                 'table' => 'scms_third_and_forth_subject',
    //                                 'type' => 'LEFT',
    //                                 'conditions' => [
    //                                     'scms_third_and_forth_subject_1.student_cycle_id  = scms_student_cycle.student_cycle_id',
    //                                     'scms_third_and_forth_subject_1.type' => 'forth'
    //                                 ]
    //                             ],
    //                             'course' => [
    //                                 'table' => 'scms_courses',
    //                                 'type' => 'LEFT',
    //                                 'conditions' => [
    //                                     'course.course_id  = scms_third_and_forth_subject.course_id'
    //                                 ]
    //                             ],
    //                             'course1' => [
    //                                 'table' => 'scms_courses',
    //                                 'type' => 'LEFT',
    //                                 'conditions' => [
    //                                     'course1.course_id  = scms_third_and_forth_subject_1.course_id'
    //                                 ]
    //                             ],
    //                             'religion' => [
    //                                 'table' => 'scms_courses',
    //                                 'type' => 'LEFT',
    //                                 'conditions' => [
    //                                     'religion.course_id  = s.religion_subject'
    //                                 ]
    //                             ],
    //                         ])->toArray();
    //         $this->set('students', $scms_student_cycles);
    //         $head = $this->set_head($request_data);
    //         $this->set('head', $head);
    //     }
    //     $session = TableRegistry::getTableLocator()->get('scms_sessions');
    //     $sessions = $session
    //             ->find()
    //             ->order(['session_name' => 'DESC'])
    //             ->toArray();
    //     $this->set('sessions', $sessions);

    //     $levels = $this->get_levels();
    //     $this->set('levels', $levels);
    //     $shift = TableRegistry::getTableLocator()->get('hr_shift');
    //     $shifts = $shift
    //             ->find()
    //             ->enableAutoFields(true)
    //             ->enableHydration(false)
    //             ->toArray();
    //     $this->set('shifts', $shifts);
    // }

    public function index()
    {
        $value['session_id'] = null;
        $value['shift_id'] = null;
        $value['level_id'] = null;
        $value['section_id'] = null;
        $value['sid'] = null;
        $value['name'] = null;
        $value['roll'] = null;
        $value['religion'] = null;
        $value['status'] = null;

        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();

            $where['scms_student_cycle.session_id'] = $request_data['session_id'];
            if ($request_data['shift_id']) {
                $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
            }
            if ($request_data['level_id']) {
                $where['scms_student_cycle.level_id'] = $request_data['level_id'];
            }
            if ($request_data['section_id']) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if ($request_data['sid']) {
                $where['s.sid'] = $request_data['sid'];
            }
            if (!empty($request_data['name'])) {
                $name = $request_data['name'];
                $where[] = ['s.name LIKE' => "%$name%"];
            }
            if ($request_data['roll']) {
                $where['scms_student_cycle.roll'] = $request_data['roll'];
            }
            if ($request_data['religion']) {
                $where['s.religion'] = $request_data['religion'];
            }
            if ($request_data['status']) {
                if ($request_data['status'] == -1) {
                    $where['s.status'] = 0;
                } else {
                    $where['s.status'] = 1;
                }
            }
            $this->set('where', $where);
            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $scms_student_cycles = $scms_student_cycle->find()->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'name' => "s.name",
                    'gender' => "s.gender",
                    'sid' => "s.sid",
                    'mobile' => 'father.mobile',
                    'father_name' => 'father.name',
                    'mother_name' => 'mother.name',
                    'thumbnail' => 's.thumbnail',
                    'active_guardian' => 's.active_guardian',
                    'permanent_address' => "s.permanent_address",
                    'present_address' => "s.present_address",
                    'freedom_fighter' => "s.freedom_fighter",
                    'disabled' => "s.disabled",
                    'scholership' => "s.scholership",
                    'stipend' => "s.stipend",
                    'date_of_birth' => "s.date_of_birth",
                    'blood_group' => "s.blood_group",
                    'status' => "s.status",
                    'shift_name' => "shift.shift_name",
                    'level_name' => "level.level_name",
                    'section_name' => "section.section_name",
                    'session_name' => "session.session_name",
                    'group_name' => "scms_groups.group_name",
                    'thrid_subject_name' => "course.course_name",
                    'forth_subject_name' => "course1.course_name",
                    'religion_subject' => "religion.course_name",
                ])
                ->order(['scms_student_cycle.level_id' => 'ASC', 'scms_student_cycle.section_id' => 'ASC', 'roll' => 'ASC'])
                ->join([
                    's' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            's.student_id = scms_student_cycle.student_id',
                        ]
                    ],
                    'father' => [
                        'table' => 'scms_guardians',
                        'type' => 'INNER',
                        'conditions' => [
                            'father.student_id = scms_student_cycle.student_id',
                            'father.rtype' => 'Father',
                        ]
                    ],
                    'mother' => [
                        'table' => 'scms_guardians',
                        'type' => 'INNER',
                        'conditions' => [
                            'mother.student_id = scms_student_cycle.student_id',
                            'mother.rtype' => 'Mother',
                        ]
                    ],
                    'shift' => [
                        'table' => 'hr_shift',
                        'type' => 'INNER',
                        'conditions' => [
                            'shift.shift_id = scms_student_cycle.shift_id'
                        ]
                    ],
                    'level' => [
                        'table' => 'scms_levels',
                        'type' => 'INNER',
                        'conditions' => [
                            'level.level_id = scms_student_cycle.level_id'
                        ]
                    ],
                    'section' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'section.section_id = scms_student_cycle.section_id'
                        ]
                    ],
                    'session' => [
                        'table' => 'scms_sessions',
                        'type' => 'INNER',
                        'conditions' => [
                            'session.session_id  = scms_student_cycle.session_id'
                        ]
                    ],
                    'scms_groups' => [
                        'table' => 'scms_groups',
                        'type' => 'LEFT',
                        'conditions' => [
                            'scms_student_cycle.group_id  = scms_groups.group_id'
                        ]
                    ],
                    'scms_third_and_forth_subject' => [
                        'table' => 'scms_third_and_forth_subject',
                        'type' => 'LEFT',
                        'conditions' => [
                            'scms_third_and_forth_subject.student_cycle_id  = scms_student_cycle.student_cycle_id',
                            'scms_third_and_forth_subject.type' => 'third',
                        ]
                    ],
                    'scms_third_and_forth_subject_1' => [
                        'table' => 'scms_third_and_forth_subject',
                        'type' => 'LEFT',
                        'conditions' => [
                            'scms_third_and_forth_subject_1.student_cycle_id  = scms_student_cycle.student_cycle_id',
                            'scms_third_and_forth_subject_1.type' => 'forth'
                        ]
                    ],
                    'course' => [
                        'table' => 'scms_courses',
                        'type' => 'LEFT',
                        'conditions' => [
                            'course.course_id  = scms_third_and_forth_subject.course_id'
                        ]
                    ],
                    'course1' => [
                        'table' => 'scms_courses',
                        'type' => 'LEFT',
                        'conditions' => [
                            'course1.course_id  = scms_third_and_forth_subject_1.course_id'
                        ]
                    ],
                    'religion' => [
                        'table' => 'scms_courses',
                        'type' => 'LEFT',
                        'conditions' => [
                            'religion.course_id  = s.religion_subject'
                        ]
                    ],
                ])->toArray();


            if (empty($scms_student_cycles)) {
                $this->set('flashMessage', [
                    'message' => 'No Student Found',
                    'type' => 'info',
                    'key' => 'positive',
                    'escape' => false, // Disable escaping for HTML
                ]);
                $this->set('students', []);
                $value = $request_data;
                $this->set('value', $value);
            } else {
                $student = $this->get_guardians($scms_student_cycles);
                $this->set('students', $student);
                $head = $this->set_head($request_data);
                $this->set('head', $head);
                $value = $request_data;
                $this->set('value', $value);
            }
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);
        $levels = $this->get_levels('students');
        $this->set('levels', $levels);

        $sections = $this->get_sections('students', $levels[0]->level_id);
        $this->set('sections', $sections);

        $this->set('data', $value);

        $required = 'required';
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles)) {
            $required = '';
        }
        $this->set('required', $required);

        $shifts = $this->get_shifts('students');
        $this->set('shifts', $shifts);
        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);
    }
    
    

    // private function get_guardians($scms_student_cycles)
    // {

    //     $scms_guardian = TableRegistry::getTableLocator()->get('scms_guardians');
    //     $scms_guardians = $scms_guardian->find()->enableAutoFields(true)->enableHydration(false)->where(['student_id' => $student['student_id']])->toArray();
    //     $guardians = array();
    //     foreach ($scms_guardians as $scms_guardian) {
    //         $guardians[strtolower($scms_guardian['rtype'])] = $scms_guardian;
    //     }
    //     $student['guardians'] = $guardians;

    //     return $student;
    // }

    private function get_guardians($scms_student_cycles)
    {
        $scms_guardian_table = TableRegistry::getTableLocator()->get('scms_guardians');

        $student_ids = array_column($scms_student_cycles, 'student_id');

        $scms_guardians = $scms_guardian_table->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['student_id IN' => $student_ids])
            ->toArray();

        // Map guardians by student_id
        $guardians_map = [];
        foreach ($scms_guardians as $guardian) {
            $rtype = strtolower($guardian['rtype']);
            $guardians_map[$guardian['student_id']][$rtype] = $guardian;
        }

        // Add guardians to each student record
        foreach ($scms_student_cycles as &$student) {
            $student['guardians'] = $guardians_map[$student['student_id']] ?? [];
        }


        return $scms_student_cycles;
    }


    public function activeStatus()
    {

        $value['start_date'] = null;
        $value['end_date'] = null;
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();

            $startDate = $request_data['start_date'];
            $endDate = $request_data['end_date'];


            if (!empty($startDate)) {
                $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
                $endDate = !empty($endDate)
                    ? date('Y-m-d 23:59:59', strtotime($endDate))
                    : $startDate;

                // Set the date range for the query
                $where = [
                    'date BETWEEN :startDate AND :endDate'
                ];
            }

            // Get the table instance
            $studentLog = TableRegistry::getTableLocator()->get('students_log');
            $query = $studentLog
                ->find()
                ->where($where)
                ->bind(':startDate', $startDate, 'datetime')
                ->bind(':endDate', $endDate, 'datetime')
                ->toArray();

            $this->set('data', $request_data);
            $this->set('students', $query);
            $value = $request_data;
        }
        $this->set('data', $value);
    }

    private function set_head($request_data)
    {
        $head['session_name'] = null;
        $head['shift_name'] = null;
        $head['level_name'] = null;
        $head['section_name'] = null;
        $head['sid'] = null;
        $head['ststus'] = null;
        $head['course_name'] = null;
        $head['term_name'] = null;
        $head['sid'] = null;
        $head['part'] = null;

        if (isset($request_data['term_course_cycle_part_id']) && $request_data['term_course_cycle_part_id']) {
            $term_course_cycle_part = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part');
            $displaypart = $term_course_cycle_part
                ->find()
                ->where(['term_course_cycle_part_id' => $request_data['term_course_cycle_part_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term_course_cycle_part_type_name' => 'tccpt.term_course_cycle_part_type_name',
                ])
                ->join([
                    'tccpt' => [
                        'table' => 'scms_term_course_cycle_part_type',
                        'type' => 'LEFT',
                        'conditions' => ['tccpt.term_course_cycle_part_type_id  = scms_term_course_cycle_part.term_course_cycle_part_type_id'],
                    ],
                ])
                ->toArray();
            $head['part'] = $displaypart[0]['term_course_cycle_part_type_name'];
        }

        if (isset($request_data['term_cycle_id']) && $request_data['term_cycle_id']) {
            $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
            $displayTerm = $term_cycle->find()->where(['term_cycle_id' => $request_data['term_cycle_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term_name' => "term.term_name"
                ])
                ->join([
                    'term' => [
                        'table' => 'scms_term',
                        'type' => 'INNER',
                        'conditions' => [
                            'term.term_id = scms_term_cycle.term_id'
                        ]
                    ],
                ])->toArray();
            $head['term_name'] = $displayTerm[0]['term_name'];
        }
        if (isset($request_data['courses_cycle_id']) && $request_data['courses_cycle_id']) {
            $course_cycle = TableRegistry::getTableLocator()->get('scms_courses_cycle');
            $displayCourse = $course_cycle->find()->where(['courses_cycle_id' => $request_data['courses_cycle_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'course_name' => "course.course_name",
                    'course_code' => 'course.course_code',
                    'course_type_name' => 'course_type.course_type_name'
                ])
                ->join([
                    'course' => [
                        'table' => 'scms_courses',
                        'type' => 'INNER',
                        'conditions' => [
                            'course.course_id = scms_courses_cycle.course_id'
                        ]
                    ],
                    'course_type' => [
                        'table' => 'scms_course_type',
                        'type' => 'INNER',
                        'conditions' => [
                            'course_type.course_type_id = course.course_type_id'
                        ]
                    ],
                ])->toArray();
            $head['course_name'] = $displayCourse[0];
        }
        if (isset($request_data['sid']) && $request_data['sid']) {

            $head['sid'] = $request_data['sid'];
        }
        if (isset($request_data['session_id']) && $request_data['session_id']) {
            $session = TableRegistry::getTableLocator()->get('scms_sessions');
            $sessions_display = $session
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['session_id' => $request_data['session_id']])
                ->toArray();

            $head['session_name'] = $sessions_display[0]['session_name'];
        }
        if (isset($request_data['level_id']) && $request_data['level_id']) {
            $level = TableRegistry::getTableLocator()->get('scms_levels');
            $level_display = $level
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['level_id' => $request_data['level_id']])
                ->toArray();
            $head['level_name'] = $level_display[0]['level_name'];
        }
        if (isset($request_data['shift_id']) && $request_data['shift_id']) {
            $shift = TableRegistry::getTableLocator()->get('hr_shift');
            $shifts_display = $shift
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['shift_id' => $request_data['shift_id']])
                ->toArray();
            $head['shift_name'] = $shifts_display[0]['shift_name'];
        }
        if (isset($request_data['section_id']) && $request_data['section_id']) {

            $section = TableRegistry::getTableLocator()->get('scms_sections');
            $section_display = $section
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['section_id' => $request_data['section_id']])
                ->toArray();
            $head['section_name'] = $section_display[0]['section_name'];
        }
        if (isset($request_data['status']) && $request_data['status']) {
            if ($request_data['status'] == -1) {
                $head['ststus'] = " In-Active";
            } else {
                $head['ststus'] = " Active";
            }
        }
        return $head;
    }

    private function get_template_details($id)
    {
        $scms_promotion_template = TableRegistry::getTableLocator()->get('scms_promotion_template');
        $prmotion_templates = $scms_promotion_template->find()->where(['promotion_template_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'session_from_name' => "session_from.session_name",
                'session_to_name' => "session_to.session_name",
                'term_name' => "scms_term.term_name",
            ])
            ->join([
                'session_from' => [
                    'table' => 'scms_sessions',
                    'type' => 'INNER',
                    'conditions' => [
                        'session_from.session_id = scms_promotion_template.session_from'
                    ]
                ],
                'session_to' => [
                    'table' => 'scms_sessions',
                    'type' => 'INNER',
                    'conditions' => [
                        'session_to.session_id = scms_promotion_template.session_to'
                    ]
                ],
                'scms_term' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_term.term_id = scms_promotion_template.term_id'
                    ]
                ]
            ])->toArray();
        return $prmotion_templates;
    }

    private function get_students_from_cycle($data, $section_ids, $template)
    {
        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $result_students = $scms_student_cycle->find()
            ->where(['scms_student_cycle.section_id IN' => $section_ids])
            ->where(['scms_student_cycle.level_id' => $data['level_from']])
            ->where(['scms_students.status' => 1])
            ->where(['scms_student_cycle.session_id IN' => $template['session_from']])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'section_id_from_cycle' => "scms_student_cycle.section_id",
            ])
            ->join([
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_student_cycle.student_id  = scms_students.student_id',
                                    'scms_students.status' => 1
                    ]
                ],
            ])->toArray();

        $return['promote_students'] = $result_students;
        $return['fail_students'] = array();
        return $return;
    }

    private function get_students_from_result($result_id, $section_ids, $template)
    {
        $scms_result_students = TableRegistry::getTableLocator()->get('scms_result_students');
        $result_students = $scms_result_students->find()
            ->where(['scms_result_students.result_id' => $result_id])
            ->where(['scms_student_cycle.section_id IN' => $section_ids])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'section_id_from_cycle' => "scms_student_cycle.section_id",
                'roll' => "scms_student_cycle.roll",
                'student_id' => "scms_student_cycle.student_id",
                'grp_id' => "scms_groups.group_id",
                'third_course_id' => "third_course.course_id",
                'third_course_name' => "third_course.course_name",
                'forth_course_id' => "forth_course.course_id",
                'forth_course_name' => "forth_course.course_name",
                'sid' => "scms_students.sid",
                'status' => "scms_students.status",
            ])
            ->join([
                'scms_student_term_cycle' => [
                    'table' => 'scms_student_term_cycle',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_student_term_cycle.student_term_cycle_id = scms_result_students.student_term_cycle_id'
                    ]
                ],
                'scms_student_cycle' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_student_term_cycle.student_cycle_id = scms_student_cycle.student_cycle_id'
                    ]
                ],
                'scms_groups' => [
                    'table' => 'scms_groups',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_groups.group_id = scms_student_cycle.group_id'
                    ]
                ],
                '3rd' => [
                    'table' => 'scms_third_and_forth_subject',
                    'type' => 'LEFT',
                    'conditions' => [
                        '3rd.student_cycle_id = scms_student_cycle.student_cycle_id',
                        '3rd.type' => 'third',
                    ]
                ],
                'third_course' => [
                    'table' => 'scms_courses',
                    'type' => 'LEFT',
                    'conditions' => [
                        'third_course.course_id = 3rd.course_id',
                    ]
                ],
                '4th' => [
                    'table' => 'scms_third_and_forth_subject',
                    'type' => 'LEFT',
                    'conditions' => [
                        '4th.student_cycle_id = scms_student_cycle.student_cycle_id',
                        '4th.type' => 'forth',
                    ]
                ],
                'forth_course' => [
                    'table' => 'scms_courses',
                    'type' => 'LEFT',
                    'conditions' => [
                        'forth_course.course_id = 4th.course_id',
                    ]
                ],
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_students.student_id = scms_student_cycle.student_id',
                        'scms_students.status' => 1
                    ]
                ]

            ])->toArray();
        // echo 'get_students_from_result';
        // echo '<pre>';
        // print_r($result_students);
        // die;
        $filter_result_student = array();
        $result_student_ids = array();
        foreach ($result_students as $result_student) {
            $result_student['fail_count'] = 0;
            $filter_result_student[$result_student['result_student_id']] = $result_student;
            $result_student_ids[] = $result_student['result_student_id'];
        }

        $scms_result_student_courses = TableRegistry::getTableLocator()->get('scms_result_student_courses');
        $result_student_fail_courses = $scms_result_student_courses->find()
            ->where(['result_student_id IN' => $result_student_ids])
            ->where(['parent_result_student_course_id IS NULL'])
            ->where(['grade' => 'F'])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        foreach ($result_student_fail_courses as $result_student_fail_course) {
            $filter_result_student[$result_student_fail_course['result_student_id']]['fail_count']++;
        }
        $return = array();
        if (isset($template['promote_fail']) && $template['promote_fail']) {
            if (isset($template['fail_course_count']) && $template['fail_course_count']) {
                foreach ($filter_result_student as $student) {
                    if ($template['fail_course_count'] > $student['fail_count']) {
                        $return['promote_students'][] = $student;
                    } else {
                        $return['fail_students'][] = $student;
                    }
                }
            } else {
                foreach ($filter_result_student as $student) {
                    $return['promote_students'][] = $student;
                }
            }
        } else {
            foreach ($filter_result_student as $student) {
                if ($student['result'] == 'pass') {
                    $return['promote_students'][] = $student;
                } else {
                    $return['fail_students'][] = $student;
                }
            }
        }
        // echo '<pre>';
        // print_r($return);
        // die;
        return $return;
    }

    private function genarate_promotion_roll($session_name, $level_id, $section_ids, $fail = false)
    {
        if ($this->get_settings_value('Promotion.Roll.Calulative')) {
            $session_name = strval($session_name % 100);
            $roll = $fail ? '501' : '01';
            if ($level_id < 10) {
                $level_id = '0' . $level_id;
            } else {
                $level_id = strval($level_id);
            }
            $calculative_roll = (int) $session_name . $level_id . $roll;
        } else {
            $calculative_roll = $fail ? '501' : '01';
        }
        $section_roll = array();
        foreach ($section_ids as $section_id) {
            $section_roll[$section_id] = $calculative_roll;
        }
        return $section_roll;
    }

    // private function crate_student_cycles_for_promotion($student_cycle_data, $saved_student_cycle)
    // {
    //     echo '<pre>';
    //     print_r($student_cycle_data);
    //     die;
    //     $ids = [];
    //     $hasGroupId = false;

    //     // Collect student_cycle_ids and check for group_id
    //     foreach ($saved_student_cycle as $e) {
    //         if (!empty($e->group_id)) {
    //             $hasGroupId = true;
    //         }
    //         $ids[] = $e->student_cycle_id;
    //     }

    //     // Initialize subjects array
    //     $subjects = [
    //         'third_subject' => [],
    //         'forth_subject' => []
    //     ];

    //     if ($hasGroupId) {
    //         $scms_third_and_forth_subject = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');

    //         // Fetch all subjects
    //         $subjectsData = $scms_third_and_forth_subject
    //             ->find()
    //             ->where(['student_cycle_id IN' => $ids])
    //             ->enableAutoFields(true)
    //             ->enableHydration(false)
    //             ->toArray();


    //         $optional_id = [];

    //         foreach ($subjectsData as $sub) {
    //             if ($sub['type'] === 'third') {
    //                 $single_third_subject = [];
    //                 $single_third_subject['type'] = 'third';
    //                 $single_third_subject['student_cycle_id'] = $sub['student_cycle_id'];
    //                 $single_third_subject['course_id'] = $sub['course_id'];

    //                 $subjects['third_subject'][] = $single_third_subject;

    //                 // Add course_id to optional_id
    //                 $optional_id[] = $sub['course_id'];
    //             } elseif ($sub['type'] === 'forth') {
    //                 $single_forth_subject = [];
    //                 $single_forth_subject['type'] = 'forth';
    //                 $single_forth_subject['student_cycle_id'] = $sub['student_cycle_id'];
    //                 $single_forth_subject['course_id'] = $sub['course_id'];

    //                 $subjects['forth_subject'][] = $single_forth_subject;

    //                 // Add course_id to optional_id
    //                 $optional_id[] = $sub['course_id'];
    //             }
    //         }
    //     }


    //     $where['level_id'] = $student_cycle_data[0]['level_id'];
    //     $where['session_id'] = $student_cycle_data[0]['session_id'];
    //     $optional_courses = array();

    //     if (count($optional_id) > 0) {
    //         $where['c.course_id in'] = $optional_id;

    //         // ðŸ”¥ FIX: filter optional courses by group_id (if exists)
    //         if (!empty($student_cycle_data[0]['group_id'])) {
    //             $where['c.course_group_id'] = $student_cycle_data[0]['group_id'];
    //         }

    //         $optional_courses = $this->getCoursecycle($where);
    //     }

    //     // Remove to avoid affecting next queries
    //     unset($where['c.course_id in']);
    //     unset($where['c.course_group_id']);


    //     $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
    //     $term_cycles = $scms_term_cycle->find()
    //         ->where(['level_id' => $student_cycle_data[0]['level_id']])
    //         ->where(['session_id' => $student_cycle_data[0]['session_id']])
    //         ->enableAutoFields(true)
    //         ->enableHydration(false)
    //         ->toArray();

    //     $where['level_id'] = $student_cycle_data[0]['level_id'];
    //     $where['session_id'] = $student_cycle_data[0]['session_id'];
    //     //Compulsory course
    //     $where['c.course_type_id'] = 1;
    //     $compulsory_courses = $this->getCoursecycle($where);

    //     //extra course
    //     $where['c.course_type_id'] = 2;
    //     $extra_courses = $this->getCoursecycle($where);

    //     $selective_courses = array();
    //     if ($student_cycle_data[0]['group_id']) {
    //         $where['c.course_type_id'] = 4;
    //         $where['c.course_group_id'] = $student_cycle_data[0]['group_id'];
    //         $selective_courses = $this->getCoursecycle($where);
    //     }

    //     $course_cycles = array_merge($extra_courses, $compulsory_courses, $selective_courses, $optional_courses);
    //     // echo '<pre>';
    //     // print_r($course_cycles);
    //     // die;
    //     //  religion course
    //     $where['c.course_type_id'] = 5;
    //     $religion_courses = $this->getCoursecycle($where);
    //     $filter_religion_course = array();
    //     foreach ($religion_courses as $religion_course) {
    //         $filter_religion_course[$religion_course['course_id']] = $religion_course;
    //     }
    //     $student_course_cycle_data = array();
    //     $student_term_cycle_data = array();
    //     $student_cycle_ids = array();
    //     foreach ($saved_student_cycle as $student_cycle) {
    //         $student_cycle_ids[] = $student_cycle['student_cycle_id'];
    //         $student_term_cycle_data_single['student_cycle_id'] = $student_course_cycle_data_single['student_cycle_id'] = $student_cycle['student_cycle_id'];
    //         foreach ($course_cycles as $course_cycle) {
    //             $student_course_cycle_data_single['courses_cycle_id'] = $course_cycle['courses_cycle_id'];
    //             $student_course_cycle_data[] = $student_course_cycle_data_single;
    //         }
    //         if (isset($filter_religion_course[$student_cycle['religion_subject']])) {
    //             $student_course_cycle_data_single['courses_cycle_id'] = $filter_religion_course[$student_cycle['religion_subject']]['courses_cycle_id'];
    //             $student_course_cycle_data[] = $student_course_cycle_data_single;
    //         }

    //         foreach ($term_cycles as $term_cycle) {
    //             $student_term_cycle_data_single['term_cycle_id'] = $term_cycle['term_cycle_id'];
    //             $student_term_cycle_data[] = $student_term_cycle_data_single;
    //         }
    //     }
    //     $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
    //     $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');

    //     if (count($student_course_cycle_data)) {
    //         //start  scms_student_course_cycle
    //         $insertQueryResult = $scms_student_course_cycle->query();
    //         $columns = array_keys($student_course_cycle_data[0]);
    //         $insertQueryResult->insert($columns);
    //         $insertQueryResult->clause('values')->values($student_course_cycle_data);
    //         $insertQueryResult->execute();
    //         //end  scms_student_course_cycle
    //     }

    //     if (count($student_term_cycle_data)) {
    //         //start  scms_student_course_cycle
    //         $insertQueryResult = $scms_student_term_cycle->query();
    //         $columns = array_keys($student_term_cycle_data[0]);
    //         $insertQueryResult->insert($columns);
    //         $insertQueryResult->clause('values')->values($student_term_cycle_data);
    //         $insertQueryResult->execute();
    //         //end  scms_student_course_cycle
    //     }


    //     $saved_student_course_cycles = $scms_student_course_cycle->find()
    //         ->where(['student_cycle_id IN' => $student_cycle_ids])
    //         ->enableAutoFields(true)
    //         ->enableHydration(false)
    //         ->toArray();
    //     $saved_student_term_cycles = $scms_student_term_cycle->find()
    //         ->where(['student_cycle_id IN' => $student_cycle_ids])
    //         ->enableAutoFields(true)
    //         ->enableHydration(false)
    //         ->toArray();
    //     $filter_saved_student_course_cycle = array();
    //     foreach ($saved_student_course_cycles as $saved_student_course_cycle) {
    //         $student_cycle_id = $saved_student_course_cycle["student_cycle_id"];
    //         unset($saved_student_course_cycle["student_cycle_id"]);
    //         unset($saved_student_course_cycle["courses_cycle_id"]);
    //         $filter_saved_student_course_cycle[$student_cycle_id][] = $saved_student_course_cycle;
    //     }
    //     $student_term_course_cycle_data = array();
    //     foreach ($saved_student_term_cycles as $saved_student_term_cycle) {
    //         foreach ($filter_saved_student_course_cycle[$saved_student_term_cycle["student_cycle_id"]] as $filter_saved_student_course_cycle_single) {
    //             $filter_saved_student_course_cycle_single['student_term_cycle_id'] = $saved_student_term_cycle['student_term_cycle_id'];
    //             $student_term_course_cycle_data[] = $filter_saved_student_course_cycle_single;
    //         }
    //     }
    //     if (count($student_term_course_cycle_data)) {
    //         //start  scms_student_course_cycle
    //         $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
    //         $insertQueryResult = $scms_student_term_course_cycle->query();
    //         $columns = array_keys($student_term_course_cycle_data[0]);
    //         $insertQueryResult->insert($columns);
    //         $insertQueryResult->clause('values')->values($student_term_course_cycle_data);
    //         $insertQueryResult->execute();
    //         //end  scms_student_course_cycle
    //     }
    //     return true;
    // }

    private function crate_student_cycles_for_promotion($student_cycle_data, $saved_student_cycle)
    {
        $student_cycle_ids = array_column($saved_student_cycle, 'student_cycle_id');

        $optional_id_map = [];

        $scms_third_and_forth_subject = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
        $subjectsData = $scms_third_and_forth_subject
            ->find()
            ->where(['student_cycle_id IN' => $student_cycle_ids])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        foreach ($subjectsData as $sub) {
            $optional_id_map[$sub['student_cycle_id']][] = $sub['course_id'];
        }

        $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
        $term_cycles = $scms_term_cycle->find()
            ->where([
                'level_id' => $student_cycle_data[0]['level_id'],
                'session_id' => $student_cycle_data[0]['session_id']
            ])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        $baseWhere = [
            'level_id' => $student_cycle_data[0]['level_id'],
            'session_id' => $student_cycle_data[0]['session_id'],
        ];

        $compulsory_courses = $this->getCoursecycle(array_merge($baseWhere, [
            'c.course_type_id' => 1
        ]));

        $extra_courses = $this->getCoursecycle(array_merge($baseWhere, [
            'c.course_type_id' => 2
        ]));

        $studentsTable = TableRegistry::getTableLocator()->get('scms_students');
        $studentReligionSubjectsRaw = $studentsTable->find()
            ->select(['student_id', 'religion_subject'])
            ->where(['student_id IN' => array_column($saved_student_cycle, 'student_id')])
            ->enableHydration(false)
            ->toArray();

        $studentReligionSubjects = [];
        foreach ($studentReligionSubjectsRaw as $s) {
            if (!empty($s['religion_subject'])) {
                $studentReligionSubjects[$s['student_id']] = $s['religion_subject'];
            }
        }

        $student_course_cycle_data = [];
        $student_term_cycle_data = [];

        foreach ($saved_student_cycle as $student_cycle) {
            $student_cycle_id = $student_cycle['student_cycle_id'];
            $student_group_id = $student_cycle['group_id'];
            $student_id = $student_cycle['student_id'];

            $selective_courses = [];
            if (!empty($student_group_id)) {
                $selective_courses = $this->getCoursecycle(array_merge($baseWhere, [
                    'c.course_type_id' => 4,
                    'c.course_group_id' => $student_group_id
                ]));
            }

            $optional_courses = [];
            if (!empty($optional_id_map[$student_cycle_id])) {
                $optional_courses = $this->getCoursecycle(array_merge($baseWhere, [
                    'c.course_id IN' => $optional_id_map[$student_cycle_id],
                    'c.course_group_id' => $student_group_id
                ]));
            }

            $final_courses = array_merge(
                $compulsory_courses,
                $extra_courses,
                $selective_courses,
                $optional_courses
            );

            $rowBase = ['student_cycle_id' => $student_cycle_id];

            foreach ($final_courses as $course) {
                $row = $rowBase;
                $row['courses_cycle_id'] = $course['courses_cycle_id'];
                $student_course_cycle_data[] = $row;
            }

            if (!empty($studentReligionSubjects[$student_id])) {
                $religion_course_id = $studentReligionSubjects[$student_id];
                $religion_course = $this->getCoursecycle(array_merge($baseWhere, [
                    'c.course_id' => $religion_course_id
                ]));
                if (!empty($religion_course)) {
                    $row = $rowBase;
                    $row['courses_cycle_id'] = $religion_course[0]['courses_cycle_id'];
                    $student_course_cycle_data[] = $row;
                }
            }

            foreach ($term_cycles as $term) {
                $student_term_cycle_data[] = [
                    'student_cycle_id' => $student_cycle_id,
                    'term_cycle_id' => $term['term_cycle_id']
                ];
            }
        }

        $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
        $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');

        if ($student_course_cycle_data) {
            $query = $scms_student_course_cycle->query();
            $query->insert(array_keys($student_course_cycle_data[0]));
            $query->clause('values')->values($student_course_cycle_data);
            $query->execute();
        }

        if ($student_term_cycle_data) {
            $query = $scms_student_term_cycle->query();
            $query->insert(array_keys($student_term_cycle_data[0]));
            $query->clause('values')->values($student_term_cycle_data);
            $query->execute();
        }

        $saved_student_course_cycles = $scms_student_course_cycle->find()
            ->where(['student_cycle_id IN' => $student_cycle_ids])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        $saved_student_term_cycles = $scms_student_term_cycle->find()
            ->where(['student_cycle_id IN' => $student_cycle_ids])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        $courseMap = [];
        foreach ($saved_student_course_cycles as $c) {
            $cid = $c['student_cycle_id'];
            unset($c['student_cycle_id']);
            unset($c['courses_cycle_id']);
            $courseMap[$cid][] = $c;
        }

        $student_term_course_cycle_data = [];
        foreach ($saved_student_term_cycles as $tm) {
            $sid = $tm['student_cycle_id'];
            foreach ($courseMap[$sid] as $cr) {
                $cr['student_term_cycle_id'] = $tm['student_term_cycle_id'];
                $student_term_course_cycle_data[] = $cr;
            }
        }

        if ($student_term_course_cycle_data) {
            $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
            $query = $scms_student_term_course_cycle->query();
            $query->insert(array_keys($student_term_course_cycle_data[0]));
            $query->clause('values')->values($student_term_course_cycle_data);
            $query->execute();
        }

        return true;
    }


    // private function crate_student_cycles_for_promotion($student_cycle_data, $saved_student_cycle)
    // {
    //     $student_cycle_ids = [];
    //     $ids = [];
    //     $optional_id_map = [];

    //     foreach ($saved_student_cycle as $e) {
    //         $ids[] = $e['student_cycle_id'];
    //         $student_cycle_ids[] = $e['student_cycle_id'];
    //     }

    //     // ========================================
    //     // LOAD OPTIONAL (3RD & 4TH) SUBJECTS PER STUDENT
    //     // ========================================
    //     $scms_third_and_forth_subject = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
    //     $subjectsData = $scms_third_and_forth_subject
    //         ->find()
    //         ->where(['student_cycle_id IN' => $ids])
    //         ->enableAutoFields(true)
    //         ->enableHydration(false)
    //         ->toArray();

    //     foreach ($subjectsData as $sub) {
    //         $optional_id_map[$sub['student_cycle_id']][] = $sub['course_id'];
    //     }

    //     // ========================================
    //     // LOAD TERM CYCLES
    //     // ========================================
    //     $scms_term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
    //     $term_cycles = $scms_term_cycle->find()
    //         ->where([
    //             'level_id' => $student_cycle_data[0]['level_id'],
    //             'session_id' => $student_cycle_data[0]['session_id']
    //         ])
    //         ->enableAutoFields(true)
    //         ->enableHydration(false)
    //         ->toArray();

    //     // ========================================
    //     // LOAD COMPULSORY & EXTRA COURSES
    //     // ========================================
    //     $baseWhere = [
    //         'level_id' => $student_cycle_data[0]['level_id'],
    //         'session_id' => $student_cycle_data[0]['session_id'],
    //     ];

    //     $compulsory_courses = $this->getCoursecycle(array_merge($baseWhere, [
    //         'c.course_type_id' => 1
    //     ]));

    //     $extra_courses = $this->getCoursecycle(array_merge($baseWhere, [
    //         'c.course_type_id' => 2
    //     ]));

    //     // ========================================
    //     // LOAD RELIGION COURSES PER STUDENT
    //     // ========================================
    //     $studentsTable = TableRegistry::getTableLocator()->get('students');
    //     $studentReligionSubjectsRaw = $studentsTable->find()
    //         ->select(['student_id', 'religion_subject'])
    //         ->where(['student_id IN' => array_column($saved_student_cycle, 'student_id')])
    //         ->enableHydration(false)
    //         ->toArray();

    //     $studentReligionSubjects = [];
    //     foreach ($studentReligionSubjectsRaw as $s) {
    //         if (!empty($s['religion_subject'])) {
    //             $studentReligionSubjects[$s['student_id']] = $s['religion_subject'];
    //         }
    //     }

    //     // ========================================
    //     // PREPARE INSERT DATA
    //     // ========================================
    //     $student_course_cycle_data = [];
    //     $student_term_cycle_data = [];

    //     foreach ($saved_student_cycle as $student_cycle) {
    //         $student_cycle_id = $student_cycle['student_cycle_id'];
    //         $student_group_id = $student_cycle['group_id']; // OLD GROUP
    //         $student_id = $student_cycle['student_id'];

    //         // ============================
    //         // SELECTIVE COURSES (per student group)
    //         // ============================
    //         $selective_courses = [];
    //         if (!empty($student_group_id)) {
    //             $selective_courses = $this->getCoursecycle(array_merge($baseWhere, [
    //                 'c.course_type_id' => 4,
    //                 'c.course_group_id' => $student_group_id
    //             ]));
    //         }

    //         // ============================
    //         // OPTIONAL COURSES (3rd/4th) per student
    //         // ============================
    //         $optional_courses = [];
    //         if (!empty($optional_id_map[$student_cycle_id])) {
    //             $optional_courses = $this->getCoursecycle(array_merge($baseWhere, [
    //                 'c.course_id IN' => $optional_id_map[$student_cycle_id],
    //                 'c.course_group_id' => $student_group_id
    //             ]));
    //         }

    //         // ============================
    //         // MERGE COURSES
    //         // ============================
    //         $final_courses = array_merge(
    //             $compulsory_courses,
    //             $extra_courses,
    //             $selective_courses,
    //             $optional_courses
    //         );

    //         // ============================
    //         // INSERT: student_course_cycle
    //         // ============================
    //         $rowBase = ['student_cycle_id' => $student_cycle_id];

    //         foreach ($final_courses as $course) {
    //             $row = $rowBase;
    //             $row['courses_cycle_id'] = $course['courses_cycle_id'];
    //             $student_course_cycle_data[] = $row;
    //         }

    //         // religion subject
    //         if (!empty($studentReligionSubjects[$student_id])) {
    //             $religion_course_id = $studentReligionSubjects[$student_id];
    //             $religion_course = $this->getCoursecycle(array_merge($baseWhere, [
    //                 'c.course_id' => $religion_course_id
    //             ]));
    //             if (!empty($religion_course)) {
    //                 $row = $rowBase;
    //                 $row['courses_cycle_id'] = $religion_course[0]['courses_cycle_id'];
    //                 $student_course_cycle_data[] = $row;
    //             }
    //         }

    //         // ============================
    //         // INSERT: student_term_cycle
    //         // ============================
    //         foreach ($term_cycles as $term) {
    //             $student_term_cycle_data[] = [
    //                 'student_cycle_id' => $student_cycle_id,
    //                 'term_cycle_id' => $term['term_cycle_id']
    //             ];
    //         }
    //     }

    //     // ========================================
    //     // BULK INSERT
    //     // ========================================
    //     $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
    //     $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');

    //     if ($student_course_cycle_data) {
    //         $query = $scms_student_course_cycle->query();
    //         $query->insert(array_keys($student_course_cycle_data[0]));
    //         $query->clause('values')->values($student_course_cycle_data);
    //         $query->execute();
    //     }

    //     if ($student_term_cycle_data) {
    //         $query = $scms_student_term_cycle->query();
    //         $query->insert(array_keys($student_term_cycle_data[0]));
    //         $query->clause('values')->values($student_term_cycle_data);
    //         $query->execute();
    //     }

    //     // ========================================
    //     // CREATE TERMâ€“COURSE RELATION
    //     // ========================================
    //     $saved_student_course_cycles = $scms_student_course_cycle->find()
    //         ->where(['student_cycle_id IN' => $student_cycle_ids])
    //         ->enableAutoFields(true)
    //         ->enableHydration(false)
    //         ->toArray();

    //     $saved_student_term_cycles = $scms_student_term_cycle->find()
    //         ->where(['student_cycle_id IN' => $student_cycle_ids])
    //         ->enableAutoFields(true)
    //         ->enableHydration(false)
    //         ->toArray();

    //     $courseMap = [];
    //     foreach ($saved_student_course_cycles as $c) {
    //         $cid = $c['student_cycle_id'];
    //         unset($c['student_cycle_id']);
    //         unset($c['courses_cycle_id']);
    //         $courseMap[$cid][] = $c;
    //     }

    //     $student_term_course_cycle_data = [];
    //     foreach ($saved_student_term_cycles as $tm) {
    //         $sid = $tm['student_cycle_id'];
    //         foreach ($courseMap[$sid] as $cr) {
    //             $cr['student_term_cycle_id'] = $tm['student_term_cycle_id'];
    //             $student_term_course_cycle_data[] = $cr;
    //         }
    //     }

    //     if ($student_term_course_cycle_data) {
    //         $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
    //         $query = $scms_student_term_course_cycle->query();
    //         $query->insert(array_keys($student_term_course_cycle_data[0]));
    //         $query->clause('values')->values($student_term_course_cycle_data);
    //         $query->execute();
    //     }

    //     return true;
    // }



    private function promote_fail_student($fail_students, $template, $request_data, $section_from_ids)
    {
        $sections = $this->get_sections_details($request_data['section_from']);
        foreach ($fail_students as $key => $fail_student) {
            usort($fail_students[$key], function ($a, $b) {
                return [$a['fail_count'], $a['roll']] <=>
                    [$b['fail_count'], $b['roll']];
            });
        }
        $student_cycle_data = array();
        $student_data = array();
        $student_ids = array();
        $section_roll = $this->genarate_promotion_roll($template[0]['session_to_name'], $request_data['level_from'], $section_from_ids, $fail = true);
        foreach ($fail_students as $key => $fail_student) {
            for ($j = 0; $j < count($fail_student); $j++) {
                for ($i = 0; $i < count($request_data['section_from'][$key]); $i++) {
                    if (isset($fail_student[$j])) {
                        $student_ids[] = $fail_student[$j]['student_id'];
                        $single_data['student_cycle_data']['student_id'] = $single_data['student_data']['student_id'] = $fail_student[$j]['student_id'];
                        $single_data['student_cycle_data']['session_id'] = $single_data['student_data']['session_id'] = $template[0]['session_to'];
                        $single_data['student_cycle_data']['level_id'] = $single_data['student_data']['level_id'] = $request_data['level_from'];
                        $single_data['student_cycle_data']['shift_id'] = $sections[$request_data['section_from'][$key][$i]]['shift_id'];
                        $single_data['student_cycle_data']['group_id'] = $fail_student[$j]['grp_id'];
                        $single_data['student_cycle_data']['section_id'] = $sections[$request_data['section_from'][$key][$i]]['section_id'];
                        $single_data['student_cycle_data']['roll'] = $section_roll[$single_data['student_cycle_data']['section_id']];
                        $section_roll[$single_data['student_cycle_data']['section_id']]++;
                        $student_cycle_data[] = $single_data['student_cycle_data'];
                        $student_data[] = $single_data['student_data'];
                    }
                    if ($i != count($request_data['section_from'][$key]) - 1) {
                        $j++;
                    }
                }
            }
        }

        if (count($student_cycle_data) > 0) {
            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');

            $entities = $scms_student_cycle->newEntities($student_cycle_data);
            $saved_entities = $scms_student_cycle->saveMany($entities);

            $student_cycle_map = [];
            foreach ($saved_entities as $entity) {
                if ($entity) {
                    $student_cycle_map[$entity->student_id] = $entity->student_cycle_id;
                }
            }

            $third_forth_data = [];
            foreach ($fail_students as $group_id => $students) {
                foreach ($students as $st) {
                    $old_student_id = $st['student_id'];
                    if (empty($student_cycle_map[$old_student_id]))
                        continue;

                    $new_cycle_id = $student_cycle_map[$old_student_id];

                    if (!empty($st['third_course_id'])) {
                        $third_forth_data[] = [
                            'student_cycle_id' => $new_cycle_id,
                            'course_id' => $st['third_course_id'],
                            'type' => 'third',
                            'group_id' => $st['grp_id'],
                        ];
                    }

                    if (!empty($st['forth_course_id'])) {
                        $third_forth_data[] = [
                            'student_cycle_id' => $new_cycle_id,
                            'course_id' => $st['forth_course_id'],
                            'type' => 'forth',
                            'group_id' => $st['grp_id'],
                        ];
                    }
                }
            }

            if (!empty($third_forth_data)) {
                $ThirdForth = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
                $entities = $ThirdForth->newEntities($third_forth_data);
                $ThirdForth->saveMany($entities);
            }


            $this->crate_student_cycles_for_promotion($student_cycle_data, $saved_entities);
        }


        $scms_students = TableRegistry::getTableLocator()->get('scms_students');
        foreach ($student_data as $student) {
            $query = $scms_students->query();
            $query->update()
                ->set($student)
                ->where(['student_id' => $student['student_id']])
                ->execute();
        }
        return true;
    }

    private function promote_promoted_student($promote_students, $template, $request_data, $section_to_ids)
    {
        $sections = $this->get_sections_details($request_data['section_to']);
        foreach ($promote_students as $key => $promote_student) {
            if (isset($template[0]['chnage_roll']) && $template[0]['chnage_roll'] && $template[0]['term_id']) {
                usort($promote_students[$key], function ($a, $b) {
                    return [$b['gpa_with_forth_subject'], $b['gpa'], $b['marks_with_forth_subject'], $a['fail_count'], $a['roll']] <=>
                        [$a['gpa_with_forth_subject'], $a['gpa'], $a['marks_with_forth_subject'], $b['fail_count'], $b['roll']];
                });
            } else {
                usort($promote_students[$key], function ($a, $b) {
                    return [$a['roll']] <=>
                        [$b['roll']];
                });
            }
        }

        $student_cycle_data = array();
        $student_data = array();
        $student_ids = array();
        $section_roll = $this->genarate_promotion_roll($template[0]['session_to_name'], $request_data['level_to'], $section_to_ids);
        foreach ($promote_students as $key => $promote_student) {
            for ($j = 0; $j < count($promote_student); $j++) {
                for ($i = 0; $i < count($request_data['section_to'][$key]); $i++) {
                    if (isset($promote_student[$j])) {
                        $student_ids[] = $promote_student[$j]['student_id'];
                        $single_data['student_cycle_data']['student_id'] = $single_data['student_data']['student_id'] = $promote_student[$j]['student_id'];
                        $single_data['student_cycle_data']['session_id'] = $single_data['student_data']['session_id'] = $template[0]['session_to'];
                        $single_data['student_cycle_data']['level_id'] = $single_data['student_data']['level_id'] = $request_data['level_to'];
                        $single_data['student_cycle_data']['shift_id'] = $sections[$request_data['section_to'][$key][$i]]['shift_id'];
                        $single_data['student_cycle_data']['group_id'] = $promote_student[$j]['grp_id'];
                        $single_data['student_cycle_data']['section_id'] = $sections[$request_data['section_to'][$key][$i]]['section_id'];
                        $single_data['student_cycle_data']['roll'] = $template[0]['chnage_roll'] ? $section_roll[$single_data['student_cycle_data']['section_id']] : $promote_student[$j]['roll'];
                        $section_roll[$single_data['student_cycle_data']['section_id']]++;
                        $student_cycle_data[] = $single_data['student_cycle_data'];
                        $student_data[] = $single_data['student_data'];
                    }
                    if ($i != count($request_data['section_to'][$key]) - 1) {
                        $j++;
                    }
                }
            }
        }


       /* if (count($student_cycle_data) > 0) {
            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');

            $entities = $scms_student_cycle->newEntities($student_cycle_data);
            $saved_entities = $scms_student_cycle->saveMany($entities);

            $student_cycle_map = [];
            foreach ($saved_entities as $entity) {
                if ($entity) {
                    $student_cycle_map[$entity->student_id] = $entity->student_cycle_id;
                }
            }

            $third_forth_data = [];
            foreach ($promote_students as $group_id => $students) {
                foreach ($students as $st) {
                    $old_student_id = $st['student_id'];
                    if (empty($student_cycle_map[$old_student_id]))
                        continue;

                    $new_cycle_id = $student_cycle_map[$old_student_id];

                    if (!empty($st['third_course_id'])) {
                        $third_forth_data[] = [
                            'student_cycle_id' => $new_cycle_id,
                            'course_id' => $st['third_course_id'],
                            'type' => 'third',
                            'group_id' => $st['grp_id'],
                        ];
                    }

                    if (!empty($st['forth_course_id'])) {
                        $third_forth_data[] = [
                            'student_cycle_id' => $new_cycle_id,
                            'course_id' => $st['forth_course_id'],
                            'type' => 'forth',
                            'group_id' => $st['grp_id'],
                        ];
                    }
                }
            }

            if (!empty($third_forth_data)) {
                $ThirdForth = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
                $entities = $ThirdForth->newEntities($third_forth_data);
                $ThirdForth->saveMany($entities);
            }



            $this->crate_student_cycles_for_promotion($student_cycle_data, $saved_entities);
        } */
        

        if (!empty($student_cycle_data)) {
        
            // ===============================
            // STEP 1: Get ACTIVE students only
            // ===============================
            $StudentsTable = TableRegistry::getTableLocator()->get('scms_students');
        
            $activeStudentIds = $StudentsTable->find()
                ->select(['student_id'])
                ->where(['status' => 1])
                ->enableHydration(false)
                ->extract('student_id')
                ->toArray();
        
            if (empty($activeStudentIds)) {
                return;
            }
        
            // ==================================
            // STEP 2: Filter student_cycle_data
            // ==================================
            $student_cycle_data = array_values(array_filter(
                $student_cycle_data,
                function ($row) use ($activeStudentIds) {
                    return in_array($row['student_id'], $activeStudentIds);
                }
            ));
        
            if (empty($student_cycle_data)) {
                return;
            }
        
            // ==================================
            // STEP 3: Save student cycles
            // ==================================
            $StudentCycleTable = TableRegistry::getTableLocator()->get('scms_student_cycle');
        
            $cycleEntities = $StudentCycleTable->newEntities($student_cycle_data);
            $savedEntities = $StudentCycleTable->saveMany($cycleEntities);
        
            if (empty($savedEntities)) {
                return;
            }
        
            // Build map: old student_id => new student_cycle_id
            $student_cycle_map = [];
            foreach ($savedEntities as $entity) {
                if ($entity && !empty($entity->student_id)) {
                    $student_cycle_map[$entity->student_id] = $entity->student_cycle_id;
                }
            }
        
            if (empty($student_cycle_map)) {
                return;
            }
        
            // ==================================
            // STEP 4: Prepare third & forth data
            // ==================================
            $third_forth_data = [];
        
            foreach ($promote_students as $group_id => $students) {
        
                foreach ($students as $st) {
        
                    $old_student_id = $st['student_id'];
        
                    // Skip inactive or failed mappings
                    if (empty($student_cycle_map[$old_student_id])) {
                        continue;
                    }
        
                    $new_cycle_id = $student_cycle_map[$old_student_id];
        
                    if (!empty($st['third_course_id'])) {
                        $third_forth_data[] = [
                            'student_cycle_id' => $new_cycle_id,
                            'course_id'        => $st['third_course_id'],
                            'type'             => 'third',
                            'group_id'         => $st['grp_id'],
                        ];
                    }
        
                    if (!empty($st['forth_course_id'])) {
                        $third_forth_data[] = [
                            'student_cycle_id' => $new_cycle_id,
                            'course_id'        => $st['forth_course_id'],
                            'type'             => 'forth',
                            'group_id'         => $st['grp_id'],
                        ];
                    }
                }
            }
        
            // ==================================
            // STEP 5: Save third & forth subjects
            // ==================================
            if (!empty($third_forth_data)) {
                $ThirdForthTable = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
                $thirdForthEntities = $ThirdForthTable->newEntities($third_forth_data);
                $ThirdForthTable->saveMany($thirdForthEntities);
            }
        
            // ==================================
            // STEP 6: Call promotion helper
            // ==================================
            $this->crate_student_cycles_for_promotion($student_cycle_data, $savedEntities);
        }

        
        $scms_students = TableRegistry::getTableLocator()->get('scms_students');
        foreach ($student_data as $student) {
            $query = $scms_students->query();
            $query->update()
                ->set($student)
                ->where(['student_id' => $student['student_id']])
                ->execute();
        }
        return true;
    }

    public function deletePromotion($id)
    {
        $scms_promotion_log = TableRegistry::getTableLocator()->get('scms_promotion_log');
        $promotion_log = $scms_promotion_log->find()
            ->where(['promotion_log_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'session_from' => "scms_promotion_template.session_from",
                'session_to' => "scms_promotion_template.session_to",
            ])
            ->join([
                'scms_promotion_template' => [
                    'table' => 'scms_promotion_template',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_promotion_log.promotion_template_id = scms_promotion_template.promotion_template_id'
                    ]
                ]
            ])->toArray();
        $where['scms_student_cycle.session_id'] = $promotion_log[0]['session_from'];
        $where['scms_student_cycle.level_id'] = $promotion_log[0]['level_from'];

        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $old_student_cycles = $scms_student_cycle->find()->where($where)
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $student_ids = array();
        $student_data = array();
        foreach ($old_student_cycles as $old_student) {
            $student_ids[] = $single_student_data['student_id'] = $old_student['student_id'];
            $single_student_data['session_id'] = $old_student['session_id'];
            $single_student_data['level_id'] = $old_student['level_id'];
            $student_data[] = $single_student_data;
        }

        $where['scms_student_cycle.session_id'] = $promotion_log[0]['session_to'];
        $where['scms_student_cycle.level_id'] = $promotion_log[0]['level_to'];
        $where['scms_student_cycle.student_id IN'] = $student_ids;
        $new_student_cycles = $scms_student_cycle->find()->where($where)
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $deleted_cycle_ids = array();
        foreach ($new_student_cycles as $new_student) {
            $deleted_cycle_ids[] = $new_student['student_cycle_id'];
        }
        $this->deleteStudentCycle($deleted_cycle_ids);
        $scms_students = TableRegistry::getTableLocator()->get('scms_students');
        foreach ($student_data as $student) {
            $query = $scms_students->query();
            $query->update()
                ->set($student)
                ->where(['student_id' => $student['student_id']])
                ->execute();
        }
        $promotion_log_data['deleted_by'] = $this->Auth->user('id');
        $promotion_log_data['deleted'] = 1;
        $query = $scms_promotion_log->query();
        $query->update()
            ->set($promotion_log_data)
            ->where(['promotion_log_id' => $id])
            ->execute();
        $this->Flash->success('Promotion Deleted Successfully', [
            'key' => 'Negative',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'promotionLog']);
    }

    public function promotionLog()
    {
        $scms_promotion_log = TableRegistry::getTableLocator()->get('scms_promotion_log');
        $promotion_log = $scms_promotion_log->find()->where(['scms_promotion_log.deleted' => 0])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'name' => "scms_promotion_template.name",
                'session_from_name' => "session_from.session_name",
                'session_to_name' => "session_to.session_name",
                'level_from_name' => "level_from.level_name",
                'level_to_name' => "level_to.level_name",
            ])
            ->join([
                'scms_promotion_template' => [
                    'table' => 'scms_promotion_template',
                    'type' => 'INNER',
                    'conditions' => [
                        'scms_promotion_log.promotion_template_id = scms_promotion_template.promotion_template_id'
                    ]
                ],
                'session_from' => [
                    'table' => 'scms_sessions',
                    'type' => 'INNER',
                    'conditions' => [
                        'session_from.session_id = scms_promotion_template.session_from'
                    ]
                ],
                'session_to' => [
                    'table' => 'scms_sessions',
                    'type' => 'INNER',
                    'conditions' => [
                        'session_to.session_id = scms_promotion_template.session_to'
                    ]
                ],
                'level_from' => [
                    'table' => 'scms_levels',
                    'type' => 'INNER',
                    'conditions' => [
                        'level_from.level_id = scms_promotion_log.level_from'
                    ]
                ],
                'level_to' => [
                    'table' => 'scms_levels',
                    'type' => 'INNER',
                    'conditions' => [
                        'level_to.level_id = scms_promotion_log.level_to'
                    ]
                ],
            ])->toArray();
        $this->set('promotion_log', $promotion_log);
    }


    public function delete_all_cycle($student_cycle_id)
    {
        $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
        $student_course_cycles = $scms_student_course_cycle->find()
            ->where(['student_cycle_id' => $student_cycle_id])
            ->toArray();
        $student_course_cycle_ids = array();
        foreach ($student_course_cycles as $student_course_cycle) {
            $student_course_cycle_ids[] = $student_course_cycle->student_course_cycle_id;
        }

        $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
        $student_term_cycles = $scms_student_term_cycle->find()
            ->where(['student_cycle_id' => $student_cycle_id])
            ->toArray();
        $student_term_cycle_ids = array();
        foreach ($student_term_cycles as $student_term_cycle) {
            $student_term_cycle_ids[] = $student_term_cycle->student_term_cycle_id;
        }
        if (count($student_term_cycle_ids)) {
            //delete activity
            $scms_student_activity = TableRegistry::getTableLocator()->get('scms_student_activity');
            $query = $scms_student_activity->query();
            $query->delete()
                ->where(['student_term_cycle_id IN' => $student_term_cycle_ids])
                ->execute();
        }

        if (count($student_course_cycle_ids)) {
            $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
            $student_term_course_cycles = $scms_student_term_course_cycle->find()
                ->where(['student_course_cycle_id IN' => $student_course_cycle_ids])
                ->toArray();
            $student_term_course_cycle_ids = array();
            foreach ($student_term_course_cycles as $student_term_course_cycle) {
                $student_term_course_cycle_ids[] = $student_term_course_cycle->student_term_course_cycle_id;
            }
            //delete student term course cycle mark
            if (count($student_term_course_cycle_ids)) {
                $scms_term_course_cycle_part_mark = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_mark');
                $query = $scms_term_course_cycle_part_mark->query();
                $query->delete()
                    ->where(['student_term_course_cycle_id IN' => $student_term_course_cycle_ids])
                    ->execute();
                //delete student term course cycle 
                $query = $scms_student_term_course_cycle->query();
                $query->delete()
                    ->where(['student_term_course_cycle_id IN' => $student_term_course_cycle_ids])
                    ->execute();
            }
        }
        //delete student course cycle 
        $query = $scms_student_course_cycle->query();
        $query->delete()
            ->where(['student_cycle_id IN' => $student_cycle_id])
            ->execute();
        //delete student term cycle 
        $query = $scms_student_term_cycle->query();
        $query->delete()
            ->where(['student_cycle_id IN' => $student_cycle_id])
            ->execute();

        //delete student cycle
        $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $query = $scms_student_cycle->query();
        $query->delete()
            ->where(['student_cycle_id' => $student_cycle_id])
            ->execute();
        return true;
    }

    public function individualPromotion()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $new_roll = $request_data['roll'];
            // echo '<pre>';
            // print_r($request_data);
            // die;
            $section = TableRegistry::getTableLocator()->get('scms_sections');
            $section_from = $section
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['level_id' => $request_data['level_from']])
                ->where(['section_id' => $request_data['section_from']])
                ->toArray();
            $section_from_id = $section_from[0]['section_id'];

            $section_to = $section
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['level_id' => $request_data['level_to']])
                ->where(['section_id' => $request_data['section_to']])
                ->toArray();
            $section_to_id = $section_to[0]['section_id'];
            $shift_to_id = $section_to[0]['shift_id'];
            // echo '<pre>';
            // print_r($section_from_id);
            // echo '<pre>';
            // print_r($section_to);
            // die;
            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $result_students = $scms_student_cycle->find()
                ->where(['scms_student_cycle.level_id' => $request_data['level_from']])
                ->where(['scms_students.status' => 1])
                ->where(['scms_student_cycle.session_id' => $request_data['session_from']])
                ->where(['scms_students.sid' => $request_data['sid']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'section_id_from_cycle' => "scms_student_cycle.section_id",
                ])
                ->join([
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_student_cycle.student_id  = scms_students.student_id'
                        ]
                    ],
                ])->toArray();

            if (count($result_students) == 0) {
                $this->Flash->success('Promotion Unsuccessful, No Student Found', [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'IndividualPromotion']);
            }
            $student_cycle_data['student_id'] = $result_students[0]['student_id'];
            $student_cycle_data['level_id'] = $request_data['level_to'];
            $student_cycle_data['session_id'] = $request_data['session_to'];
            $student_cycle_data['section_id'] = $section_to_id;
            $student_cycle_data['shift_id'] = $shift_to_id;
            $student_cycle_data['roll'] = $new_roll;
            $student_data = $insert_data[0] = $student_cycle_data;


            if (count($insert_data) > 0) {
                //insert scms_student_cycle start
                $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
                $insertQueryResult = $scms_student_cycle->query();
                $columns = array_keys($insert_data[0]);

                $insertQueryResult->insert($columns);
                $insertQueryResult->clause('values')->values($insert_data);
                $insertQueryResult->execute();
                //end  scms_student_cycle

                $saved_student_cycle = $scms_student_cycle->find()
                    ->where(['scms_student_cycle.student_id' => $insert_data[0]['student_id']])
                    ->where(['scms_student_cycle.level_id' => $insert_data[0]['level_id']])
                    ->where(['scms_student_cycle.session_id' => $insert_data[0]['session_id']])
                    ->select([
                        'religion_subject' => "scms_students.religion_subject",
                    ])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->join([
                        'scms_students' => [
                            'table' => 'scms_students',
                            'type' => 'INNER',
                            'conditions' => [
                                'scms_student_cycle.student_id = scms_students.student_id'
                            ]
                        ],
                    ])->toArray();
                $this->crate_student_cycles_for_promotion($insert_data, $saved_student_cycle);
            }
            unset($student_data['section_id']);
            unset($student_data['shift_id']);
            unset($student_data['roll']);
            // pr($student_data);
            // die;
            $scms_students = TableRegistry::getTableLocator()->get('scms_students');
            $query = $scms_students->query();
            $query->update()
                ->set($student_data)
                ->where(['student_id' => $result_students[0]['student_id']])
                ->execute();
            if ($request_data['remove']) {
                $this->delete_all_cycle($result_students[0]['student_cycle_id']);
            }
            $this->Flash->success('Promotion Successfully Completed', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'IndividualPromotion']);
        }


        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->toArray();
        $this->set('levels', $levels);
        $section = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $section
            ->find()
            ->toArray();
        $this->set('sections', $sections);
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);
    }

    public function promotion()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $scms_promotion_log = TableRegistry::getTableLocator()->get('scms_promotion_log');
            $promotion_log = $scms_promotion_log->find()
                ->where(['promotion_template_id' => $request_data['template']])
                ->where(['level_from' => $request_data['level_from']])
                ->where(['level_to' => $request_data['level_to']])
                ->where(['deleted' => 0])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

            if (count($promotion_log)) {
                $this->Flash->success('Promotion Unsuccessful, Priovious Promoton Found', [
                    'key' => 'Negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'promotion']);
            }
            $section_from_ids = array();
            foreach ($request_data['section_from'] as $section_from) {
                foreach ($section_from as $section) {
                    $section_from_ids[] = $section;
                }
            }
            $section_to_ids = array();
            foreach ($request_data['section_to'] as $section_to) {
                foreach ($section_to as $section) {
                    $section_to_ids[] = $section;
                }
            }
            $template = $this->get_template_details($request_data['template']);
            if ($template[0]['term_id']) {
                $scms_results = TableRegistry::getTableLocator()->get('scms_results');
                $results = $scms_results->find()
                    ->where(['scms_term_cycle.term_id' => $template[0]['term_id']])
                    ->where(['scms_results.level_id' => $request_data['level_from']])
                    ->where(['scms_results.session_id' => $template[0]['session_from']])
                    ->where(['scms_results.type' => $template[0]['type']])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->join([
                        'scms_term_cycle' => [
                            'table' => 'scms_term_cycle',
                            'type' => 'INNER',
                            'conditions' => [
                                'scms_term_cycle.term_cycle_id = scms_results.term_cycle_id'
                            ]
                        ],
                    ])->toArray();

                if (count($results) == 0) {
                    $this->Flash->success('Promotion Unsuccessful, No Result Found', [
                        'key' => 'Negative',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'promotion']);
                }
                $students = $this->get_students_from_result($results[0]['result_id'], $section_from_ids, $template[0]);
            } else {
                $students = $this->get_students_from_cycle($request_data, $section_from_ids, $template[0]);
            }
            // echo 'tudents';
            // echo '<pre>';
            // print_r($students);
            // die;

            if (isset($students['fail_students']) && count($students['fail_students'])) {
                $fail_students = array();
                foreach ($students['fail_students'] as $student) {
                    foreach ($request_data['section_from'] as $key => $section_from) {
                        if (in_array($student['section_id_from_cycle'], $section_from)) {
                            $fail_students[$key][] = $student;
                            break;
                        }
                    }
                }
                // echo 'fail students';
                // echo '<pre>';
                // print_r($fail_students);
                // die;
                $this->promote_fail_student($fail_students, $template, $request_data, $section_from_ids);
            }


            if (count($students['promote_students'])) {
                $promote_students = array();
                foreach ($students['promote_students'] as $student) {
                    foreach ($request_data['section_from'] as $key => $section_from) {
                        if (in_array($student['section_id_from_cycle'], $section_from)) {
                            $promote_students[$key][] = $student;
                            break;
                        }
                    }
                }
                // echo 'pass students';
                // echo '<pre>';
                // print_r($promote_students);
                // die;
                $this->promote_promoted_student($promote_students, $template, $request_data, $section_to_ids);
            }


            $promotion_log_data[0]['promotion_template_id'] = $request_data['template'];
            $promotion_log_data[0]['level_from'] = $request_data['level_from'];
            $promotion_log_data[0]['level_to'] = $request_data['level_to'];
            $promotion_log_data[0]['section_from'] = json_encode($request_data['section_from']);
            $promotion_log_data[0]['section_to'] = json_encode($request_data['section_to']);
            $promotion_log_data[0]['created_by'] = $this->Auth->user('id');

            $scms_promotion_log = TableRegistry::getTableLocator()->get('scms_promotion_log');
            $insertQueryResult = $scms_promotion_log->query();
            $columns = array_keys($promotion_log_data[0]);
            $insertQueryResult->insert($columns);
            $insertQueryResult->clause('values')->values($promotion_log_data);
            $insertQueryResult->execute();

            $level = TableRegistry::getTableLocator()->get('scms_levels');
            $levelfrom = $level
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['level_id' => $promotion_log_data[0]['level_from']])
                ->toArray();

            $levelto = $level
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['level_id' => $promotion_log_data[0]['level_to']])
                ->toArray();
            $levelfrom = $levelfrom[0]['level_name'];
            $levelto = $levelto[0]['level_name'];
            $total = count($students['promote_students']);

            $this->Flash->success(
                $total . ' students has been promoted from class ' .
                    $levelfrom . ' to ' . $levelto . ' successfully.',
                [
                    'key' => 'positive',
                    'params' => [],
                ]
            );

            // $this->Flash->success('Promotion Successfully Completed', [
            //     'key' => 'positive',
            //     'params' => [],
            // ]);
        }
        $scms_promotion_template = TableRegistry::getTableLocator()->get('scms_promotion_template');
        $prmotion_templates = $scms_promotion_template->find()->where(['deleted' => 0])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('prmotion_templates', $prmotion_templates);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->toArray();
        $this->set('levels', $levels);
    }

    public function promotionList()
    {

        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $session = TableRegistry::getTableLocator()->get('scms_sessions');
            $sessions = $session
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['session_id' => $request_data['session_id']])
                ->toArray();
            $this->set('session', $sessions[0]['session_name']);

            $where['scms_student_cycle.session_id'] = $request_data['session_id'];
            $where['s.status'] = 1;
            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $scms_student_cycles = $scms_student_cycle->find()->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'name' => "s.name",
                    'gender' => "s.gender",
                    'sid' => "s.sid",
                    'mobile' => 's.mobile',
                    'present_address' => "s.present_address",
                    'father_name' => "father.name",
                    'mother_name' => "mother.name",
                    'date_of_birth' => "s.date_of_birth",
                    'blood_group' => "s.blood_group",
                    'status' => "s.status",
                    'shift_name' => "shift.shift_name",
                    'level_name' => "level.level_name",
                    'section_name' => "section.section_name",
                ])
                ->order(['scms_student_cycle.level_id' => 'ASC', 'scms_student_cycle.section_id' => 'ASC', 'roll' => 'ASC'])
                ->join([
                    's' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            's.student_id = scms_student_cycle.student_id'
                        ]
                    ],
                    'father' => [
                        'table' => 'scms_guardians',
                        'type' => 'INNER',
                        'conditions' => [
                            'father.student_id = scms_student_cycle.student_id',
                            'father.rtype' => 'Father',
                        ]
                    ],
                    'mother' => [
                        'table' => 'scms_guardians',
                        'type' => 'INNER',
                        'conditions' => [
                            'mother.student_id = scms_student_cycle.student_id',
                            'mother.rtype' => 'Mother',
                        ]
                    ],
                    'shift' => [
                        'table' => 'hr_shift',
                        'type' => 'INNER',
                        'conditions' => [
                            'shift.shift_id = scms_student_cycle.shift_id'
                        ]
                    ],
                    'level' => [
                        'table' => 'scms_levels',
                        'type' => 'INNER',
                        'conditions' => [
                            'level.level_id = scms_student_cycle.level_id'
                        ]
                    ],
                    'section' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'section.section_id = scms_student_cycle.section_id'
                        ]
                    ],
                    'session' => [
                        'table' => 'scms_sessions',
                        'type' => 'INNER',
                        'conditions' => [
                            'session.session_id  = scms_student_cycle.session_id'
                        ]
                    ],
                    'scms_groups' => [
                        'table' => 'scms_groups',
                        'type' => 'LEFT',
                        'conditions' => [
                            'scms_student_cycle.group_id  = scms_groups.group_id'
                        ]
                    ],
                ])->toArray();
            // pr($scms_student_cycles);die;
            $this->set('students', $scms_student_cycles);
            $head = $this->set_head($request_data);
            $this->set('head', $head);
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
    }

    private function get_sections_details($section_to)
    {
        $section_ids = array_reduce($section_to, 'array_merge', array());
        $scms_sections = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $scms_sections
            ->find()
            ->where(['section_id IN' => $section_ids])
            ->toArray();
        $filter_section = array();
        foreach ($sections as $section) {
            $filter_section_single['section_id'] = $section['section_id'];
            $filter_section_single['shift_id'] = $section['shift_id'];
            $filter_section_single['level_id'] = $section['level_id'];
            $filter_section[$section['section_id']] = $filter_section_single;
        }
        return $filter_section;
    }

    public function viewPromotionTemplate($id)
    {
        $scms_promotion_template = TableRegistry::getTableLocator()->get('scms_promotion_template');
        $prmotion_templates = $scms_promotion_template->find()->where(['promotion_template_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'session_from_name' => "session_from.session_name",
                'session_to_name' => "session_to.session_name",
                'term_name' => "scms_term.term_name",
            ])
            ->join([
                'session_from' => [
                    'table' => 'scms_sessions',
                    'type' => 'INNER',
                    'conditions' => [
                        'session_from.session_id = scms_promotion_template.session_from'
                    ]
                ],
                'session_to' => [
                    'table' => 'scms_sessions',
                    'type' => 'INNER',
                    'conditions' => [
                        'session_to.session_id = scms_promotion_template.session_to'
                    ]
                ],
                'scms_term' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_term.term_id = scms_promotion_template.term_id'
                    ]
                ]
            ])->toArray();
        $this->set('prmotion_templates', $prmotion_templates[0]);
    }

    public function deletePromotionTemplate($id)
    {
        $data['deleted'] = 1;
        $data['deleted_by'] = $this->Auth->user('id');
        $scms_promotion_template = TableRegistry::getTableLocator()->get('scms_promotion_template');
        $query = $scms_promotion_template->query();
        $query->update()
            ->set($data)
            ->where(['promotion_template_id' => $id])
            ->execute();
        $this->Flash->success('Promotion Template Deleted Successfully', [
            'key' => 'positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'promotionTemplate']);
    }

    public function promotionTemplate()
    {
        $scms_promotion_template = TableRegistry::getTableLocator()->get('scms_promotion_template');
        $prmotion_templates = $scms_promotion_template->find()->where(['deleted' => 0])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'session_from_name' => "session_from.session_name",
                'session_to_name' => "session_to.session_name",
                'term_name' => "scms_term.term_name",
            ])
            ->join([
                'session_from' => [
                    'table' => 'scms_sessions',
                    'type' => 'INNER',
                    'conditions' => [
                        'session_from.session_id = scms_promotion_template.session_from'
                    ]
                ],
                'session_to' => [
                    'table' => 'scms_sessions',
                    'type' => 'INNER',
                    'conditions' => [
                        'session_to.session_id = scms_promotion_template.session_to'
                    ]
                ],
                'scms_term' => [
                    'table' => 'scms_term',
                    'type' => 'LEFT',
                    'conditions' => [
                        'scms_term.term_id = scms_promotion_template.term_id'
                    ]
                ]
            ])->toArray();
        $this->set('prmotion_templates', $prmotion_templates);
    }

    public function addPromotionTemplate()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (!isset($request_data['promote_fail'])) {
                unset($request_data['fail_course_count']);
                unset($request_data['fourth_subject']);
            }
            $data[0] = $request_data;
            $scms_promotion_template = TableRegistry::getTableLocator()->get('scms_promotion_template');
            $insertQuery = $scms_promotion_template->query();
            $columns = array_keys($request_data);
            $insertQuery->insert($columns);
            // you must always alter the values clause AFTER insert
            $insertQuery->clause('values')->values($data);
            $insertQuery->execute();
            $this->Flash->success('Promotion Template Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'promotionTemplate']);
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);
        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->toArray();
        $this->set('levels', $levels);
    }

    private function old_promote()
    {

        /*
          //remove multiple course cycle start
          $course_cycle_ids[] = 80;
          $course_cycle_ids[] = 81;
          $course_cycle_ids[] = 101;
          $course_cycle_ids[] = 102;
          $student_term_course_cycle_id = array();
          $student_course_cycle_id = array();
          foreach ($course_cycle_ids as $id) {
          $connection = ConnectionManager::get('default');
          $student_term_course_cycle_sql = 'SELECT* From scms_student_term_course_cycle '
          . 'INNER JOIN scms_student_term_cycle ON scms_student_term_course_cycle.student_term_cycle_id = scms_student_term_cycle.student_term_cycle_id '
          . 'INNER JOIN scms_student_course_cycle ON scms_student_term_course_cycle.student_course_cycle_id = scms_student_course_cycle.student_course_cycle_id '
          . 'INNER JOIN scms_student_cycle ON scms_student_course_cycle.student_cycle_id = scms_student_cycle.student_cycle_id '
          . 'INNER JOIN scms_students ON scms_student_cycle.student_id = scms_students.student_id '
          . 'Where (scms_student_course_cycle.courses_cycle_id =' . $id . ')'
          . 'GROUP BY scms_students.sid ';

          $students = $connection->execute($student_term_course_cycle_sql)->fetchAll('assoc');
          foreach ($students as $student) {
          $student_term_course_cycle_id[] = $student['student_term_course_cycle_id'];
          $student_course_cycle_id[] = $student['student_course_cycle_id'];
          }
          }
          $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
          $query = $scms_student_course_cycle->query();
          $query->delete()
          ->where(['student_course_cycle_id  IN' => $student_course_cycle_id])
          ->execute();

          $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
          $query = $scms_student_term_course_cycle->query();
          $query->delete()
          ->where(['student_term_course_cycle_id  IN' => $student_term_course_cycle_id])
          ->execute();

          die;
         *  //remove multiple course cycle end
         *
         */

        /*
          $old_student_cycles = TableRegistry::getTableLocator()->get('old_student_cycles');
          $old_student_cycless = $old_student_cycles->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['school_session_id' => 2023])
          ->select([
          'sid' => "s.sid",
          'name' => "s.name",
          'email' => "s.email",
          'smobile' => "s.smobile",
          'telephone' => "s.telephone",
          'gender' => "s.gender",
          'religion' => "s.religion",
          'permanent_address' => "s.permanent_address",
          'current_address' => "s.current_address",
          'nationality' => "s.nationality",
          'blood_group' => "s.blood_group",
          'card_no' => "s.card_no",
          'quota' => "s.quota",
          'enrolled' => "s.enrolled",
          'active_guardian' => "s.active_guardian",
          'comment' => "s.comment",
          'status' => "s.status",
          'section_name' => "section.name",
          'shift_name' => "shift.name",
          ])
          ->join([
          's' => [
          'table' => 'old_students',
          'type' => 'INNER',
          'conditions' => [
          's.id = old_student_cycles.student_id'
          ]
          ],
          'section' => [
          'table' => 'old_sections',
          'type' => 'INNER',
          'conditions' => [
          'section.id = old_student_cycles.section_id'
          ]
          ],
          'shift' => [
          'table' => 'old_shifts',
          'type' => 'INNER',
          'conditions' => [
          'shift.id  = section.shift'
          ]
          ],
          ])->toArray();

          $student_ids = array();
          foreach ($old_student_cycless as $key => $old_student_cycles) {
          $student_ids[] = $old_student_cycles['student_id'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['sid'] = $old_student_cycles['sid'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['name'] = $old_student_cycles['name'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['email'] = $old_student_cycles['email'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['mobile'] = $old_student_cycles['smobile'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['gender'] = $old_student_cycles['gender'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['religion'] = $old_student_cycles['religion'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['permanent_address'] = $old_student_cycles['permanent_address'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['present_address'] = $old_student_cycles['current_address'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['nationality'] = $old_student_cycles['nationality'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['blood_group'] = $old_student_cycles['blood_group'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['card_no'] = $old_student_cycles['card_no'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['enrolled'] = $old_student_cycles['enrolled'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['active_guardian'] = $old_student_cycles['active_guardian'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['status'] = $old_student_cycles['status'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['level_id'] = $old_student_cycles['level_id'];

          $studnet[$old_student_cycles['student_id']]['studnet_data']['thrid_subject'] = null;
          $studnet[$old_student_cycles['student_id']]['studnet_data']['forth_subject'] = null;

          $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['level_id'] = $old_student_cycles['level_id'];
          $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['roll'] = $old_student_cycles['roll'];

          if ($old_student_cycles['shift_name']) {
          $hr_shift = TableRegistry::getTableLocator()->get('hr_shift');
          $hr_shifts = $hr_shift
          ->find()
          ->where(['old_shifts.name' => $old_student_cycles['shift_name']])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->join([
          'old_shifts' => [
          'table' => 'old_shifts',
          'type' => 'INNER',
          'conditions' => [
          'old_shifts.name = hr_shift.shift_name'
          ]
          ],
          ])->toArray();
          $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['shift_id'] = $hr_shifts[0]['shift_id'];
          } else {
          $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['shift_id'] = $old_student_cycles['shift_name'];
          }


          if ($old_student_cycles['section_id']) {
          $scms_section = TableRegistry::getTableLocator()->get('scms_sections');
          $scms_sections = $scms_section
          ->find()
          ->where(['section_name' => $old_student_cycles['section_name']])
          ->where(['level_id' => $old_student_cycles['level_id']])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
          $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['section_id'] = $scms_sections[0]['section_id'];
          } else {
          $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['section_id'] = $old_student_cycles['section_id'];
          }

          if ($old_student_cycles['school_session_id']) {
          $scms_session = TableRegistry::getTableLocator()->get('scms_sessions');
          $scms_sessions = $scms_session
          ->find()
          ->where(['session_name' => $old_student_cycles['school_session_id']])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
          $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['session_id'] = $scms_sessions[0]['session_id'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['session_id'] = $scms_sessions[0]['session_id'];
          } else {
          $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['session_id'] = $old_student_cycles['session_id'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['session_id'] = $scms_sessions[0]['session_id'];
          }
          if ($old_student_cycles['group_id']) {
          $scms_group = TableRegistry::getTableLocator()->get('scms_groups');
          $scms_groups = $scms_group
          ->find()
          ->where(['id' => $old_student_cycles['group_id']])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->join([
          'old_groups' => [
          'table' => 'old_groups',
          'type' => 'INNER',
          'conditions' => [
          'old_groups.name = scms_groups.group_name'
          ]
          ],
          ])->toArray();
          if (count($scms_groups) > 0) {
          $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['group_id'] = $scms_groups[0]['group_id'];
          } else {
          $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['group_id'] = null;
          }
          } else {
          $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['group_id'] = $old_student_cycles['group_id'];
          }

          //course cycle
          $course_type_id[] = 1;
          $course_type_id[] = 2;
          $scms_course = TableRegistry::getTableLocator()->get('scms_courses');
          $scms_courses = $scms_course
          ->find()
          ->select([
          'courses_cycle_id' => "scms_courses_cycle.courses_cycle_id",
          ])
          ->where(['level_id' => $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['level_id']])
          ->where(['session_id' => $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['session_id']])
          ->where(['course_type_id IN' => $course_type_id])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->join([
          'scms_courses_cycle' => [
          'table' => 'scms_courses_cycle',
          'type' => 'INNER',
          'conditions' => [
          'scms_courses.course_id = scms_courses_cycle.course_id'
          ]
          ],
          ])->toArray();
          foreach ($scms_courses as $course) {
          $studnet[$old_student_cycles['student_id']]['courses_cycle_ids'][] = $course['courses_cycle_id'];
          }
          //religion course
          if ($studnet[$old_student_cycles['student_id']]['studnet_data']['religion'] == 'Islam') {
          $course_name = 'ISLAM AND MORAL EDUCATION';
          } else if ($studnet[$old_student_cycles['student_id']]['studnet_data']['religion'] == 'Hindu') {
          $course_name = 'HINDU RELIGION AND MORAL EDUCATION';
          }
          $religion_courses = $scms_course
          ->find()
          ->select([
          'courses_cycle_id' => "scms_courses_cycle.courses_cycle_id",
          ])
          ->where(['level_id' => $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['level_id']])
          ->where(['session_id' => $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['session_id']])
          ->where(['course_name' => $course_name])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->join([
          'scms_courses_cycle' => [
          'table' => 'scms_courses_cycle',
          'type' => 'INNER',
          'conditions' => [
          'scms_courses.course_id = scms_courses_cycle.course_id'
          ]
          ],
          ])->toArray();

          $studnet[$old_student_cycles['student_id']]['courses_cycle_ids'][] = $religion_courses[0]['courses_cycle_id'];
          $studnet[$old_student_cycles['student_id']]['studnet_data']['religion_subject'] = $religion_courses[0]['course_id'];

          //3rd subject 4th subject
          $old_student_course = TableRegistry::getTableLocator()->get('old_student_courses');
          $old_student_3rd_4th = $old_student_course->find()
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->where(['old_student_courses.student_cycle_id' => $old_student_cycles['id']])
          ->where(['old_course_cycles.school_session_id' => 2023])
          ->where(['old_course_cycles.level_id' => $old_student_cycles['level_id']])
          ->select([
          'name' => "old_courses.name",
          ])
          ->join([
          'old_course_cycles' => [
          'table' => 'old_course_cycles',
          'type' => 'INNER',
          'conditions' => [
          'old_course_cycles.id = old_student_courses.course_cycle_id'
          ]
          ],
          'old_courses' => [
          'table' => 'old_courses',
          'type' => 'INNER',
          'conditions' => [
          'old_courses.id = old_course_cycles.course_id'
          ]
          ],
          ])->toArray();

          if (count($old_student_3rd_4th) > 0) {
          $course_names = array();
          foreach ($old_student_3rd_4th as $old_3rd_4th) {
          if (trim($old_3rd_4th['name']) == "HOME SCIENCE") {
          $course_names = 'HOME SCIENCE (4TH)';
          } else {
          $course_names = $old_3rd_4th['name'];
          }
          $new_3rd_4th_cycle = $scms_course
          ->find()
          ->select([
          'courses_cycle_id' => "scms_courses_cycle.courses_cycle_id",
          ])
          ->where(['level_id' => $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['level_id']])
          ->where(['session_id' => $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['session_id']])
          ->where(['course_name' => $course_names])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->join([
          'scms_courses_cycle' => [
          'table' => 'scms_courses_cycle',
          'type' => 'INNER',
          'conditions' => [
          'scms_courses.course_id = scms_courses_cycle.course_id'
          ]
          ],
          ])->toArray();
          if (count($new_3rd_4th_cycle) > 0) {
          $studnet[$old_student_cycles['student_id']]['courses_cycle_ids'][] = $new_3rd_4th_cycle[0]['courses_cycle_id'];

          if ($old_3rd_4th['type'] == '4th') {
          $studnet[$old_student_cycles['student_id']]['studnet_data']['forth_subject'] = $new_3rd_4th_cycle[0]['course_id'];
          }
          if ($old_3rd_4th['type'] == '3rd') {
          $studnet[$old_student_cycles['student_id']]['studnet_data']['thrid_subject'] = $new_3rd_4th_cycle[0]['course_id'];
          }
          }
          }
          }
          //selective course
          if ($studnet[$old_student_cycles['student_id']]['studnet_data']['level_id'] > 8) {
          $selective_courses = $scms_course
          ->find()
          ->select([
          'courses_cycle_id' => "scms_courses_cycle.courses_cycle_id",
          ])
          ->where(['level_id' => $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['level_id']])
          ->where(['session_id' => $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['session_id']])
          ->where(['course_group_id' => $studnet[$old_student_cycles['student_id']]['studnet_cycle_data']['group_id']])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->join([
          'scms_courses_cycle' => [
          'table' => 'scms_courses_cycle',
          'type' => 'INNER',
          'conditions' => [
          'scms_courses.course_id = scms_courses_cycle.course_id'
          ]
          ],
          ])->toArray();
          foreach ($selective_courses as $selective_course) {
          $studnet[$old_student_cycles['student_id']]['courses_cycle_ids'][] = $selective_course['courses_cycle_id'];
          }
          }
          }
          //guardians
          $old_guardian = TableRegistry::getTableLocator()->get('old_guardians');
          $old_guardians = $old_guardian
          ->find()
          ->where(['student_id IN' => $student_ids])
          ->enableAutoFields(true)
          ->enableHydration(false)
          ->toArray();
          foreach ($old_guardians as $guardian) {
          if ($guardian['rtype'] != 'Guardian') {
          $guardian_data = array();
          $guardian_data['name'] = $guardian['name'];
          $guardian_data['gender'] = $guardian['gender'];
          $guardian_data['nationality'] = $guardian['nationality'];
          $guardian_data['occupation'] = $guardian['occupation'];
          $guardian_data['email'] = $guardian['email'];
          $guardian_data['mobile'] = $guardian['mobile'];
          $guardian_data['yearly_income'] = $guardian['yearly_income'];
          $guardian_data['rtype'] = $guardian['rtype'];
          $guardian_data['relation'] = $guardian['relation'];
          $guardian_data['religion'] = $guardian['religion'];
          $studnet[$guardian['student_id']]['guardian_data'][] = $guardian_data;
          } else {
          if ($studnet[$guardian['student_id']]['guardian_data'][0]['mobile'] == $guardian['mobile']) {
          $studnet[$guardian['student_id']]['studnet_data']['active_guardian'] = $studnet[$guardian['student_id']]['guardian_data'][0]['rtype'];
          }
          if ($studnet[$guardian['student_id']]['guardian_data'][1]['mobile'] == $guardian['mobile']) {
          $studnet[$guardian['student_id']]['studnet_data']['active_guardian'] = $studnet[$guardian['student_id']]['guardian_data'][1]['rtype'];
          }
          }
          }

          foreach ($studnet as $key => $new_studnet) {
          //student table
          $scms_students = TableRegistry::getTableLocator()->get('scms_students');
          $query = $scms_students->query();
          $query->insert(['sid', 'name', 'email', 'mobile', 'gender', 'religion', 'permanent_address', 'present_address', 'nationality', 'blood_group', 'enrolled', 'active_guardian', 'status', 'level_id', 'religion_subject', 'thrid_subject', 'forth_subject', 'card_no'])
          ->values($new_studnet['studnet_data'])
          ->execute();
          $myrecords = $scms_students->find()->last(); //get the last id
          $student_id = $new_studnet['studnet_cycle_data']['student_id'] = $myrecords->student_id;
          //student cycle table
          $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
          $query = $scms_student_cycle->query();
          $query->insert(['level_id', 'roll', 'shift_id', 'section_id', 'session_id', 'group_id', 'student_id'])
          ->values($new_studnet['studnet_cycle_data'])
          ->execute();
          $myrecords1 = $scms_student_cycle->find()->last(); //get the last id
          $student_cycle_id = $myrecords1->student_cycle_id;

          foreach ($new_studnet['guardian_data'] as $key => $guardian_data) {
          $guardian_data['student_id'] = $student_id;
          $scms_guardians = TableRegistry::getTableLocator()->get('scms_guardians');
          $query = $scms_guardians->query();
          $query->insert(['student_id', 'name', 'gender', 'nationality', 'occupation', 'email', 'mobile', 'yearly_income', 'rtype', 'relation', 'religion'])
          ->values($guardian_data)
          ->execute();
          }

          foreach ($new_studnet['courses_cycle_ids'] as $key => $courses_cycle_id) {
          $scms_student_course_cycle_data['courses_cycle_id'] = $courses_cycle_id;
          $scms_student_course_cycle_data['student_cycle_id'] = $student_cycle_id;
          $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
          $query = $scms_student_course_cycle->query();
          $query->insert(['courses_cycle_id', 'student_cycle_id'])
          ->values($scms_student_course_cycle_data)
          ->execute();
          }
          }

          echo 'completed';
          die;
         *
         */
    }

    public function addQuizResult()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            if (count($request_data) > 0) {
                if (isset($request_data['student_term_course_cycle_id'])) {
                    foreach ($request_data['student_term_course_cycle_id'] as $key => $student_term_course_cycle_id) {
                        foreach ($request_data['quiz'] as $key1 => $quiz) {
                            $quiz_mark_data['student_term_course_cycle_id'] = $student_term_course_cycle_id;
                            $quiz_mark_data['quiz_id'] = $key1;
                            if ($quiz[$student_term_course_cycle_id][1]) {
                                $quiz_mark_data['mark'] = $quiz[$student_term_course_cycle_id][1];
                            } else {
                                $quiz_mark_data['mark'] = 0;
                            }
                            $quiz_mark_id = $quiz[$student_term_course_cycle_id][0];
                            $quiz_mark = TableRegistry::getTableLocator()->get('scms_quiz_mark');
                            if ($quiz_mark_id) {
                                $query = $quiz_mark->query();
                                $query->update()
                                    ->set($quiz_mark_data)
                                    ->where(['quiz_mark_id' => $quiz_mark_id])
                                    ->execute();
                            } else {
                                $query = $quiz_mark->query();
                                $query
                                    ->insert(['student_term_course_cycle_id', 'quiz_id', 'mark'])
                                    ->values($quiz_mark_data)
                                    ->execute();
                            }
                        }
                    }
                    //Set Flash
                    $this->Flash->success('Quiz Added/Updated Successfully', [
                        'key' => 'positive',
                        'params' => [],
                    ]);
                } else {
                    $connection = ConnectionManager::get('default');
                    $student_term_course_cycle_sql = 'SELECT* From scms_student_term_course_cycle '
                        . 'INNER JOIN scms_student_term_cycle ON scms_student_term_course_cycle.student_term_cycle_id = scms_student_term_cycle.student_term_cycle_id '
                        . 'INNER JOIN scms_student_course_cycle ON scms_student_term_course_cycle.student_course_cycle_id = scms_student_course_cycle.student_course_cycle_id '
                        . 'INNER JOIN scms_student_cycle ON scms_student_course_cycle.student_cycle_id = scms_student_cycle.student_cycle_id '
                        . 'INNER JOIN scms_students ON scms_student_cycle.student_id = scms_students.student_id '
                        . 'Where (scms_student_course_cycle.courses_cycle_id =' . $request_data['courses_cycle_id'] . ' And scms_students.status = 1' . ' And scms_student_term_cycle.term_cycle_id =' . $request_data['term_cycle_id'] . ' And scms_student_cycle.session_id =' . $request_data['session_id'] . ' And scms_student_cycle.shift_id =' . $request_data['shift_id'] . ' And scms_student_cycle.level_id =' . $request_data['level_id'] . ' And scms_student_cycle.section_id =' . $request_data['section_id'] . ')'
                        . 'ORDER BY scms_student_cycle.roll ASC ';

                    $students = $connection->execute($student_term_course_cycle_sql)->fetchAll('assoc');
                    $students_filter = array();
                    $quizs_filter = array();
                    if (count($students) > 0) {
                        $where['term_course_cycle_part_id'] = $request_data['term_course_cycle_part_id'];
                        if ($request_data['scms_quiz_id']) {
                            $where['scms_quiz_id'] = $request_data['scms_quiz_id'];
                        }
                        $quiz = TableRegistry::getTableLocator()->get('scms_quiz');
                        $quizs = $quiz
                            ->find()
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->where($where)
                            ->order(['scms_quiz_id' => 'ASC'])
                            ->toArray();
                        if (count($quizs) == 0) {
                            //Set Flash
                            $this->Flash->success('Please Create Quiz for this Part!', [
                                'key' => 'Negative',
                                'params' => [],
                            ]);
                            return $this->redirect(['action' => 'addQuizResult']);
                        }
                        foreach ($quizs as $quiz) {
                            $quiz['quiz_mark_id'] = null;
                            $quiz['obtail_marks'] = null;
                            $quizs_filter[$quiz['scms_quiz_id']] = $quiz;
                            $quiz_ids[] = $quiz['scms_quiz_id'];
                        }

                        foreach ($students as $student) {
                            $students_filter[$student['student_term_course_cycle_id']] = $student;
                            $students_filter[$student['student_term_course_cycle_id']]['quiz'] = $quizs_filter;
                        }
                        $quiz_mark = TableRegistry::getTableLocator()->get('scms_quiz_mark');
                        $quiz_marks = $quiz_mark
                            ->find()
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->where(['quiz_id  in' => $quiz_ids])
                            ->order(['quiz_id' => 'ASC'])
                            ->toArray();

                        foreach ($quiz_marks as $quiz_mark) {
                            if (isset($students_filter[$quiz_mark['student_term_course_cycle_id']])) {
                                $students_filter[$quiz_mark['student_term_course_cycle_id']]['quiz'][$quiz_mark['quiz_id']]['obtail_marks'] = $quiz_mark['mark'];
                                $students_filter[$quiz_mark['student_term_course_cycle_id']]['quiz'][$quiz_mark['quiz_id']]['quiz_mark_id'] = $quiz_mark['quiz_mark_id'];
                            }
                        }
                    }
                    $this->set('students', $students_filter);
                    $this->set('quizs', $quizs_filter);

                    $head = $this->set_head($request_data);
                    $this->set('head', $head);
                }
            } else {
                //Set Flash
                $this->Flash->warning('Nothing to Add/Update', [
                    'key' => 'positive',
                    'params' => [],
                ]);
            }
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels('marks');
        $this->set('levels', $levels);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('groups', $groups);
        $shifts = $this->get_shifts('marks');
        $this->set('shifts', $shifts);
        $sections = $this->get_sections('marks', $levels[0]->level_id);
        $this->set('sections', $sections);

        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);
    }

    public function addActivityResult()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();

            if (count($request_data) > 0) {
                if (isset($request_data['student_term_cycle_id'])) {
                    $scms_student_activity = TableRegistry::getTableLocator()->get('scms_student_activity');
                    if ($request_data['update']) {
                        $no_index_student_term_cycle_id = array_values($request_data['student_term_cycle_id']);
                        $query = $scms_student_activity->query();
                        $query->delete()
                            ->where(['student_term_cycle_id IN' => $no_index_student_term_cycle_id])
                            ->where(['term_activity_cycle_id' => $request_data['term_activity_cycle_id']])
                            ->execute();
                        //delete scms_student_activity
                    }
                    $scms_student_activity_data = array();
                    foreach ($request_data['student_term_cycle_id'] as $student_term_cycle_id) {
                        $scms_student_activity_data_single['term_activity_cycle_id'] = $request_data['term_activity_cycle_id'];
                        $scms_student_activity_data_single['student_term_cycle_id'] = $student_term_cycle_id;
                        if (isset($request_data['remark_id'])) {
                            $scms_student_activity_data_single['remark_id'] = json_encode($request_data['remark_id'][$student_term_cycle_id]);
                        }
                        $scms_student_activity_data_single['comment'] = $request_data['comment'][$student_term_cycle_id];
                        $scms_student_activity_data[] = $scms_student_activity_data_single;
                    }
                    if (count($scms_student_activity_data) > 0) {

                        $insertQuery = $scms_student_activity->query();
                        $columns = array_keys($scms_student_activity_data[0]);
                        $insertQuery->insert($columns);
                        // you must always alter the values clause AFTER insert
                        $insertQuery->clause('values')->values($scms_student_activity_data);
                        $insertQuery->execute();
                    }
                    //Set Flash
                    $this->Flash->success('Activity Added/Updated Successfully', [
                        'key' => 'positive',
                        'params' => [],
                    ]);
                } else {
                    $scms_term_activity_cycle = TableRegistry::getTableLocator()->get('scms_term_activity_cycle');
                    $term_activity_cycle = $scms_term_activity_cycle
                        ->find()
                        ->where(['scms_term_activity_cycle.term_activity_cycle_id' => $request_data['term_activity_cycle_id']])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->select([
                            'activity_name' => 'a.name',
                            'activity_id' => 'a.activity_id',
                            'multiple' => 'a.multiple',
                            'comment' => 'a.comment',
                        ])
                        ->join([
                            'ac' => [
                                'table' => 'scms_activity_cycle',
                                'type' => 'LEFT',
                                'conditions' => ['ac.activity_cycle_id  = scms_term_activity_cycle.activity_cycle_id'],
                            ],
                            'a' => [
                                'table' => 'scms_activity',
                                'type' => 'LEFT',
                                'conditions' => ['a.activity_id  = ac.activity_id'],
                            ],
                        ])
                        ->toArray();

                    $this->set('term_activity_cycle', $term_activity_cycle[0]);

                    $scms_activity_remark = TableRegistry::getTableLocator()->get('scms_activity_remark');
                    $activity_remark = $scms_activity_remark
                        ->find()
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->where(['activity_id' => $term_activity_cycle[0]['activity_id']])
                        ->where(['deleted' => 0])
                        ->toArray();

                    $connection = ConnectionManager::get('default');
                    $student_term_course_cycle_sql = 'SELECT* From scms_student_term_cycle '
                        . 'INNER JOIN scms_student_cycle ON scms_student_term_cycle.student_cycle_id = scms_student_cycle.student_cycle_id '
                        . 'INNER JOIN scms_students ON scms_student_cycle.student_id = scms_students.student_id '
                        . 'Where (scms_students.status = 1' . ' And scms_student_term_cycle.term_cycle_id =' . $request_data['term_cycle_id'] . ' And scms_student_cycle.session_id =' . $request_data['session_id'] . ' And scms_student_cycle.shift_id =' . $request_data['shift_id'] . ' And scms_student_cycle.level_id =' . $request_data['level_id'] . ' And scms_student_cycle.section_id =' . $request_data['section_id'] . ')'
                        . 'ORDER BY scms_student_cycle.roll ASC ';

                    $students = $connection->execute($student_term_course_cycle_sql)->fetchAll('assoc');

                    $student_term_cycle_ids = array();
                    $filter_student = array();
                    foreach ($students as $student) {
                        $student_term_cycle_ids[] = $student['student_term_cycle_id'];
                        $student['comment'] = $term_activity_cycle[0]['comment'];
                        $student['activity_remark'] = $activity_remark;
                        $filter_student[$student['student_term_cycle_id']] = $student;
                    }

                    $scms_student_activity = TableRegistry::getTableLocator()->get('scms_student_activity');
                    $student_activity = $scms_student_activity
                        ->find()
                        ->where(['scms_student_activity.term_activity_cycle_id' => $request_data['term_activity_cycle_id']])
                        ->where(['scms_student_activity.student_term_cycle_id IN' => $student_term_cycle_ids])
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->toArray();
                    if (count($student_activity) > 0) {
                        $this->set('update', 1);
                        $no_activity_remark = array();
                        foreach ($activity_remark as $remark) {
                            $remark['is_default'] = null;
                            $no_activity_remark[$remark['activity_remark_id']] = $remark;
                        }
                        foreach ($filter_student as $key => $student) {
                            $filter_student[$key]['activity_remark'] = $no_activity_remark;
                        }
                        foreach ($student_activity as $activity) {
                            $filter_student[$activity['student_term_cycle_id']]['comment'] = $activity['comment'];
                            $remark_ids = json_decode($activity['remark_id']);
                            if ($remark_ids) {
                                foreach ($remark_ids as $remark_id) {
                                    if (isset($filter_student[$activity['student_term_cycle_id']]['activity_remark'][$remark_id])) {
                                        $filter_student[$activity['student_term_cycle_id']]['activity_remark'][$remark_id]['is_default'] = 1;
                                    }
                                }
                            }
                        }
                    } else {
                        $this->set('update', 0);
                    }
                    if (count($activity_remark) > 0) {
                        $this->set('activity_remark', $activity_remark);
                    } else {
                        $this->set('activity_remark', 0);
                    }
                    $this->set('multiple', $term_activity_cycle[0]['multiple']);
                    $this->set('students', $filter_student);
                    $head = $this->set_head($request_data);
                    $head['activity_name'] = $term_activity_cycle[0]['activity_name'];
                    $this->set('head', $head);
                }
            } else {
                //Set Flash
                $this->Flash->warning('Nothing to Add/Update', [
                    'key' => 'positive',
                    'params' => [],
                ]);
            }
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('groups', $groups);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
    }

    public function addResult()
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();


            if (isset($request_data['student_term_course_cycle_id'])) { //echo '1';die;
                if (isset($request_data['mark'])) {

                    foreach ($request_data['mark'] as $student_term_course_cycle_id => $student_marks) {

                        $term_course_cycle_part_mark_data['student_term_course_cycle_id'] = $student_term_course_cycle_id;

                        $total_mark = 0;

                        // FIRST LOOP — calculate total
                        foreach ($student_marks as $term_course_cycle_part_id => $student_mark) {

                            $key = array_keys($student_mark);
                            $mark_value = $student_mark[$key[0]] ?? 0;

                            if ($mark_value === null || $mark_value === '' || !is_numeric($mark_value)) {
                                $mark_value = 0;
                            }

                            $count_flag_value = $request_data['count_flag'][$student_term_course_cycle_id][$term_course_cycle_part_id];
                            $type_flag_value  = $request_data['type_flag'][$student_term_course_cycle_id][$term_course_cycle_part_id];

                            if ($count_flag_value == 0 && $type_flag_value != 9999) {
                                continue;
                            }

                            if ($type_flag_value != 9999) {
                                $total_mark += $mark_value;
                            }
                        }


                        // SECOND LOOP — save each part
                        foreach ($student_marks as $term_course_cycle_part_id => $student_mark) {

                            $key = array_keys($student_mark);
                            $mark_value = $student_mark[$key[0]] ?? 0;

                            if ($mark_value === null || $mark_value === '' || !is_numeric($mark_value)) {
                                $mark_value = 0;
                            }

                            $count_flag_value = $request_data['count_flag'][$student_term_course_cycle_id][$term_course_cycle_part_id];
                            $type_flag_value  = $request_data['type_flag'][$student_term_course_cycle_id][$term_course_cycle_part_id];

                            if ($type_flag_value == 9999) {
                                $mark_value = $total_mark;
                            }

                            $term_course_cycle_part_mark_data = [
                                'student_term_course_cycle_id' => $student_term_course_cycle_id,
                                'term_course_cycle_part_id'    => $term_course_cycle_part_id,
                                'marks'                        => $mark_value
                            ];

                            $mark = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_mark');

                            if ($key[0] > 0) {
                                $mark->query()->update()
                                    ->set($term_course_cycle_part_mark_data)
                                    ->where(['term_course_cycle_part_mark_id' => $key[0]])
                                    ->execute();
                            } else {
                                $mark->query()->insert(['student_term_course_cycle_id', 'term_course_cycle_part_id', 'marks'])
                                    ->values($term_course_cycle_part_mark_data)
                                    ->execute();
                            }

                            if ($type_flag_value == 9999) {
                                $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
                                $scms_student_term_course_cycle->query()->update()
                                    ->set(['student_term_course_cycle_mark' => $mark_value])
                                    ->where(['student_term_course_cycle_id' => $student_term_course_cycle_id])
                                    ->execute();
                            }
                        }
                    }

                    //Set Flash
                    $this->Flash->success('Marks Added/Updated Successfully', [
                        'key' => 'positive',
                        'params' => [],
                    ]);
                    return $this->redirect(['action' => 'addResult']);
                } else {
                    //Set Flash
                    $this->Flash->warning('Nothing to Add/Update', [
                        'key' => 'positive',
                        'params' => [],
                    ]);
                }
            } else { //echo '2';die;
                $connection = ConnectionManager::get('default');
                $term_course_cycle_id_sql = 'SELECT scms_term_course_cycle.term_course_cycle_id  FROM scms_term_course_cycle '
                    . 'INNER JOIN scms_term_cycle ON scms_term_course_cycle.term_cycle_id = scms_term_cycle.term_cycle_id '
                    . 'INNER JOIN scms_courses_cycle ON scms_term_course_cycle.courses_cycle_id = scms_courses_cycle.courses_cycle_id '
                    . 'Where (scms_courses_cycle.courses_cycle_id =' . $request_data['courses_cycle_id'] . ' And scms_term_cycle.term_cycle_id =' . $request_data['term_cycle_id'] . ')';

                $sql = 'SELECT* From scms_term_course_cycle_part '
                    . 'INNER JOIN scms_term_course_cycle_part_type ON scms_term_course_cycle_part.term_course_cycle_part_type_id = scms_term_course_cycle_part_type.term_course_cycle_part_type_id '
                    . 'Where (scms_term_course_cycle_part.term_course_cycle_id = (' . $term_course_cycle_id_sql . ') And scms_term_course_cycle_part.mark > 0 )'
                    . 'ORDER BY scms_term_course_cycle_part_type.term_course_cycle_part_type_id ASC';
                $scms_term_course_cycle_part = $connection->execute($sql)->fetchAll('assoc');
                $scms_term_course_cycle_part_filter = array();
                foreach ($scms_term_course_cycle_part as $part) {
                    $part['term_course_cycle_part_mark_id'] = null;
                    $part['obtail_marks'] = null;
                    if ($part['partable'] == 'Yes') {
                        $part['quiz_marks'] = null;
                    }
                    $scms_term_course_cycle_part_filter[$part['term_course_cycle_part_id']] = $part;
                    $part_ids[] = $part['term_course_cycle_part_id'];
                }
                // echo '<pre>';
                // print_r($scms_term_course_cycle_part_filter);die;

                $this->set('scms_term_course_cycle_parts', $scms_term_course_cycle_part_filter);

                $student_term_course_cycle_sql = 'SELECT* From scms_student_term_course_cycle '
                    . 'INNER JOIN scms_student_term_cycle ON scms_student_term_course_cycle.student_term_cycle_id = scms_student_term_cycle.student_term_cycle_id '
                    . 'INNER JOIN scms_student_course_cycle ON scms_student_term_course_cycle.student_course_cycle_id = scms_student_course_cycle.student_course_cycle_id '
                    . 'INNER JOIN scms_student_cycle ON scms_student_course_cycle.student_cycle_id = scms_student_cycle.student_cycle_id '
                    . 'INNER JOIN scms_students ON scms_student_cycle.student_id = scms_students.student_id '
                    . 'Where (scms_student_course_cycle.courses_cycle_id =' . $request_data['courses_cycle_id'] . ' And scms_students.status = 1' . ' And scms_student_term_cycle.term_cycle_id =' . $request_data['term_cycle_id'] . ' And scms_student_cycle.session_id =' . $request_data['session_id'] . ' And scms_student_cycle.shift_id =' . $request_data['shift_id'] . ' And scms_student_cycle.level_id =' . $request_data['level_id'] . ' And scms_student_cycle.section_id =' . $request_data['section_id'] . ')'
                    . 'ORDER BY scms_student_cycle.roll ASC ';

                $students = $connection->execute($student_term_course_cycle_sql)->fetchAll('assoc');
                $students_filter = array();
                foreach ($students as $student) {
                    $students_filter[$student['student_term_course_cycle_id']] = $student;
                    $students_filter[$student['student_term_course_cycle_id']]['mark'] = $scms_term_course_cycle_part_filter;
                }

                if (count($scms_term_course_cycle_part_filter) > 0) {
                    $term_course_cycle_part_mark = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_mark');
                    $term_course_cycle_part_marks = $term_course_cycle_part_mark
                        ->find()
                        ->enableAutoFields(true)
                        ->enableHydration(false)
                        ->where(['term_course_cycle_part_id  in' => $part_ids])
                        ->order(['term_course_cycle_part_id' => 'ASC'])
                        ->toArray();

                    foreach ($term_course_cycle_part_marks as $part_mark) {
                        if (isset($students_filter[$part_mark['student_term_course_cycle_id']])) {
                            $students_filter[$part_mark['student_term_course_cycle_id']]['mark'][$part_mark['term_course_cycle_part_id']]['obtail_marks'] = $part_mark['marks'];
                            $students_filter[$part_mark['student_term_course_cycle_id']]['mark'][$part_mark['term_course_cycle_part_id']]['term_course_cycle_part_mark_id'] = $part_mark['term_course_cycle_part_mark_id'];
                        }
                    }
                }

                $partable_parts = $this->get_partable_part($request_data);
                // echo '<pre>';
                // print_r($partable_parts);die;

                foreach ($partable_parts as $term_course_cycle_part_id => $partable_part) {
                    if (count($partable_part['student']) > 0) {
                        foreach ($partable_part['student'] as $student_term_course_cycle_id => $quiz_part) {
                            if (isset($students_filter[$student_term_course_cycle_id])) {
                                $students_filter[$student_term_course_cycle_id]['mark'][$term_course_cycle_part_id]['quiz_marks'] = number_format($quiz_part['obtail_mark'], 2);
                            }
                        }
                    }
                }

                $this->set('students', $students_filter);
            }


            $head = $this->set_head($request_data);
            $this->set('head', $head);
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels('marks');
        $this->set('levels', $levels);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('groups', $groups);

        $shifts = $this->get_shifts('students');
        $this->set('shifts', $shifts);
        $active_session = $this->get_active_session();
        $this->set('active_session_id', $active_session[0]['session_id']);
        $sections = $this->get_sections('marks', $levels[0]->level_id);
        $this->set('sections', $sections);
    }



    /* private function get_sid($data) {
         $student = TableRegistry::getTableLocator()->get('scms_students'); //Execute First
         $students = $student
                 ->find()
                 ->where(['session_id' => $data['session_id']])
                 ->where(['level_id' => $data['level_id']])
                 ->order(['student_id' => 'DESC'])
                 ->toArray();

         if (!empty($students)) {
             $new_serial = intval(substr($students[0]->sid, -3)) + 1;
             if ($new_serial < 10) {
                 $new_serial = '00' . $new_serial;
             } else if ($new_serial < 100) {
                 $new_serial = '0' . $new_serial;
             }
         } else {
             $new_serial = '001';
         }
         $session = TableRegistry::getTableLocator()->get('scms_sessions'); //Execute First
         $sessions = $session
                 ->find()
                 ->where(['session_id' => $data['session_id']])
                 ->toArray();
         $session = intval(substr($sessions[0]->session_name, -2));
         if ($data['level_id'] < 10) {
             $data['level_id'] = '0' . $data['level_id'];
         }
         $sid = $session . $data['level_id'] . $new_serial;
         return $sid;
     }*/

    private function get_sid($data)
    {


        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['session_id' => $data['session_id']])
            ->toArray();

        $session = $sessions[0]['session_name'];
        $level = $data['level_id'];
        $year = empty($session) ? date('y') : substr($session, 2);





        $condition = sprintf("%02s%02s", $year, $level);


        $student = TableRegistry::getTableLocator()->get('scms_students');

        // Find the last student SID for the given session
        $students = $student
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['sid LIKE' => $condition . '%'])
            ->order(['sid' => 'DESC']) // Sort by 'sid' in descending order to get the last entry
            ->first();


        $sid = !empty($students) ? ($students['sid'] + 1) : $condition . '001';


        return $sid;
    }

    private function get_partable_part($request_data)
    {
        $term_course_cycle_part = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part');
        $parts = $term_course_cycle_part
            ->find()
            ->where(['tcc.courses_cycle_id' => $request_data['courses_cycle_id']])
            ->where(['tcc.term_cycle_id' => $request_data['term_cycle_id']])
            ->where(['scms_term_course_cycle_part.mark >' => 0])
            ->where(['tccpt.partable' => 'Yes'])
            ->where(['tccpt.status' => 1])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'courses_cycle_id' => 'tcc.courses_cycle_id',
                'term_course_cycle_part_type_name' => 'tccpt.term_course_cycle_part_type_name',
                'count' => 'tccpt.count',
                'status' => 'tccpt.status',
            ])
            ->join([
                'tccpt' => [
                    'table' => 'scms_term_course_cycle_part_type',
                    'type' => 'LEFT',
                    'conditions' => ['tccpt.term_course_cycle_part_type_id  = scms_term_course_cycle_part.term_course_cycle_part_type_id'],
                ],
            ])
            ->join([
                'tcc' => [
                    'table' => 'scms_term_course_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['tcc.term_course_cycle_id   = scms_term_course_cycle_part.term_course_cycle_id'],
                ],
            ])
            ->toArray();

        $filter_parts = array();
        foreach ($parts as $key => $part) {
            $part['total'] = 0;
            $quiz = TableRegistry::getTableLocator()->get('scms_quiz');
            $quizs = $quiz
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['term_course_cycle_part_id' => $part['term_course_cycle_part_id']])
                ->order(['scms_quiz_id' => 'ASC'])
                ->toArray();
            $filter_quiz_marks = array();
            if (count($quizs) > 0) {
                foreach ($quizs as $quiz) {
                    $part['total'] = $part['total'] + $quiz['marks'];
                    $part['quiz_id'][] = $quiz['scms_quiz_id'];
                }
                $quiz_mark = TableRegistry::getTableLocator()->get('scms_quiz_mark');
                $quiz_marks = $quiz_mark
                    ->find()
                    ->select([
                        'total_mark' => 'SUM(scms_quiz_mark.mark)',
                    ])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['quiz_id  in' => $part['quiz_id']])
                    ->order(['quiz_id' => 'ASC'])
                    ->group(['student_term_course_cycle_id'])
                    ->toArray();

                foreach ($quiz_marks as $key2 => $quiz_mark) {
                    $quiz_mark['obtail_mark'] = $quiz_mark['total_mark'] * ($part['mark'] / $part['total']);
                    $filter_quiz_marks[$quiz_mark['student_term_course_cycle_id']] = $quiz_mark;
                }
            }

            $part['student'] = $filter_quiz_marks;
            $filter_parts[$part['term_course_cycle_part_id']] = $part;
        }
        // echo '<pre>';
        // print_r($filter_parts);die;
        return $filter_parts;
    }

    public function addSeatplan()
    {
        if ($this->request->is('post')) {
            $rooms = $this->request->data;

            $individualArrays = array();

            for ($i = 0; $i < count($rooms['name']); $i++) {
                $item = array(
                    'name' => $rooms['name'][$i],
                    'quantity' => $rooms['quantity'][$i],
                    'location' => $rooms['location'][$i]
                );
                $individualArrays[$i] = $item;
            }

            $admissionInfos = TableRegistry::getTableLocator()->get('admissions');
            $admissionInfo = $admissionInfos->find()
                ->where(['roll IS NOT' => NULL])
                ->toArray();

            $std = 0;
            foreach ($individualArrays as $room):
                for ($i = 1; $i <= $room['quantity']; $i++) {
                    $student = TableRegistry::getTableLocator()->get('admissions');
                    $query = $student->query();
                    $query->update()
                        ->set([
                            'room' => $room['name'],
                            'location' => $room['location']
                        ])
                        ->where(['id' => $admissionInfo[$std]['id']])
                        ->execute();
                    $std++;
                }
            endforeach;

            $roomInfos = TableRegistry::getTableLocator()->get('admissions');
            $roomInfo = $roomInfos->find()
                ->where(['roll IS NOT' => NULL])
                ->toArray();

            $result = array();
            foreach ($roomInfo as $roomI) {
                $room = $roomI['room'];
                if (isset($result[$room])) {
                    $result[$room][] = $roomI;
                } else {
                    $result[$room] = array($roomI);
                }
            }
        }

        $this->set('results', $result);
    }

    public function admissionRoom()
    {

        if ($this->request->is('post')) {

            $roomName = $this->request->data['room'];
            //              pr($roomName);die;

            $students = TableRegistry::getTableLocator()->get('admissions');
            $student = $students->find()
                ->where(['roll IS NOT' => NULL])
                ->where(['room' => $roomName])
                ->toArray();
            //            pr($student);die;
            $levels = $lvl = array();
            $total_students = count($student);
            //            pr($total_students);die;
            $out = array();
            foreach ($student as $stu) {
                $levels[] = $stu['level'];
            }
            $levels = array_count_values($levels);
            foreach ($levels as $key => $value) {
                $lvl[] = $key . '(' . $value . ')';
            }
            $level_str = implode(', ', $lvl);
            $this->set(compact('level_str'));

            $this->set('students', $student);
        }

        $lists = TableRegistry::getTableLocator()->get('admissions');
        $list = $lists->find()
            ->where(['room IS NOT' => NULL])
            ->select(['room', 'room'])
            ->group('room')
            ->orderAsc('room')
            ->toArray();

        $this->set('list', $list);
    }

    public function viewSeatplan()
    {

        $roomInfos = TableRegistry::getTableLocator()->get('admissions');
        $roomInfo = $roomInfos->find()
            ->where(['roll IS NOT' => NULL])
            //              ->where(['room' => $roomName])
            ->toArray();
        //        pr($roomInfo);
        //        die;
        $result = array();
        foreach ($roomInfo as $roomIn) {
            $room = $roomIn['room'];
            if (isset($result[$room])) {
                $result[$room][] = $roomIn;
            } else {
                $result[$room] = array($roomIn);
            }
        }
        //          pr($result); die;
        $this->set('results', $result);
    }

    public function tindex()
    {
        $request_data = array();
        $where = [];

        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            // pr($request_data);die;

            if (isset($request_data['name_english']) && $request_data['name_english']) {
                $where['name_english'] = $request_data['name_english'];
            }
            if (isset($request_data['fmobile']) && $request_data['fmobile']) {
                $where['fmobile'] = $request_data['fmobile'];
            }
            if (isset($request_data['serial']) && $request_data['serial']) {
                $where['serial'] = $request_data['serial'];
            }
            // if (isset($request_data['level']) && $request_data['level']) {
            //     $where['level'] = $request_data['level'];
            // }
            // if (isset($request_data['roll']) && $request_data['roll']) {
            //     $where['roll'] = $request_data['roll'];
            // }
            // if (isset($request_data['status']) && $request_data['status']) {
            //     $where['status'] = $request_data['status'];
            // }
        }
        $student = TableRegistry::getTableLocator()->get('temp_students');
        $students = $student->find()
            ->where($where)
            ->enableAutoFields(true)
            ->enableHydration(false);

        $this->set('students', $students);

        $this->set('request_data', $request_data);
        // $this->set('datas', $students);
    }

    public function changeStatus($id = null)
    {


        $student = TableRegistry::getTableLocator()->get('temp_students');
        $students = $student->find()
            ->where(['temp_students.id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        $query = $student->query();
        $query
            ->update()
            ->set([
                'status' => 0
            ])
            ->where(['id' => $id])
            ->execute();

        $this->Flash->info('The Student\'s Form Submit Status has been changed.', [
            'key' => 'positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'tindex']);
    }

    public function tedit($id)
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            // echo '<pre>';
            // print_r($request_data);die;

            $session = TableRegistry::getTableLocator()->get('scms_sessions');
            $sessions = $session
                ->find()
                ->where(['session_id' => $request_data['session_id']])
                ->toArray();

            $level = $request_data['level_id'];

            $year = substr($sessions[0]['session_name'], 2);
            $condition = sprintf("%02s%02s", $year, $level);

            $sids = TableRegistry::getTableLocator()->get('scms_students');
            $sid = $sids
                ->find()
                ->where([
                    'scms_students.sid LIKE' => $condition . '%'
                ])
                ->order(array('sid DESC'))
                ->toArray();
            //            pr($sid);
            //------- student table data ----------

            $student_data['name'] = $request_data['name'];
            $student_data['name_bn'] = $request_data['name_bangla'];
            $student_data['mobile'] = $request_data['mobile'];
            $student_data['email'] = $request_data['email'];
            $student_data['date_of_birth'] = $request_data['date_of_birth'];
            $student_data['birth_registration'] = $request_data['national_id'];
            $student_data['permanent_address'] = $request_data['permanent_address'];
            $student_data['present_address'] = $request_data['present_address'];
            $student_data['gender'] = $request_data['gender'];
            $student_data['religion'] = $request_data['religion'];
            $student_data['blood_group'] = $request_data['blood_group'];
            $student_data['marital_status'] = $request_data['marital_status'];
            $student_data['nationality'] = $request_data['nationality'];
            $student_data['thumbnail'] = $request_data['thumbnail'];
            $student_data['regular_size'] = $request_data['regular_size'];
            $student_data['religion_subject'] = $request_data['religion_subject'];
            $student_data['gsa_id'] = $request_data['gsa_id'];

            $student_data['level_id'] = $request_data['level_id'];
            $student_data['session_id'] = $request_data['session_id'];
            $student_data['status'] = $request_data['status'];
            $student_data['active_guardian'] = $request_data['active_guardian'];
            $student_data['sid'] = $this->get_sid($student_data);

            $temp_student = TableRegistry::getTableLocator()->get('temp_students');
            $query = $temp_student->query();
            $query
                ->update()
                ->set([
                    'sid' => $student_data['sid'],
                    'status' => 1
                ])
                ->where(['id' => $id])
                ->execute();

            foreach ($student_data as $key => $data) {
                if ($data == '-- Choose --') {
                    $student_data[$key] = null;
                }
            }
            // echo '<pre>';
            // print_r($student_data);
            // die;
            $student_columns = array_keys($student_data);
            $student = TableRegistry::getTableLocator()->get('scms_students');
            $query = $student->query();
            $query->insert($student_columns)
                ->values($student_data)
                ->execute();
            $student_record = $student->find()->last(); //get the last employee id
            $request_data['student_id'] = $student_record->student_id;




            $student_cycle = TableRegistry::getTableLocator()->get('scms_students');
            $student_cycles_record = $student_cycle->find()->last(); //get the last student_cycle_id
            $student_id = $student_cycles_record->student_id;
            //            pr($student_id);die;



            $student_cycle_data['student_id'] = $request_data['student_id'];
            $student_cycle_data['level_id'] = $student_data['level_id'];
            $student_cycle_data['group_id'] = $request_data['group_id'];
            $student_cycle_data['shift_id'] = $request_data['shift_id'];
            $student_cycle_data['section_id'] = $request_data['section_id'];
            $student_cycle_data['session_id'] = $student_data['session_id'];
            $student_cycle_data['roll'] = $request_data['roll'];
            // $student_cycle_data['resedential'] = $request_data['resedential'];
            //            pr($student_cycle_data);die;

            $student_cycles = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $query = $student_cycles->query();
            $query->insert(['student_id', 'level_id', 'group_id', 'shift_id', 'section_id', 'session_id', 'roll', 'resedential'])
                ->values($student_cycle_data)
                ->execute();

            $student_cycles_record = $student_cycles->find()->last(); //get the last student_cycle_id
            $student_cycle_id = $student_cycles_record->student_cycle_id;

            foreach ($request_data['g_relation'] as $key => $relation) {
                $guardian_data[$key]['relation'] = $request_data['g_relation'][$key];
                $guardian_data[$key]['name'] = $request_data['g_name'][$key];
                $guardian_data[$key]['name_bn'] = $request_data['g_name_bn'][$key];
                $guardian_data[$key]['mobile'] = $request_data['g_mobile'][$key];
                $guardian_data[$key]['nid'] = $request_data['g_nid'][$key];
                $guardian_data[$key]['occupation'] = $request_data['g_occupation'][$key];
                $guardian_data[$key]['yearly_income'] = $request_data['g_income'][$key];
                $guardian_data[$key]['nationality'] = $request_data['nationality'][$key];
                $guardian_data[$key]['religion'] = $request_data['g_religion'][$key];
                $guardian_data[$key]['gender'] = $request_data['g_gender'][$key];
                $guardian_data[$key]['student_id'] = $request_data['student_id'];
                $guardian_data[$key]['rtype'] = $request_data['g_relation'][$key];
            }
            //            pr($guardian_data);//die;
            foreach ($guardian_data as $key1 => $guardians) {
                foreach ($guardians as $key2 => $data) {
                    if ($data == '-- Choose --') {
                        $guardian_data[$key1][$key2] = null;
                    }
                }
                $guardian = TableRegistry::getTableLocator()->get('scms_guardians');
                $query = $guardian->query();
                $query->insert(['student_id', 'relation', 'name', 'gender', 'name_bn', 'rtype', 'email', 'mobile', 'nid', 'birth_reg', 'occupation', 'yearly_income', 'nationality', 'religion'])
                    ->values($guardians)
                    ->execute();
            }

            if (isset($request_data['exam_name'])) {
                foreach ($request_data['exam_name'] as $key => $exam) {
                    $education_data['exam_name'] = $request_data['exam_name'][$key];
                    $education_data['exam_board'] = $request_data['exam_board'][$key];
                    $education_data['exam_session'] = $request_data['exam_session'][$key];
                    $education_data['exam_roll'] = $request_data['exam_roll'][$key];
                    $education_data['exam_registration'] = $request_data['exam_registration'][$key];
                    $education_data['institute'] = $request_data['institute'][$key];
                    $education_data['grade'] = $request_data['grade'][$key];
                    $education_data['group_name'] = $request_data['group_name'][$key];
                    $education_data['gpa'] = $request_data['gpa'][$key];
                    $education_data['passing_year'] = $request_data['passing_year'][$key];
                    $education_data['student_id'] = $request_data['student_id'];
                    // pr($education_data);
                    // die;

                    $qualification = TableRegistry::getTableLocator()->get('scms_qualification');
                    $query = $qualification->query();
                    $query
                        ->insert(['student_id', 'exam_name', 'exam_board', 'exam_session', 'exam_roll', 'exam_registration', 'institute', 'grade', 'group_name', 'gpa', 'passing_year'])
                        ->values($education_data)
                        ->execute();
                }
            }

            $student_cycles_record = $student_cycles->find()->last(); //get the last student_cycle_id
            $student_cycle_id = $student_cycles_record->student_cycle_id;

            $optional_id = [];
            //3rd, 4th and religion subject (optional)
            if ($student_data['religion_subject']) {
                // echo '<pre>';
                // print_r($student_data['religion_subject']);
                $optional_id[] = $student_data['religion_subject'];
            }
            $scms_third_and_forth_subject_data = array();
            if (isset($request_data['thrid_subject'])) {
                foreach ($request_data['thrid_subject'] as $thrid_subject) {
                    $optional_id[] = $thrid_subject;
                    $single_third_subject['type'] = 'third';
                    $single_third_subject['student_cycle_id'] = $student_cycle_id;
                    $single_third_subject['course_id'] = $thrid_subject;
                    $scms_third_and_forth_subject_data[] = $single_third_subject;
                }
            }
            if (isset($request_data['forth_subject'])) {
                foreach ($request_data['forth_subject'] as $forth_subject) {
                    $optional_id[] = $forth_subject;
                    $single_forth_subject['type'] = 'forth';
                    $single_forth_subject['student_cycle_id'] = $student_cycle_id;
                    $single_forth_subject['course_id'] = $forth_subject;
                    $scms_third_and_forth_subject_data[] = $single_forth_subject;
                }
            }

            $where['level_id'] = $student_data['level_id'];
            $where['session_id'] = $student_data['session_id'];
            $optional_courses = array();

            if (count($optional_id) > 0) {
                $where['c.course_id in'] = $optional_id;
                $optional_courses = $this->getCoursecycle($where);
            }
            unset($where['c.course_id in']);

            //Compulsory course
            $where['c.course_type_id'] = 1;
            $compulsory_courses = $this->getCoursecycle($where);

            //extra course
            $where['c.course_type_id'] = 2;
            $extra_courses = $this->getCoursecycle($where);

            //Selective course
            $selective_courses = array();
            if ($request_data['group_id']) {
                $where['c.course_type_id'] = 4;
                $where['c.course_group_id'] = $request_data['group_id'];
                $selective_courses = $this->getCoursecycle($where);
            }


            $student_course_cycles = array_merge($optional_courses, $compulsory_courses, $selective_courses, $extra_courses);
            // echo '<pre>';
            // print_r($student_course_cycles);
            // die;
            //scms_student_course_cycle insert start
            $student_course_cycle_data['student_cycle_id'] = $student_cycle_id;
            foreach ($student_course_cycles as $student_course_cycle) {
                $student_course_cycle_data['courses_cycle_id'] = $student_course_cycle['courses_cycle_id'];
                $student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
                $query = $student_course_cycle->query();
                $query->insert(['student_cycle_id', 'courses_cycle_id'])
                    ->values($student_course_cycle_data)
                    ->execute();

                $student_course_cycle_record = $student_course_cycle->find()->last(); //get the last student_course_cycle_id
                $student_course_cycle_ids[] = $student_course_cycle_record->student_course_cycle_id;
            }
            //scms_student_course_cycle insert end
            //------***------
            //scms_student_term_cycle start
            $term_cycle = TableRegistry::getTableLocator()->get('scms_term_cycle');
            $term_cycles = $term_cycle
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['session_id' => $request_data['session_id']])
                ->where(['level_id' => $student_data['level_id']])
                ->toArray();
            foreach ($term_cycles as $term_cycle) {
                $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
                $scms_student_term_cycle_data['student_cycle_id'] = $student_cycle_id;
                $scms_student_term_cycle_data['term_cycle_id'] = $term_cycle['term_cycle_id'];
                $query = $scms_student_term_cycle->query();
                $query
                    ->insert(['student_cycle_id', 'term_cycle_id'])
                    ->values($scms_student_term_cycle_data)
                    ->execute();
                $scms_student_term_cycle_last_data = $scms_student_term_cycle->find()->last(); //get the last id
                $student_term_course_cycle_data['student_term_cycle_id'] = $scms_student_term_cycle_last_data->student_term_cycle_id;

                //scms_student_term_course_cycle start
                foreach ($student_course_cycle_ids as $student_course_cycle_id) {
                    $student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
                    $student_term_course_cycle_data['student_course_cycle_id'] = $student_course_cycle_id;
                    $query = $student_term_course_cycle->query();
                    $query
                        ->insert(['student_term_cycle_id', 'student_course_cycle_id'])
                        ->values($student_term_course_cycle_data)
                        ->execute();
                }

                //scms_student_term_course_cycle end
            }
            //scms_student_term_cycle end
            //save third and forth subject
            if (count($scms_third_and_forth_subject_data)) {
                $scms_third_and_forth_subject = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
                $columns = array_keys($scms_third_and_forth_subject_data[0]);
                $insertQuery = $scms_third_and_forth_subject->query();
                $insertQuery->insert($columns);
                // you must always alter the values clause AFTER insert
                $insertQuery->clause('values')->values($scms_third_and_forth_subject_data);
                $insertQuery->execute();
            }
            $sms_mobile = $request_data['g_mobile'][0];
            $student_data['fmobile'] = $request_data['g_mobile'][0];
            $student_data['gsa_id'] = $request_data['gsa_id'];


            if (isset($student_data)) {

                $type = 'admission';
                $numbers = $sms_mobile;
                $smsCnt = $this->send_sms($type, $numbers, $student_data);
            }
            //die;
            $this->Flash->info('Student Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);

            return $this->redirect(['action' => 'tindex']);
        }

        $basic = TableRegistry::getTableLocator()->get('temp_students'); //Execute First
        $basics = $basic
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['id' => $id])
            ->toArray();
        $new_sess = $basics[0]['session'];

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['session_name' => $new_sess])
            ->toArray();
        // echo '<pre>';print_r($sessions);die;
        $this->set('sessions', $sessions);


        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $courses = $course
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['course_type_id' => 5])
            ->toArray();
        // echo '<pre>';
        // print_r($basics);
        // die;

        $this->set('courses', $courses);

        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['level_name' => $basics[0]['level']])
            ->toArray();

        $this->set('levels', $levels);

        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
        $this->set('student', $basics[0]);
        $section = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $section
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['level_id' => $levels[0]['level_id']])
            ->toArray();
        // echo '<pre>';
        // print_r($sections);
        // die;
        $this->set('sections', $sections);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['group_id' => $basics[0]['admission_group']])
            ->toArray();
        // echo '<pre>';
        // print_r($basics[0]);
        // die;
        $this->set('groups', $groups);
    }

    public function view($id)
    {
        //        echo $id;die;
        $student = TableRegistry::getTableLocator()->get('temp_students'); //Execute First
        //        echo '<pre>';
        //        print_r($student);die;
        $students = $student
            ->find()
            ->where(['temp_students.id' => $id])
            //          ->where(['level' => $data['level_id']])
            //          ->order(['student_id' => 'DESC'])
            ->toArray();
        //        echo '<pre>';
        //        print_r($students);
        //        die;
    }

    public function seatplan()
    {
        $this->layout = 'admin';
    }

    public function import($fileName = null)
    {

        if (!empty($this->request->data)) {


            $file = $this->request->data['file']['name'];
            $tmpName = $this->request->data['file']['tmp_name'];
            $ext = substr(strrchr($file, "."), 1);
            //            pr($ext);die;
            if ($ext == "csv") {
                $fileName = md5(rand() * time()) . ".$ext";
                $UPLOAD = WWW_ROOT . '/uploads/csv/'; // Specify original folder path
                $result = move_uploaded_file($tmpName, $UPLOAD . $fileName);
                //                pr($result);die;
            } else {
                //$this->Session->setFlash(__('Wrong File. Only "csv"  file extensions are allowed.', true), 'default', ['class' => 'notice']);
                $this->redirect(['action' => 'import', null]);
            }
        }

        if ($fileName) {

            $MAX_POSSIBLE_CSV_ROWS = 1200;
            $STATUS_FILE_NAME = $UPLOAD . DS . 'import-status-report.txt';
            $filePath = $UPLOAD . DS . $fileName;
            $han = fopen($filePath, "r");
            $header = fgetcsv($han);

            if ($header[0] == 'SL' && $header[1] == 'User ID') {
                //                echo '122';die;

                if (($handle = fopen($filePath, "r")) !== false) {
                    //loop through the csv file and insert into database
                    for ($i = 0; ($data = fgetcsv($handle, 1200, ",")) !== false; $i++) {

                        if ($i == 0)
                            continue;
                        else if ($i > $MAX_POSSIBLE_CSV_ROWS)
                            break;

                        if ($data[0] > $MAX_POSSIBLE_CSV_ROWS) {
                            echo PHP_EOL . PHP_EOL . "====LAST ENTRY :: (SUCCESS)====" . PHP_EOL . PHP_EOL;
                            break;
                        } else {
                            $data[1] = empty($data[1]) ? '' : addslashes(trim($data[1])); //Roll,
                            $data[2] = empty($data[2]) ? '' : addslashes(trim(str_replace(chr(160), " ", $data[2]))); //NAME,
                            $data[3] = empty($data[3]) ? '' : addslashes(trim($data[3])); //birth reg,
                            $data[4] = empty($data[4]) ? '' : addslashes(trim($data[4])); //level,
                            $data[5] = empty($data[5]) ? '' : addslashes(trim($data[5])); //Shift,
                            $data[6] = empty($data[6]) ? '' : addslashes(trim($data[6])); //quota,

                            $data[3] = str_replace('*', '', $data[3]);
                            $data['id'] = $data[0];
                            $data['roll'] = $data[1]; //Roll,
                            $data['name'] = $data[2]; //NAME,
                            $data['birth_reg'] = $data[3]; //birth reg,
                            $data['level'] = $data[4]; //level,
                            $data['shift'] = $data[5]; //Shift,
                            $data['quota'] = $data[6];
                            unset($data[0]);
                            unset($data[1]);
                            unset($data[2]);
                            unset($data[3]);
                            unset($data[4]);
                            unset($data[5]);
                            unset($data[6]);
                            $sameDatas = TableRegistry::getTableLocator()->get('temp_students'); //Execute First
                            $sameData = $sameDatas
                                ->find()
                                ->where(['roll' => $data['roll']])
                                ->toArray();

                            $msg = '';
                            if (empty($sameData)) {
                                //                                pr($data);die;
                                $student = TableRegistry::getTableLocator()->get('temp_students');
                                $query = $student->query();
                                $query->insert(['roll', 'name', 'birth_reg', 'level', 'shift', 'quota'])
                                    ->values($data)
                                    ->execute();

                                if (!$query)
                                    die('Invalid query: ' . $mysqli->error);
                                //$stdId = $mysqli->insert_id;
                            }
                        }
                    } //die;

                    if ($i > 0 && $data == false)
                        echo PHP_EOL . PHP_EOL . "<br>====THE END :: (SUCCESS)====" . PHP_EOL . PHP_EOL;
                    fclose($handle);
                }
                //                $mysqli->close();
                echo 'DONE !!!';
                exit();
            } else {
                $this->Session->setFlash(__('Wrong File, Please Check the header of the file', true), 'default', ['class' => 'notice']);
                $this->redirect(['action' => 'import', null]);
            }

            unlink($filePath);
        }
    }

    public function tutionFees()
    { //@shovon
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if (isset($request_data['session_id'])) {
                $where['scms_student_cycle.session_id'] = $request_data['session_id'];
                if ($request_data['shift_id']) {
                    $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
                }
                if ($request_data['level_id']) {
                    $where['scms_student_cycle.level_id'] = $request_data['level_id'];
                }
                if ($request_data['section_id']) {
                    $where['scms_student_cycle.section_id'] = $request_data['section_id'];
                }

                $student = TableRegistry::getTableLocator()->get('scms_student_cycle');
                $students = $student->find()
                    ->where($where)
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->select([
                        'name' => "s.name",
                        'sid' => "s.sid",
                    ])
                    ->join([
                        's' => [
                            'table' => 'scms_students',
                            'type' => 'INNER',
                            'conditions' => [
                                's.student_id = scms_student_cycle.student_id'
                            ]
                        ],
                        'shift' => [
                            'table' => 'hr_shift',
                            'type' => 'INNER',
                            'conditions' => [
                                'shift.shift_id = scms_student_cycle.shift_id'
                            ]
                        ],
                        'level' => [
                            'table' => 'scms_levels',
                            'type' => 'INNER',
                            'conditions' => [
                                'level.level_id = scms_student_cycle.level_id'
                            ]
                        ],
                        'section' => [
                            'table' => 'scms_sections',
                            'type' => 'INNER',
                            'conditions' => [
                                'section.section_id = scms_student_cycle.section_id'
                            ]
                        ],
                        'session' => [
                            'table' => 'scms_sessions',
                            'type' => 'INNER',
                            'conditions' => [
                                'session.session_id  = scms_student_cycle.session_id'
                            ]
                        ],
                    ])->toArray();
                $this->set('students', $students);
            } else {

                $tution_fees = $request_data['tution_fees'];
                $student = TableRegistry::getTableLocator()->get('scms_student_cycle');
                foreach ($tution_fees as $key => $tution_fee) {
                    $value['tuition_fee_status'] = $tution_fee;
                    $query = $student->query();
                    $query
                        ->update()
                        ->set($value)
                        ->where(['student_cycle_id' => $key])
                        ->execute();
                }
                $this->Flash->info('Student\'s Scholarship Added Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'tutionFees']);
            }
            $head = $this->set_head($request_data);
            //            pr($head);die;
            $this->set('head', $head);
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->orderDesc('session_name')
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('groups', $groups);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
    }

    public function dataSettings()
    {

        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $array = [];
            foreach ($request_data['return'] as $key => $data) {
                $single_array['scms_students_data_settings_group_id'] = $key;

                foreach ($data as $key2 => $value) {
                    $single_array['scms_students_data_settings_id'] = $key2;
                    $single_array['exist'] = isset($value['exist']) ? 1 : null;
                    $single_array['required'] = isset($value['required']) ? 1 : null;
                    $array[] = $single_array;
                }
            }
            $scms_students_data_settings_value = TableRegistry::getTableLocator()->get('scms_students_data_settings_value');
            $values = $scms_students_data_settings_value
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['scms_students_data_settings_group_id NOT IN' => [2]])
                ->toArray();
            $delete_ids = [];
            foreach ($values as $val) {
                $delete_ids[] = $val['id'];
            }
            if (count($delete_ids)) {
                $query = $scms_students_data_settings_value->query();
                $query->delete()
                    ->where(['id IN' => $delete_ids])
                    ->execute();
            }
            if (count($array)) {
                $columns = array_keys($array[0]);
                $insertQuery = $scms_students_data_settings_value->query();
                $insertQuery->insert($columns);
                $insertQuery->clause('values')->values($array);
                $insertQuery->execute();
            }
            $this->Flash->success('Data Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'dataSettings']);
        }

        $data = TableRegistry::getTableLocator()->get('scms_students_data_settings');
        $datas = $data
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        //        pr($datas);die;
        foreach ($datas as $data) {
            if ($data['type_id'] == 4) {
                $data['readonly'] = 'readonly';
            }
            $filter_data[$data['type_id']][$data['id']] = $data;
        }

        $data_count = TableRegistry::getTableLocator()->get('scms_students_data_settings_group');
        $data_counts = $data_count
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        //pr($data_counts);//die;

        $filter_data_count = [];
        foreach ($data_counts as $data_count) {

            $filter_data_count[$data_count['id']]['field'] = $filter_data[$data_count['type_id']];
            $filter_data_count[$data_count['id']]['heading'] = $data_count['heading'];
        }
        //        pr($filter_data_count);die;
        $value = TableRegistry::getTableLocator()->get('scms_students_data_settings_value');
        $values = $value
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        foreach ($values as $value) {

            if ($value['exist']) {
                $filter_data_count[$value['scms_students_data_settings_group_id']]['field'][$value['scms_students_data_settings_id']]['exist'] = 'Checked';
            }
            if ($value['required']) {
                $filter_data_count[$value['scms_students_data_settings_group_id']]['field'][$value['scms_students_data_settings_id']]['required'] = 'required';
            }
        }
        //        pr($filter_data_count);
        //        die;

        $this->set('data_counts', $filter_data_count);
    }

    public function dataCount()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $data['type_id'] = $request_data['type_id'];
            $data['heading'] = $request_data['heading'];

            $data_counts = TableRegistry::getTableLocator()->get('scms_students_data_settings_group');
            $query = $data_counts->query();
            $query
                ->insert(['type_id', 'heading'])
                ->values($data)
                ->execute();

            //Set Flash
            $this->Flash->success('Data Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'datas']);
        }
        $type = TableRegistry::getTableLocator()->get('scms_students_data_settings_type');
        $types = $type
            ->find()
            ->where(['id NOT IN' => [3, 4]])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('types', $types);
    }

    public function datas()
    {
        $data = TableRegistry::getTableLocator()->get('scms_students_data_settings_group');
        $datas = $data->find()
            ->where(['scms_students_data_settings_group.id NOT IN' => [1, 2]])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'name' => "t.type_name",
            ])
            ->join([
                't' => [
                    'table' => 'scms_students_data_settings_type',
                    'type' => 'INNER',
                    'conditions' => [
                        't.id = scms_students_data_settings_group.type_id'
                    ]
                ],
            ]);
        $paginate = $this->paginate($datas, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();

        $this->set('datas', $paginate);
    }

    public function editCount($id)
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $data['id'] = $request_data['id'];
            $data['type_id'] = $request_data['type_id'];
            $data['heading'] = $request_data['heading'];
            $data_counts = TableRegistry::getTableLocator()->get('scms_students_data_settings_group');
            $query = $data_counts->query();
            $query
                ->update()
                ->set($data)
                ->where(['id' => $id])
                ->execute();

            //Set Flash
            $this->Flash->info('Data Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'datas']);
        }

        $request_data = TableRegistry::getTableLocator()->get('scms_students_data_settings_group'); //Execute First
        $get_datas = $request_data
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['scms_students_data_settings_group.id' => $id])
            ->select([
                'name' => "t.type_name",
            ])
            ->join([
                't' => [
                    'table' => 'scms_students_data_settings_type',
                    'type' => 'INNER',
                    'conditions' => [
                        't.id = scms_students_data_settings_group.type_id'
                    ]
                ],
            ])
            ->toArray();
        $this->set('get_datas', $get_datas);
    }

    public function numberFordo()
    {


        if (!empty($this->request->data)) {
            $this->layout = 'report';
            $request_data = $this->request->getData();
            //            pr($request_data);die;



            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $students = $scms_student_cycle->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'sid' => 's.sid',
                    'name' => 's.name',
                    'class' => 'level.level_name',
                    'shift' => 'shift.shift_name',
                    'section' => 'section.section_name',
                    'term_name' => 'term.term_name',
                ])
                ->where(['scms_student_cycle.session_id' => $request_data['session_id']])
                ->where(['scms_student_cycle.shift_id' => $request_data['shift_id']])
                ->where(['scms_student_cycle.level_id' => $request_data['level_id']])
                ->where(['scms_student_cycle.section_id' => $request_data['section_id']])
                ->join([
                    's' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            's.student_id  = scms_student_cycle.student_id'
                        ]
                    ],
                    'sc' => [
                        'table' => 'scms_attendance',
                        'type' => 'INNER',
                        'conditions' => [
                            'sc.student_cycle_id  = scms_student_cycle.student_cycle_id'
                        ]
                    ],
                    'term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'term_cycle.term_cycle_id  = sc.term_cycle_id'
                        ]
                    ],
                    'term' => [
                        'table' => 'scms_term',
                        'type' => 'INNER',
                        'conditions' => [
                            'term.term_id  = term_cycle.term_id'
                        ]
                    ],
                    'level' => [
                        'table' => 'scms_levels',
                        'type' => 'INNER',
                        'conditions' => [
                            'level.level_id  = scms_student_cycle.level_id'
                        ]
                    ],
                    'shift' => [
                        'table' => 'hr_shift',
                        'type' => 'INNER',
                        'conditions' => [
                            'shift.shift_id  = scms_student_cycle.shift_id'
                        ]
                    ],
                    'section' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'section.section_id  = scms_student_cycle.section_id'
                        ]
                    ],
                ])
                ->group(['s.sid', 'scms_student_cycle.roll', 'level.level_name', 'shift.shift_name', 'section.section_name', 'term.term_name'])
                ->toArray();
            //            $vals = array_count_values($attendances);
            //            pr($students);
            //            die;
            $this->set('students', $students);
            $this->render('/reports/number_fordo');
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('groups', $groups);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
    }

    public function paymentList()
    {


        $payment = TableRegistry::getTableLocator()->get('payments');
        $payments = $payment->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();

        $this->set('payments', $payments);
    }

    public function addPayment()
    {
        if (!empty($this->request->data)) {
            // echo '<pre>';
            // print_r($this->request->data);
            // die;
            if (!empty($this->request->data)) {
                $pay['ref_proxy'] = $this->request->data['ref_proxy'];
                $pay['trxId'] = $this->request->data['trxId'];
                $pay['sender'] = $this->request->data['sender'];
                $pay['receiver'] = '01705806080';
                $pay['amount'] = '200';
                $pay['status'] = 'Paid';
                $pay['pay_media'] = 'bKash';
                // pr($pay);die;


                $payment = TableRegistry::getTableLocator()->get('payments');
                $payments = $payment->query();
                $payments
                    ->insert(['trxId', 'ref_proxy', 'amount', 'sender', 'receiver', 'pay_media', 'status'])
                    ->values($pay)
                    ->execute();

                $this->Flash->success('Payment Added Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'paymentList']);
            } else {
                $this->Flash->error('Check Reference Number', [
                    'key' => 'negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'paymentList']);
            }
        }
    }

    public function addeditPayment($id = null)
    {
        $this->layout = 'admin';
        $this->set('title_for_layout', __('Payments'));

        if (!empty($this->request->data)) {
            if (!empty($this->request->data)) {
                $pay['ref_proxy'] = $this->request->data['ref_proxy'];
                $pay['trxId'] = $this->request->data['trxId'];
                $pay['sender'] = $this->request->data['sender'];
                $pay['receiver'] = $this->request->data['receiver'];
                $pay['amount'] = $this->request->data['amount'];
                //                pr($pay);die;

                $payment = TableRegistry::getTableLocator()->get('payments');
                $payments = $payment->query();

                $payments->update()
                    ->set([
                        'ref_proxy' => $pay['ref_proxy'],
                        'trxId' => $pay['trxId'],
                        'sender' => $pay['sender'],
                        'receiver' => $pay['receiver'],
                        'amount' => $pay['amount']
                    ])
                    ->where(['id' => $id])
                    ->execute();
                $this->Flash->success('Payment Added Successfully', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'paymentList']);
            } else {
                $this->Flash->error('Check Reference Number', [
                    'key' => 'negative',
                    'params' => [],
                ]);
                return $this->redirect(['action' => 'paymentList']);
            }
        }
        $payment = TableRegistry::getTableLocator()->get('payments'); //Execute First
        $payments = $payment
            ->find()
            ->where(['id' => $id])
            ->toArray();

        $this->set('payments', $payments[0]);
    }


    public function upload($fileName = null)
    {

        if (!empty($this->request->data)) {


            $file = $this->request->data['file']['name'];
            $tmpName = $this->request->data['file']['tmp_name'];
            $ext = substr(strrchr($file, "."), 1);
            if ($ext == "csv") {
                $fileName = md5(rand() * time()) . ".$ext";
                $UPLOAD = WWW_ROOT . '/uploads/'; // Specify original folder path
                $result = move_uploaded_file($tmpName, $UPLOAD . $fileName);
            } else {
                //$this->Session->setFlash(__('Wrong File. Only "csv"  file extensions are allowed.', true), 'default', ['class' => 'notice']);
                $this->redirect(['action' => 'upload', null]);
            }
        }

        if ($fileName) {
            // pr($fileName);die;
            //            $MAX_POSSIBLE_CSV_ROWS = 1200;
            $STATUS_FILE_NAME = $UPLOAD . DS . 'import-status-report.txt';
            $filePath = $UPLOAD . DS . $fileName;
            $han = fopen($filePath, "r");
            $header = fgetcsv($han);


            if ($header[0] == 'Name' && $header[2] == 'Sid') {

                if (($handle = fopen($filePath, "r")) !== false) {
                    //loop through the csv file and insert into database
                    while (($data = fgetcsv($handle, 12000, ",")) !== false) {

                        if ($data[0] == 'Name' && $data[2] == 'Sid') {
                            continue;
                        }
                        $data[0] = empty($data[0]) ? '' : addslashes(trim(str_replace(chr(160), " ", $data[0]))); //Name,
                        $data[1] = empty($data[1]) ? '' : addslashes(trim($data[1])); //Class,
                        $data[2] = empty($data[2]) ? '' : addslashes(trim($data[2])); //sid,
                        $data[3] = empty($data[3]) ? '' : addslashes(trim($data[3])); //mobile,
                        $data[4] = empty($data[4]) ? '' : addslashes(trim($data[4])); //session,
                        $data[5] = empty($data[5]) ? '' : addslashes(trim($data[5])); //roll,
                        $data[6] = empty($data[6]) ? '' : addslashes(trim($data[6])); //section,
                        $data[7] = empty($data[7]) ? '' : addslashes(trim($data[7])); //religion,
                        $data[8] = empty($data[8]) ? '' : addslashes(trim($data[8])); //dob,
                        $data[9] = empty($data[9]) ? '' : addslashes(trim($data[9])); //nationality,
                        $data[10] = empty($data[10]) ? '' : addslashes(trim($data[10])); //blood_group,
                        $data[11] = empty($data[11]) ? '' : addslashes(trim($data[11])); //active_guardian,
                        $data[12] = empty($data[12]) ? '' : addslashes(trim($data[12])); //present address,
                        $data[13] = empty($data[13]) ? '' : addslashes(trim($data[13])); //permanent address,
                        $data[14] = empty($data[14]) ? '' : addslashes(trim($data[14])); //birth_reg,
                        $data[15] = empty($data[15]) ? '' : addslashes(trim($data[15])); //religion subject,
                        $data[16] = empty($data[16]) ? '' : addslashes(trim($data[16])); //shift,
                        $data[17] = empty($data[17]) ? '' : addslashes(trim($data[17])); //group,

                        $data[18] = empty($data[18]) ? '' : addslashes(trim(str_replace(chr(160), " ", $data[18]))); //F_name,
                        $data[19] = empty($data[19]) ? '' : addslashes(trim($data[19])); //F_mobile,
                        $data[20] = empty($data[20]) ? '' : addslashes(trim($data[20])); //F_occupation,
                        $data[21] = empty($data[21]) ? '' : addslashes(trim($data[21])); //F_income,
                        $data[22] = empty($data[22]) ? '' : addslashes(trim($data[22])); //F_religion,
                        $data[23] = empty($data[23]) ? '' : addslashes(trim($data[23])); //F_nid,

                        $data[24] = empty($data[24]) ? '' : addslashes(trim(str_replace(chr(160), " ", $data[24]))); //M_name,
                        $data[25] = empty($data[25]) ? '' : addslashes(trim($data[25])); //M_mobile,
                        $data[26] = empty($data[26]) ? '' : addslashes(trim($data[26])); //M_occupation,
                        $data[27] = empty($data[27]) ? '' : addslashes(trim($data[27])); //M_income,
                        $data[28] = empty($data[28]) ? '' : addslashes(trim($data[28])); //M_religion,
                        $data[29] = empty($data[29]) ? '' : addslashes(trim($data[29])); //M_nid,


                        $data[30] = empty($data[30]) ? '' : addslashes(trim($data[30])); //3rd,
                        $data[31] = empty($data[31]) ? '' : addslashes(trim($data[31])); //4th,

                        $data[32] = empty($data[32]) ? '' : addslashes(trim($data[32])); //gender
                        $data[33] = empty($data[33]) ? '' : addslashes(trim($data[33])); //enrolled_date,



                        $formattedDate = $data[8];
                        $enrolled_date = $data[33];

                        $level = TableRegistry::getTableLocator()->get('scms_levels');
                        $levels = $level
                            ->find()
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->where(['level_name' => $data[1]])
                            ->toArray();
                        $level_id = $levels[0]['level_id'];

                        $session = TableRegistry::getTableLocator()->get('scms_sessions');
                        $sessions = $session
                            ->find()
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->where(['session_name' => $data[4]])
                            ->toArray();
                        $session_id = $sessions[0]['session_id'];


                        $shift = TableRegistry::getTableLocator()->get('hr_shift');
                        $shifts = $shift
                            ->find()
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->where(['shift_name' => $data[16]])
                            ->toArray();
                        $shift_id = $shifts[0]['shift_id'];

                        $section = TableRegistry::getTableLocator()->get('scms_sections');
                        $sections = $section
                            ->find()
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->where(['section_name' => $data[6]])
                            ->where(['level_id' => $level_id])
                            ->toArray();
                        $section_id = $sections[0]['section_id'];

                        $group = TableRegistry::getTableLocator()->get('scms_groups');
                        $groups = $group
                            ->find()
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->where(['group_name' => $data[17]])
                            ->toArray();

                        $group_id = $groups[0]['group_id'];


                        $msg = '';
                        $connection = ConnectionManager::get('default'); //need to adjust the connection name
                        // ------insert Student Data------
                        /* if (!empty($data[0])) {


                            $data1 = [
                                'name' => $data[0],
                                'sid' => $data[2],
                                'mobile' => $data[3],
                                'session_id' => $session_id,
                                'level_id' => $level_id,
                                'religion' => $data[7],
                                'nationality' => $data[9],
                                'blood_group' => $data[10],
                                'date_of_birth' => $formattedDate,
                                'birth_registration' => $data[14],
                                'religion_subject' => $data[15],
                                'active_guardian' => $data[11],
                                'present_address' => $data[12],
                                'permanent_address' => $data[13],
                                'gender' => $data[32]
                            ];

                            $sql = "INSERT INTO scms_students (name, sid, mobile, session_id, level_id, religion, nationality, blood_group, date_of_birth, birth_registration, religion_subject, active_guardian, present_address, permanent_address, gender) VALUES (:name, :sid, :mobile, :session_id, :level_id, :religion, :nationality, :blood_group, :date_of_birth, :birth_registration, :religion_subject, :active_guardian, :present_address, :permanent_address, :gender)";

                            $params = ['name' => $data1['name'], 'sid' => $data1['sid'], 'mobile' => $data1['mobile'], 'session_id' => $data1['session_id'], 'level_id' => $data1['level_id'], 'religion' => $data1['religion'], 'nationality' => $data1['nationality'], 'blood_group' => $data1['blood_group'], 'date_of_birth' => $data1['date_of_birth'], 'birth_registration' => $data1['birth_registration'], 'religion_subject' => $data1['religion_subject'], 'active_guardian' => $data1['active_guardian'], 'present_address' => $data1['present_address'], 'permanent_address' => $data1['permanent_address'], 'gender' => $data1['gender']];

                            $statement = $connection->execute($sql, $params);
                        }*/

                        if (!empty($data[0])) {


                            $data1 = [
                                'name' => $data[0],
                                'sid' => $data[2],
                                'mobile' => $data[3],
                                'session_id' => $session_id,
                                'level_id' => $level_id,
                                'religion' => $data[7],
                                'nationality' => $data[9],
                                'blood_group' => $data[10],
                                'date_of_birth' => $formattedDate,
                                'date_of_admission' => $enrolled_date,
                                'birth_registration' => $data[14],
                                'religion_subject' => $data[15],
                                'active_guardian' => $data[11],
                                'present_address' => $data[12],
                                'permanent_address' => $data[13],
                                'gender' => $data[32]
                            ];

                            $sql = "INSERT INTO scms_students (name, sid, mobile, session_id, level_id, religion, nationality, blood_group, date_of_birth, date_of_admission, birth_registration, religion_subject, active_guardian, present_address, permanent_address, gender) VALUES (:name, :sid, :mobile, :session_id, :level_id, :religion, :nationality, :blood_group, :date_of_birth, :date_of_admission, :birth_registration, :religion_subject, :active_guardian, :present_address, :permanent_address, :gender)";

                            $params = ['name' => $data1['name'], 'sid' => $data1['sid'], 'mobile' => $data1['mobile'], 'session_id' => $data1['session_id'], 'level_id' => $data1['level_id'], 'religion' => $data1['religion'], 'nationality' => $data1['nationality'], 'blood_group' => $data1['blood_group'], 'date_of_birth' => $data1['date_of_birth'], 'date_of_admission' => $data1['date_of_admission'], 'birth_registration' => $data1['birth_registration'], 'religion_subject' => $data1['religion_subject'], 'active_guardian' => $data1['active_guardian'], 'present_address' => $data1['present_address'], 'permanent_address' => $data1['permanent_address'], 'gender' => $data1['gender']];

                            $statement = $connection->execute($sql, $params);
                        }

                        // ------insert Student_cycle Data------
                        if (!empty($data[4])) {

                            $student_cycles = TableRegistry::getTableLocator()->get('scms_students');
                            $student_cycles_record = $student_cycles->find()->last(); //get the last student_id
                            $student_cycle_id = $student_cycles_record->student_id;

                            $data2 = [
                                'student_id' => $student_cycle_id,
                                'session_id' => $session_id,
                                'level_id' => $level_id,
                                'roll' => $data[5],
                                'shift_id' =>
                                $shift_id,
                                'group_id' => $group_id,
                                'section_id' => $section_id
                            ];

                            $sql = "INSERT INTO scms_student_cycle (student_id, session_id, level_id, roll, shift_id, group_id, section_id) VALUES (:student_id, :session_id, :level_id, :roll, :shift_id, :group_id, :section_id)";

                            $params = ['student_id' => $student_cycle_id, 'session_id' => $session_id, 'level_id' => $level_id, 'roll' => $data2['roll'], 'shift_id' => $data2['shift_id'], 'group_id' => $group_id, 'section_id' => $section_id];


                            $statement = $connection->execute($sql, $params);
                        }
                        // ------insert Father Data------
                        if (!empty($data[18])) {


                            $data3 = [
                                'name' => $data[18],
                                'student_id' => $student_cycle_id,
                                'rtype' => 'Father',
                                'relation' => 'Father',
                                'gender' => 'Male',
                                'nid' => $data[23],
                                'mobile' => $data[19],
                                'occupation' => $data[20],
                                'yearly_income' => $data[21],
                                'religion' => $data[22]
                            ];

                            $sql = "INSERT INTO scms_guardians (name, student_id, rtype, relation, gender, nid, mobile, occupation, yearly_income, religion) VALUES (:name, :student_id, :rtype, :relation, :gender, :nid, :mobile, :occupation, :yearly_income, :religion)";

                            $params = ['name' => $data3['name'], 'student_id' => $data3['student_id'], 'rtype' => $data3['rtype'], 'relation' => $data3['relation'], 'gender' => $data3['gender'], 'nid' => $data3['nid'], 'mobile' => $data3['mobile'], 'occupation' => $data3['occupation'], 'yearly_income' => $data3['yearly_income'], 'religion' => $data3['religion']];

                            $statement = $connection->execute($sql, $params);
                        }
                        // ------insert Mother Data------
                        if (!empty($data[24])) {



                            $data4 = [
                                'name' => $data[24],
                                'student_id' => $student_cycle_id,
                                'rtype' => 'Mother',
                                'relation' => 'Mother',
                                'gender' => 'Female',
                                'nid' => $data[29],
                                'mobile' => $data[25],
                                'occupation' => $data[26],
                                'yearly_income' => $data[27],
                                'religion' => $data[28]
                            ];

                            $sql = "INSERT INTO scms_guardians (name, student_id, rtype, relation, gender, nid, mobile, occupation, yearly_income, religion) VALUES (:name, :student_id, :rtype, :relation, :gender, :nid, :mobile, :occupation, :yearly_income, :religion)";
                            $params = ['name' => $data4['name'], 'student_id' => $data4['student_id'], 'rtype' => $data4['rtype'], 'relation' => $data4['relation'], 'gender' => $data4['gender'], 'nid' => $data4['nid'], 'mobile' => $data4['mobile'], 'occupation' => $data4['occupation'], 'yearly_income' => $data4['yearly_income'], 'religion' => $data4['religion']];

                            $statement = $connection->execute($sql, $params);
                        }
                        $where = [];
                        $where['level_id'] = $level_id;
                        $where['session_id'] = $session_id;
                        $optional_courses = array();

                        $optional_id = [];
                        //3rd, 4th and religion subject (optional)
                        if ($data[15]) {
                            $optional_id[] = $data[15];
                        }
                        if (count($optional_id) > 0) {
                            $where['c.course_id in'] = $optional_id;
                            $optional_courses = $this->getCoursecycle($where);
                        }
                        unset($where['c.course_id in']);

                        $scms_third_and_forth_subject_data = array();
                        if (in_array($level_id, array(9, 10))) {
                            if (isset($data[30])) {
                                $array1 = [$data[30]];
                                foreach ($array1 as $thrid_subject) {
                                    $optional_id[] = $thrid_subject;
                                    $single_third_subject['type'] = 'third';
                                    $single_third_subject['student_cycle_id'] = $student_cycle_id;
                                    $single_third_subject['course_id'] = $thrid_subject;
                                    $scms_third_and_forth_subject_data[] = $single_third_subject;
                                }
                            }
                            if (isset($data[31])) {
                                $array2 = [$data[31]];
                                foreach ($array2 as $forth_subject) {
                                    $optional_id[] = $forth_subject;
                                    $single_forth_subject['type'] = 'forth';
                                    $single_forth_subject['student_cycle_id'] = $student_cycle_id;
                                    $single_forth_subject['course_id'] = $forth_subject;
                                    $scms_third_and_forth_subject_data[] = $single_forth_subject;
                                }
                            }
                        }



                        //Compulsory course
                        $compulsory_courses = array();
                        $where['c.course_type_id'] = 1;
                        $compulsory_courses = $this->getCoursecycle($where);

                        //extra course
                        $extra_courses = array();
                        $where['c.course_type_id'] = 2;
                        $extra_courses = $this->getCoursecycle($where);



                        //Selective course
                        $selective_courses = array();
                        if (isset($group_id)) {
                            $where['c.course_type_id'] = 4;
                            $where['c.course_group_id'] = $group_id;
                            $selective_courses = $this->getCoursecycle($where);
                        }


                        $student_course_cycles = array_merge($compulsory_courses, $optional_courses, $selective_courses);

                        //------ Insert Course Data in scms_student_course_cycle ------

                        $student_cycles = TableRegistry::getTableLocator()->get('scms_student_cycle');
                        $student_cycles_record = $student_cycles->find()->last(); // Get last student_cycle_id
                        $student_cycle_id_main = $student_cycles_record->student_cycle_id;

                        $student_course_cycle_ids = []; // Reset array before inserting new courses

                        foreach ($student_course_cycles as $student_course_cycle) {
                            $student_course_cycle_data = [
                                'student_cycle_id' => $student_cycle_id_main,
                                'courses_cycle_id' => $student_course_cycle['courses_cycle_id']
                            ];

                            $student_course_cycle_table = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
                            $query = $student_course_cycle_table->query();
                            $query->insert(['student_cycle_id', 'courses_cycle_id'])
                                ->values($student_course_cycle_data)
                                ->execute();

                            // Get last inserted ID safely
                            $student_course_cycle_record = $student_course_cycle_table->find()->order(['student_course_cycle_id' => 'DESC'])->first();
                            $student_course_cycle_ids[] = $student_course_cycle_record->student_course_cycle_id;
                        }

                        //------ Insert scms_student_term_cycle Data ------

                        $term_cycle_table = TableRegistry::getTableLocator()->get('scms_term_cycle');
                        $term_cycles = $term_cycle_table
                            ->find()
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->where(['session_id' => $session_id])
                            ->where(['level_id' => $level_id])
                            ->toArray();

                        foreach ($term_cycles as $term_cycle) {
                            $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');

                            $scms_student_term_cycle_data = [
                                'student_cycle_id' => $student_cycle_id_main,
                                'term_cycle_id' => $term_cycle['term_cycle_id']
                            ];

                            $query = $scms_student_term_cycle->query();
                            $query->insert(['student_cycle_id', 'term_cycle_id'])
                                ->values($scms_student_term_cycle_data)
                                ->execute();

                            // Get last inserted student_term_cycle_id safely
                            $student_term_cycle_last_data = $scms_student_term_cycle->find()->order(['student_term_cycle_id' => 'DESC'])->first();
                            $student_term_cycle_id = $student_term_cycle_last_data->student_term_cycle_id;

                            // Insert into scms_student_term_course_cycle
                            if (!empty($student_course_cycle_ids)) {
                                $student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');

                                foreach ($student_course_cycle_ids as $student_course_cycle_id) {
                                    $student_term_course_cycle_data = [
                                        'student_term_cycle_id' => $student_term_cycle_id,
                                        'student_course_cycle_id' => $student_course_cycle_id
                                    ];

                                    $query = $student_term_course_cycle->query();
                                    $query->insert(['student_term_cycle_id', 'student_course_cycle_id'])
                                        ->values($student_term_course_cycle_data)
                                        ->execute();
                                }
                            }
                        }


                        //save third and forth subject
                        if (count($scms_third_and_forth_subject_data)) {
                            $scms_third_and_forth_subject = TableRegistry::getTableLocator()->get('scms_third_and_forth_subject');
                            $columns = array_keys($scms_third_and_forth_subject_data[0]);
                            $insertQuery = $scms_third_and_forth_subject->query();
                            $insertQuery->insert($columns);
                            // you must always alter the values clause AFTER insert
                            $insertQuery->clause('values')->values($scms_third_and_forth_subject_data);
                            $insertQuery->execute();
                        }
                    }

                    if ($data == false)
                        echo PHP_EOL . PHP_EOL . "<br>====THE END :: (SUCCESS)====" . PHP_EOL . PHP_EOL;
                    fclose($handle);
                }
                //                $mysqli->close();
                echo 'DONE !!!';
                exit();
            } else {
                $this->Flash->info('Wrong File, Please Check the header of the file', [
                    'key' => 'positive',
                    'params' => [],
                ]);
                $this->redirect(array('action' => 'upload'));
            }

            unlink($filePath);
        }
    }

    /* public function export()
    {

        $request_data = $this->request->getData();


        if (!empty($request_data)) {
            // pr($request_data);die;


            $where['scms_student_cycle.session_id'] = $request_data['session_id'];
            if ($request_data['level_id']) {
                $where['scms_student_cycle.level_id'] = $request_data['level_id'];
            }
            if ($request_data['shift_id']) {
                $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
            }
            if ($request_data['section_id']) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if ($request_data['status']) {
                $where['sc.status'] = $request_data['status'];
            }


            $data = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $students = $data->find()
                //   ->enableAutoFields(true)
                //   ->enableHydration(false)
                ->select([
                    'name' => 'sc.name',
                    'sid' => 'sc.sid',
                    'class' => 'level.level_name',
                    'section' => 'section.section_name',
                    'father' => 'father.name',
                    'mother' => 'mother.name',
                    'permanent_address' => 'sc.permanent_address',
                    'present_address' => 'sc.present_address',
                    'date_of_birth' => 'sc.date_of_birth',
                    'roll' => 'scms_student_cycle.roll'
                ])
                ->where($where)
                ->order(['scms_student_cycle.level_id' => 'ASC', 'scms_student_cycle.section_id' => 'ASC', 'scms_student_cycle.roll' => 'ASC'])
                ->join([
                    'sc' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            'sc.student_id  = scms_student_cycle.student_id'
                        ]
                    ],
                    'father' => [
                        'table' => 'scms_guardians',
                        'type' => 'INNER',
                        'conditions' => [
                            'father.student_id = scms_student_cycle.student_id',
                            'father.rtype' => 'Father',
                        ]
                    ],
                    'mother' => [
                        'table' => 'scms_guardians',
                        'type' => 'INNER',
                        'conditions' => [
                            'mother.student_id = scms_student_cycle.student_id',
                            'mother.rtype' => 'Mother',
                        ]
                    ],
                    'level' => [
                        'table' => 'scms_levels',
                        'type' => 'INNER',
                        'conditions' => [
                            'level.level_id  = scms_student_cycle.level_id'
                        ]
                    ],
                    'shift' => [
                        'table' => 'hr_shift',
                        'type' => 'INNER',
                        'conditions' => [
                            'shift.shift_id  = scms_student_cycle.shift_id'
                        ]
                    ],
                    'section' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'section.section_id  = scms_student_cycle.section_id'
                        ]
                    ],
                    'session' => [
                        'table' => 'scms_sessions',
                        'type' => 'INNER',
                        'conditions' => [
                            'session.session_id  = scms_student_cycle.session_id'
                        ]
                    ],
                ])
                ->toArray();
            // echo "<pre>";
            // print_r($students);die;
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="export.csv"');

            // Open the output stream
            $output = fopen('php://output', 'w');

            // Write CSV header
            fputcsv($output, ['Name', 'Sid', 'Class', 'Section', 'Father', 'Mother', 'Permanent_address', 'Present_address', 'Date_of_birth', 'Roll']);

            // Write each article to the CSV file
            foreach ($students as $student) {
                fputcsv($output, $student->toArray());
            }

            // Close the output stream
            fclose($output);
            $this->autoRender = false;

            // Create a new Spreadsheet object
            // $spreadsheet = new Spreadsheet();

            // // Set column headers
            // $spreadsheet->setActiveSheetIndex(0)
            //     ->setCellValue('A1', 'Name')
            //     ->setCellValue('B1', 'Sid')
            //     ->setCellValue('C1', 'Class')
            //     ->setCellValue('D1', 'Father')
            //     ->setCellValue('E1', 'Mother')
            //     ->setCellValue('F1', 'Permanent_address')
            //     ->setCellValue('G1', 'Present_address')
            //     ->setCellValue('H1', 'Date_of_birth');

            // // Set data
            // $row = 2;
            // foreach ($students as $item) {

            //     $spreadsheet->setActiveSheetIndex(0)
            //         ->setCellValue('A' . $row, $item->name)
            //         ->setCellValue('B' . $row, $item->sid)
            //         ->setCellValue('C' . $row, $item->class)
            //         ->setCellValue('D' . $row, $item->father)
            //         ->setCellValue('E' . $row, $item->mother)
            //         ->setCellValue('F' . $row, $item->permanent_address)
            //         ->setCellValue('G' . $row, $item->present_address)
            //         ->setCellValue('H' . $row, $item->date_of_birth);

            //     $row++;
            // }

            // // Redirect output to a clientâ€™s web browser (Excel2007)
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // header('Content-Disposition: attachment;filename="exported_data.xlsx"');
            // header('Cache-Control: max-age=0');

            // $writer = new Xlsx($spreadsheet);
            // $writer->save('php://output');

            // // Make sure nothing else is sent
            // exit();
        }
    } */


    public function export()
    {

        $request_data = $this->request->getData();


        if (!empty($request_data)) {
            // pr($request_data);die;


            $where['scms_student_cycle.session_id'] = $request_data['session_id'];
            if ($request_data['level_id']) {
                $where['scms_student_cycle.level_id'] = $request_data['level_id'];
            }
            if ($request_data['shift_id']) {
                $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
            }
            if ($request_data['section_id']) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if ($request_data['status']) {
                $where['sc.status'] = $request_data['status'];
            }


            $data = TableRegistry::getTableLocator()->get('scms_student_cycle');
            $students = $data->find()
                //   ->enableAutoFields(true)
                //   ->enableHydration(false)
                ->select([
                    'name' => 'sc.name',
                    'sid' => 'sc.sid',
                    'class' => 'level.level_name',
                    'section' => 'section.section_name',
                    'father' => 'father.name',
                    'mother' => 'mother.name',
                    'blood_group' => 'sc.blood_group',
                    'contact_no' => 'scms_guardians.mobile',
                    // 'permanent_address' => 'sc.permanent_address',
                    // 'present_address' => 'sc.present_address',
                    'date_of_birth' => 'sc.date_of_birth',
                    'roll' => 'scms_student_cycle.roll',
                    'status' => 'sc.status',
                ])
                ->where($where)
                ->order(['scms_student_cycle.level_id' => 'ASC', 'scms_student_cycle.section_id' => 'ASC', 'scms_student_cycle.roll' => 'ASC'])
                ->join([
                    'sc' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            'sc.student_id  = scms_student_cycle.student_id',
                        ]
                    ],
                    'scms_guardians' => [
                        'table' => 'scms_guardians',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_guardians.student_id  = sc.student_id',
                            'scms_guardians.rtype  = sc.active_guardian',
                        ]
                    ],
                    'father' => [
                        'table' => 'scms_guardians',
                        'type' => 'INNER',
                        'conditions' => [
                            'father.student_id = scms_student_cycle.student_id',
                            'father.rtype' => 'Father',
                        ]
                    ],
                    'mother' => [
                        'table' => 'scms_guardians',
                        'type' => 'INNER',
                        'conditions' => [
                            'mother.student_id = scms_student_cycle.student_id',
                            'mother.rtype' => 'Mother',
                        ]
                    ],
                    'level' => [
                        'table' => 'scms_levels',
                        'type' => 'INNER',
                        'conditions' => [
                            'level.level_id  = scms_student_cycle.level_id'
                        ]
                    ],
                    'shift' => [
                        'table' => 'hr_shift',
                        'type' => 'INNER',
                        'conditions' => [
                            'shift.shift_id  = scms_student_cycle.shift_id'
                        ]
                    ],
                    'section' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'section.section_id  = scms_student_cycle.section_id'
                        ]
                    ],
                    'session' => [
                        'table' => 'scms_sessions',
                        'type' => 'INNER',
                        'conditions' => [
                            'session.session_id  = scms_student_cycle.session_id'
                        ]
                    ],
                ])
                ->toArray();
            // echo "<pre>";
            // print_r($students);die;
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="export.csv"');

            // Open the output stream
            $output = fopen('php://output', 'w');

            // Write CSV header
            fputcsv($output, ['Name', 'Sid', 'Class', 'Section', 'Father', 'Mother', 'Blood Group', 'Contact No', 'Date_of_birth', 'Roll', 'Status']);

            // Write each article to the CSV file
            foreach ($students as $student) {
                fputcsv($output, $student->toArray());
            }

            // Close the output stream
            fclose($output);
            $this->autoRender = false;

           
        }
    }


    
    
    
    // public function imageDownload()
    // {
    //     if ($this->request->is(['post'])) {
    
    //         $request_data = $this->request->getData();
    //         $this->set('title_for_layout', __('Student Image Download'));
    
    //         /* =======================
    //          * BUILD WHERE CONDITION
    //          * ======================= */
    //         $where = [];
    //         $where['scms_student_cycle.session_id'] = $request_data['session_id'];
    
    //         if (!empty($request_data['shift_id'])) {
    //             $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
    //         }
    //         if (!empty($request_data['level_id'])) {
    //             $where['scms_student_cycle.level_id'] = $request_data['level_id'];
    //         }
    //         if (!empty($request_data['section_id'])) {
    //             $where['scms_student_cycle.section_id'] = $request_data['section_id'];
    //         }
    //         if (!empty($request_data['status'])) {
    //             $where['s.status'] = ($request_data['status'] == -1) ? 0 : 1;
    //         }
    
    //         /* =======================
    //          * FETCH STUDENTS
    //          * ======================= */
    //         $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
    
    //         $students = $scms_student_cycle->find()
    //             ->where($where)
    //             ->enableHydration(false)
    //             ->select([
    //                 'sid'          => 's.sid',
    //                 'roll'         => 'scms_student_cycle.roll',
    //                 'regular_size' => 's.regular_size',
    //                 'level_id'     => 'scms_student_cycle.level_id',
    //                 'section_name' => 'section.section_name'
    //             ])
    //             ->order([
    //                 'scms_student_cycle.level_id'   => 'ASC',
    //                 'scms_student_cycle.section_id' => 'ASC',
    //                 'scms_student_cycle.roll'       => 'ASC'
    //             ])
    //             ->join([
    //                 's' => [
    //                     'table' => 'scms_students',
    //                     'type' => 'INNER',
    //                     'conditions' => ['s.student_id = scms_student_cycle.student_id']
    //                 ],
    //                 'section' => [
    //                     'table' => 'scms_sections',
    //                     'type' => 'INNER',
    //                     'conditions' => ['section.section_id = scms_student_cycle.section_id']
    //                 ],
    //             ])
    //             ->toArray();
    
    //         if (empty($students)) {
    //             $this->Flash->error('No student found', ['key' => 'negative']);
    //             return;
    //         }
    
    //         /* =======================
    //          * PREPARE FILE LIST
    //          * ======================= */
    //         $files = scandir(WWW_ROOT . 'uploads/students/regularSize/');
    //         $filesArray = [];
    
    //         foreach ($students as $st) {
    //             $filesArray[] = [
    //                 'sid'  => $st['sid'],
    //                 'roll' => $st['roll'],
    //                 'file' => (!empty($st['regular_size']) && in_array($st['regular_size'], $files))
    //                     ? $st['regular_size']
    //                     : 'default.jpg'
    //             ];
    //         }
    
    //         /* =======================
    //          * CREATE TEMP FOLDER
    //          * ======================= */
    //         $dirName = $students[0]['level_id'] . '_' . $students[0]['section_name'];
    //         $destDir = WWW_ROOT . 'uploads/students/' . $dirName;
    
    //         if (!file_exists($destDir)) {
    //             mkdir($destDir, 0777, true);
    //         }
    
    //         /* =======================
    //          * IMAGE PROCESSING
    //          * ======================= */
    //         foreach ($filesArray as $data) {
    
    //             $sid  = $data['sid'];
    //             $roll = $data['roll'];
    //             $file = $data['file'];
    
    //             $filePath = ($file === 'default.jpg')
    //                 ? WWW_ROOT . 'uploads/default.jpg'
    //                 : WWW_ROOT . 'uploads/students/regularSize/' . $file;
    
    //             if (!file_exists($filePath)) {
    //                 continue;
    //             }
    
    //             $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    //             $newName = $sid . '(' . $roll . ').' . $ext;
    //             $newFile = $destDir . '/' . $newName;
    
    //             // Load image
    //             switch ($ext) {
    //                 case 'png':
    //                     $src = imagecreatefrompng($filePath);
    //                     break;
    //                 case 'gif':
    //                     $src = imagecreatefromgif($filePath);
    //                     break;
    //                 default:
    //                     $src = imagecreatefromjpeg($filePath);
    //             }
    
    //             if (!$src) {
    //                 continue;
    //             }
    
    //             $newImg = imagecreatetruecolor(200, 235);
    //             $white = imagecolorallocate($newImg, 255, 255, 255);
    //             imagefilledrectangle($newImg, 0, 0, 200, 235, $white);
    
    //             imagecopyresampled(
    //                 $newImg,
    //                 $src,
    //                 0, 0, 0, 0,
    //                 200, 235,
    //                 imagesx($src),
    //                 imagesy($src)
    //             );
    
    //             if ($ext === 'png') {
    //                 imagepng($newImg, $newFile);
    //             } else {
    //                 imagejpeg($newImg, $newFile, 90);
    //             }
    
    //             imagedestroy($newImg);
    //             imagedestroy($src);
    //         }
    
    //         /* =======================
    //          * ZIP CREATION
    //          * ======================= */
    //         $zipName = $dirName . '.zip';
    //         $zipPath = WWW_ROOT . $zipName;
    
    //         $zip = new \ZipArchive;
    //         if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
    
    //             foreach (scandir($destDir) as $file) {
    //                 if ($file !== '.' && $file !== '..') {
    //                     $zip->addFile($destDir . '/' . $file, $file);
    //                 }
    //             }
    //             $zip->close();
    
    //             // cleanup
    //             $folder = new Folder($destDir);
    //             $folder->delete();
    
    //             $this->Flash->success('Image zip file created successfully');
    //             $this->set('downloadLink', $zipName);
    
    //         } else {
    //             $this->Flash->error('Zip creation failed');
    //         }
    
    //         $this->set(compact('students'));
    //     }
    
    //     /* =======================
    //      * LOAD FORM DATA
    //      * ======================= */
    //     $session = TableRegistry::getTableLocator()->get('scms_sessions');
    //     $this->set('sessions', $session->find()->order(['session_name' => 'DESC'])->toArray());
    
    //     $this->set('levels', $this->get_levels());
    
    //     $shift = TableRegistry::getTableLocator()->get('hr_shift');
    //     $this->set('shifts', $shift->find()->enableHydration(false)->toArray());
    // }
    
   /* public function imageDownload()
    {
        if ($this->request->is(['post'])) {
    
            $request_data = $this->request->getData();
            $this->set('title_for_layout', __('Student Image Download'));
    
            $where = [];
            $where['scms_student_cycle.session_id'] = $request_data['session_id'];
    
            if (!empty($request_data['shift_id'])) {
                $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
            }
            if (!empty($request_data['level_id'])) {
                $where['scms_student_cycle.level_id'] = $request_data['level_id'];
            }
            if (!empty($request_data['section_id'])) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if (isset($request_data['status']) && $request_data['status'] !== '') {
                $where['s.status'] = ($request_data['status'] == -1) ? 0 : 1;
            }
    
            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
    
            $students = $scms_student_cycle->find()
                ->where($where)
                ->enableHydration(false)
                ->select([
                    'sid'          => 's.sid',
                    'regular_size' => 's.regular_size',
                    'level_id'     => 'scms_student_cycle.level_id',
                    'section_name' => 'section.section_name'
                ])
                ->join([
                    's' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => ['s.student_id = scms_student_cycle.student_id']
                    ],
                    'section' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => ['section.section_id = scms_student_cycle.section_id']
                    ]
                ])
                ->order([
                    'scms_student_cycle.level_id'   => 'ASC',
                    'scms_student_cycle.section_id' => 'ASC',
                    'scms_student_cycle.roll'       => 'ASC'
                ])
                ->toArray();
    
            if (empty($students)) {
                $this->Flash->error('No student found', ['key' => 'negative']);
                return;
            }
    
            $sourceDir   = WWW_ROOT . 'uploads/students/regularSize/';
            $defaultImg  = WWW_ROOT . 'uploads/default.jpg';
            $sourceFiles = array_diff(scandir($sourceDir), ['.', '..']);
    
            $filesArray = [];
            foreach ($students as $student) {
                if (!empty($student['regular_size']) && in_array($student['regular_size'], $sourceFiles)) {
                    $filesArray[$student['sid']] = $student['regular_size'];
                } else {
                    $filesArray[$student['sid']] = 'default.jpg';
                }
            }
    
            $dirName = $students[0]['level_id'] . '_' . $students[0]['section_name'];
            $destDir = WWW_ROOT . 'uploads/students/' . $dirName;
    
            if (!file_exists($destDir)) {
                mkdir($destDir, 0777, true);
            }
    
            foreach ($filesArray as $sid => $file) {
    
                $sourcePath = ($file === 'default.jpg')
                    ? $defaultImg
                    : $sourceDir . $file;
    
                if (!file_exists($sourcePath)) {
                    continue;
                }
    
                $ext = pathinfo($sourcePath, PATHINFO_EXTENSION);
                $destPath = $destDir . '/' . $sid . '.' . $ext;
    
                copy($sourcePath, $destPath);
            }
    
            $zipName = $dirName . '.zip';
            $zipPath = WWW_ROOT . $zipName;
    
            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
    
                $files = array_diff(scandir($destDir), ['.', '..']);
                foreach ($files as $file) {
                    $zip->addFile($destDir . '/' . $file, $file);
                }
                $zip->close();
    
                // Cleanup
                $folder = new Folder($destDir);
                $folder->delete();
    
                $this->Flash->success('The Image Zip File has been created', ['key' => 'positive']);
                $this->set('downloadLink', $zipName);
    
            } else {
                $this->Flash->error('Failed to create zip file', ['key' => 'negative']);
            }
    
            $this->set(compact('students'));
        }
    
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $this->set('sessions', $session->find()->order(['session_name' => 'DESC'])->toArray());
    
        $this->set('levels', $this->get_levels());
    
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $this->set('shifts', $shift->find()->enableHydration(false)->toArray());
    } */
    
    public function imageDownload()
    {
        if ($this->request->is(['post'])) {
    
            $request_data = $this->request->getData();
            $this->set('title_for_layout', __('Student Image Download'));
    
            $where = [];
            $where['scms_student_cycle.session_id'] = $request_data['session_id'];
    
            if (!empty($request_data['shift_id'])) {
                $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
            }
            if (!empty($request_data['level_id'])) {
                $where['scms_student_cycle.level_id'] = $request_data['level_id'];
            }
            if (!empty($request_data['section_id'])) {
                $where['scms_student_cycle.section_id'] = $request_data['section_id'];
            }
            if (isset($request_data['status']) && $request_data['status'] !== '') {
                $where['s.status'] = ($request_data['status'] == -1) ? 0 : 1;
            }
    
            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_student_cycle');
    
            $students = $scms_student_cycle->find()
                ->where($where)
                ->enableHydration(false)
                ->select([
                    'sid'          => 's.sid',
                    'regular_size' => 's.regular_size',
                    'level_id'     => 'scms_student_cycle.level_id',
                    'section_name' => 'section.section_name'
                ])
                ->join([
                    's' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => ['s.student_id = scms_student_cycle.student_id']
                    ],
                    'section' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => ['section.section_id = scms_student_cycle.section_id']
                    ]
                ])
                ->order([
                    'scms_student_cycle.level_id'   => 'ASC',
                    'scms_student_cycle.section_id' => 'ASC',
                    'scms_student_cycle.roll'       => 'ASC'
                ])
                ->toArray();
    
            if (empty($students)) {
                $this->Flash->error('No student found', ['key' => 'negative']);
                return;
            }
    
            $sourceDir = WWW_ROOT . 'uploads/students/regularSize/';

            // Try to find a default image from common places (no guessing)
            $defaultCandidates = [
                WWW_ROOT . 'uploads/default.jpg',
                WWW_ROOT . 'uploads/demo.jpg',
                WWW_ROOT . 'img/default.jpg',
                WWW_ROOT . 'img/default-boy.jpg',
                WWW_ROOT . 'img/default-girl.jpg',
            ];
            
            $defaultImg = null;
            foreach ($defaultCandidates as $p) {
                if (file_exists($p)) {
                    $defaultImg = $p;
                    break;
                }
            }
            
            if (!$defaultImg) {
                $this->Flash->error('Default image not found. Put default.jpg (or demo.jpg) in webroot/uploads/', ['key' => 'negative']);
                return;
            }
            
            // (Optional) scan sourceDir once
            $sourceFiles = array_diff(scandir($sourceDir), ['.', '..']);
            
            $dirName = $students[0]['level_id'] . '_' . $students[0]['section_name'];
            $destDir = WWW_ROOT . 'uploads/students/' . $dirName;
            
            if (!file_exists($destDir)) {
                mkdir($destDir, 0777, true);
            }
            
            // Prevent SID overwrite (duplicate SID makes only 25 files)
            $used = [];
            
            foreach ($students as $student) {
            
                $sid = !empty($student['sid']) ? trim($student['sid']) : '';
                if ($sid === '') {
                    $sid = 'NO_SID_' . uniqid();
                }
            
                // Make SID unique if duplicate
                if (isset($used[$sid])) {
                    $used[$sid]++;
                    $sidUnique = $sid . '_' . $used[$sid];
                } else {
                    $used[$sid] = 0;
                    $sidUnique = $sid;
                }
            
                $imgName = !empty($student['regular_size']) ? trim($student['regular_size']) : '';
            
                // Choose source path
                if ($imgName !== '' && in_array($imgName, $sourceFiles) && file_exists($sourceDir . $imgName)) {
                    $sourcePath = $sourceDir . $imgName;
                } else {
                    $sourcePath = $defaultImg; // ALWAYS exists now
                }
            
                $ext = pathinfo($sourcePath, PATHINFO_EXTENSION);
                if ($ext === '') {
                    $ext = 'jpg';
                }
            
                $destPath = $destDir . '/' . $sidUnique . '.' . $ext;
            
                copy($sourcePath, $destPath);
            }
            
            // Zip it
            $zipName = $dirName . '.zip';
            $zipPath = WWW_ROOT . $zipName;
            
            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            
                $files = array_diff(scandir($destDir), ['.', '..']);
                foreach ($files as $file) {
                    $zip->addFile($destDir . '/' . $file, $file);
                }
                $zip->close();
            
                // Cleanup
                $folder = new Folder($destDir);
                $folder->delete();
            
                $this->Flash->success('The Image Zip File has been created', ['key' => 'positive']);
                $this->set('downloadLink', $zipName);
            
            } else {
                $this->Flash->error('Failed to create zip file', ['key' => 'negative']);
            }
            
            $this->set(compact('students'));

        }
    
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $this->set('sessions', $session->find()->order(['session_name' => 'DESC'])->toArray());
    
        $this->set('levels', $this->get_levels());
    
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $this->set('shifts', $shift->find()->enableHydration(false)->toArray());
    }


    public function deleteDownload($fileName)
    {
        unlink(WWW_ROOT . $fileName);
        $this->redirect(array('action' => 'imageDownload'));
    }
    
    public function markEntryReport()
    {
        if (!empty($this->request->getData())) {

            $value = [
                'session_id'    => null,
                'shift_id'      => null,
                'term_id'       => null,
            ];
        
            $request_data = $this->request->getData();
            $where = [];
        
            // Filters
            if (!empty($request_data['shift_id'])) {
                $where['scms_student_cycle.shift_id'] = $request_data['shift_id'];
            }
        
            if (!empty($request_data['session_id'])) {
                $where['scms_student_cycle.session_id'] = $request_data['session_id'];
            }
        
            // IMPORTANT: term_id filter (NEW LOGIC)
            if (!empty($request_data['term_id'])) {
                $where['scms_term_cycle.term_id'] = $request_data['term_id'];
            }
        
            $termTable = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
        
            $datas = $termTable->find()
                ->where($where)
                ->enableAutoFields(false)
                ->enableHydration(false)
                ->select([
                    'shift_id'   => 'scms_student_cycle.shift_id',
                    'shift_name' => 'hr_shift.shift_name',
        
                    'level_id'   => 'scms_student_cycle.level_id',
                    'level_name' => 'scms_levels.level_name',
        
                    'section_id'   => 'scms_student_cycle.section_id',
                    'section_name' => 'scms_sections.section_name',
        
                    'course_code' => 'scms_courses.course_code',
                    'course_name' => 'scms_courses.course_name',
        
                    // total students
                    'total_students' => $termTable->find()->func()->count(
                        'DISTINCT scms_student_cycle.student_cycle_id'
                    ),
        
                    // marked students
                    'marked_students' => $termTable->find()->func()->count(
                        'DISTINCT CASE
                            WHEN scms_student_term_course_cycle.student_term_course_cycle_mark IS NOT NULL
                            THEN scms_student_cycle.student_cycle_id
                            ELSE NULL
                        END'
                    ),
                ])
                ->join([
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_student_cycle.student_cycle_id = scms_student_term_cycle.student_cycle_id'
                        ]
                    ],
                    'scms_term_cycle' => [ // 🔥 REQUIRED JOIN
                        'table' => 'scms_term_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_term_cycle.term_cycle_id = scms_student_term_cycle.term_cycle_id'
                        ]
                    ],
                    'hr_shift' => [
                        'table' => 'hr_shift',
                        'type' => 'INNER',
                        'conditions' => [
                            'hr_shift.shift_id = scms_student_cycle.shift_id'
                        ]
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_levels.level_id = scms_student_cycle.level_id'
                        ]
                    ],
                    'scms_sections' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_sections.section_id = scms_student_cycle.section_id'
                        ]
                    ],
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_students.student_id = scms_student_cycle.student_id',
                            'scms_students.status' => 1
                        ]
                    ],
                    'scms_student_term_course_cycle' => [
                        'table' => 'scms_student_term_course_cycle',
                        'type' => 'LEFT',
                        'conditions' => [
                            'scms_student_term_course_cycle.student_term_cycle_id = scms_student_term_cycle.student_term_cycle_id'
                        ]
                    ],
                    'scms_student_course_cycle' => [
                        'table' => 'scms_student_course_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_student_course_cycle.student_course_cycle_id = scms_student_term_course_cycle.student_course_cycle_id'
                        ]
                    ],
                    'scms_courses_cycle' => [
                        'table' => 'scms_courses_cycle',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_courses_cycle.courses_cycle_id = scms_student_course_cycle.courses_cycle_id'
                        ]
                    ],
                    'scms_courses' => [
                        'table' => 'scms_courses',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_courses.course_id = scms_courses_cycle.course_id'
                        ]
                    ],
                ])
                ->group([
                    'scms_student_cycle.shift_id',
                    'scms_student_cycle.level_id',
                    'scms_student_cycle.section_id',
                    'scms_courses.course_id'
                ])
                ->order([
                    'scms_student_cycle.shift_id',
                    'scms_student_cycle.level_id',
                    'scms_student_cycle.section_id',
                    'scms_courses.course_code'
                ])
                ->toArray();
        
            // GROUP + PERCENTAGE
            $groupedDatas = [];
        
            foreach ($datas as $row) {
        
                $total  = (int)$row['total_students'];
                $marked = (int)$row['marked_students'];
                $percentage = $total > 0 ? round(($marked / $total) * 100) : 0;
        
                $levelId   = $row['level_id'];
                $sectionId = $row['section_id'];
        
                $groupedDatas[$levelId]['level_name'] =
                $groupedDatas[$levelId]['level_name'] ?? $row['level_name'];
        
                $groupedDatas[$levelId]['sections'][$sectionId]['section_name'] =
                $groupedDatas[$levelId]['sections'][$sectionId]['section_name'] ?? $row['section_name'];
        
        
                $groupedDatas[$levelId]['sections'][$sectionId]['subjects'][] = [
                    'course_code'     => $row['course_code'],
                    'course_name'     => $row['course_name'],
                    'total_students'  => $total,
                    'marked_students' => $marked,
                    'percentage'      => $percentage,
                ];
            }
        
            $this->set('groupedDatas', $groupedDatas);
            $this->set('value', $request_data);
        
            // Term header
            $termHeader = TableRegistry::getTableLocator()
                ->get('scms_term')
                ->find()
                ->select(['term_name'])
                ->where(['term_id' => $request_data['term_id']])
                ->first();
        
            $this->set('termh', ['term' => $termHeader->term_name]);
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);



        $levels = $this->get_levels();
        $this->set('levels', $levels);
        $section = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $section
            ->find()
            ->toArray();
        $this->set('sections', $sections);
        $group = TableRegistry::getTableLocator()->get('scms_groups');
        $groups = $group
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('groups', $groups);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->where(['shift_id IN' => [1, 2]])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
        $term = TableRegistry::getTableLocator()->get('scms_term');
        $terms = $term
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('terms', $terms);
        $value = $request_data;

        $this->set('data', $value);
    }

    //all cycle code
    // public function refactorCycle()
    // {
    //     if ($this->request->is(['post'])) {
    //         $data = $this->request->getData();
    //         $where['scms_student_cycle.level_id'] = $data['level_id'];
    //         if ($data['shift_id']) {
    //             $where['scms_student_cycle.shift_id'] = $data['shift_id'];
    //         }
    //         $where['scms_student_cycle.session_id'] = $data['session_id'];
    //         if ($data['section_id']) {
    //             $where['scms_student_cycle.section_id'] = $data['section_id'];
    //         }
    //         if ($data['sid']) {
    //             $where['scms_students.sid'] = $data['sid'];
    //         }
    //         $where['scms_student_term_cycle.term_cycle_id'] = $data['term_cycle_id'];

    //         $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
    //         $cycles = $scms_student_term_course_cycle
    //             ->find()
    //             ->select([
    //                 'student_cycle_id' => 'scms_student_cycle.student_cycle_id',
    //             ])
    //             ->where($where)
    //             ->enableAutoFields(true)
    //             ->enableHydration(false)
    //             ->join([
    //                 'scms_student_term_cycle' => [
    //                     'table' => 'scms_student_term_cycle',
    //                     'type' => 'INNER',
    //                     'conditions' => ['scms_student_term_cycle.student_term_cycle_id  = scms_student_term_course_cycle.student_term_cycle_id'],
    //                 ],

    //                 'scms_student_cycle' => [
    //                     'table' => 'scms_student_cycle',
    //                     'type' => 'INNER',
    //                     'conditions' => ['scms_student_cycle.student_cycle_id = scms_student_term_cycle.student_cycle_id'],
    //                 ],
    //                 'scms_students' => [
    //                     'table' => 'scms_students',
    //                     'type' => 'INNER',
    //                     'conditions' => ['scms_students.student_id = scms_student_cycle.student_id'],
    //                 ],
    //             ])
    //             ->toArray();
    //         $student_term_course_cycle_ids = array();
    //         $student_term_cycle_ids = array();
    //         $student_cycle_ids = array();
    //         foreach ($cycles as $cycle) {
    //             $student_term_course_cycle_ids[] = $cycle['student_term_course_cycle_id'];
    //             $student_term_cycle_ids[$cycle['student_cycle_id']] = $cycle['student_term_cycle_id'];
    //             $student_cycle_ids[] = $cycle['student_cycle_id'];
    //         }

    //         $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
    //         $student_course_cycles = $scms_student_course_cycle
    //             ->find()
    //             ->where(['student_cycle_id IN' => $student_cycle_ids])
    //             ->enableAutoFields(true)
    //             ->enableHydration(false)
    //             ->toArray();
    //         $new_cycles = array();
    //         foreach ($student_course_cycles as $student_course_cycle) {
    //             $single['student_course_cycle_id'] = $student_course_cycle['student_course_cycle_id'];
    //             $single['student_term_cycle_id'] = $student_term_cycle_ids[$student_course_cycle['student_cycle_id']];
    //             $new_cycles[] = $single;
    //         }

    //         $scms_term_course_cycle_part_mark = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_mark');
    //         $query = $scms_term_course_cycle_part_mark->query();
    //         $query->delete()
    //             ->where(['student_term_course_cycle_id IN' => $student_term_course_cycle_ids])
    //             ->execute();

    //         $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
    //         $query = $scms_student_term_course_cycle->query();
    //         $query->delete()
    //             ->where(['student_term_course_cycle_id IN' => $student_term_course_cycle_ids])
    //             ->execute();

    //         if (count($new_cycles)) {
    //             $columns = array_keys($new_cycles[0]);
    //             $insertQuery = $scms_student_term_course_cycle->query();
    //             $insertQuery->insert($columns);
    //             $insertQuery->clause('values')->values($new_cycles);
    //             $insertQuery->execute();
    //         }

    //         $this->Flash->success('Cycle  Refactor Successfully', [
    //             'key' => 'positive',
    //             'params' => [],
    //         ]);
    //         return $this->redirect(['action' => 'refactorCycle']);
    //     }

    //     $session = TableRegistry::getTableLocator()->get('scms_sessions');
    //     $sessions = $session
    //         ->find()
    //         ->order(['session_name' => 'DESC'])
    //         ->toArray();
    //     $this->set('sessions', $sessions);

    //     $levels = $this->get_levels();
    //     $this->set('levels', $levels);

    //     $shift = TableRegistry::getTableLocator()->get('hr_shift');
    //     $shifts = $shift
    //         ->find()
    //         ->enableAutoFields(true)
    //         ->enableHydration(false)
    //         ->toArray();
    //     $this->set('shifts', $shifts);
    // }

    public function refactorCycle()
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $where['scms_student_cycle.level_id'] = $data['level_id'];
            if ($data['shift_id']) {
                $where['scms_student_cycle.shift_id'] = $data['shift_id'];
            }
            $where['scms_student_cycle.session_id'] = $data['session_id'];
            if ($data['section_id']) {
                $where['scms_student_cycle.section_id'] = $data['section_id'];
            }
            if ($data['sid']) {
                $where['scms_students.sid'] = $data['sid'];
            }
            $where['scms_student_term_cycle.term_cycle_id'] = $data['term_cycle_id'];

            $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
            $cycles = $scms_student_term_course_cycle
                ->find()
                ->select([
                    'student_cycle_id' => 'scms_student_cycle.student_cycle_id',
                ])
                ->where($where)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->join([
                    'scms_student_term_cycle' => [
                        'table' => 'scms_student_term_cycle',
                        'type' => 'INNER',
                        'conditions' => ['scms_student_term_cycle.student_term_cycle_id  = scms_student_term_course_cycle.student_term_cycle_id'],
                    ],

                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'INNER',
                        'conditions' => ['scms_student_cycle.student_cycle_id = scms_student_term_cycle.student_cycle_id'],
                    ],
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => ['scms_students.student_id = scms_student_cycle.student_id'],
                    ],
                ])
                ->toArray();
            $student_term_course_cycle_ids = array();
            $student_term_cycle_ids = array();
            $student_cycle_ids = array();
            foreach ($cycles as $cycle) {
                $student_term_course_cycle_ids[] = $cycle['student_term_course_cycle_id'];
                $student_term_cycle_ids[$cycle['student_cycle_id']] = $cycle['student_term_cycle_id'];
                $student_cycle_ids[] = $cycle['student_cycle_id'];
            }

            $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
            $student_course_cycles = $scms_student_course_cycle
                ->find()
                ->where(['student_cycle_id IN' => $student_cycle_ids])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

            #added by shovon @17/08/2025
            $where2['scms_term_course_cycle.term_cycle_id'] = $data['term_cycle_id'];
            $scms_term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
            $scms_term_course_cycles = $scms_term_course_cycle
                ->find()
                ->where($where2)
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();

            $term_ids = array_column($scms_term_course_cycles, 'courses_cycle_id');

            $new_cycles = array();
            foreach ($student_course_cycles as $student_course_cycle) {
                if (in_array($student_course_cycle['courses_cycle_id'], $term_ids)) {
                    $single['student_course_cycle_id'] = $student_course_cycle['student_course_cycle_id'];
                    $single['student_term_cycle_id'] = $student_term_cycle_ids[$student_course_cycle['student_cycle_id']];
                    $new_cycles[] = $single;
                }
            }
            #end here

            $scms_term_course_cycle_part_mark = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_mark');
            $query = $scms_term_course_cycle_part_mark->query();
            $query->delete()
                ->where(['student_term_course_cycle_id IN' => $student_term_course_cycle_ids])
                ->execute();

            $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
            $query = $scms_student_term_course_cycle->query();
            $query->delete()
                ->where(['student_term_course_cycle_id IN' => $student_term_course_cycle_ids])
                ->execute();
            // echo '<pre>';
            // print_r($new_cycles);
            // die;
            if (count($new_cycles)) {
                $columns = array_keys($new_cycles[0]);
                $insertQuery = $scms_student_term_course_cycle->query();
                $insertQuery->insert($columns);
                $insertQuery->clause('values')->values($new_cycles);
                $insertQuery->execute();
            }

            $this->Flash->success('Cycle  Refactor Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'refactorCycle']);
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);

        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
    }

    public function viewCycle()
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $this->set('data', $data);
            $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
            $scms_student_term_cycle_data = $scms_student_term_cycle
                ->find()
                ->where(['scms_students.sid' => $data['sid']])
                ->where(['scms_student_cycle.level_id' => $data['level_id']])
                ->where(['scms_student_cycle.session_id' => $data['session_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'term_name' => 'scms_term.term_name',
                    'session_name' => 'scms_sessions.session_name',
                    'sid' => 'scms_students.sid',
                    'name' => 'scms_students.name',
                    'level_name' => 'scms_levels.level_name',
                ])
                ->join([
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'INNER',
                        'conditions' => ['scms_student_cycle.student_cycle_id  = scms_student_term_cycle.student_cycle_id'],
                    ],
                    'scms_students' => [
                        'table' => 'scms_students',
                        'type' => 'INNER',
                        'conditions' => ['scms_students.student_id  = scms_student_cycle.student_id'],
                    ],
                    'scms_levels' => [
                        'table' => 'scms_levels',
                        'type' => 'INNER',
                        'conditions' => ['scms_student_cycle.level_id = scms_levels.level_id'],
                    ],
                    'scms_sessions' => [
                        'table' => 'scms_sessions',
                        'type' => 'INNER',
                        'conditions' => ['scms_student_cycle.session_id = scms_sessions.session_id'],
                    ],
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'INNER',
                        'conditions' => ['scms_student_term_cycle.term_cycle_id = scms_term_cycle.term_cycle_id'],
                    ],
                    'scms_term' => [
                        'table' => 'scms_term',
                        'type' => 'INNER',
                        'conditions' => ['scms_term_cycle.term_id = scms_term.term_id'],
                    ],
                ])
                ->toArray();
            $this->set('terms', $scms_student_term_cycle_data);
        }
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);
    }



    public function individualTermAssign()
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            // echo '<pre>';
            // print_r($data);
            // die;
            $where['scms_student_cycle.level_id'] = $data['level_id'];
            if ($data['shift_id']) {
                $where['scms_student_cycle.shift_id'] = $data['shift_id'];
            }
            $where['scms_student_cycle.session_id'] = $data['session_id'];
            if ($data['section_id']) {
                $where['scms_student_cycle.section_id'] = $data['section_id'];
            }
            if ($data['sid']) {
                $where['scms_students.sid'] = $data['sid'];
            }
            $where['scms_student_term_cycle.term_cycle_id'] = $data['term_cycle_id'];



            $scms_student_cycle = TableRegistry::getTableLocator()->get('scms_students');

            $student_cycle = $scms_student_cycle
                ->find()
                ->select([
                    'student_cycle_id' => 'scms_student_cycle.student_cycle_id',
                    'term_cycle_id' => 'scms_term_cycle.term_cycle_id',
                    'student_id' => 'scms_students.student_id',
                    'sid' => 'scms_students.sid',
                    'name' => 'scms_students.name',
                    'session_id' => 'scms_student_cycle.session_id',
                    'level_id' => 'scms_student_cycle.level_id',
                ])
                ->where([
                    'scms_students.sid' => $data['sid'],
                    'scms_student_cycle.session_id' => $data['session_id'],
                    'scms_term_cycle.session_id' => $data['session_id'],
                ])
                ->enableAutoFields(false)
                ->enableHydration(false)
                ->join([
                    'scms_student_cycle' => [
                        'table' => 'scms_student_cycle',
                        'type' => 'INNER',
                        'conditions' => ['scms_student_cycle.student_id = scms_students.student_id'],
                    ],
                    'scms_term_cycle' => [
                        'table' => 'scms_term_cycle',
                        'type' => 'INNER',
                        'conditions' => ['scms_student_cycle.level_id = scms_term_cycle.level_id'],
                    ],
                ])
                ->toArray();

            $student_cycle_id = $student_cycle[0]['student_cycle_id'];
            $requested_term_cycle_id = $data['term_cycle_id'];

            $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
            $cycles = $scms_student_term_course_cycle
                ->find()
                ->where(['student_cycle_id' => $student_cycle_id])
                ->enableAutoFields(true)
                ->enableHydration(false)

                ->toArray();




            $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');

            // Check if exists
            $exists = $scms_student_term_cycle->exists([
                'student_cycle_id' => $student_cycle_id,
                'term_cycle_id' => $requested_term_cycle_id
            ]);

            if (!$exists) {
                $entity = $scms_student_term_cycle->newEntity([
                    'student_cycle_id' => $student_cycle_id,
                    'term_cycle_id' => $requested_term_cycle_id
                ]);

                if ($scms_student_term_cycle->save($entity)) {
                    $this->Flash->success(__('This Term Cycle ID has been added successfully.'));
                    $response = [
                        'status' => 'success',
                        'message' => 'This Term Cycle ID added successfully',
                        'data' => $entity
                    ];
                } else {
                    $this->Flash->error(__('Unable to add Student Term Cycle. Please try again.'));
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to add Student Term Cycle',
                        'errors' => $entity->getErrors()
                    ];
                }
            } else {
                // Already exists
                $this->Flash->warning(__('This Term Cycle ID is already added for this student.'));
                $response = [
                    'status' => 'warning',
                    'message' => 'This Term Cycle ID already exists for this student'
                ];
            }

            return $this->redirect(['action' => 'individualTermAssign']);
        }

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->order(['session_name' => 'DESC'])
            ->toArray();
        $this->set('sessions', $sessions);

        $levels = $this->get_levels();
        $this->set('levels', $levels);

        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
    }


    public function studentCycleAddCourse($student_term_cycle_id)
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
            $student_term_cycle = $scms_student_term_cycle
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where(['scms_student_term_cycle.student_term_cycle_id' => $student_term_cycle_id])
                ->toArray();

            $single['student_term_cycle_id'] = $student_term_cycle_id;
            foreach ($data['courses_cycle_id'] as $courses_cycle_id) {
                $scms_student_course_cycle = TableRegistry::getTableLocator()->get('scms_student_course_cycle');
                $student_course_cycle = $scms_student_course_cycle
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['scms_student_course_cycle.student_cycle_id' => $student_term_cycle[0]['student_cycle_id']])
                    ->where(['scms_student_course_cycle.courses_cycle_id' => $courses_cycle_id])
                    ->toArray();
                if (count($student_course_cycle)) {
                    $single['student_course_cycle_id'] = $student_course_cycle[0]['student_course_cycle_id'];
                } else {
                    $insert_data['student_cycle_id'] = $student_term_cycle[0]['student_cycle_id'];
                    $insert_data['courses_cycle_id'] = $courses_cycle_id;
                    $query = $scms_student_course_cycle->query();
                    $query->insert(['student_cycle_id', 'courses_cycle_id'])
                        ->values($insert_data)
                        ->execute();
                    $record = $scms_student_course_cycle->find()->last(); //get the last employee id
                    $single['student_course_cycle_id'] = $record->student_course_cycle_id;
                }
                $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
                $query = $scms_student_term_course_cycle->query();
                $query->insert(['student_term_cycle_id', 'student_course_cycle_id'])
                    ->values($single)
                    ->execute();
            }
            $this->Flash->success('Course Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'studentCycleDetails', $student_term_cycle_id]);
        }
        $scms_term_course_cycle = TableRegistry::getTableLocator()->get('scms_term_course_cycle');
        $term_courses = $scms_term_course_cycle
            ->find()
            ->where(['scms_student_term_cycle.student_term_cycle_id' => $student_term_cycle_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'course_name' => 'scms_courses.course_name',
                'course_code' => 'scms_courses.course_code',
                'courses_cycle_id' => 'scms_courses_cycle.courses_cycle_id',
            ])
            ->join([
                'scms_student_term_cycle' => [
                    'table' => 'scms_student_term_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_term_cycle.term_cycle_id  = scms_term_course_cycle.term_cycle_id'],
                ],

                'scms_courses_cycle' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_term_course_cycle.courses_cycle_id  = scms_courses_cycle.courses_cycle_id'],
                ],
                'scms_courses' => [
                    'table' => 'scms_courses',
                    'type' => 'INNER',
                    'conditions' => ['scms_courses_cycle.course_id = scms_courses.course_id'],
                ],
            ])
            ->toArray();
        $term_courses_filter = array();
        foreach ($term_courses as $term_course) {
            $term_courses_filter[$term_course['courses_cycle_id']] = $term_course;
        }

        $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
        $courses = $scms_student_term_course_cycle
            ->find()
            ->where(['scms_student_term_course_cycle.student_term_cycle_id' => $student_term_cycle_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'course_name' => 'scms_courses.course_name',
                'course_code' => 'scms_courses.course_code',
                'courses_cycle_id' => 'scms_courses_cycle.courses_cycle_id',
            ])
            ->join([
                'scms_student_course_cycle' => [
                    'table' => 'scms_student_course_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_course_cycle.student_course_cycle_id  = scms_student_term_course_cycle.student_course_cycle_id'],
                ],

                'scms_courses_cycle' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_course_cycle.courses_cycle_id  = scms_courses_cycle.courses_cycle_id'],
                ],
                'scms_courses' => [
                    'table' => 'scms_courses',
                    'type' => 'INNER',
                    'conditions' => ['scms_courses_cycle.course_id = scms_courses.course_id'],
                ],
            ])
            ->toArray();
        foreach ($courses as $course) {
            unset($term_courses_filter[$course['courses_cycle_id']]);
        }
        $this->set('term_courses_filter', $term_courses_filter);
        $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
        $scms_student_term_cycle_data = $scms_student_term_cycle
            ->find()
            ->where(['scms_student_term_cycle.student_term_cycle_id' => $student_term_cycle_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'term_name' => 'scms_term.term_name',
                'session_name' => 'scms_sessions.session_name',
                'sid' => 'scms_students.sid',
                'name' => 'scms_students.name',
                'level_name' => 'scms_levels.level_name',
            ])
            ->join([
                'scms_student_cycle' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_cycle.student_cycle_id  = scms_student_term_cycle.student_cycle_id'],
                ],
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'INNER',
                    'conditions' => ['scms_students.student_id  = scms_student_cycle.student_id'],
                ],
                'scms_levels' => [
                    'table' => 'scms_levels',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_cycle.level_id = scms_levels.level_id'],
                ],
                'scms_sessions' => [
                    'table' => 'scms_sessions',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_cycle.session_id = scms_sessions.session_id'],
                ],
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_term_cycle.term_cycle_id = scms_term_cycle.term_cycle_id'],
                ],
                'scms_term' => [
                    'table' => 'scms_term',
                    'type' => 'INNER',
                    'conditions' => ['scms_term_cycle.term_id = scms_term.term_id'],
                ],
            ])
            ->toArray();
        $this->set('head', $scms_student_term_cycle_data[0]);
    }

    public function studentCycleDetails($id)
    {
        $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
        $courses = $scms_student_term_course_cycle
            ->find()
            ->where(['scms_student_term_course_cycle.student_term_cycle_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'course_name' => 'scms_courses.course_name',
                'course_code' => 'scms_courses.course_code',
            ])
            ->join([
                'scms_student_course_cycle' => [
                    'table' => 'scms_student_course_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_term_course_cycle.student_course_cycle_id = scms_student_course_cycle.student_course_cycle_id'],
                ],
                'scms_courses_cycle' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_course_cycle.courses_cycle_id  = scms_courses_cycle.courses_cycle_id'],
                ],
                'scms_courses' => [
                    'table' => 'scms_courses',
                    'type' => 'INNER',
                    'conditions' => ['scms_courses_cycle.course_id = scms_courses.course_id'],
                ],
            ])
            ->toArray();

        $this->set('courses', $courses);

        $scms_student_term_cycle = TableRegistry::getTableLocator()->get('scms_student_term_cycle');
        $scms_student_term_cycle_data = $scms_student_term_cycle
            ->find()
            ->where(['scms_student_term_cycle.student_term_cycle_id' => $id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'term_name' => 'scms_term.term_name',
                'session_name' => 'scms_sessions.session_name',
                'sid' => 'scms_students.sid',
                'name' => 'scms_students.name',
                'level_name' => 'scms_levels.level_name',
            ])
            ->join([
                'scms_student_cycle' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_cycle.student_cycle_id  = scms_student_term_cycle.student_cycle_id'],
                ],
                'scms_students' => [
                    'table' => 'scms_students',
                    'type' => 'INNER',
                    'conditions' => ['scms_students.student_id  = scms_student_cycle.student_id'],
                ],
                'scms_levels' => [
                    'table' => 'scms_levels',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_cycle.level_id = scms_levels.level_id'],
                ],
                'scms_sessions' => [
                    'table' => 'scms_sessions',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_cycle.session_id = scms_sessions.session_id'],
                ],
                'scms_term_cycle' => [
                    'table' => 'scms_term_cycle',
                    'type' => 'INNER',
                    'conditions' => ['scms_student_term_cycle.term_cycle_id = scms_term_cycle.term_cycle_id'],
                ],
                'scms_term' => [
                    'table' => 'scms_term',
                    'type' => 'INNER',
                    'conditions' => ['scms_term_cycle.term_id = scms_term.term_id'],
                ],
            ])
            ->toArray();
        $this->set('head', $scms_student_term_cycle_data[0]);
    }
    //delete cycle
    public function deleteStudentTermCourseCycle($id)
    {
        $scms_term_course_cycle_part_mark = TableRegistry::getTableLocator()->get('scms_term_course_cycle_part_mark');
        $query = $scms_term_course_cycle_part_mark->query();
        $query->delete()
            ->where(['student_term_course_cycle_id' => $id])
            ->execute();

        $scms_student_term_course_cycle = TableRegistry::getTableLocator()->get('scms_student_term_course_cycle');
        $query = $scms_student_term_course_cycle->query();
        $query->delete()
            ->where(['student_term_course_cycle_id' => $id])
            ->execute();

        $this->Flash->info('Student Term Course Cycle With Marks Deleted Successfully', [
            'key' => 'positive',
            'params' => [],
        ]);
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        $segments = explode('/', trim(parse_url($referer, PHP_URL_PATH), '/'));
        $lastTwo = array_slice($segments, -2, 2);
        $method = $lastTwo[0] ?? null;
        $id = $lastTwo[1] ?? null;
        $this->redirect(['action' => $method, $id]);
    }
}
