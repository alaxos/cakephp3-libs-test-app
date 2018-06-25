<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.roles',
        'app.users',
        'plugin.alaxos.log_categories',
        'plugin.alaxos.log_levels',
        'plugin.alaxos.log_entries',
    ];

    /**
     * Test that the role item is selected in the submenu
     *
     * @return void
     */
    public function testIndexMenuSelected()
    {
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseRegExp('/<li class="active">\r*\s*<a href="\/users" id="users"/');
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndexContent()
    {
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseContains('John');
        $this->assertResponseContains('Jack');
        $this->assertResponseContains('Jane');

        /*
         * Page contains add button
         */
        $this->assertResponseContains('<span class="glyphicon glyphicon-plus"></span> ' . __d('alaxos', 'add') . '</a>');

        /*
         * Page contains date filter
         */
        $this->assertResponseContains('id="filter-created-start"');
        $this->assertResponseContains('<div class="input-group date alaxos-date" id="filter-created-start-container">');
        $this->assertResponseContains(__d('alaxos', 'from or equal'));
    }

    public function testIndexSort()
    {
        $this->get('/users?sort=lastname&direction=asc');
        $this->assertResponseOk();
        $this->assertResponseContains('Dalton');
        $this->assertResponseContains('Doe');
        $this->assertResponseContains('Smith');
        $this->assertResponseRegExp('/<div class="table-responsive">.*Dalton.*Doe.*Smith/s');
        $this->assertResponseNotRegExp('/<div class="table-responsive">.*Smith.*Doe.*Dalton/s');

        $this->get('/users?sort=lastname&direction=desc');
        $this->assertResponseOk();
        $this->assertResponseContains('Dalton');
        $this->assertResponseContains('Doe');
        $this->assertResponseContains('Smith');
        $this->assertResponseNotRegExp('/<div class="table-responsive">.*Dalton.*Doe.*Smith/s');
        $this->assertResponseRegExp('/<div class="table-responsive">.*Smith.*Doe.*Dalton/s');
    }

    public function testIndexPostFilter()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = ['Filter' => ['lastname' => 'Smith']];
        $this->post('/users', $data);
        $this->assertResponseOk();
        $this->assertResponseNotContains('Dalton');
        $this->assertResponseNotContains('Doe');
        $this->assertResponseContains('Smith');

        $data = ['Filter' => ['lastname' => 'd']];
        $this->post('/users', $data);
        $this->assertResponseOk();
        $this->assertResponseContains('Dalton');
        $this->assertResponseContains('Doe');
        $this->assertResponseNotContains('Smith');

        $data = ['Filter' => []];
        $this->post('/users', $data);
        $this->assertResponseOk();
        $this->assertResponseContains('Dalton');
        $this->assertResponseContains('Doe');
        $this->assertResponseContains('Smith');

        $data = ['Filter' => ['lastname' => 'xxx']];
        $this->post('/users', $data);
        $this->assertResponseOk();
        $this->assertResponseNotContains('Dalton');
        $this->assertResponseNotContains('Doe');
        $this->assertResponseNotContains('Smith');

        $data = ['Filter' => ['modified' => ['__start__' => '2017-03-15', '__end__' => '2017-03-20']]];
        $this->post('/users', $data);
        $this->assertResponseOk();
        $this->assertResponseNotContains('Dalton');
        $this->assertResponseContains('Doe');
        $this->assertResponseContains('Smith');

        $data = ['Filter' => ['modified' => ['__start__' => '15.03.2017', '__end__' => '20.03.2017']]];
        $this->post('/users', $data);
        $this->assertResponseOk();
        $this->assertResponseNotContains('Dalton');
        $this->assertResponseContains('Doe');
        $this->assertResponseContains('Smith');

        $data = ['Filter' => ['modified' => ['__start__' => '12.03.2017', '__end__' => '14.03.2017']]];
        $this->post('/users', $data);
        $this->assertResponseOk();
        $this->assertResponseNotContains('Dalton');
        $this->assertResponseNotContains('Doe');
        $this->assertResponseNotContains('Smith');
    }

    public function testIndexFilterNotCleared()
    {
        $this->session([
            'Alaxos' => [
                'Filter' => [
                    '/users' => [
                        'lastname' => 'Smith'
                    ]
                ]
            ]
        ]);

        /*
         * Filter not cleared if coming from index
         */
        $this->configRequest([
            'headers' => ['Referer' => '/users']
        ]);
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseNotContains('Dalton');
        $this->assertResponseNotContains('Doe');
        $this->assertResponseContains('Smith');

        /*
         * Filter not cleared if coming from view
         */
        $this->configRequest([
            'headers' => ['Referer' => '/users/view/1']
        ]);
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseNotContains('Dalton');
        $this->assertResponseNotContains('Doe');
        $this->assertResponseContains('Smith');

        /*
         * Filter not cleared if coming from edit
         */
        $this->configRequest([
            'headers' => ['Referer' => '/users/edit/1']
        ]);
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseNotContains('Dalton');
        $this->assertResponseNotContains('Doe');
        $this->assertResponseContains('Smith');

        /*
         * Filter not cleared if coming from add
         */
        $this->configRequest([
            'headers' => ['Referer' => '/users/add']
        ]);
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseNotContains('Dalton');
        $this->assertResponseNotContains('Doe');
        $this->assertResponseContains('Smith');

        /*
         * Filter not cleared if coming from copy
         */
        $this->configRequest([
            'headers' => ['Referer' => '/users/copy/1']
        ]);
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseNotContains('Dalton');
        $this->assertResponseNotContains('Doe');
        $this->assertResponseContains('Smith');
    }

    public function testIndexFilterClearedFromSomewhereElse()
    {
        $this->session([
            'Alaxos' => [
                'Filter' => [
                    '/users' => [
                        'name' => 'admin'
                    ]
                ]
            ]
        ]);

        $this->configRequest([
            'headers' => ['Referer' => '/']
        ]);
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseContains('Dalton');
        $this->assertResponseContains('Doe');
        $this->assertResponseContains('Smith');
    }

    public function testIndexFilterClearedWithoutReferer()
    {
        $this->session([
            'Alaxos' => [
                'Filter' => [
                    '/users' => [
                        'name' => 'admin'
                    ]
                ]
            ]
        ]);

        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseContains('Dalton');
        $this->assertResponseContains('Doe');
        $this->assertResponseContains('Smith');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testViewContent()
    {
        $this->get('/users/view/1');

        $this->assertResponseOk();
        $this->assertResponseContains('John');
        $this->assertResponseContains('Doe');

        /*
         * Action buttons
         */
        $this->assertResponseContains('<a href="/users" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> ' . __d('alaxos', 'list') . '</a>');
        $this->assertResponseContains('<a href="/users/add" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> ' . __d('alaxos', 'add') . '</a>');
        $this->assertResponseContains('<a href="/users/edit/1" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> ' . __d('alaxos', 'edit') . '</a>');
        $this->assertResponseContains('<a href="/users/copy/1" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> ' . __d('alaxos', 'copy') . '</a>');
        $this->assertResponseRegExp('/<form name="post_[a-z0-9]+" style="display:none;" method="post" action="\/users\/delete\/1">/');

        $entity   = TableRegistry::get('Users')->get(1);
        $created  = $entity->to_display_timezone('created');
        $modified = $entity->to_display_timezone('modified');
        $this->assertResponseContains(sprintf(__d('alaxos', 'created on %s at %s'), $created->format('d.m.Y'), $created->format('H:i:s')));
        /*
         * modified date is the same than created date --> not shown
         */
        $this->assertResponseNotContains(sprintf(__d('alaxos', 'last update on %s at %s'), $modified->format('d.m.Y'), $modified->format('H:i:s')));
    }

    public function testViewContentCreatedModified()
    {
        $this->get('/users/view/2');

        $this->assertResponseOk();

        $entity   = TableRegistry::get('Users')->get(2);
        $created  = $entity->to_display_timezone('created');
        $modified = $entity->to_display_timezone('modified');
        $this->assertResponseContains(sprintf(__d('alaxos', 'created on %s at %s'), $created->format('d.m.Y'), $created->format('H:i:s')));
        $this->assertResponseContains(sprintf(__d('alaxos', 'last update on %s at %s'), $modified->format('d.m.Y'), $modified->format('H:i:s')));
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = [
            'role_id'      => 1,
            'firstname'    => 'Albert',
            'lastname'     => 'Levert',
            'email'        => 'albert@example.com',
            'external_uid' => '1346@example.com',
        ];
        $this->post('/users/add', $data);

//         debug($this->_response->__toString());

        $this->assertRedirectContains('/users/view/');

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(4, $total);

        $user = TableRegistry::get('Users')->get(4);
        $this->assertNull($user->created_by);
        $this->assertNull($user->modified_by);
    }

    public function testAddByUser1()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1
                ]
            ]
        ]);

        $data = [
            'role_id'      => 1,
            'firstname'    => 'Albert',
            'lastname'     => 'Levert',
            'email'        => 'albert@example.com',
            'external_uid' => '1346@example.com',
        ];
        $this->post('/users/add', $data);

        $this->assertRedirectContains('/users/view/');

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(4, $total);

        $user = TableRegistry::get('Users')->get(4);
        $this->assertEquals(1, $user->created_by);
        $this->assertNull($user->modified_by);
    }

    public function testAddFail()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        /*
         * lastname empty
         */
        $data = [
            'role_id'      => 1,
            'firstname'    => 'Albert',
            'lastname'     => '',
            'email'        => 'albert@example.com',
            'external_uid' => '1346@example.com',
        ];
        $this->post('/users/add', $data);

        $this->assertResponseOk();

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(3, $total);

        /*
         * No data not given
         */
        $data = [];
        $this->post('/users/add', $data);

        $this->assertResponseOk();

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(3, $total);

        /*
         * Existing email
         */
        $data = ['email' => 'john@example.com'];
        $this->post('/users/add', $data);

        $this->assertResponseOk();

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(3, $total);
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        /*
         * Name updated
         */
        $data = ['id' => 1, 'lastname' => 'xyxyxy'];
        $this->post('/users/edit/1', $data);

        $this->assertRedirect('/users/view/1');

        $user = TableRegistry::get('Users')->get(1);
        $this->assertEquals('xyxyxy', $user->lastname);
    }

    public function testEditNovalue()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        /*
         * Name not given
         */
        $data = ['id' => 1];
        $this->post('/users/edit/1', $data);

        $this->assertRedirect();

        $user = TableRegistry::get('Users')->get(1);
        $this->assertEquals('Doe', $user->lastname);
    }

    public function testEditModifiedByUser1()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1
                ]
            ]
        ]);

        /*
         * Name updated
         */
        $data = ['id' => 1, 'lastname' => 'xyxyxy'];
        $this->post('/users/edit/1', $data);

        $this->assertRedirect('/users/view/1');

        $user = TableRegistry::get('Users')->get(1);
        $this->assertEquals(1, $user->modified_by);
    }

    public function testEditModifiedByUser2()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2
                ]
            ]
        ]);

        /*
         * Name updated
         */
        $data = ['id' => 1, 'lastname' => 'xyxyxy'];
        $this->post('/users/edit/1', $data);

        $this->assertRedirect('/users/view/1');

        $user = TableRegistry::get('Users')->get(1);
        $this->assertEquals(2, $user->modified_by);
    }

    public function testEditFail()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        /*
         * Lastname empty
         */
        $data = ['id' => 1, 'lastname' => ''];
        $this->post('/users/edit/1', $data);

        $this->assertResponseOk();

        $user = TableRegistry::get('Users')->get(1);
        $this->assertEquals('Doe', $user->lastname);

        /*
         * Not existing
         */
        $data = ['id' => 5, 'name' => 'xyxyxy'];
        $this->post('/users/edit/5', $data);

        $this->assertResponseError();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/users/delete/3');
        $this->assertRedirect('/users');
        $this->assertSession(__('The user has been deleted'), 'Flash.flash.0.message');

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(2, $total);
    }

    public function testDeleteNotExisting()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/users/delete/5');

        $this->assertResponseError();

        //         debug($this->_requestSession->read());
        //         debug($this->_response->__toString());

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(3, $total);
    }

    /**
     * Test deleteAll method
     *
     * @return void
     */
    public function testDeleteAllNoData()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = [];

        $this->post('/users/delete-all', $data);
        $this->assertRedirect('/users');
        $this->assertSession(__('There was no user to delete'), 'Flash.flash.0.message');

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(3, $total);
    }

    public function testDeleteAllOK()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = ['checked_ids' => [3]];

        $this->post('/users/delete-all', $data);
        $this->assertRedirect('/users');
        $this->assertSession(__('The selected user has been deleted.'), 'Flash.flash.0.message');

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(2, $total);
    }

    public function testDeleteAllNotUsed()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        /*
         * Delete 2 roles that are not used
         */
        $data = ['checked_ids' => [2, 3]];
        $this->post('/users/delete-all', $data);
        $this->assertRedirect('/users');
        $this->assertSession(sprintf(__('The %s selected users have been deleted.'), 2), 'Flash.flash.0.message');

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(1, $total);
    }

    /**
     * Test copy method
     *
     * @return void
     */
    public function testCopy()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->get('/users/copy/1');

        $this->assertResponseContains('John');
        $this->assertResponseContains('Doe');
        $this->assertResponseContains('123@example.com');

        $data = [
            'role_id'      => 1,
            'firstname'    => 'John',
            'lastname'     => 'Done',
            'email'        => 'xyxyxy@example.com',
            'external_uid' => '1728@example.com',
        ];

        $this->post('/users/copy/1', $data);

