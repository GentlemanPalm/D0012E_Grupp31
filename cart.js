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
				console.log("Hej");
			}
		};
		xmlhttp.open("GET", "loadcart.php?q="+id,true);
		console.log("1");
		xmlhttp.send();
	}
}
function deleteItem(item){
	var x = JSON.parse(item);
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
				loadCart(x.user_ID);
			}
		};
		xmlhttp.open("GET", "deleteitem.php?q="+item,true);
		xmlhttp.send();
	}
}