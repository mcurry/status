/*
 * App Status Planel CakePHP Plugin
 * Copyright (c) 2009 Matt Curry
 * www.PseudoCoder.com
 * http://github.com/mcurry/status
 *
 * @author      Matt Curry <matt@pseudocoder.com>
 * @license     MIT
 *
 */
 
(function($) {
	var options = null;
	
	$.fn.arrange = function(opts) {
		options = $.extend({}, $.fn.arrange.defaults, opts);
		
		return this.each(function() {
			$elem = $(this);
			$(window).resize(function(){
				$.fn.arrange.run($elem);
			}).resize();
		});
	};

	$.fn.arrange.run = function($this) {
		totalWidth = $this.innerWidth();
		
		//figure out the margin
		widthMargin = $this.children("div:first").outerWidth(true) - $this.children("div:first").outerWidth();
		heightMargin = $this.children("div:first").outerHeight(true) - $this.children("div:first").outerHeight();
		
		totalColumns = Math.floor(totalWidth / options.bestWidth);
		width = Math.floor((totalWidth - (totalColumns * widthMargin)) / totalColumns);

		columnsHeight = {};
		row = 0;
		col = 0;

		for (i = 0; i < totalColumns; i++) {
			columnsHeight[i] = 0;
		}

		$this.children("div").each(function(i) {
			if (i % totalColumns == 0) {
				row++;
				col = 0;
			}

			bestColumn = col;
			if (row == 1) {
				height = 0;
				columnTop = columnsHeight[bestColumn];
			} else {
				bestColumn = null;
				for (i = 0; i < totalColumns; i++) {
					if (bestColumn == null || columnsHeight[i] < columnsHeight[bestColumn]) {
						bestColumn = i;
					}
				}
				
				columnTop = columnsHeight[bestColumn]+ "px";
			}

			css = {
				width: width + "px",
				position: "absolute",
				left: ((bestColumn * width) + (bestColumn * widthMargin)) + "px",
				top: columnTop
			};
			$(this).css(css);

			columnsHeight[bestColumn] += $(this).outerHeight() + heightMargin;
			col++;
		})
	};

	$.fn.arrange.defaults = {
		bestWidth: 350
	};

})(jQuery);