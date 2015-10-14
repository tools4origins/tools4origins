<?php

if(!isset($t4o))
	$chemin='../';
else
	$chemin='';

/* ----------------------------------- NOMBRE DE VISITES ---------------------------------------------- */
$fichierVisiteurs = fopen($chemin . 'stats/visiteurs.txt', 'r+');
$nb_visites = (int) fgets($fichierVisiteurs); // Lecture du nombre de visiteurs
$nb_visites++; // Incrémentation du nombre de visites
fseek($fichierVisiteurs, 0); // Réinitialisation du curseur
fwrite($fichierVisiteurs, $nb_visites); // On écrit le nombre de visites obtenu
 
fclose($fichierVisiteurs); // On ferme le fichier

/* ----------------------------------- NOMBRE DE VISITES AUJOURD'HUI ---------------------------------------------- */

	include($chemin . 'non_accessible/connect.php');
//ETAPE 1 - Affichage du nombre de visites d'aujourd'hui
	$retour_count = $sql->query('SELECT COUNT(*) AS nbre_entrees FROM visites_jour WHERE date=CURRENT_DATE()');//On compte le nombre d'entrées pour aujourd'hui
	$donnees_count = $retour_count->fetch(); //Fetch-array
	$retour_count->closeCursor();
//	echo 'Pages vues aujourd\'hui : <strong>'; // On affiche tout de suite pour pas le retaper 2 fois après
	
    if ($donnees_count['nbre_entrees'] == 0) //Si la date d'aujourd'hui n'a pas encore été enregistrée (première visite de la journée)
	{
		$sql->query('INSERT INTO visites_jour(visites, date) VALUES (1, CURRENT_DATE());'); //On rentre la date d'aujourd'hui et on marque 1 comme nombre de visites.
		//echo '1'; //On affiche une visite car c'est la première visite de la journée
	}
	else
	{ //Si la date a déjà été enregistrée
		$retour = $sql->query('SELECT visites FROM visites_jour WHERE date=CURRENT_DATE()'); //On sélectionne l'entrée qui correspond à notre date
		$donnees = $retour->fetch();
		$visites = $donnees['visites'] + 1; //Incrémentation du nombre de visites
		$sql->query('UPDATE visites_jour SET visites = visites + 1 WHERE date=CURRENT_DATE()'); //Update dans la base de données
		//echo $visites; //Enfin, on affiche le nombre de visites d'aujourd'hui !
	}
//	echo '</strong></br/>';

//ETAPE 2 - Record des connectés par jour
	
	$retour_max = $sql->query('SELECT visites, date FROM visites_jour ORDER BY visites DESC LIMIT 0, 1'); //On sélectionne l'entrée qui a le nombre visite le plus important
	$donnees_max = $retour_max->fetch();
//	echo 'Record : <strong>' . $donnees_max['visites'] . '</strong> établi le <strong>' . $donnees_max['date'] . '</strong><br/>'; //On l'affiche ainsi que la date à laquelle le record a été établi

//ETAPE 3 - Moyenne du nombre de visites par jour
	$total_visites = 0; //Nombre de visites
    /*(pour éviter les bugs on ne prendra pas le nombre du premier exercice, 
	mais celui-ci reste utile pour être affiché sur toutes les pages car il est plus rapide, 
	contrairement à $total_visites dont on ne se servira que pour la page de stats)*/
	
	$total_jours = 0;//Nombre de jours enregistrés dans la base

    $retour = $sql->query('SELECT SUM(visites) AS total_visites FROM visites_jour');
    $total_visites = $retour->fetch();
	$total_visites = $total_visites['total_visites'];
	$retour->closeCursor();

	$retour = $sql->query('SELECT COUNT(*) AS total_jours FROM visites_jour');
	$total_jours = $retour->fetch();
    $total_jours = $total_jours['total_jours'];
    $retour->closeCursor();

	$moyenne = $total_visites/$total_jours; //on fait la moyenne
//	echo 'Moyenne : <strong>' . $moyenne . '</strong> visiteurs par jour<br/>'; // On affiche ! Terminé !!!

