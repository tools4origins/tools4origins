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
	armement=parseFloat(document.getElementById("techno_armement").value);
	techno_coque=parseFloat(document.getElementById("techno_coque").value);
	tour_combat=parseFloat(document.getElementById("tour_combat").value);
	document.getElementById('liste_tour_combat').innerHTML=' ' + tour_combat;
	canon_laser=parseFloat(document.getElementById("canon_laser").value);
	document.getElementById('liste_canon_laser').innerHTML=' ' + canon_laser;
	grand_canon_laser=parseFloat(document.getElementById("grand_canon_laser").value);
	document.getElementById('liste_grand_canon_laser').innerHTML=' ' + grand_canon_laser;
	rayon_tracteur=parseFloat(document.getElementById("rayon_tracteur").value);
	document.getElementById('liste_rayon_tracteur').innerHTML=' ' + rayon_tracteur;
	lance_missile=parseFloat(document.getElementById("lance_missile").value);
	document.getElementById('liste_lance_missile').innerHTML=' ' + lance_missile;
	satellite=parseFloat(document.getElementById("satellite").value);
	document.getElementById('liste_satellite').innerHTML=' ' + satellite;
	batterie=parseFloat(document.getElementById("batterie").value);
	document.getElementById('liste_batterie').innerHTML=' ' + batterie;
	canon_plasma=parseFloat(document.getElementById("canon_plasma").value);
	document.getElementById('liste_canon_plasma').innerHTML=' ' + canon_plasma;
	canon_electro=parseFloat(document.getElementById("canon_electro").value);
	document.getElementById('liste_canon_electro').innerHTML=' ' + canon_electro;
	silo_missile=parseFloat(document.getElementById("silo_missile").value);
	document.getElementById('liste_silo_missile').innerHTML=' ' + silo_missile;
	complexe=parseFloat(document.getElementById("complexe").value);
	document.getElementById('liste_complexe').innerHTML=' ' + complexe;
	MII=parseFloat(document.getElementById("MII").value);
	document.getElementById('liste_MII').innerHTML=' ' + MII;
	attaque=tour_combat*100+canon_laser*200+grand_canon_laser*450+rayon_tracteur*1000+lance_missile*500+satellite*4400+batterie*5000+canon_plasma*9500+canon_electro*13000+silo_missile*50000+complexe*120000+MII*34000;
	coque=tour_combat*100+canon_laser*200+grand_canon_laser*500+rayon_tracteur*750+lance_missile*200+satellite*3000+batterie*2900+canon_plasma*6500+canon_electro*8500+silo_missile*50000+complexe*80000+MII*0;
	nombre=tour_combat+canon_laser+grand_canon_laser+rayon_tracteur+lance_missile+satellite+batterie+canon_plasma+canon_electro+silo_missile+complexe;
	fer=tour_combat*500+canon_laser*750+grand_canon_laser*2000+rayon_tracteur*2000+lance_missile*2500+satellite*5000+batterie*5500+canon_plasma*9000+canon_electro*11500+silo_missile*5000+complexe*75000+MII*5000;
	or=tour_combat*350+canon_laser*600+grand_canon_laser*750+rayon_tracteur*750+lance_missile*1250+satellite*2600+batterie*3000+canon_plasma*6000+canon_electro*7000+silo_missile*2500+complexe*50000+MII*4000;
	cri=tour_combat*50+canon_laser*75+grand_canon_laser*75+rayon_tracteur*175+lance_missile*100+satellite*1500+batterie*2000+canon_plasma*2500+canon_electro*500+silo_missile*25000+complexe*50000+MII*2500;
	hydro=tour_combat*0+canon_laser*0+grand_canon_laser*0+rayon_tracteur*0+lance_missile*280+satellite*750+batterie*0+canon_plasma*1750+canon_electro*3500+silo_missile*10000+complexe*7500+MII*1500;
	document.getElementById("attaque").innerHTML=format(attaque,0,'.');
	document.getElementById("attaque_techno").innerHTML='('+format((attaque*(1+0.1*armement)),0,'.')+')';
	document.getElementById("liste_attaque").innerHTML=' '+format((attaque*(1+0.1*armement)),0,'.');
	document.getElementById("coque").innerHTML=format(coque,0,'.');
	document.getElementById("coque_techno").innerHTML='('+format((coque*(1+0.1*techno_coque)),0,'.')+')';
	document.getElementById("liste_coque").innerHTML=' '+format((coque*(1+0.1*techno_coque)),0,'.');
	document.getElementById("nombre").innerHTML=format((nombre+MII),0,'.');
	document.getElementById("nombre_sans_mii").innerHTML='('+format(nombre,0,'.')+')';
	document.getElementById("liste_nombre").innerHTML=format((nombre+MII),0,'.');
	document.getElementById("fer").innerHTML=format(fer,0,'.');
	document.getElementById("or").innerHTML=format(or,0,'.');
	document.getElementById("cri").innerHTML=format(cri,0,'.');
	document.getElementById("hydro").innerHTML=format(hydro,0,'.');
	document.getElementById("pts").innerHTML=format((fer+or+cri+hydro)/1000,0,'.');
}
function change(id, value)
{
	if(value=='+')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)+1;
	else if(value=='-')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)-1;
}
