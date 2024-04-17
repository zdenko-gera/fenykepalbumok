<?php
require("db-conn.php");
if(isset($_POST["delete-contest-btn"])) {
    $contestID = $_POST["id-to-delete"];


    $sql= "DELETE FROM CONTESTS WHERE CONTEST_ID = :contestID";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt,':contestID',$contestID);



    oci_execute($stmt);

    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    } else {
        oci_free_statement($stmt);
        //echo $contestStart;
        header("Location: ../contests.php?delete_contest=success");
        exit();
    }
} else {
    echo 'Hozzáférés megtagadva!';
}