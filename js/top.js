var xhr = null;
var ancienTop = 0;
var ancienPseudo = '';
var ancienAlliance = '';
var ancienPause = true;

function verif()
{
	if(ancienTop != document.getElementById('top').value ||ancienPseudo != document.getElementById('pseudo').value ||ancienAlliance != document.getElementById('alliance').value)
		request(readData);
	
	ancienTop = document.getElementById('top').value;
	ancienPseudo = document.getElementById('pseudo').value;
	ancienAlliance = document.getElementById('alliance').value;
}

function request(callback)
{
	var univers = encodeURIComponent(document.getElementById('univers').value);
	var top = encodeURIComponent(document.getElementById('top').value);
	var pseudo = encodeURIComponent(document.getElementById('pseudo').value);
	var alliance = encodeURIComponent(document.getElementById('alliance').value);
	if(document.getElementById('pause').checked)
		pause=1;
	else
		pause=0;
	
	if (xhr && xhr.readyState != 0) {
		xhr.abort();
	}
	
	xhr = getXMLHttpRequest();
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			callback(xhr.responseText);
			document.getElementById("chargement").style.visibility = "hidden";
		} else if (xhr.readyState < 4) {
			document.getElementById("chargement").style.visibility = "visible";
		}
	};
	
	xhr.open("GET", "classement.php?univers="+univers+"&top="+top+"&pause="+pause+"&pseudo=" + pseudo + "&alliance=" + alliance, true);
	xhr.send(null);

}

function readData(data)
{
	var classement = document.getElementById("classement");
	classement.innerHTML=data;
}

function change(id, value)
{
	if(value=='+'  &&  document.getElementById(id).value<5000)
		document.getElementById(id).value=parseInt(document.getElementById(id).value)+100;
	else if(value=='-' &&  document.getElementById(id).value>0)
		document.getElementById(id).value=parseInt(document.getElementById(id).value)-100;
}
