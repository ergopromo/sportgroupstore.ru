<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$frame = $this->createFrame()->begin();
global $APPLICATION; ?>
<div class="list questions-list">
    <div class="list-rows">
        <? if (isset($arResult['QUESTIONS']) && is_array($arResult['QUESTIONS'])): ?>
            <? foreach ($arResult['QUESTIONS'] as $Question): ?>
                <div class="questions-list__item" data-site-dir="<?= SITE_DIR ?>" data-id="<?= $Question['ID'] ?>"
                     id="question-<?= $Question['ID'] ?>">
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
                                    <span class="reviews-container__user-name">
                                         <?= (isset($Question['NAME']) && !empty($Question['NAME'])) ? $Question['NAME'] : ''; ?><?= (isset($Question['LAST_NAME']) && !empty($Question['LAST_NAME'])) ? ' ' . $Question['LAST_NAME'] : ''; ?>
                                    </span>
                                <span class="reviews-container__user-reviews-number">
                                    <? if ($Review['ID_USER'] > 0): ?>

                                        <?= GetMessage(CSotbitReviews::iModuleID . "_QUESTIONS_CNT_USER") ?>

                                        <? if (isset($arResult['LINK_TO_USER'][$Review['ID_USER']]) && !empty($arResult['LINK_TO_USER'][$Review['ID_USER']])): ?>
                                            <a href="<?= $arResult['LINK_TO_USER'][$Question['ID_USER']] ?>"> <?= $arResult['USER_QUESTIONS_CNT'][$Question['ID_USER']] ?></a>
                                        <? else: ?>
                                            <?= $arResult['USER_QUESTIONS_CNT'][$Question['ID_USER']] ?>
                                        <? endif; ?>

                                    <? endif; ?>
                                    </span>
                            </div>
                            <div class="reviews-container__date-stars-wrapper">
                                <div class="reviews-container__date" itemprop="datePublished">
                                    <?= $Question['DATE_CREATION']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="reviews-container__body revirew-body">
                        <?= $Question['QUESTION'] ?>
                    </div>
                    <div class="reviews-container__footer">
                        <div class="reviews-container__footer-item">
                            <? $APPLICATION->IncludeComponent(
                                "sotbit:reviews.share",
                                "",
                                array(
                                    "TITLE" => '',
                                    "URL" => $arResult['ELEMENT']['DETAIL_PAGE_URL'],
                                    "PICTURE" => $Question['SHARE_IMAGE'],
                                    "TEXT" => $Question['QUESTION'],
                                    "SERVICES" => $arResult['SHARE_SERVICES'],
                                    "FACEBOOK_APP_ID" => $arResult['FACEBOOK_APP_ID'],
                                    "SHARE_LINK" => $arResult['ELEMENT']['DETAIL_PAGE_URL'] . '#question-' . $Question['ID'],
                                    "LINK_TITLE" => GetMessage(CSotbitReviews::iModuleID . "_LINK_TITLE_QUESTIONS")
                                ),
                                false
                            ); ?>
                        </div>
                        <div class="reviews-container__footer-item">
                            <div class="spoiler">
                                <div class="spoiler-input">
                                    <?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_SPOILER_ANSWER") ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="questions-list__reply">
                        <? $APPLICATION->IncludeComponent(
                            "sotbit:reviews.questions.add",
                            "",
                            array(
                                'TEXTBOX_MAXLENGTH' => $arParams['TEXTBOX_MAXLENGTH'],
                                'ID_ELEMENT' => $arParams['ID_ELEMENT'],
                                "PRIMARY_COLOR" => $arParams['PRIMARY_COLOR'],
                                "BUTTON_BACKGROUND" => $arParams['BUTTON_BACKGROUND'],
                                'AJAX' => $arParams["AJAX"],
                                "NOTICE_EMAIL" => $arParams['NOTICE_EMAIL'],
                                'CACHE_TIME' => $arParams["CACHE_TIME"],
                                'CACHE_GROUPS' => $arParams["CACHE_GROUPS"],
                            ),
                            $component
                        ); ?>
                    </div>
                    <? if (isset($Question['ANSWER']) && !empty($Question['ANSWER'])): ?>
                        <div class="shopanswer">
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
                            </div>
                            <div class="reviews-container__body revirew-body">
                                <?= $Question['ANSWER'] ?>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                    <? endif; ?>
                </div>
            <? endforeach; ?>
        <? else: ?>
            <p><?= GetMessage(CSotbitReviews::iModuleID . "_QUESTIONS_NO_RESULTS") ?></p>
        <? endif; ?>
        <? if ($arResult['CNT_PAGES'] > 1): ?>
            <div id="filter-pagination-questions" class="filter-pagination"
                 data-url="<?= $APPLICATION->GetCurPage() ?>"
                 data-id-element="<?= $arParams["ID_ELEMENT"] ?>"
                 data-site-dir="<?= SITE_DIR ?>"
                 data-primary-color="<?= $arParams['PRIMARY_COLOR'] ?>"
                 data-template="<?= $templateName ?>"
                 data-date-format="<?= $arParams['DATE_FORMAT'] ?>"
                 data-cnt-left-pgn="<?= $arResult["CNT_LEFT_PGN"] ?>"
                 data-cnt-right-pgn="<?= $arResult["CNT_RIGHT_PGN"] ?>"
                 data-per-page="<?= COption::GetOptionString(CSotbitReviews::iModuleID, "QUESTIONS_COUNT_PAGE_"
                     . SITE_ID, "10") ?>"
                <?= ($arResult['CNT_PAGES'] <= 1) ? 'style="display:none;' : '' ?>>
                <? if ($arResult['CURRENT_PAGE'] > 1): ?>
                    <div class="left-arrows">
                        <button data-number="1" type="button" class="first">
                            <i class="fa fa-angle-double-left"></i>
                        </button>
                        <button data-number="<?= $arResult['CURRENT_PAGE'] - 1 ?>"
                                type="button" class="prev">
                            <i class="fa fa-angle-left"></i>
                        </button>
                    </div>
                <? endif; ?>

                <? for ($i = 1; $i <= $arResult['CNT_PAGES']; ++$i): ?>

                    <? if ($arResult['CNT_PAGES'] - $arResult["CNT_LEFT_PGN"] - $arResult["CNT_RIGHT_PGN"] < $arResult['CURRENT_PAGE']): ?>
                        <? if ($i >= $arResult['CNT_PAGES'] - $arResult["CNT_LEFT_PGN"] - $arResult["CNT_RIGHT_PGN"] && $i <= $arResult['CNT_PAGES'] - $arResult["CNT_RIGHT_PGN"]): ?>
                            <button class="filter-pagination__page-button" data-number="<?= $i ?>"
                                <?= ($i == $arResult['CURRENT_PAGE']) ? 'data-active="true" class="current"' : '' ?>><?= $i ?></button>
                        <? endif ?>
                    <? else: ?>
                        <? if ((int)ceil($arResult['CURRENT_PAGE'] / $arResult["CNT_LEFT_PGN"]) == (int)ceil($i / ($arResult["CNT_LEFT_PGN"]))): ?>
                            <button class="filter-pagination__page-button" data-number="<?= $i ?>"
                                <?= ($i == $arResult['CURRENT_PAGE']) ? 'data-active="true" class="current"' : '' ?>><?= $i ?></button>
                        <? endif; ?>


                        <? if ((int)ceil($arResult['CURRENT_PAGE'] / $arResult["CNT_LEFT_PGN"]) * $arResult["CNT_LEFT_PGN"] + 1 == $i): ?>
                            <button class="filter-pagination__page-button dots" data-number="<?= $i ?>">...</button>
                        <? endif; ?>
                    <? endif; ?>
                    <? if ($i > $arResult['CNT_PAGES'] - $arResult["CNT_RIGHT_PGN"]): ?>
                        <button class="filter-pagination__page-button" data-number="<?= $i ?>"
                            <?= ($i == $arResult['CURRENT_PAGE']) ? 'data-active="true" class="current"' : '' ?>><?= $i ?></button>
                    <? endif; ?>

                <? endfor; ?>
                <? if ($arResult['CURRENT_PAGE'] <> $arResult['CNT_PAGES']): ?>
                    <div class="right-arrows">
                        <button data-number="<?= $arResult['CURRENT_PAGE'] + 1 ?>"
                                type="button" class="next">
                            <i class="fa fa-angle-right"></i>
                        </button>
                        <button data-number="<?= $arResult['CNT_PAGES'] ?>" type="button"
                                class="last">
                            <i class="fa fa-angle-double-right"></i>
                        </button>
                    </div>
                <? endif; ?>
            </div>
        <? endif; ?>
    </div>
</div>
<? $frame->end(); ?>
