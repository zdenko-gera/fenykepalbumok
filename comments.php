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

echo '<h2>Kommentek</h2>';

echo '<table id="categories-table">';
$stid = oci_parse($conn, 'SELECT * FROM COMMENTS');

oci_execute($stid);
while ( $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<tr>';
    echo '<td>'.$row["COMMENT_ID"].'</td>';
    echo '<td><a href="category.php?category_id='.$row["COMMENT_ID"].'">' . $row["CONTENT"] . '</a></td>';
    echo '<td>'.$row["COMMENT_DATE"].'</td>';


}

?>

<tr><td></td><td><a href="createComment.php"><img src="icons/plus-round-line-icon.svg" alt="plusz-jel" id="add-category-plus-icon"></a></td></tr>

<?php
echo '</table>';



include_once('partials/footer.php');
?>
</body>
</html>