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
<form action="includes/login.inc.php" class="login-reg-form">
    <input type="text" placeholder="Felhasználónév">
    <input type="password" placeholder="jelszó">
    <input type="submit" value="Bejelentkezés">
</form>

<?php
include_once('partials/footer.php');
?>
</body>
</html>