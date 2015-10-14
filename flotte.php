<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Simulateur de Flotte</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/flotte.js"></script>
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
<h2>Simulateur de flotte</h2>
<h4>Modèles</h4>
<!--<table id="modeles">
<tr>
<td>Modèle 1</td>
</tr>
</table>
<hr />-->
<form method='post'> <!--DEBUT DU FORMULAIRE-->
<!--infos-->Nom: <input type="text" id="nom" value="Vaisseau" onfocus="this.value=''; this.onfocus=''"/><br />
<!--<input type="button" value="Ajouter à la flotte" onclick="addFlotte()" />--><br /><br />
<table>
<!--<tr>
<td><label for="nom_1">Nom: </label></td>
<td><input type="text" name="nom_1" id="nom_1" value="Modèle 1" onchange="calculer()"/>
</td>
</tr>-->
<tr>
<td><label for="infra">Infrastructure: </label></td>
<td>
<select name="infra" id="infra" onchange="calculer()">
<option value="500">Chasseur</option>
<option value="1000">Chasseur Lourd</option>
<option value="6000">Vaisseau Cargo</option>
<option value="20000">Bombardier</option>
<option value="50000">Croiseur</option>
<option value="100000">Croiseur Lourd</option>
<option value="500000">Destroyer</option>
<option value="1000000">Vaisseau Mère</option>
<option value="5000000" selected="selected">Vaisseau Amiral</option>
</select>
</td>
</tr>
</table>
<!--compos-->
<div id="compo">
<span id="compo1"><select name="compo_1" id="compo_1" onchange="calculer()">
<option value="rien">Aucun</option>
<optgroup label="Réacteurs">
<option value="reacteuracombustionprimitive">Combustion primitive</option>
<option value="reacteuracombustionamelioree">Combustion améliorée</option>
<option value="reacteursubluminiqueionique">Subluminique Ionique</option>
<option value="reacteursubluminiqueafusion">Subluminique à Fusion</option>
<option value="reacteuraantimatiere">Antimatière</option>
<option value="reacteuraantigravite">Antigravité</option>
<option value="reacteurhyperpropulseur">Hyperpropulseurs</option>
<option value="reacteurdetypestardrive">Stardrive</option>
</optgroup>
<optgroup label="Boucliers">
<option value="petitbouclier">Petit Bouclier</option>
<option value="champdeforce">Champ de Force</option>
<option value="bouclierdeflecteur">Bouclier Déflecteur</option>
<option value="bouclierdescroises">Bouclier des Croisés</option>
<option value="bouclierdesgrandssages">Bouclier des Grands Sages</option>
</optgroup>
<optgroup label="Armes">
<option value="missiles">Missiles</option>
<option value="missilesenrichis">Missiles Enrichis</option>
<option value="canonlaser">Canons Laser</option>
<option value="batterielaserrenforcee">Batteries Laser Renf.</option>
<option value="canonaions">Canons à Ions</option>
<option value="canonelectromagnetique">Batteries Electro.</option>
<option value="canonaplasma">Canons à Plasma</option>
<option value="lanceurdeplasmaavance">Lanceurs de Plasma Avancé</option>
<option value="missilesnucleaire">Missiles Nucléaire</option>
<option value="rayonelectromagnetique">Rayons Electromagnétique</option>
<option value="bombesaimpulsion">Bombes à Impulsion</option>
<option value="lanceurdedrones" selected="selected">Lanceurs de drones</option>
</optgroup>
<optgroup label="Coques">
<option value="coquesimple">Coque Simple</option>
<option value="coqueblindee">Coque Blindée</option>
<option value="coqueorganique">Coque Organique</option>
<option value="coquedescroises">Coque Des Croisés</option>
<option value="coquedesgrandssages">Coque des Grands Sages</option>
</optgroup>
<optgroup label="Occulteurs">
<option value="occulteurdescroises">Occulteurs des Croisés</option>
<option value="occulteurdesgrandssages">Occulteurs des Grands Sages</option>
</optgroup>
<optgroup label="Tranporteurs">
<option value="archedesauvetage">Arche de Sauvetage</option>
<option value="teleporteurs">Téléporteurs</option>
</optgroup>
</select>
<span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();">
	<input type="text" id="nombre_compo_1" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/>
	<input type="button" class="ui-stepper-plus" value="+" />
	<input type="button" class="ui-stepper-minus" value="-" />
