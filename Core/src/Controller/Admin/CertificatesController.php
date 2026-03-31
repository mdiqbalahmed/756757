<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class CertificatesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
    }

    public function addCertificates()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            if ($request_data['generate'] != null) {

                $result['student_id'] = $request_data['student_id'];
                $result['config_id'] = $request_data['config_id'];

                unset($request_data['student_id']);
                unset($request_data['config_id']);
                unset($request_data['generate']);

                $result['tag_values'] = json_encode($request_data);
                $get_values = TableRegistry::getTableLocator()->get('scms_certificate_tag_values');
                $query = $get_values->query();
                $query
                    ->insert(['student_id', 'config_id', 'tag_values'])
                    ->values($result)
                    ->execute();
                $view_id = $get_values->find()->last(); //get the last id
                return $this->redirect(['action' => 'printCertificate', $view_id['tag_values_id']]); //return to the "view/$id"
            } else {
                $get_student = TableRegistry::getTableLocator()->get('scms_students');
                $get_students = $get_student
                    ->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where(['student_id' => $request_data['student_id']])
                    ->order('scms_students.student_id ASC')
                    ->select([
                        'student_id' => 'student_id',
                        'level_id' => 'scms_students.level_id',
                        'level_name' => 'L.level_name',
                        'session_id' => 'scms_students.session_id',
                        'session_name' => 's.session_name',
                    ])
                    ->join([
                        'L' => [
                            'table' => 'scms_levels',
                            'type' => 'LEFT',
                            'conditions' => ['L.level_id = scms_students.level_id'],
                        ],
                        's' => [
                            'table' => 'scms_sessions',
                            'type' => 'LEFT',
                            'conditions' => ['s.session_id = scms_students.session_id'],
                        ],
                    ])
                    ->toArray();
                $this->set('request_data', $request_data);
            }

            $this->set('students', $get_students);

            $allArray = $this->generateCertificate($request_data['config_id']);
            $vals = array_keys($allArray);

            foreach ($vals as $val) {
                $tags[$val] = '@' . $val;
            }
            $tags = $this->tagMatch($tags, $request_data['student_id'], $request_data['config_id']);
            $this->set('tags', $tags);
        }

        $student = TableRegistry::getTableLocator()->get('scms_students');
        $students = $student->find()->toArray();
        $this->set('student_ids', $students);

        $type = TableRegistry::getTableLocator()->get('scms_certificate_type');
        $types = $type->find()->toArray();
        $this->set('types', $types);

        $config = TableRegistry::getTableLocator()->get('scms_certificate_config');
        $configs = $config->find()->toArray();
        $this->set('configs', $configs);
    }

    private function tagMatch($tag_name, $student_id, $config_id)
    {
        $tag = TableRegistry::getTableLocator()->get('scms_certificate_tags');
        $tags = $tag->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['tag  IN' => $tag_name]) //matching tag name
            ->toArray();


        $allArrayCss = $this->setSpanWidth($config_id);

        // Remove the numeric part from the array keys and prefix with '@'
        $updatedArray = array();
        foreach ($allArrayCss as $key => $value) {
            $newKey = '@' . preg_replace('/\d+/', '', $key);
            $updatedArray[$newKey] = $value;
        }

        foreach ($tags as $key => $tag) {
            // Match the tag key with the updated array key and set the width value
            if (isset($updatedArray[$tag['tag']])) {
                $tags[$key]['width'] = $updatedArray[$tag['tag']];
            } else {
                $tags[$key]['width'] = null; // or any default value you want to set
            }
        }

        foreach ($tags as $key => $tag) {
            $where = array();
            if ($tag['related_table'] && $tag['related_table_field']) {
                $related_table = TableRegistry::getTableLocator()->get($tag['related_table']);
                $where['student_id'] = $student_id;
                if ($tag['related_table'] == 'scms_guardians') {
                    $where['relation'] = substr(str_replace("_name", "", $tag['tag']), 1);
                }

                $value = $related_table->find()
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->where($where)
                    ->toArray();
                $tags[$key]['tag_value'] = $value[0][$tag['related_table_field']] ?? null;
            }
        }
        return $tags;
    }

    private function generateCertificate($id)
    {
        $type = TableRegistry::getTableLocator()->get('scms_certificate_config');
        $types = $type
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['config_id' => $id])
            ->toArray();

        $str_main = $types[0]['main_content']; //get the field value from DB
        $str_left_head = $types[0]['left_head'];
        $str_right_head = $types[0]['right_head'];
        $str_left_footer = $types[0]['left_footer'];
        $str_right_footer = $types[0]['right_footer'];
        $str_office_main = $types[0]['office_main_content']; //get the field value from DB
        $str_office_lh = $types[0]['office_left_head']; //get the field value from DB
        $str_office_rh = $types[0]['office_right_head']; //get the field value from DB
        $str_office_lf = $types[0]['office_left_footer']; //get the field value from DB
        $str_office_rf = $types[0]['office_right_footer']; //get the field value from DB

        $tag = '@'; //Search for this tag value and get the tag


        // =========================================
        ##Main_content
        preg_match_all('/' . preg_quote($tag, '/') . '\w+/', $str_main, $matches);
        $results = $matches[0];

        $val = str_replace('@', '', $results);
        $arr_main = array_flip($val);

        foreach ($arr_main as $key => $value) {
            $arr_main[$key] = null;
        }

        ##OFFICE MAIN CONTENT
        preg_match_all('/' . preg_quote($tag, '/') . '\w+/', $str_office_main, $matches_office);

        $office_words_st = $matches_office[0]; // The matched tags

        $val_ofc = str_replace('@', '', $office_words_st);
        $arr_main_ofc = array_flip($val_ofc);

        foreach ($arr_main_ofc as $key => $value) {
            $arr_main_ofc[$key] = null;
        }
        // =========================================



        // =========================================
        ##Left Header
        preg_match_all('/' . preg_quote($tag, '/') . '\w+/', $str_left_head, $matches_lh);
        $results_lh = $matches_lh[0]; // The matched tags

        $val_lh = str_replace('@', '', $results_lh);
        $arr_lh = array_flip($val_lh);

        foreach ($arr_lh as $key => $value) {
            $arr_lh[$key] = null;
        }

        ##OFFICE Left Header
        preg_match_all('/' . preg_quote($tag, '/') . '\w+/', $str_office_lh, $matches_lh_ofc);
        $results_lh_ofc = $matches_lh_ofc[0]; // The matched tags

        $val_lh_ofc = str_replace('@', '', $results_lh_ofc);
        $arr_lh_ofc = array_flip($val_lh_ofc);

        foreach ($arr_lh_ofc as $key => $value) {
            $arr_lh_ofc[$key] = null;
        }
        // =========================================



        // =========================================
        ##Right Header
        preg_match_all('/' . preg_quote($tag, '/') . '\w+/', $str_right_head, $matches_rh);
        $results_rh = $matches_rh[0]; // The matched tags

        $val_rh = str_replace('@', '', $results_rh);
        $arr_rh = array_flip($val_rh);

        foreach ($arr_rh as $key => $value) {
            $arr_rh[$key] = null;
        }

        ##OFFICE Right Header
        preg_match_all('/' . preg_quote($tag, '/') . '\w+/', $str_office_rh, $matches_rh_ofc);
        $results_rh_ofc = $matches_rh_ofc[0]; // The matched tags

        $val_rh_ofc = str_replace('@', '', $results_rh_ofc);
        $arr_rh_ofc = array_flip($val_rh_ofc);

        foreach ($arr_rh_ofc as $key => $value) {
            $arr_rh_ofc[$key] = null;
        }
        // =========================================



        // =========================================
        ##Left Footer
        preg_match_all('/' . preg_quote($tag, '/') . '\w+/', $str_left_footer, $matches_lf);
        $results_lf = $matches_lf[0]; // The matched tags

        $val_lf = str_replace('@', '', $results_lf);
        $arr_lf = array_flip($val_lf);

        foreach ($arr_lf as $key => $value) {
            $arr_lf[$key] = null;
        }

        ##OFFICE Left Footer
        preg_match_all('/' . preg_quote($tag, '/') . '\w+/', $str_office_lf, $matches_lf_ofc);
        $results_lf_ofc = $matches_lf_ofc[0]; // The matched tags

        $val_lf_ofc = str_replace('@', '', $results_lf_ofc);
        $arr_lf_ofc = array_flip($val_lf_ofc);

        foreach ($arr_lf_ofc as $key => $value) {
            $arr_lf_ofc[$key] = null;
        }
        // =========================================



        // =========================================
        ##Right Footer
        preg_match_all('/' . preg_quote($tag, '/') . '\w+/', $str_right_footer, $matches_rf);
        $results_rf = $matches_rf[0]; // The matched tags

        $val_rf = str_replace('@', '', $results_rf);
        $arr_rf = array_flip($val_rf);

        foreach ($arr_rf as $key => $value) {
            $arr_rf[$key] = null;
        }

        ##OFFICE Right Footer
        preg_match_all('/' . preg_quote($tag, '/') . '\w+/', $str_office_rf, $matches_rf_ofc);
        $results_rf_ofc = $matches_rf_ofc[0]; // The matched tags

        $val_rf_ofc = str_replace('@', '', $results_rf_ofc);
        $arr_rf_ofc = array_flip($val_rf_ofc);

        foreach ($arr_rf_ofc as $key => $value) {
            $arr_rf_ofc[$key] = null;
        }
        // =========================================

        $marged = array_merge($arr_lh, $arr_rh, $arr_main, $arr_lf, $arr_rf, $arr_lh_ofc, $arr_rh_ofc, $arr_main_ofc, $arr_lf_ofc, $arr_rf_ofc);

        return $marged;
    }


    private function setSpanWidth($id)
    {
        $type = TableRegistry::getTableLocator()->get('scms_certificate_config');
        $types = $type
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['config_id' => $id])
            ->toArray();

        $str_main = $types[0]['main_content']; //get the field value from DB
        $str_left_head = $types[0]['left_head'];
        $str_right_head = $types[0]['right_head'];
        $str_left_footer = $types[0]['left_footer'];
        $str_right_footer = $types[0]['right_footer'];
        $str_office_main = $types[0]['office_main_content']; //get the field value from DB
        $str_office_lh = $types[0]['office_left_head']; //get the field value from DB
        $str_office_rh = $types[0]['office_right_head']; //get the field value from DB
        $str_office_lf = $types[0]['office_left_footer']; //get the field value from DB
        $str_office_rf = $types[0]['office_right_footer']; //get the field value from DB



        // =========================================
        ##MAIN_CONTENT SPAN WIDTH
        preg_match_all('/\[\w+\]/', $str_main, $matches_css);
        $resultsCss = array_map(function ($match) {
            return trim($match, '[]');
        }, $matches_css[0]);

        $val_css = str_replace('@', '', $resultsCss);
        $arr_main_css = array_flip($val_css);

        foreach ($arr_main_css as $key => $value) {
            // Extract the numeric part from the key using a regular expression
            preg_match('/\d+/', $key, $matches);
            $arr_main_css[$key] = isset($matches[0]) ? $matches[0] : null;
        }


        // OFFICE MAIN CONTENT
        preg_match_all('/\[\w+\]/', $str_office_main, $matches_office_css);
        $results_office_css = array_map(function ($match) {
            return trim($match, '[]');
        }, $matches_office_css[0]);

        $val_ofc_css = str_replace('@', '', $results_office_css);
        $arr_main_ofc_css = array_flip($val_ofc_css);

        foreach ($arr_main_ofc_css as $key => $value) {
            // Extract the numeric part from the key using a regular expression
            preg_match('/\d+/', $key, $matches);
            $arr_main_ofc_css[$key] = isset($matches[0]) ? $matches[0] : null;
        }
        // =========================================



        // =========================================
        // Left Header
        preg_match_all('/\[\w+\]/', $str_left_head, $matches_lh_css);
        $results_lh_css = array_map(function ($match) {
            return trim($match, '[]');
        }, $matches_lh_css[0]);

        $val_lh_css = str_replace('@', '', $results_lh_css);
        $arr_lh_css = array_flip($val_lh_css);

        foreach ($arr_lh_css as $key => $value) {
            // Extract the numeric part from the key using a regular expression
            preg_match('/\d+/', $key, $matches);
            $arr_lh_css[$key] = isset($matches[0]) ? $matches[0] : null;
        }

        // OFFICE Left Header
        preg_match_all('/\[\w+\]/', $str_office_lh, $matches_lh_ofc_css);
        $results_lh_ofc_css = array_map(function ($match) {
            return trim($match, '[]');
        }, $matches_lh_ofc_css[0]);

        $val_lh_ofc_css = str_replace('@', '', $results_lh_ofc_css);
        $arr_lh_ofc_css = array_flip($val_lh_ofc_css);

        foreach ($arr_lh_ofc_css as $key => $value) {
            // Extract the numeric part from the key using a regular expression
            preg_match('/\d+/', $key, $matches);
            $arr_lh_ofc_css[$key] = isset($matches[0]) ? $matches[0] : null;
        }
        // =========================================



        // =========================================
        // Right Header
        preg_match_all('/\[\w+\]/', $str_right_head, $matches_rh_css);
        $results_rh_css = array_map(function ($match) {
            return trim($match, '[]');
        }, $matches_rh_css[0]);

        $val_rh_css = str_replace('@', '', $results_rh_css);
        $arr_rh_css = array_flip($val_rh_css);

        foreach ($arr_rh_css as $key => $value) {
            // Extract the numeric part from the key using a regular expression
            preg_match('/\d+/', $key, $matches);
            $arr_rh_css[$key] = isset($matches[0]) ? $matches[0] : null;
        }

        // OFFICE Right Header
        preg_match_all('/\[\w+\]/', $str_office_rh, $matches_rh_ofc_css);
        $results_rh_ofc_css = array_map(function ($match) {
            return trim($match, '[]');
        }, $matches_rh_ofc_css[0]);

        $val_rh_ofc_css = str_replace('@', '', $results_rh_ofc_css);
        $arr_rh_ofc_css = array_flip($val_rh_ofc_css);

        foreach ($arr_rh_ofc_css as $key => $value) {
            // Extract the numeric part from the key using a regular expression
            preg_match('/\d+/', $key, $matches);
            $arr_rh_ofc_css[$key] = isset($matches[0]) ? $matches[0] : null;
        }
        // =========================================



        // =========================================
        // Left Footer
        preg_match_all('/\[\w+\]/', $str_left_footer, $matches_lf_css);
        $results_lf_css = array_map(function ($match) {
            return trim($match, '[]');
        }, $matches_lf_css[0]);

        $val_lf_css = str_replace('@', '', $results_lf_css);
        $arr_lf_css = array_flip($val_lf_css);

        foreach ($arr_lf_css as $key => $value) {
            // Extract the numeric part from the key using a regular expression
            preg_match('/\d+/', $key, $matches);
            $arr_lf_css[$key] = isset($matches[0]) ? $matches[0] : null;
        }

        // OFFICE Left Footer
        preg_match_all('/\[\w+\]/', $str_office_lf, $matches_lf_ofc_css);
        $results_lf_ofc_css = array_map(function ($match) {
            return trim($match, '[]');
        }, $matches_lf_ofc_css[0]);

        $val_lf_ofc_css = str_replace('@', '', $results_lf_ofc_css);
        $arr_lf_ofc_css = array_flip($val_lf_ofc_css);

        foreach ($arr_lf_ofc_css as $key => $value) {
            // Extract the numeric part from the key using a regular expression
            preg_match('/\d+/', $key, $matches);
            $arr_lf_ofc_css[$key] = isset($matches[0]) ? $matches[0] : null;
        }
        // =========================================



        // =========================================
        // Right Footer
        preg_match_all('/\[\w+\]/', $str_right_footer, $matches_rf_css);
        $results_rf_css = array_map(function ($match) {
            return trim($match, '[]');
        }, $matches_rf_css[0]);

        $val_rf_css = str_replace('@', '', $results_rf_css);
        $arr_rf_css = array_flip($val_rf_css);

        foreach ($arr_rf_css as $key => $value) {
            // Extract the numeric part from the key using a regular expression
            preg_match('/\d+/', $key, $matches);
            $arr_rf_css[$key] = isset($matches[0]) ? $matches[0] : null;
        }

        // OFFICE Right Footer
        preg_match_all('/\[\w+\]/', $str_office_rf, $matches_rf_ofc_css);
        $results_rf_ofc_css = array_map(function ($match) {
            return trim($match, '[]');
        }, $matches_rf_ofc_css[0]);

        $val_rf_ofc_css = str_replace('@', '', $results_rf_ofc_css);
        $arr_rf_ofc_css = array_flip($val_rf_ofc_css);

        foreach ($arr_rf_ofc_css as $key => $value) {
            // Extract the numeric part from the key using a regular expression
            preg_match('/\d+/', $key, $matches);
            $arr_rf_ofc_css[$key] = isset($matches[0]) ? $matches[0] : null;
        }
        // =========================================



        $marged = array_merge($arr_main_css, $arr_main_ofc_css, $arr_lh_css, $arr_lh_ofc_css, $arr_rh_css, $arr_rh_ofc_css, $arr_lf_css, $arr_lf_ofc_css, $arr_rf_css, $arr_rf_ofc_css);

        return $marged;
    }


     public function printCertificate($id)
    {
        $this->layout = 'report';
        $tag_value = TableRegistry::getTableLocator()->get('scms_certificate_tag_values');
        $tag_values = $tag_value
            ->find()
            ->where(['tag_values_id' => $id])
            ->toArray();

        $decoded_values = json_decode($tag_values[0]['tag_values'], true); // decode JSON as associative array
        $values = (array) $decoded_values; // cast to array, though this may not be necessary
        
        
        $this->set('values', $values);
        /* foreach ($values as $key => $value) {
            $devide = $value['value'];
            $width = !empty($value['width']) ? ' style="width:' . $value['width'] . 'px!important;"' : '';
            $values[$key]['value'] = '<span' . $width . '>' . $devide . '</span>';
            $devide = null;
        }*/
        foreach ($values as $key => $value) {
            $devide = ucwords(strtolower($value['value'])); // Format the text
            $width = !empty($value['width']) ? ' style="width:' . $value['width'] . 'px!important;"' : '';
            $values[$key]['value'] = '<span' . $width . '>' . $devide . '</span>';
            $devide = null;
        }

        // echo '<pre>';
        // print_r($values);die;
        $this->set('values', $values);

        $type = TableRegistry::getTableLocator()->get('scms_certificate_config');
        $types = $type
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['config_id' => $tag_values[0]['config_id']])
            ->toArray();
            
        $this->set('tag_values', $tag_values);
        $this->set('types', $types[0]);
        $this->render('/reports/certificate');
    }


    public function viewCertificates()
    {
        $request_data = TableRegistry::getTableLocator()->get('scms_certificate_tag_values');
        $get_values = $request_data
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->order('scms_certificate_tag_values.tag_values_id  ASC')
            ->select([
                'sid' => 's.sid',
                'name' => 's.name',
                'config_name' => 'cn.config_name',
                'certificate_title' => 'ct.certificate_title'
            ])
            ->join([
                's' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => ['s.student_id = scms_certificate_tag_values.student_id'],
                ],
                'cn' => [
                    'table' => 'scms_certificate_config',
                    'type' => 'LEFT',
                    'conditions' => ['cn.config_id  = scms_certificate_tag_values.config_id '],
                ],
                'ct' => [
                    'table' => 'scms_certificate_type',
                    'type' => 'LEFT',
                    'conditions' => ['ct.certificate_type_id   = cn.certificate_type_id '],
                ],
            ]);


        $paginate = $this->paginate($get_values, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();

        $this->set('values', $paginate);
    }

    public function editCertificates($id)
    {
        print_r('Will be working if required');
        die;
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $result['student_id'] = $request_data['student_id'];
            $result['config_id'] = $request_data['config_id'];

            unset($request_data['student_id']);
            unset($request_data['config_id']);
            unset($request_data['generate']);

            $result['tag_values'] = json_encode($request_data);
            $get_values = TableRegistry::getTableLocator()->get('scms_certificate_tag_values');
            $query = $get_values->query();
            $query
                ->update()
                ->values($result)
                ->where([$id => $request_data['tag_values_id']])
                ->execute();
            $view_id = $get_values->find()->last(); //get the last id
            //Set Flash
            $this->Flash->success(' Certificate Saved Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'printCertificate', $view_id['tag_values_id']]);
        }

        $tag_value = TableRegistry::getTableLocator()->get('scms_certificate_tag_values');
        $tag_values = $tag_value
            ->find()
            ->where(['tag_values_id' => $id])
            ->toArray();
        $decoded_values = json_decode($tag_values[0]['tag_values']);
        $values = ((array) ($decoded_values)); //make array with the values

        foreach ($values as $key => $value) {
            $devide = $value;
            $values[$key] = '<span style="font-spacing: 5px">' . $devide . '</span>';
            $devide = null;
        }
        $this->set('values', $values);
    }

    public function deleteCertificates($id)
    {
        $tag_value = TableRegistry::getTableLocator()->get('scms_certificate_tag_values'); //Execute First
        $query = $tag_value->query();
        $query->delete()
            ->where(['tag_values_id' => $id])
            ->execute();

        //Set Flash
        $this->Flash->error('Certificate Deleted Successfully', [
            'key' => 'positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'viewCertificates']);
    }

    public function configCirtificates()
    {
        $request_data = TableRegistry::getTableLocator()->get('scms_certificate_config');
        $get_configs = $request_data
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->order('scms_certificate_config.config_id ASC')
            ->select([
                'id' => 'config_id',
                'certificate_title' => 'c.certificate_title',
            ])
            ->join([
                'c' => [
                    'table' => 'scms_certificate_type',
                    'type' => 'LEFT',
                    'conditions' => ['c.certificate_type_id = scms_certificate_config.certificate_type_id'],
                ],
            ]);

        $paginate = $this->paginate($get_configs, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('configs', $paginate);
    }

    public function addConfig()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();

            $file = $request_data['config_image'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);
            $imageFileName = null;
            if (in_array($ext, $arr_ext)) {
                move_uploaded_file($file['tmp_name'], WWW_ROOT . '/uploads/certificate_image/' . $setNewFileName . '.' . $ext);
                $imageFileName = $setNewFileName . '.' . $ext;
            }
            $ofccpy = $request_data['office_copy_image'];
            $ofext = substr(strtolower(strrchr($ofccpy['name'], '.')), 1); //get the extension
            $arr_ofc_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setOfcFileName = time() . "_" . rand(000000, 999999);
            $imageOfcFileName = null;
            if (in_array($ofext, $arr_ofc_ext)) {
                move_uploaded_file($ofccpy['tmp_name'], WWW_ROOT . '/uploads/certificate_image/' . $setOfcFileName . '.' . $ofext);
                $imageOfcFileName = $setOfcFileName . '.' . $ofext;
            }

            $request_data['config_image'] = $imageFileName;
            $request_data['office_copy_image'] = $imageOfcFileName;
            $get_configs = TableRegistry::getTableLocator()->get('scms_certificate_config');
            $query = $get_configs->query();
            $query
                ->insert(['config_name', 'certificate_type_id', 'left_head', 'right_head', 'main_content', 'left_footer', 'right_footer', 'config_image', 'office_left_head', 'office_right_head', 'office_main_content', 'office_left_footer', 'office_right_footer', 'office_copy_image'])
                ->values($request_data)
                ->execute();
            //Set Flash
            $this->Flash->success('Configuration Saved Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'configCirtificates']);
        }
        $type = TableRegistry::getTableLocator()->get('scms_certificate_type');
        $types = $type->find()->toArray();
        $this->set('types', $types);

        $tag = TableRegistry::getTableLocator()->get('scms_certificate_tags'); //Execute First
        $tags = $tag
            ->find()
            ->where(['related_table !=' => 0])
            ->toArray();
        $this->set('rectags', $tags);

        $get_tag = TableRegistry::getTableLocator()->get('scms_certificate_tags'); //Execute First
        $get_tags = $get_tag
            ->find()
            ->where(['related_table' => 0])
            ->toArray();
        $this->set('notags', $get_tags);
    }

    public function editConfig($id)
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $file = $request_data['config_image'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);
            $imageFileName = null;
            if (in_array($ext, $arr_ext)) {
                move_uploaded_file($file['tmp_name'], WWW_ROOT . '/uploads/certificate_image/' . $setNewFileName . '.' . $ext);
                $imageFileName = $setNewFileName . '.' . $ext;
            }

            $ofccpy = $request_data['office_copy_image'];
            $ofext = substr(strtolower(strrchr($ofccpy['name'], '.')), 1); //get the extension
            $arr_ofc_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setOfcFileName = time() . "_" . rand(000000, 999999);
            $imageOfcFileName = null;
            if (in_array($ofext, $arr_ofc_ext)) {
                move_uploaded_file($ofccpy['tmp_name'], WWW_ROOT . '/uploads/certificate_image/' . $setOfcFileName . '.' . $ofext);
                $imageOfcFileName = $setOfcFileName . '.' . $ofext;
            }

            $request_data['config_image'] = $imageFileName;
            $request_data['office_copy_image'] = $imageOfcFileName;

            if ($imageFileName == null) {
                unset($request_data['config_image']);
            }
            if ($imageOfcFileName == null) {
                unset($request_data['office_copy_image']);
            }
            // pr($request_data);die;
            $get_configs = TableRegistry::getTableLocator()->get('scms_certificate_config');
            $query = $get_configs->query();
            $query
                ->update()
                ->set($request_data)
                ->where(['config_id' => $id])
                ->execute();
            //Set Flash
            $this->Flash->info('Configuration Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'configCirtificates']);
        }
        $config = TableRegistry::getTableLocator()->get('scms_certificate_config'); //Execute First
        $configs = $config
            ->find()
            ->where(['config_id' => $id])
            ->toArray();
        $this->set('configs', $configs[0]);

        $type = TableRegistry::getTableLocator()->get('scms_certificate_type'); //Execute First
        $types = $type->find()->toArray();
        $this->set('types', $types);

        $tag = TableRegistry::getTableLocator()->get('scms_certificate_tags'); //Execute First
        $tags = $tag
            ->find()
            ->where(['related_table !=' => 0])
            ->toArray();
        $this->set('rectags', $tags);

        $get_tag = TableRegistry::getTableLocator()->get('scms_certificate_tags'); //Execute First
        $get_tags = $get_tag
            ->find()
            ->where(['related_table' => 0])
            ->toArray();
        $this->set('notags', $get_tags);
    }

    public function allTags()
    {
        $request_data = TableRegistry::getTableLocator()->get('scms_certificate_tags');
        $get_tags = $request_data->find()->enableAutoFields(true)
            ->enableHydration(false);
        $paginate = $this->paginate($get_tags, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('tags', $paginate);
    }

    public function addTags()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_configs = TableRegistry::getTableLocator()->get('scms_certificate_tags');
            $query = $get_configs->query();
            $query
                ->insert(['tag', 'tag_description'])
                ->values($request_data)
                ->execute();
            //Set Flash
            $this->Flash->success('Tag Saved Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'allTags']);
        }
        $request_data = TableRegistry::getTableLocator()->get('scms_certificate_tags');
        $get_tags = $request_data->find()->enableAutoFields(true)
            ->enableHydration(false);
        $paginate = $this->paginate($get_tags, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('tags', $paginate);
    }

    public function editTags($id)
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $get_configs = TableRegistry::getTableLocator()->get('scms_certificate_tags');
            $query = $get_configs->query();
            $query
                ->update()
                ->set($request_data)
                ->where(['tag_id' => $id])
                ->execute();
            //Set Flash
            $this->Flash->info('Tag Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'allTags']);
        }
        $tag = TableRegistry::getTableLocator()->get('scms_certificate_tags'); //Execute First
        $tags = $tag
            ->find()
            ->where(['tag_id' => $id])
            ->toArray();
        $this->set('tags', $tags[0]);
    }

    public function allTypes()
    {
        $request_data = TableRegistry::getTableLocator()->get('scms_certificate_type');
        $get_types = $request_data->find()->enableAutoFields(true)
            ->enableHydration(false);
        $paginate = $this->paginate($get_types, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('types', $paginate);
    }

    public function addTypes()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_configs = TableRegistry::getTableLocator()->get('scms_certificate_type');
            $query = $get_configs->query();
            $query
                ->insert(['certificate_title'])
                ->values($request_data)
                ->execute();
            //Set Flash
            $this->Flash->success('Certificate Type Saved Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'allTypes']);
        }
    }

    public function editTypes($id)
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $get_configs = TableRegistry::getTableLocator()->get('scms_certificate_type');
            $query = $get_configs->query();
            $query
                ->update()
                ->set($request_data)
                ->where(['certificate_type_id' => $id])
                ->execute();
            //Set Flash
            $this->Flash->info('Certificate Type Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'allTypes']);
        }
        $type = TableRegistry::getTableLocator()->get('scms_certificate_type'); //Execute First
        $types = $type
            ->find()
            ->where(['certificate_type_id' => $id])
            ->toArray();
        $this->set('types', $types[0]);
    }
}
