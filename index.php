<?php
session_start();
require 'db.php';

if (isset($_POST['formconnexion'])) {
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);
    if (!empty($mailconnect) AND !empty($mdpconnect)) {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
        $requser->execute(array($mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if ($userexist == 1) {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            $_SESSION['user_role'] = $userinfo['role'];

            // Redirection en fonction du rôle
            if ($_SESSION['user_role'] === 'admin') {
                header("Location: gestion_groupes.php");
            } else {
                header("Location: profil.php?id=" . $_SESSION['id']);
            }
            exit();
        } else {
            $erreur = "Mauvais mail ou mot de passe !";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés !";
    }
}
?>
<html>

<head>
  <title>TUTO PHP</title>
  <meta charset="utf-8">
  <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 20px;
  }

  h2 {
    text-align: center;
    color: #555;
  }

  .container {
    max-width: 400px;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  input[type="email"],
  input[type="password"],
  input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  input[type="submit"] {
    background-color: #5cb85c;
    color: white;
    border: none;
    cursor: pointer;
  }

  input[type="submit"]:hover {
    background-color: #4cae4c;
  }

  .error {
    color: red;
    text-align: center;
  }

  .signup-link {
    text-align: center;
    margin-top: 20px;
  }
  </style>
</head>

<body>
  <div class="container">
    <h2>Connexion</h2>
    <form method="POST" action="">
      E-mail : <input type="email" name="mailconnect" placeholder="Mail" required /><br>
      Mot de passe : <input type="password" name="mdpconnect" placeholder="Mot de passe" required /><br>
      <input type="submit" name="formconnexion" value="Se connecter !" />
    </form>
    <?php
        if (isset($erreur)) {
            echo '<div class="error">' . $erreur . "</div>";
        }
    ?>
    <div class="signup-link">
      <p>Vous n'avez pas un compte ? <a href="inscription.php">Je m'inscris</a></p>
    </div>
  </div>
</body>

</html>