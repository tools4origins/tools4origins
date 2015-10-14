<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Détails d'un Joueur</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/graph.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/highcharts.js"></script>
	<script type="text/javascript" src="js/graphTheme.js"></script>
	<script type="text/javascript" src="js/exporting.js"></script>
</head>

<body>   
<?php
	include('menu.php');
	include('non_accessible/value.php');
	include('non_accessible/sep_point.php');
	
	$uniName=htmlspecialchars($_GET['univers']);
	$uni=strtolower($uniName);
	$player=htmlspecialchars($_GET['joueur']);
?>
<!-- Le corps -->
<div id="corps" class="center">
	<h2>
		Détails du joueur <span class="link"><?php echo $player; ?></span>
	</h2>
	<br />
	<?php include('non_accessible/evolution.php');?>
	<br />
	<img src="planetes.php?joueur=<?php echo $player .'&amp;univers=' . $uniName ;?>" /><br />
	<input name="bbcode" value="[url=http://tools4origins.fr.nf/][img]http://tools4origins.fr.nf/planetes.php?joueur=<?php echo $player . '&amp;univers=' . $uniName ;?>&amp;type=.png[/img][/url]" readonly="readonly" size="100" type="text"><br /><br />
	<img src="sign/<?php echo $uniName . '/' . $player;?>/0.png" /><br />
	<input name="bbcode" value="[url=http://tools4origins.fr.nf/][img]http://tools4origins.fr.nf/sign/<?php echo $uniName . '/' . $player;?>/0.png[/img][/url]" readonly="readonly" size="100" type="text"><br /><br />
	<img src="sign/<?php echo $uniName . '/' . $player;?>/1.png" /><br />
	<input name="bbcode" value="[url=http://tools4origins.fr.nf/][img]http://tools4origins.fr.nf/sign/<?php echo $uniName . '/' . $player;?>/1.png[/img][/url]" readonly="readonly" size="100" type="text"><br /><br />
	<br /><br />
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>
