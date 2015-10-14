<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Simulateur de modèle de vaisseaux</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/modelisateur.js"></script>
</head>

<body>
<?php 
include('menu.php');
include('non_accessible/value.php');
?>
<!-- Le corps -->
<div id="corps">
<center>
<h2>Simulateur de modèle de vaisseaux</h2>
<h4>Modèle</h4>
<form method='post'> <!--DEBUT DU FORMULAIRE-->

<!--LDD-->
<table>
<tr>
<td><label for="ldd">Lanceurs de Drones : </label></td>
<td><input type="button" value="-" onclick="change('ldd','-');calculer()"/>
<input type="text" name="ldd" id="ldd" size="2" value="0" onChange="calculer()"/>
<input type="button" value="+" onclick="change('ldd','+');calculer()"/></td>
</tr>

<!--BGS-->
<tr>
<td><label for="bgs">Boucliers des Grands Sages: </label></td>
<td><input type="button" value="-" onclick="change('bgs','-');calculer()"/>
<input type="text" name="bgs" id="bgs" size="2" value="0" onChange="calculer()"/>
<input type="button" value="+" onclick="change('bgs','+');calculer()"/></td>
</tr>

<!--CGS-->
<tr>
<td><label for="cgs">Coque des Grands Sages: </label></td>
<td><input type="button" value="-" onclick="change('cgs','-');calculer()"/>
<input type="text" name="cgs" id="cgs" size="2" value="0" onChange="calculer()"/>
<input type="button" value="+" onclick="change('cgs','+');calculer()"/></td>
</tr>

<!--nbre-->
<tr>
<td><label for="nbre">Nombre: </label></td>
<td><input type="button" value="-" onclick="change('nbre','-');calculer()"/>
<input type="text" name="nbre" id="nbre" size="2" value="1" onChange="calculer()"/>
<input type="button" value="+" onclick="change('nbre','+');calculer()"/></td>
</tr>

<!--occu-->
<tr>
<td><label for="occu">Occulteurs</label></td>
<td><input type="checkbox" name="occu" id="occu" onChange="calculer()"/></td>
</tr>
</table>
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
</table><br />
<!--calculer-->
<input type="button" value="Calculer" onclick="calculer()"/>
</form>
<h4>Vaisseaux &amp; Cout:</h4>
<table>
<!--armement-->
<tr>
<td>Attaque : </td>
<td id="attaque" style="width:100px;">0</td>
<td id="attaque_techno" style="width:100px;">(0)</td>
</tr>
<!--boubou-->
<tr>
<td>Bouclier : </td>
<td id="bouclier">0</td>
<td id="bouclier_techno">(0)</td>
</tr>
<!--coque-->
<tr>
<td>Coque : </td>
<td id="coque">0</td>
<td id="coque_techno">(0)</td>
</tr>
<!--fret-->
<tr>
<td>Fret : </td>
<td id="fret" class="plus">4999900</td>
<td></td>
</tr>
</table>
<table>
<tr><td>Fer : </td><td id="fer">3.263.000</td></tr>
<tr><td>Or : </td><td id="or">1.008.000</td></tr>
<tr><td>Cristal : </td><td id="cristal">302.900</td></tr>
<tr><td>Hydrogène : </td><td id="hydro">30.700</td></tr>
<tr><td>Point : </td><td id="pts">4.604</td></tr>
</table>
</center>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>