</span>
<span id="compo2"><br />
<select name="compo_2" id="compo_2" onchange="calculer()">
<option value="rien">Aucun</option>
<optgroup label="Réacteurs">
<option value="reacteuracombustionprimitive">Combustion primitive</option>
<option value="reacteuracombustionamelioree">Combustion améliorée</option>
<option value="reacteursubluminiqueionique">Subluminique Ionique</option>
<option value="reacteursubluminiqueafusion">Subluminique à Fusion</option>
<option value="reacteuraantimatiere">Antimatière</option>
<option value="reacteuraantigravite">Antigravité</option>
<option value="reacteurhyperpropulseur">Hyperpropulseurs</option>
<option value="reacteurdetypestardrive">Stardrive</option>
</optgroup>
<optgroup label="Boucliers">
<option value="petitbouclier">Petit Bouclier</option>
<option value="champdeforce">Champ de Force</option>
<option value="bouclierdeflecteur">Bouclier Déflecteur</option>
<option value="bouclierdescroises">Bouclier des Croisés</option>
<option value="bouclierdesgrandssages" selected="selected">Bouclier des Grands Sages</option>
</optgroup>
<optgroup label="Armes">
<option value="missiles">Missiles</option>
<option value="missilesenrichis">Missiles Enrichis</option>
<option value="canonlaser">Canons Laser</option>
<option value="batterielaserrenforcee">Batteries Laser Renf.</option>
<option value="canonaions">Canons à Ions</option>
<option value="canonelectromagnetique">Batteries Electro.</option>
<option value="canonaplasma">Canons à Plasma</option>
<option value="lanceurdeplasmaavance">Lanceurs de Plasma Avancé</option>
<option value="missilesnucleaire">Missiles Nucléaire</option>
<option value="rayonelectromagnetique">Rayons Electromagnétique</option>
<option value="bombesaimpulsion">Bombes à Impulsion</option>
<option value="lanceurdedrones">Lanceurs de drones</option>
</optgroup>
<optgroup label="Coques">
<option value="coquesimple">Coque Simple</option>
<option value="coqueblindee">Coque Blindée</option>
<option value="coqueorganique">Coque Organique</option>
<option value="coquedescroises">Coque Des Croisés</option>
<option value="coquedesgrandssages">Coque des Grands Sages</option>
</optgroup>
<optgroup label="Occulteurs">
<option value="occulteurdescroises">Occulteurs des Croisés</option>
<option value="occulteurdesgrandssages">Occulteurs des Grands Sages</option>
</optgroup>
<optgroup label="Tranporteurs">
<option value="archedesauvetage">Arche de Sauvetage</option>
<option value="teleporteurs">Téléporteurs</option>
</optgroup>
</select>
<span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();">
	<input type="text" id="nombre_compo_2" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/>
	<input type="button" class="ui-stepper-plus" value="+" />
	<input type="button" class="ui-stepper-minus" value="-" />
