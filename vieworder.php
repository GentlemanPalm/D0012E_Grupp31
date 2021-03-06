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

$admin = false;

$items = NULL;
$order = NULL;
$id = "";
$uid = "";

if (isset($_SESSION["user_ID"]) && isset($_GET["id"])) {
    if (isset($_GET["admin"]) && $_SESSION["access"] > 1) {
        $admin = true;
    }
    $id = sanitizeString($_GET["id"]);
    $uid = sanitizeString($_SESSION["user_ID"]);
    $items = querySQL("SELECT o.*, p.name FROM OrderItems o INNER JOIN Products p ON o.item=p.ID WHERE o.order_ID = $id");
    $order = querySQL("SELECT payment_option, payment_received, discount, order_placed FROM Orders WHERE ID = $id".($admin ? "" : " AND user_ID = $uid"));
   /* if ($order->num_rows < 1) {
        header("Location: browseorders.php");
        die("Verkar inte hitta någon order på din användare...");
    }*/
    $order = $order->fetch_assoc();
} else {
    header("Location: browseorders.php");
    die("Hittar inte ordern...");
}

generateHeader("Visa order");
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
                <td class="sent" id="sent<?=$item["ID"]?>"><?=$sent?><?php if ($admin) {?>
                <button class="senditem" onclick="sendItem(<?=$item["ID"]?>)">Skicka?</button>
                <?php } ?></td>
            </tr><?php
        
        }?>
        </tbody>
    </table>
    <script type="text/javascript">
    function sendItem(id) {
        $.ajax({
            url: "senditem.php?id="+id
        }).done(function(data) {
            $("#sent"+id).html("Skickad!");
        });
    }
    </script>
    <p><strong>Betalsätt:</strong> <?=$order["payment_option"]?></p>
    <p><strong>Belopp:</strong> <?=$tp-$order["discount"]?></p>
    <p><strong>Mottaget:</strong> <?=$order["payment_received"]?></p>
    <?php if ($order["payment_received"] - $order["discount"] < $tp) {?>
    <form action="makepayment.php" method="POST">
        <input type="number" class="form-control" name="amount" step="0.01" placeholder="Belopp" /><br />
        <input type="hidden" name="id" value="<?=$id?>" />
        <button type="submit" name="submit" class="form-control btn btn-primary">Betala!</button>
    </form>
    <?php } ?>

<?php
    $altaddr = querySQL("SELECT * FROM OrderAddresses WHERE ID = $id");
    while ($aa = $altaddr->fetch_assoc()) {
        $addrt = "";
        if (strcmp($aa["addr_type"], "B") == 0) {
            $addrt = "Faktura";
        } else {
            $addrt = "Leverans";
        }
        ?>
            <h3><?=$addrt?>adress</h3>
            <p>
                <p><strong>Namn:</strong> <?=$aa["first_name"]?> <?=$aa["last_name"]?></p>
                <p><strong>Epost:</strong> <?=$aa["email"]?></p>
                <p><strong>Telefon:</strong> <?=$aa["phone"]?></p>
                <p><strong>Adress:</strong> <?=$aa["address1"]?></p>
                <p><strong>Ort:</strong> <?=$aa["city"]?></p>
                <p><strong>Postnummer:</strong> <?=$aa["zip"]?></p>
            </p>

        <?php
        
    }
    if ($admin) {
        $uid = querySQL("SELECT user_ID FROM Orders WHERE ID = $id")->fetch_assoc()["user_ID"];
    $altaddr = querySQL("SELECT * FROM Users WHERE ID = $uid");
    while ($aa = $altaddr->fetch_assoc()) {
        $addrt = "Användar";
        ?>
            <h3><?=$addrt?>adress</h3>
            <p>
                <p><strong>Namn:</strong> <?=$aa["first_name"]?> <?=$aa["last_name"]?></p>
                <p><strong>Epost:</strong> <?=$aa["email"]?></p>
                <p><strong>Telefon:</strong> <?=$aa["phone"]?></p>
                <p><strong>Adress:</strong> <?=$aa["address1"]?></p>
                <p><strong>Ort:</strong> <?=$aa["city"]?></p>
                <p><strong>Postnummer:</strong> <?=$aa["zip"]?></p>
            </p>

        <?php
        }
    }
generateFooter();
