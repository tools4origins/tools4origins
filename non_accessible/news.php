<?
include('non_accessible/connect.php');
// On récupère les 10 dernières news
$retour = $sql->query('SELECT * FROM news ORDER BY id DESC LIMIT 0, 8');
$liste='';
$news='';
$numeroNews=0;
while ($donnees = $retour->fetch())
{
	/* RESUME DES NEWS */
	$numeroNews++;
	$news .= '		<a href="#news' . $numeroNews . '" class="lien_news">';
	if($donnees['timestamp']>(time()-604800)) //7 jours
	{
		$news .= '<img src="images/new.png" class="imgNew" alt="New" /> ';
		$news .= '<span class="red">' . $donnees['titre'] . '</span>';
	}
	elseif($donnees['timestamp']>(time()-1296000)) //15j
	{
		$news .= '- ';
		$news .= '<span class="red">' . $donnees['titre'] . '</span>';
	}
	else
	{
		$news .= '- ';
		$news .= $donnees['titre'];
	}
	$news .= '</a><br />' . "\n";
	
	/* CONTENU DES NEWS */
	$liste .= "\t\t" . '<div class="titre_news" id="news' . $numeroNews . '">' . $donnees['titre'];
	$liste .= ' <div class="date">';
	$liste .= str_replace('Monday', 'Lundi', str_replace('Tuesday', 'Mardi', str_replace('Wednesday', 'Mercredi', str_replace('Thursday', 'Jeudi', str_replace('Friday', 'Vendredi', str_replace('Saturday', 'Samedi', str_replace('Sunday', 'Dimanche', str_replace('January', 'Janvier', str_replace('February', 'Février', str_replace('March', 'Mars', str_replace('April', 'Avril', str_replace('May', 'Mai', str_replace('June', 'Juin', str_replace('July', 'Juillet', str_replace('August', 'Ao&ucirc;t', str_replace('September', 'Septembre', str_replace('October', 'Octobre', str_replace('November', 'Novembre', str_replace('December', 'Décembre', date('l d F', $donnees['timestamp']))))))))))))))))))));
	$liste .= '</div>';
	$liste .= '</div>' . "\n";
	$liste .= "\t\t" . '<div class="texte_news">' . "\n";
//	$liste .= $donnees['contenu'];
	$liste .= "\t\t\t" . str_replace("<br />\r\n", "<br />", nl2br(str_replace('<center>', '<div style="width:100%; text-align:center;">', str_replace('</center>', '</div>', str_replace('&', '&amp;', stripslashes($donnees['contenu'])))))) . "\n";
	$liste .= "\t\t" . '</div>' . "\n";
	$liste .= "\n"; 

}

echo '<div id="cadre_resume_news">' . "\n";
echo "\t" . '<div id="contenu_resume_news">' . "\n";
//echo "\t\t" . 'Commentez les derni&egrave;res news <a href="forum/index.php" class="link">ici</a> :<br />' . "\n";
echo "\t\t" . 'Derni&egrave;res news :<br />' . "\n";
echo $news;
echo "\t" . '</div>' . "\n";
echo "\t" . '</div>' . "\n";
echo "\t" . '<div id="conteneur_screen">'. "\n";
echo "\t\t" . '<div id="screen">'. "\n";
include('stats/sondage.php');
echo "\t\t" . '</div>'. "\n";
echo "\t" . '</div>'. "\n";
echo "\t" . '<div id="contenu_news">' . "\n";
echo $liste . "\n";
echo "\t" . '</div>' . "\n";
