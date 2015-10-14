<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
   <head>
       <title>Liste des news</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
        body
        {
			background-image:url('http://help.tools4origins.fr.nf/images/fond.jpg');
		}
        h2, th, td
        {
            text-align:center;
        }
        table
        {
            border-collapse:collapse;
            border:2px solid black;
            margin:auto;
            background-color:rgba(0,0,0,0.7);
            color:#ccc;
        }
        th, td
        {
            border:1px solid black;
        }
        a
        {
			color:#5596BF;
		}
		a:hover
		{
			color:#FFB400;
		}
        </style>
    </head>
    
    <body>
 
<h2><a href="rediger_news.php">Ajouter une news</a></h2>
<?php
include('../non_accessible/connect.php');
//-----------------------------------------------------
// Vérification 1 : est-ce qu'on veut poster une news ?
//-----------------------------------------------------
if (isset($_POST['titre']) AND isset($_POST['contenu']))
{
    $titre = addslashes($_POST['titre']);
    $contenu = addslashes($_POST['contenu']);
    // On vérifie si c'est une modification de news ou pas
    if ($_POST['id_news'] == 0)
    {
        // Ce n'est pas une modification, on crée une nouvelle entrée dans la table
        $sql->query("INSERT INTO news VALUES('', '" . $titre . "', '" . $contenu . "', '" . time() . "')");
    }
    else
    {
        // On protège la variable "id_news" pour éviter une faille SQL
        $_POST['id_news'] = addslashes($_POST['id_news']);
        // C'est une modification, on met juste à jour le titre et le contenu
        $sql->query("UPDATE news SET titre='" . $titre . "', contenu='" . $contenu . "' WHERE id='" . $_POST['id_news'] . "'");
    }
}
 
//--------------------------------------------------------
// Vérification 2 : est-ce qu'on veut supprimer une news ?
//--------------------------------------------------------
if (isset($_GET['supprimer_news'])) // Si on demande de supprimer une news
{
    // Alors on supprime la news correspondante
    // On protège la variable "id_news" pour éviter une faille SQL
//    $_GET['supprimer_news'] = addslashes($_GET['supprimer_news']);
//    $sql->query('DELETE FROM news WHERE id=\'' . $_GET['supprimer_news'] . '\'');
}
?>
<table><tr>
<th>Modifier</th>
<th>Titre</th>
<th>Date</th>
</tr>
<?php
$retour = $sql->query('SELECT * FROM news ORDER BY id DESC LIMIT 20');
while ($donnees = $retour->fetch()) // On fait une boucle pour lister les news
{
	echo '<tr>';
	echo '<td>' . '<a href="rediger_news.php?modifier_news=' . $donnees['id'] . '">' . 'Modifier</a></td>';
	//echo '<td>' . '<a href="liste_news.php?supprimer_news=' . $donnees['id'] . '">' . 'Supprimer</a></td>';
	echo '<td>' . stripslashes($donnees['titre']) . '</td>';
	echo '<td>' . date('d/m/Y', $donnees['timestamp']) . '</td>';
	echo '</tr>';
} // Fin de la boucle qui liste les news
?>
</table>
</body>
</html>

