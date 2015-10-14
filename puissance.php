<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Calculateur de Puissance de Feu</title>
	<?php include('non_accessible/head.php'); ?>
</head>

<body>   
<?php 
include('menu.php');
include('non_accessible/value.php');
include('non_accessible/sep_point.php');
?>
<!-- Le corps -->
<div id="corps"><center><u>Coller ici votre rapport d'espionnage:</u>
<center>
<form method='post' action="puissance.php"> <!--DEBUT DU FORMULAIRE-->
<input type="hidden" name="afficher" />
<input type="hidden" name="mot_de_passe" value="saypab1"/>
<p>
<textarea name="rc" id="rc" cols="75" rows="10" ><?php 
if (isset($_POST['rc']))
{
	$_POST['rc']=stripslashes($_POST['rc']);
	if(substr_count($_POST['rc'], "\r\n\r\n\r\n\r\n")>3)
		$_POST['rc']=str_replace("\r\n\r\n", "\r\n", $_POST['rc']);
	echo $_POST['rc'];
}
?></textarea><br />
	<br />
	<br /><b>Technologies:</b>
	<br /><label for="armement">Amélioration de l'Armement</label> : <input type="text" name="armement" size="3" <?php echo value('armement'); ?> />
	<br /><label for="coque">Amélioration de la Coque</label> : <input type="text" name="coque" size="3" <?php echo value('coque'); ?>/>	
	<br /><label for="boubou">Bouclier de protection</label> : <input type="text" name="boubou" size="3" <?php echo value('boubou'); ?>/>
	<br /><input type="checkbox" name="techno" id="techno" <?php if(isset($_POST['techno'])) echo 'checked="checked"'; ?>/> <label for="techno">Ignorer celles présentes sur le rapport</label><br />
	<br />
	<br /><input type="submit" value="Calculer" />
	
