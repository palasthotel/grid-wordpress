<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 23.02.18
 * Time: 18:05
 */

namespace grid_plugin;


class Gutenberg {
	public function __construct(\grid_plugin $plugin) {
		$this->plugin = $plugin;
		add_action('enqueue_block_editor_assets', array($this, 'enqueue_block'));
	}

	public function enqueue_block(){
		wp_enqueue_script(
			'grid-gutenberg-block',
			$this->plugin->url.'/gutenberg/grid-block.built.js',
			array( 'wp-blocks', 'wp-element' )
		);
	}
}