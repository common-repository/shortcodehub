(function($){

	"use strict";

	var Sh_Query_Masonry = {

		/**
		 * Init
		 * 
		 * @return void
		 */
		init: function() {
			this._init_masonary();
			this._bind();
		},

		/**
		 * Init Masonry
		 * 
		 * @return void
		 */
		_init_masonary: function() {
			$('.sh-masonry').masonry({
 				horizontalOrder : false,
 				percentPosition : false
 			});
		},

	};

	/**
	 * Initialization
	 */
	$(function(){
		Sh_Query_Masonry.init();
	});

})(jQuery);