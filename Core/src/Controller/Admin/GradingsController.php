<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class GradingsController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function index() {
        $grading = TableRegistry::getTableLocator()->get('scms_gradings');
        $gradings = $grading
          ->find();
        $paginate = $this->paginate($gradings, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('gradings', $paginate);
    }

    public function edit($id) {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $grading_data['gradings_system_name'] = $data['gradings_system_name'];
            $grading = TableRegistry::getTableLocator()->get('scms_gradings');
            $query = $grading->query();
            $query
              ->update()
              ->set($grading_data)
              ->where(['gradings_id' => $id])
              ->execute();
            foreach ($data['grade_id'] as $key => $grade_id) {
                $grade_data['gradings_id'] = $id;
                $grade_data['grade_name'] = $data['grade_name'][$key];
                $grade_data['point'] = $data['point'][$key];
                $grade_data['percentage_down'] = $data['percentage_down'][$key];
                $grade_data['percentage_top'] = $data['percentage_top'][$key];
                $grade = TableRegistry::getTableLocator()->get('scms_grade');
                if ($grade_id) {
                    $query = $grade->query();
                    $query
                      ->update()
                      ->set($grade_data)
                      ->where(['grade_id' => $grade_id])
                      ->execute();
                } else {
                    $query = $grade->query();
                    $query
                      ->insert(['gradings_id', 'grade_name', 'point', 'percentage_down', 'percentage_top'])
                      ->values($grade_data)
                      ->execute();
                }
            }
            //Set Flash
            $this->Flash->success('Grade Add/Edit Successfully Done', [
              'key' => 'positive',
              'params' => [],
            ]);
            return $this->redirect(['action' => 'index']);
        }
        $grading = TableRegistry::getTableLocator()->get('scms_gradings');
        $gradings = $grading
          ->find()
          ->where(['gradings_id' => $id])
          ->toArray();
        $this->set('gradings', $gradings);
        $grade = TableRegistry::getTableLocator()->get('scms_grade');
        $grades = $grade
          ->find()
          ->order(['point' => 'ASC'])
          ->where(['gradings_id' => $id])
          ->toArray();
        $this->set('grades', $grades);
    }

    public function add() {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $grading = TableRegistry::getTableLocator()->get('scms_gradings');
            $query = $grading->query();
            $query
              ->insert(['gradings_system_name'])
              ->values($data)
              ->execute();
            //Set Flash
            $this->Flash->success('Grading System Added Successfully', [
              'key' => 'positive',
              'params' => [],
            ]);
            return $this->redirect(['action' => 'index']);
        }
    }

    public function search() {
        
    }

    public function promote() {
        
    }

}
