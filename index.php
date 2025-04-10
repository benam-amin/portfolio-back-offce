<!DOCTYPE HTML>
<html>
	<head>
		<title>PORTFOLIO AMÎN BENAMAOUCHE - Développeur Web</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload landing">
		<div id="page-wrapper">
			<?php 
				// Inclusion du header de la page
				require_once('header.php'); 
			?>

			<!-- Banner Section -->
			<section id="banner">
				<?php 
					// Récupération des éléments de la section 'banner' depuis la base de données
					$banner = getSectionElements($connexion_bdd, "banner"); 
				?>
				<div class="content">
					<header>
						<!-- Titre et sous-titre de la section 'banner', avec une vérification si les valeurs sont nulles -->
						<h2><?php echo $banner['titre'] ?? ''; ?></h2>
						<p><?php echo $banner['sousTitre'] ?? ''; ?></p>
					</header>
					<span class="image">
						<!-- Affichage de l'image associée à la section 'banner' ou une image par défaut si elle n'est pas définie -->
						<img src="<?php echo $banner['lienMedia'] ?? 'assets/images/default-banner.jpg'; ?>" alt="<?php echo $banner['sousTitre'] ?? ''; ?>" />
					</span>
				</div>
				<!-- Lien vers la section suivante -->
				<a href="<?php echo $banner['lienBouton'] ?? ''; ?>" class="goto-next scrolly" title="En apprendre plus sur moi">Next</a>
			</section>

			<!-- About Section -->
			<section id="about" class="spotlight style2 right">
				<?php 
					// Récupération des éléments de la section 'about' depuis la base de données
					$about = getSectionElements($connexion_bdd, "about"); 
				?>
				<span class="image fit main"><img src="<?php echo $about['lienMedia'] ?? 'assets/images/default-about.jpg'; ?>" alt="<?php echo $about['sousTitre'] ?? ''; ?>" /></span>
				<div class="content">
					<header>
						<!-- Titre et sous-titre de la section 'about' avec vérification des valeurs -->
						<h2><?php echo $about['titre'] ?? ''; ?></h2>
						<p><?php echo $about['sousTitre'] ?? ''; ?></p>
					</header>
					<!-- Description de la section 'about', avec valeur par défaut si absente -->
					<p><?php echo $about['description'] ?? ''; ?></p>
					<ul class="actions">
						<?php 
							// Récupération des éléments de la section 'CV' pour afficher un lien de téléchargement
							$cv = getSectionElements($connexion_bdd, "CV");
						?>
						<li><a href="<?php echo $cv['lienMedia'] ?? '#'; ?>" download="<?php echo $cv['titre'] ?? ''; ?>" class="button"><i class="fa-sharp fa-solid fa-download"></i> <?php echo $cv['sousTitre'] ?? ''; ?></a></li>
					</ul>
				</div>
				<!-- Lien vers la section suivante -->
				<a href="<?php echo $about['lienBouton'] ?? ''; ?>" class="goto-next scrolly ">Next</a>
			</section>

			<!-- Interest Section -->
			<section id="interest" class="spotlight style3 left">
				<?php 
					// Récupération des éléments de la section 'interest' depuis la base de données
					$interest = getSectionElements($connexion_bdd, "interest"); 
				?>
				<span class="image fit main"><img src="<?php echo $interest['lienMedia'] ?? 'assets/images/default-interest.jpg'; ?>" alt="<?php echo $interest['sousTitre'] ?? ''; ?>" /></span>
				<div class="content">
					<header>
						<!-- Titre et sous-titre de la section 'interest' avec vérification des valeurs -->
						<h2><?php echo $interest['titre'] ?? ''; ?></h2>
						<p><?php echo $interest['sousTitre'] ?? ''; ?></p>
					</header>
					<!-- Description de la section 'interest', avec valeur par défaut si absente -->
					<p><?php echo $interest['description'] ?? ''; ?></p>
					<ul class="actions">
						<!-- Lien pour en savoir plus (optionnel) -->
						<li><a href="projects.php" class="button">Découvrir les projets</a></li>
					</ul>
				</div>
				<!-- Lien vers la section suivante -->
				<a href="<?php echo $interest['lienBouton'] ?? ''; ?>" class="goto-next scrolly ">Next</a>
			</section>
			<!-- Outils Section -->
			<section id="outils" class="wrapper style1 special fade-up">
				<div class="container">
					<header class="major"> 
						<?php 
							// Récupération des éléments de la section 'outils' depuis la base de données
							$sectionOutil = getSectionElements($connexion_bdd, "outils");  
						?>
						<!-- Titre et sous-titre de la section 'outils' avec vérification des valeurs -->
						<h2><?php echo $sectionOutil['titre'] ?? ''; ?></h2>
						<p><?php echo $sectionOutil['sousTitre'] ?? ''; ?></p>
					</header>
					<?php 
						// Appel de la fonction afficherOutils() pour afficher les outils (fonction définie ailleurs)
						afficherOutils($connexion_bdd); 
					?>
					<footer class="major">
						<ul class="actions special">
							<li><a href="<?php echo $sectionOutil['lienBouton'] ?? ''; ?>" class="button">Découvrir les projets</a></li>
						</ul>
					</footer>
				</div>
			</section>
		</div>

		<?php 
			// Inclusion du footer de la page
			require_once('footer.php'); 
		?>

		<!-- Scripts -->
		<?php require_once('assets/php/scripts.php'); ?>

	</body>
</html>
