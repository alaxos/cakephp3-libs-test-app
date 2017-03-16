<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="users form">

    <fieldset>
        <legend><?= ___('edit user') ?></legend>

        <div class="panel panel-default">
            <div class="panel-heading">
            <?php
            echo $this->Navbars->actionButtons(['buttons_group' => 'edit', 'model_id' => $user->id]);
            ?>
            </div>
            <div class="panel-body">

            <?php
            echo $this->AlaxosForm->create($user, ['class' => 'form-horizontal', 'role' => 'form', 'novalidate' => 'novalidate']);

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('role_id', __('role_id'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->input('role_id', ['options' => $roles, 'label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('firstname', __('firstname'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->input('firstname', ['label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('lastname', __('lastname'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->input('lastname', ['label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('email', __('email'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->input('email', ['label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('external_uid', __('external_uid'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->input('external_uid', ['label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo $this->AlaxosForm->label('last_login_date', __('last_login_date'), ['class' => 'col-sm-2 control-label']);
            echo '<div class="col-sm-5">';
            echo $this->AlaxosForm->input('last_login_date', ['label' => false, 'class' => 'form-control']);
            echo '</div>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<div class="col-sm-offset-2 col-sm-5">';
            echo $this->AlaxosForm->button(___d('alaxos', 'submit'), ['class' => 'btn btn-default']);
            echo '</div>';
            echo '</div>';

            echo $this->AlaxosForm->end();
            ?>
            </div>
        </div>

    </fieldset>

</div>
