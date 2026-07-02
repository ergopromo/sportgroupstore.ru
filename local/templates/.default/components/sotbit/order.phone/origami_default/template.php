<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;
use Sotbit\Origami\Helper\Config;
use Bitrix\Main\Page\Asset;

if (!CModule::IncludeModule("sotbit.orderphone") || !CSotbitOrderphone::GetDemo()) {
    return;
}
$APPLICATION->ShowAjaxHead();
\Bitrix\Main\Page\Asset::getInstance()->addJs($templateFolder . "/js/jquery.maskedinput.min.js");
Asset::getInstance()->addJs(SITE_DIR . "local/templates/.default/components/sotbit/order.phone/origami_default/script.js");
Asset::getInstance()->addCss(SITE_DIR . "local/templates/.default/components/sotbit/order.phone/origami_default/style.css");
$typeMask = (Config::get('TYPE_MASK_VIEW') == 'FLAGS') ? 'Y' : 'N';
if ($typeMask == 'Y') {
    CJSCore::Init(['phone_number']);
} else {
    $mask = Config::get('MASK');
}
?>
<div class="buy-in-click">
    <div class="sotbit_order_phone__title"><?= Loc::getMessage('OK_TITLE') ?></div>
    <form class="buy-in-click__form">
        <div class="sotbit_order_success">
            <div class="popup-window-message-content">
                <svg class="popup-window-icon-check">
                    <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_check_form"></use>
                </svg>
                <div>
                    <div class="popup-window-message-title"><?= GetMessage('OK_THANKS') ?></div>
                    <div style="font-size: 16px;"><?= GetMessage('OK_SUCCESS') ?></div>
                </div>
            </div>
        </div>

        <div class="hide-on-success">

            <div class="popup_resizeable_content">

                <div class="popup-error-message">
                    <div class="sotbit_order_error"></div>
                </div>
                <? if (empty($arResult["FORM_NOTE"])) : ?>
                    <? if (is_array($arParams)): ?>
                        <? foreach ($arParams as $param => $val):
                            if (strpos($param,
                                    "~") !== false ||
                                is_array($val) ||
                                ($typeMask == 'Y' && mb_strpos($param,
                                        'TEL_MASK') !== false)) {
                                continue;
                            }
                            ?>
                            <input type="hidden"
                                   name="<?= $param ?>"
                                   value="<?= $val ?>"/>
                        <? endforeach; ?>
                    <? endif; ?>

                    <?if(is_array($arResult['DISPLAY'])):?>
                        <? foreach ($arResult['DISPLAY'] as $field): ?>
                        <? if ($field != 'COMMENT'): ?>

                            <? if ($field == 'PHONE'): ?>
                                <div class="sotbit_order_phone__block">
                                    <div class="buy-in-click__phone-input">
                                        <? if ($typeMask == 'Y'): ?>
                                            <span class="phone_input__flag">
												<span id="buy-in-click_flag-wrapper"
                                                      onclick="fixCountryPopup(this)"></span>
											</span>
                                        <? endif; ?>

                                        <div
                                                class="main-input-md__wrapper <?= ($typeMask == 'N') ? 'fullsize' : ''; ?>">
                                            <input

                                                    type="text"
                                                    name="order_phone"
                                                    class="main-input-md filled"
                                                    maxlength='17'
                                                    id="buy-in-click_phone"
                                                    placeholder="<?= $mask ?: '' ?>"
                                            >
                                            <label
                                                    for="buy-in-click_phone"
                                                    class="main-label-md">
                                                <?= Loc::getMessage('OK_PHONE') ?>
                                                *
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <? else : ?>
                                <div class="sotbit_order_phone__block main-input-md__wrapper">
                                    <input type="text"
                                           name="order_<?= mb_strtolower($field) ?>"
                                           value="<?= $arResult['USER'][$field] ?>"
                                           id="order_<?= mb_strtolower($field) ?>"
                                           class="main-input-md"
                                           onchange="isInputFilled(this)"
                                        <? if (in_array($field,
                                            $arResult['REQUIRE'])) echo 'data-req-' . $field . '="y"' ?>
                                    />
                                    <label class="main-label-md"
                                           for="order_<?= mb_strtolower($field) ?>">
                                        <?= Loc::getMessage('OK_' . $field);
                                        if (in_array($field,
                                            $arResult['REQUIRE'])) echo '<span class="star"> *</span>' ?>
                                    </label>
                                </div>
                            <? endif ?>

                        <? else : ?>
                            <div class="sotbit_order_phone__block main-textarea-md__wrapper">
                                <textarea
                                        name="order_comment"
                                        class="main-textarea-md"
                                        id="order_<?= mb_strtolower($field) ?>"
                                <? if (in_array($field,
                                    $arResult['REQUIRE'])) echo 'data-req-' . $field . '="y"' ?>
                                onchange="isInputFilled(this)"></textarea>
                                <label class="main-label-textarea-md"
                                       for="order_<?= mb_strtolower($field) ?>">
                                    <?= Loc::getMessage('OK_' . $field);
                                    if (in_array($field,
                                        $arResult['REQUIRE'])) echo '<span class="star">  *</span>' ?>
                                </label>
                            </div>
                        <? endif ?>
                    <? endforeach ?>
                    <?endif;?>
                    <? if ($arResult["isUseCaptcha"] == "Y") {
                        ?>
                        <div class="buy-in-click__captcha">
                            <div class="main-input-md__wrapper">
                                <input type="text"
                                       class="main-input-md"
                                       name="captcha_word"
                                       id="callback-popup_captcha-input"
                                       size="30"
                                       maxlength="50"
                                       value=""
                                       onchange="isInputFilled(this)"
                                       required/>
                                <label class="main-label-md"
                                       for="callback-popup_captcha-input">
                                    <?= GetMessage('CAPTCHA_TITLE'); ?>
                                </label>
                            </div>
                            <div class="buy-in-click__captcha_img feedback_block__captcha">
                                <input type="hidden"
                                       name="captcha_sid"
                                       value="<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>"/>
                                <img
                                        src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>"
                                        alt="captcha"/>
                                <div class="captcha-refresh"
                                     onclick="reloadCaptcha(this,'<?= SITE_DIR ?>');return false;">
                                    <svg class="icon_refresh"
                                         width="16"
                                         height="14">
                                        <use
                                                xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_refresh"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>

                    <? }
                    ?>

                    <div class="confidential-field main_checkbox">
                        <input type="checkbox"
                               id="UF_CONFIDENTIAL"
                               name="UF_CONFIDENTIAL"
                               class="confidential__checkbox__input"
                               checked="checked">
                        <label for="UF_CONFIDENTIAL"
                               class="confidential__checkbox__label fonts__middle_comment">
                            <span id="personal_phone_personal_checked"></span>
                            <span><?= Loc::getMessage('OK_CONFIDENTIAL',
                                    [
                                        '#CONFIDENTIAL_LINK#' => Config::get('CONFIDENTIAL_PAGE',
                                            $arParams['SITE_ID'])
                                    ]) ?></span>
                        </label>
                    </div>

                    <div class="popup-window-submit_button">
                        <input class="main_btn"
                               type="submit"
                               name="submit"
                               value="<?= Loc::getMessage('OK_SEND') ?>"/>
                    </div>
                <? endif; ?>

            </div>

        </div>

    </form>
