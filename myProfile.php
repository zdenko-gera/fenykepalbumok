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

$user_id = $_SESSION["userID"];

echo '<h2>Fényképeim</h2>
<div class="content-wrapper">
';
$stid = oci_parse($conn, 'SELECT * FROM IMAGES WHERE USER_ID = '. $_SESSION["userID"]);
oci_execute($stid);
while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<a href="image.php?id='.$row["IMAGE_ID"].'" class="main-page-image-wrapper">';
    echo '<img src="uploadedImages/uploadedImg-'.$row["IMAGE_ID"].'.jpg" alt="foto" class="my-photo">';
    echo '<p>'.$row["TITLE"].'</p>';
    echo '</a>';
}

echo '</div>'; // bezárjuk a content-wrapper div-et, hogy a footer elé kerüljön

echo '<div>';
echo '<h2>Kedvenc kategóriáim</h2>';


// Végrehajtjuk a lekérdezést és tároljuk az eredményt
$sql = "SELECT CATEGORY_NAME, AVG_RATING
        FROM (
            SELECT c.CATEGORY_NAME, AVG(pr.RATING) AS AVG_RATING
            FROM PHOTORATING pr
            JOIN IMAGES i ON pr.PHOTOID = i.IMAGE_ID
            JOIN CATEGORIES c ON i.CATEGORY_ID = c.CATEGORY_ID
            WHERE pr.RATINGUSERID = :user_id
            GROUP BY c.CATEGORY_NAME
            ORDER BY AVG_RATING DESC
        )
        WHERE ROWNUM <= 3";


$statement = oci_parse($conn, $sql);
oci_bind_by_name($statement, ':user_id', $user_id);
oci_execute($statement);

// Táblázat fejlécének kiírása
echo '<table>';
echo '<tr><th>Kategória</th><th>Átlagos értékelésem</th></tr>';

// Eredmények soronkénti feldolgozása és kiírása
while ($row = oci_fetch_assoc($statement)) {
    echo '<tr>';
    echo '<td>' . $row['CATEGORY_NAME'] . '</td>';
    echo '<td>' . $row['AVG_RATING'] . '</td>';
    echo '</tr>';
}

// Táblázat lezárása
echo '</table>';


echo '</div>';

include_once('partials/footer.php'); // footer az oldal végén

?>
</body>
</html>
