<?php
include 'db.php';

$errors = [];

// Χειρισμός φόρμας εγγραφής
if (isset($_POST['register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Έλεγχοι εγκυρότητας
    if (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
        $errors[] = "Το όνομα πρέπει να περιέχει μόνο χαρακτήρες.";
    }
    if (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $errors[] = "Το επώνυμο πρέπει να περιέχει μόνο χαρακτήρες.";
    }
    if (strlen($password) < 4 || strlen($password) > 10 || !preg_match("/\d/", $password)) {
        $errors[] = "Ο κωδικός πρόσβασης πρέπει να έχει μήκος μεταξύ 4 και 10 χαρακτήρων και να περιέχει τουλάχιστον έναν αριθμό.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, '@') === false) {
        $errors[] = "Το email δεν είναι έγκυρο.";
    }

    // Έλεγχος μοναδικότητας username και email
    $sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $errors[] = "Το όνομα χρήστη ή το email είναι ήδη καταχωρημένα.";
    }

    // Εισαγωγή χρήστη στη βάση δεδομένων αν δεν υπάρχουν σφάλματα
    if (empty($errors)) {
        $sql = "INSERT INTO users (first_name, last_name, username, password, email) VALUES ('$first_name', '$last_name', '$username', '$password', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "Η εγγραφή ήταν επιτυχής. Παρακαλώ συνδεθείτε.";
        } else {
            echo "Σφάλμα: " . $sql . "<br>" . $conn->error;
        }
    }
}


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        setcookie('username', $user['username'], time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie('first_name', $user['first_name'], time() + (86400 * 30), "/");
        setcookie('last_name', $user['last_name'], time() + (86400 * 30), "/");
        setcookie('email', $user['email'], time() + (86400 * 30), "/");

        header("Location: feed.php");
        exit();
    } else {
        $error = "Λάθος όνομα χρήστη ή κωδικός πρόσβασης.";
    }
}

if (isset($_COOKIE['username'])) {
    header("Location: feed.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Σύνδεση/Εγγραφή</title>
    <link rel="stylesheet" href="styles.css">
    <script src="login_script.js" defer></script>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <?php
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p class='error'>$error</p>";
        }
    }
    ?>
    <div id="login-register-forms">
        <form id="login-form" method="post" action="login_register.php">
            <h2>Σύνδεση</h2>
            <label for="login-username">Όνομα χρήστη:</label>
            <input type="text" name="username" id="login-username" required>
            <label for="login-password">Κωδικός πρόσβασης:</label>
            <input type="password" name="password" id="login-password" required>
            <button type="submit" name="login">Σύνδεση</button>
            <p>Δεν έχετε λογαριασμό; <a href="#" id="show-register-form">Εγγραφή</a></p>
        </form>

        <form id="register-form" method="post" action="login_register.php" style="display: none;">
            <h2>Εγγραφή</h2>
            <label for="first_name">Όνομα:</label>
            <input type="text" name="first_name" id="first_name" required>
            <label for="last_name">Επώνυμο:</label>
            <input type="text" name="last_name" id="last_name" required>
            <label for="username">Όνομα χρήστη:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Κωδικός πρόσβασης:</label>
            <input type="password" name="password" id="password" required>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required>
            <button type="submit" name="register">Εγγραφή</button>
            <p>Έχετε ήδη λογαριασμό; <a href="#" id="show-login-form">Σύνδεση</a></p>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
