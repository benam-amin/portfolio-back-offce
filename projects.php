<!DOCTYPE HTML>
<html>
	<head>
		<title>Mes Projets</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/modale.css">
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
	<?php 
		require_once('header.php');
		// Récupération de fetchFilteredData
		require_once('administration/assets/fonctionBdd/filtre.php');
		$colonnesBDD = [
			'projects.id', 
			'projects.titre', 
			'projects.lienMedia',
			'projects.description',
			'projects.visibilite',
			'categories.nom AS categorie',
			'GROUP_CONCAT(COALESCE(collaborators.nom, "Aucun collaborateur") SEPARATOR ", ") AS collaborateurs' // Agrégation des collaborateurs
		];			

		// Récupérer les paramètres de filtrage
		$categorie_filtre = isset($_GET['categorie']) ? mysqli_real_escape_string($connexion_bdd, $_GET['categorie']) : '';

		// Requête SQL pour récupérer les catégories disponibles
		$resultat_categories = fetchFilteredData($connexion_bdd, 'categories', ["id", "nom"]);

		// Récupération des projets disponibles dans la base de données
		$resultat = fetchFilteredData($connexion_bdd, 'projects', $colonnesBDD, 'categories.id', $categorie_filtre);
	?>
			<!-- Main -->
			<div id="main" class="wrapper style1">
				<section id="four" class="wrapper style1 special fade-up">
					<div class="container">
						<header class="major">
							<h2>Mes projets !</h2>
							<p>Retrouvez l'ensemble de mes réalisations (ou presque...)</p>
						</header>
						<div class="categorie-toggle-wrapper">
							<button id="toggleCategories" class="button fit">Catégories</button>
							<div id="categoriesMenu" class="categories-menu">
								<ul class="alt">
									<li><a href="?categorie=">Toutes</a></li>
									<?php while ($cat = $resultat_categories->fetch_assoc()) { 
										if ($cat['nom'] == "collaborateur") continue; ?>
										<li><a href="?categorie=<?php echo $cat['id']; ?>">
											<?php echo htmlspecialchars($cat['nom']); ?>
										</a></li>
									<?php } ?>
								</ul>
							</div>
						</div>
						<div class="row gtr-150">
							<!-- Liste des projets -->
							<div class="col-9 col-12-medium">
								<div class="box alt">
									<div class="row gtr-uniform">
										<?php 
											if ($resultat->num_rows > 0) {
												while ($entite = $resultat->fetch_assoc()) {
													if ($entite["visibilite"] == 1) {
														$image = !empty($entite['lienMedia']) ? 'administration/' . $entite['lienMedia'] : 'images/banner.jpg';
														?>
														<section class="col-4 col-6-medium col-12-xsmall project-box" onclick="openModal(<?php echo $entite['id']; ?>)">
															<span class="image fit"><img src="<?php echo $image ?>" alt="<?php echo strtoupper($projet['titre'])  ?>"></span>
															<h3><?php echo ucfirst($entite['titre']); ?></h3>
															<p><?php echo substr(strip_tags($entite['description']), 0, 100); ?>...</p>
															<p><strong>Catégorie:</strong> <?php echo $entite['categorie']; ?></p>
														</section>
														<?php 
													}
												}
											} else {
												echo "<p>Aucun projet trouvé.</p>";
											} 
										?>
									</div>
								</div>
							</div>

							<!-- Filtre à droite -->
						</div> <!-- fin du row -->
					</div>
				</section>
			<div id="customModal" class="modal">
				<div class="modal-content">
						<span class="close" onclick="closeModal()">&times;</span>
						<div id="modal-body">Chargement...</div>
					</div>
			</div>
			<!-- Footer -->
			<?php require_once('footer.php'); ?>

		</div>

		<!-- Scripts -->
		<?php require_once('assets/php/scripts.php'); ?>
		<script src="assets/js/hideCategories.js"></script>
		<script src="assets/js/openModal.js"></script>
	</body>
</html>