</p>
</form><br />
<table class="resultat">
<?php
$nvx=0;
$ndef=0;
$nombre_def=0;
$num_modele=0;
$attaque_totale=0;
$bouclier_totale=0;
$coque_totale=0;
$vitesse_totale=0;
$attaque_def_totale=0;
$coque_def_totale=0;
$tourdecombat=0;
$canonlaser=0;
$grandcanonlaser=0;
$rayontracteur=0;
$lanceurdemissiles=0;
$satelliteaions=0;
$batterieelectromagnetique=0;
$canonaplasma=0;
$canonelectromagnetique=0;
$silosamissileshem=0;
$complexededefenseorbital=0;
$missiledinterceptionintelligent=0;
$attaquetourdecombat=100;
$attaquecanonlaser=200;
$attaquegrandcanonlaser=450;
$attaquerayontracteur=1000;
$attaquelanceurdemissiles=500;
$attaquesatelliteaions=4400;
$attaquebatterieelectromagnetique=5000;
$attaquecanonaplasma=9500;
$attaquecanonelectromagnetique=13000;
$attaquesilosamissileshem=50000;
$attaquecomplexededefenseorbital=120000;
$attaquemissiledinterceptionintelligent=34000;
$coquetourdecombat=100;
$coquecanonlaser=200;
$coquegrandcanonlaser=500;
$coquerayontracteur=750;
$coquelanceurdemissiles=200;
$coquesatelliteaions=3000;
$coquebatterieelectromagnetique=2900;
$coquecanonaplasma=6500;
$coquecanonelectromagnetique=8500;
$coquesilosamissileshem=50000;
$coquecomplexededefenseorbital=80000;
$coquemissiledinterceptionintelligent=0;
if(isset($_POST['afficher']))
{
	$array = explode('
', $_POST['rc']);
for($len=0; isset($array[$len]); $len++);
for($lv=0; isset($array[$lv]) AND !substr_count($array[$lv],'- Vaisseaux'); $lv++);
for($ld=0; isset($array[$ld]) AND substr_count($array[$ld], '- D')==0 AND substr_count($array[$ld], "fenses")==0; $ld++);
for($lt=0; isset($array[$lt]) AND !substr_count($array[$lt],'- Laboratoire'); $lt++);
if($lt!=$len AND !isset($_POST['techno'])) //S'il y a des technos et que la case "Ignorer celles présentes sur le rapport" n'a pas été coché => rapport
{
	$infos[1]=0;
	for($li=0; isset($array[$li]) AND substr_count($array[$li], 'Armement')==0; $li++);
	if(isset($array[$li]))
		$infos=explode(": ", $array[$li]);
	$niv_armement=$infos[1];
	$infos[1]=0;
	for($li=0; isset($array[$li]) AND substr_count($array[$li], 'lioration de la Coque')==0; $li++);
	if(isset($array[$li]))
		$infos=explode(": ", $array[$li]);
	$niv_coque=$infos[1];
	$infos[1]=0;
	for($li=0; isset($array[$li]) AND substr_count($array[$li], 'Bouclier de Protection')==0; $li++);
	if(isset($array[$li]))
		$infos=explode(": ", $array[$li]);
	$niv_bouclier=$infos[1];
}
else // SINON, on prend le formulaire
{
	$niv_coque=$_POST['coque'];
	$niv_armement=$_POST['armement'];
	$niv_bouclier=$_POST['boubou'];
}
for($ligne=$lv;$ligne<$ld;$ligne++) //VAISSEAUX
{
	if(strlen($array[$ligne])!=strlen(str_replace('(', '', $array[$ligne])))
	{
		$ligne2=$ligne;
		$num_modele++;
		$infos=explode('(', $array[$ligne]);
		${'nom_vaisseau' . $num_modele}=$infos[0];
		${'nbre_vaisseau_type' . $num_modele}=str_replace('.', '', str_replace(' )', '', $infos[1]));
		$nvx += ${'nbre_vaisseau_type' . $num_modele};
		if(substr_count($array[$ligne2+1], 'Attaque')==1)
		{
			$infos=explode(' : ', $array[$ligne2+1]);
			${'attaque' . $num_modele}=str_replace('.', '', $infos[1]);
		}
		else
		{
			$ligne2--;
		}
		if(substr_count($array[$ligne2+2], 'Bouclier')==1)
		{
			$infos=explode(' : ', $array[$ligne2+2]);
			${'bouclier' . $num_modele}=str_replace('.', '', $infos[1]);
		}
		else
		{
			$ligne2--;
		}
		if(substr_count($array[$ligne2+3], 'Coque')==1)
		{
			$infos=explode(' : ', $array[$ligne2+3]);
			${'coque' . $num_modele}=str_replace('.', '', $infos[1]);
		}
		else
		{
			$ligne2--;
		}
		if(substr_count($array[$ligne2+4], 'Vitesse')==1)
		{
			$infos=explode(' : ', $array[$ligne2+4]);
			${'vitesse' . $num_modele}=str_replace('.', '', $infos[1]);
		}
		else
		{
			$ligne2++;
		}
	}
}
echo '<tr class=ligne_titre><td><b>Nom</b></td><td><b>Attaque</b></td><td><b>Bouclier</b></td><td><b>Coque</b></td><td><b>Nombre</b></td></tr>';
for($i=1; $i<=$num_modele; $i++)//AFFICHAGE VAISSEAUX
{
	if(isset(${'attaque' . $i}))
	{
		$attaque_totale+=${'attaque' . $i}*${'nbre_vaisseau_type' . $i};
	}
	else
	{
		${'attaque' . $i}=0;
	}
	if(isset(${'bouclier' . $i}))
	{
		$bouclier_totale+=${'bouclier' . $i}*${'nbre_vaisseau_type' . $i};
	}
	else
	{
		${'bouclier' . $i}=0;
	}
	if(isset(${'coque' . $i}))
	{
		$coque_totale+=${'coque' . $i}*${'nbre_vaisseau_type' . $i};
	}
	else
	{
		${'coque' . $i}=0;
	}
	if(isset(${'vitesse' . $i}))
	{
		if(${'vitesse' . $i}<$vitesse_totale)
		{
			$vitesse_totale=${'vitesse' . $i};
		}
	}
	else
	{
		${'vitesse' . $i}=0;
	}
	echo '<tr class="ligne"><td>' . ${'nom_vaisseau' . $i} . ' </td><td>' . sep(${'attaque' . $i} + (${'attaque' . $i} * 0.1 * $niv_armement)) . ' </td><td>' . sep(${'bouclier' . $i} + (${'bouclier' . $i} * 0.1 * $niv_bouclier)) . ' </td><td>' . sep(${'coque' . $i} + (${'coque' . $i} * 0.1 * $niv_coque)) . ' </td><td>' . sep(${'nbre_vaisseau_type' . $i}) . ' </td></tr>';
}
for($ligne=$ld+1;substr_count($array[$ligne], ':')==1;$ligne++)//DEFENSE
{
	$array2=explode(':', $array[$ligne]);
	$def=str_replace('é', 'e', $array2[0]);
	$def=str_replace('à', 'a', $def);
	$def=str_replace('\'', '', $def);
	$def=str_replace(' ', '', $def);
	$def=strtolower($def);
	$ndef=str_replace('.', '', $array2[1]);
	${$def}=${$def}+$ndef;
	$nombre_def+=$ndef;
	echo '<tr class="ligne"><td>' . $array2[0] . ' </td><td>' . sep(${'attaque' . $def} + (${'attaque' . $def} * 0.1 * $niv_armement)) . ' </td><td>0 </td><td>' . sep(${'coque' . $def} + (${'coque' . $def} * 0.1 * $niv_coque)) . ' </td><td>' . sep(${$def}) . ' </td></tr>';
}
$attaque_def_totale=$tourdecombat*100+$canonlaser*200+$grandcanonlaser*450+$rayontracteur*1000+$lanceurdemissiles*500+$satelliteaions*4400+$batterieelectromagnetique*5000+$canonaplasma*9500+$canonelectromagnetique*13000+$silosamissileshem*50000+$complexededefenseorbital*120000+$missiledinterceptionintelligent*34000;
$coque_def_totale=$tourdecombat*100+$canonlaser*200+$grandcanonlaser*500+$rayontracteur*750+$lanceurdemissiles*200+$satelliteaions*3000+$batterieelectromagnetique*2900+$canonaplasma*6500+$canonelectromagnetique*8500+$silosamissileshem*50000+$complexededefenseorbital*80000;
$attaque_totaux = $attaque_totale + ($attaque_totale * 0.1 * $niv_armement) + $attaque_def_totale + ($attaque_def_totale * 0.1 * $niv_armement);
$bouclier_totaux = $bouclier_totale + ($bouclier_totale * 0.1 * $niv_bouclier);
$coque_totaux = $coque_totale + ($coque_totale * 0.1 * $niv_coque) + $coque_def_totale + ($coque_def_totale * 0.1 * $niv_coque);
//*
echo '<tr class="ligne_total"><td><b>Total </b></td><td><b>' . sep(ceil($attaque_totaux)) . '</b> </td><td><b>' . sep(ceil($bouclier_totaux)) . '</b> </td><td><b>' . sep(ceil($coque_totaux)) . '</b> </td><td><b>' . sep(($nvx+$nombre_def)) . '</b> (' . sep(($nvx+$nombre_def-$missiledinterceptionintelligent)) . ')</td></tr>\n';
echo '<tr class="ligne_sous_total"><td><i>Vaisseaux</i></td><td><i>' . sep(ceil($attaque_totale + ($attaque_totale * 0.1 * $niv_armement))) . '</i></td><td><i>' . sep(ceil($bouclier_totale + ($bouclier_totale * 0.1 * $niv_bouclier))) . '</i></td><td><i>' . sep(ceil($coque_totale  + ($coque_totale * 0.1 * $niv_coque))) . '</i></td><td><i>' . sep($nvx) . '</i></td></tr>\n';
echo '<tr class="ligne_sous_total"><td><i>Défenses</i></td><td><i>' . sep(ceil($attaque_def_totale  + ($attaque_def_totale * 0.1 * $niv_armement))) . '</i></td><td><i>0</i></td><td><i>' . sep(ceil($coque_def_totale  + ($coque_def_totale * 0.1 * $niv_coque))) . '</i></td><td><i>' . sep($nombre_def) . '</i> (' . sep($nombre_def-$missiledinterceptionintelligent) . ')</td></tr>\n';
echo '</table><br />';

if($niv_armement != '' AND $niv_coque != '' AND $niv_bouclier != '')
{
	echo '<b><u>Technologies</u></b> : Armement: ' . $niv_armement . ' Coque: ' . $niv_coque . ' Bouclier: ' . $niv_bouclier;
}
else
{
	echo 'Une ou plusieurs technologie(s) n\'ont pas été détectées.';
}
?>
</center>
<?php
}
?>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>
