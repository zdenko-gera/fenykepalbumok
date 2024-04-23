<?php
    session_start();
?>
<header>
    <div id="navbar">
        <a href="main.php" id="navbar-title">Fényképalbumok</a>
            <div id="navbar-links-container">
                <?php
                    if(isset($_SESSION["username"])) {
                        echo '<a href="myProfile.php" id="navbar-username">'.$_SESSION["username"].'</a>';
                        if($_SESSION["role"] === 'admin') {
                            echo '<a href="adminPage.php" class="navbar-link">ADMIN-OLDAL</a>';
                        }
                        echo '<a href="uploadImage.php" class="navbar-link">Képfeltöltés</a>';
                        echo '<a href="contests.php" class="navbar-link">Fotópályázatok</a>';
                        echo '<a href="locations.php" class="navbar-link">Helyszínek</a>';
                        echo '<a href="categories.php" class="navbar-link">Kategóriák</a>';
                        echo '<a href="includes/logout.inc.php" class="navbar-link">Kijelentkezés</a>';
                    } else {
                        echo '<a href="login.php" class="navbar-link">Képfeltöltés</a>';
                        echo '<a href="locations.php" class="navbar-link">Helyszínek</a>';
                        echo '<a href="categories.php" class="navbar-link">Kategóriák</a>';
                        echo '
                            <a href="login.php" class="navbar-link">Bejelentkezés</a>
                            <a href="register.php" class="navbar-link">Regisztráció</a>';
                    }
                ?>
            </div>
    </div>
</header>