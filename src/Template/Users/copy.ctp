<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form">
    <fieldset>
        <legend><?= ___('copy user') ?></legend>

        <div class="panel panel-default">
            <div class="panel-heading">
            <?php
            echo $this->Navbars->actionButtons(['buttons_group' => 'add']);
            ?>
            </div>
            <div class="panel-body">

            <?php
            echo $this->AlaxosForm->create($user, ['class' => 'form-horizontal', 'role' => 'form', 'novalidate' => 'novalidate']);

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('role_id', __('role_id'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->control('role_id', ['options' => $roles, 'label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('firstname', __('firstname'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->control('firstname', ['label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('lastname', __('lastname'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->control('lastname', ['label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('email', __('email'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->control('email', ['label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('external_uid', __('external_uid'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->control('external_uid', ['label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('last_login_date', __('last_login_date'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->control('last_login_date', ['empty' => true, 'label' => false, 'class' => 'form-control']);
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
