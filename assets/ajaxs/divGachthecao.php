<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");

    $rand = random('123456789', 6).time();
?>

<div class="gachthe row mt-2" data-row="<?=$rand;?>">
    <div class="col-lg-3">
        <div class="form-group">
            <select id="loaithe" name="loaithe" class="telco form-control" data-row="<?=$rand;?>">
                <option value="">-- Loại thẻ --</option>
                <?php foreach($list_loaithe as $row) { ?>
                <option value="<?=$row;?>">
                    <?=$row;?> Auto
                </option>
                <?php }?>
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <select id="menhgia" name="menhgia" class="charging-amount form-control" data-row="<?=$rand;?>">
                <option value="0">Chọn mệnh giá</option>
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <input id="seri" name="seri" class="serial form-control" type="text" data-row="<?=$rand;?>" placeholder="Serial">

        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <input id="pin" class="pin form-control" name="pin" type="text" data-row="<?=$rand;?>" placeholder="Mã thẻ">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <button class="btn btn-sm" onclick="f_<?=$rand;?>()"><img src="<?=BASE_URL('assets/img/delete-icon.jpeg');?>" width="20px"></button>
        </div>
    </div>
</div>

<script>
function f_<?=$rand;?>() {
    $('.gachthe[data-row="<?=$rand;?>"]').remove();
}
</script>
