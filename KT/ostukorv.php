<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Turismibüroo</title>

</head>
<body>
<div class="container mt-5">
    <h2>Kalkulaator</h2>
    <form action="calculate.php" method="post">
        <div class="form-group">
            <label for="people">Inimeste arv:</label>
            <input type="number" class="form-control" id="people" name="people" required>
        </div>
        <div class="form-group">
            <label for="additional_services">Lisateenused:</label>
            <select class="form-control" id="additional_services" name="additional_services">
                <option value="0">Ei</option>
                <option value="50">Giid (50 EUR)</option>
                <option value="30">Kindlustus (30 EUR)</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Arvuta</button>
    </form>
</div>