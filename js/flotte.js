function calculer() 
{
	function format(valeur,decimal,separateur)
	{
		var deci=Math.round( Math.pow(10,decimal)*(Math.abs(valeur)-Math.floor(Math.abs(valeur)))) ; 
		var val=Math.floor(Math.abs(valeur));
		if ((decimal==0)||(deci==Math.pow(10,decimal))) {val=Math.floor(Math.abs(valeur)); deci=0;}
		var val_format=val+"";
		var nb=val_format.length;
		for (var i=1;i<4;i++)
		{
			if (val>=Math.pow(10,(3*i)))
			{
				val_format=val_format.substring(0,nb-(3*i))+separateur+val_format.substring(nb-(3*i));
			}
		}
		if (decimal>0)
		{
			var decim=""; 
			for (var j=0;j<(decimal-deci.toString().length);j++) {decim+="0";}
			deci=decim+deci.toString();
			val_format=val_format+"."+deci;
		}
		if (parseFloat(valeur)<0) {val_format="-"+val_format;}
		return val_format;
	}
	var nbre_vx=parseInt(document.getElementById("nbre").value);
	var fret=parseInt(document.getElementById("infra").value);
	var nbre_compo=parseInt(document.getElementById("nombre_compo").value);
	var techno_arm=parseInt(document.getElementById("techno_armement").value);
	var techno_bou=parseInt(document.getElementById("techno_boubou").value);
	var techno_coq=parseInt(document.getElementById("techno_coque").value);
	var techno_sou=parseInt(document.getElementById("techno_soute").value);
	var attaque=0;
	var bouclier=0;
	var coque=0;
	var cout_fer=0;
	var cout_or=0;
	var cout_cri=0;
	var cout_hyd=0;
	if(fret==5000000)
	{
		cout_fer+=3250000;
		cout_or+=1000000;
		cout_cri+=300000;
		cout_hyd+=30000;
	}
	else if(fret==1000000)
	{
		cout_fer+=750000;
		cout_or+=250000;
		cout_cri+=70800;
		cout_hyd+=6000;
	}
	else if(fret==500000)
	{
		cout_fer+=295000;
		cout_or+=200000;
		cout_cri+=50000;
		cout_hyd+=35000;
	}
	else if(fret==100000)
	{
		cout_fer+=70500;
		cout_or+=30000;
		cout_cri+=10000;
		cout_hyd+=8500;
	}
	else if(fret==50000)
	{
		cout_fer+=36000;
		cout_or+=17000;
		cout_cri+=5000;
		cout_hyd+=3500;
	}
	else if(fret==20000)
	{
		cout_fer+=15000;
		cout_or+=7500;
		cout_cri+=1800;
		cout_hyd+=1200;
	}
	else if(fret==6000)
	{
		cout_fer+=4500;
		cout_or+=3000;
		cout_cri+=400;
		cout_hyd+=50;
	}
	else if(fret==1000)
	{
		cout_fer+=900;
		cout_or+=400;
		cout_cri+=50;
		cout_hyd+=30;
	}
	else if(fret==500)
	{
		cout_fer+=450;
		cout_or+=250;
		cout_cri+=30;
		cout_hyd+=0;
	}
	fret=Math.round(fret*(1+2*techno_sou/Math.exp(Math.log(fret)/Math.log(10))));
	var infos = new Array();
	infos['reacteuracombustionprimitive'] = Array (450,250,50,0,0,0,0,8);
	infos['reacteuracombustionamelioree'] = Array (750,600,70,30,0,0,0,15);
	infos['reacteursubluminiqueionique'] = Array (1250,750,120,0,0,0,0,18);
	infos['reacteursubluminiqueafusion'] = Array (2500,1990,275,45,0,0,0,22);
	infos['reacteuraantimatiere'] = Array (4000,2000,500,200,0,0,0,30);
	infos['reacteuraantigravite'] = Array (5000,3650,800,350,0,0,0,40);
	infos['reacteurhyperpropulseur'] = Array (5780,3700,1000,350,0,0,0,45);
	infos['reacteurdetypestardrive'] = Array (6500,4000,1450,350,0,0,0,50);
	infos['petitbouclier'] = Array (450,300,50,0,0,50,0,40);
	infos['champdeforce'] = Array (750,500,75,0,0,305,0,60);
	infos['bouclierdeflecteur'] = Array (1250,600,50,0,0,450,0,80);
	infos['bouclierdescroises'] = Array (1750,750,100,0,0,630,0,90);
	infos['bouclierdesgrandssages'] = Array (125000,800000,600000,0,0,850000,0,100000);
	infos['missiles'] = Array (200,50,0,0,50,0,0,20);
	infos['missilesenrichis'] = Array (250,750,30,65,85,0,0,30);
	infos['canonlaser'] = Array (350,100,75,90,125,0,0,40);
	infos['batterielaserrenforcee'] = Array (500,155,100,100,175,0,0,50);
	infos['canonaions'] = Array (700,180,50,45,200,0,0,55);
	infos['canonelectromagnetique'] = Array (800,200,90,125,250,0,0,60);
	infos['canonaplasma'] = Array (1450,525,250,200,550,0,0,110);
	infos['lanceurdeplasmaavance'] = Array (3000,980,450,400,1000,0,0,170);
	infos['missilesnucleaire'] = Array (4500,1500,710,500,1500,0,0,150);
	infos['rayonelectromagnetique'] = Array (8500,2000,800,700,2500,0,0,240);
	infos['bombesaimpulsion'] = Array (9000,3000,1500,850,3000,0,0,280);
	infos['lanceurdedrones'] = Array (1000000,1100000,750000,350000,1500000,0,0,100000);
	infos['coquesimple'] = Array (350,250,50,0,0,0,144,15);
	infos['coqueblindee'] = Array (750,525,75,0,0,0,325,30);
	infos['coqueorganique'] = Array (1500,550,50,0,0,0,540,45);
	infos['coquedescroises'] = Array (1750,750,125,0,0,0,720,55);
	infos['coquedesgrandssages'] = Array (1500000,1100000,800000,0,0,0,1700000,100000);
	infos['occulteurdescroises'] = Array (50000,45000,1250,5000,0,0,0,10);
	infos['occulteurdesgrandssages'] = Array (75000,25000,2000,8000,0,0,0,20);
	infos['archedesauvetage'] = Array (500,500,250,1000,0,0,0,15);
	infos['teleporteurs'] = Array (10000,10000,25000,40000,0,0,0,150);
	infos['rien'] = Array (0,0,0,0,0,0,0,0);
	for(var i=1; i<=nbre_compo; i++)
	{
		var type=document.getElementById("compo_" + i).value;
		var nbre=document.getElementById("nombre_compo_" + i).value;
		fret-=(infos[type][7])*nbre;
		attaque+=(infos[type][4])*nbre;
		bouclier+=(infos[type][5])*nbre;
		coque+=(infos[type][6])*nbre;
		cout_fer+=(infos[type][0])*nbre;
		cout_or+=(infos[type][1])*nbre;
		cout_cri+=(infos[type][2])*nbre;
		cout_hyd+=(infos[type][3])*nbre;
	}
	document.getElementById("fret").className=((fret>=0) ? "plus": "moins");
	document.getElementById("fret").innerHTML=format(fret*nbre_vx,0,'.');
	document.getElementById("attaque").innerHTML=format(attaque*nbre_vx,0,'.');
	document.getElementById("attaque_techno").innerHTML='(' + format((attaque*nbre_vx)*((10+techno_arm)/10),0,'.') + ')';
	document.getElementById("bouclier").innerHTML=format(bouclier*nbre_vx,0,'.');
	document.getElementById("bouclier_techno").innerHTML='(' + format(bouclier*nbre_vx*((10+techno_bou)/10),0,'.') + ')';
	document.getElementById("coque").innerHTML=format(coque*nbre_vx,0,'.');
	document.getElementById("coque_techno").innerHTML='(' + format(coque*nbre_vx*((10+techno_coq)/10),0,'.') + ')';
	document.getElementById("fer").innerHTML=format(cout_fer*nbre_vx,0,'.');
	document.getElementById("or").innerHTML=format(cout_or*nbre_vx,0,'.');
	document.getElementById("cristal").innerHTML=format(cout_cri*nbre_vx,0,'.');
	document.getElementById("hydro").innerHTML=format(cout_hyd*nbre_vx,0,'.');
	document.getElementById("pts").innerHTML=format(((cout_fer+cout_or+cout_cri+cout_hyd)/1000)*nbre_vx,0,'.');
}
function change(id, value)
{
	if(value=='+')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)+1;
	else if(value=='-')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)-1;
}
function add()
{
	document.getElementById('nombre_compo').value++;
	value=document.getElementById('nombre_compo').value;
	document.getElementById('compo'+value).innerHTML+="<select name=\"compo_" + value + "\" id=\"compo_" + value + "\" onChange=\"calculer()\">\n"+"<option value=\"rien\">Aucun</option>\n"+"<optgroup label=\"Réacteurs\">\n"+"<option value=\"reacteuracombustionprimitive\">Combustion primitive</option>\n"+"<option value=\"reacteuracombustionamelioree\">Combustion améliorée</option>\n"+"<option value=\"reacteursubluminiqueionique\">Subluminique Ionique</option>\n"+"<option value=\"reacteursubluminiqueafusion\">Subluminique à Fusion</option>\n"+"<option value=\"reacteuraantimatiere\">Antimatière</option>\n"+"<option value=\"reacteuraantigravite\">Antigravité</option>\n"+"<option value=\"reacteurhyperpropulseur\">Hyperpropulseurs</option>\n"+"<option value=\"reacteurdetypestardrive\">Stardrive</option>\n"+"</optgroup>\n"+"<optgroup label=\"Boucliers\">\n"+"<option value=\"petitbouclier\">Petit Bouclier</option>\n"+"<option value=\"champdeforce\">Champ de Force</option>\n"+"<option value=\"bouclierdeflecteur\">Bouclier Déflecteur</option>\n"+"<option value=\"bouclierdescroises\">Bouclier des Croisés</option>\n"+"<option value=\"bouclierdesgrandssages\">Bouclier des Grands Sages</option>\n"+"</optgroup>\n"+"<optgroup label=\"Armes\">\n"+"<option value=\"missiles\">Missiles</option>\n"+"<option value=\"missilesenrichis\">Missiles Enrichis</option>\n"+"<option value=\"canonlaser\">Canons Laser</option>\n"+"<option value=\"batterielaserrenforcee\">Batteries Laser Renf.</option>\n"+"<option value=\"canonaions\">Canons à Ions</option>\n"+"<option value=\"canonelectromagnetique\">Batteries Electro.</option>\n"+"<option value=\"canonaplasma\">Canons à Plasma</option>\n"+"<option value=\"lanceurdeplasmaavance\">Lanceurs de Plasma Avancé</option>\n"+"<option value=\"missilesnucleaire\">Missiles Nucléaire</option>\n"+"<option value=\"rayonelectromagnetique\">Rayons Electromagnétique</option>\n"+"<option value=\"bombesaimpulsion\">Bombes à Impulsion</option>\n"+"<option value=\"lanceurdedrones\">Lanceurs de drones</option>\n"+"</optgroup>\n"+"<optgroup label=\"Coques\">\n"+"<option value=\"coquesimple\">Coque Simple</option>\n"+"<option value=\"coqueblindee\">Coque Blindée</option>\n"+"<option value=\"coqueorganique\">Coque Organique</option>\n"+"<option value=\"coquedescroises\">Coque Des Croisés</option>\n"+"<option value=\"coquedesgrandssages\">Coque des Grands Sages</option>\n"+"</optgroup>\n"+"<optgroup label=\"Occulteurs\">\n"+"<option value=\"occulteurdescroises\">Occulteurs des Croisés</option>\n"+"<option value=\"occulteurdesgrandssages\">Occulteurs des Grands Sages</option>\n"+"</optgroup>\n"+"<optgroup label=\"Tranporteurs\">\n"+"<option value=\"archedesauvetage\">Arche de Sauvetage</option>\n"+"<option value=\"teleporteurs\">Téléporteurs</option>\n"+"</optgroup>\n"+"</optgroup>\n"+"</select>\n";
	document.getElementById('compo'+value).innerHTML+="<span class=\"ui-stepper\" onmousedown=\"startModify(event, 1, 100, calculer);\" onmouseup=\"stopModify();\" onmouseout=\"stopModify();\"><input type=\"text\" id=\"nombre_compo_" + value + "\" value=\"0\" size=\"2\" class=\"ui-stepper-textbox\" onkeyup=\"calculer()\"/><input type=\"button\" class=\"ui-stepper-plus\" value=\"+\" /><input type=\"button\" class=\"ui-stepper-minus\" value=\"-\" /></span><br /><span id=\"compo"+(parseInt(value)+1)+"></span>";
}
/*function addFlotte()
{
	nombre=parseInt(document.getElementById("nbre").value);
	nom=document.getElementById("nom").value;
	attaque=document.getElementById("attaque_techno").innerHTML.replace('(', '').replace(')', '');
	bouclier=document.getElementById("bouclier_techno").innerHTML.replace('(', '').replace(')', '');
	coque=document.getElementById("coque_techno").innerHTML.replace('(', '').replace(')', '');
	ligneTot=document.getElementById('ligneTotal');
	ligneTot.parentNode.removeChild(ligneTot);
	listeModeles=document.getElementById('flotte').children;
	listeModeles.innerHTML+='<tr class="ligne"><td>'+nom+' </td><td>'+attaque+' </td><td>'+bouclier+' </td><td>'+coque+' </td><td>'+nombre+' <img src="images/false.png" alt="" style="width:12px;height:12px;cursor:pointer" onclick="this.parentNode.parentNode.parentNode.innerHTML=\'\'"/></td></tr>';
	listeModeles.innerHTML+='<tr class="ligne_titre" id="ligneTotal"><td><b>Total</b></td><td id="totalAtt"><b>Non calculé</b></td><td id="totalBou"><b>Non calculé</b></td><td id="totalCoq"><b>Non calculé</b></td><td id="totalNbre"><b>Non calculé</b></td></tr>';
	calculeTotal();
}

function calculeTotal()
{
	listeModeles=document.getElementById('flotte').children[0];
	nbreModele=listeModeles.childElementCount;
	for(i=0; i<nbreModele; i++)
	{
		document.getElementById('totalAtt').innerHTML=;
		document.getElementById('totalBou').innerHTML=;
		document.getElementById('totalDef').innerHTML=;
		document.getElementById('totalNbre').innerHTML=;
	}
}*/
