<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Exception\Exception;
use Cake\Core\Configure;

/**
 * Things Controller
 *
 * @property \App\Model\Table\ThingsTable $Things
 * @property \Alaxos\Controller\Component\FilterComponent $Filter
 *
 * @method \App\Model\Entity\Thing[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ThingsController extends AppController
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
            'contain' => ['Creator', 'Editor', 'Users']
        ];
        $things = $this->paginate($this->Filter->getFilterQuery());

        $users = $this->Things->Users->find('list', ['limit' => 200]);

        $this->set(compact('things', 'users'));
    }

    /**
     * View method
     *
     * @param string|null $id Thing id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $thing = $this->Things->get($id, [
            'contain' => ['Creator', 'Editor', 'Users']
        ]);

        $this->set('thing', $thing);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $thing = $this->Things->newEntity();
        if ($this->getRequest()->is('post')) {
            $thing = $this->Things->patchEntity($thing, $this->getRequest()->getData());
            if ($this->Things->save($thing)) {
                $this->Flash->success(__('The thing has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'view', $thing->id]);
            }
            $this->Flash->error(__('The thing could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
        }
        $users = $this->Things->Users->find('list', ['limit' => 200]);
        $this->set(compact('thing', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Thing id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $thing = $this->Things->get($id, [
            'contain' => []
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $thing = $this->Things->patchEntity($thing, $this->getRequest()->getData());
            if ($this->Things->save($thing)) {
                $this->Flash->success(__('The thing has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'view', $thing->id]);
            }
            $this->Flash->error(__('The thing could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
        }
        $users = $this->Things->Users->find('list', ['limit' => 200]);
        $this->set(compact('thing', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Thing id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $thing = $this->Things->get($id);
        try {
            if ($this->Things->delete($thing)) {
                $this->Flash->success(__('The thing has been deleted.'), ['plugin' => 'Alaxos']);
            } else {
                $this->Flash->error(__('The thing could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
            }
        } catch (\Exception $ex) {
            if ($ex->getCode() == 23000) {
                $this->Flash->error(___('The thing could not be deleted as it is still used in the database'), ['plugin' => 'Alaxos']);
            } else {
                if (Configure::read('debug')) {
                    $this->Flash->error(sprintf(___('The thing could not be deleted: %s'), $ex->getMessage()), ['plugin' => 'Alaxos']);
                } else {
                    $this->Flash->error(__('The thing could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
                }
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete all method
     *
     * @param string|null $id Thing id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteAll($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);

        $checked_ids = $this->getRequest()->getData('checked_ids');
        if (!empty($checked_ids)) {

            $query = $this->Things->query();
            $query->delete()->where(['id IN' => $checked_ids]);

            try {
                if ($statement = $query->execute()) {
                    $deleted_total = $statement->rowCount();
                    if ($deleted_total == 1) {
                        $this->Flash->set(___('The selected thing has been deleted.'), ['element' => 'Alaxos.success']);
                    } elseif ($deleted_total > 1) {
                        $this->Flash->set(sprintf(__('The %s selected things have been deleted.'), $deleted_total), ['element' => 'Alaxos.success']);
                    }
                } else {
                    $this->Flash->set(___('The selected things could not be deleted. Please, try again.'), ['element' => 'Alaxos.error']);
                }
            } catch (\Exception $ex) {
                if ($ex->getCode() == 23000) {
                    $this->Flash->error(___('The things could not be deleted as some of them are still used in the database'), ['plugin' => 'Alaxos']);
                } else {
                    if (Configure::read('debug')) {
                        $this->Flash->set(___('The selected things could not be deleted. Please, try again.'), ['element' => 'Alaxos.error', 'params' => ['exception_message' => $ex->getMessage()]]);
                    } else {
                        $this->Flash->set(___('The selected things could not be deleted. Please, try again.'), ['element' => 'Alaxos.error']);
                    }
                }
            }

        } else {
            $this->Flash->set(___('There was no thing to delete'), ['element' => 'Alaxos.error']);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Thing id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function copy($id = null)
    {
        $thing = $this->Things->get($id, [
            'contain' => []
        ]);
        $thing->isNew(true);

        if ($this->getRequest()->is(['post'])) {
            $thing = $this->Things->newEntity($this->getRequest()->getData());
            if ($this->Things->save($thing)) {
                $this->Flash->success(__('The thing has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'view', $thing->id]);
            }
            $this->Flash->error(__('The thing could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
        }
        $users = $this->Things->Users->find('list', ['limit' => 200]);
        $this->set(compact('thing', 'users'));
    }
}
