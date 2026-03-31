<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class BuildingsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }


    public function addHostel()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();

            $get_building = TableRegistry::getTableLocator()->get('hostel_hostels');
            $query = $get_building->query();
            $query
                ->insert(['hostel_name'])
                ->values($request_data)
                ->execute();

            //Set Flash
            $this->Flash->success('Hostel Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'index']);
        }
    }

    public function hostels()
    {
        $data = TableRegistry::getTableLocator()->get('hostel_hostels');
        $hostels = $data->find();


        $paginate = $this->paginate($hostels, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        // pr($paginate);die;
        $this->set('hostels', $paginate);
    }

    public function editHostel($id)
    {
        if ($this->request->is(['post'])) {
            $get_building = TableRegistry::getTableLocator()->get('hostel_hostels');
            $query = $get_building->query();
            $query
                ->update()
                ->set($this->request->getData())
                ->where(['id' => $id])
                ->execute();

            //Set Flash
            $this->Flash->info('Hostel Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'hostels']);
        }

        $request_data = TableRegistry::getTableLocator()->get('hostel_hostels'); //Execute First
        $get_hostels = $request_data
            ->find()
            ->where(['id' => $id])
            ->toArray();
        $this->set('get_hostels', $get_hostels);
    }

    public function addBuilding()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            // pr($request_data);die;

            $get_building = TableRegistry::getTableLocator()->get('hostel_buildings');
            $query = $get_building->query();
            $query
                ->insert(['name', 'hostel_id', 'description'])
                ->values($request_data)
                ->execute();

            //Set Flash
            $this->Flash->success('Building Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'index']);
        }
        $hostel = TableRegistry::getTableLocator()->get('hostel_hostels');
        $hostels = $hostel
            ->find()
            ->toArray();
        $this->set('hostels', $hostels);
    }

    public function editBuilding($id)
    {
        if ($this->request->is(['post'])) {
            $get_building = TableRegistry::getTableLocator()->get('hostel_buildings');
            $query = $get_building->query();
            $query
                ->update()
                ->set($this->request->getData())
                ->where(['id' => $id])
                ->execute();

            //Set Flash
            $this->Flash->info('Building Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'index']);
        }

        $request_data = TableRegistry::getTableLocator()->get('hostel_buildings'); //Execute First
        $get_building = $request_data
            ->find()
            ->where(['id' => $id])
            ->toArray();
        $this->set('get_building', $get_building);
    }

    public function deleteBuilding($id)
    {
        if ($this->request->is(['post'])) {
            $get_buildings = TableRegistry::getTableLocator()->get('hostel_buildings');
            $query = $get_buildings->query();
            $query
                ->delete()
                ->where(['id' => $id])
                ->execute();
            //Set Flash
            $this->Flash->error('Building Deleted Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'index']);
        }

        $request_data = TableRegistry::getTableLocator()->get('hostel_buildings'); //Execute First
        $get_buildings = $request_data
            ->find()
            ->where(['id' => $id])
            ->toArray();
        $this->set('get_buildings', $get_buildings);
    }


    public function index()
    {
        $data = TableRegistry::getTableLocator()->get('hostel_buildings');
        $building = $data->find()
            ->select([
                'id' => "hostel_buildings.id",
                'hostel_name' => "h.hostel_name",
                'building_name' => "hostel_buildings.name",
                'description' => "hostel_buildings.description",
            ])
            ->join([
                'h' => [
                    'table' => 'hostel_hostels',
                    'type' => 'INNER',
                    'conditions' => [
                        'h.id = hostel_buildings.hostel_id'
                    ]
                ],
            ]);


        $paginate = $this->paginate($building, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('buildings', $paginate);
    }



    public function report()
    {
        $this->set('title_for_layout', __('Report By Building'));

        $building = TableRegistry::getTableLocator()->get('hostel_buildings');
        $get_buildings = $building
            ->find()
            // ->enableAutoFields(true)
            ->enableHydration(false)
            ->toArray();
        // pr($get_buildings);die;

        $this->set('buildingList', $get_buildings);
        if (!empty($this->request->data)) {
            $building_id = $this->request->data['building_id'];
            // $room_id = $this->request->data['room_id'];
            $where = [];
            if ($building_id) {
                $where['hostel_allotements.building_id'] = $building_id;
                // $where['hostel_allotements.room_id'] = $room_id;
            }
            $room = TableRegistry::getTableLocator()->get('hostel_allotements');
            $get_rooms = $room
                ->find()
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->where($where)
                // ->group('s.student_id')
                ->select([
                    'building_name' => "b.name",
                    'room_name' => "r.room_number",
                    // 'student_name' => "s.name",
                    'status' => "r.status",
                    'seat' => "r.seat",
                    'extra' => "r.extra"
                ])
                ->join([
                    'b' => [
                        'table' => 'hostel_buildings',
                        'type' => 'INNER',
                        'conditions' => [
                            'b.id = hostel_allotements.building_id'
                        ]
                    ],
                    'r' => [
                        'table' => 'hostel_rooms',
                        'type' => 'INNER',
                        'conditions' => [
                            'r.id = hostel_allotements.room_id'
                        ]
                    ],
                    // 's' => [
                    //     'table' => 'scms_students',
                    //     'type' => 'INNER',
                    //     'conditions' => [
                    //         's.sid = hostel_allotements.std_id'
                    //     ]
                    // ],
                ])->toArray();
            // echo '<pre>';
            // print_r($get_rooms);
            // die;
            foreach ($get_rooms as $rminfo) {
                // echo '<pre>';
                // print_r($rminfo);
                $building_id = $rminfo['building_id'];
                $room_name = $rminfo['room_name'];

                if (!isset($rm[$building_id])) {
                    $rm[$building_id] = ['Room' => []];
                }

                if (!isset($rm[$building_id]['Room'][$room_name])) {
                    $rm[$building_id]['Room'][$room_name] = [];
                }

                $rm[$building_id]['Room'][$room_name][] = $rminfo;
            }



            // echo '<pre>';
            // print_r($rm);
            // die;
            $this->set('get_rooms', $rm);
            $this->render('/reports/allotement_report');
        }
    }
}
