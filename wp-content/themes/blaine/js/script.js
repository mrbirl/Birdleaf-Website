(function($) {
	"use strict";

	$(document).ready(function() {

		if ( window.thb_slideshow && $( '.thb-slideshow' ).length ) {
			var rsOptions = {
				loop: true,
				slidesSpacing: 0,
				navigateByClick: false,
				addActiveClass: true,
				imageScaleMode: "fill",
				numImagesToPreload: 1,
				keyboardNavEnabled: true
			};

			// Autoplay
			if ( window.thb_slideshow.autoplay && window.thb_slideshow.autoplay == "1" ) {
				rsOptions.autoPlay = {
					enabled: true,
					delay: window.thb_slideshow.speed
				};
			}

			// Effect
			rsOptions.transitionType = window.thb_slideshow.effect;

			if ( window.thb_slideshow.num_slides == 1 ) {
				rsOptions.transitionType = "fade";
			}

			var thb_slideshow_container = $( '.thb-slideshow' ),
				is_mobile = $("body").hasClass("thb-mobile");

			if ( thb_slideshow_container.hasClass( 'page-content-slideshow' ) ) {
				rsOptions.autoScaleSlider = true;
				rsOptions.autoScaleSliderWidth = 930;
				rsOptions.autoScaleSliderHeight = 523;
			}

			window.thb_setup_slide = function( slide, pause_other ) {
				if ( thb_slideshow_container.hasClass( 'header-slideshow' ) ) {
					/**
					 * Skin
					 */
					$( "body" ).removeClass( "thb-skin-light thb-skin-dark thb-skin-" );

					if ( slide.hasClass( "thb-skin-light" ) ) {
						$("body").addClass( "thb-skin-light" );
					}

					if ( slide.hasClass( "thb-skin-dark" ) ) {
						$("body").addClass( "thb-skin-dark" );
					}
				}

				if ( thb_slideshow_container.hasClass('rsFade') ) {
					$(window).trigger('resize');
				}
			};

			window.thb_slideshow_start = function( el, opts ) {

				el.royalSlider( opts );

				el.data('royalSlider').ev.on('rsBeforeAnimStart rsAfterContentSet', function(event) {
					var slide = $( event.target.currSlide.holder ).find(".slide");

					thb_setup_slide( slide, true );
				});

				el.data('royalSlider').ev.on("rsBeforeAnimStart",function( event ) {
					el.data('royalSlider').stopVideo();

					thb_slideshow_container.find("video").each(function() {
						this.stop();
					});

					var slide = $( event.target.currSlide.holder ).find(".slide");

					if ( slide.find("video").length ) {
						if ( slide.data( "fill" ) === "1" ) {
							thb_video_holders( slide );
						}
						else {
							thb_video_holders_off( slide );
						}
					}
				});

				el.data('royalSlider').ev.on('rsVideoPlay', function() {
					var embed = el.data("royalSlider").videoObj[0],
						slide = $(embed).parents(".slide");

					if ( slide.data("loop") == '1' ) {
						embed.src += '&loop=1&playlist=' + slide.data("code");
					}

					if ( ! is_mobile ) {
						el.data("royalSlider").ev.off('rsBeforeSizeSet');

						if ( slide.attr( "data-fill" ) == "1" ) {
							thb_video_holders( slide, '.rsVideoFrameHolder' );
						}
					}
				});

				el.data('royalSlider').ev.on('rsAfterSlideChange', function( event ) {
					if ( is_mobile ) {
						return;
					}

					thb_slideshow_container.removeClass( "rsVideoPlaying" );

					var slide = $(event.target.currSlide.holder).find(".slide"),
						thb_video_controls = slide.find('.thb-video-controls'),
						thb_video_play = thb_video_controls.find('.thb-video-play'),
						thb_video_stop = thb_video_controls.find('.thb-video-stop');

					thb_video_play.on('click', function() {
						if ( slide.find('video').length ) {
							slide.find('video').get(0).play();
							thb_slideshow_container.addClass( "rsVideoPlaying" );
						}
						else {
							el.data('royalSlider').playVideo();
						}

						return false;
					});

					thb_video_stop.on('click', function() {
						if ( slide.find('video').length ) {
							slide.find('video').get(0).pause();
							thb_slideshow_container.removeClass( "rsVideoPlaying" );
						}
						else {
							el.data('royalSlider').stopVideo();
						}

						return false;
					});

					if ( slide.data("autoplay") == '1' ) {
						if ( slide.find("video").length ) {
							el.data('royalSlider').stopAutoPlay();
							slide.find("video").get(0).play();
							thb_slideshow_container.addClass( "rsVideoPlaying" );
						}
						else {
							el.data('royalSlider').playVideo();
						}
					}
				});

				el.data('royalSlider').ev.on('rsAfterContentSet', function( event ) {
					if ( is_mobile ) {
						return;
					}

					var slide = $(event.target.currSlide.holder).find(".slide"),
						thb_video_controls = slide.find('.thb-video-controls'),
						thb_video_play = thb_video_controls.find('.thb-video-play'),
						thb_video_stop = thb_video_controls.find('.thb-video-stop');

					if ( slide.find("video").length ) {
						if ( slide.data( "fill" ) === "1" ) {
							thb_video_holders( slide );
						}
						else {
							thb_video_holders_off( slide );
						}
					}

					if ( event.target.currSlide.id === 0 && ! thb_slideshow_container.hasClass('rsVideoPlaying') ) {

						thb_video_play.on('click', function() {
							if ( slide.find('video').length ) {
								slide.find('video').get(0).play();
								thb_slideshow_container.addClass( "rsVideoPlaying" );
							}
							else {
								el.data('royalSlider').playVideo();
							}

							return false;
						});

						thb_video_stop.on('click', function() {
							if ( slide.find('video').length ) {
								slide.find('video').get(0).pause();
								thb_slideshow_container.removeClass( "rsVideoPlaying" );
							}
							else {
								el.data('royalSlider').stopVideo();
							}

							return false;
						});

						if ( slide.data("autoplay") == '1' ) {
							if ( slide.find("video").length ) {
								el.data('royalSlider').stopAutoPlay();
								slide.find("video").get(0).play();
								thb_slideshow_container.addClass( "rsVideoPlaying" );
							}
							else {
								el.data('royalSlider').playVideo();
							}
						}
					}
				});
			};

			thb_slideshow_start(thb_slideshow_container, rsOptions);
		}

		$("#main-nav > div").menu();

		$(".thb-gallery").royalSlider({
			loopRewind: true,
			slidesSpacing: 0,
			navigateByClick: false,
			imageScaleMode: "fill",
			autoScaleSlider: true,
			autoScaleSliderWidth: 930,
			autoScaleSliderHeight: 523,
		});

		$(".thb-text, .textwidget, .work-slides-container, .format-embed-wrapper").fitVids();

		// Fix the content height if there isn't enough content

		if( !$('body').hasClass('thb-mobile') ) {

			if ( $('#page-content').length > 0 ) {
				var body_height = $('body').height(),
					window_height = $(window).height() - $('body').offset().top,
					page_content_height = $('#page-content').outerHeight(),
					body_window_diff = window_height - body_height;

				if ( body_height < window_height ) {
					$('#page-content').css('min-height', page_content_height + body_window_diff);
				} else {
					$('#page-content').css('min-height', $(window).height() - $('#page-content').offset().top - $('#footer').outerHeight() - $('#footer-sidebar').outerHeight() );
				}

			}

		}

		// Add a fake page preload

		if( !$('body').hasClass('thb-mobile') ) {
			NProgress.configure().start();

			setTimeout( function() {
				NProgress.done();
				setTimeout( function() {
					$("body").addClass("thb-page-loaded");
				}, 250 );
			}, 250 );
		} else {
			$("body").addClass("thb-page-loaded");
		}

		// Fixed header position

		if( ! $('body').hasClass('thb-mobile') && $('body').hasClass('header-fixed') && $('body').hasClass('thb-pageheader-layout-a') ) {
			var $page_content = $('#page-content'),
				header_height = $('#header').outerHeight();

			$page_content.css('margin-top', header_height + 72);
		}

		if( ! $('body').hasClass('thb-mobile') && $('body').hasClass('header-fixed') ) {
			var $page_header = $('#header'),
				page_header_height = $page_header.outerHeight();

			$(window).scroll(function(){
				if ($(this).scrollTop() > page_header_height ) {
					$page_header.addClass('scrolled');
				} else {
					$page_header.removeClass('scrolled');
				}
			});

			$(window).trigger('scroll');
		}

		// Go top

		if( !$('body').hasClass('thb-mobile') ) {
			$(window).scroll(function(){
				if ($(this).scrollTop() > 300) {
					$('.thb-scrollup').fadeIn('fast');
				} else {
					$('.thb-scrollup').fadeOut('fast');
				}
			});

			$('.thb-scrollup').click(function(){
				$("html, body").stop().animate({ scrollTop: 0 }, 350, 'easeInOutCubic' );
				return false;
			});
		}

		/**
		 * Portfolio.
		 */
		if( $("body.page-template-template-portfolio-php").length && typeof thb_portfolio != 'undefined' ) {
			if( !$("body.thb-password-protected").length ) { // Check if page is not password protected

				var useAjax = thb_portfolio.use_ajax === "1",
					isotopeContainer = $(".thb-grid-layout"),
					thb_portfolio_filtering = false;

				if( ! useAjax ) {
					$("#filterlist li").each(function() {
						var data = $(this).data("filter");

						if( data !== "" ) {
							if( ! isotopeContainer.find("[data-filter-" + data + "]").length ) {
								$(this).remove();
							}
						}
					});
				}

				var filter_wrapper = "#thb-portfolio-filter",
					filter_controls = "#filterlist";

				if ( filter_wrapper ) {
					filter_wrapper = $( filter_wrapper );

					filter_wrapper.find( "> h3 .thb-filter-by" ).on( "click", function() {
						filter_wrapper.toggleClass( "open" );

						return false;
					} );

					$( filter_controls ).children().on( "click", function() {
						var item = $(this);

						setTimeout(function() {
							filter_wrapper.find( "> h3 span.thb-filter-active" ).html( item.text().trim() );
						}, 200);

						return false;
					} );
				}

				var portfolio_isotope = new THB_Isotope( isotopeContainer, {
					filter: new THB_Filter(isotopeContainer, {
						controls: filter_controls,
						controlsOnClass: "active",
						filter: function( selector ) {
							filter_wrapper.removeClass( "open" );

							if ( ! useAjax ) {
								portfolio_isotope.filter(selector);
							}
						}
					})
				});

				window.thb_portfolio_reload = function( url, callback ) {
					portfolio_isotope.remove(function() {
						$.thb.pageChange(url, {
							filter: false,
							complete: function( data ) {
								NProgress.done();
								var items = $(data).find(".thb-grid-layout .item");

								if( $(".thb-navigation").length ) {
									if ( $(data).find(".thb-navigation").length ) {
										$(".thb-navigation").replaceWith( $(data).find(".thb-navigation") );
									} else {
										$(".thb-navigation").html('');
									}
								}
								else {
									isotopeContainer.after( $(data).find(".thb-navigation") );
								}

								portfolio_isotope.insert(items, function() {
									thb_portfolio_bind_pagination();

									if( callback !== undefined ) {
										callback();
									}
								});
							}
						});
					});
				};

				window.thb_portfolio_bind_pagination = function() {
					$(".thb-navigation a").on("click", function() {
						NProgress.configure().start();
						thb_portfolio_reload( $(this).attr("href") );
						return false;
					});
				};

				window.thb_portfolio_bind_filter = function() {
					$("#filterlist li").on("click", function() {
						if( thb_portfolio_filtering ) {
							return false;
						}

						thb_portfolio_filtering = true;

						thb_portfolio_reload( $(this).data("href"), function() {
							thb_portfolio_filtering = false;
						} );

						NProgress.configure().start();

						$("#filterlist li").removeClass("active");
						$(this).addClass("active");
						return false;
					});
				};

				if( useAjax ) {
					thb_portfolio_bind_filter();
					thb_portfolio_bind_pagination();
				}

			} // /.thb-password-protected
		}

		// Mobile menu toggle

		var thb_mobile_menu = new THB_Toggle({
			target: $("#thb-external-wrapper"),
			on: function() {
				$("body").addClass( 'menu-open' );
				$("#mobile-menu-container").css("visibility", "visible");
			},
			off: function() {
				$("body").removeClass( 'menu-open' );
			},
			offTransitionEnd: function() {
				$("#mobile-menu-container").css("visibility", "hidden");
			}
		});

		$.thb.key("esc", thb_mobile_menu.off);
		$('.mobile-menu-trigger').on('click', thb_mobile_menu.toggle);

	});

	if( $('body').hasClass('thb-mobile') ) {
		FastClick.attach(document.body);
	}

})(jQuery);

