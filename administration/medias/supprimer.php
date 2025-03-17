<?php 
$page_courante = "medias";
require_once('../header-admin.php'); // Récupération du header
require_once('../assets/fonctionBdd/delete.php'); // Fonction pour valider la suppression

$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Vérifie si l'ID est défini, sinon le définit à 0
$formulaire_soumis = !empty($_POST);

if ($id > 0) { // On ne fait ceci que si l'ID est valide
    $resultat_affiche = genererRequeteEtResultat("medias", $id, $connexion_bdd);
    $entite = mysqli_fetch_assoc($resultat_affiche);

    if ($formulaire_soumis && $entite) { // Vérifie si l'entrée existe bien
        $chemin_fichier = "../" . $entite["lien"]; // Chemin du fichier à supprimer

        // Suppression de l'entrée dans la base de données
        deleteFromTable($connexion_bdd, 'medias', $id);

        // Suppression du fichier du serveur
        if (file_exists($chemin_fichier)) {
            unlink($chemin_fichier);
        }

        $success = messageConfirmationSuppression();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression - Média</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
<main class="mx-auto max-w-3xl py-12 rounded-lg">
    <?php if ($entite) { ?>
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">
            Voulez-vous vraiment supprimer <span class="text-red-600"><?= strtoupper($entite["titre"]); ?></span> ?
        </h1>
        
        <div class="bg-gray-50 p-6 rounded-md shadow-md">
            <?php 
                echo !empty($success) ? $success : '' ;
            ?>
            <table class="w-full border-collapse mb-6">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-6 py-3 border">ID</th>
                        <th class="px-6 py-3 border">Titre</th>
                        <th class="px-6 py-3 border">Catégorie</th>
                        <th class="px-6 py-3 border">Label</th>
                        <th class="px-6 py-3 border">Alt</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b text-center">
                        <td class="px-6 py-3 text-xl"><?= htmlspecialchars($entite["id"]) ?></td>
                        <td class="px-6 py-3 text-xl"><?= htmlspecialchars($entite["titre"]) ?></td>
                        <td class="px-6 py-3 text-xl"><?= htmlspecialchars($entite["idCategories"]) ?></td>
                        <td class="px-6 py-3 text-xl"><?= htmlspecialchars($entite["label"]) ?></td>
                        <td class="px-6 py-3 text-xl"><?= htmlspecialchars($entite["alt"]) ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Aperçu du média -->
            <div class="text-center mb-6">
                <p class="text-lg font-semibold mb-2">Aperçu du média :</p>
                <?php 
                    echo "<img src='../" . htmlspecialchars($entite["lien"]) . "' class='max-w-full h-48 mx-auto rounded shadow-md' alt='" . htmlspecialchars($entite["alt"]) . "'>";
                ?>
            </div>

            <!-- Formulaire de suppression -->
            <form method="POST" class="flex justify-between">
                <a href="./" class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Retour</a>
                <button type="submit" name="Supprimer" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Supprimer
                </button>
            </form>
        </div>
    <?php } else { ?>
        <p class="text-center text-red-600 font-bold">L'élément n'existe pas.</p>
    <?php } ?>
</main>
<?php require_once('../footer-admin.php'); // Récupération du footer ?>
</body>
</html>
