<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Δημιουργία Αγγελίας</title>
    <link rel="stylesheet" href="styles.css">
    <script src="create_script.js" defer></script>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h1>Δημιουργία Αγγελίας</h1>
    <form action="create_listing.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="photo">Φωτογραφία του ακινήτου:</label>
        <input type="file" id="photo" name="photo" required><br><br>

        <label for="title">Τίτλος:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="area">Περιοχή:</label>
        <input type="text" id="area" name="area" required><br><br>

        <label for="rooms">Πλήθος δωματίων:</label>
        <input type="text" id="rooms" name="rooms" required><br><br>

        <label for="price_per_night">Τιμή ανά διανυκτέρευση:</label>
        <input type="text" id="price_per_night" name="price_per_night" required><br><br>

        <input type="submit" id ="submit_listing" value="Δημιουργία Αγγελίας">
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>



