<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Thing[]|\Cake\Collection\CollectionInterface $things
 */
?>

<div class="things index">
    <h2><?= __('Things') ?></h2>

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
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('int_field') ?></th>
                <th><?= $this->Paginator->sort('smallint_field') ?></th>
                <th><?= $this->Paginator->sort('bigint_field') ?></th>
                <th><?= $this->Paginator->sort('decimal_field') ?></th>
                <th><?= $this->Paginator->sort('float_field') ?></th>
                <th><?= $this->Paginator->sort('double_field') ?></th>
                <th><?= $this->Paginator->sort('real_field') ?></th>
                <th><?= $this->Paginator->sort('boolean_field') ?></th>
                <th style="width:160px;"><?= $this->Paginator->sort('date_field') ?></th>
                <th style="width:160px;"><?= $this->Paginator->sort('datetime_field') ?></th>
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
                    echo $this->AlaxosForm->filterField('user_id');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('name');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('int_field');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('smallint_field');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('bigint_field');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('decimal_field');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('float_field');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('double_field');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('real_field');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterField('boolean_field');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterDate('date_field');
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->AlaxosForm->filterDate('datetime_field');
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
            <?php foreach ($things as $i => $thing): ?>
            <tr>
                <td>
                    <?php
                    echo $this->AlaxosForm->checkBox('Thing.' . $i . '.id', array('value' => $thing->id, 'class' => 'model_id'));
                    ?>
                </td>
                <td>
                    <?php echo $thing->has('user') ? $this->Html->link($thing->user->firstname, ['controller' => 'Users', 'action' => 'view', $thing->user->id]) : ''; ?>
                </td>
                <td>
                    <?php echo h($thing->name); ?>
                </td>
                <td>
                    <?php echo $this->Number->format($thing->int_field); ?>
                </td>
                <td>
                    <?php echo $this->Number->format($thing->smallint_field); ?>
                </td>
                <td>
                    <?php echo $this->Number->format($thing->bigint_field); ?>
                </td>
                <td>
                    <?php echo $this->Number->format($thing->decimal_field); ?>
                </td>
                <td>
                    <?php echo $this->Number->format($thing->float_field); ?>
                </td>
                <td>
                    <?php echo $this->Number->format($thing->double_field); ?>
                </td>
                <td>
                    <?php echo $this->Number->format($thing->real_field); ?>
                </td>
                <td>
                    <?php $this->AlaxosHtml->yesNo($thing->boolean_field); ?>
                </td>
                <td>
                    <?php echo h($thing->to_display_timezone('date_field')); ?>
                </td>
                <td>
                    <?php echo h($thing->to_display_timezone('datetime_field')); ?>
                </td>
                <td>
                    <?php echo h($thing->to_display_timezone('created')); ?>
                </td>
                <td>
                    <?php echo h($thing->to_display_timezone('modified')); ?>
                </td>
                <td class="actions">
                    <?php
                    echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', ['action' => 'view', $thing->id], ['class' => 'to_view', 'escape' => false]);
                    echo '&nbsp;&nbsp;';
                    echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $thing->id], ['escape' => false]);
                    echo '&nbsp;&nbsp;';
                    echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>', ['action' => 'delete', $thing->id], ['confirm' => __('Are you sure you want to delete # {0}?', $thing->id), 'escape' => false]);
                    ?>
                </td>

            </tr>
            <?php endforeach; ?>
            </tbody>
            </table>

            </div>

            <?php
            if(isset($things) && $things->count() > 0)
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