<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

global $sotbitSeoMetaBottomDesc;
global $sotbitSeoMetaTopDesc;
global $sotbitSeoMetaAddDesc;
global $sotbitSeoMetaFile;
global $issetCondition;
global ${$arParams["FILTER_NAME"]};

$this->setFrameMode(true);
use Sotbit\Origami\Helper\Config;
$hoverClass = implode(" ", Config::getArray("HOVER_EFFECT"));
$lazyLoad = (Config::get('LAZY_LOAD') == "Y");
?>

<?
if(isset($sotbitSeoMetaFile))
{
    ?>
    <div class="catalog_content__canvas">
        <?=$sotbitSeoMetaFile?>
    </div>
    <?
}elseif($arResult["SECTION"]["DETAIL_PICTURE"]){
    ?>
    <div class="catalog_content__canvas">
        <img class="catalog_content__canvas_img"
             src="<?=$arResult["SECTION"]["DETAIL_PICTURE"]['SRC']?>"
             width="<?=$arResult["SECTION"]["DETAIL_PICTURE"]['WIDTH']?>"
             height="<?=$arResult["SECTION"]["DETAIL_PICTURE"]['HEIGHT']?>"
             alt="<?=$arResult["SECTION"]["DETAIL_PICTURE"]['ALT']?>"
             title="<?=$arResult["SECTION"]["DETAIL_PICTURE"]['TITLE']?>"
        >
    </div>

    <?
}

?>
<?if (count($arResult['SECTIONS']) > 0):?>
<div class="catalog_content__category_block JS-catalog_content__category_block">
	<div class="catalog_content__category">
        <?
        foreach ($arResult['SECTIONS'] as $section)
        {
            $this->AddEditAction($section['ID'], $section['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($section['ID'], $section['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

            if($lazyLoad)
            {
                $strLazyLoad = 'src="'.SITE_TEMPLATE_PATH.'/assets/img/loader_lazy.svg" data-src="'.$section['PICTURE']['SRC'].'"';
                $lazyClass = 'lazy';
            }else{
                $strLazyLoad = 'src="'.$section['PICTURE']['SRC'].'"';
                $lazyClass = '';
            }
            ?>
			<a href="<?=$section['SECTION_PAGE_URL'] ?>" title="<?=$section['NAME']?>" class="catalog_content__category_item JS-catalog_content__category_item <?=$hoverClass?>">
				<div class="catalog_content__category_block_img">
					<img class="catalog_content__category_img <?=$lazyClass?>"
                         <?=$strLazyLoad?>
                         alt="<?=$section['PICTURE']['ALT']?>"
                         title="<?=$section['PICTURE']['TITLE']?>"
                    >
                    <?if($lazyLoad):?>
                    <span class="loader-lazy"></span>
                    <?endif;?>
				</div>
				<p class="catalog_content__category_img_title fonts__middle_text"><?=$section['NAME']?></p>
			</a>
            <?
        }
        ?>
	</div>
    <div id="loadMore"><?= GetMessage('SEE_ALL_SECTIONS') ?> <i class="icon-nav_button"></i></div>

</div>
    <script>
        try {
            const categoryBlock = document.querySelector('.JS-catalog_content__category_block');
            const categoryItems = Array.from(categoryBlock.querySelectorAll('.JS-catalog_content__category_item'));
            const btnMore = categoryBlock.querySelector('#loadMore');
            const COUNT_SHOW_ITEM_MOBILE = 4;
            const COUNT_SHOW_ITEM_DESKTOP = 5;
            const RESOLUTION_TRIGGER = 768;
            if (window.innerWidth < RESOLUTION_TRIGGER && categoryItems.length > COUNT_SHOW_ITEM_MOBILE) {
                hideItem(COUNT_SHOW_ITEM_MOBILE);
            }

            if (window.innerWidth > RESOLUTION_TRIGGER && categoryItems.length > COUNT_SHOW_ITEM_DESKTOP) {
                hideItem(COUNT_SHOW_ITEM_DESKTOP);
            }

            if(categoryItems.length < COUNT_SHOW_ITEM_DESKTOP){
                btnMore.classList.add('loadMore_hide');
            }

            function hideItem(itemType) {
                categoryItems.map((item, n) => {
                    if (n >= itemType) {
                        item.style.display = 'none';
                        btnMore.classList.remove('loadMore_hide');
                    }
                })
            }

            btnMore.addEventListener('click', () => {
                categoryItems.map((item) => {
                    item.style.display = ''
                });
                categoryBlock.classList.add('show-all-category');
                btnMore.classList.add('loadMore_hide');
            });
        } catch (e) {
            console.warn(e)
        }
    </script>
<?endif;?>
