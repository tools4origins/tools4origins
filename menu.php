<?php

	$baseUrl=((defined('PUN')) ? '../' : '');
?>
<!-- L'en-tête -->
<div id="en_tete">
	<a href='index.php'><img src="<?php echo $baseUrl ?>images/banniere_espace.png" alt="banniere" /></a>
</div>


<!-- Les menus -->
<div id="menu">
	<div class="milieu">
		<div class="sdmenu" id="catMenu">
			<div class="collapsed">
				<span class="fVert">Alpha</span>
				<a href="<?php echo $baseUrl ?>classement_alpha.php">Classement</a>
				<a href="<?php echo $baseUrl ?>alliance_alpha.php">Alliance</a>
				<a href="<?php echo $baseUrl ?>cartographie_alpha.php">Cartographie</a>
				<a href="<?php echo $baseUrl ?>coo_alpha.php">Coordonnées</a>
				<a href="<?php echo $baseUrl ?>stats_alpha.php">Statistiques</a>
			</div>
			<div class="collapsed">
				<span class="fVert">Pegase</span>
				<a href="<?php echo $baseUrl ?>classement_pegase.php">Classement</a>
				<a href="<?php echo $baseUrl ?>alliance_pegase.php">Alliance</a>
				<a href="<?php echo $baseUrl ?>cartographie_pegase.php">Cartographie</a>
				<a href="<?php echo $baseUrl ?>coo_pegase.php">Coordonnées</a>
				<a href="<?php echo $baseUrl ?>stats_pegase.php">Statistiques</a>
			</div>
			<div class="collapsed">
				<span class="fVert">Orion</span>
				<a href="<?php echo $baseUrl ?>classement_orion.php">Classement</a>
				<a href="<?php echo $baseUrl ?>alliance_orion.php">Alliance</a>
				<a href="<?php echo $baseUrl ?>cartographie_orion.php">Cartographie</a>
				<a href="<?php echo $baseUrl ?>coo_orion.php">Coordonnées</a>
				<a href="<?php echo $baseUrl ?>stats_orion.php">Statistiques</a>
			</div>
			<div class="collapsed">
				<span class="fVert">Ida</span>
				<a href="<?php echo $baseUrl ?>classement_ida.php">Classement</a>
				<a href="<?php echo $baseUrl ?>alliance_ida.php">Alliance</a>
				<a href="<?php echo $baseUrl ?>cartographie_ida.php">Cartographie</a>
				<a href="<?php echo $baseUrl ?>coo_ida.php">Coordonnées</a>
				<a href="<?php echo $baseUrl ?>stats_ida.php">Statistiques</a>
			</div>
			<div class="collapsed">
				<span class="fVert">Eridan</span>
				<a href="<?php echo $baseUrl ?>classement_eridan.php">Classement</a>
				<a href="<?php echo $baseUrl ?>alliance_eridan.php">Alliance</a>
				<a href="<?php echo $baseUrl ?>cartographie_eridan.php">Cartographie</a>
				<a href="<?php echo $baseUrl ?>coo_eridan.php">Coordonnées</a>
				<a href="<?php echo $baseUrl ?>stats_eridan.php">Statistiques</a>
			</div>
			<div class="collapsed">
				<span class="fVert">Centaure</span>
				<a href="<?php echo $baseUrl ?>classement_centaure.php">Classement</a>
				<a href="<?php echo $baseUrl ?>alliance_centaure.php">Alliance</a>
				<a href="<?php echo $baseUrl ?>cartographie_centaure.php">Cartographie</a>
				<a href="<?php echo $baseUrl ?>coo_centaure.php">Coordonnées</a>
				<a href="<?php echo $baseUrl ?>stats_centaure.php">Statistiques</a>
			</div>
			<div class="collapsed">
				<span class="fVert">Taurus</span>
				<a href="<?php echo $baseUrl ?>classement_taurus.php">Classement</a>
				<a href="<?php echo $baseUrl ?>alliance_taurus.php">Alliance</a>
				<a href="<?php echo $baseUrl ?>cartographie_taurus.php">Cartographie</a>
				<a href="<?php echo $baseUrl ?>coo_taurus.php">Coordonnées</a>
				<a href="<?php echo $baseUrl ?>stats_taurus.php">Statistiques</a>
			</div>
			<div class="collapsed">
				<span class="fVert">Sateda</span>
				<a href="<?php echo $baseUrl ?>classement_sateda.php">Classement</a>
				<a href="<?php echo $baseUrl ?>alliance_sateda.php">Alliance</a>
				<a href="<?php echo $baseUrl ?>cartographie_sateda.php">Cartographie</a>
				<a href="<?php echo $baseUrl ?>coo_sateda.php">Coordonnées</a>
				<a href="<?php echo $baseUrl ?>stats_sateda.php">Statistiques</a>
			</div>
			<div class="collapsed">
				<span class="fRouge">Simulateurs</span>
				<a href="<?php echo $baseUrl ?>simulateur_vx.php">Combat Spatiaux</a>
				<a href="<?php echo $baseUrl ?>ska.php">Kidnapping/Assassinat</a>
				<a href="<?php echo $baseUrl ?>kamikaze.php">Kamikazage</a>
				<a href="<?php echo $baseUrl ?>camouflage.php">Camouflage</a>
				<a href="<?php echo $baseUrl ?>flotte.php">Vaisseaux</a>
				<a href="<?php echo $baseUrl ?>simu_def.php">Défenses</a>
				<a href="<?php echo $baseUrl ?>vol.php">Vol</a>
			</div>
			<div class="collapsed">
				<span class="fRouge">Analyseurs</span>
				<a href="<?php echo $baseUrl ?>puissance.php">Calculateur de PdF</a>
				<a href="<?php echo $baseUrl ?>analyseur_vx.php">Combat par Vaisseaux</a>
				<a href="<?php echo $baseUrl ?>analyseur_pde.php">Combat via Portail</a>
				<a href="<?php echo $baseUrl ?>analyseur_cdr.php">Recyclage</a>
				<a href="<?php echo $baseUrl ?>attaque.php">Coordinateur d'attaque</a>
				<a href="<?php echo $baseUrl ?>listeur.php">Générateur de liste</a>
			</div>
			<div class="collapsed">
				<span class="fRouge">Divers</span>
				<a href="<?php echo $baseUrl ?>convertisseur.php">Convertisseur</a>
				<a href="<?php echo $baseUrl ?>remerciement.php">Remerciements</a>
			<?php /*	<a href="<?php echo $baseUrl ?>forum/index.php">Forum</a> */ ?>
				<a href="<?php echo $baseUrl ?>contact.php">Nous contacter</a>
			</div>
		</div>
		
		<div class="directLink">
			<div class="lien_section"><a href="http://help.tools4origins.fr.nf/">Help4Origins</a></div>
			<div class="lien_section"><a href="http://adds.tools4origins.fr.nf/">Adds4Origins</a></div>
		</div>
	</div>
	

	<div class="message">
		Site hébergé chez :<br />
		<a href="http://www.free-h.org/" class="link img_free"><img src="<?php echo $baseUrl ?>images/free-h.gif" alt="Free-h"/></a>
	</div>

	<div class="message" style="padding-top:5px;">
