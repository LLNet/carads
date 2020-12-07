jQuery(document).ready(function () {


    jQuery('.car-filters .car-filters-form .auto-submit').on('change', function () {
        jQuery('.car-filters .car-filters-form').submit();
    });


    jQuery('.active-filters a.remove-filter').on('click', function (e) {
        e.preventDefault();
        let target = jQuery(this).data('target');

        // find target input and re-submit
        let target_input = jQuery('[value="' + target + '"]');
        jQuery(target_input).removeAttr('selected').val('');
        jQuery('form.car-filters-form').submit();


    });


    let viewportWidth = jQuery(window).width();

    if (viewportWidth < 576) {

        jQuery('.main-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            dots: false,
            nextArrow: '<button class="slick-next "><i class="fa fa-chevron-right"></i></button>',
            prevArrow: '<button class="slick-prev "><i class="fa fa-chevron-left"></i></button>',
        });
        $('.thumb-slider').hide();

        let $status = jQuery('.pagingInfo');
        let $slickElement = jQuery('.main-slider');

        $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
            //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            let i = (currentSlide ? currentSlide : 0) + 1;
            $status.text(i + '/' + slick.slideCount);
        });



    } else {
        jQuery('.main-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            dots: false,
            asNavFor: '.thumb-slider',
            nextArrow: '<button class="slick-next "><i class="fa fa-chevron-right"></i></button>',
            prevArrow: '<button class="slick-prev "><i class="fa fa-chevron-left"></i></button>',
        });
        jQuery('.thumb-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.main-slider',
            dots: false,
            focusOnSelect: true,
            centerMode: true,
            centerPadding: '40px',
            nextArrow: '<button class="slick-next "><i class="fa fa-chevron-right"></i></button>',
            prevArrow: '<button class="slick-prev "><i class="fa fa-chevron-left"></i></button>',
        });
    }


    jQuery('.toggle-filters').on('click', function (e) {
        e.preventDefault();
        if (jQuery(window).width() > 1024) {
            scrollToTop();
        } else {
            scrollToTop();
            jQuery('.car-filters').toggleClass('show');
            jQuery('.car-active-filters').toggleClass('show');
        }

    });

    function scrollToTop() {
        jQuery('html,body').animate({scrollTop: 0}, 'slow');
    }

    if (jQuery('.multiselect').length > 0) {
        let options = {
            buttonWidth: '100%',
            includeSelectAllOption: true,
            buttonContainer: '<div class="btn-group" />',
            nonSelectedText: "Vælg en mulighed",
            allSelectedText: "Alle valgt",
            nSelectedText: "valgt",
            selectAllText: 'Vælg alle'
        };
        options.nonSelectedText = "Mærker";
        jQuery('select#brands').multiselect(options);

        options.nonSelectedText = "Modeller";
        jQuery('select#categories').multiselect(options);

        options.nonSelectedText = "Drivmiddel";
        jQuery('select#propellant').multiselect(options);

        options.nonSelectedText = "Årgange";
        jQuery('select#year').multiselect(options);

        options.nonSelectedText = "Gearkassetype";
        jQuery('select#geartype').multiselect(options);

        options.nonSelectedText = "Kilometertal";
        jQuery('select#mileage').multiselect(options);

        // jQuery('.attributes .btn-group').on('focusin', function () {
        //     jQuery('.attributes .btn-group').removeClass('open');
        //     jQuery(this).toggleClass('open');
        // });
    }

    jQuery('#sort_by').on('change', function (e) {
        e.preventDefault();
        jQuery(this).closest('form').submit();
    });


    let time = 0;
    jQuery('.car-filters-form').on('change', function (e) {
        e.preventDefault();
        let formValues = jQuery(this).serialize();

        // Reset the timer
        clearTimeout(time);

        time = setTimeout(function () {
            jQuery.ajax({
                type: "post",
                url: indexed.ajaxurl,
                data: {action: "pre_search", data: formValues},
                success: function (response) {
                    // console.log(formValues)
                    if (response > 0) {
                        jQuery('button.filter').prop("disabled", false).text(" Vis " + response + " biler");
                    } else {
                        jQuery('button.filter').prop("disabled", true).text("Ingen biler i søgning");
                    }
                    return false;
                }
            })
        }, 100);
    });

    if (jQuery('#update-filters').length > 0) {
        jQuery(window).scroll(function () {
            if (jQuery(window).scrollTop() >= 250) {
                jQuery('#update-filters').addClass('fixed');
            } else {
                jQuery('#update-filters').removeClass('fixed');
            }
        });
    }


});
