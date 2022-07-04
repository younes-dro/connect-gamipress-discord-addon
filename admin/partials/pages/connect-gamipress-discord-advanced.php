<?php
$ets_gamipress_discord_send_welcome_dm         = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_send_welcome_dm' ) ) );
$ets_gamipress_discord_welcome_message         = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_welcome_message' ) ) );


$retry_failed_api                              = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_retry_failed_api' ) ) );
$kick_upon_disconnect                          = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_kick_upon_disconnect' ) ) );
$retry_api_count                               = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_retry_api_count' ) ) );
$set_job_cnrc                                  = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_job_queue_concurrency' ) ) );
$set_job_q_batch_size                          = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_job_queue_batch_size' ) ) );
$log_api_res                                   = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_log_api_response' ) ) );

		$guild_id                           = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_server_id' ) ) );
		$discord_bot_token                  = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_bot_token' ) ) );
		$default_role                       = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_default_role_id' ) ) );
		$ets_gamipress_discord_role_mapping = json_decode( get_option( 'ets_gamipress_discord_role_mapping' ), true );
		$discord_role                       = '';
		$discord_roles                      = array();
		$ranks_user                            = map_deep( ets_gamipress_discord_get_user_ranks_ids( 11), 'sanitize_text_field' );

		$ets_gamipress_discord_send_welcome_dm = sanitize_text_field( trim( get_option( 'ets_gamipress_discord_send_welcome_dm' ) ) );
		if ( is_array( $ranks_user ) ) {
			foreach ( $ranks_user as $rank_id ) {

				if ( is_array( $ets_gamipress_discord_role_mapping ) && array_key_exists( 'gamipress_rank_type_id_' . $rank_id, $ets_gamipress_discord_role_mapping ) ) {
					$discord_role = sanitize_text_field( trim( $ets_gamipress_discord_role_mapping[ 'gamipress_rank_type_id_' . $rank_id ] ) );
					array_push( $discord_roles, $discord_role );
					//update_user_meta( $user_id, '_ets_gamipress_discord_role_id_for_' . $rank_id, $discord_role );
				}
			}
		}
                
                echo '<pre>';
                
                var_dump($ets_gamipress_discord_send_welcome_dm);
                
                echo '</pre>';
?>
<form method="post" action="<?php echo esc_url( get_site_url().'/wp-admin/admin-post.php' ) ?>">
 <input type="hidden" name="action" value="gamipress_discord_save_advance_settings">
 <input type="hidden" name="current_url" value="<?php echo esc_url( ets_gamipress_discord_get_current_screen_url() )?>">   
<?php wp_nonce_field( 'gamipress_discord_advance_settings_nonce', 'ets_gamipress_discord_advance_settings_nonce' ); ?>
  <table class="form-table" role="presentation">
	<tbody>
	<tr>
		<th scope="row"><?php esc_html_e( 'Shortcode:', 'connect-gamipress-discord-addon' ); ?></th>
		<td> <fieldset>
		[gamipress_discord]
		<br/>
		<small><?php esc_html_e( 'Use this shortcode [gamipress_discord] to display connect to discord button on any page.', 'connect-gamipress-discord-addon' ); ?></small>
		</fieldset></td>
	</tr>         
	<tr>
		<th scope="row"><?php esc_html_e( 'Send welcome message', 'connect-gamipress-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_gamipress_discord_send_welcome_dm" type="checkbox" id="ets_gamipress_discord_send_welcome_dm" 
		<?php
		if ( $ets_gamipress_discord_send_welcome_dm == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Welcome message', 'connect-gamipress-discord-addon' ); ?></th>
		<td> <fieldset>
		<textarea class="ets_gamipress_discord_dm_textarea" name="ets_gamipress_discord_welcome_message" id="ets_gamipress_discord_welcome_message" row="25" cols="50"><?php if ( $ets_gamipress_discord_welcome_message ) { echo esc_textarea( wp_unslash( $ets_gamipress_discord_welcome_message ) ); } ?></textarea> 
	<br/>
	<small>Merge fields: [GP_STUDENT_NAME], [GP_STUDENT_EMAIL], [GP_RANKS], [SITE_URL], [BLOG_NAME]</small>
		</fieldset></td>
	</tr>
	  <tr>
		<th scope="row"><?php esc_html_e( 'Retry Failed API calls', 'connect-gamipress-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="retry_failed_api" type="checkbox" id="retry_failed_api" 
		<?php
		if ( $retry_failed_api == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	  <tr>
		<th scope="row"><?php esc_html_e( 'Don\'t kick students upon disconnect', 'connect-gamipress-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="kick_upon_disconnect" type="checkbox" id="kick_upon_disconnect" 
		<?php
		if ( $kick_upon_disconnect == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'How many times a failed API call should get re-try', 'connect-gamipress-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_gamipress_retry_api_count" type="number" min="1" id="ets_gamipress_retry_api_count" value="<?php if ( isset( $retry_api_count ) ) { echo esc_attr( intval( $retry_api_count ) ); } else { echo 1; } ?>">
		</fieldset></td>
	  </tr> 
	  <tr>
		<th scope="row"><?php esc_html_e( 'Set job queue concurrency', 'connect-gamipress-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="set_job_cnrc" type="number" min="1" id="set_job_cnrc" value="<?php if ( isset( $set_job_cnrc ) ) { echo esc_attr( intval( $set_job_cnrc ) ); } else { echo 1; } ?>">
		</fieldset></td>
	  </tr>
	  <tr>
		<th scope="row"><?php esc_html_e( 'Set job queue batch size', 'connect-gamipress-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="set_job_q_batch_size" type="number" min="1" id="set_job_q_batch_size" value="<?php if ( isset( $set_job_q_batch_size ) ) { echo esc_attr ( intval( $set_job_q_batch_size ) ); } else { echo 10; } ?>">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Log API calls response (For debugging purpose)', 'connect-gamipress-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="log_api_res" type="checkbox" id="log_api_res" 
		<?php
		if ( $log_api_res == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
          	
	</tbody>
  </table>
  <div class="bottom-btn">
	<button type="submit" name="adv_submit" value="ets_submit" class="ets-submit ets-bg-green">
	  <?php esc_html_e( 'Save Settings', 'connect-gamipress-discord-addon' ); ?>
	</button>
  </div>
</form>
