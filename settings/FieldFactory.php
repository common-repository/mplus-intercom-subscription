<?php

namespace Mplus\Intercom\Settings;

use Mplus\Intercom\Settings\Fields\Text;
use Mplus\Intercom\Settings\Fields\Radio;
use Mplus\Intercom\Settings\Fields\Select;
use Mplus\Intercom\Settings\Fields\Checkbox;
use Mplus\Intercom\Settings\Fields\TextArea;
use Mplus\Intercom\Settings\Fields\GroupFields;
use Mplus\Intercom\Settings\Fields\AddOnsFields;
use Mplus\Intercom\Settings\Fields\HTML;

class FieldFactory {
	public static function get_field( $page_id, $field_id, $params ) {
		if ( 'text' == $params['type'] ) {
			return new Text( $page_id, $field_id, $params );
		}

		if ( 'textarea' == $params['type'] ) {
			return new TextArea( $page_id, $field_id, $params );
		}

		if ( 'select' == $params['type'] ) {
			return new Select( $page_id, $field_id, $params );
		}

		if ( 'checkbox' == $params['type'] ) {
			return new Checkbox( $page_id, $field_id, $params );
		}

		if ( 'radio' == $params['type'] ) {
			return new Radio( $page_id, $field_id, $params );
		}

		if ( 'group-fields' == $params['type'] ) {
			return new GroupFields( $page_id, $field_id, $params );
		}

		if ( 'addons' == $params['type'] ) {
			return new AddOnsFields( $page_id, $field_id, $params );
		}
		
		if ( 'html' == $params['type'] ) {
			return new HTML( $page_id, $field_id, $params );
		}
	}
}
