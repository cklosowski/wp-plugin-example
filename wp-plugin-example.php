<?php
/*
Plugin Name: WordPress Plugin Example
Plugin URI: http://www.chriskdesigns.com/
Description: This is the example plugin for WordPress Plugin Bootcamp @ Desert Code Camp 2012.
Version: 1.0
Author: Chris Klosowski
Author URI: http://www.chriskdesigns.com/
License: GPLv2 or later
*/

class CKWPPExamplePlugin {
	private static $ckwppe_instance;

	private function __construct() {
		$this->constants(); // Defines any constants used in the plugin
		$this->init();   // Sets up all the actions and filters
	}

	public static function getInstance() {
		if ( !self::$ckwppe_instance ) {
			self::$ckwppe_instance = new CKWPPExamplePlugin();
		}

		return self::$ckwppe_instance;
	}

	private function constants() {
		define( 'CKWPPE_VERSION', '1.0' );
		define( 'CKWPPE_TEXT_DOMAIN', 'ckwppe' );
	}

	private function init() {
		// Register the options with the settings API
		add_action( 'admin_init', array( $this, 'ckwppe_register_settings' ) );

		// Add the menu page
		add_action( 'admin_menu', array( $this, 'ckwppe_setup_admin' ) );
	}

	public function ckwppe_register_settings() {
		register_setting( 'ckwppe-update-options', 'ckwppe_enable' );
	}

	public function ckwppe_setup_admin() {
		// Add our Menu Area
		add_options_page( __( 'Example Plugin', CKWPPE_TEXT_DOMAIN ), 
						  __( 'Example', CKWPPE_TEXT_DOMAIN ), 
						  'administrator', 'ckwppe-settings', 
						  array( $this, 'ckwppe_admin_page' ) 
						);
	}

	public function ckwppe_admin_page() {
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"></div><h2>WordPress Example Plugin</h2>
			<form method="post" action="options.php">
				<?php wp_nonce_field( 'ckwppe-update-options' ); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( 'Options:', CKWPPE_TEXT_DOMAIN ); ?><br />
							<span style="font-size: x-small;"><?php _e( 'With great power, comes great responsiblity.', CKWPPE_TEXT_DOMAIN ); ?></span>
						</th>
						<td>
							<input type="checkbox" name="ckwppe_enable" value="1" <?php if ( get_option( 'ckwppe_enable' ) ) {?>checked="checked"<?php ;}?> /> <?php _e( 'Enable the Example Plugin to output', CKWPPE_TEXT_DOMAIN ); ?>
						</td>
					</tr>
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="page_options" value="ckwppe_primary_setting" />

					<?php settings_fields( 'ckwppe-update-options' ); ?>
				</table>
				<input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" />
			</form>
		</div>
		<?php
	}
}


$ckwpee = CKWPPExamplePlugin::getInstance();
