<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Recherche de coordonnées - Univers <?php echo $uniName ?></title>
	<?php include('non_accessible/head.php'); ?>
</head>

<body>   
<?php 
	include('menu.php');
	include('value.php');
	function diff($n1,$n2=0)
	{
		$diff=$n1-$n2;
		if($diff>0)
		{
			return '<span class="plus">+' . $diff . '</span';
		}
		if($diff<0)
		{
			return '<span class="moins">' . $diff . '</span';
		}
		if($diff==0)
		{
			return '<span class="egal">' . $diff . '</span';
		}
	}
	include('date.php');
	?>
	<!-- Le corps -->
	<div id="corps"><center><u>Rechercher une coordonnée</u><br />
	<span class="info">Date du dernier relevé: <?php echo $date[$uni]; ?></span><br />
<table border='1' cellpadding="10" cellspacing="1"><tr><td><br /><center><form method='post' action="coo_<?php echo $uni ?>.php"> <!--DEBUT DU FORMULAIRE-->
	<input type="hidden" name="afficher" /> <!--CHAMP CACHE UTILISE POUR NE RIEN AFFICHER COO SI ON ARRIVE SUR LA PAGE AVEC UN LIEN ET PAS AVEC LE FORMULAIRE-->
	<!--GALAXIE RECHERCHE, VIDE PAR DEF-->
	<label for="galaxie">Galaxie</label> : 
	<input type="text" name="galaxie" id="galaxie" <?php echo value('galaxie'); ?> /><br />
	<!--SYSTEME RECHERCHEE, VIDE PAR DEF-->
	<label for="systeme">Système</label> : 
	<input type="text" name="systeme" id="systeme" <?php echo value('systeme'); ?> /><br />
	<!--POSITION RECHERCHEE, VIDE PAR DEF-->
	<label for="position">Position</label> : 
	<input type="text" name="position" id="position" <?php echo value('position'); ?> /><br /><br />
<input type="submit" value="OK" /> <!--BOUTON OK-->
</form><br /></center></tr></td></table></center><br /><br />

<!-- ******* FIN DU FORMULAIRE ******* -->
<?php
include('connect.php');
if(isset($_POST['afficher']))
{
	if($_POST['galaxie']!='' AND $_POST['systeme']!='' AND $_POST['position']!='')
	{
		if(ctype_digit($_POST['galaxie']) AND ctype_digit($_POST['systeme']) AND ctype_digit($_POST['position']))
		{
			$retour=$sql->query("SELECT * FROM univers_" . $uni . " WHERE `galaxie` = " . $_POST['galaxie'] . " AND `systeme` = " . $_POST['systeme'] . " AND `position` = " . $_POST['position'] . " ORDER BY ID");
			$coo=$retour->fetch();
			if(isset($coo['joueur']))
			{
				$lien='<a href="details_joueur.php?joueur=' . $coo['joueur'] . '&univers=' . ucfirst($uni) . '" class="link">';
				echo '<center><table class="resultat" border = "1"><thead><tr><th>Gal.</th><th>Syst.</th><th>Pos.</th><th>Pseudo</th><th>Alliance</th></tr></thead><tr><td>' . $coo['galaxie'] . '</td><td>' . $coo['systeme'] . '</td><td>' . $coo['position'] . '</td><td>' . $lien . $coo['joueur'] . '</a></td><td>' . $coo['alliance'] . '</td></tr></table></center>';
			}
			else
			{
				echo "Aucun résultat trouvé";
			}
		}
		else
		{
			echo "Les valeurs que vous avez renseigné pour la recherche de coordonnées ne semblent pas être des nombres";
		}
	}
	else
	{
		echo "Veuillez affiner votre recherche";
	}
}
?>
</div>
<?php include('non_accessible/pub.php'); ?>
</body></html>
