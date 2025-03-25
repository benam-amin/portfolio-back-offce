<?php 
	function afficherOutils($connexion_bdd) {
		$requete = "SELECT * FROM outils;";
		$resultat = $connexion_bdd->query($requete);
		?>
		<div class="box alt">
			<div class="row gtr-uniform">
			<?php 
				if ($resultat->num_rows > 0) {
					while ($entite = $resultat->fetch_assoc()) {
						if ($entite["visibilite"] == 1) {?>
							<section class="col-4 col-6-medium col-12-xsmall">
								<span class="icon alt major brands fa-<?php echo $entite["icon"];?>"></span>
								<h3><?php echo ucfirst($entite["nom"]);?></h3>
								<p><?php echo isset($entite["description"]) ? $entite["description"] : ''; ?></p>
							</section>
							<?php	}
					 }
					
				}
			?>
			</div>
		</div>
	<?php }
?>
	
