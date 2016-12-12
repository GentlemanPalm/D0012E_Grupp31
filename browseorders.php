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
generateHeader("Hantera ordrar");

$orders = NULL;
$id = "";
$admin = false;



if (isset($_SESSION["user_ID"])) {
    if($_SESSION["access"] > 1 && isset($_GET["admin"])) {
        $admin = true;
        $orders = querySQL("SELECT * FROM Orders ORDER BY order_placed DESC");
    } else {
        $id = sanitizeString($_SESSION["user_ID"]);
        $orders = querySQL("SELECT * FROM Orders WHERE user_ID = $id ORDER BY order_placed DESC");
    }
} else {
    header("Location: login.php");
    die("Du måste logga in.");
}


//echo $products;
?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Beställning</th>
            <th>Pris</th>
            <?=$admin ? "<th>% skickad</th>" : ""?>
            <th>Betald</th>
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
            $prices = querySQL("SELECT SUM(price * quantity) as totp, SUM(price * quantity * vat) as totv FROM OrderItems WHERE order_ID = $ord[ID]")->fetch_assoc();
            $price = $prices["totp"];
            $vat = $prices["totv"];

            $paid = ($price + $vat) - $ord["payment_received"] - $ord["discount"]  <= 0;

            $sent = querySQL("SELECT count(*) AS tots, (SELECT count(*) AS totns FROM OrderItems WHERE order_ID = $ord[ID] AND shipped IS NULL) AS totns FROM OrderItems WHERE order_ID = $ord[ID] AND shipped IS NOT NULL")->fetch_assoc();
            $sent_per = (int) (100.00 * $sent["tots"] / ($sent["tots"] + $sent["totns"]));
            $sent_per = $sent_per == false ? 0.00 : $sent_per;
            ?>
            <tr>
            <?php if ($admin) { ?>
            <td><a href="vieworder.php?id=<?=$ord["ID"]?>&admin=1"><?=($ord["user_ID"] == NULL ? "<b>D</b>" : $ord["user_ID"])."#".$ord_id."#".$dc?></a></td>
            <?php } else { ?>
            <td><a href="vieworder.php?id=<?=$ord["ID"]?>"><?=$ord_id."#".$dc?></a></td>
            <?php } ?>

                <td><?=$price+$vat-$ord["discount"]?> kr</td>
                <?php if ($admin) { ?>
                    <td><?=$sent_per.'%'?></td>
                <?php } ?>
                    <td><?=$paid ? "Betald" : "Ej betald"?></td>
                
            </tr><?php
            $sd = $ord_id;
            $dc = $dc + 1;
        }?>
        </tbody>
    </table>
<?php
generateFooter();