<?php
// Include a db-conn.php fájlt a kapcsolódáshoz az adatbázishoz
require_once('db-conn.php');

// Ellenőrizd, hogy a módosítás gombra kattintva érkezett-e kérés
if(isset($_POST["modify-user-btn"])) {
    // Ellenőrizd, hogy a felhasználó ID-t megadták-e az űrlapról
    if(empty($_POST["id-to-modify"])) {
        header("Location: users.php?error=emptyuserid");
        exit();
    }

    // Ellenőrizd, hogy a felhasználónév és az e-mail cím mezők kitöltésre kerültek-e
    if(empty($_POST["new-username"]) || empty($_POST["new-email"])) {
        header("Location: modify_user.php?error=emptyfields");
        exit();
    }

    // Mentés a változókba az űrlapról érkező adatokat
    $userID = $_POST["id-to-modify"];
    $newUsername = $_POST["new-username"];
    $newEmail = $_POST["new-email"];

    // Ellenőrizd az e-mail cím formátumát
    if(!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        header("Location: modify_user.php?error=invalidemail");
        exit();
    }

    // Ellenőrizd, hogy a felhasználónév és az e-mail cím már létezik-e más felhasználónál
    $sql_check_duplicate = "SELECT * FROM USERS WHERE (USERNAME = :newUsername OR EMAIL = :newEmail) AND USER_ID != :userID";
    $stmt_check_duplicate = oci_parse($conn, $sql_check_duplicate);
    oci_bind_by_name($stmt_check_duplicate, ':newUsername', $newUsername);
    oci_bind_by_name($stmt_check_duplicate, ':newEmail', $newEmail);
    oci_bind_by_name($stmt_check_duplicate, ':userID', $userID);
    oci_execute($stmt_check_duplicate);
    $row_check_duplicate = oci_fetch_array($stmt_check_duplicate, OCI_ASSOC);
    if($row_check_duplicate) {
        header("Location: modify_user.php?error=userexists");
        exit();
    }

    // Felhasználó adatainak frissítése az adatbázisban
    $sql_update_user = "UPDATE USERS SET USERNAME = :newUsername, EMAIL = :newEmail WHERE USER_ID = :userID";
    $stmt_update_user = oci_parse($conn, $sql_update_user);
    oci_bind_by_name($stmt_update_user, ':newUsername', $newUsername);
    oci_bind_by_name($stmt_update_user, ':newEmail', $newEmail);
    oci_bind_by_name($stmt_update_user, ':userID', $userID);
    oci_execute($stmt_update_user);

    // Ellenőrizd, hogy a módosítás sikeres volt-e
    if($stmt_update_user) {
        header("Location: ../users.php?success=update");
        exit();
    } else {
        header("Location: ../users.php?error=sqlerror");
        exit();
    }
} else {
    // Ha nem érkezett megfelelő kérés a módosítás gombra kattintva, irányítsd vissza a felhasználó listázó oldalra
    header("Location: users.php");
    exit();
}
?>
