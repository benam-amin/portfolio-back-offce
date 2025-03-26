<!DOCTYPE HTML>
<!--
	Landed by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Left Sidebar - Landed by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/modale.css">
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
		<div id="page-wrapper">

			<!-- Header -->
			<?php 
				require_once('header.php');
			?>

			<!-- Main -->
				<div id="main" class="wrapper style1">
					<div class="container">
						<header class="major">
							<h2>Left Sidebar</h2>
							<p>Ipsum dolor feugiat aliquam tempus sed magna lorem consequat accumsan</p>
						</header>
						<div class="row gtr-150">
							<div class="col-10 col-12-medium imp-medium">

								<!-- Content -->
									<section id="content">
										<a href="#" class="image fit"><img src="images/pic05.jpg" alt="" /></a>
										<h3>Dolore Amet Consequat</h3>
										<p>Aliquam massa urna, imperdiet sit amet mi non, bibendum euismod est. Curabitur mi justo, tincidunt vel eros ullamcorper, porta cursus justo. Cras vel neque eros. Vestibulum diam quam, mollis at magna consectetur non, malesuada quis augue. Morbi tincidunt pretium interdum est. Curabitur mi justo, tincidunt vel eros ullamcorper, porta cursus justo. Cras vel neque eros. Vestibulum diam.</p>
										<p>Vestibulum diam quam, mollis at consectetur non, malesuada quis augue. Morbi tincidunt pretium interdum. Morbi mattis elementum orci, nec dictum porta cursus justo. Quisque ultricies lorem in ligula condimentum, et egestas turpis sagittis. Cras ac nunc urna. Nullam eget lobortis purus. Phasellus vitae tortor non est placerat tristique.</p>
										<h3>Sed Magna Ornare</h3>
										<p>In vestibulum massa quis arcu lobortis tempus. Nam pretium arcu in odio vulputate luctus. Suspendisse euismod lorem eget lacinia fringilla. Sed sed felis justo. Nunc sodales elit in laoreet aliquam. Nam gravida, nisl sit amet iaculis porttitor, risus nisi rutrum metus.</p>
										<ul>
											<li><button class="button primary" onclick="openModal(1)">Projet 1</button></li>
											<li><button class="button primary" onclick="openModal(2)">Projet 2</button></li>
											<li><button class="button primary" onclick="openModal(3)">Projet 3</button></li>
										</ul>
									</section>

							</div>
						</div>
					</div>
				</div>
				<div id="customModal" class="modal">
				<div class="modal-content">
						<span class="close" onclick="closeModal()">&times;</span>
						<div id="modal-body">Chargement...</div>
					</div>
				</div>

			<!-- Footer -->
			<?php require_once('footer.php');?>

		</div>

		<!-- Scripts -->
		<?php require_once('assets/php/scripts.php'); ?>>
		<script>
			function openModal(projetId) { //fonction pour ouvrir la modale
				fetch('projects/projet.php?id=' + projetId) //récupère le fichier et permet de l'afficher en tant que modale
					.then(response => response.text())
					.then(data => {
						const modal = document.getElementById("customModal");
						document.getElementById('modal-body').innerHTML = data;
						modal.style.display = "flex";
						setTimeout(() => modal.style.opacity = "1", 10);
					})
					.catch(error => console.error('Erreur de chargement:', error));
			}

			function closeModal() {
				const modal = document.getElementById("customModal");
				modal.style.opacity = "0";
				setTimeout(() => modal.style.display = "none", 300);
			}

			// Fermer en cliquant en dehors du contenu
			document.getElementById("customModal").addEventListener("click", function(event) {
				if (event.target === this) {
					closeModal();
				}
			});
		</script>

	</body>
</html>