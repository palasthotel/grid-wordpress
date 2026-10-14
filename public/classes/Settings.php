<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 04.10.15
 * Time: 12:09
 */

namespace Palasthotel\Grid\WordPress;


use Grid\Constants\GridCSSVariant;
use Grid\Constants\GridCssVariantFlexbox;
use Grid\Constants\GridCssVariantNone;
use Grid\Constants\GridCssVariantTable;
use const Grid\Constants\GRID_CSS_VARIANT_FLEXBOX;
use const Grid\Constants\GRID_CSS_VARIANT_NONE;
use const Grid\Constants\GRID_CSS_VARIANT_TABLE;

class Settings extends _Component
{
	function onCreate(){
		add_action( 'admin_bar_menu', array( $this, 'admin_bar' ), 999 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}

	/**
	 * add adminbar button
	 */
	function admin_bar() {
		/**
		 * @var \WP_Admin_Bar $wp_admin_bar
		 */
		global $wp_admin_bar;
		global $post;
		if ( ! isset( $post->ID ) || ! current_user_can( 'edit_post', $post->ID ) ) {
			return;
		}
		if ( isset( $post->grid ) || ( is_admin() && grid_wp_get_grid_by_postid( $post->ID ) ) ) {
			$wp_admin_bar->add_node( array(
				'id' => 'grid_wp_thegrid',
				'title' => __('Edit Grid', 'grid'),
				'href' => add_query_arg( array( 'page' => 'grid', 'postid' => $post->ID ), admin_url( 'admin.php' ) ),
			) );
		}
	}

	/**
	 * register admin menu page for settings
	 */
	function admin_menu(){
		add_menu_page(
				'Grid',
				'Grid',
				"manage_options",
				'grid_settings',
				null,
				plugins_url( '../images/post-type-icon.png', __FILE__),
				35
		);
		add_submenu_page( 'grid_settings', 'Settings', 'Settings', 'manage_options', 'grid_settings', array( $this, 'render_settings_form' ) );
	}

	/**
	 * render settings form
	 */
	function render_settings_form() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e('Grid Settings', 'grid'); ?></h2>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'grid_settings' );
				do_settings_sections( 'grid_settings' );
				?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	/**
	 *
	 */
	function admin_init() {
		/**
		 * grid frontend css version
		 */
		add_settings_section( 'grid_frontend_css', __('Frontend CSS', 'grid'), array( $this, 'frontend_css_settings_section' ), 'grid_settings' );
		add_settings_field( Plugin::OPTION_FRONTEND_CSS_VARIANT, __('Variant', 'grid'), array( $this, 'frontend_css_html' ), 'grid_settings', 'grid_frontend_css' );
		register_setting( 'grid_settings', Plugin::OPTION_FRONTEND_CSS_VARIANT, array( 'sanitize_callback' => array( $this, 'sanitize_css_variant' ) ) );

		/**
		 * default styles
		 */
		add_settings_section( 'grid_default_styles', __('Default Styles', 'grid'), array( $this, 'default_styles_settings_section' ), 'grid_settings' );
		add_settings_field( 'grid_default_container_style', __('Container Style', 'grid'), array( $this, 'default_container_style_html' ), 'grid_settings', 'grid_default_styles' );
		register_setting( 'grid_settings', 'grid_default_container_style', array( 'sanitize_callback' => 'sanitize_text_field' ) );
		add_settings_field( 'grid_default_slot_style', __('Slot Style', 'grid'), array( $this, 'default_slot_style_html' ), 'grid_settings', 'grid_default_styles' );
		register_setting( 'grid_settings', 'grid_default_slot_style', array( 'sanitize_callback' => 'sanitize_text_field' ) );
		add_settings_field( 'grid_default_box_style', __('Box Style','grid'), array( $this, 'default_box_style_html' ), 'grid_settings', 'grid_default_styles' );
		register_setting( 'grid_settings', 'grid_default_box_style', array( 'sanitize_callback' => 'sanitize_text_field' ) );

		/**
		 * enabled post types for grid
		 */
		add_settings_section( 'grid_post_types', __('Post Types', 'grid'), array( $this, 'post_type_settings_section' ), 'grid_settings' );
		$post_types = get_post_types( array('public' => true, 'show_ui' => true), 'objects' );
		foreach ( $post_types as $key => $post_type ) {
			// ignore landing_page and sidebar because we check them seperately
			if($key == 'landing_page') continue;
			add_settings_field( 'grid_'.$key.'_enabled', $post_type->labels->name, array( $this, 'post_type_html' ), 'grid_settings', 'grid_post_types', array( 'type' => $key ) );
			register_setting( 'grid_settings', 'grid_'.$key.'_enabled', array( 'sanitize_callback' => array( $this, 'sanitize_checkbox' ) ) );
		}
		/**
		 * check manually because disabling this will unregister post types
		 */
		add_settings_field( 'grid_landing_page_enabled', __("Landing Pages", 'grid'), array( $this, 'post_type_html' ), 'grid_settings', 'grid_post_types', array( 'type' => 'landing_page') );
		register_setting( 'grid_settings', 'grid_landing_page_enabled', array( 'sanitize_callback' => array( $this, 'sanitize_checkbox' ) ) );

		/**
		 * post types for search
		 */
		add_settings_section( 'grid_post_types_search', __('Post Types for content search', 'grid'), array( $this, 'post_type_search_settings_section' ), 'grid_settings' );
		$post_types = get_post_types( array('public' => true, 'show_ui' => true), 'objects' );
		foreach ( $post_types as $key => $post_type ) {
			add_settings_field( 'grid_'.$key.'_search_enabled', $post_type->labels->name, array( $this, 'post_type_search_html' ), 'grid_settings', 'grid_post_types_search', array( 'type' => $key ) );
			register_setting( 'grid_settings', 'grid_'.$key.'_search_enabled', array( 'sanitize_callback' => array( $this, 'sanitize_checkbox' ) ) );
		}

		/**
		 * default grid container
		 */
		add_settings_section( 'grid_default_container', __('New Grids', 'grid'), array( $this, 'default_container_section' ), 'grid_settings' );
		add_settings_field( 'grid_default_container', __('Which container should be placed automatically', 'grid'), array( $this, 'default_container_html' ), 'grid_settings', 'grid_default_container' );
		register_setting( 'grid_settings', 'grid_default_container', array( 'sanitize_callback' => 'sanitize_text_field' ) );

		/**
		 * debug mode
		 */
		add_settings_section( 'grid_debug_mode', __('Debug Mode', 'grid'), array( $this, 'debug_mode_section' ), 'grid_settings' );
		add_settings_field( 'grid_debug_mode', __('Turn debug mode on/off', 'grid'), array( $this, 'debug_mode_html' ), 'grid_settings', 'grid_debug_mode' );
		register_setting( 'grid_settings', 'grid_debug_mode', array( 'sanitize_callback' => array( $this, 'sanitize_checkbox' ) ) );

		/**
		 * async settings
		 */
		add_settings_section( 'grid_async_service', __('Async', 'grid'), array( $this, 'async_section' ), 'grid_settings' );

		add_settings_field( 'grid_async', _x('Enable', 'grid_async', 'grid'), array( $this, 'async_enable_html' ), 'grid_settings', 'grid_async_service' );
		register_setting( 'grid_settings', 'grid_async', array( 'sanitize_callback' => array( $this, 'sanitize_checkbox' ) ) );

		add_settings_field( 'grid_async_url', __('Service url (leave empty to use default url)', 'grid'), array( $this, 'async_url_html' ), 'grid_settings', 'grid_async_service' );
		register_setting( 'grid_settings', 'grid_async_url', array( 'sanitize_callback' => array( $this, 'sanitize_async_url' ) ) );

		add_settings_field( 'grid_async_timeout', __('After how many seconds an author loses the lock on a grid when not active?', 'grid'), array( $this, 'async_timeout_html' ), 'grid_settings', 'grid_async_service' );
		register_setting( 'grid_settings', 'grid_async_timeout', array( 'sanitize_callback' => 'absint' ) );

		/**
		 * mediaselect info
		 */
		add_settings_section( 'grid_mediaselect_info', __('Mediaselect Info', 'grid'), array( $this, 'mediaselect_info_section' ), 'grid_settings' );
		add_settings_field( 'grid_mediaselect_info', __('Set an info text for media in the WordPress media-box', 'grid'), array( $this, 'mediaselect_info_html' ), 'grid_settings', 'grid_mediaselect_info' );
		register_setting( 'grid_settings', 'grid_mediaselect_info', array( 'sanitize_callback' => 'wp_kses_post' ) );

		/**
		* mediaselect types
		*/
		add_settings_section( 'grid_mediaselect_types', __('Mediaselect Types', 'grid'), array( $this, 'mediaselect_types_section' ), 'grid_settings' );
		add_settings_field( 'grid_mediaselect_types', __('Choose types for media-box', 'grid'), array( $this, 'mediaselect_types_html' ), 'grid_settings', 'grid_mediaselect_types' );
		register_setting( 'grid_settings', 'grid_mediaselect_types', array( 'sanitize_callback' => array( $this, 'sanitize_media_types' ) ) );

		/**
		 * permalinks
		 */
		add_settings_section( 'grid_permalinks', __('Grid', 'grid'), array( $this, 'permalinks_section' ), 'grid_settings' );
		add_settings_field( 'grid_permalinks', __('Landing Page base', 'grid'), array( $this, 'permalinks_html' ), 'grid_settings', 'grid_permalinks' );
		register_setting( 'grid_settings', 'grid_permalinks', array( 'sanitize_callback' => 'sanitize_text_field' ) );
	}

