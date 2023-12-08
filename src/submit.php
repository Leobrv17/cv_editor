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

    // Insertion dans la table profil
    $stmt = $pdo->prepare("INSERT INTO profil (FirstName, LastName, Birthday, PhoneNumb,Email , City, Country, Permis, Description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['firstName'],
        $_POST['lastName'],
        $_POST['birthday'],
        $_POST['phoneNumb'],
        $_POST['email'],
        $_POST['city'],
        $_POST['country'],
        $_POST['permis'],
        $_POST['description']
    ]);
    $userId = $pdo->lastInsertId();

    // Insertion des expériences
    foreach ($_POST['expName'] as $index => $expName) {
        $stmt = $pdo->prepare("INSERT INTO experience (UserId, ExpName, JobPosition, ExpStart, ExpEnd, Localisation, ExpDescription) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $userId,
            $expName,
            $_POST['jobPosition'][$index],
            $_POST['expStart'][$index],
            $_POST['expEnd'][$index],
            $_POST['localisation'][$index],
            $_POST['expDescription'][$index]
        ]);
    }

    // Insertion des compétences
    foreach ($_POST['skillName'] as $index => $skillName) {
        $stmt = $pdo->prepare("INSERT INTO skills (UserId, SkillName, ExpDescription) VALUES (?, ?, ?)");
        $stmt->execute([
            $userId,
            $skillName,
            $_POST['skillDescription'][$index]
        ]);
    }

    // Insertion des certifications
    foreach ($_POST['certName'] as $index => $certName) {
        $stmt = $pdo->prepare("INSERT INTO certification (UserId, CertName, CertDate, CertDescription) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $userId,
            $certName,
            $_POST['certDate'][$index],
            $_POST['certDescription'][$index]
        ]);
    }

    header("Location: /");
    exit();

} catch (\PDOException $e) {
    echo "Erreur de base de données: " . $e->getMessage();
}
?>
