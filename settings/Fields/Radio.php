<?php
namespace Mplus\Intercom\Settings\Fields;

use Mplus\Intercom\Settings\Field as Field;

class Radio extends Field{
    private $page_id;
    private $params;
    public function __construct($page_id, $field_id, $params){
        $this->page_id = $page_id;
        $this->params = $params;
        parent::__construct($field_id);
    }
    public function render(){
        ?>
        <div><?php echo $this->params['label']; ?></div>
        <?php foreach( $this->params['options'] as $val => $lbl ): ?>
            <input type="radio"
            name="<?php echo $this->field_id; ?>"
            id="<?php echo $this->field_id . $val; ?>"
            value="<?php echo $val; ?>"
            <?php checked($val, $this->get_value()); ?>
            >
            <label for="<?php echo $this->field_id . $val; ?>"><?php echo $lbl; ?></label>
        <?php endforeach; ?>
        <?php if(isset($this->params['desc'])): ?>
            <div class="description"><?php echo $this->params['desc']; ?></div>
        <?php endif; ?>
        <?php
    }
}