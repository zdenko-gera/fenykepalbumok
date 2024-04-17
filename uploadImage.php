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

<h2>Képfeltöltéss</h2>

<form action="uploadImage.inc.php" class="login-reg-form" method="POST" enctype="multipart/form-data">
    <input type="text" name="image-title" placeholder="Kép címe">
    <input type="text" name="image-category" placeholder="Kép kategóriája">
    <input type="text" name="image-location" placeholder="Kép helyszíne">
    <?php
    echo '
    <input type="hidden" name="image-owner" value="'.$_SESSION["userID"].'">
    <input type="hidden" name="image-owner-email" value="'.$_SESSION["email"].'">';
    ?>



    <input type="file" name="image" id="image-to-upload">
    <input type="submit" name="upload-btn" value="Feltöltés">
</form>

<?php
include_once('partials/footer.php');
?>
</body>
</html>