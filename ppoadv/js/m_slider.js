// JavaScript Document
//var so_spotlight = 1;

(function($) { // Compliant with jquery.noConflict()
	$.fn.Sj_So_Article_Slider = function(o) {
		o = $.extend( {
			btnPrev : null,
			btnNext : null,
			btnPause : null,
			btnGo : null,
			mouseWheel : true,
			auto : null,
			speed : 200,
			easing : null,
			vertical : false,
			circular : true,
			visible : 0,
			start : 0,
			scroll : 1,
			moduleId : 0,
			thumbHeight : 1,
			num_element : 0,
			beforeStart : null,
			afterEnd : null,
			type : 'theme1',
			navigation : ''
		}, o || {});

		var time_interval;
		var is_tooltip_hover = 0;
		var time_out;

		if (o.type == 'theme14' || o.type == 'theme15' || o.type == 'theme16'
				|| o.type == 'theme18') {
			$(this).hover(function() {
				$(o.navigation).show();
			}, function() {
				$(o.navigation).hide();
			});
		}
		// Stop when hover

		return this.each(function() { // Returns the element collection.
										// Chainable.

					var running = false, animCss = o.vertical ? "top" : "left", sizeCss = o.vertical ? "height"
							: "width";
					var div = $(this), ul = $("ul", div), tLi = $("li", ul), tl = tLi
							.size(), v = o.visible;
					if (o.circular) {
						ul.prepend(tLi.slice(tl - v - 1 + 1).clone()).append(
								tLi.slice(0, v).clone());
						//o.start += v;
					}

					var li = $("li", ul), itemLength = li.size(), curr = o.start, last = 0;
					div.css("visibility", "visible");
					li.css( {
						overflow : "hidden",
						float : o.vertical ? "none" : "left"
					});
					ul.css( {
						margin : "0",
						padding : "0",
						position : "relative",
						"list-style-type" : "none",
						"z-index" : "1"
					});
					div.css( {
						overflow : "hidden",
						position : "relative",
						"z-index" : "2",
						left : "0px"
					});

					var liSize = o.vertical ? height(li) : width(li); // Full
																		// li
																		// size(incl
																		// margin)-Used
																		// for
																		// animation
                                                                        
                    if (!liSize){
                        liSizeWidth = parseInt(li.css('width')) + parseInt(li.css('marginLeft')) + parseInt(li.css('marginRight'));
                        liSize = o.vertical ? parseInt(li.css('height')) : liSizeWidth;
                    }                                                 
                    
					var ulSize = liSize * itemLength; // size of full ul(total
														// length, not just for
														// the visible items)
					var divSize = liSize * v; // size of entire div(total
												// length for just the visible
												// items)

					/* Get max height of li tag */

					/*
					 * var max_height = 0; for (i = 0; i < li.length; i++) { if
					 * (max_height < li[i].offsetHeight) { max_height =
					 * li[i].offsetHeight; } }
					 */
					var arrItemHeight = $('div.panecontent_' + o.moduleId);
					var maxItemHeight = 0;
					$.each(arrItemHeight, function(key, val) {
						if (maxItemHeight < $(val).height()) {
							maxItemHeight = $(val).height();
						}

					});

					$.each(arrItemHeight, function(key, val) {
						$(val).css('height', maxItemHeight);
					});
					maxItemHeight += 20;
					$('#sj_so_artilce_slider_' + o.moduleId).css(
							'height',
							(maxItemHeight + o.thumbHeight) * o.num_element
									+ 'px');
					$('#liPanenav_' + o.moduleId).css(
							'height',
							(maxItemHeight + o.thumbHeight) * o.num_element
									+ 'px');

					BrowserDetect.init();
					var max_height = 0;
					var li_height = 0;
					var max_width = 0;
					var li_width = 0;

					$.each(li, function(key, val) {
						li_height = parseInt($(val).children('div.so_item')
								.css('height'));
						if (max_height < li.height())
							max_height = li.height();

					})

					max_height += 10;
					max_width = li.width();

					/*
					 * if (o.type == 'theme1' || o.type == 'theme2' || o.type ==
					 * 'theme3' || o.type == 'theme4' || o.type == 'theme5' ||
					 * o.type == 'theme6'|| o.type == 'theme7') { li.css({width:
					 * max_width, height: max_height }); }
					 */
					ul.css(sizeCss, ulSize + "px").css(animCss,
							-(curr * liSize));
					if (o.vertical) {
						div.css(sizeCss, divSize + "px"); // Width of the DIV.
															// length of visible
															// images
						$(".so_navigation").css(sizeCss, divSize + "px");

					}

					if (o.btnPrev)
						$(o.btnPrev).click(function() {
							return go(curr - o.scroll);
						});

					if (o.btnNext)
						$(o.btnNext).click(function() {//alert('hungpq');
							return go(curr + o.scroll);
						});

					if (o.btnPause)
						$(o.btnPause).click(
								function() {
									if ($(o.btnPause + ' > img').attr('src')
											.indexOf('pause') > 0) {
										o.auto = 0;
										clearInterval(time_out);
										$(o.btnPause + ' > img').attr(
												'src',
												$(o.btnPause + ' > img').attr(
														'src').replace('pause',
														'play'));
									} else {
										o.auto = 1;
										time_out = setInterval(function() {
											go(curr + o.scroll);
										}, o.auto + o.speed);
										$(o.btnPause + ' > img').attr(
												'src',
												$(o.btnPause + ' > img').attr(
														'src').replace('play',
														'pause'));
									}

								});

					if (o.btnGo)
						$.each(o.btnGo, function(i, val) {
							$(val).click(function() {
								return go(o.circular ? o.visible + i : i);
							});
						});

					if (o.mouseWheel && div.mousewheel)
						div.mousewheel(function(e, d) {
							return d > 0 ? go(curr - o.scroll) : go(curr
									+ o.scroll);
						});

					if (o.auto) {
						time_out = setInterval(function() {
							go(curr + o.scroll);
						}, 0);//o.auto + o.speed);
					}

					if (o.type == 'theme14' || o.type == 'theme18'
							|| o.type == 'theme1' || o.type == 'theme2'
							|| o.type == 'theme6' || o.type == 'theme8'
							|| o.type == 'theme9') {
						$(this).find('li').hover(function() {
							clearInterval(time_out);
							ul.pause();
							$(this).addClass("so_hover");
						}, function() {
							if (o.auto) {
								//o.scroll = 2;
								 clearInterval(time_out);
								 time_out = setInterval(function() {
								 	go(curr + o.scroll);
								 }, 0);//o.auto + o.speed);
								ul.resume ();
							}
							//$(this).removeClass("so_hover");
						});
					} else if (o.type == 'theme17' || o.type == 'theme5') {
						// $(o.navigation).css("bottom", "50px");
						$(this).find('li').hover(function() {
							clearInterval(time_out);
							$(this).addClass("so_hover");
						}, function() {
							if (o.auto) {
								//o.scroll = 2;
								clearInterval(time_out);
								time_out = setInterval(function() {
									go(curr + o.scroll);
								}, o.auto + o.speed);
							}
							$(this).removeClass("so_hover");
						});

					} else if (o.type == 'theme16' || o.type == 'theme4'
							|| o.type == 'theme7' || o.type == 'theme12'
							|| o.type == 'theme13') {
						$(this).find('li').hover(
								function() {
									$(this).addClass("so_hover");
									is_tooltip_hover = 0;
									clearInterval(time_out);
									clearInterval(time_interval);
									var pos = $(this).offset();

									$("#so_tooltip" + o.moduleId).html(
											$(this).find('.so_content').html())
											.css( {
												display : 'block',
												top : pos.top - 180,
												left : pos.left
											});

									$("#so_tooltip" + o.moduleId).hover(
											function() {
												clearInterval(time_out);
												is_tooltip_hover = 1;
											}, function() {
												is_tooltip_hover = 0;
												update_tooltip();
											});

								}, function() {
									$(this).removeClass("so_hover");
									update_tooltip();
								});

					} else if (o.type == 'theme15' || o.type == 'theme3'
							|| o.type == 'theme10' || o.type == 'theme11') {
						$(this).find('li').hover(
								function() {
									clearInterval(time_out);
									$($(this).find('.so_content')).animate(
											{
												height : parseInt($(this).css(
														"height"))
														- 80 + "px"
											}, 500);
								}, function() {
									if (o.auto) {
										//o.scroll = 2;
										clearInterval(time_out);
										time_out = setInterval(function() {
											go(curr + o.scroll);
										}, o.auto + o.speed);
									}
									$($(this).find('.so_content')).animate( {
										'height' : "15px"
									}, 100);
								});
					}

					function update_tooltip() {
						time_out = setTimeout(function() {
							if (is_tooltip_hover == 0) {
								$("#so_tooltip" + o.moduleId).css( {
									display : 'none'
								});
								if (o.auto) {
									//o.scroll = 2;
									clearInterval(time_interval);
									time_interval = setInterval(function() {
										go(curr + o.scroll);
									}, o.auto + o.speed);
								}
							}
						}, 1000);
					}

					function vis() {
						return li.slice(curr).slice(0, v);
					}
					;

					function go(to) {
						if (!running) {

							if (o.beforeStart)
								o.beforeStart.call(this, vis());

							if (o.circular) { // If circular we are in first
												// or last, then goto the other
												// end
								if (to <= o.start - v - 1) { // If first,
																// then goto
																// last
									ul.css(animCss,
											-((itemLength - (v * 2)) * liSize)
													+ "px");
									// If "scroll" > 1, then the "to" might not
									// be equal to the condition; it can be
									// lesser depending on the number of
									// elements.
									curr = to == o.start - v - 1 ? itemLength
											- (v * 2) - 1 : itemLength
											- (v * 2) - o.scroll;
								} else if (to >= itemLength - v + 1) { // If
																		// last,
																		// then
																		// goto
																		// first
									ul.css(animCss, -((v) * liSize) + "px");
									// If "scroll" > 1, then the "to" might not
									// be equal to the condition; it can be
									// greater depending on the number of
									// elements.
									curr = to == itemLength - v + 1 ? v + 1 : v
											+ o.scroll;
								} else
									curr = to;
							} else { // If non-circular and to points to
										// first or last, we just return.
								if (to < 0 || to > itemLength - v)
									return;
								else
									curr = to;
							} // If neither overrides it, the curr will still
								// be "to" and we can proceed.

							running = true;

							ul.animate(animCss == "left" ? {
								left : -(curr * liSize)
							} : {
								top : -(curr * liSize)
							}, o.speed, "linear", function() {
								if (o.afterEnd)
									o.afterEnd.call(this, vis());
								running = false;
							});
							// Disable buttons when the carousel reaches the
							// last/first, and enable when not
							if (!o.circular) {
								$(o.btnPrev + "," + o.btnNext).removeClass(
										"disabled");
								$(
										(curr - o.scroll < 0 && o.btnPrev)
												|| (curr + o.scroll > itemLength
														- v && o.btnNext)

								).addClass("disabled");

								// $(o.btnPrev).removeClass("so_pre_hor");
								// alert($(o.btnPrev).attr("id"));
							}

						}
						return false;
					}
					;
				});
	};

	function css(el, prop) {
		return parseInt($.css(el[0], prop)) || 0;
	}
	;
	function width(el) {
		return el[0].offsetWidth + css(el, 'marginLeft')
				+ css(el, 'marginRight');
	}
	;
	function height(el) {
		return el[0].offsetHeight + css(el, 'marginTop')
				+ css(el, 'marginBottom');
	}
	;

	var BrowserDetect = {
		init : function() {
			this.browser = this.searchString(this.dataBrowser)
					|| "An unknown browser";
			this.version = this.searchVersion(navigator.userAgent)
					|| this.searchVersion(navigator.appVersion)
					|| "an unknown version";
			this.OS = this.searchString(this.dataOS) || "an unknown OS";
		},
		searchString : function(data) {
			for ( var i = 0; i < data.length; i++) {
				var dataString = data[i].string;
				var dataProp = data[i].prop;
				this.versionSearchString = data[i].versionSearch
						|| data[i].identity;
				if (dataString) {
					if (dataString.indexOf(data[i].subString) != -1)
						return data[i].identity;
				} else if (dataProp)
					return data[i].identity;
			}
		},
		searchVersion : function(dataString) {
			var index = dataString.indexOf(this.versionSearchString);
			if (index == -1)
				return;
			return parseFloat(dataString.substring(index
					+ this.versionSearchString.length + 1));
		},
		dataBrowser : [ {
			string : navigator.userAgent,
			subString : "Chrome",
			identity : "Chrome"
		}, {
			string : navigator.userAgent,
			subString : "OmniWeb",
			versionSearch : "OmniWeb/",
			identity : "OmniWeb"
		}, {
			string : navigator.vendor,
			subString : "Apple",
			identity : "Safari",
			versionSearch : "Version"
		}, {
			prop : window.opera,
			identity : "Opera"
		}, {
			string : navigator.vendor,
			subString : "iCab",
			identity : "iCab"
		}, {
			string : navigator.vendor,
			subString : "KDE",
			identity : "Konqueror"
		}, {
			string : navigator.userAgent,
			subString : "Firefox",
			identity : "Firefox"
		}, {
			string : navigator.vendor,
			subString : "Camino",
			identity : "Camino"
		}, { // for newer Netscapes (6+)
					string : navigator.userAgent,
					subString : "Netscape",
					identity : "Netscape"
				}, {
					string : navigator.userAgent,
					subString : "MSIE",
					identity : "Explorer",
					versionSearch : "MSIE"
				}, {
					string : navigator.userAgent,
					subString : "Gecko",
					identity : "Mozilla",
					versionSearch : "rv"
				}, { // for older Netscapes (4-)
					string : navigator.userAgent,
					subString : "Mozilla",
					identity : "Netscape",
					versionSearch : "Mozilla"
				} ],
		dataOS : [ {
			string : navigator.platform,
			subString : "Win",
			identity : "Windows"
		}, {
			string : navigator.platform,
			subString : "Mac",
			identity : "Mac"
		}, {
			string : navigator.userAgent,
			subString : "iPhone",
			identity : "iPhone/iPod"
		}, {
			string : navigator.platform,
			subString : "Linux",
			identity : "Linux"
		} ]

	};
})($jsmart||jQuery);
function css(el, prop) {
	return parseInt($jsmart.css(el, prop)) || 0;
};
function width(el) {
	return el.offsetWidth + css(el, 'marginLeft') + css(el, 'marginRight');
};
function height(el) {

	return el.offsetHeight + css(el, 'marginTop') + css(el, 'marginBottom');
};
