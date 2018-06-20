<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 23.02.18
 * Time: 18:05
 */

namespace grid_plugin;


class Gutenberg {
	public function __construct( \grid_plugin $plugin ) {
		$this->plugin = $plugin;
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block' ) );
	}

	public function enqueue_block() {
		wp_enqueue_script(
			'grid-gutenberg-block',
			$this->plugin->url . '/gutenberg/block/grid-block.built.js',
			array( 'wp-blocks', 'wp-element' )
		);
		$ajax = $this->plugin->get_ajax_endpoint();
		$types = $ajax->perform( (object) array(
			"component" => "grid.editing.container",
			"method" => "getContainerTypes",
			"params" => array(null),
		));
		wp_localize_script(
			'grid-gutenberg-block',
			'GridGutenberg',
			array(
				'containertypesdemo' => array(
					array(
						"type"           => "c-1d3-1d3-1d3",
						"space_to_left"  => null,
						"space_to_right" => null,
						"numslots"       => "3"
					),
					array(
						"type"           => "c-2d3-1d3",
						"space_to_left"  => null,
						"space_to_right" => null,
						"numslots"       => "2"
					),
				),
				'containertypes'     => array_filter($types["result"],function($type){
					return substr($type["type"], 0, 2) == "c-";
				}),
			)
		);
	}
}