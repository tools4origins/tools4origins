<?php
	include('non_accessible/connect.php');
	$query="SELECT * FROM " . $uni . "Players WHERE pseudo = '". $player . "' ORDER BY week DESC;";
	$retour = $sql->query($query);
	$infos=$retour->fetchAll();
	$retour->closeCursor();
	$infos=array_reverse($infos);

	//Gestion des trous dans les relevés (moyennes des ceux à coté)
	$dataArray=array('generalRank', 'generalPoints', 'batimentsRank', 'batimentsPoints', 'technologiesRank', 'technologiesPoints', 'flottesRank', 'flottesPoints', 'defensesRank', 'defensesPoints', 'appareilsRank', 'appareilsPoints');
	$lastInfos=NULL;
	for($i=0; isset($infos[$i]) AND $i<100; $i++) //Pour chaque relevés
	{
		if($lastInfos!=NULL)
			if($infos[$i]['week']!=$lastInfos['week']+1) //Si la date n'est pas la dernière + 1 semaine
			{
				$nombreDeRelevesManquants=$infos[$i]['week']-$lastInfos['week']-1; //On calcul le nombre de relevés manquants
				if($nombreDeRelevesManquants>=1) //Si yen a un ou plus (dans certains cas il y en a 0 avec des bugs du relevés)
				{	
					for($c=count($infos)-1; $c>=$i; $c--) //On décale les relevés suivant
					{
						$infos[$c+$nombreDeRelevesManquants]=$infos[$c];
					}
					
					for($c=$i; $c<$i+$nombreDeRelevesManquants; $c++) //Et on insère des valeurs calculées 
					{
						foreach($dataArray AS $key)
							$infos[$c][$key]='null';
						$infos[$c]['week']=floor($infos[$c-1]['week']+($infos[$i+$nombreDeRelevesManquants]['week']-$infos[$i-1]['week'])/($nombreDeRelevesManquants+1));
						$infos[$c]['pause']=0;
					}
					$i+=$nombreDeRelevesManquants; //On ne vérifie pas les valeurs calculées (inutile, on gagne ainsi du temps)
				}
			}
		$lastInfos=$infos[$i];
	}

	$nbreData=count($infos);
	$startDate=mktime(0,0,0,9,23+7*$infos[0]['week'],2009);


	if(isset($infos[$nbreData-1]['idAlly']))
	{
		$queryAlly="SELECT * FROM " . $uni . "AllysList WHERE idAlly = ". $infos[$nbreData-1]['idAlly'] . " LIMIT 1;";
		$retourAlly=$sql->query($queryAlly);
		$dataAlly=$retourAlly->fetch();
	}
