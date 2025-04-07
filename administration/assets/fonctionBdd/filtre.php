<?php
function fetchFilteredData($connexion_bdd, $table, $colonnes, $filtreBDD = '', $filtreSubmit = '', $id = '') {
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
    } elseif ($table === 'medias') {
        $requeteFiltre .= " 
            LEFT JOIN categories ON $table.idCategories = categories.id";
    } else {
        // Pas de jointure pour les autres tables 
        // Jointure par défaut avec `categories` si la table est autre
    }

    // Ajouter le filtrage si nécessaire
    if (!empty($filtreBDD) && !empty($filtreSubmit)) {
        $filtreSubmit = mysqli_real_escape_string($connexion_bdd, $filtreSubmit);
        $requeteFiltre .= " WHERE $filtreBDD = '$filtreSubmit'";
    }

    // Si un ID est fourni, ajouter une condition WHERE supplémentaire
    if (!empty($id)) {
        $id = mysqli_real_escape_string($connexion_bdd, $id); // Sécuriser l'ID
        if (strpos($requeteFiltre, 'WHERE') !== false) {
            $requeteFiltre .= " AND projects.id = '$id'";
        } else {
            $requeteFiltre .= " WHERE projects.id = '$id'";
        }
    }

    // Ajouter un GROUP BY si on est sur la table projects (pour gérer les GROUP_CONCAT)
    if ($table === 'projects') {
        $requeteFiltre .= " GROUP BY projects.id";
    }

    // Debug
    // echo "<pre>$requeteFiltre</pre>";

    // Exécuter la requête
    $resultatFiltre = mysqli_query($connexion_bdd, $requeteFiltre);

    if (!$resultatFiltre) {
        die("Erreur SQL : " . mysqli_error($connexion_bdd));
    }

    return $resultatFiltre;
}
?>
