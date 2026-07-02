<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $frame = $this->createFrame()->begin();
global $APPLICATION;
global $USER;
if (!is_object($USER)) $USER = new CUser;
?>
<div class="reviews-filter"
     data-url="<?= $APPLICATION->GetCurPage() ?>"
     data-max-rating="<?= $arParams["MAX_RATING"] ?>"
     data-id-element="<?= $arParams["ID_ELEMENT"] ?>"
     data-site-dir="<?= SITE_DIR ?>"
     data-template="<?= $templateName ?>">
    <div class="reviews-filter__filter-rating">
        <div class="reviews-filter__title">
            <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_FILTER") ?>
        </div>
        <div id="select-rating" class="select-rating-close">
            <div id="current-option-select-rating" class="reviews-filter__filter-sort-orop" data-value="<?= $arResult['FILTER_REVIEWS_VALUE'] ?>">
                <span class="current-option-select-rating-span"><?= $arResult['FILTER_REVIEWS_TITLE'] ?></span>
                <span class="toggle-icon"></span>
            </div>
            <ul id="custom-options-select-rating" class="reviews-filter__rating-select rating-select">
                <li class="rating-select__item" data-value="-1">
                    <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_FILTER_GENERAL_RATING") ?>
                    (<?= $arResult['SUM_CNT_REVIEWS'] ?>)
                </li>
                <? for ($i = 1; $i <= $arParams["MAX_RATING"]; ++$i): ?>
                    <li class="rating-select__item" data-value="<?= $i ?>">
						<span class="reviews-filter__stars-rating">
						<? for ($k = 1; $k <= $i; ++$k): ?>
                            <svg class="reviews-filter__rating-stars-icon"
                                 width="14"
                                 height="13">
                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_star"></use>
                            </svg>
                        <? endfor; ?>
                            <? for ($a = $k; $a <= $arParams["MAX_RATING"]; ++$a): ?>
                                <svg class="reviews-filter__rating-stars-icon reviews-filter__rating-stars-icon_empty"
                                     width="14"
                                     height="13">
                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_star"></use>
                            </svg>
                            <? endfor; ?>
						</span>
                        (<?= $arResult['CNT_REVIEW'][$i] ?>)
                    </li>
                <? endfor; ?>
            </ul>
        </div>
        <? if (COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_UPLOAD_IMAGE_" . SITE_ID, "") == 'Y'): ?>
            <div class="main_checkbox">
                <input type="checkbox"
                       id="filter-images"
                       class="checkbox__input"
                    <?= ($arResult['SORT_IMAGES'] == "Y") ? "checked" : "" ?>
                       data-value="N"
                       name="personal">
                <label for="filter-images">
                    <span></span>
                    <span>
                    <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_FILTER_PHOTO") ?>
                (<?= $arResult['CNT_PIC'] ?>)
                </span>
                </label>
            </div>
        <? endif; ?>
    </div>
    <div class="reviews-filter__filter-sort-by">
        <div class="filter-sort-text"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_FILTER_SORT_TEXT") ?></div>
        <div id="select-sort" class="select-sort-close">
            <div class="reviews-filter__filter-sort-orop" id="current-option-select-sort" data-sort-by="<?= $arResult['BY'] ?>"
                 data-sort-order="<? $arResult['ORDER'] ?>">
                <span class="reviews-filter__selected-text"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_SORT_" . $arResult['TITLE']) ?></span>
                <span class="toggle-icon"></span>
            </div>
            <ul class="reviews-filter__rating-select rating-select" id="custom-options-select-sort">
                <li class="rating-select__item" data-sort-by="DATE_CREATION"
                    data-sort-order="desc"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_SORT_NEW") ?></li>
                <li class="rating-select__item" data-sort-by="DATE_CREATION"
                    data-sort-order="asc"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_SORT_OLD") ?></li>
                <li class="rating-select__item" data-sort-by="RATING"
                    data-sort-order="desc"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_SORT_HIGH_RATING") ?></li>
                <li class="rating-select__item" data-sort-by="RATING"
                    data-sort-order="asc"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_SORT_LOW_RATING") ?></li>
                <li class="rating-select__item" data-sort-by="LIKES"
                    data-sort-order="desc"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_SORT_LIKES") ?></li>
            </ul>
        </div>
    </div>
</div>
<? $frame->end(); ?>
