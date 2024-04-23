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

echo '<h2>Fényképeim</h2>
<div class="content-wrapper">
';
$stid = oci_parse($conn, 'SELECT * FROM IMAGES WHERE USER_ID = '. $_SESSION["userID"]);
oci_execute($stid);
while ( $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<a href="image.php?id='.$row["IMAGE_ID"].'" class="main-page-image-wrapper">';
    echo '<img src="uploadedImages/uploadedImg-'.$row["IMAGE_ID"].'.jpg" alt="foto" class="my-photo">';
    echo '<p>'.$row["TITLE"].'</p>';
    echo '</a>';
}
include_once('partials/footer.php');
?>
</div>
</body>
</html>