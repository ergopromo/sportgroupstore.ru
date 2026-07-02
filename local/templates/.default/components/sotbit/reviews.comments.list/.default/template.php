<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

global $USER;
global $APPLICATION;

$origamiIsInstalled = \Bitrix\Main\Loader::includeModule('sotbit.origami');
$frame = $this->createFrame()->begin();
?>
<div class="comments-container">
    <? if (!empty($arResult['COMMENTS']) && is_array($arResult['COMMENTS'])): ?>
        <? foreach ($arResult['COMMENTS'] as $Comment): ?>
            <div data-site-dir="<?= SITE_DIR ?>"
                 id="comment-<?= $Comment['ID'] ?>"
                 data-id="<?= $Comment['ID'] ?>"
                 class="reviews-container__item item level level-<?= $Comment['LEVEL'] ?> <?= $Comment['SHOP_ADMIN'] == "Y" ? "shopanswer" : "" ?> <?=$Comment['LEVEL'] > 0 ? "child-comment": ""?>"
                 itemprop="comment"
                 itemscope
                 itemtype="http://schema.org/UserComments">
                <? if ($Comment['SHOP_ADMIN'] == "N") : ?>
                    <div class="reviews-container__header">
                        <div class="reviews-container__avatar-container">
                            <div class="reviews-container__avatar-overflow-wrapper">
                                <svg class="reviews-container__avatar-no-image" width="18" height="20">
                                    <use
                                        xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_authorized_medium"></use>
                                </svg>
                            </div>
                            <? if ($arResult['MODERATOR'] == 'Y') : ?>
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
                            <? endif; ?>
                        </div>
                        <div class="reviews-container__user-info-container">
                            <div class="reviews-container__user-info">
                                <? if ($Comment['NAME']): ?>
                                    <span class="reviews-container__user-name">
                                            <?= $Comment['NAME'] ?>
                                        </span>
                                <? endif; ?>
                                <? if ($Comment['ID_USER'] > 0): ?>
                                    <span class="reviews-container__user-reviews-number">
                                        <?= GetMessage(CSotbitReviews::iModuleID . "COMMENTS_NUMBER") ?>
                                        <span class="dnone" itemprop="interactionCount"><?= $arResult["USER_COMMENTS_CNT"][$Comment['ID_USER']];?></span>
                                    </span>
                                <? endif; ?>
                            </div>
                            <div class="reviews-container__date-stars-wrapper">
                                <div class="reviews-container__date" itemprop="datePublished">
                                    <?= $Comment['DATE_CREATION']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="reviews-container__body revirew-body">
                        <div class="revirew-body__content" itemprop="commentText"><?= $Comment['TEXT'] ?></div>
                    </div>
                    <div class="reviews-container__footer">
                        <? if (
                                ($USER->IsAuthorized() && COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_REGISTER_USERS_" . SITE_ID) == 'Y')
                                || COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_REGISTER_USERS_" . SITE_ID, "") != 'Y'
                        ) : ?>
                            <div class="reviews-container__footer-item">
                                <div class="spoiler__comments">
                                    <div class="spoiler-input answer">
                                        <?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_SPOILER_ANSWER") ?>
                                    </div>
                                </div>
                            </div>
                        <?endif;?>
                        <div class="reviews-container__footer-item">
                            <?
                            $APPLICATION->IncludeComponent(
                                "sotbit:reviews.share",
                                "",
                                [
                                    "TITLE" => '',
                                    "URL" => $arResult['ELEMENT']['DETAIL_PAGE_URL'],
                                    "PICTURE" => $Question['SHARE_IMAGE'],
                                    "TEXT" => $Question['QUESTION'],
                                    "SERVICES" => $arResult['SHARE_SERVICES'],
                                    "FACEBOOK_APP_ID" => $arResult['FACEBOOK_APP_ID'],
                                    "SHARE_LINK" => $arResult['ELEMENT']['DETAIL_PAGE_URL'] . '#comment-' . $Comment['ID'],
                                    "LINK_TITLE" => GetMessage(CSotbitReviews::iModuleID . "_LINK_TITLE_COMMENTS")
                                ],
                                false
                            );
                            ?>
                        </div>
                        <? if (
                            !$origamiIsInstalled
                            && (
                                ($USER->IsAuthorized() && COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_REGISTER_USERS_" . SITE_ID) == 'Y')
                                    || COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_REGISTER_USERS_" . SITE_ID) != 'Y'
                            )
                            && COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_EDITOR_" . SITE_ID) == 'Y'
                        ) : ?>
                            <div class="reviews-container__footer-item comments_quote">
                                <?= GetMessage(CSotbitReviews::iModuleID . '_COMMENTS_QUOTE') ?>
                            </div>
                        <?endif;?>
                    </div>
                    <?
                    $APPLICATION->IncludeComponent(
                        "sotbit:reviews.comments.add",
                        "default-answer",
                        [
                            'TEXTBOX_MAXLENGTH' => $arParams['TEXTBOX_MAXLENGTH'],
                            'ID_ELEMENT' => $arParams['ID_ELEMENT'],
                            "PRIMARY_COLOR" => $arParams['PRIMARY_COLOR'],
                            "BUTTON_BACKGROUND" => $arParams['BUTTON_BACKGROUND'],
                            'AJAX' => $arParams["AJAX"],
                            'PARENT' => $Comment['ID'],
                            "NOTICE_EMAIL" => $arParams['NOTICE_EMAIL'],
                            'CACHE_TIME' => $arParams["CACHE_TIME"],
                            'CACHE_GROUPS' => $arParams["CACHE_GROUPS"]
                        ],
                        $component
                    );
                    ?>
                <? else: ?>
                    <div class="user-info">
                        <div class="avatar">
                            <div class="avatar-inner">
                                <img class="img-responsive" alt="<?= $Comment['NAME'] ?>"
                                     title="<?= $Comment['NAME'] ?>" src="<?= $Comment['PERSONAL_PHOTO'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="text">
                        <div class="username" itemprop="creator">
                            <?= $Comment['NAME'] ?: ''; ?>
                        </div>
                        <span class="text" itemprop="commentText"><?= $Comment['TEXT'] ?></span>
                    </div>
                    <div style="clear: both;"></div>
                <? endif; ?>
            </div>
        <? endforeach; ?>
    <? else: ?>
        <p><?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_NO_RESULTS") ?></p>
        <?
        if ($arParams['AJAX'] == 'Y') {
            $APPLICATION->IncludeComponent(
                "sotbit:reviews.comments.add",
                "default-answer",
                [
                    'TEXTBOX_MAXLENGTH' => $arParams['TEXTBOX_MAXLENGTH'],
                    'ID_ELEMENT' => $arParams['ID_ELEMENT'],
                    "PRIMARY_COLOR" => $arParams['PRIMARY_COLOR'],
                    "BUTTON_BACKGROUND" => $arParams['BUTTON_BACKGROUND'],
                    'AJAX' => $arParams["AJAX"],
                    'PARENT' => $Comment['ID'],
                    "NOTICE_EMAIL" => $arParams['NOTICE_EMAIL'],
                    'CACHE_TIME' => $arParams["CACHE_TIME"],
                    'CACHE_GROUPS' => $arParams["CACHE_GROUPS"]
                ]);
        }
        ?>
    <? endif; ?>
    <? if ($arResult['CNT_PAGES'] > 1): ?>
        <div class="filter-pagination" id="filter-pagination-comments"
             data-url="<?= $APPLICATION->GetCurPage() ?>"
             data-id-element="<?= $arParams["ID_ELEMENT"] ?>"
             data-site-dir="<?= SITE_DIR ?>"
             data-primary-color="<?= $arParams['PRIMARY_COLOR'] ?>"
             data-template="<?= $templateName ?>"
             data-date-format="<?= $arParams['DATE_FORMAT'] ?>"
             data-cnt-left-pgn="<?= $arResult["CNT_LEFT_PGN"] ?>"
             data-cnt-right-pgn="<?= $arResult["CNT_RIGHT_PGN"] ?>"
             data-per-page="<?= COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_COUNT_PAGE_" . SITE_ID, "10") ?>"
            <?= ($arResult['CNT_PAGES'] <= 1) ? 'style="display:none;' : '' ?>>
            <? if ($arResult['CURRENT_PAGE'] > 1): ?>
                <div class="left-arrows">
                    <button data-number="1" type="button" class="first">
                    </button>
                    <button data-number="<?= $arResult['CURRENT_PAGE'] - 1 ?>"
                            type="button" class="prev">
                    </button>
                </div>
            <? endif; ?>
            <? for ($i = 1; $i <= $arResult['CNT_PAGES']; ++$i): ?>
                    <? if ((int)ceil($arResult['CURRENT_PAGE'] / $arResult["CNT_LEFT_PGN"]) == (int)ceil($i / ($arResult["CNT_LEFT_PGN"]))): ?>
                        <button class="filter-pagination__page-button" data-number="<?= $i ?>" type="button"
                            <?= ($i == $arResult['CURRENT_PAGE']) ? 'data-active="true" class="current"' : '' ?>><?= $i ?></button>
                    <? endif; ?>
                    <? if ((int)ceil($arResult['CURRENT_PAGE'] / $arResult["CNT_LEFT_PGN"]) * $arResult["CNT_LEFT_PGN"] + 1 == $i): ?>
                        <button class="filter-pagination__page-button" data-number="<?= $i ?>" type="button" class="dots">...</button>
                    <? endif; ?>
            <? endfor; ?>
            <? if ($arResult['CURRENT_PAGE'] <> $arResult['CNT_PAGES']): ?>
                <div class="right-arrows">
                    <button data-number="<?= $arResult['CURRENT_PAGE'] + 1 ?>"
                            type="button" class="next">
                    </button>
                    <button data-number="<?= $arResult['CNT_PAGES'] ?>" type="button"
                            class="last">
                    </button>
                </div>
            <? endif; ?>
        </div>
    <? endif; ?>
</div>
<div id="idsComments" style="display:none"
     data-site-dir="<?= SITE_DIR ?>"><?= $arResult['COMMENTS_IDS'] ?></div>
<? $frame->end(); ?>
