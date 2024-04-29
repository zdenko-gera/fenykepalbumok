<?php
require("db-conn.php");
if(isset($_POST["delete-user-btn"])) {
    $userID = $_POST["id-to-delete"];


    $sql= "DELETE FROM USERS WHERE USER_ID = :userID";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt,':userID',$userID);



    oci_execute($stmt);

    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    } else {
        oci_free_statement($stmt);
        //echo $contestStart;
        header("Location: ../users.php?delete_user=success");
        exit();
    }
} else {
    echo 'Hozzáférés megtagadva!';
}