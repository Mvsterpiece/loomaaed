<?php
$kasutaja = 'd113372_denis'; //d113372_denis
$server = 'd113372.mysql.zonevs.eu'; //d113372.mysql.zonevs.eu
$andmebaas = 'd113372_baasdenis'; //d113372_baasdenis
$salasyna='Armastanminuema';
$yhendus = new mysqli($server,$kasutaja,$salasyna,$andmebaas);
$yhendus -> set_charset('UTF8');

?>