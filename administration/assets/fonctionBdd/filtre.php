<?php 
function fetchFilteredData($connexion_bdd, $table, $colonnes, $filtreBDD = '', $filtreSubmit = '') {
    // Joindre les colonnes avec des virgules
    $colonnesListe = implode(", ", $colonnes);

    // Si la table est 'categories', ne pas faire de jointure
    if ($table === 'categories') {
        $requeteFiltre = "SELECT $colonnesListe FROM $table";
    } else {
        $requeteFiltre = "SELECT $colonnesListe FROM $table LEFT JOIN categories ON $table.idCategories = categories.id";
    }

    // Ajouter le filtrage si une valeur de filtre est fournie
    if (!empty($filtreBDD) && !empty($filtreSubmit)) {
        $filtreSubmit = mysqli_real_escape_string($connexion_bdd, $filtreSubmit);
        $requeteFiltre .= " WHERE $filtreBDD = '$filtreSubmit'";
    }

    $resultatFiltre = mysqli_query($connexion_bdd, $requeteFiltre);

    if (!$resultatFiltre) {
        die("Erreur SQL : " . mysqli_error($connexion_bdd));
    }

    return $resultatFiltre;
}
?>