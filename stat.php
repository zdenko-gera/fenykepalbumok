<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">

</head>
<body>
<?php
include_once('partials/navbar.php');
require_once('includes/db-conn.php');


echo '<h2 style="text-align: center">Statisztikák</h2>';


$sql_users = "SELECT COUNT(*) as total_users FROM USERS";
$statement_users = oci_parse($conn, $sql_users);
oci_execute($statement_users);
$row_users = oci_fetch_assoc($statement_users);
$total_users = $row_users['TOTAL_USERS'];
echo '<div id="trendy-dests-wrapper">';
echo '<h2>Felhasználók</h2>';
echo '<p>Az összes felhasználó a fényképalbum alkalmazásban: ' . $total_users . '</p>';
$sql_uploaders_with_images = "SELECT u.USER_ID, u.USERNAME, COUNT(i.IMAGE_ID) AS num_images
                    FROM USERS u
                    INNER JOIN IMAGES i ON u.USER_ID = i.USER_ID
                    GROUP BY u.USER_ID, u.USERNAME
                    ORDER BY num_images DESC";
$statement_uploaders_with_images = oci_parse($conn, $sql_uploaders_with_images);
oci_execute($statement_uploaders_with_images);

echo '<div>';
echo '<table id="categories-table">';
echo '<tr><th>Felhasználónév</th><th>Feltöltött képek száma</th></tr>';
while ($row = oci_fetch_assoc($statement_uploaders_with_images)) {
    echo '<tr>';
    echo '<td><a href="stat_pics.php?user_id=' . $row["USER_ID"] . '">' . $row["USERNAME"] . '</a></td>';
    echo '<td>' . $row["NUM_IMAGES"] . '</td>';
    echo '</tr>';
}
echo '</table>';
echo '</div>';

echo '</table>';
echo '</div>';

echo '</div>';

echo '<p></p>';

$sql_upload_count_by_date = "SELECT TO_CHAR(UPLOAD_DATE, 'YYYY-MM-DD') AS upload_date, COUNT(*) AS upload_count
                             FROM IMAGES
                             GROUP BY TO_CHAR(UPLOAD_DATE, 'YYYY-MM-DD')
                             ORDER BY UPLOAD_DATE DESC";
$statement_upload_count_by_date = oci_parse($conn, $sql_upload_count_by_date);
oci_execute($statement_upload_count_by_date);
echo '<div id="trendy-dests-wrapper">';

echo "<h2 style='text-align: match-parent'>Feltöltések száma idő szerint</h2>";
echo '<p></p>';

echo "<ul>";
while ($row_upload_count = oci_fetch_assoc($statement_upload_count_by_date)) {
    $upload_date = $row_upload_count['UPLOAD_DATE'];

    $upload_count = $row_upload_count['UPLOAD_COUNT'];

    echo "<p><li>{$upload_date}: {$upload_count} <a href='stat_pics.php?upload_date={$upload_date}'>Kép</a> </li></p>";
}

echo '</div>';
echo "</ul>";

echo '<p></p>';

echo '<div id="trendy-dests-wrapper">';

$sql = "SELECT c.CATEGORY_NAME, COUNT(i.CATEGORY_ID) AS num_images
        FROM CATEGORIES c
        LEFT JOIN IMAGES i ON c.CATEGORY_ID = i.CATEGORY_ID
        GROUP BY c.CATEGORY_NAME
        ORDER BY num_images DESC
        FETCH FIRST 5 ROWS ONLY";

$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

echo "<h2>Legnépszerűbb kategóriák:</h2>";
echo "<ul>";
while ($row = oci_fetch_assoc($stmt)) {
    echo "<li>" . $row['CATEGORY_NAME'] . ": " . $row['NUM_IMAGES'] . " kép</li>";
}
echo "</ul>";

echo '</div>';

echo '<p></p>';
echo '<div id="trendy-dests-wrapper">';


$sql = "SELECT i.IMAGE_ID, i.IMAGE_PATH, i.TITLE, COUNT(c.COMMENT_ID) AS num_comments
        FROM IMAGES i
        LEFT JOIN COMMENTS c ON i.IMAGE_ID = c.IMAGE_ID
        GROUP BY i.IMAGE_ID, i.IMAGE_PATH, i.TITLE
        ORDER BY num_comments DESC
        FETCH FIRST 1 ROW ONLY";

$statement = oci_parse($conn, $sql);
oci_execute($statement);

if ($row = oci_fetch_assoc($statement)) {
    $num_comments = $row['NUM_COMMENTS'];

    echo "A legtöbb kommenttel rendelkező kép: <br>";

    echo "Kommentek száma: $num_comments <br>";


    echo '<a href="image.php?id=' . $row["IMAGE_ID"] . '" class="main-page-image-wrapper">';
    echo '<img src="uploadedImages/uploadedImg-' . $row["IMAGE_ID"] . '.jpg" alt="foto" class="my-photo">';
    echo '<p>' . $row["TITLE"] . '</p>';
    echo '</a>';

} else {
    echo "Nincs ilyen kép a rendszerben.";
}
echo '</div>';



include_once('partials/footer.php');
?>
</body>
</html>
