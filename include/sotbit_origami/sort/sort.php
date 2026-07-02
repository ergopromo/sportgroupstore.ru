<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application;
use Bitrix\Main\Page\Asset;
use Sotbit\Origami\Config\Option;
use Bitrix\Main\Localization\Loc;
use Sotbit\Origami\Helper\Config;

Loc::loadMessages(__FILE__);

Asset::getInstance()->addCss(SITE_DIR . "include/sotbit_origami/sort/style.css");
Asset::getInstance()->addJs(SITE_DIR . "include/sotbit_origami/sort/script.js");

global $APPLICATION;

function stripslashes_array($arr) {
    if (!is_array($arr)) {
        return stripslashes($arr);
    }

    $out = [];
    foreach ($arr as $key => $value) {
        $out[stripslashes($key)] = stripslashes_array($value);
    }

    return $out;
}

$sort = [
    'by' => [
        'by' => $arParams['ELEMENT_SORT_FIELD'],
        'order' => $arParams['ELEMENT_SORT_ORDER']
    ],
    'limit' => [
        'limit' => $arParams['PAGE_ELEMENT_COUNT']
    ]
];

$arTemplateListView = [
    "card",
    "list",
    "column"
];
$viewDefault = "card";
if(!isset($arParams["TEMPLATE_LIST_VIEW"])) {
    $arTemplateListView = Config::getArray("TEMPLATE_LIST_VIEW");
}

if (!isset($arParams["TEMPLATE_LIST_VIEW_DEFAULT"])) {
    $viewDefault = Config::get("TEMPLATE_LIST_VIEW_DEFAULT");
}

if($_GET['sort_by']) {
    $_SESSION['sort']['by']['by'] = $_GET['sort_by'];
    $_SESSION['sort']['by']['order'] = $_GET['sort_order'];
    $_SESSION['sort']['limit'] = $_GET['cnt'];
}

if($_GET['view']) {
    $_SESSION['view'] = $_GET['view'];
}

if ($_SESSION['view']) {
    $viewDefault = $_SESSION['view'];
}

if($_SESSION['sort']) {
    $sort = [
        'by' => [
            'by' => $_SESSION['sort']['by']['by'],
            'order' => $_SESSION['sort']['by']['order']
        ],
        'limit' => [
            'limit' => $_SESSION['sort']['limit']
        ]
    ];

    $defSortByVal = $_SESSION['sort']['by']['by'];
    $defSortOrder = $_SESSION['sort']['by']['order'];
    $defLim = $_SESSION['sort']['limit'];
}

if(empty($defSortByVal)) {
    $defSortBy = Option::get('DEFAULT_SORT_TAB_', SITE_ID);
}

$sortBy = Option::get('TAB_SORT_', SITE_ID);
if(!empty($sortBy)) {
    $sortBy = unserialize($sortBy);
}

$activeSort = 0;
foreach ($sortBy as $key => $item) {
    if (empty($item)) {
        continue;
    }

    $nameSortBy[] = Option::get('NAME_TAB_' . $item . '_', SITE_ID);
    $codeSortBy[] = Option::get('CODE_TAB_' . $item . '_', SITE_ID);
    $sortOrder[] = Option::get('SORT_ORDER_TAB_' . $item . '_', SITE_ID);
    if (empty($defSortByVal) && !empty($defSortBy) && $item == $defSortBy) {
        $defSortByVal = Option::get('CODE_TAB_' . $item . '_', SITE_ID);
        $activeSort = $key;
    } elseif (
        !empty($defSortByVal)
        && empty($defSortBy)
        && $defSortByVal == Option::get('CODE_TAB_' . $item . '_', SITE_ID)
        && $defSortOrder == Option::get('SORT_ORDER_TAB_' . $item . '_', SITE_ID)
    ) {
        $activeSort = $key;
        $defSortBy = $item;
    }
}


for ($i = 0; $i < 5; $i++) {
    $sortLimit[$i] = Option::get('COUNT_COUNT_TAB_' . $i . '_', SITE_ID);
}

if(empty($defLim)) {
    $defLim = $sortLimit[Option::get('DEFAULT_COUNT_TAB_', SITE_ID)];
}

if(!is_array($nameSortBy) || count(array_diff($nameSortBy, [''])) == 0) {
    $sortBy = ['SORT_FIELD_1', 'SORT_FIELD_2'];
    $nameSortBy = [
        Loc::getMessage('SORT_NAME'),
        Loc::getMessage('SORT_CREATED')
    ];
    $codeSortBy = ['NAME', 'CREATED_DATE'];
    $sortOrder = ['ASC', 'DESC'];
    $defSortBy = ['SORT_FIELD_1'];
}

if(!is_array($sortLimit) || count(array_diff($sortLimit, [''])) == 0){
    $sortLimit = [14, 28];
    $defLim = 14;
}

if($_SESSION['sort']['limit']) {
    $limSession = $_SESSION['sort']['limit'];
    $defLim = stripslashes_array($limSession);
}

if($_SESSION['sort']['by']['by']) {
    $defSortByVal = $_SESSION['sort']['by']['by'];
}

