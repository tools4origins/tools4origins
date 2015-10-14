function change_graph(affiche)
{
	univers=document.getElementById('univers').value;
	joueur=document.getElementById('pseudo_joueur').value;
	document.getElementById('image_graph').src='graphique.php?joueur='+joueur+'&univers='+univers+'&affiche='+affiche+'&type=.png';
	document.getElementById('bb_code_graph').value='[img]http://tools4origins.fr.nf/graphique.php?joueur='+joueur+'&univers='+univers+'&affiche='+affiche+'&type=.png[/img]';
}