<?php
/**
 * Add shortcode form
 *
 * @package ShortcodeHub
 * @since 0.0.1
 */

?>

<div class="wrap">

	<h1><?php esc_html_e( 'Add New', 'shortcodehub' ); ?></h1>

	<p><?php esc_html_e( 'Quick create new shortcode from below list of shortcodes.', 'shortcodehub' ); ?></p>

	<form class="sh-new-template-form" name="sh-new-template-form" method="POST">

	<hr/>

	<?php foreach ( $groups as $group_type => $group ) { ?>
		<h2><?php echo esc_html( $group['label'] ); ?></h2>
		<?php if ( isset( $group['description'] ) ) { ?>
			<p><?php echo esc_html( $group['description'] ); ?></p>
		<?php } ?>
		<div class="inner-wrap <?php echo esc_attr( $group_type ); ?>">
		<?php foreach ( $group['types'] as $shortcode_key => $shortcode ) { ?>
			<?php $is_soon = isset( $shortcode['is_soon'] ) && $shortcode['is_soon'] ? 'disabled' : ''; ?>
			<div class="box <?php echo esc_attr( $is_soon ); ?>">
				<div class="inner">

					<?php if ( isset( $shortcode['is_soon'] ) && $shortcode['is_soon'] && ! isset( $shortcode['is_pro'] ) ) { ?>
						<div class="ribbon"><span><?php esc_html_e( 'Soon', 'shortcodehub' ); ?></span></div>
					<?php } ?>
					<?php if ( isset( $shortcode['is_pro'] ) ) { ?>
						<div class="ribbon"><span><?php esc_html_e( 'Pro', 'shortcodehub' ); ?></span></div>
					<?php } ?>

					<h3 class="widget-title"><?php echo esc_html( $shortcode['title'] ); ?></h3>
					<p class="widget-description"><?php echo esc_html( $shortcode['description'] ); ?></p>

					<?php if ( isset( $shortcode['is_soon'] ) && $shortcode['is_soon'] ) { ?>
						<i><?php esc_html_e( 'Coming Soon', 'shortcodehub' ); ?></i>
						<?php
					} else {
						$selected_hook = isset( $_GET['selected-hook'] ) ? sanitize_text_field( $_GET['selected-hook'] ) : '';
						?>
						<a href="#" class="sh-create-shortcode" data-title="<?php echo esc_attr( $shortcode['title'] ); ?>" data-type="<?php echo esc_attr( $shortcode_key ); ?>" data-group="<?php echo esc_attr( $group_type ); ?>" data-selected-hook="<?php echo esc_attr( $selected_hook ); ?>"><?php esc_html_e( 'Create', 'shortcodehub' ); ?></a>
					<?php } ?>

					<?php if ( isset( $shortcode['video-link'] ) && ! empty( $shortcode['video-link'] ) ) { ?>
						<span href="<?php echo esc_url( $shortcode['video-link'] ); ?>" class="video-link">
							<span class="dashicons dashicons-video-alt3"></span>
						</span>
					<?php } ?>
					<?php if ( isset( $shortcode['doc-link'] ) ) { ?>
						<a href="<?php echo esc_url( $shortcode['doc-link'] ); ?>" class="doc-link">
							<span class="dashicons dashicons-external"></span>
						</a>
					<?php } ?>
				</div>
			</div>			
		<?php } ?>
		</div>
		<hr />
	<?php } ?>

</div>
