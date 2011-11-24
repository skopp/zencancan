<?php
$page = "mes_sites";
$titre_h1 = "Titre de niveau H1";
include('_haut.php'); ?>

<h1><?php echo $titre_h1 ?></h1>

<div class="box">


<table>

<?php for ( $i=1; $i < 10 ; $i++ ) : ?>
<tr>
<td class="favicon"><img src="img/commun/favicon_001.png" alt="" /></td>
<td class="blog">titre du blog</td>
<td><a href="billet.php">Article du blog blablbalblblaa</a></td>
<td class="tag">toto, lolopopop</td>
<td class="date">10h20</td>
</tr>
<?php endfor; ?>
</table>


</div>





<?php include('_bas.php'); ?>
				
				
				
				
				
				
				
				
				