//         debug($this->_response->__toString());

        $this->assertRedirect('/users/view/4');

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(4, $total);

        $user = TableRegistry::get('Users')->get(4);
        $this->assertEquals('John', $user->firstname);
        $this->assertEquals('Done', $user->lastname);
        $this->assertNull($user->created_by);
        $this->assertNull($user->modified_by);
    }

    public function testCopyFail()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        /*
         * lastname empty
         */
        $data = [
            'role_id'      => 1,
            'firstname'    => 'John',
            'lastname'     => '',
            'email'        => 'xyxyxy@example.com',
            'external_uid' => '1728@example.com',
        ];
        $this->post('/users/copy/1', $data);

        $this->assertResponseOk();

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(3, $total);

        /*
         * No data given
         */
        $data = [];
        $this->post('/users/copy/1', $data);

        $this->assertResponseOk();

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(3, $total);

        /*
         * Existing email
         */
        $data = [
            'role_id'      => 1,
            'firstname'    => 'John',
            'lastname'     => 'Done',
            'email'        => 'john@example.com',
            'external_uid' => '1728@example.com',
        ];
        $this->post('/users/copy/1', $data);

        $this->assertResponseOk();

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(3, $total);
    }

    public function testCopyByUser1()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1
                ]
            ]
        ]);

        $data = [
            'role_id'      => 1,
            'firstname'    => 'John',
            'lastname'     => 'Done',
            'email'        => 'xyxyxy@example.com',
            'external_uid' => '1728@example.com',
        ];
        $this->post('/users/copy/1', $data);

        $this->assertRedirect('/users/view/4');

        $total = TableRegistry::get('Users')->find()->count();
        $this->assertEquals(4, $total);

        $user = TableRegistry::get('Users')->get(4);
        $this->assertEquals(1, $user->created_by);
        $this->assertNull($user->modified_by);
    }
}
