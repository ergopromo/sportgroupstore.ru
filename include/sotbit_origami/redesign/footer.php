<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Sotbit\Origami\Helper\Config;

$siteDir = SITE_DIR;
$year = date('Y');

$catalogLinks = [
    ['label' => 'Протеины', 'href' => $siteDir . 'catalog/sportivnoe-pitanie/proteins/'],
    ['label' => 'Гейнеры', 'href' => $siteDir . 'catalog/sportivnoe-pitanie/geiner/'],
    ['label' => 'Предтреники', 'href' => $siteDir . 'catalog/sportivnye-dobavki/predtrenirovochnyy-kompleks/'],
    ['label' => 'Аминокислоты', 'href' => $siteDir . 'catalog/sportivnye-dobavki/aminokislotnyy-kompleks/'],
    ['label' => 'Изотоники', 'href' => $siteDir . 'catalog/sportivnoe-pitanie/'],
    ['label' => 'Добавки', 'href' => $siteDir . 'catalog/sportivnye-dobavki/'],
    ['label' => 'Витамины', 'href' => $siteDir . 'catalog/sportivnye-dobavki/'],
    ['label' => 'Аксессуары', 'href' => $siteDir . 'catalog/turisticheskaya-posuda/'],
];

$infoLinks = [
    ['label' => 'О компании', 'href' => $siteDir . 'about/'],
    ['label' => 'Акции', 'href' => $siteDir . 'promotions/'],
    ['label' => 'Новости', 'href' => $siteDir . 'news/'],
    ['label' => 'Блог', 'href' => $siteDir . 'blog/'],
    ['label' => 'Энциклопедия', 'href' => $siteDir . 'about/'],
];

$docLinks = [
    ['label' => 'Публичная оферта', 'href' => $siteDir . 'help/oferta/'],
    ['label' => 'Политика конфиденциальности', 'href' => $siteDir . 'help/confidentiality/'],
    ['label' => 'Правила продажи', 'href' => $siteDir . 'help/rules/'],
    ['label' => 'Условия доставки', 'href' => $siteDir . 'about/delivery/'],
    ['label' => 'Условия оплаты', 'href' => $siteDir . 'help/payment/'],
];

$vkLink = Config::get('VK');
$tgLink = Config::get('TELEGA');
?>
<footer class="sg-footer">
    <div class="sg-footer__inner">
        <div class="sg-footer__columns">
            <div class="sg-footer__brand">
                <a href="<?= $siteDir ?>" class="sg-footer__logo-link" aria-label="СПОРТГРУПП">
                    <img
                        class="sg-footer__logo"
                        src="<?= $siteDir ?>include/sotbit_origami/redesign/footer-logo.svg"
                        alt="СПОРТГРУПП"
                        width="100"
                        height="95"
                        loading="lazy"
                    >
                </a>
                <p class="sg-footer__tagline">
                    Спортивное питание<br>
                    с проверенными составами<br>
                    и честными описаниями.
                </p>
                <?php if ($vkLink || $tgLink): ?>
                    <div class="sg-footer__socials">
                        <div class="sg-footer__socials-wrap">
                            <img
                                class="sg-footer__socials-img"
                                src="<?= $siteDir ?>include/sotbit_origami/redesign/footer-socials.svg"
                                alt=""
                                width="105"
                                height="20"
                                loading="lazy"
                                aria-hidden="true"
                            >
                            <?php if ($tgLink): ?>
                                <a
                                    class="sg-footer__social-hit sg-footer__social-hit--tg"
                                    href="<?= htmlspecialcharsbx($tgLink) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="Telegram"
                                ></a>
                            <?php endif; ?>
                            <?php if ($vkLink): ?>
                                <a
                                    class="sg-footer__social-hit sg-footer__social-hit--vk"
                                    href="<?= htmlspecialcharsbx($vkLink) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="ВКонтакте"
                                ></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="sg-footer__col">
                <p class="sg-footer__title">Каталог</p>
                <ul class="sg-footer__links">
                    <?php foreach ($catalogLinks as $item): ?>
                        <li><a href="<?= htmlspecialcharsbx($item['href']) ?>"><?= htmlspecialcharsbx($item['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="sg-footer__col">
                <p class="sg-footer__title">Информация</p>
                <ul class="sg-footer__links">
                    <?php foreach ($infoLinks as $item): ?>
                        <li><a href="<?= htmlspecialcharsbx($item['href']) ?>"><?= htmlspecialcharsbx($item['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="sg-footer__col">
                <p class="sg-footer__title">Документы</p>
                <ul class="sg-footer__links">
                    <?php foreach ($docLinks as $item): ?>
                        <li><a href="<?= htmlspecialcharsbx($item['href']) ?>"><?= htmlspecialcharsbx($item['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="sg-footer__col sg-footer__col--contacts">
                <p class="sg-footer__title">Контакты</p>
                <div class="sg-footer__contacts">
                    <a class="sg-footer__phone" href="tel:+79117385438">+7 911 738-54-38</a>
                    <a href="mailto:sales@sportgroupstore.ru">sales@sportgroupstore.ru</a>
                    <a href="mailto:sportgroup777@gmail.com">sportgroup777@gmail.com</a>
                    <span>Пн–Пт 10:00–18:00</span>
                    <span class="sg-footer__address">Санкт-Петербург, 9-я Советская ул., д. 4–6, Лит. А, офис № 412</span>
                </div>
            </div>
        </div>

        <div class="sg-footer__divider" aria-hidden="true"></div>

        <div class="sg-footer__bar">
            <p class="sg-footer__copy">© <?= $year ?> OOO «СПОРТГРУПП». Все права защищены.</p>
            <div class="sg-footer__payments" aria-label="Способы оплаты">
                <span>Visa</span>
                <span>Mastercard</span>
                <span>МИР</span>
            </div>
        </div>
    </div>
</footer>
