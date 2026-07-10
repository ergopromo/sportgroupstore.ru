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
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSgRedesign);
    } else {
        initSgRedesign();
    }
})();
