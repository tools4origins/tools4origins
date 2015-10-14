<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Convertisseur de Ressources</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/convertisseur.js"></script>
	<script type="text/JavaScript" src="js/stepper.js"></script>
</head>

<body>
<?php 
include('menu.php');
include('non_accessible/value.php');
?>
<!-- Le corps -->
<div id="corps">

<?php
	//GENERATION DU SELECT dans la variable $selectSource
	$selectSource = null;
	
	//Charge le xml
	$dom = new DomDocument();
	$dom->load('non_accessible/taux_' . $basePourLeTaux . '.xml');
	
	//Recupere la VF de chaque ressource de reference
	$tauxFer=1;
	$elements = $dom->getElementsByTagName('Element');
	foreach($elements as $element) {
		$nom = utf8_decode($element->getAttribute('nom'));
		$fer = $element->getAttribute('fer');
		if($nom == "Or")
			$tauxOr = $fer;
		elseif($nom == "Cristal")
			$tauxCristal = $fer;
		elseif($nom == "Hydrogene")
			$tauxHydro = $fer;
		elseif($nom == "Soldat") {
			$tauxSoldat = $fer;
			break;
		}
	}
	
	//Genere le select en parcourant les categories et elements par boucle
	$selectSource .= '<select id="selectList" onchange="convert();" onkeyup="convert();" style="width:100px;">';
	$categories = $dom->getElementsByTagName('Categorie');
	foreach($categories as $categorie) {
		$selectSource .= '<optgroup label="' . utf8_decode($categorie->getAttribute('nom')) . '">';
		$elements = $categorie->getElementsByTagName('Element');
		foreach($elements as $element) {
			$nom = utf8_decode($element->getAttribute('nom'));
			$fer = $element->getAttribute('fer');
			$or = $element->getAttribute('or');
			$cristal = $element->getAttribute('cristal');
			$hydro = $element->getAttribute('hydrogene');
			$soldats = $element->getAttribute('soldats');
			$vf = $fer * $tauxFer + $or * $tauxOr + $cristal * $tauxCristal + $hydro * $tauxHydro + $soldats * $tauxSoldat;
			$selectSource .= '<option value="' . $vf . '">' . $nom . '</option>';
		}
		$selectSource .= '</optgroup>';
	}
	$selectSource .= '</select>';
?>

<center>
<h2>Convertisseur de Ressources</h2>

<table class="classement" border="1">
	<tr>
		<td width="39%"><h4>Ressources à convertir</h4>
			Type de ressource et quantité à convertir :
			<div id="allEntry">
				<div>
					<?php echo $selectSource; ?> <input type="text" id="entryValue" value="0" size="12" onkeyup="convert();">
				</div>
				<input type="hidden">
			</div>
			<br/><input type="button" value="Ajouter une autre ressource" onclick="addSelect('entry');"><br/><br/>
		</td>
		<td width="22%"><h4>Taux</h4>
			<span class="ui-stepper" onmousedown="startModify(event, 1, 100, convert);" onmouseup="stopModify();" onmouseout="stopModify();">
				<input type="text" id="taux" value="0" size="2" class="ui-stepper-textbox" onkeyup="convert()"/>
				<input type="button" class="ui-stepper-plus" value="+" />
				<input type="button" class="ui-stepper-minus" value="-" />
			</span> %
			<br/><br/>Rappel : Le taux maximum autorisé dans un commerce faible vers fort est de +15%.<br/><br/>
		</td>
		<td width="39%"><h4>Convertir en</h4>
			Pondération (pourcentage) et type de ressource :
			<div id="allOut">
				<div>
					<input type="text" id="outPercent" value="100" size="2" onkeyup="convert();">% en <?php echo $selectSource; ?> = <input type="text" id="outValue" value="0" size="12" readonly="true">
				</div>
				<input type="hidden">
			</div>
			<br/><input type="button" value="Ajouter une autre ressource" onclick="addSelect('out');"><br/><br/>
		</td>
	</tr>
</table>
<br/>
<div id='error' class='moins' style='font-weight:bold;'></div>
<br/><br/>

</center>
</div>
</body></html>
