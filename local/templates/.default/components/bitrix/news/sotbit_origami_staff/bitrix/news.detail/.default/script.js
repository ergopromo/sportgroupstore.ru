"use strict";

document.addEventListener('DOMContentLoaded', function () {
  var gallary_item = document.querySelectorAll(".staff-detail__sertificate-img");

  var _loop = function _loop(i) {
    gallary_item[i].addEventListener("click", function () {
      openPhotoSwipe(i);
    });
  };

  for (var i = 0; i < gallary_item.length; i++) {
    _loop(i);
  }

  window.callback_staff = function (siteDir, lid, item, staffName) {
    createBtnLoader(item);
    BX.ajax({
      url: siteDir + 'include/ajax/callbackphone_staff.php',
      method: 'POST',
      data: {
        'lid': lid,
        'staffName': staffName
      },
      onsuccess: function onsuccess(html) {
        removeBtnLoader(item);
        showModal(html);
      }
    });
  };

  function openPhotoSwipe(indexItem) {
    var pswpElement = document.querySelector('.pswp');
    var items = [];

    for (var _i = 0; _i < gallary_item.length; _i++) {
      items.push({
        src: gallary_item[_i].getAttribute("src"),
        w: gallary_item[_i].naturalWidth,
        h: gallary_item[_i].naturalHeight
      });
    }

    var options = {
      history: false,
      focus: false,
      index: indexItem,
      showAnimationDuration: 0,
      hideAnimationDuration: 0
    };
    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
  }

  ;
});