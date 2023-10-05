<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPFS - Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="/static/css/style.css" />
    <link rel="stylesheet" href="/static/css/password_reset.css" />
    <link rel="stylesheet" href="/static/css/login.css" />
    <script src="/static/js/password_requirements.js" defer></script>
</head>

<body>
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
            <form action="/controller/password_reset.php" method="post" id="password-reset" class="rightside login-box">
                <div class="password">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" name="new_password" />
                </div>
                <div class="password">
                    <label for="password_repeat">Répétez le mot de passe</label>
                    <input type="password" name="password_repeat" />
                </div>

                <div class="password">
                    <img src="/gen_captcha.php" />
                    <input type="text" name="captcha_answer" />
                </div>
                <input type="submit" name="submit" value="Changer le mot de passe" class="submit-disabled" id="submit-button" disabled />
            </form>
        </div>
    </div>
</body>

</html>