<?php
include('non_accessible/sep_point.php');
if(isset($uni))
	$_GET['univers']=$uni;
if(isset($_GET['univers']))
	if($_GET['univers']=='alpha' OR $_GET['univers']=='pegase' OR $_GET['univers']=='orion' OR $_GET['univers']=='ida' OR $_GET['univers']=='eridan' OR $_GET['univers']=='centaure' OR $_GET['univers']=='taurus' OR $_GET['univers']=='sateda')
	{
		if(isset($_GET['pause']) AND ($_GET['pause']==1 OR $_GET['pause']==0))
			$recherchePause=$_GET['pause'];
		else
			$recherchePause=1;
		if(isset($_GET['top']) AND !is_nan($_GET['top']) AND $_GET['top']>=0 AND $_GET['top']%100==0)
			$ligneDep=$_GET['top'];
		else
			$ligneDep=0;
		if(isset($_GET['pseudo']) AND $_GET['pseudo']!='')
		{
			$rechercheJoueur=$_GET['pseudo'];
			$ligneDep=0;
		}
		else
			$rechercheJoueur='';
		if(isset($_GET['alliance']) AND $_GET['alliance']!='')
		{
			$rechercheAlliance=$_GET['alliance'];
			$ligneDep=0;
		}
		else
			$rechercheAlliance='';
		$univers=$_GET['univers'];
		$emplacementClassement='non_accessible/classement/classement_' . $univers . '.xml';
		$fichierClassement=fopen($emplacementClassement, 'r');
		$classement=fread($fichierClassement, filesize($emplacementClassement));
		fclose($fichierClassement);
		$classement=explode("\n", $classement);
		$nombreDeLigne=count($classement);
		$ligneAffichees=0;
		
		echo '<table class="classement" border="1">' . "\n";
		echo '<tr><th style="width: 5%;" colspan="2">Rang</th><th style="width: 30%;">Joueur</th><th style="width: 20%;">Alliance</th><th style="width: 22.5%;">Points</th><th style="width: 22.5%;">Evolution</th></tr>' . "\n";
		for($ligne=0; $ligne<$nombreDeLigne AND $ligneAffichees < $ligneDep+100; $ligne++)
		{
			//echo $classement[$ligne] . '<br />' . "\n";
			if(preg_match("#<joueur><pause>([0-1])</pause><rang>([0-9]+)</rang><joueur>(.+)</joueur><alliance>(.*)</alliance><points>([0-9]+)</points><evRang>(<span class=\"(inconnu|moins|egal|plus)\">-?\+?[0-9?.]+</span>)</evRang><evPoint>(<span class=\"(inconnu|moins|egal|plus)\">-?\+?[0-9?.]+</span>)</evPoint></joueur>#", $classement[$ligne], $infos))
			{
				//print_r($infos);
				$enPause = $infos[1];
				$pause = ($enPause) ? ' class="JoueurPause"' : ' class="JoueurNonPause"' ;
				$rang = $infos[2];
				$joueur = $infos[3];
				$lien='<a target="_blank" href="details_joueur.php?joueur=' . $joueur . '&univers=' . ucfirst($univers) . '" class="link" onclick="arreter_deplacement();delElem(\'' . $joueur . '\');lock[\'' . $joueur . '\']=10;">' . $joueur . '</a>';
				$action=' onmouseover="passage_souris(event,400,\'NF\',' . '\'' . $joueur . "','bulle','" . $joueur . "');\" onmouseout=\"arreter_deplacement();delElem('" . $joueur . "');\" onclick=\"lock['" . $joueur . "']=(1/lock['" . $joueur . "']);\"";
				$alliance = $infos[4];
				$points = $infos[5];
				
				$evolutionRang = $infos[6];
				$evolutionPoint = $infos[8];
				if($recherchePause==1 OR $enPause==0)
					if($rechercheJoueur=='' OR stristr($joueur, $rechercheJoueur))
						if($rechercheAlliance=='' OR stristr($alliance, $rechercheAlliance))
						{
							if($ligneAffichees>=$ligneDep)
								echo '<tr' . $pause . '><td>' . $rang . '</td><td>' . $evolutionRang . '</td><td' . $action . '>' . $lien . '</td><td>' . $alliance . '</td><td>' . sep($points) . '</td><td>' . $evolutionPoint . '</td></tr>' . "\n";
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