if(empty($sort['by']['by']) && !empty($defSortByVal)) {
    $sort['by']['by'] = $defSortByVal;
}

if(empty($sort['limit']['limit']) && !empty($defLim)) {
    $sort['limit']['limit'] = $defLim;
}

if(empty($sort['by']['order'])) {
    $sort['by']['order'] = $sortOrder[(
        array_search($defSortBy, $sortBy) !== false
        ? array_search($defSortBy, $sortBy)
        : 'asc'
    )];
}
?>
	<div class="catalog_content__sort_horizon sorting">
		<form name="sort" method="get" id="sort-section">
			<span class="sorting__title"><?= Loc::getMessage('SORT') ?></span>
			<div class="catalog_content__sort_horizon_property">
				<div class="select_block <?= $sort['by']['order'] == 'asc' ? 'sort-asc' : 'sort-desc'; ?>">
					<select name="sort_by" onchange="submitSort(this)" class="custom-select-block sources
                       	<? preg_match('/\d+/', $defSortBy, $defNumber); ?>
						fonts__middle_comment" data-placeholder="<?= $activeSort + 1 ?>">
                        <? foreach ($nameSortBy as $key => $value): ?>
                            <?if(!empty($value)): ?>
                                <option value="<?= $codeSortBy[$key] ?>" <?= $key == $activeSort ? 'selected' : '' ?>><?=$value?></option>
                            <?endif;?>
                        <?endforeach;?>
					</select>
                    <select class="sort-orders" name="sort_order" style="display: none;">
                        <? foreach ($sortOrder as $orderK => $order): ?>
                            <option class="sort-order" value="<?=$order;?>" <?= $orderK == $activeSort ? "selected" : "" ?>><?=$order;?></option>
                        <?endforeach;?>
                    </select>
				</div>
			</div>
			<span class="sorting__title"><?= Loc::getMessage('SORT_NUMBER') ?></span>
			<div class="catalog_content__sort_horizon_property catalog_content__sort_horizon_property--second">
				<div class="select_block">
                    <select name="cnt"
                            onchange="submitSort(this)"
                            class="custom-select-block sources fonts__middle_comment"
                            data-placeholder="<?= $defLim ?>"
                    >
                        <? for ($i = 0; $i < 5; $i++): ?>
                            <? if (!empty($sortLimit[$i])): ?>
                                <option value="<?= $sortLimit[$i] ?>" <?= $sortLimit[$i] == $defLim ? 'selected' : '' ?>><?= $sortLimit[$i] ?></option>
                            <? endif; ?>
                        <? endfor; ?>
					</select>
				</div>
			</div>
            <?= !empty($_REQUEST['q']) ? "<input type='hidden' name='q' value='" . $_REQUEST['q'] . "'>" : '' ?>
            <?= !empty($_REQUEST['q']) ? "<input type='hidden' name='s' value='" . $_REQUEST['s'] . "'>" : '' ?>
            <?
            if (!empty($arTemplateListView)) {
            ?>
                <div class="catalog_content__sort_horizon_btn-block">
                    <?
                    $active = false;
                    foreach($arTemplateListView as $view) {
                        if($viewDefault == $view) {
                            $active = true;
                        }

                        if ($active) {
                            ?>
                            <span class="catalog_content__sort_horizon_btn" title="<?= Config::getTemplateListView()[$view] ?>">
                            <?
                        } else {
                            $str = $APPLICATION->GetCurPageParam("view=".$view, ["view", "ajaxFilter"]);
                            $reqBXAjax = htmlspecialcharsbx($_REQUEST['bxajaxid']);
                            ?>
                            <a class="catalog_content__sort_horizon_btn" onclick=""
                            href="<?= str_replace('&bxajaxid=' . $reqBXAjax, '', $str) ?>"
                            rel="nofollow"
                            title="<?=Config::getTemplateListView()[$view]?>">
                            <?
                        }

                        if($view == "card") {
                            ?>
                            <svg class="catalog_content__sort_horizon_btn-titles" width="20" height="20">
                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_tiles"></use>
                            </svg>
                            <?
                        } elseif ($view == "list") {
                            ?>
                            <svg class="catalog_content__sort_horizon_btn-list" width="30" height="20">
                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_list"></use>
                            </svg>
                            <?
                        } elseif ($view == "column") {
                            ?>
                            <svg class="catalog_content__sort_horizon_btn-list" width="30" height="20">
                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_catalog_table"></use>
                            </svg>
                            <?
                        }

                        if ($active) {
                            ?>
                            </span>
                            <?
                        } else {
                            ?>
                            </a>
                            <?
                        }

                        $active = false;
                    }
                    ?>
                </div>
                <?
            }
            ?>
		</form>
	</div>
<?if(Application::getInstance()->getContext()->getRequest()->isAjaxRequest()) {
    ?>
    <script>
        MainSelect();
        try {
            waitSortElement()
        } catch (e) {
            console.warn(e)
        }
    </script>
    <?
}

$sort["view"] = $viewDefault;

return $sort;
?>


