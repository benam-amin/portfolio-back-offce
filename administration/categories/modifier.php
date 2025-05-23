<?php $page_courante = "categories"; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification - Catégories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php 
        require_once('../header-admin.php'); //récupération du header

        require_once('../assets/fonctionBdd/editInit.php'); //récupère les vérifications, les requêtes et l'id de l'élément à modifier

        if ($formulaire_soumis) { 
            if (!empty($_POST["nom"]) && !empty($_POST["description"])) { //vérification de l'entrée des input du formulaire
                $id = $_GET["id"]; //automatique, n'est pas supposé changer
                //on récupère les entrées du formulaire dans des variables
                $nom = htmlentities($_POST["nom"]);
                $description = htmlentities($_POST["description"]);
                
                $requete_modif = "UPDATE categories SET nom = '$nom', description = '$description' WHERE id = $id;"; //requête de modification
                $resultat_modif = mysqli_query($connexion_bdd, $requete_modif); //résultat
                //si tout se passe bien, on retourne à la page précédente
                header("Location: ./"); 
                exit();
            } else {
                $error_msg = "Veuillez remplir tous les champs du formulaire."; //on affiche une erreur si certains champs sont vides
            }
        }
    ?>

    <main class="mx-6 md:mx-20">
        <?php if ($entite) { //si il y a bel et bien un élément à modifier ?>
            <div class="mx-auto max-w-lg py-12">
                <h1 class="text-3xl font-bold text-center mb-8">Modification de <?php echo strtoupper($entite['nom']); ?></h1>
                
                <div class="w-full bg-white rounded-lg shadow-md p-6 border border-gray-200">
                    <form method="POST" action="">
                        <section class="grid gap-6">
                            <div>
                                <label for="nom" class="block text-lg font-medium text-gray-700">Nom de la catégorie</label>
                                <input type="text" value="<?php echo $entite['nom']; ?>" name="nom" id="nom" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <div>
                                <label for="description" class="block text-lg font-medium text-gray-700">Description de la catégorie</label>
                                <input type="textarea" value="<?php echo $entite['description']; ?>" name="description" id="description" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div> 
                            <div class="flex gap-4">
                                <button type="submit" class="rounded-md py-2 bg-blue-500 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-blue-700">Modifier</button>
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
    <?php 
        } 
        require_once('../footer-admin.php'); //récupération du header
    ?>
</body>
</html>
