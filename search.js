function myFunction(search){
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				document.getElementById("lista").innerHTML = this.responseText;
				console.log("Hej");
			}
		};
		xmlhttp.open("GET", "search.php?q="+search,true);
		xmlhttp.send();
}