<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class RoomsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }



    public function addRoomType()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();

            $get_room_type = TableRegistry::getTableLocator()->get('hostel_room_type');
            $query = $get_room_type->query();
            $query
                ->insert(['type'])
                ->values($request_data)
                ->execute();

            //Set Flash
            $this->Flash->success('Room Type Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'roomTypes']);
        }
    }

    public function roomTypes()
    {
        $data = TableRegistry::getTableLocator()->get('hostel_room_type');
        $room = $data->find();

        $paginate = $this->paginate($room, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('rooms_type', $paginate);
    }

    public function editRoomType($id)
    {
        if ($this->request->is(['post'])) {
            $get_room_type = TableRegistry::getTableLocator()->get('hostel_room_type');
            $query = $get_room_type->query();
            $query
                ->update()
                ->set($this->request->getData())
                ->where(['id' => $id])
                ->execute();

            //Set Flash
            $this->Flash->info('Room Type Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'roomTypes']);
        }
        $get_room_type = TableRegistry::getTableLocator()->get('hostel_room_type');
        $get_room_types = $get_room_type
            ->find()
            ->toArray();
        $this->set('get_room_types', $get_room_types);
    }

    public function addRoom()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $request_data['room_type_id'] = $request_data['type_id'];

            unset($request_data['type_id']);
            // pr($request_data);
            // die;
            $get_room = TableRegistry::getTableLocator()->get('hostel_rooms');
            $query = $get_room->query();
            $query
                ->insert(['building_id', 'hostel_id', 'room_type_id', 'room_number', 'seat'])
                ->values($request_data)
                ->execute();

            //Set Flash
            $this->Flash->success('Room Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'index']);
        }
        $get_building = TableRegistry::getTableLocator()->get('hostel_buildings');
        $get_buildings = $get_building
            ->find()
            ->toArray();
        $this->set('get_buildings', $get_buildings);
        $get_room_type = TableRegistry::getTableLocator()->get('hostel_room_type');
        $get_room_types = $get_room_type
            ->find()
            ->toArray();
        $this->set('get_room_types', $get_room_types);
    }

    public function editRoom($id)
    {
        if ($this->request->is(['post'])) {
            $get_room = TableRegistry::getTableLocator()->get('hostel_rooms');
            $query = $get_room->query();
            $query
                ->update()
                ->set($this->request->getData())
                ->where(['id' => $id])
                ->execute();

            //Set Flash
            $this->Flash->info('Room Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'index']);
        }
        $get_building = TableRegistry::getTableLocator()->get('hostel_buildings');
        $get_buildings = $get_building
            ->find()
            ->toArray();
        $this->set('get_buildings', $get_buildings);

        $request_data = TableRegistry::getTableLocator()->get('hostel_rooms'); //Execute First
        $get_room = $request_data
            ->find()
            ->where(['id' => $id])
            ->toArray();
        // pr($get_room);die;
        $this->set('get_room', $get_room);
        $get_room_type = TableRegistry::getTableLocator()->get('hostel_room_type');
        $get_room_types = $get_room_type
            ->find()
            ->toArray();
        $this->set('get_room_types', $get_room_types);
    }

    public function deleteRoom($id)
    {
        if ($this->request->is(['post'])) {
            $get_rooms = TableRegistry::getTableLocator()->get('hostel_rooms');
            $query = $get_rooms->query();
            $query
                ->delete()
                ->where(['id' => $id])
                ->execute();
            //Set Flash
            $this->Flash->error('Room Deleted Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'index']);
        }

        $request_data = TableRegistry::getTableLocator()->get('hostel_rooms'); //Execute First
        $get_rooms = $request_data
            ->find()
            ->where(['id' => $id])
            ->toArray();
        $this->set('get_rooms', $get_rooms);
    }


    public function index()
    {
        $data = TableRegistry::getTableLocator()->get('hostel_rooms');
        $room = $data->find()
            ->select([
                'building_name' => 'b.name',
                'id' => 'hostel_rooms.id',
                'room_number' => 'hostel_rooms.room_number',
                'seat' => 'hostel_rooms.seat',
                'status' => 'hostel_rooms.status',
                'extra' => 'hostel_rooms.extra',
            ])
            ->join([
                'b' => [
                    'table' => 'hostel_buildings',
                    'type' => 'LEFT',
                    'conditions' => [
                        'b.id  = hostel_rooms.building_id',
                    ],
                ],
            ]);
        $paginate = $this->paginate($room, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('rooms', $paginate);
    }
}