</span><span id="compo3"><br />
<select name="compo_3" id="compo_3" onchange="calculer()">
<option value="rien">Aucun</option>
<optgroup label="Réacteurs">
<option value="reacteuracombustionprimitive">Combustion primitive</option>
<option value="reacteuracombustionamelioree">Combustion améliorée</option>
<option value="reacteursubluminiqueionique">Subluminique Ionique</option>
<option value="reacteursubluminiqueafusion">Subluminique à Fusion</option>
<option value="reacteuraantimatiere">Antimatière</option>
<option value="reacteuraantigravite">Antigravité</option>
<option value="reacteurhyperpropulseur">Hyperpropulseurs</option>
<option value="reacteurdetypestardrive">Stardrive</option>
</optgroup>
<optgroup label="Boucliers">
<option value="petitbouclier">Petit Bouclier</option>
<option value="champdeforce">Champ de Force</option>
<option value="bouclierdeflecteur">Bouclier Déflecteur</option>
<option value="bouclierdescroises">Bouclier des Croisés</option>
<option value="bouclierdesgrandssages">Bouclier des Grands Sages</option>
</optgroup>
<optgroup label="Armes">
<option value="missiles">Missiles</option>
<option value="missilesenrichis">Missiles Enrichis</option>
<option value="canonlaser">Canons Laser</option>
<option value="batterielaserrenforcee">Batteries Laser Renf.</option>
<option value="canonaions">Canons à Ions</option>
<option value="canonelectromagnetique">Batteries Electro.</option>
<option value="canonaplasma">Canons à Plasma</option>
<option value="lanceurdeplasmaavance">Lanceurs de Plasma Avancé</option>
<option value="missilesnucleaire">Missiles Nucléaire</option>
<option value="rayonelectromagnetique">Rayons Electromagnétique</option>
<option value="bombesaimpulsion">Bombes à Impulsion</option>
<option value="lanceurdedrones">Lanceurs de drones</option>
</optgroup>
<optgroup label="Coques">
<option value="coquesimple">Coque Simple</option>
<option value="coqueblindee">Coque Blindée</option>
<option value="coqueorganique">Coque Organique</option>
<option value="coquedescroises">Coque Des Croisés</option>
<option value="coquedesgrandssages" selected="selected">Coque des Grands Sages</option>
</optgroup>
<optgroup label="Occulteurs">
<option value="occulteurdescroises">Occulteurs des Croisés</option>
<option value="occulteurdesgrandssages">Occulteurs des Grands Sages</option>
</optgroup>
<optgroup label="Tranporteurs">
<option value="archedesauvetage">Arche de Sauvetage</option>
<option value="teleporteurs">Téléporteurs</option>
</optgroup>
</select>
<span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();">
	<input type="text" id="nombre_compo_3" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/>
	<input type="button" class="ui-stepper-plus" value="+" />
	<input type="button" class="ui-stepper-minus" value="-" />
</span>
<span id="compo4"><br />
<select name="compo_4" id="compo_4" onchange="calculer()">
<option value="rien">Aucun</option>
<optgroup label="Réacteurs">
<option value="reacteuracombustionprimitive">Combustion primitive</option>
<option value="reacteuracombustionamelioree">Combustion améliorée</option>
<option value="reacteursubluminiqueionique">Subluminique Ionique</option>
<option value="reacteursubluminiqueafusion">Subluminique à Fusion</option>
<option value="reacteuraantimatiere">Antimatière</option>
<option value="reacteuraantigravite">Antigravité</option>
<option value="reacteurhyperpropulseur">Hyperpropulseurs</option>
<option value="reacteurdetypestardrive">Stardrive</option>
</optgroup>
<optgroup label="Boucliers">
<option value="petitbouclier">Petit Bouclier</option>
<option value="champdeforce">Champ de Force</option>
<option value="bouclierdeflecteur">Bouclier Déflecteur</option>
<option value="bouclierdescroises">Bouclier des Croisés</option>
<option value="bouclierdesgrandssages">Bouclier des Grands Sages</option>
</optgroup>
<optgroup label="Armes">
<option value="missiles">Missiles</option>
<option value="missilesenrichis">Missiles Enrichis</option>
<option value="canonlaser">Canons Laser</option>
<option value="batterielaserrenforcee">Batteries Laser Renf.</option>
<option value="canonaions">Canons à Ions</option>
<option value="canonelectromagnetique">Batteries Electro.</option>
<option value="canonaplasma">Canons à Plasma</option>
<option value="lanceurdeplasmaavance">Lanceurs de Plasma Avancé</option>
<option value="missilesnucleaire">Missiles Nucléaire</option>
<option value="rayonelectromagnetique">Rayons Electromagnétique</option>
<option value="bombesaimpulsion">Bombes à Impulsion</option>
<option value="lanceurdedrones">Lanceurs de drones</option>
</optgroup>
<optgroup label="Coques">
<option value="coquesimple">Coque Simple</option>
<option value="coqueblindee">Coque Blindée</option>
<option value="coqueorganique">Coque Organique</option>
<option value="coquedescroises">Coque Des Croisés</option>
<option value="coquedesgrandssages">Coque des Grands Sages</option>
</optgroup>
<optgroup label="Occulteurs">
<option value="occulteurdescroises">Occulteurs des Croisés</option>
<option value="occulteurdesgrandssages" selected="selected">Occulteurs des Grands Sages</option>
</optgroup>
<optgroup label="Tranporteurs">
<option value="archedesauvetage">Arche de Sauvetage</option>
<option value="teleporteurs">Téléporteurs</option>
</optgroup>
</select>
<span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();">
	<input type="text" id="nombre_compo_4" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/>
	<input type="button" class="ui-stepper-plus" value="+" />
	<input type="button" class="ui-stepper-minus" value="-" />
