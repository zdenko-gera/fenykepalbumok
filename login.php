<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/forms.css">
</head>
<body>
<?php
include_once('partials/navbar.php');
?>

<h2>Jelentkezz be, majd hozz létre saját albumokat!</h2>
<?php
if(isset($_GET["error"])) {
    if($_GET["error"] == "nouser") {
        echo "<div class='error-msg'>Nincs ilyen felhasználó!</div>";
    }
    if($_GET["error"] == "wrongpassword") {
        echo "<div class='error-msg'>Rossz jelszó!</div>";
    }
}
?>
<form action="includes/login.inc.php" class="login-reg-form" method="POST">
    <input type="text" name="username" placeholder="Felhasználónév">
    <input type="password" name="pwd" placeholder="jelszó">
    <input type="submit" name="login-btn" value="Bejelentkezés">
</form>

<?php
include_once('partials/footer.php');
?>
</body>
</html>