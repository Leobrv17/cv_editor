<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du CV</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1, h2 {
            color: #333;
        }

        .container {
            display: flex;
        }

        .left-column, .right-column {
            flex: 1;
            padding: 10px;
        }

        .left-column {
            margin-right: 20px;
        }

        a {
            color: #0275d8;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .details {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .details p {
            margin: 5px 0;
        }

        .download-link {
            background-color: #0275d8;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .download-link:hover {
            background-color: #025aa5;
        }

        iframe {
            width: 100%;
            height: 400px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .home-button {
            background-color: #0275d8;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            text-decoration: none; /* Supprime le soulignement du lien */
            display: inline-block; /* Permet de définir des dimensions au lien */
            font-weight: bold;
        }

        .home-button:hover {
            background-color: #025aa5;
        }
    </style>
</head>
<body>
<h1>Détails du CV</h1>
<a href="/" class="home-button">Home</a>
<?php
$host = 'db';
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

<div class="container">
    <div class="left-column">
        <div class="details">
            <?php
            try {
                $pdo = new PDO($dsn, $user, $pass, $options);

                if (isset($_GET['userId']) && is_numeric($_GET['userId'])) {
                    $userId = $_GET['userId'];

                    $stmt = $pdo->prepare("SELECT * FROM profil WHERE UserId = ?");
                    $stmt->execute([$userId]);
                    $profil = $stmt->fetch();


                    echo "<h2>Profil de " . htmlspecialchars($profil['FirstName']) . " " . htmlspecialchars($profil['LastName']) . "</h2>";
                    echo "<p>ID: " . htmlspecialchars($profil['UserId']) . "</p>";
                    echo "<p>Date de naissance: " . htmlspecialchars($profil['Birthday']) . "</p>";
                    echo "<p>Numéro de téléphone: " . htmlspecialchars($profil['PhoneNumb']) . "</p>";
                    echo "<p>Email: " . htmlspecialchars($profil['Email']) . "</p>";
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
        </div>
    </div>
    <div class="right-column">
        <a href='/cv_pdf?userId=<?= htmlspecialchars($userId) ?>' class="download-link">Télécharger le CV en PDF</a>
        <iframe src='/cv_pdf?userId=<?= htmlspecialchars($userId) ?>'></iframe>
    </div>
</div>
</body>
</html>
