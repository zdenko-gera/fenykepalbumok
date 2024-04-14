<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">
</head>
<body>
<?php
include_once('partials/navbar.php');

if(isset($_GET["signup"])) {
    if($_GET["signup"] == "success") {
        echo "<div class='success-msg'>Sikeresen regisztráltál! Mostmár bejelentkezhetsz!</div>";
    }
}
if(isset($_GET["logout"])) {
    if($_GET["logout"] == "success") {
        echo "<div class='success-msg'>Sikeresen kijelentkeztél!</div>";
    }
}
if(isset($_GET["login"])) {
    if($_GET["login"] == "success") {
        echo "<div class='success-msg'>Szia, ".$_SESSION["username"]."!</div>";
    }
}

?>
<h2>Hozd létre az első fotóalbumodat nálunk!</h2>

<?php
if(isset($_SESSION["username"])) {
    echo '<a href="createAlbum.php" class="btn-w-padding">Létrehozom!</a>';
} else {
    echo '<a href="login.php" class="btn-w-padding">Létrehozom!</a>';
}
?>


<?php
    include_once('partials/footer.php');
?>
</body>
</html>
