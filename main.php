<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">
</head>
<body>
<?php
include_once('partials/navbar.php');
require('includes/db-conn.php');

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
if(isset($_GET["create_category"])) {
    if($_GET["create_category"] == "success") {
        echo "<div class='success-msg'>Kategória létrehozva!</div>";
    }
}
if(isset($_GET["create_comment"])) {
    if($_GET["create_comment"] == "success") {
        echo "<div class='success-msg'>Komment létrehozva</div>";
    }
}
if(isset($_GET["create_location"])) {
    if($_GET["create_location"] == "success") {
        echo "<div class='success-msg'>Helyszín hozzáadva!</div>";
    }
}

?>
<h2>Tölts fel képeket, és indulj fotópályázatokon még ma!</h2>

<?php
if(isset($_SESSION["username"])) {
    echo '<a href="uploadImage.php" class="btn-w-padding">Feltöltés</a>';
} else {
    echo '<a href="login.php" class="btn-w-padding">Létrehozom!</a>';
}

$stid = oci_parse($conn, 'SELECT * FROM IMAGES');
oci_execute($stid);


?>

<div class="content-wrapper">
    <?php
        while ( $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            echo '<div class="main-page-image-wrapper">';
            echo '<img src="uploadedImages/uploadedImg-'.$row["IMAGE_ID"].'.jpg" alt="foto" class="my-photo">';
            echo '<p>'.$row["TITLE"].'</p>';
            echo '<p> Kat: '.$row["CATEGORY_ID"].'</p>';
            echo '<p> Hely: '.$row["LOCATION_ID"].'</p>';
            echo '</div>';
        }
    ?>    
</div>


<?php
    include_once('partials/footer.php');
?>
</body>
</html>
