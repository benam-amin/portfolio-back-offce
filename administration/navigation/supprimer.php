<?php $page_courante = "navigation";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression - Navigation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php require_once('../header-admin.php'); //récupération du header
    require_once('../assets/fonctionBdd/delete.php'); //fonction pour valider la suppression
    
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0; //on vérifie si l'id est défini sinon on le défini à 0
    $formulaire_soumis = !empty($_POST);
    
    if ($id > 0) { //on ne fait ceci que si l'id est défini
        $resultat_affiche = genererRequeteEtResultat("navigation", $id, $connexion_bdd);
        $entite = mysqli_fetch_assoc($resultat_affiche);
    
        if ($formulaire_soumis && $entite) { //on vérifie si le contenu par rapport à l'id n'est pas vide
            $requete_suppr = "DELETE FROM `navigation` WHERE id = $id";
            mysqli_query($connexion_bdd, $requete_suppr); //suppression de l'élément de la table réseau
            echo "<div class='text-center text-green-600 font-bold text-xl py-4'>L'élément a bien été supprimé ! <a href='./' class='text-red-500'>Retour</a></div>";
        }
    }?>
<main class="mx-auto max-w-3xl p-8 bg-white shadow-lg rounded-lg">
    <?php if ($entite) { ?>
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">Voulez-vous vraiment supprimer <?= strtoupper($entite["contenu"]); ?> ?</h1>
        <div class="bg-gray-50 p-6 rounded-md shadow-md">
            <table class="w-full border-collapse ">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-6 py-3 border">Ancre</th>
                        <th class="px-6 py-3 border">Contenu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b text-center">
                        <td class="px-6 py-3 text-xl"> <?= htmlspecialchars($entite["ancre"]) ?> </td>
                        <td class="px-6 py-3 text-xl"> <?= htmlspecialchars($entite["contenu"]) ?> </td>
                    </tr>
                </tbody>
            </table>
            <form method="POST" class="mt-6 flex justify-between">
                <a href="./" class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Retour</a>
                <button type="submit" name="Supprimer" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
            </form>
        </div>
    <?php } else { ?>
        <p class="text-center text-red-600 font-bold">L'élément n'existe pas.</p>
    <?php } ?>
</main>
<?php require_once('../footer-admin.php'); //récupération du header ?>
</body>
</html>
