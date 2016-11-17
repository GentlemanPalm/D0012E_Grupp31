function loadCart(id){
	if (id ==""){
		return;
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				document.getElementById("cart").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "loadcart.php?q="+id,true);
		xmlhttp.send();
	}
}
function deleteItem(item, id){
	if (item ==""){
		console.log("Item är tomt");
		return;
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				loadCart('1');
				console.log("Godkänt");
			}
		};
		xmlhttp.open("GET", "deleteitem.php?q="+item,true);
		xmlhttp.send();
	}
}