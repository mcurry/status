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
		totalWidth = $this.width();
		totalColumns = Math.floor(totalWidth / options.bestWidth);
		width = Math.floor((totalWidth - (totalColumns * options.margin)) / totalColumns);

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
				top = columnsHeight[bestColumn];
			} else {
				bestColumn = null;
				for (i = 0; i < totalColumns; i++) {
					if (bestColumn == null || columnsHeight[i] < columnsHeight[bestColumn]) {
						bestColumn = i;
					}
				}
				
				top = (columnsHeight[bestColumn] + options.margin) + "px";
			}

			css = {
				width: width + "px",
				position: "absolute",
				left: ((bestColumn * width) + (bestColumn * options.margin)) + "px",
				top: top
			};
			$(this).css(css);

			columnsHeight[bestColumn] += $(this).outerHeight() + options.margin;
			col++;
		})
	};

	$.fn.arrange.defaults = {
		bestWidth: 350,
		margin: 20
	};

})(jQuery);