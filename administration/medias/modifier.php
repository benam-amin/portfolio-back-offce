<?php
$page_courante = "medias";
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Média - Back Office Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
<?php 
require_once('../header-admin.php'); // Récupération du header et de la connexion à la BDD
require_once('../assets/fonctionBdd/deplacerMedia.php');
require_once('../assets/fonctionBdd/getCategoriesName.php');

$error_msg = "";
$mediasPath = null;

// Récupérer l'ID du média à modifier
if (isset($_GET['id'])) {
    $mediaId = mysqli_real_escape_string($connexion_bdd, $_GET['id']);
    $requeteMedia = "SELECT * FROM medias WHERE id = ?";
    if ($stmt = $connexion_bdd->prepare($requeteMedia)) {
        $stmt->bind_param("i", $mediaId);
        $stmt->execute();
        $resultatMedia = $stmt->get_result();
        if ($media = $resultatMedia->fetch_assoc()) {
            $mediasPath = $media['lien'];
            $titre = $media['titre'];
            $label = $media['label'];
            $alt = $media['alt'];
            $categorieId = $media['idCategories'];
        } else {
            die("Média non trouvé.");
        }
        $stmt->close();
    } else {
        die("Erreur lors de la préparation de la requête.");
    }
} else {
    die("ID de média non spécifié.");
}

// Récupérer les catégories
$requeteCategories = "SELECT id, nom FROM categories";
$resultatCategories = mysqli_query($connexion_bdd, $requeteCategories);

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification que les champs obligatoires sont remplis
    if (!empty($_POST["titre"]) && !empty($_POST["label"]) && !empty($_POST["categorie"])) {
        // Récupération et nettoyage des données du formulaire
        $titre = mysqli_real_escape_string($connexion_bdd, $_POST["titre"]);
        $label = mysqli_real_escape_string($connexion_bdd, $_POST["label"]);
        $alt = mysqli_real_escape_string($connexion_bdd, $_POST["alt"]);
        $categorieId = mysqli_real_escape_string($connexion_bdd, $_POST["categorie"]);
        $categorieNom = getCategoriesName($connexion_bdd, $categorieId);

        // Préparation de la requête d'insertion sécurisée
        $requete = "UPDATE medias SET titre = ?, label = ?, idCategories = ?, alt = ? WHERE id = ?";
        if ($stmt = $connexion_bdd->prepare($requete)) {
            // Liaison des paramètres avec les valeurs
            $stmt->bind_param("ssssi", $titre, $label, $categorieId, $alt, $mediaId);

            // Exécution de la requête
            if ($stmt->execute()) {
                header("Location: ./");
                exit();
            } else {
                $error_msg = "Erreur lors de la modification du media.";
            }

            // Fermeture de la requête préparée
            $stmt->close();
        } else {
            $error_msg = "Erreur lors de la préparation de la requête.";
        }
    } else {
        // Message d'erreur si un champ est vide
        $error_msg = "Veuillez remplir tous les champs du formulaire.";
    }
}?>
    <!-- Section principale -->
    <section class="py-12 px-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Modifier Média</h1>

            <div class="w-full bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <form method="POST" action="" enctype="multipart/form-data">
                    <section class="grid gap-6">
                        <div>
                            <label for="titre" class="block text-lg font-medium text-gray-700">Titre</label>
                            <input type="text" placeholder="titre" name="titre" id="titre" value="<?php echo htmlspecialchars($titre); ?>" required
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div>
                            <label for="label" class="block text-lg font-medium text-gray-700">Label</label>
                            <input type="text" placeholder="label" name="label" id="label" value="<?php echo htmlspecialchars($label); ?>" required
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div>
                            <label for="alt" class="block text-lg font-medium text-gray-700">Alt</label>
                            <input type="text" placeholder="alt" name="alt" id="alt" value="<?php echo htmlspecialchars($alt); ?>"
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div>
                            <label for="categories" class="block text-lg font-medium text-gray-700">Liste des catégories</label>
                            <select name="categorie" id="categories">
                            <?php
                                while ($entite = mysqli_fetch_assoc($resultatCategories)) {
                                    ?>
                                    <option value="<?php echo $entite['id'];?>" <?php if ($entite['id'] == $categorieId) echo "selected"; ?>><?php echo $entite['nom']?></option>
                                <?php }
                            ?>
                            </select>
                        </div>
                        <!-- Aperçu du média -->
                        <div class="text-center mb-6">
                            <p class="text-lg font-semibold mb-2">Aperçu du média :</p>
                            <?php
                                // Vérifiez si le chemin de l'image et l'alt sont définis
                                if (!empty($mediasPath)) {
                                    echo "<img src='../../" . htmlspecialchars($mediasPath) . "' class='max-w-full h-48 mx-auto rounded shadow-md' alt='" . htmlspecialchars($alt) . "'>";
                                } else {
                                    echo "<p class='text-red-500'>Aucun média disponible pour l'aperçu.</p>";
                                }
                            ?>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="rounded-md bg-blue-500 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-blue-700">Modifier</button>
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
    </section>

    <!-- Footer -->
    <?php require_once('../footer-admin.php'); ?>
    <script src="../assets/dragDrop.js"></script>
</body>
</html>
