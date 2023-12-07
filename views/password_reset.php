<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPFS - Réinitialisation du mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="/static/js/password_requirements.js" defer></script>
</head>

<body class="bg-gray-200">
<div id="mainscreen" class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white p-8 rounded shadow-md">
        <div class="text-center">
            <h1 class="text-2xl font-bold mb-4">Réinitialisation du mot de passe</h1>
            <p>Le mot de passe de votre compte a besoin d'être changé. Veuillez rentrer un mot de passe composé de:</p>
            <ul class="text-left list-disc pl-4">
                <li id="size-p" class="text-red-500">Au moins 16 caractères</li>
                <li id="lowercase-p" class="text-red-500">Lettres minuscules</li>
                <li id="uppercase-p" class="text-red-500">Lettres majuscules</li>
                <li id="special-p" class="text-red-500">Caractères spéciaux(_ - & , '# etc.)</li>
                <li id="numbers-p" class="text-red-500">Chiffres</li>
            </ul>
        </div>
        <form action="/controller/password_reset.php" method="post" id="password-reset"
              class="mt-4 space-y-4">
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-600">Nouveau mot de
                    passe</label>
                <input type="password" name="new_password"
                       class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label for="password_repeat" class="block text-sm font-medium text-gray-600">Répétez le mot de
                    passe</label>
                <input type="password" name="password_repeat"
                       class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <img src="/gen_captcha.php" alt="Captcha Image" class="mt-2">
                <input type="text" name="captcha_answer"
                       class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <input type="submit" name="submit" value="Changer le mot de passe"
                   class="mt-4 p-2 bg-blue-500 text-white rounded-md cursor-not-allowed" disabled />
        </form>
    </div>
</div>
</body>

</html>
