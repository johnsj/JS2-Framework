<?php 
global $input_variables;
$input_variables = array(
    'input_first_name' => '',
    'input_last_name' => '',
    'input_nationality' => '',
    'input_residence' => '',
    'input_programme' => '',
    'input_network' => '',
    'input_jayerole' => '',
    'input_email' => ''
);

$input_variables = apply_filters('js2_registration_input',$input_variables);

do_action('js2_registration_form_before');

echo apply_filters( 'js2_registration_form_print', $this->get_partial('form') );
  
do_action('js2_registration_form_after');