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
$pdf->SetFont('helvetica', '', 12);
try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    if (isset($_GET['userId']) && is_numeric($_GET['userId'])) {
        $userId = $_GET['userId'];

        $stmt = $pdo->prepare("SELECT * FROM profil WHERE UserId = ?");
        $stmt->execute([$userId]);
        $profil = $stmt->fetch();

        $profil_pdf_text = "Profil de " . $profil['FirstName'] . " " . $profil['LastName'];
        $pdf->Write(0, $profil_pdf_text);

        $imagePath = $profil['Image'];
        $pdf->Image($imagePath);

        $profil_pdf_text = "\nDate de naissance: " . $profil['Birthday'];
        $pdf->Write(0, $profil_pdf_text);

        $profil_pdf_text = "\nNuméro de téléphone: " . $profil['PhoneNumb'];
        $pdf->Write(0, $profil_pdf_text);

        $profil_pdf_text = "\nVille: " . $profil['City'];
        $pdf->Write(0, $profil_pdf_text);

        $profil_pdf_text = "\nPays: " . $profil['Country'];
        $pdf->Write(0, $profil_pdf_text);

        $profil_pdf_text = "\nPermis: " . $profil['Permis'];
        $pdf->Write(0, $profil_pdf_text);

        $profil_pdf_text = "\nDescription: " . $profil['Description'];
        $pdf->Write(0, $profil_pdf_text);

        // Ajouter les expériences professionnelles
        $stmt = $pdo->prepare("SELECT * FROM experience WHERE UserId = ?");
        $stmt->execute([$userId]);
        while ($exp = $stmt->fetch()) {
            $exp_pdf_text = "\nExpérience: " . $exp['ExpName'] . ", Position: " . $exp['JobPosition'] . ", De " . $exp['ExpStart'] . " à " . $exp['ExpEnd'] . ", Localisation: " . $exp['Localisation'] . ", Description: " . $exp['ExpDescription'];
            $pdf->Write(0, $exp_pdf_text);
        }

        // Ajouter les compétences
        $stmt = $pdo->prepare("SELECT * FROM skills WHERE UserId = ?");
        $stmt->execute([$userId]);
        while ($skill = $stmt->fetch()) {
            $skill_pdf_text = "\nCompétence: " . $skill['SkillName'] . ", Description: " . $skill['SkillDescription']; // Assurez-vous que la colonne s'appelle 'SkillDescription'
            $pdf->Write(0, $skill_pdf_text);
        }

        // Ajouter les certifications
        $stmt = $pdo->prepare("SELECT * FROM certification WHERE UserId = ?");
        $stmt->execute([$userId]);
        while ($cert = $stmt->fetch()) {
            $cert_pdf_text = "\nCertification: " . $cert['CertName'] . ", Date: " . $cert['CertDate'] . ", Description: " . $cert['CertDescription'];
            $pdf->Write(0, $cert_pdf_text);
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
