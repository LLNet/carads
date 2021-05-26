/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/app.js":
/*!***********************!*\
  !*** ./src/js/app.js ***!
  \***********************/
/***/ (() => {

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

jQuery(document).ready(function () {
  var userAgent = navigator.userAgent.toLowerCase();
  var android = /android/i.test(userAgent);
  var iphone = /iphone|ipad/i.test(userAgent);
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
  jQuery('#scroll-to-top').on('click', function (e) {
    e.preventDefault();
    scrollToTop();
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
        dataType: "json",
        data: {
          action: "pre_search",
          data: formValues
        },
        success: function success(response) {
          // console.log(formValues)
          if (response.total > 0) {
            jQuery('button.filter').prop("disabled", false).text(" Vis " + response.total + " biler"); // response.count

            var oldValue = jQuery("select#categories").val();
            jQuery("select#categories option").each(function () {
              jQuery(this).remove();
            });
            jQuery.each(response.categories, function (v, k) {
              jQuery("select#categories").append('<option value="' + k + '">' + k + '</option>');
            });
            jQuery("select#categories").val(oldValue);
            jQuery("select#categories").multiselect('rebuild');
          } else {
            jQuery('button.filter').prop("disabled", true).text("Ingen biler i søgning");
          }

          return false;
        }
      });
    }, 100);
  });

  if (jQuery('#update-filters').length > 0) {
    var topofDiv = jQuery(".car-filters").offset().top;
    var height = jQuery(".car-filters").outerHeight();
    jQuery(window).scroll(function () {
      if (jQuery(window).scrollTop() > topofDiv + height) {
        jQuery('#update-filters').addClass('ca-fixed').removeClass('ca-hidden');
      } else {
        jQuery('#update-filters').removeClass('ca-fixed').addClass('ca-hidden');
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
    var $slickElement = jQuery('.carads-main-slider');
    $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
      //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
      var i = (currentSlide ? currentSlide : 0) + 1;
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
        prevArrow: jQuery('.main-slider-prev')
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
        prevArrow: jQuery('.main-slider-prev')
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
        prevArrow: jQuery('#thumb-prev')
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
      selectAllText: 'Vælg alle',
      preventInputChangeEvent: true,
      maxHeight: 250,
      templates: {
        button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span></button>',
        container: '<div class="multiselect-container dropdown-menu"></div>',
        filter: '<div class="multiselect-filter"><div class="input-group input-group-sm p-1"><div class="input-group-prepend"><i class="input-group-text fas fa-search"></i></div><input class="form-control multiselect-search" type="text" /></div></div>',
        filterClearBtn: '<div class="input-group-append"><button class="multiselect-clear-filter input-group-text" type="button"><i class="fas fa-times"></i></button></div>',
        option: '<button class="multiselect-option dropdown-item"></button>',
        divider: '<div class="dropdown-divider"></div>',
        optionGroup: '<button class="multiselect-group dropdown-item"></button>',
        resetButton: '<div class="multiselect-reset text-center p-2"><button class="btn btn-sm btn-block btn-outline-secondary"></button></div>'
      }
    }; // if iphone or android - we using build selector from os!

    if (!(android || iphone)) {
      options.nonSelectedText = "Mærker";
      jQuery('select#brands').multiselect(options);
    } else {
      jQuery('select#brands').removeClass('multiselect');
    }

    options.nonSelectedText = "Modeller";
    jQuery('select#categories').multiselect(options);
    options.nonSelectedText = "Drivmiddel";
    jQuery('select#propellant').multiselect(options);
    options.nonSelectedText = "Årgange";
    jQuery('select#year').multiselect(options);
    options.nonSelectedText = "Gearkasse";
    jQuery('select#geartype').multiselect(options);
    options.nonSelectedText = "Kilometertal";
    jQuery('select#mileage').multiselect(options);
    console.log('DEBUG!!!');
    jQuery('.form-check-input').click(function (e) {
      e.preventDefault();
    }); // jQuery('.attributes .btn-group').on('focusin', function () {
    //     jQuery('.attributes .btn-group').removeClass('open');
    //     jQuery(this).toggleClass('open');
    // });
  } // jQuery(document).on("click", function () {
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
    var view_mode = jQuery(this).data('view'); // remove active state on all

    jQuery('.car_view_change').addClass('ca-bg-white ca-text-text').addClass('ca-bg-white ca-text-text').removeClass('ca-bg-primary').removeClass('ca-text-white'); // add active state on $this

    jQuery(this).removeClass('ca-bg-white ca-text-text').removeClass('ca-bg-white ca-text-text').addClass('ca-bg-primary').addClass('ca-text-white'); // set cookie

    setCookie('car_view', view_mode); // Reload to make changes take effect

    window.location.reload();
  });
  /**
   * Cookie handling
   */

  function checkCookie() {
    var cookie = getCookie("car_view");

    if (cookie === undefined) {
      setCookie("car_view", "list");
    }
  }

  function getCookie(name) {
    var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
    return matches ? decodeURIComponent(matches[1]) : undefined;
  }

  function setCookie(name, value) {
    var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
    var date = new Date();
    date.setTime(date.getTime() + 30 * 24 * 60 * 60 * 1000);
    options = _objectSpread({
      path: '/',
      expires: date.toUTCString(),
      'max-age': 3600
    }, options);

    if (false) {}

    var updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

    for (var optionKey in options) {
      updatedCookie += "; " + optionKey;
      var optionValue = options[optionKey];

      if (optionValue !== true) {
        updatedCookie += "=" + optionValue;
      }
    }

    document.cookie = updatedCookie;
  }

  checkCookie();
});

/***/ }),

/***/ "./src/scss/app.scss":
/*!***************************!*\
  !*** ./src/scss/app.scss ***!
  \***************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					result = fn();
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/js/app": 0,
/******/ 			"assets/css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkcar_app"] = self["webpackChunkcar_app"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/css/app"], () => (__webpack_require__("./src/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/css/app"], () => (__webpack_require__("./src/scss/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;