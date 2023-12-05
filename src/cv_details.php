<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du CV</title>
</head>
<body>
<h1>Détails du CV</h1>
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

    if (isset($_GET['userId']) && is_numeric($_GET['userId'])) {
        $userId = $_GET['userId'];

        // Récupérer les informations de profil
        $stmt = $pdo->prepare("SELECT * FROM profil WHERE UserId = ?");
        $stmt->execute([$userId]);
        $profil = $stmt->fetch();

        // Afficher les informations de profil
        echo "<h2>Profil de " . htmlspecialchars($profil['FirstName']) . " " . htmlspecialchars($profil['LastName']) . "</h2>";
        echo "<p>ID: " . htmlspecialchars($profil['UserId']) . "</p>";
        echo "<p>Image: <img src='" . htmlspecialchars($profil['Image']) . "' alt='Profil Image'></p>";
        echo "<p>Date de naissance: " . htmlspecialchars($profil['Birthday']) . "</p>";
        echo "<p>Numéro de téléphone: " . htmlspecialchars($profil['PhoneNumb']) . "</p>";
        echo "<p>Ville: " . htmlspecialchars($profil['City']) . "</p>";
        echo "<p>Pays: " . htmlspecialchars($profil['Country']) . "</p>";
        echo "<p>Permis: " . htmlspecialchars($profil['Permis']) . "</p>";
        echo "<p>Description: " . htmlspecialchars($profil['Description']) . "</p>";





        $stmt = $pdo->prepare("SELECT * FROM experience WHERE UserId = ?");
        $stmt->execute([$userId]);
        while ($exp = $stmt->fetch()) {
            echo "<p>Expérience: " . htmlspecialchars($exp['ExpName']) . ", Position: " . htmlspecialchars($exp['JobPosition']) . ", De " . htmlspecialchars($exp['ExpStart']) . " à " . htmlspecialchars($exp['ExpEnd']) . ", Localisation: " . htmlspecialchars($exp['Localisation']) . ", Description: " . htmlspecialchars($exp['ExpDescription']) . "</p>";
        }

        $stmt = $pdo->prepare("SELECT * FROM skills WHERE UserId = ?");
        $stmt->execute([$userId]);
        while ($skill = $stmt->fetch()) {
            echo "<p>Compétence: " . htmlspecialchars($skill['SkillName']) . ", Description: " . htmlspecialchars($skill['ExpDescription']) . "</p>";
        }

        $stmt = $pdo->prepare("SELECT * FROM certification WHERE UserId = ?");
        $stmt->execute([$userId]);
        while ($cert = $stmt->fetch()) {
            echo "<p>Certification: " . htmlspecialchars($cert['CertName']) . ", Date: " . htmlspecialchars($cert['CertDate']) . ", Description: " . htmlspecialchars($cert['CertDescription']) . "</p>";
        }

    } else {
        echo "<p>Utilisateur non spécifié ou invalide.</p>";
    }

} catch (\PDOException $e) {
    echo "Erreur de base de données: " . $e->getMessage();
}
?>
<a href="generate_pdf.php?userId=<?php echo $userId; ?>">Télécharger le CV en PDF</a>
</body>
</html>
