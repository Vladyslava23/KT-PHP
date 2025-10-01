<?php
require __DIR__ . '/includes/header.php';

$sent = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $msg   = trim($_POST['message'] ?? '');

    if ($name === '')  $errors[] = 'Nimi on kohustuslik.';
    if ($email === '' && $phone === '') $errors[] = 'Sisesta vähemalt e-post või telefon.';
    if ($msg === '')   $errors[] = 'Sõnum ei tohi olla tühi.';

    if (!$errors) {
        $contact = [
            'created_at' => date('c'),
            'name'       => $name,
            'email'      => $email,
            'phone'      => $phone,
            'message'    => $msg,
        ];
        save_contact_to_file($contact);
        $sent = true;
    }
}
?>

<h2 class="mb-4">Kontakt</h2>

<?php if ($sent): ?>
  <div class="alert alert-success">Aitäh! Teie sõnum on salvestatud.</div>
<?php endif; ?>

<?php if ($errors): ?>
  <div class="alert alert-danger">
    <?php foreach ($errors as $e) echo '<div>'.h($e).'</div>'; ?>
  </div>
<?php endif; ?>

<div class="row g-4">
  <div class="col-12 col-md-6">
    <form method="post" action="contact.php" class="card card-body shadow-sm">
      <div class="mb-3">
        <label class="form-label">Nimi *</label>
        <input type="text" name="name" class="form-control" value="<?php echo h($_POST['name'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">E-post</label>
        <input type="email" name="email" class="form-control" value="<?php echo h($_POST['email'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Telefon</label>
        <input type="text" name="phone" class="form-control" value="<?php echo h($_POST['phone'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Sõnum *</label>
        <textarea name="message" rows="5" class="form-control"><?php echo h($_POST['message'] ?? '') ?></textarea>
      </div>
      <button class="btn btn-blue">Saada</button>
    </form>
  </div>

  <div class="col-12 col-md-6">
    <!-- Google Maps iFrame (jätan sinu lingi) -->
    <div class="ratio ratio-4x3 rounded shadow-sm">
      <iframe src="https://www.google.com/maps?q=59.4370,24.7536&hl=et&z=12&output=embed" loading="lazy"></iframe>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
