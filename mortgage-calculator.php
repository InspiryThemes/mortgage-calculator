<?php
/**
 * Plugin Name:     Mortgage Calculator
 * Plugin URI:      https://github.com/InspiryThemes/mortgage-calculator
 * Description:     It provides an easy to use mortgage calculator widget.
 * Version:         1.0.3
 * Author:          Inspiry Themes
 * Author URI:      https://inspirythemes.com/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     mc
 * Domain Path:     /languages
 */

/**
 *  Make sure the plugin is accessed through the appropriate channels
 */
defined('ABSPATH') || die;

/**
 * The current version of the Plugin.
 */
define( 'MORTGAGE_CALCULATOR_VERSION', '1.0.3' );


class MC_Mortgage_Calculator extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'mortgage-calculator',
            __( 'Mortgage Calculator', 'mc' ),
            array ( 'description' => __( 'It provides an easy to use mortgage calculator widget.', 'mc' ) )
        );
    }


    /**
     * Creating widget front-end - This is where the action happens.
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {

        $title  = ( isset( $instance['title'] ) && ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Monthly Mortgage Payments', 'mc' );
        $title  = apply_filters( 'widget_title', $title );

        $mc_total_amount_label      = ( isset( $instance['mc_total_amount_label'] ) && ! empty( $instance['mc_total_amount_label'] ) )          ? $instance['mc_total_amount_label']    : __( 'Total Amount', 'mc' );
        $mc_down_payment_label      = ( isset( $instance['mc_down_payment_label'] ) && ! empty( $instance['mc_down_payment_label'] ) )          ? $instance['mc_down_payment_label']    : __( 'Down Payment', 'mc' );
        $mc_interest_rate_label     = ( isset( $instance['mc_interest_rate_label'] ) && ! empty( $instance['mc_interest_rate_label'] ) )        ? $instance['mc_interest_rate_label']   : __( 'Interest Rate', 'mc' );
        $mc_mortgage_period_label   = ( isset( $instance['mc_mortgage_period_label'] ) && ! empty( $instance['mc_mortgage_period_label'] ) )    ? $instance['mc_mortgage_period_label'] : __( 'Mortgage Period', 'mc' );

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>
        <div class="mc-wrapper clearfx">
            <form id="mc-form" action="#mc-form">
                <p>
                    <label for="mc-total-amount"><?php echo esc_html( $mc_total_amount_label ); ?></label>
                    <input type="number" name="mc_total_amount_label" id="mc-total-amount" min="1" class="required" placeholder="<?php echo mc_get_option( 'mc_currency_sign', 'mc_settings', '$' ); ?>" value="<?php echo apply_filters( 'mc_total_amount', null ); ?>"/>
                </p>
                <p>
                    <label for="mc-down-payment"><?php echo esc_html( $mc_down_payment_label ); ?></label>
                    <input type="number" name="mc_down_payment_label" id="mc-down-payment" min="1" class="required" placeholder="<?php echo mc_get_option( 'mc_currency_sign', 'mc_settings', '$' ); ?>">
                </p>
                <p>
                    <label for="mc-interest-rate"><?php echo esc_html( $mc_interest_rate_label ); ?></label>
                    <input type="number" name="mc_interest_rate_label" id="mc-interest-rate" min="1" class="required" placeholder="<?php esc_html_e( '%', 'mc' ); ?>">
                </p>
                <p>
                    <label for="mc-mortgage-period"><?php echo esc_html( $mc_mortgage_period_label ); ?></label>
                    <input type="number" name="mc_mortgage_period_label" id="mc-mortgage-period" class="required" placeholder="<?php esc_html_e( 'Years', 'mc' ); ?>">
                </p>
                <p>
                    <input type="submit" id="mc-submit" value="<?php esc_html_e( 'Calculate Mortgage', 'mc' ); ?>">
                </p>
            </form>

            <!-- This div is holding output values-->
            <div id="mc-output" class="clearfix"></div>
        </div>

        <?php echo $args['after_widget'];
    }

    /**
     * Widget Backend
     * @param array $instance
     */
    public function form( $instance ) {
        $title               = isset( $instance['title'] )              ? $instance['title']              : __( 'Monthly Mortgage Payments', 'mc' );
        $mc_total_amount_label     = isset( $instance['mc_total_amount_label'] )    ? $instance['mc_total_amount_label']    : __( 'Total Amount', 'mc' );
        $mc_down_payment_label     = isset( $instance['mc_down_payment_label'] )    ? $instance['mc_down_payment_label']    : __( 'Down Payment', 'mc' );
        $mc_interest_rate_label    = isset( $instance['mc_interest_rate_label'] )   ? $instance['mc_interest_rate_label']   : __( 'Interest Rate', 'mc' );
        $mc_mortgage_period_label  = isset( $instance['mc_mortgage_period_label'] ) ? $instance['mc_mortgage_period_label'] : __( 'Mortgage Period', 'mc' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                <?php echo esc_html__( 'Title', 'mc' ) . ':'; ?>
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                   type="text"
                   value="<?php if(isset($title)){echo esc_attr( $title );} ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'mc-total-amount' ) ); ?>">
                <?php echo esc_html__( 'Total Amount Label', 'mc' ) . ':'; ?>
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr( $this->get_field_id( 'mc-total-amount' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'mc_total_amount_label' ) ); ?>"
                   type="text"
                   value="<?php if(isset($mc_total_amount_label)){echo esc_attr( $mc_total_amount_label );} ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'mc-down-payment' ) ); ?>">
                <?php echo esc_html__( 'Down Payment Label', 'mc' ) . ':'; ?>
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr( $this->get_field_id( 'mc-down-payment' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'mc_down_payment_label' ) ); ?>"
                   type="text"
                   value="<?php if(isset($mc_down_payment_label)){echo esc_attr( $mc_down_payment_label );} ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'mc-interest-rate' ) ); ?>">
                <?php echo esc_html__( 'Interest Rate Label', 'mc' ) . ':'; ?>
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr( $this->get_field_id( 'mc-interest-rate' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'mc_interest_rate_label' ) ); ?>"
                   type="text"
                   value="<?php if(isset($mc_interest_rate_label)){echo esc_attr( $mc_interest_rate_label );} ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'mc-mortgage-period' ) ); ?>">
                <?php echo esc_html__( 'Mortgage Period Label', 'mc' ) . ':'; ?>
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr( $this->get_field_id( 'mc-mortgage-period' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'mc_mortgage_period_label' ) ); ?>"
                   type="text"
                   value="<?php if(isset($mc_mortgage_period_label)){echo esc_attr( $mc_mortgage_period_label );} ?>" />
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['title']              = ( ! empty( $new_instance['title'] ) )              ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['mc_total_amount_label']    = ( ! empty( $new_instance['mc_total_amount_label'] ) )    ? sanitize_text_field( $new_instance['mc_total_amount_label'] ) : '';
        $instance['mc_down_payment_label']    = ( ! empty( $new_instance['mc_down_payment_label'] ) )    ? sanitize_text_field( $new_instance['mc_down_payment_label'] ) : '';
        $instance['mc_interest_rate_label']   = ( ! empty( $new_instance['mc_interest_rate_label'] ) )   ? sanitize_text_field( $new_instance['mc_interest_rate_label'] ) : '';
        $instance['mc_mortgage_period_label'] = ( ! empty( $new_instance['mc_mortgage_period_label'] ) ) ? sanitize_text_field( $new_instance['mc_mortgage_period_label'] ) : '';

        return $instance;
    }


}//End Class Mortgage Calculator


