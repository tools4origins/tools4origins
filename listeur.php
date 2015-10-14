<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Générateur de liste</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/listeur.js"></script>
</head>

<body>
<?php
include('menu.php');
include('non_accessible/value.php');
?>
<!-- Le corps -->
<div id="corps">
<center>
<h2>Générateur de liste</h2>
<form method='post'> <!--DEBUT DU FORMULAIRE-->
<a href="http://help.tools4origins.fr.nf/simulateur_vx.php" class="link">Utilité et utilisation du générateur de liste.</a>
<h4>Modèles</h4>
<input type="button" value="Ajouter un modèle" onclick="add();"/>
<div id="modeles">
<span id="modele0"><textarea rows="15" cols="30" name="modele0" value="modele0"></textarea><span id="modele1"></span></span>
</div>
<input type="hidden" value="1" name="nombre_modele" id="nombre_modele" />
<input type="button" value="Générer" onclick="calculer();"/>
<br /><br />
<h4>Technos</h4>
<table>
<!--armement-->
<tr>
<td><label for="techno_armement">Amélioration de l'Armement: </label></td>
<td><input type="text" name="armement" id="techno_armement" size="3" value="0" onChange="calculer()"/></td>
</tr>
<!--boubou-->
<tr>
<td><label for="techno_boubou">Bouclier de Protection: </label></td>
<td><input type="text" name="boubou" id="techno_boubou" size="3" value="0" onChange="calculer()"/></td>
</tr>
<!--coque-->
<tr>
<td><label for="techno_coque">Amélioration de la Coque: </label></td>
<td><input type="text" name="coque" id="techno_coque" size="3" value="0" onChange="calculer()"/></td>
</tr>
</table><br />Liste à copier-coller:<br />
<textarea id="liste_vx" cols="75" rows="15"></textarea>
</center>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>
