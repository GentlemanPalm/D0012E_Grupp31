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


$items = NULL;
$order = NULL;
$id = "";
echo "<;";
if (isset($_SESSION["user_ID"]) && isset($_GET["id"])) {
    $id = sanitizeString($_GET["id"]);
    $uid = sanitizeString($_SESSION["user_ID"]);
    $items = querySQL("SELECT o.*, p.name FROM OrderItems o INNER JOIN Products p ON o.item=p.ID WHERE o.order_ID = $id");
    $order = querySQL("SELECT payment_option, payment_received, discount, order_placed FROM Orders WHERE ID = $id AND user_ID = $uid");
   /* if ($order->num_rows < 1) {
        header("Location: browseorders.php");
        die("Verkar inte hitta någon order på din användare...");
    }*/
    $order = $order->fetch_assoc();
} else {
    header("Location: browseorders.php");
    die("Hittar inte ordern...");
}

generateHeader("Se beställning");

//echo $products;
?>
    <h2>Orderinformation</h2>
    <p>Du har fått en rabatt på <?=$order["discount"]?> kr din order som lades den <?=explode(" ", $order["order_placed"])[0]?>.</p>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Vara</th>
            <th>Kvantitet</th>
            <th>Pris/st</th>
            <th>Totalpris</th>
            <th>Skickad</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $tp = 0;
        while ($item = $items->fetch_assoc()) {
            $product = $item["name"];
            $product = $product == NULL ? "<strike>borttagen vara</strike>" : $product;
            $price = $item["price"];
            $vat = $item["vat"] * $price;
            $quantity = $item["quantity"];
            $sent = $item["shipped"];
            $sent = $sent == NULL ? "Ej skickad" : $sent;

            $price = $price + $vat;
            $tp += $price * $quantity;

            ?>
            <tr>
                <td><a href="viewproduct.php?id=<?=$item["item"]?>"><?=$product?></a></td>
                <td><?=$quantity?> st</td>
                <td><?=$price?> kr</td>
                <td><?=$price*$quantity?> kr</td>
                <td><?=$sent?></td>
            </tr><?php
        
        }?>
        </tbody>
    </table>
    <p><strong>Betalsätt:</strong> <?=$order["payment_option"]?></p>
    <p><strong>Belopp:</strong> <?=$tp?></p>
    <p><strong>Mottaget:</strong> <?=$order["payment_received"]?></p>
<?php
generateFooter();