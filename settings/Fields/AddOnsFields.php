<?php

namespace Mplus\Intercom\Settings\Fields;

use Mplus\Intercom\Settings\Field as Field;

class AddOnsFields extends Field {
	private $page_id;
	private $params;
	public function __construct( $page_id, $field_id, $params ) {
		$this->page_id = $page_id;
		$this->params  = $params;
		parent::__construct( $field_id );
	}
	public function render() {
		$args = [
			'add-to-cart' => $this->params['product_id'],
			'utm_content' => 'intercom_settings_page_addon_list'
		];
		$cart_url = add_query_arg( $args, $this->params['product_url'] );
		?>
		<fieldset class="mplus-fieldsContainer-fieldset">
			<div class="add-on-container ">
				<div class="mplus-field">
					<div class="mplus-flex">
						<h4 class="mplus-title3"><?php echo esc_attr( $this->params['label'] ); ?></h4>
					</div>
				</div>
				<div class="mplus-field mplus-addon">
					<div class="mplus-flex">
						<div class="mplus-addon-logo">
							<img src="<?php echo esc_url( $this->params['image_url'] ); ?>" width="152" height="135" alt="">
						</div>
						<div class="mplus-addon-text">
							<div class="mplus-field-description">
								<?php echo esc_textarea( $this->params['desc'] ); ?>
							</div>
							<a class="mplus-button" href="<?php echo esc_url( $cart_url ); ?>" target="_blank">I Want This</a>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<?php
	}
}
