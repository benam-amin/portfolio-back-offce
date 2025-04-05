<?php 
$titre = mysqli_real_escape_string($connexion_bdd, $_POST['titre']);
$chapo = mysqli_real_escape_string($connexion_bdd, $_POST['chapo']);
$description = mysqli_real_escape_string($connexion_bdd, $_POST['description']);
$outils = mysqli_real_escape_string($connexion_bdd, $_POST['outils']);
$video = mysqli_real_escape_string($connexion_bdd, $_POST['video']);
$categorie = mysqli_real_escape_string($connexion_bdd, $_POST['categorie']);
$date = mysqli_real_escape_string($connexion_bdd, $_POST['date']);
$collaborateurs_selected = $_POST['collaborateurs'] ?? [];
$categorieNom = getCategoriesName($connexion_bdd, $categorie);

// On récupère d'abord le média existant sélectionné (si présent)
if (!empty($_POST["media_existant"])) {
    $mediasPath = mysqli_real_escape_string($connexion_bdd, $_POST["media_existant"]);
}

// Upload d'une nouvelle image uniquement si aucun média existant sélectionné
if (!empty($_FILES["medias"]["name"])) { 
    $uploadResult = uploadImage("medias", $categorieNom);

    if (isset($uploadResult["error"])) {
        $error_msg_medias = $uploadResult["error"];
    } elseif (isset($uploadResult["success"])) {
        $mediasPath =  $uploadResult["success"];
    }
}?>