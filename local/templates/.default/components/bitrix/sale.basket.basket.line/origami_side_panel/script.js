
document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.querySelector('.side-panel-over');
    const sidePanel = document.querySelector('.side-panel');
    const btnCartOpen = sidePanel.querySelector('.side-panel-main__nav-item--cart');
    const btnDelayOpen = sidePanel.querySelector('.side-panel-main__nav-item--delay');
    const btnDelayCompare = sidePanel.querySelector('.side-panel-main__nav-item--compare');
    const countCompare = btnDelayCompare.querySelector('.side-panel-main__nav-count');
    const basketLine = document.querySelector('[id^=bx_basket]');

    const btnAuthOpen = sidePanel.querySelector('.side-panel-main__nav-item--login');
    const sidePanelBasket = sidePanel.querySelector('.side-panel__main-basket');
    const sidePanelAuth = sidePanel.querySelector('.side-panel__main-auth');
    const sidePanelOrder = sidePanel.querySelector('.side-panel__main-order');
    const arrPanelItems = Array.prototype.slice.call(sidePanel.querySelectorAll('.side-panel__main-item'));

    // const obCountMobileBasket = document.getElementById('mobile-menu-basket');
    // const obCountMobileDelay = document.getElementById('mobile-menu-delay');
    // const obCountMobileCompare = document.getElementById('mobile-menu-compare');

    const changeCountBasket = function (mutationsList, observer) {
        try {
            countCompare.innerHTML = document.getElementById('compare-count')?.textContent;

            if (parseFloat(countCompare.innerHTML) > 0) {
                countCompare.classList.add('active');
                btnDelayCompare.classList.add('active');
                btnDelayCompare.removeAttribute('onclick');
            } else {
                countCompare.classList.remove('active');
                btnDelayCompare.classList.remove('active');
                btnDelayCompare.setAttribute('onclick', 'return false;');
                countCompare.innerHTML = '0';
            }

            if (parseFloat(document.getElementById('favorites-count')?.innerHTML) > 0) {
                btnDelayOpen.classList.add('active');
            } else {
                btnDelayOpen.classList.remove('active');
            }

            // if (obCountMobileBasket) {
            //     obCountMobileBasket.innerHTML = document.getElementById('basket-count').textContent || '';
            // }
            // if (obCountMobileDelay) {
            //     obCountMobileDelay.innerHTML = document.getElementById('favorites-count').textContent || '';
            // }
            // if (obCountMobileBasket) {
            //     obCountMobileCompare.innerHTML = document.getElementById('compare-count').textContent || '';
            // }
        } catch (e) {
            console.log(e)
        }

    };
    const observerCompareBasket = new MutationObserver(changeCountBasket);

    observerCompareBasket.observe(basketLine, {
        attributes: true,
        childList: true,
        subtree: true
    });

    changeCountBasket();

    window.rightPanel = {
        closePanel: closeSidePanel,
        showOrder:  onClickBtnNav(sidePanelOrder),
        initOrder: onClickOpenOrder
    };

    function openSidePanel () {
        sidePanel.classList.add('show');
        overlay.style = "display: block";
    }

    function closeSidePanel () {
        sidePanel.classList.remove('show');
        overlay.style = "display: none";
        BX.onCustomEvent('OnBasketChange')
    }

    function closeAllItems () {
        arrPanelItems.forEach(function (item) {
            item.classList.remove('show');
        });
    }

    function onClickBtnNav (item) {
        return function (e) {
            e.preventDefault();
            openSidePanel();
            closeAllItems();
            item.classList.add('show')
        }
    }

    function onClickOpenOrder () {
        // BX.Sale.OrderAjaxComponent.sendRequest('refreshOrderAjax');
        try {
            const sidePanelMainOrder = document.querySelector('.main-order__content');
            // const orderHeaderHeight = document.querySelector('.side-panel__main-order .side-panel__main-header').offsetHeight;
            // const orderTotalBlockHeight = document.querySelector('#bx-soa-total').offsetHeight;
            // const orderContentBlock = document.querySelector('.main-order__content');
            // orderContentBlock.style.height = `calc(100% - ${orderHeaderHeight}px - ${orderTotalBlockHeight}px)`;
            // if (sidePanelMainOrder) {
            //     new PerfectScrollbar(sidePanelMainOrder,{
            //         wheelSpeed: 0.5,
            //         wheelPropagation: true,
            //         minScrollbarLength: 20
            //     });
            // }

            sidePanelMainOrder.innerHTML= '';
            const frame = document.createElement('iframe');
            frame.setAttribute('src', '/include/ajax/order_confirm.php');
            frame.setAttribute('width', '100%');
            frame.setAttribute('height', '100%');
            sidePanelMainOrder.appendChild(frame);
        } catch (e) {
            console.error(e);
        }

    }

    btnCartOpen.addEventListener('click', onClickBtnNav(sidePanelBasket));
    btnDelayOpen.addEventListener('click', onClickBtnNav(sidePanelBasket));
    if (btnAuthOpen) {
        btnAuthOpen.addEventListener('click', onClickBtnNav(sidePanelAuth));
    }
    overlay.addEventListener('click', closeSidePanel);


    window.rightPanel.auth = {

        id: "sidePanel-auth",
        popup: null,

        convertLinks: function() {
            let links = $("#" + this.id + " a");
            links.each(function (i) {
                $(this).attr('onclick', "rightPanel.auth.set('" + $(this).attr('href') + "')");
            });
            links.attr('href', '#');

            let form = $("#" + this.id + " form");
            form.attr('onsubmit', "rightPanel.auth.submit('" + form.attr('action') + "');return false;");
        },

        showAuth: function(url) {
            let app = this;
            this.popup = document.querySelector('.side-panel__main-auth');
            this.popup.innerHTML = this.getForm(url);
            app.convertLinks();
            try {
                setClassInputFilled();
            } catch (error) {
                console.warn(error);
            }
        },

        getForm: function(url) {
            let content = null;
            url += (url.includes("?") ? '&' : '?') + 'ajax_mode=Y';
            BX.ajax({
                url: url,
                method: 'GET',
                dataType: 'html',
                async: false,
                preparePost: false,
                start: true,
                processData: false,
                skipAuthCheck: true,
                onsuccess: function(data) {
                    let html = BX.processHTML(data);
                    content = data;
                    try {
                        html.SCRIPT.forEach((item) => {
                            BX.evalGlobal(
                                item.JS
                            );
                        })
                    } catch (e) {
                        console.warn(e)
                    }


                },
                onfailure: function(html, e) {
                    console.error('getForm onfailure html', html, e, this);
                }
            });
            return content;
        },

        set: function(url) {
            let form = this.getForm(url);
            this.popup.innerHTML = form;
            try {
                setClassInputFilled();
            } catch (error) {
                console.warn(error);
            }
            this.convertLinks();
            if (document.querySelector('.js-phone')) {
               $(document).ready(function () {
                   $('.js-phone').inputmask("<?//= $telMask ?>//");
               });
            }
        },
        /**
         * Отправка данных формы и получение новой формы в ответе
         * @param url - url с параметрами ссылки
         */
        submit: function(url) {
            try {
                if (url.indexOf('forgot_password') !== -1) {
                    window.USER_EMAIL.value = window.USER_LOGIN.value;
                    window.USER_LOGIN.focus();
                }
            } catch (e) {
                console.warn(e)
            }

            let app = this;
            let form = document.querySelector("#" + this.id + " form");
            let data = BX.ajax.prepareForm(form).data;
            data.ajax_mode = 'Y';
            BX.ajax({
                url: url,
                data: data,
                method: 'POST',
                preparePost: true,
                dataType: 'html',
                async: false,
                start: true,
                processData: true,
                skipAuthCheck: true,
                onsuccess: function(data) {
                    let html = BX.processHTML(data);
                    app.popup.innerHTML = html.HTML;
                    app.convertLinks();
                    try {
                        setClassInputFilled();
                    } catch (error) {
                        console.warn(error);
                    }
                },
                onfailure: function(html, e) {
                    console.error('getForm onfailure html', html, e, this);
                }
            });
        }
    };
});

