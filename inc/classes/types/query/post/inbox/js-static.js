(function($){

	"use strict";

	var Sh_Query_Inbox = {

		/**
		 * Init
		 * 
		 * @return void
		 */
		init: function() {
			this._bind();
			this.show_first_post_preview();
		},

		/**
		 * Bind
		 * 
		 * @return void
		 */
		_bind: function() {
			$( document ).on('click', '.shortcode-type-inbox .inner', Sh_Query_Inbox.show_single_post);
		},

		/**
		 * Show first post preview
		 * 
		 * @return void
		 */
		show_first_post_preview: function() {
			if( $('.shortcode-type-inbox .shortcodehub-grid > .item').eq(0).length ) {
				var post_id = $('.shortcode-type-inbox .shortcodehub-grid > .item').eq(0).attr('data-id') || '';
				Sh_Query_Inbox.get_single_post_markup( post_id );
			}
		},

		/**
		 * Show single Post
		 * 
		 * @param  int post_id Post ID.
		 * @return void
		 */
		show_single_post: function( post_id ) {

			var item = $(this).parents('.item');
			var post_id = item.attr('data-id');

			Sh_Query_Inbox.get_single_post_markup( post_id );
		},

		/**
		 * Single Post Markup
		 * 
		 * @param  int post_id Post ID.
		 * @return void
		 */
		get_single_post_markup: function( post_id ) {

			$('.shortcode-type-inbox .sh-post-preview').html( 'Loading..' );

			$('.shortcode-type-inbox .item').removeClass('active');
			$('.shortcode-type-inbox .item[data-id="'+post_id+'"]').addClass('active');
			
			// Import categories.
			$.ajax({
				url  : ShQueryInbox.ajaxurl,
				type : 'POST',
				data : {
					action : 'sh-query-inbox-show-single-post',
					sh_post_id : post_id,
				},
			})
			.fail(function( jqXHR ){
				console.log( jqXHR );
		    })
			.done(function ( response ) {
				if( response.success ) {
					$('.shortcode-type-inbox .sh-post-preview').html( response.data );
				}
			});
		}

	};

	/**
	 * Initialization
	 */
	$(function(){
		Sh_Query_Inbox.init();
	});

})(jQuery);