<?php

namespace Croogo\Core\Controller\Admin;

use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
I18n::setLocale('jp_JP');

class StaffsController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function index() {
        $staff = TableRegistry::getTableLocator()->get('scms_staffs');
        $staffs = $staff
          ->find();
        $paginate = $this->paginate($staffs, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('staffs', $paginate);
    }

    public function edit($id) {
        $staffs = $this->Staffs->get($id);
        $this->set('staffs', $staffs);

        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $staff = TableRegistry::getTableLocator()->get('scms_staffs');
            $query = $staff->query();
            $query->update()
              ->set($this->request->getData())
              ->where(['staff_id' => $data['staff_id']])
              ->execute();
            return $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id) {
        
    }

    public function search() {
        
    }

    public function promote() {
        
    }

}
