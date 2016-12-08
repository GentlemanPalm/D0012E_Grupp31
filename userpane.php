<?php
require_once 'functions.php';
require 'template/header.php';
require 'template/footer.php';
global $connection;
$id = $email = $orgnr = $password = $name = $lastname = $security = $phonenumber = $town = $zipcode = $address1 = $address2 = $addressco = "";
$update_ok = 0;
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
    $old_email = $email;
    $email = sanitizeString($_POST['email']);
    $address1 = sanitizeString($_POST['address1']);
    $town = sanitizeString($_POST['city']);
    $zip = sanitizeString($_POST['zip']);
    $phonenumber = sanitizeString($_POST['phone']);

    $query = "";
    if (strcmp($old_email, $email) == 0) {
        $query = "UPDATE Users SET city='$town', address1='$address1', zip='$zip', phone='$phonenumber' WHERE ID = $id";
    } else {
        $result = querySQL("SELECT * FROM Users WHERE email = '$email'");
        if ($result->num_rows > 0) {
            $update_ok = -1;
        } else {
            $query = "UPDATE Users SET city='$town', address1='$address1', zip='$zip', phone='$phonenumber', email='$email' WHERE ID = $id";
        }
    }
    if ($update_ok != -1) {
        querySQL($query);
        $update_ok = 1;
    }
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
<p>
<a href="browseorders.php">Beställningar</a>
</p>
<form action = "" method = "POST">
    <?php
    if ($update_ok != 0) {
        if ($update_ok == 1) {
            ?>
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Uppgifter uppdaterade!</strong>
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Eposten redan tagen!</strong>
            </div>
            <?php
        }
    }
    ?>
    Email: <input type = "text" name = "email" value="<?=$email?>" id="emailfield"/><br><br>
    <span id="emailstatus"></span>
    <script type="text/javascript">
        $("#emailfield").on("change keyup paste", function () {
            //alert($("#emailfield").val());
            $.get("checkemail.php", {email: $("#emailfield").val() }).done(function(data) {
                if (data == 1) {
                    $("#emailstatus").html("");
                } else {
                    if ($("#emailfield").val() != "<?=$email?>") {
                        $("#emailstatus").html("<div class=\"alert alert-danger\"><strong>OBS!</strong> Eposten är redan i bruk!</div>");
                    } else {
                        $("#emailstatus").html("");
                    }
                }
            });
        });
    </script>
    Adress: <input type = "text" name = "address1" value="<?=$address1?>"/><br><br>
    Telefon: <input type = "text" name = "phone" value="<?=$phonenumber?>"/><br><br>
    Stad: <input type = "text" name = "city" value="<?=$town?>"/><br><br>
    Postkod: <input type = "text" name = "zip" value="<?=$zip?>"/><br><br>
    <button type="submit" name = "submit" class = "btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Uppdatera</button>
</form>
<?php
generateFooter();