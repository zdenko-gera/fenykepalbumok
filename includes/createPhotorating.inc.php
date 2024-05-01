<?php
require("db-conn.php");

$imageID = $_POST["rated-image-id"];
$ratingUser = $_POST["rating-user"];

if(isset($_POST["create-btn"])) {
    if(empty($_POST["rating"])) {
        header("Location: ../image.php?id=" . $imageID . "&error=emptyfields");
        exit();
    }

    // Ellenőrzés, hogy a felhasználó már értékelte-e a képet
    $sqlCheckRated = "SELECT * FROM PHOTORATING WHERE RATINGUSERID = :ratingUser AND PHOTOID = :imageID";
    $stmtCheckRated = oci_parse($conn, $sqlCheckRated);
    oci_bind_by_name($stmtCheckRated, ':ratingUser', $ratingUser);
    oci_bind_by_name($stmtCheckRated, ':imageID', $imageID);
    oci_execute($stmtCheckRated);

    // Ha már van értékelése a felhasználónak a képhez, akkor hibaüzenet
    if(oci_fetch($stmtCheckRated)) {
        header("Location: ../image.php?id=" . $imageID . "&error=already_rated");
        exit();
    }

    // Ha még nincs értékelése, akkor az új értékelés létrehozása
    $rating = $_POST["rating"];
    $sqlCreateRating = "INSERT INTO PHOTORATING (PHOTOID, RATINGUSERID, RATING) VALUES (:imageID, :ratingUser, :rating)";
    $stmtCreateRating = oci_parse($conn, $sqlCreateRating);
    oci_bind_by_name($stmtCreateRating, ':imageID', $imageID);
    oci_bind_by_name($stmtCreateRating, ':ratingUser', $ratingUser);
    oci_bind_by_name($stmtCreateRating, ':rating', $rating);

    oci_execute($stmtCreateRating);

    header("Location: ../image.php?id=" . $imageID . "&photorating=success");
    exit();
}
?>
