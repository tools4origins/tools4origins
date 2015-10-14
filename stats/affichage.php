<?php error_reporting(E_ALL); ?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stats</title>
</head>
<body><?php

echo '<u>Statistique du site depuis le 19/02/2010:</u><br />';
/* ----------------------------------- NOMBRE DE VISITES ---------------------------------------------- */
$fichierVisiteurs = fopen('visiteurs.txt', 'r+');
$nb_visites = (int) fgets($fichierVisiteurs); // Lecture du nombre de visiteurs
echo 'Nombre de visites : ' . $nb_visites . '<br />';
fclose($fichierVisiteurs); // On ferme le fichier

echo '<b>SQL:</b> Depuis le 4 juillet 2010, 15h35 au 30 décembre 2010, 20h<br />';
/* ----------------------------------- NOMBRE DE CONNEXION ---------------------------------------------- */
$fichierConnexions = fopen('SQLconnect.txt', 'r+');
$nb_connect = (int) fgets($fichierConnexions); // Lecture du nombre de visiteurs
echo '<b>SQL:</b> Nombre de connexions : ' . $nb_connect . '<br />';
fclose($fichierConnexions); // On ferme le fichier

/* ----------------------------------- NOMBRE DE REQUETES ---------------------------------------------- */
$fichierRequetes = fopen('SQLquery.txt', 'r+');
$nb_query = (int) fgets($fichierRequetes); // Lecture du nombre de visiteurs
echo '<b>SQL:</b> Nombre de requetes : ' . $nb_query . '<br />';
fclose($fichierRequetes); // On ferme le fichier

/* ----------------------------------- NOMBRE DE VISITES AUJOURD'HUI ---------------------------------------------- */
include('../non_accessible/connect.php');
//ETAPE 1 - Affichage du nombre de visites d'aujourd'hui
	$retour_count = $sql->query('SELECT COUNT(*) AS nbre_entrees FROM visites_jour WHERE date=CURRENT_DATE()');//On compte le nombre d'entrées pour aujourd'hui
	$donnees_count = $retour_count->fetch(); //Fetch-array
	echo 'Pages vues aujourd\'hui : <strong>'; // On affiche tout de suite pour pas le retaper 2 fois après
	
    if ($donnees_count['nbre_entrees'] == 0) //Si la date d'aujourd'hui n'a pas encore été enregistrée (première visite de la journée)
	{
		echo '0'; //On affiche une visite car c'est la première visite de la journée
	}
	else
	{ //Si la date a déjà été enregistrée
		$retour = $sql->query('SELECT visites FROM visites_jour WHERE date=CURRENT_DATE()'); //On sélectionne l'entrée qui correspond à notre date
		$donnees = $retour->fetch();
		$visites = $donnees['visites']; //Incrémentation du nombre de visites
		echo $visites; //Enfin, on affiche le nombre de visites d'aujourd'hui !
	}
	echo '</strong></br/>';

//ETAPE 2 - Record des connectés par jour
	
	$retour_max = $sql->query('SELECT visites, date FROM visites_jour ORDER BY visites DESC LIMIT 0, 1'); //On sélectionne l'entrée qui a le nombre visite le plus important
	$donnees_max = $retour_max->fetch();
	echo 'Record : <strong>' . $donnees_max['visites'] . '</strong> établi le <strong>' . $donnees_max['date'] . '</strong><br/>'; //On l'affiche ainsi que la date à laquelle le record a été établi

//ETAPE 3 - Moyenne du nombre de visites par jour
	$total_visites = 0; //Nombre de visites
    /*(pour éviter les bugs on ne prendra pas le nombre du premier exercice, 
	mais celui-ci reste utile pour être affiché sur toutes les pages car il est plus rapide, 
	contrairement à $total_visites dont on ne se servira que pour la page de stats)*/
	
	$total_jours = 0;//Nombre de jours enregistrés dans la base

    $total_visites = $sql->query('SELECT SUM(visites) AS total_visites FROM visites_jour')->fetch();
	$total_visites = $total_visites['total_visites'];

	$total_jours = $sql->query('SELECT COUNT(*) AS total_jours FROM visites_jour')->fetch();
    $total_jours = $total_jours['total_jours'];

	$moyenne = $total_visites/$total_jours; //on fait la moyenne
	echo 'Moyenne : <strong>' . ceil($moyenne) . '</strong> visites par jour<br/>'; // On affiche ! Terminé !!!

/* ----------------------------------- Nombre de visiteur connectées ---------------------------------------------- */

// On stocke dans une variable le timestamp qu'il était il y a 5 minutes :
$timestamp_5min = time() - (60 * 5); // 60 * 5 = nombre de secondes écoulées en 5 minutes
//On commence par virer les entrées trop vieilles (+ de 5 minutes)
$sql->query('DELETE FROM connectes WHERE timestamp < ' . $timestamp_5min);

//Enfin, on calcule le nombre total d'entrées puis on l'affiche !
$retour = $sql->query('SELECT COUNT(*) AS nb_connectes FROM connectes');
$donnees = $retour->fetch();
$visiteurs_connectes = $donnees['nb_connectes'];
// Affichage
echo 'Visiteurs connectés : <strong>' . $donnees['nb_connectes'] . '</strong><br/>';

$f_records = fopen('records.txt', 'r+'); //On ouvre le fichier
$dernierRecord = fgets($f_records); //On prend sa première ligne
$dernierRecord = explode(' ', $dernierRecord); //Je vous avais dit de regarder la fonction explode !
//Elle va permettre de séparer notre fichier en 2 parties :
//Le record (0) dans $dernierRecord[0] et la date (0/0/0) dans $dernierRecord[1]
echo 'Record du nombre de connectés : <strong>'; //On le marque tout de suite
//Ici on va avoir besoin de la variable $visiteurs_connectes de l'exercice précédent

if ($visiteurs_connectes > $dernierRecord[0]) //Si le nombre de connecté est plus important que le record actuel
{
	rewind($f_records); //On "rebobine " le fichier
	$ligne = $visiteurs_connectes . ' ' . date('d/m/Y'); 
	fwrite($f_records, $ligne); //On écrit la ligne sous la forme fixée au départ
	echo $visiteurs_connectes . '</strong> établi le <strong>' . date('d/m/Y');
} else { //sinon, on affiche le record du fichier.
	echo $dernierRecord[0] . '</strong> établi le <strong>' . $dernierRecord[1];
}

// On ferme la balise puis le fichier
echo '</strong><br/>'; 
fclose($f_records); 

/* ----------------------------------- Affichage de la liste des connectés ---------------------------------------------- */
echo '<br /><strong><u>Pages actuellement vues : </u></strong>(' . $visiteurs_connectes . ')<br/>';
$retour = $sql->query('SELECT ip, page FROM connectes');
while ($donnees = $retour->fetch())
{
	echo  $donnees['page'] . ': ' . long2ip($donnees['ip']) . '<br />';
}




	
$retour->closeCursor();

?>
</body>
</html>
