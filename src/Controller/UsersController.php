<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \Alaxos\Controller\Component\FilterComponent $Filter
 */
class UsersController extends AppController
{

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = ['Alaxos.AlaxosHtml', 'Alaxos.AlaxosForm', 'Alaxos.Navbars'];

    /**
     * Components
     *
     * @var array
     */
    public $components = ['Alaxos.Filter'];

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles']
        ];
        $users = $this->paginate($this->Filter->getFilterQuery());

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        
        try {
            
            if ($this->Users->delete($user)) {
                $this->Flash->success(___('The user has been deleted'), ['plugin' => 'Alaxos']);
            } else {
                $this->Flash->error(___('The user could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
            }
            
        } catch(\Exception $ex) {
            
            if ($ex->getCode() == 23000) {
                $this->Flash->error(___('The user could not be deleted as it is still used in the database'), ['plugin' => 'Alaxos']);
            } else {
                $this->Flash->error(sprintf(__('The user could not be deleted: %s'), $ex->getMessage()), ['plugin' => 'Alaxos']);
            }
            
        }
        
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete all method
     */
    public function deleteAll() {

        $this->request->allowMethod('post', 'delete');

        if($this->request->getData('checked_ids') !== null && !empty($this->request->getData('checked_ids'))){

            $users = $this->Users->find()->where(['id IN' => $this->request->getData('checked_ids')]);

            $total         = $users->count();
            $total_deleted = 0;

            foreach($users as $user) {

                try {

                    if ($this->Users->delete($user)) {
                        $total_deleted++;
                    }

                } catch(\Exception $ex) {
                    $this->log($ex);
                }

            }

            if ($total_deleted == $total) {

                if ($total_deleted == 1) {
                    $this->Flash->success(__('The selected user has been deleted.'), ['plugin' => 'Alaxos']);
                } elseif ($total_deleted > 1) {
                    $this->Flash->success(sprintf(__('The %s selected users have been deleted.'), $total_deleted), ['plugin' => 'Alaxos']);
                }

            } else {

                if ($total_deleted == 0) {
                    $this->Flash->error(__('The selected users could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
                } else {
                    $this->Flash->error(sprintf(__('Only %s selected users on %s could be deleted'), $total_deleted, $total), ['plugin' => 'Alaxos']);
                }

            }

        } else {
            $this->Flash->error(__('There was no user to delete'), ['plugin' => 'Alaxos']);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Copy method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful copy, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function copy($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved'), ['plugin' => 'Alaxos']);
                return $this->redirect(['action' => 'view', $user->id]);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
            }
        }

        $roles = $this->Users->Roles->find('list', ['limit' => 200]);

        $user->id = $id;
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);
    }
}