</div>
<script>
    try {
        setClassInputFilled();
    } catch (error) {
        console.warn(error);
    }

    <?if($typeMask == 'Y'):?>
    BX.ready(function () {
        if (document.getElementById("buy-in-click_phone")) {
            new BX.PhoneNumber.Input({
                node: BX("buy-in-click_phone"),
                forceLeadingPlus: true,
                flagNode: BX("buy-in-click_flag-wrapper"),
                flagSize: 16,
                defaultCountry: 'ru',
                onChange: function (e) {
                }
            });
        }
    });
    <?endif;?>
    $(function () {
        $(".buy-in-click").on("submit", "form", submitOrderPhone);

        maska = $(".buy-in-click form input[name='TEL_MASK']").eq(0).val();
        if (maska !== undefined && maska) {
            maska = $.trim(maska);
            if (maska != "") {
                $(".buy-in-click form input[name='order_phone']").mask(maska, {placeholder: "_"});
            }
        }

        function submitOrderPhone(e) {
            e.preventDefault();
            let name = $(this).find("input[name='order_name']").val();
            let email = $(this).find("input[name='order_email']").val();
            let fio = $(this).find("input[name='order_fio']").val();
            let zip = $(this).find("input[name='order_zip']").val();
            let city = $(this).find("input[name='order_city']").val();
            let prop_location = $(this).find("input[name='order_location']").val();
            let address = $(this).find("input[name='order_address']").val();
            let company = $(this).find("input[name='order_company']").val();
            let company_adr = $(this).find("input[name='order_company_adr']").val();
            let inn = $(this).find("input[name='order_inn']").val();
            let kpp = $(this).find("input[name='order_kpp']").val();
            let contact_person = $(this).find("input[name='order_contact_person']").val();
            let fax = $(this).find("input[name='order_fax']").val();
            let comment = $(this).find("textarea[name='order_comment']").val();

            v = $(this).find("input[name='TEL_MASK']").val();
            v = $.trim(v);
            req = strReplace(v);
            let _this = $(this);
            v = $(this).find("input[name='order_phone']").val();

            $(this).find('input').removeClass('error');
            $(this).find('.checkbox__label').removeClass('error');
            $(this).find(".sotbit_order_error").hide();
            $(this).find(".sotbit_order_timedate").hide();
            $(this).find(".sotbit_order_success").hide();


            let error = false;

            let reqName = this.querySelector('[data-req-name]');
            if (reqName) {
                if (name.length <= 0) {
                    $(this).find("input[name='order_name']").addClass('error');
                    error = true;
                }
            }

            let reqFio = this.querySelector('[data-req-fio]');
            if (reqFio) {
                if (fio.length <= 0) {
                    $(this).find("input[name='order_fio']").addClass('error');
                    error = true;
                }
            }

            let reqZip = this.querySelector('[data-req-zip]');
            if (reqZip) {
                if (zip.length <= 0) {
                    $(this).find("input[name='order_zip']").addClass('error');
                    error = true;
                }
            }

            let reqCity = this.querySelector('[data-req-city]');
            if (reqCity) {
                if (city.length <= 0) {
                    $(this).find("input[name='order_city']").addClass('error');
                    error = true;
                }
            }

            let reqLocation = this.querySelector('[data-req-location]');
            if (reqLocation) {
                if (prop_location.length <= 0) {
                    $(this).find("input[name='order_location']").addClass('error');
                    error = true;
                }
            }

            let reqAddress = this.querySelector('[data-req-address]');
            if (reqAddress) {
                if (address.length <= 0) {
                    $(this).find("input[name='order_address']").addClass('error');
                    error = true;
                }
            }

            let reqCompany = this.querySelector('[data-req-company]');
            if (reqCompany) {
                if (company.length <= 0) {
                    $(this).find("input[name='order_company']").addClass('error');
                    error = true;
                }
            }

            let reqCompany_adr = this.querySelector('[data-req-company_adr]');
            if (reqCompany_adr) {
                if (company_adr.length <= 0) {
                    $(this).find("input[name='order_company_adr']").addClass('error');
                    error = true;
                }
            }

            let reqInn = this.querySelector('[data-req-inn]');
            if (reqInn) {
                if (inn.length <= 0) {
                    $(this).find("input[name='order_inn']").addClass('error');
                    error = true;
                }
            }

            let reqKpp = this.querySelector('[data-req-kpp]');
            if (reqKpp) {
                if (kpp.length <= 0) {
                    $(this).find("input[name='order_kpp']").addClass('error');
                    error = true;
                }
            }

            let reqContact_person = this.querySelector('[data-req-contact_person]');
            if (reqContact_person) {
                if (contact_person.length <= 0) {
                    $(this).find("input[name='order_contact_person']").addClass('error');
                    error = true;
                }
            }

            let reqFax = this.querySelector('[data-req-fax]');
            if (reqFax) {
                if (fax.length <= 0) {
                    $(this).find("input[name='order_fax']").addClass('error');
                    error = true;
                }
            }


            if (v.search(req) == -1 || v.length <= 0) {
                $(this).find("input[name='order_phone']").addClass('error');
                error = true;
            }
            if (!$(this).find("input[name='UF_CONFIDENTIAL']").is(':checked')) {
                console.log($(this).find('#personal_phone_personal_checked'));
                $(this).find('#personal_phone_personal_checked').addClass('error');
                error = true;
            }

            let reqEmail = this.querySelector('[data-req-email]');
            if (reqEmail) {
                let pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
                if (!pattern.test(email)) {
                    $(this).find("input[name='order_email']").addClass('error');
                    error = true;
                }
            }

            let reqComment = this.querySelector('[data-req-comment]');
            if (reqComment) {
                if (comment.length <= 0) {
                    $(this).find("textarea[name='order_comment']").addClass('error');
                    error = true;
                }
            }

            if (!error) {
                $(this).find("input[type='text']").removeClass("red");
                ser = $(this).serialize();
                userType = 0;

                BX.ajax.post("/bitrix/components/sotbit/order.phone/ajax.php", ser, function (data) {
                    data = $.trim(data);
                    if (data.indexOf("SUCCESS") >= 0) {
                        _this.find(".sotbit_order_success").show();
                        _this.find(".sotbit_order_error").hide();
                        _this.find(".hide-on-success").hide();
                        id = data.replace("SUCCESS", "").split(',')[0];
                        userPassword = data.replace("SUCCESS", "").split(',')[1];
                        localHref = $('input[name="LOCAL_REDIRECT"]').val();
                        orderID = $('input[name="ORDER_ID"]').val();
                        if (userPassword.length > 0) {
                            _this.find(".sotbit_order_timedate").show();
                            _this.find(".time_date_login").text('<?=Loc::getMessage('FORM_LOGIN'); ?> ' + data.replace("SUCCESS", "").split(',')[2]);
                            _this.find(".time_date_pass").text('<?=Loc::getMessage("FORM_PASSWORD"); ?> ' + userPassword);
                        }

                        if (typeof (localHref) != "undefined" && localHref != "") {
                            location.href = localHref + "?" + orderID + "=" + id;
                        }
                    } else {
                        _this.find(".sotbit_order_success").hide();
                        _this.find(".sotbit_order_timedate").hide();
                        _this.find(".sotbit_order_error").show().html(data);
                    }
                });
            }
        }

        function strReplace(str) {
            str = str.replace("+", "\\+");
            str = str.replace("(", "\\(");
            str = str.replace(")", "\\)");
            str = str.replace(/[0-9]/g, "[0-9]{1}");
            return new RegExp(str, 'g');
        }
    });
