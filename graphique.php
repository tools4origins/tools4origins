<?php
header("Content-type: image/png");
define('NOMBRE_DE_RELEVE', 34);
include('non_accessible/sep_point.php');
function printar($stats, $dates , $i)
{
	$nb=count($dates);
	$lastValue=NULL;
	for($n=0; $n<$nb; $n++)
	{
		if($n==$i)
			echo '<b>';
		echo date('d-m-Y', $dates[$n]). ' - ' . sep($stats[$n]);
	//	if($lastValue!=NULL AND round(($dates[$n]-$lastValue)/(7*60*60*24)) != 1)
	//		echo round(($dates[$n]-$lastValue)/(7*60*60*24))-1 . ' semaine(s)';
		echo ' <br />';
		$lastValue=$dates[$n];
		if($n==$i)
			echo '</b>';
	}
	echo '<br />';
}
function error($errorId)
{
	echo 'Erreur ' . $errorId;
	//CREATION IMAGE
	$image = imagecreatefrompng('images/fond_graph2.png');
	
	//DEFINITION COULEURS ET POLICE
	$couleur_fond=imagecolorallocate($image, 228, 234, 242);
	$couleur_fond_graphique=imagecolorallocatealpha($image, 0, 0, 0, 30);
	$couleur_ligne_graphique=imagecolorallocatealpha($image, 120, 120, 120, 80);
	$couleur_axe_graphique=imagecolorallocate($image, 60, 60, 60);
	$couleur_graphique=imagecolorallocate($image, 18, 34, 57);
	$couleur_texte=imagecolorallocate($image, 150, 150, 150);
	$couleur_cadre=imagecolorallocate($image, 0, 0, 0);
	$couleur_titre=imagecolorallocate($image, 255, 255, 255);
	$couleur_uni=imagecolorallocate($image, 240, 130, 0);
	$couleur_sign=imagecolorallocate($image, 0, 0, 0);
	$couleur_transparence=imagecolorallocate($image, 108, 255, 0);
	$couleur_contour_graph=imagecolorallocate($image, 69, 114, 181);
	imagecolortransparent($image, $couleur_transparence);
	$police_texte = 'non_accessible/GeosansLight.ttf';
	$police_univers = 'non_accessible/Arial.ttf';
	
	//AJOUT SIGNATURE
	imagestring($image, 4, 115, 282, utf8_decode("Graphique généré sur tools4origins.fr.nf"), $couleur_titre);
	
	//AJOUT TITRE
	imagestring($image, 4, 10, 3, "Evolution du joueur : " . utf8_decode($_GET['joueur']), $couleur_titre);
	imagestring($image, 4, 390, 3, "Univers : ", $couleur_titre);
	imagestring($image, 4, 465, 3, "[" . utf8_decode(ucfirst($_GET['univers'])) . "]", $couleur_uni);
	
	//AJOUT CADRE
	ImageLine ($image, 0, 0, 0, 300, $couleur_cadre);
	ImageLine ($image, 0, 299, 539, 299, $couleur_cadre);
	ImageLine ($image, 539, 0, 539, 299, $couleur_cadre);
	ImageLine ($image, 0, 0, 539, 0, $couleur_cadre);
	
	//AJOUT GRAPHIQUE
	ImageFilledRectangle ($image, 60, 25, 525, 220, $couleur_fond_graphique);
	
	//AJOUT MSG ERREUR
	imagestring($image, 5, 120, 55, utf8_decode("Impossible de générer le graphique."), $couleur_texte);
	imagestring($image, 5, 80, 100, utf8_decode("Cause probable du probleme:"), $couleur_texte);
	imagestring($image, 5, 80, 115, utf8_decode("-Lien érroné."), $couleur_texte);
	imagestring($image, 5, 80, 130, utf8_decode("-Joueur inexistant."), $couleur_texte);
	imagestring($image, 5, 80, 145, utf8_decode("-Trop peu de rélevés pour génerer le graphique."), $couleur_texte);
	imagestring($image, 5, 80, 160, utf8_decode("-Variable(s) non renseignée(s)."), $couleur_texte);
	
	//AFFICHAGE IMAGE
	$couleur_fond=imagecolorallocate($image, 228, 234, 242);
	//imagepng($image);
	exit();
}

