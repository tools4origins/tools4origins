function Deroule(nom) {
	
	var objet = document.getElementById(nom); // entre les deux ' tu mes le nom du div que tu veux faire apparaître !
	
	if(objet.style.display == "none" || !objet.style.display){

		objet.style.display = "block";
		
		/*alert(objet.clientHeight);
		alert(objet.offsetWidth);
		alert(objet.scrollWidth);*/
		//if(objet.clientHeight)
			//var hActuel=objet.clientHeight;
		if(nom == "Analyseurs")
			var hFinal	  =	 135;
		else if(nom == "Simulateurs")
			var hFinal	  =	 180;
		else if(nom == "Divers")
			var hFinal	  =	 160;
		else
			var hFinal	  =	 120;
		
		var hActuel	 =	 0;
	   
		objet.style.maxHeight=0;
		var timer;
		var fct =		function ()
		{
			hActuel=parseInt(objet.style.maxHeight.replace('px', ''))+10;
			objet.style.maxHeight=hActuel+'px';
			if( hActuel > hFinal)
			{
				clearInterval(timer);
				objet.style.maxHeight		=	'';
			}
		};
		fct();


		timer = setInterval(fct,10);
	}else if(objet.style.display == "block"){
		objet.style.display='';
		var hFinal	  =	 0;
		if(objet.clientHeight)
			var hActuel=objet.clientHeight;
		else if(nom == "Analyseurs")
			var hActuel	  =	 135;
		else if(nom == "Simulateurs")
			var hActuel	  =	 180;
		else if(nom == "Divers")
			var hActuel	  =	 160;
		else
			var hActuel	  =	 120;
	   
		objet.style.maxHeight=hActuel + 'px';
		var timer;
		var fct =		function ()
		{
			hActuel=parseInt(objet.style.maxHeight.replace('px'))-10;
			objet.style.maxHeight=hActuel+'px';
//			alert(hActuel);

			if( hActuel < hFinal)
			{
					clearInterval(timer);
					objet.style.display	 =   "none";
					objet.style.maxHeight		=	'';
			}
		};
		fct();

		
		timer = setInterval(fct,10);	//Toute les 40 ms		
	}
}
