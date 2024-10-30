<?php

namespace Mplus\Intercom\Settings\Fields;

use Mplus\Intercom\Settings\FieldFactory;
use Mplus\Intercom\Settings\Field as Field;

class GroupFields extends Field {
	private $page_id;
	private $params;
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
            <?php if ( ! isset( $this->params['addons-group'] ) ) { ?>
            <fieldset class="mplus-fieldsContainer-fieldset">
            <?php } ?>
            <?php
                foreach ( $this->params['fields'] as $field_id => $field ) {
                    $field = FieldFactory::get_field( $this->page_id, $field_id, $field );

                    if ( $field ) {
                        // echo '<fieldset class="mplus-fieldsContainer-fieldset">';
                        $field->render();
                        // echo '</fieldset>';
                    }
                }
            ?>
            <?php if ( ! isset( $this->params['addons-group'] ) ) { ?>
            </fieldset>
            <?php } ?>
        </div>
        <?php
	}
}
