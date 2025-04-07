<?php
function uploadImage($inputName, $categorie, $uploadDir = '../../upload/', $allowedTypes = ["jpg", "png", "jpeg", "gif", "webp"], $maxSizeMB = 2, $page_courante='') {
    // Vérifie si un fichier a été envoyé et s'il n'y a pas d'erreur
    if (!isset($_FILES[$inputName]) || $_FILES[$inputName]["error"] !== UPLOAD_ERR_OK) {
        return ["error" => "Aucun fichier envoyé ou une erreur est survenue."];
    }
    if ($page_courante == "contenu") { array_push($allowedTypes, "pdf"); }
    // Définir le répertoire d'upload
    $uploadDir = "../../upload/medias/" . $categorie . "/";
    $file = $_FILES[$inputName];
    $fileName = basename($file["name"]);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Récupère l'extension du fichier

    // Vérification du type de fichier
    if (!in_array($fileType, $allowedTypes)) {
        return ["error" => "Type de fichier non autorisé (jpg, png, jpeg, webp et gif uniquement)."];
    }

    // Vérification de la taille du fichier
    if ($file["size"] > $maxSizeMB * 1024 * 1024) {
        return ["error" => "Fichier trop volumineux (max {$maxSizeMB}MB)."];
    }

    // Création du dossier s'il n'existe pas
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            return ["error" => "Impossible de créer le dossier d'upload."];
        }
    }

    // Génération d'un nom unique pour le fichier
    $newFileName = date('YmdHis') . "_" . $fileName;
    $filePath = $uploadDir . $newFileName;
    $filePathDatabase = "upload/medias/" . $categorie . "/" . $newFileName;

    // Déplacement du fichier vers le répertoire d'upload
    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        return ["success" => $filePathDatabase]; // Retourne le chemin du fichier pour la base de données
    } else {
        return ["error" => "Erreur lors de l'upload."];
    }
}
?>
