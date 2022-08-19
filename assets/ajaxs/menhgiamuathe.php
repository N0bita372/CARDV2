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
<option value="">-- Chọn mệnh giá cần mua --</option>

<?php foreach($CMSNT->get_list("SELECT * FROM `sellcards` WHERE `sellcard_id` = '$loaithe' AND `sellcard_id` != 0 ") as $row) {?>
<option value="<?=$row['id'];?>">Thẻ <?=format_currency($row['name']);?> - Trả <?=format_currency($row['name'] - $row['name'] * $row['ck'] / 100);?> - Còn <?=format_cash($CMSNT->num_rows("SELECT * FROM `storecards` WHERE `sellcard_id` = '".$row['id']."' AND `username` IS NULL "));?> thẻ</option>
<?php }?>