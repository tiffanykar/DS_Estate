<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Έλεγχος αν ο χρήστης είναι συνδεδεμένος
    if (!isset($_COOKIE['username'])) {
        echo "Πρέπει να συνδεθείτε για να δημιουργήσετε αγγελία.";
        exit;
    }

    // Συλλογή δεδομένων από τη φόρμα
    $title = $_POST['title'];
    $area = $_POST['area'];
    $rooms = $_POST['rooms'];
    $price_per_night = $_POST['price_per_night'];
    $photo = $_FILES['photo'];


    // Διαχείριση αρχείου εικόνας
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Έλεγχος αν το αρχείο είναι εικόνα
    $check = getimagesize($photo["tmp_name"]);
    if ($check === false) {
        echo "Το αρχείο δεν είναι έγκυρη εικόνα.";
        exit;
    }

    // Έλεγχος αν το αρχείο υπάρχει ήδη
    if (file_exists($target_file)) {
        echo "Το αρχείο υπάρχει ήδη.";
        exit;
    }

    // Επιτρεπόμενοι τύποι αρχείων
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Επιτρέπονται μόνο αρχεία JPG, JPEG, PNG & GIF.";
        exit;
    }

    // Μετακίνηση του αρχείου στην κατάλληλη τοποθεσία
    if (!move_uploaded_file($photo["tmp_name"], $target_file)) {
        echo "Υπήρξε πρόβλημα με την αποστολή του αρχείου.";
        exit;
    }

    // Αποθήκευση αγγελίας στη βάση δεδομένων
    $sql = "INSERT INTO listings (title, area, rooms, price_per_night, photo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiis", $title, $area, $rooms, $price_per_night, $target_file);

    if ($stmt->execute()) {
        echo "Η αγγελία δημιουργήθηκε επιτυχώς!";
        header("Location: feed.php");
        exit;
    } else {
        echo "Σφάλμα: " . $stmt->error;
    }

    $stmt->close();
}
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



