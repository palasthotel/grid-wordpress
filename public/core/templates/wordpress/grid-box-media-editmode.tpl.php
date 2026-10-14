<?php
/**
 * @author Palasthotel <rezeption@palasthotel.de>
 * @copyright Copyright (c) 2014, Palasthotel
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package Palasthotel\Grid\Wordpress
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="grid-box-editmode">
    <div class="content">
		<?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- markup built and escaped by grid_media_box::build().
		echo $content->rendered_html;
		?>
    </div>
</div>
