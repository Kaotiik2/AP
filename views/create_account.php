<!DOCTYPE html>
<html>

<head>
    <title>LPFS - Créer un compte</title>
    <!-- <script src="/static/js/create_account.js" defer></script> -->
</head>

<body>
    <form action="/controller/create_user.php" method="post">
        <label for="surname">Nom</label>
        <input type="text" name="name" required />

        <label for="surname">Prénom</label>
        <input type="text" name="surname" required />

        <label for="mail">Mail</label>
        <input type="email" name="mail" required />

        <label for="birth_date">Date de naissance</label>
        <input type="date" name="birth_date" required />

        <label for="telephone">Téléphone</label>
        <input type="text" name="telephone" required />

        <label for="password">Mot de passe</label>
        <input type="password" name="password" required />

        <label for="repeat_password">Répétez le mot de passe</label>
        <input type="password" name="repeat_password" required />

        <input type="submit" />
    </form>
</body>

</html>