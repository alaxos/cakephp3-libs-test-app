<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 * @property \Alaxos\Controller\Component\FilterComponent $Filter
 */
class RolesController extends AppController
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
        $roles = $this->paginate($this->Filter->getFilterQuery());

        $this->set(compact('roles'));
        $this->set('_serialize', ['roles']);
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('role', $role);
        $this->set('_serialize', ['role']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $role = $this->Roles->newEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The role could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
            }
        }
        $this->set(compact('role'));
        $this->set('_serialize', ['role']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The role could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
            }
        }
        $this->set(compact('role'));
        $this->set('_serialize', ['role']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id);

        try {

            if ($this->Roles->delete($role)) {
                $this->Flash->success(__('The role has been deleted'), ['plugin' => 'Alaxos']);
            } else {
                $this->Flash->error(__('The role could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
            }

        } catch(\Exception $ex) {

            if ($ex->getCode() == 23000) {
                $this->Flash->error(__('The role could not be deleted as it is still used in the database'), ['plugin' => 'Alaxos']);
            } else {
                $this->Flash->error(sprintf(__('The role could not be deleted: %s'), $ex->getMessage()), ['plugin' => 'Alaxos']);
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

            $roles = $this->Roles->find()->where(['id IN' => $this->request->getData('checked_ids')]);

            $total         = $roles->count();
            $total_deleted = 0;

            foreach($roles as $role) {

                try {

                    if ($this->Roles->delete($role)) {
                        $total_deleted++;
                    }

                } catch(\Exception $ex) {
                    $this->log($ex);
                }

            }

            if ($total_deleted == $total) {

                if ($total_deleted == 1) {
                    $this->Flash->success(__('The selected role has been deleted.'), ['plugin' => 'Alaxos']);
                } elseif ($total_deleted > 1) {
                    $this->Flash->success(sprintf(__('The %s selected roles have been deleted.'), $total_deleted), ['plugin' => 'Alaxos']);
                }

            } else {

                if ($total_deleted == 0) {
                    $this->Flash->error(__('The selected roles could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
                } else {
                    $this->Flash->error(sprintf(__('Only %s selected roles on %s could be deleted'), $total_deleted, $total), ['plugin' => 'Alaxos']);
                }

            }

        } else {
            $this->Flash->error(__('There was no role to delete'), ['plugin' => 'Alaxos']);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Copy method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|void Redirects on successful copy, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function copy($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->newEntity();
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved'), ['plugin' => 'Alaxos']);
                return $this->redirect(['action' => 'view', $role->id]);
            } else {
                $this->Flash->error(__('The role could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
            }
        }


        $role->id = $id;
        $this->set(compact('role'));
        $this->set('_serialize', ['role']);
    }
}
