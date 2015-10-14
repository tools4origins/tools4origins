<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Simulateur de Défense</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/simu_def.js"></script>
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
<h2>Simulateur de Défense</h2>

<h4>Défenses</h4>
<form method='post'> <!--DEBUT DU FORMULAIRE-->
<!--UA-->
<table>
<tr><td><label for="tour_combat">Tour de Combat : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="tour_combat" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="canon_laser">Canon Laser : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="canon_laser" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="grand_canon_laser">Grand Canon Laser : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="grand_canon_laser" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="rayon_tracteur">Rayon Tracteur : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="rayon_tracteur" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="lance_missile">Lanceur de Missiles : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="lance_missile" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="satellite">Satellite à Ions : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="satellite" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="batterie">Batterie Electromagnétique : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="batterie" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="canon_plasma">Canon à Plasma : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="canon_plasma" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="canon_electro">Canon Electromagnétique : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="canon_electro" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="silo_missile">Silos à Missiles HEM : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="silo_missile" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="complexe">Complexe de Défense Orbital : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="complexe" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
<tr><td><label for="MII">Missile d'Interception Intelligent : </label></td><td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="MII" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" /><input type="button" class="ui-stepper-minus" value="-" /></td></tr>
</table>
<h4>Technos</h4>
<table>
<!--armement-->
<tr>
<td><label for="techno_armement">Amélioration de l'Armement: </label></td>
<td><input type="text" name="armement" id="techno_armement" size="3" value="0" onChange="calculer()"/></td>
</tr>
<!--coque-->
<tr>
<td><label for="techno_coque">Amélioration de la Coque: </label></td>
<td><input type="text" name="coque" id="techno_coque" size="3" value="0" onChange="calculer()"/></td>
</tr>
</table><h4>Défense:</h4>
<table>
<tr><td>Attaque : </td><td id="attaque" style="width:100px;">0</td><td id="attaque_techno" style="width:100px;">(0)</td></tr>
<!--coque-->
<tr><td>Coque : </td><td id="coque">0</td><td id="coque_techno">(0)</td></tr>
<!--Nombre-->
<tr><td>Nombre : </td><td id="nombre">0</td><td id="nombre_sans_mii">(0)</td></tr>
</table>
<table>
<tr><td>Fer : </td><td id="fer">0</td></tr>
<tr><td>Or : </td><td id="or">0</td></tr>
<tr><td>Cristal : </td><td id="cri">0</td></tr>
<tr><td>Hydrogène : </td><td id="hydro">0</td></tr>
<tr><td>Points : </td><td id="pts">0</td></tr>
</table>
<h4>Liste : </h4>
<table>
<tr><td>Nom </td><td>Attaque </td><td>Bouclier </td><td>Coque </td><td>Nombre</td></tr>
<tr><td>Tour de combat </td><td>100 </td><td>0 </td><td>100 </td><td id="liste_tour_combat">0 </td></tr>
<tr><td>Canon Laser </td><td>200 </td><td>0 </td><td>200 </td><td id="liste_canon_laser">0 </td></tr>
<tr><td>Grand Canon Laser </td><td>450 </td><td>0 </td><td>500 </td><td id="liste_grand_canon_laser">0 </td></tr>
<tr><td>Rayon Tracteur </td><td>1000 </td><td>0 </td><td>750 </td><td id="liste_rayon_tracteur">0</td></tr>
<tr><td>Lance Missile </td><td>500 </td><td>0 </td><td>200 </td><td id="liste_lance_missile">0</td></tr>
<tr><td>Satellite à ions </td><td>4.400 </td><td>0 </td><td>3.000 </td><td id="liste_satellite">0</td></tr>
<tr><td>Batterie Electromagnétique </td><td>5.000 </td><td>0 </td><td>2.900 </td><td id="liste_batterie">0</td></tr>
<tr><td>Canon à Plasma </td><td>9.500 </td><td>0 </td><td>6.500 </td><td id="liste_canon_plasma">0</td></tr>
<tr><td>Canon Electromagnétique </td><td>13.000 </td><td>0 </td><td>8.500 </td><td id="liste_canon_electro">0</td></tr>
<tr><td>Silos à Missiles HEM </td><td>50.000 </td><td>0 </td><td>50.000 </td><td id="liste_silo_missile">0</td></tr>
<tr><td>Complexe de Défense Orbital </td><td>120.000 </td><td>0 </td><td>80.000 </td><td id="liste_complexe">0</td></tr>
<tr><td>Missile d'Interception Intelligent </td><td>34.000 </td><td>0 </td><td>0 </td><td id="liste_MII">0</td></tr>
<tr><td>Total </td><td id="liste_attaque"> 0</td><td> 0</td><td id="liste_coque"> 0</td><td id="liste_nombre"> 0</td></td></tr>
</table>
<a class="link" href="#en_tete">Retour en haut de page</a>
</center>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>
