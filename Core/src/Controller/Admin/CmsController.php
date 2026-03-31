<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class CmsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }



    public function boxes()
    {
        $box = TableRegistry::getTableLocator()->get('cms_boxes');
        $boxes = $box
            ->find()
            ->order(['CAST(box_order AS SIGNED)' => 'ASC'])
            ->select([
                'node_title' => 'N.title',
            ])
            ->join([
                'N' => [
                    'table' => 'nodes',
                    'type' => 'LEFT',
                    'conditions' => ['N.id = cms_boxes.node_page_id'],
                ],
            ])
            ->enableAutoFields(true)
            ->enableHydration(false);
        $paginate = $this->paginate($boxes, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('boxes', $paginate);
    }



    public function addBoxes()
    {

        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $file = $request_data['box_image'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);

            $thumbnailFileName = null;
            if (in_array($ext, $arr_ext)) {
                // Move uploaded file to original folder
                $originalFolderPath = WWW_ROOT . '/uploads/cms/boxes/original/'; // Specify original folder path
                if (!file_exists($originalFolderPath)) {
                    mkdir($originalFolderPath, 0777, true);
                }
                $originalImagePath = $originalFolderPath . $setNewFileName . '.' . $ext;
                move_uploaded_file($file['tmp_name'], $originalImagePath);

                // Open original image file
                $image = null;
                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'webp') {
                    $image = imagecreatefromjpeg($originalImagePath);
                } else if ($ext == 'png') {
                    $image = imagecreatefrompng($originalImagePath);
                }
                // Compress image and save thumbnail version
                if ($image) {
                    $thumbnailFolderPath = WWW_ROOT . '/uploads/cms/boxes/thumbnail/'; // Specify thumbnail folder path
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


            $request_data['box_image'] = $thumbnailFileName;
            $get_boxes = TableRegistry::getTableLocator()->get('cms_boxes');
            $query = $get_boxes->query();
            $query
                ->insert(['block_id','box_title', 'node_page_id', 'box_description', 'status', 'url', 'box_order', 'box_image'])
                ->values($request_data)
                ->execute();

            //Set Flash
            $this->Flash->success('Box Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'Boxes']);
        }
        $get_node_page = TableRegistry::getTableLocator()->get('nodes');
        $nodes = $get_node_page->find()->where(['type' => 'page'])->toArray();
        $this->set('nodes', $nodes);
        $get_blocks = TableRegistry::getTableLocator()->get('blocks');
        $blocks = $get_blocks->find()->toArray();
        $this->set('blocks', $blocks);
    }



    public function editBoxes($id)
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $file = $request_data['box_image'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);

            $thumbnailFileName = null;
            if (in_array($ext, $arr_ext)) {
                // Move uploaded file to original folder
                $originalFolderPath = WWW_ROOT . '/uploads/cms/boxes/original/'; // Specify original folder path
                if (!file_exists($originalFolderPath)) {
                    mkdir($originalFolderPath, 0777, true);
                }
                $originalImagePath = $originalFolderPath . $setNewFileName . '.' . $ext;
                move_uploaded_file($file['tmp_name'], $originalImagePath);

                // Open original image file
                $image = null;
                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'webp') {
                    $image = imagecreatefromjpeg($originalImagePath);
                } else if ($ext == 'png') {
                    $image = imagecreatefrompng($originalImagePath);
                }
                // Compress image and save thumbnail version
                if ($image) {
                    $thumbnailFolderPath = WWW_ROOT . '/uploads/cms/boxes/thumbnail/'; // Specify thumbnail folder path
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
            $request_data['box_image'] = $thumbnailFileName;
            if ($thumbnailFileName == null) {
                unset($request_data['box_image']);
            }

            $get_boxes = TableRegistry::getTableLocator()->get('cms_boxes');
            $query = $get_boxes->query();
            $query
                ->update()
                ->set($request_data)
                ->where(['id' => $id])
                ->execute();

            //Set Flash
            $this->Flash->info('Box Update Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'Boxes']);
        }
        $get_node_page = TableRegistry::getTableLocator()->get('nodes');
        $nodes = $get_node_page->find()->where(['type' => 'page'])->toArray();
        $this->set('nodes', $nodes);

        $get_blocks = TableRegistry::getTableLocator()->get('blocks');
        $blocks = $get_blocks->find()->toArray();
        $this->set('blocks', $blocks);

        $get_boxes = TableRegistry::getTableLocator()->get('cms_boxes'); //Execute First
        $boxes = $get_boxes
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['id' => $id])
            ->toArray();
        $this->set('boxes', $boxes[0]);
    }



    public function deleteBoxes($id)
    {
        $get_box = TableRegistry::getTableLocator()->get('cms_boxes'); //Execute First
        $query = $get_box->query();
        $query->delete()
            ->where(['id' => $id])
            ->execute();

        //Set Flash
        $this->Flash->error('Box Deleted Successfully', [
            'key' => 'positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'Boxes']);
    }



    public function pageConfig()
    {
        $get_config = TableRegistry::getTableLocator()->get('cms_page_config');
        $configs = $get_config
            ->find()
            ->select([
                'node_title' => 'N.title',
            ])
            ->join([
                'N' => [
                    'table' => 'nodes',
                    'type' => 'LEFT',
                    'conditions' => ['N.id = cms_page_config.node_page_id'],
                ],
            ])
            ->enableAutoFields(true)
            ->enableHydration(false);
        $paginate = $this->paginate($configs, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('configs', $paginate);
    }



    public function addPageConfig()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_boxes = TableRegistry::getTableLocator()->get('cms_page_config');
            $query = $get_boxes->query();
            $query
                ->insert(['config_title', 'node_page_id', 'box_per_row', 'box_height', 'box_position'])
                ->values($request_data)
                ->execute();

            //Set Flash
            $this->Flash->success('Configuration Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'pageConfig']);
        }
        $get_node_page = TableRegistry::getTableLocator()->get('nodes');
        $nodes = $get_node_page->find()->where(['type' => 'page'])->toArray();
        $this->set('nodes', $nodes);
    }


    public function editPageConfig($id)
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_boxes = TableRegistry::getTableLocator()->get('cms_page_config');
            $query = $get_boxes->query();
            $query
                ->update()
                ->set($request_data)
                ->where(['id' => $id])
                ->execute();

            //Set Flash
            $this->Flash->info('Configuration Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'pageConfig']);
        }
        $get_node_page = TableRegistry::getTableLocator()->get('nodes');
        $nodes = $get_node_page->find()->where(['type' => 'page'])->toArray();
        $this->set('nodes', $nodes);

        $get_config = TableRegistry::getTableLocator()->get('cms_page_config'); //Execute First
        $configs = $get_config
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['id' => $id])
            ->toArray();
        $this->set('configs', $configs[0]);
    }



    public function deletePageConfig($id)
    {
        $get_config = TableRegistry::getTableLocator()->get('cms_page_config'); //Execute First
        $query = $get_config->query();
        $query->delete()
            ->where(['id' => $id])
            ->execute();

        //Set Flash
        $this->Flash->error('Configuration Deleted Successfully', [
            'key' => 'positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'pageConfig']);
    }



    public function quickLink(){
        $get_button = TableRegistry::getTableLocator()->get('cms_quicklink');
        $buttons = $get_button
            ->find()
            ->enableAutoFields(true)
            ->order(['CAST(button_order AS SIGNED)' => 'ASC'])
            ->enableHydration(false);
        $paginate = $this->paginate($buttons, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('buttons', $paginate);
    }



    public function addQuickLink(){
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_button = TableRegistry::getTableLocator()->get('cms_quicklink');
            $query = $get_button->query();
            $query
                ->insert(['button_title', 'button_link', 'button_color', 'button_text_color', 'button_order'])
                ->values($request_data)
                ->execute();
            //Set Flash
            $this->Flash->success('Quick Link Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'quickLink']);
        }
        $get_button = TableRegistry::getTableLocator()->get('cms_quicklink');
        $buttons = $get_button
                ->find()
                ->count();
        $this->set('buttons', $buttons);//Get the Last Order ID of the button
    }



    public function editQuickLink($id){
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_button = TableRegistry::getTableLocator()->get('cms_quicklink');
            $query = $get_button->query();
            $query
                ->update()
                ->set($request_data)
                ->where(['id' => $id])
                ->execute();

            //Set Flash
            $this->Flash->info('Quick Link Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'quickLink']);
        }

        $get_buttons = TableRegistry::getTableLocator()->get('cms_quicklink'); //Execute First
        $button = $get_buttons
            ->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['id' => $id])
            ->toArray();
        $this->set('button', $button[0]);
    }



    public function deleteQuickLink($id){
        $get_button = TableRegistry::getTableLocator()->get('cms_quicklink');
        $query = $get_button->query();
        $query->delete()
            ->where(['id' => $id])
            ->execute();

        //Set Flash
        $this->Flash->error('Quick Link Deleted Successfully', [
            'key' => 'positive',
            'params' => [],
        ]);
        return $this->redirect(['action' => 'quickLink']);
    }
}
