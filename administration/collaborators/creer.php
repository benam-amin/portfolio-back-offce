<?php 
$page_courante = "collaborators"; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création - Collaborateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900" data-page-courante="<?php echo $page_courante ?>">
    <?php
        require_once('../header-admin.php');
        require_once('../assets/fonctionBdd/addMedia.php');
        require_once('../assets/fonctionBdd/addCollaborator.php');

        $error_msg_medias = "";
        $mediasPath = null;
        $error_msg = "";

        // 🔹 Récupération de la catégorie "collaborateur"
        $requeteCategorie = "SELECT id, nom FROM categories WHERE nom = 'collaborateur';";
        $resultatCategories = mysqli_query($connexion_bdd, $requeteCategorie);
        $categorie_item = mysqli_fetch_assoc($resultatCategories);

        // 🔹 Récupération des médias existants de la catégorie "collaborateur"
        $mediasExistants = [];
        $queryMedias = "SELECT id, titre, lien FROM medias WHERE idCategories = 12 ORDER BY id DESC";
        $resultMedias = mysqli_query($connexion_bdd, $queryMedias);
        while ($media = mysqli_fetch_assoc($resultMedias)) {
            $mediasExistants[] = $media;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!isset($connexion_bdd)) {
                die("Erreur : Connexion à la base de données non établie.");
            }

            if (!empty($_POST["nom"]) && !empty($_POST["prenom"])) {
                $nom = htmlentities($_POST["nom"]);
                $prenom = htmlentities($_POST["prenom"]);
                $contactListe = isset($_POST["contactListe"]) ? implode(',', array_map('trim', explode(',', $_POST["contactListe"]))) : '';
                $liensContact = isset($_POST["liensContact"]) ? implode(',', array_map('trim', explode(',', $_POST["liensContact"]))) : '';

                // 🔹 Tentative d’upload d’une image (prioritaire)
                if (!empty($_FILES["medias"]["name"])) {
                    $uploadResult = uploadImage("medias", "collaborateur");
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

                $categorieId = 12;
                $titre = "Avatar de {$nom} {$prenom}";

                if ($mediasPath !== null) {
                    // 🔹 Si nouveau média : insertion dans la table `medias`
                    $titre = mysqli_real_escape_string($connexion_bdd, $titre);
                    $mediasPath = mysqli_real_escape_string($connexion_bdd, $mediasPath);
                    if (
                        (empty($_POST["mediaExistant"]) && addMedia($connexion_bdd, $titre, $titre, $categorieId, $mediasPath, $titre) == "success") || 
                        !empty($_POST["mediaExistant"])
                    ) {
                        // 🔹 Ajout du collaborateur avec le chemin de l’image
                        if (addCollaborator($connexion_bdd, $nom, $prenom, $contactListe, $liensContact, $mediasPath) == "success") {
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
            <h1 class="text-3xl font-bold text-center mb-8">Ajout d'un nouveau collaborateur</h1>
            
            <div class="w-full bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <form method="POST" action="" enctype="multipart/form-data">
                    <section class="grid gap-6">
                        <div>
                            <label for="nom" class="block text-lg font-medium text-gray-700">Nom</label>
                            <input type="text" placeholder="Nom" name="nom" id="nom" required
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div>
                            <label for="prenom" class="block text-lg font-medium text-gray-700">Prénom</label>
                            <input type="text" placeholder="Prénom" name="prenom" id="prenom" required
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div>
                            <label for="contactListe" class="block text-lg font-medium text-gray-700">Liste des réseaux du collaborateur</label>
                            <input type="text" placeholder="twitter,github... (séparés d'une virgule sans espace)" name="contactListe" id="contactListe"
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div class="hidden">
                            <label for="categorie" class="block text-lg font-medium text-gray-700">Catégorie</label>
                            <select name="categorie" id="categorie" class="w-full px-4 py-2 border rounded-md">
                                <?php
                                    echo "<option value='" . $categorie_item['id'] . "' " . 'selected'  . ">" . htmlspecialchars($categorie_item['nom']) . "</option>";
                                ?>
                            </select>
                        </div>
                        
                        <div>
                            <label for="liensContact" class="block text-lg font-medium text-gray-700">Liens des réseaux</label>
                            <input type="text" placeholder="liens des réseaux (séparés d'une virgule sans espace)" name="liensContact" id="liensContact"
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        
                        <?php require_once ('../assets/gestionImage.php'); ?>
                        
                        <div class="flex gap-4">
                            <button type="submit" class="rounded-md bg-blue-500 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-blue-700">Créer</button>
                            <a href="./" class="rounded-md bg-gray-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-gray-700">Retour</a>
                        </div>
                    </section>
                </form>
            </div>
            
            <?php if (!empty($error_msg)) {
                //s'il y a un message d'erreur défini on l'affiche ?>
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
