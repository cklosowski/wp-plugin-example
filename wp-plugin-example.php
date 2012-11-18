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

		add_filter( 'the_content', array( $this, 'ckwppe_add_like' ) );
		remove_action('wp_head', 'wp_generator');
		add_action( 'wp_head', array( $this, 'alter_header' ) );
	}

	function alter_header() {
		if (is_single()) {
		echo '<rel name="og:link" content="'. get_permalink() .'" />';
	 }
	}

	public function ckwppe_add_like($content) {
		if ( get_option( 'ckwppe_enable' ) && is_single() ) {
			$content .= '<iframe src="https://www.facebook.com/plugins/like.php?href='. urlencode(get_permalink()) .'"
        scrolling="no" frameborder="0"
        style="border:none; width:450px; height:80px"></iframe>';
    	}

        return $content;
	}

	public function ckwppe_register_settings() {
		register_setting( 'ckwppe-update-options', 'ckwppe_enable' );
		register_setting( 'ckwppe-update-options', 'ckwppe_enable2' );
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
						<th scope="row"><?php _e( 'Options:', CKWPPE_TEXT_DOMAIN ); ?><br />
							<span style="font-size: x-small;"><?php _e( 'With great power, comes great responsiblity.', CKWPPE_TEXT_DOMAIN ); ?></span>
						</th>
						<td>
							<input type="checkbox" name="ckwppe_enable2" value="1" <?php if ( get_option( 'ckwppe_enable2' ) ) {?>checked="checked"<?php ;}?> /> <?php _e( 'Enable the Example Plugin to output', CKWPPE_TEXT_DOMAIN ); ?>
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
