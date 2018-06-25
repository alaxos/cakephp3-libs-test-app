<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role[]|\Cake\Collection\CollectionInterface $roles
 */
?>

<div class="roles index">
    <h2><?= __('Roles') ?></h2>

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
                <th><?= $this->Paginator->sort('name') ?></th>
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
                    echo $this->AlaxosForm->filterField('name');
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
            <?php foreach ($roles as $i => $role): ?>
            <tr>
                <td>
                    <?php
                    echo $this->AlaxosForm->checkBox('Role.' . $i . '.id', array('value' => $role->id, 'class' => 'model_id'));
                    ?>
                </td>
                <td>
                    <?php echo h($role->name); ?>
                </td>
                <td>
                    <?php echo h($role->to_display_timezone('created')); ?>
                </td>
                <td>
                    <?php echo h($role->to_display_timezone('modified')); ?>
                </td>
                <td class="actions">
                    <?php
                    echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', ['action' => 'view', $role->id], ['class' => 'to_view', 'escape' => false]);
                    echo '&nbsp;&nbsp;';
                    echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $role->id], ['escape' => false]);
                    echo '&nbsp;&nbsp;';
                    echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>', ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id), 'escape' => false]);
                    ?>
                </td>

            </tr>
            <?php endforeach; ?>
            </tbody>
            </table>

            </div>

            <?php
            if(isset($roles) && $roles->count() > 0)
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