<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");
?>

<?php

if(!empty($_GET['loaithe']) && !empty($_GET['menhgia']))
{
    $loaithe = check_string($_GET['loaithe']);
    $menhgia = check_string($_GET['menhgia']);
    $ck = $CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '$menhgia' ")['ck'];
    echo $menhgia - $menhgia * $ck / 100;
    die();
}
else
{
    die('0');
}
