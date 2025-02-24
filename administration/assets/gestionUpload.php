<?php
function uploadImage($inputName, $uploadDir = '../upload/uploadImage/', $allowedTypes = ["jpg", "png", "jpeg", "gif"], $maxSizeMB = 2) {
    if (!isset($_FILES[$inputName]) || $_FILES[$inputName]["error"] !== UPLOAD_ERR_OK) {
        return ["error" => "Aucun fichier envoyé ou une erreur est survenue."];
    }
    $uploadDir = "../upload/uploadImage/" + $inputName + "/";
    $file = $_FILES[$inputName]; 
    $fileName = basename($file["name"]);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); //PATHINFO_EXTENSION récupère l'extension du fichier

    // Vérification du type de fichier
    if (!in_array($fileType, $allowedTypes)) { //on vérifie si l'extension du fichier est dans nos allowed types
        return ["error" => "Type de fichier non autorisé (jpg, png, jpeg et gif uniquement)."];
    }

    // Vérification de la taille du fichier
    if ($file["size"] > $maxSizeMB * 1024 * 1024) {
        return ["error" => "Fichier trop volumineux (max {$maxSizeMB}MB)."];
    }

    // Création du dossier s'il n'existe pas
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); //permet de créer un dossier
    }

    // Génération d'un nom unique
    $newFileName = time() . "_" . $fileName;
    $filePath = $uploadDir . $newFileName;

    // Déplacement du fichier
    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        return ["success" => $filePath]; // Retourne le chemin du fichier
    } else {
        return ["error" => "Erreur lors de l'upload."];
    }
}
?>
