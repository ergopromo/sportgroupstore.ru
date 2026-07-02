<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="staff-detail">
    <div class="staff-detail__sidebar sidebar-staff-detail">
        <div class="sidebar-staff-detail__img-wrap">
            <?if($arResult["DETAIL_PICTURE"]):?>
                <img class="sidebar-staff-detail__img" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>">
            <?elseif ($arResult["PREVIEW_PICTURE"]):?>
                <img class="sidebar-staff-detail__img" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arResult["PREVIEW_PICTURE"]["ALT"]?>">
            <?endif;?>
        </div>
        <?if($arResult["PREVIEW_TEXT"]):?>
            <div class="sidebar-staff-detail__quote quote-block-staff-detail">
                <svg class="quote-block-staff-detail__svg" viewBox="0 0 30 22" preserveAspectRatio="none">
                    <path d="M27.6748 0H20.6991L16.0486 8.8V22H30V8.8H23.0243L27.6748 0ZM11.6261 0H4.65045L-1.90735e-06 8.8V22H13.9514V8.8H6.97568L11.6261 0Z"/>
                </svg>
                <span class="quote-block-staff-detail__text"><?=$arResult["PREVIEW_TEXT"]?></span>
            </div>
        <?endif;?>
    </div>
    <div class="staff-detail__content">
        <h2 class="staff-detail__title"><?=$arResult["NAME"]?></h2>
        <?if($arResult["DETAIL_TEXT"]):?>
            <p class="staff-detail__description">
                <?=$arResult["DETAIL_TEXT"]?>
            </p>
        <?endif;?>
        <div class="staff-detail__info-block">
            <?if($arParams["PROPERTIES_DISPLAYED_ON_DETAIL"]):?>
                <?foreach ($arResult["PROPERTIES"] as $code=>$property):?>
                    <?if($property["VALUE"] && in_array($code, $arParams["PROPERTIES_DISPLAYED_ON_DETAIL"])):?>
                        <div class="staff-detail__info-item">
                            <span class="staff-detail__info-item-title"><?=$property["NAME"]?>&#58;</span>
                            <?if(is_array($property["VALUE"])):?>
                                <?foreach ($property["VALUE"] as $value):?>
                                    <span class="staff-detail__info-item-text"><?=$value?></span>
                                <?endforeach;?>
                            <?else:?>
                                <span class="staff-detail__info-item-text"><?=$property["VALUE"]?></span>
                            <?endif;?>
                        </div>
                    <?endif;?>
                <?endforeach;?>
            <?endif;?>
            <?if($arParams["USER_DISPLAYED_FIELDS"] && $arResult["USER_DISPLAYED_FIELDS"]):?>
                <?foreach ($arResult["USER_DISPLAYED_FIELDS"] as $code=>$field):?>
                    <?if($field && in_array($code, $arParams["USER_DISPLAYED_FIELDS"])):?>
                        <div class="staff-detail__info-item">
                            <span class="staff-detail__info-item-title"><?=GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_".$code)?>&#58;</span>
                                <span class="staff-detail__info-item-text"><?=$field?></span>
                        </div>
                    <?endif;?>
                <?endforeach;?>
            <?endif;?>
        </div>
        <?if(!empty($arParams["PROPERTIES_SOCIAL_NETWORK"])):?>
        <div class="staff-detail__social-block">
            <? foreach ($arResult["PROPERTIES"] as $code=>$prop):?>
                <? if($prop["VALUE"] && in_array($code, $arParams["PROPERTIES_SOCIAL_NETWORK"])):?>
                    <a href="<?=$prop["VALUE"]?>" class="staff-detail__social-link">
                        <svg class="staff-detail__social-link-svg">
                            <?if($prop["HINT"]):?>
                                <use
                                        xlink:href="<?=$prop["HINT"]?>">
                                </use>
                            <?else:?>
                                <path d="M7.2 0C3.22699 0 0 2.35685 0 5.24481C0 6.70539 0.815422 8.0166 2.11663 8.96265C1.90843 10.0083 1.35325 10.9544 0.555181 11.7178C0.433735 11.834 0.520482 12 0.676626 12C2.41157 11.9668 4.00771 11.3195 5.13542 10.2905C5.7947 10.4232 6.48867 10.5062 7.2 10.5062C11.173 10.5062 14.4 8.14938 14.4 5.26141C14.4 2.37344 11.173 0 7.2 0ZM4.68434 6.12448C4.1812 6.12448 3.76482 5.72614 3.76482 5.24481C3.76482 4.76348 4.1812 4.36514 4.68434 4.36514C5.18747 4.36514 5.60386 4.76348 5.60386 5.24481C5.58651 5.72614 5.18747 6.12448 4.68434 6.12448ZM7.2 6.12448C6.69687 6.12448 6.28048 5.72614 6.28048 5.24481C6.28048 4.76348 6.69687 4.36514 7.2 4.36514C7.70313 4.36514 8.11952 4.76348 8.11952 5.24481C8.10217 5.72614 7.70313 6.12448 7.2 6.12448ZM9.71566 6.12448C9.21253 6.12448 8.79614 5.72614 8.79614 5.24481C8.79614 4.76348 9.21253 4.36514 9.71566 4.36514C10.2188 4.36514 10.6352 4.76348 10.6352 5.24481C10.6178 5.72614 10.2188 6.12448 9.71566 6.12448Z"/>
                            <?endif;?>
                        </svg>
                    </a>
                <?endif;?>
            <?endforeach;?>
        </div>
        <?endif;?>
        <?if($arResult["PROPERTIES"]["ORIGAMI_ASK_QUESTION"]["VALUE"]):?>
            <button type="button" class="staff-detail__btn" onclick="window.callback_staff('<?=SITE_DIR?>','<?=SITE_ID?>',this, '<?=$arResult["NAME"]?>')"><?=GetMessage("NEWS_ASK_QUESTION")?></button>
        <?endif;?>
        <?if($arResult["DISPLAY_PROPERTIES"]["ORIGAMI_CERTIFICATES"]["FILE_VALUE"]):?>
            <div class="staff-detail__sertificate">
                <h3 class="staff-detail__sertificate-title"><?=GetMessage("ORIGAMI_CERTIFICATES_TITLE")?></h3>
                <div class="staff-detail__sertificate-content">
                    <?foreach ($arResult["DISPLAY_PROPERTIES"]["ORIGAMI_CERTIFICATES"]["FILE_VALUE"] as $file):?>
                        <div class="staff-detail__sertificate-item">
                            <img class="staff-detail__sertificate-img" src="<?=$file["SRC"]?>">
                        </div>
                    <?endforeach;?>
                </div>
            </div>
        <?endif;?>
    </div>
</div>

<!-- PhotoSwipe Layout -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
