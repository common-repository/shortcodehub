<?php
/**
 * Shortcode Type: Query Shortcode
 *
 * @package ShortcodeHub
 * @since 1.2.0
 */

if ( ! class_exists( 'Sh_Shortcode_Type_Query' ) ) :

	/**
	 * Shortcode Type: Query Shortcode
	 *
	 * @since 1.2.0
	 */
	class Sh_Shortcode_Type_Query {

		/**
		 * Instance
		 *
		 * @var instance Class Instance.
		 * @access private
		 * @since 1.2.0
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 1.2.0
		 * @return object initialized object of class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @since 1.2.0
		 */
		public function __construct() {

			require_once SHORTCODEHUB_DIR . 'inc/classes/types/query/post/simple-grid/class-sh-shortcode-type-query-simple-grid.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/types/query/post/inbox/class-sh-shortcode-type-query-inbox.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/types/query/post/masonry-grid/class-sh-shortcode-type-query-masonry-grid.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/types/query/post/summery/class-sh-shortcode-type-query-summery.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/types/query/post/glossary/class-sh-shortcode-type-query-glossary.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/types/query/post/timeline/class-sh-shortcode-type-query-timeline.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/types/query/post/accordion/class-sh-shortcode-type-query-accordion.php';

			// Page & Post.
			add_action( 'sh_metabox_post-query', array( $this, 'metabox_markup' ), 10, 2 );

			add_action( 'sh_save_shortcode_post-query', array( $this, 'save_shortcode' ), 10, 3 );

			// AJAX.
			add_action( 'wp_ajax_sh-save-layout-and-open-customizer', array( $this, 'save_layout_and_open_customizer' ) );
			add_action( 'wp_ajax_sh-load-taxonomies', array( $this, 'load_taxonomies' ) );
		}

		/**
		 * Load taxonomies
		 *
		 * @since 1.2.0
		 * @return void
		 */
		function load_taxonomies() {
			$post_type = isset( $_POST['post_type'] ) ? $_POST['post_type'] : '';
			$post_id   = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

			if ( empty( $post_type ) || empty( $post_id ) ) {
				wp_send_json_success( '<div class="sh-taxonomy-row-not-found"><p>Please select the post type.</p></div>' );
			}

			$all_taxs = get_object_taxonomies( $post_type, 'objects' );

			ob_start();
			if ( $all_taxs ) {
				?>
				<table class="widefat sh-table">
				<?php
				foreach ( $all_taxs as $key => $current_tax ) {
					$args      = array(
						'taxonomy' => $current_tax->name,
					);
					$all_terms = get_terms( $args );

					$selected_operator = get_post_meta( $post_id, 'sh-tax-' . $current_tax->name . '-operator', true );
					$selected_terms    = (array) get_post_meta( $post_id, 'sh-tax-' . $current_tax->name, true );

					if ( $all_terms ) {
						?>
							<tr class="sh-row">
								<td class="sh-heading"><?php echo esc_html( $current_tax->label ); ?></td>
								<td class="sh-content">
									<p>
										<select name="<?php echo esc_attr( 'sh-tax-' . $current_tax->name ); ?>[]" class="sh-field-select2" multiple>
										<?php
										foreach ( $all_terms as $key => $single_term ) {
											$selected = in_array( $single_term->slug, $selected_terms ) ? 'selected' : '';
											echo '<option value="' . esc_attr( $single_term->slug ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $single_term->name ) . '</option>';
										}
										?>
										</select>
									</p>
									<p>
										<select name="<?php echo esc_attr( 'sh-tax-' . $current_tax->name ); ?>-operator">
											<option value="" selected=""><?php esc_html_e( 'Select Operator', 'shortcodehub' ); ?></option>
											<option <?php selected( $selected_operator, 'IN' ); ?> value="IN"><?php esc_html_e( 'IN', 'shortcodehub' ); ?></option>
											<option <?php selected( $selected_operator, 'NOT IN' ); ?> value="NOT IN"><?php esc_html_e( 'NOT IN', 'shortcodehub' ); ?></option>
											<option <?php selected( $selected_operator, 'AND' ); ?> value="AND"><?php esc_html_e( 'AND', 'shortcodehub' ); ?></option>
										</select>
									</p>
								</td>
							</tr>
						<?php
					}
				}
				?>
				</table>
				<?php
			} else {
				?>
				<div class="sh-taxonomy-row-not-found"><p><?php esc_html_e( 'Not have any taxonomy.', 'shortcodehub' ); ?></p></div>
				<?php
			}
			$data = ob_get_clean();

			wp_send_json_success( $data );

		}

		/**
		 * Save Shortcode
		 *
		 * @param  string $shortcode_group Shortcode Group.
		 * @param  int    $post_id            Post ID.
		 * @return void
		 */
		function save_shortcode( $shortcode_group = '', $post_id = 0 ) {

			$shortcode_type = get_post_meta( $post_id, 'shortcode-type', true );

			$post_type = isset( $_POST['sh-query-post-type'] ) ? $_POST['sh-query-post-type'] : '';
			if ( ! empty( $post_type ) ) {
				$all_taxs = get_object_taxonomies( $post_type, 'objects' );
				if ( $all_taxs ) {
					foreach ( $all_taxs as $key => $current_tax ) {
						$args      = array(
							'taxonomy' => $current_tax->name,
						);
						$all_terms = get_terms( $args );
						if ( $all_terms ) {
							if ( isset( $_POST[ 'sh-tax-' . $current_tax->name ] ) ) {
								update_post_meta( $post_id, 'sh-tax-' . $current_tax->name, $_POST[ 'sh-tax-' . $current_tax->name ] );
							}
							if ( isset( $_POST[ 'sh-tax-' . $current_tax->name . '-operator' ] ) ) {
								update_post_meta( $post_id, 'sh-tax-' . $current_tax->name . '-operator', $_POST[ 'sh-tax-' . $current_tax->name . '-operator' ] );
							}
						}
					}
				}
			}

			if ( isset( $_POST['sh-query-markup'] ) ) {
				update_post_meta( $post_id, 'sh-query-markup', $_POST['sh-query-markup'] );
			}

			if ( isset( $_POST['sh-query-layout'] ) ) {
				update_post_meta( $post_id, 'sh-query-layout', $_POST['sh-query-layout'] );
			}

			if ( isset( $_POST['sh-query-per-page'] ) ) {
				update_post_meta( $post_id, 'sh-query-per-page', $_POST['sh-query-per-page'] );
			}

			if ( isset( $_POST['sh-query-specific-posts-options'] ) ) {
				update_post_meta( $post_id, 'sh-query-specific-posts-options', absint( $_POST['sh-query-specific-posts-options'] ) );
			} else {
				update_post_meta( $post_id, 'sh-query-specific-posts-options', 0 );
			}

			if ( isset( $_POST['sh-query-status-options'] ) ) {
				update_post_meta( $post_id, 'sh-query-status-options', absint( $_POST['sh-query-status-options'] ) );
			} else {
				update_post_meta( $post_id, 'sh-query-status-options', 0 );
			}

			if ( isset( $_POST['sh-query-sorting-options'] ) ) {
				update_post_meta( $post_id, 'sh-query-sorting-options', absint( $_POST['sh-query-sorting-options'] ) );
			} else {
				update_post_meta( $post_id, 'sh-query-sorting-options', 0 );
			}

			if ( isset( $_POST['sh-query-author-in'] ) ) {
				update_post_meta( $post_id, 'sh-query-author-in', $_POST['sh-query-author-in'] );
			} else {
				update_post_meta( $post_id, 'sh-query-author-in', '' );
			}

			if ( isset( $_POST['sh-query-post-in'] ) ) {
				update_post_meta( $post_id, 'sh-query-post-in', $_POST['sh-query-post-in'] );
			} else {
				update_post_meta( $post_id, 'sh-query-post-in', '' );
			}

			if ( isset( $_POST['sh-query-status'] ) ) {
				update_post_meta( $post_id, 'sh-query-status', $_POST['sh-query-status'] );
			} else {
				update_post_meta( $post_id, 'sh-query-status', '' );
			}

			if ( isset( $_POST['sh-query-post-not-in'] ) ) {
				update_post_meta( $post_id, 'sh-query-post-not-in', $_POST['sh-query-post-not-in'] );
			} else {
				update_post_meta( $post_id, 'sh-query-post-not-in', '' );
			}

			if ( isset( $_POST['sh-query-ignore-sticky-posts'] ) ) {
				update_post_meta( $post_id, 'sh-query-ignore-sticky-posts', absint( $_POST['sh-query-ignore-sticky-posts'] ) );
			} else {
				update_post_meta( $post_id, 'sh-query-ignore-sticky-posts', 0 );
			}

			if ( isset( $_POST['sh-query-author-not-in'] ) ) {
				update_post_meta( $post_id, 'sh-query-author-not-in', $_POST['sh-query-author-not-in'] );
			} else {
				update_post_meta( $post_id, 'sh-query-author-not-in', '' );
			}

			if ( isset( $_POST['sh-query-author-options'] ) ) {
				update_post_meta( $post_id, 'sh-query-author-options', absint( $_POST['sh-query-author-options'] ) );
			} else {
				update_post_meta( $post_id, 'sh-query-author-options', 0 );
			}

			if ( isset( $_POST['sh-query-keyword-options'] ) ) {
				update_post_meta( $post_id, 'sh-query-keyword-options', absint( $_POST['sh-query-keyword-options'] ) );
			} else {
				update_post_meta( $post_id, 'sh-query-keyword-options', 0 );
			}
			if ( isset( $_POST['sh-query-override-markup'] ) ) {
				update_post_meta( $post_id, 'sh-query-override-markup', absint( $_POST['sh-query-override-markup'] ) );
			} else {
				update_post_meta( $post_id, 'sh-query-override-markup', 0 );
			}

			if ( isset( $_POST['sh-query-override-design'] ) ) {
				update_post_meta( $post_id, 'sh-query-override-design', absint( $_POST['sh-query-override-design'] ) );
			} else {
				update_post_meta( $post_id, 'sh-query-override-design', 0 );
			}

			if ( isset( $_POST['sh-query-order'] ) ) {
				update_post_meta( $post_id, 'sh-query-order', $_POST['sh-query-order'] );
			}

			if ( isset( $_POST['sh-query-keyword'] ) ) {
				update_post_meta( $post_id, 'sh-query-keyword', $_POST['sh-query-keyword'] );
			}

			if ( isset( $_POST['sh-query-orderby'] ) ) {
				update_post_meta( $post_id, 'sh-query-orderby', $_POST['sh-query-orderby'] );
			}

			if ( isset( $_POST['sh-query-post-type'] ) ) {
				update_post_meta( $post_id, 'sh-query-post-type', $_POST['sh-query-post-type'] );
			}
		}

		/**
		 * Meta box display callback.
		 *
		 * @since 1.2.0
		 *
		 * @param string  $shortcode_group Shortcode Group.
		 * @param WP_Post $post Current post object.
		 * @return void
		 */
		function metabox_markup( $shortcode_group, $post ) {

			$shortcode_type     = get_post_meta( $post->ID, 'shortcode-type', true );
			$selected_post_type = get_post_meta( $post->ID, 'sh-query-post-type', true );
			$orderby            = get_post_meta( $post->ID, 'sh-query-orderby', true );
			$order              = get_post_meta( $post->ID, 'sh-query-order', true );

			if ( empty( $order ) ) {
				$order = 'ASC';
			}

			$per_page = get_post_meta( $post->ID, 'sh-query-per-page', true );

			$custom_posts = get_post_meta( $post->ID, 'sh-query-specific-posts-options', true );
			$author       = get_post_meta( $post->ID, 'sh-query-author-options', true );
			$sorting      = get_post_meta( $post->ID, 'sh-query-sorting-options', true );
			?>
			<h3 class="sh-title"><?php esc_html_e( 'Options', 'shortcodehub' ); ?></h3>

			<?php
			$post_types = apply_filters(
				'sh_post_types',
				array(
					'post' => __( 'Post', 'shortcodehub' ),
					'page' => __( 'Page', 'shortcodehub' ),
				)
			);
			?>
			<table class="widefat sh-table">
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Post Type', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<select name="sh-query-post-type" class="sh-query-post-type">
							<option value="" selected=""><?php esc_html_e( 'Select', 'shortcodehub' ); ?></option>
							<?php foreach ( $post_types as $post_type => $post_type_title ) { ?>
								<option <?php selected( $selected_post_type, $post_type ); ?> value="<?php echo esc_attr( $post_type ); ?>">
									<?php echo esc_html( $post_type_title ); ?>
								</option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr class="sh-row sh-taxonomy-row">
					<td class="sh-heading"><?php esc_html_e( 'Taxonomies', 'shortcodehub' ); ?></td>
					<td class="sh-content"><div class="sh-taxonomy-row-not-found"><span class="spinner is-active" style="float: none;margin: 0;"></span></div></td>
				</tr>
			</table>

			<table class="widefat sh-table sh-table-advanced">
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Specific Posts', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<p class="description">
							<label>
								<input type="checkbox" name="sh-query-specific-posts-options" class="sh-query-specific-posts-options" value="1" <?php checked( $custom_posts, 1 ); ?>>
								<?php esc_html_e( 'Select inclusive or exclusive posts from the list.', 'shortcodehub' ); ?>
							</label>
						</p>
					</td>
				</tr>
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Include Only', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<?php
						$posts   = get_posts(
							array(
								'post_type'      => $post_type,
								'posts_per_page' => -1,
							)
						);
						$post_in = (array) get_post_meta( $post->ID, 'sh-query-post-in', true );
						?>
						<select name="sh-query-post-in[]" class="sh-field-select2" multiple>
							<?php
							foreach ( $posts as $key => $current_post ) {
								$selected = in_array( $current_post->ID, $post_in ) ? 'selected' : '';
								echo '<option value="' . esc_attr( $current_post->ID ) . '" ' . $selected . '>' . esc_html( $current_post->post_title ) . '</option>';
							}
							?>
						</select>
					</td>
				</tr>
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Exclude', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<?php
						$posts       = get_posts(
							array(
								'post_type'      => $post_type,
								'posts_per_page' => -1,
							)
						);
						$post_not_in = (array) get_post_meta( $post->ID, 'sh-query-post-not-in', true );
						?>
						<p>
						<select name="sh-query-post-not-in[]" class="sh-field-select2" multiple>
							<?php
							foreach ( $posts as $key => $current_post ) {
								$selected = in_array( $current_post->ID, $post_not_in ) ? 'selected' : '';
								echo '<option value="' . esc_attr( $current_post->ID ) . '" ' . $selected . '>' . esc_html( $current_post->post_title ) . '</option>';
							}
							?>
						</select>
						<?php
						$ignore_sticky_posts = get_post_meta( $post->ID, 'sh-query-ignore-sticky-posts', true );
						?>
						</p>

						<p class="description">
							<label><input type="checkbox" name="sh-query-ignore-sticky-posts" class="sh-query-ignore-sticky-posts" value="1" <?php checked( $ignore_sticky_posts, 1 ); ?>> <?php esc_html_e( 'Ignore Sticky Posts.', 'shortcodehub' ); ?></label>
						</p>

					</td>
				</tr>
			</table>

			<table class="widefat sh-table">
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'No of Items', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<input type="number" name="sh-query-per-page" value="<?php echo esc_attr( $per_page ); ?>" placeholder="10" />
					</td>
				</tr>
			</table>

			<table class="widefat sh-table sh-table-advanced">
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Sorting', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<p class="description">
							<label>
								<input type="checkbox" name="sh-query-sorting-options" class="sh-query-sorting-options" value="1" <?php checked( $sorting, 1 ); ?>>
								<?php esc_html_e( 'Sort the posts by post title, post ID, publish date etc with order by ascending or descending.', 'shortcodehub' ); ?>
							</label>
						</p>
					</td>
				</tr>
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Order By', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<select name="sh-query-orderby">
							<option value="" selected=""><?php esc_html_e( 'Select', 'shortcodehub' ); ?></option>
							<option <?php selected( $orderby, 'ID' ); ?> value="ID"><?php esc_html_e( 'ID', 'shortcodehub' ); ?></option>
							<option <?php selected( $orderby, 'title' ); ?> value="title"><?php esc_html_e( 'Title', 'shortcodehub' ); ?></option>
							<option <?php selected( $orderby, 'date' ); ?> value="date"><?php esc_html_e( 'Published date', 'shortcodehub' ); ?></option>
							<option <?php selected( $orderby, 'modified' ); ?> value="modified"><?php esc_html_e( 'Modified date', 'shortcodehub' ); ?></option>
						</select>
					</td>
				</tr>
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Order', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<label><input type="radio" name="sh-query-order" value="ASC" <?php checked( $order, 'ASC' ); ?>><?php esc_html_e( 'Ascending', 'shortcodehub' ); ?></label><br/>
						<label><input type="radio" name="sh-query-order" value="DESC" <?php checked( $order, 'DESC' ); ?>><?php esc_html_e( 'Descending', 'shortcodehub' ); ?></label>
					</td>
				</tr>
			</table>

			<?php
			$keyword_options = get_post_meta( $post->ID, 'sh-query-keyword-options', true );
			$keyword         = get_post_meta( $post->ID, 'sh-query-keyword', true );
			?>
			<table class="widefat sh-table sh-table-advanced">
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Keyword', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<p class="description">
							<label>
								<input type="checkbox" name="sh-query-keyword-options" class="sh-query-keyword-options" value="1" <?php checked( $keyword_options, 1 ); ?>>
								<?php esc_html_e( 'Show the post from the specific keyword.', 'shortcodehub' ); ?>
							</label>
						</p>
					</td>
				</tr>
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Add Keyword', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<input type="text" name="sh-query-keyword" value="<?php echo esc_attr( $keyword ); ?>" placeholder="Keywords.." style="width: 100%;">
					</td>
				</tr>
			</table>

			<?php
			$status = get_post_meta( $post->ID, 'sh-query-status-options', true );
			?>
			<table class="widefat sh-table sh-table-advanced">
				<tr class="sh-row">
					<td class="sh-heading sh-display-options"><?php esc_html_e( 'Status', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<p class="description">
							<label>
								<input type="checkbox" name="sh-query-status-options" class="sh-query-status-options" value="1" <?php checked( $status, 1 ); ?>>
								<?php esc_html_e( 'Select posts by post status.', 'shortcodehub' ); ?>
							</label>
						</p>
					</td>
				</tr>
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Status', 'shortcodehub' ); ?></td>
					<td class="sh-content">

						<?php
						$status_list     = get_post_stati( null, 'objects' );
						$selected_status = (array) get_post_meta( $post->ID, 'sh-query-status', true );
						?>
						<select name="sh-query-status[]" class="sh-field-select2" multiple>
							<?php
							foreach ( $status_list as $status_slug => $status ) {
								$selected = in_array( $status_slug, $selected_status ) ? 'selected' : '';
								echo '<option value="' . esc_attr( $status_slug ) . '" ' . $selected . '>' . esc_html( $status->label ) . '</option>';
							}
							?>
						</select>
					</td>
				</tr>
			</table>

			<table class="widefat sh-table sh-table-advanced">
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Author', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<p class="description">
							<label>
								<input type="checkbox" name="sh-query-author-options" class="sh-query-author-options" value="1" <?php checked( $author, 1 ); ?>>
								<?php esc_html_e( 'Select posts of inclusive/exclusive author.', 'shortcodehub' ); ?>
							</label>
						</p>
					</td>
				</tr>
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Include Only', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<?php
						$authors   = get_users(
							array(
								'fields'  => array( 'ID', 'display_name' ),
								'orderby' => 'display_name',
							)
						);
						$author_in = (array) get_post_meta( $post->ID, 'sh-query-author-in', true );
						?>
						<select name="sh-query-author-in[]" class="sh-field-select2" multiple>
							<?php
							foreach ( $authors as $key => $author ) {
								$selected = in_array( $author->ID, $author_in ) ? 'selected' : '';
								echo '<option value="' . esc_attr( $author->ID ) . '" ' . $selected . '>' . esc_html( $author->display_name ) . '</option>';
							}
							?>
						</select>
					</td>
				</tr>
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Exclude', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<?php
						$author_not_in = (array) get_post_meta( $post->ID, 'sh-query-author-not-in', true );
						?>
						<select name="sh-query-author-not-in[]" class="sh-field-select2" multiple>
							<?php
							foreach ( $authors as $key => $author ) {
								$selected = in_array( $author->ID, $author_not_in ) ? 'selected' : '';
								echo '<option value="' . esc_attr( $author->ID ) . '" ' . $selected . '>' . esc_html( $author->display_name ) . '</option>';
							}
							?>
						</select>
					</td>
				</tr>
			</table>

			<?php
		}

		/**
		 * Get Customizer Link
		 *
		 * @since 1.2.0
		 *
		 * @param  int $post_id Post ID.
		 * @return string       Customizer edit link.
		 */
		function get_customizer_link( $post_id ) {
			$section_id = 'sh_section_' . $post_id;
			$permalink  = get_post_permalink( $post_id );
			return admin_url( 'customize.php?url=' . $permalink . '&autofocus[section]=' . $section_id );
		}

		/**
		 * Get post type query group
		 *
		 * @since 1.2.0
		 *
		 * @param  string $shortcode_type Shrotcode Type.
		 * @return mixed
		 */
		function get_post_type_from_query_group( $shortcode_type = '' ) {
			foreach ( sh_get_shortcode_types() as $key => $group ) {
				foreach ( $group['types'] as $type_slug => $type ) {
					if ( $shortcode_type === $type_slug ) {
						return $type['post_type'];
					}
				}
			}

			return;
		}

		/**
		 * Save selected layout and open customizer.
		 *
		 * @since 1.2.0
		 *
		 * @return mixed
		 */
		function save_layout_and_open_customizer() {
			$post_id = isset( $_POST['post_ID'] ) ? absint( $_POST['post_ID'] ) : '';

			update_post_meta( $post_id, 'sh-query-override-design', 1 );

			// Success.
			wp_send_json_success( $this->get_customizer_link( $post_id ) );
		}

		/**
		 * Get Shortcode Query Args
		 *
		 * @since 1.2.0
		 *
		 * @param  int $post_id Post ID.
		 * @return mixed
		 */
		function get_query_args( $post_id = 0 ) {

			$post_type = get_post_meta( $post_id, 'sh-query-post-type', true );
			$per_page  = get_post_meta( $post_id, 'sh-query-per-page', true );

			$args = array(
				'post_type'      => $post_type,
				'posts_per_page' => ( $per_page ) ? $per_page : 10,
			);

			/** Status. */
			$status_options = get_post_meta( $post_id, 'sh-query-status-options', true );
			if ( $status_options ) {
				$selected_status = (array) get_post_meta( $post_id, 'sh-query-status', true );
				if ( ! empty( $selected_status ) ) {
					$args['post_status'] = $selected_status;
				}
			}

			/** Keyword. */
			$keyword_options = get_post_meta( $post_id, 'sh-query-keyword-options', true );
			if ( $keyword_options ) {
				$keyword = get_post_meta( $post_id, 'sh-query-keyword', true );
				if ( ! empty( $keyword ) ) {
					$args['s'] = $keyword;
				}
			}

			// Taxonomy.
			$term_args = $this->get_query_terms( $post_id );
			if ( $term_args ) {
				$args['tax_query'] = apply_filters( 'sh_query_term_args', $term_args );
			}

			/**
			 * Sorting
			 */
			$sorting_options = get_post_meta( $post_id, 'sh-query-sorting-options', true );
			if ( $sorting_options ) {
				$orderby = get_post_meta( $post_id, 'sh-query-orderby', true );
				if ( ! empty( $orderby ) ) {
					$args['orderby'] = $orderby;
				}
				$order = get_post_meta( $post_id, 'sh-query-order', true );
				if ( ! empty( $order ) ) {
					$args['order'] = $order;
				}
			}

			/**
			 * Author
			 */
			$author_options = get_post_meta( $post_id, 'sh-query-author-options', true );
			if ( $author_options ) {
				$author_in = get_post_meta( $post_id, 'sh-query-author-in', true );
				if ( ! empty( $author_in ) ) {
					$args['author__in'] = $author_in;
				}
				$author_not_in = get_post_meta( $post_id, 'sh-query-author-not-in', true );
				if ( ! empty( $author_not_in ) ) {
					$args['author__not_in'] = $author_not_in;
				}
			}

			/**
			 * Specific Posts
			 */
			$specific_posts = get_post_meta( $post_id, 'sh-query-specific-posts-options', true );
			if ( $specific_posts ) {
				$post_in = get_post_meta( $post_id, 'sh-query-post-in', true );
				if ( ! empty( $post_in ) ) {
					$args['post__in'] = $post_in;
				}
				$post_not_in = get_post_meta( $post_id, 'sh-query-post-not-in', true );
				if ( ! empty( $post_not_in ) ) {
					$args['post__not_in'] = $post_not_in;
				}
				$ignore_sticky_posts = get_post_meta( $post_id, 'sh-query-ignore-sticky-posts', true );
				if ( ! empty( $ignore_sticky_posts ) ) {
					$args['ignore_sticky_posts'] = $ignore_sticky_posts;
				}
			}

			return $args;
		}

		/**
		 * Get Query Terms
		 *
		 * @since 1.5.0
		 *
		 * @param  int $post_id Post ID.
		 * @return array        Post query terms.
		 */
		function get_query_terms( $post_id ) {
			$post_type = get_post_meta( $post_id, 'sh-query-post-type', true );

			if ( empty( $post_type ) ) {
				return array();
			}

			$term_args = array();

			$post_metas = get_post_meta( $post_id );

			foreach ( $post_metas as $meta_key => $meta_value ) {
				if ( strpos( $meta_key, 'sh-tax-' ) !== false && strpos( $meta_key, '-operator' ) === false ) {
					if ( ! empty( $meta_value[0] ) ) {
						$term_slug = str_replace( 'sh-tax-', '', $meta_key );

						$meta_value = $meta_value[0];

						if ( serialize( $meta_value ) ) {
							$meta_value = unserialize( $meta_value );
						}

						$selected_term = array(
							'taxonomy' => $term_slug,
							'field'    => 'slug',
							'terms'    => $meta_value,
						);

						$operator = get_post_meta( $post_id, 'sh-tax-' . $term_slug . '-operator', true );

						if ( ! empty( $operator ) ) {
							$selected_term['operator']         = $operator;
							$selected_term['include_children'] = ( 'AND' == $operator ) ? false : true;
						}

						$term_args[] = $selected_term;
					}
				}
			}

			return $term_args;
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Shortcode_Type_Query::get_instance();

endif;

if ( ! function_exists( 'sh_shortcode_type_query' ) ) :
	/**
	 * Get Instance
	 *
	 * @since 1.2.0
	 *
	 * @return object       Class object.
	 */
	function sh_shortcode_type_query() {
		return Sh_Shortcode_Type_Query::get_instance();
	}
endif;

if ( ! function_exists( 'sh_get_query_args' ) ) :
	/**
	 * Get Instance
	 *
	 * @since 1.2.0
	 *
	 * @param  int $post_id Post ID.
	 * @return object       Class object.
	 */
	function sh_get_query_args( $post_id = 0 ) {
		return sh_shortcode_type_query()->get_query_args( $post_id );
	}
endif;

if ( ! function_exists( 'sh_get_customizer_link' ) ) :
	/**
	 * Get Customizer Link
	 *
	 * @since 1.2.0
	 *
	 * @param  int $post_id Post ID.
	 * @return string       Customizer edit link.
	 */
	function sh_get_customizer_link( $post_id ) {
		return Sh_Shortcode_Type_Query::get_instance()->get_customizer_link( $post_id );
	}
endif;

if ( ! function_exists( 'sh_get_post_type_from_query_group' ) ) :
	/**
	 * Get Post type from query shortcode group
	 *
	 * @since 1.2.0
	 *
	 * @param string $shortcode_type Shortcode type.
	 * @return string       Post type from the query shortcode group.
	 */
	function sh_get_post_type_from_query_group( $shortcode_type ) {
		return Sh_Shortcode_Type_Query::get_instance()->get_post_type_from_query_group( $shortcode_type );
	}
endif;

if ( ! function_exists( 'sh_get_query_terms' ) ) :
	/**
	 * Get Terms
	 *
	 * @since 1.5.0
	 *
	 * @param  int $post_id Post ID.
	 * @return array       Terms.
	 */
	function sh_get_query_terms( $post_id = 0 ) {
		return sh_shortcode_type_query()->get_query_terms( $post_id );
	}
endif;
