<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
<title>Tools4Origins - Classement de l'univers <?php echo $uniName ?></title>
	<?php include('non_accessible/head.php'); ?>
	<?php include('sep_point.php'); ?>
	<script type="text/JavaScript" src="js/fenetres.js"></script>
</head>

<body>   
<?php 
	include('menu.php');
	function diff($n1,$n2=0)
	{
		$diff=$n1-$n2;
		if($diff>0)
		{
			return '<span class="plus">+' . sep($diff) . '</span>';
		}
		if($diff<0)
		{
			return '<span class="moins">' . sep($diff) . '</span>';
		}
		if($diff==0)
		{
			return '<span class="egal">' . sep($diff) . '</span>';
		}
	}
	?>
	<!-- Le corps -->
	<div id="corps"><center><u>Rechercher un/des joueurs</u><br /><br />
<table border='1' cellpadding="10" cellspacing="1"><tr><td><br /><center><form method='post' action="classement_<?php echo $uni ?>.php"> <!--DEBUT DU FORMULAIRE-->
	<input type="hidden" name="afficher" /> <!--CHAMP CACHE UTILISE POUR NE RIEN AFFICHER COO SI ON ARRIVE SUR LA PAGE AVEC UN LIEN ET PAS AVEC LE FORMULAIRE-->
	<!--JOUEUR RECHERCHE, VIDE PAR DEF-->
	<label for="joueur">Joueur</label> : 
	<input type="text" name="joueur" id="joueur" 
<?php 
if (isset($_POST['joueur'])) //SI $_POST['joueur'] EXISTE, DONC SI ON EST ARRIVE SUR CETTE PAGE EN CLIQUANT SUR LE FORMULAIRE ET PAS AVEC UN LIEN
{
	echo 'value="' . $_POST['joueur'] . '"'; //ON MET COMME VALEUR DANS LA CASE "joueur" LE PSEUDO INDIQUER PAR L'UTILISATEUR QUAND IL A REMPLI LE FORMULAIRE JUSTE AVANT DE CLIQUER SUR "OK"
}
?> />
<br />OU<br />
	<!--ALLIANCE RECHERCHEE, VIDE PAR DEF-->
	<label for="alliance">Alliance</label> : 
	<input type="text" name="alliance" id="alliance" 
<?php
if (isset($_POST['alliance'])) //SI $_POST['alliance'] EXISTE, DONC SI ON EST ARRIVE SUR CETTE PAGE EN CLIQUANT SUR LE FORMULAIRE ET PAS AVEC UN LIEN
{
    echo 'value="' . $_POST['alliance'] . '"'; //ON MET COMME VALEUR DANS LA CASE "alliance" LE PSEUDO INDIQUER PAR L'UTILISATEUR QUAND IL A REMPLI LE FORMULAIRE JUSTE AVANT DE CLIQUER SUR "OK"
}
?>
/><!--<br />OU<br />
	TOP RECHERCHE, 100 PAR DEF
	<label for="top">Top</label> : 
	<select name="top">
	<?php
	for($i=0; $i<50; $i++)
	{
		echo '		<option value ="' . $i*100 . '">Top ' . ($i+1)*100 . '</option>
		';
	}
	?>
	</select>-->
	<br />

	<!--PSEUDO/NOM D'ALLY EXACTE OU JUSTE UN BOUT, DECOCHE PAR DEF-->
	<br /><label for="exex">Expression Exacte:</label> 
		<input type="checkbox" name="exex" id="exex" <?php
if (isset($_POST['exex'])) //SI LA CASE A ETE COCHER LORS DU DERNIER ENVOI DU FORMULAIRE
{ 
	echo 'checked="checked"'; //ON LA COCHE.
}
?> />
<br /><label for="maspaus">Masquer les joueurs en pause:</label> 
		<input type="checkbox" name="maspaus" id="maspaus" <?php
if (isset($_POST['maspaus'])) //SI LA CASE A ETE COCHER LORS DU DERNIER ENVOI DU FORMULAIRE
{ 
	echo 'checked="checked"'; //ON LA COCHE.
}
?> /><br />
<br />
<input type="submit" value="OK" /> <!--BOUTON OK-->
</form><br /></center></tr></td></table></center><br /><br />

