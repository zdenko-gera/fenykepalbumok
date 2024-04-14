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

<h2>Regisztráció</h2>
<form action="includes/register.inc.php" class="login-reg-form" method="POST">
    <input type="text" name="username" placeholder="Felhasználónév">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="pwd" placeholder="Jelszó">
    <input type="password" name="repwd" placeholder="Jelszó mégegyszer">
    <input type="submit" name="register-btn" value="Regisztrálok">
</form>

<?php
include_once('partials/footer.php');
?>
</body>
</html>
