<?php 
function moveMediaFile($mediasPath, $newCategorieId, $mediaId, $connexion_bdd) {
    $oldPath = "../" . $mediasPath;
    $newPath = "../upload/medias/" . $newCategorieId . "/" . basename($mediasPath);

    // Créer le nouveau dossier s'il n'existe pas
    $newDir = dirname($newPath);
    if (!is_dir($newDir)) {
        mkdir($newDir, 0777, true);
    }

    // Déplacer le fichier
    if (rename($oldPath, $newPath)) {
        // Mettre à jour le chemin dans la base de données
        $newMediasPath = "upload/medias/" . $newCategorieId . "/" . basename($mediasPath);
        $requeteUpdatePath = "UPDATE medias SET lien = ? WHERE id = ?";
        if ($stmt = $connexion_bdd->prepare($requeteUpdatePath)) {
            $stmt->bind_param("si", $newMediasPath, $mediaId);
            $stmt->execute();
            $stmt->close();
        } else {
            return "Erreur lors de la mise à jour du chemin dans la base de données.";
        }
    } else {
        return "Erreur lors du déplacement du fichier.";
    }
    return "";
}
?>