<?php
        //Si la session n'est pas démarrée, on la démarre
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
        if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
            // Enregistre l'URL actuelle dans une variable de session
            $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
            // Redirige vers la page de connexion
            header("Location: ../login.php");
            exit();
        }
?>