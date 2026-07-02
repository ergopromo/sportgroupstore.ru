document.addEventListener('DOMContentLoaded', function () {
    const gallary_item = document.querySelectorAll(".staff-detail__sertificate-img");

    for (let i = 0; i < gallary_item.length; i++) {
        gallary_item[i].addEventListener("click", function () {
            openPhotoSwipe(i);
        });
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
            onsuccess: function (html) {
                removeBtnLoader(item);
                showModal(html);
            }
        });
    }

    function openPhotoSwipe(indexItem) {
        const pswpElement = document.querySelector('.pswp');
        const items = [];

        for (let i = 0; i < gallary_item.length; i++) {
            items.push({
                src: gallary_item[i].getAttribute("src"),
                w: gallary_item[i].naturalWidth,
                h: gallary_item[i].naturalHeight
            });
        }

        const options = {
            history: false,
            focus: false,
            index: indexItem,
            showAnimationDuration: 0,
            hideAnimationDuration: 0
        };

        const gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };
});
