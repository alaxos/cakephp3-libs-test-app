<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<div class="users index">
    <h2><?= __('Users') ?></h2>

    <div class="panel panel-default">
        <div class="panel-heading">
        <?php
        echo $this->Navbars->actionButtons(['paginate_infos' => true, 'select_pagination_limit' => true]);
        ?>
        </div>
        <div class="panel-body">

            <div class="table-responsive">

            <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
            <thead>
            <tr class="sortHeader">
                <th  style="width:20px;"></th>
                <th><?= $this->Paginator->sort('role_id') ?></th>
                <th><?= $this->Paginator->sort('firstname') ?></th>
                <th><?= $this->Paginator->sort('lastname') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('external_uid') ?></th>
                <th style="width:160px;"><?= $this->Paginator->sort('last_login_date') ?></th>
                <th style="width:160px;"><?= $this->Paginator->sort('created') ?></th>
                <th style="width:160px;"><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"></th>
            </tr>

            <tr class="filterHeader">
                <td>
                    <?php
                    echo $this->AlaxosForm->checkbox('_Tech.selectAll', ['id' => 'TechSelectAll']);

                    echo $this->AlaxosForm->create($search_entity, array('url' => [], 'class' => 'form-horizontal', 'role' => 'form', 'novalidate' => 'novalidate'));
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('role_id');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('firstname');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('lastname');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('email');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('external_uid');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterDate('last_login_date');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterDate('created');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterDate('modified');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->button(___('filter'), ['class' => 'btn btn-default']);
                    echo $this->AlaxosForm->end();
                    ?>
                </td>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($users as $i => $user): ?>
            <tr>
                <td>
                    <?php
                    echo $this->AlaxosForm->checkBox('User.' . $i . '.id', array('value' => $user->id, 'class' => 'model_id'));
                    ?>
                </td>
                <td>
                    <?php echo $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : ''; ?>
                </td>
                <td>
                    <?php echo h($user->firstname); ?>
                </td>
                <td>
                    <?php echo h($user->lastname); ?>
                </td>
                <td>
                    <?php echo h($user->email); ?>
                </td>
                <td>
                    <?php echo h($user->external_uid); ?>
                </td>
                <td>
                    <?php echo h($user->to_display_timezone('last_login_date')); ?>
                </td>
                <td>
                    <?php echo h($user->to_display_timezone('created')); ?>
                </td>
                <td>
                    <?php echo h($user->to_display_timezone('modified')); ?>
                </td>
                <td class="actions">
                    <?php
                    echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', ['action' => 'view', $user->id], ['class' => 'to_view', 'escape' => false]);
                    echo '&nbsp;&nbsp;';
                    echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $user->id], ['escape' => false]);
                    echo '&nbsp;&nbsp;';
                    echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'escape' => false]);
                    ?>
                </td>

            </tr>
            <?php endforeach; ?>
            </tbody>
            </table>

            </div>

            <?php
            if(isset($users) && $users->count() > 0)
            {
                echo '<div class="row">';
                echo '<div class="col-md-1">';
                echo $this->AlaxosForm->postActionAllButton(__d('alaxos', 'delete all'), ['action' => 'delete_all'], ['confirm' => __d('alaxos', 'do you really want to delete the selected items ?')]);
                echo '</div>';
                echo '</div>';
            }
            ?>

            <div class="paging text-center">
                <ul class="pagination pagination-sm">
                    <?php
                    $this->Paginator->setTemplates(['ellipsis' => '<li class="ellipsis"><span>...</span></li>']);
                    echo $this->Paginator->prev('< ' . __('previous'));
                    echo $this->Paginator->numbers(['first' => 2, 'last' => 2]);
                    echo $this->Paginator->next(__('next') . ' >');
                    ?>
                </ul>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
    Alaxos.start();
});
</script>