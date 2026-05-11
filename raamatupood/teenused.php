<?php
$pageTitle = 'Raamatupood - Teenused';
require_once __DIR__ . '/includes/header.php';
?>

<section class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Teenused</h1>
        <p class="lead text-muted">
            Pakume mugavat tellimist, kinkepakendit ja soodsaid pakkumisi kõigile raamatusõpradele.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="h2 mb-3">Kiire tellimine</h3>
                    <p class="text-muted">
                        Telli mugavalt veebist ja lisa soovitud raamatud ostukorvi.
                        Meie süsteem aitab sul kiiresti leida sobivad tooted ja vormistada tellimuse.
                    </p>
                    <a href="index.php#tooted" class="btn btn-outline-dark">Vaata tooteid</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="h2 mb-3">Kinkepakend</h3>
                    <p class="text-muted">
                        Ostukorvis saab lisada kinkepakendi hinnaga 2 €
                        iga raamatu kohta. See teeb tellimuse eriti sobivaks kingituseks.
                    </p>
                    <a href="ostukorv.php" class="btn btn-outline-dark">Ava ostukorv</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="h2 mb-3">Sooduskoodid</h3>
                    <p class="text-muted">
                        Kasuta kampaaniakoodi <strong>RAAMAT10</strong> ja saa
                        tellimuselt 10% allahindlust. Sooduskood töötab ostukorvis.
                    </p>
                    <a href="ostukorv.php" class="btn btn-outline-dark">Kasuta soodustust</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-light py-5 border-top border-bottom">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Miks valida meie raamatupood?</h2>
                <p class="text-muted">
                    Meie veebileht on ehitatud Bootstrapiga, on kohanduv erinevatele seadmetele
                    ning võimaldab mugavalt sirvida tooteid, lisada neid ostukorvi ja arvutada tellimuse lõpphinda.
                </p>
                <ul class="list-group list-group-flush shadow-sm">
                    <li class="list-group-item">Responsive Bootstrap kujundus</li>
                    <li class="list-group-item">Ostukorv ja tellimuse arvutamine</li>
                    <li class="list-group-item">Kinkepakendi lisamise võimalus</li>
                    <li class="list-group-item">Sooduskoodi kasutamine</li>
                </ul>
            </div>

            <div class="col-lg-6">
                <div class="p-4 bg-white rounded-4 shadow-sm">
                    <h3 class="mb-3">Teenuste kokkuvõte</h3>
                    <p><strong>Tellimine:</strong> kiire ja lihtne ostuprotsess.</p>
                    <p><strong>Ostukorv:</strong> kogused, hind ja tellimuse arvutamine ühes kohas.</p>
                    <p><strong>Soodustus:</strong> RAAMAT10 annab 10% allahindlust.</p>
                    <p class="mb-0"><strong>Kinkepakend:</strong> +2 € iga raamatu kohta.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>