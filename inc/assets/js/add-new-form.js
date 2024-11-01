(function($){

	"use strict";

	var Sh_Add_New = {

		/**
		 * Init
		 * 
		 * @return void
		 */
		init: function()
		{
			this._bind();
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
			$( document ).on('click', '.sh-create-shortcode', Sh_Add_New._create_shortcode );
		},

		/**
		 * Create Shortcode
		 * 
		 * @return void
		 */
		_create_shortcode: function( event ) {
            event.preventDefault();

			var btn           = $(this),
				title         = btn.data('title') || '',
				type          = btn.data('type') || '',
				group         = btn.data('group') || '',
				selected_hook = btn.data('selected-hook') || '';

            if( btn.hasClass('processing') ) {
            	return;
            }
            console.log( 'processing..' );

            btn.addClass('processing').text('Creating..');

            $.ajax({
                url  : ajaxurl,
                type : 'POST',
                data : {
					action   : 'sh_ajax_create_shortcode',
					title    : title,
					type     : type,
					group    : group,
					selected_hook    : selected_hook,
					security : SHAddNewVars._nonce
                },
            })
            .done(function( response, status, XHR ) {

                if( response.success ) {
                	btn.removeClass('processing').text('Shortcode Created!');
	            	setTimeout(function() {
	            		btn.text('Redirecting to Edit Shortcode..');
	            	}, 1000);
                    location = response['data']['url'];
                } else {
                    btn.text( response.data );
                }
            })
            .fail(function( jqXHR, textStatus )
            {
            })
            .always(function()
            {
            });
        
		}

	};

	/**
	 * Initialize Sh_Add_New
	 */
	$(function(){
		Sh_Add_New.init();
	});

})(jQuery);