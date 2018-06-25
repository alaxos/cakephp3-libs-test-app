<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users view">
    <h3><?php echo h($user->id) ?></h3>

    <div class="panel panel-default">
        <div class="panel-heading">
        <?php
        echo $this->Navbars->actionButtons(['buttons_group' => 'view', 'model_id' => $user->id]);
        ?>
        </div>
        <div class="panel-body">
            <dl class="dl-horizontal">

                <dt><?php echo __('Role'); ?></dt>
                <dd>
                    <?php
                    echo $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '';
                    ?>
                </dd>
                <dt><?php echo __('Firstname'); ?></dt>
                <dd>
                    <?php
                    echo h($user->firstname);
                    ?>
                </dd>
                <dt><?php echo __('Lastname'); ?></dt>
                <dd>
                    <?php
                    echo h($user->lastname);
                    ?>
                </dd>
                <dt><?php echo __('Email'); ?></dt>
                <dd>
                    <?php
                    echo h($user->email);
                    ?>
                </dd>
                <dt><?php echo __('External Uid'); ?></dt>
                <dd>
                    <?php
                    echo h($user->external_uid);
                    ?>
                </dd>
                <dt><?php echo __('Last Login Date'); ?></dt>
                <dd>
                    <?php
                    echo h($user->to_display_timezone('last_login_date'));
                    ?>
                </dd>
            </dl>
            <?php
            echo $this->element('Alaxos.create_update_infos', ['entity' => $user], ['plugin' => 'Alaxos']);
            ?>
        </div>
    </div>
</div>
