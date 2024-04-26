<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">
</head>
<body>
<?php
include_once('partials/navbar.php');
require_once('includes/db-conn.php');

echo '<h2>Népszerű Úticélok</h2>';
echo '<p>A 3 legnépszerűbb úticél a feltöltések alapján</p>';

$stid = oci_parse($conn, 'select * from locations inner join (select * from (select images.location_id, count(image_id) as cnt_of_locs from images inner join users on images.user_id = users.user_id where images.location_id != users.location_id group by images.location_id order by cnt_of_locs desc) where rownum <= 3)images on locations.location_id = images.location_id');

oci_execute($stid);
echo '<div id="trendy-dests-wrapper">';
while ( $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<a href="location.php?location_id='.$row["LOCATION_ID"].'" class="trendy-dest">';
    echo '<h2>'.$row["LOCATION_NAME"].'</h2>';
    echo '<p>'.$row["CNT_OF_LOCS"].' vidéki feltöltés</p>';
    echo '</a>';
}
echo '</div>';

include_once('partials/footer.php');
?>
</body>
</html>