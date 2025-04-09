<!DOCTYPE HTML>
<!--
	Landed by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Contact</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	</head>
	<body class="is-preload">
		<div id="page-wrapper">

			<!-- Header -->
			<?php 
				require_once('header.php');
				require_once('assets/php/gestionFormulaireContact.php');
				$formulaire_soumis = !empty($_POST);
				$errMsg;
				$successMsg;
				if ($formulaire_soumis) {
					$copyChecked = isset($_POST["copy"]) ? true : false;
					$envoiResultat = contactEnvoiMail($connexion_bdd, $_POST["nom"], $_POST["prenom"], $_POST["email"], $_POST["objet"], $_POST["message"], $copyChecked);
					isset($envoiResultat["success"]) ? $successMsg = $envoiResultat["success"] : $errMsg = $envoiResultat["error"];

				} 
			?>

			<!-- Main -->
				<div id="main" class="wrapper style1">
				<?php $contact = getSectionElements($connexion_bdd, "contact"); ?>
					<div class="container">
						<header class="major">
							<h2><?php echo  $contact['titre'];?></h2>
							<p><?php echo  $contact['sousTitre'];?></p>
						</header>

						<!-- Content -->
						<section>
								<form method="post" action="#">
									<div class="row gtr-uniform gtr-50">
										<div class="col-12 col-12-xsmall">
											<?php
												if (!empty($errMsg)) {
													echo "<span style='font-size: 1.5em; color: red;'>$errMsg";
												} else if (!empty($successMsg)) {
													echo "<span style='font-size: 1.5em; color: green;'>$successMsg";
												} 
											?>
										</div>
										<div class="col-6 col-12-xsmall">
											<input type="text" name="nom" id="nom" value="" placeholder="Nom" />
										</div>
										<div class="col-6 col-12-xsmall">
											<input type="text" name="prenom" id="prenom" value="" placeholder="Prénom" />
										</div>
										<div class="col-12 col-12-xsmall">
											<input type="email" name="email" id="email" value="" placeholder="Email" />
										</div>
										<div class="col-12 col-12-xsmall">
											<input type="text" name="objet" id="objet" value="" placeholder="Objet du message" />
										</div>
										<div class="col-12">
											<textarea name="message" id="message" placeholder="Enter your message" rows="6"></textarea>
										</div>
										<div class="col-6 col-12-medium">
											<input type="checkbox" id="copy" name="copy">
											<label for="copy">Recevoir une copie du message par mail</label>
										</div>
										<div class="col-12">
											<ul class="actions">
												<li><input type="submit" value="Envoyer" class="primary" /></li>
												<li><input type="reset" value="Annuler" /></li>
											</ul>
										</div>
										
									</div>
								</form>
							</section>

					</div>
				</div>

			<!-- Footer -->
				<?php require_once('footer.php');?>

		</div>

		<!-- Scripts -->
		<?php require_once('assets/php/scripts.php'); ?>

	</body>
</html>