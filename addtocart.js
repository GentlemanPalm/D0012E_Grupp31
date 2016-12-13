function addToCart(str){
	if (str ==""){
		return;
	}else{
		var x = document.getElementById("quantity").value;	
		var y = str+" "+x;
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				document.getElementById("txtHint").innerHTML = this.responseText;
				getQuantity(str);
				loadCart(str);
			}
		};
		xmlhttp.open("GET", "getproduct.php?q="+y,true);
		xmlhttp.send();
	}
}

function getQuantity(ant){
	if (ant ==""){
		return;
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				document.getElementById("show_quantity").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "getquantity.php?q="+ant,true);
		xmlhttp.send();
	}
}