if(in_array($_GET['univers'], array('Alpha', 'Pegase', 'Orion', 'Ida', 'Eridan', 'Centaure', 'Taurus')))
{
	// Traitement de $_GET
	$player=htmlspecialchars($_GET['joueur']);
	$uni=strtolower($_GET['univers']);
	$uniName=str_replace("Pegase", "Pégase", $_GET['univers']);
	
	if(!isset($_GET['affiche']))
	{
		$affiche='generalPoints';
		$nom_graph='Points general';
	}
	elseif(preg_match("#^(general|batiments|technologies|flottes|defenses|appareils)(Points|Rank)$#", $_GET['affiche'], $arrAffiche))
	{
		$affiche=$_GET['affiche'];
		$nom_graph=str_replace('Rank', 'Rang', $arrAffiche[2]) . ' ' . $arrAffiche[1];
	}
	else
		error('#2');

	// Récupération des statistiques dans la BDD
	include('non_accessible/connect.php');
	$query="SELECT " . $affiche . ", week FROM " . $uni . "Players WHERE pseudo = '". $player . "' ORDER BY week DESC LIMIT " . NOMBRE_DE_RELEVE . ";";
	//echo $query;
	$retour = $sql->query($query);
	for($c=0; $data=$retour->fetch(); $c++)
	{
		$stats[$c]=$data[$affiche];
		$dates[$c]=$data['week'];
	}
	$retour->closeCursor();
	
	//Les tableaux ont été remplis dans l'ordre inverse, on change donc l'ordre.
	$stats=array_reverse($stats);
	$dates=array_reverse($dates);
	
	//Gestion des trous dans les relevés (moyennes des ceux à coté)
	
	$lastDate=NULL;
	$lastPoints=NULL;
	for($i=0; isset($dates[$i]) AND $i<100; $i++) //Pour chaque relevés
	{
		if($lastPoints!=NULL)
			if($dates[$i]!=$lastDate+1) //Si la date n'est pas la dernière + 1 semaine
			{
				$nombreDeRelevesManquants=round($dates[$i]-$lastDate)-1; //On calcul le nombre de relevés manquants
				if($nombreDeRelevesManquants>=1) //Si yen a un ou plus (dans certains cas il y en a 0 avec le changement d'heure
				{	
					for($c=count($stats)-1; $c>=$i; $c--) //On décale les relevés suivant
					{
						$stats[$c+$nombreDeRelevesManquants]=$stats[$c];
						$dates[$c+$nombreDeRelevesManquants]=$dates[$c];
					}
					
					for($c=$i; $c<$i+$nombreDeRelevesManquants; $c++) //Et on insère des valeurs calculées 
					{
						$stats[$c]=floor($stats[$c-1]+($stats[$i+$nombreDeRelevesManquants]-$stats[$i-1])/($nombreDeRelevesManquants+1));
						$dates[$c]=$dates[$i-1]+$c-$i+1;
					}
					$i+=$nombreDeRelevesManquants; //On ne vérifie pas les valeurs calculées (inutile, on gagne ainsi du temps)
				}
			}
		$lastDate=$dates[$i];
		$lastPoints=$stats[$i];
	}
 
	$tailleArray=count($stats);
	if($tailleArray>NOMBRE_DE_RELEVE) //Si on a eu des trous, on a trop de relevé par rapport à ce qu'on voulait (on a ceux que le nombre que l'on désirait + les trous) 
	{
		$diff=$tailleArray-NOMBRE_DE_RELEVE;
		for($c=$diff; $c<$tailleArray; $c++) //Donc on décale les relevés pour n'avoir que NOMBRE_DE_RELEVE relevés.
		{
			$stats[$c-$diff]=$stats[$c];
			$dates[$c-$diff]=$dates[$c];
			unset($stats[$c]);
			unset($dates[$c]);
		}
	}

	//Calculs d'informations sur les tableaux
	$nombre_releves=count($stats);
	$nombre_date=count($dates);
	$minReleves=min($stats);
	$maxReleves=max($stats);
	$intervalDate=ceil($nombre_releves/20); //On affichera une date tout les intervalDate relevés

	if($nombre_releves<2 OR $nombre_date<2) { error('#3'); } //Si on a pas assez de relevés pour faire un graphique on ne le fais pas

	if(strlen($minReleves)!=strlen($maxReleves))
	{
		$minGraph=floor($minReleves/pow(10, strlen($minReleves)-1))*pow(10, strlen($minReleves)-1);
		$maxGraph=ceil($maxReleves/pow(10, strlen($minReleves)-1))*pow(10, strlen($minReleves)-1);
		$diff_entre_2_ligne=pow(10, strlen($minReleves)-1);
	}
	else
	{
		$minGraph=floor($minReleves/pow(10, strlen($minReleves)-2))*pow(10, strlen($minReleves)-2);
		$maxGraph=ceil($maxReleves/pow(10, strlen($minReleves)-2))*pow(10, strlen($minReleves)-2);
		$diff_entre_2_ligne=pow(10, strlen($minReleves)-2);
	}
	
	$difference_extremum_graphique=($maxGraph-$minGraph) ? $maxGraph-$minGraph : 1;			//On envisage le cas où ces valeurs sont nulles vu qu'on fais une division plus loin
	$nombre_ligne=($maxGraph-$minGraph) ? ($maxGraph-$minGraph)/$diff_entre_2_ligne : 1;

	$echelle_y=195/$difference_extremum_graphique;
	
	for($c=0; $nombre_ligne>=10 AND $c<100; $c++)
	{
		$nombre_ligne/=2;
		$diff_entre_2_ligne*=2;
	}
	
	//Définition de la taille de la police des légendes en fonction de la longueur de ces dernières
	$longueur_max_graph=strlen($maxGraph);
	if($longueur_max_graph<7)
	{
		$taille_texte=4;
		$decalage=6;
		$marge=4;
	}
	elseif($longueur_max_graph<8)
	{
		$taille_texte=3;
		$decalage=7;
		$marge=6;
	}
	elseif($longueur_max_graph<10)
	{
		$taille_texte=2;
		$decalage=7;
		$marge=5;
	}
	elseif($longueur_max_graph<11)
	{
		$taille_texte=2;
		$decalage=7;
		$marge=0;
	}
	else
	{
		$taille_texte=1;
		$decalage=4;
		$marge=3;
	}
	
	//CREATION IMAGE
	$image = imagecreatefrompng('images/fond_graph2.png');
	//DEFINITION COULEURS ET POLICE
	$couleur_fond=imagecolorallocate($image, 228, 234, 242);
	$couleur_fond_graphique=imagecolorallocatealpha($image, 0, 0, 0, 30);
	$couleur_ligne_graphique=imagecolorallocatealpha($image, 120, 120, 120, 80);
	$couleur_axe_graphique=imagecolorallocate($image, 60, 60, 60);
	$couleur_graphique=imagecolorallocate($image, 18, 34, 57);
	$couleur_texte=imagecolorallocate($image, 150, 150, 150);
	$couleur_cadre=imagecolorallocate($image, 0, 0, 0);
	$couleur_titre=imagecolorallocate($image, 255, 255, 255);
	$couleur_uni=imagecolorallocate($image, 240, 130, 0);
	$couleur_sign=imagecolorallocate($image, 0, 0, 0);
	$couleur_transparence=imagecolorallocate($image, 108, 255, 0);
	$couleur_contour_graph=imagecolorallocate($image, 69, 114, 181);
	imagecolortransparent($image, $couleur_transparence);
	$police_texte = 'non_accessible/GeosansLight.ttf';
	$police_univers = 'non_accessible/Arial.ttf';
	
	//AJOUT SIGNATURE
	imagettftext($image, 12, 0, 150, 290, $couleur_titre, $police_texte, "Graphique généré sur tools4origins.fr.nf");
	//AJOUT TITRE
	imagettftext($image, 12, 0, 20, 16, $couleur_titre, $police_texte, $nom_graph . " du joueur : " . $player);
	imagettftext($image, 12, 0, 410, 16, $couleur_titre, $police_texte, "Univers : ");
	imagettftext($image, 10, 0, 465, 16, $couleur_uni, $police_univers, ucfirst($uniName));
	//AJOUT CADRE
	ImageLine ($image, 0, 29, 0, 270, $couleur_cadre);
	ImageLine ($image, 29, 299, 509, 299, $couleur_cadre);
	ImageLine ($image, 539, 29, 539, 269, $couleur_cadre);
	ImageLine ($image, 29, 0, 509, 0, $couleur_cadre);
	//AJOUT GRAPHIQUE
	ImageFilledRectangle ($image, 60, 25, 525, 220, $couleur_fond_graphique);
	//CREACTION POLYGONE (ZONE EN DESSOUS DE LA COURBE)
	$points_poly=array();
	if(substr_count($affiche,'Points'))
		for($i=0; $i<$nombre_releves; $i++)
		{
			$points_poly[$i*2]=floor(60+(465/($nombre_releves-1))*$i);
			$points_poly[$i*2+1]=220-floor(($stats[$i]-$minGraph)*$echelle_y);
		}
	else
		for($i=0; $i<$nombre_releves AND $i<100; $i++)
		{
			$points_poly[$i*2]=floor(60+(465/($nombre_releves-1))*$i);
			$points_poly[$i*2+1]=25+floor(($stats[$i]-$minGraph)*$echelle_y);
		}
	imagesetthickness($image, 3);
	//print_r($points_poly);
	for($n=0; $n<(count($points_poly)-2); $n+=2)
		ImageLine($image, $points_poly[$n], $points_poly[$n+1]-1, $points_poly[$n+2], $points_poly[$n+3]-1, $couleur_contour_graph);
	imagesetthickness($image, 1);
	$points_poly[$i*2]=525;
	$points_poly[$i*2+1]=220;
	$points_poly[$i*2+2]=60;
	$points_poly[$i*2+3]=220;
	//print_r($points_poly);
	
	//AJOUT POLYGONE
	ImageFilledPolygon($image, $points_poly, $nombre_releves+2, $couleur_graphique);
	
	//AJOUT AXE ORDONNEES
	ImageLine($image, 60, 220, 525, 220, $couleur_axe_graphique);
	if(substr_count($affiche,'Points'))
		for($y=25; $y<=220; $y+=(195/$nombre_ligne))
		{
			if($y<200)
			{
				ImageLine($image, 60, $y, 525, $y, $couleur_ligne_graphique);
				ImageLine($image, 60, $y, 66, $y, $couleur_axe_graphique);
			}
			imagettftext($image, 7, 0, 3, $y+4, $couleur_texte, $police_univers, sep($minGraph+((220-$y)/(195/$nombre_ligne))*$diff_entre_2_ligne));
		}
	else
		for($y=220; $y>=25; $y-=(195/$nombre_ligne))
		{
			if($y<200)
			{
				ImageLine($image, 60, $y, 525, $y, $couleur_ligne_graphique);
				ImageLine($image, 60, $y, 66, $y, $couleur_axe_graphique);
			}
			imagestring($image, 1, 3, 240-$y, sep($minGraph+((220-$y)/(195/$nombre_ligne))*$diff_entre_2_ligne), $couleur_texte);
		}
	ImageLine($image, 60, 25, 60, 220, $couleur_axe_graphique);
	
	//AJOUT AXE ABSCISSES
	for($x=60; $x<=526; $x+=(465/($nombre_releves-1))*$intervalDate)
	{
		ImageLine($image, $x, 220, $x, 215, $couleur_axe_graphique);
		$date=date('d-m-Y', mktime(0,0,0,9,23+$dates[floor((($x-60)/(465/$nombre_releves))/1.125)]*7,2009));
		imagettftext($image, 8, 45.0, $x-33, 272, $couleur_texte, $police_texte, $date);
	}
	//AFFICHAGE IMAGE
	imagepng($image);
}
else
	error('#1');
?>
