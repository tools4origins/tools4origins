function calculer() 
{
	var nbreParticipants=parseInt(document.getElementsByName("nbreParticipants")[0].value);
	var heuDeb=parseInt(document.getElementsByName("heuDeb")[0].value);
	var minDeb=parseInt(document.getElementsByName("minDeb")[0].value);
	var secDeb=parseInt(document.getElementsByName("secDeb")[0].value);
	var tpsDeb=heuDeb*3600+minDeb*60+secDeb;
	var nom;var nombre;var niveau;var delai;var tempsMission;
	var heuDep;var minDep;var secDep;var tpsDep;
	var nbreNonParticipants=0;
	var mission = new Array();
	
	function tri(a,b)
	{
		if(a['temps']>b['temps'])
			return a;
		else
			return b;
	}
	
	for(var i=0; i<=nbreParticipants; i++)
	{
		nom=document.getElementById("nom"+i).value;
		nombre=document.getElementById("nombre"+i).value;
		niveau=document.getElementById("complexe"+i).value;
		delai=parseInt(document.getElementById("delai"+i).value);
		tempsMission=nombre*Math.round(14*Math.pow(0.95,niveau))-delai;
		tpsDep=tpsDeb-tempsMission;
		if(tpsDep<0)
			tpsDep+=86400;
		heuDep=Math.floor(tpsDep/3600);
		minDep=Math.floor(tpsDep%3600/60);
		secDep=Math.floor(tpsDep%60);
		if(nombre>0)
		{
			mission[i-nbreNonParticipants]= new Array();
			mission[i-nbreNonParticipants]['temps']=tempsMission;
			mission[i-nbreNonParticipants]['texte']=nom+':	'+nombre+' Nanos partant d\'un complexe '+niveau+' à '+heuDep+'h '+minDep+'m '+secDep+'s\n';
		}
		else
			nbreNonParticipants++;
	}
	
	var modif=-1;
	for(n=0; n<20 && modif!=0; n++)
	{
		modif=0;
		for(i=0; i<=nbreParticipants-nbreNonParticipants; i++)
			if(mission[i+1])
			{
				if(mission[i]['temps']<=mission[i+1]['temps'])
				{
					temporaire=mission[i];
					mission[i]=mission[i+1];
					mission[i+1]=temporaire;
					modif=1;
				}
			}
	}
	document.getElementById('heureDep').innerHTML='';
	for(i=0; mission[i]; i++)
		if(mission[i])
			document.getElementById('heureDep').innerHTML+=mission[i]['texte'];
}
function add()
{
	document.getElementById('nbreParticipants').value++;
	value=parseInt(document.getElementById('nbreParticipants').value);
	document.getElementById('div'+value).innerHTML+='<input type="text" id="nom'+value+'" size="10" value="Joueur '+(value+1)+'" onfocus="this.value=\'\';this.onfocus=\'\';" onchange="this.onfocus=\'\';"/> : <span class="ui-stepper" onmousedown="startModify(event, 1, 50, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="nombre'+value+'" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> NanoSoldat(s) envoyé(s) à partir d\'un complexe niv <span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="complexe'+value+'" value="1" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> Délai: <span class="ui-stepper" onmousedown="startModify(event, 1, 100, calculer);" onmouseup="stopModify();" onmouseout="stopModify();"><input type="text" id="delai'+value+'" value="0" size="2" class="ui-stepper-textbox" onkeyup="calculer()"/><input type="button" class="ui-stepper-plus" value="+" />	<input type="button" class="ui-stepper-minus" value="-" /></span> s<br />\n<div id="div'+(value+1)+'"></div>';
}
