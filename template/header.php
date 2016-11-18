<?php
/**
 * Created by PhpStorm.
 * User: palm
 * Date: 2016-11-16
 * Time: 10:25
 */

/*
 * Syftet med denna fil är att ha en gemensam header för alla sidor. Denna ska sedan inkluderas i samtliga
 * PHP-dokument. Just nu får denna dock vara ganska så bare-bones.
 * */

function generateBootstrap() {
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php
}

function generateHeader ($title, $gen_head = true, $gen_bootstrap = true)
{
    if ($gen_head) { ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8"/>
            <title><?= $title ?></title>
            <?php
            if ($gen_bootstrap) {
                generateBootstrap();
            }
            ?>
        </head>
        <?php
    } ?>
    <body>
    <div class="jumbotron" stype="margin-left:10pt;">
        <h1>Kontorsshoppen.se - <?=$title?></h1>
        <p>Kontorsvaror för den prisblinde kunden</p>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <h3>Kategori</h3>
                <ul class="list-group"><!-- Lägg till så att man kan få fram kategorierna -->
                    <li class="list-group-item">Pennor <span class="badge">14</span></li>
                    <li class="list-group-item">Bläck <span class="badge">8</span></li>
                    <li class="list-group-item">Papper <span class="badge">5</span></li>
                    <li class="list-group-item">Skrivare <span class="badge">3</span></li>
                </ul>
            </div>
            <div class="col-sm-7">


    <!-- TODO: Lägg till paneler och sådant. Kundvagn kan vara mycket viktigt i detta fall. -->
<?php
}