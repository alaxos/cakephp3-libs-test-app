<?php

//$this->AlaxosHtml->includeAlaxosJS();
//echo $this->AlaxosHtml->script('/alaxos/js/jquery/jquery-ui.min');
//$this->AlaxosHtml->includeAlaxosBootstrapDatepickerJS();
//$this->AlaxosHtml->includeAlaxosBootstrapDatepickerCSS();

echo $this->AlaxosHtml->script('/alaxos/js/alaxos/dateWidget');

echo '<div style="margin-top:150px"></div>';

echo $this->AlaxosForm->create($thing, ['class' => 'form-horizontal', 'role' => 'form', 'novalidate' => 'novalidate']);

echo '<div class="form-group">';
echo $this->AlaxosForm->label('date_field', __('date_field'), ['class' => 'col-sm-2 control-label']);
echo '<div class="col-sm-5">';
echo $this->AlaxosForm->control('date_field', ['empty' => true, 'label' => false, 'class' => 'form-control', 'js_options' => ['datepicker' => ['format' => 'dd-mm-yyyy']]]);
echo '</div>';
echo '</div>';

//echo '<div class="form-group">';
//echo $this->AlaxosForm->label('date_field_test1', __('lower date'), ['class' => 'col-sm-2 control-label']);
//echo '<div class="col-sm-5">';
//echo $this->AlaxosForm->control('date_field_test1', ['value' => '25.04.2019', 'id' => 'date_field_test1', 'label' => false, 'class' => 'form-control']);
//echo '</div>';
//echo '</div>';
//
//echo '<div class="form-group">';
//echo $this->AlaxosForm->label('date_field_test2', __('upper date'), ['class' => 'col-sm-2 control-label']);
//echo '<div class="col-sm-5">';
//echo $this->AlaxosForm->control('date_field_test2', ['id' => 'date_field_test2', 'label' => false, 'class' => 'form-control']);
//echo '</div>';
//echo '</div>';

echo '<div class="form-group">';
echo '<div class="col-sm-offset-2 col-sm-5">';
echo $this->AlaxosForm->button(___('submit'), ['class' => 'btn btn-default']);
echo '</div>';
echo '</div>';

echo $this->AlaxosForm->end();
?>
<script type="text/javascript">
    $(document).ready(function(){
        var dateWidget1 = $("#date_field_test1").datewidget({
            datepicker: {
                format : 'dd.mm.yyyy',
                language: "fr"
            },
            auto_complete_date : false,
            upper_datepicker_selector : "#date_field_test2"
        });

        var dateWidget2 = $("#date_field_test2").datewidget({
            datepicker: {
                format : 'dd.mm.yyyy',
                language: "fr"
            },
        });
    });

</script>
