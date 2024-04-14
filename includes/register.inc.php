<?php
require("db-conn.php");
if(isset($_POST["register-btn"])) {
    //Üres mezők ellenőrzése:

    if(empty($_POST["username"])) {
        header("Location: ../register.php?error=emptyfields");
        exit();
    }
    if(empty($_POST["email"])) {
        header("Location: ../register.php?error=emptyfields");
        exit();
    }
    if(empty($_POST["pwd"])) {
        header("Location: ../register.php?error=emptyfields");
        exit();
    }
    if(empty($_POST["repwd"])) {
        header("Location: ../register.php?error=emptyfields");
        exit();
    }
    if($_POST["pwd"] != $_POST["repwd"]){
        header("Location: ../register.php?error=passwords-not-matching");
        exit();
    }

    $username = $_POST["username"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $repwd = $_POST["repwd"];
    $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
    $role = "user";



    $sql= 'INSERT INTO USERS (USERNAME, PASSWORD, EMAIL) VALUES (:username, :pwd, :email)';
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt,':username',$username);
    oci_bind_by_name($stmt,':email',$email);
    oci_bind_by_name($stmt,':pwd',$pwdHash);

    oci_execute($stmt);

    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    } else {
        header("Location: ../main.php?signup=success");
        exit();
    }
    oci_free_statement($stmt);


} else {
    echo 'Hozzáférés megtagadva!';
}
