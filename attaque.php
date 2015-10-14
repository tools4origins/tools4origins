<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Coordinateur d'Attaque</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/attaque.js"></script>
	<script type="text/JavaScript" src="js/stepper.js"></script>
</head>
  
<body>   
<?php 
include('menu.php');
include('non_accessible/value.php');
?>
<!-- Le corps -->
<div id="corps">
<div style="text-align:center">
<h2>Coordinateur d'Attaque</h2>
<i>Entrez les missions qui seront envoyés et l'heure à laquelle elles doivent arrivées et le coordinateur vous dit quand les envoyer.<br />Si vous voulez qu'une attaque arrive quelques secondes plus tard, indiquez le dans le champ "Délai".</i>
<h4>Participants</h4>
<form method='post'> <!--DEBUT DU FORMULAIRE-->
<!--MISSIONS-->
<input type="button" value="Ajouter une attaque" onclick="add()"/>
<input type="hidden" value="2" name="nbreParticipants" id="nbreParticipants"/>
<div id="div0"><input type="text" id="nom0" size="10" value="Joueur 1" onfocus="this.value='';this.onfocus='';" onchange="this.onfocus='';" onkeyup="calculer()"/> : <span class="ui-stepper" onmousedown="startModify(event, 1, 50, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="nombre0" value="1" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> NanoSoldat(s) envoyé(s) à partir d'un complexe niv <span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="complexe0" value="1" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> Délai: <span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="delai0" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> s<br />
<div id="div1"><input type="text" id="nom1" size="10" value="Joueur 2" onfocus="this.value='';this.onfocus='';" onchange="this.onfocus='';" onkeyup="calculer()"/> : <span class="ui-stepper" onmousedown="startModify(event, 1, 50, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="nombre1" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> NanoSoldat(s) envoyé(s) à partir d'un complexe niv <span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="complexe1" value="1" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> Délai: <span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="delai1" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> s<br />
<div id="div2"><input type="text" id="nom2" size="10" value="Joueur 3" onfocus="this.value='';this.onfocus='';" onchange="this.onfocus='';" onkeyup="calculer()"/> : <span class="ui-stepper" onmousedown="startModify(event, 1, 50, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="nombre2" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> NanoSoldat(s) envoyé(s) à partir d'un complexe niv <span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="complexe2" value="1" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> Délai: <span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="delai2" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> s<br />
<div id="div3"></div>
</div></div></div>

<h4>Heure d'arrivée des dernières missions</h4>
<input type="text" name="heuDeb" id="heuDeb" size="1" value="00" onfocus="this.value='';this.onfocus='';" onkeyup="calculer()" /> h <input type="text" name="minDeb" id="minDeb" size="1" value="00" onfocus="this.value='';this.onfocus='';" onchange="calculer()"/> m <input type="text" name="secDeb" id="secDeb" size="1" value="00" onfocus="this.value='';this.onfocus='';" onkeyup="calculer()"/> s <br />
<br />
<input type="button" value="Calculer" onclick="calculer()"/>

<h4>Heure de départ</h4>
<textarea id="heureDep" cols="100" rows="20" onclick="this.focus();this.select()">Le temps de départ de chacune des missions sera calculé lorsque vous cliquerez sur "Calculer".</textarea>
</div>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>
