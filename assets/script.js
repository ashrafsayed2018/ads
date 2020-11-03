$(document).ready(function(){
    //navigation scroll function
    $(window).scroll(function(){
        if($(this).scrollTop()>=50){
            $("nav").css({"background-color":"#FFF"});
        }
        else{
            $("nav").css({"background-color":"rgba(255, 255, 255, 0.1)"});
        }
    });
    //ads loading animation on scroll
    function apperance(_this,i) {
        setTimeout(function() { 
            $(_this).removeClass("ad-hidden"); 
        }, 100 + i * 300);
    }

    $(window).scroll(function(){
        var scrTop = $(this).scrollTop()+$(this).height();
        $(".ad-hidden").each(function(index){
            if(scrTop > $(this).offset().top){
                apperance(this,index);
            }
        });
    });

    $(window).on("load", function(){
        //$(".preloader").fadeOut("slow");
        setTimeout(function(){ 
            $(".preloader").fadeOut("slow");
            $(".landing-page").addClass("bg-animation");
            $(".top-form-wrapper").addClass("form-animation");
            $(".slogans h1").addClass("slogan-h1-animation");
            $(".slogans h2").addClass("slogan-h2-animation");
        }, 1000);
    });
});

// for an individual element
    var flkty = new Flickity( '#adFeatureCarousel', {
        contain: true,
        pageDots: false,
        wrapAround: true,
        freeScroll: true,
        autoPlay: 2000
        });

