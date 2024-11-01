(function($){

	"use strict";

	var Sh_Post = {

		init: function()
		{
			this._select2();
			this._bind();
			this._toggle_specific_posts();
			this._toggle_taxonomies();
			this._toggle_sorting();
			this._toggle_author();
			this._toggle_status();
			this._toggle_keyword();
			this._toggle_override_markup();
			this._toggle_override_design();
			this._currentHookDescription();
		},

		_select2: function() {
			$( '.sh-field-select2' ).select2();
		},

		_toggle_override_markup: function() {
			var value = $('.sh-query-override-markup').is(':checked') || false;

			if( value ) {
				$( '.sh-query-markup' ).show();
			} else {
				$( '.sh-query-markup' ).hide();
			}
		},

		_toggle_override_design: function() {
			var value = $('.sh-query-override-design').is(':checked') || false;

			if( value ) {
				$( '.sh-query-design' ).show();
			} else {
				$( '.sh-query-design' ).hide();
			}
		},

		_toggle_status: function() {
			var value = $('.sh-query-status-options').is(':checked') || false;

			if( value ) {
				$('.sh-query-status-options').parents('table').find('tr').show();
			} else {
				$('.sh-query-status-options').parents('table').find('tr').hide();
				$('.sh-query-status-options').parents('table').find('tr:first-child').show();
			}
		},

		_toggle_keyword: function() {
			var value = $('.sh-query-keyword-options').is(':checked') || false;

			if( value ) {
				$('.sh-query-keyword-options').parents('table').find('tr').show();
			} else {
				$('.sh-query-keyword-options').parents('table').find('tr').hide();
				$('.sh-query-keyword-options').parents('table').find('tr:first-child').show();
			}
		},

		_toggle_author: function() {
			var value = $('.sh-query-author-options').is(':checked') || false;

			if( value ) {
				$('.sh-query-author-options').parents('table').find('tr').show();
			} else {
				$('.sh-query-author-options').parents('table').find('tr').hide();
				$('.sh-query-author-options').parents('table').find('tr:first-child').show();
			}
		},

		_toggle_sorting: function() {
			var value = $('.sh-query-sorting-options').is(':checked') || false;

			if( value ) {
				$('.sh-query-sorting-options').parents('table').find('tr').show();
			} else {
				$('.sh-query-sorting-options').parents('table').find('tr').hide();
				$('.sh-query-sorting-options').parents('table').find('tr:first-child').show();
			}
		},

		_toggle_taxonomies: function() {
			var value = $('.sh-query-taxonomies-options').is(':checked') || false;

			if( value ) {
				$('.sh-query-taxonomies-options').parents('table').find('tr').show();
			} else {
				$('.sh-query-taxonomies-options').parents('table').find('tr').hide();
				$('.sh-query-taxonomies-options').parents('table').find('tr:first-child').show();
			}
		},
		
		_toggle_specific_posts: function() {
			var value = $('.sh-query-specific-posts-options').is(':checked') || false;

			if( value ) {
				$('.sh-query-specific-posts-options').parents('table').find('tr').show();
			} else {
				$('.sh-query-specific-posts-options').parents('table').find('tr').hide();
				$('.sh-query-specific-posts-options').parents('table').find('tr:first-child').show();
			}
		},
		
		/**
		 * Binds events for the ShortcodeHub.
		 *
		 * @since 0.0.1
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
			Sh_Post._show_taxonomies();
			$( document ).on('change', '.sh-query-post-type', Sh_Post._show_taxonomies );

			$( document ).on('click', '.sh-query-override-markup', Sh_Post._toggle_override_markup );
			$( document ).on('click', '.sh-query-override-design', Sh_Post._toggle_override_design );
			$( document ).on('click', '.sh-query-keyword-options', Sh_Post._toggle_keyword );
			$( document ).on('click', '.sh-query-author-options', Sh_Post._toggle_author );
			$( document ).on('click', '.sh-query-status-options', Sh_Post._toggle_status );
			$( document ).on('click', '.sh-query-sorting-options', Sh_Post._toggle_sorting );
			$( document ).on('click', '.sh-query-specific-posts-options', Sh_Post._toggle_specific_posts );
			$( document ).on('click', '.sh-query-taxonomies-options', Sh_Post._toggle_taxonomies );
			$( document ).on('change', '.sh-current-hook', Sh_Post._currentHookDescription );
			// $( document ).on('click', '.sh-query-markup-reset', Sh_Post._resetCurrentMarkup );
			$( document ).on('click', '.sh-tip .icon', Sh_Post._toggleTip );
			$( document ).on('click', '.sh-customize-design-button', Sh_Post._customizeDesign );
		},

		_show_taxonomies: function( ) {
			var post_type = $('.sh-query-post-type option:selected').val() || '';
			var post_id   = $('#post_ID').val() || '';

			$('.sh-taxonomy-row').find('.sh-content').html( '<div class="sh-taxonomy-row-not-found"><span class="spinner is-active" style="float: none;margin: 0;"></span></div>' );

			$.ajax({
				url  : ajaxurl,
				type : 'POST',
				data : {
					action    : 'sh-load-taxonomies',
					post_id   : post_id,
					post_type : post_type,
				},
			})
			.done(function( result, status, XHR ) {

				if( result.success ) {
					$('.sh-taxonomy-row').find('.sh-content').html( result.data );

					Sh_Post._select2();
				}
			})
			.fail(function( jqXHR, textStatus ) {
				console.log( jqXHR );
			})
			.always(function() {
			});
		},

		_customizeDesign: function( event ) {
			event.preventDefault();

			var post_ID = $('#post_ID').val() || '';

			$.ajax({
				url  : ajaxurl,
				type : 'POST',
				data : {
					action      : 'sh-save-layout-and-open-customizer',
					post_ID     : post_ID,
				},
			})
			.done(function( data, status, XHR ) {
				if( data.success ) {
					window.open( data.data, '_blank' ); 
				}
			})
			.fail(function( jqXHR, textStatus ) {
				console.log( 'jqXHR: ' );
				console.log( jqXHR );
			})
			.always(function() {
			});
		},

		_toggleTip: function( event ) {
			event.preventDefault();
			var tip_id = $(this).data('id') || '';
			if( tip_id && $( '#' + tip_id ).length ) {
				$( '#' + tip_id ).slideToggle();
			}
		},

		_currentHookDescription: function() {
			var current_hook = $( '.sh-current-hook' ).val() || '';

			if( current_hook ) {
				$.each(SHArgs.hook_groups, function(index, hook_group) {
					$.each(hook_group.hooks, function(index, hook) {
						if( current_hook === hook.hook ) {
							$('.sh-default-hook-description').hide();
							$('.sh-current-hook-description').show().html(hook.description);
						}
					});
				});
			} else {
				$('.sh-current-hook-description').hide().html('');
				$('.sh-default-hook-description').show();
			}
		}

	};

	/**
	 * Initialize Sh_Post
	 */
	$(function(){
		Sh_Post.init();
	});

})(jQuery);