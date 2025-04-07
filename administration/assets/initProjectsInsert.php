<?php 
// Sécurisation et récupération des données envoyées via le formulaire
$titre = mysqli_real_escape_string($connexion_bdd, $_POST['titre']);
$chapo = mysqli_real_escape_string($connexion_bdd, $_POST['chapo']);
$description = mysqli_real_escape_string($connexion_bdd, $_POST['description']);
$outils = mysqli_real_escape_string($connexion_bdd, $_POST['outils']);
$video = mysqli_real_escape_string($connexion_bdd, $_POST['video']);
$lienProjet = mysqli_real_escape_string($connexion_bdd, $_POST['lienProjet']);
$categorie = mysqli_real_escape_string($connexion_bdd, $_POST['categorie']);
$visibilite = (int) $_POST["visibilite"]; // Visibilité en entier (0 ou 1)
$date = mysqli_real_escape_string($connexion_bdd, $_POST['date']); // Date de création récupérée
$collaborateurs_selected = $_POST['collaborateurs'] ?? []; // Récupère les collaborateurs sélectionnés (s'ils existent)
$categorieNom = getCategoriesName($connexion_bdd, $categorie); // Récupère le nom de la catégorie
$mediasPath ='';
// Gestion de l'upload de l'image du projet
if (!empty($_FILES["medias"]["name"])) { 
    // Appel à la fonction uploadImage pour gérer l'upload
    $uploadResult = uploadImage("medias", $categorieNom);

    // Vérifie s'il y a une erreur ou une réussite dans l'upload
    if (isset($uploadResult["error"])) {
        $error_msg_medias = $uploadResult["error"]; // Enregistre l'erreur dans la variable
    } elseif (isset($uploadResult["success"])) {
        $mediasPath = $uploadResult["success"]; // Enregistre le chemin du média téléchargé
    }
}
if (empty($mediasPath) && !empty($_POST["mediaExistant"])) {
    $mediasPath =  $_POST["mediaExistant"];
}
$mediasPath = mysqli_real_escape_string($connexion_bdd, $mediasPath);
?>