/* ----------------------------------- Nombre de visiteur connectées ---------------------------------------------- */
//On prend l'adresse de la page à laquelle on enlève le \ du début (1er caractère) :
$page = substr($_SERVER['PHP_SELF'], 1);
// On stocke dans une variable le timestamp qu'il était il y a 5 minutes :
$timestamp_5min = time() - (60 * 5); // 60 * 5 = nombre de secondes écoulées en 5 minutes
//On commence par virer les entrées trop vieilles (+ de 5 minutes)
$sql->query('DELETE FROM connectes WHERE timestamp < ' . $timestamp_5min);
$retour = $sql->query('SELECT COUNT(*) AS nb_connectes FROM connectes WHERE ip=\'' . ip2long($_SERVER['REMOTE_ADDR']) . '\'');
$donnees = $retour->fetch(); //On regarde si le visiteur est déjà dans la table
$retour->closeCursor();

if ($donnees['nb_connectes'] == 0) // Si il n'y est pas, on l'ajoute
{
//	echo time();
    $sql->query('INSERT INTO connectes(ip, timestamp, page) VALUES(\'' . ip2long($_SERVER['REMOTE_ADDR']) . '\', ' . time() . ', \'' . $page . '\')');
}
else // Sinon, on remet le décompte de 5 minutes à 0
{
//	echo "bbbb";
    $sql->query('UPDATE connectes SET timestamp=' . time() . ', page=\'' . $page . '\' WHERE ip=\'' . ip2long($_SERVER['REMOTE_ADDR']) . '\'');
}

//Enfin, on calcule le nombre total d'entrées puis on l'affiche !
$retour = $sql->query('SELECT COUNT(*) AS nb_connectes FROM connectes');
$donnees = $retour->fetch();
$retour->closeCursor();

$visiteurs_connectes = $donnees['nb_connectes'];
// Affichage
//echo 'Visiteurs connectés : <strong>' . $donnees['nb_connectes'] . '</strong><br/>';

$f_records = fopen($chemin . 'stats/records.txt', 'r+'); //On ouvre le fichier
$dernierRecord = fgets($f_records); //On prend sa première ligne
$dernierRecord = explode(' ', $dernierRecord); //Je vous avais dit de regarder la fonction explode !
//Elle va permettre de séparer notre fichier en 2 parties :
//Le record (0) dans $dernierRecord[0] et la date (0/0/0) dans $dernierRecord[1]
//echo 'Record du nombre de connectés : <strong>'; //On le marque tout de suite
//Ici on va avoir besoin de la variable $visiteurs_connectes de l'exercice précédent

if ($visiteurs_connectes > $dernierRecord[0]) //Si le nombre de connecté est plus important que le record actuel
{
	rewind($f_records); //On "rebobine " le fichier
	$ligne = $visiteurs_connectes . ' ' . date('d/m/Y'); 
	fwrite($f_records, $ligne); //On écrit la ligne sous la forme fixée au départ
	//echo $visiteurs_connectes . '</strong> établi le <strong>' . date('d/m/Y');
} //else { //sinon, on affiche le record du fichier.
	//echo $dernierRecord[0] . '</strong> établi le <strong>' . $dernierRecord[1];
//}

// On ferme la balise puis le fichier
//echo '</strong><br/>'; 
fclose($f_records); 

/* ----------------------------------- Affichage de la liste des connectés ---------------------------------------------- */
//echo '<strong>Liste des connectés : </strong>(' . $visiteurs_connectes . ')<br/>';
/*$retour = $sql->query('SELECT ip, page FROM connectes');
while ($donnees = mysql_fetch_assoc($retour))
{
	echo long2ip($donnees['ip']) . ' : ' . $donnees['page'] . '<br />';
}*/

if($_SERVER['HTTP_HOST']!='localhost')
{
echo '<script type="text/javascript">  var _gaq = _gaq || [];_gaq.push([\'_setAccount\', \'UA-15079637-2\']);_gaq.push([\'_trackPageview\']);(function() {    var ga = document.createElement(\'script\');ga.type = \'text/javascript\';ga.async = true;ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';var s = document.getElementsByTagName(\'script\')[0];s.parentNode.insertBefore(ga, s);})();</script>';
}
?>

