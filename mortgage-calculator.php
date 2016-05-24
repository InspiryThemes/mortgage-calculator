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
define( 'MORTGAGE_CALCULATOR_VERSION', '1.0.0' );


class MC_Mortgage_Calculator extends WP_Widget {

    /**
     * Register widget with WordPress.
     */

    public function __construct() {
        parent::__construct(

        // Base ID of your widget
            'mortgage-calculator',

            // Widget name will appear in UI
            __( 'Mortgage Calculator', 'mc' ),

            // Widget description
            array ( 'description' => __( 'It provides an easy to use mortgage calculator widget.', 'mc' ) ) );
    }


    /**
     * Creating widget front-end - This is where the action happens.
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        $title  = apply_filters( 'widget_title', $instance['title'] );

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>
        <div class="mc-wrapper clearfx">
            <form id="mc-form" action="#mc-form">
                <p>
                    <label for="mc-total-amount"><?php _e("Total Amount", "mc"); ?></label>
                    <input type="number" name="mc_total_amount" id="mc-total-amount" min="1" class="required" placeholder="<?php _e('%', 'mc'); ?>"/>
                </p>
                <p>
                    <label for="mc-down-payment"><?php _e("Down Payment", "mc"); ?></label>
                    <input type="number" name="mc_down_payment" id="mc-down-payment" min="1" class="required" placeholder="<?php _e('%', 'mc'); ?>">
                </p>
                <p>
                    <label for="mc-interest-rate"><?php _e("Interest Rate", "mc"); ?></label>
                    <input type="number" name="mc_interest_rate" id="mc-interest-rate" min="1" class="required" placeholder="<?php _e('%', 'mc'); ?>">
                </p>
                <p>
                    <label for="mc-amortization-period"><?php _e("Amortization Period", "mc"); ?></label>
                    <input type="number" name="mc_amortization_period" id="mc-amortization-period" class="required" placeholder="<?php _e('Years', 'mc'); ?>">
                </p>
                <p>
                    <input type="submit" id="mc-submit" value="<?php _e('Calculate', 'mc'); ?>">
                </p>
            </form>

            <div id="mc-output" class="clearfix">

            </div>
        </div>

        <?php echo $args['after_widget'];
    }

    /**
     * Widget Backend
     * @param array $instance
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Monthly Mortgage Payments', 'mc' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php echo __( 'Title', 'mc' ) . ':'; ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>"
                   type="text" value="<?php if(isset($title)){echo esc_attr( $title );} ?>" />
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

        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

        return $instance;
    }


}
//End Class Mortgage Calculator


/**
 * Register Mortgage Calculator
 */
function register_mortgage_calculator() {
    register_widget( 'MC_Mortgage_Calculator' );
}
add_action( 'widgets_init', 'register_mortgage_calculator' );


/**
 * Load plugin text domain.
 */
function mc_load_textdomain() {
    load_plugin_textdomain( 'mc', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'mc_load_textdomain' );


/**
 * Localize the script with new data
 */
function mc_get_localization(){

    $localization = array(

        'mc_output_string' => sprintf(
            __( 'For a mortgage of %1$s amortized over %2$s years, your Monthly payment is: <br> Mortgage Payment: %3$s <br>Total Mortgage with Interest: %4$s <br>Total with Down Payment: %5$s', 'mc' ),
            '[mortgage_amount]',
            '[amortization_years]',
            '[mortgage_payment]',
            '[total_mortgage_interest]',
            '[total_mortgage_down_payment]'
        )
    );
    return $localization;
}


/**
 * Load plugin Scripts
 */
function mortgage_calculator_scripts()
{
    $mc_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'mc_css', $mc_url. 'css/main.css', '', MORTGAGE_CALCULATOR_VERSION, 'screen'  );
    wp_enqueue_script( 'mc_validate',$mc_url. 'js/jquery.validate.min.js', array('jquery'), MORTGAGE_CALCULATOR_VERSION, true );
    wp_enqueue_script( 'mc_custom', $mc_url. 'js/mc-custom.js', array('jquery', 'mc_validate'), MORTGAGE_CALCULATOR_VERSION, true );
    mc_localize_script();
}
add_action( 'wp_enqueue_scripts', 'mortgage_calculator_scripts' );

/**
 * Localize JavaScript
 */
function mc_localize_script() {

    $localization = mc_get_localization();

    wp_localize_script( 'mc_custom', 'mc_strings', $localization );
}

