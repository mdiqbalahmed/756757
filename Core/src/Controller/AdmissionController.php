<?php

namespace Croogo\Core\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Http\ResponseEmitter;
use Cake\Http\ServerRequest;
use Croogo\Core\Croogo;
use DateTime;
use Cake\Datasource\ConnectionManager;
use Croogo\Core\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;


class AdmissionController extends AppController
{

    private $pSalt = '+R*e!2$A-';
    protected $pAmount = 200;
    protected $isAdmissionOpen = true;
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {

        if ($this->request->is('post')) {

            $request_data = $this->request->getData();

            if (!empty($request_data['gsa_id']) && empty($request_data['id'])) {

                $gsa_id = $request_data['gsa_id'];

                $studentTable = TableRegistry::getTableLocator()->get('temp_students');
                $students = $studentTable
                    ->find()
                    ->where(['temp_students.gsa_id' => $gsa_id])
                    ->where(['temp_students.status !=' => 1])
                    ->toArray();

                if (!empty($students)) {
                    $this->set('stu', $students[0]);
                } else {
                    $this->Flash->error(__('No student found with GSA ID or the student is already submitted.'));
                }
            } else {

                $request_data = $this->request->getData();

                $file = $_FILES['thumbnail'] ?? null; // use $_FILES, not $request_data

                if ($file && $file['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $arr_ext = ['jpg', 'jpeg', 'png'];
                    $setNewFileName = time() . "_" . rand(100000, 999999);

                    $thumbnailFileName = null;
                    $regularSizeFileName = null;

                    if (in_array($ext, $arr_ext)) {
                        // Move uploaded file to original folder
                        $originalFolderPath = WWW_ROOT . 'uploads/students/large_version/';
                        if (!file_exists($originalFolderPath)) {
                            mkdir($originalFolderPath, 0777, true);
                        }
                        $originalImagePath = $originalFolderPath . $setNewFileName . '.' . $ext;
                        move_uploaded_file($file['tmp_name'], $originalImagePath);

                        // Open original image file
                        $image = null;
                        if ($ext === 'jpg' || $ext === 'jpeg') {
                            $image = imagecreatefromjpeg($originalImagePath);
                        } elseif ($ext === 'png') {
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
                                $regularSizeWidth = 800; // Change this value to adjust regularSize width
                                $regularSizeHeight = 800; // Change this value to adjust regularSize height
                                $regularSizeImage = imagescale($image, $regularSizeWidth, $regularSizeHeight);
                                imagejpeg($regularSizeImage, $regularSizeImagePath, 80);
                                $regularSizeFileName = $setNewFileName . '_rs.' . $ext;
                                imagedestroy($regularSizeImage);
                                $student_data['thumbnail'] = $thumbnailFileName;
                                $student_data['regular_size'] = $regularSizeFileName;
                            }

                        // Delete original
                        unlink($originalImagePath);

                        // $student_data['thumbnail'] = $thumbnailFileName;
                        // $student_data['regular_size'] = $regularSizeFileName;
                    }
                }

                if ($thumbnailFileName == null) {
                    unset($request_data['thumbnail']);
                    unset($request_data['regular_size']);
                }


                $student_data['id'] = $request_data['id'];
                $student_data['name_english'] = $request_data['name_english'];
                $student_data['name_bangla'] = $request_data['name_bangla'];
                $student_data['gsa_id'] = $request_data['gsa_id'];
                $student_data['mobile'] = $request_data['mobile'];
                $student_data['date_of_birth'] = $request_data['dob'];
                $student_data['birth_reg'] = $request_data['birth_reg'];
                $student_data['present_address'] = (isset($request_data['present_house']) ? $request_data['present_house'] : '') . ',' .
                    (isset($request_data['present_village']) ? $request_data['present_village'] : '') . ',' .
                    (isset($request_data['present_mouza']) ? $request_data['present_mouza'] : '') . ',' .
                    (isset($request_data['present_post']) ? $request_data['present_post'] : '') . ',' .
                    (isset($request_data['present_upazila']) ? $request_data['present_upazila'] : '') . ',' .
                    (isset($request_data['present_district']) ? $request_data['present_district'] : '');

                $student_data['permanent_address'] = (isset($request_data['permanent_house']) ? $request_data['permanent_house'] : '') . ',' .
                    (isset($request_data['permanent_village']) ? $request_data['permanent_village'] : '') . ',' .
                    (isset($request_data['permanent_mouza']) ? $request_data['permanent_mouza'] : '') . ',' .
                    (isset($request_data['permanent_post']) ? $request_data['permanent_post'] : '') . ',' .
                    (isset($request_data['permanent_upazila']) ? $request_data['permanent_upazila'] : '') . ',' .
                    (isset($request_data['permanent_district']) ? $request_data['permanent_district'] : '');
                $student_data['gender'] = $request_data['gender'];
                $student_data['religion'] = $request_data['religion'];
                $student_data['blood_group'] = $request_data['blood_group'];
                $student_data['quota'] = $request_data['quota'];
                $student_data['nationality'] = 'Bangladeshi';

                $student_data['bn_fname'] = $request_data['bn_fname'];
                $student_data['fname'] = $request_data['fname'];
                $student_data['fmobile'] = $request_data['fmobile'];
                $student_data['f_nid'] = $request_data['f_nid'];
                $student_data['foccupation'] = $request_data['foccupation'];
                $student_data['foccupation_type'] = $request_data['foccupation_type'];
                $student_data['fincome'] = $request_data['fincome'];

                $student_data['bn_mname'] = $request_data['bn_mname'];
                $student_data['mname'] = $request_data['mname'];
                $student_data['mmobile'] = $request_data['mmobile'];
                $student_data['m_nid'] = $request_data['m_nid'];
                $student_data['moccupation'] = $request_data['moccupation'];
                $student_data['moccupation_type'] = $request_data['moccupation_type'];
                $student_data['mincome'] = $request_data['mincome'];

                $student_data['aname'] = $request_data['aname'];
                $student_data['relation'] = $request_data['relation'];
                $student_data['address'] = (isset($request_data['other_house']) ? $request_data['other_house'] : '') . ',' .
                    (isset($request_data['other_village']) ? $request_data['other_village'] : '') . ',' .
                    (isset($request_data['other_mouza']) ? $request_data['other_mouza'] : '') . ',' .
                    (isset($request_data['other_post']) ? $request_data['other_post'] : '') . ',' .
                    (isset($request_data['other_upazila']) ? $request_data['other_upazila'] : '') . ',' .
                    (isset($request_data['other_district']) ? $request_data['other_district'] : '');


                $student_data['pre_school'] = $request_data['pre_school'];
                $student_data['session'] = $request_data['session'];
                $student_data['status'] = 1;



                $session = intval(substr($student_data['session'], -2));

                $serial = $session . '0' . 3 . $student_data['id'];
                $student_data['serial'] = $serial;

                // echo "<pre>";
                // print_r($student_data);
                // die;


                $students = TableRegistry::getTableLocator()->get('temp_students');
                $query = $students->query();
                $query->update()
                    ->set($student_data)
                    ->where(['id' => $student_data['id']])
                    ->execute();
                $students = TableRegistry::getTableLocator()->get('temp_students');
                $student = $students
                    ->find()
                    ->where(['id' => $student_data['id']])
                    ->toArray();
                $student = $student[0];
                $permAdd = !empty($student['permanent_address']) ? explode(',', $student['permanent_address']) : [];
                $currAdd = !empty($student['present_address']) ? explode(',', $student['present_address']) : [];
                $Add     = !empty($student['address']) ? explode(',', $student['address']) : [];

                $this->set(compact('student', 'permAdd', 'currAdd', 'Add'));
                $this->render('/Admission/view');
            }
        }
        $zila = TableRegistry::getTableLocator()->get('zila');
        $zilas = $zila
            ->find()
            ->toArray();
        $this->set('zilas', $zilas);
        $upazila = TableRegistry::getTableLocator()->get('upazila');
        $upazilas = $upazila
            ->find()
            ->toArray();
        $this->set('upazilas', $upazilas);
        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find('all')
            ->toArray();
        $this->set('levels', $levels);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
    }

    public function tform($id)
    {

        $this->layout = 'admission-form';
        $this->set('title_for_layout', __('Admission Form Submission'));
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $file = $request_data['image_name'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);

            $thumbnailFileName = null;
            $regularSizeFileName = null;

            if (in_array($ext, $arr_ext)) {
                // Move uploaded file to original folder
                $originalFolderPath = WWW_ROOT . '/uploads/students/large_version//'; // Specify original folder path
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

                // Delete original image
                unlink($originalImagePath);
            }
            $request_data['thumbnail'] = $thumbnailFileName;
            $student_data['name'] = $request_data['name'];
            $student_data['bn_name'] = $request_data['bn_name'];
            $student_data['mobile'] = $request_data['mobile'];
            $student_data['dob'] = $request_data['dob'];
            $student_data['birth_reg'] = $request_data['birth_reg'];
            $student_data['permanent_address'] = $request_data['permanent_address'];
            $student_data['current_address'] = $request_data['present_address'];
            $student_data['gender'] = $request_data['gender'];
            $student_data['religion'] = $request_data['religion'];
            $student_data['bn_fname'] = $request_data['bn_fname'];
            $student_data['fname'] = $request_data['fname'];
            $student_data['fmobile'] = $request_data['fmobile'];
            $student_data['f_nid'] = $request_data['f_nid'];
            $student_data['foccupation'] = $request_data['foccupation'];
            $student_data['foccupation_type'] = $request_data['foccupation_type'];
            $student_data['fincome'] = $request_data['fincome'];

            $student_data['bn_mname'] = $request_data['bn_mname'];
            $student_data['mname'] = $request_data['mname'];
            $student_data['mmobile'] = $request_data['mmobile'];
            $student_data['m_nid'] = $request_data['m_nid'];
            $student_data['moccupation'] = $request_data['moccupation'];
            $student_data['moccupation_type'] = $request_data['moccupation_type'];
            $student_data['mincome'] = $request_data['mincome'];

            $student_data['pre_school'] = $request_data['pre_school'];
            $student_data['session'] = $request_data['session'];
            $student_data['shift'] = $request_data['shift'];
            $student_data['level'] = $request_data['level'];
            $student_data['quota'] = $request_data['quota'];
            $student_data['status'] = $request_data['status'];
            $student_data['thumbnail'] = $request_data['thumbnail'];

            $session = intval(substr($student_data['session'], -2));

            if ($id != null) {
                $serial = $session . '0' . '3' . $id;
                $student_data['serial'] = $serial;
            }

            foreach ($student_data as $key => $data) {
                if ($data == '-- Choose --') {
                    $student_data[$key] = null;
                }
            }

            $student = TableRegistry::getTableLocator()->get('temp_students');
            $query = $student->query();
            $query->insert([
                'name',
                'bn_name',
                'mobile',
                'dob',
                'birth_reg',
                'permanent_address',
                'current_address',
                'gender',
                'religion',
                'bn_fname',
                'fname',
                'fmobile',
                'f_nid',
                'foccupation',
                'foccupation_type',
                'fincome',
                'bn_mname',
                'mname',
                'mmobile',
                'm_nid',
                'moccupation',
                'moccupation_type',
                'mincome',
                'thumbnail',
                'serial',
                'shift',
                'level',
                'session'
            ])
                ->values($student_data)
                ->execute();
            $this->set('stu', $student_data);
            $this->render('/Contacts/view');
        }
        $student = TableRegistry::getTableLocator()->get('temp_students');
        $students = $student
            ->find()
            ->where(['id' => $id])
            ->toArray();
        $this->set('stu', $students[0]);
        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
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

            $STATUS_FILE_NAME = $UPLOAD . DS . 'import-status-report.txt';
            $filePath = $UPLOAD . DS . $fileName;
            $han = fopen($filePath, "r");
            $header = fgetcsv($han);


            if ($header[1] == 'User ID' && $header[2] == 'Name') {

                if (($handle = fopen($filePath, "r")) !== false) {
                    //loop through the csv file and insert into database
                    while (($data = fgetcsv($handle, 12000, ",")) !== false) {

                        if ($data[1] == 'User ID' && $data[2] == 'Name') {
                            continue;
                        }
                        $data[0] = empty($data[0]) ? '' : addslashes(trim($data[0]));
                        $data[1] = empty($data[1]) ? '' : addslashes(trim(str_replace(chr(160), " ", $data[1])));
                        $data[2] = empty($data[2]) ? '' : addslashes(trim($data[2]));
                        $data[3] = empty($data[3]) ? '' : addslashes(trim($data[3]));
                        $data[4] = empty($data[4]) ? '' : addslashes(trim($data[4]));
                        $data[5] = empty($data[5]) ? '' : addslashes(trim($data[5]));
                        $data[6] = empty($data[6]) ? '' : addslashes(trim($data[6]));
                        $data[7] = empty($data[7]) ? '' : addslashes(trim($data[7]));
                        $data[8] = empty($data[8]) ? '' : addslashes(trim($data[8]));
                        $data[9] = empty($data[9]) ? '' : addslashes(trim($data[9]));



                        $msg = '';
                        $connection = ConnectionManager::get('default'); //need to adjust the connection name
                        // ------insert Student Data------
                        if (!empty($data[0])) {


                            $data1 = [
                                'gsa_id' => $data[1],
                                'name_english' => $data[2],
                                'birth_reg' => $data[3],
                                'level' => $data[4],
                                'shift' => $data[5],
                                'quota' => $data[6],
                                'fname' => $data[7],
                                'mname' => $data[8],
                                'fmobile' => $data[9],
                            ];

                            $sql = "INSERT INTO temp_students (gsa_id, name_english, birth_reg, level, shift, quota, fname, mname, fmobile) VALUES (:gsa_id, :name_english, :birth_reg, :level, :shift, :quota, :fname, :mname, :fmobile)";

                            $params = ['gsa_id' => $data1['gsa_id'], 'name_english' => $data1['name_english'], 'birth_reg' => $data1['birth_reg'], 'level' => $data1['level'], 'shift' => $data1['shift'], 'quota' => $data1['quota'], 'fname' => $data1['fname'], 'mname' => $data1['mname'], 'fmobile' => $data1['fmobile']];

                            $statement = $connection->execute($sql, $params);
                        }
                    }

                    if ($data == false)
                        echo PHP_EOL . PHP_EOL . "<br>====THE END :: (SUCCESS)====" . PHP_EOL . PHP_EOL;
                    fclose($handle);
                }

                echo 'DONE !!!';
                exit();
            } else {
            }

            unlink($filePath);
        }
    }

    public function admissionform($id = null)
    {
        $this->layout = 'report';
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


                // Delete original image
                unlink($originalImagePath);
            }
            $request_data['thumbnail'] = $thumbnailFileName;

            if (!empty($request_data)) {
                $student_data['name'] = $request_data['name'];
                $student_data['name_bn'] = $request_data['name_bn'];
                $student_data['resident'] = $request_data['resident'];
                $student_data['campus'] = $request_data['campus'];
                $student_data['religion'] = $request_data['religion'];
                $student_data['nationality'] = $request_data['nationality'];
                $student_data['pre_school'] = $request_data['pre_school'];
                $student_data['pre_class'] = $request_data['pre_class'];


                $student_data['level'] = $request_data['level'];
                $student_data['quota'] = $request_data['quota'];
                $student_data['version'] = $request_data['version'];
                $student_data['fname'] = $request_data['fname'];
                $student_data['fname_bn'] = $request_data['fname_bn'];
                $student_data['foccupation'] = $request_data['foccupation'];
                $student_data['fmobile'] = $request_data['fmobile'];

                $student_data['mname'] = $request_data['mname'];
                $student_data['mname_bn'] = $request_data['mname_bn'];
                $student_data['moccupation'] = $request_data['moccupation'];
                $student_data['mmobile'] = $request_data['mmobile'];

                $student_data['shift'] = $request_data['shift'];
                $student_data['session'] = date("Y") + 1;
                $student_data['present_location'] = $request_data['present_location'];
                $student_data['permanent_location'] = $request_data['permanent_location'];
                $student_data['mobile'] = $request_data['mobile'];
                $student_data['dob'] = $request_data['dob'];
                $student_data['photo'] = $request_data['thumbnail'];

                foreach ($student_data as $key => $data) {
                    if ($data == '-- Choose --') {
                        $student_data[$key] = null;
                    }
                }

                $student = TableRegistry::getTableLocator()->get('admissions');
                $query = $student->query();
                $query->insert([
                    'name',
                    'name_bn',
                    'resident',
                    'campus',
                    'religion',
                    'nationality',
                    'pre_school',
                    'pre_class',
                    'level',
                    'quota',
                    'shift',
                    'session',
                    'version',
                    'fname',
                    'fname_bn',
                    'foccupation',
                    'fmobile',
                    'mname',
                    'mname_bn',
                    'moccupation',
                    'mmobile',
                    'present_location',
                    'permanent_location',
                    'photo',
                    'mobile',
                    'dob'
                ])
                    ->values($student_data)
                    ->execute();

                $student_record = $student->find()->last(); //get the last student id
                $newAdmissionId = $student_record->id;
                //                pr($newAdmissionId);die;
                $REF['ref'] = $this->generateRefNum($student_data['session'], $student_data['level'], $newAdmissionId);
                $student = TableRegistry::getTableLocator()->get('admissions');
                $query1 = $student->query();
                $query1->update()
                    ->set($REF)
                    ->where(['id' => $newAdmissionId])
                    ->execute();

                $token = sha1($newAdmissionId . $this->pSalt . $REF['ref']);
                $_SESSION['token'] = $token;
                $_SESSION['data'] = [
                    'id' => $newAdmissionId,
                    'ref' => $REF
                ];
                //                pr($_SESSION);
                //                die;

                $getStudent = $student
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['id' => $newAdmissionId])
                    ->toArray();
                //                pr($getStudent);die;

                $type = "admission";
                $args = $getStudent[0];
                $numbers = $this->request->data['mobile'];
                $smsCnt = $this->send_sms($type, $numbers, $getStudent[0]);
                //                return [
                //                  'type' => $type,
                //                  'numbers' => $numbers
                //                ];
                $this->redirect(array('action' => 'payment', $token));
            } else {
                $this->Flash->error('Failed to verify as not a robot.');
                //                return;
            }
        }
        $level = TableRegistry::getTableLocator()->get('scms_levels');
        $levels = $level
            ->find('all')
            ->toArray();
        $this->set('levels', $levels);
        $shift = TableRegistry::getTableLocator()->get('hr_shift');
        $shifts = $shift
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('shifts', $shifts);
    }

    public function payment($token = null)
    {
        if (!empty($token)) {

            if (($green = $_SESSION) && !empty($green['token']) && !empty($green['data']['id']) && !empty($green['data']['ref']['ref']) && ($token2 = sha1($green['data']['id'] . $this->pSalt . $green['data']['ref']['ref'])) && $token == $token2 && $token == $green['token']
            ) {
                $this->loadModel('admissions');
                $user = $this->admissions->find('all')->where(['id' => $green['data']['id']])->first();
                $this->set('newAdmitter', $user);
            } else {
                $this->Flash->error('Invalid session!');
            }
        }
    }

    public function admitSearch()
    {
        $this->set('title_for_layout', __('Admission Card Form'));

        if ((!empty($this->request->data))) {



            $pStat = $this->request->data['gsa_id'];
            $aStat = $this->request->data['birth_reg'];

            if ($pStat && $aStat) {

                $gsa_id = trim($this->request->data['gsa_id']);
                $birth_reg = trim($this->request->data['birth_reg']);

                $student = TableRegistry::getTableLocator()->get('temp_students');
                $admitter_up = $student
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['gsa_id' => $gsa_id])
                    ->where(['birth_reg' => $birth_reg])
                    
                    ->toArray();
                $student = $admitter_up[0];
                $permAdd = !empty($student['permanent_address']) ? explode(',', $student['permanent_address']) : [];
                $currAdd = !empty($student['present_address']) ? explode(',', $student['present_address']) : [];
                $Add     = !empty($student['address']) ? explode(',', $student['address']) : [];

                $this->set(compact('student', 'permAdd', 'currAdd', 'Add'));
                $this->render('/Admission/view');
                // $this->set('students', $admitter_up[0]);
                // $this->render('/Admission/view');
            }
        }
    }

    public function admitcard($token = null)
    {
        //	$this->layout = 'default';
        $this->layout = 'no_sidebar';

        //	$this->set('noSidebar', true); //To be traced in the front layout;
        $this->set('title_for_layout', __('Admission Card Form'));

        if ((!empty($this->request->data))) {
            //            pr($this->request->data);
            //            die;
            $session = date('Y') + 1; //for december



            $pStat = $this->request->data['trxId'];
            $aStat = $this->request->data['ref'];

            if ($pStat && $aStat) {

                $REF = trim($this->request->data['ref']);
                $trxId = trim($this->request->data['trxId']);

                // print_r($REF);
                // print_r($session);die;

                $student = TableRegistry::getTableLocator()->get('admissions');
                $admitter = $student
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['ref' => $REF])
                    ->where(['session' => $session])
                    ->toArray();
                //  echo "<pre>";
                //  print_r($admitter);die;
                //                pr($admitter); die;
                //return;

                if (empty($admitter)) {
                    // echo '1';die;
                    $validationErrors['pErr'] = 'The reference number doesn\'t exist!!';
                } elseif (!empty($admitter['Payment']['id'])) {
                    // echo '2';die;
                    //Already verified:

                    if ($admitter['Payment']['trxId'] != $trxId) {
                        //But wrong Ref is entered;
                        $validationErrors['pErr'] = 'The reference or the transaction number is not correct!';
                    } elseif ($admitter['status'] != 'Applied') {
                        //All Good, so show the admit card for the whole year:
                        $this->layout = 'scms-admission-print';
                        $this->set('title_for_layout', __('Admit Card'));
                        $this->set('admitter', $admitter['Admission']);
                        return;
                    } else {
                        //we never should be here, though create a msg!
                        $validationErrors['pErr'] = 'System Error!';
                    }
                } else {
                    // echo '3';die;

                    //                    $obj_response = $this->verifyPaymentResponse($trxId, $REF);
                    //
                    //                    $response = (array)$obj_response;
                    //                    $response_arr = (array)$response['transaction'];


                    $response = $this->verifyPaymentResponse($trxId, $REF);
                    //                    $REF = '93040896';
                    //                    pr($response);die;

                    if ($response && !empty($response->transaction)) {
                        //                        pr($response->transaction);die;
                        if ($response->transaction->trxStatus == '0000') {
                            //                            pr($response->transaction);die;
                            if ($response->transaction->reference == $REF) {
                                if (($response->transaction->amount >= $this->pAmount)) {
                                    //                                    echo 'amount';die;
                                    //pr($response); echo $response->transaction->reference.'>>>>>>'.$REF;
                                    //die();
                                    //Save To DB with secure transaction:
                                    //pr($db->isConnected()); die;

                                    $admitter = $student
                                        ->find()
                                        ->enableAutoFields(true)
                                        ->enableHydration(false)
                                        ->where(['ref' => $REF])
                                        ->where(['session' => $session])
                                        ->toArray();
                                    //                        pr($admitter[0]);die;

                                    $rollFeild = 'class_' . $admitter[0]['level'];

                                    $rollRow = TableRegistry::getTableLocator()->get('admission_rolls');
                                    $rollRows = $rollRow
                                        ->find()
                                        ->where([$rollFeild . ' !=' => 1])
                                        ->enableAutoFields(true)
                                        ->enableHydration(false)
                                        ->toArray();

                                    //                        pr($rollRows);
                                    //                        die;

                                    if (empty($rollRows)) {
                                        $validationErrors['pErr'] = 'System Error !!!';
                                        //                            $dataSource->rollback(); //din
                                        //                            $this->set(compact('validationErrors'));
                                        return;
                                    }


                                    //$dataSource->rollback(); din
                                    //return;
                                    //die();
                                    //Don't Save the proxy (if any) for the 2nd time:

                                    if (!empty($response->proxy_id)) {
                                        //                                        echo '4';die;
                                        $pStatus = true;
                                        $newPaymentId = $response->proxy_id;

                                        // pr($newPaymentId);
                                        // die;
                                    } else {
                                        //                                        echo '5';die;
                                        //                                        pr($response);die;
                                        $payment['trxId'] = $response->transaction->trxId;
                                        $payment['ref_proxy'] = $response->transaction->reference;
                                        $payment['amount'] = $response->transaction->amount;
                                        $payment['sender'] = $response->transaction->sender;
                                        $payment['receiver'] = $response->transaction->receiver;
                                        $payment['pay_date'] = date('Y-m-d H:i:s', strtotime($response->transaction->trxTimestamp));
                                        $payment['payment_type_id'] = 1; //Admission|mFee
                                        $payment['pay_media'] = 2; //'Cash'|'bKash'|'Rocket'
                                        $payment['created'] = date('Y-m-d H:i:s');
                                        $payment['status'] = 2; //Paid;
                                        //                                        pr($payment);die;



                                        $pStatus = TableRegistry::getTableLocator()->get('payments');
                                        $payments_query = $pStatus->query();
                                        $payments_query->insert(['trxId', 'ref_proxy', 'amount', 'sender', 'receiver', 'pay_date', 'payment_type_id', 'pay_media', 'created', 'status'])
                                            ->values($payment)
                                            ->execute();
                                        //                                        $newPaymentId = $this->Payment->id;
                                        $newPaymentId = $pStatus->find()->last();
                                        $last_payment_id = $newPaymentId->id;
                                        //                                        pr($last_payment_id);die;
                                    }

                                    /* s pr($admitter);
                                      pr($rollRow);
                                      echo $rollFeild.'>>>>>>>';
                                      $dataSource->rollback();
                                      die(); */
                                    if ($admitter[0]['level'] == 90) {
                                        $levelCode = '000';
                                    } elseif ($admitter[0]['level'] == 91) {
                                        $levelCode = '091';
                                    } elseif ($admitter[0]['level'] == 92) {
                                        $levelCode = '092';
                                    } elseif ($admitter[0]['level'] == 1) {
                                        $levelCode = '001';
                                    } elseif ($admitter[0]['level'] == 2) {
                                        $levelCode = '002';
                                    } elseif ($admitter[0]['level'] == 3) {
                                        $levelCode = '003';
                                    } elseif ($admitter[0]['level'] == 4) {
                                        $levelCode = '004';
                                    } elseif ($admitter[0]['level'] == 5) {
                                        $levelCode = '005';
                                    } elseif ($admitter[0]['level'] == 6) {
                                        $levelCode = '006';
                                    } elseif ($admitter[0]['level'] == 7) {
                                        $levelCode = '007';
                                    } elseif ($admitter[0]['level'] == 8) {
                                        $levelCode = '008';
                                    } elseif ($admitter[0]['level'] == 9) {
                                        $levelCode = '009';
                                    }



                                    //
                                    $rollRow = TableRegistry::getTableLocator()->get('admission_rolls');
                                    $rollRows = $rollRow
                                        ->find()
                                        ->where([$rollFeild . ' !=' => 1])
                                        ->enableAutoFields(true)
                                        ->enableHydration(false)
                                        ->toArray();

                                    $rollFeild = 'class_' . $admitter[0]['level'];
                                    //                                    pr($rollFeild);die;
                                    $updateAdmission = [
                                        'roll' => $levelCode . $rollRows[0]['roll'],
                                        'payment_id' => $last_payment_id,
                                        'status' => 2
                                    ];

                                    //                                    pr($updateAdmission);
                                    //                                    die;

                                    $aStatus = $student->query();
                                    $aStatus
                                        ->update()
                                        ->set($updateAdmission)
                                        ->where(['id' => $admitter[0]['id']])
                                        ->where(['ref' => $admitter[0]['ref']])
                                        ->execute();

                                    $rStatus = $rollRow->query();
                                    $rStatus
                                        ->update()
                                        ->set([$rollFeild => 1])
                                        ->where(['id' => $rollRows[0]['id']])
                                        ->execute();

                                    //                                    pr($admitter);die;
                                    if ($aStatus && $pStatus && $rStatus) {
                                        //All Good:
                                        $admitter_up = $student
                                            ->find()
                                            ->enableAutoFields(true)
                                            ->enableHydration(false)
                                            ->where(['ref' => $REF])
                                            ->where(['session' => $session])
                                            ->toArray();

                                        //                                        pr($admitter_up);die;

                                        $smsCnt = $this->send_sms('admission', ['pmnt-verified'], [
                                            'ref' => $REF,
                                            'trxId' => $trxId,
                                            'roll' => $admitter_up[0]['roll'],
                                            'name' => $admitter_up[0]['name'],
                                            'level' => $admitter_up[0]['level'],
                                            'mobile' => $admitter_up[0]['mobile']
                                        ]);
                                        //                                        pr($smsCnt);die;
                                        $this->set('admitter', $admitter_up);
                                        $this->render('/reports/admission_admit_card');
                                        return;

                                        //return;
                                    } else {
                                        //                            $dataSource->rollback();
                                        $validationErrors['pErr'] = 'Verification Error! Please contact with administrator OR try again.';
                                    }
                                } else {
                                    $validationErrors['pErr'] = 'Invalid amount [Tk. ' . $response->transaction->amount . '] is paid! It should be Tk.' . $this->pAmount . ' exactly.';
                                }
                            } else {
                                $validationErrors['pErr'] = 'Oops! The trxId number doesn\'t match with the reference number! Please try with another trxId or reference number.';
                            }
                        } else {
                            $validationErrors['pErr'] = $this->get_bKash_statusMSG($response->transaction->trxStatus);
                        }
                    } else {
                        $validationErrors['pErr'] = $this->isAdmissionOpen ? 'Network Error !! Please try again.' : 'Sorry! The Admission system is closed. No new payment is acceptable.';
                    }
                }
            } else {
                $this->Flash->error('Admission Form Not Submitted', [
                    'key' => 'negative',
                    'params' => [],
                ]);
                //$validationErrors = Set::merge($this->Admission->validationErrors, $this->Payment->validationErrors);
                //pr($validationErrors);
            }
            $this->set(compact('validationErrors'));
        }
    }

    //    public function admitcard($token = null) {
    ////        $this->layout = 'no_sidebar';
    //
    //        if (!empty($this->request->data)) {
    ////            pr($this->request->data);die;
    //            $session = date('Y');
    //
    //            $REF = trim($this->request->data['ref']);
    //            $trxId = trim($this->request->data['trxId']);
    //
    //            if ($REF && $trxId) {
    ////                echo '1';die;
    ////                pr($REF);
    ////                pr($trxId);die;
    //                $student = TableRegistry::getTableLocator()->get('admissions');
    //                $students = $student
    //                  ->find()
    //                  ->where(['ref' => $REF])
    //                  ->where(['session' => $session])
    //                  ->select([
    //                    'trxId' => 'c.trxId',
    //                    'ref_proxy' => 'c.ref_proxy',
    //                    'amount' => 'c.amount',
    //                    'pay_media' => 'c.pay_media',
    //                  ])
    //                  ->join([
    //                    'c' => [
    //                      'table' => 'payments',
    //                      'type' => 'LEFT',
    //                      'conditions' => ['c.ref_proxy = admissions.ref'],
    //                    ],
    //                  ])
    //                  ->enableAutoFields(true)
    //                  ->enableHydration(false)
    //                  ->toArray();
    //                pr($students);die;
    //                $this->set('admitter', $students);
    //                $this->render('/reports/admission_admit_card');
    //
    //                if (empty($students)) {
    //                    $validationErrors['pErr'] = 'The reference number doesn\'t exist!!';
    //                } elseif (!empty($students[0]['payment_id'])) {
    //                    //Already verified:
    //                    if (($students[0]['level'] >= 3) && ($students[0]['level'] <= 9)) {
    //                        $this->pAmount = 2;
    //                    } else {
    //                        $this->pAmount = 2;
    //                    }
    //
    //                    if ($students[0]['trxId'] != $trxId) {
    //                        $validationErrors['pErr'] = 'The reference or the transaction number is not correct!';
    //                    } elseif ($students[0]['status'] != 'Applied') {
    //                        $this->set('admitter', $students);
    //                        $this->render('/reports/admission_admit_card');
    //                        return;
    //                    } else {
    //                        //we never should be here, though create a msg!
    //                        $validationErrors['pErr'] = 'System Error!';
    //                    }
    //                } else {
    //
    //                    $obj_response = $this->verifyPaymentResponse($trxId, $REF);
    //
    //                    $response = (array)$obj_response;
    //                    $response_arr = (array)$response['transaction'];
    ////                    pr($response1);die;
    //
    //                    if ($response && !empty($response->transaction)) {
    ////                        echo '0';die;
    ////                        pr($response_arr);die;
    //                        if ($response_arr['trxStatus'] == '0000') {
    ////                            echo '1';die;
    //                            if ($response_arr['reference'] == $REF) {
    ////                                echo '2';die;
    //                                if ($response_arr['amount'] >= $this->pAmount) {
    ////                                    echo '3';die;
    //                                    $rollFeild = 'class_' . $students[0]['level'];
    //                                    $rollRow = TableRegistry::getTableLocator()->get('admission_rolls');
    //                                    $rollRows = $rollRow
    //                                      ->find()
    //                                      ->where([$rollFeild => 0])
    //                                      ->enableAutoFields(true)
    //                                      ->enableHydration(false)
    //                                      ->toArray();
    //
    //                                    if (empty($rollRows)) {
    //                                        $validationErrors['pErr'] = 'System Error !!!';
    //                                        $dataSource->rollback(); //din
    //                                        $this->set(compact('validationErrors'));
    //                                        return;
    //                                    }
    //
    //                                    //Don't Save the proxy (if any) for the 2nd time:
    //
    //                                    if (!empty($response_arr['proxy_id'])) {
    ////                                        echo '4';die;
    //                                        $pStatus = true;
    //                                        $newPaymentId = $response_arr['proxy_id'];
    //                                        //                                         pr($newPaymentId); die;
    //                                    } else {
    ////                                        echo '5';die;
    //                                        $payment['trxId'] = $response['name'];
    //                                        $payment['ref_proxy'] = $response['ref_proxy'];
    //                                        $payment['amount'] = $response['amount'];
    //                                        $payment['sender'] = $response['sender'];
    //                                        $payment['receiver'] = $response['receiver'];
    //                                        $payment['pay_date'] = date('Y-m-d H:i:s', strtotime($response_arr['trxTimestamp']));
    //                                        $payment['payment_type_id'] = 1; //Admission|mFee
    //                                        $payment['pay_media'] = 3; //'Cash'|'bKash'|'Rocket'
    //                                        $payment['created'] = date('Y-m-d H:i:s');
    //                                        $payment['status'] = 2; //Paid;
    //
    //
    //
    //                                        $pStatus = TableRegistry::getTableLocator()->get('payments');
    //                                        $query = $pStatus->query();
    //                                        $query->insert(['trxId', 'ref_proxy', 'amount', 'sender', 'receiver', 'pay_date', 'payment_type_id', 'pay_media', 'created', 'status'])
    //                                          ->values($payment)
    //                                          ->execute();
    //                                    }
    //                                    $admission_roll = sprintf("%03s", $students['level']) . $rollRows['roll'];
    //                                    $admission_data['id'] = $students['id'];
    //                                    $admission_data['roll'] = $admission_roll;
    //                                    $admission_data['payment_id'] = $newPaymentId;
    //                                    $admission_data['status'] = 2;
    //
    //                                    $aStatus = TableRegistry::getTableLocator()->get('admissions');
    //                                    $query = $aStatus->query();
    //                                    $query->update()
    //                                      ->set($admission_data)
    //                                      ->where(['id' => $students['id']])
    //                                      ->execute();
    //
    //                                    $rolls['id'] = $rollRows['id'];
    //                                    $rolls['status'] = 1;
    //
    //                                    $rStatus = TableRegistry::getTableLocator()->get('admission_rolls');
    //                                    $query = $rStatus->query();
    //                                    $query->update('admission_rolls')
    //                                      ->set($rolls + [$rollFeild => 1, 'status' => 1])
    //                                      ->where(['id' => $rollRows[0]['id']])
    //                                      ->execute(); //So, the roll status is booked;
    //
    //
    //
    //
    //                                    if ($aStatus && $pStatus && $rStatus) {
    //                                        $students['roll'] = $admission_roll;
    ////                                        $this->set('admitter', $students);
    ////                                        $this->render('/reports/admission_admit_card');
    //                                    } else {
    //                                        $dataSource->rollback();
    //                                        $validationErrors['pErr'] = 'Verification Error! Please contact with administrator OR try again.';
    //                                    }
    //                                } else {
    //                                    $validationErrors['pErr'] = 'Invalid amount [Tk. ' . $response->transaction->amount . '] is paid! It should be Tk.' . $this->pAmount . ' exactly.';
    //                                }
    //                            } else {
    //                                $validationErrors['pErr'] = 'Oops! The trxId number doesn\'t match with the reference number! Please try with another trxId or reference number.';
    //                            }
    //                        } else {
    //                            $validationErrors['pErr'] = $this->get_bKash_statusMSG($response->transaction->trxStatus);
    //                        }
    //                    } else {
    //                        $validationErrors['pErr'] = $this->isAdmissionOpen ? 'Network Error !! Please try again.' : 'Sorry! The Admission system is closed. No new payment is acceptable.';
    //                    }
    //                }
    //            } else {
    //                $validationErrors = Set::merge($this->Admission->validationErrors, $this->Payment->validationErrors);
    //            }
    //        }
    //    }

    private function generateRefNum($session, $level, $id)
    {
        $session = date("Y");
        $schoolCode = '9';
        if (!$level)
            $level = 0;
        $sessionPart = substr($session, 3); //last digit;

        if ($level !== 90 || $level !== 91 || $level !== 92) {
            $level = sprintf("%02s", $level);
        }
        $REF = $schoolCode . $sessionPart . $level . sprintf("%04s", $id); //mt_rand(10501,90905); //????????????????????????????
        return $REF; //$this->is_Ref_Exist_InDb($REF)? $this->generateRefNum($session,$level) : $REF;
    }

    private function verifyPaymentResponse($trxId, $REF)
    {
        //        pr($trxId);
        //        pr($REF);die;
        $response = false;
        $getProxy = TableRegistry::getTableLocator()->get('payments');
        $getProxys = $getProxy
            ->find()
            ->where(['trxId' => $trxId])
            ->where(['ref_proxy' != NULL])
            ->where(['status' != 2])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        //        pr($getProxys);die;

        if ($getProxys) {
            $response = array('transaction' => array(
                'amount' => $getProxys[0]['amount'], //5,
                'counter' => 1,
                'currency' => 'BDT',
                'reference' => $getProxys[0]['ref_proxy'], //$REF,
                'receiver' => $getProxys[0]['receiver'], //'01720556561',
                'sender' => $getProxys[0]['sender'], //'01722856004',
                'service' => 'Payment',
                'trxId' => $trxId,
                'trxStatus' => '0000',
                'trxTimestamp' => date('Y-m-d H:i:s'),
                'proxy_id' => $getProxys[0]['id'] //Just to track proxy :)
            ));
        } else if ($this->isAdmissionOpen) { //Admission is closed !!!
            $response = $this->chk_bKash($trxId, array('qType' => 'trxid', 'ref' => $REF));
            //             pr($response);die;
            $this->scmsDbReconnect();
        }
        //        pr($response);die;
        return $response;
    }

    private function scmsDbReconnect()
    {
        $db = ConnectionManager::get('default');
        $db->connect();
    }


    private function get_serial($data)
    {
        $student = TableRegistry::getTableLocator()->get('temp_students'); //Execute First
        $students = $student
            ->find()
            ->where(['session' => $data['session']])
            ->where(['level' => $data['level']])
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
            ->where(['session_id' => $data['session']])
            ->toArray();
        $session = intval(substr($sessions[0]->session_name, -2));
        if ($data['level'] < 10) {
            $data['level'] = '0' . $data['level'];
        } else {
            if ($data['level'] = 11) {
                $data['level'] = $data['level'];
            } else {
                $data['level'] = $data['level'];
            }
        }
        $sid = $session . $data['level'] . $new_serial;
        return $sid;
    }



    public function getSectionAjax()
    {
        $this->autoRender = false;
        $Level_id = $_GET['level_id'];
        $shift_id = $_GET['shift_id'];
        $section = TableRegistry::getTableLocator()->get('scms_sections');
        $sections = $section
            ->find()
            ->where(['level_id' => $Level_id])
            ->where(['shift_id' => $shift_id])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        echo json_encode($sections);
    }



    public function getSubjectAjax()
    {
        $this->autoRender = false;
        $Level_id = $_GET['level_id'];
        $group_id = $_GET['group_id'];
        $session_id = $_GET['session_id'];
        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $courses_all = $course
            ->find()
            ->where(['cs.session_id' => $session_id])
            ->where(['cs.level_id' => $Level_id])
            ->where(['course_type_id' => 3]) //static
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'level_id' => 'cs.level_id',
            ])
            ->join([
                'cs' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['cs.course_id  = scms_courses.course_id'],
                ],
            ])
            ->toArray();
        $courses = array();
        foreach ($courses_all as $course_all) {
            if ($course_all['course_group_id'] == $group_id || $course_all['course_group_id'] == null) {
                $courses[] = $course_all;
            }
        }
        echo json_encode($courses);
    }



    public function getReligionSubjectAjax()
    {
        $this->autoRender = false;
        $Level_id = $_GET['level_id'];
        $session_id = $_GET['session_id'];
        $course = TableRegistry::getTableLocator()->get('scms_courses');
        $courses_all = $course
            ->find()
            ->where(['cs.session_id' => $session_id])
            ->where(['cs.level_id' => $Level_id])
            ->where(['course_type_id' => 5]) //static
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'level_id' => 'cs.level_id',
            ])
            ->join([
                'cs' => [
                    'table' => 'scms_courses_cycle',
                    'type' => 'LEFT',
                    'conditions' => ['cs.course_id  = scms_courses.course_id'],
                ],
            ])
            ->toArray();
        echo json_encode($courses_all);
    }
}
