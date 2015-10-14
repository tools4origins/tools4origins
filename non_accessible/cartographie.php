<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Cartographie de l'univers <?php echo $uniName ?></title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/oXHR.js"></script>
	<script type="text/JavaScript" src="js/fenetres.js"></script>
</head>

<body>
<?php 
include('menu.php');
include('value.php');
include('sep_point.php');
$g=0;
$g1=0;
$g2=0;
$g3=0;
$g4=0;
$g5=0;
$where="";
$where2="";
$where3="";
$orderby="";
$exex="";
$alliance="";
$joueur="";
include('date.php');
?>
<body>
<!-- Le corps -->
<div id="corps">
<center><br /><br /><u>Recherchez les coordonn&eacute;es:</u><br />
<span class="info">Date du dernier relevé: <?php echo $date[$uni]; ?></span><br />
<table border='1' cellpadding="10" cellspacing="1">
<tr><td><br /><center>
	<form method='post' action="cartographie_<?php echo $uni ?>.php"> <!--DEBUT DU FORMULAIRE-->
	<input type="hidden" id="univers" name="univers" value="<?php echo $uni ?>"/>
	<input type="hidden" name="afficher" /> <!--CHAMP CACHE UTILISE POUR NE RIEN AFFICHER COMME COO SI ON ARRIVE SUR LA PAGE AVEC UN LIEN ET PAS AVEC LE FORMULAIRE-->
	<!--JOUEUR RECHERCHE, VIDE PAR DEF-->
	<label for="joueur">Du joueur</label> : <input type="text" name="joueur" id="joueur" <?php echo value('joueur');?>/>
<br />
	<!--ALLIANCE RECHERCHEE, VIDE PAR DEF-->
	<label for="alliance">OU des membres de l'alliance</label> : <input type="text" name="alliance" id="alliance" <?php echo value('alliance');?>/><br /><br />

	<!--PSEUDO/NOM D'ALLY EXACTE OU JUSTE UN BOUT, DECOCHE PAR DEF-->
	<label for="exex">Expression Exacte:</label> 
		<input type="checkbox" name="exex" id="exex" <?php
if (isset($_POST['exex'])) //SI LA CASE A ETE COCHER LORS DU DERNIER ENVOI DU FORMULAIRE
{ 
	echo 'checked="checked"'; //ON LA COCHE.
}
?> />
<br />
<label for="maspaus">Masquer les joueurs en pause:</label>
<input type="checkbox" name="maspaus" id="maspaus" <?php
if (isset($_POST['maspaus'])) //SI LA CASE A ETE COCHER LORS DU DERNIER ENVOI DU FORMULAIRE
{ 
	echo 'checked="checked"'; //ON LA COCHE.
}
?> />
	<p>
		<!--GALAXIES RECHERCHEES, COCHEES PAR DEF-->
		Dans les galaxies suivantes:<br /> 
		<input type="checkbox" name="G1" id="G1" <?php
		if (isset($_POST['G1']) OR !isset($_POST['afficher'])) //SI LA CASE A ETE COCHER LORS DU DERNIER ENVOI DU FORMULAIRE OU SI C'EST LE PREMIER AFFICHAGE
{
	$g1=1; //$g1 VAUDRA "1" (AVANT: "")
	echo 'checked="checked"'; //ON LA COCHE.
}
?>/> <label for="G1">G1</label> <br />
		<input type="checkbox" name="G2" id="G2" <?php
		if (isset($_POST['G2']) OR !isset($_POST['afficher'])) //SI LA CASE A ETE COCHER LORS DU DERNIER ENVOI DU FORMULAIRE OU SI C'EST LE PREMIER AFFICHAGE
{
	$g2=2; //$g2 VAUDRA "2" (AVANT: "")
	echo 'checked="checked"'; //ON LA COCHE.
}
?> /> <label for="G2">G2</label><br /> 
		<input type="checkbox" name="G3" id="G3" <?php
		if (isset($_POST['G3']) OR !isset($_POST['afficher'])) //SI LA CASE A ETE COCHER LORS DU DERNIER ENVOI DU FORMULAIRE OU SI C'EST LE PREMIER AFFICHAGE
{
	$g3=3; //$g3 VAUDRA "3" (AVANT: "")
	echo 'checked="checked"'; //ON LA COCHE.
}
?> /> <label for="G3">G3</label><br />
		<input type="checkbox" name="G4" id="G4" <?php
		if (isset($_POST['G4']) OR !isset($_POST['afficher'])) //SI LA CASE A ETE COCHER LORS DU DERNIER ENVOI DU FORMULAIRE OU SI C'EST LE PREMIER AFFICHAGE
{
	$g4=4; //$g5 VAUDRA "5" (AVANT: "")
	echo 'checked="checked"'; //ON LA COCHE.
}
?> /> <label for="G4">G4</label><br />
		<input type="checkbox" name="G5" id="G5" <?php
		if (isset($_POST['G5']) OR !isset($_POST['afficher'])) //SI LA CASE A ETE COCHER LORS DU DERNIER ENVOI DU FORMULAIRE OU SI C'EST LE PREMIER AFFICHAGE
{
	$g5=5; //$g5 VAUDRA "5" (AVANT: "")
	echo 'checked="checked"'; //ON LA COCHE.
}
?> /> <label for="G5">G5</label> 
	</p>
	<!--INTERVALLE DE SYSTEME OU ON RECHERCHE-->
	<!--SYSTEME LE PLUS BAS, 1 PAR DEF-->
	<label for="sysmin">Du syst&egrave;me n&deg;</label><input type="text" name="sysmin" id="sysmin" size="3" 
