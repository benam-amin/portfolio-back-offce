<?php
function fetchFilteredData($connexion_bdd, $table, $colonnes, $filtreBDD = '', $filtreSubmit = '') {
    // Joindre les colonnes avec des virgules
    $colonnesListe = implode(", ", $colonnes);

    // Construire la requête de base
    $requeteFiltre = "SELECT $colonnesListe FROM $table";

    // Ajouter les jointures selon la table
    if ($table === 'projects') {
        $requeteFiltre .= " 
            LEFT JOIN project_collaborators ON projects.id = project_collaborators.project_id
            LEFT JOIN collaborators ON project_collaborators.collaborator_id = collaborators.id
            LEFT JOIN categories ON projects.idCategories = categories.id";
    } elseif ($table === 'categories') {
        // Pas de jointure pour la table `categories`
    } else {
        // Jointure par défaut avec `categories` si la table est autre
        $requeteFiltre .= " 
            LEFT JOIN categories ON $table.idCategories = categories.id";
    }

    // Ajouter le filtrage si une valeur de filtre est fournie
    if (!empty($filtreBDD) && !empty($filtreSubmit)) {
        $filtreSubmit = mysqli_real_escape_string($connexion_bdd, $filtreSubmit);
        $requeteFiltre .= " WHERE $filtreBDD = '$filtreSubmit'";
    }
    echo $requeteFiltre;
    // Exécuter la requête
    $resultatFiltre = mysqli_query($connexion_bdd, $requeteFiltre);

    if (!$resultatFiltre) {
        die("Erreur SQL : " . mysqli_error($connexion_bdd));
    }

    return $resultatFiltre;
}
?>
