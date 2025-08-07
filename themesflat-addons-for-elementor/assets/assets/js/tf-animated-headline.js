;(function($) {

    "use strict";

var tf_animated_headline = function() {
    var highlightedWave = $('.tf-highlighted-wave'),
        highlightedDrop = $('.tf-highlighted-drop-in'),
        highlightedSlide = $('.tf-highlighted-slide');

    if ( highlightedWave.length ) {
        highlightedWave.each(function (index ,item) {
            item.innerHTML = $(this).text().replace(/\S/g, "<span class='letter'>$&</span>");
        });

        anime.timeline({loop: true})
            .add({
                targets: '.tf-highlighted-wave .letter',
                scale: [4,1],
                opacity: [0,1],
                translateZ: 0,
                easing: "easeOutExpo",
                duration: 950,
                delay: (el, i) => 70*i
            }).add({
            targets: '.tf-highlighted-wave',
            opacity: 0,
            duration: 1000,
            easing: "easeOutExpo",
            delay: 1000
        });
    }

    if(highlightedDrop.length){
        highlightedDrop.each(function (index ,item) {
            item.innerHTML = $(this).text().replace(/\S/g, "<span class='letter'>$&</span>");
        });

        anime.timeline({loop: true})
            .add({
                targets: '.tf-highlighted-drop-in .letter',
                scale: [0, 1],
                duration: 1500,
                elasticity: 600,
                delay: (el, i) => 45 * (i+1)
            }).add({
            targets: '.tf-highlighted-drop-in',
            opacity: 0,
            duration: 1000,
            easing: "easeOutExpo",
            delay: 1000
        });
    }

    if(highlightedDrop.length){
        highlightedDrop.each(function (index ,item) {
            item.innerHTML = $(this).text().replace(/\S/g, "<span class='letter'>$&</span>");
        });

        anime.timeline({loop: true})
            .add({
                targets: '.tf-highlighted-drop-in .letter',
                scale: [0, 1],
                duration: 1500,
                elasticity: 600,
                delay: (el, i) => 45 * (i+1)
            }).add({
            targets: '.tf-highlighted-drop-in',
            opacity: 0,
            duration: 1000,
            easing: "easeOutExpo",
            delay: 1000
        });
    }

    if(highlightedSlide.length){
        highlightedSlide.each(function (index ,item) {
            item.innerHTML = $(this).text().replace(/\S/g, "<span class='letter'>$&</span>");
        });

        anime.timeline({loop: true})
            .add({
                targets: '.tf-highlighted-slide .letter',
                translateX: [40,0],
                translateZ: 0,
                opacity: [0,1],
                easing: "easeOutExpo",
                duration: 1200,
                delay: (el, i) => 500 + 30 * i
            }).add({
            targets: '.tf-highlighted-slide .letter',
            translateX: [0,-30],
            opacity: [1,0],
            easing: "easeInExpo",
            duration: 1100,
            delay: (el, i) => 100 + 30 * i
        });
    }

}


$(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/tfanimated_headline.default', tf_animated_headline );
});

})(jQuery);