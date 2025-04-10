<?php 
// Définition des variables pour gérer l'état de la page
$page_courante = "contenu"; 
$modifier = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification - Contenu</title>
    <!-- Import de Tailwind CSS et FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900" data-page-courante="<?php echo $page_courante ?>">

<?php
    // Import des fichiers nécessaires
    require_once('../header-admin.php'); // Récupération du header de l'administration
    require_once('../assets/fonctionBdd/addMedia.php'); // Fonction pour ajouter des médias
    require_once('../assets/gestionUpload.php'); // Gestion des uploads de fichiers
    require_once('../assets/fonctionBdd/editInit.php'); // Initialisation pour l'édition d'un contenu

    $error_msg = ""; // Initialisation des messages d'erreur
    $error_msg_medias = "";
    $mediasPath = mysqli_real_escape_string($connexion_bdd, $entite['lienMedia']);

    // Choix du nom de la catégorie selon la section
    $nomCategorie = ($entite['section'] == "CV") ? "CV" : "contenu";  

    // Récupération de la catégorie depuis la base de données
    $requeteCategorie = "SELECT id, nom FROM categories WHERE nom = '$nomCategorie';";
    $resultatCategories = mysqli_query($connexion_bdd, $requeteCategorie);
    $categorie_item = mysqli_fetch_assoc($resultatCategories);
    $categorieId = $categorie_item['id'];

    // Récupération des médias existants de cette catégorie
    $mediasExistants = [];
    $queryMedias = "SELECT id, titre, lien FROM medias WHERE idCategories = $categorieId ORDER BY id DESC";
    $resultMedias = mysqli_query($connexion_bdd, $queryMedias);
    while ($media = mysqli_fetch_assoc($resultMedias)) {
        $mediasExistants[] = $media; // Ajout des médias existants à un tableau
    }

    // Traitement du formulaire
    if ($formulaire_soumis) {
        if (!empty($_POST["section"])) {
            // Nettoyage des champs du formulaire
            $section = htmlentities($_POST["section"]);
            $titre = htmlentities($_POST["titre"]);
            $sousTitre = htmlentities($_POST["sousTitre"]);
            $description = htmlentities($_POST["description"]);
            $lienBouton = htmlentities($_POST["lienBouton"]);

            // Gestion des médias : upload ou sélection (facultatif)
            if (!empty($_FILES["medias"]["name"])) {
                // Tentative d'upload d'une nouvelle image
                $uploadResult = uploadImage("medias", "contenu", $page_courante);
                if (isset($uploadResult["success"])) {
                    // Si l'upload réussit, ajout du média à la base de données
                    $mediasPath = mysqli_real_escape_string($connexion_bdd, $uploadResult["success"]);
                    $addMediaResult = addMedia($connexion_bdd, $titre, $titre, $categorieId, $mediasPath, $section);
                    
                    // Vérification de l'ajout
                    if ($addMediaResult["success"]) {
                        echo "<p class='text-green-500 text-lg font-semibold'>" . $addMediaResult["message"] . "</p>";
                    } else {
                        $error_msg_medias = $addMediaResult["message"]; // Message d'erreur
                    }
                } else {
                    $error_msg_medias = $uploadResult["error"]; // Message d'erreur en cas d'échec
                }
            }

            // Requête de mise à jour du contenu dans la base de données
            $requete_modif = "UPDATE contenu SET section = '$section', titre = '$titre', sousTitre = '$sousTitre', description = '$description', lienMedia = '$mediasPath', lienBouton = '$lienBouton' WHERE id = $id;";
            $resultat_modif = mysqli_query($connexion_bdd, $requete_modif);

            // Redirection vers la page principale après mise à jour
            header("Location: ./");
            exit();
        } else {
            $error_msg = "Veuillez remplir tous les champs du formulaire."; // Message d'erreur si le formulaire n'est pas complet
        }
    }
?>

<!-- HTML du formulaire de modification -->
<main class="mx-6 md:mx-20">
    <div class="mx-auto max-w-lg py-12">
        <h1 class="text-3xl font-bold text-center mb-8">Modification de <?php echo $entite['section'];?></h1>

        <div class="w-full bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <form method="POST" action="" enctype="multipart/form-data">
                <section class="grid gap-6">
                    <!-- Champs du formulaire -->
                    <div>
                        <label for="section" class="block text-lg font-medium text-gray-700">Section</label>
                        <input type="text" name="section" id="section" required value="<?php echo $entite['section']; ?>"
                            class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                    </div>

                    <div>
                        <label for="titre" class="block text-lg font-medium text-gray-700">Titre</label>
                        <input type="text" name="titre" id="titre" required value="<?php echo $entite['titre']; ?>"
                            class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                    </div>

                    <div>
                        <label for="sousTitre" class="block text-lg font-medium text-gray-700">Sous-titre</label>
                        <input type="text" name="sousTitre" id="sousTitre" value="<?php echo $entite['sousTitre']; ?>"
                            class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                    </div>

                    <div>
                        <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800"><?php echo $entite['description']; ?></textarea>
                    </div>

                    <div>
                        <label for="lienBouton" class="block text-lg font-medium text-gray-700">Lien du bouton</label>
                        <input type="text" name="lienBouton" id="lienBouton" rows="4"
                            class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800"><?php echo $entite['lienBouton']; ?></input>
                    </div>

                    <!-- Catégorie masquée -->
                    <div class="hidden">
                        <label for="categorie" class="block text-lg font-medium text-gray-700">Catégorie</label>
                        <select name="categorie" id="categorie" class="w-full px-4 py-2 border rounded-md">
                            <option value="<?php echo $categorie_item['id']; ?>" selected><?php echo $categorie_item['nom']; ?></option>
                        </select>
                    </div>

                    <!-- Inclusion de la gestion d'image (upload/sélection) -->
                    <?php require_once ('../assets/gestionImage.php'); ?>

                    <!-- Boutons d'action -->
                    <div class="flex gap-4">
                        <button type="submit" class="rounded-md bg-blue-500 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-blue-700">Enregistrer</button>
                        <a href="./" class="rounded-md bg-gray-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-gray-700">Retour</a>
                    </div>
                </section>
            </form>
        </div>

        <!-- Message d'erreur si besoin -->
        <?php if (!empty($error_msg)) { ?>
            <section class="mt-4 text-red-500 text-lg font-semibold" role="alert">
                <p><?php echo $error_msg; ?></p>
            </section>
        <?php } ?>
    </div>
</main>

<!-- Pied de page et scripts JS -->
<?php require_once('../footer-admin.php'); ?>
<script src="../assets/dragDrop.js"></script>
<script src="../assets/displayMediasByCategories.js"></script>
</body>
</html>
