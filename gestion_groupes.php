<?php
session_start();
require 'db.php'; // Assurez-vous que ce fichier contient la connexion à votre base de données

// Vérification du rôle de l'utilisateur
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php'); // Redirige vers la page d'accueil ou de connexion
    exit();
}

// Ajout d'un groupe
if (isset($_POST['ajouter_groupe'])) {
    $nom_groupe = htmlspecialchars($_POST['nom_groupe']);
    if (!empty($nom_groupe)) {
        $stmt = $bdd->prepare("INSERT INTO groupes (nom) VALUES (?)");
        $stmt->execute([$nom_groupe]);
        $message = "Groupe ajouté avec succès !";
    } else {
        $message = "Le nom du groupe ne peut pas être vide.";
    }
}

// Suppression d'un groupe
if (isset($_GET['supprimer'])) {
    $groupe_id = intval($_GET['supprimer']);
    $stmt = $bdd->prepare("DELETE FROM groupes WHERE id = ?");
    $stmt->execute([$groupe_id]);
    $message = "Groupe supprimé avec succès !";
}

// Édition d'un groupe
if (isset($_POST['editer_groupe'])) {
    $groupe_id = intval($_POST['groupe_id']);
    $nom_groupe = htmlspecialchars($_POST['nom_groupe']);
    if (!empty($nom_groupe)) {
        $stmt = $bdd->prepare("UPDATE groupes SET nom = ? WHERE id = ?");
        $stmt->execute([$nom_groupe, $groupe_id]);
        $message = "Groupe modifié avec succès !";
    } else {
        $message = "Le nom du groupe ne peut pas être vide.";
    }
}

// Association d'un membre à un groupe
if (isset($_POST['associer_membre'])) {
    $membre_id = intval($_POST['membre_id']);
    $groupe_id = intval($_POST['groupe_id']);
    $stmt = $bdd->prepare("INSERT INTO membre_groupe (membre_id, groupe_id) VALUES (?, ?)");
    $stmt->execute([$membre_id, $groupe_id]);
    $message = "Membre associé au groupe avec succès !";
}

// Récupération des groupes
$groupes = $bdd->query("SELECT * FROM groupes")->fetchAll();

// Récupération des membres
$membres = $bdd->query("SELECT * FROM membres")->fetchAll();

// Récupération des informations du groupe à éditer
$groupe_a_editer = null;
if (isset($_GET['editer'])) {
    $groupe_id = intval($_GET['editer']);
    $groupe_a_editer = $bdd->prepare("SELECT * FROM groupes WHERE id = ?");
    $groupe_a_editer->execute([$groupe_id]);
    $groupe_a_editer = $groupe_a_editer->fetch();
}

// Récupération des membres associés à un groupe
$members_in_group = [];
if (isset($_GET['voir_membres'])) {
    $groupe_id = intval($_GET['voir_membres']);
    $members_in_group = $bdd->prepare("
        SELECT m.* FROM membres m
        JOIN membre_groupe mg ON m.id = mg.membre_id
        WHERE mg.groupe_id = ?
    ");
    $members_in_group->execute([$groupe_id]);
    $members_in_group = $members_in_group->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Groupes</title>
  <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
  }

  .container {
    max-width: 600px;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  h2 {
    text-align: center;
  }

  form {
    margin-bottom: 20px;
  }

  input[type="text"],
  select {
    width: calc(100% - 22px);
    padding: 10px;
    margin-bottom: 10px;
  }

  input[type="submit"] {
    padding: 10px 15px;
    background-color: #5cb85c;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  input[type="submit"]:hover {
    background-color: #4cae4c;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  th,
  td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  a {
    color: red;
    text-decoration: none;
  }
  </style>
</head>

<body>

  <div class="container">
    <a href="profil.php?id=<?= $_SESSION['id']; ?>">Mon profil</a>

    <h2>Gestion des Groupes</h2>

    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>

    <form method="POST">
      <input type="text" name="nom_groupe" placeholder="Nom du groupe" required>
      <input type="submit" name="ajouter_groupe" value="Ajouter un Groupe">
    </form>

    <?php if ($groupe_a_editer): ?>
    <h3>Éditer le Groupe</h3>
    <form method="POST">
      <input type="hidden" name="groupe_id" value="<?= htmlspecialchars($groupe_a_editer['id']); ?>">
      <input type="text" name="nom_groupe" value="<?= htmlspecialchars($groupe_a_editer['nom']); ?>" required>
      <input type="submit" name="editer_groupe" value="Modifier le Groupe">
    </form>
    <?php endif; ?>

    <h3>Associer un Membre à un Groupe</h3>
    <form method="POST">
      <select name="membre_id" required>
        <option value="">Sélectionnez un membre</option>
        <?php foreach ($membres as $membre): ?>
        <option value="<?= htmlspecialchars($membre['id']); ?>"><?= htmlspecialchars($membre['pseudo']); ?></option>
        <?php endforeach; ?>
      </select>
      <select name="groupe_id" required>
        <option value="">Sélectionnez un groupe</option>
        <?php foreach ($groupes as $groupe): ?>
        <option value="<?= htmlspecialchars($groupe['id']); ?>"><?= htmlspecialchars($groupe['nom']); ?></option>
        <?php endforeach; ?>
      </select>
      <input type="submit" name="associer_membre" value="Associer Membre">
    </form>
    <h3>Liste des Groupes</h3>
    <table>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Actions</th>
      </tr>
      <?php foreach ($groupes as $groupe): ?>
      <tr>
        <td><?= htmlspecialchars($groupe['id']); ?></td>
        <td><?= htmlspecialchars($groupe['nom']); ?></td>
        <td>
          <a href="?editer=<?= $groupe['id']; ?>">Éditer</a> |
          <a href="?supprimer=<?= $groupe['id']; ?>">Supprimer</a> |
          <a href="?voir_membres=<?= $groupe['id']; ?>">Voir Membres</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>

    <?php if (isset($_GET['voir_membres'])): ?>
    <h3>Membres du Groupe</h3>
    <?php if (empty($members_in_group)): ?>
    <p>Aucun membre pour l'instant.</p>
    <?php else: ?>
    <p>Nombre de membres dans le groupe : <?= count($members_in_group); ?></p>
    <table>
      <tr>
        <th>ID</th>
        <th>Pseudo</th>
        <th>Email</th>
        <th>Rôle</th> <!-- Nouvelle colonne pour le rôle -->
      </tr>
      <?php foreach ($members_in_group as $membre): ?>
      <tr>
        <td><?= htmlspecialchars($membre['id']); ?></td>
        <td><?= htmlspecialchars($membre['pseudo']); ?></td>
        <td><?= htmlspecialchars($membre['mail']); ?></td>
        <td><?= htmlspecialchars($membre['role']); ?></td> <!-- Affichage du rôle -->
      </tr>
      <?php endforeach; ?>
    </table>
    <?php endif; ?>
    <?php endif; ?>



  </div>

</body>

</html>