<?php
$pageTitle = 'Raamatupood - Avaleht';
require_once __DIR__ . '/includes/header.php';
$books = get_books(__DIR__ . '/books.csv');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    add_to_cart($_POST['title']);
    header('Location: index.php?added=1');
    exit;
}

$banners = random_banner_images(__DIR__ . '/reklaam');
?>

<header class="container py-4">

    <?php if (!empty($banners)): ?>
        <div id="heroCarousel" class="carousel slide shadow rounded overflow-hidden" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php foreach ($banners as $i => $banner): ?>
                    <button
                        type="button"
                        data-bs-target="#heroCarousel"
                        data-bs-slide-to="<?= $i; ?>"
                        class="<?= $i === 0 ? 'active' : ''; ?>"
                        <?= $i === 0 ? 'aria-current="true"' : ''; ?>
                        aria-label="Slide <?= $i + 1; ?>"
                    ></button>
                <?php endforeach; ?>
            </div>

            <div class="carousel-inner">
                <?php foreach ($banners as $i => $banner): ?>
                    <div class="carousel-item <?= $i === 0 ? 'active' : ''; ?>">
                        <img src="<?= 'reklaam/' . basename($banner); ?>" class="d-block w-100 hero-carousel-img" alt="Bänner">

                        <div class="carousel-caption text-start hero-caption">
                            <h1 class="display-5 fw-bold">Leia järgmine lemmikraamat</h1>
                            <p class="lead">Põnevad lood, teadmised ja inspiratsioon igale lugejale.</p>
                            <a href="#tooted" class="btn btn-primary btn-lg">Vaata tooteid</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Eelmine</span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Järgmine</span>
            </button>
        </div>
    <?php endif; ?>
</header>

<section class="container py-4" id="tooted">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Tooted</h2>
        <span class="text-muted">Kokku <?= count($books); ?> raamatut</span>
    </div>

    <div class="row g-4">
        <?php foreach ($books as $book): ?>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card h-100 shadow-sm book-card">
                    <img
                        src="<?= htmlspecialchars($book['pilt']); ?>"
                        class="card-img-top book-img"
                        alt="<?= htmlspecialchars($book['pealkiri']); ?>"
                    >
                    <div class="card-body d-flex flex-column">
                        <span class="badge text-bg-secondary mb-2 align-self-start">
                            <?= htmlspecialchars($book['kategooria']); ?>
                        </span>

                        <h5 class="card-title"><?= htmlspecialchars($book['pealkiri']); ?></h5>
                        <p class="card-text text-muted mb-2"><?= htmlspecialchars($book['autor']); ?></p>
                        <p class="price-tag mt-auto"><?= euro($book['hind']); ?></p>

                        <form method="post">
                            <input type="hidden" name="title" value="<?= htmlspecialchars($book['pealkiri']); ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-outline-primary w-100">
                                Lisa ostukorvi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>