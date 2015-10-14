var zindex=0;
var fenetre_deplacee=0;
var fenetre_deplacee_difx=0;
var fenetre_deplacee_dify=0;
var F = new Array('name');
var Valid;
var visible=1;
var lock = new Array();
var xhr = null;
function creer_fenetre(left,top,width,height,name,types,txt){	
		for(var i=0; i < F.length; i++)
		{
			if(F[i] == name) 
			{
				Valid = true;
				i=F.length+1
			}
			else
			{
				Valid = false;
			}
		}
		//typeof(F)
		if(Valid == true)
		{
			
		} else {	
			F[F.length+1]=name;
			var fenetre = document.createElement("div"); //Création du bloc principal
			fenetre.className="infos_joueur"; //On donne un attribut class à  cette div
			fenetre.id = name;
			fenetre.title = name;
			fenetre.style.left=left+5+"px"; //Modification de l'attribut left du style de notre div
			fenetre.style.top=top+5+"px";
			if(types != "bulle")
				fenetre.style.width=width+"px";
			if(height!='NF')
			{
				fenetre.style.height=height+"px";
			}
			fenetre.style.display='block';
			if(document.all) fenetre.attachEvent("onmousedown",function (){premier_plan(fenetre)}); //Pour IE
			else fenetre.addEventListener("mousedown",function (){premier_plan(fenetre)},true); //Pour les autres
			
			//On crée de la même manière la div "haut" :
			var haut = document.createElement("div");
			haut.className="haut";
	
			//On crée ensuite les trois div qui y figureront :
			var haut_gauche = document.createElement("div");
			haut_gauche.className="haut_gauche_infos";
			var haut_droite = document.createElement("div");
			haut_droite.className="haut_droite_infos";
			// Bouton close
			// var btn_exit = document.createElement("img");
			// btn_exit.className="img_close";
			// btn_exit.border = "0";
			// btn_exit.src = "images/btn-close.png";
			//Lien du tire pr fermer
			var Exit = document.createElement("a_infos");
			Exit.href = "javascript:delElem(\'"+name+"\');"; 
			 //Ici on a créé un titre
			var titre = document.createTextNode(name); 
			//Exit.appendChild(btn_exit);
			//haut_droite.appendChild(Exit);
			var haut_centre = document.createElement("div");
			haut_centre.className="haut_centre_infos";
			//haut_centre.appendChild(titre); 
			//Puis on les insère une par une dans notre bloc "haut" :
			haut.appendChild(haut_gauche);
			haut.appendChild(haut_droite);
			haut.appendChild(haut_centre);
			//On insère le tout (la div "haut" et les trois div à  l'intérieur) dans le bloc "fenetre":
			fenetre.appendChild(haut);
			
			//On fait de même pour la div "milieu"
			var milieu = document.createElement("div");
			milieu.className="milieu_infos";
			var milieu_gauche = document.createElement("div");
			milieu_gauche.className="milieu_gauche_infos";
			var milieu_droite = document.createElement("div");
			milieu_droite.className="milieu_droite_infos";
			var milieu_centre = document.createElement("div");
			milieu_centre.className="milieu_centre_infos";
			if(types == "html")
			{
				var texte = document.createElement("iframe");
				texte.src = txt;
				texte.frameborder = "0";
				texte.width = width-19;
				texte.height = height-4;
				texte.name = name;
				milieu_centre.appendChild(texte);
			}
			else if(types == "bulle")
			{
				BulleInfo(txt, milieu_centre, MettreInfo);
			}
			else
			{
				var texte = document.createTextNode(txt); //Ici on a créé un texte createTextNode
				milieu_centre.innerHTML=txt;
			}
			milieu.appendChild(milieu_gauche);
			milieu.appendChild(milieu_droite);
			milieu.appendChild(milieu_centre);
			fenetre.appendChild(milieu);
			//Pour mousedown
			addEvent(milieu,"dblclick",function (event){commencer_deplacement(event,fenetre)});
			//Et pour mouseup
			addEvent(milieu,"mouseup",arreter_deplacement);
			//On fait de même pour la div "bas"
			var bas = document.createElement("div");
			bas.className="bas_infos";
			var bas_gauche = document.createElement("div");
			bas_gauche.className="bas_gauche_infos";
			var bas_droite = document.createElement("div");
			bas_droite.className="bas_droite_infos";
			var bas_centre = document.createElement("div");
			bas_centre.className="bas_centre_infos";
			bas.appendChild(bas_gauche);
			bas.appendChild(bas_droite);
			bas.appendChild(bas_centre);
			fenetre.appendChild(bas);
	 
			premier_plan(fenetre); //On met au premier plan notre fenêtre
			document.body.appendChild(fenetre);
		}

}

