<?php
//print_r($_SERVER);
header("Content-type: image/png");
include('non_accessible/sep_point.php');
function error($errorId, $week=NULL)
{
	//CREATION IMAGE
	//DEFINITION COULEURS ET POLICE
	if($couleur=='rouge')
	{
		$image = imagecreatefrompng("images/fond_sign.png");
		//DEFINITION COULEURS ET POLICE
		$couleur_texte=imagecolorallocate($image, 255, 255, 255);
		$couleur_cadre=imagecolorallocate($image, 0, 0, 0);
		$couleur_titre=imagecolorallocate($image, 255, 255, 255);
		$couleur_joueur=imagecolorallocate($image, 91, 176, 0);
		$couleur_alliance=imagecolorallocate($image, 152, 162, 198);
		$couleur_uni=imagecolorallocate($image, 240, 130, 0);
		$couleur_sign=imagecolorallocate($image, 0, 0, 0);
		$couleur_parentheses=imagecolorallocate($image, 255, 210, 185);
		$couleur_classement=imagecolorallocate($image, 255, 100, 60);
	}
	else
	{
		$image = imagecreatefrompng("images/fond_sign2.png");
		//DEFINITION COULEURS ET POLICE
		$couleur_texte=imagecolorallocate($image, 255, 255, 255);
		$couleur_cadre=imagecolorallocate($image, 0, 0, 0);
		$couleur_titre=imagecolorallocate($image, 255, 255, 255);
		$couleur_joueur=imagecolorallocate($image, 255, 70, 80);
		$couleur_alliance=imagecolorallocate($image, 120, 180, 240);
		$couleur_uni=imagecolorallocate($image, 0, 150, 0);
		$couleur_sign=imagecolorallocate($image, 0, 0, 0);
		$couleur_parentheses=imagecolorallocate($image, 170, 181, 231);
		$couleur_classement=imagecolorallocate($image, 120, 180, 240);
	}
	$police_texte = 'non_accessible/tahoma.ttf';
	//AJOUT TITRE
	imagettftext($image, 9, 0.0, 35, 15, $couleur_titre, $police_texte, "Joueur: ");
	imagettftext($image, 9, 0.0, 80, 15, $couleur_joueur, $police_texte, $_GET['joueur']);
	imagettftext($image, 9, 0.0, 185, 15, $couleur_titre, $police_texte, "Alliance: ");
	imagettftext($image, 9, 0.0, 236, 15, $couleur_alliance, $police_texte, "Inconnue");
	imagettftext($image, 9, 0.0, 330, 15, $couleur_titre, $police_texte, "Univers : ");
	imagettftext($image, 9, 0.0, 383, 14, $couleur_uni, $police_texte, "[" . ucfirst($_GET['univers']) . "]");
	//AJOUT MSG ERREUR
	imagestring($image, 4, 110, 27, utf8_decode("Impossible de générer les stats."), $couleur_texte);
	//imagestring($image, 2, 160, 35, utf8_decode("Cause du problème:"), $couleur_texte);
	if($errorId=='#1')
		imagestring($image, 4, 134, 42, utf8_decode("Erreur " . $errorId . ": Univers inconnu."), $couleur_texte);
	elseif($errorId=='#2')
		imagestring($image, 4, 134, 42, utf8_decode("Erreur " . $errorId . ": Joueur inconnu."), $couleur_texte);
	elseif($errorId=='#3')
		imagestring($image, 4, 40, 42, utf8_decode("Erreur " . $errorId . ": Le dernier relevé date du " . date('d-m-Y', mktime(0,0,0,02,24+$week*7,10))), $couleur_texte);
	//AFFICHAGE IMAGE
	$couleur_fond=imagecolorallocate($image, 228, 234, 242);
	imagepng($image);
}

