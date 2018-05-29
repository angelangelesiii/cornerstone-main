// ==================================
//    MAIN SCRIPT
// ==================================

(function($) {})( jQuery ); // JQuery WordPress workaround

jQuery(document).ready(function($){ // Document Ready

    function mediumSizeScript() {
        if($(window).width() < 1024) {
            $('#belt-menu-trigger').addClass('medium-screen');
        } else {
            $('#belt-menu-trigger').removeClass('medium-screen');
        }
    }
    mediumSizeScript();

    $(window).resize(function() { // Window resize
       mediumSizeScript();
    });

    // Scrollbars
    // $('.custom-scrollbar').scrollbar({
    //     // options
    //     autoUpdate: true,
    //     autoScrollSize: true,
    // });

    // Main menu button interaction

    function toggleMenu() {
        $('body').toggleClass('menu-opened')
        $('#mainheader').toggleClass('opened')
        $('#mainmenubutton').toggleClass('opened');
        $('#mainmenupanel').toggleClass('opened');
        $('#menu-overlay').toggleClass('opened');
        $('#belt-menu-nav').toggleClass('menu-opened');
        $('#belt-menu-alt-nav').toggleClass('menu-opened');
    }

    var menuItem = $('ul#header-menu>li')
    var menuStaggerAnimation = new TimelineMax()
        .staggerFrom(menuItem, 0.5, {
            opacity: 0,
            x: 100,
            ease: Back.easeOut
        }, 0.1);

    $('#mainmenubutton').click(function(e) {
        toggleMenu();
        if ($('#mainmenupanel').hasClass('opened')) {
            console.log('menu is opened so I will play animation');
            menuStaggerAnimation.play(0);
        }
    });

    // $('#mainmenupanel').click(function(e) {
    //     toggleMenu();
    // });
    

    // Parallax effect
    var mainController = new ScrollMagic.Controller(),
        beltColor = $('#belt-menu-nav').css('background-color');

    // console.log(beltColor);

    var dimInitial = $('.hero-banner.full-section').data('dim');
    // console.log(dimInitial);
    var heroEffect = new TimelineMax()
        .to('.parallaxBG', 1, {
            y: '40%',
        }, 'a')
        // .fromTo('.hero-banner.full-section .overlay', 1, {
        //     opacity: dimInitial,
        // }, {
        //     opacity: 1,
        // }, 'a')
        // .to('.hero-banner .hero-container', 1, {
        //     opacity: 0.1,
        //     scale: 0.7,
        //     y:'20%',
        // }, 'a')
        .fromTo('#belt-menu-nav', 1, {
            css: {background: beltColor},
        },{
            css: {background: 'rgba(0, 0, 0, 1)'},
        }, 'a')
        .to('#belt-menu li.menu-item a', 1, {
            opacity: 1
        }, 'a');

    var frontPageParallax = new ScrollMagic.Scene({
        triggerElement: '.hero-banner',
        triggerHook: 0,
        duration: '130%'
    })
    .setTween(heroEffect)
    // .addIndicators()
    .addTo(mainController);

    // Belt menu pinning
    var beltMenuHeight = $('#belt-menu-nav').outerHeight();
    // console.log(beltMenuHeight);
    $('#belt-menu-trigger').outerHeight(beltMenuHeight);
    $('#mainheader .navbar-bg').outerHeight(beltMenuHeight);

    var beltMenuPin = new ScrollMagic.Scene({
        triggerElement: "#belt-menu-trigger",
        triggerHook: 0,
    })
    .on('enter', function() {
        $('#belt-menu-nav').addClass('latch');
	})
	.on('leave', function() {
        $('#belt-menu-nav').removeClass('latch');
    })
    // .addIndicators()
    .addTo(mainController);

    // Navbar scrolling toggle
    var navbarToggle = new ScrollMagic.Scene({
        triggerElement: '#top',
        triggerHook: 0,
        offset: 100
    })
    .on('enter', function() { // if viewport moved by 50px, remove 'top-position' class
        $('#mainheader').toggleClass('top-position');
        $('#mainheader').toggleClass('not-top-position');
	})
	.on('leave', function() {// if viewport is < 50px from top, add 'top-position' class
        $('#mainheader').toggleClass('top-position');
        $('#mainheader').toggleClass('not-top-position');
    })
    // .addIndicators()
    .addTo(mainController);
    
    var navbarBGfade = new ScrollMagic.Scene({
        triggerElement: '#top',
        duration: 200,
        triggerHook: 0,
    })
    .setTween(TweenMax.to('#mainheader .navbar-bg', 1, {
        opacity: 1
    }))
    // .addIndicators()
    .addTo(mainController);

    // MASONRY
    var $indexGrid = $('.grid-container').imagesLoaded(function(){
        $indexGrid.masonry({
            itemSelector: '.grid-item',
            columnWidth: '.grid-sizer',
            percentPosition: true,
            transitionDuration: '0.2s',
        });
    });
    
    jQuery(function ($) {
        $.fn.hScroll = function (amount) {
            amount = amount || 120;
            $(this).bind("DOMMouseScroll mousewheel", function (event) {
                var oEvent = event.originalEvent, 
                    direction = oEvent.detail ? oEvent.detail * -amount : oEvent.wheelDelta, 
                    position = $(this).scrollLeft();
                position += direction > 0 ? -amount : amount;
                $(this).scrollLeft(position);
                event.preventDefault();
            })
        };
    });

    $(document).ready(function(){
        $('.header-menu-container').hScroll(40); // You can pass (optionally) scrolling amount
    });

});