(function($){

    $(document).ready(function() {

        $('.testimonial-slider').owlCarousel({
            items: 1,
            autoplay: true,
            nav: true,
            loop: true
        });

        $('#cta-btn').on('click', function() {
            $('.floating-cta-bar').hide();
        });

    });

})(jQuery);