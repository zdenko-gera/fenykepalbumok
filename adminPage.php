<html lang="hu">
<head>
    <title>Fényképalbumok | Admin</title>
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/forms.css">
    <link rel="stylesheet" href="styles/admin.css">

</head>
<body>
<?php
include_once('partials/navbar.php');

if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyfields") {
        echo "<div class='error-msg'>Töltsd ki az üres mezőket!</div>";
    }
}
if(isset($_GET["create_contest"])) {
    if($_GET["create_contest"] == "success") {
        echo "<div class='success-msg'>Pályázat sikeresen kiírásra került!</div>";
    }
}
?>

<div id="admin-menu">
    <div class="admin-menu-element">
    <h3>Pályázat kiírása</h3>

    <form action="includes/createContest.inc.php" method="POST" class="login-reg-form">
        <input type="text" name="contest-name" placeholder="Pályázat címe">
        <textarea name="contest-desc" placeholder="Leírás"></textarea>
        <input type="date" name="contest-start-date" placeholder="Kezdőidőpont">
        <input type="date" name="contest-until-date" placeholder="Határidő">
        <input type="submit" name="contest-create-btn" value="Kiírás">
    </form>
    </div>
</div>





<?php
include_once('partials/footer.php');
?>
</body>
</html>
