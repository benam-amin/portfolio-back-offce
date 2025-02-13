<?php $page_courante = "navigation"; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création - Navigation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php 
        require_once('../header-admin.php'); //récupération du header

        $formulaire_soumis = (!empty($_POST)); // Vérification de la soumission du formulaire
        $error_msg = ""; // Variable pour stocker les messages d'erreur

        if ($formulaire_soumis) {
            // Vérification que tous les champs sont remplis
            if (!empty($_POST["ancre"]) && !empty($_POST["contenu"])) {
                $ancre = htmlentities($_POST["ancre"]); 
                $contenu = htmlentities($_POST["contenu"]);
                $visibilite = (int) $_POST["visibilite"]; // Visibilité en entier (0 ou 1) 

                $requete = "INSERT INTO navigation (ancre, contenu, visibilite) VALUES ('$ancre', '$contenu', '$visibilite');";
                $resultat= mysqli_query($connexion_bdd, $requete); // Exécution de la requête

                // Redirection après mise à jour
                header("Location: ./");
                exit();
            } else {
                // Message d'erreur si un champ est vide
                $error_msg = "Veuillez remplir tous les champs du formulaire.";
            }
        }
        ?>
    <main class="mx-6 md:mx-20">
            <div class="mx-auto max-w-lg py-6">
                <h1 class="text-3xl font-bold text-center mb-8">Création d'un nouveau lien de navigation</h1>
                
                <div class="w-full bg-white rounded-lg shadow-md p-6 border border-gray-200">
                    <form method="POST" action="">
                        <section class="grid gap-6">
                            <div>
                                <label for="ancre" class="block text-lg font-medium text-gray-700">Lien de navigation</label>
                                <input type="text" placeholder="Twitter, Facebook, linkedin" name="ancre" id="ancre" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <div>
                                <label for="contenu" class="block text-lg font-medium text-gray-700">Contenu affiché dans la balise &lt;a&gt;</label>
                                <input type="text" placeholder="contenu du réseau" name="contenu" id="contenu" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <!-- Section des boutons radio pour la visibilité -->
                            <div>
                                <label class="block text-lg font-medium text-gray-700">Visibilité</label>
                                <div class="mt-2 flex gap-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="visibilite" value="1" class="form-radio text-blue-600" checked>
                                        <span class="ml-2">Visible</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="visibilite" value="0" class="form-radio text-blue-600">
                                        <span class="ml-2">Masqué</span>
                                    </label>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <button type="submit" class="rounded-md bg-blue-500 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-blue-700">Créer</button>
                                <a href="./" class="rounded-md bg-gray-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-gray-700">Retour</a>
                            </div>
                        </section>
                    </form>
                </div>
                
                <?php if (!empty($error_msg)) {  //si il y a un message d'erreur, on l'affiche?>
                    <section class="mt-4 text-red-500 text-lg font-semibold" role="alert">
                        <p><?php echo $error_msg; ?></p>
                    </section>
                <?php } ?>
            </div>
    </main>
    <?php 
        require_once('../footer-admin.php'); //récupération du header ?>
</body>
</html>
