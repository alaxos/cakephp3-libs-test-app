<?php
echo '<div style="margin-top:50px"></div>';

if ($this->request->is('post')) {
    debug($this->request->getData());
}

echo '<fieldset>';
echo '<legend>';
echo __('simple form');
echo '</legend>';

echo $this->AlaxosForm->create($thing, ['class' => 'form-horizontal', 'role' => 'form', 'novalidate' => 'novalidate']);

echo '<div class="form-group">';
echo $this->AlaxosForm->label('date_field', __('date_field'), ['class' => 'col-sm-2 control-label']);
echo '<div class="col-sm-5">';
echo $this->AlaxosForm->control('date_field', ['empty' => true, 'label' => false, 'class' => 'form-control', 'js_options' => ['datepicker' => ['format' => 'dd-mm-yyyy']]]);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo $this->AlaxosForm->label('datetime_field', __('datetime_field'), ['class' => 'col-sm-2 control-label']);
echo '<div class="col-sm-5">';
echo $this->AlaxosForm->control('datetime_field', ['empty' => true, 'label' => false, 'class' => 'form-control', 'js_options' => ['datepicker' => ['format' => 'dd-mm-yyyy']]]);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo '<div class="col-sm-offset-2 col-sm-5">';
echo $this->AlaxosForm->button(___('submit'), ['class' => 'btn btn-default']);
echo '</div>';
echo '</div>';

echo $this->AlaxosForm->end();

echo '</fieldset>';


echo '<fieldset>';
echo '<legend>';
echo __('filters');
echo '</legend>';

echo $this->AlaxosForm->create($thing, ['class' => 'form-horizontal', 'role' => 'form', 'novalidate' => 'novalidate']);

echo '<div class="form-group">';
echo $this->AlaxosForm->label('date_field', __('date_field'), ['class' => 'col-sm-2 control-label']);
echo '<div class="col-sm-5">';
echo $this->AlaxosForm->filterField('date_field');
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo $this->AlaxosForm->label('datetime_field', __('datetime_field'), ['class' => 'col-sm-2 control-label']);
echo '<div class="col-sm-5">';
echo $this->AlaxosForm->filterField('datetime_field');
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo '<div class="col-sm-offset-2 col-sm-5">';
echo $this->AlaxosForm->button(___('submit'), ['class' => 'btn btn-default']);
echo '</div>';
echo '</div>';

echo $this->AlaxosForm->end();

echo '</fieldset>';