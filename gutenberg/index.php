<?php
/*
Plugin Name:  Gutenpride
Plugin URI:   https://github.com/mkaz/gutenpride
Description:  A simple example block displaying Gutenberg pride
Author:       Marcus Kazmierczak
Author URI:   https://mkaz.tech/
*/


/**
 * Enqueue assets for editor portion of Gutenberg
 */
function mkaz_gutenpride_editor_assets() {
	wp_enqueue_script(
		'mkaz-gutenpride',
		plugins_url( 'block.built.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	);
}
add_action( 'enqueue_block_editor_assets', 'mkaz_gutenpride_editor_assets' );
