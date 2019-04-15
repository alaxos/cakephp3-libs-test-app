<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Thing $thing
 */
?>
<div class="things view">
    <h3><?php echo h($thing->name) ?></h3>

    <div class="panel panel-default">
        <div class="panel-heading">
        <?php
        echo $this->Navbars->actionButtons(['buttons_group' => 'view', 'model_id' => $thing->id]);
        ?>
        </div>
        <div class="panel-body">
            <dl class="dl-horizontal">

                <dt><?php echo __('User'); ?></dt>
                <dd>
                    <?php
                    echo $thing->has('user') ? $this->Html->link($thing->user->firstname, ['controller' => 'Users', 'action' => 'view', $thing->user->id]) : '';
                    ?>
                </dd>
                <dt><?php echo __('Name'); ?></dt>
                <dd>
                    <?php
                    echo h($thing->name);
                    ?>
                </dd>
                <dt><?php echo __('Int Field'); ?></dt>
                <dd>
                    <?php
                    echo $this->Number->format($thing->int_field);
                    ?>
                </dd>
                <dt><?php echo __('Smallint Field'); ?></dt>
                <dd>
                    <?php
                    echo $this->Number->format($thing->smallint_field);
                    ?>
                </dd>
                <dt><?php echo __('Bigint Field'); ?></dt>
                <dd>
                    <?php
                    echo $this->Number->format($thing->bigint_field);
                    ?>
                </dd>
                <dt><?php echo __('Decimal Field'); ?></dt>
                <dd>
                    <?php
                    echo $this->Number->format($thing->decimal_field);
                    ?>
                </dd>
                <dt><?php echo __('Float Field'); ?></dt>
                <dd>
                    <?php
                    echo $this->Number->format($thing->float_field);
                    ?>
                </dd>
                <dt><?php echo __('Double Field'); ?></dt>
                <dd>
                    <?php
                    echo $this->Number->format($thing->double_field);
                    ?>
                </dd>
                <dt><?php echo __('Real Field'); ?></dt>
                <dd>
                    <?php
                    echo $this->Number->format($thing->real_field);
                    ?>
                </dd>
                <dt><?php echo __('Date Field'); ?></dt>
                <dd>
                    <?php
                    echo h($thing->to_display_timezone('date_field'));
                    ?>
                </dd>
                <dt><?php echo __('Datetime Field'); ?></dt>
                <dd>
                    <?php
                    echo h($thing->to_display_timezone('datetime_field'));
                    ?>
                </dd>
                <dt><?php echo __('Boolean Field'); ?></dt>
                <dd>
                    <?php
                    echo $thing->boolean_field ? __('Yes') : __('No');
                    ?>
                </dd>
                <dt><?php echo __('Description'); ?></dt>
                <dd>
                    <?php
                    echo $this->Text->autoParagraph(h($thing->description));
                    ?>
                </dd>
            </dl>
            <?php
            echo $this->element('Alaxos.create_update_infos', ['entity' => $thing], ['plugin' => 'Alaxos']);
            ?>
        </div>
    </div>
</div>
