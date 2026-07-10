(function () {
    var cartApiUrl = '/include/sotbit_origami/ajax/product_cart.php';

    function initSgRedesign() {
        var menu = document.querySelector('[data-sg-menu]');
        var openBtn = document.querySelector('[data-sg-menu-open]');
        var closeBtns = document.querySelectorAll('[data-sg-menu-close]');
        var searchToggle = document.querySelector('[data-sg-search-toggle]');
        var searchPanel = document.querySelector('[data-sg-search-panel]');

        if (openBtn && menu) {
            openBtn.addEventListener('click', function () {
                menu.hidden = false;
                document.body.classList.add('sg-menu-open');
            });
        }

        closeBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (menu) {
                    menu.hidden = true;
                }
                document.body.classList.remove('sg-menu-open');
            });
        });

        if (searchToggle && searchPanel) {
            searchToggle.addEventListener('click', function () {
                var isHidden = searchPanel.hasAttribute('hidden');
                if (isHidden) {
                    searchPanel.removeAttribute('hidden');
                    var input = searchPanel.querySelector('input[type="text"]');
                    if (input) {
                        input.focus();
                    }
                } else {
                    searchPanel.setAttribute('hidden', 'hidden');
                }
            });
        }

        initSgProductCards();
        initSgCartControls();
    }

    function sgGetSessid() {
        return window.BX && typeof BX.bitrix_sessid === 'function' ? BX.bitrix_sessid() : '';
    }

    function sgCartRequest(url, payload, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.onload = function () {
            try {
                callback(null, JSON.parse(xhr.responseText));
            } catch (error) {
                callback(error);
            }
        };
        xhr.onerror = function () {
            callback(new Error('network'));
        };
        xhr.send(
            'sessid=' + encodeURIComponent(sgGetSessid()) +
            '&params=' + encodeURIComponent(JSON.stringify(payload))
        );
    }

    function sgGetBasketCartInstance() {
        var cartRoot = document.querySelector('.sg-header__basket [id^="bx_basket"]');
        if (!cartRoot || !cartRoot.id || !window[cartRoot.id]) {
            return null;
        }

        return window[cartRoot.id];
    }

    function sgPulseBasketBadge() {
        var badge = document.getElementById('basket-count');
        if (!badge) {
            return;
        }

        badge.classList.remove('sg-header__badge--pulse');
        void badge.offsetWidth;
        badge.classList.add('sg-header__badge--pulse');
    }

    function sgUpdateBasketBadge(delta) {
        var badge = document.getElementById('basket-count');
        var cartLink = document.querySelector('.sg-header__basket .header-two__basket-buy');

        if (!badge) {
            return;
        }

        var current = parseInt(badge.textContent, 10) || 0;
        var next = Math.max(0, current + delta);
        badge.textContent = String(next);

        if (cartLink) {
            if (next > 0) {
                cartLink.classList.add('active');
            } else {
                cartLink.classList.remove('active');
            }
        }

        if (delta !== 0) {
            sgPulseBasketBadge();
        }
    }

    function sgTrackBasketProduct(productId, quantity) {
        if (typeof arBasketID === 'undefined') {
            return;
        }

        var id = parseInt(productId, 10);
        var index = arBasketID.indexOf(id);

        if (quantity > 0 && index === -1) {
            arBasketID.push(id);
        }

        if (quantity <= 0 && index !== -1) {
            arBasketID.splice(index, 1);
        }
    }

    function sgNotifyBasketChange(delta) {
        if (delta) {
            sgUpdateBasketBadge(delta);
        }

        var cartInstance = sgGetBasketCartInstance();
        if (cartInstance && typeof cartInstance.refreshCart === 'function') {
            cartInstance.refreshCart({});
            return;
        }

        if (window.BX && typeof BX.onCustomEvent === 'function') {
            BX.onCustomEvent('OnBasketChange');
        }
    }

    function sgSetCartLoading(control, isLoading) {
        var addBtn = control.querySelector('[data-sg-cart-add]');
        if (!addBtn) {
            return;
        }

        var loader = addBtn.querySelector('[data-sg-cart-loader]');

        if (isLoading) {
            addBtn.classList.add('sg-product-mini__cart-btn--loading');
            addBtn.disabled = true;

            if (!loader) {
                loader = document.createElement('span');
                loader.className = 'sg-product-mini__cart-btn__loader';
                loader.setAttribute('data-sg-cart-loader', '');
                loader.setAttribute('aria-hidden', 'true');
                addBtn.appendChild(loader);
            }
            return;
        }

        addBtn.classList.remove('sg-product-mini__cart-btn--loading');
        addBtn.disabled = false;

        if (loader) {
            loader.remove();
        }
    }

    function sgRenderCartControl(control, quantity) {
        var addBtn = control.querySelector('[data-sg-cart-add]');
        var qtyPanel = control.querySelector('[data-sg-cart-qty-panel]');
        var qtyValue = control.querySelector('[data-sg-cart-qty]');
        var qty = Math.max(0, parseInt(quantity, 10) || 0);

        control.dataset.sgCartQuantity = String(qty);

        if (qty > 0) {
            if (addBtn) {
                addBtn.hidden = true;
            }
            if (qtyPanel) {
                qtyPanel.hidden = false;
            }
            if (qtyValue) {
                qtyValue.textContent = String(qty);
            }
            sgSetCartLoading(control, false);
            return;
        }

        if (addBtn) {
            addBtn.hidden = false;
        }
        if (qtyPanel) {
            qtyPanel.hidden = true;
        }
        sgSetCartLoading(control, false);
    }

    function sgSetQtyButtonsDisabled(control, disabled) {
        control.querySelectorAll('[data-sg-cart-minus], [data-sg-cart-plus]').forEach(function (btn) {
            btn.disabled = disabled;
        });
    }

    function sgChangeCartQuantity(control, nextQuantity, previousQuantity) {
        var productId = parseInt(control.getAttribute('data-product-id'), 10);
        var cartUrl = control.getAttribute('data-cart-url') || cartApiUrl;
        var prevQty = Math.max(0, parseInt(previousQuantity, 10) || 0);
        var nextQty = Math.max(0, parseInt(nextQuantity, 10) || 0);

        if (!productId) {
            return;
        }

        if (nextQty === prevQty) {
            return;
        }

        if (nextQty === 0) {
            sgRenderCartControl(control, 0);
        } else if (prevQty === 0) {
            sgSetCartLoading(control, true);
        } else {
            sgSetQtyButtonsDisabled(control, true);
            sgRenderCartControl(control, nextQty);
        }

        sgCartRequest(cartUrl, {
            action: 'change',
            id: productId,
            quantity: nextQty
        }, function (error, result) {
            if (error || !result || result.STATUS !== 'OK') {
                sgRenderCartControl(control, prevQty);
                sgSetQtyButtonsDisabled(control, false);
                return;
            }

            var quantity = Math.max(0, parseInt(result.QUANTITY, 10) || 0);
            sgRenderCartControl(control, quantity);
            sgSetQtyButtonsDisabled(control, false);
            sgTrackBasketProduct(productId, quantity);
            sgNotifyBasketChange(quantity - prevQty);
        });
    }

    function sgAddToCart(control) {
        var productId = parseInt(control.getAttribute('data-product-id'), 10);
        var cartUrl = control.getAttribute('data-cart-url') || cartApiUrl;
        var previousQuantity = parseInt(control.dataset.sgCartQuantity || '0', 10) || 0;

        if (!productId || previousQuantity > 0) {
            return;
        }

        sgSetCartLoading(control, true);

        sgCartRequest(cartUrl, {
            action: 'add',
            id: productId,
            step: 1
        }, function (error, result) {
            if (error || !result || result.STATUS !== 'OK') {
                sgRenderCartControl(control, 0);
                return;
            }

            var quantity = Math.max(0, parseInt(result.QUANTITY, 10) || 0);
            sgRenderCartControl(control, quantity);
            sgTrackBasketProduct(productId, quantity);
            sgNotifyBasketChange(quantity - previousQuantity);
        });
    }

    function sgLoadCartStates() {
        var controls = document.querySelectorAll('[data-sg-cart-control]');
        if (!controls.length) {
            return;
        }

        var ids = [];
        controls.forEach(function (control) {
            var productId = parseInt(control.getAttribute('data-product-id'), 10);
            if (!productId) {
                return;
            }

            ids.push(productId);

            if (typeof arBasketID !== 'undefined' && arBasketID.indexOf(productId) !== -1) {
                sgRenderCartControl(control, 1);
            } else {
                sgRenderCartControl(control, 0);
            }
        });

        if (!ids.length) {
            return;
        }

        var cartUrl = controls[0].getAttribute('data-cart-url') || cartApiUrl;

        sgCartRequest(cartUrl, {
            action: 'state',
            ids: ids
        }, function (error, result) {
            if (error || !result || result.STATUS !== 'OK' || !result.ITEMS) {
                return;
            }

            controls.forEach(function (control) {
                var productId = parseInt(control.getAttribute('data-product-id'), 10);
                if (!productId) {
                    return;
                }

                var rawQuantity = result.ITEMS[productId];
                if (rawQuantity === undefined) {
                    rawQuantity = result.ITEMS[String(productId)];
                }
                if (rawQuantity === undefined) {
                    return;
                }

                var quantity = Math.max(0, parseInt(rawQuantity, 10) || 0);
                sgRenderCartControl(control, quantity);
                sgTrackBasketProduct(productId, quantity);
            });
        });
    }

    function initSgCartControls() {
        document.addEventListener('click', function (event) {
            var addBtn = event.target.closest('[data-sg-cart-add]');
            if (addBtn) {
                event.preventDefault();
                var control = addBtn.closest('[data-sg-cart-control]');
                if (control) {
                    sgAddToCart(control);
                }
                return;
            }

            var plusBtn = event.target.closest('[data-sg-cart-plus]');
            if (plusBtn) {
                event.preventDefault();
                var plusControl = plusBtn.closest('[data-sg-cart-control]');
                if (!plusControl) {
                    return;
                }
                var currentQty = parseInt(plusControl.dataset.sgCartQuantity || '0', 10) || 0;
                sgChangeCartQuantity(plusControl, currentQty + 1, currentQty);
                return;
            }

            var minusBtn = event.target.closest('[data-sg-cart-minus]');
            if (minusBtn) {
                event.preventDefault();
                var minusControl = minusBtn.closest('[data-sg-cart-control]');
                if (!minusControl) {
                    return;
                }
                var qty = parseInt(minusControl.dataset.sgCartQuantity || '0', 10) || 0;
                if (qty <= 1) {
                    sgChangeCartQuantity(minusControl, 0, qty);
                } else {
                    sgChangeCartQuantity(minusControl, qty - 1, qty);
                }
            }
        });

        if (window.BX && typeof BX.ready === 'function') {
            BX.ready(sgLoadCartStates);
        } else if (document.readyState === 'complete') {
            sgLoadCartStates();
        } else {
            window.addEventListener('load', sgLoadCartStates, { once: true });
        }
    }

    function initSgProductCards() {
        var cards = document.querySelectorAll('.sg-product-mini');
        if (!cards.length || !('IntersectionObserver' in window)) {
            return;
        }

        var desktopQuery = window.matchMedia('(min-width: 992px)');

        if (desktopQuery.matches) {
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                var card = entry.target;
                if (card.dataset.sgFadeScheduled) {
                    return;
                }

                card.dataset.sgFadeScheduled = '1';
                window.setTimeout(function () {
                    card.classList.add('sg-product-mini--muted');
                }, 3000);
            });
        }, { threshold: 0.3 });

        cards.forEach(function (card) {
            observer.observe(card);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSgRedesign);
    } else {
        initSgRedesign();
    }
})();
