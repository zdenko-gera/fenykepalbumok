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
if (isset($_GET["user_id"])){
    $user_id = $_GET['user_id'];

    $stid = oci_parse($conn, "SELECT * FROM IMAGES WHERE USER_ID = $user_id");

    oci_execute($stid);

    echo '<h2 style="text-align: center">A felhasználó fényképei</h2>';

    echo '<div class="content-wrapper">';


    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo '<a href="image.php?id=' . $row["IMAGE_ID"] . '" class="main-page-image-wrapper">';
        echo '<img src="uploadedImages/uploadedImg-' . $row["IMAGE_ID"] . '.jpg" alt="foto" class="my-photo">';
        echo '<p>' . $row["TITLE"] . '</p>';
        echo '</a>';
    }

    echo '</div>';
    oci_free_statement($stid);

}elseif(isset($_GET["upload_date"])){
    $upload_date = $_GET['upload_date'];

    $upload_date_formatted = date('Y-m-d', strtotime($upload_date));

    $stid = oci_parse($conn, "SELECT * FROM IMAGES WHERE UPLOAD_DATE = TO_DATE('$upload_date_formatted', 'YYYY-MM-DD') ");
     oci_execute($stid);

    echo "<h2 style='text-align: center'>" .$upload_date. "</h2>";

    echo '<div class="content-wrapper">';


    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo '<a href="image.php?id=' . $row["IMAGE_ID"] . '" class="main-page-image-wrapper">';
        echo '<img src="uploadedImages/uploadedImg-' . $row["IMAGE_ID"] . '.jpg" alt="foto" class="my-photo">';
        echo '<p>' . $row["TITLE"] . '</p>';
        echo '</a>';
    }

    echo '</div>';
    oci_free_statement($stid);
}


include_once('partials/footer.php');
?>

</body>
</html>

