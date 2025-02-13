<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion au back-office</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="flex flex-col min-h-screen bg-gray-900 text-white">

<?php
session_start(); //reprend la session en cours
$formulaire_soumis = !empty($_POST); //vérifie que le formulaire a été soumis
$errMsg = ""; //initialisation d'un message d'erreur vide
require_once('../assets/php/connexion_bdd.php'); //connexion à la base de données
if ($formulaire_soumis) {
    

    if (!empty($_POST['login']) && !empty($_POST['mdp'])) { //test conditionnel pour vérifier que les champs sont bien remplis
        $login = mysqli_real_escape_string($connexion_bdd, $_POST['login']); //on récupère exactement l'entrée de l'utilisateur, real_espace_string permet de transformer la chaine pour éviter les erreurs
        $requete_login = "SELECT * FROM user WHERE login = '$login';"; //on cherche le login entré par l'input
        $resultat_login = mysqli_query($connexion_bdd, $requete_login); //on prend le résultat de la requête
        $user = mysqli_fetch_assoc($resultat_login); //on stock le tableau associatif retourné
        $pwd = $_POST['mdp'];

        if ($user && password_verify($pwd, $user['pwd'])) { //on test si user n'est pas vide et on compare les mots de passe entrés en paramètres avec password_verify, puisque les mdp sont cryptés
            $_SESSION['user'] = $login; 
            $_SESSION['connected'] = true; //on passe la valeur en true, pour éviter la redirection infinie vers cette page
            $_SESSION['admin'] = $user['admin'] == 1;

            $redirectTo = "projects/index.php"; //on redirige vers la gestion des projets
            header("Location: $redirectTo");
            exit(); //on s'arrête là
        } else {
            $errMsg = "Identifiant ou mot de passe incorrect."; //si le mdp ou le login n'est pas correct
        }
    } else {
        $errMsg = "Veuillez entrer tous les éléments du formulaire."; //si un des deux champ n'est pas rempli
    }
}
?>


<main class="flex-grow flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold text-center mb-6">Connexion</h1>

        <form method="POST" action="">
            <div class="mb-4">
                <label for="login" class="block text-lg font-medium">Identifiant</label>
                <input type="text" name="login" id="login" placeholder="Votre identifiant"
                    class="mt-1 w-full px-4 py-2 border border-gray-700 bg-gray-700 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-4">
                <label for="mdp" class="block text-lg font-medium">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" placeholder="••••••••"
                    class="mt-1 w-full px-4 py-2 border border-gray-700 bg-gray-700 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <?php if (!empty($errMsg)) : //si le message d'erreur n'est pas vide, on l'affiche?>
                <p class="text-red-400 text-center font-semibold mb-4"><?= htmlspecialchars($errMsg); ?></p>
            <?php endif; ?>

            <div class="flex flex-col space-y-4">
                <button type="submit"
                    class="w-full py-2 text-lg font-bold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700">
                    Connexion
                </button>
                <a href="../index.php"
                    class="w-full py-2 text-lg font-bold text-white bg-red-600 rounded-md text-center shadow-sm hover:bg-red-700">
                    Retourner sur le site
                </a>
            </div>
        </form>
    </div>
</main>

<?require_once "footer.php"; //récupération des footer?>

</body>
</html>
