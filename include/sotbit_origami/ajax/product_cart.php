<?php

define('STOP_STATISTICS', true);
define('NOT_CHECK_PERMISSIONS', true);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Loader;

header('Content-Type: application/json; charset=utf-8');

if (!check_bitrix_sessid()) {
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'sessid']);
    die();
}

$params = json_decode((string)($_POST['params'] ?? ''), true);
if (!is_array($params)) {
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'params']);
    die();
}

if (
    !Loader::includeModule('catalog')
    || !Loader::includeModule('sale')
    || !Loader::includeModule('sotbit.origami')
) {
    echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'modules']);
    die();
}

$action = (string)($params['action'] ?? '');
$productId = (int)($params['id'] ?? 0);

/**
 * @return array{ID: int, QUANTITY: int}|null
 */
function sgGetBasketRow(int $productId): ?array
{
    $row = CSaleBasket::GetList(
        [],
        [
            'FUSER_ID' => CSaleBasket::GetBasketUserID(),
            'LID' => SITE_ID,
            'ORDER_ID' => false,
            'DELAY' => 'N',
            'PRODUCT_ID' => $productId,
        ],
        false,
        false,
        ['ID', 'QUANTITY']
    )->Fetch();

    if (!$row) {
        return null;
    }

    return [
        'ID' => (int)$row['ID'],
        'QUANTITY' => (int)$row['QUANTITY'],
    ];
}

function sgGetBasketQuantity(int $productId): int
{
    $row = sgGetBasketRow($productId);

    return $row ? $row['QUANTITY'] : 0;
}

/**
 * @param int[] $productIds
 * @return array<int, int>
 */
function sgGetBasketQuantities(array $productIds): array
{
    $items = [];

    foreach ($productIds as $productId) {
        $productId = (int)$productId;
        if ($productId <= 0) {
            continue;
        }
        $items[$productId] = sgGetBasketQuantity($productId);
    }

    return $items;
}

function sgSetBasketQuantity(int $productId, int $quantity): int
{
    $row = sgGetBasketRow($productId);

    if ($quantity <= 0) {
        if ($row) {
            CSaleBasket::Delete($row['ID']);
        }

        return 0;
    }

    if ($row) {
        CSaleBasket::Update($row['ID'], ['QUANTITY' => $quantity]);

        return $quantity;
    }

    $buy = new \Sotbit\Origami\Sale\Basket\Buy();
    $buy->setId($productId);
    $buy->setProps([]);
    $buy->setQnt($quantity);
    if (!$buy->add()) {
        return 0;
    }

    return sgGetBasketQuantity($productId);
}

switch ($action) {
    case 'state':
        $ids = is_array($params['ids'] ?? null) ? $params['ids'] : [];
        echo json_encode([
            'STATUS' => 'OK',
            'ITEMS' => sgGetBasketQuantities($ids),
        ]);
        break;

    case 'add':
        if ($productId <= 0) {
            echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'id']);
            break;
        }

        $current = sgGetBasketQuantity($productId);
        $step = max(1, (int)($params['step'] ?? 1));
        $quantity = sgSetBasketQuantity($productId, $current + $step);

        echo json_encode([
            'STATUS' => $quantity > 0 ? 'OK' : 'ERROR',
            'QUANTITY' => $quantity,
        ]);
        break;

    case 'change':
        if ($productId <= 0) {
            echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'id']);
            break;
        }

        $quantity = sgSetBasketQuantity($productId, max(0, (int)($params['quantity'] ?? 0)));

        echo json_encode([
            'STATUS' => 'OK',
            'QUANTITY' => $quantity,
        ]);
        break;

    default:
        echo json_encode(['STATUS' => 'ERROR', 'MESSAGE' => 'action']);
        break;
}
