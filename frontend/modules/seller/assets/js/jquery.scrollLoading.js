(function($) {
	$.fn.scrollLoading = function(options) {
		var defaults = {
			attr: "data-url",
			container: $(window),
			callback: $.noop,
			height: 0,
			useParentSize: false
		};
		var params = $.extend({}, defaults, options || {});
		params.cache = [];
		$(this).each(function() {
			var node = this.nodeName.toLowerCase(), url = $(this).attr(params["attr"]);
			var data = {
				obj: $(this),
				tag: node,
				url: url
			};
			params.cache.push(data);
		});
		
		var callback = function(call) {
			if ($.isFunction(params.callback)) {
				params.callback.call(call.get(0));
			}
		};
		var loading = function() {
			
			var contHeight = params.container.height();
			if ($(window).get(0) === window) {
				contop = $(window).scrollTop();
			} else {
				contop = params.container.offset().top;
			}		
			
			$.each(params.cache, function(i, data) {
				var o = data.obj, tag = data.tag, url = data.url, post, posb;

				if (o) {
				    var h = 0;
					if(params.useParentSize){
						var p= o.parent();
						h= params.height | p.height();
						post = p.offset().top - contop, posb= post + h;
						p= null;
					}else{
						h = params.height | o.height();
						post = o.offset().top - contop, posb= post + h;
					}

					if ((post >= 0 && post < contHeight) || (posb > 0 && posb <= contHeight)) {
						if (url) {
							if (tag === "img") {
								callback(o.attr("src", url));		
							} else {
								o.load(url, {}, function() {
									callback(o);
								});
							}		
						} else {
							callback(o);
						}
						data.obj = null;	
					}
				}
			});	
		};

        loading();
		params.container.bind("scroll", loading);
		$(window).resize(loading);
        $(function(){
            loading();
        });
	};
})(jQuery);