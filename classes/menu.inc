<?php

namespace grid_plugin;


class menu
{
	function __construct($plugin){
		$this->plugin = $plugin;
		add_action( 'admin_bar_menu', array( $this, 'admin_bar' ), 999 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * add adminbar button
	 */
	function admin_bar() {
		global $wp_admin_bar;
		global $post;
		if ( isset( $post->grid ) ) {
			$wp_admin_bar->add_node( array(
				'id' => 'grid_wp_thegrid',
				'title' => 'Edit Grid',
				'href' => add_query_arg( array( 'page' => 'grid', 'postid' => $post->ID ), admin_url( 'admin.php' ) ),
			) );
		}
	}

	/**
	 * register admin menu page for settings
	 */
	function admin_menu(){
		add_menu_page( 'Grid', 'Grid', 'edit_published_posts', 'grid_menu', null, $this->plugin->url.'images/post-type-icon.png', 10 );
		/**
		 * landig page info page if custom_post_type landig_page is disabled
		 */
		if(!get_option("grid_landing_page_enabled", false)){
			// if landigpage is not enabled render the info submenu page
			add_submenu_page( 'grid_menu', __( 'Grid ‹ Landing Pages', 'grid' ), __( 'Landing Pages', 'grid' ), 'edit_published_posts', 'grid_menu', array($this, 'render_landing_pages_info') );
		}
		/**
		 * sidebar info page if custom_post_type sidebar is disabled
		 */
		if(!get_option("grid_sidebar_enabled", false)){
			add_submenu_page( 'grid_menu', __( 'Grid ‹ Sidebars', 'grid' ), __( 'Sidebars', 'grid' ), 'edit_published_posts', 'grid_sidebars', array($this, 'render_landing_pages_info') );

    }



	}

	/**
	 * render overview
	 */
	function render_landing_pages_info() {
		?>
		<div class="wrap">
			<p>Landig pages are disabled.</p>
		</div>
		<?php
	}

}
