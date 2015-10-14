<?php 
if(substr_count($_SERVER["HTTP_USER_AGENT"], 'MSIE '))
{
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo '<link rel="shortcut icon" href="images/favicon.png" />';
	echo '<link rel="stylesheet" media="screen" type="text/css" title="Design Espace" href="design_espace.css" />';
	echo '</head><body>';
	echo '<div id="en_tete">';
	echo '<a href=\'index.php\'><img src="images/banniere_espace.png" alt="banniere" /></a>';
	echo '</div>';
	echo '<div id="corps_index">';

	echo '<h1 style="font-size:20px; text-align:center;">LE WEBMASTER DE CE SITE REFUSE DE L\'AFFICHER SUR INTERNET EXPLORER</h1>';
	echo '<br/><h2 style="font-size:18px;" >Cause :</h2>';
	echo '<p style="font-size:15px;">Internet Explorer refuse de respecter les standards du web et, par consequent, de nombreuses fonctionnalités ne fonctionnent pas sous ce navigateur ou nécéssitent une attention particulière qui ne devrais pas être nécéssaire normalement.</p>';
	echo '<br/><h2 style="font-size:18px;" >Solution :</h2>';
	echo '<p style="font-size:15px;">Telécharger un des ces navigateurs :</p>';
	echo '<ul style="padding-left:10px; margin:0;">';
	echo '<li><a href="http://www.google.ch/chrome?hl=fr" title="Télécharger Google Chrome" class="link">Télécharger Google Chrome</a></li>';
	echo '<li><a href="http://www.mozilla-europe.org/fr/firefox/" title="Télécharger FireFox" class="link">Télécharger Firefox</a></li>';
	echo '<li><a href="http://www.opera.com/browser/download/" title="Télécharger Opera" class="link">Télécharger Opera</a></li>';
	echo '</ul>';
	echo '<p>Plus d\'information: tools4origins@gmail.com</p>';
	echo '</div>';
	echo '</body>';
	echo '</html>';
	exit();
}
elseif(0 AND $_SERVER['HTTP_HOST']!='localhost' AND $_SERVER['REMOTE_ADDR']!='78.112.250.82') //MAINTENANCE
{
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo '<link rel="shortcut icon" href="images/favicon.png" />';
	echo '<link rel="stylesheet" media="screen" type="text/css" title="Design Espace" href="design_espace.css" />';
	echo '</head><body>';
	echo '<div id="en_tete">';
	echo '<a href=\'index.php\'><img src="images/banniere_espace.png" alt="banniere" /></a>';
	echo '</div>';
	echo '<div id="corps_index">';

	echo '<h1 style="font-size:20px; text-align:center;">Tools4Origins est actuellement en maintenance</h1>';
	echo 'Comme annoncé précédement, le site subi actuellement une mise à jour majeure empechant son utilisation. Il devrait redevenir fonctionnel prochainement.<br /><br />';
	echo 'En cas de problème ou si la maintenance perdure jusqu\'à après le 31/12/10 à 18h: tools4origins@gmail.com<br /><br />';
	echo 'Veuillez nous excusez de la gêne occasionnée.<br /><br />';
	echo '<b>Mise à Jour 19h27:</b> La première partie concernant le remplacement des fichiers est terminé, nous nous attaquons à la base de données mais cela devrait prendre plus de temps.<br />';
	echo '<b>Mise à Jour 21h05:</b> Petit problème de notre hébergeur, on a dû interrompre le remplacement de la BDD, on espère que ça refonctionnera à nouveau rapidement.<br />';
	echo '<b>Mise à Jour 01h17:</b> Le soucis avec l\'hébergeur a rapidement été résolu (il était dû à une panne matériel) et la mise à jour s\'est continuée. La BDD est remplacée et nous entrons dans la dernière phase de la mise à jour qui consiste à vérifier que des bugs ne sont pas apparus.<br />';
	echo '</div>';
	echo '</body>';
	echo '</html>';
	exit();
}
else
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-site-verification" content="F69dbAAcY_J9U-0upCoJjCrTOp6t6d5idtVakVEio2U" />
<link rel="shortcut icon" href="images/favicon.png" />
<link rel="stylesheet" media="screen" type="text/css" title="Design Espace" href="design_espace.css" />
<script type="text/JavaScript" src="js/sdmenu.js"></script>';
?>