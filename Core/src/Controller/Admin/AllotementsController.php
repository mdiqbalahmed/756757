<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class AllotementsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }


    public function add()
    {

        $session = TableRegistry::getTableLocator()->get('scms_sessions');
        $sessions = $session
            ->find()
            ->where(['session_name' => date('Y')])
            ->toArray();

        $allotement = TableRegistry::getTableLocator()->get('scms_student_cycle');
        $allotements = $allotement->find()
            ->where(['scms_student_cycle.resedential IS NULL '])
            ->Where(['scms_student_cycle.seat <> ' => 1])
            ->where(['scms_student_cycle.session_id' => $sessions[0]['session_id']])
            ->enableHydration(false)
            ->select([
                'id' => "scms_student_cycle.student_cycle_id",
                'name' => "s.name",
                'sid' => "s.sid",
                'level_id' => "scms_student_cycle.level_id",
                'section_id' => "scms_student_cycle.section_id",
                'roll' => "scms_student_cycle.roll"

            ])
            ->join([
                's' => [
                    'table' => 'scms_students',
                    'type' => 'INNER',
                    'conditions' => [
                        's.student_id = scms_student_cycle.student_id',
                        's.session_id = scms_student_cycle.session_id',
                    ]
                ],
            ])
            ->toArray();
        // pr($allotements);
        // die;
        $this->set('stdInfos', $allotements);

        $rooms = TableRegistry::getTableLocator()->get('hostel_rooms');
        $roominfos = $rooms->find()
            ->enableHydration(false)
            ->select([
                'id' => "hostel_rooms.id",
                'building_id' => "hostel_rooms.building_id",
                'room_number' => "hostel_rooms.room_number",
                'seat' => "hostel_rooms.seat",
                'extra' => "hostel_rooms.extra",
                'status' => "hostel_rooms.status",
                'building_name' => "hb.name",

            ])
            ->join([
                'hb' => [
                    'table' => 'hostel_buildings',
                    'type' => 'INNER',
                    'conditions' => [
                        'hb.id = hostel_rooms.building_id',
                    ]
                ],
            ])
            ->toArray();
        $validRoomInfos = [];
        // pr($roominfos);
        // die;
        $this->set('validRoomInfos', $roominfos);
    }




    public function index()
    {
        $hostel_allotement = TableRegistry::getTableLocator()->get('hostel_allotements');
        $hostel_allotements = $hostel_allotement->find()
            ->select([
                'id' => 'hostel_allotements.id',
                'name' => 's.name',
                'sid' => 's.sid',
                'level_id' => 's.level_id',
                'room' => 'r.room_number',
                'building_name' => 'b.name',
                'seat' => "sc.seat",
                // 'date' => 'hostel_payments.date',
            ])
            ->join([
                's' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => [
                        's.sid  = hostel_allotements.std_id',
                    ],
                ],
                'sc' => [
                    'table' => 'scms_student_cycle',
                    'type' => 'LEFT',
                    'conditions' => [
                        'sc.student_id  = s.student_id',
                    ],
                ],
                'b' => [
                    'table' => 'hostel_buildings',
                    'type' => 'LEFT',
                    'conditions' => [
                        'b.id  = hostel_allotements.building_id',
                    ],
                ],
                'r' => [
                    'table' => 'hostel_rooms',
                    'type' => 'LEFT',
                    'conditions' => [
                        'r.id  = hostel_allotements.room_id',
                    ],
                ],
            ])
            ->order(['id' => 'ASC']);

        $paginate = $this->paginate($hostel_allotements, [
            'limit' => $this->Paginate_limit, 'order' => ['id' => 'DESC']
        ]);
        $paginate = $paginate->toArray();
        // pr($paginate);
        // die;
        $this->set('hostel_allotements', $paginate);
    }
}
