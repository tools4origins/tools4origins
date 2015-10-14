<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Alliances</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/javascript" src="oXHR.js"></script>
	<script type="text/javascript" src="ally.js"></script>
	<script type="text/JavaScript" src="fenetres.js"></script>
</head>
  
<body onload="setInterval('verif()', 1200)">   
<?php 
include('menu.php');
include('value.php');
?>
<!-- Le corps -->
<div id="corps">
	<div style="text-align:center;">
		<h2>Alliances de l'univers <?php echo $uni_nom ?></h2>
		<form>
			<input type="hidden" id="univers" name="univers" value="<?php echo $uni ?>"/>
			<label for="alliance">Alliance</label>: <input type="text" id="alliance" name="alliance" size="8"/>
			<label for="top">Top</label> : <input type="button" value="-" onclick="change('top', '-')" /><select name="top" id="top">
			<?php
				for($i=0; $i<3; $i++)
				{
					echo '		<option value ="' . $i*100 . '">' . ($i+1)*100 . '</option>' . "\n\t";
				}
			?>
			</select><input type="button" value="+" onclick="change('top', '+')" />
		</form>
	</div>
	<div id="chargement" style="display:inline;visibility:hidden;">Chargement...</div>
	<div id="classement">
		<?php include('alliance.php') ?>
	</div>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>
