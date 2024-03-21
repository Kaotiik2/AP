<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>LOGIN PAGE LPF</title>
    <script src="/static/js/login.js" defer></script>
    <!-- Inclure Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-200">
    <div class="flex justify-center items-center h-screen">
        <div class="max-w-md w-full bg-white p-8 rounded-md shadow-md">
            <div class="flex justify-center items-center mb-8">
                <img src="/static/images/LPFS_logo.png" alt="" class="w-64">
            </div>
            <form action="/controller/login.php" method="post" id="login-form">
                <h1 class="text-2xl font-bold mb-4">Se Connecter</h1>
                <div class="login-box">
                    <p id="error-display" class="text-red-500 mb-4"></p>
                    <div class="email mb-4">
                        <label for="email" class="hidden"></label>
                        <div class="flex items-center">
                            <ion-icon name="at-circle-outline" class="mr-2"></ion-icon>
                            <input type="email" name="username" placeholder="Email" class="border rounded p-2 w-full">
                        </div>
                    </div>
                    <div class="password mb-4">
                        <label for="password" class="hidden"></label>
                        <div class="flex items-center">
                            <ion-icon name="lock-closed-outline" class="mr-2"></ion-icon>
                            <input class="pas border rounded p-2 w-full" type="password" name="password" placeholder="Votre Mot De Passe">
                        </div>
                    </div>
                    <img src="/gen_captcha.php" class="mb-4" /> <br>
                    <label for="captcha_answer" class="hidden"></label>
                    <input type="text" name="captcha_answer" class="input_1 border rounded p-2 mb-4 w-full" placeholder="Captcha" /> <br>
                    <button type="submit" class="button bg-blue-500 text-white py-2 px-4 rounded">Connexion</button>
                </div>
                <img src="/gen_captcha.php" class="mb-1 m-auto"/> <br>
                <label for="captcha_answer" class="hidden"></label>
                <input type="text" name="captcha_answer" class="input_1 border rounded p-2 mb-4 w-full"/> <br>
                <button type="submit" class="button bg-blue-500 text-white py-2 px-4 rounded ">Connexion</button>
        </form>
    </div>
</body>

</html>