<?php
/**
 * Plugin Name:     Mortgage Calculator
 * Plugin URI:      https://github.com/InspiryThemes/mortgage-calculator
 * Description:     It provides an easy to use mortgage calculator widget
 * Version:         1.0.0
 * Author:          Inspiry Themes
 * Author URI:      http://inspirythemes.com/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     smc
 * Domain Path:     /languages
 */

// Make sure the plugin is accessed through the appropriate channels
defined('ABSPATH') || die;

class simple_mortgage_calculator extends WP_Widget {

    // Register widget with WordPress.

    public function __construct() {
        parent::__construct(

        // Base ID of your widget
            'simple-mortgage-calculator',

            // Widget name will appear in UI
            __( 'Simple Mortgage Calculator', 'smc' ),

            // Widget description
            array ( 'description' => __( 'A  Simple Mortgage Calculator.', 'smc' ) ) );
    }


    // Creating widget front-end - This is where the action happens.
    public function widget( $args, $instance ) {
        $title  = apply_filters( 'widget_title', $instance['title'] );

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // This is where you run the code and display the output
        ob_start();

        echo ob_get_clean();

        ?>
        <div class="smcf-wrapper clearfx">
            <form id="smcf-form" action="#smcf-form">
                <p>
                    <label for="smcf-total-amount">Total Amount</label>
                    <input type="number" name="totalamount" id="smcf-total-amount" min="1" class="required" placeholder="$"/>
                </p>
                <p>
                    <label for="smcf-down-payment">Down Payment</label>
                    <input type="number" name="downpayment" id="smcf-down-payment" min="1" class="required" placeholder="$">
                </p>
                <p>
                    <label for="smcf-interest-rate">Interest Rate</label>
                    <input type="number" name="interestrate" id="smcf-interest-rate" min="1" class="required" placeholder="%">
                </p>
                <p>
                    <label for="smcf-amortization-period">Amortization Period</label>
                    <input type="number" name="authperiod" id="smcf-amortization-period" class="required" placeholder="Years">
                </p>
                <p>
                    <input type="submit" id="smcf-submit" value="Calculate">
                </p>
            </form>
            
            <div id="smcf-output" class="clearfix">
               
            </div>
        </div>

        <?php echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Monthly Mortgage Payments', 'smc' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php echo __( 'Title', 'smc' ) . ':'; ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>"
                   type="text" value="<?php if(isset($title)){echo esc_attr( $title );} ?>" />
        </p>

        <?php
    }

    // Sanitize widget form values as they are saved.
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }


}
//End Class  Simple Mortgage Calculator


//Register Simple Mortgage Calculator
function register_simple_mortgage_calculator() {
    register_widget( 'simple_mortgage_calculator' );
}
add_action( 'widgets_init', 'register_simple_mortgage_calculator' );


//Load plugin text domain.
function smc_load_textdomain() {
    load_plugin_textdomain( 'smc', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'smc_load_textdomain' );


function smc_url() {
    $url = plugin_dir_url( __FILE__ );
    if ( is_ssl() ) $url = str_replace( 'http://', 'https://', $url );
    return $url;
}
defined( 'SMC_URL' ) or define( 'SMC_URL', smc_url() );


//Load plugin Scripts
function simple_mortgage_calculator_scripts()
{
    wp_enqueue_style( 'smc_css', SMC_URL . 'css/main.css', '', '1.0', 'screen'  );
    wp_enqueue_script( 'smc_validate', SMC_URL . 'js/jquery.validate.min.js', 'jquery', "1.15", true );
    wp_enqueue_script( 'smc_custom', SMC_URL . 'js/smc-custom.js', 'jquery', "1.0", true );

}
add_action( 'wp_enqueue_scripts', 'simple_mortgage_calculator_scripts' );
