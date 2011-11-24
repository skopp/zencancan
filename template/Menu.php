<div id="colonne">
	
	
		<div class="box">
			<h2>Utilisateur</h2>
			
				<ul class="ul">
				<?php if (! $this->Connexion->getId()) : ?>
					<li><a href="<?php echo $this->Path->getPathWithUsername("","/Account/create") ?>">Cr&eacute;er un compte</a></li>
					<li><a href="<?php echo $this->Path->getPathWithUsername("","/Connexion/login") ?>">Se connecter</a></li>
				<?php endif;?>
				<li><a href="<?php $this->Path->path("/Aide/index")?>">Aide</a></li>
				<li><a href="<?php $this->Path->path("/Contact/index")?>">Nous contacter</a></li>
				<li><a href="<?php $this->Path->path("/Param/index")?>">Paramètre du compte</a></li>
				</ul>
			
		
		</div>
		
		<div class="box">
			<h2>D&eacute;veloppeur</h2>

			
			<ul class="ul">
			<li><a href="https://github.com/epommate/zencancan/tarball/master">T&eacute;lecharger</a></li>
			<li><a href="https://github.com/epommate/zencancan" target='_blank'>Voir le code source</a></li>
			<li><a href="<?php $this->Path->path("/Aide/licence")?>">Licence</a></li>
			</ul>
	
		</div>
		
		
		<?php if ($isAdmin) : ?>
			<div class="box">
				<h2>Admin</h2>
				
				<ul class="ul">
				<li><a href="<?php $this->Path->path("/Admin/flux")?>">Flux</a></li>
				<li><a href="<?php $this->Path->path("/Admin/userList")?>">Utilisateurs</a></li>
				</ul>
		
			</div>
		<?php endif;?>
		
		
</div><!-- fin colonne -->