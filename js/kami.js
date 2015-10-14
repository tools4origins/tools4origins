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
	tempsmin=document.getElementById("tempsmin").value;
	tempssec=document.getElementById("tempssec").value;
	temps=parseFloat(tempsmin)*60+parseFloat(tempssec);
	centredef=document.getElementById("centredef").value;
	nombre_bombe=document.getElementById("nbrebombe").value;
	nucleaire=document.getElementById("nucleaire").value;
	plasma=document.getElementById("plasma").value;
	electro=document.getElementById("electro").value;
	centre=document.getElementById("centre").value;
	puissance=(temps*(Math.pow(2,centredef)));
	document.getElementById("puissance").innerHTML=format(puissance,0,'.');
	document.getElementById("nbrebombe").innerHTML=format(Math.ceil(puissance/10000),0,'.');
	puissance_bombe=(nucleaire*500)+(plasma*3000)+(electro*10000);
	temps_bloque=puissance_bombe/(Math.pow(2,centre));
	temps_bloque_min=Math.floor(temps_bloque/60);
	temps_bloque_sec=temps_bloque%60;
	document.getElementById("puissance_bombe").innerHTML=format(puissance_bombe,0,'.');
	document.getElementById("temps_bloque_min").innerHTML=format(temps_bloque_min,0,'.') + " min";
	document.getElementById("temps_bloque_sec").innerHTML=format(temps_bloque_sec,0,'.') + " sec";
}
function change(id, value)
{
	if(value=='+')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)+1;
	else if(value=='-')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)-1;
}
