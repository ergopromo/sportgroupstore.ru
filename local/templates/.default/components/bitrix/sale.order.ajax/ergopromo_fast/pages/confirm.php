<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 */

if ($arParams['SET_TITLE'] == 'Y') {
    $APPLICATION->SetTitle(Loc::getMessage('SOA_ORDER_COMPLETE'));
}
?>

<div class="bx-soa-page bx-soa-page-confirm row" style="display: flex; justify-content: center; text-align: center;">
    <?php if (!empty($arResult["ORDER"])): ?>
        <div class="col-md-8">
            <p style="font-size: 18px; line-height: 1.6;">
                Ваш заказ <b>№<?= htmlspecialcharsbx($arResult["ORDER"]["ACCOUNT_NUMBER"]) ?></b>
                от <?= htmlspecialcharsbx($arResult["ORDER"]["DATE_INSERT_FORMATED"]) ?> успешно создан.<br>
                После подтверждения заказа менеджером у вас появится возможность оплатить товары
                в личном кабинете в разделе
                <a href="/personal/order/" style="color: #007bff; text-decoration: underline;">Мои заказы</a>.
            </p>
        </div>
    <?php else: ?>
        <div class="col-md-8">
            <h2><?= Loc::getMessage("SOA_ORDER_COMPLETE") ?></h2>
            <p><?= Loc::getMessage("SOA_ERROR_ORDER") ?></p>
        </div>
    <?php endif; ?>
</div>

<style>
    .order-confirm{width:100%;max-width:1024px;margin:0 auto;padding:24px}
    .order-confirm--center{min-height:220px;display:flex;align-items:center;justify-content:center;gap:20px;text-align:center}
    .order-confirm__icon{flex:0 0 80px}
    .order-confirm__icon img{display:block;width:80px;height:80px}
    .order-confirm__text{font-size:18px;line-height:1.5}
    @media (max-width:768px){
        .order-confirm--center{flex-direction:column;gap:16px;padding:8px}
        .order-confirm__text{font-size:16px}
        .order-confirm__icon{flex:0 0 64px}
        .order-confirm__icon img{width:64px;height:64px}
    }
</style>
