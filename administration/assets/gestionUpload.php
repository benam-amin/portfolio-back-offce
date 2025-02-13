<?php
$error = $success = "";

// Traitement de l'upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $uploadDir = "../upload/" + $cat; // Dossier de destination
    $fileName = basename($_FILES["file"]["name"]);
    $targetFile = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); //permet de récuperer l'extension du fichier donc .jpg ect..

    // Vérification du type de fichier
    $allowedTypes = ["jpg", "png", "jpeg"];
    if (!in_array($fileType, $allowedTypes)) {
        $error = "Type de fichier non autorisé.";
    }

    // Vérification de la taille du fichier (max 2MB)
    elseif ($_FILES["file"]["size"] > 2 * 1024 * 1024) {
        $error = "Fichier trop volumineux (max 2MB).";
    }

    // Déplacer le fichier uploadé
    elseif (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        $success = "Le fichier " . htmlspecialchars($fileName) . " a été uploadé avec succès.";
    } else {
        $error = "Erreur lors de l'upload.";
    }
}
?>