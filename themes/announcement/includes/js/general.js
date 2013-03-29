/*-----------------------------------------------------------------------------------

FILE INFORMATION

Description: JavaScript on the "Announcement" WooTheme.
Date Created: 2011-07-07.
Author: Mike and Matty.
Since: 1.0.0


TABLE OF CONTENTS

- BabyStats JavaScript
- Comment form JavaScript.
- Initialize Video Embed Component.
- Initialize jQuery.Masonry.
- Initialize localScroll.
- Initialize PrettyPhoto.
- Remove empty paragraph tags.
- Countdown Setup (jQuery.countdown)
- Photograph Slider Setup (jCarousel)
- Add alt-row styling to tables

- function woo_initCallback()
- function woo_itemVisibleInCallbackBeforeAnimation()
- function woo_itemVisibleInCallbackAfterAnimation()
- function woo_itemVisibleOutCallbackBeforeAnimation()
- function woo_itemVisibleOutCallbackAfterAnimation()

- Superfish navigation dropdown

-----------------------------------------------------------------------------------*/

jQuery(function($) {

/*-----------------------------------------------------------------------------------*/
/* BabyStats JavaScript. */
/*-----------------------------------------------------------------------------------*/

			jQuery('.stat-content').textfill({ maxFontPixels: 180 });

			jQuery('#dyntext').keyup(function() {
				jQuery('.dyntextval').html(this.value);
				jQuery('.stat-content').textfill({ maxFontPixels: 180 });
			});

/*-----------------------------------------------------------------------------------*/
/* Comment form JavaScript. */
/*-----------------------------------------------------------------------------------*/

	if ( jQuery( '#respond .comment-form-author' ).length ) {
		jQuery( '#respond .comment-form-author input, #respond .comment-form-email input, #respond .comment-form-url input' ).focus( function ( e ) {
			if ( jQuery( this ).val() == jQuery( this ).next( 'label' ).text() ) {
				jQuery( this ).attr( 'value', '' );
			}
		});
		
		jQuery( '#respond .comment-form-author input, #respond .comment-form-email input, #respond .comment-form-url input' ).blur( function ( e ) {
			if ( jQuery( this ).val() == '' ) {
				jQuery( this ).attr( 'value', jQuery( this ).next( 'label' ).text() );
			}
		});
		
		jQuery( '#respond form' ).submit( function ( e ) {
			var websiteField = jQuery( this ).find( '.comment-form-url input' );
			
			if ( websiteField.val() == websiteField.next( 'label' ).text() ) {
				websiteField.attr( 'value', '' );
			}
		});
	}

/*-----------------------------------------------------------------------------------*/
/* Initialize Video Embed Component. */
/*-----------------------------------------------------------------------------------*/

	if ( jQuery( '.component.embed ul.widget-video-list' ).length ) {

	var list = jQuery( '.component.embed ul.widget-video-list' );
	
		list.find( 'a' ).click( function() {
			
			var clickedTitle = jQuery( this ).text();
			jQuery( list ).find( '.active' ).removeClass( 'active' );
			jQuery( this ).parent().addClass( 'active' );
			
			var videoHolders = jQuery( list ).parent().find( '.widget-video-unit' );
			
			videoHolders.each( function() {
				if(clickedTitle == jQuery( this ).children( 'h4' ).text() ) {
					videoHolders.hide();
					jQuery( this ).show();
				}
			});
			
			return false;
		});
		
	}

/*-----------------------------------------------------------------------------------*/
/* Initialize jQuery.Masonry. */
/*-----------------------------------------------------------------------------------*/

	if ( jQuery( '#comments .commentlist' ).length ) {
		jQuery( '#comments .commentlist' ).masonry({
			itemSelector: '.comment.depth-1'
		});
		
		jQuery( '.comment-reply-link, #cancel-comment-reply-link' ).click( function () {
			jQuery( '#comments .commentlist' ).masonry( 'reload' );
		});
	}

/*-----------------------------------------------------------------------------------*/
/* Initialize localScroll. */
/*-----------------------------------------------------------------------------------*/

	jQuery.localScroll();

/*-----------------------------------------------------------------------------------*/
/* Initialize PrettyPhoto. */
/*-----------------------------------------------------------------------------------*/

	jQuery( 'a[rel^="prettyPhoto"]' ).prettyPhoto({ social_tools: '', gallery_markup: '' });

/*-----------------------------------------------------------------------------------*/
/* Remove empty paragraph tags. */
/*-----------------------------------------------------------------------------------*/

	var emptyParagraphs = jQuery( 'p:empty' );
	
	if ( emptyParagraphs.length ) {
		emptyParagraphs.remove();
	}

	if ( jQuery( '.countdown' ) ) {
	
/*-----------------------------------------------------------------------------------*/
/* Countdown Setup (jQuery.countdown) */
/*-----------------------------------------------------------------------------------*/

		var countdownObj = jQuery( '.countdown-timer' );
	
		var countdownYear = parseInt( countdownObj.find( '.year' ).text() );
		var countdownMonth = countdownObj.find( '.month' ).text();
		var countdownDay = countdownObj.find( '.day' ).text();
		var countdownHour = countdownObj.find( '.hour' ).text();
		var countdownMinute = countdownObj.find( '.minute' ).text();
	
		if ( parseInt( countdownMonth ) < 10 ) { countdownMonth = parseInt( countdownMonth.replace( '0', '' ) ) - 1; } else { countdownMonth--; }
		if ( parseInt( countdownDay ) < 10 ) { countdownDay = parseInt( countdownDay.replace( '0', '' ) ); }
	
		jQuery( '.countdown-timer' ).countdown( { until: new Date( countdownYear, countdownMonth, countdownDay, countdownHour, countdownMinute ), format: 'dHMS'} );
	}

	if ( jQuery( '.photograph-slider' ).length ) {

/*-----------------------------------------------------------------------------------*/
/* Featured Slider Setup (jCarousel) */
/*-----------------------------------------------------------------------------------*/
	
		/* Work out variables for use in the slider. */
		var startSlide = 1;
		var visibleSlides = 1;
		
		startSlide = Math.floor( ( jQuery( '.photograph-slider ul li' ).length ) / 2 );
	
		/* Setup dynamic variables. */
		var autoStart = woo_jcarousel_settings.autoStart;
		var autoInterval = parseInt( woo_jcarousel_settings.interval );
		var speed = parseInt( woo_jcarousel_settings.speed );
		var visible = parseInt( woo_jcarousel_settings.visible );
		var scroll = parseInt( woo_jcarousel_settings.scroll );
		var scrolling = woo_jcarousel_settings.scrolling;
	
		if ( autoStart != 'true' ) { autoInterval = 0; } // Set the autoInterval to 0 if autoStart is disabled.
		if ( scrolling != 'circular' && scrolling != 'both' ) { scrolling = 'circular'; } // Sanity check.
	
		jQuery( '.photograph-slider ul' ).jcarousel({
			auto: autoInterval, 
			visible: visible, 
			buttonNextHTML: '<a href="#" class="next">Next</a>', 
			buttonPrevHTML: '<a href="#" class="previous">Previous</a>', 
			scroll: scroll, 
			animation: speed, 
			wrap: scrolling, 
			start: startSlide, 
			initCallback: woo_initCallback, 
			itemVisibleInCallback: {
	            onBeforeAnimation: woo_itemVisibleInCallbackBeforeAnimation,
	            onAfterAnimation:  woo_itemVisibleInCallbackAfterAnimation
	        },
	        itemVisibleOutCallback: {
	            onBeforeAnimation: woo_itemVisibleOutCallbackBeforeAnimation,
	            onAfterAnimation:  woo_itemVisibleOutCallbackAfterAnimation
	        }
		});
		
		// Make sure the original click event doesn't fire on our slider navigation.
		jQuery( '.photograph-slider a.next, .photograph-slider a.previous' ).click( function ( e ) {
			return false;
		});
	
	}

/*-----------------------------------------------------------------------------------*/
/* Add alt-row styling to tables */
/*-----------------------------------------------------------------------------------*/

	jQuery( '.entry table tr:odd').addClass( 'alt-table-row' );

}); // End jQuery()


