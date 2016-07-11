<?php

namespace grid_plugin;


class custom_post_types
{
	function __construct($plugin){
		$this->plugin = $plugin;
    add_action( 'init', array( $this, 'init' ) );
	}

  /**
	 * init grid to post types
	 */
	function init() {

		$options = get_option( 'grid', array() );
		if(isset($options['installed']))
		{
			$this->plugin->update();
		}

		do_action( 'grid_register_post_type' );

		if(get_option("grid_landing_page_enabled", false)){
			$permalink = get_option( 'grid_permalinks', '' );
			if ( '' == $permalink ) {
				$landing_page_permalink = _x( 'landing_page', 'slug', 'grid' );
			} else {
				$landing_page_permalink = $permalink;
			}
			$this->register_landig_page($landing_page_permalink);
		}
    if(get_option("grid_sidebar_enabled", false)){
      $this->register_sidebar();
    }

	}

  /**
   * register landig page post type
   */
  function register_landig_page($landing_page_permalink){
    register_post_type( 'landing_page',
      apply_filters( 'grid_register_post_type_landing_page',
        array(
          'labels'  => array(
            'name'          => __( 'Landing Pages', 'grid' ),
            'singular_name' => __( 'Landing Page', 'grid' ),
            // labels to be continued
          ),
          'menu_icon'			=>  plugins_url( 'images/post-type-icon.png', __FILE__),
          'description'       => __( 'This is where you can add new landing pages to your site.', 'grid' ),
          'public'            => true,
          'show_ui'           => true,
          'hierarchical'      => false, // Hierarchical causes memory issues - WP loads all records!
          'rewrite'           => $landing_page_permalink ? array(
            'slug' => untrailingslashit( $landing_page_permalink ),
            'with_front' => false,
            'feeds' => true )
            : false,
          'supports' 			=> array( 'title', 'custom-fields', 'thumbnail', 'excerpt', 'comments', 'revisions', 'page-attributes' ),
          'show_in_menu' => 'grid_menu',
        )
      )
    );
  }

  /**
   * register sidebar post type
   */
  function register_sidebar(){
		register_post_type( 'sidebar',
			apply_filters( 'grid_register_post_type_landing_page',
				array(
					'labels'  => array(
						'name'          => __( 'Sidebars', 'grid' ),
						'singular_name' => __( 'Sidebar', 'grid' ),
						// labels to be continued
					),
					'menu_icon'			=>  plugins_url( 'images/post-type-icon.png', __FILE__),
					'description'       => __( 'This is where you can add new sidebars to your site.', 'grid' ),
					'public'            => true,
					'show_ui'           => true,
					'hierarchical'      => false, // Hierarchical causes memory issues - WP loads all records!
					'show_in_menu' => 'grid_menu',
				)
			)
		);
  }
}
