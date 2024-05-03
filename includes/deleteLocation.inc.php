<?php
require_once('db-conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['location_id'])) {
    $location_id = $_POST['location_id'];

    $stid = oci_parse($conn, 'BEGIN DeleteLocation(:p_location_id); END;');
    oci_bind_by_name($stid, ':p_location_id', $location_id);
    oci_execute($stid);

    oci_free_statement($stid);
    oci_close($conn);

    header("Location: ../locations.php");
    exit();
}
?>

