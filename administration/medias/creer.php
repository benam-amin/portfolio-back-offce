<?php
$page_courante = "medias";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création Média - Portfolio Back Office</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php
        require_once('../header-admin.php'); // Récupération du header et de la connexion à la BDD
        require_once('../assets/fonctionBdd/getCategoriesName.php');

        $error_msg_medias = "";
        $mediasPath = null; // Initialisation de l'avatar
        $error_msg = "";
        $requeteCategories = "SELECT id, nom FROM categories;";
        $resultatCategories = mysqli_query($connexion_bdd, $requeteCategories);

        // Vérification de la soumission du formulaire
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Vérification de la connexion à la base de données
            if (!$connexion_bdd) {
                die("Erreur : Connexion à la base de données non établie.");
            }

            // Vérification que les champs obligatoires sont remplis
            if (!empty($_POST["titre"]) && !empty($_POST["label"]) && !empty($_POST["categorie"])) {

                // Récupération et nettoyage des données du formulaire
                $titre = mysqli_real_escape_string($connexion_bdd, $_POST["titre"]);
                $label = mysqli_real_escape_string($connexion_bdd, $_POST["label"]);
                $alt = mysqli_real_escape_string($connexion_bdd, $_POST["alt"]);
                $categorieId = mysqli_real_escape_string($connexion_bdd, $_POST["categorie"]);

                // Récupération du nom de la catégorie à partir de l'ID
                $categorieNom = getCategoriesName($connexion_bdd, $categorieId);

                // Gestion de l'upload de l'avatar
                if (!empty($_FILES["medias"]["name"])) { // Vérifie si un fichier est bien envoyé
                    $uploadResult = uploadImage("medias", $categorieNom);

                    if (isset($uploadResult["error"])) {
                        $error_msg_medias = $uploadResult["error"];
                        echo "<p class='text-red-500 text-sm mt-2'>Erreur d'upload : " . $error_msg_medias . "</p>";
                    } elseif (isset($uploadResult["success"])) {
                        $mediasPath = $uploadResult["success"]; // Stockage du chemin dans la BDD
                        echo "<p class='text-green-500 text-sm mt-2'>Upload réussi : " . $mediasPath . "</p> ";
                    }
                }

                // Préparation de la requête d'insertion sécurisée
                $requete = "INSERT INTO medias (titre, label, idCategories, lien, alt) VALUES (?, ?, ?, ?, ?)";
                var_dump($_POST, $mediasPath);

                if ($stmt = $connexion_bdd->prepare($requete)) {
                    // Liaison des paramètres avec les valeurs
                    $stmt->bind_param("sssss", $titre, $label, $categorieId, $mediasPath, $alt);

                    // Exécution de la requête
                    if ($stmt->execute()) {
                        echo "<p class='text-green-500 text-lg font-semibold'>Média ajouté avec succès !</p> <a href='./' class='text-red-500'>Retour</a></div>";
                        exit();
                    } else {
                        $error_msg = "Erreur lors de l'ajout du media.";
                        echo "<p class='text-red-500 text-sm mt-2'>Erreur : " . $error_msg . "</p>";
                    }

                    // Fermeture de la requête préparée
                    $stmt->close();
                } else {
                    $error_msg = "Erreur lors de la préparation de la requête.";
                    echo "<p class='text-red-500 text-sm mt-2'>Erreur : " . $error_msg . "</p>";
                }

            } else {
                // Message d'erreur si un champ est vide
                $error_msg = "Veuillez remplir tous les champs du formulaire.";
                echo "<p class='text-red-500 text-sm mt-2'>Erreur : " . $error_msg . "</p>";
            }
        }
    ?>

    <main class="mx-6 md:mx-20">
        <div class="mx-auto max-w-lg py-12">
            <h1 class="text-3xl font-bold text-center mb-8">Ajout d'un nouveau media</h1>

            <div class="w-full bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <form method="POST" action="" enctype="multipart/form-data">
                    <section class="grid gap-6">
                        <div>
                            <label for="titre" class="block text-lg font-medium text-gray-700">Titre</label>
                            <input type="text" placeholder="titre" name="titre" id="titre" required
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div>
                            <label for="label" class="block text-lg font-medium text-gray-700">Label</label>
                            <input type="text" placeholder="label" name="label" id="label" required
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div>
                            <label for="alt" class="block text-lg font-medium text-gray-700">Alt</label>
                            <input type="text" placeholder="alt" name="alt" id="alt"
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div>
                            <label for="categories" class="block text-lg font-medium text-gray-700">Liste des catégories</label>
                            <select name="categorie" id="categories">
                            <?php
                                while ($listeCategorie = mysqli_fetch_assoc($resultatCategories)) {
                                    ?>
                                    <option value="<?php echo $listeCategorie['id'];?>"><?php echo $listeCategorie['nom']?></option>
                                <?php }
                            ?>
                            </select>
                        </div>

                        <!-- Upload de l'image -->
                        <div>
                            <?php inputUpload("medias", "medias", $mediasPath, $error_msg_medias); ?>
                            <?php if (!empty($error_msg_medias)) { ?>
                                <p class='text-red-500 text-sm mt-2'><?php echo $error_msg_medias; ?></p>
                            <?php } ?>
                        </div>

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
</body>
</html>
