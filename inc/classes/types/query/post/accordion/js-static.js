(function($){

	"use strict";

	let Sh_Query_Accordion = {

		/**
		 * Init
		 * 
		 * @return void
		 */
		init: function() {
			this._init_accordion();
		},

		_init_accordion: function() {
			$('.sh-query-accordion').accordion({
				collapsible: true
			});
		}
	};

	/**
	 * Initialization
	 */
	$(function(){
		Sh_Query_Accordion.init();
	});

})(jQuery);