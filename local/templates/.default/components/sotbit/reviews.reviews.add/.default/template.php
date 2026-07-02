<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
use Bitrix\Main\Localization\Loc;
?>
<? $frame = $this->createFrame()->begin(); ?>
<? global $APPLICATION;
global $USER;
if (!is_object($USER)) $USER = new CUser; ?>
<div class="add-reviews">
    <div class="success"
         style="display:none;"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_SUCCESS_TEXT") ?></div>
    <div class="add-review">
        <? if ($USER->IsAuthorized() || COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_REGISTER_USERS_" . SITE_ID, "") != 'Y'): ?>
            <?
            if ($arResult['BAN'] != "Y"):
                if ((COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_IF_BUY_" . SITE_ID, "") == 'Y' && $arResult['REVIEWS_BUY'] == 'Y') || COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_IF_BUY_" . SITE_ID, "") != 'Y'):?>
                    <? if ($arResult['CAN_REPEAT'] == 1): ?>
                        <div class="add-review__title">
                            <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_ADD_TITLE") ?>
                            <div class="add-review__title-info-popup">
                                <svg class="add-review__title-info-icon" width="20px" height="20px">
                                    <use
                                        xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_info"></use>
                                </svg>
                                <div class="add-review__title-info-popup-content">
                                    <p><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_TEXTAREA_RIGHT_TEXT1") ?></p>
                                    <ul>
                                        <li><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_TEXTAREA_RIGHT_TEXT2") ?></li>
                                        <li><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_TEXTAREA_RIGHT_TEXT3") ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="review-add-block">
                            <div class="add-review__left-container">
                                <p class="add-check-error" style="display:none;"></p>
                                <form class="review" id="add_review" action="javascript:void(null);"
                                      enctype="multipart/form-data">
                                    <div class="add_review__stars review-stars">
                                        <span class="stars__title">
                                            <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_ADD_RATING_TITLE1") ?>
                                        </span>
                                        <div class="stars__selection">
                                            <? for ($i = 1; $i <= $arParams['MAX_RATING']; ++$i): ?>
                                                <input class="stars__input" id="star-<?= $i ?>" type="radio"
                                                       name="rating"
                                                       value="<?= $i ?>" <?= ($i == $arParams['DEFAULT_RATING_ACTIVE']) ? 'checked' : ''; ?>/>
                                                <label class="stars__label" title="" for="star-<?= $i ?>">
                                                    <svg class="review-stars__icon" width="25" height="24">
                                                        <use
                                                            xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_star"></use>
                                                    </svg>
                                                </label>
                                            <? endfor; ?>
                                        </div>
                                        <span class="stars__mark">
                                            <span><?= GetMessage(CSotbitReviews::iModuleID . "MARK_1") ?></span>
                                            <span><?= GetMessage(CSotbitReviews::iModuleID . "MARK_2") ?></span>
                                            <span><?= GetMessage(CSotbitReviews::iModuleID . "MARK_3") ?></span>
                                            <span><?= GetMessage(CSotbitReviews::iModuleID . "MARK_4") ?></span>
                                            <span><?= GetMessage(CSotbitReviews::iModuleID . "MARK_5") ?></span>
                                        </span>
                                    </div>
                                    <input type="hidden" name="ID_ELEMENT" value="<?= $arParams['ID_ELEMENT'] ?>"/>
                                    <input type="hidden" name="MODERATION"
                                           value="<?= COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_MODERATION_" . SITE_ID, "") ?>"/>
                                    <input type="hidden" name="NOTICE_EMAIL" value="<?= $arParams['NOTICE_EMAIL'] ?>"/>
                                    <input type="hidden" name="SITE_DIR" value="<?= SITE_DIR ?>"/>
                                    <input type="hidden" name="SPAM_ERROR"
                                           value="<?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_SPAM_ERROR") ?>"/>
                                    <input type="hidden" name="VIDEO_ERROR"
                                           value="<?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_VIDEO_ERROR") ?>"/>
                                    <input type="hidden" name="PAGE_URL" value="<?= $APPLICATION->GetCurPage() ?>"/>
                                    <input type="hidden" name="SPAM_ERROR"
                                           value="<?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_SPAM_ERROR") ?>"/>
                                    <input type="hidden" name="PRIMARY_COLOR"
                                           value="<?= $arParams['PRIMARY_COLOR'] ?>"/>
                                    <input type="hidden" name="MAX_RATING" value="<?= $arParams['MAX_RATING'] ?>"/>
                                    <input type="hidden" name="BUTTON_BACKGROUND"
                                           value="<?= $arParams['BUTTON_BACKGROUND'] ?>"/>
                                    <input type="hidden" name="ADD_REVIEW_PLACE"
                                           value="<?= $arParams['ADD_REVIEW_PLACE'] ?>"/>
                                    <input type="hidden" name="TEMPLATE" value="<?= $templateName ?>"/>

                                    <div class="add-review__wrapper">

                                        <? if (COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_TITLE_" . SITE_ID, "") == 'Y'): ?>
                                            <label class="main-input-md__wrapper">
                                                <input
                                                    type="text"
                                                    class="main-input-md"
                                                    onchange="isInputFilled(this)"
                                                    name="title"
                                                    value=""
                                                    maxlength="255"
                                                >
                                                <span class="main-label-md">
                                                <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_TITLE") ?>
                                            </span>
                                            </label>
                                        <? endif; ?>

                                        <? if (COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_EDITOR_" . SITE_ID, "") == "Y"): ?>
                                            <span id="review-editor">
                                            <? $APPLICATION->IncludeComponent("bitrix:main.post.form", "", Array(
                                                'BUTTONS' => array(),
                                                'PARSER' => array(),
                                                'PIN_EDITOR_PANEL' => 'N',
                                                'TEXT' => array(
                                                    'SHOW' => 'Y',
                                                    'VALUE' => "",
                                                    'NAME' => 'text'
                                                )
                                            )); ?>
                                        </span>
                                        <? else: ?>

                                            <label class="main-textarea-md__wrapper">
                                                <textarea
                                                    name="text"
                                                    class="contacts-textarea main-textarea-md"
                                                    id="contentbox"
                                                    maxlength="<?= $arParams["TEXTBOX_MAXLENGTH"] ?>"
                                                    onchange="isInputFilled(this)"
                                                ></textarea>
                                                <span class="main-label-textarea-md">
                                                    <?= Loc::getMessage(CSotbitReviews::iModuleID . '_TEXTAREA_REVIEW'); ?>
                                                </span>
                                            </label>
                                            <p class="count"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_ADD_COUNT") ?>
                                                <span class="count-now">0</span> / <?= $arParams["TEXTBOX_MAXLENGTH"] ?>
                                            </p>
                                        <? endif; ?>
                                    </div>

                                    <? if (isset($arResult['ADD_FIELDS']) && is_array($arResult['ADD_FIELDS'])): ?>
                                        <? foreach ($arResult['ADD_FIELDS'] as $key => $value): ?>
                                            <p class="add-field-title"><?= $value['NAME'] ?>:</p>
                                            <? if ($value['TYPE'] == 'textbox'): ?>
                                                <? if (COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_EDITOR_" . SITE_ID, "") == "Y"): ?>
                                                    <? $APPLICATION->IncludeComponent("bitrix:main.post.form", "", Array(
                                                        'BUTTONS' => array(),
                                                        'PARSER' => array(),
                                                        'PIN_EDITOR_PANEL' => 'N',
                                                        'TEXT' => array(
                                                            'SHOW' => 'Y',
                                                            'VALUE' => "",
                                                            'NAME' => 'AddFields_' . $key
                                                        )
                                                    )); ?>
                                                <? else: ?>
                                                    <textarea name="AddFields_<?= $key ?>" id="<?= $key ?>"></textarea>
                                                <? endif; ?>
                                            <? endif; ?>
                                        <? endforeach; ?>
                                    <? endif; ?>
                                    <? if (COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_UPLOAD_IMAGE_" . SITE_ID, "") == 'Y'): ?>
                                        <div class="add-photo">
                                            <input type="file" multiple="" id="photo" accept="image/jpeg,image/png">
                                            <label class="add-review__add-photo-label" for="photo"
                                                   id="add-photo-button">
                                                <span class="add-review__photo-icon-wrapper">
                                                 <svg class="add-review__photo-icon" width="10" height="8">
                                                        <use
                                                            xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_photo"></use>
                                                 </svg>
                                                </span>
                                                <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_ADD_IMAGES") ?>
                                            </label>
                                        </div>
                                        <ul class="add-review__add-photo-container add-image"
                                            id="preview-photo"
                                            data-max-size="<?= COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_MAX_IMAGE_SIZE_" . SITE_ID, "2") ?>"
                                            data-thumb-width="<?= COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_THUMB_WIDTH_" . SITE_ID, "150") ?>"
                                            data-thumb-height="<?= COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_THUMB_HEIGHT_" . SITE_ID, "150") ?>"
                                            data-max-count-images="<?= COption::GetOptionString(CSotbitReviews::iModuleID, "REVIEWS_MAX_COUNT_IMAGES_" . SITE_ID, "5") ?>"
                                            data-error-max-size="<?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_ERROR_IMAGE_MAX_SIZE") ?>"
                                            data-error-type="<?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_ERROR_IMAGE_TYPE") ?>"
                                            data-error-max-count="<?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_ERROR_MAX_COUNT_IMAGES") ?>">
                                        </ul>
                                    <? endif; ?>
                                    <div style="clear:both"></div>

                                    <? if ($arResult['VIDEO_ALLOW'] == "Y"): ?>
                                        <label class="main-input-md__wrapper">
                                            <input
                                                class="main-input-md"
                                                type="text"
                                                name="video"
                                                onchange="isInputFilled(this)"
                                            >
                                            <span class="main-label-md">
                                            <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_VIDEO") ?>
                                        </span>

                                        </label>
                                    <? endif; ?>
                                    <? if ($arResult['PRESENTATION_ALLOW'] == "Y"): ?>
                                        <label class="main-input-md__wrapper">
                                            <input
                                                class="main-input-md"
                                                type="text"
                                                name="presentation"
                                                onchange="isInputFilled(this)"
                                            >
                                            <span class="main-label-md">
                                            <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_PRESENTATION") ?>
                                        </span>

                                        </label>
                                    <? endif; ?>

                                    <? if (isset($arResult['RECAPTCHA2_SITE_KEY']) && !empty($arResult['RECAPTCHA2_SITE_KEY'])): ?>
                                        <div data-captcha-review="Y"
                                             id="recaptcha-review-<?= $arResult["REVIEWS_CNT"] ?>"
                                             class="captcha-block"></div>
                                    <? endif; ?>

                                    <div class="add-review__recommend">
                                        <span
                                            class="add-review__recommend-title"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_RECOMMENDATED") ?></span>
                                        <span class="add-review__recommend-radios">
                                        <label class="main_radio">
                                            <input type="radio" name="RECOMMENDATED" value="Y">
                                            <span>
                                        <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_RECOMMENDATED_YES") ?>
                                        </span>
                                        </label>
                                        <label class="main_radio">
                                            <input type="radio" name="RECOMMENDATED"
                                                   value="N">
                                            <span>
                                        <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_RECOMMENDATED_NO") ?>
                                    </span>
                                        </label>
                                        </span>
                                    </div>

                                    <div class="add-review__buttons">
                                        <button class="main_btn" type="submit" name="submit" id="review_submit">
                                            <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_SUBMIT_VALUE") ?>
                                        </button>
                                        <button id="reset-form" class="main_btn add-review__reset">
                                            <?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_ADD_CANCEL") ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="add-review__right-container">
                                <p class="add-review__right-container-title"><b><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_TEXTAREA_RIGHT_TEXT1") ?></b></p>
                                <ul class="add-review__right-container-description">
                                    <li class="add-review__right-container-description-item"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_TEXTAREA_RIGHT_TEXT2") ?></li>
                                    <li class="add-review__right-container-description-item"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_TEXTAREA_RIGHT_TEXT3") ?></li>
                                </ul>
                            </div>

                        </div>


                    <? else: ?>

                        <? if ($arResult['CAN_REPEAT'] == 0): ?>
                            <p class="not-error"><?= GetMessage(CSotbitReviews::iModuleID . "_REPEAT") ?></p>
                        <? else: ?>
                            <p class="not-error"><?= GetMessage(CSotbitReviews::iModuleID . "_REPEAT_TIME") . ' ' . $arResult['CAN_REPEAT'] ?></p>
                        <? endif; ?>

                    <? endif; ?>
                <? else: ?>
                    <p class="not-buy-error"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_IF_BUY_NOT_TITLE") ?></p>
                <? endif; ?>
            <? else: ?>
                <p class="not-error not-ban-error"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_USER_BAN_TITLE") ?></p>
                <? if (isset($arResult['REASON']) && !empty($arResult['REASON'])): ?>
                    <p class="reason-title"><?= GetMessage(CSotbitReviews::iModuleID . "_REVIEWS_USER_BAN_REASON_TITLE") ?></p>
                    <p class="reason-text"><?= $arResult['REASON'] ?></p>
                <? endif; ?>
            <? endif; ?>
        <? endif; ?>
    </div>
</div>
<? $frame->end(); ?>
