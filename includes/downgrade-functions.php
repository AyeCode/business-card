<?php

add_action( 'admin_notices', 'portfolio_theme_downgrade_notice' );
/**
 * Maybe show the downgrade notice.
 *
 * @return void
 */
function portfolio_theme_downgrade_notice() {

	if ( isset( $_REQUEST['business-card_v2_ok'] ) && check_admin_referer( 'business-card_nonce' ) ) {
		update_option( 'business-card_theme_v2', time() );
	}

	$v2_ok = get_option( 'business-card_theme_v2' );

	// if accepted v2 then bail
	if ( $v2_ok ) {
		return;
	}

	$action      = 'install-theme';
	$slug        = 'business-card';
	$install_url = wp_nonce_url(
		add_query_arg(
			array(
				'action'                  => $action,
				'theme'                   => $slug,
				'business-card_downgrade' => 1,
			),
			admin_url( 'update.php' )
		),
		$action . '_' . $slug
	);

	$continue_url = wp_nonce_url(
		add_query_arg(
			array(
				'business-card_v2_ok' => 1,
			)
		),
		'business-card_nonce'
	);

	$learn_more_url = 'https://docs.wpgeodirectory.com/article/729-beta-release-of-the-new-fse-directory-theme';

	?>
	<div class="notice notice-error" style="text-align: center">
		<h1 style="font-size: 40px;font-weight: bold;text-align: center;">
			<?php
			esc_html_e( 'Business Card Theme Notice', 'portfolio' );
			?>
		</h1>
		<h2 style="font-size: 22px;font-weight: bold;text-align: center;color: red;">
			<?php
			esc_html_e( 'Immediate attention required', 'portfolio' );
			?>
		</h2>
		<p>
			<strong>
			<?php
				/* translators: %1$s: Opening link tag %2$s PHP Closing link tag. */
//			echo sprintf( esc_attr__( 'Version 2 of Business Card theme has changed to be a block theme, this will require manual work to recreate your current layout. %1$sLearn more.%2$s', 'portfolio' ), "<a href='" . esc_url_raw( $learn_more_url ) . "' target='_blank'>", '</a>' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo esc_attr__( 'Version 2 of Business Card theme has changed to be a block theme, this will require manual work to recreate your current layout.', 'portfolio' );
			?>
				</strong>
		</p>
		<p><?php esc_html_e( 'Not ready? no problem', 'portfolio' ); ?><br><strong><a
						onclick="return confirm('<?php esc_html_e( 'This will downgrade Business Card to the latest version 1', 'portfolio' ); ?>');"
						class="button button-primary" href="<?php echo esc_url_raw( $install_url ); ?>" target="_parent"><i
							class="fas fa-undo-alt"></i> <?php esc_html_e( 'Downgrade to latest v1.4', 'portfolio' ); ?>
				</a></strong></p>
		<p><strong><?php esc_html_e( 'OR', 'portfolio' ); ?></strong></p>
		<p>
			<strong><a
						class="button button-primary" href="<?php echo esc_url_raw( $continue_url ); ?>" target="_parent"><?php esc_html_e( 'Continue with v2 block theme', 'portfolio' ); ?>
				</a></strong>

		</p>
		<div style="margin-bottom: 10px;"><?php esc_html_e( '( If this is a new install you can proceed and ignore this notice )', 'portfolio' ); ?></div>

	</div>
	<?php
}



/**
 * Maybe filter the package request for the theme and change it to v2.
 *
 * @param $options
 *
 * @return mixed
 */
function portfolio_theme_maybe_downgrade_v1( $options ) {

	if (
		! empty( $_REQUEST['business-card_downgrade'] )
		&& ! empty( $options['package'] )
		&& strpos( $options['package'], 'https://downloads.wordpress.org/theme/business-card.' ) === 0
		&& check_admin_referer( 'install-theme_business-card' )
	) {
		$options['package']                     = 'https://downloads.wordpress.org/theme/business-card.1.4.zip';
		$options['abort_if_destination_exists'] = false;
	}

	return $options;
}
add_filter( 'upgrader_package_options', 'portfolio_theme_maybe_downgrade_v1' );


/**
 * Old version has no child theme so we must set the template to match the main theme.
 *
 * @param $upgrader_object
 * @param $options
 *
 * @return void
 */
function portfolio_theme_downgrade_completed( $upgrader_object, $options ) {
	if ( 'theme' === $options['type'] ) {
		// Get the current theme version
		$current_theme   = wp_get_theme();
		$current_version = $current_theme->get( 'Version' );

		if (
			check_admin_referer( 'install-theme_business-card' )
			&& ! empty( $_REQUEST['theme'] )
			&& 'business-card' === $_REQUEST['theme']
			&& ! empty( $_REQUEST['business-card_downgrade'] )
		) {
			update_option( 'template', 'business-card' );
		}
	}
}
add_filter( 'upgrader_post_install', 'portfolio_theme_downgrade_completed', 10, 2 );
