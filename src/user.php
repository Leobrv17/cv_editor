<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Utilisateurs</title>
</head>
<body>
<h1>Liste des Utilisateurs</h1>
<a href="/new_cv">nouveau cv</a>

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
</body>
</html>