	/**
	 * checkbox options store "on" or an empty string
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	public function sanitize_checkbox( $value ) {
		return empty( $value ) ? '' : 'on';
	}

	/**
	 * @param mixed $value
	 *
	 * @return string
	 */
	public function sanitize_css_variant( $value ) {
		// unknown values fall back to the table variant
		return GridCSSVariant::getVariant( is_string( $value ) ? $value : '' )->slug();
	}

	/**
	 * @param mixed $value
	 *
	 * @return string
	 */
	public function sanitize_media_types( $value ) {
		return ( '*' === $value ) ? '*' : 'image';
	}

	/**
	 * @param mixed $value
	 *
	 * @return string
	 */
	public function sanitize_async_url( $value ) {
		return esc_url_raw( trim( (string) $value ), array( 'http', 'https', 'ws', 'wss' ) );
	}

	function frontend_css_settings_section(){
		esc_html_e('Choose the css variant for frontend grid rendering.', 'grid');
	}

	function frontend_css_html(){
		$variantTable = new GridCssVariantTable(GRID_CSS_VARIANT_TABLE);
		$frontendCssVariant = get_option(Plugin::OPTION_FRONTEND_CSS_VARIANT, $variantTable->slug());
		$variants = [
			[
				"key"   => (new GridCssVariantNone(GRID_CSS_VARIANT_NONE))->slug(),
				"label" => _x( "None", "Frontend css variant settings", 'grid' ),
			],
			[
				"key"   => $variantTable->slug(),
				"label" => _x( "Table", "Frontend css variant settings", 'grid' ),
			],
			[
				"key"   => (new GridCssVariantFlexbox(GRID_CSS_VARIANT_FLEXBOX))->slug(),
				"label" => _x( "Flexbox", "Frontend css variant settings", 'grid' ),
			],
		];
		echo "<select name='".esc_attr( Plugin::OPTION_FRONTEND_CSS_VARIANT )."'>";
		foreach ($variants as $variant){
			$key = $variant["key"];
			$label = $variant["label"];
			echo "<option value='".esc_attr( $key )."' ".selected( $frontendCssVariant, $key, false ).">".esc_html( $label )."</option>";
		}
		echo "</select>";
	}