<?php /*		<a href="<?php echo $baseUrl ?>forum/viewforum.php?id=5" class="link"><img src="<?php echo $baseUrl ?>images/bug.png" alt="Bug" class="img_fofo" title="Signaler un bug ou une erreur"/></a>
		<a href="<?php echo $baseUrl ?>forum/viewforum.php?id=4" class="link"><img src="<?php echo $baseUrl ?>images/idee.png" alt="Idee" class="img_fofo" title="Donner une idée"/></a>
		<a href="<?php echo $baseUrl ?>forum/viewforum.php?id=8" class="link"><img src="<?php echo $baseUrl ?>images/question.png" alt="Question" class="img_fofo" title="Poser une question"/></a>*/
?>		<a href="<?php echo $baseUrl ?>plan.php" class="link"><img src="<?php echo $baseUrl ?>images/map.png" alt="Map" class="img_fofo" title="Plan du site" /></a>
		<a href="mailto:tools4origins@gmail.com" class="link"><img src="<?php echo $baseUrl ?>images/mail.png" alt="Mail" class="img_fofo" title="Nous contacter"/></a>
	</div>
	<?php 
	if(0)//!defined('PUN'))
	{
		echo '<div class="message" style="padding:5px;">' . "\n";
		echo "\t\t" . '<span style="text-decoration:underline">Dernier message du <a href="forum/index.php" class="link">forum</a>:</span><br />' . "\n";
		if(1) //$_SERVER['HTTP_HOST']!='localhost')
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$sql = new PDO('mysql:host=sql1.free-h.org;dbname='+FORUM_DATABASE, FORUM_DATABASE_USERNAME, FORUM_DATABASE_PASSWD, $pdo_options);
			}
			catch (Exception $e)
			{
					die('Erreur : ' . $e->getMessage());
			}
			$retour = $sql->query('SELECT * FROM posts ORDER BY id DESC LIMIT 1');
			$lastMsg=$retour->fetch();
			echo '<span style="font-weight:bolder;">';
			echo '<a href="forum/viewtopic.php?pid=' . $lastMsg['id'] . '#p' . $lastMsg['id'] . '" class="link">' . $lastMsg['poster'] . ':</a>';
			echo '</span> ' . utf8_encode((substr(htmlspecialchars_decode($lastMsg['message']), 0, 50)));
			echo (strlen($lastMsg['message'])>50) ? '... ' : ' ';
			echo '<a href="forum/viewtopic.php?pid=' . $lastMsg['id'] . '#p' . $lastMsg['id'] . '" class="link"><img src="images/voirMsg.png" class="voirMsg" alt="Voir le dernier message" /></a>';
			$retour->closeCursor();
			$sql=NULL;
		}
	}
	?>
	</div>
</div>

<script type="text/javascript">
	// <![CDATA[
	var myMenu;
//	window.onload += function() {
		myMenu = new SDMenu("catMenu");
		myMenu.init();
	//};
	// ]]>
</script>

<?php
if(!defined('PUN'))
{
	$t4o=1;
	include('non_accessible/pub_droite.php');
	include('stats/stats.php');

}
else
	include('../stats/stats.php');
