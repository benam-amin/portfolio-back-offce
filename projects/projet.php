	<!DOCTYPE HTML>
	<html>
		<head>
			<title>Projet </title>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
			<link rel="stylesheet" href="../assets/css/main.css" />
			<noscript><link rel="stylesheet" href="../assets/css/noscript.css" /></noscript>
		</head>
		<body class="is-preload">
			<div id="page-wrapper">

				<!-- Header -->
				<?php 
				$id = $_GET["id"];
				require_once('../assets/php/connexion_bdd.php');
					$requete_affiche = "SELECT * FROM projects WHERE id = '$id'"; // requête pour afficher l'élément
					$resultat = $connexion_bdd->query($requete_affiche); // exécution de la requête
				?>

				<!-- Main -->
				<div id="main" class="wrapper style1">
						<div class="container">
							<header class="major">
								<h2>Projects</h2>
								<p>Liste des projets récupérés depuis la base de données</p>
							</header>

							<div class="row gtr-150">
								<div class="col-8 col-12-medium imp-medium">
									<!-- Content -->
									<section id="content">
										<?php
										// Vérifier si des projets ont été récupérés
										if ($resultat->num_rows > 0) {
											// Afficher chaque projet
											while($row = $resultat->fetch_assoc()) {
												echo "<article>";
												echo "<h3>" . htmlspecialchars($row['titre']) . "</h3>";
												echo "<p>" . htmlspecialchars($row['chapo']) . "</p>";
												echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
												echo "<p><strong>Outils:</strong> " . htmlspecialchars($row['outils']) . "</p>";
												echo "<p><strong>Date:</strong> " . htmlspecialchars($row['date']) . "</p>";
												echo "<p><strong>Collaborateur ID:</strong> " . htmlspecialchars($row['idCollaborateur']) . "</p>";
												echo "<p><strong>Catégorie ID:</strong> " . htmlspecialchars($row['idCategories']) . "</p>";
												echo "<p><a href='" . htmlspecialchars($row['lienMedia']) . "' target='_blank'>Voir le média</a></p>";
												echo "</article>";
											}
										} else {
											echo "<p>Aucun projet trouvé.</p>";
										}
										?>
									</section>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>

			<!-- Scripts -->
			<?php require_once('../assets/php/scripts.php'); ?>

		</body>
	</html>