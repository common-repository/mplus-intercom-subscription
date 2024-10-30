<?php
namespace Mplus\Intercom\Settings\Fields;

use Mplus\Intercom\Settings\Field as Field;

class HTML extends Field{
    private $page_id;
    private $params;
    public function __construct($page_id, $field_id, $params){
        $this->page_id = $page_id;
        $this->params = $params;
        parent::__construct($field_id);
    }
    public function render(){
        if(is_callable($this->params['content'])){
            call_user_func($this->params['content']);
        }else{
            echo $this->params['content'];
        }
    }
}