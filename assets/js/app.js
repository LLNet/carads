!function(e){var t={};function r(l){if(t[l])return t[l].exports;var n=t[l]={i:l,l:!1,exports:{}};return e[l].call(n.exports,n,n.exports,r),n.l=!0,n.exports}r.m=e,r.c=t,r.d=function(e,t,l){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:l})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var l=Object.create(null);if(r.r(l),Object.defineProperty(l,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)r.d(l,n,function(t){return e[t]}.bind(null,n));return l},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="/",r(r.s=0)}([function(e,t,r){r(1),e.exports=r(2)},function(e,t){jQuery(document).ready((function(){if(jQuery(".car-filters .car-filters-form .auto-submit").on("change",(function(){jQuery(".car-filters .car-filters-form").submit()})),jQuery(".active-filters a.remove-filter").on("click",(function(e){e.preventDefault();var t=jQuery(this).data("target"),r=jQuery('[value="'+t+'"]');jQuery(r).removeAttr("selected").val(""),jQuery("form.car-filters-form").submit()})),jQuery(window).width()<576){jQuery(".main-slider").slick({slidesToShow:1,slidesToScroll:1,arrows:!0,fade:!0,dots:!1,nextArrow:'<button class="slick-next "><i class="fa fa-chevron-right"></i></button>',prevArrow:'<button class="slick-prev "><i class="fa fa-chevron-left"></i></button>'}),$(".thumb-slider").hide();var e=jQuery(".pagingInfo");jQuery(".main-slider").on("init reInit afterChange",(function(t,r,l,n){var o=(l||0)+1;e.text(o+"/"+r.slideCount)}))}else jQuery(".main-slider").slick({slidesToShow:1,slidesToScroll:1,arrows:!0,fade:!0,dots:!1,asNavFor:".thumb-slider",nextArrow:'<button class="slick-next "><i class="fa fa-chevron-right"></i></button>',prevArrow:'<button class="slick-prev "><i class="fa fa-chevron-left"></i></button>'}),jQuery(".thumb-slider").slick({slidesToShow:4,slidesToScroll:1,asNavFor:".main-slider",dots:!1,focusOnSelect:!0,centerMode:!0,centerPadding:"40px",nextArrow:'<button class="slick-next "><i class="fa fa-chevron-right"></i></button>',prevArrow:'<button class="slick-prev "><i class="fa fa-chevron-left"></i></button>'});function t(){jQuery("html,body").animate({scrollTop:0},"slow")}if(jQuery(".toggle-filters").on("click",(function(e){e.preventDefault(),jQuery(window).width()>1024?t():(t(),jQuery(".car-filters").toggleClass("show"),jQuery(".car-active-filters").toggleClass("show"))})),jQuery(".multiselect").length>0){var r={buttonWidth:"100%",includeSelectAllOption:!0,buttonContainer:'<div class="btn-group" />',nonSelectedText:("Vælg en mulighed","Mærker"),allSelectedText:"Alle valgt",nSelectedText:"valgt",selectAllText:"Vælg alle"};jQuery("select#brands").multiselect(r),r.nonSelectedText="Modeller",jQuery("select#categories").multiselect(r),r.nonSelectedText="Drivmiddel",jQuery("select#propellant").multiselect(r),r.nonSelectedText="Årgange",jQuery("select#year").multiselect(r),r.nonSelectedText="Gearkassetype",jQuery("select#geartype").multiselect(r),r.nonSelectedText="Kilometertal",jQuery("select#mileage").multiselect(r)}jQuery("#sort_by").on("change",(function(e){e.preventDefault(),jQuery(this).closest("form").submit()}));var l=0;jQuery(".car-filters-form").on("change",(function(e){e.preventDefault();var t=jQuery(this).serialize();clearTimeout(l),l=setTimeout((function(){jQuery.ajax({type:"post",url:indexed.ajaxurl,data:{action:"pre_search",data:t},success:function(e){return e>0?jQuery("button.filter").prop("disabled",!1).text(" Vis "+e+" biler"):jQuery("button.filter").prop("disabled",!0).text("Ingen biler i søgning"),!1}})}),100)})),jQuery("#update-filters").length>0&&jQuery(window).scroll((function(){jQuery(window).scrollTop()>=250?jQuery("#update-filters").addClass("fixed"):jQuery("#update-filters").removeClass("fixed")}))}))},function(e,t){}]);