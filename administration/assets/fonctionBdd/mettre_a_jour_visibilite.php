<?php
require_once('../../../assets/php/connexion_bdd.php'); // Connexion à la base de données

// Fonction générique pour mettre à jour la visibilité
function mettre_a_jour_visibilite($connexion_bdd, $table, $id, $visibilite) {

    // Construction de la requête SQL pour mettre à jour la visibilité
    $query = "UPDATE {$table} SET visibilite = ? WHERE id = ?";
    $stmt = $connexion_bdd->prepare($query);
    $stmt->bind_param("ii", $visibilite, $id);
    
    return $stmt->execute();
}

// Si les paramètres sont passés par POST
if (isset($_POST['id']) && isset($_POST['visibilite']) && isset($_POST['table'])) {
    $id = (int) $_POST['id'];
    $visibilite = (int) $_POST['visibilite'];
    $table = $_POST['table'];

    if (mettre_a_jour_visibilite($connexion_bdd,$table, $id, $visibilite)) {
        echo "Visibilité mise à jour";
    } else {
        echo "Erreur de mise à jour";
    }
}
?>
