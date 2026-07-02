"use strict";

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

document.addEventListener('DOMContentLoaded', function () {
  var header = document.getElementById('header-three');
  var sidebar = document.getElementById('header-sidebar');
  var bxPanel = document.getElementById('bx-panel');
  var headerUpAuth = document.querySelector('.header-three__personal ');
  var body = document.querySelector('body');
  var headerShadow = document.querySelector('.header-three-shadow');
  setPosition();
  window.addEventListener('scroll', setPosition);
  window.addEventListener('resize', setPosition);

    if(headerUpAuth){
        var observePopupAuth = new MutationObserver(function (){
            const popupAuth = document.querySelector('#modal_auth');
            const popupAuthOverlay = document.querySelector('#popup-window-overlay-modal_auth');
            if(popupAuth && popupAuthOverlay){
                popupAuth.style.zIndex = 10996;
                popupAuthOverlay.style.zIndex = 10995;
            }
        });
        observePopupAuth.observe(body, {
            childList: true,
        });
    }

  if (bxPanel) {
    var observerBxPanel = new MutationObserver(setPosition);
    observerBxPanel.observe(bxPanel, {
      attributes: true
    });
  }

  function setPosition() {
    if (window.innerWidth > 1023) {
      if (bxPanel && bxPanel.classList.contains('bx-panel-fixed')) {
          if(window.pageYOffset >= getHeightElement(header)){
              header.classList.add('fix-header-three');
              header.style.top = getHeightElement(bxPanel) + 'px';
          }else{
              header.classList.remove('fix-header-three');
              header.style.top = '';
          }
        sidebar.style.top = getHeightElement(bxPanel) + getHeightElement(header) + 'px';
        sidebar.style.height = window.innerHeight - (getHeightElement(bxPanel) - window.pageYOffset + getHeightElement(header)) + 'px';
      } else {
        if (window.pageYOffset >= getHeightElement(header)) {
          header.classList.add('fix-header-three');
          header.style.top = '';
          sidebar.style.top = getHeightElement(header) + 'px';
          sidebar.style.height = window.innerHeight - getHeightElement(header) + 'px';
        } else {
          header.classList.remove('fix-header-three');
          sidebar.style.top = getHeightElement(bxPanel) + getHeightElement(header) - window.pageYOffset + 'px';
          sidebar.style.height = window.innerHeight - (getHeightElement(bxPanel) - window.pageYOffset + getHeightElement(header)) + 'px';
        }
      }

      return;
    } else {
      if (bxPanel && bxPanel.classList.contains('bx-panel-fixed')) {
        if(window.pageYOffset >= getHeightElement(header)){
            header.classList.add('fix-header-three');
            header.style.top = getHeightElement(bxPanel) + 'px';
        }  else{
            header.classList.remove('fix-header-three');
            header.style.top = '';
        }
          sidebar.style.height = '';
          sidebar.style.top = '';
      } else {
        if (window.pageYOffset >= getHeightElement(header)) {
          header.classList.add('fix-header-three');
        } else {
          header.classList.remove('fix-header-three');
        }
          sidebar.style.height = '';
          sidebar.style.top = '';
      }

      return;
    }

    showMobileView();
  }

  function showMobileView() {
    header.style.top = '';
    sidebar.style.bottom = '0px';
    sidebar.style.top = '';
    sidebar.style.height = '';
  }

  function getHeightElement(item) {
    return item ? item.offsetHeight : 0;
  }
});
document.addEventListener('DOMContentLoaded', function () {
  var cityMenu = document.getElementById('menu-city');
  var cityHeader = document.querySelector('[data-entity="open_region"]');
  var compareMenuCount = document.getElementById('menu-compare-count');
  var favoritesMenuCount = document.getElementById('menu-favorites-count');
  var basketMenuCount = document.getElementById('menu-basket-count');
  var compareHeaderCount = document.getElementById('compare-count');
  var favoritesHeaderCount = document.getElementById('favorites-count');
  var basketHeaderCount = document.getElementById('basket-count');
  var city = document.querySelector('.header-three__city');
  changeCity();
  changeCount();
  var observerCity = new MutationObserver(changeCity);
  observerCity.observe(city, {
    childList: true,
    subtree: true
  });
  var basket = document.querySelector('.header-three__basket');
  var observerCompare = new MutationObserver(changeCount);
  observerCompare.observe(basket, {
    childList: true,
    subtree: true
  });

  function changeCity() {
    if (cityHeader && cityMenu) {
      createCopyTextContent(cityHeader, cityMenu);
    }
  }

  function changeCount() {
    compareHeaderCount = document.getElementById('compare-count');
    favoritesHeaderCount = document.getElementById('favorites-count');
    basketHeaderCount = document.getElementById('basket-count');

    if (compareHeaderCount) {
      createCopyTextContent(compareHeaderCount, compareMenuCount);
      toggleActive(compareMenuCount);
    }

    if (favoritesHeaderCount) {
      createCopyTextContent(favoritesHeaderCount, favoritesMenuCount);
      toggleActive(favoritesMenuCount);
    }

    if (basketHeaderCount) {
      createCopyTextContent(basketHeaderCount, basketMenuCount);
      toggleActive(basketMenuCount);
    }
  }

  function toggleActive(observerItem) {
    if (parseInt(observerItem.innerText) !== 0 && !observerItem.classList.contains('active')) {
      observerItem.classList.add('active');
    }

    if (parseInt(observerItem.innerText) === 0) {
      observerItem.classList.remove('active');
    }
  }

  function createCopyTextContent(inEl, outEl) {
    outEl.innerText = inEl.innerText.replace(/\r?\n/g, "");
  }

  ;
  var arrSubMenu = document.querySelectorAll('.section__item-submenu');

  var _iterator = _createForOfIteratorHelper(arrSubMenu),
      _step;

  try {
    var _loop = function _loop() {
      var item = _step.value;
      var titleItem = item.previousElementSibling;
      var heightItem = item.offsetHeight;
      titleItem.dataset.submenu = true;
      item.style.height = '0px';
      titleItem.addEventListener('click', function (evt) {
        evt.currentTarget.classList.toggle('open');

        if (evt.currentTarget.classList.contains('open')) {
          item.style.height = heightItem + 'px';
        } else {
          item.style.height = '0px';
        }
      });
    };

    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      _loop();
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }

  var header = document.getElementById('header-three');
  var menu = document.querySelector('#menu-header-three');
  var overlay = menu.querySelector('.menu__overlay');
  var btnClose = document.querySelector('[data-entity="close_menu"]');
  var btnOpen = document.querySelector('[data-entity="open_menu"]');

  if (btnOpen) {
    btnOpen.addEventListener('click', function (evt) {
      menu.classList.add('show');
      header.classList.add('js-side-panel-show');
    });
  }

  btnClose.addEventListener('click', function (evt) {
    menu.classList.remove('show');
    header.classList.remove('js-side-panel-show');
  });
  overlay.addEventListener('click', function (evt) {
    menu.classList.remove('show');
    header.classList.remove('js-side-panel-show');
  });
  menu.addEventListener('wheel', function (evt) {
    evt.preventDefault();
  });
  var menuWrapper = menu.querySelector('.menu__wrap-scroll');
  new PerfectScrollbar(menuWrapper, {
    wheelSpeed: 0.5,
    wheelPropagation: true,
    minScrollbarLength: 20
  });
});