/**
 * Register Mortgage Calculator
 */
function mc_register_mortgage_calculator() {
    register_widget( 'MC_Mortgage_Calculator' );
}
add_action( 'widgets_init', 'mc_register_mortgage_calculator' );


/**
 * Including Settings Page and WordPress api wrapper
 */
require_once dirname( __FILE__ ) . '/class.settings-api.php';
require_once dirname( __FILE__ ) .'/mc-settings.php';

new MC_Mortgage_Calculator_Settings();


/**
 * Load plugin text domain.
 */
function mc_load_textdomain() {
    load_plugin_textdomain( 'mc', false, plugin_basename( plugin_dir_path( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'mc_load_textdomain' );


/**
 * Get the value of a settings field
 *
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 * @return mixed
 */
function mc_get_option( $option, $section, $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}


/**
 * Localize the script with new data
 */
function mc_localization_strings(){
    $localization = array(

        'mc_output_string' => sprintf(
            __( 'Principal Amount: %1$s %6$s Years: %2$s %6$s Monthly Payment: %3$s %6$s Balance Payable With Interest: %4$s %6$s Total With Down Payment: %5$s', 'mc' ),
            '[mortgage_amount]',
            '[amortization_years]',
            '[mortgage_payment]',
            '[total_mortgage_interest]',
            '[total_mortgage_down_payment]',
            'LINEBREAK'
        ),
        'mc_currency_sign'          => mc_get_option( 'mc_currency_sign', 'mc_settings', '$' ),
        'mc_currency_sign_position' => mc_get_option( 'mc_currency_sign_position', 'mc_settings', 'before' ),
        'mc_thousand_separator'     => mc_get_option( 'mc_thousand_separator', 'mc_settings', ',' ),
        'mc_decimal_separator'      => mc_get_option( 'mc_decimal_separator', 'mc_settings', '.' ),
        'mc_number_of_decimals'     => mc_get_option( 'mc_number_of_decimals', 'mc_settings', '2' )
    );
    return $localization;
}

/**
 * Localize the script for validation
 */
function mc_validate_localization_strings() {
    $localization = array(

        'mc_field_required' => esc_html__( 'This field is required.', 'mc' ),
        'mc_valid_number'   => esc_html__( 'Please enter a valid number.', 'mc' )
    );

    return $localization;
}


/**
 * Load plugin Scripts
 */
function mortgage_calculator_scripts(){

    $mc_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'mortgage-calculator',
        $mc_url. 'css/main.css',
        MORTGAGE_CALCULATOR_VERSION,
        'screen'
    );

    wp_enqueue_script( 'mortgage-calculator-validator',
        $mc_url. 'js/jquery.validate.min.js',
        array('jquery'),
        MORTGAGE_CALCULATOR_VERSION,
        true
    );

    wp_enqueue_script( 'mortgage-calculator',
        $mc_url. 'js/mortgage-calculator.js',
        array('jquery', 'mortgage-calculator-validator'),
        MORTGAGE_CALCULATOR_VERSION,
        true
    );

    $validation_locals = mc_validate_localization_strings();
    wp_localize_script( 'mortgage-calculator-validator', 'mc_validate_strings', $validation_locals );

    //Localizing Scripts
    $localization = mc_localization_strings();
    wp_localize_script( 'mortgage-calculator', 'mc_strings', $localization );
}
add_action( 'wp_enqueue_scripts', 'mortgage_calculator_scripts' );
