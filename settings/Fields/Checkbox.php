<?php

namespace Mplus\Intercom\Settings\Fields;

use Mplus\Intercom\Settings\Field as Field;

class Checkbox extends Field {
	private $page_id;
	protected $params;
	public function __construct( $page_id, $field_id, $params ) {
		$this->page_id = $page_id;
		$this->params  = $params;
		parent::__construct( $field_id );
	}
	public function render() {
		?>
        <?php if ( isset( $this->params['header'] ) ) { ?>
        <div class="mplus-optionHeader ">
            <h3 class="mplus-title2"><?php echo $this->params['header']; ?></h3>
            <!-- <a href="#" class="mplus-infoAction mplus-infoAction--help mplus-icon-help" target="_blank">Need Help?</a> -->
        </div>
        <?php } ?>

        <div class="mplus-fieldsContainer">
            <?php if ( isset( $this->params['desc'] ) ) { ?>
                <div class="mplus-fieldsContainer-description"><?php echo $this->params['desc']; ?></div>
            <?php } ?>

            <fieldset class="mplus-fieldsContainer-fieldset">
                <div class="mplus-field mplus-field--checkbox">
                    <div class="mplus-checkbox">
                        <input type="checkbox"
                            id="<?php echo $this->field_id; ?>"
                            class="<?php echo $this->page_id; ?>-field"
                            name="<?php echo $this->field_id; ?>"
                            value="<?php echo $this->params['value']; ?>"
                            <?php checked( $this->get_value(), $this->params['value'] ); ?>
                        />
                        <label for="<?php echo $this->field_id; ?>" class=""><?php echo $this->params['label']; ?></label>
                    </div>
                </div>
            </fieldset>
        </div>
        <?php
	}
}
