<?php
require("db-conn.php");
if(isset($_POST["create-btn"])) {
    if(empty($_POST["location-name"]) || empty($_POST["location-country"]) || empty($_POST["location-county"]) || empty($_POST["location-city"])) {
        header("Location: ../createLocation.php?error=emptyfields");
        exit();
    }

    $locationName = $_POST["location-name"];
    $country = $_POST["location-country"];
    $county = $_POST["location-county"];
    $city = $_POST["location-city"];


    $sql= 'INSERT INTO LOCATIONS (LOCATION_NAME, COUNTRY, CITY, COUNTY) VALUES (:location_name, :country, :city, :county)';
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt,':location_name',$locationName);
    oci_bind_by_name($stmt,':country',$country);
    oci_bind_by_name($stmt,':city',$city);
    oci_bind_by_name($stmt,':county',$county);



    oci_execute($stmt);

    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);

    } else {
        oci_free_statement($stmt);
        header("Location: ../main.php?create_location=success");
        exit();
    }
} else {
    echo 'Hozzáférés megtagadva!';
}