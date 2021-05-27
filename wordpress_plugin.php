<?php
/**
 * Plugin Name:       Grid - DEV
 * Description:       Dev inc file
 * Version:           X.X.X
 * Requires at least: X.X
 * Tested up to:      X.X.X
 * Author: Palasthotel <rezeption@palasthotel.de> (in person: Benjamin Birkenhake, Edward Bock, Enno Welbers, Jana Marie Eggebrecht, Stephan Kroppenstedt)
 * Author URI:        http://www.palasthotel.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       grid
 * Domain Path:       /plugin/languages
 */

use Palasthotel\Grid\WordPress\Plugin;

include dirname(__FILE__) . "/public/wordpress_plugin.php";

register_activation_hook(__FILE__, function($multisite){
	Plugin::instance()->onActivation($multisite);
});

register_deactivation_hook(__FILE__, function($multisite){
	Plugin::instance()->onDeactivation($multisite);
});