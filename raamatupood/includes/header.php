<?php
require_once __DIR__ . '/functions.php';

$cartCount = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (is_array($item)) {
            if (isset($item['qty'])) {
                $cartCount += (int)$item['qty'];
            } elseif (isset($item['kogus'])) {
                $cartCount += (int)$item['kogus'];
            } else {
                $cartCount += 1;
            }
        } else {
            $cartCount += (int)$item;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Raamatupood'; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Raamatupood</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Avaleht</a></li>
                <li class="nav-item"><a class="nav-link" href="teenused.php">Teenused</a></li>
                <li class="nav-item"><a class="nav-link" href="kontakt.php">Kontakt</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="ostukorv.php">
                        Ostukorv
                        <span class="badge bg-warning text-dark"><?= $cartCount ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="flex-fill">