<!-- ******* FIN DU FORMULAIRE ******* -->
	<?php
	if(isset($_POST['afficher']))
	{
		include('connect.php');
		$retour=$sql->query("SELECT * FROM infos_donnees WHERE `0` LIKE 'classement_" . $uni . "'");
		$infos=$retour->fetch;
		$exex='';
		$chaine_valide=1;
		if(!isset($_POST['exex']))
		{
			$exex='%';
		}
		if (isset($_POST['maspaus'])) //SI LA CASE "EXpression EXacte" EST COCHEE
			$pause=" AND pause != 1"; //$EXEX VALAIT "" ET VAUX MAINTENANT "%"
		else
			$pause="";
		if($_POST['joueur']!='' AND strlen($_POST['joueur'])>=3)
		{
			$query = "SELECT * FROM classement_" . $uni . "_R" . $infos['1'] . " WHERE joueur LIKE '" . $exex . $_POST['joueur'] . $exex ."'" . $pause . " ORDER BY classement_general";
		}
		elseif($_POST['alliance']!='' AND strlen($_POST['alliance'])>=3)
		{
			$query = "SELECT * FROM classement_" . $uni . "_R" . $infos['1'] . " WHERE alliance LIKE '" . $exex . $_POST['alliance'] . $exex . "'" . $pause . " ORDER BY classement_general";
		}
		elseif(isset($_POST['top']))
		{
			$query = "SELECT * FROM classement_" . $uni . "_R" . $infos['1'] . " ORDER BY classement_general LIMIT " . $_POST['top'] . ", 100";
		}
		else
		{
			echo '<center><span class=rep_trouvee>Veuillez affiner votre recherche</span></center>';
			$chaine_valide=0;
		}
		if($chaine_valide)
		{
			//echo $query;
			echo '<table class="resultat" border="1"><thead><tr><th>Rang</th><th>Alliance</th><th>Joueur</th><th>Points</th><th>Evolution</th></tr></thead>' . "\n";
			$classement=$sql->query($query);
			$num=$infos['1']-1;
			while($joueur = mysql_fetch_array($classement))
			{
				$classement1=$sql->query("SELECT points_general FROM classement_" . $uni . "_R" . $num . " WHERE `joueur` LIKE '" . $joueur['joueur'] . "'ORDER BY classement_general LIMIT 1");
				$retour=$sql->query("SELECT COUNT(*) AS nbre FROM classement_" . $uni . "_R" . $num . " WHERE `joueur` LIKE '" . $joueur['joueur'] . "'ORDER BY classement_general LIMIT 1");
				$nombre=$retour->fetch;
				if($nombre['nbre']==1)
				{
					$rang1=mysql_fetch_array($classement1);
					$point1 = $rang1['points_general'];
				}
				else
				{
					$point1 = "error";
				}
				($joueur['pause']) ? $class=' class="JoueurPause"' : $class = '';
				$action='onmouseover="passage_souris(event,400,\'NF\',' . '\'' . $joueur['joueur'] . "','html','infos_joueur.php?uni=" . $uni . "&pseudo=" . $joueur['joueur'] . "');\" onmouseout=\"arreter_deplacement();delElem('" . $joueur['joueur'] . "');\" onclick=\"lock['" . $joueur['joueur'] . "']=(1/lock['" . $joueur['joueur'] . "']);\"";
				$lien='<a target="_blank" href="details_joueur.php?joueur=' . $joueur['joueur'] . '&univers=' . ucfirst($uni) . '" class="link">';
				echo '<tr' . $class . '><td>' . sep($joueur['classement_general']) . '</td><td>' . $joueur['alliance'] . '</td><td ' . $action . '>' . $lien .  $joueur['joueur'] . '</a></td><td>' . sep($joueur['points_general']) . '</td>' . "\n";
				if($point1 != "error")
				{
					echo '<td>' . diff($joueur['points_general'],$point1) . '</td>';
				}
				else
				{
					echo '<td>???</td>';
				}
				echo '</tr>';
			}
			echo '</table>';
		}
		mysql_close();
	}
	
?>
</div>
<?php include('non_accessible/pub.php'); ?>
</body></html>
