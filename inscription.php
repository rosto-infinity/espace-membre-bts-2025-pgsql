<?php
session_start();
require 'db.php';

if (isset($_POST['forminscription'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);
    
    if (!empty($pseudo) && !empty($mail) && !empty($mail2) && !empty($mdp) && !empty($mdp2)) {
        if ($mail === $mail2) {
            if ($mdp === $mdp2) {
                $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
                $requser->execute(array($mail));
                $userexist = $requser->rowCount();
                
                if ($userexist == 0) {
                    $insertuser = $bdd->prepare("INSERT INTO membres (pseudo, mail, motdepasse) VALUES (?, ?, ?)");
                    $insertuser->execute(array($pseudo, $mail, $mdp));
                    $success = "Votre compte a été créé avec succès ! Vous pouvez maintenant vous connecter.<a href=\"index.php\">Me connecter</a>";
                } else {
                    $erreur = "Cet e-mail est déjà utilisé.";
                }
            } else {
                $erreur = "Les mots de passe ne correspondent pas.";
            }
        } else {
            $erreur = "Les e-mails ne correspondent pas.";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés !";
    }
}
?>

<html>

<head>
  <title>Inscription</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="container">
    <h2>Inscription</h2>
    <form method="POST" action="">
      <label>Pseudo :</label>
      <input type="text" name="pseudo" placeholder="Votre pseudo" required /> <br><br>

      <label>E-mail :</label>
      <input type="email" name="mail" placeholder="Votre mail" required /> <br><br>

      <label>Confirmation E-mail :</label>
      <input type="email" name="mail2" placeholder="Confirmez votre mail" required /> <br><br>

      <label>Mot de passe :</label>
      <input type="password" name="mdp" placeholder="Votre mot de passe" required /> <br><br>

      <label>Confirmation Mot de passe :</label>
      <input type="password" name="mdp2" placeholder="Confirmez votre mot de passe" required /> <br><br>

      <input type="submit" name="forminscription" value="Je m'inscris" />
    </form>

    <?php if (isset($erreur)) { echo '<div class="error">'.$erreur."</div>"; } ?>
    <?php if (isset($success)) { echo '<div style="color: green; text-align: center;">'.$success."</div>"; } ?>
  </div>
</body>

</html>