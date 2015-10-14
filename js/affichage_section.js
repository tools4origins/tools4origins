function affichage(section) 
{

	var section_a_afficher;
	
	section_a_afficher = document.getElementById(section);
	
	if (section_a_afficher.style.display == "none") 
	{
		section_a_afficher.style.display = ""
	}
	else 
	{
		section_a_afficher.style.display = "none"
	}
}
function non_affichage(section) 
{

	var section_a_afficher;
	
	section_a_afficher = document.getElementById(section);
	section_a_afficher.style.display = "none"
}