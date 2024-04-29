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

// Ellenőrizzük, hogy a location_id paraméter át lett-e adva az URL-ben
if(isset($_GET["location_id"])) {
    // Lekérjük a location_id értékét
    $locationID = $_GET["location_id"];

    // SQL lekérdezés összeállítása és előkészítése
    $stid = oci_parse($conn, 'SELECT * FROM IMAGES WHERE LOCATION_ID = :locationID');
    oci_bind_by_name($stid, ':locationID', $locationID);

    // Lekérdezés végrehajtása
    oci_execute($stid);

    echo '<h2>Fényképek</h2>';

    echo '<div class="content-wrapper">';

    // Fényképek megjelenítése
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo '<a href="image.php?id='.$row["IMAGE_ID"].'" class="main-page-image-wrapper">';
        echo '<img src="uploadedImages/uploadedImg-'.$row["IMAGE_ID"].'.jpg" alt="foto" class="my-photo">';
        echo '<p>'.$row["TITLE"].'</p>';
        echo '</a>';
    }

    echo '</div>';
    oci_free_statement($stid);
    echo '<h2>A város arcai</h2>';

    $stnd = oci_parse($conn, 'SELECT * FROM (
                                    SELECT u.USERNAME, COUNT(i.IMAGE_ID) AS num_images
                                    FROM USERS u
                                    JOIN IMAGES i ON u.USER_ID = i.USER_ID
                                    JOIN LOCATIONS l ON i.LOCATION_ID = l.LOCATION_ID
                                    WHERE l.LOCATION_ID = :locationID
                                    GROUP BY u.USERNAME
                                    ORDER BY num_images DESC) 
                                    WHERE ROWNUM <= 3');

    oci_bind_by_name($stnd, ':locationID', $locationID);

    oci_execute($stnd);

    echo '<div id="trendy-dests-wrapper">';
    while ( $row = oci_fetch_array($stnd, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<h2>'.$row["USERNAME"].'</h2>';
}
echo '</div>';


    // Lekérdezés eredményének felszabadítása

} else {
    // Ha a location_id paraméter nincs átadva az URL-ben
    echo "Hiba: Nincs megadva location_id paraméter az URL-ben.";
}

include_once('partials/footer.php');
?>

</body>
</html>

