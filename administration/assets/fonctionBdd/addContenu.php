<?php 
function addCollaborator($connexion_bdd, $section, $titre, $sousTitre, $description, $lienMedia) {
    $requete = "INSERT INTO contenu (section, titre, sousTitre, description, lienMedia) VALUES (?, ?, ?, ?, ?)";
    $error_msg = "success";

    if ($stmt = $connexion_bdd->prepare($requete)) {
        // Liaison des paramètres avec les valeurs
        $stmt->bind_param("sssss", $section, $titre, $sousTitre, $description, $lienMedia);

        // Exécution de la requête
        if ($stmt->execute()) {
            echo "<p class='text-green-500 text-lg font-semibold'>Contenu ajouté avec succès !</p> 
                  <a href='./' class='text-blue-500 underline'>Retour</a>";
        } else {
            $error_msg = "<p class='text-red-500 text-sm mt-2'>Erreur lors de l'ajout du contenu : " . $stmt->error . "</p>";
        }

        // Fermeture de la requête préparée
        $stmt->close();
    } else {
        $error_msg = "<p class='text-red-500 text-sm mt-2'>Erreur lors de la préparation de la requête : " . $connexion_bdd->error . "</p>";
    }

    return $error_msg;
}
?>
