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
	texte_modele=document.getElementsByTagName('textarea');
	techno_arm=parseInt(document.getElementById("techno_armement").value);
	techno_bou=parseInt(document.getElementById("techno_boubou").value);
	techno_coq=parseInt(document.getElementById("techno_coque").value);
	document.getElementById('liste_vx').innerHTML='Nom Attaque Bouclier Coque Nombre\n'; //r
	for(i=0; texte_modele[i] && texte_modele[i].id!='liste_vx'; i++)
	{
		infos= new Array();
		infos['Coque']=0;
		infos['Bouclier']=0;
		infos['Attaque']=0;
		ligne=texte_modele[i].value.split("\n");
		for(deb=0; ligne[deb]==''; deb++); 
		if(ligne[5])
		{
			nombre=/\([0-9.]+\) ?$/.exec(ligne[deb]).toString().replace('(', '').replace(')', '').replace('.', '');
			nom=/^.+ /.exec(ligne[deb]).toString();
			for(c=4; ligne[deb+c]!=''; c++)
			{
				if((ligne[deb+c].search(/\(/))+1)
				{
					infos[/^.+ :/.exec(ligne[deb+c]).toString().replace(' :', '')]=/: .+ \(/.exec(ligne[deb+c]).toString().replace(' : ', '').replace(' (', '').replace('.', '');
				}
				else
				{
					infos[/^.+ :/.exec(ligne[deb+c]).toString().replace(' :', '')]=/: [0-9.]+/.exec(ligne[deb+c]).toString().replace(/\./gi, '').replace(':', '').replace(' ', '');
				}
			}
			document.getElementById('liste_vx').innerHTML+=nom + format(Math.floor(parseInt(infos['Attaque'])*(1+techno_arm/10)),0,'.') + ' ' + format(Math.floor(parseInt(infos['Bouclier'])*(1+techno_bou/10)),0,'.') + ' ' + format(Math.floor(parseInt(infos['Coque'])*(1+techno_coq/10)),0,'.') + ' ' + format(nombre,0,'.') + ' \n';
		}
	}
	document.getElementById('liste_vx').innerHTML+='Total => Non calculé (c\'est normal et sans incidence)\n';
}
function add()
{
	nombre_modele=document.getElementById('nombre_modele').value;
	document.getElementById('modele'+nombre_modele).innerHTML+='<textarea rows="15" cols="30"></textarea>';
}
