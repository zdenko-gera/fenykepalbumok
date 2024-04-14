<?php
require("db-conn.php");
if(isset($_POST["create-btn"])) {
    if(empty($_POST["category-name"])) {
        header("Location: ../createCategory.php?error=emptyfields");
        exit();
    }

    $categoryName = $_POST["category-name"];

    $sql= 'INSERT INTO CATEGORIES (CATEGORY_NAME) VALUES (:categoryName)';
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt,':categoryName',$categoryName);


    oci_execute($stmt);

    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    } else {
        header("Location: ../main.php?create_category=success");
        exit();
    }
    oci_free_statement($stmt);
} else {
    echo 'Hozzáférés megtagadva!';
}