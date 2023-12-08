<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Utilisateurs</title>
</head>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        color: #333;
    }

    h1 {
        color: #333;
    }

    a {
        color: #0275d8;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .user-list {
        list-style: none;
        padding: 0;
    }

    .user-list li {
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header a {
        background-color: #0275d8;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-transform: uppercase;
        font-weight: bold;
    }

    .header a:hover {
        background-color: #025aa5;
    }
</style>
<body>
<div class="header">
    <h1>Liste des Utilisateurs</h1>
    <a href="/new_cv">Nouveau CV</a>
</div>

<?php
$host = 'db';  // Le nom du service MySQL dans Docker
$db = 'cvdb';
$user = 'root';
$pass = 'rootpassword';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
?>
<ul class="user-list">
    <?php

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);

        $stmt = $pdo->query("SELECT UserId, FirstName, LastName FROM profil");
        while ($row = $stmt->fetch()) {
            echo "<p><a href='/read_cv?userId=" . htmlspecialchars($row['UserId']) . "'>ID: " . htmlspecialchars($row['UserId']) . ", Nom: " . htmlspecialchars($row['LastName']) . ", Prénom: " . htmlspecialchars($row['FirstName']) . "</a></p>";
        }
    } catch (\PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    ?>
</ul>
</body>
</html>

