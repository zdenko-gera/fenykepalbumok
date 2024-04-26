<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/forms.css">
</head>
<body>
<?php
include_once('partials/navbar.php');
require_once('includes/db-conn.php');

?>

<h2>Regisztráció</h2>
<form action="includes/register.inc.php" class="login-reg-form" method="POST">
    <input type="text" name="username" placeholder="Felhasználónév">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="pwd" placeholder="Jelszó">
    <input type="password" name="repwd" placeholder="Jelszó mégegyszer">
    <select name="location">
      <option disabled selected value>Lakhely</option>
      <?php 
      $stid = oci_parse($conn, 'SELECT * FROM LOCATIONS');
      oci_execute($stid);

      while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo '<option value="'.htmlspecialchars($row['LOCATION_ID']).'">'.htmlspecialchars($row['LOCATION_NAME']).'</option>';
      }
      ?>
    </select>
    <input type="submit" name="register-btn" value="Regisztrálok">
</form>

<?php
include_once('partials/footer.php');
?>
</body>
</html>
