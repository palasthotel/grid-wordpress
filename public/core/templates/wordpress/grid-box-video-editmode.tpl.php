<?php
/**
 * @author Palasthotel <rezeption@palasthotel.de>
 * @copyright Copyright (c) 2014, Palasthotel
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package Palasthotel\Grid
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="grid-box-editmode">
  Video
  <?php
  /**
   * if part of grid render details
   */
  $fields = array('url', 'title', 'related');
  if (NULL != $this->grid) {
    foreach ($fields as $field) {
      if (!empty($content->{$field})) {
        echo '<br>' . esc_html( $field . ': ' . $content->{$field} );
      }
    }
  }
  ?>
</div>
