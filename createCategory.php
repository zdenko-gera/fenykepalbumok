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


<?php
if(isset($_GET["error"])) {
    if($_GET["error"] == "emptyfields") {
        echo "<div class='error-msg'>Adjon meg egy kommentet</div>";
    }
}
?>
<form action="includes/createCategory.inc.php" class="login-reg-form" method="POST">
    <input type="text" name="category-name" placeholder="Komment">
    <input type="submit" name="create-btn" value="Létrehozom">
</form>

<?php
include_once('partials/footer.php');
?>
</body>
</html>