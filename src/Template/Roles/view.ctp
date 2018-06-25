<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<div class="roles view">
    <h3><?php echo h($role->name) ?></h3>

    <div class="panel panel-default">
        <div class="panel-heading">
        <?php
        echo $this->Navbars->actionButtons(['buttons_group' => 'view', 'model_id' => $role->id]);
        ?>
        </div>
        <div class="panel-body">
            <dl class="dl-horizontal">
                <dt><?php echo __('Name'); ?></dt>
                <dd>
                    <?php
                    echo h($role->name);
                    ?>
                </dd>
            </dl>
            <?php
            echo $this->element('Alaxos.create_update_infos', ['entity' => $role], ['plugin' => 'Alaxos']);
            ?>
        </div>
    </div>
</div>
