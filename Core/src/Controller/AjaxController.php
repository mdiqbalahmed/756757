<?php

namespace Croogo\Core\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Http\ResponseEmitter;
use Cake\Http\ServerRequest;
use Croogo\Core\Croogo;

use Cake\ORM\TableRegistry;

class AjaxController extends AppController
{
    public function initialize()
    {
        parent::initialize();
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

    public function getLevelSectionAjax()
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
                    'conditions' => ['cs.course_id = scms_courses.course_id'],
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
                    'conditions' => ['cs.course_id = scms_courses.course_id'],
                ],
            ])
            ->toArray();
        echo json_encode($courses_all);
    }
}
