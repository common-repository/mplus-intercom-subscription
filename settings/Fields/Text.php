<?php
namespace Mplus\Intercom\Settings\Fields;

use Mplus\Intercom\Settings\Field as Field;

class Text extends Field{
    private $page_id;
    private $params;
    public function __construct($page_id, $field_id, $params){
        $this->page_id = $page_id;
        $this->params = $params;
        parent::__construct($field_id);
    }
    public function render(){
        $value = $this->get_value();
        if( empty( $value ) && isset( $this->params['value'] )){
            $value = $this->params['value'];
        }
        ?>
        <?php if ( isset( $this->params['header'] ) ) { ?>
        <div class="mplus-optionHeader ">
            <h3 class="mplus-title2"><?php echo $this->params['header']; ?></h3>
            <!-- <a href="#" class="mplus-infoAction mplus-infoAction--help mplus-icon-help" target="_blank">Need Help?</a> -->
        </div>
        <?php } ?>

        <div id="<?php echo $this->field_id; ?>-container" class="mplus-fieldsContainer">
            <?php if ( isset( $this->params['desc'] ) ) { ?>
                <div class="mplus-fieldsContainer-description"><?php echo $this->params['desc']; ?></div>
            <?php } ?>

            <fieldset class="mplus-fieldsContainer-fieldset">
                <div class="mplus-field mplus-field--text">
                    <div class="mplus-text">
                        <?php if ( isset( $this->params['label'] ) ) { ?>
                            <label for="<?php echo $this->field_id; ?>" class=""><?php echo $this->params['label']; ?></label>
                        <?php } ?>
                        <input type="text"
                            id="<?php echo $this->field_id; ?>"
                            class="<?php echo $this->page_id; ?>-field"
                            name="<?php echo $this->field_id; ?>"
                            value="<?php echo $value; ?>"
                            placeholder="<?php echo $this->params['placeholder'] ?? ''; ?>"
                            <?php echo $this->params['readonly'] ?? ''; ?>
                        />
                        <?php if ( isset( $this->params['infodesc'] ) ) { ?>
                            <div class="mplus-fieldsContainer-description"><?php echo $this->params['infodesc']; ?></div>
                        <?php } ?>
                    </div>
                </div>
            </fieldset>
        </div>
        <?php
    }
}