$couleur=($_GET['couleur']) ? 'bleu' : 'rouge';
if(in_array($_GET['univers'], array('Alpha', 'Pegase', 'Orion', 'Ida', 'Eridan', 'Centaure', 'Taurus')))
{
	//DONNEES
	$player=htmlspecialchars($_GET['joueur']);
	$uni=strtolower($_GET['univers']);
	$uniName=ucfirst(str_replace("Pegase", "Pégase", $uni));
	
	include('non_accessible/connect.php');
	$queryDate="SELECT MAX(week) AS dateMax FROM " . $uni . "Players";
	$retourDate=$sql->query($queryDate);
	$dateMax=$retourDate->fetch();
	$dateMax=$dateMax['dateMax'];
	$retourDate->closeCursor();

	$query="SELECT * FROM " . $uni . "Players WHERE pseudo='" . $player . "' ORDER BY week DESC LIMIT 1";
	//echo $query . '<br/>';
	$retour=$sql->query($query);
	$dataPlayer=$retour->fetch();
	$retour->closeCursor();
	
	if($dataPlayer['generalPoints']<1) error('#2');
//	echo $dataPlayer['week'] . ' ' . $dataPlayer['dateMax'] . '<br />';
	if($dataPlayer['week']!=$dateMax) error('#3', $dataPlayer['week']);

	
	$queryAlly="SELECT tag FROM " . $uni . "AllysList WHERE idAlly='" . $dataPlayer['idAlly'] . "' LIMIT 1";
	$retourAlly=$sql->query($queryAlly);
	$dataAlly=$retourAlly->fetch();
	$retourAlly->closeCursor();
	
	
	//CREATION IMAGE
	if($couleur=='rouge')
	{
		$image = imagecreatefrompng("images/fond_sign.png");
		//DEFINITION COULEURS ET POLICE
		$couleur_texte=imagecolorallocate($image, 255, 255, 255);
		$couleur_cadre=imagecolorallocate($image, 0, 0, 0);
		$couleur_titre=imagecolorallocate($image, 255, 255, 255);
		$couleur_joueur=imagecolorallocate($image, 91, 176, 0);
		$couleur_alliance=imagecolorallocate($image, 152, 162, 198);
		$couleur_uni=imagecolorallocate($image, 240, 130, 0);
		$couleur_sign=imagecolorallocate($image, 0, 0, 0);
		$couleur_parentheses=imagecolorallocate($image, 255, 210, 185);
		$couleur_classement=imagecolorallocate($image, 255, 100, 60);
	}
	else
	{
		$image = imagecreatefrompng("images/fond_sign2.png");
		//DEFINITION COULEURS ET POLICE
		$couleur_texte=imagecolorallocate($image, 255, 255, 255);
		$couleur_cadre=imagecolorallocate($image, 0, 0, 0);
		$couleur_titre=imagecolorallocate($image, 255, 255, 255);
		$couleur_joueur=imagecolorallocate($image, 255, 70, 80);
		$couleur_alliance=imagecolorallocate($image, 120, 180, 240);
		$couleur_uni=imagecolorallocate($image, 0, 150, 0);
		$couleur_sign=imagecolorallocate($image, 0, 0, 0);
		$couleur_parentheses=imagecolorallocate($image, 170, 181, 231);
		$couleur_classement=imagecolorallocate($image, 120, 180, 240);
	}
	$police_texte = 'non_accessible/tahoma.ttf';
	$police_texte_gras = 'non_accessible/tahomabd.ttf';
	//AJOUT TITRE
	imagettftext($image, 9, 0.0, 35, 15, $couleur_titre, $police_texte, "Joueur: ");
	imagettftext($image, 9, 0.0, 80, 14, $couleur_joueur, $police_texte_gras, $player);
	imagettftext($image, 9, 0.0, 185, 15, $couleur_titre, $police_texte, "Alliance: ");
	imagettftext($image, 9, 0.0, 236, 14, $couleur_alliance, $police_texte_gras, $dataAlly['tag']);
	imagettftext($image, 9, 0.0, 330, 15, $couleur_titre, $police_texte, "Univers : ");
	imagettftext($image, 9, 0.0, 383, 14, $couleur_uni, $police_texte_gras, "[" . ucfirst($uni) . "]");
	imagettftext($image, 9, 0.0, 15, 32, $couleur_titre, $police_texte, "Général:");
	imagettftext($image, 9, 0.0, 15, 48, $couleur_titre, $police_texte, "Batiment:");
	imagettftext($image, 9, 0.0, 15, 64, $couleur_titre, $police_texte, "Techno:");
	imagettftext($image, 9, 0.0, 215, 32, $couleur_titre, $police_texte, "Flotte:");
	imagettftext($image, 9, 0.0, 215, 48, $couleur_titre, $police_texte, "Défense:");
	imagettftext($image, 9, 0.0, 215, 64, $couleur_titre, $police_texte, "App. Spé:");
	if($dataPlayer['generalRank']!=65535)
	{
		$points=imagettftext($image, 10, 0.0, 75, 32, $couleur_classement, $police_texte, sep($dataPlayer['generalRank']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, " (");
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+10, $couleur_parentheses, $police_texte, sep($dataPlayer['generalPoints']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, ")");
	}
	else
	{
		$points=imagettftext($image, 10, 0.0, 75, 32, $couleur_classement, $police_texte, "Inconnu");
	}
	if($dataPlayer['batimentsRank']!=65535)
	{
		$points=imagettftext($image, 10, 0.0, 75, 48, $couleur_classement, $police_texte, sep($dataPlayer['batimentsRank']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, " (");
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+10, $couleur_parentheses, $police_texte, sep($dataPlayer['batimentsPoints']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, ")");
	}
	else
	{
		$points=imagettftext($image, 10, 0.0, 75, 48, $couleur_classement, $police_texte, "Inconnu");
	}
	if($dataPlayer['technologiesRank']!=65535)
	{
		$points=imagettftext($image, 10, 0.0, 75, 64, $couleur_classement, $police_texte, sep($dataPlayer['technologiesRank']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, " (");
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+10, $couleur_parentheses, $police_texte, sep($dataPlayer['technologiesPoints']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, ")");
	}
	else
	{
		$points=imagettftext($image, 10, 0.0, 75, 64, $couleur_classement, $police_texte, "Inconnu");
	}
	if($dataPlayer['flottesRank']!=65535)
	{
		$points=imagettftext($image, 10, 0.0, 275, 32, $couleur_classement, $police_texte, sep($dataPlayer['flottesRank']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, " (");
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+10, $couleur_parentheses, $police_texte, sep($dataPlayer['flottesPoints']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, ")");
	}
	else
	{
		$points=imagettftext($image, 10, 0.0, 275, 32, $couleur_classement, $police_texte, "Inconnu");
	}
	if($dataPlayer['DefensesRank']!=65535)
	{
		$points=imagettftext($image, 10, 0.0, 275, 48, $couleur_classement, $police_texte, sep($dataPlayer['DefensesRank']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, " (");
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+10, $couleur_parentheses, $police_texte, sep($dataPlayer['DefensesPoints']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, ")");
	}
	else
	{
		$points=imagettftext($image, 10, 0.0, 275, 48, $couleur_classement, $police_texte, "Inconnu");
	}
	if($dataPlayer['AppareilsRank']!=65535)
	{
		$points=imagettftext($image, 10, 0.0, 275, 64, $couleur_classement, $police_texte, sep($dataPlayer['AppareilsRank']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, " (");
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+10, $couleur_parentheses, $police_texte, sep($dataPlayer['AppareilsPoints']));
		$points=imagettftext($image, 10, 0.0, $points[2], $points[5]+8, $couleur_parentheses, $police_texte, ")");
	}
	else
	{
		$points=imagettftext($image, 10, 0.0, 275, 64, $couleur_classement, $police_texte, "Inconnu");
	}
		
	//AFFICHAGE IMAGE
	imagepng($image);
}
else
	error('#1');
?>
