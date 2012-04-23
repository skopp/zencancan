<div id="colonne">
		
<div class="info_blog">
	
	<div>
	<a class="btn_retour tooltip" title="Retour aux sites" href="<?php $this->Path->path()?>"><img src="<?php $this->Path->echoRessourcePath("/img/commun/ilu_retour.png") ?>" alt="retour aux sites" /></a>
	</div>
	
	<h2><img src="<?php $abonnementInfo['favicon']?$this->Path->echoRessourcePath("/static/favicon/{$abonnementInfo['favicon']}"):$this->Path->echoRessourcePath("/img/commun/no_favicon.png")  ?>" alt="" />
		<a href='<?php hecho($abonnementInfo['link']) ?>' target='_blank'><?php hecho($abonnementInfo['title']) ?></a></h2>
	
	
	<div class="blog_option">
		<ul>
			
			<?php if ($isAdmin) : ?>
				<li><a class="tooltip" title="Forcer l'actualisation" href="<?php $this->Path->path("/Feed/forceReload/{$abonnementInfo['id_f']}")?>"><img src="<?php $this->Path->echoRessourcePath("/img/commun/ilu_forcer_actualiser.png") ?>" alt="Forcer l'actualisation" /></a></li>	
			<?php endif;?>
			<?php if ($abonnementInfo['nb_second_since_last_recup']>360 || $isAdmin) : ?>
				<li><a class="tooltip" title="Actualiser" href="<?php $this->Path->path("/Feed/update/{$abonnementInfo['id_f']}")?>"><img src="<?php $this->Path->echoRessourcePath("/img/commun/ilu_actualiser.png") ?>" alt="Actualiser" /></a></li>
			<?php endif;?>	

			<li>
				<form  action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Feed/doDelete' />
				<input type='hidden' name='id_f' value='<?php echo $abonnementInfo['id_f'] ?>'/>
				<input  class="tooltip" type='image' src='<?php $this->Path->echoRessourcePath("/img/commun/ilu_del_blog.png") ?>' title='Ne plus suivre'/>
				</form>
			</li>
			<li>
				<a id="tags_btn" href="#"><img src='<?php $this->Path->echoRessourcePath("/img/commun/ilu_tag_option.png") ?>' alt="G&eacute;rer les &eacute;tiquettes" /></a>
			</li>
		</ul>
		
		<div id="tags_menu">
			<span class="btn_close" title="Fermer" id="login_close_btn">&nbsp;</span>
			<?php if ($tag) : ?>
			&Eacute;tiquettes : 
				<?php foreach($tag as $one_tag): ?>
				<a href='<?php $this->Path->path("/Feed/list/0/$one_tag") ?>'><?php hecho($one_tag) ?></a>
				&nbsp;<a href='<?php $this->Path->path("/Tag/del/{$abonnementInfo['id_f']}/$one_tag") ?>' title='supprimer'>X</a>
				<?php endforeach;?>
			<?php endif;?>
			
			
			<form action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Tag/doAdd' />
				<input type='hidden' name='id_f' value='<?php echo $abonnementInfo['id_f'] ?>'/>
				<p>
					<span>Ajouter une &eacute;tiquette: </span>
					<input type='text' name='tag' value='' />
					<br/>
					<input class='a_btn' type='submit' value='Ajouter'/>
				</p>
			</form>
		</div>
		
	</div><!-- fin info_blog -->
</div><!-- fin blog_option -->
</div>


<div id="contenu">

<h1><?php hecho($abonnementInfo['title'])?></h1>
<div class="box">


<table class='tableSite'>
<?php foreach($allItem as $i => $item) : ?>
	<tr class="siteTR">
		<td class="favicon"><img width='16' height='16' src="<?php $abonnementInfo['favicon']?$this->Path->echoRessourcePath("/static/favicon/{$abonnementInfo['favicon']}"):$this->Path->echoRessourcePath("/img/commun/no_favicon.png") ?>" alt="" /></td>
		<td>
			<a href='<?php $this->Path->path("/Feed/read/{$item['id_i']}") ?>' title='<?php  hecho($item['description']) ?>'>
				<?php hecho($item['title']) ?>
			</a> - 			
			<?php hecho ($item['description'])?>
		</td>
		<td class='date'>
				<?php echo $this->FancyDate->get($item['date'])?>
		</td>
	</tr>
<?php endforeach;?>
</table>
</div>

</div>
