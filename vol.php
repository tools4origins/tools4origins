<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Calculateur de temps de vol</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/vol.js"></script>
</head>

<body onload="calculer();">
<?php 
include('menu.php');
include('non_accessible/value.php');
?>
<!-- Le corps -->
<div id="corps">
<center>
<h2>Calculateur de temps de vol</h2>

<h4>Technologies ==> Informations</h4>
<form method='post'> <!--DEBUT DU FORMULAIRE-->
<table>
<tr><td><label for="gal_dep">Coordonnées de départ: </label></td><td><input type="text" name="gal_dep" id="gal_dep" size="1" value="1" onChange="calculer()"/></td><td><input type="text" name="sys_dep" id="sys_dep" size="1" value="1" onChange="calculer()"/></td><td><input type="text" name="pos_dep" id="pos_dep" size="1" value="1" onChange="calculer()"/></td></tr>
<tr><td><label for="gal_arr">Coordonnées d'arrivée: </label></td><td><input type="text" name="gal_arr" id="gal_arr" size="1" value="1" onChange="calculer()"/></td><td><input type="text" name="sys_arr" id="sys_arr" size="1" value="1" onChange="calculer()"/></td><td><input type="text" name="pos_arr" id="pos_arr" size="1" value="2" onChange="calculer()"/></td></tr>
<tr><td><label for="nbre_vx">Nombre de vaisseaux: </label></td><td colspan="3"><input type="text" name="nbre_vx" id="nbre_vx" size="13" value="1" onChange="calculer()"/></td></tr>
<tr><td><label for="pourcent_vitesse">Vitesse :</label></td><td colspan="3"><select name="pourcent_vitesse" id="pourcent_vitesse" onchange="calculer();">
<option value="1"> 100 % </option>
<option value="0.9"> 90 % </option>
<option value="0.8"> 80 % </option>
<option value="0.7"> 70 % </option>
<option value="0.6"> 60 % </option>
<option value="0.5"> 50 % </option>
<option value="0.4"> 40 % </option>
<option value="0.3"> 30 % </option>
<option value="0.2"> 20 % </option>
<option value="0.1"> 10 % </option>
</select>
</td></tr>
</table>
<br />
<table>
<tr><td><label for="combu">Technologie Réacteur à Combustion: </label></td><td><input type="text" name="combu" id="combu" size="1" value="0" onChange="calculer()"/></td></tr>
<tr><td><label for="sublu">Technologie Réacteur à SubLuminique: </label></td><td><input type="text" name="sublu" id="sublu" size="1" value="0" onChange="calculer()"/></td></tr>
<tr><td><label for="anti">Technologie Antimatière: </label></td><td><input type="text" name="anti" id="anti" size="1" value="0" onChange="calculer()"/></td></tr>
<tr><td><label for="hyper">Technologie Hyperespace: </label></td><td><input type="text" name="hyper" id="hyper" size="1" value="0" onChange="calculer()"/></td></tr>
</table>
<br />Indiquez les réacteurs les plus lents des modèles qui voleront
<table id="vaisseaux">
<tr><td><label for="reac">Réacteurs: </label></td><td colspan="3">
<select name="reac" id="reac" onChange="calculer()">
<option value="primi1">Combustion Primitive x 1</option>
<option value="primi2">Combustion Primitive x 2</option>
<option value="ameli1">Combustion Améliorée x 1</option>
<option value="ameli2">Combustion Améliorée x 2</option>
<option value="ioniq1">SubLuminique Ionique x 1</option>
<option value="ioniq2">SubLuminique Ionique x 2</option>
<option value="fusio1">SubLuminique à Fusion x 1</option>
<option value="fusio2">SubLuminique à Fusion x 2</option>
<option value="antim1">Antimatière x 1</option>
<option value="antim2">Antimatière x 2</option>
<option value="antig1">Antigravité x 1</option>
<option value="antig2">Antigravité x 2</option>
<option value="propu1">Hyperpropulseur x 1</option>
<option value="propu2">Hyperpropulseur x 2</option>
<option value="drive1">Stardrive x 1</option>
<option value="drive2" selected="selected">Stardrive x 2</option>
</select></td></tr>
</table><br />
<table>
<tr><td>Temps:</td><td id="temps_jou">0</td><td id="temps_heu">0</td><td id="temps_min">0</td><td id="temps_sec">0</td></tr>
<tr><td>Carburant:</td><td id="carbu" colspan="4">0</td></tr>
<tr><td>Voyage possible:</td><td style="width:100px;" colspan="4"><img src="images/false.png" style="height:20px;width:20px;" id="possible" /></td></tr>
</table>
</center>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>
