<?php $this->render("Menu");?>
<div id="contenu">
	
		<div class="box">
			<div class="haut"><h2>Listes des utilisateurs</h2></div>
			<div class="cont">	
				<table>
					<?php foreach($all_user as $user) : ?>
					<tr><td><?php echo $user['name']?></td><td><?php echo $this->FancyDate->get($user['date'])?></td></tr>
					<?php endforeach;?>
				</table>
			</div>
			<div class="bas"></div>				
		</div>
</div><!-- fin contenu -->