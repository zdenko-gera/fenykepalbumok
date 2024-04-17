<?php
require("db-conn.php");
if(isset($_POST["create-btn"])) {
    if(empty($_POST["comment-name"])) {
        header("Location: ../createComment.php?error=emptyfields");
        exit();
    }

    $categoryName = $_POST["comment-name"];

    $sql= 'INSERT INTO COMMENTS (CONTENT) VALUES (:commentName)';
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt,':commentName',$commentName);


    oci_execute($stmt);

    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    } else {
        oci_free_statement($stmt);
        header("Location: ../main.php?create_comment=success");
        exit();
    }
} else {
    echo 'Hozzáférés megtagadva!';
}
