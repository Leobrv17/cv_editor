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
ob_start();
require_once __DIR__ . '/vendor/autoload.php';

$pdf = new TCPDF();
$pdf->SetCreator('TCPDF');
$pdf->SetAuthor('CV_Editor');
$pdf->SetTitle('Your_CV');
$pdf->SetSubject('Curiculum Vitae');
$pdf->AddPage();

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    if (isset($_GET['userId']) && is_numeric($_GET['userId'])) {
        $userId = $_GET['userId'];

        // Début du CV
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->Write(0, "Détails du CV\n", '', 0, 'C', true);

        $stmt = $pdo->prepare("SELECT * FROM profil WHERE UserId = ?");
        $stmt->execute([$userId]);
        $profil = $stmt->fetch();

        // Section Profil
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Write(0, "\nProfil\n", '', 0, 'L', true);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(0, 0, 0);

        $imagePath = $profil['Image'];
        $pdf->Image($imagePath, '', '', 40);

        $pdf->Write(0, "Nom: " . $profil['FirstName'] . " " . $profil['LastName'] . "\n");
        $pdf->Write(0, "Date de naissance: " . $profil['Birthday'] . "\n");
        $pdf->Write(0, "Numéro de téléphone: " . $profil['PhoneNumb'] . "\n");
        $pdf->Write(0, "Ville: " . $profil['City'] . "\n");
        $pdf->Write(0, "Pays: " . $profil['Country'] . "\n");
        $pdf->Write(0, "Permis: " . $profil['Permis'] . "\n");
        $pdf->Write(0, "Description: " . $profil['Description'] . "\n");

        // Section Expérience Professionnelle
        $stmt = $pdo->prepare("SELECT * FROM experience WHERE UserId = ?");
        $stmt->execute([$userId]);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Write(0, "\nExpérience Professionnelle\n", '', 0, 'L', true);
        $pdf->SetFont('helvetica', '', 12);
        while ($exp = $stmt->fetch()) {
            $pdf->Write(0, $exp['ExpName'] . " - " . $exp['JobPosition'] . " (de " . $exp['ExpStart'] . " à " . $exp['ExpEnd'] . ")\n");
            $pdf->Write(0, "Localisation: " . $exp['Localisation'] . "\n");
            $pdf->Write(0, "Description: " . $exp['ExpDescription'] . "\n\n");
        }

        // Section Compétences
        $stmt = $pdo->prepare("SELECT * FROM skills WHERE UserId = ?");
        $stmt->execute([$userId]);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Write(0, "\nCompétences\n", '', 0, 'L', true);
        $pdf->SetFont('helvetica', '', 12);
        while ($skill = $stmt->fetch()) {
            $pdf->Write(0, $skill['SkillName'] . ": " . $skill['SkillDescription'] . "\n");
        }

        // Section Certifications
        $stmt = $pdo->prepare("SELECT * FROM certification WHERE UserId = ?");
        $stmt->execute([$userId]);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Write(0, "\nCertifications\n", '', 0, 'L', true);
        $pdf->SetFont('helvetica', '', 12);
        while ($cert = $stmt->fetch()) {
            $pdf->Write(0, $cert['CertName'] . " - " . $cert['CertDate'] . "\n");
            $pdf->Write(0, "Description: " . $cert['CertDescription'] . "\n");
        }
    } else {
        echo "<p>Utilisateur non spécifié ou invalide.</p>";
    }
} catch (\PDOException $e) {
    echo "Erreur de base de données: " . $e->getMessage();
}

$pdf->Output('your_cv.pdf', 'I');

ob_end_flush();
?>
