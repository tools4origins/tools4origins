function Deroule(nom) {
	
	var objet = document.getElementById(nom); // entre les deux ' tu mes le nom du div que tu veux faire apparaître !
	
	if(objet.style.display == "none" || !objet.style.display){

		objet.style.display = "block";
		
		if(nom == "Analyseurs")
			var hFinal	  =	 135;
		else if(nom == "Simulateurs")
			var hFinal	  =	 180;
		else if(nom == "Divers")
			var hFinal	  =	 160;
		else
			var hFinal	  =	 120;
		
		var hActuel	 =	 0;
	   
		var timer;
		var fct =		function ()
		{
			hActuel  +=	   10;
			objet.style.maxHeight	 =	 hActuel	  +	 'px';
			if( hActuel > hFinal)
			{
				clearInterval(timer);
				objet.style.maxHeight		=	'';
			}
		};
		fct();


		timer = setInterval(fct,40);
	}else if(objet.style.display == "block"){
		
		var hFinal	  =	 0;
		if(nom == "Analyseurs")
			var hActuel	  =	 135;
		else if(nom == "Simulateurs")
			var hActuel	  =	 180;
		else if(nom == "Divers")
			var hActuel	  =	 160;
		else
			var hActuel	  =	 120;
	   
		var timer;
		var fct =		function ()
		{
			hActuel  -=   15;

			objet.style.maxHeight	 =	 hActuel	  +	 'px';

			if( hActuel < hFinal)
			{
					clearInterval(timer);
					objet.style.display	 =   "none";
					objet.style.maxHeight		=	'';
			}
		};
		fct();

		
		timer = setInterval(fct,40);	//Toute les 40 ms		
	}
}
