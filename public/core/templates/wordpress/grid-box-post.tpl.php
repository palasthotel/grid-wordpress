<?php
/**
 * @author Palasthotel <rezeption@palasthotel.de>
 * @copyright Copyright (c) 2014, Palasthotel
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package Palasthotel\Grid\Wordpress
 */

defined( 'ABSPATH' ) || exit;

$classes = $this->classes;
array_push( $classes, 'grid-box' );

if ( ! empty( $this->style ) ) {
	array_push( $classes, $this->style );
}

if ( isset( $content ) && isset( $content->publish ) && 'publish' == $content->publish ) : ?>
    <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
        <?php if ( ! empty( $this->title ) ) : ?>
            <?php if ( ! empty( $this->titleurl ) ) : ?>
                <h2 class="grid-box-title b-title"><a href="<?php echo esc_url( $this->titleurl ); ?>"><?php echo wp_kses_post( $this->title ); ?></a></h2>
            <?php else : ?>
                <h2 class="grid-box-title b-title"><?php echo wp_kses_post( $this->title ); ?></h2>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ( ! empty( $this->prolog ) ) : ?>
            <div class="grid-box-prolog b-prolog">
                <?php echo wp_kses_post( $this->prolog ); ?>
            </div>
        <?php endif; ?>

        <?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- output of the post_content.tpl.php template, which escapes its own output.
        echo $content->output;
        ?>

        <?php if ( ! empty( $this->epilog ) ) : ?>
            <div class="grid-box-epilog b-epilog">
                <?php echo wp_kses_post( $this->epilog ); ?>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $this->readmore ) ) : ?>
            <a href="<?php echo esc_url( $this->readmoreurl ); ?>" class="grid-box-readmore-link b-readmore-link"><?php echo wp_kses_post( $this->readmore ); ?></a>
        <?php endif; ?>
    </div>
<?php elseif ( grid_wp_show_box_errors( $this ) ) : ?>
    <p>No Content found or is not published yet!</p>
<?php endif; ?>
