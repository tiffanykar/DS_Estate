<header>
    <nav>
        <ul>
            <li><a href="feed.php">Feed</a></li>
            <li><a href="create_listing.php">Create Listing</a></li>
            <?php if (isset($_COOKIE['username'])): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login_register.php">Login</a></li>
        <?php endif; ?>
        </ul>
    </nav>
</header>
