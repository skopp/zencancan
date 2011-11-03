<?php
header("Content-type: text/xml; charset=UTF-8");
header('Content-Disposition: attachment; filename="zencancan.xml"'); 
?>
<opml version="1.0">
	<head>
		<title>zenCancan <?php echo $id ?></title>
	</head>
<body>
<?php foreach($lesFlux as $f) : ?>	
	<outline text="<?php echo htmlspecialchars($f['title']) ?>" title="<?php echo htmlspecialchars($f['title']) ?>" type="rss" 
		xmlUrl="<?php echo htmlspecialchars($f['url']) ?>" htmlUrl="<?php echo htmlspecialchars($f['link']) ?>"/>		
<?php endforeach; ?>
</body>
</opml>