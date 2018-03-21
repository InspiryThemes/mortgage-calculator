<?php

/**
 * WordPress settings API class
 */
if ( !class_exists('MC_Mortgage_Calculator_Settings' ) ):
	class MC_Mortgage_Calculator_Settings {

		private $settings_api;

		function __construct() {
			$this->settings_api = new MC_WeDevs_Settings_API;

			add_action( 'admin_init', array($this, 'admin_init') );
			add_action( 'admin_menu', array($this, 'admin_menu') );
		}

		function admin_init() {

			//set the settings
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );

			//initialize settings
			$this->settings_api->admin_init();
		}

		function admin_menu() {
			add_options_page( __('Mortgage Calculator', 'mc'), __('Mortgage Calculator', 'mc'), 'delete_posts', 'mc_setting_page', array($this, 'mc_setting_page') );
		}

		function get_settings_sections() {
			$sections = array(
				array(
					'id' => 'mc_settings',
					'title' => __( 'Mortgage Calculator', 'mc' ),
					'desc' =>  __('You can modify price format to match your needs by using below options.', 'mc')
				)
			);
			return $sections;
		}

		/**
		 * Returns all the settings fields
		 *
		 * @return array settings fields
		 */
		function get_settings_fields() {
			$settings_fields = array(
				'mc_settings' => array(
					array(
						'name'              => 'mc_currency_sign',
						'label'             => __( 'Currency Sign', 'mc' ),
						'desc'              => __( 'Default: $', 'mc' ),
						'type'              => 'text',
						'default'           => '$',
						'sanitize_callback' => ''
					),
					array(
						'name'    => 'mc_currency_sign_position',
						'label'   => __( 'Currency Sign Position', 'mc' ),
						'desc'    => __( 'Default: Before', 'mc' ),
						'type'    => 'select',
						'default' => 'Before',
						'options' => array(
							'before' => 'Before($5000)',
							'after'  => 'After(5000$)'
						)
					),
					array(
						'name'              => 'mc_thousand_separator',
						'label'             => __( 'Thousand Separator', 'mc' ),
						'desc'              => __( 'Default: ,', 'mc' ),
						'type'              => 'text',
						'default'           => ',',
						'sanitize_callback' => ''
					),
					array(
						'name'              => 'mc_decimal_separator',
						'label'             => __( 'Decimal Separator', 'mc' ),
						'desc'              => __( 'Default: .', 'mc' ),
						'type'              => 'text',
						'default'           => '.',
						'sanitize_callback' => ''
					),
					array(
						'name'              => 'mc_number_of_decimals',
						'label'             => __( 'Number of decimals', 'mc' ),
						'desc'              => __( 'Default: 2', 'mc' ),
						'type'              => 'text',
						'default'           => '2',
						'sanitize_callback' => 'intval'
					)
				)
			);

			return $settings_fields;
		}

		function mc_setting_page() {
			echo '<div class="wrap">';

			//$this->settings_api->show_navigation();
			$this->settings_api->show_forms();

			echo '</div>';
		}

		/**
		 * Get all the pages
		 *
		 * @return array page names with key value pairs
		 */
		function get_pages() {
			$pages = get_pages();
			$pages_options = array();
			if ( $pages ) {
				foreach ($pages as $page) {
					$pages_options[$page->ID] = $page->post_title;
				}
			}

			return $pages_options;
		}

	}
endif;