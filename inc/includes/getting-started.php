<?php
/**
 * Getting Started
 *
 * @package ShortcodeHub
 * @since 0.0.1
 */

?>

<div class="sh-getting-started">
	<h1><span class="title"><?php echo esc_html( 'Getting Started', 'shortcodehub' ); ?></span></h1>

	<h2><?php esc_html_e( 'Quick Video', 'shortcodehub' ); ?></h2>
	<iframe width="560" height="315" src="https://www.youtube.com/embed/_Uyd9WfH6ZE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

	<h2><?php esc_html_e( 'Create Shortcode from a Scratch', 'shortcodehub' ); ?></h2>
	<p class="description"><?php esc_html_e( 'Creating a shortcode from a scratch is very simple. Simply select shortcode type and click on Add Shortcode button.', 'shortcodehub' ); ?></p>
	<img class="select-shortcode-type" src="<?php echo esc_url( SHORTCODEHUB_URI . 'inc/assets/images/select-shortcode-type.png' ); ?>">
	<p class="description"><?php esc_html_e( 'We have categorize the shortcodes in a group. Check below shortcode types and groups.', 'shortcodehub' ); ?></p>

	<ul>
		<li><b><?php esc_html_e( 'Basic', 'shortcodehub' ); ?></b></li>
		<ol>
			<li><?php esc_html_e( 'Text Editor', 'shortcodehub' ); ?> - <span class="shortcode-type-description"><?php esc_html_e( 'Add content though WYSWYG editor/TinyMCE editor and show them with shortcode.', 'shortcodehub' ); ?> <!-- Let's quick create <a href="<?php echo admin_url( 'edit.php?post_type=shortcode&page=shortcodehub&create-shortcode=yes&shortcode-title=New Text Editor&shortcode-type=text-editor' ); ?>" target="_blank">Text Shortcode</a> -->.</span></li>
		</ol>
		<li><b><?php esc_html_e( 'Core', 'shortcodehub' ); ?></b></li>
		<ol>
			<li><?php esc_html_e( 'Widget', 'shortcodehub' ); ?> - <span class="shortcode-type-description"><?php esc_html_e( 'Select any active widget and show it with shortcode.', 'shortcodehub' ); ?></span></li>
			<li><?php esc_html_e( 'Menu', 'shortcodehub' ); ?> - <span class="shortcode-type-description"><?php esc_html_e( 'Select any menu and show it with shortcode.', 'shortcodehub' ); ?></span></li>
		</ol>

	</ul>
	<hr><h2><?php esc_html_e( 'Yup!', 'shortcodehub' ); ?></h2>
	<p class="description"><?php esc_html_e( 'You have created a shortcode. Now you can show it with:', 'shortcodehub' ); ?></p>
	<ol>
		<li><?php esc_html_e( 'Shortcode - Use shortcode <code>[shortcodehub id="{POST_ID}"]</code> anywhere.', 'shortcodehub' ); ?></li>
		<li><?php esc_html_e( 'Hook - Select action hook to show your shortcode. E.g.', 'shortcodehub' ); ?></li>
	</ol>
	<img class="sh-show-shortcode" src="<?php echo esc_url( SHORTCODEHUB_URI . 'inc/assets/images/show-shortcode.png' ); ?>">
	<p class="description">
		<?php
		/* translators: $1%s is show hooks link. */
		printf( __( 'Don\'t know hook locations? Then, Click on <a href="$1%s" target="_blank">show hooks</a> to see the available hooks location on frontend. E.g.', 'shortcodehub' ), esc_url( sh_get_show_hooks_url() ) );
		?>
		</p>
	<img class="sh-show-hooks" src="<?php echo esc_url( SHORTCODEHUB_URI . 'inc/assets/images/show-hooks.png' ); ?>">

	<hr/>

	<h2><?php esc_html_e( 'List of some useful shortcodes', 'shortcodehub' ); ?></h2>

	<table class="sh-most-useful-shortcodes-table">
		<tr>
			<td>
				<h4><?php esc_html_e( '# Post Shortcode\'s', 'shortcodehub' ); ?></h4>
				<div>
					<p><?php esc_html_e( 'Use below shortcodes to show the post title, id, content etc.', 'shortcodehub' ); ?></p>
					<p><?php esc_html_e( 'E.g. Use <code>[sh_post_title]</code> to show the current post title.', 'shortcodehub' ); ?></p>
					<p><?php esc_html_e( 'Or Use <code>[sh_post_title id="123"]</code> to show another post title.', 'shortcodehub' ); ?></p>
				</div>
				<ul class="most-useful-shortcode-list">
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_id]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_title]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_slug]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_content]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_excerpt]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_author]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_date]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_date_gmt]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_modified]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_modified_gmt]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_publish_date]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_publish_date_gmt]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_update_date]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_update_date_gmt]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_status]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_comment_status]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_ping_status]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_password]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_to_ping]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_pinged]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_content_filtered]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_parent]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_guid]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_menu_order]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_type]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_mime_type]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_comment_count]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_post_filter]</span></li>
				</ul>
			</td>
			<td>
				<h4><?php esc_html_e( '# Author Shortcode\'s', 'shortcodehub' ); ?></h4>
				<div>
					<p><?php esc_html_e( 'Use below shortcodes to show the author name, description etc.', 'shortcodehub' ); ?></p>
					<p><?php esc_html_e( 'E.g. Use <code>[sh_author_display_name]</code> to show the current logged in user display name.', 'shortcodehub' ); ?></p>
					<p><?php esc_html_e( 'Or Use <code>[sh_author_display_name id="123"]</code> to show another user display name.', 'shortcodehub' ); ?></p>
				</div>
				<ul>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_id]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_admin_color]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_aim]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_comment_shortcuts]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_description]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_display_name]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_first_name]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_jabber]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_last_name]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_nickname]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_plugins_last_view]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_plugins_per_page]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_rich_editing]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_syntax_highlighting]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_activation_key]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_description]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_email]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_firstname]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_lastname]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_level]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_login]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_nicename]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_pass]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_registered]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_status]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_user_url]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_author_yim]</span></li>
				</ul>
			</td>
			<td>
				<h4><?php esc_html_e( '# Theme Shortcode\'s', 'shortcodehub' ); ?></h4>
				<div>
					<p><?php esc_html_e( 'Use below shortcodes to show the theme name, description etc.', 'shortcodehub' ); ?></p>
					<p><?php esc_html_e( 'E.g. Use <code>[sh_theme_version]</code> to show the current active theme version.', 'shortcodehub' ); ?></p>
					<p><?php esc_html_e( 'Or Use <code>[sh_theme_version slug="awesomepress"]</code> to show installed theme version by theme slug.', 'shortcodehub' ); ?></p>
				</div>
				<ul>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_list]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_name]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_url]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_title]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_status]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_version]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_parent_theme]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_template_dir]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_stylesheet_dir]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_template]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_stylesheet]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_screenshot]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_screenshot_url]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_description]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_author]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_author_link]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_root]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_root_uri]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_template_file_names]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_template_file_links]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_tags]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_theme_download]</span></li>
				</ul>
			</td>
			<td>
				<h4><?php esc_html_e( '# Plugin Shortcode\'s', 'shortcodehub' ); ?></h4>
				<div>
					<p><?php esc_html_e( 'Use below shortcodes to show the plugin name, description etc.', 'shortcodehub' ); ?></p>
					<p><?php esc_html_e( 'E.g. Use <code>[sh_plugin_version]</code> to show the current active plugin version.', 'shortcodehub' ); ?></p>
					<p><?php esc_html_e( 'Or Use <code>[sh_plugin_version slug="shortcodehub"]</code> to show installed plugin version by plugin slug.', 'shortcodehub' ); ?></p>
				</div>
				<ul>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_name]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_uri]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_version]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_description]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_author]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_author_uri]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_author_url]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_textdomain]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_domainpath]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_network]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_title]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_author_name]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_list]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_active_list]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_inactive_list]</span></li>
					<li><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_plugin_download]</span></li>
				</ul>
			</td>
		</tr>
	</table>

	<hr>

	<table class="sh-most-useful-shortcodes-table">
		<tr>
			<td>
				<h4><?php esc_html_e( '# Date Shortcode\'s', 'shortcodehub' ); ?></h4><br/>
				<span class="shortcode-heading"><?php esc_html_e( 'Date Examples', 'shortcodehub' ); ?></span>
				<p><?php esc_html_e( 'Use below shortcodes to show the current date.', 'shortcodehub' ); ?></p>
				<table class="sh-most-useful-shortcodes-table-inline">
					<tr><td><?php esc_html_e( 'Example', 'shortcodehub' ); ?></b></td><td><?php esc_html_e( 'Output', 'shortcodehub' ); ?></td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='d/m/y']</span></td><td>15/02/19</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='d-M-Y']</span></td><td>15-Feb-2019</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='d F Y']</span></td><td>15 February 2019</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='dS F Y']</span></td><td>15th February 2019</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='M, dS Y']</span></td><td>Feb, 15th 2019</td></tr>
				</table>

				<br/>
				<span class="shortcode-heading"><?php esc_html_e( 'Date & Time Examples', 'shortcodehub' ); ?></span>
				<p><?php esc_html_e( 'Use below shortcodes to show the current date & time.', 'shortcodehub' ); ?></p>
				<table class="sh-most-useful-shortcodes-table-inline">
					<tr><td><?php esc_html_e( 'Example', 'shortcodehub' ); ?></b></td><td><?php esc_html_e( 'Output', 'shortcodehub' ); ?></td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='d-m-Y h:i:s a']</span></td><td>15-02-2019 05:57:15 pm</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='d-M-Y h:i:s a']</span></td><td>15-Feb-2019 05:57:15 pm</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='d F Y h:i a']</span></td><td>15 February 2019 05:57 pm</td></tr>
				</table>
			</td>
			<td>
				<h4><?php esc_html_e( '# Time Shortcode\'s', 'shortcodehub' ); ?></h4><br/>

				<span class="shortcode-heading"><?php esc_html_e( 'Time 12 hrs Examples', 'shortcodehub' ); ?></span>
				<p><?php esc_html_e( 'Use below shortcodes to show the current time in 12 hours format.', 'shortcodehub' ); ?></p>
				<table class="sh-most-useful-shortcodes-table-inline">
					<tr><td><?php esc_html_e( 'Example', 'shortcodehub' ); ?></b></td><td><?php esc_html_e( 'Output', 'shortcodehub' ); ?></td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='h:i a']</span></td><td>05:57 pm</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='h:i A']</span></td><td>05:57 PM</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='h:i:s a']</span></td><td>05:57:15 pm</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='h:i:s A']</span></td><td>05:57:15 PM</td></tr>
				</table>

				<br/>
				<span class="shortcode-heading"><?php esc_html_e( 'Time 24 hrs Examples', 'shortcodehub' ); ?></span>
				<p><?php esc_html_e( 'Use below shortcodes to show the current time in 24 hours format.', 'shortcodehub' ); ?></p>
				<table class="sh-most-useful-shortcodes-table-inline">
					<tr><td><?php esc_html_e( 'Example', 'shortcodehub' ); ?></b></td><td><?php esc_html_e( 'Output', 'shortcodehub' ); ?></td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='H:i a']</span></td><td>17:57 pm</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='H:i A']</span></td><td>17:57 PM</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='H:i:s a']</span></td><td>17:57:15 pm</td></tr>
					<tr><td><span class="sh-copy-to-clipboard"><span class="inner"><?php esc_html_e( 'Copy Shortcode', 'shortcodehub' ); ?></span></span><span class="shortcode">[sh_date format='H:i:s A']</span></td><td>17:57:15 PM</td></tr>
				</table>

			</td>
		</tr>
	</table>

	<hr>

	<p class="description" style="margin: 1em auto .5em auto;">
		<b style="margin-bottom: .5em;display: inline-block;"><?php esc_html_e( 'Quick Links', 'shortcodehub' ); ?></b>:<br>
		<?php
		/* translators: %s is forum link. %s is doc link. */
		printf( __( '- Do you have any questions? Checkout the <a href="%1$s" target="_blank">forum</a> or <a href="%2$s" target="_blank">documentation</a>.', 'shortcodehub' ), 'https://forum.surror.com/forums/forum/shortcodehub/', 'https://docs.surror.com/' );
		?>
		<br>

		<?php
		$subject = __( 'New Suggestion Request', 'shortcodehub' );
		$message = __( 'I have a new suggestion request for ShortcodeHub. I suggest ______', 'shortcodehub' );

		/* translators: %s is support link. */
		printf( __( '- Do you have any suggestions? Feel free to <a href="%1$s" target="_blank">contact us</a>.', 'shortcodehub' ), sh_get_support_link( $subject, $message ) );
		?>
		<br>

		<?php
		$subject = __( 'I have a issue ___', 'shortcodehub' );
		$message = __( 'I have a issue in ShortcodeHub. Issue is ______', 'shortcodehub' );

		/* translators: %s is support link. */
		printf( __( '- Do you have any issues? Don\'t hesitate to <a href="%1$s" target="_blank">open a support ticket</a>.', 'shortcodehub' ), sh_get_support_link( $subject, $message ) );
		?>
	</p>

	<p class="description" style="margin-bottom: 1em;">
	<?php
		/* translators: %s is pro link. */
		printf( __( 'Get much more in ShortcodeHub Pro. <a href="%1$s" target="_blank">Get Pro</a>.', 'shortcodehub' ), esc_url( sh_get_product_pro_url() ) );
	?>
	</p>


	<hr/>

</div>
