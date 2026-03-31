<?php

namespace Croogo\Core\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Http\ResponseEmitter;
use Cake\Http\ServerRequest;
use Croogo\Core\Croogo;

use Cake\ORM\TableRegistry;


class GalleryController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function gallery()
    {
        $albumsTable = TableRegistry::getTableLocator()->get('cms_album');
        $albums = $albumsTable->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('albums', $albums);

        // WILL WORK LATER FOR THE COUNT AS CHALLANGE
        $get_photos = TableRegistry::getTableLocator()->get('cms_photos'); //Execute First
        $photos = $get_photos->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        $this->set('photos', $photos);


        $count = count($photos);
        $this->set('count', $count);
    }



    public function viewPhotos($id)
    {
        $get_photos = TableRegistry::getTableLocator()->get('cms_photos'); //Execute First
        $photos = $get_photos->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->order('cms_photos.photo_id ASC')
            ->select(['album_title' => 'ap.album_title', 'description' => 'ap.description'])
            ->join([
                'ap' => [
                    'table' => 'cms_album',
                    'type' => 'LEFT',
                    'conditions' => ['ap.album_id = cms_photos.album_id'],
                ]
            ])
            ->where(['cms_photos.album_id' => $id])
            ->toArray();
        $this->set('photos', $photos);
    }
}
