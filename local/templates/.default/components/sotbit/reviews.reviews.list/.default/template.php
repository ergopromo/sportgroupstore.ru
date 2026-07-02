<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$frame = $this->createFrame()->begin();
global $APPLICATION;
global $USER;
?>
<div class="reviews-container" data-items-count="<?= $arResult["REVIEWS_FILTER_CNT"] ?>"
     data-date-format="<?= $arParams['DATE_FORMAT'] ?>">
    <? if (isset($arResult['REVIEWS']) && is_array($arResult['REVIEWS'])) { ?>
        <? foreach ($arResult['REVIEWS'] as $Review) { ?>
            <div data-id="<?= $Review['ID'] ?>" data-site-dir="<?= SITE_DIR ?>" class="reviews-container__item"
                 id="review-<?= $Review['ID'] ?>" itemscope itemtype="http://schema.org/Review">
                <div class="reviews-container__header">

                    <div class="reviews-container__avatar-container">
                        <div class="reviews-container__avatar-overflow-wrapper">
                            <svg class="reviews-container__avatar-no-image" width="18" height="20">
                                <use
                                    xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_authorized_medium"></use>
                            </svg>
                        </div>
                        <? if ($arResult['MODERATOR'] == 'Y') {
                            ?>
                            <div class="reviews-container__ban-user" data-action="ban">
                                <div class="reviews-container__ban ban-menu">
                                    <div
                                        class="message ban-menu__message-success"><?= GetMessage(CSotbitReviews::iModuleID . "_BAN_USER_SUCCESS") ?></div>
                                    <div
                                        class="message ban-menu__message-error"><?= GetMessage(CSotbitReviews::iModuleID . "_BAN_USER_ERROR") ?></div>
                                    <div style="display:none">
                                        <?= GetMessage(CSotbitReviews::iModuleID . "_BAN_USER_CONFIRM") ?>
                                    </div>
                                </div>
                                <svg class="reviews-container__ban-user-icon" width="10" height="10">
                                    <use
                                        xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_no_product"></use>
                                </svg>
                            </div>
                        <? } ?>
                    </div>
                    <div class="reviews-container__user-info-container">
                        <div class="reviews-container__user-info">
                            <? if ($Review['NAME']): ?>
                                <span class="reviews-container__user-name">
                                            <?= $Review['NAME'] ?>
                                        </span>
                            <? endif; ?>
                            <span class="reviews-container__user-reviews-number">
                            <? if ($Review['ID_USER'] > 0): ?>

                                <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_CNT_USER") ?>

                                <? if (isset($arResult['LINK_TO_USER'][$Review['ID_USER']]) && !empty($arResult['LINK_TO_USER'][$Review['ID_USER']])): ?>
                                    <a href="<?= $arResult['LINK_TO_USER'][$Review['ID_USER']] ?>"> <?= $arResult['USER_REVIEWS_CNT'][$Review['ID_USER']] ?></a>
                                <? else: ?>
                                    <?= $arResult['USER_REVIEWS_CNT'][$Review['ID_USER']] ?>
                                <? endif; ?>

                            <? endif; ?>
                            </span>
                        </div>

                        <div class="reviews-container__date-stars-wrapper">
                            <div class="reviews-container__rating-stars">
                                <? for ($i = 1; $i <= $arParams["MAX_RATING"]; ++$i): ?>
                                    <svg
                                        class="reviews-container__rating-stars-icon <?= ($i <= $Review['RATING']) ? 'reviews-container__rating-stars-icon_full' : 'reviews-container__rating-stars-icon_empty' ?>"
                                        width="14" height="13">
                                        <use
                                            xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_star"></use>
                                    </svg>
                                <? endfor; ?>
                            </div>
                            <div class="reviews-container__date" itemprop="datePublished">
                                <?= $Review['DATE_CREATION']; ?>
                            </div>
                        </div>
                    </div>
                    <? if (isset($Review['RECOMMENDATED']) && $Review['RECOMMENDATED'] == 'Y'): ?>
                        <div class="reviews-container__recommendated">
                            <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_I_RECOMMENDATED") ?>
                        </div>
                    <? endif; ?>
                </div>
                <div class="reviews-container__body revirew-body">
                    <? if (COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_TITLE_" . SITE_ID, "") == 'Y'): ?>
                        <p class="revirew-body__title"><?= $Review['TITLE'] ?></p>
                    <? endif; ?>

                    <div class="revirew-body__content text" itemprop="reviewBody"><?= $Review['TEXT'] ?></div>

                    <? if (COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_UPLOAD_IMAGE_" . SITE_ID, "") == 'Y'): ?>
                        <? if (isset($Review['THUMB_IMAGE']) && is_array($Review['THUMB_IMAGE'])): ?>
                            <ul class="revirew-body__images-wrapper">
                                <? foreach ($Review['THUMB_IMAGE'] as $key => $image): ?>
                                    <a href="<?= $Review['BIG_IMAGE'][$key] ?>"
                                       class="revirew-body__image-link" rel="<?= $Review['ID'] ?>">
                                        <img src="<?= $image ?>" class="revirew-body__image">
                                    </a>
                                <? endforeach; ?>
                            </ul>
                        <? endif; ?>
                    <? endif; ?>

                    <? if (COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_MULTIMEDIA_VIDEO_ALLOW_" . SITE_ID, "") == 'Y' && isset($Review['MULTIMEDIA']['VIDEO']) && !empty($Review['MULTIMEDIA']['VIDEO'])): ?>
                        <div>
                            <p class="video-title"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_VIDEO_TITLE"); ?></p>
                            <div class="reviews-container__iframe-container">
                                <div class="reviews-container__iframe">
                                    <?= $Review['MULTIMEDIA']['VIDEO'] ?>
                                </div>
                            </div>
                        </div>
                    <? endif; ?>
                    <? if (COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_MULTIMEDIA_PRESENTATION_ALLOW_" . SITE_ID, "") == 'Y' && isset($Review['MULTIMEDIA']['PRESENTATION']) && !empty($Review['MULTIMEDIA']['PRESENTATION'])): ?>
                        <div>
                            <p class="presentation-title"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_PRESENTATION_TITLE"); ?></p>
                            <div class="reviews-container__iframe-container">
                                <div class="reviews-container__iframe">
                                    <?= $Review['MULTIMEDIA']['PRESENTATION'] ?>
                                </div>
                            </div>
                        </div>
                    <? endif; ?>
                    <? if (isset($Review['ADD_FIELDS']) && is_array($Review['ADD_FIELDS'])): ?>
                        <? foreach ($Review['ADD_FIELDS'] as $key => $value): ?>
                            <? if (isset($value) && !empty($value)): ?>
                                <p class="add-field-title <?= $key ?>"><?= (isset($arResult['ADD_FIELDS'][$key]['TITLE']) && !empty($arResult['ADD_FIELDS'][$key]['TITLE'])) ? $arResult['ADD_FIELDS'][$key]['TITLE'] : GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_ADD_FIELD_TITLE_" . $key) ?></p>
                                <p class="add-field-text <?= $key ?>"><?= CSotbitReviews::bb2html($value) ?></p>
                            <? endif; ?>
                        <? endforeach; ?>
                    <? endif; ?>
                    <div class="reviews-container__footer">
                        <? if (COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_EDITOR_" . SITE_ID, "") == "Y" && COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_QUOTS_" . SITE_ID, "") == "Y" && ($USER->IsAuthorized() || COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_REGISTER_USERS_" . SITE_ID, "") != 'Y')): ?>
                            <div class="reviews-container__footer-item wrap-quote reviews-container__footer-item_quote">
                                <div class="quote">
                                    <?= GetMessage(CSotbitReviews::iModuleID . '_REVIEWS_QUOTE') ?>
                                </div>
                            </div>
                        <? endif; ?>
                        <div class="reviews-container__footer-item reviews-container__footer-item_share">
                            <? $APPLICATION->IncludeComponent(
                                "sotbit:reviews.share",
                                "",
                                array(
                                    "TITLE" => (isset($Review['TITLE']) && !empty($Review['TITLE'])) ? $Review['TITLE'] : '',
                                    "URL" => $arResult['ELEMENT']['DETAIL_PAGE_URL'],
                                    "PICTURE" => $Review['SHARE_IMAGE'],
                                    "TEXT" => $Review['TEXT'],
                                    "SERVICES" => $arResult['SHARE_SERVICES'],
                                    "FACEBOOK_APP_ID" => $arResult['FACEBOOK_APP_ID'],
                                    "SHARE_LINK" => $arResult['ELEMENT']['DETAIL_PAGE_URL'] . '#review-' . $Review['ID'],
                                    "LINK_TITLE" => GetMessage(CSotbitReviews::iModuleID . "_LINK_TITLE_REVIEWS")
                                ),
                                false
                            ); ?>
                        </div>
                        <div class="reviews-container__footer-item review-likes"
                             data-review-id="<?= $Review['ID'] ?>"
                             data-site-dir="<?= SITE_DIR ?>">
                            <span class="review-likes__vote review-likes__vote_like review-likes__vote_send-yes
                            <?= (isset($Review['ID'])
                                && !empty($Review['ID'])
                                && isset($_COOKIE['LIKES'])
                                && is_array($_COOKIE['LIKES'])
                                && in_array($Review['ID'], $_COOKIE['LIKES'])) ? 'review-likes__vote_voted-yes' : 'review-likes__vote_send-yes'; ?>"
                            >
                                <svg class="review-likes__like" width="22" height="21">
                                            <use
                                                xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_like"></use>
                                        </svg>
                                <span class="reviews-container__likes-number"><?= $Review['LIKES'] ?></span>
                            </span>
                            <span class="review-likes__vote review-likes__vote_dislike <?= (isset($Review['ID'])
                                && !empty($Review['ID'])
                                && isset($_COOKIE['DISLIKES'])
                                && is_array($_COOKIE['DISLIKES'])
                                && in_array($Review['ID'], $_COOKIE['DISLIKES'])) ? 'review-likes__vote_voted-no' : 'review-likes__vote_send-no' ?>"
                            >
                                <svg class="review-likes__like review-likes__like_dislike" width="22"
                                     height="21">
                                            <use
                                                xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_like"></use>
                                        </svg>
                                <span class="reviews-container__likes-number"><?= $Review['DISLIKES'] ?></span>
                            </span>
                        </div>
                    </div>
                </div>
                <? if (isset($Review['ANSWER']) && !empty($Review['ANSWER'])): ?>
                    <div class="reviews-container__answer">
                        <div class="reviews-container__header">
                            <div class="reviews-container__avatar-container">
                                <div class="reviews-container__avatar-overflow-wrapper">
                                    <svg class="reviews-container__avatar-no-image" width="18" height="20">
                                        <use
                                            xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_authorized_medium"></use>
                                    </svg>
                                </div>
                                <? if ($arResult['MODERATOR'] == 'Y') {
                                    ?>
                                    <div class="reviews-container__ban-user" data-action="ban">
                                        <div class="reviews-container__ban ban-menu">
                                            <div
                                                class="message ban-menu__message-success"><?= GetMessage(CSotbitReviews::iModuleID . "_BAN_USER_SUCCESS") ?></div>
                                            <div
                                                class="message ban-menu__message-error"><?= GetMessage(CSotbitReviews::iModuleID . "_BAN_USER_ERROR") ?></div>
                                            <div style="display:none">
                                                <?= GetMessage(CSotbitReviews::iModuleID . "_BAN_USER_CONFIRM") ?>
                                            </div>
                                        </div>
                                        <svg class="reviews-container__ban-user-icon" width="10" height="10">
                                            <use
                                                xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_no_product"></use>
                                        </svg>
                                    </div>
                                <? } ?>
                            </div>
                            <div class="reviews-container__user-info-container">
                                <div class="reviews-container__user-info">
                                    <? if ($Review['NAME']): ?>
                                        <span class="reviews-container__user-name">
                                            <?= $Review['NAME'] ?>
                                        </span>
                                    <? endif; ?>
                                    <span class="reviews-container__user-reviews-number">
                                    <? if ($Review['ID_USER'] > 0): ?>

                                        <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_CNT_USER") ?>

                                        <? if (isset($arResult['LINK_TO_USER'][$Review['ID_USER']]) && !empty($arResult['LINK_TO_USER'][$Review['ID_USER']])): ?>
                                            <a href="<?= $arResult['LINK_TO_USER'][$Review['ID_USER']] ?>"> <?= $arResult['USER_REVIEWS_CNT'][$Review['ID_USER']] ?></a>
                                        <? else: ?>
                                            <?= $arResult['USER_REVIEWS_CNT'][$Review['ID_USER']] ?>
                                        <? endif; ?>

                                    <? endif; ?>
                                    </span>
                                </div>

                                <div class="reviews-container__date-stars-wrapper">
                                    <div class="reviews-container__date" itemprop="datePublished">
                                        <?= $Review['DATE_CREATION']; ?>
                                    </div>
                                </div>
                            </div>
                            <? if (isset($Review['RECOMMENDATED']) && $Review['RECOMMENDATED'] == 'Y'): ?>
                                <div class="recommendated">
                                    <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_I_RECOMMENDATED") ?>
                                </div>
                            <? endif; ?>
                        </div>
                        <div class="revirew-body__content text"><?= $Review['ANSWER'] ?></div>
                    </div>
                <? endif; ?>
            </div>
        <? } ?>
        <? if ($arResult['CNT_PAGES'] > 1): ?>
            <div class="filter-pagination" id="filter-pagination"
                 data-cnt-left-pgn="<?= $arResult["CNT_LEFT_PGN"] ?>"
                 data-cnt-right-pgn="<?= $arResult["CNT_RIGHT_PGN"] ?>"
                 data-per-page="<?= COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_COUNT_PAGE_" . SITE_ID, "10") ?>"
                <?= ($arResult['CNT_PAGES'] <= 1) ? 'style="display:none;' : '' ?>>
                <? if ($arResult['CURRENT_PAGE'] > 1): ?>
                    <div class="left-arrows">
                        <button data-number="1" type="button" class="first">
                        </button>
                        <button data-number="<?= $arResult['CURRENT_PAGE'] - 1 ?>" type="button"
                                class="prev">
                        </button>
                    </div>
                <? endif; ?>

                <? for ($i = 1; $i <= $arResult['CNT_PAGES']; ++$i): ?>

                    <? if ($arResult['CNT_PAGES'] - $arResult["CNT_LEFT_PGN"] - $arResult["CNT_RIGHT_PGN"] < $arResult['CURRENT_PAGE']): ?>
                        <? if ($i >= $arResult['CNT_PAGES'] - $arResult["CNT_LEFT_PGN"] - $arResult["CNT_RIGHT_PGN"] && $i <= $arResult['CNT_PAGES'] - $arResult["CNT_RIGHT_PGN"]): ?>
                            <button class="filter-pagination__page-button" data-number="<?= $i ?>" type="button"
                                <?= ($i == $arResult['CURRENT_PAGE']) ? 'data-active="true" class="current"' : '' ?>><?= $i ?></button>
                        <? endif ?>
                    <? else: ?>
                        <? if ((int)ceil($arResult['CURRENT_PAGE'] / $arResult["CNT_LEFT_PGN"]) == (int)ceil($i / ($arResult["CNT_LEFT_PGN"]))): ?>
                            <button class="filter-pagination__page-button" data-number="<?= $i ?>" type="button"
                                <?= ($i == $arResult['CURRENT_PAGE']) ? 'data-active="true" class="current"' : '' ?>><?= $i ?></button>
                        <? endif; ?>


                        <? if ((int)ceil($arResult['CURRENT_PAGE'] / $arResult["CNT_LEFT_PGN"]) * $arResult["CNT_LEFT_PGN"] + 1 == $i): ?>
                            <button class="filter-pagination__page-button" data-number="<?= $i ?>" type="button" class="dots">...</button>
                        <? endif; ?>
                    <? endif; ?>
                    <? if ($i > $arResult['CNT_PAGES'] - $arResult["CNT_RIGHT_PGN"]): ?>
                        <button class="filter-pagination__page-button" data-number="<?= $i ?>" type="button"
                            <?= ($i == $arResult['CURRENT_PAGE']) ? 'data-active="true" class="current"' : '' ?>><?= $i ?></button>
                    <? endif; ?>

                <? endfor; ?>
                <? if ($arResult['CURRENT_PAGE'] <> $arResult['CNT_PAGES']): ?>
                    <div class="right-arrows">
                        <button data-number="<?= $arResult['CURRENT_PAGE'] + 1 ?>" type="button"
                                class="next">
                        </button>
                        <button data-number="<?= $arResult['CNT_PAGES'] ?>" type="button"
                                class="last">
                        </button>
                    </div>
                <? endif; ?>
            </div>
        <? endif; ?>
    <? } else { ?>
        <p><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_NO_RESULTS") ?></p>
    <? } ?>
</div>
<div id="idsReviews" style="display:none" data-site-dir="<?= SITE_DIR ?>"><?= $arResult['REVIEWS_IDS'] ?></div>
<? $frame->end(); ?>
