<?php 


class FeedHTML {
	
	private $fancyDate;
	
	public function __construct(FancyDate $fancyDate){
		$this->fancyDate = $fancyDate;
	}
	
	public function display($allFlux,$id,$tag){?>
		<table>
<?php foreach($allFlux as $i => $flux) : ?>
	<tr class="<?php echo $i%2?"":"bgcolor01";?>">
		<td class='date'><a name='' title='Dernier passage : <?php echo $this->fancyDate->get($flux['last_recup'])?>'><?php echo $this->fancyDate->get($flux['last_maj'])?></a></td>
		<td class='tag'>
		<?php if(! $tag): ?>
			<a href='index.php?id=<?php echo $id?>&tag=<?php echo urlencode($flux['tag'])?>'><?php echo $flux['tag'] ?></a>
		<?php endif;?>
		</td>
		
		<td class='site' style=' white-space:nowrap;'><a href='feed.php?id=<?php echo $id ?>&id_f=<?php hecho($flux['id_f'])?>' title='<?php hecho($flux['title'])?>'><?php hecho(wrap($flux['title'],25,2))?></a></td>
	
		<td class='lien' white-space:nowrap;'>
		<a href='read.php?id=<?php hecho($id) ?>&id_f=<?php echo $flux['id_f'] ?>&item=<?php echo urlencode($flux['last_id'])?>' title='<?php  echo get_link_title($flux['item_content']) ?>'>
				<?php echo strip_tags($flux['item_title']) ?>
			</a>
			<a href='<?php hecho($flux['item_link'])?>' target='_blank' title="Ouvrir l'article original">
				&raquo;
			</a></td>		
	</tr>
<?php endforeach;?>
</table>
		
	<?php 
	}
	
}
