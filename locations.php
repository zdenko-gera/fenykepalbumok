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
    echo '<td><a href="category.php?category_id='.$row["LOCATION_ID"].'">' . $row["LOCATION_NAME"] . '</a></td>';
    echo '<td>'.$row["COUNTRY"].'</td>
            <td>'.$row["COUNTY"].'</td>
            <td>'.$row["CITY"].'</td>';

    $sub_sql = 'SELECT COUNT(IMAGE_ID) AS IMAGE_COUNT FROM IMAGES WHERE LOCATION_ID = '.$row["LOCATION_ID"];
    $valami = oci_parse($conn, $sub_sql);
    oci_execute($valami);
    $gyik = oci_fetch_array($valami, OCI_ASSOC + OCI_RETURN_NULLS);

    echo '<td>'.$gyik["IMAGE_COUNT"].' db</td>';

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