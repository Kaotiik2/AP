<!DOCTYPE html>
<html>


<head>
    <link rel="stylesheet" href="/static/css/secretaire.css">
</head>

<body>
    <img src="/static/images/LPFS_logo.png" alt="" class="logo">
    <img src="/static/images/derou4.png" alt="" class="derou2">

    <form action="/controller/pre_admission.php" method="post" enctype="multipart/form-data">
        <?php

        use lib\utils;

        utils\relay_post();
        ?>
        <input type="file" name="ci_recto" required />
        <input type="file" name="ci_verso" required />
        <input type="file" name="carte_vitale" required />
        <input type="file" name="carte_mutuelle" required />
        <?php
        if ($_POST["mineur"] == "on") {
            echo '<input type="file" name="livret_famille" required/>';
            echo '<input type="file" name="autorisation_soin" required />'; //Si mineur
        }
        if ($_POST["parents_divorces"] == "on") {
        ?>
            <input type="file" name="monoparentalite_juge" required /> <!-- Si divorcés -->
        <?php
        }
        ?>

        <input type="submit" class="bouton" />
    </form>
</body>

</html>