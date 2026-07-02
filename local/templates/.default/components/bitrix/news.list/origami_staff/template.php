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
$this->createFrame()->begin();

use Bitrix\Main\Localization\Loc;
use Sotbit\Origami\Helper\Config;

Loc::loadMessages(__FILE__);

if(is_array($arResult['ITEMS'])) {
    $hoverClass = implode(" ", Config::getArray("HOVER_EFFECT"));
    $lazyLoad = (Config::get('LAZY_LOAD') == "Y");
    $idItem = bin2hex(random_bytes(5));
    $sliderButtons = "";
    if (\Sotbit\Origami\Helper\Config::get('SLIDER_BUTTONS') == 'square') {
        $sliderButtons = "btn-slider-main--one";
    } else if (\Sotbit\Origami\Helper\Config::get('SLIDER_BUTTONS') == 'circle') {
        $sliderButtons = "btn-slider-main--two";
    }
    ?>

<article id="staff-block-<?=$idItem?>" class="staff-block puzzle_block main-container size">
    <div class="staff-block__headline">
        <h2 class="staff-block__title"><?=$arParams["BLOCK_NAME"] ? $arParams["BLOCK_NAME"] : GetMessage("SOTBIT_STAFF_BLOCK_NAME")?></h2>
        <a class="staff-block__link" href="<?=$arParams["LINK_TO_THE_FULL_LIST"]?>"><?=GetMessage("SOTBIT_STAFF_SIMPLE_LINK_TEXT");?></a>
    </div>
    <div class="staff-block__slider swiper-container">
        <div class="staff-block__slider-inner swiper-wrapper">
            <?foreach ($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="staff-block__slider-item staff-block-item swiper-slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="staff-block-item__inner">
                        <div class="staff-block-item__img-wrap">
                            <?
                                if($lazyLoad)
                                {
                                    $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arItem["PREVIEW_PICTURE"]["SRC"].'" class="lazy"';
                                    $strLazyLoadDetail = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arItem["DETAIL_PICTURE"]["SRC"].'" class="lazy"';
                                }else{
                                    $strLazyLoad = 'src="'.$arItem["PREVIEW_PICTURE"]["SRC"].'"';
                                    $strLazyLoadDetail = 'src="'.$arItem["DETAIL_PICTURE"]["SRC"].'"';
                                }
                            ?>
                            <?if($arItem["PREVIEW_PICTURE"]["SRC"]):?>
                                <img class="staff-block-item__img <?= $lazyLoad ? "lazy" : ""?>" <?=$strLazyLoad?>>
                                <?if($lazyLoad):?>
                                    <span class="loader-lazy"></span>
                                <?endif;?>
                            <?elseif ($arItem["DETAIL_PICTURE"]["SRC"]):?>
                                <img class="staff-block-item__img <?= $lazyLoad ? "lazy" : ""?>" <?=$strLazyLoadDetail?>>
                                <?if($lazyLoad):?>
                                    <span class="loader-lazy"></span>
                                <?endif;?>
                            <?endif;?>
                        </div>
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="staff-block-item__name"><?=$arItem["NAME"]?></a>
                        <?if($arItem["PROPERTIES"]["ORIGAMI_POSITION"]["VALUE"]):?>
                            <span class="staff-block-item__post"><?=$arItem["PROPERTIES"]["ORIGAMI_POSITION"]["VALUE"]?></span>
                        <?endif;?>
                        <div class="staff-block-item__hidden-block">
                            <?if($arItem["PROPERTIES"]["ORIGAMI_MAIN_TEL"]["VALUE"]):?>
                                <a href="tel:<?$arItem["PROPERTIES"]["ORIGAMI_MAIN_TEL"]["VALUE"]?>" class="staff-block-item__phone">
                                    <svg class="staff-block-item__phone-icon" width="12px" height="12px">
                                        <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_phone_filled"></use>
                                    </svg>
                                    <?=$arItem["PROPERTIES"]["ORIGAMI_MAIN_TEL"]["VALUE"]?>
                                </a>
                            <?endif;?>
                            <?if($arItem["PROPERTIES"]["ORIGAMI_MAIN_EMAIL"]["VALUE"]):?>
                                <a href="mailto:<?=$arItem["PROPERTIES"]["ORIGAMI_MAIN_EMAIL"]["VALUE"]?>" class="staff-block-item__email"><?=$arItem["PROPERTIES"]["ORIGAMI_MAIN_EMAIL"]["VALUE"]?></a>
                            <?endif;?>
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="staff-block-item__link"><?=GetMessage("SOTBIT_STAFF_BUTTON_TEXT")?></a>
                        </div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
        <div class="btn-slider-main <?=$sliderButtons?> btn-slider-main--prev btn-slider-main--disabled"></div>
        <div class="btn-slider-main <?=$sliderButtons?> btn-slider-main--next btn-slider-main--disabled"></div>
    </div>
</article>

<script>
    var staff__block_<?=$idItem?> = new CreateSlider ({
        sliderContainer: '#staff-block-<?=$idItem?> .staff-block__slider',
        sizeSliderInit: 'all',
        freeMode1024: false,
        spaceBetween1024: 30,
    });
    var slider_btn_<?=$idItem?> = new sliderBtnPos();
</script>
<?
}
