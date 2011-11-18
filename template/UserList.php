<?php $this->render("Menu");?>
<div id="contenu">
	
		<div class="box">
			<div class="haut"><h2>Listes des utilisateurs</h2></div>
			<div class="cont">	
				<table>
					<tr>
						<th><a href='<?php $this->Path->path("/Admin/userList/name")?>'>Pseudo</a></th>
						<th><a href='<?php $this->Path->path("/Admin/userList/nb_abonnement")?>'>Nombre d'abonnement</a></th>
						<th><a href='<?php $this->Path->path("/Admin/userList/nb_publication")?>'>Nombre de publication</a></th>
						<th><a href='<?php $this->Path->path("/Admin/userList/last_login")?>'>Dernière connexion</a></th>
						<th><a href='<?php $this->Path->path("/Admin/userList/date")?>'>Date d'inscription</a></th>
						<th><a href='<?php $this->Path->path("/Admin/userList/last_publication")?>'>Dernière publication</a></th>
						
					</tr>
					
					<?php foreach($all_user as $user) : ?>
					<tr>
						<td><a href='<?php echo $this->Path->getPathWithUsername($user['name'],"/Mur/index")?>'><?php echo $user['name']?></a></td>
						<td><?php echo $user['nb_abonnement']?></td>
						<td><?php echo $user['nb_publication']?></td>
						<td><?php echo $this->FancyDate->get($user['last_login'])?></td>
						<td><?php echo $this->FancyDate->get($user['date'])?></td>
						<td><?php echo $this->FancyDate->get($user['last_publication'])?></td>
						
					</tr>
					<?php endforeach;?>
				</table>
			</div>
			<div class="bas"></div>				
		</div>
</div>