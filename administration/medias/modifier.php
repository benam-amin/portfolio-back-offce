<?php 
$page_courante = "medias";
require_once('../header-admin.php'); // Récupération du header et connexion BDD

$formulaire_soumis = (!empty($_POST)); // Vérifie si le formulaire est soumis
$entree_mise_a_jour = array_key_exists('id', $_GET); // Vérifie si un ID est passé dans l'URL
$entite = null; // Initialisation pour éviter les erreurs
$error_msg = ""; // Message d'erreur par défaut

if ($entree_mise_a_jour) {
    $id = mysqli_real_escape_string($connexion_bdd, $_GET["id"]);
    $requete = "SELECT * FROM medias WHERE id = $id";
    $resultat_affiche = mysqli_query($connexion_bdd, $requete);
    
    if ($resultat_affiche && mysqli_num_rows($resultat_affiche) > 0) {
        $entite = mysqli_fetch_assoc($resultat_affiche);
    } else {
        die("Erreur : Média introuvable.");
    }
}

// Traitement du formulaire
if ($formulaire_soumis) { 
    if (!empty($_POST["titre"]) && !empty($_POST["label"]) && !empty($_POST["alt"]) && !empty($_POST["idCategories"])) {
        $titre = htmlentities($_POST["titre"]);
        $label = htmlentities($_POST["label"]);
        $alt = htmlentities($_POST["alt"]);
        $idCategories = (int) $_POST["idCategories"];

        $requete_modif = "UPDATE medias SET titre = '$titre', label = '$label', alt = '$alt', idCategories = $idCategories WHERE id = $id";
        $resultat_modif = mysqli_query($connexion_bdd, $requete_modif);

        if ($resultat_modif) {
            header("Location: ./"); 
            exit();
        } else {
            $error_msg = "Erreur lors de la mise à jour.";
        }
    } else {
        $error_msg = "Veuillez remplir tous les champs du formulaire.";
    }
}

// Récupération des catégories pour le menu déroulant
$requete_categories = "SELECT id, nom FROM categories";
$resultat_categories = mysqli_query($connexion_bdd, $requete_categories);
$categories = mysqli_fetch_all($resultat_categories, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification - Média</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <main class="mx-6 md:mx-20">
        <?php if ($entite) { ?>
            <div class="mx-auto max-w-lg py-12">
                <h1 class="text-3xl font-bold text-center mb-8">Modification de "<?php echo strtoupper($entite['titre']); ?>"</h1>
                
                <div class="w-full bg-white rounded-lg shadow-md p-6 border border-gray-200">
                    <form method="POST" action="">
                        <section class="grid gap-6">
                            <div>
                                <label for="titre" class="block text-lg font-medium text-gray-700">Titre</label>
                                <input type="text" value="<?php echo $entite['titre']; ?>" name="titre" id="titre" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <div>
                                <label for="label" class="block text-lg font-medium text-gray-700">Label</label>
                                <input type="text" value="<?php echo $entite['label']; ?>" name="label" id="label" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <div>
                                <label for="alt" class="block text-lg font-medium text-gray-700">Texte alternatif (alt)</label>
                                <input type="text" value="<?php echo $entite['alt']; ?>" name="alt" id="alt" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <div>
                                <label for="idCategories" class="block text-lg font-medium text-gray-700">Catégorie</label>
                                <select name="idCategories" id="idCategories" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                                    <?php foreach ($categories as $categorie) { ?>
                                        <option value="<?php echo $categorie['id']; ?>" <?php echo ($categorie['id'] == $entite['idCategories']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($categorie['nom']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="text-center mb-6">
                                <p class="text-lg font-semibold mb-2">Aperçu du média :</p>
                                <?php 
                                    echo "<img src='../" . htmlspecialchars($entite["lien"]) . "' class='max-w-full h-48 mx-auto rounded shadow-md' alt='" . htmlspecialchars($entite["alt"]) . "'>";
                                ?>
                            </div>
                            <div class="flex gap-4">
                                <button type="submit" class="rounded-md py-2 bg-blue-500 px-4 text-lg font-medium text-white shadow-sm hover:bg-blue-700">
                                    Modifier
                                </button>
                                <a href="./" class="rounded-md bg-gray-600 px-4 py-2 text-lg font-medium text-white shadow-sm hover:bg-gray-700">
                                    Retour
                                </a>
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
        <?php } ?>
    </main>
    <?php require_once('../footer-admin.php'); ?>
</body>
</html>
