<?php
// Διαγραφή των cookies
setcookie("username", "", time() - 3600, "/");
setcookie("first_name", "", time() - 3600, "/");
setcookie("last_name", "", time() - 3600, "/");
setcookie("email", "", time() - 3600, "/");

// Ανακατεύθυνση στη σελίδα σύνδεσης
header("Location: feed.php");
exit();
?>
