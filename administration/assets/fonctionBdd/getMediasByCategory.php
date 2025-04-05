<?php
require_once('../../../assets/php/connexion_bdd.php');

if (!isset($_GET['categorie_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "ID catégorie manquant"]);
    exit;
}

$categorie_id = intval($_GET['categorie_id']);
$query = "SELECT id, titre, lien FROM medias WHERE idCategories = $categorie_id";
$result = mysqli_query($connexion_bdd, $query);

$medias = [];
while ($row = mysqli_fetch_assoc($result)) {
    $medias[] = $row;
}

header('Content-Type: application/json');
echo json_encode($medias);
?>