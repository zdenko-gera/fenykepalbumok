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

$sql_top_uploader = "SELECT USER_ID, USERNAME, UPLOADED_IMAGES FROM USERS 
                    ORDER BY UPLOADED_IMAGES DESC 
                    FETCH FIRST 1 ROWS ONLY";
$statement_top_uploader = oci_parse($conn, $sql_top_uploader);
oci_execute($statement_top_uploader);
$row_top_uploader = oci_fetch_assoc($statement_top_uploader);
$top_uploader_user_id = $row_top_uploader['USER_ID'];
$top_uploader_username = $row_top_uploader['USERNAME'];
$top_uploaded_images = $row_top_uploader['UPLOADED_IMAGES'];


echo '<p><a href="stat_pics.php?user_id=' . $top_uploader_user_id . '">Kattints ide</a> a legtöbb képpel rendelkező felhasználó  (' . $top_uploader_username . ') képeinek megtekintéséhez! (' . $top_uploaded_images . ' kép)</p>';

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

include_once('partials/footer.php');
?>
</body>
</html>
