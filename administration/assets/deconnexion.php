<?php 
    function deconnexion() {
        session_destroy();
        // Redirige vers la page de connexion après la déconnexion
        header("Location: ../login.php");
        
        exit();
    }
?>