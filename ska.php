<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Simulateur de Kidnapping et Assassinat</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/ska.js"></script>
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
<h2>Simulateur de Kidnapping et Assassinat</h2>

<h4>Nombre de militaire ==> Nanosoldat</h4>
<form method='post'> <!--DEBUT DU FORMULAIRE-->
<table>
<tr><td><label for="militaires">Militaires visés à quai : </label></td><td><span class="ui-stepper width2" onmousedown="startModify(event, 10000, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="militaires" value="0" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
<tr><td></td></tr>
<tr><td><label for="milikid">Militaires ass/kid (au max): </label></td><td name="milikid" id="milikid" style="width:100px;">0</td></tr>
<tr><td><label for="nano_envo_kid">Nanosoldats à envoyer (kid): </label></td><td name="nano_envo_kid" id="nano_envo_kid" style="width:100px;">0</td></tr>
<tr><td></td></tr>
<tr><td><label for="nano_envo_ass">Nanosoldats à envoyer (ass): </label></td><td name="nano_envo_ass" id="nano_envo_ass" style="width:100px;">0</td></tr>
</table>

<h4>Unitées d'assaut ==> Nombre de militaire</h4>
<form method='post'> <!--DEBUT DU FORMULAIRE-->
<!--UA-->
<table>
<tr><td><label for="marines">Marines : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="marines" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
<tr><td><label for="unites_elite">Unités d'Elite : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="unites_elite" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
<tr><td><label for="biosoldat">BioSoldat : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="biosoldat" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
<tr><td><label for="agentsecret">Agent Secret : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="agentsecret" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
<tr><td><label for="soldat_droide">Soldat Droïde : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="soldat_droide" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
<tr><td><label for="androide">Androïde de Combat : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="androide" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
<tr><td><label for="nanos">NanoSoldat : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="nanos" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></span></td></tr>
</table><br />
<table>
<tr>
<td>Mission</td>
<td>Nombre max. de milit. kid/ass</td>
<td>Nombre min. de milit. à quai (*)</td>
</tr>
<!--assassinat-->
<tr>
<td>Assassinat : </td>
<td id="assmax">0</td>
<td id="assnbrequai">0</td>
</tr>
<!--kidnapping-->
<tr>
<td>Kidnapping : </td>
<td id="kidmax">0</td>
<td id="kidnbrequai">0</td>
</tr>
</table><br />
(*): Pour atteindre le maximum de militaire kidnappé/assassiné.
</center>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>