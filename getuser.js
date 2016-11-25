function loaduser(id){
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
				var x = this.responseText;
				console.log(x);
				var y = JSON.parse(x);
				document.getElementById("name").value = y.first_name;
				document.getElementById("lastname").value = y.last_name;
				document.getElementById("email").value = y.email;
				document.getElementById("address1").value =decodeChar(y.address1);
				document.getElementById("zip").value = y.zip;
				document.getElementById("city").value = y.city;
				document.getElementById("phone").value = y.phone;
				
			}
		};
		xmlhttp.open("GET", "getuser.php?q="+id,true);
		xmlhttp.send();
	}
}

function decodeChar(str){

}