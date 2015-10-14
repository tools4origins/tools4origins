<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
   <head>
       <title>Bergson - Voc En</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
        body
        {
			background-image:url('http://help.tools4origins.fr.nf/images/fond.jpg');
			color:#ccc;
		}
        h3, form
        {
            text-align:center;
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
<h3><a href="liste_news.php">Retour à la liste des news</a></h3>
<?php
include('../non_accessible/connect.php');
if (isset($_GET['modifier_news'])) // Si on demande de modifier une news
{
    // On protège la variable "modifier_news" pour éviter une faille SQL
    $_GET['modifier_news'] = htmlspecialchars($_GET['modifier_news']);
    // On récupère les infos de la news correspondante
    $retour = $sql->query('SELECT * FROM news WHERE id=\'' . $_GET['modifier_news'] . '\'');
    $donnees = $retour->fetch();
    
    // On place le titre et le contenu dans des variables simples
    $titre = stripslashes($donnees['titre']);
    $contenu = stripslashes($donnees['contenu']);
    $id_news = $donnees['id']; // Cette variable va servir pour se souvenir que c'est une modification
}
else // C'est qu'on rédige une nouvelle news
{
    // Les variables $titre et $contenu sont vides, puisque c'est une nouvelle news
    $titre = '';
    $contenu = '';
    $id_news = 0; // La variable vaut 0, donc on se souviendra que ce n'est pas une modification
}
?>
<form action="liste_news.php" method="post">
<p>Titre : <input type="text" size="30" name="titre" style="background-color:black;color:white;" value="<?php echo $titre; ?>" /></p>
<p>
    Contenu :<br />
    <textarea name="contenu" cols="150" rows="20" style="background-color:black;color:white;"><?php echo $contenu; ?></textarea><br />
    
    <input type="hidden" name="id_news" value="<?php echo $id_news; ?>" />
    <input type="submit" value="Envoyer" />
</p>
</form>
</body>
</html>

