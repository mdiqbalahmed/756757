<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class PhotosController extends AppController
{

      public function initialize()
      {
            parent::initialize();
      }

      public function index()
      {
      }

      public function viewPhotos()
      {
            $photo = TableRegistry::getTableLocator()->get('cms_photos');
            $photos = $photo->find()
                  ->enableAutoFields(true)
                  ->enableHydration(false)
                  ->order('cms_photos.photo_id ASC')
                  ->select(['album_title' => 'a.album_title'])
                  ->join([
                        'a' => [
                              'table' => 'cms_album',
                              'type' => 'LEFT',
                              'conditions' => ['a.album_id = cms_photos.album_id'],
                        ]
                  ]);
            $paginate = $this->paginate($photos, ['limit' => $this->Paginate_limit]);
            $paginate = $paginate->toArray();
            $this->set('photos', $paginate);

      }

      public function addPhotos()
      {
            if ($this->request->is('post')) {
                  $request_data = $this->request->getData();
                  $file = $request_data['large_version'];
                  $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                  $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
                  $setNewFileName = time() . "_" . rand(000000, 999999);

                  $thumbnailFileName = null;
                  $regularSizeFileName = null;
        

                  if (in_array($ext,
                        $arr_ext
                  )) {
                        // Move uploaded file to original folder
                        $originalFolderPath = WWW_ROOT . '/uploads/gallery/large_version/'; // Specify original folder path
                        if (!file_exists($originalFolderPath)) {
                              mkdir($originalFolderPath, 0777, true);
                        }
                        $originalImagePath = $originalFolderPath . $setNewFileName . '.' . $ext;
                        move_uploaded_file($file['tmp_name'], $originalImagePath);

                        // Open original image file
                        $image = null;
                        if ($ext == 'jpg' || $ext == 'jpeg') {
                              $image = imagecreatefromjpeg($originalImagePath);
                        } else if ($ext == 'png'
                        ) {
                              $image = imagecreatefrompng($originalImagePath);
                        }

                        // Compress image and save thumbnail version
                        if ($image) {
                              $thumbnailFolderPath = WWW_ROOT . '/uploads/gallery/thumbnail/'; // Specify thumbnail folder path
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
                              $regularSizeFolderPath = WWW_ROOT . '/uploads/gallery/regularSize/'; // Specify regularSize folder path
                              if (!file_exists($regularSizeFolderPath)) {
                                    mkdir($regularSizeFolderPath, 0777, true);
                              }
                              $regularSizeImagePath = $regularSizeFolderPath . $setNewFileName . '_rs.' . $ext;
                              $regularSizeWidth = 1920; //800 Change this value to adjust regularSize width
                              $regularSizeHeight = 1080; //450 Change this value to adjust regularSize height
                              $regularSizeImage = imagescale($image, $regularSizeWidth, $regularSizeHeight);
                              imagejpeg($regularSizeImage, $regularSizeImagePath, 100);
                              $regularSizeFileName = $setNewFileName . '_rs.' . $ext;
                              imagedestroy($regularSizeImage);
                        }
                        // Delete original image
                        unlink($originalImagePath);
                  }

                  $get_photo = TableRegistry::getTableLocator()->get('cms_photos');
                  $request_data['thumbnail'] = $thumbnailFileName;
                  $request_data['regular_size'] = $regularSizeFileName;

                  $query = $get_photo->query();
                  $query
                        ->insert(['album_id', 'photos_title', 'description','thumbnail', 'regular_size', 'url', 'target'])
                        ->values($request_data)
                        ->execute();

                  //Set Flash
                  $this->Flash->success('Photo Added Successfully', [
                        'key' => 'positive',
                        'params' => [],
                  ]);
                  return $this->redirect(['action' => 'viewPhotos']);
            }
            $get_album = TableRegistry::getTableLocator()->get('cms_album');
            $albums = $get_album->find()->toArray();
            $this->set('albums', $albums);
      }

      public function editPhotos($id)
      {
            if ($this->request->is(['post'])) {
                  $request_data = $this->request->getData();
                  $file = $request_data['large_version'];
                  $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                  $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
                  $setNewFileName = time() . "_" . rand(000000, 999999);

                  $thumbnailFileName = null;
                  $regularSizeFileName = null;


                  if (in_array(
                        $ext,
                        $arr_ext
                  )) {
                        // Move uploaded file to original folder
                        $originalFolderPath = WWW_ROOT . '/uploads/gallery/large_version/'; // Specify original folder path
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
                              $thumbnailFolderPath = WWW_ROOT . '/uploads/gallery/thumbnail/'; // Specify thumbnail folder path
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
                              $regularSizeFolderPath = WWW_ROOT . '/uploads/gallery/regularSize/'; // Specify regularSize folder path
                              if (!file_exists($regularSizeFolderPath)) {
                                    mkdir($regularSizeFolderPath, 0777, true);
                              }
                              $regularSizeImagePath = $regularSizeFolderPath . $setNewFileName . '_rs.' . $ext;
                              $regularSizeWidth = 1920; //800 Change this value to adjust regularSize width
                              $regularSizeHeight = 1080; //450 Change this value to adjust regularSize height
                              $regularSizeImage = imagescale($image, $regularSizeWidth, $regularSizeHeight);
                              imagejpeg($regularSizeImage, $regularSizeImagePath, 100);
                              $regularSizeFileName = $setNewFileName . '_rs.' . $ext;
                              imagedestroy($regularSizeImage);
                        }


                        // Delete original image
                        unlink($originalImagePath);
                  }

                  $get_photos = TableRegistry::getTableLocator()->get('cms_photos');
                  $request_data['thumbnail'] = $thumbnailFileName;
                  $request_data['regular_size'] = $regularSizeFileName;
                  unset($request_data['large_version']);
                  

                  $query = $get_photos->query();
                  $query
                        ->update()
                        ->set($request_data)
                        ->where(['photo_id' => $request_data['photo_id']])
                        ->execute();

                  //Set Flash
                  $this->Flash->info('Photo Updated Successfully', [
                        'key' => 'positive',
                        'params' => [],
                  ]);
                  return $this->redirect(['action' => 'viewPhotos']);
            }

            $album = TableRegistry::getTableLocator()->get('cms_album');
            $albums = $album->find()->toArray();
            $this->set('albums', $albums);

            $photo = TableRegistry::getTableLocator()->get('cms_photos');
            $photos = $photo->find()->where(['photo_id' => $id])->toArray();
            $this->set('photos', $photos[0]);

      }

      public function deletePhotos($id)
      {
            $get_photo = TableRegistry::getTableLocator()->get('cms_photos'); //Execute First
            $query = $get_photo->query();
            $query->delete()
            ->where(['photo_id' => $id])
            ->execute();

            //Set Flash
            $this->Flash->error('Photo Deleted Successfully', [
                  'key' => 'positive',
                  'params' => [],
            ]);
            return $this->redirect(['action' => 'viewPhotos']);
      }
}
