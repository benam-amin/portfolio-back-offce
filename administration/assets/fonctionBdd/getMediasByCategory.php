<?php
require_once('../../../assets/php/connexion_bdd.php'); // Inclusion de la connexion à la base de données

// Vérification si le paramètre 'categorie_id' est présent dans l'URL
if (!isset($_GET['categorie_id'])) {
    http_response_code(400); // Si le paramètre est manquant, on renvoie un code de réponse 400 (Bad Request)
    echo json_encode(["error" => "ID catégorie manquant"]); // On renvoie un message d'erreur au format JSON
    exit; // Arrêt de l'exécution du script
}

// Récupération de l'ID de la catégorie depuis l'URL et conversion en entier
$categorie_id = intval($_GET['categorie_id']);

// Construction de la requête SQL pour sélectionner les médias correspondant à l'ID de la catégorie
$query = "SELECT id, titre, lien FROM medias WHERE idCategories = $categorie_id";

// Exécution de la requête SQL
$result = mysqli_query($connexion_bdd, $query);

// Initialisation d'un tableau pour stocker les résultats
$medias = [];

// Récupération des résultats de la requête et ajout dans le tableau $medias
while ($row = mysqli_fetch_assoc($result)) {
    $medias[] = $row; // Ajoute chaque ligne du résultat dans le tableau $medias
}

// Définition de l'en-tête de la réponse HTTP pour indiquer que le contenu est en JSON
header('Content-Type: application/json');

// Renvoi des résultats sous forme de JSON
echo json_encode($medias);
?>
