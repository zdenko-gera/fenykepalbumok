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

echo '<h2>Felhasználók</h2>';
echo '<table id="categories-table">';

$stid = oci_parse($conn, 'SELECT * FROM USERS');

oci_execute($stid);
while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['USER_ID'] . "</td>";
    echo "<td>" . $row['USERNAME'] . "</td>";
    echo "<td>" . $row['EMAIL'] . "</td>";
    echo "<td>" . $row['ROLE'] . "</td>";
    echo "<td>" . $row['LOCATION_ID'] . "</td>";
    echo '<td><form action="includes/deleteUser.inc.php" method="POST">
                    <input type="hidden" name="id-to-delete" value="'.$row["USER_ID"].'">
                    <input type="submit" name="delete-user-btn" id="" value="Törlés">
                    </form></td>';
    echo '<td>
              <form action="modify_user.php" method="POST">
                <input type="hidden" name="id-to-modify" value="' .$row["USER_ID"].'">
                <input type="submit" name="modify-user-btn" value="Módosítás">
              </form>
          </td>';
    echo "</tr>";
    echo "</tr>";

}
?>
<?php
echo '</table>';
    include_once('partials/footer.php');
    ?>
</body>
</html>