<?php
if (isset($_POST['sysmin'])) //SI $_POST['sysmin'] EXISTE, DONC SI ON EST ARRIVE SUR CETTE PAGE EN CLIQUANT SUR LE FORMULAIRE ET PAS AVEC UN LIEN
{
	echo 'value="' . $_POST['sysmin'] . '"'; //ON MET LA PRECEDENTE VALEUR DANS LA CASE, SI LE JOUEUR N'Y A PAS TOUCHE, CE SERA "1"
}
else //SINON
{
	echo 'value="1"'; //ON MET LA VALEUR PAR DEFAUT, 1
}
?>/>		<!--SYSTEME LE PLUS HAUT, 2999 PAR DEF-->
	<label for="sysmax">au syst&egrave;me n&deg;</label><input type="text" name="sysmax" id="sysmax" size="3" 
<?php
if (isset($_POST['sysmax'])) //SI $_POST['sysmax'] EXISTE, DONC SI ON EST ARRIVE SUR CETTE PAGE EN CLIQUANT SUR LE FORMULAIRE ET PAS AVEC UN LIEN
{
	echo 'value="' . $_POST['sysmax'] . '"'; //ON MET LA PRECEDENTE VALEUR DANS LA CASE, SI LE JOUEUR N'Y A PAS TOUCHE, CE SERA "2999"
}
else //SINON
{
	echo 'value="2999"'; //ON MET LA VALEUR PAR DEFAUT, 2999
}
?>/><br /><br /> 
	<!--INTERVALLE DE POINT OU ON RECHERCHE-->
	<!--MINIMUM DE POINT, 0 PAR DEF-->
	<input type="checkbox" name="usemini" id="usemini" <?php