?>

	<table style="margin: 0 auto;">
		<tr><td>Univers:</td><td><?php echo ucfirst($uni); ?></td></tr>
		<tr><td>Pseudo:</td><td><?php echo htmlspecialchars_decode($player); ?></td></tr>
		<tr><td>Alliance:</td><td><?php echo (($infos[$nbreData-1]['idAlly']) ? '[' . $dataAlly['tag'] . '] ' . $dataAlly['name'] : ''); ?></td></tr>
		<tr><td>Points:</td><td><?php echo sep($infos[$nbreData-1]['generalPoints']); ?></td></tr>
	</table>
	<br />

	<div id="repartionPoints" style="width: 800px; height: 150px; margin: 0 auto"></div>
	<script type="text/javascript">
		Highcharts.setOptions({
			colors: ["#529069", "#72caff", "#f63635", "#55BF3B", "#7798BF", "#999999"]
		});
		var repartionPoints = new Highcharts.Chart({
			chart: {
			renderTo: 'repartionPoints',
			defaultSeriesType: 'bar'
			},
			title: {
				text: 'Répartition des points'
			},
			xAxis: {
				categories: [' ']
			},
			yAxis: {
				min: 0,
				title: {
					text: ' '
				},
				endOnTick: true
			},
			navigation: {
				buttonOptions: {
					backgroundColor: 'transparent',
					borderColor: 'transparent',
					printButton: {
						enabled: false
					}
				}
			},
			exporting: {
				buttons: {
					printButton: {
						enabled: false
					}
				}
			},
			legend: {
				backgroundColor: 'transparent',
				reversed: true
			},
			credits: {
				enabled: false
			},
			tooltip: {
				formatter: function() {
					return '<span style="color:'+this.series.color+';font-weight:bold">'+ this.series.name +':</span><br/>' + Highcharts.numberFormat(this.y, 0, ',', '.') + ' points (' + this.percentage.toFixed(1) + '%)';
				}
			},
			plotOptions: {
				series: {
					stacking: 'percent'
				}
			},
			series: [{
				name: 'Appareils Spécialisés',
				data: [<?php echo $infos[$nbreData-1]['appareilsPoints']; ?>]
			}, {
				name: 'Défenses',
				data: [<?php echo $infos[$nbreData-1]['defensesPoints']; ?>]
			}, {
				name: 'Flottes',
				data: [<?php echo $infos[$nbreData-1]['flottesPoints']; ?>]
			}, {
				name: 'Technologies',
				data: [<?php echo $infos[$nbreData-1]['technologiesPoints']; ?>]
			}, {
				name: 'Batiments',
				data: [<?php echo $infos[$nbreData-1]['batimentsPoints']; ?>]
			}]
		});
		Highcharts.setOptions({
			colors: ["#999999", "#7798BF", "#55BF3B", "#f63635", "#72caff", "#529069"]
		});
	</script>
	
	<div id="playerPoints" style="height: 400px"></div>
	<script type="text/javascript">
	var months = ["Jan", "Fev", "Mar", "Avr", "Mai", "Juin", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"];
	var playerPoints = new Highcharts.Chart({
		chart: {
			renderTo: 'playerPoints',
			zoomType: 'x',
			defaultSeriesType: 'line'
		},
		title: {
			text: 'Points du joueur <?php echo $player ?>'
		},
		xAxis: {
			type: 'datetime',
			tickmarkPlacement: 'on',
			title: {
				enabled: false
			},
			labels: {
				style: {
					fontSize: '9px'
				},
				formatter: function() {
					var date = new Date(this.value);
					return (date.getDate() + ' ' + months[date.getMonth()] + ' ' + Number(date.getYear()+1900))
				}
			},
			plotBands: [<?php
				$enPause=0;
				for($i=0; $i<$nbreData; $i++)
				{
					if($infos[$i]['pause']==1 && $enPause%2==0)
					{
						$date=mktime(0,0,0,9,23+$infos[$i]['week']*7-4,2009);
						echo ($enPause) ? ',' : '';
						echo "{\n";
						echo "\t\t\t\tfrom: Date.UTC(" . date('Y', $date) .  ", " . (date('m', $date)-1) . ", " . date('d', $date) ."),\n";
						$enPause++;
					}
					elseif($infos[$i]['pause']==0 && $enPause%2==1)
					{
						$date=mktime(0,0,0,9,23+$infos[$i]['week']*7-3,2009);
						echo "\t\t\t\tto: Date.UTC(" . date('Y', $date) .  ", " . (date('m', $date)-1) . ", " . date('d', $date) ."),\n";
						echo "\t\t\t\tcolor: 'rgba(0, 128, 255, 0.2)'\n";
						echo "\t\t\t}";
						$enPause++;
					}
				}
				if($enPause%2==1)
				{
					$date=mktime(0,0,0,9,23+$infos[$nbreData-1]['week']*7,2009);;
					echo "\t\t\t\tto: Date.UTC(" . date('Y', $date) .  ", " . (date('m', $date)-1) . ", " . date('d', $date) ."),\n";
					echo "\t\t\t\tcolor: 'rgba(0, 128, 255, 0.2)'\n";
					echo "\t\t\t}";
					$enPause++;
				}
				?>]
		},
		yAxis: {
			title: {
				text: 'Points'
			},
			startOnTick: false,
			labels: {
				style: {
					fontSize: '9px'
				},
				formatter: function() {
					return (this.value ? ((this.value>=1000000000) ? this.value/1000000000 + 'G' : ((this.value>=1000000) ? this.value/1000000 + 'M': ((this.value>=1000) ? this.value/1000 + 'K' : this.value))) : 0);
//					return this.value;
				}
			}
		},
		tooltip: {
			formatter: function() {
				var date = new Date(this.x);
				return '<span style="color:' + this.series.color + ';font-weight:bold">' + this.series.name + '</span><br/>' 
					+ date.getDate() + ' ' + months[date.getMonth()] + ' ' + Number(date.getYear()+1900) + ': ' + Highcharts.numberFormat(this.y, 0, ',', '.') + ' points';
			}
		},
		plotOptions: {
			line: {
				lineWidth:1,
				pointInterval: 7 * 24 * 3600 * 1000,
				pointStart: Date.UTC(<?php echo date('Y', $startDate) . ', ' . (date('m', $startDate)-1) . ', ' . date('d', $startDate);?>)
			},
			series: {
				marker: {
					enabled: false,
					states: {
						hover: {
							enabled: true
						}
					}
				}
			}
		},
		navigation: {
			buttonOptions: {
				backgroundColor: 'transparent',
				borderColor: 'transparent',
				printButton: {
					enabled: false
				}
			}
		},
		exporting: {
			buttons: {
				printButton: {
					enabled: false
				}
			}
		},
		credits: {
			enabled: false
		},
		series: [{
			name: 'Points Général',
			lineWidth:3,
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['generalPoints']) ? $infos[$i]['generalPoints'] : 'null');
				?>]},
		{
			name: 'Points Bâtiments',
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['batimentsPoints']) ? $infos[$i]['batimentsPoints'] : 'null');
			?>]},
		{
			name: 'Points Technologies',
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['technologiesPoints']) ? $infos[$i]['technologiesPoints'] : 'null');
			?>]},
		{
			name: 'Points Flottes',
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['flottesPoints']) ? $infos[$i]['flottesPoints'] : 'null');
			?>]},
		{
			name: 'Points Défenses',
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['defensesPoints']) ? $infos[$i]['defensesPoints'] : 'null');
			?>]},
		{
			name: 'Points Appareils',
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['appareilsPoints']) ? $infos[$i]['appareilsPoints'] : 'null');
			?>]}]
	});
	</script>
	
	<div id="playerRank" style="height: 400px"></div>
	<script type="text/javascript">
	var months = ["Jan", "Fev", "Mar", "Avr", "Mai", "Juin", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"];
	var playerRank = new Highcharts.Chart({
		chart: {
			renderTo: 'playerRank',
			zoomType: 'x',
			defaultSeriesType: 'line'
		},
		title: {
			text: 'Classement du joueur <?php echo $player ?>'
		},
		xAxis: {
			type: 'datetime',
			tickmarkPlacement: 'on',
			title: {
				enabled: false
			},
			labels: {
				style: {
					fontSize: '9px'
				},
				formatter: function() {
					var date = new Date(this.value);
					return (date.getDate() + ' ' + months[date.getMonth()] + ' ' + Number(date.getYear()+1900))
				}
			},
			plotBands: [<?php
				$enPause=0;
				for($i=0; $i<$nbreData; $i++)
				{
					if($infos[$i]['pause']==1 && $enPause%2==0)
					{
						$date=mktime(0,0,0,9,23+$infos[$i]['week']*7-4,2009);
						echo ($enPause) ? ',' : '';
						echo "{\n";
						echo "\t\t\t\tfrom: Date.UTC(" . date('Y', $date) .  ", " . (date('m', $date)-1) . ", " . date('d', $date) ."),\n";
						$enPause++;
					}
					elseif($infos[$i]['pause']==0 && $enPause%2==1)
					{
						$date=mktime(0,0,0,9,23+$infos[$i]['week']*7-3,2009);
						echo "\t\t\t\tto: Date.UTC(" . date('Y', $date) .  ", " . (date('m', $date)-1) . ", " . date('d', $date) ."),\n";
						echo "\t\t\t\tcolor: 'rgba(0, 128, 255, 0.2)'\n";
						echo "\t\t\t}";
						$enPause++;
					}
				}
				if($enPause%2==1)
				{
					$date=mktime(0,0,0,9,23+$infos[$nbreData-1]['week']*7,2009);;
					echo "\t\t\t\tto: Date.UTC(" . date('Y', $date) .  ", " . (date('m', $date)-1) . ", " . date('d', $date) ."),\n";
					echo "\t\t\t\tcolor: 'rgba(0, 128, 255, 0.2)'\n";
					echo "\t\t\t}";
					$enPause++;
				}
				?>]
		},
		yAxis: {
			reversed: true,
			title: {
				text: 'Classement'
			},
			startOnTick: false,
			labels: {
				style: {
					fontSize: '9px'
				},
				formatter: function() {
					return Highcharts.numberFormat(this.value, 0, ',', '.');
				}
			}
		},
		tooltip: {
			formatter: function() {
				var date = new Date(this.x);
				return '<span style="color:' + this.series.color + ';font-weight:bold">' + this.series.name + '</span><br/>' 
					+ date.getDate() + ' ' + months[date.getMonth()] + ' ' + Number(date.getYear()+1900) + ': ' + Highcharts.numberFormat(this.y, 0, ',', '.') + ((this.y==1) ? 'er' : ((this.y==2) ? 'nd' : 'ème'));
			}
		},
		navigation: {
			buttonOptions: {
				backgroundColor: 'transparent',
				borderColor: 'transparent',
				printButton: {
					enabled: false
				}
			}
		},
		exporting: {
			buttons: {
				printButton: {
					enabled: false
				}
			}
		},
		plotOptions: {
			line: {
				lineWidth:1,
				pointInterval: 7 * 24 * 3600 * 1000,
				pointStart: Date.UTC(<?php echo date('Y', $startDate) . ', ' . (date('m', $startDate)-1) . ', ' . date('d', $startDate);?>)
			},
			series: {
				marker: {
					enabled: false,
					states: {
						hover: {
							enabled: true
						}
					}
				}
			}
		},
		credits: {
			enabled: false
		},
		series: [{
			name: 'Classement Général',
			lineWidth:3,
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['generalRank']!=65535) ? $infos[$i]['generalRank'] : 'null');
				?>]},
		{
			name: 'Classement Bâtiments',
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['batimentsRank']!=65535) ? $infos[$i]['batimentsRank'] : 'null');
			?>]},
		{
			name: 'Classement Technologies',
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['technologiesRank']!=65535) ? $infos[$i]['technologiesRank'] : 'null');
			?>]},
		{
			name: 'Classement Flottes',
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['flottesRank']!=65535) ? $infos[$i]['flottesRank'] : 'null');
			?>]},
		{
			name: 'Classement Défenses',
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['defensesRank']!=65535) ? $infos[$i]['defensesRank'] : 'null');
			?>]},
		{
			name: 'Classement Appareils',
			data: [<?php
				for($i=0; $i<$nbreData; $i++)
					echo (($i==0) ? '' : ', ') . (($infos[$i]['appareilsRank']!=65535) ? $infos[$i]['appareilsRank'] : 'null');
			?>]}]
	});
	playerRank.series[1].hide();
	playerRank.series[2].hide();
	playerRank.series[3].hide();
	playerRank.series[4].hide();
	playerRank.series[5].hide();
	</script>	