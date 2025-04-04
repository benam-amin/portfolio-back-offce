<?php 
require_once('../../../assets/php/connexion_bdd.php');
// Vérifier si les données ont été envoyées via AJAX
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id']) && isset($_POST['table'])) {
    $id = $_POST['id'];
    $table = $_POST['table'];
    
    // Appeler la fonction deleteFromTable pour supprimer l'élément
    echo deleteFromTable($connexion_bdd, $table, $id);
}

// Fonction pour supprimer un élément de la base de données
function deleteFromTable($connexion_bdd, $table, $id) {
    $requete_suppr = "DELETE FROM $table WHERE id = $id";
    if (mysqli_query($connexion_bdd, $requete_suppr)) {
        return "L'élément a bien été supprimé !";
    } else {
        return "Erreur de suppression";
    }
}


?>