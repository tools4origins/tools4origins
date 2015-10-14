<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title>Tools4Origins - Statistiques de l'univers</title>
	<?php include('non_accessible/head.php'); ?>
	<script type="text/JavaScript" src="js/graph.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/highcharts.js"></script>
	<script type="text/javascript" src="js/graphTheme.js"></script>
	<script type="text/javascript" src="js/exporting.js"></script>
</head>

<body>
<?php
	include('menu.php');
	include('sep_point.php');
	$query="SELECT * FROM " . $uni . "Stats ORDER BY week ASC";
	$retour=$sql->query($query);
	for($i=1; $data=$retour->fetch(); $i++)
		$stats[$i]=$data;
	$retour->closeCursor();
	$nbreData=count($stats);
	
?>
<!-- Le corps -->
<div id="corps">
		<h2>
			Statistiques de l'univers <span class="link"><?php echo $uniName; ?></span>
		</h2>
		<h4>Lors du dernier relevé:</h4>
		<div style="margin-left:60px;">
			<?php
				echo 'Nombre de joueur : ' . sep($stats[$nbreData]['playersNumber']) . '.<br />';
				echo 'Limite : ' . sep($stats[$nbreData]['limitFF']) . ' Points.<br />';
				echo 'Comptes au dessus de la limite : ' . sep($stats[$nbreData]['playerLimitNumber']) . '.<br /><br />';
			?>
		</div>		
		
		<h4>Nouveaux comptes</h4>
		<div id="newPlayers" style="width: 800px; height: 400px; margin: 0 auto"></div>
		<script type="text/javascript">
			Highcharts.setOptions({
				colors: ["#234A80"]
			});
			var newPlayers;
			newPlayers = new Highcharts.Chart({
				chart: {
					renderTo: 'newPlayers',
					defaultSeriesType: 'spline'
				},
				title: {
					text: 'Créations de nouveaux comptes',
					x: -20 //center
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
							return Highcharts.dateFormat('%d-%m-%Y', this.value);
						}
					}
				},
				yAxis: {
					title: {
						text: 'Comptes'
					},
					min:0
				},
				plotOptions: {
					line: {
						dataLabels: {
							enabled: true
						},
					enableMouseTracking: false
					}
				},
				tooltip: {
					formatter: function() {
							return '<span style="color:'+this.series.color+';font-weight:bold">'+ this.series.name +'</span><br/>'+ Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y;
					}
				},
				credits: {
					enabled: false
				},
				legend: {
					enabled: false
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
				series: [{
					name: 'Nouveaux Comptes',
					pointInterval: 7* 24 * 3600 * 1000,
					pointStart: Date.UTC(2010, 6, 14),
					data: [<?php
					for($i=42; $i<=$nbreData; $i++)
						echo (($i==42) ? '' : ', ') . ($stats[$i]['playersNumber']-$stats[$i-1]['playersNumber']);
					?>]
				}]
			});
		</script>
		
		
		<h4>Activité de l'univers</h4>
		<?php 
			if($uni=='taurus')
				$numberOfStats=1000;
			elseif($uni=='centaure')
				$numberOfStats=2500;
			else
				$numberOfStats=5000;
		?>
		
		<div id="universeActivity" style="width: 800px; height: 400px; margin: 0 auto"></div>
		<script type="text/javascript">
			Highcharts.setOptions({
				colors: ["#747272", "#56749E", "#359120"]
			});
			var universeActivity = new Highcharts.Chart({
				chart: {
					renderTo: 'universeActivity',
					defaultSeriesType: 'area'
				},
				title: {
					text: 'Activité de l\'univers <?php echo $uniName ?>'
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
							return Highcharts.dateFormat('%d-%m-%Y', this.value);
						}
					}
				},
				yAxis: {
					title: {
						text: 'Joueurs'
					}
				},
				tooltip: {
					formatter: function() {
							return '<span style="color:'+this.series.color+';font-weight:bold">'+ this.series.name +'</span><br/>'+
							Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ Highcharts.numberFormat(this.y, 0, ',', '.') +' joueurs';
					}
				},
				plotOptions: {
					area: {
						stacking: 'normal',
						lineColor: '#666666',
						lineWidth: 1,
						marker: {
							lineWidth: 1,
							lineColor: '#666666'
						},
						pointInterval: 7 * 24 * 3600 * 1000,
						pointStart: Date.UTC(2010, 6, 7)
					}
				},
				credits: {
					enabled: false
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
				series: [{
					name: 'AFK',
					data: [<?php
					for($i=41; $i<=$nbreData; $i++)
						echo (($i==52) ? (', ' . round(($stats[51]['afk5000Number']+$stats[53]['afk5000Number'])/2)) : ((($i==41) ? '' : ', ') . $stats[$i]['afk5000Number']));
					?>]
				}, {
					name: 'Pause',
					data: [<?php
					for($i=41; $i<=$nbreData; $i++)
						echo (($i==52) ? (', ' . round(($stats[51]['pause5000Number']+$stats[53]['pause5000Number'])/2)) : ((($i==41) ? '' : ', ') . $stats[$i]['pause5000Number']));
					?>]
				}, {
					name: 'Actif',
					data: [<?php
					for($i=41; $i<=$nbreData; $i++)
						echo (($i==52) ? (', ' . ($numberOfStats-round(($stats[51]['afk5000Number']+$stats[53]['afk5000Number'])/2)-round(($stats[51]['pause5000Number']+$stats[53]['pause5000Number'])/2))) : ((($i==41) ? '' : ', ') . ($numberOfStats-$stats[$i]['afk5000Number']-$stats[$i]['pause5000Number'])));
					?>]
				}]
			});
			universeActivity.series[0].hide();
		</script>
		<div class="astuce">AFK: Aucun changement de point durant une semaine. Statistiques basées sur les <?php echo sep($numberOfStats) ?> premiers joueurs de l'univers.</div>
		
		
		<h4>Activité des joueurs au dessus de la limite</h4><br />
		<div id="LimitActivity" style="width: 800px; height: 400px; margin: 0 auto"></div>
		<script type="text/javascript">
			var LimitActivity = new Highcharts.Chart({
				chart: {
					renderTo: 'LimitActivity',
					defaultSeriesType: 'area'
				},
				title: {
					text: 'Activité au dessus de la limite de <?php echo $uniName ?>'
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
							return Highcharts.dateFormat('%d-%m-%Y', this.value);
						}
					}
				},
				yAxis: {
					title: {
						text: 'Joueurs'
					},
					labels: {
						style: {
							fontSize: '9px'
						},
						formatter: function() {
							return this.value;
						}
					}
				},
				tooltip: {
					formatter: function() {
							return '<span style="color:'+this.series.color+';font-weight:bold">'+ this.series.name +'</span><br/>'+
							Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ Highcharts.numberFormat(this.y, 0, ',', '.') +' joueurs';
					}
				},
				plotOptions: {
					area: {
						stacking: 'normal',
						lineColor: '#666666',
						lineWidth: 1,
						marker: {
							lineWidth: 1,
							lineColor: '#666666'
						},
						pointInterval: 7 * 24 * 3600 * 1000,
						pointStart: Date.UTC(2010, 6, 7)
					}
				},
				credits: {
					enabled: false
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
				series: [{
					name: 'AFK',
					pointInterval: 7* 24 * 3600 * 1000,
					pointStart: Date.UTC(2010, 6, 7),
					data: [<?php
					for($i=41; $i<=$nbreData; $i++)
						echo (($i==52) ? (', ' . round(($stats[51]['afkLimitNumber']+$stats[53]['afkLimitNumber'])/2)) : ((($i==41) ? '' : ', ') . $stats[$i]['afkLimitNumber']));
					?>]
				}, {
					name: 'Pause',
					pointInterval: 7 * 24 * 3600 * 1000,
					pointStart: Date.UTC(2010, 6, 7),
					data: [<?php
					for($i=41; $i<=$nbreData; $i++)
						echo (($i==52) ? (', ' . round(($stats[51]['pauseLimitNumber']+$stats[53]['pauseLimitNumber'])/2)) : ((($i==41) ? '' : ', ') . $stats[$i]['pauseLimitNumber']));
					?>]
				}, {
					name: 'Actif',
					pointInterval: 7 * 24 * 3600 * 1000,
					pointStart: Date.UTC(2010, 6, 7),
					data: [<?php
					for($i=41; $i<=$nbreData; $i++)
						echo (($i==52) ? (', ' . (round(($stats[51]['playerLimitNumber']+$stats[53]['playerLimitNumber'])/2)-round(($stats[51]['afkLimitNumber']+$stats[53]['afkLimitNumber'])/2)-round(($stats[51]['pauseLimitNumber']+$stats[53]['pauseLimitNumber'])/2))) : ((($i==41) ? '' : ', ') . ($stats[$i]['playerLimitNumber']-$stats[$i]['afkLimitNumber']-$stats[$i]['pauseLimitNumber'])));
					?>]
				}]
			});
		</script>
		<div class="astuce">AFK: Aucun changement de point durant une semaine.<br />
		Les importantes variations du 06 au 20 octobre 2010 sont dû à une modifications dans la façon de compter la limite.</div>
		
		
		<h4>Répartition des planètes entre galaxies</h4>
		<?php
		$totalPlanete=0;
		include('non_accessible/connect.php');
		$queryPlapla="SELECT COUNT(*) AS planetsNumber FROM univers_" . $uni . " GROUP BY galaxie;";
		$retourPlapla=$sql->query($queryPlapla);
		for($i=0; $i<5; $i++)
		{
			$dataPlapla=$retourPlapla->fetch();
			$planetsNumber[$i]=$dataPlapla['planetsNumber'];
			$totalPlanete+=$planetsNumber[$i];
		}
		$retourPlapla->closeCursor();
		?>
		<div id="repartitionPlanetes" style="width: 600px; height: 350px; margin: 0 auto"></div>
		<script type="text/javascript">
		Highcharts.setOptions({
			colors: ["#234A80", "#7798BF", "#55BF3B"]
		});
			repartitionPlanetes = new Highcharts.Chart({
				chart: {
					renderTo: 'repartitionPlanetes',
					defaultSeriesType: 'bar'
				},
				title: {
					text: 'Répartition des planètes dans l\'univers <?php echo $uniName ?>'
				},
				xAxis: {
					categories: ['Galaxie 1', 'Galaxie 2', 'Galaxie 3', 'Galaxie 4', 'Galaxie 5'],
					title: {
						text: null
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Total: <?php echo sep($totalPlanete) ?> planètes',
						align: 'high'
					}
				},
				tooltip: {
					formatter: function() {
						return ''+
							 this.y +' planètes';
					}
				},
				plotOptions: {
					bar: {
						dataLabels: {
							enabled: true
						}
					}
				},
				legend: {
					enabled: false
				},
				credits: {
					enabled: false
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
				series: [{
					name: 'Planètes',
					data: [<?php echo $planetsNumber[0] . ', ' . $planetsNumber[1] . ', ' . $planetsNumber[2] . ', ' . $planetsNumber[3] . ', ' . $planetsNumber[4]?>]
				}]
			});
		</script>
</div>
<?php include('non_accessible/pub.php'); ?>
</body>
</html>