</span>
<span id="compo5"><br />
<select name="compo_5" id="compo_5" onchange="calculer()">
<option value="rien">Aucun</option>
<optgroup label="Réacteurs">
<option value="reacteuracombustionprimitive">Combustion primitive</option>
<option value="reacteuracombustionamelioree">Combustion améliorée</option>
<option value="reacteursubluminiqueionique">Subluminique Ionique</option>
<option value="reacteursubluminiqueafusion">Subluminique à Fusion</option>
<option value="reacteuraantimatiere">Antimatière</option>
<option value="reacteuraantigravite">Antigravité</option>
<option value="reacteurhyperpropulseur">Hyperpropulseurs</option>
<option value="reacteurdetypestardrive" selected="selected">Stardrive</option>
</optgroup>
<optgroup label="Boucliers">
<option value="petitbouclier">Petit Bouclier</option>
<option value="champdeforce">Champ de Force</option>
<option value="bouclierdeflecteur">Bouclier Déflecteur</option>
<option value="bouclierdescroises">Bouclier des Croisés</option>
<option value="bouclierdesgrandssages">Bouclier des Grands Sages</option>
</optgroup>
<optgroup label="Armes">
<option value="missiles">Missiles</option>
<option value="missilesenrichis">Missiles Enrichis</option>
<option value="canonlaser">Canons Laser</option>
<option value="batterielaserrenforcee">Batteries Laser Renf.</option>
<option value="canonaions">Canons à Ions</option>
<option value="canonelectromagnetique">Batteries Electro.</option>
<option value="canonaplasma">Canons à Plasma</option>
<option value="lanceurdeplasmaavance">Lanceurs de Plasma Avancé</option>
<option value="missilesnucleaire">Missiles Nucléaire</option>
<option value="rayonelectromagnetique">Rayons Electromagnétique</option>
<option value="bombesaimpulsion">Bombes à Impulsion</option>
<option value="lanceurdedrones">Lanceurs de drones</option>
</optgroup>
<optgroup label="Coques">
<option value="coquesimple">Coque Simple</option>
<option value="coqueblindee">Coque Blindée</option>
<option value="coqueorganique">Coque Organique</option>
<option value="coquedescroises">Coque Des Croisés</option>
<option value="coquedesgrandssages">Coque des Grands Sages</option>
</optgroup>
<optgroup label="Occulteurs">
<option value="occulteurdescroises">Occulteurs des Croisés</option>
<option value="occulteurdesgrandssages">Occulteurs des Grands Sages</option>
</optgroup>
<optgroup label="Tranporteurs">
<option value="archedesauvetage">Arche de Sauvetage</option>
<option value="teleporteurs">Téléporteurs</option>
</optgroup>
</select>
<span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();">
	<input type="text" id="nombre_compo_5" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/>
	<input type="button" class="ui-stepper-plus" value="+" />
	<input type="button" class="ui-stepper-minus" value="-" />
