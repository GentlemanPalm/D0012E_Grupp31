<?php
/**
 * Created by PhpStorm.
 * User: palm
 * Date: 2016-11-16
 * Time: 10:24
 */

/*
 * Detta program ska läsa in produkter från databasen och sammanställa dem till en lista.
 * Preliminärt kommer det att generera statisk HTML, men om allt är klart till den sista sprinten så
 * ska detta omvandlas till JSON för att skickas via AJAJ.
 *
 * TODO: Testa detta program när en webbserver är tillgänglig
 */

require_once 'functions.php';
require 'template/header.php';
require 'template/footer.php';


$orders = NULL;
$id = "";
if (isset($_SESSION["user_ID"])) {
    $id = sanitizeString($_SESSION["user_ID"]);
    $orders = querySQL("SELECT * FROM Orders WHERE user_ID = $id ORDER BY order_placed DESC");
} else {
    header("Location: login.php");
    die("Du måste logga in.");
}

generateHeader("Beställiningar");

//echo $products;
?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Beställning</th>
            <th>Pris</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sd = "";
        $dc = 0;
       while ($ord = $orders->fetch_assoc()) {
            $ord_id = explode(" ", $ord["order_placed"])[0];
            if (strcmp($sd, $ord_id) != 0) {
                $dc = 0;
            }  
            $prices = querySQL("SELECT SUM(price) as totp, SUM(price * vat) as totv FROM OrderItems WHERE order_ID = $ord[ID]")->fetch_assoc();
            $price = $prices["totp"];
            $vat = $prices["totv"];
            ?>
            <tr>
                <td><a href="vieworder.php?id=<?=$ord["ID"]?>"><?=$ord_id."#".$dc?></a></td>
                <td><?=$price+$vat?> kr</td>
            </tr><?php
            $sd = $ord_id;
            $dc = $dc + 1;
        }?>
        </tbody>
    </table>
<?php
generateFooter();