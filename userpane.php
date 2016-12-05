<?php
require_once 'functions.php';
require 'template/header.php';
require 'template/footer.php';
global $connection;
$id = $email = $orgnr = $password = $name = $lastname = $security = $phonenumber = $town = $zipcode = $address1 = $address2 = $addressco = "";
//Undviker SQL-injection
if (isset($_SESSION["user_ID"])){ 
    $id = $_SESSION["user_ID"];
    $res = querySQL("SELECT * FROM Users WHERE ID = '$id'")->fetch_assoc();
    //	$address2 = sanitizeString($_POST['address2']);
    //	$addressco = sanitizeString($_POST['addressco']);
    //Kontrollerar om alla fällt är ifyllda.
    $email = $res["email"];
    $phonenumber = $res["phone"];
    $zip = $res["zip"];
    $security = $res["sec"];
    $address1 = $res["address1"];
    $name = $res["first_name"];
    $lastname = $res["last_name"];
    $town = $res["city"];
}
if(!isset($_SESSION["user_ID"])) {
    header("Location: index.php");
    die();
}

if (isset($_POST["submit"])) {
    // TODO: Ta hand om informationen.
}

generateHeader("Inställningar för $name $lastname");
?>
<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<h1>Uppgifter</h1>
<a href="browseorders.php">Beställningar</a>
<form action = "" method = "POST">
    Email: <input type = "text" name = "email" value="<?=$email?>"/><br><br>
    Adress: <input type = "text" name = "address1" value="<?=$address1?>"/><br><br>
    Telefon: <input type = "text" name = "phone" value="<?=$phonenumber?>"/><br><br>
    Stad: <input type = "text" name = "city" value="<?=$town?>"/><br><br>
    Postkod: <input type = "text" name = "zip" value="<?=$zip?>"/><br><br>
    <button type="submit" name = "submit" class = "btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Uppdatera</button>
</form>
<?php
generateFooter();