</span>
<span id="compo6"><br />
<select name="compo_6" id="compo_6" onchange="calculer()">
<option value="rien">Aucun</option>
<optgroup label="Réacteurs">
<option value="reacteuracombustionprimitive">Combustion primitive</option>
<option value="reacteuracombustionamelioree">Combustion améliorée</option>
<option value="reacteursubluminiqueionique">Subluminique Ionique</option>
<option value="reacteursubluminiqueafusion">Subluminique à Fusion</option>
<option value="reacteuraantimatiere">Antimatière</option>
<option value="reacteuraantigravite">Antigravité</option>
<option value="reacteurhyperpropulseur">Hyperpropulseurs</option>
<option value="reacteurdetypestardrive">Stardrive</option>
</optgroup>
<optgroup label="Boucliers">
<option value="petitbouclier">Petit Bouclier</option>
<option value="champdeforce">Champ de Force</option>
<option value="bouclierdeflecteur">Bouclier Déflecteur</option>
<option value="bouclierdescroises">Bouclier des Croisés</option>
<option value="bouclierdesgrandssages">Bouclier des Grands Sages</option>
</optgroup>
<optgroup label="Armes">
<option value="missiles">Missiles</option>
<option value="missilesenrichis">Missiles Enrichis</option>
<option value="canonlaser">Canons Laser</option>
<option value="batterielaserrenforcee">Batteries Laser Renf.</option>
<option value="canonaions">Canons à Ions</option>
<option value="canonelectromagnetique">Batteries Electro.</option>
<option value="canonaplasma">Canons à Plasma</option>
<option value="lanceurdeplasmaavance">Lanceurs de Plasma Avancé</option>
<option value="missilesnucleaire">Missiles Nucléaire</option>
<option value="rayonelectromagnetique">Rayons Electromagnétique</option>
<option value="bombesaimpulsion">Bombes à Impulsion</option>
<option value="lanceurdedrones">Lanceurs de drones</option>
</optgroup>
<optgroup label="Coques">
<option value="coquesimple">Coque Simple</option>
<option value="coqueblindee">Coque Blindée</option>
<option value="coqueorganique">Coque Organique</option>
<option value="coquedescroises">Coque Des Croisés</option>
<option value="coquedesgrandssages">Coque des Grands Sages</option>
</optgroup>
<optgroup label="Occulteurs">
<option value="occulteurdescroises">Occulteurs des Croisés</option>
<option value="occulteurdesgrandssages">Occulteurs des Grands Sages</option>
</optgroup>
<optgroup label="Tranporteurs">
<option value="archedesauvetage">Arche de Sauvetage</option>
<option value="teleporteurs" selected="selected">Téléporteurs</option>
</optgroup>
</select>
<span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();">
	<input type="text" id="nombre_compo_6" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/>
	<input type="button" class="ui-stepper-plus" value="+" />
	<input type="button" class="ui-stepper-minus" value="-" />
</span><br />
<span id="compo7"></span></span></span></span></span></span></span></div>
<input type="hidden" id="nombre_compo" value="6"/>
<input type="button" value="Ajouter un composant" onclick="add();"/><br /><br />
<table>
<tr>
<td><label for="nbre">Nombre: </label></td>
<td><span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();">
	<input type="text" id="nbre" value="1" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/>
	<input type="button" class="ui-stepper-plus" value="+" />
	<input type="button" class="ui-stepper-minus" value="-" />
</span></td>
</tr>
</table>
<!--<hr />
<input type="button" value="Ajouter un modèle" onclick="add_modele();"/>
<hr />-->
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
<!--soute-->
<tr>
<td><label for="techno_soute">Extension des soutes: </label></td>
<td><input type="text" name="coque" id="techno_soute" size="3" value="0" onChange="calculer()"/></td>
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
<td id="fret" class="plus">5.000.000</td>
<td></td>
</tr>
</table>
<table>
<tr><td>Fer : </td><td id="fer">3.263.000</td></tr>
<tr><td>Or : </td><td id="or">1.008.000</td></tr>
<tr><td>Cristal : </td><td id="cristal">302.900</td></tr>
<tr><td>Hydrogène : </td><td id="hydro">30.700</td></tr>
<tr><td>Points : </td><td id="pts">4.604</td></tr>
</table><!--
<h4>Flotte</h4>
<table id="flotte">
<tr class="ligne_titre"><td><b>Nom</b></td><td><b>Attaque</b></td><td><b>Bouclier</b></td><td><b>Coque</b></td><td><b>Nombre</b></td></tr>
<tr class="ligne_titre" id="ligneTotal"><td><b>Total</b></td><td>0</td><td>0</td><td>0</td><td>0</td></tr>
</table>-->
</center>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>