if (isset($_POST['usemini'])) //SI LA CASE A ETE COCHER LORS DU DERNIER ENVOI DU FORMULAIRE
{
	echo 'checked="checked"'; //ON LA COCHE.
}
?> /><label for="pointmin">Utiliser Minimum: </label><input type="text" name="pointmin" id="pointmin" size="7"
<?php
if (isset($_POST['pointmin'])) //SI $_POST['pointmin'] EXISTE, DONC SI ON EST ARRIVE SUR CETTE PAGE EN CLIQUANT SUR LE FORMULAIRE ET PAS AVEC UN LIEN
{
	echo 'value="' . $_POST['pointmin'] . '"'; //ON MET LA PRECEDENTE VALEUR DANS LA CASE, SI LE JOUEUR N'Y A PAS TOUCHE, CE SERA "0"
}
else //SINON
{
	echo 'value=""'; //ON MET LA VALEUR PAR DEFAUT, 0
}
?>/> points

	<!--MAXIMUM DE POINT, 0 PAR DEF-->
	<br /><input type="checkbox" name="usemaxi" id="usemaxi" <?php
		if (isset($_POST['usemaxi'])) //SI LA CASE A ETE COCHER LORS DU DERNIER ENVOI DU FORMULAIRE
{
	echo 'checked="checked"'; //ON LA COCHE.
}
?> /><label for="pointmax">Utiliser Maximum: </label><input type="text" name="pointmax" id="pointmax" size="7"
<?php
if (isset($_POST['pointmax'])) //SI $_POST['pointmax'] EXISTE, DONC SI ON EST ARRIVE SUR CETTE PAGE EN CLIQUANT SUR LE FORMULAIRE ET PAS AVEC UN LIEN
{
	echo 'value="' . $_POST['pointmax'] . '"'; //ON MET LA PRECEDENTE VALEUR DANS LA CASE, SI LE JOUEUR N'Y A PAS TOUCHE, CE SERA "1"
}
else //SINON
{
	echo 'value=""'; //ON MET LA VALEUR PAR DEFAUT, 1
}
?>/> points<br />
	<p>
		<u>Trier par:</u><br /> <!--TRIER LES COORDONNEES PAR...-->
		<!--PAR POSITION (PAR DEF)-->
		<input type="radio" name="orderby" value="" id="triposition" checked="checked"/> <label for="triposition">Position</label> 
		<!--PAR JOUEUR-->
		<input type="radio" name="orderby" value="joueur" id="trijoueur"  <?php 
if (isset($_POST['orderby']) AND $_POST['orderby'] == "joueur") //SI LORS DU DERNIER REMPLISSAGE DE FORMULAIRE, L'UTILISATEUR A COCHER CETTE CASE
{
	echo 'checked="checked"'; //ON LA COCHE, ETANT DONNE QUE C'EST UNE LISTE A CHOIX UNIQUE, CELA DECOCHERA LA CASE 'POSITION'
}
?>/> <label for="trijoueur">Joueur</label>
		<!--PAR ALLIANCE-->
		<input type="radio" name="orderby" value="alliance" id="trialliance" <?php
if (isset($_POST['orderby']) AND $_POST['orderby'] == "alliance") //SI LORS DU DERNIER REMPLISSAGE DE FORMULAIRE, L'UTILISATEUR A COCHER CETTE CASE
{
	echo 'checked="checked"'; //ON LA COCHE, ETANT DONNE QUE C'EST UNE LISTE A CHOIX UNIQUE, CELA DECOCHERA LA CASE 'POSITION'
}
?>/> <label for="trialliance">Alliance</label>
<!--PAR POINT-->
		<input type="radio" name="orderby" value="points" id="tripoints" <?php
if (isset($_POST['orderby']) AND $_POST['orderby'] == "points") //SI LORS DU DERNIER REMPLISSAGE DE FORMULAIRE, L'UTILISATEUR A COCHER CETTE CASE
{
	echo 'checked="checked"'; //ON LA COCHE, ETANT DONNE QUE C'EST UNE LISTE A CHOIX UNIQUE, CELA DECOCHERA LA CASE 'POSITION'
}
?>/> <label for="tripoints">Point</label>
	</p>
	<input type="submit" value="OK" /> <!--BOUTON OK-->
</form>
</center></tr></td>
</table><br />

<!-- ******* FIN DU FORMULAIRE ******* -->