/*-----------------------------------------------------------------------------------*/
/* - function woo_initCallback() */
/*-----------------------------------------------------------------------------------*/

function woo_initCallback(carousel, state) {
    if (state == 'init') {}
};

/*-----------------------------------------------------------------------------------*/
/* - function woo_itemVisibleInCallbackBeforeAnimation() */
/*-----------------------------------------------------------------------------------*/

function woo_itemVisibleInCallbackBeforeAnimation( carousel, item, idx, state ) {
    // No animation on first load of the carousel
    if (state == 'init') {
    	jQuery( '.photograph-slider' ).fadeTo( 'slow', 1 );
    }
};

/*-----------------------------------------------------------------------------------*/
/* - function woo_itemVisibleInCallbackAfterAnimation() */
/*-----------------------------------------------------------------------------------*/

function woo_itemVisibleInCallbackAfterAnimation( carousel, item, idx, state ) {
	jQuery( item ).fadeTo( 'slow', 1, function () {
		jQuery( item ).toggleClass( 'active' );
		jQuery( item ).toggleClass( 'inactive' );
	});
};

/*-----------------------------------------------------------------------------------*/
/* - function woo_itemVisibleOutCallbackBeforeAnimation() */
/*-----------------------------------------------------------------------------------*/

function woo_itemVisibleOutCallbackBeforeAnimation( carousel, item, idx, state ) {
	jQuery( item ).fadeTo( 'slow', 0.2, function () {
		jQuery( item ).toggleClass( 'inactive' );
	});
};

