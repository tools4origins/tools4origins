<?php
if(!isset($sql))
{
	if($_SERVER['HTTP_HOST']!='localhost')
	{
		try
		{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$sql = new PDO('mysql:host=sql1.free-h.org;dbname='+DISTANT_DATABASE, DISTANT_DATABASE_USERNAME, DISTANT_DATABASE_PASSWD, $pdo_options);
		}
		catch (Exception $e)
		{
				die('Erreur : ' . $e->getMessage());
		}
	}
	else
	{
		try
		{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$sql = new PDO('mysql:host=sql1.free-h.org;dbname='+LOCAL_DATABASE, LOCAL_DATABASE_USERNAME, LOCAL_DATABASE_PASSWD, $pdo_options);
		}
		catch (Exception $e)
		{
				die('Erreur : ' . $e->getMessage());
		}
	}
}
?>
