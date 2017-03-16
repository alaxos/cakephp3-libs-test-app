<?php
namespace App\Test\TestCase\Controller;

use App\Controller\RolesController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\RolesController Test Case
 */
class RolesControllerTest extends IntegrationTestCase
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
        $this->get('/roles');
        $this->assertResponseOk();
        $this->assertResponseRegExp('/<li class="active">\r*\s*<a href="\/roles" id="roles"/');
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndexContent()
    {
        $this->get('/roles');
        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');
        $this->assertResponseContains('utilisateur');

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
        $this->get('/roles?sort=name&direction=asc');
        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');
        $this->assertResponseContains('utilisateur');
        $this->assertResponseRegExp('/<div class="table-responsive">.*administrateur.*utilisateur/s');
        $this->assertResponseNotRegExp('/<div class="table-responsive">.*utilisateur.*administrateur/s');

        $this->get('/roles?sort=name&direction=desc');
        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');
        $this->assertResponseContains('utilisateur');
        $this->assertResponseNotRegExp('/<div class="table-responsive">.*administrateur.*utilisateur/s');
        $this->assertResponseRegExp('/<div class="table-responsive">.*utilisateur.*administrateur/s');
    }

    public function testIndexPostFilter()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = ['Filter' => ['name' => 'utilisateur']];
        $this->post('/roles', $data);
        $this->assertResponseOk();
        $this->assertResponseContains('utilisateur');
        $this->assertResponseNotContains('administrateur');

        $data = ['Filter' => ['name' => 'eur']];
        $this->post('/roles', $data);
        $this->assertResponseOk();
        $this->assertResponseContains('utilisateur');
        $this->assertResponseContains('administrateur');

        $data = ['Filter' => []];
        $this->post('/roles', $data);
        $this->assertResponseOk();
        $this->assertResponseContains('utilisateur');
        $this->assertResponseContains('administrateur');

        $data = ['Filter' => ['name' => 'xxx']];
        $this->post('/roles', $data);
        $this->assertResponseOk();
        $this->assertResponseNotContains('utilisateur');
        $this->assertResponseNotContains('administrateur');

        $data = ['Filter' => ['modified' => ['__start__' => '2017-03-15', '__end__' => '2017-03-20']]];
        $this->post('/roles', $data);
        $this->assertResponseOk();
        $this->assertResponseContains('utilisateur');
        $this->assertResponseNotContains('administrateur');

        $data = ['Filter' => ['modified' => ['__start__' => '15.03.2017', '__end__' => '20.03.2017']]];
        $this->post('/roles', $data);
        $this->assertResponseOk();
        $this->assertResponseContains('utilisateur');
        $this->assertResponseNotContains('administrateur');

        $data = ['Filter' => ['modified' => ['__start__' => '12.03.2017', '__end__' => '14.03.2017']]];
        $this->post('/roles', $data);
        $this->assertResponseOk();
        $this->assertResponseNotContains('utilisateur');
        $this->assertResponseNotContains('administrateur');
    }

    public function testIndexFilterNotCleared()
    {
        $this->session([
            'Alaxos' => [
                'Filter' => [
                    '/roles' => [
                        'name' => 'admin'
                    ]
                ]
            ]
        ]);

        /*
         * Filter not cleared if coming from index
         */
        $this->configRequest([
            'headers' => ['Referer' => '/roles']
        ]);
        $this->get('/roles');
        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');
        $this->assertResponseNotContains('utilisateur');

        /*
         * Filter not cleared if coming from view
         */
        $this->configRequest([
            'headers' => ['Referer' => '/roles/view/1']
        ]);
        $this->get('/roles');
        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');
        $this->assertResponseNotContains('utilisateur');

        /*
         * Filter not cleared if coming from edit
         */
        $this->configRequest([
            'headers' => ['Referer' => '/roles/edit/1']
        ]);
        $this->get('/roles');
        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');
        $this->assertResponseNotContains('utilisateur');

        /*
         * Filter not cleared if coming from add
         */
        $this->configRequest([
            'headers' => ['Referer' => '/roles/add']
        ]);
        $this->get('/roles');
        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');
        $this->assertResponseNotContains('utilisateur');

        /*
         * Filter not cleared if coming from copy
         */
        $this->configRequest([
            'headers' => ['Referer' => '/roles/copy/1']
        ]);
        $this->get('/roles');
        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');
        $this->assertResponseNotContains('utilisateur');

        /*
         * Filter cleared if no referer
         */
        $this->configRequest([
            'headers' => ['Referer' => '/']
        ]);
        $this->get('/roles');
        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');
        $this->assertResponseContains('utilisateur');
    }

    public function testIndexFilterClearedFromSomewhereElse()
    {
        $this->session([
            'Alaxos' => [
                'Filter' => [
                    '/roles' => [
                        'name' => 'admin'
                    ]
                ]
            ]
        ]);

        $this->configRequest([
            'headers' => ['Referer' => '/']
        ]);
        $this->get('/roles');
        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');
        $this->assertResponseContains('utilisateur');
    }

    public function testIndexFilterClearedWithoutReferer()
    {
        $this->session([
            'Alaxos' => [
                'Filter' => [
                    '/roles' => [
                        'name' => 'admin'
                    ]
                ]
            ]
        ]);

        $this->get('/roles');
        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');
        $this->assertResponseContains('utilisateur');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testViewContent()
    {
        $this->get('/roles/view/1');

        $this->assertResponseOk();
        $this->assertResponseContains('administrateur');

        /*
         * Action buttons
         */
        $this->assertResponseContains('<a href="/roles" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> ' . __d('alaxos', 'list') . '</a>');
        $this->assertResponseContains('<a href="/roles/add" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> ' . __d('alaxos', 'add') . '</a>');
        $this->assertResponseContains('<a href="/roles/edit/1" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> ' . __d('alaxos', 'edit') . '</a>');
        $this->assertResponseContains('<a href="/roles/copy/1" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> ' . __d('alaxos', 'copy') . '</a>');
        $this->assertResponseRegExp('/<form name="post_[a-z0-9]+" style="display:none;" method="post" action="\/roles\/delete\/1">/');

        $entity   = TableRegistry::get('Roles')->get(1);
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
        $this->get('/roles/view/2');

        $this->assertResponseOk();

        $entity   = TableRegistry::get('Roles')->get(2);
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
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test deleteAll method
     *
     * @return void
     */
    public function testDeleteAll()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test copy method
     *
     * @return void
     */
    public function testCopy()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
