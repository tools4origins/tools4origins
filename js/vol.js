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
	gal_dep=parseInt(document.getElementById("gal_dep").value);
	sys_dep=parseInt(document.getElementById("sys_dep").value);
	pos_dep=parseInt(document.getElementById("pos_dep").value);
	gal_arr=parseInt(document.getElementById("gal_arr").value);
	sys_arr=parseInt(document.getElementById("sys_arr").value);
	pos_arr=parseInt(document.getElementById("pos_arr").value);
	nbre_vx=parseInt(document.getElementById("nbre_vx").value);
	combu=parseInt(document.getElementById("combu").value);
	sublu=parseInt(document.getElementById("sublu").value);
	anti=parseInt(document.getElementById("anti").value);
	hyper=parseInt(document.getElementById("hyper").value);
	reac=document.getElementById("reac").value;
	pourcent_vitesse=document.getElementById("pourcent_vitesse").value;
	
	if(reac=="drive1")
		vreac=100;
	else if(reac=="propu1")
		vreac=85;
	else if(reac=="antig1")
		vreac=75;
	else if(reac=="antim1")
		vreac=50;
	else if(reac=="fusio1")
		vreac=35;
	else if(reac=="ioniq1")
		vreac=15;
	else if(reac=="ameli1")
		vreac=10;
	else if(reac=="primi1")
		vreac=5;
	else if(reac=="drive2")
		vreac=200;
	else if(reac=="propu2")
		vreac=170;
	else if(reac=="antig2")
		vreac=150;
	else if(reac=="antim2")
		vreac=100;
	else if(reac=="fusio2")
		vreac=70;
	else if(reac=="ioniq2")
		vreac=30;
	else if(reac=="ameli2")
		vreac=20;
	else if(reac=="primi2")
		vreac=10;
	else
		vreac=0;
	
	dg=Math.abs(gal_dep-gal_arr);
	ds=Math.abs(sys_dep-sys_arr);
	dp=Math.abs(pos_dep-pos_arr);
	if(dg==0)
	{
		bidule=anti*ds/7500
		document.getElementById("possible").src="images/true.png";
	}
	else
	{
		bidule=hyper*dg/100
		if(reac=="drive1" || reac=="drive2" || reac=="propu2" || reac=="propu1")
			document.getElementById("possible").src="images/true.png";
		else
			document.getElementById("possible").src="images/false.png";
	}
	carburant=((40+2*dp+5*ds+30*dg)*vreac*nbre_vx*0.03)*pourcent_vitesse;
	temps=((10000*carburant/nbre_vx/vreac/vreac/(1+(combu+sublu)/20+bidule))/pourcent_vitesse/pourcent_vitesse);
	temps_jou=Math.floor(temps/(86400));
	temps_heu=Math.floor((temps-temps_jou*(86400))/(3600));
	temps_min=Math.floor((temps-temps_jou*(86400)-temps_heu*(3600))/60);
	temps_sec=temps%60;
	document.getElementById("carbu").innerHTML=format(Math.round(carburant),0,'.');
	document.getElementById("temps_jou").innerHTML=Math.ceil(temps_jou) + ' j';
	document.getElementById("temps_heu").innerHTML=Math.ceil(temps_heu) + ' h';
	document.getElementById("temps_min").innerHTML=Math.ceil(temps_min) + ' m';
	document.getElementById("temps_sec").innerHTML=Math.ceil(temps_sec) + ' s';
}

function change(id, value)
{
	if(value=='+')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)+1;
	else if(value=='-')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)-1;
}
