<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<div class="roles form">
    <fieldset>
        <legend><?= ___('copy role') ?></legend>

        <div class="panel panel-default">
            <div class="panel-heading">
            <?php
            echo $this->Navbars->actionButtons(['buttons_group' => 'add']);
            ?>
            </div>
            <div class="panel-body">

            <?php
            echo $this->AlaxosForm->create($role, ['class' => 'form-horizontal', 'role' => 'form', 'novalidate' => 'novalidate']);

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('name', __('name'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->control('name', ['label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<div class="col-sm-offset-2 col-sm-5">';
            echo $this->AlaxosForm->button(___('submit'), ['class' => 'btn btn-default']);
            echo '</div>';
            echo '</div>';

            echo $this->AlaxosForm->end();
            ?>
            </div>
        </div>
    </fieldset>
</div>
