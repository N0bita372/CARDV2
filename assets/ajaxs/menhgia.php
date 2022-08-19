<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");

?>

<?php
if(!empty($_GET['loaithe']))
{
    $loaithe = check_string($_GET['loaithe']);
}
else
{
    die('<option value="">Vui lòng chọn loại thẻ</option>');
}
?>
<option value="">-- Chọn mệnh giá --</option>
<option value="10000">10.000đ - Thực nhận <?=format_cash(10000-10000*$CMSNT->get_row("SELECT * FROM `".myGroupExCard('')."` WHERE `loaithe` = '$loaithe' AND `menhgia` = '10000' ")['ck']/100);?>đ</option>
<option value="20000">20.000đ - Thực nhận <?=format_cash(20000-20000*$CMSNT->get_row("SELECT * FROM `".myGroupExCard('')."` WHERE `loaithe` = '$loaithe' AND `menhgia` = '20000' ")['ck']/100);?>đ</option>
<option value="30000">30.000đ - Thực nhận <?=format_cash(30000-30000*$CMSNT->get_row("SELECT * FROM `".myGroupExCard('')."` WHERE `loaithe` = '$loaithe' AND `menhgia` = '30000' ")['ck']/100);?>đ</option>
<option value="50000">50.000đ - Thực nhận <?=format_cash(50000-50000*$CMSNT->get_row("SELECT * FROM `".myGroupExCard('')."` WHERE `loaithe` = '$loaithe' AND `menhgia` = '50000' ")['ck']/100);?>đ</option>
<option value="100000">100.000đ - Thực nhận <?=format_cash(100000-100000*$CMSNT->get_row("SELECT * FROM `".myGroupExCard('')."` WHERE `loaithe` = '$loaithe' AND `menhgia` = '100000' ")['ck']/100);?>đ</option>
<option value="200000">200.000đ - Thực nhận <?=format_cash(200000-200000*$CMSNT->get_row("SELECT * FROM `".myGroupExCard('')."` WHERE `loaithe` = '$loaithe' AND `menhgia` = '200000' ")['ck']/100);?>đ</option>
<option value="300000">300.000đ - Thực nhận <?=format_cash(300000-300000*$CMSNT->get_row("SELECT * FROM `".myGroupExCard('')."` WHERE `loaithe` = '$loaithe' AND `menhgia` = '300000' ")['ck']/100);?>đ</option>
<option value="500000">500.000đ - Thực nhận <?=format_cash(500000-500000*$CMSNT->get_row("SELECT * FROM `".myGroupExCard('')."` WHERE `loaithe` = '$loaithe' AND `menhgia` = '500000' ")['ck']/100);?>đ</option>
<option value="1000000">1.000.000đ - Thực nhận <?=format_cash(1000000-1000000*$CMSNT->get_row("SELECT * FROM `".myGroupExCard('')."` WHERE `loaithe` = '$loaithe' AND `menhgia` = '1000000' ")['ck']/100);?>đ</option>