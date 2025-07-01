<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 04.10.15
 * Time: 20:18
 */

namespace Palasthotel\Grid\WordPress;

class MetaBoxes extends _Component
{

    public Plugin $plugin;

	const CSS_HANDLE = "grid-meta-box-style";

	function onCreate(){
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action('save_post', array($this, 'save_post'));
	}

	function add_meta_boxes() {
		$post_types = get_post_types( array(), 'objects' );
		foreach ( $post_types as $key => $post_type ) {
			if ( get_option( 'grid_'.$key.'_enabled', false ) ) {
				add_meta_box( 'grid', __( 'Grid', Plugin::DOMAIN ), array( $this, 'render_meta_box' ) , $key, 'side', 'high' );
			}
		}
	}
	
	/**
	 * render the metabox content
	 * @param $post
	 *
	 */
	function render_meta_box( $post ) {
		wp_enqueue_style(self::CSS_HANDLE, $this->plugin->url."/css/meta-box.css");
		if( get_post_status($post->ID) == 'auto-draft' ){
			?>
			<input type="hidden" name="grid[<?php echo PositionInPost::META_KEY ?>]" value="<?php echo PositionInPost::POSITION_BOTTOM ?>" />
			<p><?php _e('Save post before you can use grid.', 'grid'); ?></p>
			<?php
		} else if ( get_option( 'grid_'.$post->post_type.'_enabled', false ) ) {
			$url = add_query_arg( array( 'page' => 'grid', 'postid' => $post->ID ), admin_url( 'admin.php' ) );
			
			?>
			<p>
				<a class="button" href="<?php echo $url?>"><?php _e('Switch to the Grid', 'grid'); ?></a>
			</p>
			<?php
			// get from hook
			$position = apply_filters(PositionInPost::FILTER_OVERWRITE, null, $post);
			if($position == null){
				/**
				 * - to top of content
				 * - to bottom of content
				 * - grid only
				 * - no grid - content only
				 * SHORTCODE
				 */
				$val = get_post_meta($post->ID, PositionInPost::META_KEY, true);

				?>
				<p>
					<strong><?php _e('Position of grid', 'grid'); ?></strong>
					<label
							for="grid-position"
							class="screen-reader-text"
					><?php _e('Position of grid', 'grid'); ?></label>
					<select
							id="grid-position"
							name="grid[<?php echo PositionInPost::META_KEY ?>]"
					>
						<?php $this->render_position_option(__('Append to content', Plugin::DOMAIN), PositionInPost::POSITION_BOTTOM, $val); ?>
						<?php $this->render_position_option(__('Prepend to content', Plugin::DOMAIN), PositionInPost::POSITION_TOP, $val); ?>
						<?php $this->render_position_option(__('Grid only, no content', Plugin::DOMAIN), PositionInPost::POSITION_ONLY, $val); ?>
						<?php $this->render_position_option(__('Disable grid rendering', Plugin::DOMAIN), PositionInPost::POSITION_NONE, $val); ?>
					</select>
				</p>
				<?php
			}
			do_action('grid_post_edit_meta_box');
		}
	}
	
	/**
	 * render select option
	 * @param $label
	 * @param $position
	 * @param $value
	 */
	private function render_position_option($label, $position, $value){
		?>
		<option
			value="<?php echo $position ?>"
			<?php if($position == $value) echo " selected='selected' " ?>
		>
			<?php echo $label ?>
		</option>
		<?php
	}
	
	/**
	 * save post
	 * @param $post_id
	 */
	function save_post($post_id){
		if(!empty($_POST["grid"]) && !empty($_POST["grid"][PositionInPost::META_KEY])){
			update_post_meta($post_id, PositionInPost::META_KEY,$_POST["grid"][PositionInPost::META_KEY]);
		}
	}
	
	
}