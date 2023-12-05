<?php
echo getcwd();
echo "<p>";
function afficherArborescence($dir, $level = 0) {
    // Obtient la liste des fichiers et dossiers, sauf "." et ".."
    $fichiers = scandir($dir);

    foreach ($fichiers as $fichier) {
        // Ignore les répertoires spéciaux "." et ".."
        if ($fichier === '.' || $fichier === '..') {
            continue;
        }

        // Indentation pour la visibilité
        $indentation = str_repeat("--", $level);

        // Chemin complet du fichier ou du dossier
        $cheminComplet = $dir . DIRECTORY_SEPARATOR . $fichier;

        // Vérifie si c'est un dossier
        if (is_dir($cheminComplet)) {
            echo $indentation . "[Dossier] " . $fichier . PHP_EOL;

            // Appel récursif pour parcourir le sous-dossier
            afficherArborescence($cheminComplet, $level + 1);
        } else {
            // C'est un fichier
            echo $indentation . "[Fichier] " . $fichier . PHP_EOL;
        }
    }
}

// Appel de la fonction pour le répertoire courant
afficherArborescence(getcwd());
?>
