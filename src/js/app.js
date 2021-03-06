jQuery(document).ready(function () {
    var userAgent = navigator.userAgent.toLowerCase();
    var android = /android/i.test(userAgent);
    var iphone = /iphone|ipad/i.test(userAgent);
    /**
     * Car filters
     */
    jQuery('.car-filters .car-filters-form .auto-submit').on('change', function() {
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
    jQuery('#scroll-to-top').on('click', function (e) {
        e.preventDefault();
        scrollToTop();

    });

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
                dataType: "json",
                data: {action: "pre_search", data: formValues},
                success: function (response) {
                    // console.log(formValues)
                    if (response.total > 0) {

                        jQuery('button.filter')
                            .prop("disabled", false)
                            .text(" Vis " + response.total + " biler"); // response.count

                        var oldValue = jQuery("select#categories").val();
                        jQuery("select#categories option").each(function(){
                            jQuery(this).remove();
                        })

                        jQuery.each(response.categories, function(v,k){
                            jQuery("select#categories").append('<option value="' + k + '">' + k + '</option>');
                        });

                        jQuery("select#categories").val(oldValue);
                        jQuery("select#categories").multiselect('rebuild');
                    } else {
                        jQuery('button.filter')
                            .prop("disabled", true)
                            .text("Ingen biler i s??gning");
                    }
                    return false;
                }
            })
        }, 100);
    });

    if (jQuery('#update-filters').length > 0) {

        let topofDiv = jQuery(".car-filters").offset().top;
        let height = jQuery(".car-filters").outerHeight();

        jQuery(window).scroll(function () {
            if (jQuery(window).scrollTop() > (topofDiv + height)) {
                jQuery('#update-filters')
                    .addClass('ca-fixed')
                    .removeClass('ca-hidden');
            } else {
                jQuery('#update-filters')
                    .removeClass('ca-fixed')
                    .addClass('ca-hidden');
            }
        });
    }


    /**
     * Image sliders
     * @type {*|jQuery}
     */
    let viewportWidth = jQuery(window).width();

    if (jQuery('.single-bil').length > 0) {
        let $status = jQuery('.pagingInfo');
        let $slickElement = jQuery('.carads-main-slider');

        $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
            //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            let i = (currentSlide ? currentSlide : 0) + 1;
            $status.text(i + '/' + slick.slideCount);
        });

        if (viewportWidth < 576) {

            jQuery('.carads-main-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                dots: false,
                nextArrow: jQuery('.main-slider-next'),
                prevArrow: jQuery('.main-slider-prev'),
            });
            jQuery('.carads-thumb-slider').hide();

        } else {
            jQuery('.carads-main-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                dots: false,
                asNavFor: '.carads-thumb-slider',
                nextArrow: jQuery('.main-slider-next'),
                prevArrow: jQuery('.main-slider-prev'),
            });
            jQuery('.carads-thumb-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: '.carads-main-slider',
                dots: false,
                focusOnSelect: true,
                centerMode: true,
                centerPadding: '40px',
                nextArrow: jQuery('#thumb-next'),
                prevArrow: jQuery('#thumb-prev'),
            });
        }
    }


    /**
     * Scroll to top
     */
    function scrollToTop() {
        jQuery('html,body').animate({scrollTop: 0}, 'slow');
    }

    /**
     * Multiselect
     */
    if (jQuery('.multiselect').length > 0) {
        let options = {
            buttonWidth: '100%',
            includeSelectAllOption: true,
            buttonContainer: '<div class="btn-group" />',
            nonSelectedText: "V??lg en mulighed",
            allSelectedText: "Alle valgt",
            nSelectedText: "valgt",
            selectAllText: 'V??lg alle',
            preventInputChangeEvent: true,
            maxHeight: 250,
            templates: {
                button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span></button>',
                container: '<div class="multiselect-container dropdown-menu"></div>',
                filter: '<div class="multiselect-filter"><div class="input-group input-group-sm p-1"><div class="input-group-prepend"><i class="input-group-text fas fa-search"></i></div><input class="form-control multiselect-search" type="text" /></div></div>',
                filterClearBtn: '<div class="input-group-append"><button class="multiselect-clear-filter input-group-text" type="button"><i class="fas fa-times"></i></button></div>',
                option: '<button type="button" class="multiselect-option dropdown-item"></button>',
                divider: '<div class="dropdown-divider"></div>',
                optionGroup: '<button type="button" class="multiselect-group dropdown-item"></button>',
                resetButton: '<div class="multiselect-reset text-center p-2"><button class="btn btn-sm btn-block btn-outline-secondary"></button></div>'
            }

        };

        // if iphone or android - we using build selector from os!
        if(!(android || iphone))
        {
            options.nonSelectedText = "M??rker";
            jQuery('select#brands').multiselect(options);
        }
        else{
            jQuery('select#brands').removeClass('multiselect');
        }

        options.nonSelectedText = "Modeller";
        jQuery('select#categories').multiselect(options);


        options.nonSelectedText = "Drivmiddel";
        jQuery('select#propellant').multiselect(options);

        options.nonSelectedText = "??rgange";
        jQuery('select#year').multiselect(options);

        options.nonSelectedText = "Gearkasse";
        jQuery('select#geartype').multiselect(options);

        options.nonSelectedText = "Kilometertal";
        jQuery('select#mileage').multiselect(options);

        console.log('DEBUG!!!');

        // jQuery('.attributes .btn-group').on('focusin', function () {
        //     jQuery('.attributes .btn-group').removeClass('open');
        //     jQuery(this).toggleClass('open');
        // });
    }


    // jQuery(document).on("click", function () {
    //     jQuery('.multiselect-container.dropdown-menu').removeClass('active')
    // });
    jQuery('.multiselect.dropdown-toggle').on('click', function (e) {
        if (jQuery(this).next('.multiselect-container.dropdown-menu').hasClass('active') === true) {
            jQuery(this).next('.multiselect-container.dropdown-menu').removeClass('active');
            jQuery(this).parent('.btn-group').find('button.multiselect').removeClass('active');
        } else {
            jQuery('.multiselect-container.dropdown-menu').removeClass('active');
            jQuery('.btn-group button.multiselect').removeClass('active');


            jQuery(this).next('.multiselect-container.dropdown-menu').addClass('active');
            jQuery(this).parent('.btn-group').find('button.multiselect').addClass('active');
            jQuery(this).next('button.multiselect.dropdown-toggle span.multiselect-selected-text:before').css('content', 'LUK');

        }
    });

    jQuery('.multiselect-container.dropdown-menu').on('click', function (e) {
        e.stopPropagation();
    });


    /**
     * Car view mode
     */
    jQuery('.car_view_change').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        let view_mode = jQuery(this).data('view');

        // remove active state on all
        jQuery('.car_view_change')
            .addClass('ca-bg-white ca-text-text')
            .addClass('ca-bg-white ca-text-text')
            .removeClass('ca-bg-primary')
            .removeClass('ca-text-white');

        // add active state on $this
        jQuery(this)
            .removeClass('ca-bg-white ca-text-text')
            .removeClass('ca-bg-white ca-text-text')
            .addClass('ca-bg-primary')
            .addClass('ca-text-white');

        // set cookie
        setCookie('car_view', view_mode);

        // Reload to make changes take effect
        window.location.reload();

    });

    /**
     * Cookie handling
     */
    function checkCookie() {
        let cookie = getCookie("car_view");
        if (cookie === undefined) {
            setCookie("car_view", "list");
        }
    }

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    function setCookie(name, value, options = {}) {
        let date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));

        options = {
            path: '/',
            expires: date.toUTCString(),
            'max-age': 3600,
            ...options
        };
        if (process.env.NODE_ENV === 'production') {
            options.secure = true;
        }

        let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

        for (let optionKey in options) {
            updatedCookie += "; " + optionKey;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
                updatedCookie += "=" + optionValue;
            }
        }

        document.cookie = updatedCookie;
    }


    checkCookie();


});
