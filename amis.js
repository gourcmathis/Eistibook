// ajax
function getXhr() {
	var xhr = null;
	if (window.XMLHttpRequest) {
		xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { 
		try {
			xhr = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
	} else { 
		alert("Votre navigateur ne supporte pas AJAX");
		xhr = false;
	}
	return xhr;
}


//
function listeAmis(login) {
	var xhr = getXhr();
  	xhr.open("POST","listeAmis.php",true) ;
  	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  	xhr.send("login="+login); 
  	xhr.onreadystatechange = function() {
     		// On ne fait quelque chose que si on a tout reçu
    		// et que le serveur est ok
     		if (xhr.readyState == 4 && xhr.status == 200){
     			document.getElementById("results").innerHTML= xhr.responseText;
     		}
  	}
  	
}
