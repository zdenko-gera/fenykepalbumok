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

echo '<h2>Kategória</h2>';


$categoryID = $_GET["category_id"];
$stmt = oci_parse($conn, 'SELECT * FROM IMAGES WHERE CATEGORY_ID = :categoryID');
oci_bind_by_name($stmt,':categoryID',$categoryID);
oci_execute($stmt);
if (!oci_execute($stmt)) {
    echo 'Nincs a keresésnek megfelelő elem!';
}
while ( $row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<p>'.$row["IMAGE_PATH"].'</p>';
}


include_once('partials/footer.php');
?>
</body>
</html>