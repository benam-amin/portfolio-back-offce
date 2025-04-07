<?php 
$page_courante = "projects";
$modifier = true;
require_once('../header-admin.php'); 
require_once('../assets/fonctionBdd/getCategoriesName.php');
require_once('../assets/fonctionBdd/deplacerMedia.php');
require_once('../assets/fonctionBdd/addMedia.php');
require_once('../assets/fonctionBdd/filtre.php'); // Importation de la fonction fetchFilteredData

$formulaire_soumis = (!empty($_POST)); // Variable indiquant si le formulaire a été soumis 
$entite = null; 
$mediasPath = null;
$error_msg_medias = null;

// Vérification si un ID de projet a été passé dans l'URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connexion_bdd, $_GET['id']);
    // Colonnes à récupérer depuis la base de données
    $colonnesBDD = [
        'projects.id', 
        'projects.titre', 
        'projects.chapo', 
        'projects.date', 
        'projects.lienMedia',
        'projects.lienProjet',
        'projects.video',
        'projects.idCategories',
        'projects.description',
        'projects.visibilite',
        'projects.outils',
        'categories.nom AS categorie',
        'GROUP_CONCAT(COALESCE(collaborators.nom, "Aucun collaborateur") SEPARATOR ", ") AS collaborateurs' // Agrégation des collaborateurs
    ];
    // Ajout de la table des collaborateurs dans la requête de récupération des données
    $resultat = fetchFilteredData($connexion_bdd, 'projects', $colonnesBDD, '', '', $id);

    if ($resultat && mysqli_num_rows($resultat) > 0) {
        $entite = mysqli_fetch_assoc($resultat);
        
        // Récupérer les collaborateurs associés à ce projet
        $collaborateurs_associés = [];
        $collaborateurs_query = "SELECT collaborator_id FROM project_collaborators WHERE project_id = $id";
        $collaborateurs_result = mysqli_query($connexion_bdd, $collaborateurs_query);

        while ($row = mysqli_fetch_assoc($collaborateurs_result)) {
            $collaborateurs_associés[] = $row['collaborator_id'];
        }
    } else {
        // Si le projet n'existe pas
        header("Location: index.php");
        exit();
    }
} else {
    // Si aucun ID n'est passé dans l'URL
    header("Location: index.php");
    exit();
}

// Récupérer tous les collaborateurs
$collaborateurs_resultat = mysqli_query($connexion_bdd, "SELECT id, nom, prenom FROM collaborators");
$requeteCategories = "SELECT id, nom FROM categories";
$resultatCategories = mysqli_query($connexion_bdd, $requeteCategories);
$mediaLien = mysqli_real_escape_string($connexion_bdd, $entite["lienMedia"]);
// $requeteMedia = "SELECT id FROM medias WHERE lien = '$mediaLien'";
// $resultatMedia = mysqli_query($connexion_bdd, $requeteMedia);
// $media = mysqli_fetch_assoc($resultatMedia);

// Traitement du formulaire de modification
if ($formulaire_soumis) {
    //récupération des variables nécessaires
    require_once('../assets/initProjectsInsert.php');
    
    // Vérification et déplacement du média si la catégorie a changé
    // if (isset($entite["idCategories"]) && $entite["idCategories"] != $categorie) {
    //     moveMediaFile($mediaLien, $categorie, $media["id"], $connexion_bdd);
    // }

    // S'assurer que $mediasPath est bien échappé pour les caractères spéciaux
    $mediasPath = mysqli_real_escape_string($connexion_bdd, $mediasPath);
    
        // Si $mediasPath a été modifié, mettre à jour le lien dans la table medias
    if ($mediasPath || $categorie != $entite["idCategories"]) {
        if ($mediasPath != null) { $updateMedia = "UPDATE medias SET lien = '$mediasPath', idCategories = '$categorie' WHERE lien = '$mediaLien'"; }
        else {$updateMedia = "UPDATE medias SET lien = '$mediaLien', idCategories = '$categorie' WHERE lien = '$mediaLien'";}
            mysqli_query($connexion_bdd, $updateMedia);
        }
    // Mise à jour du projet dans la base de données
    $requete_update = "UPDATE projects SET 
                        titre = '$titre', 
                        chapo = '$chapo', 
                        description = '$description',
                        date = '$date', 
                        outils = '$outils',
                        video = '$video', 
                        lienProjet = '$lienProjet', 
                        visibilite = '$visibilite', 
                        idCategories = '$categorie'" . 
                        ($mediasPath ? ", lienMedia = '$mediasPath'" : "") . 
                        " WHERE id = $id";

    // Exécution de la mise à jour du projet
    $resultat_update = mysqli_query($connexion_bdd, $requete_update);


    

    if ($resultat_update) {
        // Supprimer les anciennes relations avec les collaborateurs
        mysqli_query($connexion_bdd, "DELETE FROM project_collaborators WHERE project_id = $id");

        // Ajouter les nouvelles relations avec les collaborateurs sélectionnés
        if (!empty($collaborateurs_selected)) {
            foreach ($collaborateurs_selected as $collaborateur_id) {
                $collaborateur_id = mysqli_real_escape_string($connexion_bdd, $collaborateur_id);
                mysqli_query($connexion_bdd, "INSERT INTO project_collaborators (project_id, collaborator_id) VALUES ($id, $collaborateur_id)");
            }
        }

        // Rediriger après l'update
        header("Location: ./");
        exit();
    } else {
        $error_msg = "Erreur lors de la mise à jour du projet.";
    }
}