	function default_styles_settings_section() {
		esc_html_e('Set which default styles should be applied.','grid');
	}

	function default_container_style_html() {
		$storage = $this->plugin->gridCore->storage;
		$types = $storage->fetchContainerStyles();
		$setting = get_option( 'grid_default_container_style', '__NONE__' );
		?>
		<select id="grid_default_container_style" name="grid_default_container_style">
			<option value="__NONE__" <?php echo ( $setting == '__NONE__' ? 'selected' : '' ) ?>><?php echo esc_html_x('None', 'grid_styles', 'grid'); ?></option>
			<?php
			foreach ( $types as $idx => $elem ) {
				?>
				<option value="<?php echo esc_attr( $elem['slug'] );?>" <?php echo ( $elem['slug'] == $setting ? 'selected' : '' );?>><?php echo esc_html( $elem['title'] );?></option>
				<?php
			}
			?>
		</select>
		<?php
	}

	function default_slot_style_html() {
		$storage = $this->plugin->gridCore->storage;
		$types = $storage->fetchSlotStyles();
		$setting = get_option( 'grid_default_slot_style', '__NONE__' );
		?>
		<select id="grid_default_slot_style" name="grid_default_slot_style">
			<option value="__NONE__" <?php echo ( $setting == '__NONE__' ? 'selected' : '' );?>><?php echo esc_html_x('None', 'grid_styles', 'grid'); ?></option>
			<?php
			foreach ( $types as $idx => $elem ) {
				?>
				<option value="<?php echo esc_attr( $elem['slug'] );?>" <?php echo ( $elem['slug'] == $setting ? 'selected' : '' );?>><?php echo esc_html( $elem['title'] );?></option>
				<?php
			}
			?>
		</select>
		<?php
	}

