<?php

namespace Mplus\Intercom\Settings;

class Field{
    protected $field_id;
    public function __construct($field_id){
        $this->field_id = $field_id;
    }
    public function get_value(){
        $mplusis_settings = get_option($this->field_id, $this->params['default'] ?? false);
        return $mplusis_settings;
    }
}