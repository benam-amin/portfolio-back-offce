<?php 
$page_courante = "projects";
require_once('../header-admin.php'); 
require_once('../assets/fonctionBdd/getCategoriesName.php');
require_once('../assets/fonctionBdd/deplacerMedia.php');
require_once('../assets/fonctionBdd/addMedia.php');
$formulaire_soumis = (!empty($_POST)); // Variable indiquant si le formulaire a été soumis 
$entite = null; 
$mediasPath = null;
$error_msg_medias = null;

// Vérification si un ID de projet a été passé dans l'URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connexion_bdd, $_GET['id']);

    // Récupération des données du projet
    $requete = "SELECT projects.*, GROUP_CONCAT(collaborators.nom SEPARATOR ', ') AS collaborateurs, categories.nom AS categorie 
                FROM projects 
                LEFT JOIN categories ON projects.idCategories = categories.id 
                LEFT JOIN project_collaborators AS pc ON projects.id = pc.project_id 
                LEFT JOIN collaborators ON pc.collaborator_id = collaborators.id 
                WHERE projects.id = $id";
    $resultat = mysqli_query($connexion_bdd, $requete);

    if ($resultat && mysqli_num_rows($resultat) > 0) {
        $entite = mysqli_fetch_assoc($resultat);
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

// Traitement du formulaire de modification
if ($formulaire_soumis) {
    $titre = mysqli_real_escape_string($connexion_bdd, $_POST['titre']);
    $chapo = mysqli_real_escape_string($connexion_bdd, $_POST['chapo']);
    $description = mysqli_real_escape_string($connexion_bdd, $_POST['description']);
    $outils = mysqli_real_escape_string($connexion_bdd, $_POST['outils']);
    $video = mysqli_real_escape_string($connexion_bdd, $_POST['video']);
    $categorie = mysqli_real_escape_string($connexion_bdd, $_POST['categorie']);
    $collaborateurs_selected = $_POST['collaborateurs'] ?? []; // Récupère les collaborateurs sélectionnés
    $categorieNom = getCategoriesName($connexion_bdd, $categorie);

    // Gestion de l'upload de l'image du projet
    $mediasPath = mysqli_real_escape_string($connexion_bdd, $_POST['lienMedia']);
    if (!empty($_FILES["medias"]["name"])) { 
        $uploadResult = uploadImage("medias", $categorieNom);

        if (isset($uploadResult["error"])) {
            $error_msg_medias = $uploadResult["error"];
        } elseif (isset($uploadResult["success"])) {
            $mediasPath = $uploadResult["success"];
            $mediasPath = mysqli_real_escape_string($connexion_bdd, $mediasPath); // Échapper le chemin du fichier
        }
        if ($mediasPath == mysqli_real_escape_string($connexion_bdd, $_POST['lienMedia'])) {
            $requete_media = "SELECT id FROM medias WHERE lien = '$mediasPath'";
            $resultat_media = mysqli_query($connexion_bdd, $requete_media);
            $mediaId = mysqli_fetch_assoc( $resultat_media);
            $error_msg = moveMediaFile($mediasPath, $categorieNom, $mediaId["id"], $connexion_bdd);
        }
    }

    // Mise à jour du projet dans la base de données
    $requete_update = "UPDATE projects SET 
                        titre = '$titre', 
                        chapo = '$chapo', 
                        description = '$description', 
                        outils = '$outils',
                        video = '$video', 
                        idCategories = '$categorie'";

    if ($mediasPath) {
        $requete_update .= ", lienMedia = '$mediasPath'"; // Ajout du chemin de l'image si elle existe
    }

    $requete_update .= " WHERE id = $id";
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

        if (addMedia($connexion_bdd, $titre, $chapo, $categorie, $mediasPath, $chapo) == "success") {
            header("Location: ./");
            exit();
        } else {
            $error_msg = "Erreur lors de la préparation de la requête.";
        }
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
                        <label for="categorie" class="block text-lg font-medium text-gray-700">Catégorie</label>
                        <select name="categorie" id="categorie" class="w-full px-4 py-2 border rounded-md">
                            <?php
                            // Récupérer les catégories
                            while ($categorie_item = mysqli_fetch_assoc($resultatCategories)) {
                                echo "<option value='" . $categorie_item['id'] . "' " . ($entite['idCategories'] == $categorie_item['id'] ? 'selected' : '') . ">" . htmlspecialchars($categorie_item['nom']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Visualisation de l'image actuelle -->
                    <?php if (!empty($entite['lienMedia'])) { ?>
                        <div class="mb-4">
                            <label class="block text-lg font-medium text-gray-700">Image actuelle</label>
                            <img src="../<?php echo htmlspecialchars($entite['lienMedia']); ?>" alt="Image actuelle du projet" class="w-full h-auto rounded-md mb-4">
                        </div>
                    <?php } ?>

                    <!-- Upload de l'image -->
                    <div class="mb-4">
                        <?php
                            inputUpload("Image du projet", "medias", $mediasPath, $error_msg_medias); 
                            if (!empty($error_msg_medias)) { ?>
                            <p class='text-red-500 text-sm mt-2'><?php echo $error_msg_medias; ?></p>
                        <?php } ?>
                    </div>

                    <!-- Collaborateurs -->
                    <div class="mb-4">
                        <label class="block text-lg font-medium text-gray-700">Collaborateurs</label>
                        <div class="space-y-2">
                            <?php 
                            // Si la colonne 'collaborateurs' est null ou vide, on la remplace par une chaîne vide.
                            $collaborateurs_array = $entite['collaborateurs'] ? explode(",", $entite['collaborateurs']) : [];
                            
                            while ($collaborateur = mysqli_fetch_assoc($collaborateurs_resultat)) { ?>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="collaborateurs[]" value="<?php echo $collaborateur['id']; ?>" 
                                        <?php echo (in_array($collaborateur['id'], $collaborateurs_array)) ? 'checked' : ''; ?> 
                                        class="form-checkbox text-blue-600">
                                    <span class="ml-2"><?php echo htmlspecialchars($collaborateur['nom']); ?></span>
                                </label>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md">Modifier</button>
                        <a href="index.php" class="bg-gray-600 text-white px-6 py-2 rounded-md">Retour</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require_once('../footer-admin.php'); ?>
    <script src="../assets/dragDrop.js"></script>

</body>
</html>
