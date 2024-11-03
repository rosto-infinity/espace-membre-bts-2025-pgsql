<?php
session_start();

require 'db.php';

if (isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
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
    text-align: center;
  }

  img {
    border-radius: 50%;
    margin-bottom: 20px;
  }

  a {
    display: inline-block;
    margin: 10px 0;
    padding: 10px 15px;
    background-color: #5cb85c;
    color: white;
    text-decoration: none;
    border-radius: 4px;
  }

  a:hover {
    background-color: #4cae4c;
  }
  </style>
</head>

<body>
  <div class="container">
    <h2>Profil de <?= htmlspecialchars($userinfo['pseudo']); ?></h2>
    <br /><br />
    <?php if (!empty($userinfo['avatar'])) { ?>
    <img src="membres/avatars/<?= htmlspecialchars($userinfo['avatar']); ?>" width="222">
    <?php } ?>
    <br /><br />
    Pseudo : <?= htmlspecialchars($userinfo['pseudo']); ?><br />
    Mail : <?= htmlspecialchars($userinfo['mail']); ?><br />
    <?php
        if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
        ?>
    <br />
    <a href="editionprofil.php">Éditer mon profil</a>
    <a href="deconnexion.php">Se déconnecter</a>
    <a href="http://localhost/bts-2/espace-membre-2024-2025/gestion_groupes.php">Admin</a>
    <?php
        }
        ?>
  </div>
</body>

</html>
<?php
}
?>