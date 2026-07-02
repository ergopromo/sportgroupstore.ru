<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

?>
<? $frame = $this->createFrame()->begin();
global $APPLICATION;
global $USER;
if (!is_object($USER)) $USER = new CUser;
?>
<div class="product-rating">
    <div class="product-rating__col rating__stars-col">
        <h3 class="product-rating__title"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_HEADER_TITLE2") ?></h3>
        <div class="product-rating__stars-container">
            <span class="product-rating__middle"><?= $arResult['MID_REVIEW'] ?: '0.0' ?></span>
            <div class="product-rating__icons-container-resizer">
                <div class="product-rating__icons-container">
                    <div class="product-rating__icons-wrapper">
                        <? for ($i = 1; $i <= 5; ++$i): ?>
                            <svg class="product-rating__icon" width="25" height="24">
                                <use
                                    xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_star"></use>
                            </svg>
                        <? endfor; ?>
                    </div>
                    <div class="product-rating__icons-wrapper product-rating__icons-wrapper_yellow"
                         style="width:<?= $arResult['MID_REVIEW_PROC'] ?: 0 ?>%">
                        <? for ($i = 1; $i <= 5; ++$i): ?>
                            <svg class="product-rating__icon product-rating__icon_yellow" width="25" height="24">
                                <use
                                    xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_star"></use>
                            </svg>
                        <? endfor; ?>
                    </div>
                </div>
            </div>
        </div>
        <p class="reviews-medium-rating">
            <? if ($arResult['SUM_CNT_REVIEWS']) : ?>
                <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_HEADER_FIXED") ?> <?= $arResult['SUM_CNT_REVIEWS'] ?> <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_HEADER_FIXED2") ?>
            <? else: ?>
                <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_NO_REVIEW_TITLE1") ?>
            <? endif; ?>
        </p>
    </div>
    <div class="product-rating__col rating__lines-col">
        <div class="review-line">
            <div class="review-line__text">
                <? for ($i = $arParams["MAX_RATING"]; $i >= 1; --$i): ?>
                    <span
                        class="review-line__text-item"><?= $i ?> <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_HEADER_STAR" . $arResult['TRANSLATE_REVIEW'][$i]) ?></span>
                <? endfor; ?>
            </div>
            <div class="review-line__lines-container">
                <? for ($i = $arParams["MAX_RATING"]; $i >= 1; --$i): ?>
                    <div class="review-line__empty-line-wrapper">
                        <div class="review-line__empty-line">
                            <div class="review-line__filled-line"
                                 style="width:<?= $arResult['PROC_REVIEWS'][$i] ?>%;">
                            </div>
                        </div>
                    </div>
                <? endfor; ?>
            </div>
            <div class="review-line__reviews-counter">
                <? for ($i = $arParams["MAX_RATING"]; $i >= 1; --$i): ?>
                    <span class="review-line__reviews-counter-item"><?= $arResult['CNT_REVIEW'][$i] ?></span>
                <? endfor; ?>
            </div>
        </div>
    </div>
    <div class="product-rating__col rating__button-col">
        <div>
            <button class="main_btn product-rating__write-review"><?= Loc::getMessage('SOTBIT_WRITE_REVIEW')?></button>
        </div>
    </div>
</div>
<? $frame->end(); ?>
