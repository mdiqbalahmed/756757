<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class AlbumController extends AppController
{

      public function initialize()
      {
            parent::initialize();
      }

      public function index()
      {

      }


      public function viewAlbum()
      {
            $album = TableRegistry::getTableLocator()->get('cms_album');
            $albums = $album->find()->enableAutoFields(true)->enableHydration(false);
            $paginate = $this->paginate($albums, ['limit' => $this->Paginate_limit]);
            $paginate = $paginate->toArray();
            $this->set('albums', $paginate);
      }


      public function addAlbum()
      {
            if ($this->request->is('post')) {
                  $request_data = $this->request->getData();
                  $file = $request_data['thumbnail'];
                  $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                  $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
                  $setNewFileName = time() . "_" . rand(000000, 999999);

                  $thumbnailFileName = null;
                  if (in_array($ext,$arr_ext)) {
                        // Move uploaded file to original folder
                        $originalFolderPath = WWW_ROOT . '/uploads/gallery/album/large_version/'; // Specify original folder path
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
                              $thumbnailFolderPath = WWW_ROOT . '/uploads/gallery/album/thumbnail/'; // Specify thumbnail folder path
                              if (!file_exists($thumbnailFolderPath)) {
                                    mkdir($thumbnailFolderPath, 0777, true);
                              }
                              $thumbnailImagePath = $thumbnailFolderPath . $setNewFileName . '_th.' . $ext;
                              $thumbnailWidth = 400; // Change this value to adjust thumbnail width
                              $thumbnailHeight = 225; // Change this value to adjust thumbnail height
                              $thumbnailImage = imagescale($image, $thumbnailWidth, $thumbnailHeight);
                              imagejpeg($thumbnailImage, $thumbnailImagePath, 50);
                              $thumbnailFileName = $setNewFileName . '_th.' . $ext;
                              imagedestroy($thumbnailImage);
                        }
                        // Delete original image
                        unlink($originalImagePath);
                  }
                  
                  $get_album = TableRegistry::getTableLocator()->get('cms_album');
                  $request_data['thumbnail'] = $thumbnailFileName;
                  $query = $get_album->query();
                  $query
                        ->insert([ 'album_title', 'album_location', 'slug', 'description', 'album_position', 'params', 'status', 'thumbnail'])
                        ->values($request_data)
                        ->execute();

                  //Set Flash
                  $this->Flash->success('Album Added Successfully', [
                        'key' => 'positive',
                        'params' => [],
                  ]);
                  return $this->redirect(['action' => 'viewAlbum']);

            }
            $get_album = TableRegistry::getTableLocator()->get('cms_album');
            $albums = $get_album->find()->toArray();
            $this->set('albums', $albums);
      }


      public function editAlbum($id)
      {
            if ($this->request->is(['post'])) {
                  $request_data = $this->request->getData();
                  $file = $request_data['thumbnail'];
                  $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                  $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
                  $setNewFileName = time() . "_" . rand(000000, 999999);

                  $thumbnailFileName = null;
                  if (in_array(
                        $ext,
                        $arr_ext
                  )) {
                        // Move uploaded file to original folder
                        $originalFolderPath = WWW_ROOT . '/uploads/gallery/album/large_version/'; // Specify original folder path
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
                              $thumbnailFolderPath = WWW_ROOT . '/uploads/gallery/album/thumbnail/'; // Specify thumbnail folder path
                              if (!file_exists($thumbnailFolderPath)) {
                                    mkdir($thumbnailFolderPath, 0777, true);
                              }
                              $thumbnailImagePath = $thumbnailFolderPath . $setNewFileName . '_th.' . $ext;
                              $thumbnailWidth = 400; // Change this value to adjust thumbnail width
                              $thumbnailHeight = 225; // Change this value to adjust thumbnail height
                              $thumbnailImage = imagescale($image, $thumbnailWidth, $thumbnailHeight);
                              imagejpeg($thumbnailImage, $thumbnailImagePath, 50);
                              $thumbnailFileName = $setNewFileName . '_th.' . $ext;
                              imagedestroy($thumbnailImage);
                        }
                        // Delete original image
                        unlink($originalImagePath);
                  }


                  $get_album = TableRegistry::getTableLocator()->get('cms_album');
                  $request_data['thumbnail'] = $thumbnailFileName;
                  $query = $get_album->query();
                  $query
                        ->update()
                        ->set($request_data)
                        ->where(['album_id' => $id])
                        ->execute();
                  //Set Flash
                  $this->Flash->info('Album Updated Successfully', [
                        'key' => 'positive',
                        'params' => [],
                  ]);
                  return $this->redirect(['action' => 'viewAlbum']);
            }
            $get_album = TableRegistry::getTableLocator()->get('cms_album'); //Execute First
            $albums = $get_album
                  ->find()
                  ->enableAutoFields(true)
                  ->enableHydration(false)
                  ->where(['album_id' => $id])
                  ->toArray();
            $this->set('albums', $albums[0]);
      }


      public function deleteAlbum($id)
      {
            $get_album= TableRegistry::getTableLocator()->get('cms_album'); //Execute First
            $query = $get_album->query();
            $query->delete()
                  ->where(['album_id' => $id])
                  ->execute();

            //Set Flash
            $this->Flash->error('Album Deleted Successfully', [
                  'key' => 'positive',
                  'params' => [],
            ]);
            return $this->redirect(['action' => 'viewAlbum']);
      }
}
