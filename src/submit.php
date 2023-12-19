<?php

// Paramètres de connexion à la base de données
$host = 'db';  // Le nom du service MySQL dans Docker
$db = 'cvdb';
$user = 'root';
$pass = 'rootpassword';
$charset = 'utf8mb4';

// DSN pour la connexion PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

session_start();

// Génération et vérification du jeton CSRF
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['_token']) || $_POST['_token'] !== $_SESSION['_token']) {
        die('Invalid CSRF token');
    }
} else {
    $_SESSION['_token'] = bin2hex(random_bytes(32));
}

try {
    // Création de l'objet PDO pour la connexion à la base de données
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Validation et nettoyage des entrées
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING);
    $phoneNumb = filter_input(INPUT_POST, 'phoneNumb', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
    $permis = filter_input(INPUT_POST, 'permis', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

    // Insertion dans la table profil
    $stmt = $pdo->prepare("INSERT INTO profil (FirstName, LastName, Birthday, PhoneNumb, Email, City, Country, Permis, Description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $firstName,
        $lastName,
        $birthday,
        $phoneNumb,
        $email,
        $city,
        $country,
        $permis,
        $description
    ]);
    $userId = $pdo->lastInsertId();

    // Insertion des expériences
    foreach ($_POST['expName'] as $index => $expName) {
        $expNameClean = filter_var($expName, FILTER_SANITIZE_STRING);
        $jobPosition = filter_input(INPUT_POST, 'jobPosition', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY)[$index];
        $expStart = filter_input(INPUT_POST, 'expStart', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY)[$index];
        $expEnd = filter_input(INPUT_POST, 'expEnd', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY)[$index];
        $localisation = filter_input(INPUT_POST, 'localisation', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY)[$index];
        $expDescription = filter_input(INPUT_POST, 'expDescription', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY)[$index];

        $stmt = $pdo->prepare("INSERT INTO experience (UserId, ExpName, JobPosition, ExpStart, ExpEnd, Localisation, ExpDescription) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $userId,
            $expNameClean,
            $jobPosition,
            $expStart,
            $expEnd,
            $localisation,
            $expDescription
        ]);
    }

    if (isset($_POST['skillName']) && is_array($_POST['skillName'])) {
        foreach ($_POST['skillName'] as $index => $skillName) {
            $skillNameClean = filter_var($skillName, FILTER_SANITIZE_STRING);
            $skillDescription = filter_input(INPUT_POST, 'skillDescription', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY)[$index];

            $stmt = $pdo->prepare("INSERT INTO skills (UserId, SkillName, SkillDescription) VALUES (?, ?, ?)");
            $stmt->execute([
                $userId,
                $skillNameClean,
                $skillDescription
            ]);
        }
    }

    // Insertion des certifications
    if (isset($_POST['certName']) && is_array($_POST['certName'])) {
        foreach ($_POST['certName'] as $index => $certName) {
            $certNameClean = filter_var($certName, FILTER_SANITIZE_STRING);
            $certDate = filter_input(INPUT_POST, 'certDate', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY)[$index];
            $certDescription = filter_input(INPUT_POST, 'certDescription', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY)[$index];

            $stmt = $pdo->prepare("INSERT INTO certification (UserId, CertName, CertDate, CertDescription) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $userId,
                $certNameClean,
                $certDate,
                $certDescription
            ]);
        }
    }

    header("Location: /");
    exit();

} catch (\PDOException $e) {
    echo "Erreur de base de données: " . htmlspecialchars($e->getMessage());
}
?>
