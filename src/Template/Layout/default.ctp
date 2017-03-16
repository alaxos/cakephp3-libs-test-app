<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?php
    echo $this->AlaxosHtml->includeBootstrapCSS(['block' => false]);
    echo $this->AlaxosHtml->includeAlaxosCSS(['block' => false]);
    echo $this->AlaxosHtml->css('cakephp3-libs-test');

    echo $this->AlaxosHtml->includeAlaxosJQuery(['block' => false]);
    echo $this->AlaxosHtml->includeAlaxosBootstrapJS(['block' => false]);
    ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div id="container" class="container">

        <div class="row">
            <div class="col-md-12">
                <header>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
                            <?php
                            echo '<div id="top_logo" style="background-color:#D33C44;">';
                            echo $this->Html->image('cake-logo.png');
                            echo '</div>';
                            ?>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
                            <?php
                            echo '<h1 id="application_title">';
                            echo $this->Html->link(__("CakePHP v3.x test application"), '/');
                            echo '</h1>';
                            ?>
                        </div>
                    </div>
                </header>
            </div>
        </div>

        <?php
        echo $this->element('menus/top');
        ?>

        <div id="content" class="row">
            <div class="col-md-12">

                <?= $this->Flash->render() ?>
                <?= $this->Flash->render('auth') ?>

                <?= $this->fetch('content') ?>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <footer id="footer">

                    <div class="row">

                        <?php
                        echo '<div class="col-md-12 text-right">';
                        echo __('footer');
                        echo '</div>';
                        ?>

                    </div>

                </footer>
            </div>
        </div>

    </div>


</body>
</html>