<?php
//   ******* DEBUT DU CODE PHP ******* //
//echo '<div class="annonce" style="-moz-border-radius:10px 10px 10px 10px;-webkit-border-radius:10px 10px 10px 10px;background-color:#880000;padding:15px;width:400px;"><b>Annonce <span>Tools4Origins</span></b>:<br>
//<a href="http://forum.origins-return.fr/index.php?/topic/228706-design-personnalisable/" class="link">Merci d\'avoir voté à cette suggestion :)</a></div>';

if(isset($_POST['afficher']))
{
		include('connect.php');
	
	/* -------------------------------------------------- CREATION DE LA REQUETE ------------------------------------------ */
	
	if (!isset($_POST['exex'])) //SI LA CASE "EXpression EXacte" EST COCHEE
	{
		$exex="%"; //$EXEX VALAIT "" ET VAUX MAINTENANT "%"
	}
	if (isset($_POST['sysmin']) AND isset($_POST['sysmax']) AND $_POST['sysmin'] != NULL AND $_POST['sysmax'] != NULL) //SI LES CASES "SYSteme MIN" ET "SYSteme MAX" SONT REMPLIS ==> SI ON RECHERCHE DES SYSTEME EN PARTICULIERS (OU CEUX PAR DEFAUT)
	{
		$_POST['sysmin']=htmlspecialchars($_POST['sysmin']); //PROTECTION CONTRE LES HACKERS, SUPPRIME LE CODE PHP/MYSL QU'IL AURAIT PU METTRE DANS LA VARIABLE
		$_POST['sysmax']=htmlspecialchars($_POST['sysmax']); //PROTECTION CONTRE LES HACKERS, SUPPRIME LE CODE PHP/MYSL QU'IL AURAIT PU METTRE DANS LA VARIABLE
		$where2=" AND systeme >= " . $_POST['sysmin'] . " AND systeme <= " . $_POST['sysmax'] . " "; // ON RAJOUTE A LA 2EME PARTIE WHERE DE LA REQUETE MYSQL (AVEC LA 1 FORME LA PARTIE MYSQL DE LA REQUETE) QU'IL FAUT PAS CHERCHER EN DEHORS DE CES SYSTEMES
	}
	if((isset($_POST['usemini']) AND !is_NaN($_POST['pointmin'])) OR (isset($_POST['usemaxi']) AND !is_NaN($_POST['pointmax']))) //SI ON A COCHE USEMINI ET MIS UN NOMBRE DANS POINTMIN OU SI ON A COCHE USEMAXI ET MIT UN NOMBRE DANS POINTMAX
	{
		if(isset($_POST['usemini']) AND !is_NaN(str_replace('.', '', $_POST['pointmin'])))
		$where3.=" AND points >= " . str_replace('.', '', $_POST['pointmin']);
		if(isset($_POST['usemaxi']) AND !is_NaN(str_replace('.', '', $_POST['pointmax'])))
		$where3.=" AND points <= " . str_replace('.', '', $_POST['pointmax']);
		$where3.=" ";
	}
	if (isset($_POST['alliance']) AND $_POST['alliance'] != NULL) //SI LA CASE ALLIANCE DU FORMULAIRE EST PAS VIDE ==> SI ON RECHERCHE UNE ALLIANCE
	{
		$_POST['alliance']=htmlspecialchars($_POST['alliance']); //PROTECTION CONTRE LES HACKERS, SUPPRIME LE CODE PHP/MYSL QU'IL AURAIT PU METTRE DANS LA VARIABLE
		$_POST['alliance']=str_replace('/', "%' OR alliance LIKE '%", $_POST['alliance']);
		$where=" WHERE alliance LIKE '" . $exex . $_POST['alliance'] . $exex . "' "; // LA PARTIE "WHERE" DE LA REQUETE MYSQL RECHERCHERA L'ALLIANCE INDIQUEE --- LA VARIABLE $exex FAIT QUE SOIT LA REQUETE EST LIKE '...' ou LIKE '%...%'
	}
	elseif(isset($_POST['joueur']) AND $_POST['joueur'] != NULL) //SI LA CASE JOUEUR DU FORMULAIRE EST PAS VIDE ==> SI ON RECHERCHE UN JOUEUR
	{
		$_POST['joueur']=htmlspecialchars($_POST['joueur']); //PROTECTION CONTRE LES HACKERS, SUPPRIME LE CODE PHP/MYSL QU'IL AURAIT PU METTRE DANS LA VARIABLE
		$_POST['joueur']=str_replace('/', "%' OR joueur LIKE '%", $_POST['joueur']);
		$where=" WHERE joueur LIKE '" . $exex . $_POST['joueur'] . $exex . "' "; //LA PARTIE "WHERE" DE LA REQUETE MYSQL RECHERCHERA LE JOUEUR INDIQUE --- LA VARIABLE $exex FAIT QUE SOIT LA REQUETE EST LIKE '...' ou LIKE '%...%'
	}
	else
	{
		$where=" WHERE 1 ";
	}
	if(isset($_POST['orderby']) AND $_POST['orderby'] != NULL) //SI ORDERBY EST DIFFERENT DE "", VALEUR QU'IL A SI LA CASE POSITION EST COCHEE
	{
		if($_POST['orderby']=='points')
		$orderby=" ORDER BY " . $_POST['orderby'] . ", ID";
		else
		$orderby=" ORDER BY " . $_POST['orderby'] . ", ID"; //LA PARTIE ORDERBY DE LA REQUETE INDIQUERA QU'IL FAUT ORDONNER EN FONCTION DE LA CASE COCHEE ('joueur' / 'alliance')
	}
	if(isset($_POST['maspaus'])) //SI LA CASE "EXpression EXacte" EST COCHEE
		$where4=" AND pause != 1"; //$EXEX VALAIT "" ET VAUX MAINTENANT "%"
	else
		$where4="";
	
	
	
	/* ----------------------------------------------------- TRAITEMENT DE LA REQUETE ------------------------------------------ */
	
	
	$query="SELECT * FROM univers_" . $uni . $where. $where2 . $where3 . $where4 . $orderby ; //ON RASSEMBLE LES DIFFERENTE PARTIE DE LA REQUETE POUR FAIRE CELLE QUI VA RECHERCHER
	//echo $query;
	$galaxie=$sql->query($query) or die(mysql_error());
	
/*	$queryn="SELECT COUNT(*) AS nbre FROM univers_" . $uni . $where. $where2 . $where3 . $where4 . $orderby; //ON RASSEMBLE LES DIFF PART POUR FAIRE LA REQUETE QUI VA AFFICHER LE NBRE DE RESULTAT
	//echo $queryn . "<br />";
	$nombre=$sql->query($queryn) or die(mysql_error()); //ON MET DANS $NOMBRE*/
	$nombreReponse=$galaxie->rowCount();
	//$reponse=mysql_fetch_array($nombre);
	if(($nombreReponse<5000))//SI IL Y A TROP DE RÉPONSE, ON N'AFFICHE PAS
	{
		echo '<span class="rep_trouvee">' . sep($nombreReponse) . ' réponses trouvées</span><br />';
		echo '<table class="resultat" border="1"><thead><tr><th style="width:7%;">Galaxie</th><th style="width:11%;">Système</th><th style="width:7%;">Position</th><th style="width:25%;">Pseudo</th><th style="width:25%;">Alliance</th><th style="width:25%;">Points</th></tr></thead></table><br />';
		echo '<script type="text/javascript"><!--
			google_ad_client = "pub-1565720051377675";
			// 728x90, date de création 19/07/10 
			google_ad_slot = "6325465281";
			google_ad_width = 728;
			google_ad_height = 90;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script><br />' . "\n";
		if($nombreReponse!=0)
		{
			
			while($coo = $galaxie->fetch()) //AFFICHAGE
			{
				if($orderby=="ORDER BY joueur")
				{
					if($coo['joueur'] != $joueur)
					{
						echo "</tr></table><br />"; //FIN DU TABLEAU
						echo "<hr />"; //BARRE HORIZONTALE
						echo '<table class="resultat" border="1">'; //DEBUT DU TABLEAU
						$g=""; //$G DEVIENT AINSI FORCEMENT DIFFERENT DE $coo['galaxie']
					}
					$joueur=$coo['joueur']; //$joueur CORRESPOND DONC A LA VALEUR DE $coo['joueur'] DU DERNIER TOUR DE BOUCLE DANS LA CONDITION CI DESSUS
				}
				else if($orderby=="ORDER BY alliance")
				{
					if($coo['alliance'] != $alliance)
					{
						echo "</tr></table><br />"; //FIN DU TABLEAU
						echo "<hr />"; //BARRE HORIZONTALE
						echo '<table class="resultat" border="1">'; //DEBUT DU TABLEAU
						$g=""; //$G DEVIENT AINSI FORCEMENT DIFFERENT DE $coo['galaxie']
					}
					$alliance=$coo['alliance']; //$alliance CORRESPOND DONC A LA VALEUR DE $coo['alliance'] DU DERNIER TOUR DE BOUCLE DANS LA CONDITION CI DESSUS
				}
				if($coo['galaxie'] != $g) //SI LA GALAXIE N'EST PAS LA MEME
				{
					if($coo['galaxie'] == $g1 OR $coo['galaxie'] == $g2 OR $coo['galaxie'] == $g3 OR $coo['galaxie'] == $g4 OR $coo['galaxie'] == $g5) //SI LA GALAXIE EST COCHEE DANS LE FORMULAIRE
					{
						echo "</table><br />"; // FIN DU TABLEAU PRECEDENT
						echo '<span class="rep_trouvee">Galaxie n°' . $coo['galaxie'] . ':</span>'; //AFFICHE LE NUM DE LA GALAXIE
						echo '<br /><br /><table class="resultat"border="1">'; // DEBUT DU NOUVEAU
						$g=$coo['galaxie'];
					}
				}
				if($coo['galaxie'] == $g1 OR $coo['galaxie'] == $g2 OR $coo['galaxie'] == $g3 OR $coo['galaxie'] == $g4 OR $coo['galaxie'] == $g5) //SI LA GALAXIE EST COCHEE DANS LE FORMULAIRE
				{
					$action='onmouseover="passage_souris(event,400,\'NF\',' . '\'' . $coo['joueur'] . "','bulle','" . $coo['joueur'] . "');\" onmouseout=\"arreter_deplacement();delElem('" . $coo['joueur'] . "');\" onclick=\"lock['" . $coo['joueur'] . "']=(1/lock['" . $coo['joueur'] . "']);\"";
					$lien='<a target="_blank" href="details_joueur.php?joueur=' . $coo['joueur'] . '&univers=' . ucfirst($uni) . '" class="link"onclick="arreter_deplacement();delElem(\'' . $joueur . '\');lock[\'' . $joueur . '\']=10;">';
					($coo['pause']) ? $class=' class="JoueurPause"' : $class = '';
					echo '<tr ' . $class . '> <td style="width:7%;">' . $coo['galaxie'] . '</td> <td style="width:11%;">' . $coo['systeme'] . '</td> <td style="width:7%;">' . $coo['position'] . '</td> <td ' . $action . ' style="width:25%;">' . $lien . $coo['joueur'] . '</a></td> <td style="width:25%;">' . $coo['alliance'] . '</td><td style="width:25%;">' . sep($coo['points']) . '</td>' . "\n"; // AFFICHE LES COORDONNEES DANS UNE LIGNE DE TABLEAU
				}
			}
			echo "</table>"; //ON FERME LE TABLEAU A LA FIN DE LA BOUCLE.
		}
	}
	else //SINON (SI "strlen($where)>27" EST FAUX)
	{
		echo '<br /><span class="rep_trouvee">Veuillez affiner votre recherche.</span>';
	}
}
?>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>
<!-- FIN -->
