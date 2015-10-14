<?php
include('non_accessible/sep_point.php');
if(isset($uni))
	$_GET['univers']=$uni;
if(isset($_GET['univers']))
	if($_GET['univers']=='alpha' OR $_GET['univers']=='pegase' OR $_GET['univers']=='orion' OR $_GET['univers']=='ida' OR $_GET['univers']=='eridan' OR $_GET['univers']=='centaure' OR $_GET['univers']=='taurus' OR $_GET['univers']=='sateda')
	{
		if(isset($_GET['top']) AND !is_nan($_GET['top']) AND $_GET['top']>=0 AND $_GET['top']%100==0)
			$ligneDep=$_GET['top'];
		else
			$ligneDep=0;
		if(isset($_GET['alliance']) AND $_GET['alliance']!='')
		{
			$rechercheAlliance=$_GET['alliance'];
			$ligneDep=0;
		}
		else
			$rechercheAlliance='';
		$univers=$_GET['univers'];
		$emplacementClassement='non_accessible/classement/alliance_' . $univers . '.xml';
		$fichierClassement=fopen($emplacementClassement, 'r');
		$classement=fread($fichierClassement, filesize($emplacementClassement));
		fclose($fichierClassement);
		$classement=explode("\n", $classement);
		$nombreDeLigne=count($classement);
		$ligneAffichees=0;
		
		echo '<table class="classement" border="1">' . "\n";
		echo '<tr><th colspan="2" style="width:5%">Rang</th><th style="width:30%">Alliance</th><th colspan="2" style="width:20%">Nombre de membres</th><th style="width:22.5%">Points</th><th style="width:22.5%">Evolution</th></tr>' . "\n";
		for($ligne=0; $ligne<$nombreDeLigne AND $ligneAffichees < $ligneDep+100; $ligne++)
		{
			//echo $classement[$ligne] . '<br />' . "\n";
			if(preg_match("#<ally><rang>(.+)</rang><tag>(.+)</tag><nom>(.+)</nom><membres>(.+)</membres><points>(.+)</points><ratio>(.+)</ratio><evRang>(.+)</evRang><evMembres>(.+)</evMembres><evPoints>(.+)</evPoints></ally>#", $classement[$ligne], $infos))
			{
				$rang = $infos[1];
				$tag = $infos[2];
				$nom = $infos[3];
				$membres = $infos[4];
				$points = $infos[5];
				$ratio = $infos[6];
				$evRang = $infos[7];
				$evMembres = $infos[8];
				$evPoints = $infos[9];
				if($rechercheAlliance=='' OR stristr($nom, $rechercheAlliance) OR stristr($tag, $rechercheAlliance))
				{
					if($ligneAffichees>=$ligneDep)
						echo '<tr class="JoueurNonPause"><td>' . $rang . '</td><td>' . $evRang . '</td><td class="ally">[' . $tag . '] ' . $nom . '</td><td>' . $membres . ' </td><td>' . $evMembres . ' </td><td>' . $points . '</td><td>' . $evPoints . '</td></tr>' . "\n";
					$ligneAffichees++;
				}
			}
		}
		echo '</table>';
		
		if($ligneAffichees>35)
			echo '<br /><a class="link" href="#">Retour en haut de page</a>';
	}
	else
	{
		echo 'Vous ne pouvez accèder à la page directement.';
	}
else
{
	echo 'Vous ne pouvez accèder à la page directement.';
}

?>
