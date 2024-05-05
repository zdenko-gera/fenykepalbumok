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

echo '<h2>Kategóriák<h2>';

$stid = oci_parse($conn, 'BEGIN list_categories_data; END;');
if (!$stid) {
    $m = oci_error($conn);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

// Engedélyezzük a DBMS_OUTPUT használatát
$s = oci_parse($conn, 'begin dbms_output.enable; end;');
if(oci_execute($s)){
    if(oci_execute($stid)){
        // Lekérdezzük a DBMS_OUTPUT-ból az adatokat
        $s = oci_parse($conn, 'begin dbms_output.get_line(:ln, :st); end;');
        oci_bind_by_name($s, ":ln", $ln, 32767);
        oci_bind_by_name($s, ":st", $st);

        echo '<table id="categories-table">';
        while (($succ = oci_execute($s)) && !$st){
            echo '<tr><td>' . $ln . '</td></tr>';
        }
        echo '</table>';
    }
}

echo '<table id="categories-table">';
$sql_categories = oci_parse($conn, 'SELECT * FROM CATEGORIES');
oci_execute($sql_categories);
while ( $row = oci_fetch_array($sql_categories, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<tr><td><a href="category.php?category='.$row["CATEGORY_ID"].'">'.$row["CATEGORY_NAME"].'</a></td></tr>';
}
echo '</table>';

oci_free_statement($stid);
oci_close($conn);

include_once('partials/footer.php');
?>
</body>
</html>
