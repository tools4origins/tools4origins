<?php
$dejaVote=0;															//Variable indiquant si quelqu'un a déjà voté (donc s'il peut voter oupa)

$fichierSondage = fopen('stats/sondage.txt', 'a+');
$sondage = fread($fichierSondage, filesize('stats/sondage.txt'));
$sondage = explode("\n", $sondage);
fclose($fichierSondage); // On ferme le fichier Sondage

if(isset($sondage[2])) //S'il  y a un sondage actuellement, on l'affiche
{
	echo '<span style="color: rgb(255, 180, 0); font-weight: bold;">Sondage: </span>';
	/* -------------------------- VERIFICATION DE L'IP -------------------------- */
	$fichierIps = fopen('stats/ips.txt', 'a+');						//On ouvre le fichier en lecture et écriture
	$ips = fread($fichierIps, filesize('stats/ips.txt')); 		//Et on lis ce qu'il y a dedans.
	if(substr_count($ips, $_SERVER['REMOTE_ADDR'])!=0)
		$dejaVote=1;

	if(!isset($_POST['choix']) AND $dejaVote==0)
	{
		echo '<form method="post" action="index.php"><p style="align:center">' . "\n";
		echo $sondage[0] . ':<br />' . "\n";
		echo '<table style="width:100%">';
		for($ligne=1; !substr_count($sondage[$ligne], '---'); $ligne++)
		{
			echo '<tr><td><input type="radio" name="choix" value="choix_' . $ligne . '" id="choix_' . $ligne . '" /></td><td><label for="choix_' . $ligne . '">' . $sondage[$ligne] . '</label></td></tr>';
		}
		echo '</table>
		<input type="submit" value="Voter" />';
		echo '</p></form><br />';
		$dejaVote=0;
	}
	elseif(isset($_POST['choix']) AND $dejaVote==0)
	{
		$voteUtilisateur=(int) str_replace('choix_', '', $_POST['choix']);	//On regarde ce que l'utilisateur a voté
		$fichierVotes = fopen('stats/votes.txt', 'r');						//On ouvre le fichier en lecture
		$votes = fread($fichierVotes, filesize('stats/votes.txt')); 		//Et on lis ce qu'il y a dedans.
		$votes = explode(':', $votes);										//On fais un explode pour avoir un array
		$votes[--$voteUtilisateur]++;										//On incrémente dans l'array le nombre de vote là où l'utilisateur à voté
		$votes=implode(':', $votes);										//On utilise implode pour revenir à une chaine
		fclose($fichierVotes);												//On ferme le fichier
		$fichierVotes = fopen('stats/votes.txt', 'w');						//On ouvre le fichier en écriture (ce qui le vide)
		fputs($fichierVotes, $votes);										//On met la chaine
		fclose($fichierVotes);												//On referme le fichier
		fputs($fichierIps, $_SERVER['REMOTE_ADDR'] . "\n");
		$dejaVote=1;														//On indique que l'utilisateur a voté.
		/*if($voteUtilisateur==3)
			echo '<span class="red">Pourquoi cela?</span><br/><iframe style="border:0;height:40px;" scrolling="no" src="http://tools4origins.fr.nf/stats/rep_sondage.php"></iframe><br />';*/
	}
	if($dejaVote)
	{
		$fichierVotes = fopen('stats/votes.txt', 'r');						//On ouvre le fichier en lecture
		$votes = fread($fichierVotes, filesize('stats/votes.txt')); 		//Et on lis ce qu'il y a dedans.
		$votes = explode(':', $votes);										//On fais un explode pour avoir un array
		$nombreDeVoteTotal=0;
		foreach($votes AS $choix=>$nombreDeVote)							//Petite boucle pour connaitre le nombre de vote en tout
				$nombreDeVoteTotal+=$nombreDeVote;
		echo $sondage[0] . ':<br />' . "\n";								//On affiche la question
		echo '<table>';														//On affiche les résultat dans un tableau
		foreach($votes AS $choix=>$nombreDeVote)
		{
			if($sondage[$choix+1]=='---') 									//Si on est arrivé au dernier choix
				break;														//On arrete la boucle
			else															//Sinon
			{
				$pourcent=round(100*$nombreDeVote/$nombreDeVoteTotal);		//Pourcentage de personne ayant coché ce choix
				echo '<tr><td style="width:300px;">' .  $sondage[$choix+1] . '</td><td>' . $pourcent . '%</td><td><div style="background-color:#009cff;-moz-border-radius:3px;-webkit-border-radius:3px;height:15px;width:' . ($pourcent+6) . 'px;font-size:12px;"></div></td></tr>'; //On affiche le résultat dans une ligne
			}
		}
		echo '</table>';
		if($nombreDeVoteTotal<=1)
			echo '<i>' . $nombreDeVoteTotal . ' utilisateur a voté.</i>';
		else
			echo '<i>' . $nombreDeVoteTotal . ' utilisateurs ont votés.</i>';
		fclose($fichierVotes);												//On referme le fichier
	}
	fclose($fichierIps); // On ferme le fichier Ips
}
elseif(!isset($_GET['p']) && $_SERVER['HTTP_HOST']!='localhost') //S'il n'y a pas de sondage, on affiche une bannière
{
		echo "\n" . '<script type="text/javascript">google_ad_client = "ca-pub-1565720051377675";google_ad_slot = "4882937337";google_ad_width = 300;google_ad_height = 250;</script>';
		echo '<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script></script>';
}
?>
