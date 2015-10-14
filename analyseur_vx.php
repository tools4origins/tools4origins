<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Analyseur de rapports de combats par Vaisseau</title>
	<?php include('non_accessible/head.php'); ?>
</head>

<body>
<?php
include('menu.php'); //Menu du site
?>
<!-- Le corps -->
	<div id="corps"><div style="text-align:center"><h2>Analyseur de RC par Vaisseau</h2>
		<u>Collez ici vos rapports de combat par vaisseau (date et titre inclus).</u><br />
		<span class="red">Attention, depuis une mise à jour il faut afficher l'intégralité des rapports dans le jeu pour que le copier-coller fonctionne</span>
		<form method='post' action="analyseur_vx.php"> <!--DEBUT DU FORMULAIRE-->
			<input type="hidden" name="afficher" />
			<p>
				<textarea name="rc" id="rc" cols="75" rows="10" ><?php
if (isset($_POST['rc'])) { // Si le formulaire a été envoyé
	$_POST['rc'] = htmlspecialchars($_POST['rc']);
	$_POST['rc'] = stripslashes($_POST['rc']);
	echo $_POST['rc']; //Remplit la zone de texte avec ce qui a été envoyé
}

?></textarea>
				<br />
				<br />
				<input type="submit" value="Analyser" />
			</p>
		</form>
	</div>
	<?php
