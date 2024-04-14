<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">
</head>
<body>
<?php
    include_once('partials/navbar.php');
?>

<div id="db-conn-response">
<?php

$tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1500))
    )
    (CONNECT_DATA =
      (SID = xe)
    )
  )";

$conn = oci_connect('ZDENKO','palacsinta', $tns, 'UTF8');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
} else {
    echo '<p>Adatbáziskapcsolat sikeresen létrehozva!</p>';
    echo '</div>';
    echo '<a href="main.php" id="jumo-to-main-page-btn">Tovább a kezdőlapra!</a>';
}
?>

</body>
</html>
