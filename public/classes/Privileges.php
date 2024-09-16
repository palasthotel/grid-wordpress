<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 04.10.15
 * Time: 12:50
 */

namespace Palasthotel\Grid\WordPress;


/**
 * @property Plugin plugin
 */
class Privileges
{

	/**
	 * privileges constructor.
	 *
	 * @param Plugin $plugin
	 */
	function __construct($plugin){
		$this->plugin = $plugin;
		add_action( 'admin_menu', array($this, 'admin_menu') );
	}

	function admin_menu(){
		add_submenu_page( 'grid_settings', 'Grid Privileges', 'Privileges', 'edit_users', 'grid_privileges', array( $this, 'privileges') );
	}

	function privileges() {
		global $wp_roles;
		$names = $wp_roles->get_names();

		$ajaxendpoint = new Ajax();
		$rights = $ajaxendpoint->Rights();

		if ( ! empty( $_POST ) ) {
			$privileges = $_POST['privileges'];
			foreach ( $privileges as $role => $privs ) {
				foreach ( $privs as $key ) {
					if ( 'on' == $privileges[ $role ][ $key ] ) {
						$privileges[ $role ][ $key ] = true;
					} else {
						$privileges[ $role ][ $key ] = false;
					}
				}
			}
			update_option( 'grid_privileges', $privileges );
			wp_redirect( add_query_arg( array( 'page' => 'grid_privileges' ), admin_url( 'admin.php' ) ) );
			return;
		}
		$privileges = grid_wp_get_privs();
		wp_enqueue_style( 'grid_css_wordpress', $this->plugin->url. 'css/grid-wordpress.css' );

		?>
		<form method="post" action="<?php echo add_query_arg( array( 'noheader' => true, 'page' => 'grid_privileges' ), admin_url( 'admin.php' ) );?>">
			<table cellspacing="0" cellpadding="0" class="grid-privileges-editor">
				<tr>
					<th>Role</th>
					<?php
					foreach ( $rights as $right ) {
						?>
						<th><?php echo $right; ?></th>
						<?php
					}
					?>
				</tr>
				<?php
				foreach ( $names as $key => $name ) {
					?>
					<tr>
						<td><?php echo $name ?></td>
						<?php
						foreach ( $rights as $right ) {
							$checked = '';
							if ( $privileges[ $key ][ $right ] ) {
								$checked = 'checked';
							}
							?>
							<td><input title="<?php echo $name.' can '.$right; ?>" type="checkbox" name="privileges[<?php echo $key;?>][<?php echo $right; ?>]" <?php echo $checked ?>></td>
							<?php
						}
						?>
					</tr>
					<?php
				}
				?>
			</table>
			<input class="button" type="submit">
		</form>
		<?php
	}
}