/* Modernizr 2.7.1 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-csstransforms-csstransforms3d-csstransitions-shiv-cssclasses-teststyles-testprop-testallprops-prefixes-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function z(a){j.cssText=a}function A(a,b){return z(m.join(a+";")+(b||""))}function B(a,b){return typeof a===b}function C(a,b){return!!~(""+a).indexOf(b)}function D(a,b){for(var d in a){var e=a[d];if(!C(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function E(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:B(f,"function")?f.bind(d||b):f}return!1}function F(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+o.join(d+" ")+d).split(" ");return B(b,"string")||B(b,"undefined")?D(e,b):(e=(a+" "+p.join(d+" ")+d).split(" "),E(e,b,c))}var d="2.7.1",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m=" -webkit- -moz- -o- -ms- ".split(" "),n="Webkit Moz O ms",o=n.split(" "),p=n.toLowerCase().split(" "),q={},r={},s={},t=[],u=t.slice,v,w=function(a,c,d,e){var f,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),l.appendChild(j);return f=["&#173;",'<style id="s',h,'">',a,"</style>"].join(""),l.id=h,(m?l:n).innerHTML+=f,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=g.style.overflow,g.style.overflow="hidden",g.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),g.style.overflow=k),!!i},x={}.hasOwnProperty,y;!B(x,"undefined")&&!B(x.call,"undefined")?y=function(a,b){return x.call(a,b)}:y=function(a,b){return b in a&&B(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=u.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(u.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(u.call(arguments)))};return e}),q.csstransforms=function(){return!!F("transform")},q.csstransforms3d=function(){var a=!!F("perspective");return a&&"webkitPerspective"in g.style&&w("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}",function(b,c){a=b.offsetLeft===9&&b.offsetHeight===3}),a},q.csstransitions=function(){return F("transition")};for(var G in q)y(q,G)&&(v=G.toLowerCase(),e[v]=q[G](),t.push((e[v]?"":"no-")+v));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)y(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},z(""),i=k=null,function(a,b){function l(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function m(){var a=s.elements;return typeof a=="string"?a.split(" "):a}function n(a){var b=j[a[h]];return b||(b={},i++,a[h]=i,j[i]=b),b}function o(a,c,d){c||(c=b);if(k)return c.createElement(a);d||(d=n(c));var g;return d.cache[a]?g=d.cache[a].cloneNode():f.test(a)?g=(d.cache[a]=d.createElem(a)).cloneNode():g=d.createElem(a),g.canHaveChildren&&!e.test(a)&&!g.tagUrn?d.frag.appendChild(g):g}function p(a,c){a||(a=b);if(k)return a.createDocumentFragment();c=c||n(a);var d=c.frag.cloneNode(),e=0,f=m(),g=f.length;for(;e<g;e++)d.createElement(f[e]);return d}function q(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return s.shivMethods?o(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+m().join().replace(/[\w\-]+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(s,b.frag)}function r(a){a||(a=b);var c=n(a);return s.shivCSS&&!g&&!c.hasCSS&&(c.hasCSS=!!l(a,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),k||q(a,c),a}var c="3.7.0",d=a.html5||{},e=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,f=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,g,h="_html5shiv",i=0,j={},k;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",g="hidden"in a,k=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){g=!0,k=!0}})();var s={elements:d.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",version:c,shivCSS:d.shivCSS!==!1,supportsUnknownElements:k,shivMethods:d.shivMethods!==!1,type:"default",shivDocument:r,createElement:o,createDocumentFragment:p};a.html5=s,r(b)}(this,b),e._version=d,e._prefixes=m,e._domPrefixes=p,e._cssomPrefixes=o,e.testProp=function(a){return D([a])},e.testAllProps=F,e.testStyles=w,g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+t.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};