<?php
$pageTitle = 'Raamatupood - Ostukorv';
require_once __DIR__ . '/includes/header.php';

$books = get_books(__DIR__ . '/books.csv');

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qtyData = $_POST['qty'] ?? [];
    $newCart = [];

    foreach ($qtyData as $title => $qty) {
        $qty = (int)$qty;
        if ($qty > 0) {
            $newCart[$title] = $qty;
        }
    }

    $_SESSION['cart'] = $newCart;

    if (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = [];
        header('Location: ostukorv.php');
        exit;
    }
}

$cart = $_SESSION['cart'];
$cartItems = [];

foreach ($books as $book) {
    $title = $book['pealkiri'];
    if (isset($cart[$title]) && (int)$cart[$title] > 0) {
        $book['qty'] = (int)$cart[$title];
        $cartItems[] = $book;
    }
}

$totalBooks = 0;
$subtotal = 0;
$giftWrapTotal = 0;
$discount = 0;
$total = 0;
$discountCode = trim($_POST['discount_code'] ?? '');
$giftWrap = isset($_POST['gift_wrap']);
$message = '';

foreach ($cartItems as $item) {
    $totalBooks += $item['qty'];
    $subtotal += $item['hind'] * $item['qty'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calculate_order'])) {
    if ($giftWrap) {
        $giftWrapTotal = $totalBooks * 2;
    }

    if (strtoupper($discountCode) === 'RAAMAT10') {
        $discount = ($subtotal + $giftWrapTotal) * 0.10;
    }

    $total = ($subtotal + $giftWrapTotal) - $discount;

    $saveLine = date('Y-m-d H:i:s')
        . " | raamatuid: {$totalBooks}"
        . " | vahesumma: " . number_format($subtotal, 2, '.', '')
        . " | kinkepakend: " . number_format($giftWrapTotal, 2, '.', '')
        . " | soodustus: " . number_format($discount, 2, '.', '')
        . " | kokku: " . number_format($total, 2, '.', '')
        . " | kood: " . ($discountCode ?: '-')
        . PHP_EOL;

    file_put_contents(__DIR__ . '/orders.txt', $saveLine, FILE_APPEND);
    
} else {
    $total = $subtotal;
}
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Ostukorv</h1>

        <?php if (!empty($cartItems)): ?>
            <form method="post" class="m-0">
                <?php foreach ($cartItems as $item): ?>
                    <input type="hidden" name="qty[<?= htmlspecialchars($item['pealkiri']); ?>]" value="<?= $item['qty']; ?>">
                <?php endforeach; ?>
                <button type="submit" name="clear_cart" class="btn btn-outline-danger">Tühjenda</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="row g-4 align-items-start">
        <div class="col-lg-8">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <?php if (empty($cartItems)): ?>
                    <div class="alert alert-info mb-0">
                        Ostukorv on tühi. Lisa kõigepealt raamatud ostukorvi.
                    </div>
                    <a href="index.php#tooted" class="btn btn-primary mt-3">Vaata tooteid</a>
                <?php else: ?>
                    <form method="post">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Raamat</th>
                                        <th class="text-center">Kogus</th>
                                        <th class="text-end">Hind</th>
                                        <th class="text-end">Summa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">
                                                    <?= htmlspecialchars($item['pealkiri']); ?>
                                                </div>
                                                <div class="text-muted small">
                                                    <?= htmlspecialchars($item['autor']); ?>
                                                </div>
                                            </td>

                                            <td class="text-center" style="width: 180px;">
                                                <input
                                                    type="number"
                                                    name="qty[<?= htmlspecialchars($item['pealkiri']); ?>]"
                                                    class="form-control text-center"
                                                    min="0"
                                                    value="<?= $item['qty']; ?>"
                                                >
                                            </td>

                                            <td class="text-end">
                                                <?= euro($item['hind']); ?>
                                            </td>

                                            <td class="text-end">
                                                <?= euro($item['hind'] * $item['qty']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-check mb-3">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="gift_wrap"
                                id="gift_wrap"
                                <?= $giftWrap ? 'checked' : ''; ?>
                            >
                            <label class="form-check-label" for="gift_wrap">
                                Lisa kinkepakend (+2 € / raamat)
                            </label>
                        </div>

                        <div class="mb-3">
                            <label for="discount_code" class="form-label">Sooduskood</label>
                            <input
                                type="text"
                                name="discount_code"
                                id="discount_code"
                                class="form-control"
                                value="<?= htmlspecialchars($discountCode); ?>"
                                placeholder="RAAMAT10"
                            >
                        </div>

                        <div class="d-flex gap-2">
                            

                            <button type="submit" name="calculate_order" class="btn btn-success">
                                Arvuta ja salvesta
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h2 class="mb-3">Tulemus</h2>

                <?php if ($message): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Raamatuid</span>
                    <strong><?= $totalBooks; ?></strong>
                </div>

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Vahesumma</span>
                    <strong><?= euro($subtotal); ?></strong>
                </div>

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Kinkepakend</span>
                    <strong><?= euro($giftWrapTotal); ?></strong>
                </div>

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Soodustus</span>
                    <strong><?= euro(-$discount); ?></strong>
                </div>

                <div class="d-flex justify-content-between py-3 fs-4">
                    <span>Kokku</span>
                    <strong><?= euro($total); ?></strong>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>