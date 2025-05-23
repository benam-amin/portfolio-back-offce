<?php $page_courante = "outils"; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création - Réseaux Sociaux</title>
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
            if (!empty($_POST["nom"]) && !empty($_POST["icon"])) {
                $nom = htmlentities($_POST["nom"]); 
                $icon = htmlentities($_POST["icon"]);  
                $visibilite = (int) $_POST["visibilite"]; // Visibilité en entier (0 ou 1)

                $requete = "INSERT INTO outils (nom, icon, visibilite) VALUES ('$nom', '$icon', '$visibilite');";
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
            <div class="mx-auto max-w-lg py-12">
                <h1 class="text-3xl font-bold text-center mb-8">Ajouter un nouvel outil !</h1>
                
                <div class="w-full bg-white rounded-lg shadow-md p-6 border border-gray-200">
                    <form method="POST" action="">
                        <section class="grid gap-6">
                            <div>
                                <label for="nom" class="block text-lg font-medium text-gray-700">Nom de l'outil</label>
                                <input type="text" placeholder="Twitter, Facebook, linkedin" name="nom" id="nom" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <div>
                                <label for="icon" class="block text-lg font-medium text-gray-700">Icône Font-Awesome</label>
                                <input type="text" placeholder="Icône Font-Awesome" name="icon" id="icon" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <!-- Section des boutons radio pour la visibilité -->
                            <?php visibiliteInput();?>
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
