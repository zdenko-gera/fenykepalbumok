<?php
require("db-conn.php");
if(isset($_POST["create-btn"])) {

    $commentWrittenBy = $_POST["comment-written-by"];
    $commentToImage = $_POST["comment-to-image-id"];
    $commentDate = date("Y-m-d");

    if(empty($_POST["comment-content"])) {
        header("Location: image.php?id=".$commentToImage."&error=emptyfields");
        exit();
    }

    $commentContent = $_POST["comment-content"];


    $sql= "INSERT INTO COMMENTS (CONTENT, COMMENT_DATE, USER_ID, IMAGE_ID) VALUES (:commentContent, TO_DATE(:commentDate,'YYYY-MM-DD'), :commentWrittenBy, :commentToImage)";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt,':commentContent',$commentContent);
    oci_bind_by_name($stmt,':commentWrittenBy',$commentWrittenBy);
    oci_bind_by_name($stmt,':commentToImage',$commentToImage);
    oci_bind_by_name($stmt,':commentDate',$commentDate);

    oci_execute($stmt);

    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    } else {
        oci_free_statement($stmt);
        header("Location: ../image.php?id={$commentToImage}&create_comment=success");
        exit();
    }
} else {
    echo 'Hozzáférés megtagadva!';
}
