<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Analyseur de rapports de combats par Portail</title>
	<?php include('non_accessible/head.php'); ?>
</head>

<body>   
<?php 
include('menu.php');
include('non_accessible/value.php');
include('non_accessible/sep_point.php');
?>
<!-- Le corps -->
<div id="corps"><div style="text-align:center"><h2>Analyseur de RC par Portail</h2>
<div style="background-color:#323232; color:#aaaaaa"><u>Prend en compte:</u><br />
- Mission vol de ressources chez un ennemi<br />
- Mission vol de ressources d'un ennemi<br />
- Kidnapping chez un ennemi<br />
- Kidnapping d'un ennemi<br />
- Assassinat chez un ennemi<br />
</div><br />
<u>Coller ici vos rapports de combat par porte:</u>
<form method='post' action="analyseur_pde.php"> <!--DEBUT DU FORMULAIRE-->
<input type="hidden" name="afficher" />
<p>
<textarea name="rc" id="rc" cols="75" rows="10" ><?php 
if (isset($_POST['rc']))
{
	echo $_POST['rc'];
}
?></textarea>
	<br />
	<br />
	<input type="submit" value="OK" />
</p>
</form></div>
<?php
if(isset($_POST['rc']))
{
	// DONNEES
	$rapport=explode("\n", $_POST['rc']);
	// STATS
	$date_deb=0;
	$date_fin=0;
	$nombre_attaque_envoyees=0;
	$nombre_attaque_recues=0;
	$vol_ressou_envoyes=0;
	$vol_ressou_recus=0;
	$kidnapping_envoyes=0;
	$kidnapping_recus=0;
	$assassinat_envoyes=0;
	$fer_vol=0;
	$or_vol=0;
	$cri_vol=0;
	$hyd_vol=0;
	$soldats_vol=0;
	$colonels_vol=0;
	$techniciens_vol=0;
	$experts_vol=0;
	$espions_vol=0;
	$kamikazes_vol=0;
	$soldats_ass=0;
	$colonels_ass=0;
	$techniciens_ass=0;
	$experts_ass=0;
	$espions_ass=0;
	$kamikazes_ass=0;
	$fer_per=0;
	$or_per=0;
	$cri_per=0;
	$hyd_per=0;
	$soldats_per=0;
	$colonels_per=0;
	$techniciens_per=0;
	$experts_per=0;
	$espions_per=0;
	$kamikazes_per=0;
	$nombre_attaque_non_reconnues=0;
	$titre_attaque_non_reconnues='';
	$titre_attaque_recues='';
	// VARIABLE SERVANT A L'ANALYSE
	$attaque_sur_joueur=0; //vaudra 0 si c'est le joueur qui a attaqué et 1 si c'est le joueur qui a été attaqué
	$volde=0;
	$perde=0;
	$nombre_ligne=count($rapport);
	for($i=0; $i<$nombre_ligne; $i++)
	{
		if(substr_count($rapport[$i],'Mission'))
		{
			$date=preg_replace('#([0-9]{2}/[0-9]{2}/[0-9]{4} [0-9]{2}:[0-9]{2}:[0-9]{2}).+#', '$1', $rapport[$i]);
			if($date_fin==0)
				$date_fin=$date;
			$date_deb=$date;
			$attaque_sur_joueur=0;
			if(substr_count($rapport[$i],'Mission vol de ressources'))
				$vol_ressou_envoyes++;
			elseif(substr_count($rapport[$i],'Mission Kidnapping'))
				$kidnapping_envoyes++;
			elseif(substr_count($rapport[$i],'Mission Assassinat'))
				$assassinat_envoyes++;
			else
			{
				$nombre_attaque_non_reconnues++;
				$titre_attaque_non_reconnues.=$rapport[$i] . "<br />\n";
			}
			$nombre_attaque_envoyees++;
		}
		if(substr_count($rapport[$i],'Activation non'))
		{
			$date=preg_replace('#([0-9]{2}/[0-9]{2}/[0-9]{4} [0-9]{2}:[0-9]{2}:[0-9]{2}).+#', '$1', $rapport[$i]);
			if($date_fin==0)
				$date_fin=$date;
			$date_deb=$date;
			$attaque_sur_joueur=1;
			$nombre_attaque_recues++;
			if(!(substr_count($rapport[$i+4],'kidnapping')) AND !(substr_count($rapport[$i+4], 'vol de ressources')))
				$titre_attaque_recues.=$rapport[$i+4] . "<br />\n";
		}
		if(substr_count($rapport[$i],'On vous à volé :'))
		{
			$perde=1;
			$vol_ressou_recus++;
		}
		elseif(substr_count($rapport[$i],'Fer : ') AND $perde==1)
			$fer_per+=str_replace('.', '', str_replace('Fer : ', '', $rapport[$i]));
		elseif(substr_count($rapport[$i],'Or : ') AND $perde==1)
			$or_per+=str_replace('.', '', str_replace('Or : ', '', $rapport[$i]));
		elseif(substr_count($rapport[$i],'Cristal : ') AND $perde==1)
			$cri_per+=str_replace('.', '', str_replace('Cristal : ', '', $rapport[$i]));
		elseif(substr_count($rapport[$i],'Hydrogène : ') AND $perde==1)
			$hyd_per+=str_replace('.', '', str_replace('Hydrogène : ', '', $rapport[$i]));
		else
			$perde=0;
		if(substr_count($rapport[$i],'Vol de :'))
			$volde=1;
		elseif(substr_count($rapport[$i],'Fer : ') AND $volde==1)
			$fer_vol+=str_replace('.', '', str_replace('Fer : ', '', $rapport[$i]));
		elseif(substr_count($rapport[$i],'Or : ') AND $volde==1)
			$or_vol+=str_replace('.', '', str_replace('Or : ', '', $rapport[$i]));
		elseif(substr_count($rapport[$i],'Cristal : ') AND $volde==1)
			$cri_vol+=str_replace('.', '', str_replace('Cristal : ', '', $rapport[$i]));
		elseif(substr_count($rapport[$i],'Hydrogène : ') AND $volde==1)
			$hyd_vol+=str_replace('.', '', str_replace('Hydrogène : ', '', $rapport[$i]));
		else
			$volde=0;
		if(substr_count($rapport[$i],'Perte de :') AND $attaque_sur_joueur)
		{
			$array=explode(' ', $rapport[$i]);
			${strtolower($array[4]) . '_per'}+=$array[3];
			$kidnapping_recus++;
		}
		if(substr_count($rapport[$i],'Kidnapping de : '))
		{
			$array=explode(' ', $rapport[$i]);
			${strtolower($array[4]) . '_vol'}+=$array[3];
		}
		if(substr_count($rapport[$i],'Assassinat de : '))
		{
			$array=explode(' ', $rapport[$i]);
			${strtolower($array[4]) . '_ass'}+=$array[3];
		}
	}
	if($nombre_attaque_recues OR $nombre_attaque_envoyees OR $nombre_attaque_recues)
	{
		echo 'Vous avez ';
		if($nombre_attaque_envoyees)
			echo 'envoyé <span class="plus">' . $nombre_attaque_envoyees . ' missions</span>';
		if($nombre_attaque_recues AND $nombre_attaque_envoyees)
			echo ' et ';
		if($nombre_attaque_recues)
			echo 'reçu <span class="moins">' . $nombre_attaque_recues . ' attaques</span>';
		echo ' du ' . $date_deb . ' au ' . $date_fin . '<br />';
		if($nombre_attaque_envoyees)
		{
			echo '<h4>Missions envoyées :</h4>';
			if($fer_vol+$or_vol+$cri_vol+$hyd_vol)
			{
				echo '<u>Vous avez envoyé ' . $vol_ressou_envoyes . ' mission(s) de vol de ressource:</u><br /><br />';
				echo 'Vol de :<br />';
				echo 'Fer : ' . sep($fer_vol) . '<br />';
				echo 'Or : ' . sep($or_vol) . '<br />';
				echo 'Cristal : ' . sep($cri_vol) . '<br />';
				echo 'Hydrogène : ' . sep($hyd_vol) . '<br />';
				echo 'Valeur Fer : ' . sep($fer_vol+$or_vol*1.25+$cri_vol*2.5+$hyd_vol*5) . '<br />';
				echo '<br />';
				echo '<br />';
			}
			if($kidnapping_envoyes)
			{
				echo '<u>Vous avez envoyé ' . $kidnapping_envoyes . ' mission(s) de kidnapping:</u><br /><br />';
				echo 'Kidnapping de : ';
				if($soldats_vol)
					echo sep($soldats_vol) . ' soldats';
				if($colonels_vol)
					echo ' ' . sep($colonels_vol) . ' colonels';
				if($techniciens_vol)
					echo ' ' . sep($techniciens_vol) . ' techniciens';
				if($experts_vol)
					echo ' ' . sep($experts_vol) . ' experts';
				if($espions_vol)
					echo ' ' . sep($espions_vol) . ' espions';
				if($kamikazes_vol)
					echo ' ' . sep($kamikazes_vol) . ' kamikazes';
				echo '<br />';
				echo '<br />';
			}
			if($assassinat_envoyes)
			{
				echo '<u>Vous avez envoyé ' . $assassinat_envoyes . ' mission(s) d\'assassinat:</u><br /><br />';
				echo 'Assassinat de : ';
				if($soldats_ass)
					echo sep($soldats_ass) . ' soldats';
				if($colonels_ass)
					echo ' ' . sep($colonels_ass) . ' colonels';
				if($techniciens_ass)
					echo ' ' . sep($techniciens_ass) . ' techniciens';
				if($experts_ass)
					echo ' ' . sep($experts_ass) . ' experts';
				if($espions_ass)
					echo ' ' . sep($espions_ass) . ' espions';
				if($kamikazes_ass)
					echo ' ' . sep($kamikazes_ass) . ' kamikazes';
				echo '<br />';
				echo '<br />';
			}
		}
		if($nombre_attaque_recues)
		{
			echo '<h4>Attaques reçues :</h4>';
			if($fer_per+$or_per+$cri_per+$hyd_per)
			{
				echo '<u>Vous avez reçus ' . $vol_ressou_recus . ' mission(s) de vol de ressource:</u><br /><br />';
				echo 'On vous a volé :<br />';
				echo 'Fer : ' . sep($fer_per) . '<br />';
				echo 'Or : ' . sep($or_per) . '<br />';
				echo 'Cristal : ' . sep($cri_per) . '<br />';
				echo 'Hydrogène : ' . sep($hyd_per) . '<br />';
				echo 'Valeur Fer : ' . sep($fer_per+$or_per*1.25+$cri_per*2.5+$hyd_per*5) . '<br />';
				echo '<br />';
			}
			if($kidnapping_recus)
			{
				echo '<u>Vous avez subit ' . $kidnapping_recus . ' mission(s) de kidnapping:</u><br /><br />';
				echo 'Kidnapping de : ';
				if($soldats_per)
					echo sep($soldats_per) . ' soldats';
				if($colonels_per)
					echo ' ' . sep($colonels_per) . ' colonels';
				if($techniciens_per)
					echo ' ' . sep($techniciens_per) . ' techniciens';
				if($experts_per)
					echo ' ' . sep($experts_per) . ' experts';
				if($espions_per)
					echo ' ' . sep($espions_per) . ' espions';
				if($kamikazes_per)
					echo ' ' . sep($kamikazes_per) . ' kamikazes';
				echo '<br />'.'<br />';
			}
			echo  str_replace('Vous avez subit une mission de ', '', $titre_attaque_recues);
		}
		if($nombre_attaque_non_reconnues)
		{
			echo '<br />';
			echo '<u>' . $nombre_attaque_non_reconnues . ' mission(s) n\'a/n\'ont pas été reconnue(s) par l\'analyseur:</u><br /><br />';
			echo $titre_attaque_non_reconnues . '<br />';
			echo 'Merci d\'envoyer, si possible, un rapport pour chaque type de mission non reconnues à tools4origins@gmail.com, afin que nous corrigions ce problème au plus vite :).<br />';
			$monfichier = fopen('rapport.txt', 'a+');
				fputs($monfichier, "---------------------------------------------------------------" . "\n" . $titre_attaque_non_reconnues);
				fclose($monfichier);
		}
	}
}
?>
</div>
</body>
</html>
<?php
include('non_accessible/pub.php');
?>