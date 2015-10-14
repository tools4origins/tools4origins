function addSelect(type)
{
	//Recupere le div general concerne
	var masterDiv;
	if (type == "entry") {
		masterDiv = document.getElementById('allEntry');
	} else if (type == "out") {
		masterDiv = document.getElementById('allOut');
	} else {
		return;
	}
	
	//Clone le premier sous-div
	var originalDiv = masterDiv.getElementsByTagName("div")[0];
	var clone = originalDiv.cloneNode(true);
	
	if (clone) {
		var allInput = clone.getElementsByTagName("input");
		for (var i = 0; i < allInput.length; i++) {
			allInput[i].value = 0;
		}
		masterDiv.appendChild(clone);
	}
}

function convert()
{
	//Retinitialise le message d'erreur
	var errorMsg = document.getElementById('error');
	errorMsg.innerText = "";
	
	//Recupere les div generaux
	var allEntry = document.getElementById('allEntry');
	var allOut = document.getElementById('allOut');
	
	//Verifie que la somme des taux de ponderation est egale a 100
	var sommeCoef = 0;
	var allInput = allOut.getElementsByTagName('input');
	for (var i = 0; i < allInput.length; i++) {
		if (allInput[i].id == 'outPercent') {
			sommeCoef += (1 * allInput[i].value);
		}
	}
	if (sommeCoef != 100) {
		errorMsg.innerText = "Erreur : La somme des coéfficients de pondération doit être égale à 100";
	} else {
		//CONVERSION
		//Somme des valeurs fer ponderees par leurs quantites
		var totalFer = 0;
		var allDiv = allEntry.getElementsByTagName('div');
		for (var i = 0; i < allDiv.length; i++) {
			var select = allDiv[i].getElementsByTagName('select')[0];
			var selectedValue = select.options[select.selectedIndex].value;
			var quantite = allDiv[i].getElementsByTagName('input')[0].value;
			//Verifie la presence de valeurs numeriques uniquement
			if (isNaN(quantite)) {
				errorMsg.innerText = "Erreur : Veuillez inserer uniquement des valeurs numériques";
				return;
			}
			totalFer += selectedValue * quantite;
		}
		
		//Multiplication par le taux
		var tauxValue = document.getElementById('taux').value;
		totalFer *= (1 + tauxValue / 100);
		totalFer = Math.round(totalFer);
					
		//Restitution en ressources demandees
		allDiv = allOut.getElementsByTagName('div');
		var lastRes = 0;
		for (var i = 0; i < allDiv.length; i++) {
			//Recupere le pourcentage de la ressource demandee
			var percent = allDiv[i].getElementsByTagName('input')[0].value;
			var select = allDiv[i].getElementsByTagName('select')[0];
			var selectedValue = select.options[select.selectedIndex].value;
			//Calcul du pourcentage de VF a traiter et le convertit
			var currentPercent = percent / 100 * totalFer + lastRes;
			var currentOutValue = currentPercent / selectedValue;
			//Place la valeur dans le input d'affichage
			allDiv[i].getElementsByTagName('input')[1].value = Math.round(currentOutValue);
			//Recupere l'eventuelle perte de ressource (VF demande - VF utilise)
			lastRes = currentPercent - currentOutValue * selectedValue;
		}
	}	
}
