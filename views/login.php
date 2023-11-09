<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>LOGIN PAGE LPF</title>
  <link href="/static/css/login.css" rel="stylesheet" />
  <link href="/static/css/style.css" rel="stylesheet" />
  <script src="/static/js/login.js" defer></script>
</head>

<body>
  <div class="mainscreen">
    <div class="card">
      <div class="leftside">
        <img src="/static/images/LPFS_logo.png" alt="">
      </div>
      <div class="rightside">
        <form action="/controller/login.php" method="post" id="login-form">
          <h1>Se Connecter</h1>
          <div class="login-box">
            <p id="error-display" class="invalid"></p>
            <div class="email">
              <label for="email"></label>
              <div class="sec-2">
                <ion-icon name="at-circle-outline"></ion-icon>
                <input type="email" name="username" placeholder="    Email" />
              </div>
            </div>
            <div class="password">
              <label for="password"></label>
              <div class="sec-2">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input class="pas" type="password" name="password" placeholder="    Votre Mot De Passe" />
              </div>
            </div>
            <img src="/gen_captcha.php" /> <br>
            <label for="captcha_answer"></label>
            <input type="text" name="captcha_answer" class="input_1" /> <br>
            <button type="submit" class="button">Connexion</button>
          </div>
        </form>
      </div>

    </div>

    <style>

    </style>

</body>

</html>