	function default_box_style_html() {
		$storage = $this->plugin->gridCore->storage;
		$types = $storage->fetchBoxStyles();
		$setting = get_option( 'grid_default_box_style', '__NONE__' );
		?>
		<select id="grid_default_box_style" name="grid_default_box_style">
			<option value="__NONE__" <?php echo ( $setting == '__NONE__' ? 'selected' : '');?>><?php echo esc_html_x('None', 'grid_styles', 'grid'); ?></option>
			<?php
			foreach ( $types as $idx => $elem ) {
				?>
				<option value="<?php echo esc_attr( $elem['slug'] );?>" <?php echo ( $elem['slug'] == $setting ? 'selected' : '' );?>><?php echo esc_html( $elem['title'] );?></option>
				<?php
			}
			?>
		</select>
		<?php
	}

	function post_type_html( $args ) {
		$posttype = $args['type'];
		$value = get_option( 'grid_'.$posttype.'_enabled', false );
		?>
		<input type="checkbox" id="grid_<?php echo esc_attr( $posttype )?>_enabled" name="grid_<?php echo esc_attr( $posttype )?>_enabled" <?php echo ( $value ? 'checked' : '' )?>> <?php echo ($value ? "Enabled": "Disabled") ?>
		<?php
	}

	function post_type_settings_section() {
		esc_html_e('Which post types should have grid support?', 'grid');
	}

	function post_type_search_html( $args ) {
		$posttype = $args['type'];
		$value = get_option( 'grid_'.$posttype.'_search_enabled', false );
		?>
		<input type="checkbox" id="grid_<?php echo esc_attr( $posttype )?>_search_enabled" name="grid_<?php echo esc_attr( $posttype )?>_search_enabled" <?php echo ( $value ? 'checked' : '' )?>> <?php echo ($value ? "Enabled": "Disabled") ?>
		<?php
	}

	function post_type_search_settings_section() {
		esc_html_e('Which post types should be found in grid content search?', 'grid');
	}

	function default_container_section() {
		echo '';
	}

	function default_container_html() {
		$storage = $this->plugin->gridCore->storage;
		$containers = $storage->fetchContainerTypes();
		?>
		<select id="grid_default_container" name="grid_default_container">
			<option value="__NONE__"><?php echo esc_html_x('Empty', 'default_container', 'grid'); ?></option>
			<?php
			foreach ( $containers as $container ) {
				$type = $container['type'];
				if ( 0 === strpos( $type, 'c-' ) ) {
					?>
					<option value="<?php echo esc_attr( $type )?>" <?php echo ( get_option( 'grid_default_container' ) == $type ? 'selected' : '');?> ><?php echo esc_html( $type )?></option>
					<?php
				}
			}
			?>
		</select>
		<?php
	}

	function debug_mode_section() {
		echo '';
	}

	function debug_mode_html() {

		$value = get_option( 'grid_debug_mode', false );
		?>
		<input type="checkbox" id="grid_debug_mode" name="grid_debug_mode" <?php echo ( $value ? 'checked' : '' );?>> <?php echo ( $value ? 'Enabled' : 'Disabled' )?>
		<?php
	}

	function async_section() {
		echo '';
	}

	function async_enable_html() {

		$value = get_option( 'grid_async', false );
		?>
		<input type="checkbox" id="grid_async" name="grid_async" <?php echo ( $value ? 'checked' : '' );?>> <?php echo ( $value ? 'Enabled' : 'Disabled' )?>
		<?php
	}

	function async_url_html() {

		$value = get_option( 'grid_async_url', '' );
		?>
		<input type="text" id="grid_async_url" name="grid_async_url" value="<?php echo esc_attr( $value ); ?>" />
		<?php
	}

  	function async_timeout_html() {
	  $value = get_option( 'grid_async_timeout', 5*60 );
	  ?>
	  <input type="number" id="grid_async_timeout" name="grid_async_timeout" value="<?php echo esc_attr( $value ); ?>" />
	  <?php
  	}

	function mediaselect_info_section(){
		echo '';
	}

	function mediaselect_info_html() {
		$value = get_option( 'grid_mediaselect_info', '' );
		?>
		<textarea id="grid_mediaselect_info" name="grid_mediaselect_info" rows="4" cols="50"><?php echo esc_textarea( $value ) ?></textarea>
		<?php
	}

	function mediaselect_types_section(){
		echo '';
	}

	function mediaselect_types_html() {
		$value = get_option( 'grid_mediaselect_types', 'image' );
		?>
		<p>
		<select id="grid_mediaselect_types" name="grid_mediaselect_types">
			<option value="image" <?php echo ($value == "image")? "selected": ""; ?> >Images</option>
			<option value="*" <?php echo ($value == "*")? "selected": ""; ?> >All</option>
		</select></p>
		<?php
	}

	function permalinks_section() {
		echo '';
	}

	function permalinks_html() {
		$value = get_option( 'grid_permalinks', '' );
		?>
		<input type="text" id="grid_permalinks" name="grid_permalinks" value="<?php echo esc_attr( $value ) ?>" />
		<?php
	}

}
