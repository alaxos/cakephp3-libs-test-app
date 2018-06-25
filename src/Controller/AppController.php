<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Core\Configure;
use Alaxos\Lib\StringTool;
use Cake\I18n\Time;
use Cake\Http\ServerRequest;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = ['Alaxos.AlaxosHtml', 'Alaxos.AlaxosForm', 'Alaxos.Navbars'];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', ['enableBeforeRedirect' => false]);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        $this->loadComponent('Security');
        $this->loadComponent('Csrf');

        $this->loadComponent('Alaxos.Filter');
        $this->loadComponent('Alaxos.Logger', ['days_to_keep_logs' => 30]);
        $this->loadComponent('Alaxos.UserLink');

        $this->Auth->allow();
    }

    function beforeFilter(Event $event)
    {
        $controller = $this->getRequest()->getParam('controller');
        if($controller == 'Pages') {
            $this->Auth->allow();
        }

        $this->_setLocale();
        $this->_setAuthentication();
        $this->_setLoggedUser();
    }

    /**
     * Set language, date, time and currency display according to query parameter, existing cookie or browser locale
     *
     * Note: default locale is set in config/app.php
     */
    protected function _setLocale()
    {
        $availableLanguages = Configure::read('website_languages');
        $langToSet          = null;

        $queryParams = $this->getRequest()->getQueryParams();
        if (isset($queryParams['lang']) && in_array($queryParams['lang'], $availableLanguages)) {
            $langToSet = $queryParams['lang'];

        } else {

            $cookieLang = $this->getRequest()->getCookie('lang');
            if (!empty($cookieLang) && in_array($cookieLang, $availableLanguages)) {
                $langToSet = $cookieLang;

            } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {

                $browserLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
                foreach ($availableLanguages as $availableLanguage) {
                    $availableLangPrefix = substr($availableLanguage, 0, stripos($availableLanguage, '-'));
                    $browserLangPrefix   = substr($browserLang,       0, stripos($browserLang, '-'));
                    if (!empty($availableLangPrefix) && $availableLangPrefix == $browserLangPrefix) {
                        $langToSet = $availableLanguage;
                        break;
                    }
                }
            }
        }

        if (!empty($langToSet)) {
            I18n::setLocale($langToSet);
            $this->setResponse($this->getResponse()->withCookie('lang', $langToSet));
        }

        /**********************************
         * Forces locale used as dates format to the Swiss locale
         */
        Time::setDefaultLocale($langToSet);

        /**********************************
         * Timezone used to display datetimes
         *
         * (by default Configure::read('default_display_timezone') value set in bootstrap is used)
         */
        //         Configure::write('display_timezone', $display_timezone);
    }

    private function _setAuthentication()
    {
        $this->Auth->setConfig('loginAction', ['plugin' => false, 'prefix' => false, 'controller' => 'Users', 'action' => 'shiblogin']);
        $this->Auth->setConfig('unauthorizedRedirect', '/');
        $this->Auth->setConfig('authError', __('you are not authorized to access this page'));
        $this->Auth->setConfig('flash', ['element' => 'Alaxos.error']);
        $this->Auth->setConfig('logoutRedirect', '/');

        $complete_new_user_data_fonction = function(ServerRequest $request, $user_data){

            $user_data['role_id']     = ROLE_ID_USER; //default role is user
            $user_data['username']    = $user_data['external_uid'];
            $user_data['enabled']     = true;

            return $user_data;
        };

        $this->Auth->setConfig('authenticate',
            [
                'Alaxos.Shibboleth'    => [
                    'unique_id'            => Configure::read('Shibboleth.unique_id_attribute'),
                    'mapping'              => Configure::read('Shibboleth.attributes_mapping'),
                    'updatable_properties' => Configure::read('Shibboleth.updatable_properties'),
                    'create_new_user'      => true,
                    'completeNewUserData'  => $complete_new_user_data_fonction,
                    'login_url'            => ['controller' => 'Users', 'action' => 'shiblogin'],
                ]
            ]);

        $this->Auth->setConfig('authorize', ['Controller']);
    }

    protected function _setLoggedUser()
    {
        $user = $this->Auth->user();
        if(!empty($user))
        {
            $this->loadModel('Users');
            $user = $this->Users->get($user['id'], ['contain' => ['Roles']]);

            $this->set('logged_user', $user);
        }
    }
}
