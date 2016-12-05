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
    $town = $res["town"];
}
if(!isset($_SESSION["user_ID"])) {
    header("Location: index.php");
    die();
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
<h1>Registrering</h1>
<form action = "" method = "POST">
    Produktnamn:
    <input type = "text" name = "pname" value="<?=$res["name"]?>"/><br><br>

    Ursprungligt lagersaldo:
    <input type = "text" name = "quantity" onkeypress="return isNumber(event)" maxlength = "4" size = "4" value="<?=$res["quantity"]?>"/><br><br>

    Produktbeskrivning (tillåter HTML):
    <textarea name="desc" cols="40" rows="10"><?=$res["description"]?></textarea><br /><br />

    Grundpris exklusive moms:
    <input type = "text" name = "price" onkeypress="return isNumber(event)" maxlength = "6" size = "6" value="<?=$res["price"]?>"/><br><br>

    Nuvarande exklusive moms:
    <input type = "text" name = "cprice" onkeypress="return isNumber(event)" maxlength = "6" size = "6" value="<?=$res["current_price"]?>"/><br><br>
    <input type = "hidden" name = "id" value="<?=$id?>" />
    Momssats:
    <select name="vat">
        <option value = "<?=$res["vat"]?>">-- Samma som förut --</option>
        <option value = "0.06">6% - Kultur, böcker, mm.</option>
        <option value = "0.12">12% - Livsmedel, mm.</option>
        <option value = "0.25">25% - ALLA digitala tjänster och övriga artiklar</option>
    </select><br><br>

    Kategori:
    <select name = "cat">
        <option value = "<?=$res["category_ID"]?>">-- Samma som förut --</option>
        <?php
        $result1 = querySQL("SELECT ID, title FROM Categories");
        while ($res1 = $result1->fetch_assoc()) { ?>
            <option value="<?=$res1["ID"]?>"><?=$res1["title"]?></option>
            <?php
        }
        ?>
    </select><br><br>
    <?php
        $r = querySQL("SELECT ID, path FROM Images WHERE product_ID = $id");
        $iurl = "";
        $imgid = "";
        if ($r->num_rows > 0) {
            $assoc = $r->fetch_assoc();
            $iurl = $assoc["path"];
            $imgid = $assoc["ID"];

        }
    ?>
    Bild-URL. Om du vill använda kategorins standardbild, lämna detta fält blankt:
    <input type = "text" name = "img" value="<?=$iurl?>"/><br/><br/>
    <input type = "hidden" name = "imgid" value="<?=$imgid?>"/>

    
    <button type="submit" name = "submit" class = "btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Redigera vara!</button><a href="deleteproduct.php?id=<?=$id?>"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Ta bort</button></a>
    <hr>
</form>
<?php
generateFooter();