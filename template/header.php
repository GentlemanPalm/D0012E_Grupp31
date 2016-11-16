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


function generateHeader ($title, $gen_head = true)
{
    if ($gen_head) { ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8"/>
            <title><?= $title ?></title>
        </head>
        <?php
    } ?>
    <body>
    <!-- TODO: Lägg till paneler och sådant. Kundvagn kan vara mycket viktigt i detta fall. -->
<?php
}