</script>
<script>
    ;(function resizeOrderPhonePopup() {
        let wrapper,
            wrappers = document.querySelectorAll(".wrap-popup-window");

        for (let i = 0; i < wrappers.length; i++) {
            if (wrappers[i].querySelector(".popup_resizeable_content")) {
                wrapper = wrappers[i];
                break;
            }
        }

        let popupResizeableContent = wrapper.querySelector(".popup_resizeable_content"),
            popupWindow = wrapper.querySelector(".popup-window"),
            popupContent = wrapper.querySelector(".popup-content"),
            popupTitle = wrapper.querySelector(".sotbit_order_phone__title"),
            submitBtn = wrapper.querySelector(".popup-window-submit_button");

        resizePopupContent();
        putTitleShadow();
        setUpListeners();

        function setUpListeners() {
            popupResizeableContent.addEventListener("scroll", putTitleShadow);

            window.addEventListener("resize", () => {
                resizePopupContent();
                putTitleShadow();
            });

            popupContent.addEventListener("load", () => {
                resizePopupContent();
                putTitleShadow();
            });

            submitBtn.addEventListener("click", () => {
                resizePopupContent();
                putTitleShadow();
            });
        }

        function resizePopupContent() {
            let clientHeight = document.documentElement.clientHeight * 0.97,
                newHeight;

            popupResizeableContent.style.overflowY = "hidden";
            popupResizeableContent.style.height = "auto";

            if ((popupContent.clientHeight > (popupWindow.clientHeight + 2)) || (popupContent.clientHeight > clientHeight)) {

                newHeight = (clientHeight < popupWindow.clientHeight) ?
                    (clientHeight - popupTitle.clientHeight) :
                    (popupWindow.clientHeight - popupTitle.clientHeight);

                popupResizeableContent.style.overflowY = "auto";
                popupResizeableContent.style.height = newHeight + "px";
            }
        }

        function putTitleShadow() {
            let scrolled = popupResizeableContent.scrollTop;

            if (scrolled === 0) {
                popupTitle.style.boxShadow = "none";
            } else {
                popupTitle.style.boxShadow = "0 2px 5px 3px rgba(0,0,0,.1)";
            }
        }

    })();
</script>
