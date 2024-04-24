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

$categoryID = $_GET["category_id"];


echo '<h2>Kategória</h2>';


$categoryID = $_GET["category_id"];
$stmt = oci_parse($conn, 'SELECT IMAGES.IMAGE_PATH, AVG(PHOTORATING.RATING) AS AVG_RATING FROM IMAGES INNER JOIN photorating ON IMAGES.IMAGE_ID = PHOTORATING.PHOTOID WHERE IMAGES.CATEGORY_ID = :categoryID GROUP BY IMAGES.IMAGE_PATH ORDER BY AVG_RATING DESC');
oci_bind_by_name($stmt,':categoryID',$categoryID);
oci_execute($stmt);
if (!oci_execute($stmt)) {
    echo 'Nincs a keresésnek megfelelő elem!';
}
while ( $row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<img src="uploadedImages/'.$row["IMAGE_PATH"].'" alt="feltoltott kep" id="image-site-img">';
    echo '<p>' . $row["AVG_RATING"] . '</p>';
}


include_once('partials/footer.php');
?>
</body>
</html>