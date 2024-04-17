<?php
require("includes/db-conn.php");

if(isset($_POST["upload-btn"])) {
    $targetDir = "uploadedImages/";  // A feltöltött képek mappája
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        echo "A fájl egy kép - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "A fájl nem egy kép.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        //echo "Csak JPG, JPEG, PNG és GIF fájlokat lehet feltölteni.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "A fájlt nem sikerült feltölteni.";
    } else {
        $sql='SELECT MAX(IMAGE_ID) AS MAX_ID FROM IMAGES';
        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $maxID = $row['MAX_ID'];
        $nextID = $maxID+1;


        if (move_uploaded_file($_FILES["image"]["tmp_name"], 'uploadedImages/uploadedImg-'.$nextID .'.'.$imageFileType)) {
            echo "A fájl " . basename($_FILES["image"]["name"]) . " sikeresen feltöltve.";

            // Itt mentheted az elérési utat az adatbázisban, ha szükséges
            // Például:
            // $imageUrl = $targetDir . basename($_FILES["fileToUpload"]["name"]);
            // ... SQL INSERT művelet a kép elérési útjának mentésére ...

        } else {
            echo "Hiba történt a fájl feltöltése közben.";
        }
    }
} else {
    echo 'Hozzáférés megtagadva!';
}
?>
