"use strict";

function AddressBlock(wrapContainer) {
  const city_list = wrapContainer.querySelector(".sidebar-address-block-city-list");
  const parent_city = Array.prototype.slice.call(wrapContainer.querySelectorAll(".sidebar-address-block-city-list__js-show-child"));
  const child_item = Array.prototype.slice.call(wrapContainer.querySelectorAll(".sidebar-address-block-city-list__js-show-popup"));
  const popup_wrap = wrapContainer.querySelector(".sidebar-address-block__popup-wrap");
  const tab_item = Array.prototype.slice.call(wrapContainer.querySelectorAll(".address-block-wrap__tab-item"));
  const tab_content = Array.prototype.slice.call(wrapContainer.querySelectorAll(".address-block__tab-content"));
  const search = wrapContainer.querySelector(".sidebar-address-block__search");
  const city_item = Array.prototype.slice.call(wrapContainer.querySelectorAll(".sidebar-address-block-city-list__item-wrap"));
  const reset_search = wrapContainer.querySelector(".sidebar-address-block__cancel-icon-wrap");
  const btn_open_map = Array.prototype.slice.call(wrapContainer.querySelectorAll(".popup-info-item-address-block__btn-open-map"));
  const event_input = new Event("input");
  const map = wrapContainer.querySelector(".bx-yandex-map");
  const re = /BX_YMAP_/gi;
  const objectMap = map.id;
  const newObjMap = objectMap.replace(re, '');

  let search_string;

  search.addEventListener("input", function () {
    search_string = new RegExp(search.value, "i");
    city_item.forEach(function (elem) {
      const name_city = elem.querySelector(".sidebar-address-block-city-list__name-city").textContent;
      const child_block = elem.querySelector(".sidebar-address-block-city-list__sub-items-block");

      if (child_block) {
        child_block.style.height = 0;
      }

      elem.classList.remove("opened");

      if (search_string.test(name_city)) {
        elem.style.display = "block";
      } else {
        elem.style.display = "none";
      }
    });
  });

  reset_search.addEventListener("mousedown", function (e) {
    search.value = "";
    search.dispatchEvent(event_input);
  });

  window.addEventListener("resize", function () {
    parent_city.forEach(function (el) {
      const child_block = el.querySelector(".sidebar-address-block-city-list__sub-items-block");
      el.classList.remove("opened");
      child_block.style.height = 0;
    });
  });

  btn_open_map.forEach(function (el) {
    el.addEventListener("click", function () {
      tab_content[0].classList.remove("active");
      tab_content[1].classList.add("active");
      tab_item[0].classList.remove("active");
      tab_item[1].classList.add("active");
    });
  });

  tab_item.forEach(function (el, numEl) {
    el.addEventListener("click", function () {
      tab_item.forEach(function (elem, num) {
        elem.classList.remove("active");
        tab_content[num].classList.remove("active");
      });
      el.classList.add("active");
      tab_content[numEl].classList.add("active");
    });
  });

  parent_city.forEach(function (el) {
    const title_city = el.querySelector(".sidebar-address-block-city-list__item");
    const child_block = el.querySelector(".sidebar-address-block-city-list__sub-items-block");
    const child_list = el.querySelector(".sidebar-address-block-city-list__sub-items-list");
    title_city.addEventListener("click", function () {
      el.classList.toggle("opened");

      if (el.classList.contains("opened")) {
        child_block.style.height = child_list.offsetHeight + "px";
      } else {
        child_block.style.height = 0;
      }
    });
  });

  child_item.forEach(function (el) {
    const popup_window = wrapContainer.querySelector(".popup-info-item-address-block[data-popup=\"".concat(el.getAttribute("data-popup"), "\"]"));
    const close_popup = popup_window.querySelector(".popup-info-item-address-block__close-wrap");
    const data_lat = el.dataset.lat;
    const data_lon = el.dataset.lon;
    el.addEventListener("click", function () {
      const coordinatesArray = [data_lat, data_lon];
      window.GLOBAL_arMapObjects[newObjMap].setCenter(coordinatesArray, 15, {
          checkZoomRange: true
      });
      popup_wrap.style.display = "flex";
      popup_window.classList.add("showed");
    });
    close_popup.addEventListener("click", function () {
      popup_wrap.style.display = "none";
      popup_window.classList.remove("showed");
    });
  });

  new PerfectScrollbar(city_list, {
    wheelSpeed: 0.5,
    wheelPropagation: true,
    minScrollbarLength: 20,
    typeContainer: 'li'
  });

  new PerfectScrollbar(popup_wrap, {
    wheelSpeed: 0.5,
    wheelPropagation: true,
    minScrollbarLength: 20
  });

  popup_wrap.addEventListener("wheel", function (e) {
    e.preventDefault();
  });
}

function addEventOnMarker(marker) {
  marker.forEach(function (el) {
    const item_mark = wrapContainer.querySelector("[data-marker=\"".concat(el.geometry.getCoordinates()[0] + el.geometry.getCoordinates()[1], "\"]"));

    if (item_mark) {
      item_mark.addEventListener("click", function () {
        el.balloon.open();
      });
    }
  });
}

function addEventOnMarkerGoogle(marker) {
  marker.forEach(function (el) {
    const item_mark = wrapContainer.querySelector("[data-marker=\"".concat(el.getPosition().lat()).concat(el.getPosition().lng(), "\"]"));

    if (item_mark) {
      item_mark.addEventListener("click", function () {
        el.infowin.open(el.map, el);
      });
    }
  });
}
