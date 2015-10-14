<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Analyseur de rapports de combats par Vaisseau</title>
	<?php include('non_accessible/head.php'); ?>
</head>

<body>
<?php
include('menu.php'); //Menu du site*/
?>

<!-- Le corps -->
	<div id="corps"><div style="text-align:center"><h2>Analyseur de recyclage de champs de ruines</h2>
		<u>Collez ici vos rapports de recyclage (Date et titre inclus) :</u>
		<form method='post' action="analyseur_cdr.php"> <!--DEBUT DU FORMULAIRE-->
			<input type="hidden" name="afficher" />
			<p>
				<textarea name="rc" id="rc" cols="75" rows="10" ><?php
if (isset($_POST['rc'])) { // Si le formulaire a ete envoye
	$_POST['rc'] = htmlspecialchars($_POST['rc']);
	$_POST['rc'] = stripslashes($_POST['rc']);
	echo $_POST['rc']; //Remplit la zone de texte avec ce qui a ete envoye
}
?></textarea>
				<br />
				<u>(Optionnel) Valeurs initiales du champ de ruines recyclé :</u>
				<br />
				<label for="iron">Fer : </label>
				<input type="text" name="iron" id="iron" value="<?php if (isset($_POST['iron'])) echo htmlspecialchars($_POST['iron']) ?>" />
				<!--<br>
				<label for="iron">Or : </label>
				<input type="text" name="gold" id="gold" value="<?php if (isset($_POST['gold'])) echo htmlspecialchars($_POST['gold']) ?>" />
				<br>
				<label for="iron">Cristal : </label>
				<input type="text" name="crystal" id="crystal" value="<?php if (isset($_POST['crystal'])) echo htmlspecialchars($_POST['crystal']) ?>" />-->
				<br />
				<br />
				<input type="submit" value="Analyser" />
			</p>
		</form>
	</div>
	<?php
	
	class GraphicPercent
	{
		//Constantes de couleur
		const COLOR_NORMAL = 255;
		const COLOR_DARK = 200;
		
		//Constantes de fond
		const BG_BRIGHT = 'CCCCCC';
		const BG_DARK = '333333';
		
		//Constantes de type
		const HTML = 0;
		const BBCODE = 1;
		
		private static function hexFromDec( $dec )
		{
			$hexaRefs = '0123456789ABCDEF';
			return ( $hexaRefs[floor($dec / 16)] . $hexaRefs[$dec % 16] );
		}
		
		private static function colorPercent( $percent, $color )
		{
			//Calcule les composantes RGB
			if ($percent <= 50) {
				$red = $color;
				$green = round(($color / 100) * $percent * 2);
			} else {
				$red = round($color - ($color / 100) * ($percent - 50) * 2);
				$green = $color;
			}		
			$blue = 0;
			
			//Convertit en hexadecimal
			$hexaColor = self::hexFromDec($red) . self::hexFromDec($green) . self::hexFromDec($blue);		
			
			//Retourne la couleur
			return $hexaColor;
		}
		
		public static function showPercent( $percent, $colorIntensity, $type )
		{
			//Verifie que le pourcentage est valide
			if ($percent < 0 || $percent > 100)
				return '<i>Erreur de pourcentage</i>';

			if ( $type == self::HTML )
				return ( '<font color="#' . self::colorPercent($percent, $colorIntensity) . '">' . $percent . '%</font>' );
			else
				return ( '[b][color=#' . self::colorPercent($percent, $colorIntensity) . ']' . $percent . '%[/color][/b]' );
		}
			
		public static function showBar( $percent, $colorIntensity, $backgroundColor, $type )
		{
			//Verifie que le pourcentage est valide
			if ($percent < 0 || $percent > 100)
				return '<i>(Erreur de pourcentage)</i>';
			
			$barString = null;
			$roundedPercent = floor($percent / 5);
			
			if ( $type == self::HTML ) {
				$barString .= '<B>';
				
				//Partie de la barre coloree html
				for ($i = 0; $i < $roundedPercent; $i++)
					$barString .= '<font color="#' . self::colorPercent($i * 5, $colorIntensity) . '">|</font>';
				
				//Partie de la barre vide html
				for ($i = $roundedPercent + 1; $i <= 20; $i++) 
					$barString .= '<font color="#' . $backgroundColor . '">|</font>';
				
				$barString .= '</B>';
					
			} else {
				$barString .= '[b]';
				
				//Partie de la barre coloree bbcode
				for ($i = 0; $i <= $roundedPercent; $i++)
					$barString .= '[color=#' . self::colorPercent($i * 5, $colorIntensity) . ']|[/color]';
				
				//Partie de la barre vide bbcode
				for ($i = $roundedPercent + 1; $i <= 20; $i++)
					$barString .= '[color=#' . $backgroundColor . ']|[/color]';
				
				$barString .= '[/b]';
			}
			
			return $barString;
		}
	}
	
	class AnalyzeCDR
	{
		private $txtReport;
		private $recyclingDate;
		private $recycledPlanet;
		private $iron;
		private $gold;
		private $crystal;
		
		public function AnalyzeCDR( $txt )
		{
			$this->txtReport = $txt;
		}
		
		public function analyze()
		{
			$this->recyclingDate = $this->getReportDate();
			$this->recycledPlanet = $this->getRecycledPlanet();
			$this->getCollectedRessources();
		}
		
		private function getReportDate()
		{
			preg_match("#([0-9]+)/([0-9]+)/([0-9]+) ([0-9]+):([0-9]+):([0-9]+)#" , $this->txtReport, $regexMatch);
			return $regexMatch[0];
		}
		
		private function getRecycledPlanet()
		{
			preg_match("#Vaisseaux ruines \[(.*)\]#" , $this->txtReport, $regexMatch);
			return $regexMatch[1]; //Planete en $1 du regex
		}
		
		private function getCollectedRessources()
		{
			//preg_match("#([0-9.]+) [a-zA-Z]+#" , $this->txtReport, $regexMatch);
			preg_match_all("#([0-9.]+) [a-zA-Z]+#" , $this->txtReport, $regexMatch);
			$this->iron = str_replace('.', '', $regexMatch[1][0]);
			$this->gold = str_replace('.', '', $regexMatch[1][1]);
			$this->crystal = str_replace('.', '', $regexMatch[1][2]);
		}
		
		public function getRecyclingDate() { return $this->recyclingDate; }
		
		public function getIron() { return $this->iron; }
		public function getGold() { return $this->gold; }
		public function getCrystal() { return $this->crystal; }
		
		public function getIronValue()
		{
			return $this->iron + $this->gold * 1.25 + $this->crystal * 2.5;
		}
	}
		
	function Sep($value)
	{
		return number_format($value, 0, ",", ".");
	}
	function GetIronValue($iron, $gold, $crystal, $hydrogen)
	{
		return $iron + $gold * 1.25 + $crystal * 2.5 + $hydrogen * 5;
	}
	
	if (isset($_POST['rc'])) {
		//--TRAITEMENT
		// Epure le rapport
		$_POST['rc'] = htmlspecialchars($_POST['rc']);
		// stripslashes( $_POST['rc'] );
		// Recupere les dates et heure qui seront supprimee lors du split
		preg_match_all("#([0-9]+)/([0-9]+)/([0-9]+) ([0-9]+):([0-9]+):([0-9]+)#" , $_POST['rc'], $aDates);
		// Separe les rapports
		$aReports = preg_split("#([0-9]+)/([0-9]+)/([0-9]+) ([0-9]+):([0-9]+):([0-9]+)#", $_POST['rc'], -1, PREG_SPLIT_NO_EMPTY);
		// Verifie la validite du POST
		if (count($aDates[0]) < 1) { // Si on a pas trouve une seule date
			echo "Veuillez coller au moins un rapport complet (Date et titre inclus)<br/>"; //Message d'erreur
			exit;
		}
		// Verifie que la premiere valeur du tableau n'est pas vide
		if (substr($_POST['rc'], 0, 2) != $aDates[1][0]) // Si le debut du POST est different du debut de la date
			array_splice($aReports, 0 , 1); //Alors on supprime la premiere valeur du tableau
		// Verifie la validite du POST
		if (count($aDates[0]) != count($aReports)) { // Si on a un nombre de dates different du nombre de rapports
			echo "Veuillez coller des rapports valides (Date et titre inclus)<br/>"; //Message d'erreur
			exit;
		}
		
		$aAnalizedReports = array();
		
		// Parcourt les rapports
		for ($i = 0; $i < count($aReports); $i++) {
			// Ajoute la date supprimee au debut du rapport
			$aReports[$i] = $aDates[0][$i] . $aReports[$i];
			
			//Si le rapport est celui d'arrivee des vaisseaux a destination
			if (substr_count($aReports[$i], "Retour") == false) {
				$aAnalizedReports[count($aAnalizedReports)] = new AnalyzeCDR($aReports[$i]);
			}
		}
		
		// Tabeaux des ressources totales (Fer, Or, Cristal, Valeur Fer)
		//$totalResourcesRecycled = array (0, 0, 0, 0);
		$totalResourcesRecycled = array (
			'iron' => 0,
			'gold' => 0,
			'crystal' => 0,
			'ironValue' => 0);
		
		// Lance le traitement de tous les rapports valides trouves
		for ($i = 0; $i < count($aAnalizedReports); $i++) {
			$aAnalizedReports[$i]->analyze();
			
			$totalResourcesRecycled['iron'] += $aAnalizedReports[$i]->getIron();
			$totalResourcesRecycled['gold'] += $aAnalizedReports[$i]->getGold();
			$totalResourcesRecycled['crystal'] += $aAnalizedReports[$i]->getCrystal();
			$totalResourcesRecycled['ironValue'] += $aAnalizedReports[$i]->getIronValue();
		}
		
		//Pourcentage en fonction du champ de ruines   
		$percent = null;
		
		if ( $_POST['iron'] != null/* && $_POST['gold'] != null && $_POST['crystal'] != null*/) {
			//$fieldIronValue = GetIronValue(str_replace('.', '', htmlspecialchars($_POST['iron'])), str_replace('.', '', htmlspecialchars($_POST['gold'])), str_replace('.', '', htmlspecialchars($_POST['crystal'])), 0);
			$fieldIronValue = str_replace('.', '', htmlspecialchars($_POST['iron']));
			//echo nl2br(print_r($totalResourcesRecycled,1));
			$percent = round($totalResourcesRecycled['iron'] / $fieldIronValue * 100);
		}
		
		
		//--AFFICHAGE
		
		$recyclingString = "recyclage";
		if (count($aAnalizedReports) > 1)
			$recyclingString .= "s"; //Ajoute un 's'
			
		$introString = 'Ressources recuperées au cours de ' . count($aAnalizedReports) . ' ' . $recyclingString;
		
		if (count($aAnalizedReports) > 1)
			$introString .= ' du ' . $aAnalizedReports[count($aAnalizedReports)-1]->getRecyclingDate() . ' au ' . $aAnalizedReports[0]->getRecyclingDate();
		else
			$introString .= ' le ' . $aAnalizedReports[0]->getRecyclingDate();
			
		echo '<h4>Résultats :</h4>';
		echo '<table class="resultatRCVol" border="1"><tbody><tr><th width="70%">Ressources recyclées</th><th width="40%">Version Forum</th></tr><tr>

<td><u>' . $introString . '  :</u><br><img src="images/ress_fer.png">Fer : ' . Sep($totalResourcesRecycled['iron']) . '<br><img src="images/ress_or.png">Or : ' . Sep($totalResourcesRecycled['gold']) . '<br><img src="images/ress_cristal.png">Cristal : ' . Sep($totalResourcesRecycled['crystal']) . '<br>= Valeur Fer : ' . Sep($totalResourcesRecycled['ironValue']) . '<br>';

		if ($percent != null) {
			echo '> Champ de ruines recyclé à ' . GraphicPercent::showPercent($percent, GraphicPercent::COLOR_NORMAL, GraphicPercent::HTML) . '  ' . GraphicPercent::showBar($percent, GraphicPercent::COLOR_NORMAL, GraphicPercent::BG_BRIGHT, GraphicPercent::HTML);
		}

		echo '<br></td><td><textarea cols="60" rows="10" onclick="this.focus();this.select()" title="Cliquez sur le texte pour le sélectionner puis faites Ctrl+C pour copier le contenu" readonly="" style="margin-left: 2px; margin-right: 2px; margin-top: 2px; margin-bottom: 2px;">
			[u]' . $introString . ' :[/u]
			[img]http://uni10.origins-return.fr/images/ressource/Fer-icon.png[/img]Fer : [b]' . Sep($totalResourcesRecycled['iron']) . '[/b]
			[img]http://uni10.origins-return.fr/images/ressource/Or-icon.png[/img]Or : [b]' . Sep($totalResourcesRecycled['gold']) . '[/b]
			[img]http://uni10.origins-return.fr/images/ressource/Cristal-icon.png[/img]Cristal : [b]' . Sep($totalResourcesRecycled['crystal']) . '[/b]
			= Valeur Fer : [b]' . Sep($totalResourcesRecycled['ironValue']) . '[/b]';
			
		if ($percent != null) {
			echo '
			> Champ de ruines recyclé à ' . GraphicPercent::showPercent($percent, GraphicPercent::COLOR_DARK, GraphicPercent::BBCODE) . '  ' . GraphicPercent::showBar($percent, GraphicPercent::COLOR_DARK, GraphicPercent::BG_DARK, GraphicPercent::BBCODE);
		}
		
		echo '</textarea><br></td></tr></tbody></table>';

	}

?>
	</div>
</body>

</html>
