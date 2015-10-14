<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Simulateur de combat spatial</title>
	<?php include('non_accessible/head.php'); ?>
</head>

<body>
   
<?php 
include('menu.php');
include('non_accessible/sep_point.php');
?>
<!-- Le corps -->
<div id="corps"><div style="text-align:center"><h2>Simulateur de combat spatial</h2>
<?php if(0)
	echo 'Vous n\'utilisez pas Firefox, des problèmes peuvent survenir';
?>
<a href="http://help.tools4origins.fr.nf/simulateur_vx.php" class="link" target="_blank">Tutoriel sur l'utilisation du simulateur</a>
<br /><br /><form method='post' action="simulateur_vx.php"> <!--DEBUT DU FORMULAIRE-->
<input type="hidden" name="afficher" />
<p>
<u>Collez ici la liste des vaisseaux de l'attaquant.</u><br />
<textarea name="vx_att" id="vx_att" cols="75" rows="10" ><?php 
if (isset($_POST['vx_att']))
{
	echo stripslashes($_POST['vx_att']);
}
?></textarea><br />
<a href="listeur.php" target="_blank" class="link">Générateur de liste</a><br />
<a href="listeur.php" target="_blank" class="link">Simulateur de vaisseau</a><br />
<br />
<u>Collez ici la liste des vaisseaux du défenseur.</u><br />
<textarea name="vx_def" id="vx_def" cols="75" rows="10" ><?php 
if (isset($_POST['vx_def']))
{
	echo stripslashes($_POST['vx_def']);	
}
?></textarea><br />
<a href="puissance.php" target="_blank" class="link">Calculateur de PdF</a><br />
<br />
<input type="submit" value="OK" />
</p>
</form></div>
<?php
if(isset($_POST['vx_att']) AND $_POST['vx_att']!=NULL AND $_POST['vx_def']!=NULL)
{
//LECTURE DES FLOTTES
	// ATTAQUANT
	$ligne_vx_att=explode("\n", $_POST['vx_att']);
	$nombre_ligne=count($ligne_vx_att);
	$continu=1;
	$message_erreur='';
	for($i=0; !substr_count($ligne_vx_att[$i], "Nom") AND $i<$nombre_ligne; $i++);
	if($i==$nombre_ligne)
		$message_erreur .= 'La ligne "Nom Attaque Coque Bouclier Nombre" n\'a pas été trouvée dans la flotte attaquante<br />';
	else
		for($i=$i+1; $i<$nombre_ligne AND $continu; $i++)
		{
			$ligne_vx_att[$i]=str_replace('	', ' ', $ligne_vx_att[$i]);
			$ligne_vx_att[$i]=str_replace('  ', ' ', $ligne_vx_att[$i]);
			$ligne_vx_att[$i]=rtrim($ligne_vx_att[$i]);
			$infos_vx=explode(' ', $ligne_vx_att[$i]);
			$nombre_partie=count($infos_vx);
			if($infos_vx[0]!="Total")
			{
				$nom_vaisseau='';
				for($c=0; $c<$nombre_partie-4; $c++)
					$nom_vaisseau.= ' ' . $infos_vx[$c];
				$nom_vaisseau_ok=str_replace(' ', '_', $nom_vaisseau);
				$forces_attaquant[$nom_vaisseau_ok]['nom']=$nom_vaisseau;
				$forces_attaquant[$nom_vaisseau_ok]['attaque']=str_replace('.', '', $infos_vx[$nombre_partie-4]);
				$forces_attaquant[$nom_vaisseau_ok]['bouclier']=str_replace('.', '', $infos_vx[$nombre_partie-3]);
				$forces_defenseur[$nom_vaisseau_ok]['bouclier_base']=str_replace('.', '', $infos_vx[$nombre_partie-3]);
				$forces_attaquant[$nom_vaisseau_ok]['coque']=str_replace('.', '', $infos_vx[$nombre_partie-2]);
				$forces_attaquant[$nom_vaisseau_ok]['coque_base']=str_replace('.', '', $infos_vx[$nombre_partie-2]);
				$forces_attaquant[$nom_vaisseau_ok]['nombre']=str_replace('.', '', $infos_vx[$nombre_partie-1]);
			}
			else
				$continu=0;
		}
	if($continu==1)
		$message_erreur .= 'Un problème est survenu: La ligne "Total" n\'a pas été reconnue dans la flotte attaquante<br />';

	//print_r($forces_attaquant);

	// DEFENSEUR
	$ligne_vx_def=explode("\n", $_POST['vx_def']);
	$nombre_ligne=count($ligne_vx_def);
	$continu=1;
	for($i=0; !substr_count($ligne_vx_def[$i], "Nom") AND $i<$nombre_ligne; $i++);
	if($i==$nombre_ligne)
		$message_erreur .= 'La ligne "Nom Attaque Coque Bouclier Nombre" n\'a pas été trouvée dans la flotte du défenseur<br />';
	else
		for($i=$i+1; $i<$nombre_ligne AND $continu; $i++)
		{
			$ligne_vx_def[$i]=str_replace('	', ' ', $ligne_vx_def[$i]);
			$ligne_vx_def[$i]=str_replace('  ', ' ', $ligne_vx_def[$i]);
			$ligne_vx_def[$i]=rtrim($ligne_vx_def[$i]);
			$infos_vx=explode(' ', $ligne_vx_def[$i]);
			$nombre_partie=count($infos_vx);
			if($infos_vx[0]!="Total")
			{
				$nom_vaisseau='';
				for($c=0; $c<$nombre_partie-4; $c++)
					$nom_vaisseau.= ' ' . $infos_vx[$c];
				$nom_vaisseau_ok=str_replace(' ', '_', $nom_vaisseau);
				$forces_defenseur[$nom_vaisseau_ok]['nom']=$nom_vaisseau;
				$forces_defenseur[$nom_vaisseau_ok]['attaque']=str_replace('.', '', $infos_vx[$nombre_partie-4]);
				$forces_defenseur[$nom_vaisseau_ok]['bouclier']=str_replace('.', '', $infos_vx[$nombre_partie-3]);
				$forces_defenseur[$nom_vaisseau_ok]['bouclier_base']=str_replace('.', '', $infos_vx[$nombre_partie-3]);
				$forces_defenseur[$nom_vaisseau_ok]['coque']=str_replace('.', '', $infos_vx[$nombre_partie-2]);
				$forces_defenseur[$nom_vaisseau_ok]['coque_base']=str_replace('.', '', $infos_vx[$nombre_partie-2]);
				$forces_defenseur[$nom_vaisseau_ok]['nombre']=str_replace('.', '', $infos_vx[$nombre_partie-1]);
			}
			else
				$continu=0;
		}
	if($continu==1)
		$message_erreur .= 'Un problème est survenu: La ligne "Total" n\'a pas été reconnue dans la flotte de défense<br />';

	//print_r($forces_defenseur);

	echo $message_erreur;

//COMBAT
	echo '<span id="nombre_passe" class="degats">Nombre de passe: </span>';
	$message_degats='';
	for($passe=1; $passe<=10 AND $message_erreur==''; $passe++)
	{
		//FORCE ATTAQUANT
		$attaque_total_techno_att=0;
		$bouclier_total_techno_att=0;
		$coque_total_techno_att=0;
		$nombre_total_att=0;
		foreach($forces_attaquant AS $vaisseau_attaquant)
		{
			$attaque_total_techno_att+=$vaisseau_attaquant['attaque']*$vaisseau_attaquant['nombre'];
			$bouclier_total_techno_att+=$vaisseau_attaquant['bouclier']*$vaisseau_attaquant['nombre'];
			$coque_total_techno_att+=$vaisseau_attaquant['coque']*$vaisseau_attaquant['nombre'];
			$nombre_total_att+=$vaisseau_attaquant['nombre'];
		}
		$attaque_total_techno_att/=$passe;
		
		//FORCE DEFENSEUR 
		$attaque_total_techno_def=0;
		$bouclier_total_techno_def=0;
		$coque_total_techno_def=0;
		$nombre_total_def=0;
		foreach($forces_defenseur AS $vaisseau_defenseur)
		{
			$attaque_total_techno_def+=$vaisseau_defenseur['attaque']*$vaisseau_defenseur['nombre'];
			$bouclier_total_techno_def+=$vaisseau_defenseur['bouclier']*$vaisseau_defenseur['nombre'];
			$coque_total_techno_def+=$vaisseau_defenseur['coque']*$vaisseau_defenseur['nombre'];
			$nombre_total_def+=$vaisseau_defenseur['nombre'];
		}
		$attaque_total_techno_def/=$passe;
		
		if($nombre_total_att<=0 OR $nombre_total_def<=0)
		{
			echo '<br /><br/><span class="degats">Fin du combat.';
			$infos_combat='';
			if($nombre_total_att<=0 AND $nombre_total_def<=0)
				$infos_combat .= '<span class="egal">Egalité</span>';
			elseif($nombre_total_att<=0)
				$infos_combat .= '<span class="moins">Le défenseur gagnera</span>';
			elseif($nombre_total_def<=0)
				$infos_combat .= '<span class="plus">L\'attaquant gagnera</span>';
			echo '</span><br /><br />';
			echo '<a class="link" href="#en_tete">Retour en haut de page</a>';
			echo '
				<script type="text/javascript">
				<!--
				document.getElementById("nombre_passe").innerHTML+="' . ($passe-1) . ' ' . addslashes($infos_combat) . '";
				//-->
				</script>';
			if($passe==1)
				echo 'Aucun vaisseau n\'a été détecté dans l\'un des camp voire les deux, vérifiez que vous avez bien signaler une quantité pour l\un des modèles';
			$passe=0;
			break;
		}
		
		echo '<br /><br /><span class="passe">Passe N°' . $passe . ' </span><br />';
		
		//CALCUL DES DEGATS PAR UNITEES
		$attaque_total_techno_att*=rand(90, 110)/100;
		$attaque_total_techno_def*=rand(90, 110)/100;
		$degat_par_unite_att=($attaque_total_techno_def/$nombre_total_att);
		$degat_par_unite_def=($attaque_total_techno_att/$nombre_total_def);
		
		echo '<div class="degats">L\'attaquant cause ' . sep($attaque_total_techno_att) . ' points de dommages au défenseur</div><br />';
		
		
		//CALCUL DEGATS VX DEFENSEUR
		foreach($forces_defenseur AS &$vaisseau_def_combat)
		{
			if($vaisseau_def_combat['nombre']>0)
			{
				echo $vaisseau_def_combat['nombre'] . ' ' . $vaisseau_def_combat['nom'];
				$message_degats = ' subit ' . sep(($vaisseau_def_combat['nombre']*$degat_par_unite_def)) . ' dommages ';
				if($vaisseau_def_combat['bouclier']==0)
				{
					$vaisseau_def_combat['coque']-=$degat_par_unite_def;
				}
				else
				{
					if($vaisseau_def_combat['bouclier_base']>($degat_par_unite_def*2))
					{
						$vaisseau_def_combat['bouclier']-=$degat_par_unite_def;
						$message_degats .= '(dont ' . sep($vaisseau_def_combat['nombre']*$degat_par_unite_def) . ' absorbés par le bouclier)';
					}
					elseif($vaisseau_def_combat['bouclier_base']>$degat_par_unite_def)
					{
						$message_degats .= '(dont ' . sep($vaisseau_def_combat['nombre']*$degat_par_unite_def) . ' absorbés par le bouclier)';
					}
					else
					{
						$vaisseau_def_combat['coque']-=$degat_par_unite_def*(5/6);
						$vaisseau_def_combat['bouclier']-=$degat_par_unite_def*(1/6);
						$message_degats .= '(dont ' . sep($vaisseau_def_combat['nombre']*$degat_par_unite_def*(1/6)) . ' absorbés par le bouclier)';
					}
					if($vaisseau_def_combat['bouclier']<0)
					{
						$vaisseau_def_combat['bouclier']=0;
					}
				}
				if($vaisseau_def_combat['coque']<=$vaisseau_def_combat['coque_base']*0.10)
				{
					$vaisseau_def_combat['coque']=0;
					$vaisseau_def_combat['bouclier']=0;
					$vaisseau_def_combat['attaque']=0;
					$vaisseau_def_combat['nombre']=0;
					//echo $message_degats;
					echo '<span style="color:#f00"> Détruit(s)</span>';
				}
				else
					echo $message_degats;
				echo '<br />';
			}
		}
		
		echo '<br /><div class="degats">Le défenseur cause ' . sep($attaque_total_techno_def) . ' points de dommages à l\'attaquant</div><br />';
		
		//CALCUL DEGATS VX ATTAQUANT
		foreach($forces_attaquant AS &$vaisseau_att_combat)
		{
			if($vaisseau_att_combat['nombre']>0)
			{
				echo $vaisseau_att_combat['nombre'] . ' ' . $vaisseau_att_combat['nom'];
				$message_degats = ' subit ' . sep(($vaisseau_att_combat['nombre']*$degat_par_unite_att)) . ' dommages ';
				if($vaisseau_att_combat['bouclier']==0)
				{
					$vaisseau_att_combat['coque']-=$degat_par_unite_att;
				}
				else
				{
					if($vaisseau_att_combat['bouclier']>($degat_par_unite_att*2))
					{
						$vaisseau_att_combat['bouclier']-=$degat_par_unite_att;
						$message_degats .= '(dont ' . sep($vaisseau_att_combat['nombre']*$degat_par_unite_att) . ' absorbés par le bouclier)';
					}
					elseif($vaisseau_att_combat['bouclier']>$degat_par_unite_att)
					{
						$message_degats .= '(dont ' . sep($vaisseau_att_combat['nombre']*$degat_par_unite_att) . ' absorbés par le bouclier)';
					}
					else
					{
						$vaisseau_att_combat['coque']-=$degat_par_unite_att*(5/6);
						$vaisseau_att_combat['bouclier']-=$degat_par_unite_att*(1/6);
						$message_degats .= '(dont ' . sep($vaisseau_att_combat['nombre']*$degat_par_unite_att*(1/6)) . ' absorbés par le bouclier)';
					}
					if($vaisseau_att_combat['bouclier']<0)
						$vaisseau_att_combat['bouclier']=0;
				}
				if($vaisseau_att_combat['coque']<=$vaisseau_att_combat['coque_base']*0.10)
				{
					$vaisseau_att_combat['coque']=0;
					$vaisseau_att_combat['bouclier']=0;
					$vaisseau_att_combat['attaque']=0;
					$vaisseau_att_combat['nombre']=0;
					//echo $message_degats;
					echo '<span style="color:#f00"> Détruit(s)</span>';
				}
				else
					echo $message_degats;
				echo '<br />';
			}
		}
	}
	if($passe==11)
	{
		echo '<br /><br/><span class="degats">Fin du combat.';
		echo '</span><br /><br />';
		echo '<a class="link" href="#en_tete">Retour en haut de page</a>';
		echo '
		<script type="text/javascript">
		<!--
		document.getElementById("nombre_passe").innerHTML+="10 <span class=\"egal\">Egalité</span>";
		//-->
		</script>';
	}
	
}
?>
</div>
</body>
</html>
<?php
include('non_accessible/pub.php');
?>
