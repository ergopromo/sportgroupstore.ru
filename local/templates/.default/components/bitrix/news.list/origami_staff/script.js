"use strict";

const sliderBtnPos = function (){
    var slider_btn = document.querySelectorAll(".staff-block__slider .btn-slider-main");
    if (slider_btn) {
        var arr_slider_btn = Array.prototype.slice.call(slider_btn);
        arr_slider_btn.forEach(function (el) {
            el.style.top = "calc(" + getComputedStyle(el).top;
        });
    }
}

document.addEventListener("DOMContentLoaded", function () {
  var slider_item = Array.prototype.slice.call(document.querySelectorAll(".staff-block-item"));

  setHeightSliderItem();
  window.addEventListener("resize", function () {
    setHeightSliderItem();
  });

  function setHeightSliderItem() {
    slider_item.forEach(function (el) {
      el.style.height = "auto";
    });
    slider_item.forEach(function (el) {
      el.style.height = el.offsetHeight + "px";
    });
  }
});
