<?php
$pageTitle = 'Raamatupood - Kontakt';
require_once __DIR__ . '/includes/header.php';
$sent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $line = sprintf("%s | %s | %s | %s%s", date('Y-m-d H:i:s'), $name, $email, str_replace(["\r", "\n"], ' ', $message), PHP_EOL);
    file_put_contents(__DIR__ . '/messages.txt', $line, FILE_APPEND);
    $sent = true;
}
?>
<section class="container py-5">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="bg-white rounded-4 shadow-sm p-3 h-100">
                <h1 class="h2 mb-3">Kontakt</h1>
                <p>Kirjuta meile või külasta meid kaardil märgitud asukohas.</p>
                <form method="post">
                    <?php if ($sent): ?><div class="alert alert-success">Sõnum saadeti ja salvestati faili messages.txt</div><?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Nimi</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-post</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sõnum</label>
                        <textarea name="message" rows="5" class="form-control" required></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit" name="send_message">Saada</button>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="bg-white rounded-4 shadow-sm p-3 h-100">
                <h2 class="h4 mb-3">Google Maps</h2>
                <div class="ratio ratio-4x3">
                    <iframe src="https://www.google.com/maps?q=Tallinn&output=embed" style="border:0;" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
