<footer id="footer" class="bg-gray-900 text-white text-center py-4">
    <ul class="flex flex-col md:flex-row justify-center items-center space-y-2 md:space-y-0 md:space-x-6 text-sm">
        <li>&copy; Amîn BENAMAOUCHE. All rights reserved.</li>
        <li>Design: Moi mon ptit bébou</li>
        <li><a href="../../index.php" class="text-blue-400 hover:underline">Retour au site</a></li>
    </ul>
    <? mysqli_close($connexion_bdd); // Fermeture de la connexion ?>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../assets/fonctionBdd/delete.js"></script>
<!-- tentative échouée d'utiliser Trumbowyg -->
<!-- <?php if(($page_courante == "projects") || ($page_courante == "contenu")) { ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
<?php } ?> -->
