<?php
function diff($n1,$n2=0)
{
	$diff=$n1-$n2;
	if($diff>0)
	{
		return '<span class="plus">+' . sep($diff) . '</span>';
	}
	if($diff<0)
	{
		return '<span class="moins">' . sep($diff) . '</span>';
	}
	if($diff==0)
	{
		return '<span class="egal">' . sep($diff) . '</span>';
	}
}
include('non_accessible/sep_point.php');
$uni=htmlspecialchars($_GET['uni']);
$pseudo=htmlspecialchars($_GET['pseudo']);
include('non_accessible/connect.php');
$query="SELECT * from " . $uni . "Players WHERE pseudo='" . $pseudo . "' ORDER BY week DESC LIMIT 2";
$retour=$sql->query($query);
$currentWeek=$retour->fetch();
$lastWeek=$retour->fetch();
$retour->closeCursor();
if($currentWeek['week']==$lastWeek['week']+1)
{
	echo '<table style="text-align:left;">';
	echo '<tr><td>Classement Général:</td><td>'		. sep($currentWeek['generalRank'])		. ' (' . diff($lastWeek['generalRank'],$currentWeek['generalRank'])				. ')</td><td>' .	sep($currentWeek['generalPoints'])			. ' (' .	diff($currentWeek['generalPoints'], $lastWeek['generalPoints']) . ')</td></tr>' . "\n";
	echo '<tr><td>Classement Bâtiments:</td><td>'	. sep($currentWeek['batimentsRank'])	. ' (' . diff($lastWeek['batimentsRank'],$currentWeek['batimentsRank'])			. ')</td><td>' .	sep($currentWeek['batimentsPoints'])		. ' (' .	diff($currentWeek['batimentsPoints'], $lastWeek['batimentsPoints']) . ')</td></tr>' . "\n";
	echo '<tr><td>Classement Technologies:</td><td>'	. sep($currentWeek['technologiesRank'])	. ' (' . diff($lastWeek['technologiesRank'],$currentWeek['technologiesRank'])	. ')</td><td>' .	sep($currentWeek['technologiesPoints'])	. ' (' .	diff($currentWeek['technologiesPoints'], $lastWeek['technologiesPoints']) . ')</td></tr>' . "\n";
	echo '<tr><td>Classement Flottes:</td><td>'		. sep($currentWeek['flottesRank'])		. ' (' . diff($lastWeek['flottesRank'],$currentWeek['flottesRank'])				. ')</td><td>' .	sep($currentWeek['flottesPoints'])			. ' (' .	diff($currentWeek['flottesPoints'], $lastWeek['flottesPoints']) . ')</td></tr>' . "\n";
	echo '<tr><td>Classement Défenses:</td><td>'		. sep($currentWeek['defensesRank'])		. ' (' . diff($lastWeek['defensesRank'],$currentWeek['defensesRank'])			. ')</td><td>' .	sep($currentWeek['defensesPoints'])		. ' (' .	diff($currentWeek['defensesPoints'], $lastWeek['defensesPoints']) . ')</td></tr>' . "\n";
	echo '<tr><td>Classement Appareils:</td><td>'	. sep($currentWeek['appareilsRank'])	. ' (' . diff($lastWeek['appareilsRank'],$currentWeek['appareilsRank'])			. ')</td><td>' .	sep($currentWeek['appareilsPoints'])		. ' (' .	diff($currentWeek['appareilsPoints'], $lastWeek['appareilsPoints']) . ')</td></tr>' . "\n";
	echo '</table>';
	echo '<span style="color:#999999;font-size:0.6em">Astuce: Cliquez dans la cellule pour fixer cette infobulle et pouvoir copier-coller les stats.</span>';
}
else
{
	echo '<table style="text-align:left;">';
	echo '<tr><td>Classement Général:</td><td>' . sep($currentWeek['generalRank']) . '</td><td>' . sep($currentWeek['generalPoints']) . '</td></tr>' . "\n";
	echo '<tr><td>Classement Bâtiments:</td><td>' . sep($currentWeek['batimentsRank']) . '</td><td>' . sep($currentWeek['batimentsPoints']) . '</td></tr>' . "\n";
	echo '<tr><td>Classement Technologies:</td><td>' . sep($currentWeek['technologiesRank']) . '</td><td>' . sep($currentWeek['technologiesPoints']) . '</td></tr>' . "\n";
	echo '<tr><td>Classement Flottes:</td><td>' . sep($currentWeek['flottesRank']) . '</td><td>' . sep($currentWeek['flottesPoints']) . '</td></tr>' . "\n";
	echo '<tr><td>Classement Défenses:</td><td>' . sep($currentWeek['defensesRank']) . '</td><td>' . sep($currentWeek['defensesPoints']) . '</td></tr>' . "\n";
	echo '<tr><td>Classement Appareils:</td><td>' . sep($currentWeek['appareilsRank']) . '</td><td>' . sep($currentWeek['appareilsPoints']) . '</td></tr>' . "\n";
	echo '</table>';
	echo '<span style="color:#999999;font-size:0.6em">Astuce: Cliquez dans la cellule pour fixer cette infobulle et pouvoir copier-coller les stats.</span>';
}
?>
