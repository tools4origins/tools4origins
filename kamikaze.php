<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Simulateur de Kamikazage</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/kami.js"></script>
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
<h2>Simulateur de Kamikazage</h2>

<h4>Temps ==> Bombes</h4>
<form method='post'> <!--DEBUT DU FORMULAIRE-->
<table>
<tr><td><label for="tempsmin">Temps de blocage voulu (min): </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="tempsmin" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
<tr><td><label for="tempssec">Temps de blocage voulu (sec): </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="tempssec" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
<tr><td><label for="centredef">Centre de défense ennemi : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="centredef" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
</form>
<tr><td></td></tr>
<tr><td><label for="puissance">Puissance des Bombes: </label></td><td name="puissance" id="puissance" style="width:100px;">0</td></tr>
<tr><td><label for="nbrebombe">Bombe Electromagnétique: </label></td><td name="nbrebombe" id="nbrebombe" style="width:100px;">0</td></tr>
</table>

<h4>Bombes ==> Temps</h4>
<form method='post'> <!--DEBUT DU FORMULAIRE-->
<!--UA-->
<table>
<tr><td><label for="nucleaire">Bombe Nucléaire : </label></td><td><span class="ui-stepper width2" onmousedown="startModify(event, 10, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="nucleaire" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
<tr><td><label for="plasma">Bombe Plasma : </label></td><td><span class="ui-stepper width2" onmousedown="startModify(event, 10, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="plasma" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
<tr><td><label for="electro">Bombe Electromagnétique : </label></td><td><span class="ui-stepper width2" onmousedown="startModify(event, 10, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="electro" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
</table>
<br />
<table>
<tr><td><label for="centre">Centre de défense ennemi : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="centre" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr></table>
</table>
</form>
<br />
<table>
<tr><td>Puissance:</td><td id="puissance_bombe" style="width:100px;" colspan="2">0</td></tr>
<tr><td>Temps:</td><td id="temps_bloque_min">0 min</td><td id="temps_bloque_sec">0 sec</td></tr>
</table><br />
Rappel: Dans une mission Kamikaze, envoyez 10 kamikazes par bombe.  
</center>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>