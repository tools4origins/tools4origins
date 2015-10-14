<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Simulateur de Camouflage</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/camou.js"></script>
	<script type="text/JavaScript" src="js/stepper.js"></script>
</head>

<body>
<?php
include('menu.php');
include('non_accessible/value.php');
?>
<!-- Le corps -->
<div id="corps">
<center>
<h2>Simulateur de Camouflage</h2>

<h4>Technologies ==> Informations</h4>
<form method='post'> <!--DEBUT DU FORMULAIRE-->
<table>
<tr><td><label for="intra">Capteurs intrastellaires: </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="intra" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="camou">Technologie Camouflages: </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="camou" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="occu">Occulteurs*: </label></td><td><select name="occu" id="occu" onChange="calculer()"><option value="aucun">Aucun</option><option value="croises">Croisés</option><option value="sages" selected="selected">Grand Sages</option></select></td></tr>
</table><br />
<table>
<tr><td>Destination</td><td style="width:100px;"><img src="images/true.png" style="height:20px;width:20px;" id="destination" /></td></tr>
<tr><td>Nombre de vaisseaux</td><td style="width:100px;"><img src="images/true.png" style="height:20px;width:20px;" id="nbrevx" /></td></tr>
<tr><td>Joueur + planète de départ</td><td style="width:100px;"><img src="images/true.png" style="height:20px;width:20px;" id="joueur" /></td></tr>
<tr><td>Infrastructures</td><td style="width:100px;"><img src="images/true.png" style="height:20px;width:20px;" id="infras" /></td></tr>
</table>
*: Prennez ceux du vaisseau qui a les moins bon/n'en a pas.
</center>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>