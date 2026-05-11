<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function euro(float $amount): string
{
    return number_format($amount, 2, ',', ' ') . ' €';
}

function title_to_image(string $title): string
{
    $map = [
        'Harry Potter ja tarkade kivi' => 'pilt10.jpg',
        'Sõrmuste isand: Sõrmuse vennaskond' => 'pilt11.jpg',
        '1984' => 'pilt12.jpg',
        'Uhkus ja eelarvamus' => 'pilt13.jpg',
        'Suur Gatsby' => 'pilt14.jpg',
        'Kuritöö ja karistus' => 'pilt15.jpg',
        'Väike prints' => 'pilt16.jpg',
        'Da Vinci kood' => 'pilt17.jpg',
        'Alkeemik' => 'pilt18.jpg',
        'Näljamängud' => 'pilt19.jpg',
        'Hobbit' => 'pilt20.jpg',
        'Tuulest viidud' => 'pilt21.jpg',
        'Mõtle ja saa rikkaks' => 'pilt22.jpg',
        'Steve Jobs' => 'pilt23.jpg',
        'Sherlock Holmes: Baskerville’ide koer' => 'pilt24.jpg',
        'Tappa laulurästast' => 'pilt25.jpg',
    ];

    return 'pildid/' . ($map[$title] ?? 'clean-architecture.svg');
    
}

function get_books(string $file = 'books.csv'): array
{
    $books = [];

    if (!file_exists($file)) {
        return $books;
    }

    if (($handle = fopen($file, 'r')) !== false) {
        $header = fgetcsv($handle, 0, ',');

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            if (count($row) < 4) {
                continue;
            }

            $books[] = [
                'pealkiri' => $row[0],
                'autor' => $row[1],
                'hind' => (float) $row[2],
                'kategooria' => $row[3],
                'pilt' => title_to_image($row[0]),
            ];
        }

        fclose($handle);
    }

    return $books;
}

function get_cart_count(): int
{
    return array_sum($_SESSION['cart'] ?? []);
}

function add_to_cart(string $title): void
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][$title] = ($_SESSION['cart'][$title] ?? 0) + 1;
}

function get_cart_items(array $books): array
{
    $cart = $_SESSION['cart'] ?? [];
    $items = [];
    foreach ($books as $book) {
        $title = $book['pealkiri'];
        if (isset($cart[$title])) {
            $book['qty'] = $cart[$title];
            $book['summa'] = $book['hind'] * $book['qty'];
            $items[] = $book;
        }
    }
    return $items;
}

function cart_total(array $items): float
{
    return array_reduce($items, fn($carry, $item) => $carry + $item['summa'], 0.0);
}

function random_banner_images(string $dir = 'reklaam'): array
{
    $files = glob($dir . '/*.{jpg,jpeg,png,gif,webp,svg}', GLOB_BRACE) ?: [];
    shuffle($files);
    return array_slice($files, 0, min(4, count($files)));
}
