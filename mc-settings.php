<?php
add_action( 'admin_menu', 'mc_add_admin_menu' );
add_action( 'admin_init', 'mc_settings_init' );

/**
 * Creating menu in admin side under tools menu.
 */
function mc_add_admin_menu() {

	add_submenu_page( 'tools.php', 'Mortgage Calculator', 'Mortgage Calculator', 'manage_options', 'mortgage_calculator', 'mc_options_page' );

}

/**
 * Creating Setting fields
 */
function mc_settings_init() {

	register_setting( 'mc_setting_page', 'mc_settings' );

	add_settings_section(
		'mc_setting_page_section',
		__( 'Mortgage Calculator Setting Page', 'mc' ),
		'mc_settings_section_callback',
		'mc_setting_page'
	);

	add_settings_field(
		'mc_currency_sign_field',
		__( 'Currency Sign', 'mc' ),
		'mc_currency_sign_field_render',
		'mc_setting_page',
		'mc_setting_page_section'
	);

	add_settings_field(
		'mc_currency_sign_position_field',
		__( 'Currency Sign Position', 'mc' ),
		'mc_currency_sign_position_field_render',
		'mc_setting_page',
		'mc_setting_page_section'
	);

	add_settings_field(
		'mc_thousand_separator_field',
		__( 'Thousand Separator', 'mc' ),
		'mc_thousand_separator_field_render',
		'mc_setting_page',
		'mc_setting_page_section'
	);

	add_settings_field(
		'mc_decimal_separator_field',
		__( 'Decimal Separator', 'mc' ),
		'mc_decimal_separator_field_render',
		'mc_setting_page',
		'mc_setting_page_section'
	);

	add_settings_field(
		'mc_number_of_decimals_field',
		__( 'Number of Decimals', 'mc' ),
		'mc_number_of_decimals_field_render',
		'mc_setting_page',
		'mc_setting_page_section'
	);

}

/**
 * Getting Currency Sign
 */
function mc_currency_sign_field_render() {
	$options = get_option( 'mc_settings' );
	?>
	<input type='text' name='mc_settings[mc_currency_sign_field]' value='<?php echo sanitize_text_field( $options[ 'mc_currency_sign_field' ] ); ?>'>
	<?php

}

/**
 * Getting Currency Sign position
 */
function mc_currency_sign_position_field_render() {
	$options = get_option( 'mc_settings' );
	?>
	<select name='mc_settings[mc_currency_sign_position_field]'>
		<option value='1' <?php selected( $options['mc_currency_sign_position_field'], 1 ); ?>><?php _e( 'Before', 'mc' ); ?></option>
		<option value='2' <?php selected( $options['mc_currency_sign_position_field'], 2 ); ?>><?php _e( 'After', 'mc' ); ?></option>
	</select>
	<?php

}

/**
 * Getting Thousand separator
 */
function mc_thousand_separator_field_render() {
	$options = get_option( 'mc_settings' );
	?>
	<input type='text' name='mc_settings[mc_thousand_separator_field]' value='<?php echo sanitize_text_field( $options[ 'mc_thousand_separator_field' ] ); ?>'>
	<?php

}

/**
 * Getting Decimal Separator
 */
function mc_decimal_separator_field_render() {
	$options = get_option( 'mc_settings' );
	?>
	<input type='text' name='mc_settings[mc_decimal_separator_field]' value='<?php echo sanitize_text_field( $options[ 'mc_decimal_separator_field' ] ); ?>'>
	<?php

}

/**
 * Getting number of decimal
 */
function mc_number_of_decimals_field_render() {
	$options = get_option( 'mc_settings' );
	?>
	<input type='text' name='mc_settings[mc_number_of_decimals_field]' value='<?php echo sanitize_text_field( $options[ 'mc_number_of_decimals_field' ] ); ?>'>
	<?php

}

/**
 * Call back Function
 */
function mc_settings_section_callback() {
	echo __( 'In this page you can control price format. ', 'mc' );

}

/**
 * Gathering all options and creating a form
 */
function mc_options_page() {
	echo "<form action='options.php' method='post'>" ;

	settings_fields( 'mc_setting_page' );
	do_settings_sections( 'mc_setting_page' );
	submit_button();

	echo "</form>" ;

}

?>