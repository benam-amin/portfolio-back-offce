<?php 
$page_courante = "contenu"; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création - Contenu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900" data-page-courante="<?php echo $page_courante ?>">
    <?php
        require_once('../header-admin.php');
        require_once('../assets/fonctionBdd/addMedia.php');
        require_once('../assets/fonctionBdd/addContenu.php');

        $error_msg_medias = "";
        $mediasPath = null;
        $error_msg = "";

        // 🔹 Récupération de la catégorie "collaborateur"
        $requeteCategorie = "SELECT id, nom FROM categories WHERE nom = 'contenu';";
        $resultatCategories = mysqli_query($connexion_bdd, $requeteCategorie);
        $categorie_item = mysqli_fetch_assoc($resultatCategories);

        // 🔹 Récupération des médias existants de la catégorie "collaborateur"
        $mediasExistants = [];
        $queryMedias = "SELECT id, titre, lien FROM medias WHERE idCategories = 15 ORDER BY id DESC";
        $resultMedias = mysqli_query($connexion_bdd, $queryMedias);
        while ($media = mysqli_fetch_assoc($resultMedias)) {
            $mediasExistants[] = $media;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!isset($connexion_bdd)) {
                die("Erreur : Connexion à la base de données non établie.");
            }

            if (!empty($_POST["section"])) {
                $section = htmlentities($_POST["section"]);
                $titre = htmlentities($_POST["titre"]);
                $sousTitre = htmlentities($_POST["sousTitre"]);
                $description = htmlentities($_POST["description"]);

                // 🔹 Tentative d’upload d’une image (prioritaire)
                if (!empty($_FILES["medias"]["name"])) {
                    $uploadResult = uploadImage("medias", "contenu", $page_courante);
                    if (isset($uploadResult["error"])) {
                        $error_msg_medias = $uploadResult["error"];
                    } elseif (isset($uploadResult["success"])) {
                        $mediasPath = $uploadResult["success"];
                    }
                }
                // 🔹 Sinon, tentative de sélection d’un média existant
                elseif (!empty($_POST["mediaExistant"])) {
                    $mediasPath = mysqli_real_escape_string($connexion_bdd, $_POST["mediaExistant"]);
                }

                $categorieId = 15;
                if ($mediasPath !== null) {
                    if ($section == "CV") { 
                        $categorieId = 17;
                    }
                    if (
                        (empty($_POST["mediaExistant"]) && addMedia($connexion_bdd, $titre, $titre, $categorieId, $mediasPath, $section) == "success") || 
                        !empty($_POST["mediaExistant"])
                    ) {
                        // 🔹 Ajout du collaborateur avec le chemin de l’image
                        if (addContenu($connexion_bdd, $section, $titre, $sousTitre, $description, $mediasPath) == "success") {
                            header("Location: ./");
                            exit();
                        } else {
                            $error_msg = "Erreur lors de l'ajout du collaborateur.";
                        }
                    } else {
                        $error_msg = "Erreur lors de l'ajout du média.";
                    }
                } else {
                    $error_msg = "Aucun média n'a été sélectionné ou téléversé.";
                }

            } else {
                $error_msg = "Veuillez remplir tous les champs du formulaire.";
            }
        }
    ?>


    <main class="mx-6 md:mx-20">
        <div class="mx-auto max-w-lg py-12">
            <h1 class="text-3xl font-bold text-center mb-8">Ajout d'un nouveau contenu</h1>
            
            <div class="w-full bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <form method="POST" action="" enctype="multipart/form-data">
                    <section class="grid gap-6">
                        <div>
                            <label for="section" class="block text-lg font-medium text-gray-700">Section</label>
                            <input type="text" placeholder="ex: Accueil, Réalisations, etc." name="section" id="section" required
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        
                        <div>
                            <label for="titre" class="block text-lg font-medium text-gray-700">Titre</label>
                            <input type="text" placeholder="Titre du contenu" name="titre" id="titre" required
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>

                        <div>
                            <label for="sousTitre" class="block text-lg font-medium text-gray-700">Sous-titre</label>
                            <input type="text" placeholder="Sous-titre (facultatif)" name="sousTitre" id="sousTitre"
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>

                        <div>
                            <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" placeholder="Description détaillée"
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800"></textarea>
                        </div>

                        <div class="hidden">
                            <label for="categorie" class="block text-lg font-medium text-gray-700">Catégorie</label>
                            <select name="categorie" id="categorie" class="w-full px-4 py-2 border rounded-md">
                                <?php
                                    echo "<option value='" . $categorie_item['id'] . "' selected>" . htmlspecialchars($categorie_item['nom']) . "</option>";
                                ?>
                            </select>
                        </div>

                        <?php require_once ('../assets/gestionImage.php'); ?>
                        
                        <div class="flex gap-4">
                            <button type="submit" class="rounded-md bg-blue-500 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-blue-700">Créer</button>
                            <a href="./" class="rounded-md bg-gray-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-gray-700">Retour</a>
                        </div>
                    </section>
                </form>
            </div>
            
            <?php if (!empty($error_msg)) { ?>
                <section class="mt-4 text-red-500 text-lg font-semibold" role="alert">
                    <p><?php echo $error_msg; ?></p>
                </section>
            <?php } ?>
        </div>

    </main>

    <?php require_once('../footer-admin.php'); ?>
    <script src="../assets/dragDrop.js"></script>
    <script src="../assets/displayMediasByCategories.js"></script>
</body>
</html>
