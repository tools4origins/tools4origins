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
	nombre_vx=document.getElementById("nbre").value;
	nombre_ldd=document.getElementById("ldd").value;
	nombre_bgs=document.getElementById("bgs").value;
	nombre_cgs=document.getElementById("cgs").value;
	techno_arm=document.getElementById("techno_armement").value;
	techno_bou=document.getElementById("techno_boubou").value;
	techno_coq=document.getElementById("techno_coque").value;
	occu=document.getElementById("occu").checked;
	nombre_scompo=parseInt(nombre_cgs)+parseInt(nombre_bgs)+parseInt(nombre_ldd);
	document.getElementById("attaque").innerHTML=format(nombre_ldd*1500000*nombre_vx,0,'.');
	document.getElementById("attaque_techno").innerHTML='('+format((nombre_ldd*1500000)*(1+techno_arm*0.1)*nombre_vx,0,'.')+')';
	document.getElementById("bouclier").innerHTML=format(nombre_bgs*850000*nombre_vx,0,'.');
	document.getElementById("bouclier_techno").innerHTML='('+format((nombre_bgs*850000)*(1+techno_bou*0.1)*nombre_vx,0,'.')+')';
	document.getElementById("coque").innerHTML=format(nombre_cgs*1700000*nombre_vx,0,'.');
	document.getElementById("coque_techno").innerHTML='('+format((nombre_cgs*1700000)*(1+techno_coq*0.1)*nombre_vx,0,'.')+')';
	document.getElementById("fret").innerHTML=format((4999900-nombre_scompo*100000-occu*20)*nombre_vx,0,'.');
	if((4999900-nombre_scompo*100000)>0)
	document.getElementById("fret").className="plus";
	if((4999900-nombre_scompo*100000)<0)
	document.getElementById("fret").className="moins";
	document.getElementById("fer").innerHTML=format((3250000+2*6500+nombre_ldd*1000000+nombre_bgs*125000+nombre_cgs*1500000+occu*75000)*nombre_vx,0,'.');
	document.getElementById("or").innerHTML=format((1000000+2*4000+nombre_ldd*1100000+nombre_bgs*800000+nombre_cgs*1100000+occu*25000)*nombre_vx,0,'.');
	document.getElementById("cristal").innerHTML=format((300000+2*1450+nombre_ldd*750000+nombre_bgs*600000+nombre_cgs*800000+occu*2000)*nombre_vx,0,'.');
	document.getElementById("hydro").innerHTML=format((30000+2*350+nombre_ldd*350000+occu*8000)*nombre_vx,0,'.');
	document.getElementById("pts").innerHTML=format((4604.6+nombre_ldd*3200+nombre_bgs*1525+nombre_cgs*3400+occu*110)*nombre_vx,0,'.');
}
function change(id, value)
{
	if(value=='+')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)+1;
	else if(value=='-')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)-1;
}
