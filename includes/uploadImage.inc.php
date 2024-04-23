<?php
require("db-conn.php");

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

    if ($imageFileType != "jpg") {
        echo "Csak JPG fájlokat lehet feltölteni.";
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


        if (move_uploaded_file($_FILES["image"]["tmp_name"], '../uploadedImages/uploadedImg-'.$nextID .'.'.$imageFileType)) {
            

            // Itt mentheted az elérési utat az adatbázisban, ha szükséges
            // Például:
            // $imageUrl = $targetDir . basename($_FILES["fileToUpload"]["name"]);
            // ... SQL INSERT művelet a kép elérési útjának mentésére ...
            $imagePath = 'uploadedImg-'.$nextID.'.'.$imageFileType;
            $uploadDate = date("Y-m-d");
            $userID = $_POST["image-owner"];
            $title = $_POST["image-title"];
            $locationID = $_POST["image-location"];
            $categoryID = $_POST["image-category"];
            $ownerEmail = $_POST["image-owner-email"];

            echo $imagePath .'\n'.$uploadDate.'\n'.$userID.'\n'.$title.'\n'.$locationID.'\n'.$categoryID.'\n'.$ownerEmail;

            $sql = "INSERT INTO IMAGES (IMAGE_PATH, UPLOAD_DATE, USER_ID, TITLE, LOCATION_ID, CATEGORY_ID, OWNER_EMAIL) VALUES (:imagePath, TO_DATE(:uploadDate,'YYYY-MM-DD'), :userID, :title, :locationID, :categoryID, :ownerEmail)";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt,':imagePath',$imagePath);
            oci_bind_by_name($stmt,':uploadDate',$uploadDate);
            oci_bind_by_name($stmt,':userID',$userID);
            oci_bind_by_name($stmt,':title',$title);
            oci_bind_by_name($stmt,':locationID',$locationID);
            oci_bind_by_name($stmt,':categoryID',$categoryID);
            oci_bind_by_name($stmt,':ownerEmail',$ownerEmail);

            oci_execute($stmt);


            //header("Location: ../uploadImage.php?upload=success");

        } else {
            echo "Hiba történt a fájl feltöltése közben.";
        }
    }
} else {
    echo 'Hozzáférés megtagadva!!';
}
?>
