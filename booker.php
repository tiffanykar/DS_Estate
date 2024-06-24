<?php
include 'header.php';
include 'db.php';
?>

<div class="container">
    <link rel="stylesheet" href="styles.css">
    <script src="scripter.js" defer></script>
    <h1>Κράτηση Ακινήτου: <?php echo htmlspecialchars($property['title']); ?></h1>
    <img src="<?php echo htmlspecialchars($property['photo']); ?>" alt="Φωτογραφία ακινήτου" class="listing-img">
    <p>Περιοχή: <?php echo htmlspecialchars($property['area']); ?></p>
    <p>Πλήθος δωματίων: <?php echo htmlspecialchars($property['rooms']); ?></p>
    <p>Τιμή ανά διανυκτέρευση: <span id="price_per_night"><?php echo htmlspecialchars($property['price_per_night']); ?></span>€</p>


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
        <form id="complete_booking" method="post" action="booker.php?title=<?php echo urlencode($title); ?>">
            <input type="hidden" id ="step" name="step" value="2">
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
            <input type="button" id="submit_final" value="Ολοκλήρωση Κράτησης">
        </form>

    <?php endif; ?>
</div>

<?php
include 'footer.php';
?>