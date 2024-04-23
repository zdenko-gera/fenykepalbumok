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

$userID = $_GET["id"];

$stid = oci_parse($conn, 'SELECT USERNAME FROM USERS WHERE USER_ID = :userID');
oci_bind_by_name($stid, ':userID', $userID);
oci_execute($stid);
$username = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)["USERNAME"];
oci_free_statement($stid);


?>
<h2><?php echo $username; ?> Fényképei:</h2>

<div class="content-wrapper">
<?php
$stid = oci_parse($conn, 'SELECT * FROM LOCATIONS INNER JOIN IMAGES ON LOCATIONS.LOCATION_ID = IMAGES.LOCATION_ID INNER JOIN CATEGORIES ON IMAGES.CATEGORY_ID = CATEGORIES.CATEGORY_ID WHERE IMAGES.USER_ID = :userID');
oci_bind_by_name($stid, ':userID', $userID);
oci_execute($stid);
while ( $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<a href="image.php?id='.$row["IMAGE_ID"].'" class="main-page-image-wrapper">';
    echo '<img src="uploadedImages/uploadedImg-'.$row["IMAGE_ID"].'.jpg" alt="foto" class="my-photo">';
    echo '<p>'.$row["TITLE"].'</p>';
    echo '<p> Kat: '.$row["CATEGORY_NAME"].'</p>';
    echo '<p> Hely: '.$row["LOCATION_NAME"].'</p>';
    echo '</a>';
}
include_once('partials/footer.php');
?>
</div>
</body>
</html>