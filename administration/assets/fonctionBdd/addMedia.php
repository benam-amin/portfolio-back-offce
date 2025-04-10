<?php
//ajoute un media dans la base de données
function addMedia($connexion_bdd, $titre, $label, $idCategories, $mediasPath, $alt) {
    // Requête d'insertion
    $requete = "INSERT INTO medias (titre, label, idCategories, lien, alt) VALUES ('$titre', '$label', '$idCategories', '$mediasPath', '$alt')";

    // Exécution de la requête
    if (mysqli_query($connexion_bdd, $requete)) {
        // Si l'ajout réussit, retourne une réponse positive
        return ["success" => true, "message" => "Média ajouté avec succès !"];
    } else {
        // Si l'ajout échoue, retourne l'erreur mais sans l'afficher directement
        return ["success" => false, "message" => "Erreur lors de l'ajout du média : " . mysqli_error($connexion_bdd)];
    }
}
?>
