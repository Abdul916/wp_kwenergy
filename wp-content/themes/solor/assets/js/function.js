(function ($) {
    "use strict";
	
	var $window = $(window); 
	var $body = $('body'); 

	/* Preloader Effect */
	$window.on('load', function(){
		$(".preloader").fadeOut(600);
	});
	
	/* Slick Menu JS */
	if($('.main-menu').length) { 
		$('.main-menu').slicknav({
			label : '',
			prependTo : '.responsive-menu'
		});
	}

	/* Image Reveal Animation */
	if ($('.solor-animation-image-style-1').length) {
        gsap.registerPlugin(ScrollTrigger);
        let revealContainers = document.querySelectorAll(".solor-animation-image-style-1");
        revealContainers.forEach((container) => {
            let image = container.querySelector("img");
            let tl = gsap.timeline({
                scrollTrigger: {
                    trigger: container,
                    toggleActions: "play none none none"
                }
            });
            tl.set(container, {
                autoAlpha: 1
            });
            tl.from(container, 1, {
                xPercent: -100,
                ease: Power2.out
            });
            tl.from(image, 1, {
                xPercent: 100,
                scale: 1,
                delay: -1,
                ease: Power2.out
            });
        });
    }

	/* Text Effect Animation */
	if ($('.solor-animation-heading-style-1 .elementor-heading-title').length) {
		let staggerAmount 	= 0.05,
			translateXValue = 0,
			delayValue 		= 0.5,
		   animatedTextElements = document.querySelectorAll('.solor-animation-heading-style-1 .elementor-heading-title');
		
		animatedTextElements.forEach((element) => {
			let animationSplitText = new SplitType(element, { type: "chars, words" });
				gsap.from(animationSplitText.words, {
				duration: 1,
				delay: delayValue,
				x: 20,
				autoAlpha: 0,
				stagger: staggerAmount,
				scrollTrigger: { trigger: element, start: "top 85%" },
				});
		});
		
	}
	
	if ($('.solor-animation-heading-style-2 .elementor-heading-title').length) {
		
		let	 staggerAmount 		= 0.05,
			 translateXValue	= 20,
			 delayValue 		= 0.5,
			 easeType 			= "power2.out",
			 animatedTextElements = document.querySelectorAll('.solor-animation-heading-style-2 .elementor-heading-title');
		
		animatedTextElements.forEach((element) => {
			let splitText = new SplitType(element, { type: "chars, words" });
				gsap.from(splitText.chars, {
					duration: 1,
					delay: delayValue,
					x: translateXValue,
					autoAlpha: 0,
					stagger: staggerAmount,
					ease: easeType,
					scrollTrigger: { trigger: element, start: "top 85%"},
				});
		});
		
	}
	
})(jQuery);