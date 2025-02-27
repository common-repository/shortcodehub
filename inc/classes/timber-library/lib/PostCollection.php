<?php

namespace Timber;

use Timber\Helper;
use Timber\Post;

/**
 * Class PostCollection
 *
 * PostCollections are internal objects used to hold a collection of posts.
 *
 * @package Timber
 */
class PostCollection extends \ArrayObject {

	public function __construct( $posts = array(), $post_class = '\Timber\Post' ) {
		$returned_posts = self::init( $posts, $post_class );

		$posts_iterator = 'Timber\PostsIterator';

		/**
		 * Filters the PostIterator class to use for a PostCollection.
		 *
		 * This filter is useful if you need to set special values or globals on each post. Because many plugins still
		 * rely on The Loop, a custom PostIterator can make it much easier to integrate third party plugins with Timber.
		 *
		 * @since 1.4.x
		 *
		 * @param string $posts_iterator The iterator class to use to loop over posts. Default `Timber\PostsIterator`.
		 * @param array  $returned_posts An array of posts.
		 * @param string $post_class     The post class to use to extend posts with.
		 */
		$posts_iterator = apply_filters( 'timber/class/posts_iterator', $posts_iterator, $returned_posts, $post_class );

		parent::__construct( $returned_posts, 0, $posts_iterator );
	}

	protected static function init( $posts, $post_class ) {
		$returned_posts = array();
		if ( is_null( $posts ) ) {
			$posts = array();
		}
		foreach ( $posts as $post_object ) {
			$post_type      = get_post_type( $post_object );
			$post_class_use = PostGetter::get_post_class( $post_type, $post_class );

			// Don't create yet another object if $post_object is already of the right type
			if ( is_a( $post_object, $post_class_use ) ) {
				$post = $post_object;
			} else {
				$post = new $post_class_use( $post_object );
			}

			if ( isset( $post->ID ) ) {
				$returned_posts[] = $post;
			}
		}

		return self::maybe_set_preview( $returned_posts );
	}


	public function get_posts() {
		return $this->getArrayCopy();
	}

	/**
	 * @param array $posts
	 * @return array
	 */
	public static function maybe_set_preview( $posts ) {
		if ( is_array( $posts ) && isset( $_GET['preview'] ) && $_GET['preview']
			   && isset( $_GET['preview_id'] ) && $_GET['preview_id']
			   && current_user_can( 'edit_post', $_GET['preview_id'] ) ) {
			// No need to check the nonce, that already happened in _show_post_preview on init

			$preview_id = $_GET['preview_id'];
			foreach ( $posts as &$post ) {
				if ( is_object( $post ) && $post->ID == $preview_id ) {
					// Based on _set_preview( $post ), but adds import_custom
					$preview = wp_get_post_autosave( $preview_id );
					if ( is_object( $preview ) ) {

						$preview = sanitize_post( $preview );

						$post->post_content = $preview->post_content;
						$post->post_title   = $preview->post_title;
						$post->post_excerpt = $preview->post_excerpt;
						$post->import_custom( $preview_id );

						add_filter( 'get_the_terms', '_wp_preview_terms_filter', 10, 3 );
					}
				}
			}
		}

		return $posts;
	}
}

class_alias( 'Timber\PostCollection', 'Timber\PostsCollection' );
class_alias( 'Timber\PostCollection', 'TimberPostsCollection' );
