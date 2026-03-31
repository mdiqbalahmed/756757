<?php

namespace Croogo\Core\Controller\Admin;

use Cake\Chronos\Date;
use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

I18n::setLocale('jp_JP');

class LibraryController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
    }

    public function books()
    {
        $get_book = TableRegistry::getTableLocator()->get('lms_books');
        $get_books = $get_book->find();
        $paginate = $this->paginate($get_books, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('books', $paginate);
    }

    public function addBooks()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $file = $request_data['book_image'];
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png', 'jfif', 'gif', 'bmp', 'svg'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);
            $imageFileName = null;
            if (in_array($ext, $arr_ext)) {
                move_uploaded_file($file['tmp_name'], WWW_ROOT . '/uploads/Library/book_images/' . $setNewFileName . '.' . $ext);
                $imageFileName = $setNewFileName . '.' . $ext;
                // echo "<pre>";
                // print_r($request_data);
                // die;
            }
            $id = $this->Auth->user('id');
            $request_data['user_id'] = $id;
            $request_data['book_image'] = $imageFileName;
            $get_books = TableRegistry::getTableLocator()->get('lms_books');
            $query = $get_books->query();
            $query
                ->insert(['book_name', 'copy_number', 'genre', 'author', 'edition', 'publication_year', 'book_price', 'book_image'])
                ->values($request_data)
                ->execute();
            //Set Flash
            $this->Flash->success('Books Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'books']);
        }
    }

    public function editBooks($id)
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $get_books = TableRegistry::getTableLocator()->get('lms_books');
            $query = $get_books->query();
            $query
                ->update()
                ->set($this->request->getData())
                ->where(['book_id' => $data['book_id']])
                ->execute();

            //Set Flash
            $this->Flash->info('Session Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'books']);
        }
        $book = TableRegistry::getTableLocator()->get('lms_books'); //Execute First

        $books = $book
            ->find()
            ->where(['book_id' => $id])
            ->toArray();
        $this->set('books', $books[0]);
    }

    public function allIssues()
    {
        $get_issue = TableRegistry::getTableLocator()->get('lms_book_issue');
        $get_issues = $get_issue
            ->find()
            ->enableAutoFields(true)
            // ->enableHydration(false)
            ->order('lms_book_issue.issue_id ASC')
            ->select([
                'issue_id' => 'lms_book_issue.issue_id',
                'book_name' => 'b.book_name',
                'copies' => 'b.copy_number',
                'member_type' => 'm.member_type',
                'issue_to_student' => 's.name',
                'issue_to_employee' => 'u.name', //This will be in condition if
            ])
            ->join([
                'b' => [
                    'table' => 'lms_books',
                    'type' => 'LEFT',
                    'conditions' => ['b.book_id = lms_book_issue.book_id'],
                ],
                'm' => [
                    'table' => 'lms_members',
                    'type' => 'LEFT',
                    'conditions' => ['m.member_id = lms_book_issue.member_id'],
                ],
                's' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => ['s.student_id = m.student_id'],
                ],
                'e' => [
                    'table' => 'employee',
                    'type' => 'LEFT',
                    'conditions' => ['e.employee_id = m.employee_id'],
                ],
                'u' => [
                    'table' => 'users',
                    'type' => 'LEFT',
                    'conditions' => ['u.id = e.user_id'],
                ],
            ]);

        $paginate = $this->paginate($get_issues, ['limit' => $this->Paginate_limit]);
        $paginate = $paginate->toArray();
        $this->set('issues', $paginate);
    }

    public function issueBooks()
    {
        $get_book = TableRegistry::getTableLocator()->get('lms_books');
        $books = $get_book->find()->toArray();
        $this->set('books', $books);

        if ($this->request->is('post')) {
            $request_data = $this->request->getData();

            $get_books = TableRegistry::getTableLocator()->get('lms_book_issue');
            $query = $get_books->query();
            $query
                ->insert(['book_id', 'member_id', 'issue_date', 'deadline', 'status'])
                ->values($request_data)
                ->execute();

            $book = TableRegistry::getTableLocator()->get('lms_books');
            $books = $book->find()->where(['book_id' => $request_data['book_id']])->toArray();

            $data['copy_number'] = $books[0]['copy_number'] - 1;
            $query = $book->query();
            $query
                ->update()
                ->set($data)
                ->where(['book_id' => $request_data['book_id']])
                ->execute();

            $this->Flash->success('Books Issued Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'allIssues']);
        }

        $get_member = TableRegistry::getTableLocator()->get('lms_members');
        $members = $get_member->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'issue_to_student' => 's.name',
                'issue_to_employee' => 'e.name', //This will be in condition if
            ])
            ->join([
                's' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => ['s.student_id = lms_members.student_id'],
                ],
                'e' => [
                    'table' => 'employee',
                    'type' => 'LEFT',
                    'conditions' => ['e.employee_id = lms_members.employee_id'],
                ],
            ])
            ->toArray();
        foreach ($members as $key => $member) {
            $result[$key]['member_id'] = $member['member_id'];
            if ($member['issue_to_student']) {
                $result[$key]['name'] = $member['issue_to_student'];
            } else {
                $result[$key]['name'] = $member['issue_to_employee'];
            }
        }
        $this->set('members', $result);
    }

    public function editIssue($id)
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $get_issues = TableRegistry::getTableLocator()->get('lms_book_issue');
            $query = $get_issues->query();
            $query
                ->update()
                ->set($this->request->getData())
                ->where(['issue_id' => $request_data['issue_id']])
                ->execute();
            $book = TableRegistry::getTableLocator()->get('lms_books');
            $books = $book->find()->where(['book_id' => $request_data['book_id']])->toArray();

            $data['copy_number'] = $books[0]['copy_number'] - 1;
            $query = $book->query();
            $query
                ->update()
                ->set($data)
                ->where(['book_id' => $request_data['book_id']])
                ->execute();

            //Set Flash
            $this->Flash->info('Issue Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'allIssues']);
        }

        $issue = TableRegistry::getTableLocator()->get('lms_book_issue'); //Execute First
        $issues = $issue
            ->find()
            ->where(['issue_id' => $id])
            ->toArray();
        $this->set('issues', $issues[0]);

        $book = TableRegistry::getTableLocator()->get('lms_books'); //Execute First
        $books = $book->find()->toArray();
        $this->set('books', $books);

        $get_member = TableRegistry::getTableLocator()->get('lms_members');
        $members = $get_member->find()->toArray();
        $this->set('members', $members);
    }

    public function members()
    {
        $get_member = TableRegistry::getTableLocator()->get('lms_members');
        $get_members = $get_member
            ->find()
            ->enableAutoFields(true)
            ->order('lms_members.member_id ASC')
            ->select([
                'member_id' => 'lms_members.member_id',
                'member_type_title' => 'mt.member_type_title',
                'member_as_student' => 's.name',
                'member_as_employee' => 'e.name', //This will be in condition if
            ])
            ->join([
                'mt' => [
                    'table' => 'lms_member_type',
                    'type' => 'LEFT',
                    'conditions' => ['mt.member_type_id = lms_members.member_type'],
                ],
                's' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => ['s.student_id = lms_members.student_id'],
                ],
                'e' => [
                    'table' => 'employee',
                    'type' => 'LEFT',
                    'conditions' => ['e.employee_id = lms_members.employee_id'],
                ],
            ]);

        $paginate = $this->paginate($get_members, ['limit' => $this->Paginate_limit]);
        $members = $paginate->toArray();
        $this->set('members', $members);
    }

    public function addMember()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $student_entry['member_type'] = $request_data['member_type'];
            $student_entry['student_id'] = $request_data['student_id'];

            $employee_entry['member_type'] = $request_data['member_type'];
            $employee_entry['employee_id'] = $request_data['employee_id'];

            $get_books = TableRegistry::getTableLocator()->get('lms_members');
            $query = $get_books->query();

            if ($request_data['member_type'] == '1') {
                $query
                    ->insert(array_keys($student_entry))
                    ->values($student_entry)
                    ->execute();
            } else if ($request_data['member_type'] == '2') {
                $query
                    ->insert(array_keys($employee_entry))
                    ->values($employee_entry)
                    ->execute();
            }


            $this->Flash->success('Member Added Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'members']);
        }
        $member_type = TableRegistry::getTableLocator()->get('lms_member_type');
        $member_types = $member_type->find()->toArray();
        $this->set('member_types', $member_types);

        $get_student = TableRegistry::getTableLocator()->get('scms_students');
        $get_students = $get_student->find()->toArray();
        $this->set('students', $get_students);

        $get_employee = TableRegistry::getTableLocator()->get('employee');
        $get_employees = $get_employee->find()->toArray();
        $this->set('employees', $get_employees);
    }

    public function editMember($id)
    {
        if ($this->request->is(['post'])) {
            $request_data = $this->request->getData();
            $get_members = TableRegistry::getTableLocator()->get('lms_members');
            $query = $get_members->query();
            $query
                ->update()
                ->set($this->request->getData())
                ->where(['member_id' => $request_data['member_id']])
                ->execute();

            $this->Flash->info('Member Updated Successfully', [
                'key' => 'positive',
                'params' => [],
            ]);
            return $this->redirect(['action' => 'members']);
        }
        $member_type = TableRegistry::getTableLocator()->get('lms_member_type');
        $member_types = $member_type->find()->toArray();
        $this->set('member_types', $member_types);

        $get_member = TableRegistry::getTableLocator()->get('lms_members');
        $members = $get_member->find()->where(['member_id' => $id])->toArray();
        $this->set('members', $members[0]);

        $student = TableRegistry::getTableLocator()->get('scms_students'); //Execute First
        $students = $student->find()->toArray();
        $this->set('students', $students);

        $employee = TableRegistry::getTableLocator()->get('employee'); //Execute First
        $employees = $employee->find()->toArray();
        $this->set('employees', $employees);
    }

    public function returnAction($id)
    {
        $this->autoRender = false;
        $array['return_date'] = Date('Y-m-d');
        $array['status'] = 0;

        $return_book = TableRegistry::getTableLocator()->get('lms_book_issue');
        $query = $return_book->query();
        $query
            ->update()
            ->set($array)
            ->where(['issue_id' => $id])
            ->execute();
        $book = TableRegistry::getTableLocator()->get('lms_book_issue');
        $books = $book->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['issue_id' => $id])
            ->select([
                'b_book_id' => 'b.book_id',
                'copy_number' => 'b.copy_number'
            ])
            ->join([
                'b' => [
                    'table' => 'lms_books',
                    'type' => 'LEFT',
                    'conditions' => ['b.book_id = lms_book_issue.book_id'],
                ],
            ])
            ->toArray();

        $copies['copy_number'] = $books[0]['copy_number'] + 1;
        $return_book = TableRegistry::getTableLocator()->get('lms_books');
        $query = $return_book->query();
        $query
            ->update()
            ->set($copies)
            ->where(['book_id' => $books[0]['book_id']])
            ->execute();

        $this->Flash->info('Book Returned Successfully', [
            'key' => 'positive',
            'params' => [],
        ]);

        return $this->redirect(['action' => 'returnBooks']);
    }

    public function returnBooks()
    {
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            $get_issue = TableRegistry::getTableLocator()->get('lms_book_issue');
            $get_issues = $get_issue
                ->find()
                ->where(['lms_book_issue.member_id' => $request_data['member_id']])
                ->enableAutoFields(true)
                ->enableHydration(false)
                ->order('lms_book_issue.issue_id ASC')
                ->select([
                    'issue_id' => 'lms_book_issue.issue_id',
                    'book_name' => 'b.book_name',
                    'copies' => 'b.copy_number',
                    'member_type' => 'm.member_type',
                    'issue_to_student' => 's.name',
                    'issue_to_employee' => 'e.name', //This will be in condition if
                ])
                ->join([
                    'b' => [
                        'table' => 'lms_books',
                        'type' => 'LEFT',
                        'conditions' => ['b.book_id = lms_book_issue.book_id'],
                    ],
                    'm' => [
                        'table' => 'lms_members',
                        'type' => 'LEFT',
                        'conditions' => ['m.member_id = lms_book_issue.member_id'],
                    ],
                    's' => [
                        'table' => 'scms_students',
                        'type' => 'LEFT',
                        'conditions' => ['s.student_id = m.student_id'],
                    ],
                    'e' => [
                        'table' => 'employee',
                        'type' => 'LEFT',
                        'conditions' => ['e.employee_id = m.employee_id'],
                    ],
                ])
                ->toArray();
            $this->set('issues', $get_issues);
            // echo "<pre>";
            // print_r($get_issues);
            // die;
        }

        $get_member = TableRegistry::getTableLocator()->get('lms_members');
        $get_members = $get_member->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->select([
                'issue_to_student' => 's.name',
                'issue_to_employee' => 'e.name', //This will be in condition if
            ])
            ->join([
                's' => [
                    'table' => 'scms_students',
                    'type' => 'LEFT',
                    'conditions' => ['s.student_id = lms_members.student_id'],
                ],
                'e' => [
                    'table' => 'employee',
                    'type' => 'LEFT',
                    'conditions' => ['e.employee_id = lms_members.employee_id'],
                ],
            ])
            ->toArray();
        $this->set('get_members', $get_members);

        foreach ($get_members as $key => $member) {
            $result[$key]['member_id'] = $member['member_id'];
            if ($member['issue_to_student']) {
                $result[$key]['name'] = $member['issue_to_student'];
            } else {
                $result[$key]['name'] = $member['issue_to_employee'];
            }
        }
        $this->set('members', $result);
    }

    private function search_members($request_data)
    {
        $member_searches = $this->get_selected_members($request_data['member_id']); //get course setup id for searching data
        $member = TableRegistry::getTableLocator()->get('lms_members');
        $members = $member->find()
            ->enableAutoFields(true)
            ->enableHydration(false)
            ->where(['member_id' => $member_searches[0]->member_id])
            ->toArray();
        return $members;
    }

    private function get_selected_members($member_id)
    {
        $where['member_id'] = $member_id;
        $member_search = TableRegistry::getTableLocator()->get('lms_book_issue');
        $member_searches = $member_search
            ->find()
            ->where($where)
            ->toArray();
        return $member_searches;
    }
}
