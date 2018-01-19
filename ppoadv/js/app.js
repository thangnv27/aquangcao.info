this.imagePreview = function () {
    xOffset = 10;
    yOffset = 30;
    $("a.preview").hover(function (e) {
        this.t = this.title;
        this.title = "";
        var c = (this.t != "") ? "<br/>" + this.t : "";
        $("body").append("<p id='preview'><img src='" + this.rel + "' alt='Image preview' />" + c + "</p>");
        $("#preview").css("top", (e.pageY - xOffset) + "px").css("left", (e.pageX + yOffset) + "px").fadeIn("fast");
    }, function () {
        this.title = this.t;
        $("#preview").remove();
    });
    $("a.preview").mousemove(function (e) {
        $("#preview").css("top", (e.pageY - xOffset) + "px").css("left", (e.pageX + yOffset) + "px");
    });
};
var PPOFixed = {
    mainMenu: function () {
        jQuery('.fixedHeader').scrollToFixed({
            marginTop: jQuery('#wpadminbar').outerHeight(true),
            limit: jQuery('.footer').offset().top
        });
    },
    columns: function (col) {
        var summaries = jQuery(col);
        summaries.each(function (i) {
            var summary = jQuery(summaries[i]);
            var next = summaries[i + 1];

            summary.scrollToFixed({
                marginTop: jQuery('#wpadminbar').outerHeight(true) + jQuery(".rHeader").outerHeight(true),
                limit: function () {
                    var limit = 0;
                    if (next) {
                        limit = jQuery(next).offset().top - jQuery(this).outerHeight(true) - 10;
                    } else {
                        limit = jQuery('.footer').offset().top - jQuery(this).outerHeight(true) - 10;
                    }
                    return limit;
                },
                zIndex: 99999
            });
        });
    }
};
jQuery(document).ready(function () {
    imagePreview();
    
    if (is_fixed_menu) {
        PPOFixed.mainMenu();
    }
});

(function ($) {
    $(".project").owlCarousel({
//        items: 5,
//        itemsCustom: [
//            [280, 2],
//            [380, 2],
//            [480, 2],
//            [768, 3],
//            [1000, 5],
//        ],
//        responsive:true,
//        loop:true,
//        autoplay:true,
//        autoplayTimeout:1000,
//        autoplayHoverPause:true
        autoPlay: 3000,
        items : 5,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3]
    });
    
    $(".partner").owlCarousel({
        items: 5,
        itemsCustom: [
            [280, 2],
            [380, 2],
            [480, 2],
            [768, 3],
            [1000, 5],
        ],
        itemsScaleUp: true,
        navigation: true,
        navigationText: ["", ""],
        pagination: false,
        merge: false,
        mergeFit: true,
        slideBy: 1,
        autoplay: true
    });
    
    // Menu mobile
    jQuery('button.left-menu').click(function (){
        var effect = jQuery(this).attr('data-effect');
        if(jQuery(this).parent().parent().hasClass('mobile-clicked')){
            jQuery('.st-menu').animate({
                width: 0
            }).css({
                display: 'none',
                transform: 'translate(0px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
            jQuery(this).parent().parent().addClass('mobile-unclicked').removeClass('mobile-clicked').css({
                transform: 'translate(0px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
            jQuery(this).parent().parent().parent().removeClass('st-menu-open ' + effect);
//            jQuery("#overlay").hide();
        } else {
            jQuery(this).parent().parent().parent().addClass('st-menu-open ' + effect);
            jQuery('.st-menu').animate({
                width: 270
            }).css({
                display: 'block',
                transform: 'translate(270px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
            jQuery(this).parent().parent().addClass('mobile-clicked').removeClass('mobile-unclicked').css({
                transform: 'translate(270px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
//            jQuery("#overlay").show();
        }
    });
})(jQuery);