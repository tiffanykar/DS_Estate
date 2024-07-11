<?php
include 'db.php';

// Ανάκτηση δεδομένων ακινήτων από τη βάση δεδομένων
$sql = "SELECT * FROM listings";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Κύρια Σελίδα - Ακίνητα προς Μίσθωση</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h1>Ακίνητα προς Μίσθωση</h1>
    <div class="listings">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='listing'>";
                echo "<img src='" . htmlspecialchars($row['photo']) . "' alt='Φωτογραφία Ακινήτου' class='listing-img'>";
                echo "<h2>" . $row['title'] . "</h2>";
                echo "<p>Περιοχή: " . $row['area'] . "</p>";
                echo "<p>Πλήθος δωματίων: " . $row['rooms'] . "</p>";
                echo "<p>Τιμή ανά διανυκτέρευση: " . $row['price_per_night'] . "€</p>";
                if (isset($_COOKIE['username'])) {
                    echo "<a href='booker.php?title=" . urlencode($row['title']) . "'>Κράτηση</a>";
                } else {
                    echo "<p><a href='login_register.php'>Συνδεθείτε</a> για να κάνετε κράτηση.</p>";
                }
                echo "</div>";
            }
        } else {
            echo "<p>Δεν υπάρχουν διαθέσιμα ακίνητα.</p>";
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
