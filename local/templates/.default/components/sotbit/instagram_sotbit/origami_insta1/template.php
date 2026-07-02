<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

use Bitrix\Main\Localization\Loc;
use Sotbit\Origami\Helper\Config;
Loc::loadMessages(__FILE__);

$hoverClass = implode(" ", Config::getArray("HOVER_EFFECT"));
$lazyLoad = (Config::get('LAZY_LOAD') == "Y");
global $settings;
?>

<? if (!empty($arResult["POSTS"]) && is_array($arResult["POSTS"])):?>
    <div class="puzzle_block about__puzzle_block main-container">
        <p class="insta_block-title puzzle_block__title fonts__middle_title">
            <?=$arResult["TITLE"]?>
        </p>
        <div class="insta_block">
            <div class="main_page-catalog_banner_instagram clearfix">
                <div class="insta_block-left_wrapper">
                    <div class="top_blocks clearfix">
                        <div class="left-wrapper">
                            <div class="<?=$hoverClass?>">
                                <?
                                if($lazyLoad)
                                {
                                    $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arResult["POSTS"][0]["media_url"].'" class="lazy" alt="lazy_loader"';
                                }else{
                                    $strLazyLoad = 'src="'.$arResult["POSTS"][0]["media_url"].'"';
                                }
                                ?>
                                <a href="#link" target="_blank">
                                    <img <?=$strLazyLoad?>>
                                    <?if($lazyLoad):?>
                                        <span class="loader-lazy"></span>
                                    <?endif;?>
                                </a>
                            </div>
                            <div class="<?=$hoverClass?>">
                                <?
                                if($lazyLoad)
                                {
                                    $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arResult["POSTS"][1]["media_url"].'" class="lazy"';
                                }else{
                                    $strLazyLoad = 'src="'.$arResult["POSTS"][1]["media_url"].'"';
                                }
                                ?>
                                <a href="#link" target="_blank">
                                    <img <?=$strLazyLoad?>>
                                    <?if($lazyLoad):?>
                                        <span class="loader-lazy"></span>
                                    <?endif;?>
                                </a>
                            </div>
                        </div>
                        <div class="right-wrapper <?=$hoverClass?>">
                            <?
                            if($lazyLoad)
                            {
                                $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arResult["POSTS"][2]["media_url"].'" class="lazy"';
                            }else{
                                $strLazyLoad = 'src="'.$arResult["POSTS"][2]["media_url"].'"';
                            }
                            ?>
                            <a href="#link" target="_blank">
                                <img <?=$strLazyLoad?>>
                                <?if($lazyLoad):?>
                                    <span class="loader-lazy"></span>
                                <?endif;?>
                            </a>
                        </div>
                    </div>

                    <div class="bottom_blocks">
                        <div class="<?=$hoverClass?>">
                            <?
                            if($lazyLoad)
                            {
                                $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arResult["POSTS"][3]["media_url"].'" class="lazy"';
                            }else{
                                $strLazyLoad = 'src="'.$arResult["POSTS"][3]["media_url"].'"';
                            }
                            ?>
                            <a href="#link" target="_blank">
                                <img <?=$strLazyLoad?>>
                                <?if($lazyLoad):?>
                                    <span class="loader-lazy"></span>
                                <?endif;?>
                            </a>
                        </div>
                        <div class="<?=$hoverClass?>">
                            <?
                            if($lazyLoad)
                            {
                                $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arResult["POSTS"][4]["media_url"].'" class="lazy"';
                            }else{
                                $strLazyLoad = 'src="'.$arResult["POSTS"][4]["media_url"].'"';
                            }
                            ?>
                            <a href="#link" target="_blank">
                                <img <?=$strLazyLoad?>>
                                <?if($lazyLoad):?>
                                    <span class="loader-lazy"></span>
                                <?endif;?>
                            </a>
                        </div>
                        <div class="<?=$hoverClass?>">
                            <?
                            if($lazyLoad)
                            {
                                $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arResult["POSTS"][5]["media_url"].'" class="lazy"';
                            }else{
                                $strLazyLoad = 'src="'.$arResult["POSTS"][5]["media_url"].'"';
                            }
                            ?>
                            <a href="#link" target="_blank">
                                <img <?=$strLazyLoad?>>
                                <?if($lazyLoad):?>
                                    <span class="loader-lazy"></span>
                                <?endif;?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="insta_block-right_wrapper">

                    <div class="top_blocks">
                        <div class="<?=$hoverClass?>">
                            <?
                            if($lazyLoad)
                            {
                                $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arResult["POSTS"][6]["media_url"].'" class="lazy"';
                            }else{
                                $strLazyLoad = 'src="'.$arResult["POSTS"][6]["media_url"].'"';
                            }
                            ?>
                            <a href="#link" target="_blank">
                                <img <?=$strLazyLoad?>>
                                <?if($lazyLoad):?>
                                    <span class="loader-lazy"></span>
                                <?endif;?>
                            </a>
                        </div>
                        <div class="<?=$hoverClass?>">
                            <?
                            if($lazyLoad)
                            {
                                $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arResult["POSTS"][7]["media_url"].'" class="lazy"';
                            }else{
                                $strLazyLoad = 'src="'.$arResult["POSTS"][7]["media_url"].'"';
                            }
                            ?>
                            <a href="#link" target="_blank">
                                <img <?=$strLazyLoad?>>
                                <?if($lazyLoad):?>
                                    <span class="loader-lazy"></span>
                                <?endif;?>
                            </a>
                        </div>
                        <div class="<?=$hoverClass?>">
                            <?
                            if($lazyLoad)
                            {
                                $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arResult["POSTS"][8]["media_url"].'" class="lazy"';
                            }else{
                                $strLazyLoad = 'src="'.$arResult["POSTS"][8]["media_url"].'"';
                            }
                            ?>
                            <a href="#link" target="_blank">
                                <img <?=$strLazyLoad?>>
                                <?if($lazyLoad):?>
                                    <span class="loader-lazy"></span>
                                <?endif;?>
                            </a>
                        </div>
                    </div>

                    <div class="bottom_blocks">
                        <div class="left-wrapper">
                            <div class="origami_instagram-block">
                                <a href="<?=$arResult["SUBSCRIBE"]?>" title="<?=Loc::getMessage("SOTBIT_INSTAGRAM_SUBSCRIBE")?>" class="origami_instagram-logo">
                                    <img style="object-fit: fill;" src="<?=Config::get('LOGO')?>">
                                </a>
                                <div class="origami_instagram-title"><?=$arParams["TITLE_TEXT"]?></div>
                                <div class="origami_instagram-text">
                                    <?=$arParams["TEXT"]?>
                                </div>
                                <div class="origami_instagram-subscribe">
                                    <a href="<?=$arResult["SUBSCRIBE"]?>" target="_blank" title="<?=Loc::getMessage("SOTBIT_INSTAGRAM_SUBSCRIBE")?>" class="origami_instagram-subscribe__link">
                                        <?=Loc::getMessage("SOTBIT_INSTAGRAM_SUBSCRIBE")?>
                                        <svg class="instagram-logo_icon" width="42" height="16">
                                            <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_arrow"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="right-wrapper">
                            <div class="<?=$hoverClass?>">
                                <?
                                if($lazyLoad)
                                {
                                    $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arResult["POSTS"][9]["media_url"].'" class="lazy"';
                                }else{
                                    $strLazyLoad = 'src="'.$arResult["POSTS"][9]["media_url"].'"';
                                }
                                ?>
                                <a href="#link" target="_blank">
                                    <img <?=$strLazyLoad?>>
                                    <?if($lazyLoad):?>
                                        <span class="loader-lazy"></span>
                                    <?endif;?>
                                </a>
                            </div>
                            <div class="<?=$hoverClass?>">
                                <?
                                if($lazyLoad)
                                {
                                    $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$arResult["POSTS"][10]["media_url"].'" class="lazy"';
                                }else{
                                    $strLazyLoad = 'src="'.$arResult["POSTS"][10]["media_url"].'"';
                                }
                                ?>
                                <a href="#link" target="_blank">
                                    <img <?=$strLazyLoad?>>
                                    <?if($lazyLoad):?>
                                        <span class="loader-lazy"></span>
                                    <?endif;?>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
<?endif;?>
