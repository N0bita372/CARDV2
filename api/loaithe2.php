<?php 
    require_once("../config/config.php");
    require_once("../config/function.php");
?>

<option value="">-- Loại thẻ --</option>
<?php foreach($list_loaithe as $row) { ?>
<option value="<?=$row;?>">
    <?=$row;?>
</option>
<?php }?>