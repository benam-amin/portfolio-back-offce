<?php $page_courante = "collaborators"; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification - Réseaux Sociaux</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php 
        require_once('../header-admin.php'); //récupération du header

        $formulaire_soumis = (!empty($_POST)); //variable stockant un bool => permet de savoir si le formulaire est soumis
        $entree_mise_a_jour = array_key_exists('id', $_GET); // permet de voir s'il y a un id qui est passé dans l'url  
        $entite = null; //initialise la variable à null pour éviter les erreurs
        $error_msg = ""; //initialise le msg dans une chaîne vide dans le cas où il n'y a pas d'erreur

        if ($entree_mise_a_jour) { //s'il y a bien un id à modifier
            $id = mysqli_real_escape_string($connexion_bdd, $_GET["id"]); //se protège des injections sql
            $resultat_affiche = genererRequeteEtResultat("reseaux", $id, $connexion_bdd); //récupère la requête est le résultat d'affichage
            $entite = mysqli_fetch_assoc($resultat_affiche); //stock le retour dans la variable entité
        }

        if ($formulaire_soumis) { 
            if (!empty($_POST["nom"]) && !empty($_POST["lien"]) && !empty($_POST["classIcon"]) && isset($_POST["visibilite"])) { //vérification de l'entrée des input du formulaire
                $id = $_GET["id"]; //automatique, n'est pas supposé changer
                //on récupère les entrées du formulaire dans des variables
                $nom = htmlentities($_POST["nom"]);
                $lien = htmlentities($_POST["lien"]);
                $classIcon = htmlentities($_POST["classIcon"]);
                $visibilite = (int) $_POST["visibilite"]; // Convertir en entier pour éviter toute injection
                
                $requete_modif = "UPDATE reseaux SET nom = '$nom', lien = '$lien', classIcon = '$classIcon', visibilite = $visibilite WHERE id = $id;"; //requête de modification
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
                                <label for="nom" class="block text-lg font-medium text-gray-700">Nom du réseau</label>
                                <input type="text" value="<?= htmlspecialchars($entite['nom']); ?>" name="nom" id="nom" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <div>
                                <label for="lien" class="block text-lg font-medium text-gray-700">Lien du réseau</label>
                                <input type="text" value="<?= htmlspecialchars($entite['lien']) ; ?>" name="lien" id="lien" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <div>
                                <label for="classIcon" class="block text-lg font-medium text-gray-700">Classe de l'icône</label>
                                <input type="text" value="<?= htmlspecialchars($entite['classIcon']); ?>" name="classIcon" id="classIcon" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            
                            <!-- Ajout des boutons radio pour la visibilité -->
                            <div>
                                <label class="block text-lg font-medium text-gray-700">Visibilité</label>
                                <div class="mt-2 flex gap-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="visibilite" value="1" <?php echo ($entite['visibilite'] == 1) ? 'checked' : ''; ?> class="form-radio text-blue-600">
                                        <span class="ml-2">Visible</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="visibilite" value="0" <?php echo ($entite['visibilite'] == 0) ? 'checked' : ''; ?> class="form-radio text-blue-600">
                                        <span class="ml-2">Masqué</span>
                                    </label>
                                </div>
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