function passage_souris(event,width,height,name,type,contenu){
if(lock[name]==undefined)
{
	lock[name]=0.1;
}
var x = event.pageX;
var y = event.pageY;
creer_fenetre(x,y,width,height,name,type,contenu);

if(lock[name]!=10)
{
	var fenetre=document.getElementById(name);
	commencer_deplacement(event,fenetre);
}
}

/*function creer_btn(left,top,js,img){
	var fenetre = document.createElement("div"); //Création du bloc principal
			fenetre.className="fenetre"; //On donne un attribut class à  cette div
			fenetre.id = "btn_fond";
			fenetre.style.left=left+"px"; //Modification de l'attribut left du style de notre div
			fenetre.style.top=top+"px";
			fenetre.style.width="50px";
			fenetre.style.height="50px";
			//Pour mousedown
			addEvent(fenetre,"mousedown",function (event){commencer_deplacement(event,fenetre)});
			//Et pour mouseup
			addEvent(fenetre,"mouseup",arreter_deplacement);
			//On crée de la même manière la div "haut" :
			var image = document.createElement("img");
			image.src=img;
			image.border="0";
			var btn = document.createElement("a");
			btn.href = "javascript:"+js;
			btn.style.width="25px";
			btn.style.height="25px";
			
			//On insère le tout:
			btn.appendChild(image);
			fenetre.appendChild(btn);
			document.body.appendChild(fenetre);
}*/

function BulleInfo(joueur, bulle, callback)
{
	var univers = encodeURIComponent(document.getElementById('univers').value);
	var pseudo = encodeURIComponent(joueur);
	
	if (xhr && xhr.readyState != 0) {
		xhr.abort();
	}
	
	xhr = getXMLHttpRequest();
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			bulle.innerHTML=xhr.responseText;
//			callback(bulle);
		}
	};
	
	xhr.open("GET", "infos_joueur.php?uni="+univers+"&pseudo=" + pseudo, true);
	xhr.send(null);
}

function MettreInfo(data)
{
	var classement = document.getElementById("classement");
	classement.innerHTML=data;
}

function premier_plan(fenetre) {
        zindex++; //On incrémente la variable globale
        fenetre.style.zIndex=zindex; //On affecte sa valeur au z-index de la fenêtre concernée
}

function commencer_deplacement(ev,fenetre) {
        fenetre_deplacee=fenetre; //On définit quelle fenêtre est en cours de déplacement
        var old_mouseCoords=mouseCoords(ev); //On récupère la position de la souris
        var old_windowCoords=getPosition(fenetre); //Et la position de notre fenêtre
        //On stocke les différences dans les variables globales
        fenetre_deplacee_difx=old_mouseCoords.x-old_windowCoords.x;
        fenetre_deplacee_dify=old_mouseCoords.y-old_windowCoords.y;
}

function arreter_deplacement() {
        fenetre_deplacee=0; //La variable vaut 0
}

function addEvent(obj,event,fct){
     if(obj.attachEvent)
        obj.attachEvent('on' + event,fct);
     else
        obj.addEventListener(event,fct,true);
}

function deplacer_fenetre(ev) {
        if(fenetre_deplacee!=0) {
                var souris=mouseCoords(ev);
                fenetre_deplacee.style.left=(souris.x-fenetre_deplacee_difx)+'px'; //On soustrait l'abscisse du curseur par rapport au coin gauche de la fenêtre
                fenetre_deplacee.style.top=(souris.y-fenetre_deplacee_dify)+'px'; //On fait de même avec l'ordonnée
        }
}

function mouseCoords(ev){
        if(ev.pageX || ev.pageY){
                return {x:ev.pageX, y:ev.pageY};
        }
        return {
                x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
                y:ev.clientY + document.body.scrollTop  - document.body.clientTop
        };
}

function getPosition(e){
        var left = 0;
        var top  = 0;
        while (e.offsetParent){
                left += e.offsetLeft;
                top  += e.offsetTop;
                e     = e.offsetParent;
        }
        left += e.offsetLeft;
        top  += e.offsetTop;
        return {x:left, y:top};
}

function delElem(child)
{
	if(lock[child]!=10)
	{
		var ref = document.getElementById(child); 
		for(var i=0; i < F.length; i++)
		{
			if(F[i] == child)
			{
				F[i] = "";
				F.sort();
				i=F.length+1
			}
		}
		document.body.removeChild(ref)
	}
	else
	{
		//alert(child+":"+lock[child]);
	}
}
