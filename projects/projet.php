<!DOCTYPE HTML>
<html>
	<head>
		<title>Projet</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/modale.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>

		<!-- Exemple d'améliorations avec Tailwind CSS (si utilisé) -->
		<!-- Ajouter les icônes Font Awesome pour les outils -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	</head>

	<body class="is-preload">

		<?php 
			$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

			require_once('../assets/php/connexion_bdd.php');
			require_once('../assets/php/transformYtbLink.php');
			require_once('../administration/assets/fonctionBdd/filtre.php');

			$colonnesBDD = [
				'projects.id', 
				'projects.titre', 
				'projects.chapo', 
				'projects.date', 
				'projects.lienMedia',
				'projects.lienProjet',
				'projects.video',
				'projects.description',
				'projects.visibilite',
				'projects.outils',
				'categories.nom AS categorie',
				'GROUP_CONCAT(COALESCE(collaborators.nom, "Aucun collaborateur") SEPARATOR ", ") AS collaborateurs',
				'GROUP_CONCAT(COALESCE(collaborators.prenom, "") SEPARATOR ", ") AS prenoms',
				'GROUP_CONCAT(COALESCE(collaborators.lienMedia , "") SEPARATOR ", ") AS avatars',
				'GROUP_CONCAT(COALESCE(collaborators.contactListe, "") SEPARATOR ", ") AS reseaux',
				'GROUP_CONCAT(COALESCE(collaborators.liensContact, "") SEPARATOR ", ") AS reseauxLien'
			];

			$projetData = fetchFilteredData($connexion_bdd, 'projects', $colonnesBDD, 'projects.id', $id);
			$projet = $projetData->fetch_assoc();

			$lienEmbed = !empty($projet['video']) ? transformerLienYoutube($projet['video']) : '';
			$lienMedia = !empty($projet['lienMedia']) ? htmlspecialchars($projet['lienMedia']) : '';
		?>
			<div class="container">

				<!-- Section du projet -->
				<section id="three" class=" style1 top">
					<!-- Affichage de l'image -->
					<span class="fit main bottom">
					</span>

					<div class="content">
						<header class="text-center">
							<h2><?= strtoupper(htmlspecialchars($projet['titre'])) ?></h2>
							<p><?= nl2br(htmlspecialchars($projet['chapo'])) ?>
								<?php if (!empty($projet['date'])): ?>
									<div class="col-8 col-12-small col-10-medium">
										<p class="align-right"><?php echo $projet['date'];?></p>
									</div>
								<?php endif; ?>
							</p>
						</header>
						<?php if (!empty($projet['lienMedia'])): ?>
							<figure class="figure">
								<img src="<?= str_replace('%20', ' ', urldecode($projet['lienMedia'])) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>"/>
							</figure>
							<?php endif; ?>
						<!-- Affichage des outils sous forme de liste -->
						<?php if (!empty($projet['outils'])): ?>
							<div class="icon tools-container list-disc pl-5 text-xl font-bold space-y-2 my-4 bigText">
								<?php 
									$outils = explode(',', $projet['outils']);
									foreach ($outils as $outil): 
										$outil = trim($outil); // Retirer les espaces
								?>	
										<i class="bigText fa-brands fa-<?php echo $outil;?> "></i>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						

						<!-- Description du projet -->
						<p class="text-lg mb-4"><?= nl2br(htmlspecialchars($projet['description'])) ?></p>

						<!-- Lien vers le projet -->
						<?php if (!empty($projet['lienProjet'])): ?>
							<ul class="actions">
								<li>
									<a href="<?= htmlspecialchars($projet['lienProjet']) ?>" target="_blank" class="button bg-blue-500 text-white hover:bg-blue-600 px-6 py-3 rounded-lg">Voir Le projet</a>
								</li>
							</ul>
						<?php endif; ?>
					</div>

					<!-- Affichage de la vidéo YouTube -->
					<?php if (!empty($lienEmbed)): ?>
						<figure class="mb-6 iframeContainer">
							<iframe src="<?= htmlspecialchars($lienEmbed) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</figure>
					<?php endif; ?>
				</section>
			</div>

		<!-- Scripts -->
		<?php require_once('../assets/php/scripts.php'); ?>
	</body>
</html>
