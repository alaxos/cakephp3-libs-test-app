<?php
$menu = [];

//debug($logged_user);

// $menu[___('profiles')] = [
//     [
//         'title'   => ___('users'),
//         'url'     => ['plugin' => false, 'prefix' => false, 'controller' => 'Users', 'action' => 'index'],
//         'options' => ['id' => 'users']
//     ],
//     [
//         'title'   => ___('roles'),
//         'url'     => ['plugin' => false, 'prefix' => false, 'controller' => 'Roles', 'action' => 'index'],
//         'options' => ['id' => 'roles']
//     ]
// ];

$menu[] = [
        'title'   => ___('users'),
        'url'     => ['plugin' => false, 'prefix' => false, 'controller' => 'Users', 'action' => 'index'],
        'options' => ['id' => 'users']
    ];

$menu[] = [
        'title'   => ___('roles'),
        'url'     => ['plugin' => false, 'prefix' => false, 'controller' => 'Roles', 'action' => 'index'],
        'options' => ['id' => 'roles']
    ];

$menu[] = [
    'title'   => ___('things'),
    'url'     => ['plugin' => false, 'prefix' => false, 'controller' => 'Things', 'action' => 'index'],
    'options' => ['id' => 'things']
];


$menu['_right_'] = [];
if(isset($logged_user)) {

    $menu['_right_'][] = [
        'title'   => ___('logout') . ' (' . $logged_user->fullname . ')',
        'url'     => array('plugin' => false, 'prefix' => false, 'controller' => 'Users', 'action' => 'logout'),
        'options' => ['id' => 'logout']
    ];

} else {

    $menu['_right_'][] = [
        'title'   => ___('login'),
        'url'     => array('plugin' => false, 'prefix' => false, 'controller' => 'Users', 'action' => 'shiblogin'),
        'options' => ['id' => 'login']
    ];
}

$options = [];
$options['navbar_class'] = 'navbar navbar-default navbar-flat';

// debug($this->request->params);

/*******************************************/

if(!empty($menu))
{
    echo '<div class="row">';
        echo '<div class="col-md-12">';
        echo $this->Navbars->horizontalMenu($menu, $options);
        echo '</div>';
    echo '</div>';
}
