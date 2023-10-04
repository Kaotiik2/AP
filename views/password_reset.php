<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPFS - Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/password_reset.css" />
    <link rel="stylesheet" href="login.css" />
    <script src="./js/password_requirements.js" defer></script>
</head>

<body>
    <?php
    require_once("lib/captcha.php");
    session_start();

    if (!captcha_verify($_POST["captcha_answer"])) {
        header("Location: password_reset.php?erreur=");
    }

    if (isset($_SESSION["erreur_ancien_mdp"])) {
        echo "<p>Le nouveau mot de passe ne doit pas être le même que le nouveau</p>";
    } else {
        extract($_POST);
        if (isset($submit) && $new_password == $password_repeat) {
            require_once("lib/config.php");
            $account_reset = $_SESSION["reset_account_id"];

            $stmt = $db->prepare("SELECT mot_de_passe from utilisateurs WHERE id=:id");
            $stmt->bindValue(":id", $account_reset);
            $stmt->execute() or die("Erreur bdd.");
            $old_password = $stmt->fetchAll()[0]["mot_de_passe"];

            if ($new_password == $old_password) {
                $_SESSION["erreur_ancien_mdp"] = "1";
                session_write_close();
                header("Location: password_reset.php");
                die();
            }

            $req = "
        UPDATE utilisateurs
            SET mot_de_passe = :new_password,
            premiere_connexion = '1',
            date_mdp = :date
            WHERE id = :id
        ";

            session_destroy();
            $datenow = time();

            $stmt = $db->prepare($req);
            $stmt->bindValue(":new_password", $new_password);
            $stmt->bindValue(":date", $datenow);
            $stmt->bindValue(":id", $account_reset);
            $result = $stmt->execute() or die("Impossible d'update la base de données, veuillez contacter l'administrateur.");

            header("Location: login.php");
        }
    }
    ?>

    <div id="mainscreen">
        <div class="card">
            <div class="leftside">
                <h1> Réinitialisation du mot de passe </h1>
                <p> Le mot de passe de votre compte a besoin d 'être changé. Veuillez rentrer un mot de passe composé de:</p>
                <ul>
                    <li id="size-p" class="invalid"> Au moins 16 caractères </li>
                    <li id="lowercase-p" class="invalid">Lettres minuscules</li>
                    <li id="uppercase-p" class="invalid">Lettres majuscules</li>
                    <li id="special-p" class="invalid"> Caractères spéciaux(_ - & , '# etc.)</li>
                    <li id="numbers-p" class="invalid"> Chiffres </li>
                </ul>
            </div>
            <form action="password_reset.php" method="post" id="password-reset" class="rightside login-box">
                <div class="password">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" name="new_password" />
                </div>
                <div class="password">
                    <label for="password_repeat">Répétez le mot de passe</label>
                    <input type="password" name="password_repeat" />
                </div>

                <div class="password">
                    <img src="gen_captcha.php" />
                    <input type="text" id="captcha_answer" />
                </div>
                <input type="submit" name="submit" value="Changer le mot de passe" class="submit-disabled" id="submit-button" disabled />
            </form>
        </div>
    </div>
</body>

</html>