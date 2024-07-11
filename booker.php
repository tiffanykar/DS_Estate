<?php
include 'header.php';
include 'db.php';

// Έλεγχος σύνδεσης χρήστη
if (!isset($_COOKIE['username'])) {
    echo "Ο χρήστης δεν είναι συνδεδεμένος.";
    header("Location: login_register.php");
    exit();
}

// Έλεγχος αν υπάρχει τίτλος ακινήτου
if (!isset($_GET['title'])) {
    echo "Ο τίτλος του ακινήτου δεν έχει δοθεί.";
    header("Location: feed.php");
    exit();
}

$title = $_GET['title'];
$username = $_COOKIE['username'];

// Ανάκτηση πληροφοριών ακινήτου
$query = "SELECT * FROM listings WHERE title = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    echo "Σφάλμα προετοιμασίας ερωτήματος: " . $conn->error;
    exit();
}

$stmt->bind_param("s", $title);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();

if (!$property) {
    echo "Το ακίνητο δεν βρέθηκε.";
    header("Location: feed.php");
    exit();
}

$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    echo "Σφάλμα προετοιμασίας ερωτήματος: " . $conn->error;
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "Ο χρήστης δεν βρέθηκε.";
    header("Location: login_register.php");
    exit();
}

$error = '';
$step = 1;
$total_amount = 0;
$discount = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $step = (int)$_POST['step'];
    if ($step == 1) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // Έλεγχος διαθεσιμότητας
        $query = "SELECT COUNT(*) AS count FROM reservations WHERE title = ? AND (start_date <= ? AND end_date >= ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $title, $end_date, $start_date);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if ($data['count'] > 0) {
            $error = "Το ακίνητο δεν είναι διαθέσιμο για τις επιλεγμένες ημερομηνίες.";
        } else {
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $total_amount = $_POST['total_amount'];
            $discount = $_POST['discount'];
            $step = 2;
        }
    } elseif ($step == 2) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $total_amount = $_POST['total_amount'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];

        // Έλεγχος αν όλες οι απαιτούμενες τιμές έχουν υποβληθεί
        if (!empty($start_date) && !empty($end_date) && !empty($total_amount) && !empty($first_name) && !empty($last_name) && !empty($email)) {
            $query = "INSERT INTO reservations (username, title, start_date, end_date, total_amount) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssi", $username, $title, $start_date, $end_date, $total_amount);
            $stmt->execute();
            
            if ($stmt->error) {
                echo "Error: " . $stmt->error;
            }else{
                header("Location: feed.php");
            }
        } else {
            $error = "Παρακαλώ συμπληρώστε όλα τα πεδία.";
        }
    }
}

?>

<div class="container">
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="scripter.js" defer></script>
    <h1>Κράτηση Ακινήτου: <?php echo htmlspecialchars($property['title']); ?></h1>
    <img src="<?php echo htmlspecialchars($property['photo']); ?>" alt="Φωτογραφία ακινήτου" class="listing-img">
    <p>Περιοχή: <?php echo htmlspecialchars($property['area']); ?></p>
    <p>Πλήθος δωματίων: <?php echo htmlspecialchars($property['rooms']); ?></p>
    <p>Τιμή ανά διανυκτέρευση: <span id="price_per_night"><?php echo htmlspecialchars($property['price_per_night']); ?></span>€</p>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>



    <?php if ($step == 1): ?>
        <form id="submit_booking" method="post" action="booker.php?title=<?php echo urlencode($title); ?>">
            <input type="hidden" id="step" name="step" value="1">
            <input type="hidden" id="total_amount" name="total_amount">
            <input type="hidden" id="discount" name="discount">
            <input type="hidden" id="first_name" name="first_name" value="<?php echo htmlspecialchars($_COOKIE['first_name']); ?>">
            <input type="hidden" id="last_name" name="last_name" value="<?php echo htmlspecialchars($_COOKIE['last_name']); ?>">
            <input type="hidden" id="email" name="email" value="<?php echo htmlspecialchars($_COOKIE['email']); ?>">
            <label for="start_date">Ημερομηνία Έναρξης:</label>
            <input type="date" id="start_date" name="start_date" required><br>

            <label for="end_date">Ημερομηνία Λήξης:</label>
            <input type="date" id="end_date" name="end_date" required><br>

            <input type="submit" id="submit_date" value="Συνέχεια">
            <p>Συνολικό Ποσό: <span id="total_amount_display"></span>€ (έκπτωση <span id="discount_display"></span>)</p>
        </form>
    <?php elseif ($step == 2): ?>
        <form id="complete_booking" method="post" action="">
            <input type="hidden" id="step" name="step" value="2">
            <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
            <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
            <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($total_amount); ?>">

            <label for="first_name">Όνομα:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($_COOKIE['first_name']); ?>" required><br>
            <label for="last_name">Επώνυμο:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($_COOKIE['last_name']); ?>" required><br>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_COOKIE['email']); ?>" required><br>

            <p>Συνολικό ποσό: <?php echo htmlspecialchars($total_amount); ?>€</p>
            <input type="submit" id="submit_final" value="Ολοκλήρωση Κράτησης">
        </form>

    <?php endif; ?>
</div>

<?php
include 'footer.php';
?>