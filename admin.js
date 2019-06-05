/* Ensemble des fonctions JavaScript permettant de faire fonctionner la page admin.php */

function getXhr() {
  var xhr = null;
  if (window.XMLHttpRequest) // FF & autres
     xhr = new XMLHttpRequest();
  else if (window.ActiveXObject) { // IE < 7
       try {
         xhr = new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
         xhr = new ActiveXObject("Microsoft.XMLHTTP");
       }
  } else { // Objet non supporté par le navigateur
     alert("Votre navigateur ne supporte pas AJAX");
     xhr = false;
  }
  return xhr;
}


function execInfo() {                                 //Affiche toutes les informations relatives à l'utilisateur sélectionné dans la liste déroulante
  xhr = getXhr();
  id_util=document.getElementById('eleve').value;
  xhr.onreadystatechange = function info() {
    if (xhr.readyState == 4 && xhr.status == 200){
      res=xhr.responseText;
      document.getElementById('affichage').innerHTML=res;
       }
    }
  xhr.open("POST","admin_info.php",true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  xhr.send("id_util="+id_util);
}

function execPrint() {                                //Affiche une entrée utilisateur afin de modifier l'information personnelle choisie en fonction du type d'information
  xhr = getXhr();
  key=document.getElementById('cle').value;
  id_util=document.getElementById('eleve').value;
  xhr.onreadystatechange = function print() {
    if (xhr.readyState == 4 && xhr.status == 200){
      res=xhr.responseText;
      document.getElementById('nouveau').innerHTML=res;
       }
    }
  xhr.open("POST","admin_print.php",true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  xhr.send("key="+key+"&id_util="+id_util);
}


function reveal(id) {                         //Révèle les champs span selon leur id, i.e. enlève leur attribut 'hidden'
  key=document.getElementById('cle').value;
  if ( (key=='langues')|(key=='caractere')|(key=='competences')|(key=='outils') ){
    document.getElementById(id).setAttribute('hidden',true);
  } else {
    document.getElementById(id).removeAttribute('hidden');
  }
	
}



function execRemplace() {
  xhr = getXhr();
  id_util=document.getElementById('eleve').value;
  key=document.getElementById('cle').value;

/* La 'forme' de la donnée (new_data) est différente selon la nature de la clé (ex: pour le type d'utilisateur on utilise un champ de type radio
qui n'est pas récupéré de la même façon qu'un champ de texte */

  if ((key == "sexe") | (key == "type")) {                    //valeur provenant d'un champ de type radio 
    for (i = 0; i < 3; i++) {
      if (document.getElementsByName(key)[i].checked) {
        break;
      }
    }
    new_data = document.getElementsByName(key)[i].value;

    



  } else {
    new_data=document.getElementById('new').value;     //valeur provenant d'un champ de texte

  }
  

  xhr.onreadystatechange = function info() {
    if (xhr.readyState == 4 && xhr.status == 200){
      res=xhr.responseText;
      document.getElementById('confirm').innerHTML="<b>Votre requête a bien été effectuée !</b>"+res;
       }
    }
  xhr.open("POST","admin_modif.php",true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  xhr.send("new_data="+new_data+"&key="+key+"&id_util="+id_util);
}


function ajoutAnnex() {                     //Permet d'ajouter une information dans la BDD selon un champ et un utilisateur précis
  xhr = getXhr();
  key=document.getElementById('cle').value;                   //Récupère les informations nécessaires (champ qu'il faut modifier + id de l'utilisateur + nouvelle valeur)
  id_util=document.getElementById('eleve').value;
  new_data=document.getElementById('not'+key).value;
  modif="ajout";                  //Variable pour que la page admin_annex.php sache si on souhaite ajouter ou supprimer l'information
  if (new_data!=="") {              //Si l'utilisateur essaye d'ajouter une information qui n'est pas présente dans la liste
    xhr.onreadystatechange = function annex() {
    if (xhr.readyState == 4 && xhr.status == 200){
      res=xhr.responseText;
      document.getElementById('status').innerHTML=res;
       }
    }
  xhr.open("POST","admin_annex.php",true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  xhr.send("key="+key+"&id_util="+id_util+"&modif="+modif+"&new_data="+new_data);
  }
  
}

function supprAnnex() {                     //Permet de supprimer une information dans la BDD selon un champ et un utilisateur précis
  xhr = getXhr();
  key=document.getElementById('cle').value;
  id_util=document.getElementById('eleve').value;
  new_data=document.getElementById(key).value;
  modif="suppr";                  //Variable pour que la page admin_annex.php sache si on souhaite ajouter ou supprimer l'information
  if (new_data!=="") {              //Si l'utilisateur essaye de supprimer une information qui n'est pas présente dans la liste
    xhr.onreadystatechange = function supannex() {
    if (xhr.readyState == 4 && xhr.status == 200){
      res=xhr.responseText;
      document.getElementById('status').innerHTML=res;
       }
    }
  xhr.open("POST","admin_annex.php",true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  xhr.send("key="+key+"&id_util="+id_util+"&modif="+modif+"&new_data="+new_data);
    }
}

function supprAccount() {                           //Supprime le compte de l'utilisateur sélectionné
  xhr = getXhr();
  id_util=document.getElementById('eleve').value;      //Récupération de l'id de l'utilisateur
  xhr.onreadystatechange = function sup() {
    if (xhr.readyState == 4 && xhr.status == 200){
      res=xhr.responseText; 
      document.getElementById('del').innerHTML=res;
       }
    }
  xhr.open("POST","admin_delete.php",true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  xhr.send("id_util="+id_util);
}

function changeBan(val) {                           //Bannit le compte de l'utilisateur sélectionné : "val" prend 0 ou 1, dans le premier cas on retire le bannissement et quand "val" vaut 1 on bannit l'utilisateur 
  xhr = getXhr();
  id_util=document.getElementById('eleve').value;      //Récupération de l'id de l'utilisateur
  xhr.onreadystatechange = function sup() {
    if (xhr.readyState == 4 && xhr.status == 200){
      res=xhr.responseText; 
      document.getElementById('ban').innerHTML=res;
       }
    }
  xhr.open("POST","admin_ban.php",true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  xhr.send("id_util="+id_util+"&val="+val);
}

function getMessagerie() {  // récupère le contenu de la messagerie de l'utilisateur sélectionné
  xhr = getXhr();
  id_util=document.getElementById('eleve').value;      //Récupération de l'id de l'utilisateur
  xhr.onreadystatechange = function sup() {
    if (xhr.readyState == 4 && xhr.status == 200){
      res=xhr.responseText; 
      document.getElementById('msg').innerHTML=res;
       }
    }
  xhr.open("POST","admin_messagerie.php",true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  xhr.send("id_util="+id_util);
}