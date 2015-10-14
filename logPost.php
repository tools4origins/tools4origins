<?php  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<title>Stats</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	</head>

	<?php
	//*/
	include('non_accessible/curl.php');
	$data = get_source('http://origins-return.fr/');
	preg_match_all("#<option value=\"http://uni([a-zA-Z0-9]+)\.origins-return\.fr/login\.php\|\|([a-zA-Z0-9]+)\">Univers [a-zA-Z0-9&;]+</option>#", $data, $infos);
	for($i=0; isset($infos[0][$i]); $i++)
	{
		$cleUni[$infos[1][$i]]=$infos[2][$i];
	}
	?>

	<body <?php echo 'onLoad="document.stat.submit();"'; ?> >
		<form method='post' name='stat' id='stat' action="<?php echo 'http://uni' . $_GET['univers'] .'.origins-return.fr/login.php' ?>">
			<input type="hidden" name="hardkey" value="<?php echo $cleUni[$_GET['univers']]; ?>" />
			<input type="hidden" name="login" value="<?php echo $_GET['login']; ?>" />
			<input type="hidden" name="password" value="<?php echo $_GET['password']; ?>" />
			<input type="hidden" name="x" value="<?php echo rand(48, 55); ?>" />
			<input type="hidden" name="y" value="<?php echo rand(2, 3); ?>" />
			<input type="submit" value="Go !" />
		</form>
	</body>
</html>
