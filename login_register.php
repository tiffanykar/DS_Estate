<?php
include 'db.php';
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
