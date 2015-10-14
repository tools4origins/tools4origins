<?php
header("Content-type: image/png");
include('non_accessible/sep_point.php');
include('non_accessible/connect.php');
$nombre['nbre']='?';
$problemes=0;

//$problemes=1;
///*

if($_GET['univers']!='Alpha' AND $_GET['univers']!='Pegase' AND $_GET['univers']!='Orion' AND $_GET['univers']!='Ida' AND $_GET['univers']!='Eridan' AND $_GET['univers']!='Centaure' AND $_GET['univers']!='Taurus')
{
	$problemes=1;
}
else
{
	//DONNEES
	$_GET['joueur']=htmlspecialchars($_GET['joueur']);
	$_GET['univers']=htmlspecialchars(strtolower($_GET['univers']));
	$joueur=$_GET['joueur'];
	$uni=ucfirst($_GET['univers']);
	$uni=str_replace("Pegase", "Pégase", $_GET['univers']);
	$query="SELECT COUNT(*) AS nbre FROM univers_" . strtolower($_GET['univers']) . " WHERE joueur = '" . $_GET['joueur'] . "'";
	$retour=$sql->query($query);
	$nombre=$retour->fetch();
	if($nombre['nbre']>0)
	{
		$plapla=$sql->query("SELECT * FROM univers_" . strtolower($_GET['univers']) . " WHERE joueur = '" . $_GET['joueur'] . "'");
	}
	else
		$problemes=1;
	if($problemes==0)
	{
		//CREATION IMAGE
		$image = imagecreatefrompng("images/fond_planetes.png");
		//DEFINITION COULEURS ET POLICE
		$couleur_titre=imagecolorallocate($image, 255, 255, 255);
		$couleur_coos=imagecolorallocate($image, 255, 255, 255);
		$couleur_joueur=imagecolorallocate($image, 91, 176, 0);
		$couleur_alliance=imagecolorallocate($image, 152, 162, 198);
		$couleur_nombre=imagecolorallocate($image, 252, 122, 168);
		$couleur_uni=imagecolorallocate($image, 240, 130, 0);
		$couleur_sign=imagecolorallocate($image, 255, 255, 255);
		$police_texte = 'non_accessible/tahoma.ttf';
		$police_texte_gras = 'non_accessible/tahomabd.ttf';
		//AJOUT TITRE
		imagettftext($image, 8, 0.0, 15, 15, $couleur_titre, $police_texte_gras, "Joueur : ");
		imagettftext($image, 8, 0.0, 65, 15, $couleur_joueur, $police_texte_gras, $joueur);
		imagettftext($image, 8, 0.0, 155, 15, $couleur_titre, $police_texte_gras, "Alliance : ");
		imagettftext($image, 8, 0.0, 350, 15, $couleur_titre, $police_texte_gras, "Planètes : ");
		imagettftext($image, 8, 0.0, 410, 15, $couleur_nombre, $police_texte_gras, $nombre['nbre']);
		imagettftext($image, 8, 0.0, 435, 15, $couleur_titre, $police_texte_gras, "Univers : ");
		imagettftext($image, 8, 0.0, 485, 15, $couleur_uni, $police_texte_gras, "[" . ucfirst($uni) . "]");
		//AJOUT PLAPLA
		$x=10;
		$y=0;
		while($coos=$plapla->fetch())
		{
			imagettftext($image, 10, 0.0, $x%540+8, 37+(4*($y-($y%6))), $couleur_coos, $police_texte, $coos['galaxie'] . " " . $coos['systeme'] . " " . $coos['position']);
			$y+=1;
			$x+=90;
			$alliance=$coos['alliance'];
		}
		imagettftext($image, 8, 0.0, 210, 15, $couleur_alliance, $police_texte_gras, $alliance);
		//AFFICHAGE IMAGE
		imagepng($image);
	}
}
if($problemes==1)
{
	//*/
		//CREATION IMAGE
		$image = imagecreatefrompng("images/fond_planetes.png");
		//DEFINITION COULEURS ET POLICE
		$couleur_fond=imagecolorallocate($image, 228, 234, 242);
		$couleur_fond_graphique=imagecolorallocate($image, 206, 212, 223);
		$couleur_texte=imagecolorallocate($image, 255, 255, 255);
		$couleur_cadre=imagecolorallocate($image, 0, 0, 0);
		$couleur_titre=imagecolorallocate($image, 255, 255, 255);
		$couleur_joueur=imagecolorallocate($image, 91, 176, 0);
		$couleur_alliance=imagecolorallocate($image, 152, 162, 198);
		$couleur_nombre=imagecolorallocate($image, 252, 122, 168);
		$couleur_uni=imagecolorallocate($image, 240, 130, 0);
		$couleur_sign=imagecolorallocate($image, 255, 255, 255);
		$police_texte = 'non_accessible/GeosansLight.ttf';
		$police_texte_gras = 'non_accessible/tahomabd.ttf';
		//AJOUT TITRE
		imagettftext($image, 9, 0.0, 15, 16, $couleur_titre, $police_texte_gras, "Planetes du joueur : ");
		imagettftext($image, 8, 0.0, 143, 16, $couleur_joueur, $police_texte_gras, $_GET['joueur']);
		imagettftext($image, 9, 0.0, 220, 16, $couleur_titre, $police_texte_gras, "Alliance : ");
		imagettftext($image, 9, 0.0, 340, 16, $couleur_titre, $police_texte_gras, "Nombre : ");
		imagettftext($image, 9, 0.0, 400, 16, $couleur_nombre, $police_texte_gras, $nombre['nbre']);
		imagettftext($image, 9, 0.0, 422, 16, $couleur_titre, $police_texte_gras, "Univers : ");
		imagettftext($image, 8, 0.0, 480, 15, $couleur_uni, $police_texte_gras, "[" . ucfirst($_GET['univers']) . "]");
		//AJOUT CADRE
		ImageLine ($image, 0, 0, 0, 89, $couleur_cadre);
		ImageLine ($image, 0, 89, 539, 89, $couleur_cadre);
		ImageLine ($image, 539, 0, 539, 89, $couleur_cadre);
		ImageLine ($image, 0, 0, 539, 0, $couleur_cadre);
		//AJOUT MSG ERREUR
//		imagestring($image, 4, 140, 27, "Suppression de la cartographie.", $couleur_texte);
//		imagestring($image, 2, 180, 42, "Plus d'informations sur le site", $couleur_texte);
		imagestring($image, 4, 120, 20, utf8_decode("Impossible de générer les stats."), $couleur_texte);
		imagestring($image, 2, 160, 35, utf8_decode("Cause probable du probleme:"), $couleur_texte);
		imagestring($image, 2, 160, 45, utf8_decode("-Lien érroné."), $couleur_texte);
		imagestring($image, 2, 160, 55, utf8_decode("-Joueur inexistant."), $couleur_texte);//*/
		//AFFICHAGE IMAGE
		$couleur_fond=imagecolorallocate($image, 228, 234, 242);
		imagepng($image);
}

?>