/*-----------------------------------------------------------------------------------*/
/* - function woo_itemVisibleOutCallbackAfterAnimation() */
/*-----------------------------------------------------------------------------------*/

function woo_itemVisibleOutCallbackAfterAnimation( carousel, item, idx, state ) {};

/*-----------------------------------------------------------------------------------*/
/* Superfish navigation dropdown */
/*-----------------------------------------------------------------------------------*/

;(function($){$.fn.superfish=function(op){var sf=$.fn.superfish,c=sf.c,$arrow=$(['<span class="',c.arrowClass,'"> &#187;</span>'].join( '')),over=function(){var $$=$(this),menu=getMenu($$);clearTimeout(menu.sfTimer);$$.showSuperfishUl().siblings().hideSuperfishUl()},out=function(){var $$=$(this),menu=getMenu($$),o=sf.op;clearTimeout(menu.sfTimer);menu.sfTimer=setTimeout(function(){o.retainPath=($.inArray($$[0],o.$path)>-1);$$.hideSuperfishUl();if(o.$path.length&&$$.parents(['li.',o.hoverClass].join( '')).length<1){over.call(o.$path)}},o.delay)},getMenu=function($menu){var menu=$menu.parents(['ul.',c.menuClass,':first'].join( ''))[0];sf.op=sf.o[menu.serial];return menu},addArrow=function($a){$a.addClass(c.anchorClass).append($arrow.clone())};return this.each(function(){var s=this.serial=sf.o.length;var o=$.extend({},sf.defaults,op);o.$path=$( 'li.'+o.pathClass,this).slice(0,o.pathLevels).each(function(){$(this).addClass([o.hoverClass,c.bcClass].join( ' ')).filter( 'li:has(ul)').removeClass(o.pathClass)});sf.o[s]=sf.op=o;$( 'li:has(ul)',this)[($.fn.hoverIntent&&!o.disableHI)?'hoverIntent':'hover'](over,out).each(function(){if(o.autoArrows)addArrow($( '>a:first-child',this))}).not( '.'+c.bcClass).hideSuperfishUl();var $a=$( 'a',this);$a.each(function(i){var $li=$a.eq(i).parents( 'li' );$a.eq(i).focus(function(){over.call($li)}).blur(function(){out.call($li)})});o.onInit.call(this)}).each(function(){var menuClasses=[c.menuClass];if(sf.op.dropShadows&&!($.browser.msie&&$.browser.version<7))menuClasses.push(c.shadowClass);$(this).addClass(menuClasses.join( ' '))})};var sf=$.fn.superfish;sf.o=[];sf.op={};sf.IE7fix=function(){var o=sf.op;if($.browser.msie&&$.browser.version>6&&o.dropShadows&&o.animation.opacity!=undefined)this.toggleClass(sf.c.shadowClass+'-off')};sf.c={bcClass:'sf-breadcrumb',menuClass:'sf-js-enabled',anchorClass:'sf-with-ul',arrowClass:'sf-sub-indicator',shadowClass:'sf-shadow'};sf.defaults={hoverClass:'sfHover',pathClass:'overideThisToUse',pathLevels:1,delay:800,animation:{opacity:'show'},speed:'normal',autoArrows:true,dropShadows:true,disableHI:false,onInit:function(){},onBeforeShow:function(){},onShow:function(){},onHide:function(){}};$.fn.extend({hideSuperfishUl:function(){var o=sf.op,not=(o.retainPath===true)?o.$path:'';o.retainPath=false;var $ul=$(['li.',o.hoverClass].join( ''),this).add(this).not(not).removeClass(o.hoverClass).find( '>ul').hide().css( 'visibility','hidden' );o.onHide.call($ul);return this},showSuperfishUl:function(){var o=sf.op,sh=sf.c.shadowClass+'-off',$ul=this.addClass(o.hoverClass).find( '>ul:hidden').css( 'visibility','visible' );sf.IE7fix.call($ul);o.onBeforeShow.call($ul);$ul.animate(o.animation,o.speed,function(){sf.IE7fix.call($ul);o.onShow.call($ul)});return this}})})(jQuery);

if(jQuery().superfish) {
	jQuery(document).ready(function() {
		jQuery( 'ul.nav').superfish({
			delay: 200,
			animation: {opacity:'show', height:'show'},
			speed: 'fast',
			dropShadows: false
		});
	});
}

