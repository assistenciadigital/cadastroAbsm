function AJAX(a){
	
	document.getElementById("cidades").innerHTML="Carregando...";
	if(window.XMLHttpRequest){
		req=new XMLHttpRequest();
		if(req.overrideMimeType){
			req.overrideMimeType("text/xml")}
			}else{
				if(window.ActiveXObject){
					try{req=new ActiveXObject("Msxml2.XMLHTTP")}catch(b){
						try{req=new ActiveXObject("Microsoft.XMLHTTP")}catch(b){}}}}req.onreadystatechange=function(){
							document.getElementById("cidades").innerHTML="Carregando...";
							if(req.readyState==4){if(req.status==200){
								document.getElementById("cidades").innerHTML=req.responseText
								}else{
									document.getElementById("cidades").innerHTML="Error: returned status code "+req.status+" "+req.statusText}}};
									req.open("GET",a,true);
									req.send(null)}
									function atualiza(a){AJAX("../../painel/funcoesPHP/combo_cidade.php?uf="+a)}
									function atualiza_cidade(a,b){AJAX("../../painel/funcoesPHP/combo_cidade.php?uf="+a+"&cidade="+b)};
