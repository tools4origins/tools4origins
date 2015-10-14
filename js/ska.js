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
	nombre_marines=document.getElementById("marines").value;
	nombre_unites_elite=document.getElementById("unites_elite").value;
	nombre_biosoldat=document.getElementById("biosoldat").value;
	nombre_agentsecret=document.getElementById("agentsecret").value;
	nombre_soldat_droide=document.getElementById("soldat_droide").value;
	nombre_androide=document.getElementById("androide").value;
	nombre_nanos=document.getElementById("nanos").value;
	nombre_milis=document.getElementById("militaires").value;
	assmax=100*nombre_marines+300*nombre_unites_elite+600*nombre_biosoldat+500*nombre_agentsecret+1200*nombre_soldat_droide+5000*nombre_androide+75000*nombre_nanos;
	document.getElementById("assmax").innerHTML=format(assmax,0,'.');
	document.getElementById("assnbrequai").innerHTML=format(assmax*6,0,'.');
	document.getElementById("kidmax").innerHTML=format(assmax/4,0,'.');
	document.getElementById("kidnbrequai").innerHTML=format(assmax*1.5,0,'.');
	document.getElementById("milikid").innerHTML=format(Math.ceil(nombre_milis/6),0,'.');
	document.getElementById("nano_envo_kid").innerHTML=format(Math.ceil(nombre_milis/6/18750),0,'.');
	document.getElementById("nano_envo_ass").innerHTML=format(Math.ceil(nombre_milis/6/75000),0,'.');
}
function change(id, value)
{
	if(value=='+')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)+1;
	else if(value=='-')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)-1;
}
