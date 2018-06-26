<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Exception\Exception;
use Cake\Core\Configure;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 * @property \Alaxos\Controller\Component\FilterComponent $Filter
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
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
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Creator', 'Editor']
        ];
        $roles = $this->paginate($this->Filter->getFilterQuery());


        $this->set(compact('roles'));
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['Creator', 'Editor', 'Users']
        ]);

        $this->set('role', $role);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $role = $this->Roles->newEntity();
        if ($this->getRequest()->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->getRequest()->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'view', $role->id]);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
        }
        $this->set(compact('role'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->getRequest()->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'view', $role->id]);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
        }
        $this->set(compact('role'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id);
        try {
            if ($this->Roles->delete($role)) {
                $this->Flash->success(__('The role has been deleted.'), ['plugin' => 'Alaxos']);
            } else {
                $this->Flash->error(__('The role could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
            }
        } catch (\Exception $ex) {
            if ($ex->getCode() == 23000) {
                $this->Flash->error(___('The role could not be deleted as it is still used in the database'), ['plugin' => 'Alaxos']);
            } else {
                if (Configure::read('debug')) {
                    $this->Flash->error(sprintf(___('The role could not be deleted: %s'), $ex->getMessage()), ['plugin' => 'Alaxos']);
                } else {
                    $this->Flash->error(__('The role could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
                }
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete all method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteAll($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);

        $checked_ids = $this->getRequest()->getData('checked_ids');
        if (!empty($checked_ids)) {

            $query = $this->Roles->query();
            $query->delete()->where(['id IN' => $checked_ids]);

            try {
                if ($statement = $query->execute()) {
                    $deleted_total = $statement->rowCount();
                    if ($deleted_total == 1) {
                        $this->Flash->set(___('The selected role has been deleted.'), ['element' => 'Alaxos.success']);
                    } elseif ($deleted_total > 1) {
                        $this->Flash->set(sprintf(__('The %s selected roles have been deleted.'), $deleted_total), ['element' => 'Alaxos.success']);
                    }
                } else {
                    $this->Flash->set(___('The selected roles could not be deleted. Please, try again.'), ['element' => 'Alaxos.error']);
                }
            } catch (\Exception $ex) {
                if ($ex->getCode() == 23000) {
                    $this->Flash->error(___('The roles could not be deleted as some of them are still used in the database'), ['plugin' => 'Alaxos']);
                } else {
                    if (Configure::read('debug')) {
                        $this->Flash->set(___('The selected roles could not be deleted. Please, try again.'), ['element' => 'Alaxos.error', 'params' => ['exception_message' => $ex->getMessage()]]);
                    } else {
                        $this->Flash->set(___('The selected roles could not be deleted. Please, try again.'), ['element' => 'Alaxos.error']);
                    }
                }
            }

        } else {
            $this->Flash->set(___('There was no role to delete'), ['element' => 'Alaxos.error']);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function copy($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);
        $role->isNew(true);

        if ($this->getRequest()->is(['post'])) {
            $role = $this->Roles->newEntity($this->getRequest()->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'view', $role->id]);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
        }
        $this->set(compact('role'));
    }
}
