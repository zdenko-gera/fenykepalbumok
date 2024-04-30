<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">
</head>
<body>
<?php
    include_once('partials/navbar.php');
    require_once("includes/db-conn.php");
?>

<div id="db-conn-response">
<?php

$tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    )
    (CONNECT_DATA =
      (SID = xe)
    )
  )";

$conn = oci_connect('ATTILA','oracle', $tns, 'UTF8');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
} else {
    echo '<img src="icons/green-checkmark-icon.svg" alt="pipa" id="db-tick"><p>Adatbáziskapcsolat sikeresen létrehozva!</p>';
    echo '</div>';
    echo '<a href="main.php" class="btn-w-padding" id="jumo-to-main-page-btn">Tovább a kezdőlapra!</a>';
}
?>

<?php
include_once('partials/footer.php');
?>
</body>
</html>
