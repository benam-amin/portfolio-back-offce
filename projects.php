<!DOCTYPE HTML>
<html>
	<head>
		<title>Mes Projets</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/modale.css">
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	</head>
	<body class="is-preload">

		<?php 
			require_once('header.php');
			require_once('administration/assets/fonctionBdd/filtre.php');
			
			$colonnesBDD = [
				'projects.id', 
				'projects.titre', 
				'projects.lienMedia',
				'projects.description',
				'projects.visibilite',
				'categories.nom AS categorie',
				'GROUP_CONCAT(COALESCE(collaborators.nom, "Aucun collaborateur") SEPARATOR ", ") AS collaborateurs'
			];			

			$categorie_filtre = isset($_GET['categorie']) ? mysqli_real_escape_string($connexion_bdd, $_GET['categorie']) : '';

			$resultat_categories = fetchFilteredData($connexion_bdd, 'categories', ["id", "nom"]);

			$resultat = fetchFilteredData($connexion_bdd, 'projects', $colonnesBDD, 'categories.id', $categorie_filtre);
		?>

		<!-- Main -->
		<div id="main" class="wrapper style1">
			<section id="four" class="wrapper style1 special fade-up">
				<div class="container">
					<header>
						<h2>Mes projets !</h2>
						<p>Retrouvez l'ensemble de mes réalisations (ou presque...)</p>
					</header>

					<!-- Filtre catégories -->
					<div class="categorie-toggle-wrapper">
						<button id="toggleCategories" class="button fit">Catégories</button>
						<div id="categoriesMenu" class="categories-menu">
							<ul class="alt">
								<li><a href="?categorie=">Toutes</a></li>
								<?php while ($cat = $resultat_categories->fetch_assoc()) { 
									if ($cat['nom'] === "collaborateur") continue; ?>
									<li><a href="?categorie=<?= $cat['id']; ?>">
										<?= htmlspecialchars($cat['nom']); ?>
									</a></li>
								<?php } ?>
							</ul>
						</div>
					</div>

					<!-- Liste des projets -->
					<div class="row gtr-150">
						<div class="col-12">
							<div class="box alt">
								<div class="row gtr-uniform">
									<?php 
										if ($resultat->num_rows > 0) {
											while ($entite = $resultat->fetch_assoc()) {
												if ($entite["visibilite"] == 1) {
													$image = !empty($entite['lienMedia']) ?  $entite['lienMedia'] : 'images/banner.jpg';
													?>
													<section class="col-4 col-6-medium col-12-xsmall project-box" onclick="openModal(<?= $entite['id']; ?>)">
														<span class="image fit"><img src="<?= $image ?>" alt="<?= htmlspecialchars($entite['titre']); ?>"></span>
														<h3><?= ucfirst($entite['titre']); ?></h3>
														<p><?= substr(strip_tags($entite['description']), 0, 100); ?>...</p>
														<p><strong>Catégorie :</strong> <?= htmlspecialchars($entite['categorie']); ?></p>
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
					</div> <!-- Fin row -->
				</div> <!-- Fin container -->
			</section>
		</div> <!-- Fin #main -->

		<!-- Modale -->
		<div id="customModal" class="modal">
			<div class="modal-content">
				<span class="close" onclick="closeModal()">&times;</span>
				<div id="modal-body">Chargement...</div>
			</div>
		</div>

		<!-- Footer -->
		<?php require_once('footer.php'); ?>

		<!-- Scripts -->
		<?php require_once('assets/php/scripts.php'); ?>
		<script src="assets/js/openModal.js"></script>
		<script src="assets/js/hideCategories.js"></script>
	</body>
</html>
