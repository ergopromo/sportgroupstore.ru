(function () {
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
        initSgAddToCart();
    }

    function initSgAddToCart() {
        document.addEventListener('click', function (event) {
            var btn = event.target.closest('[data-sg-add-to-cart]');
            if (!btn || btn.disabled) {
                return;
            }

            event.preventDefault();

            var productId = btn.getAttribute('data-product-id');
            var cartUrl = btn.getAttribute('data-cart-url') || '/include/ajax/buy.php';

            if (!productId) {
                return;
            }

            btn.disabled = true;

            var payload = {
                id: productId,
                qnt: 1,
                action: 'add',
                props: null
            };

            var xhr = new XMLHttpRequest();
            xhr.open('POST', cartUrl);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xhr.onload = function () {
                btn.disabled = false;

                try {
                    var result = JSON.parse(xhr.responseText);
                    if (result.STATUS === 'OK' && window.BX && typeof BX.onCustomEvent === 'function') {
                        BX.onCustomEvent('OnBasketChange');
                    }
                } catch (error) {
                    // ignore parse errors
                }
            };
            xhr.onerror = function () {
                btn.disabled = false;
            };
            xhr.send('params=' + encodeURIComponent(JSON.stringify(payload)));
        });
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
