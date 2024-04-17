<?php
require("db-conn.php");
if(isset($_POST["login-btn"])) {
    if(empty($_POST["username"])) {
        header("Location: ../login.php?error=emptyfields");
        exit();
    }
    if(empty($_POST["pwd"])) {
        header("Location: ../login.php?error=emptyfields");
        exit();
    }
    if(!empty($_POST["username"]) && !empty($_POST["pwd"])) {
        $username = $_POST["username"];
        $pwd = $_POST["pwd"];

        $sql = 'SELECT * FROM USERS WHERE USERNAME=:username';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt,':username',$username);
        oci_execute($stmt);
        if($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {

            if (password_verify($pwd, $row["PASSWORD"])) {
                session_start();
                $_SESSION["userID"] = $row["USER_ID"];
                $_SESSION["username"] = $row["USERNAME"];
                $_SESSION["email"] = $row["EMAIL"];
                $_SESSION["role"] = $row["ROLE"];

                header("Location: ../main.php?login=success");
                exit();


            } else {
                header("Location: ../login.php?error=wrongpassword");
                exit();
            }
        } else {
            header("Location: ../login.php?error=nouser");
            exit();
        }

    }




} else {
    echo 'Hozzáférés megtagadva!';
}

