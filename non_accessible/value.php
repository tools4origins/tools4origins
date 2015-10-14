<?php
function value($nom)
{
	if(isset($_POST[$nom]))
	{
		return 'value="' . $_POST[$nom] . '"';
	}
	else
	{
		return '';
	}
}
?>