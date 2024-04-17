<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/categories.css">
</head>
<body>
<?php
include_once('partials/navbar.php');
require_once('includes/db-conn.php');

echo '<h2>Fényképeim</h2>';
$stid = oci_parse($conn, 'SELECT * FROM IMAGES WHERE USER_ID = '. $_SESSION["userID"]);
oci_execute($stid);
while ( $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<h5>'.$row["IMAGE-TITLE"].'</h5>';
    echo '<img src="/uploadedImages/uploadedImg-'.$row["IMAGE_ID"].'" alt="foto">';
}
include_once('partials/footer.php');
?>
</body>
</html>