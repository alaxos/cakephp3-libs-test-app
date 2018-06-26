<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Exception\Exception;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \Alaxos\Controller\Component\FilterComponent $Filter
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
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

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['shiblogin', 'logout']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Creator', 'Editor', 'Roles']
        ];
        $users = $this->paginate($this->Filter->getFilterQuery());

        $roles = $this->Users->Roles->find('list', ['limit' => 200]);

        $this->set(compact('users', 'roles'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Creator', 'Editor', 'Roles']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->getRequest()->is('post')) {
            $user = $this->Users->patchEntity($user, $this->getRequest()->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->getRequest()->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        try {
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('The user has been deleted.'), ['plugin' => 'Alaxos']);
            } else {
                $this->Flash->error(__('The user could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
            }
        } catch (\Exception $ex) {
            if ($ex->getCode() == 23000) {
                $this->Flash->error(___('The user could not be deleted as it is still used in the database'), ['plugin' => 'Alaxos']);
            } else {
                if (Configure::read('debug')) {
                    $this->Flash->error(sprintf(___('The user could not be deleted: %s'), $ex->getMessage()), ['plugin' => 'Alaxos']);
                } else {
                    $this->Flash->error(__('The user could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
                }
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete all method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteAll($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);

        $checked_ids = $this->getRequest()->getData('checked_ids');
        if (!empty($checked_ids)) {

            $query = $this->Users->query();
            $query->delete()->where(['id IN' => $checked_ids]);

            try {
                if ($statement = $query->execute()) {
                    $deleted_total = $statement->rowCount();
                    if ($deleted_total == 1) {
                        $this->Flash->set(___('The selected user has been deleted.'), ['element' => 'Alaxos.success']);
                    } elseif ($deleted_total > 1) {
                        $this->Flash->set(sprintf(__('The %s selected users have been deleted.'), $deleted_total), ['element' => 'Alaxos.success']);
                    }
                } else {
                    $this->Flash->set(___('The selected users could not be deleted. Please, try again.'), ['element' => 'Alaxos.error']);
                }
            } catch (\Exception $ex) {
                if ($ex->getCode() == 23000) {
                    $this->Flash->error(___('The users could not be deleted as some of them are still used in the database'), ['plugin' => 'Alaxos']);
                } else {
                    if (Configure::read('debug')) {
                        $this->Flash->set(___('The selected users could not be deleted. Please, try again.'), ['element' => 'Alaxos.error', 'params' => ['exception_message' => $ex->getMessage()]]);
                    } else {
                        $this->Flash->set(___('The selected users could not be deleted. Please, try again.'), ['element' => 'Alaxos.error']);
                    }
                }
            }

        } else {
            $this->Flash->set(___('There was no user to delete'), ['element' => 'Alaxos.error']);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function copy($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $user->isNew(true);

        if ($this->getRequest()->is(['post'])) {
            $user = $this->Users->newEntity($this->getRequest()->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'), ['plugin' => 'Alaxos']);

                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'), ['plugin' => 'Alaxos']);
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
    }

    public function shiblogin()
    {
        /*
         * If the user comes here, it means the user is gone through the Shibboleth authentication
         *
         * -> login() can be called
         *
         *  Note: if
         *             $this->Auth->allow('shiblogin');
         *
         *        is not called in beforeFilter(), the authentication is done automatically.
         *        But in this case we could not manage the sucess/error manually
         */
        $logged_user = $this->Auth->user();

        if (empty($logged_user)) {

            if ($logged_user = $this->Auth->identify()) {

                /*
                 * Remove unauthorized messages that have not been shown yet
                 */
                $this->getRequest()->getSession()->delete('Flash.flash');

                $this->Users->setLastLoginDate($logged_user['id']);

                $this->Auth->setUser($logged_user);

                $this->Logger->login($logged_user['firstname'] . ' ' . $logged_user['lastname'] . ' logged in');

                $shibboleth_auth = $this->Auth->authenticationProvider();

                if ($shibboleth_auth->isNewUser()) {
                    $this->Flash->success(__('Your account has been created'), ['plugin' => 'Alaxos']);
                } else {
                    $this->Flash->success(__('You have been authenticated'), ['plugin' => 'Alaxos']);
                }

                $this->redirect($this->Auth->redirectUrl());

            } else {

                $this->Flash->error(__('unable to login'), ['plugin' => 'Alaxos']);
                $this->redirect('/');
            }

        } else {

            $this->Flash->info(__('you are already logged in'), ['plugin' => 'Alaxos']);

            $this->redirect('/');
        }
    }

    public function logout()
    {
        $url = $this->Auth->logout();
        $this->getRequest()->getSession()->destroy();

        $this->Flash->success(__('You have been logged out'), ['plugin' => 'Alaxos']);

        $this->redirect($url);
    }
}
