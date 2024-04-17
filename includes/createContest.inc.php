<?php
require("db-conn.php");
if(isset($_POST["contest-create-btn"])) {
    if(empty($_POST["contest-name"]) || empty($_POST["contest-desc"]) || empty($_POST["contest-start-date"]) || empty($_POST["contest-until-date"])) {
        header("Location: ../adminPage.php?error=emptyfields");
        exit();
    }

    $contestName = $_POST["contest-name"];
    $contestDesc = $_POST["contest-desc"];
    $contestStart = $_POST["contest-start-date"];
    $contestEnd = $_POST["contest-until-date"];


    $sql= "INSERT INTO CONTESTS (CONTEST_NAME, CONTEST_DESCRIPTION, START_DATE, END_DATE) VALUES (:contestName, :contestDesc, TO_DATE(:contestStart,'YYYY-MM-DD'), TO_DATE(:contestEnd,'YYYY-MM-DD'))";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt,':contestName',$contestName);
    oci_bind_by_name($stmt,':contestDesc',$contestDesc);
    oci_bind_by_name($stmt,':contestStart',$contestStart);
    oci_bind_by_name($stmt,':contestEnd',$contestEnd);



    oci_execute($stmt);

    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    } else {
        oci_free_statement($stmt);
        header("Location: ../adminPage.php?create_contest=success");
        exit();
    }
} else {
    echo 'Hozzáférés megtagadva!';
}