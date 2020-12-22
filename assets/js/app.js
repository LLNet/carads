/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/app.js":
/*!***********************!*\
  !*** ./src/js/app.js ***!
  \***********************/
/*! no static exports found */
/***/ (function(module, exports) {

jQuery(document).ready(function () {
  /**
   * Car filters
   */
  jQuery('.car-filters .car-filters-form .auto-submit').on('change', function () {
    jQuery('.car-filters .car-filters-form').submit();
  });
  jQuery('.active-filters a.remove-filter').on('click', function (e) {
    e.preventDefault();
    var target = jQuery(this).data('target'); // find target input and re-submit

    var target_input = jQuery('[value="' + target + '"]');
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
  jQuery('#sort_by').on('change', function (e) {
    e.preventDefault();
    jQuery(this).closest('form').submit();
  });
  var time = 0;
  jQuery('.car-filters-form').on('change', function (e) {
    e.preventDefault();
    var formValues = jQuery(this).serialize(); // Reset the timer

    clearTimeout(time);
    time = setTimeout(function () {
      jQuery.ajax({
        type: "post",
        url: indexed.ajaxurl,
        data: {
          action: "pre_search",
          data: formValues
        },
        success: function success(response) {
          // console.log(formValues)
          if (response > 0) {
            jQuery('button.filter').prop("disabled", false).text(" Vis " + response + " biler");
          } else {
            jQuery('button.filter').prop("disabled", true).text("Ingen biler i søgning");
          }

          return false;
        }
      });
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
  /**
   * Image sliders
   * @type {*|jQuery}
   */


  var viewportWidth = jQuery(window).width();

  if (jQuery('.single-bil').length > 0) {
    var $status = jQuery('.pagingInfo');
    var $slickElement = jQuery('.main-slider');
    $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
      //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
      var i = (currentSlide ? currentSlide : 0) + 1;
      $status.text(i + '/' + slick.slideCount);
    });

    if (viewportWidth < 576) {
      jQuery('.main-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        dots: false,
        nextArrow: $('.main-slider-next'),
        prevArrow: $('.main-slider-prev')
      });
      $('.thumb-slider').hide();
    } else {
      jQuery('.main-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        dots: false,
        asNavFor: '.thumb-slider',
        nextArrow: $('.main-slider-next'),
        prevArrow: $('.main-slider-prev')
      });
      jQuery('.thumb-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.main-slider',
        dots: false,
        focusOnSelect: true,
        centerMode: true,
        centerPadding: '40px',
        nextArrow: $('#thumb-next'),
        prevArrow: $('#thumb-prev')
      });
    }
  }
  /**
   * Scroll to top
   */


  function scrollToTop() {
    jQuery('html,body').animate({
      scrollTop: 0
    }, 'slow');
  }
  /**
   * Multiselect
   */


  if (jQuery('.multiselect').length > 0) {
    var options = {
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
    jQuery('select#mileage').multiselect(options); // jQuery('.attributes .btn-group').on('focusin', function () {
    //     jQuery('.attributes .btn-group').removeClass('open');
    //     jQuery(this).toggleClass('open');
    // });
  }

  jQuery(document).on("click", function () {
    jQuery('.multiselect-container.dropdown-menu').removeClass('active');
  });
  jQuery('button.multiselect.dropdown-toggle').on('click', function (e) {
    jQuery('.multiselect-container.dropdown-menu').removeClass('active');
    e.stopPropagation();
    e.preventDefault();
    jQuery(this).next('.multiselect-container.dropdown-menu').toggleClass('active');
  });
  jQuery('.multiselect-container.dropdown-menu').on('click', function (e) {
    e.stopPropagation();
  });
});

/***/ }),

/***/ "./src/scss/app.scss":
/*!***************************!*\
  !*** ./src/scss/app.scss ***!
  \***************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************!*\
  !*** multi ./src/js/app.js ./src/scss/app.scss ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /var/www/wordpress.test/wp-content/plugins/car-app/src/js/app.js */"./src/js/app.js");
module.exports = __webpack_require__(/*! /var/www/wordpress.test/wp-content/plugins/car-app/src/scss/app.scss */"./src/scss/app.scss");


/***/ })

/******/ });