<?php
    session_start();
?>
<header>
    <div id="navbar">
        <a href="main.php" id="navbar-title">Fényképalbumok</a>
            <div id="navbar-links-container">
                <?php
                    if(isset($_SESSION["username"])) {
                        echo '<span id="navbar-username">'.$_SESSION["username"].'</span>';
                        echo '<a href="includes/logout.inc.php" class="navbar-link">Kijelentkezés</a>';
                    } else {
                        echo '
                            <a href="login.php" class="navbar-link">Bejelentkezés</a>
                            <a href="register.php" class="navbar-link">Regisztráció</a>';
                    }
                ?>
            </div>
    </div>
</header>