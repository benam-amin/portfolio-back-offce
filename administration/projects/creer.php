<?php 
// Page courante, pour savoir où l'on est dans le back-office
$page_courante = "projects";
// Inclusion des fichiers nécessaires : en-tête, récupération des catégories et ajout de médias
require_once('../header-admin.php'); 
require_once('../assets/fonctionBdd/getCategoriesName.php');
require_once('../assets/fonctionBdd/addMedia.php');

// Variable indiquant si le formulaire a été soumis
$formulaire_soumis = (!empty($_POST)); 
$mediasPath = null; // Variable pour stocker le chemin du média téléchargé
$error_msg_medias = null; // Variable pour stocker un message d'erreur concernant l'upload du média

// Récupération de tous les collaborateurs depuis la base de données
$collaborateurs_resultat = mysqli_query($connexion_bdd, "SELECT id, nom, prenom FROM collaborators");
// Récupération des catégories de projets
$requeteCategories = "SELECT id, nom FROM categories";
$resultatCategories = mysqli_query($connexion_bdd, $requeteCategories);

// Traitement du formulaire si soumis
if ($formulaire_soumis) {
    require_once('../assets/initProjectsInsert.php');

    // Insertion des données dans la table "projects" de la base de données
    $requete_insert = "INSERT INTO projects (titre, chapo, description, outils, video, lienProjet, idCategories, lienMedia, date, visibilite) 
                       VALUES ('$titre', '$chapo', '$description', '$outils', '$video', '$lienProjet', '$categorie', '$mediasPath', '$date', '$visibilite')";
    $resultat_insert = mysqli_query($connexion_bdd, $requete_insert);

    // Si l'insertion est réussie
    if ($resultat_insert) {
        // Récupère l'ID du projet inséré pour l'utiliser plus tard
        $project_id = mysqli_insert_id($connexion_bdd);

        // Ajoute les relations entre le projet et les collaborateurs sélectionnés
        if (!empty($collaborateurs_selected)) {
            foreach ($collaborateurs_selected as $collaborateur_id) {
                $collaborateur_id = mysqli_real_escape_string($connexion_bdd, $collaborateur_id);
                // Insère chaque collaborateur dans la table de relation entre projet et collaborateur
                mysqli_query($connexion_bdd, "INSERT INTO project_collaborators (project_id, collaborator_id) VALUES ($project_id, $collaborateur_id)");
            }
        }

        // Si tout est bon, redirige vers la page d'index
        if ($mediasPath) { addMedia($connexion_bdd, $titre, $chapo, $categorie, $mediasPath, $chapo) ;}
         
        header("Location: ./"); // Redirection vers la page principale des projets
        exit(); // Arrête l'exécution du script après la redirection
    } else {
        // Message d'erreur si l'insertion du projet échoue
        $error_msg = "Erreur lors de la création du projet.";
    }
}

?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer un projet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Section principale pour l'affichage du formulaire -->
    <section class="py-12 px-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Création d'un nouveau projet</h1>
            
            <!-- Formulaire de création du projet -->
            <div class="w-full max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
                <?php if (isset($error_msg)) { ?>
                    <div class="text-red-500 text-lg mb-4"><?php echo $error_msg; ?></div> <!-- Affichage des erreurs -->
                <?php } ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- Champ pour le titre du projet -->
                    <div class="mb-4">
                        <label for="titre" class="block text-lg font-medium text-gray-700">Titre</label>
                        <input type="text" id="titre" name="titre" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <!-- Champ pour le chapo (introduction) du projet -->
                    <div class="mb-4">
                        <label for="chapo" class="block text-lg font-medium text-gray-700">Chapo</label>
                        <input type="text" id="chapo" name="chapo" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <!-- Champ pour la description du projet -->
                    <div class="mb-4">
                        <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" class="w-full px-4 py-2 border rounded-md" rows="4" required></textarea>
                    </div>

                    <!-- Champ pour les outils utilisés dans le projet -->
                    <div class="mb-4">
                        <label for="outils" class="block text-lg font-medium text-gray-700">Outils</label>
                        <input type="text" id="outils" name="outils" class="w-full px-4 py-2 border rounded-md">
                    </div>

                    <!-- Champ pour l'URL de la vidéo du projet -->
                    <div class="mb-4">
                        <label for="video" class="block text-lg font-medium text-gray-700">Vidéo</label>
                        <input type="text" id="video" name="video" class="w-full px-4 py-2 border rounded-md">
                    </div>
                    <!-- Champ pour l'URL du lien du projet -->
                    <div class="mb-4">
                        <label for="lienProjet" class="block text-lg font-medium text-gray-700">Lien du projet</label>
                        <input type="text" id="lienProjet" name="lienProjet" class="w-full px-4 py-2 border rounded-md">
                    </div>

                    <!-- Liste déroulante pour choisir la catégorie du projet -->
                    <div class="mb-4">
                        <label for="categorie" class="block text-lg font-medium text-gray-700">Catégorie</label>
                        <select name="categorie" id="categorie" class="w-full px-4 py-2 border rounded-md">
                            <?php
                            // Récupère et affiche les catégories disponibles
                            while ($categorie_item = mysqli_fetch_assoc($resultatCategories)) {
                                $categoriesHorsProjets = ["collaborateur", "contenu", "CV"];
                                if(in_array($categorie_item["nom"], $categoriesHorsProjets)) { 

                                } else {
                                    echo "<option value='" . $categorie_item['id'] . "'>" . htmlspecialchars($categorie_item['nom']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Champ pour la date de création du projet -->
                    <div class="mb-4">
                        <label for="date" class="block text-lg font-medium text-gray-700">Date de création</label>
                        <input type="date" id="date" name="date" class="w-full px-4 py-2 border rounded-md" required>
                    </div>
                    <?php require_once ('../assets/gestionImage.php'); ?>

                    <!-- Sélection des collaborateurs associés au projet -->
                    <div class="mb-4">
                        <label class="block text-lg font-medium text-gray-700">Collaborateurs</label>
                        <div class="space-y-2">
                            <?php 
                            // Affiche les collaborateurs disponibles avec des cases à cocher
                            while ($collaborateur = mysqli_fetch_assoc($collaborateurs_resultat)) { ?>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="collaborateurs[]" value="<?php echo $collaborateur['id']; ?>" 
                                        class="form-checkbox text-blue-600">
                                    <span class="ml-2"><?php echo htmlspecialchars($collaborateur['nom']); ?></span>
                                </label>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- Section des boutons radio pour la visibilité -->
                    <?php visibiliteInput();?>

                    <!-- Boutons pour soumettre ou revenir -->
                    <div class="flex justify-between">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md">Créer</button>
                        <a href="index.php" class="bg-gray-600 text-white px-6 py-2 rounded-md">Retour</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Inclusion du footer -->
    <?php require_once('../footer-admin.php'); ?>
    <script src="../assets/dragDrop.js"></script>
    <script src="../assets/displayMediasByCategories.js"></script>

</body>
</html> 