if (isset($_POST['rc'])) {
	// --FONTIONS DE TRAITEMENT
	// Fonction qui retourne un nombre au format XXX.XXX.XXX
	function sep($value)
	{
		return number_format($value, 0, ",", ".");
	}
	function duree($date1, $date2)
	{
		preg_match("#([0-9]+)/([0-9]+)/([0-9]+) ([0-9]+):([0-9]+):([0-9]+)#", $date1, $res1); //Regex pour stocké les jours/mois/années/heures/minutes/secondes dans $res1 à partir de la première date
		preg_match("#([0-9]+)/([0-9]+)/([0-9]+) ([0-9]+):([0-9]+):([0-9]+)#", $date2, $res2); //Regex pour stocké les jours/mois/années/heures/minutes/secondes dans $res2 à partir de la seconde date
		return abs(mktime($res2[4], $res2[5], $res2[6], $res2[2], $res2[1], $res2[3])-mktime($res1[4], $res1[5], $res1[6], $res1[2], $res1[1], $res1[3]));  //mktime(heu, min, sec, mois, jour, année) renvoi le timestamps correspondant à la date, donc une soustraction et un abs(int) qui renvoi la valeur absolu (inutile ici, car $date2>$date1 mais peut servir ailleurs)
	}
	// Fonction qui retourne un tableau avec les valeurs interessantes d'UN rapport
	function StudyReport($report)
	{
		// echo $report;
		// Tabeau de resultats qui sera retourne
		$aResults = array (
			'date' => null,
			'victoire' => null,
			'offensif' => null,
			'pseudoJoueur' => null,
			'allyJoueur' => null,
			'planeteJoueur' => null,
			'coordonneesJoueur' => null,
			'direction' => null,
			'pseudoOpposant' => null,
			'allyOpposant' => null,
			'planeteOpposant' => null,
			'coordonneesOpposant' => null,
			'direction' => null,
			'vol' => false);
		// Recupere la date
		preg_match("#[0-9]+/.+:[0-9]+#" , $report, $regexMatch);
		$aResults['date'] = $regexMatch[0];
		// Si la bataille est gagnee
		if (substr_count($report, "La bataille a été gagnée") == true)
			$aResults['victoire'] = true;
		// Sinon si la bataille est perdue
		elseif (substr_count($report, "La bataille a été perdue") == true)
			$aResults['victoire'] = false;
		// Sinon il y eu erreur
		else
			return false;
		// Recupere 1 s'il y eu vol sinon 0
		$aResults['vol'] = substr_count($report, "Vol de :");
		// Si vol n'est pas une valeur valide il y a une erreur
		if ($aResults['vol'] != false && $aResults['vol'] != true)
			return false;
		// Definit le type et sens du combat selon 4 cas possibles
		if (($aResults['victoire'] == true && $aResults['vol'] == true) || ($aResults['victoire'] == false && $aResults['vol'] == false)) {
			$aResults['offensif'] = true;
			$aResults['direction'] = '=>';
		} else {
			$aResults['offensif'] = false;
			$aResults['direction'] = '<=';
		}
		// Si il a y eu vol il faut recuperer les valeurs
		if ($aResults['vol'] == true) {
			// Creation d'un tableau dans [vol] pour stocker les 4 valeurs volees (Fer, Or, Cristal, Hydrogene)
			$aResults['vol'] = array (0, 0, 0, 0);
			// Recupere toutes les valeurs du vol
			preg_match_all("#- ([0-9.]+)(\(\+([0-9.]+) bunker\))? unité\(s\) de#" , $report, $aValues);
			// Pour chaque ressource
			for ($i = 0; $i < 4; $i++) {
				// Place la valeur volee trouvee par regex dans le tableau des vols
				$aResults['vol'][$i] = str_replace('.', '', $aValues[1][$i]) + ((isset($aValues[3][$i])) ? str_replace('.', '', $aValues[3][$i]) : 0);
				// Enleve les points dans les nombres
				$aResults['vol'][$i] = str_replace('.', '', $aResults['vol'][$i]);
			}
		}
		// Recupere le pseudo du joueur
		preg_match("#des forces du joueur (.+) \[(.*)\]#" , $report, $regexMatch);
		$aResults['pseudoJoueur'] = $regexMatch[1]; //Pseudo du joueur en $1 du regex
		$aResults['allyJoueur'] = $regexMatch[2]; //Alliance du joueur en $2 du regex
		$aResults['allyJoueur'] = str_replace(array('[', ']'), '', $aResults['allyJoueur']); //Enleve les crochets
		// Recupere la planete et les coordonnees du joueur
		preg_match("#Sur la planète (.+) \[(.*)\]#" , $report, $regexMatch);
		$aResults['planeteJoueur'] = $regexMatch[1]; //Planete du joueur en $1 du regex
		$aResults['coordonneesJoueur'] = $regexMatch[2]; //Coordonnees du joueur en $2 du regex
		// Recupere les informations de l'opposant
		preg_match("#au joueur (.+) \[(.*)\] Venant de la planète (.+) \[(.*)\]#" , $report, $regexMatch);
		$aResults['pseudoOpposant'] = $regexMatch[1]; //Pseudo de l'opposant en $1 du regex
		$aResults['allyOpposant'] = $regexMatch[2]; //Alliance de l'opposant en $2 du regex
		$aResults['allyOpposant'] = str_replace(array('[', ']'), '', $aResults['allyOpposant']); //Enleve les crochets
		$aResults['planeteOpposant'] = $regexMatch[3]; //Planete de l'opposant en $3 du regex
		$aResults['coordonneesOpposant'] = $regexMatch[4]; //Coordonnees de l'opposant en $4 du regex
		// Si la bataille etait offensive, les joueurs sont inverses
		if ($aResults['offensif'] == true) {
			// Sauvegarde les valeurs
			$aTemp = array (
				'pseudoJoueur' => $aResults['pseudoJoueur'],
				'allyJoueur' => $aResults['allyJoueur'],
				'planeteJoueur' => $aResults['planeteJoueur'],
				'coordonneesJoueur' => $aResults['coordonneesJoueur'],);
			// Les deplace
			$aResults['pseudoJoueur'] = $aResults['pseudoOpposant'];
			$aResults['allyJoueur'] = $aResults['allyOpposant'];
			$aResults['planeteJoueur'] = $aResults['planeteOpposant'];
			$aResults['coordonneesJoueur'] = $aResults['coordonneesOpposant'];
			// Utilise les valeurs sauvegardees
			$aResults['pseudoOpposant'] = $aTemp['pseudoJoueur'];
			$aResults['allyOpposant'] = $aTemp['allyJoueur'];
			$aResults['planeteOpposant'] = $aTemp['planeteJoueur'];
			$aResults['coordonneesOpposant'] = $aTemp['coordonneesJoueur'];
		}
		// Verifie que toutes les valeurs sont présentes
		// Pour chaque valeur
		foreach($aResults as $test) {
			if ($test === null) // Si la valeur est nulle
				return false;
			// echo "Erreur : $test<br/>";
		}
		// Si on arrive la tout est ok
		return $aResults;
	}
	// Fonction qui retourne la valeur fer
	function GetIronValue($iron, $gold, $crystal, $hydrogen)
	{
		return $iron + $gold * 1.25 + $crystal * 2.5 + $hydrogen * 5;
	}
	
	//Fonction de tri d'un tableau 2d
    function sort2d ($array, $index, $order='asc', $natsort=FALSE, $case_sensitive=FALSE)  
    { 
        if(is_array($array) && count($array)>0)  
        { 
           foreach(array_keys($array) as $key)  
               $temp[$key]=$array[$key][$index]; 
               if(!$natsort)  
                   ($order=='asc')? asort($temp) : arsort($temp); 
              else  
              { 
                 ($case_sensitive)? natsort($temp) : natcasesort($temp); 
                 if($order!='asc')  
                     $temp=array_reverse($temp,TRUE); 
           } 
           foreach(array_keys($temp) as $key)  
               (is_numeric($key))? $sorted[]=$array[$key] : $sorted[$key]=$array[$key]; 
           return $sorted; 
      } 
      return $array; 
    }  

	
	// --TRAITEMENT
	// Epure le rapport
	$_POST['rc'] = htmlspecialchars($_POST['rc']);
	// stripslashes( $_POST['rc'] );
	// Recupere les dates et heure qui seront supprimées lors du split
	preg_match_all("#([0-9]+)/([0-9]+)/([0-9]+) ([0-9]+):([0-9]+):([0-9]+)#" , $_POST['rc'], $aDates);
	// separe les rapports
	$aReports = preg_split("#([0-9]+)/([0-9]+)/([0-9]+) ([0-9]+):([0-9]+):([0-9]+)#", $_POST['rc'], - 1, PREG_SPLIT_NO_EMPTY);
	// Verifie la validite du POST
	if (count($aDates[0]) < 1) { // Si on a pas trouve une seule date
		echo "Veuillez coller au moins un rapport complet (Date et titre inclus)<br/>"; //Message d'erreur
		exit;
	}
	// Verifie que la premiere valeur du tableau n'est pas vide
	if (substr($_POST['rc'], 0, 2) != $aDates[1][0]) // Si le début du POST est different du debut de la date
		array_splice($aReports, 0 , 1); //Alors on supprime la premiere valeur du tableau
	// Verifie la validite du POST
	if (count($aDates[0]) != count($aReports)) { // Si on a un nombre de dates different du nombre de rapports
		echo "Veuillez coller des rapports valides (Date et titre inclus)<br/>"; //Message d'erreur
		exit;
	}
	// Tabeaux des ressources totales (Fer, Or, Cristal, Hydrogene, Valeur Fer)
	$totalResourcesFlights = array (0, 0, 0, 0, 0);
	$totalLostResources = array (0, 0, 0, 0, 0);
	$totalProfitResources = array (0, 0, 0, 0, 0);
	// Parcourt les rapports
	for ($i = 0; $i < count($aReports); $i++) {
		// Ajoute la date supprimée au début du rapport
		$aReports[$i] = $aDates[0][$i] . $aReports[$i];
		// Recupere les resultats du rapport
		$aReportsResults[$i] = StudyReport($aReports[$i]);
		// Debug
		// echo "<br/><br/>";
		// echo nl2br(print_r($aReportsResults[$i], 1));
		// Si il a eu une erreur
		if ($aReportsResults[$i] == false)
		{
			echo "Veuillez coller des rapports valides (Date et titre inclus)<br/>"; //Message d'erreur
			exit;
			// Sinon le rapport est valide, utilisation des valeurs
		}
		else
		{
			// S'il y a eu vol
			if ($aReportsResults[$i]['vol'] == true)
			{
				// Et si la bataille etait offensive
				if ($aReportsResults[$i]['offensif'] == true)
				{
					/* On stocke le pseudo et l'ally de l'utilisateur pour l'image Pseudo [Ally] Raideur space: XXXVF/s */
					$pseudoUtilisateur=$aReportsResults[$i]['pseudoJoueur'];
					$allyUtilisateur=$aReportsResults[$i]['allyJoueur'];
					// On ajoute aux ressources volées
					$totalResourcesFlights[0] += $aReportsResults[$i]['vol'][0];
					$totalResourcesFlights[1] += $aReportsResults[$i]['vol'][1];
					$totalResourcesFlights[2] += $aReportsResults[$i]['vol'][2];
					$totalResourcesFlights[3] += $aReportsResults[$i]['vol'][3];
					if(isset($totalParJoueur[$aReportsResults[$i]['pseudoOpposant']]))
					{
						$totalParJoueur[$aReportsResults[$i]['pseudoOpposant']][0]+=$aReportsResults[$i]['vol'][0];
						$totalParJoueur[$aReportsResults[$i]['pseudoOpposant']][1]+=$aReportsResults[$i]['vol'][1];
						$totalParJoueur[$aReportsResults[$i]['pseudoOpposant']][2]+=$aReportsResults[$i]['vol'][2];
						$totalParJoueur[$aReportsResults[$i]['pseudoOpposant']][3]+=$aReportsResults[$i]['vol'][3];
					}
					else
					{
						$totalParJoueur[$aReportsResults[$i]['pseudoOpposant']][0]=$aReportsResults[$i]['vol'][0];
						$totalParJoueur[$aReportsResults[$i]['pseudoOpposant']][1]=$aReportsResults[$i]['vol'][1];
						$totalParJoueur[$aReportsResults[$i]['pseudoOpposant']][2]=$aReportsResults[$i]['vol'][2];
						$totalParJoueur[$aReportsResults[$i]['pseudoOpposant']][3]=$aReportsResults[$i]['vol'][3];
					}
				// Sinon la bataille etait defensive
				}
				else
				{
					// On ajoute aux ressources perdues
					$totalLostResources[0] += $aReportsResults[$i]['vol'][0];
					$totalLostResources[1] += $aReportsResults[$i]['vol'][1];
					$totalLostResources[2] += $aReportsResults[$i]['vol'][2];
					$totalLostResources[3] += $aReportsResults[$i]['vol'][3];
				}
			}
		}
	}
	$aReportsResultsSorted = array (0, 0, 0, 0, 0);
	// Calcul des valeurs fer
	$totalResourcesFlights[4] = GetIronValue($totalResourcesFlights[0], $totalResourcesFlights[1],
		$totalResourcesFlights[2], $totalResourcesFlights[3]);
	$totalLostResources[4] = GetIronValue($totalLostResources[0], $totalLostResources[1],
		$totalLostResources[2], $totalLostResources[3]);
	// Calcul des gains pour chaque ressource
	for ($i = 0; $i < 5; $i++) {
		$totalProfitResources[$i] = $totalResourcesFlights[$i] - $totalLostResources[$i];
	}
	
	//Tri du tableau
	$aReportsResults = sort2d ($aReportsResults, 'allyOpposant', 'asc', TRUE, FALSE);
	
	// --AFFICHAGE
	// Resultats generaux
	echo '<br />Bilans des ' . count($aReports) . ' combats trouvés du ' . $aReportsResults[count($aReportsResults)-1]['date'] . ' au ' . $aReportsResults[0]['date'] . ',  contre ';
	if(count($totalParJoueur)>1)
		echo count($totalParJoueur) . ' joueurs différents :';
	else
		foreach($totalParJoueur AS $pseudo=>$contenu)
			echo $pseudo . ' :';
		
	// Tableau des totaux
	echo '<h4>Bilan des vols complets :</h4>';
	echo '<table class="resultatRCVol"  border="1"><thead><tr><th></th><th><b>Fer</b></th><th><b>Or</b></th><th><b>Cristal</b></th>
			<th><b>Hydrogène</b></th><th><b>Valeur Fer</b></th></tr></thead>
		<tr><td><b>Total des ressources volées</b></td>';
	for ($i = 0; $i < count($totalResourcesFlights); $i++) {
		echo '<td><b>' . sep($totalResourcesFlights[$i]) . '</b></td>';
	}
	echo '</tr>
		<tr><td><b>Total des ressources perdues</b></td>';
	for ($i = 0; $i < count($totalLostResources); $i++) {
		echo '<td><b>' . sep($totalLostResources[$i]) . '</b></td>';
	}
	echo '</tr>
		<tr><td><b>Total des gains de ressources</b></td>';
	for ($i = 0; $i < count($totalLostResources); $i++) {
		// Recupere la ressource a traiter
		$thisRes = $totalProfitResources[$i];
		// Si elle est positive
		if ($thisRes > 0) {
			$class = 'plus';
			// Sinon si elle est negative
		} elseif ($thisRes < 0) {
			$class = 'moins';
			// Sinon elle est nulle
		} else {
			$class = 'egal';
		}
		// Affiche la valeur avec sa classe pour la couleur
		echo '<td><span class="' . $class . '" title="' . $i . '"><b>' . sep($thisRes) . '</b></td>';
	}
	echo '</tr>
		</table>';	

	// Bilan des pillages
	echo '<h4>Bilan des pillages :</h4>';
	echo '<table class="resultatRCVol" border="1">';
	echo '<tr><th width="70%">Ressources Volées</th><th width="40%">Version Forum</th></tr><tr><td>';
	echo '<u>Ressources volées au cours de ' . count($aReports) . ' raids du ' . $aReportsResults[count($aReportsResults)-1]['date'] . ' au ' . $aReportsResults[0]['date'] . ' :</u><br />';
	echo '<img src="images/ress_fer.png" />Fer : ' . sep($totalResourcesFlights[0]) . '<br />';
	echo '<img src="images/ress_or.png" />Or : ' . sep($totalResourcesFlights[1]) . '<br />';
	echo '<img src="images/ress_cristal.png" />Cristal : ' . sep($totalResourcesFlights[2]) . '<br />';
	echo '<img src="images/ress_hydrogene.png" />Hydrogène : ' . sep($totalResourcesFlights[3]) . '<br />';
	echo '= Valeur Fer : ' . sep(GetIronValue($totalResourcesFlights[0], $totalResourcesFlights[1], $totalResourcesFlights[2], $totalResourcesFlights[3])) . '<br />';
	echo '</td><td>';
	echo '<textarea cols="60" rows="10" onclick="this.focus();this.select()"
			title="Cliquez sur le texte pour le sélectionner puis faites Ctrl+C pour copier le contenu"
			readonly="" style="margin-left: 2px; margin-right: 2px; margin-top: 2px; margin-bottom: 2px;">
[u]Ressources volées au cours de ' . count($aReports) . ' raids du ' . $aReportsResults[count($aReportsResults)-1]['date'] . ' au ' . $aReportsResults[0]['date'] . ' :[/u]
[img]http://uni10.origins-return.fr/images/ressource/Fer-icon.png[/img]Fer : [b]' . sep($totalResourcesFlights[0]) . '[/b]
[img]http://uni10.origins-return.fr/images/ressource/Or-icon.png[/img]Or : [b]' . sep($totalResourcesFlights[1]) . '[/b]
[img]http://uni10.origins-return.fr/images/ressource/Cristal-icon.png[/img]Cristal : [b]' . sep($totalResourcesFlights[2]) . '[/b]
[img]http://uni10.origins-return.fr/images/ressource/Hydrogene-icon.png[/img]Hydrogène : [b]' . sep($totalResourcesFlights[3]) . '[/b]
= Valeur Fer : [b]' . sep($totalResourcesFlights[4]) . '[/b]</textarea>
<br/>';
	echo '</td></tr>';
	$dureeDesRaids = duree($aReportsResults[count($aReportsResults)-1]['date'], $aReportsResults[0]['date']);
	$moyRaid = sep(GetIronValue($totalResourcesFlights[0], $totalResourcesFlights[1], $totalResourcesFlights[2], $totalResourcesFlights[3])/count($aReports));
	$moySec = sep(GetIronValue($totalResourcesFlights[0], $totalResourcesFlights[1], $totalResourcesFlights[2], $totalResourcesFlights[3])/(($dureeDesRaids!=0) ? $dureeDesRaids : 1));
	echo '<tr><td>';
	echo 'Je raide ' . $moyRaid . ' VF/raid... Et vous?<br />';
	echo 'Je raide ' . $moySec . ' VF/s... Et vous?';
	echo '</td><td>';
	echo '<input cols="60" onclick="this.focus();this.select()"
			title="Cliquez sur le texte pour le sélectionner puis faites Ctrl+C pour copier le contenu"
			readonly="" style="margin-left: 2px; margin-right: 2px; margin-top: 2px; margin-bottom: 2px;" size="60"
			value="Je raide ' . $moyRaid . ' VF/raid... Et vous?" /><br />';
	echo '<input cols="60" onclick="this.focus();this.select()"
			title="Cliquez sur le texte pour le sélectionner puis faites Ctrl+C pour copier le contenu"
			readonly="" style="margin-left: 2px; margin-right: 2px; margin-top: 2px; margin-bottom: 2px;" size="60"
			value="Je raide ' . $moySec . ' VF/s... Et vous?" />';
	echo '</td></tr>';
	echo '<tr><td colspan="2">';
	if($dureeDesRaids<3600)
		echo 'Raidez pendant au moins 60 minutes pour obtenir des images indiquant votre vitesse de raid';
	else
	{
		/* Ouverture du fichier contenant la vitesse de raid */
		$fichier = fopen('non_accessible/raid.txt', 'a+');
		$contenuFichier = fread($fichier, filesize('non_accessible/raid.txt'));
		$contenuFichier = explode("\n", $contenuFichier);
		$nombreDeLigne = count($contenuFichier);
		/* Génération de la clé */
		/* La cle est sous cette forme : XXnnXnnX */
		/* Où X est une lettre choisi au hasard dans l'alphabet et nnnn le numéro de la ligne contenant la vitesse dans raid.txt */
		/* XXXX est écrit dans le fichier et le script générant l'image vérifie que l'url de l'image n'a pas été modifié manuellement par quelqu'un qui voudrait avoir la vitesse d'un autre */
		$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		/*if($nombreDeLigne < 10)
			$nombreDeLigne = '000' . $nombreDeLigne;
		elseif($nombreDeLigne < 1000)
			$nombreDeLigne = '00' . $nombreDeLigne;
		elseif($nombreDeLigne < 1000)
			$nombreDeLigne = '0' . $nombreDeLigne;*/
		$nombreDeLigne=str_pad($nombreDeLigne, 4, '0', STR_PAD_LEFT); //Rajoute '0' à gauche, pour avoir 0001 et non 1 par ex
		$chaine = $alphabet[rand(0,25)] . $alphabet[rand(0,25)] . $alphabet[rand(0,25)] . $alphabet[rand(0,25)];
		$cle = $chaine[0] . $chaine[1] . $nombreDeLigne[0] . $nombreDeLigne[1] .  $chaine[2] . $nombreDeLigne[2] . $nombreDeLigne[3] . $chaine[3];
		/* Insertion de la vitesse et de la clé dans le fichier */
		//echo $pseudoUtilisateur . ' [' . $allyUtilisateur . ']<br />';
		fputs($fichier, $pseudoUtilisateur . '/' . $allyUtilisateur . '/' . $moySec . '/' . $chaine . "\n");
		fclose($fichier);
		/* Affichage de l'image */
		echo '<img src="raid.php?cle=' . $cle . '" alt="L\'image n\'arrive pas à se charger" /><br />';
		echo '<img src="raid2.php?cle=' . $cle . '" alt="L\'image n\'arrive pas à se charger" /><br />';
		echo 'Pour afficher ces images sur le forum officiel, vous serez obligés de les réhébergées, par exemple sur <a href="http://imageshack.us/" class="link">ImageShack</a>.';
	}
	echo '</td></tr>';
	echo '</table>';

	//Liste des ressources pillées joueurs par joueurs.
	echo '<h4>Bilan joueur par joueur</h4>';
	echo '<div class="clickon" onclick="document.getElementById(\'joueur_par_joueur\').style.display=\'block\';this.style.display=\'none\'">Cliquez pour afficher</div>';
	echo '<div id="joueur_par_joueur" style="display:none">';
	echo '<table class="resultatRCVol" border="1">';
	echo '<tr><th width="70%">Vols</th><th width="40%">Version Forum</th></tr>';
	foreach($totalParJoueur AS $pseudo=>$vols)
	{
		echo '<tr width="70%"><td>';
		echo 'Total des vols sur <span class="red">' . $pseudo . '</span>:<br />';
		echo '<img src="images/ress_fer.png" />Fer : ' . sep($vols[0]) . '<br />';
		echo '<img src="images/ress_or.png" />Or : ' . sep($vols[1]) . '<br />';
		echo '<img src="images/ress_cristal.png" />Cristal : ' . sep($vols[2]) . '<br />';
		echo '<img src="images/ress_hydrogene.png" />Hydrogène : ' . sep($vols[3]) . '<br />';
		echo '= Valeur Fer : ' . sep(GetIronValue($vols[0], $vols[1], $vols[2], $vols[3])) . '<br />';
		echo '</td><td>';
		echo '<textarea cols="50" rows="8" onclick="this.focus();this.select()"
			title="Cliquez sur le texte pour le sélectionner puis faites Ctrl+C pour copier le contenu"
			readonly="">';
		echo 'Total des vols sur ' . $pseudo . ':' . "\n";
		echo '[img]http://uni10.origins-return.fr/images/ressource/Fer-icon.png[/img]Fer : [b]' . sep($vols[0]) . "[/b]\n";
		echo '[img]http://uni10.origins-return.fr/images/ressource/Or-icon.png[/img]Or : [b]' . sep($vols[1]) . "[/b]\n";
		echo '[img]http://uni10.origins-return.fr/images/ressource/Cristal-icon.png[/img]Cristal : [b]' . sep($vols[2]) . "[/b]\n";
		echo '[img]http://uni10.origins-return.fr/images/ressource/Hydrogene-icon.png[/img]Hydrogène : [b]' . sep($vols[3]) . "[/b]\n";
		echo '= Valeur Fer : [b]' . sep(GetIronValue($vols[0], $vols[1], $vols[2], $vols[3])) . '[/b]';
		echo '</textarea>';
		echo '</td></tr>';
	}
	echo '</table>';
	echo '<a class="link" href="#en_tete">Retour en haut de page</a>';
	echo '</div>';

	// Tableau des combats
	// En-tete
	echo '<h4>Bilan des combats :</h4>';
	echo '<div class="clickon" onclick="document.getElementById(\'bilan_combats\').style.display=\'block\';this.style.display=\'none\'">Cliquez pour afficher</div>';
	echo '<div id="bilan_combats" style="display:none">';
	echo '<table width="570" border="0" class="resultatRCCombat">
		<thead><tr>
			<th width="21%">Votre planete</th>
			<th width="15%">Coordonn&eacute;es</th>
			<th width="13%">Sens de l\'attaque</th>
			<th width="21%">Plan&egrave;te ennemie</th>
			<th width="15%">Coordonn&eacute;es</th>
			<th width="15%">Issue de la bataille</th>
		</tr></thead>
	</table>
	<br/>';
	
	// Tableau pour chaque joueur
	// array_splice($aReports, 0 , 1); //Alors on supprime la premiere valeur du tableau
	// Tant que le tableau n'est pas vide il reste des joueurs a afficher
	while (count($aReportsResults) >= 1) {
		// Recupere le pseudo du premier joueur
		$processPseudo = $aReportsResults[0]['pseudoOpposant'];

		echo '<span class="egal"><strong>--- ' . $aReportsResults[0]['pseudoOpposant'] . ' [' . $aReportsResults[0]['allyOpposant'] . '] ' . ' ---</strong></span>
			<table width="570" border="0" class="resultatRCCombat">
				<thead><tr>
				<th width="21%"></th>
				<th width="15%"></th>
				<th width="13%"></th>
				<th width="21%"></th>
				<th width="15%"></th>
				<th width="15%"></th>
			</tr></thead>';
		// Pour chaque ligne du tableau
		for ($i = 0; $i < count($aReportsResults); $i++) {
			// Si le pseudo est le meme que celui qu'on traite
			if ($aReportsResults[$i]['pseudoOpposant'] == $processPseudo) {
				// Alors on l'affiche
				// Variables pour l'affichage de l'issue
				$issue = 'Perdue';
				$color = 'moins';
				if ($aReportsResults[$i]['victoire'] == true) {
					$issue = 'Gagnée';
					$color = 'plus';
				}
				echo '<tr>
						<td>' . $aReportsResults[$i]['planeteJoueur'] . '</td>
						<td>' . ' [' . $aReportsResults[$i]['coordonneesJoueur'] . '] ' . '</td>
						<td><span class="egal">' . $aReportsResults[$i]['direction'] . '</span></td>
						<td>' . $aReportsResults[$i]['planeteOpposant'] . '</td>
						<td>' . ' [' . $aReportsResults[$i]['coordonneesOpposant'] . ']  ' . '</td>
						<td><span class="' . $color . '">' . $issue . '</span></td>
					</tr>';
				// Enfin on supprime la ligne
				array_splice($aReportsResults, $i , 1);
				// Et de ce fait on recule la boucle
				$i -= 1;
			}
		}
		echo '</table>
			<br/>';
	}
	echo '<a class="link" href="#en_tete">Retour en haut de page</a>';
	echo '</div>';
}

?>
	</div>
</body>

</html>
