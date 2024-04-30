<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/forms.css">
</head>
<body>
<?php
include_once('partials/navbar.php');
require('includes/db-conn.php');
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
if(isset($_GET["upload"])) {
    if($_GET["upload"] == "success") {
        echo "<div class='success-msg'>Sikeres képfeltöltés!</div>";
            $sql_increment_images = "UPDATE USERS SET UPLOADED_IMAGES = UPLOADED_IMAGES + 1  WHERE USER_ID = '" . $_SESSION["userID"] . "'";
            $statement_increment_images = oci_parse($conn, $sql_increment_images);
            oci_execute($statement_increment_images);
    }
}
?>

<h2>Képfeltöltés</h2>

<form action="includes/uploadImage.inc.php" class="login-reg-form" method="POST" enctype="multipart/form-data">
    <input type="text" name="image-title" placeholder="Kép címe">
    <select name="image-location">
      <option disabled selected value>Válassz helyszínt!</option>
      <?php 
      $stid = oci_parse($conn, 'SELECT * FROM LOCATIONS');
      oci_execute($stid);

      while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo '<option value="'.htmlspecialchars($row['LOCATION_ID']).'">'.htmlspecialchars($row['LOCATION_NAME']).'</option>';
      }
      ?>
    </select>


    <select name="image-category">
      <option disabled selected value>Válassz kategóriát!</option>
      <?php 
      $stid = oci_parse($conn, 'SELECT * FROM CATEGORIES');
      oci_execute($stid);

      while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo '<option value="'.htmlspecialchars($row['CATEGORY_ID']).'">'.htmlspecialchars($row['CATEGORY_NAME']).'</option>';
      }
      ?>
    </select>

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