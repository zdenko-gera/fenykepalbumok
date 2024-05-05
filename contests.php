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

if(isset($_GET["delete_contest"])) {
    if($_GET["delete_contest"] == "success") {
        echo "<div class='success-msg'>Sikeres törlés!</div>";
    }
}

echo '<h2>Fotópályázatok</h2>';
echo '<table id="categories-table">';
$stid = oci_parse($conn, 'SELECT * FROM CONTESTS');
echo '<tr><th>Azon.</th><th>Cím</th><th>Leírás</th><th>Kezdőidőpont</th><th>Határidő</th></tr>';

oci_execute($stid);
while ( $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<tr>';
    echo '<td>'.$row["CONTEST_ID"].'</td>';
    echo '<td><a href="category.php?category_id='.$row["CONTEST_ID"].'">' . $row["CONTEST_NAME"] . '</a></td>';
    echo '<td>'.$row["CONTEST_DESCRIPTION"].'</td>';
    echo '<td>'.$row["START_DATE"].'</td>';
    echo '<td>'.$row["END_DATE"].'</td>';
    if ($_SESSION["role"] === 'admin') {
        echo '<td><form action="includes/deleteContest.inc.php" method="POST">
                    <input type="hidden" name="id-to-delete" value="'.$row["CONTEST_ID"].'">
                    <input type="submit" name="delete-contest-btn" id="" value="Törlés">
                    </form></td>';
    }
    echo '</tr>';
}
?>

<?php
echo '</table>';



include_once('partials/footer.php');
?>
</body>
</html>