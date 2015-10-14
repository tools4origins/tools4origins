<?php
header("Content-type: image/png");
include('non_accessible/sep_point.php');
$problemes=0;
//DONNEES
if(isset($_GET['cle']))
{
	$fichier = fopen('non_accessible/raid.txt', 'r');
	$fichier = fread($fichier, filesize('non_accessible/raid.txt'));
	$fichier = explode("\n", $fichier);
	preg_match_all("#[0-9]#", $_GET['cle'], $res);
	preg_match_all("#[a-zA-Z]#", $_GET['cle'], $car);
	if(count($res[0])==4 AND count($car[0])==4)
	{
		$ligne = $res[0][0]*1000 + $res[0][1]*100 + $res[0][2]*10 + $res[0][3];
		$cle = $car[0][0] . $car[0][1] . $car[0][2] . $car[0][3];
		if($ligne<count($fichier))
			if(!isset($_GET['nombre']))
			{
				//echo $ligne . ':' . $fichier[$ligne-1] . '-' . $cle;
				if(substr_count($fichier[$ligne-1], $cle))
				{
					$array = explode('/', $fichier[$ligne-1]);
					$nombre = $array[2];
				}
				else
					$problemes=1;
			}
			else
				$nombre = $_GET['nombre'];
		else
			$problemes = 1;
	}
	else
		$problemes = 1;
}
else
{
	$problemes = 1;
}

if($problemes == 0)
{
	//CREATION IMAGE
//	$image = imagecreate(340,28);
	$image = imagecreatefrompng("images/raid.png");
	//DEFINITION COULEURS ET POLICE
	$couleur_fond=imagecolorallocate($image, 0, 0, 0);
	$couleur_texte=imagecolorallocate($image, 255, 255, 255);
	$couleur_nombre=imagecolorallocate($image, 243, 197, 43);
	$police_texte = 'non_accessible/tahoma.ttf';
	$police_texte_gras = 'non_accessible/tahomabd.ttf';
	$point=imagettftext($image, 10, 0.0, 90-strlen($nombre)*4, 18, $couleur_texte, $police_texte_gras, 'Je raide ');
	$point=imagettftext($image, 10, 0.0, $point[2], 18, $couleur_nombre, $police_texte_gras, $nombre);
	$point=imagettftext($image, 10, 0.0, $point[2], 18, $couleur_texte, $police_texte_gras, ' VF/s...');
	$point=imagettftext($image, 10, 0.0, $point[2]+10, 18, $couleur_texte, $police_texte_gras, 'Et vous?');
	//AFFICHAGE IMAGE
	imagepng($image);
}

if($problemes==1)
{
		//CREATION IMAGE
		$image = imagecreate(340,28);
		//DEFINITION COULEURS ET POLICE
		$couleur_fond=imagecolorallocate($image, 0, 0, 0);
		$couleur_texte=imagecolorallocate($image, 255, 255, 255);
		$police_texte = 'non_accessible/tahoma.ttf';
		$police_texte_gras = 'non_accessible/tahomabd.ttf';
		//AJOUT MSG ERREUR
		imagettftext($image, 10, 0.0, 60, 18, $couleur_texte, $police_texte_gras, 'Impossible de générer l\'image.');
		//AFFICHAGE IMAGE
		$couleur_fond=imagecolorallocate($image, 228, 234, 242);
		imagepng($image);
}
?>
