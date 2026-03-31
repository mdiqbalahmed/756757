<?php

namespace Croogo\Core\Controller\Admin;

use Cake\Core\Configure;
use Cake\Event\Event;
use Croogo\Core\Controller\AppController as CroogoAppController;
use Croogo\Core\Croogo;
use Crud\Controller\ControllerTrait;
use Cake\ORM\TableRegistry;

/**
 * Croogo App Controller
 *
 * @category Croogo.Controller
 * @package  Croogo.Croogo.Controller
 * @version  1.5
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 *
 * @property \Crud\Controller\Component\CrudComponent $Crud
 */
class AppController extends CroogoAppController
{

    use ControllerTrait;

    /**
     * Load the theme component with the admin theme specified
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Paginate_limit = $this->paginate_limit();

        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'index' => [
                    'className' => 'Croogo/Core.Admin/Index'
                ],
                'lookup' => [
                    'className' => 'Crud.Lookup',
                    'findMethod' => 'all'
                ],
                'view' => [
                    'className' => 'Crud.View'
                ],
                'add' => [
                    'className' => 'Croogo/Core.Admin/Add',
                    'messages' => [
                        'success' => [
                            'text' => __d('croogo', '{name} created successfully'),
                            'params' => [
                                'type' => 'success',
                                'class' => ''
                            ]
                        ],
                        'error' => [
                            'params' => [
                                'type' => 'error',
                                'class' => ''
                            ]
                        ]
                    ]
                ],
                'edit' => [
                    'className' => 'Croogo/Core.Admin/Edit',
                    'messages' => [
                        'success' => [
                            'text' => __d('croogo', '{name} updated successfully'),
                            'params' => [
                                'type' => 'success',
                                'class' => ''
                            ]
                        ],
                        'error' => [
                            'params' => [
                                'type' => 'error',
                                'class' => ''
                            ]
                        ]
                    ]
                ],
                'toggle' => [
                    'className' => 'Croogo/Core.Admin/Toggle'
                ],
                'delete' => [
                    'className' => 'Crud.Delete'
                ]
            ],
            'listeners' => [
                'Crud.Redirect',
                'Crud.Search',
                'Crud.RelatedModels',
                'Croogo/Core.Flash',
            ]
        ]);

        $this->Theme->setConfig('theme', Configure::read('Site.admin_theme'));
    }

    /**
     * beforeFilter
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $this->viewBuilder()->setLayout('admin');

        parent::beforeFilter($event);

        Croogo::dispatchEvent('Croogo.beforeSetupAdminData', $this);
    }

    public function index()
    {
        return $this->Crud->execute();
    }

    public function view($id)
    {
        return $this->Crud->execute();
    }

    public function add()
    {
        return $this->Crud->execute();
    }

    public function edit($id)
    {
        return $this->Crud->execute();
    }

    public function delete($id)
    {
        return $this->Crud->execute();
    }

    protected function redirectToSelf(Event $event)
    {
        $subject = $event->getSubject();
        if ($subject->success) {
            $data = $this->getRequest()->getData();
            if (isset($data['_apply'])) {
                $entity = $subject->entity;

                return $this->redirect(['action' => 'edit', $entity->id]);
            }
        }
    }

    protected function insert_delete_update_log($controller, $function, $type, $comment)
    {
        $delete_update_log_data['controller_name'] = $controller;
        $delete_update_log_data['function_name'] = $function;
        $delete_update_log_data['type_name'] = $type;
        $delete_update_log_data['comment'] = $comment;
        $delete_update_log_data['perform_by'] = $this->Auth->user('id');
        $delete_update_log_data['date'] = date("Y-m-d h:i:sa");

        $scms_delete_update_log = TableRegistry::getTableLocator()->get('scms_delete_update_log');
        $query = $scms_delete_update_log->query();
        $query->insert(['controller_name', 'function_name', 'type_name', 'comment', 'perform_by', 'date'])
            ->values($delete_update_log_data)
            ->execute();
        return true;
    }

    private function paginate_limit()
    {
        return 500;
    }

    private function cheak_sms()
    {
        $setting = TableRegistry::getTableLocator()->get('settings');
        $settings = $setting
            ->find()
            ->where(['`key`' => 'SMS.SMS_status'])
            ->toArray();
        if (($settings[0]['value']) == 'ON') {
            return true;
        } else {
            return false;
        }
    }

    protected function get_settings_value($key)
    {
        $setting = TableRegistry::getTableLocator()->get('settings');
        $settings = $setting
            ->find()
            ->where(['`key`' => $key])
            ->toArray();
        return isset($settings[0]['value']) ? $settings[0]['value'] : null;
    }

    private function cheak_sms_count($messages)
    {
        $total_sms = 0;
        foreach ($messages as $single) {
            $message = $single['messageContent'];
            if ((mb_strlen($message) != strlen($message))) {
                $sms_length = mb_strlen($message);
                $persms_length = 70;
            } else {
                $sms_length = strlen($message);
                $persms_length = 160;
            }
            $total_sms += ceil($sms_length / $persms_length);
        }

        $setting = TableRegistry::getTableLocator()->get('settings');
        $settings = $setting
            ->find()
            ->where(['`key`' => 'SMS.SMS_Credit'])
            ->toArray();
        $new['value'] = $settings[0]['value'] - $total_sms;

        if ($new['value'] >= 0) {
            return true;
        } else {
            return false;
        }
    }

    private function cheak_sms_count_single($message, $count)
    {
        if ((mb_strlen($message) != strlen($message))) {
            $sms_length = mb_strlen($message);
            $persms_length = 70;
        } else {
            $sms_length = strlen($message);
            $persms_length = 160;
        }
        $total_sms = (ceil($sms_length / $persms_length)) * $count;

        $setting = TableRegistry::getTableLocator()->get('settings');
        $settings = $setting
            ->find()
            ->where(['`key`' => 'SMS.SMS_Credit'])
            ->toArray();
        $new['value'] = $settings[0]['value'] - $total_sms;

        if ($new['value'] >= 0) {
            return true;
        } else {
            return false;
        }
    }

    private function sms_minus($total_sms)
    {
        $setting = TableRegistry::getTableLocator()->get('settings');
        $settings = $setting
            ->find()
            ->where(['`key`' => 'SMS.SMS_Credit'])
            ->toArray();
        $new['value'] = $settings[0]['value'] - $total_sms;
        $query = $setting->query();
        $query->update()
            ->set($new)
            ->where(['`key`' => 'SMS.SMS_Credit'])
            ->execute();

        $count = $setting
            ->find()
            ->where(['`key`' => 'SMS.SMS_Count'])
            ->toArray();
        $new_count['value'] = $count[0]['value'] + $total_sms;
        $query1 = $setting->query();
        $query1->update()
            ->set($new_count)
            ->where(['`key`' => 'SMS.SMS_Count'])
            ->execute();
    }

    private function sms_log($data)
    {
        $sms_log = TableRegistry::getTableLocator()->get('sms_log');
        $query = $sms_log->query();
        $data['number_of_sms'] = $data['sms_count'] / $data['segment'];
        $query->insert(['sms_count', 'sms_type', 'user_id', 'sms', 'segment', 'number_of_sms'])
            ->values($data)
            ->execute();
            
        $delete_date = date('Y-m-d', strtotime('-60 days'));
        $query = $sms_log->query();
        $query->delete()
            ->where(['date <' => $delete_date])
            ->execute();
    }

    protected function send_sms($type, $recipients, $args = array())
    {
        if ($this->cheak_sms()) {
            $apikey = Configure::read('SMS.API_Key');
            $secretkey = Configure::read('SMS.Secret_Key');
            $callerID = Configure::read('SMS.CallerID');
            $instituteTag = Configure::read('SMS.SMS_institute_tag');
            $headRecipientString = Configure::read('SMS.head_number');
            $headRecipients = explode(',', $headRecipientString);
            $headCount = count($headRecipients);
            $smsFooter = "\n" . $instituteTag;
            $result = 0;
            $headMessage = '';
            if ($type == 'general') {
                $message = $args['sms'];
                if ($this->cheak_sms_count_single($message, count($recipients))) {

                    $result = $this->send_reve_single($recipients, $message, $apikey, $secretkey, $callerID);

                    // Head Message
                    $log['sms'] = $message;
                    $log['segment'] = $this->multipart_count($log['sms']);
                    $log['number_of_sms'] = count($recipients) + $headCount;
                    $log['sms_count'] = $result + ($headCount * $log['segment']);

                    $headfooter = "\n\nTotal SMS Sent:" . $log['sms_count'];
                    $hfLenth = strlen($headfooter) + 3;
                    $headMessage = $log['sms'] . '' . $headfooter;
                    // $headMessage = substr($log['sms'], 0, - ($hfLenth)) . '...' . $headfooter;
                }
            } else if ($type == 'credit') {
                $recipients = $args['mobile'];
                $message = "Thanks. " . ($args['amount']) . " Tk has been Received for " . $args['name'] . " on " . date('j-M-y') . "\nCongratulations, Fees Paid." . "$smsFooter";
                // echo '<pre>';
                // print_r($message);die;
                
                
                if ($this->cheak_sms_count_single($message, count($recipients))) {

                    $result = $this->send_reve_single($recipients, $message, $apikey, $secretkey, $callerID);
                    $log['sms'] = $message;
                    $log['number_of_sms'] = count($recipients);
                
                } else {
                
                   
                    $this->Flash->error('You have no SMS credit.');
                
                    return;
                }
                
            } else if ($type == 'sms_for_due') {

                foreach ($args['students'] as $k => $studnet) {

                    $text = !empty($args['text']) ? $args['text'] . "\n" : '';
                    $messages[$k]['callerID'] = $callerID;
                    $messages[$k]['toUser'] = preg_replace('/^[0]/', '88$0', $studnet['mobile']);
                    // $messages[$k]['messageContent'] = $args['text'] . $smsFooter;
                    $messages[$k]['messageContent'] = $text . strtoupper($studnet['name']) . " have not Paid Yet " . date('j-M-y') . "\n" . $smsFooter;
                }
                echo '<pre>';
                print_r($messages);
                die;
                if ($this->cheak_sms_count($messages)) {
                    $result = $this->send_reve_multi($messages, $apikey, $secretkey);
                    $log['sms'] = $messages[$k]['messageContent'];
                    $log['segment'] = $this->multipart_count($log['sms']);
                    $log['number_of_sms'] = count($messages) + $headCount;
                    $log['sms_count'] = $result + ($headCount * $log['segment']);
                    $headfooter = "\n\nTotal SMS Sent:" . $log['sms_count'];
                }
            } else if ($type == 'birthday') {

                foreach ($args['students'] as $k => $studnet) {


                    $messages[$k]['callerID'] = $callerID;
                    $messages[$k]['toUser'] = preg_replace('/^[0]/', '88$0', $studnet['mobile']);
                    $messages[$k]['messageContent'] = "Happy birthday " . $studnet['name'] . "! May this year bring you new knowledge, new goals, and lots of success.";
                }
                echo '<pre>';
                print_r($messages);
                die;
                if ($this->cheak_sms_count($messages)) {
                    $result = $this->send_reve_multi($messages, $apikey, $secretkey);
                    $log['sms'] = $messages[$k]['messageContent'];
                    $log['segment'] = $this->multipart_count($log['sms']);
                    $log['number_of_sms'] = count($messages) + $headCount;
                    $log['sms_count'] = $result + ($headCount * $log['segment']);
                    $headfooter = "\n\nTotal SMS Sent:" . $log['sms_count'];
                }
            } else if ($type == 'due_sms') {

                foreach ($args['students'] as $k => $studnet) {


                    $messages[$k]['callerID'] = $callerID;
                    $messages[$k]['toUser'] = preg_replace('/^[0]/', '88$0', $studnet['mobile']);
                    $messages[$k]['messageContent'] = "Dear Parent,\nPlease be informed that " . strtoupper($studnet['name']) . " SID: " . strtoupper($studnet['sid']) . " has " . number_format($studnet['amount'], 0) . " tk Due." . $smsFooter;
                    /* $messages[$k]['messageContent'] = "Dear Parent,\nPlease be informed that " . $studnet['name'] . "\n"
                     . "SID: " . $studnet['sid'] . "\n"
                     . "Pay Amount: " . number_format($studnet['amount'], 0) . " Tk.\n"
                     . "through Rocket Mobile Banking.\n" 
                     . "School Biller ID: 5276 (Rocket)\n" 
                     . "For the payment procedure, please visit our website (www.dgghs.edu.bd) "  
                     . $smsFooter; */


                }
                // echo '<pre>';
                // print_r($messages);
                // die;
                if ($this->cheak_sms_count($messages)) {
                    $result = $this->send_reve_multi($messages, $apikey, $secretkey);
                    $log['sms'] = $messages[$k]['messageContent'];
                    $log['segment'] = $this->multipart_count($log['sms']);
                    $log['number_of_sms'] = count($messages) + $headCount;
                    $log['sms_count'] = $result + ($headCount * $log['segment']);
                    $headfooter = "\n\nTotal SMS Sent:" . $log['sms_count'];
                }
            } else if ($type === 'admission') {
                $recipients = $args['fmobile'];
                $gsa_id = $args['gsa_id'];
                // echo '<pre>';
                // print_r($args);
                // die;
                // $message = "Congratulations, Document verification done." ."\nGSA ID: ". $gsa_id . "\nBill No: 
                //     " . $args['sid'] . " " . "$smsFooter";
                $message = "Congratulations, Documents verified for " . $args['name'] . ".\n"
                    . "GSA ID: " . $gsa_id . "\n"
                    . "Bill No: " . $args['sid'] . "\n"
                    . "Pay admission fee 2054 Tk (School Fee 2023 Tk & Mobile Banking Charge 31 Tk) using your 'Bill No " . $args['sid'] . "' through Mobile Banking.\n"
                    . "School Biller ID: 5276 (Rocket)\n"
                    . "School Biller ID: 3061 (Nagad)\n"
                    . "Visit our website (www.dgghs.edu.bd) for payment procedure."
                    . $smsFooter;



                
                // $log['number_of_sms'] = count($mobileNumber);
                //                $countSms = 1;
                
                
                if ($this->cheak_sms_count_single($message, count($recipients))) {

                    $result = $this->send_reve_single($recipients, $message, $apikey, $secretkey, $callerID);
                    $log['sms'] = $message;
                
                } else {
                
                   
                    $this->Flash->error('You have no SMS credit.');
                
                    return;
                }
                
                
            } else if ($type == 'present') {
                foreach ($args['father_mobile'] as $k => $number) {
                    $messages[$k]['callerID'] = $callerID;
                    $messages[$k]['toUser'] = preg_replace('/^[0]/', '88$0', $number);
                    $messages[$k]['messageContent'] = "Dear Parent,\nPlease be informed that " . strtoupper($args['name'][$k]) . ", is Present in " . "'" . $args['course_name'] . "'" . " Class." . $smsFooter;
                }

                if ($this->cheak_sms_count($messages)) {
                    $result = $this->send_reve_multi($messages, $apikey, $secretkey);
                    $log['sms'] = $messages[$k]['messageContent'];
                    $log['segment'] = $this->multipart_count($log['sms']);
                    $log['number_of_sms'] = count($messages) + $headCount;
                    $log['sms_count'] = $result + ($headCount * $log['segment']);
                    $headfooter = "\n\nTotal SMS Sent:" . $log['sms_count'];
                }
                $headMessage = "Dear Sir/Ma'am, \nPlease be informed that the Present SMS requests were sent for class: " . $args['students'][0]['level_name'] . " on " . date('j-M-y') . "" . $headfooter;
            } else if ($type == 'absent') {

                foreach ($args['students'] as $k => $studnet) {
                    $messages[$k]['callerID'] = $callerID;
                    $messages[$k]['toUser'] = preg_replace('/^[0]/', '88$0', $studnet['mobile']);
                    $messages[$k]['messageContent'] = "Dear Parent,\nPlease be informed that " . strtoupper($studnet['student_name']) . " is ABSENT on " . $args['date'] . "\nContact the Class Teacher for further inquiries." . $smsFooter;
                }
                if ($this->cheak_sms_count($messages)) {
                    $result = $this->send_reve_multi($messages, $apikey, $secretkey);
                    $log['sms'] = $messages[$k]['messageContent'];
                    $log['segment'] = $this->multipart_count($log['sms']);
                    $log['number_of_sms'] = count($messages) + $headCount;
                    $log['sms_count'] = $result + ($headCount * $log['segment']);
                    $headfooter = "\n\nTotal SMS Sent:" . $log['sms_count'];
                }
                $headMessage = "Dear Sir/Ma'am, \nPlease be informed that the ABSENT SMS requests were sent for class: " . $args['students'][0]['level_name'] . " on " . date('j-M-y') . "" . $headfooter;
            } else if ($type == 'device_absent') {
                foreach ($args as $k => $student) {
                    $messages[$k]['callerID'] = $callerID;
                    $messages[$k]['toUser'] = preg_replace('/^[0]/', '88$0', $student['mobile']);
                    $messages[$k]['messageContent'] = "Dear Parent,\nPlease be informed that " . strtoupper($student['name']) . " was ABSENT on " . date('j-M-y') . ". For enquiry please contact with Class Teacher" . $smsFooter;
                }
                if ($this->cheak_sms_count($messages)) {
                    $result = $this->send_reve_multi($messages, $apikey, $secretkey);
                    $log['sms'] = $messages[$k]['messageContent'];
                    $log['number_of_sms'] = count($messages);
                }
            } else if ($type == 'merit') {
                foreach ($args['recipients'] as $k => $student) {
                    $Message = "Exam: " . strtoupper($args['term_name']) . "\nName: " . strtoupper($student['name']) . "\nSID: " . $student['sid'] . "\nClass: " . $student['level_name'] . "-" . $student['section_name'] . "\nTotal: " . strtoupper($student['marks_with_forth_subject']) . "\nGPA: " . strtoupper($student['gpa_with_forth_subject']) . "\nGrade: " . $student['grade'] . "\nMerit: " . (empty($student['position_in_' . $args['merit']]) ? 'N/A' : $student['position_in_' . $args['merit']]) . "$smsFooter";
                    $messages[$k]['callerID'] = $callerID;
                    $messages[$k]['toUser'] = preg_replace('/^[0]/', '88$0', $student['mobile']);
                    $messages[$k]['messageContent'] = $Message;
                }
                if ($this->cheak_sms_count($messages)) {
                    $result = $this->send_reve_multi($messages, $apikey, $secretkey);
                    $log['sms'] = $messages[$k]['messageContent'];
                    $log['number_of_sms'] = count($messages);
                }
            }

            $headresult = 0;
            if (!empty($headMessage)) {
                $headresult = $this->send_reve_single($headRecipients, $headMessage, $apikey, $secretkey, $callerID);
            }
            $this->sms_minus($result + $headresult);
            $log['sms_type'] = $type;
            $log['segment'] = $this->multipart_count($log['sms']);
            $log['sms_count'] = $result + $headresult;
            $log['user_id'] = $this->Auth->user('id');
            $this->sms_log($log);
            return $result + $headresult;
        } else {
            echo 'SMS Service is Unavailable';
            return 0;
        }
    }


    protected function send_reve_single($recipients, $message, $apikey, $secretkey, $callerID)
    {
        if (!is_array($recipients))
            $recipients = explode(',', $recipients);
        $recipients = array_map('trim', $recipients);
        $recipients = array_values(array_unique(preg_replace('/^[0]/', '88$0', $recipients)));

        $url = "https://smpp.revesms.com:7790/sendtext";

        $dataformat = [
            "apikey" => $apikey,
            "secretkey" => $secretkey,
            "callerID" => $callerID,
            "toUser" => "",
            "messageContent" => str_replace("\r", "", $message)
        ];

        $datas = array();
        for ($i = 0; $i < count($recipients); $i++) {
            $dataformat["toUser"] .= $recipients[$i] . ",";
            if (strlen($url . '?' . http_build_query($dataformat)) > 8000) {
                $dataformat["toUser"] = rtrim($dataformat["toUser"], ',');
                $datas[] = $dataformat;
                $dataformat["toUser"] = '';
            }
        }
        if ($dataformat["toUser"] != '') {
            $dataformat["toUser"] = rtrim($dataformat["toUser"], ',');
            $datas[] = $dataformat;
        }

        $tatal_sent = 0;

        foreach ($datas as $data) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $headers = array();
            $headers[] = "Key: Value";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT:!DH');
            $result = json_decode(curl_exec($ch));

            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            if ($result->Status == 0) {
                $sms_sent = count(explode(',', $result->Message_ID));
                $tatal_sent += $sms_sent * $this->multipart_count($message);
            }
        }
        return $tatal_sent;
    }

    protected function send_reve_multi($messages, $apikey, $secretkey)
    {
        $url = "https://smpp.revesms.com:7790/send";
        $dataformat = [
            "apikey" => $apikey,
            "secretkey" => $secretkey,
            "content" => ''
        ];

        $datas = $slice_message = array();

        for ($i = 0; $i < count($messages); $i++) {
            array_push($slice_message, $messages[$i]);
            $dataformat["content"] = json_encode($slice_message);
            if (strlen($url . '?' . http_build_query($dataformat)) > 7800) {
                $dataformat["content"] = json_encode($slice_message);
                $datas[] = $dataformat;
                $dataformat["content"] = '';
                $slice_message = [];
            }
        }

        if ($dataformat["content"] != '') {
            $dataformat["content"] = json_encode($slice_message);
            $datas[] = $dataformat;
        }

        foreach ($datas as $data) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

            $headers = array();
            $headers[] = "Key: Value";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT:!DH');

            $result = json_decode(curl_exec($ch));
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
        }
        $total_sms = 0;

        if ($result->Status == 0) {
            foreach ($messages as $sms) {
                $tatal_sent = count(explode(',', $sms['toUser']));
                $message = $sms['messageContent'];
                $total_sms += $tatal_sent * $this->multipart_count($message);
            }
        }
        return $total_sms;
    }

    private function multipart_count($str)
    {
        $one_part_limit = 160; // use a constant i.e. GSM::SMS_SINGLE_7BIT
        $multi_limit = 153; // again, use a constant
        $max_parts = 6; // ... constant

        $str_length = $this->count_gsm_string($str);
        if ($str_length === -1) {
            $one_part_limit = 70; // ... constant
            $multi_limit = 67; // ... constant
            $str_length = $this->count_ucs2_string($str);
        }

        if ($str_length <= $one_part_limit) {
            // fits in one part
            return 1;
        } elseif ($str_length > ($max_parts * $multi_limit)) {
            // too long
            return -1; // or throw exception, or false, etc.
        } else {
            // divide the string length by multi_limit and round up to get number of parts
            return ceil($str_length / $multi_limit);
        }
    }

    private function count_gsm_string($str)
    {
        // Basic GSM character set (one 7-bit encoded char each)
        $gsm_7bit_basic = "@£$¥èéùìòÇ\nØø\rÅåΔ_ΦΓΛΩΠΨΣΘΞÆæßÉ !\"#¤%&'()*+,-./0123456789:;<=>?¡ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÑÜ§¿abcdefghijklmnopqrstuvwxyzäöñüà";

        // Extended set (requires escape code before character thus 2x7-bit encodings per)
        $gsm_7bit_extended = "^{}\\[~]|€";

        $len = 0;

        for ($i = 0; $i < mb_strlen($str); $i++) {
            $c = mb_substr($str, $i, 1);
            if (mb_strpos($gsm_7bit_basic, $c) !== FALSE) {
                $len++;
            } else if (mb_strpos($gsm_7bit_extended, $c) !== FALSE) {
                $len += 2;
            } else {
                return -1; // cannot be encoded as GSM, immediately return -1
            }
        }

        return $len;
    }

    private function count_ucs2_string($str)
    {
        $utf16str = mb_convert_encoding($str, 'UTF-16', 'UTF-8');
        // C* option gives an unsigned 16-bit integer representation of each byte
        // which option you choose doesn't actually matter as long as you get one value per byte
        $byteArray = unpack('C*', $utf16str);
        return count($byteArray) / 2;
    }

    protected function chk_bKash($queryStr, $args = array())
    {
        if (!empty($queryStr) && !empty($args['qType']) && in_array($args['qType'], array('trxid', 'reference', 'timestamp'))) {


            //====== D E B U G =======
            /* $response = $response = array('transaction'=>array(
              'amount' => 5, ///
              'counter' => 1,
              'currency' => 'BDT',
              'receiver' => '01720556561',
              'reference' => $args['ref'], ///
              'sender' => '01722856004',
              'service' => 'Payment',
              'trxId' => $queryStr,///
              'trxStatus' => '0000',
              'trxTimestamp' => date('Y-m-d H:i:s')
              ));
              return $this->array_to_object($response); */
            //==========================


            $urlPart = array(
                'trxid' => 'sendmsg',
                'reference' => 'refmsg',
                //'lastpollingtime'	=> 'periodicpullmsg', //GET Method
                'timestamp' => 'periodicpullmsg' //POST Method
            );
            /*
              $data = array(
              'user' => 'ESOFTARENA',
              'pass' => 'ad0b3tng0',
              'msisdn' => '01720556561',
              $args['qType'] => $queryStr //'513132201', ['trxid'||'reference']
              ); */

            $data = array(
                'user' => 'TECHPLEXUS',
                'pass' => 't3cH9L3Xu5247',
                'msisdn' => '01705806080',
                $args['qType'] => $queryStr //'513132201', ['trxid'||'reference']
            );

            //http://www.bkashcluster.com:9080/dreamwave/merchant/trxcheck/periodicpullmsg?user=ESOFTARENA&pass=ad0b3tng0&msisdn=01720556561&lastpollingtime=2013-11-20-2330

            $url = "https://www.bkashcluster.com:9081/dreamwave/merchant/trxcheck/" . $urlPart[$args['qType']];
            $content = json_encode($data);
            //echo '???????????'.$content;
            //return false;
            //http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
            //https://www.net24.co.nz/kb/article/AA-00246/

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            //curl_setopt($this->curlHandle, CURLOPT_USERPWD,"{$this->userName}:{$this->userPass}");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //while https !!!!!
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            //curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 100);
            //curl_setopt($curl, CURLOPT_TIMEOUT, 84600);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($content),
                'Connection: Keep-Alive', //Added Later
                'Keep-Alive: 30' //Added Later
            ));
            $json_response = curl_exec($curl);
            //echo '>>>>>>>>>>>>'.$json_response;


            /* // Check if any error occurred
              if( !curl_errno($curl) ){
              $info = curl_getinfo($curl);
              echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'];
              } */

            // Close handle
            curl_close($curl);

            if (!empty($json_response))
                return json_decode($json_response);

            //            if (!empty($json_response))
            ////                pr($json_response);die;
            //                $json_responseG = [
            //                  'transaction' => [
            //                    'trxStatus' => '4001',
            //                    'trxId' => 'AL493UJMXR',
            //                    'reference' => '93040896'
            //                  ]
            //                ];
            //
            //
            //            return $json_responseG;

            /* $response = array();
              $queryId = (int)$queryStr;
              switch($queryId){
              case 511132201:
              $response = array('transaction'=>array(
              'amount' => 5, ///
              'counter' => 1,
              'currency' => 'BDT',
              'receiver' => '01720556561',
              'reference' => 'DZ14B75392', ///
              'sender' => '01722856004',
              'service' => 'Payment',
              'trxId' => '513132201',///
              'trxStatus' => '0000',
              'trxTimestamp' => date('Y-m-d H:i:s')
              ));
              break;
              default:
              $response = array('transaction'=>array(
              'amount' => 5,
              'counter' => 1,
              'currency' => 'BDT',
              'receiver' => '01720556561',
              'reference' => $queryStr,
              'sender' => '01722856004',
              'service' => 'Payment',
              'trxId' => '513132201',
              'trxStatus' => '0000',
              'trxTimestamp' => date('Y-m-d H:i:s')
              ));
              break;
              }

              return $this->array_to_object($response); */
        }

        return false;

        /*
          stdClass Object(
          [transaction] => stdClass Object
          (
          [amount] => 5
          [counter] => 1
          [currency] => BDT
          [receiver] => 01720556561
          [reference] => DZSA140001
          [sender] => 01722856004
          [service] => Payment
          [trxId] => 513132201
          [trxStatus] => 0000
          [trxTimestamp] => 2013-11-10T18:29:55+06:00
          )
          ) */
    }

    protected function get_bKash_statusMSG($st)
    {
        $msg = '';
        switch ($st) {
            case '0000':
                $msg = 'trxID is valid and transaction is successful.'; //Transaction Successful.
                break;
            case '0010':
            case '0011':
                $msg = 'trxID is valid but transaction is in pending state. Transaction Pending.';
                break;
            case '0100':
                $msg = 'trxID is valid but transaction has been reversed. Transaction Reversed.';
                break;
            case '0111':
                $msg = 'trxID is valid but transaction has failed. Transaction Failure.';
                break;
            case '1001':
                $msg = 'Invalid MSISDN input. Try with correct mobile no. Format Error.';
                break;
            case '1002':
                $msg = 'Invalid trxID, it does not exist. Invalid Reference.';
                break;
            case '1003':
                $msg = 'Access denied. Username or Password is incorrect. Authorization Error.';
                break;
            case '1004':
                //$msg = 'Access denied. trxID is not related to this username. Authorization Error.';
                //$msg = 'বিকাশ সিস�?টেম আপডেট হতে কিছ�?টা সময় লাগতে পারে। আপনার Transaction ID verification �?র জন�?য দয়া করে �?কট�? পরে আবার চেষ�?টা কর�?ন।';
                $msg = 'Make sure that your TrxId is correct. Otherwise, your Admit Card is processing…. Please try after five minutes.';
                break;
            case '9999':
                $msg = 'Could not process request. System Error.';
            default:
                $msg = '--!!--';
                break;
        }

        return $msg;
    }
    public function get_levels($type = false)
    {
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        if (in_array($role_id, $roles) || $type == false) {
            $level = TableRegistry::getTableLocator()->get('scms_levels');
            $levels = $level
                ->find()
                ->toArray();
        } else {
            $id = $this->Auth->user('id');
            $active_session = $this->get_active_session();
            $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $permissions = $employees_permission->find()
                ->where(['user_id' => $id])
                ->where(['employees_permission.type' => $type])
                ->where(['employees_permission.session_id' => $active_session[0]['session_id']])
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
            $level_ids = array();
            foreach ($permissions as $permission) {
                $level_ids[$permission['level_id']] = $permission['level_id'];
            }
            if (count($level_ids)) {
                $level_ids = array_values($level_ids);
                $level = TableRegistry::getTableLocator()->get('scms_levels');
                $levels = $level
                    ->find()
                    ->where(['level_id IN' => $level_ids])
                    ->toArray();
            } else {
                $levels = array();
            }
        }
        return $levels;
    }

    public function get_sections($type = false, $level_id = false)
    {
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;
        $where = array();
        if ($level_id) {
            $where['level_id'] = $level_id;
        }
        if (in_array($role_id, $roles) || $type == false) {
            $section = TableRegistry::getTableLocator()->get('scms_sections');
            $sections = $section
                ->find()
                ->where($where)
                ->toArray();
        } else {
            $active_session = $this->get_active_session();
            $id = $this->Auth->user('id');
            $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $permissions = $employees_permission->find()
                ->where(['user_id' => $id])
                ->where(['employees_permission.type' => $type])
                ->where(['employees_permission.session_id' => $active_session[0]['session_id']])
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
                $section = TableRegistry::getTableLocator()->get('scms_sections');
                $sections = $section
                    ->find()
                    ->where(['section_id IN' => $section_ids])
                    ->toArray();
            } else {
                $sections = array();

            }
        }
        return $sections;
    }
    public function get_shifts($type = false)
    {
        $role_id = $this->Auth->user('role_id');
        $roles[] = 1;
        $roles[] = 2;

        if (in_array($role_id, $roles) || $type == false) {
            $shift = TableRegistry::getTableLocator()->get('hr_shift');
            $shifts = $shift
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->toArray();
        } else {
            $id = $this->Auth->user('id');
            $active_session = $this->get_active_session();
            $employees_permission = TableRegistry::getTableLocator()->get('employees_permission');
            $permissions = $employees_permission->find()
                ->where(['user_id' => $id])
                ->where(['employees_permission.type' => $type])
                ->where(['employees_permission.session_id' => $active_session[0]['session_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->select([
                    'shift_id' => 'scms_sections.shift_id',
                ])
                ->join([
                    'employee' => [
                        'table' => 'employee',
                        'type' => 'INNER',
                        'conditions' => [
                            'employee.employee_id = employees_permission.employee_id'
                        ]
                    ],
                    'scms_sections' => [
                        'table' => 'scms_sections',
                        'type' => 'INNER',
                        'conditions' => [
                            'scms_sections.section_id = employees_permission.section_id'
                        ]
                    ],
                ])
                ->toArray();
            $shift_ids = array();
            foreach ($permissions as $permission) {
                $shift_ids[$permission['shift_id']] = $permission['shift_id'];
            }
            if (count($shift_ids)) {
                $shift_ids = array_values($shift_ids);
                $shift = TableRegistry::getTableLocator()->get('hr_shift');
                $shifts = $shift
                    ->find()
                    ->where(['shift_id IN' => $shift_ids])
                    ->enableAutoFields(true)
                    ->enableHydration(false)
                    ->toArray();
            } else {
                $shifts = array();

            }
        }
        return $shifts;
    }
    public function get_active_session()
    {
        $scms_sessions = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $scms_sessions
            ->find()
            ->where(['active' => 1])
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        return $sessions;
    }
}
