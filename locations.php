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

echo '<h2>Helyszínek</h2>';
echo '<table id="categories-table">';

$stid = oci_parse($conn, 'SELECT * FROM LOCATIONS');

oci_execute($stid);

while ( $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<tr>';

    echo '<td>'.$row["LOCATION_ID"].'</td>';
    echo '<td><a href="location.php?location_id='.$row["LOCATION_ID"].'">' . $row["LOCATION_NAME"] . '</a></td>';
    echo '<td>'.$row["COUNTRY"].'</td>
            <td>'.$row["COUNTY"].'</td>
            <td>'.$row["CITY"].'</td>';

    $sub_sql = 'SELECT COUNT(IMAGE_ID) AS IMAGE_COUNT FROM IMAGES WHERE LOCATION_ID = '.$row["LOCATION_ID"];
    $valami = oci_parse($conn, $sub_sql);
    oci_execute($valami);
    $gyik = oci_fetch_array($valami, OCI_ASSOC + OCI_RETURN_NULLS);

    echo '<td>'.$gyik["IMAGE_COUNT"].' db</td>';

    //helyszinenkenti atlag ertekeles lekérdezése
    $avg_per_location = 'SELECT ROUND(AVG(RATING),2) AS AVG_RATING FROM PHOTORATING INNER JOIN IMAGES ON PHOTOID = IMAGE_ID WHERE LOCATION_ID = '.$row["LOCATION_ID"];
    $avg_per_location_stmt = oci_parse($conn, $avg_per_location);
    oci_execute($avg_per_location_stmt);
    $row_2 = oci_fetch_array($avg_per_location_stmt, OCI_ASSOC + OCI_RETURN_NULLS);
    echo '<td>Átl. ért.:'.$row_2["AVG_RATING"].'</td>';

    echo '<td><form method="post" action="includes/deleteLocation.inc.php">';
    echo '<input type="hidden" name="location_id" value="'.$row["LOCATION_ID"].'">';
    echo '<input type="submit" value="Törlés" onclick="return confirm(\'Biztosan törölni szeretné ezt a helyszínt?\')">';
    echo '</form></td>';

    echo '</tr>';
}
?>

<tr><td></td><td><a href="createLocation.php"><img src="icons/plus-round-line-icon.svg" alt="plusz-jel" id="add-category-plus-icon"></a></td></tr>

<?php
echo '</table>';



include_once('partials/footer.php');
?>
</body>
</html>