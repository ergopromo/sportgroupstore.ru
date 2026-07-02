<?

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss(SITE_DIR . "include/sotbit_origami/files/cookie-banner/style.css");
Asset::getInstance()->addJs(SITE_DIR . "include/sotbit_origami/files/cookie-banner/script.js");
?>

<script>
(function () {
    try {
        var consent = localStorage.getItem('sgs_cookie_consent');
        if (consent === 'accepted' || consent === 'rejected') {
            document.documentElement.setAttribute('data-cookie-consent', consent);
        }
    } catch (e) {}
})();
</script>

<div class="cookie-banner" id="cookie-banner" role="dialog" aria-live="polite" aria-label="Уведомление об использовании cookie">
    <div class="cookie-banner__inner">
        <p class="cookie-banner__text fonts__main_comment">
            Мы используем файлы cookie для улучшения работы сайта, персонализации контента и анализа трафика.
            Продолжая пользоваться сайтом, вы соглашаетесь с их использованием.
            <a class="cookie-banner__link" href="<?= SITE_DIR ?>help/confidentiality/">Политика конфиденциальности</a>
        </p>
        <div class="cookie-banner__actions">
            <button type="button" class="cookie-banner__btn cookie-banner__btn--reject" id="cookie-banner-reject">
                Отклонить
            </button>
            <button type="button" class="cookie-banner__btn btn btn-primary" id="cookie-banner-accept">
                Принять
            </button>
        </div>
    </div>
</div>
