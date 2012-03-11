<?php $this->render("Menu");?>
<div id="contenu">
	<h1>Informations</h1>

	<div class="cont">
		<?php echo $this->UtilisateurSQL->getNbAccount();?> comptes utilisateur, 
		<?php echo $infoFeed['nb'] ?> flux<br/>
		Date de la dernière récupération : <?php echo $infoFeed['max_date'] ?><br/>
		Date de la plus veille récuperation : <?php echo $infoFeed['min_date'] ?><br/>
	</div>
				

	<table>
		<tr>
			<th><a href='<?php $this->Path->path("/Admin/flux/name")?>'>Pseudo</a></th>
			<th><a href='<?php $this->Path->path("/Admin/flux/nb_abonnement")?>'>Nombre d'abonnement</a></th>
			<th><a href='<?php $this->Path->path("/Admin/flux/nb_publication")?>'>Nombre de publication</a></th>
			<th><a href='<?php $this->Path->path("/Admin/flux/last_login")?>'>Dernière connexion</a></th>
			<th><a href='<?php $this->Path->path("/Admin/flux/date")?>'>Date d'inscription</a></th>
			<th><a href='<?php $this->Path->path("/Admin/flux/last_publication")?>'>Dernière publication</a></th>
		</tr>
		
		<?php foreach($all_user as $user) : ?>
		<tr>
			<td><?php echo $user['name']?></td>
			<td><?php echo $user['nb_abonnement']?></td>
			<td><?php echo $user['nb_publication']?></td>
			<td><?php echo $this->FancyDate->get($user['last_login'])?></td>
			<td><?php echo $this->FancyDate->get($user['date'])?></td>
			<td><?php echo $this->FancyDate->get($user['last_publication'])?></td>						
		</tr>
		<?php endforeach;?>
	</table>

</div>