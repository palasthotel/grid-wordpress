<?php
/**
 * @author Daniel Baron <daniel.baron@axelspringer.de>
 * @copyright Copyright (c) 2015, Daniel Baron, Axel Springer SE
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package Palasthotel\Grid-WordPress
 */
/**
* Shortcode-Box is considered as static content
*/
class grid_shortcode_box extends grid_static_base_box {
 
   public function type() {
     return 'shortcode';
   }
 
   public function __construct() {
      $this->content = new Stdclass();
      $this->content->shortcode = '';
   }
 
   public function contentStructure () {
      return array(
         array(
            'key' => 'shortcode',
            'label' => t( 'Shortcode' ),
            'type' => 'text',
         )
      );
   }
 
   public function build( $editmode ) {
      if( $editmode ) {
         if ( strlen( $this->content->shortcode ) ) {
            return t( "Shortcode: " . $this->content->shortcode );
         } else {
            return t( "Shortcode" );
         }
      }
      else {
         $shortcode = $this->content->shortcode;
         if ( 0 === strpos($shortcode, '[' ) && ( strlen( $shortcode ) - 1 ) === strpos( $shortcode, ']' ) ) { 
            return do_shortcode( $this->content->shortcode );
         } else {
            return do_shortcode( '[' . $this->content->shortcode . ']' );
         }
      }
   }
 
}
?>