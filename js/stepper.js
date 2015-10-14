//Variables globales
var varEvent;
var varIncrement;
var varMaj;
var timer;
var varInterval;

function startModify(event, increment, interval, maj)
{
	//Enregistre les variables au moment de l'appui
	varEvent = event;
	varIncrement = increment;
	varInterval = interval;
	varMaj = function () {
		maj();
	}
	//Execute la modification correspondant au clic souris puis lance le timer pour la boucle potentielle
	modifyValue();
	timer = setTimeout("boucle()", 250);
}

function boucle()
{
	//Boucle d'appel de la fonction de modification
	timer = setTimeout("modifyValue(); boucle()", varInterval);
}

function modifyValue()
{
	//Definit si le bouton clique est plus ou moins et quitte quand le cas contraire
	var currentIncrement = varIncrement;
	if (varEvent.target.value == "-")
		currentIncrement = - varIncrement;
	else if (varEvent.target.value != "+")
		return;
	//Modifie la valeur du champ en question
	var input = varEvent.target.parentNode.getElementsByTagName('input')[0];
	//Reset le stepper s'il ne contient pas un nombre
	if (input.value != parseInt(input.value))
		input.value = 0;
	if(parseInt(input.value) + parseInt(currentIncrement)>=0)
		input.value = parseInt(input.value) + parseInt(currentIncrement);
	else
		input.value = 0;
	//Execute une fonction donnee pour mettre a jour un potentiel formulaire dynamique
	varMaj();
}

function stopModify()
{
	//Arrete le timer lorsque la souris est relachee
	clearTimeout(timer);
}
