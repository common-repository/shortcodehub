(function($){

	"use strict";

	var Sh_Dashboard = {

		/**
		 * Init
		 */
		init: function()
		{
			this._bind();
		},
		
		/**
		 * Binds events
		 */
		_bind: function()
		{
			$( document ).on('click', '.sh-product-rating-link', Sh_Dashboard._submitUserRating);
			$( document ).on('click', '.sh-copy-to-clipboard', Sh_Dashboard._copyCode );
		},

		/**
         * Copy to Clipboard
         */
        _copyCode: function( event )
        {
            var btn     = $( this ),
                source  = btn.siblings('.shortcode'),
                html    = source.html(),
                oldText = btn.text();

            // Remove the <copy> button.
            var tempHTML = html.replace('', '');

            // Copy the Code.
            var tempPre = $("<textarea id='temp-pre'>"),
                temp    = $("<textarea>"),
                brRegex = '/<br\s*[/\]?>/gi';

            // Append temporary elements to DOM.
            $("body").append(temp);
            $("body").append(tempPre);

            // Set temporary HTML markup.
            tempPre.html( tempHTML );

            // Format the HTML markup.
            temp.val( tempPre.text().replace(brRegex, "\r\n" ) ).select();
            document.execCommand("copy");

            // Remove temporary elements.
            temp.remove();
            tempPre.remove();

            // Copied!
            btn.text( 'Copied!' );
            setTimeout(function() {
                btn.text( 'Copy Shortcode' );
            }, 1000);
        },

		/**
		 * Submit User Rating
		 *
		 * @since 0.0.1
		 * @access private
		 * @method _submitUserRating
		 */
		_submitUserRating: function( event ) {

			var self = $( this );

			$.ajax({
				url  : ajaxurl,
				type : 'POST',
				data : {
					action : 'sh-submit-product-rating'
				},
			})
			.done(function( data, status, XHR ) {
				self.parent( '.rating-wrap' ).text( self.data( 'rated' ) );
			})
			.fail(function( jqXHR, textStatus ) {
				console.log( jqXHR );
			})
			.always(function() {
			});
		}

	};

	/**
	 * Initialization
	 */
	$(function(){
		Sh_Dashboard.init();
	});

})(jQuery);