?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier le projet - <?php echo htmlspecialchars($entite['titre']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Section principale -->
    <section class="py-12 px-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Modification du projet : <?php echo htmlspecialchars($entite['titre']); ?></h1>
            
            <!-- Formulaire de modification -->
            <div class="w-full max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
                <?php if (isset($error_msg)) { ?>
                    <div class="text-red-500 text-lg mb-4"><?php echo $error_msg; ?></div>
                <?php } ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="titre" class="block text-lg font-medium text-gray-700">Titre</label>
                        <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($entite['titre']); ?>" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label for="chapo" class="block text-lg font-medium text-gray-700">Chapo</label>
                        <input type="text" id="chapo" name="chapo" value="<?php echo htmlspecialchars($entite['chapo']); ?>" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" class="w-full px-4 py-2 border rounded-md" rows="4" required><?php echo htmlspecialchars($entite['description']); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="outils" class="block text-lg font-medium text-gray-700">Outils</label>
                        <input type="text" id="outils" name="outils" value="<?php echo htmlspecialchars($entite['outils']); ?>" class="w-full px-4 py-2 border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="video" class="block text-lg font-medium text-gray-700">Vidéo</label>
                        <input type="text" id="video" name="video" value="<?php echo htmlspecialchars($entite['video']); ?>" class="w-full px-4 py-2 border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="lienProjet" class="block text-lg font-medium text-gray-700">Lien du projet</label>
                        <input type="text" id="lienProjet" name="lienProjet" value="<?php echo $entite['lienProjet']; ?>" class="w-full px-4 py-2 border rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="categorie" class="block text-lg font-medium text-gray-700">Catégorie</label>
                        <select name="categorie" id="categorie" class="w-full px-4 py-2 border rounded-md">
                            <?php
                            while ($categorie_item = mysqli_fetch_assoc($resultatCategories)) {
                                $categoriesHorsProjets = ["collaborateur", "contenu", "CV"];
                                if(in_array($categorie_item["nom"], $categoriesHorsProjets)) { 

                                } else {
                                    echo "<option value='" . $categorie_item['id'] . "'";
                                if ($entite['idCategories'] === $categorie_item['id']) {
                                    echo " selected style='background-color: red;'";
                                }
                                echo ">" . htmlspecialchars($categorie_item['nom']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                     <!-- Champ pour la date de création du projet -->
                     <div class="mb-4">
                        <label for="date" class="block text-lg font-medium text-gray-700">Date de création</label>
                        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($entite['date']); ?>" class="w-full px-4 py-2 border rounded-md">
                    </div>
                    <!-- Affichage des images et des zones d'upload -->
                    <?php require_once ('../assets/gestionImage.php'); ?>

                    <!-- Collaborateurs -->
                    <div class="mb-4">
                        <label class="block text-lg font-medium text-gray-700">Collaborateurs</label>
                        <div class="grid grid-cols-2 gap-4">
                            <?php while ($collaborateur = mysqli_fetch_assoc($collaborateurs_resultat)) { ?>
                                <div class="flex items-center">
                                    <input type="checkbox" name="collaborateurs[]" value="<?php echo $collaborateur['id']; ?>" 
                                        <?php echo in_array($collaborateur['id'], $collaborateurs_associés) ? 'checked' : ''; ?> 
                                    >
                                    <span class="ml-2"><?php echo htmlspecialchars($collaborateur['nom']) . " " . htmlspecialchars($collaborateur['prenom']); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- Section des boutons radio pour la visibilité -->
                    <?php visibiliteInput($entite['visibilite']);?>

                    <div class="flex gap-4">
                            <button type="submit" class="rounded-md bg-blue-500 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-blue-700">Modifier</button>
                            <a href="./" class="rounded-md bg-gray-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-gray-700">Retour</a>
                        </div>
                </form>
            </div>
        </div>
    </section>
    <?php require_once('../footer-admin.php'); ?>
    <script src="../assets/dragDrop.js"></script>
    <script src="../assets/displayMediasByCategories.js"></script>

</body>
</html>
