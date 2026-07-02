(function () {
    var STORAGE_KEY = 'sgs_cookie_consent';

    function hideBanner(banner) {
        banner.classList.add('cookie-banner--hidden');
        document.documentElement.setAttribute('data-cookie-consent', 'accepted');
    }

    function acceptCookies(banner) {
        try {
            localStorage.setItem(STORAGE_KEY, 'accepted');
        } catch (e) {}

        hideBanner(banner);
    }

    function initCookieBanner() {
        var banner = document.getElementById('cookie-banner');
        var acceptBtn = document.getElementById('cookie-banner-accept');

        if (!banner || !acceptBtn) {
            return;
        }

        if (document.documentElement.getAttribute('data-cookie-consent') === 'accepted') {
            hideBanner(banner);
            return;
        }

        acceptBtn.addEventListener('click', function () {
            acceptCookies(banner);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCookieBanner);
    } else {
        initCookieBanner();
    }
})();
