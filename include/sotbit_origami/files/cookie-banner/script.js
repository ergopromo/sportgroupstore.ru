(function () {
    var STORAGE_KEY = 'sgs_cookie_consent';

    function hideBanner(banner, consent) {
        banner.classList.add('cookie-banner--hidden');
        document.documentElement.setAttribute('data-cookie-consent', consent);
    }

    function saveConsent(banner, consent) {
        try {
            localStorage.setItem(STORAGE_KEY, consent);
        } catch (e) {}

        hideBanner(banner, consent);
    }

    function initCookieBanner() {
        var banner = document.getElementById('cookie-banner');
        var acceptBtn = document.getElementById('cookie-banner-accept');
        var rejectBtn = document.getElementById('cookie-banner-reject');
        var consent = document.documentElement.getAttribute('data-cookie-consent');

        if (!banner || !acceptBtn || !rejectBtn) {
            return;
        }

        if (consent === 'accepted' || consent === 'rejected') {
            hideBanner(banner, consent);
            return;
        }

        acceptBtn.addEventListener('click', function () {
            saveConsent(banner, 'accepted');
        });

        rejectBtn.addEventListener('click', function () {
            saveConsent(banner, 'rejected');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCookieBanner);
    } else {
        initCookieBanner();
    }
})();
