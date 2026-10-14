<?php
/**
 * @author Palasthotel <rezeption@palasthotel.de>
 * @copyright Copyright (c) 2014, Palasthotel
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package Palasthotel\Grid\Wordpress
 *
 * @var object $content
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="grid-box-editmode">
	Shortcode
	<?php
	if ( null !== $this->grid ) {
		if ( empty( $content->slug ) ) {
			echo '<br>' . esc_html__( 'You need to set a valid shortcode!', 'grid' );
		} else {
			echo '<br>' . esc_html( "[{$content->slug} {$content->attributes}]" );
		}
	}
	?>
</div>
