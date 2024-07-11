<header>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <nav>
    <button class="hamburger-menu" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </button>
        <div id ="topnav" class="topnav">
        <ul>
            <li><a href="Feed.php">Feed</a></li>
            <li><a href="Create_Listing.php">Create Listing</a></li>
            <?php
            if (isset($_COOKIE['username'])) {
                echo '<li><a href="logout.php">Logout</a></li>';
            } else {
                echo '<li><a href="login_register.php">Login</a></li>';
            }
            ?>
        </ul>
        </div>

    </nav>
    
</header>

<script>
      function toggleMenu() {
          var x = document.getElementById("topnav");
          if (x.classList.contains("active")) {
              x.classList.remove("active");
           } else {
               x.classList.add("active");
           }
       }
</script>