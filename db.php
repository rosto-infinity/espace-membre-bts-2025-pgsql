<?php
//*********POSTGRES */ 

$dsn = 'pgsql:host=127.0.0.1;dbname=espace-membre-2024-2025';
$username = 'postgres'; // Nom d'utilisateur modifié
$password = '3231'; // Mot de passe
$options = [];

try {
    $bdd = new PDO($dsn, $username, $password, $options);
} catch(PDOException $e) {
    die("erreur: " . $e->getMessage());
}



// * *************** MYSQL*/
// $dsn = 'mysql:host=127.0.0.1;dbname=espace-membre-2024-2025';
// $username = 'root';
// $password = '';
// $options = [];
// try {
// $bdd= new PDO($dsn, $username, $password, $options);
// } catch(PDOException $e) {
// die("erreur". $e->getMessage());
// }