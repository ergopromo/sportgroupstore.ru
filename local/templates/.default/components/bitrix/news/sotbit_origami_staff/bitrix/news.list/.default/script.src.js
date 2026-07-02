document.addEventListener('DOMContentLoaded', function () {
    const toggle_btn = Array.prototype.slice.call(document.querySelectorAll(".staff-list-item__toggle-btn"));
    const list_item = Array.prototype.slice.call(document.querySelectorAll(".staff-list-item"));
    let timerId;

    setHeightListItems();

    window.addEventListener('resize', function() {
        clearTimeout(timerId);
        timerId = setTimeout(function(){
            setHeightListItems();

            if (window.matchMedia("(min-width:767px)").matches) {
                toggle_btn.forEach(function(elem){
                    const hidden_info_block_wrap = elem.parentNode.querySelector(".staff-list-item__hidden-info-wrap");
                    hidden_info_block_wrap.style.height = "auto";
                });
            }

            else {
                toggle_btn.forEach(function(elem){
                    const list_item = elem.closest(".staff-list-item");
                    const hidden_info_block_wrap = elem.parentNode.querySelector(".staff-list-item__hidden-info-wrap");
                    if(!list_item.classList.contains("opened")){
                        hidden_info_block_wrap.style.height = 0;
                    }
                });
            }
        },200);
    });

    toggle_btn.forEach(function(elem) {
        const list_item = elem.closest(".staff-list-item");
        const btn_arrow_icon = elem.querySelector(".staff-list-item__toggle-btn-icon");
        const hidden_info_block = elem.parentNode.querySelector(".staff-list-item__hidden-info");
        const hidden_info_block_wrap = elem.parentNode.querySelector(".staff-list-item__hidden-info-wrap");

        elem.addEventListener("click", function() {
            list_item.classList.toggle("opened");

            if(list_item.classList.contains("opened")){
                btn_arrow_icon.style.top = elem.offsetHeight / 2 - 3 + "px";
                hidden_info_block_wrap.style.height = hidden_info_block.offsetHeight + "px";
            }

            else{
                hidden_info_block_wrap.style.height = 0;
            }
           
        });
    });

    function setHeightListItems() { 
        list_item.forEach(function(elem){
            elem.style.height = "auto";
        });

        if (window.matchMedia("(min-width: 1024px)").matches) {
            list_item.forEach(function(elem){
                elem.style.height = elem.offsetHeight + "px";
            });
        }

        else{
            list_item.forEach(function(elem){
                elem.style.height = "auto";
            });
        }
    }

    window.callback_staff = function (siteDir, lid, item, staffName) {
        createBtnLoader(item);
        BX.ajax({
            url: siteDir+'include/ajax/callbackphone_staff.php',
            method: 'POST',
            data: {
                'lid':lid,
                'staffName': staffName
            },
            onsuccess: function(html)
            {
                removeBtnLoader(item);
                showModal(html);
            }
        });
    }
});