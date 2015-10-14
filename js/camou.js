function calculer() 
{
	intra=parseInt(document.getElementById("intra").value);
	camou=parseInt(document.getElementById("camou").value);
	occu=document.getElementById("occu").value;
	
	if(occu=="croises")
		indice=1;
	else if(occu=="sages")
		indice=2;
	else
		indice=0;
		
	if(indice!=0)
		resultat=intra-(1.05*camou+2*indice);
	else
		resultat=100;
		
	if(resultat>=0)
		document.getElementById("destination").src="images/true.png";
	else
		document.getElementById("destination").src="images/false.png";
		
	if(resultat>=1)
		document.getElementById("nbrevx").src="images/true.png";
	else
		document.getElementById("nbrevx").src="images/false.png";
		
	if(resultat>=2)
		document.getElementById("joueur").src="images/true.png";
	else
		document.getElementById("joueur").src="images/false.png";
		
	if(resultat>=3)
		document.getElementById("infras").src="images/true.png";
	else
		document.getElementById("infras").src="images/false.png";
}
function change(id, value)
{
	if(value=='+')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)+1;
	else if(value=='-')
	document.getElementById(id).value=parseInt(document.getElementById(id).value)-1;
}
