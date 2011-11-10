<div id="colonne">
	
	
		<div class="box">
			<div class="haut"><h2>Utilisateur</h2></div>
			<div class="cont">
				<ul class="ul_lien">
				<?php if (! $this->Connexion->getId()) : ?>
					<li><a href="<?php echo $this->Path->getPathWithUsername("","/Account/create") ?>">Cr&eacute;er un compte</a></li>
					<li><a href="<?php echo $this->Path->getPathWithUsername("","/Connexion/login") ?>">Se connecter</a></li>
				<?php endif;?>
				<li><a href="<?php $this->Path->path("/Aide/index")?>">Aide</a></li>
				<li><a href="<?php $this->Path->path("/Contact/index")?>">Nous contacter</a></li>
				<li><a href="<?php $this->Path->path("/Param/index")?>">Paramètre du compte</a></li>
				</ul>
			
			</div>
			<div class="bas"></div>				
		</div>
		
		<div class="box">
			<div class="haut"><h2>D&eacute;veloppeur</h2></div>
			<div class="cont">
			
			<ul class="ul_lien">
			<li><a href="http://zenstore.zenprog.com/telechargement/zenCancan.tgz">T&eacute;lecharger</a></li>
			<li><a href="http://source.zenprog.com/zencancan">Voir le code source</a></li>
			<li><a href="<?php $this->Path->path("/Aide/presentation#licence")?>">Licence</a></li>
			</ul>
			</div>
			<div class="bas"></div>				
		</div>
		<?php if ($isAdmin) : ?>
			<div class="box">
				<div class="haut"><h2>Admin</h2></div>
				<div class="cont">
				
				<ul class="ul_lien">
				<li><a href="<?php $this->Path->path("/Admin/flux")?>">Flux</a></li>
				<li><a href="<?php $this->Path->path("/Admin/userList")?>">Utilisateurs</a></li>
				</ul>
				</div>
				<div class="bas"></div>				
			</div>
		<?php endif;?>
		
		
</div><!-- fin colonne -->