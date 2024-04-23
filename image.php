<html lang="hu">
<head>
    <title>Fényképalbumok</title>
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/forms.css">
</head>
<body>
<?php
include_once('partials/navbar.php');
require('includes/db-conn.php');

if(isset($_GET["create_comment"])) {
    if($_GET["create_comment"] == "success") {
        echo "<div class='success-msg'>Sikeresen hozzászóltál a képhez!</div>";
    }
}
if(isset($_GET["photorating"])) {
    if($_GET["photorating"] == "success") {
        echo "<div class='success-msg'>Köszönjük az értékelést!</div>";
    }
}
if(isset($_GET["error"])) {
    if($_GET["error"] == "emptyfields") {
        echo "<div class='error-msg'>Töltsd ki a hozzászólás mezőt!</div>";
    }
    if($_GET["error"] == "emptyfields_norating") {
        echo "<div class='error-msg'>Add meg az értékelést!</div>";
    }
}

$imageID = $_GET["id"];
$stid = oci_parse($conn, 'SELECT * FROM LOCATIONS INNER JOIN IMAGES ON LOCATIONS.LOCATION_ID = IMAGES.LOCATION_ID INNER JOIN CATEGORIES ON IMAGES.CATEGORY_ID = CATEGORIES.CATEGORY_ID  WHERE IMAGES.IMAGE_ID = :imageID');
oci_bind_by_name($stid, ':imageID', $imageID);
oci_execute($stid);
?>
<div id="image-site-wrapper">
    <div id="img-details-wrapper">
    <?php
        while ( $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            echo '<img src="uploadedImages/uploadedImg-'.$imageID.'.jpg" alt="feltoltott kep" id="image-site-img">';
            echo '<div id="details-container">
                    <h1>'.$row["TITLE"].'</h1>
                    <p class="img-details">Itt készült: '.$row["LOCATION_NAME"].'</p>
                    <p class="img-details">Kategória: '.$row["CATEGORY_NAME"].'</p>
                  ';
        }
    oci_free_statement($stid);

    $stid = oci_parse($conn, 'SELECT ROUND(AVG(RATING),2) AS AVG_RATING, COUNT(ID) AS COUNT_OF_ID FROM PHOTORATING WHERE PHOTOID = :imageID');
    oci_bind_by_name($stid, ':imageID', $imageID);
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
    echo '<p class="img-details">Átlag értékelés: '. $row["AVG_RATING"] .' (' . $row["COUNT_OF_ID"] . ' db)</p>';
    ?>

    </div>
    </div>
    <div id="image-site-rating-wrapper">
        <h2>Értékelés:</h2>
        <?php
        echo '
        <form action="includes/createPhotorating.inc.php" class="" method="POST">
            <input type="hidden" name="rated-image-id" value="'.$imageID.'">
            <input type="hidden" name="rating-user" value="'.$_SESSION["userID"].'">
            <input type="number" name="rating" id="rating" min=1 max=5>
            <input type="submit" name="create-btn" value="Értékelem">
        </form>
        ';
        ?>
    </div>
    <div id="image-site-comments-wrapper">
        <h2>Hozzászólások:</h2>
        <?php
            $stid = oci_parse($conn, 'SELECT * FROM COMMENTS INNER JOIN USERS ON COMMENTS.USER_ID = USERS.USER_ID WHERE IMAGE_ID = :imageID');
            oci_bind_by_name($stid, ':imageID', $imageID);
            oci_execute($stid);

            //kommentek kiíratássa
            if (isset($_SESSION["username"])) {
                while ( $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                echo '<div class="comment-container">
                        <p class="comment-author">'.$row["USERNAME"].'</p>
                        <p class="comment-content">'.$row["CONTENT"].'</p>
                        <p class="comment-date">'.$row["COMMENT_DATE"].'</p>
                      </div>';
                }

                echo '
                <div id="add-comment-container">
                <form action="includes/createComment.inc.php" class="comment-container" method="POST">
                    <input type="hidden" name="comment-to-image-id" value="'.$imageID.'">
                    <input type="hidden" name="comment-written-by" value="'.$_SESSION["userID"].'">
                    <textarea name="comment-content" placeholder="Írd le mit gondolsz a képről!" id="add-comment-textarea"></textarea>
                    <input type="submit" name="create-btn" value="Hozzászólás">
                </form>
                </div>
                ';
            }
        ?>
    </div>
</div>


<?php
include_once('partials/footer.php');
?>
</body>
</html>