<?php
require_once('includes/db-conn.php');

if(isset($_POST["modify-user-btn"])) {
    $userID = $_POST["id-to-modify"];
    ?>

    <!DOCTYPE html>
    <html lang="hu">
    <head>
        <title>Felhasználó módosítása</title>
        <link rel="stylesheet" href="styles/common.css">
        <link rel="stylesheet" href="styles/forms.css">
    </head>
    <body>
    <h2>Felhasználó módosítása</h2>
    <form action="includes/modify_user.inc.php" method="POST">
        <input type="hidden" name="id-to-modify" value="<?php echo $userID; ?>">
        <label for="new-username">Új felhasználónév:</label>
        <input type="text" id="new-username" name="new-username" required><br>
        <label for="new-email">Új e-mail cím:</label>
        <input type="email" id="new-email" name="new-email" required><br>
        <button type="submit" name="modify-user-btn">Mentés</button>
    </form>
    </body>
    </html>

    <?php
} else {
    // Ha nem érkezett megfelelő kérés a módosítás gombra kattintva, irányítsd vissza a felhasználó listázó oldalra
    header("Location: users.php");
    exit();
}
?>

