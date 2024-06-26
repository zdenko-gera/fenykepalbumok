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

$categoryID = $_GET["category_id"];

$stid = oci_parse($conn, 'SELECT * FROM CATEGORIES WHERE CATEGORY_ID = :categoryID');

oci_bind_by_name($stid,':categoryID',$categoryID);
oci_execute($stid);
$categoryDetails = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);

echo '<h2>Legjobb 3 kép <b>' . $categoryDetails["CATEGORY_NAME"] . '</b> témában a felhasználói értékelések alapján:</h2>';
oci_free_statement($stid);

$top = oci_parse($conn, 'SELECT * FROM (SELECT IMAGES.IMAGE_PATH, IMAGES.IMAGE_ID, ROUND(AVG(PHOTORATING.RATING),2) AS AVG_RATING FROM IMAGES LEFT JOIN photorating ON IMAGES.IMAGE_ID = PHOTORATING.PHOTOID WHERE IMAGES.CATEGORY_ID = :categoryID AND (SELECT COUNT(*) AS CNT FROM PHOTORATING WHERE PHOTOID = IMAGES.IMAGE_ID) > 0 GROUP BY IMAGES.IMAGE_PATH, IMAGES.IMAGE_ID ORDER BY AVG_RATING DESC) WHERE ROWNUM <= 3');

oci_bind_by_name($top,':categoryID',$categoryID);
oci_execute($top);

echo '<div class="content-wrapper top-three-images">';
while ( $row = oci_fetch_array($top, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<a href="image.php?id='.$row["IMAGE_ID"].'" class="main-page-image-wrapper">';
    echo '<img src="uploadedImages/'.$row["IMAGE_PATH"].'" alt="foto" class="my-photo">';
    echo '<p>Értékelés: '.$row["AVG_RATING"].'</p>';
    echo '</a>';
}
echo '</div>';
oci_free_statement($top);

//képek darabszáma az adott kategóriában:
$countPerCategoryStmt = oci_parse($conn, 'SELECT COUNT(IMAGE_ID) AS CNT_OF_IMG_IN_CATEGORY FROM IMAGES  WHERE IMAGES.CATEGORY_ID = :categoryID ');

oci_bind_by_name($countPerCategoryStmt,':categoryID',$categoryID);
oci_execute($countPerCategoryStmt);
$countPerCategory = oci_fetch_array($countPerCategoryStmt, OCI_ASSOC + OCI_RETURN_NULLS)["CNT_OF_IMG_IN_CATEGORY"];
oci_free_statement($countPerCategoryStmt);



$stmt = oci_parse($conn, 'SELECT IMAGES.IMAGE_PATH, IMAGES.IMAGE_ID, ROUND(AVG(PHOTORATING.RATING),2) AS AVG_RATING FROM IMAGES LEFT JOIN photorating ON IMAGES.IMAGE_ID = PHOTORATING.PHOTOID WHERE IMAGES.CATEGORY_ID = :categoryID GROUP BY IMAGES.IMAGE_PATH, IMAGES.IMAGE_ID');

oci_bind_by_name($stmt,':categoryID',$categoryID);
oci_execute($stmt);
if (!oci_execute($stmt)) {
    echo 'Nincs a keresésnek megfelelő elem!';
}

echo '<h2>További képeink a(z) <b>' . $categoryDetails["CATEGORY_NAME"] . '</b> témában:</h2>';
echo '<p>Képek a kategóriában: '.$countPerCategory.' db</p>';

echo '<div class="content-wrapper">';
while ( $row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<a href="image.php?id='.$row["IMAGE_ID"].'" class="main-page-image-wrapper">';
    echo '<img src="uploadedImages/'.$row["IMAGE_PATH"].'" alt="foto" class="my-photo">';
    echo '<p>Értékelés: '.$row["AVG_RATING"].'</p>';
    echo '</a>';
}
echo '</div>';


include_once('partials/footer.php');
?>
</body>
</html>