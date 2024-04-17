<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/forms.css">
</head>
<body>
<?php
include_once('partials/navbar.php');
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<h2>Adj meg helyeket!</h2>
<?php
if(isset($_GET["error"])) {
    if($_GET["error"] == "emptyfields") {
        echo "<div class='error-msg'>Töltsd ki a mezőket!</div>";
    }
}
?>
<form action="includes/createLocation.inc.php" class="login-reg-form" method="POST">
    <input type="text" name="location-name" placeholder="Hely neve">
    <input type="text" name="location-country" placeholder="Ország">
    <input type="text" name="location-county" placeholder="Megye">
    <input type="text" name="location-city" placeholder="Város">

    <input type="submit" name="create-btn" value="Hozzáadom">
</form>

<?php
include_once('partials/footer.php');
?>
</body>
</html>