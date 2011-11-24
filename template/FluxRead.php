<div id="colonne">

<div class="box">
		<h2>Derniers articles</h2>
		
		<div id="billet_list">
			<div class="">
				<table>
				<?php foreach($rssInfo['item'] as $i => $itemInfo) : ?>
				<tr>
				<?php
				$img = "non_lu.png";
				//if ( rand(0,1) == 1 ) $img = "lu.png";
				
				?>
				<td class="lecture"><img src="img/commun/<?php echo $img; ?>" alt="" /></td>
				<td><a href='<?php $this->Path->path("/Feed/read/$id_f/$i")?>'  
							title='<?php  hecho($itemInfo['description']); ?>'>
							<?php hecho(strip_tags($itemInfo['title'])) ?>
						</a></td>
				<td class="date"><?php echo $this->FancyDate->get($itemInfo['pubDate'])?></td>
				</tr>
				<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>			
</div>


<div id="contenu">


<div id="info_blog">
	<div class="blog_titre">
		<p class="titre"><img src="img/commun/favicon_001.png" alt="" /><?php hecho($rssInfo['title']) ?></p>
	</div>
	
	<div class="blog_option">
		<ul>
		<li>
		<?php if ($isAdmin) : ?>
			<a  class="a_btn" href='<?php $this->Path->path("/Feed/forceReload/$id_f")?>'>Actualiser</a>
			
		<?php endif;?>
		</li>
		
			<li>
	<form  action='<?php $this->Path->path() ?>' method='post'>
			<?php $this->Connexion->displayTokenField(); ?>
			<input type='hidden' name='path_info' value='/Feed/doDelete' />
			
			<input class='submit' type='submit' value='Ne plus suivre'/>
		
			<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
		</form>

	</li>
			<li><a href="#" class="option" id="tags_btn">Gérer les étiquettes</a></li>
		</ul>
			<?php if ($tag) : ?>
		&Eacute;tiquettes : 
			<?php foreach($tag as $one_tag): ?>
			<a href='<?php $this->Path->path("/Feed/list/0/$one_tag") ?>'><?php hecho($one_tag) ?></a>
			&nbsp;<a href='<?php $this->Path->path("/Tag/del/$id_f/$one_tag") ?>' title='supprimer'>X</a>
			<?php endforeach;?>
		<?php endif;?>
		
		
		<form action='<?php $this->Path->path() ?>' method='post'>
			<?php $this->Connexion->displayTokenField(); ?>
			<input type='hidden' name='path_info' value='/Tag/doAdd' />
			<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
			
			<p >
			<span>Ajouter une &eacute;tiquette: </span>
			<input type='text' name='tag' value='' />
			<br/>
			<input class='a_btn' type='submit' value='Ajouter'/>
			</p>
		</form>
		
		
	</div>
</div>


<?php $this->LastMessage->display()?>




<?php $this->render("FluxLink"); ?>

	<div class="box">
		<div class="haut">
		<h2><?php hecho($resultItem['title'])?>
		- <a href='<?php hecho($rssInfo['link']) ?>'><?php hecho($rssInfo['title']) ?></a>
		</h2>
		</div>
		
		<div class="cont">
			<div class='item_content width_min'>
				<?php echo $content_html;?>
			</div>
		
			<br/><br/>
			
			<div class="width_min align_center">
			 <form class='force_center' action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Feed/doAddMur' />
				<input type='hidden' name='id_f' value='<?php hecho($id_f)?>' />				
				<input type='hidden' name='num_feed' value='<?php hecho($num_feed)?>' />
				<input type='submit' value='Publier sur mon mur' class="submit " />
			</form>
			</div>
			
			
			<?php $this->render("FluxLink"); ?>
			
			
				<?php 
			if ($rejected_tag || $rejected_attributes) : ?>
				<?php if (! $isAdmin) : ?><!--<?php endif; ?>
					<br/><br/> 
					Le document a &eacute;t&eacute; purifi&eacute; de la mani&egrave;re suivante :
					<?php if ($rejected_tag) : ?>
						<div>Les balises suivantes ont &eacute;&eacute; rejet&eacute; : 
						<?php echo implode(",\n",$rejected_tag)?>
						</div>
					<?php endif;?>
					<?php if ($rejected_attributes) : ?>
						<div>
						Les attributs suivantes ont &eacute;t&eacute; rejet&eacute; : 
						<?php echo implode(",\n",$rejected_attributes)?>
						</div>
					<?php endif;?>
					
					<?php if ($rejected_style) : ?>
						<div>
						Les éléments de style suivant ont &eacute;t&eacute; rejet&eacute; : 
						<?php echo implode(",\n",$rejected_style)?>
						</div>
					<?php endif;?>
					
				<?php if (! $isAdmin) : ?> -->	<?php endif;?>
			<?php endif;?>
			
				<?php $this->render("PbAffichage");?>
			
			
			</div>			
			
			
			<div class="bas"></div>	
		</div>
	</div>
	
	
	