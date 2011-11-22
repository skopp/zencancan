<?php if ( $page =="billet" ) : ?>
	<div class="box">
		<h2>Derniers articles</h2>
		
		<div id="billet_list">
			<div class="">
				<table>
				<?php for ( $i=1; $i < 10 ; $i++ ) : ?>
				<tr>
				<?php
				$img = "non_lu.png";
				if ( rand(0,1) == 1 ) $img = "lu.png";
				
				?>
				<td class="lecture"><img src="img/commun/<?php echo $img; ?>" alt="" /></td>
				<td><a href="#">Zagaz blogZagaz blogZagaz blogZagaz blogZagaz blog</a></td>
				<td class="date">10h20</td>
				</tr>
				<?php endfor; ?>
				</table>
			</div>
		</div>
	</div>			
<?php elseif ($page =="mes_sites"): ?>
				<div class="box">
					<h2>Mes tags</h2>
				</div>
				
				
				<div class="box">
					<h2>Mes sites</h2>
					<ul class="site_list">
						<?php for ( $i=1; $i < 10 ; $i++ ) : ?>
						<li><a href="#"><img src="img/commun/favicon_001.png" alt="" />Zagaz blog</a></li>
						<?php endfor; ?>
					</ul>
				</div>

	

					
					

<?php else: ?>
				<div class="box">
					<h2>Titre niv 2</h2>
				</div>
<?php endif ?>