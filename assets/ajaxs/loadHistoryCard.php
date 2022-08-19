<?php 
    require_once(__DIR__."/../../config/config.php");
    require_once(__DIR__."/../../config/function.php");
    if(empty($_SESSION['username']))
    {
        echo msg_error3("Vui lòng đăng nhập");
        die();
    }
?>
<table id="datatable2" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>LOẠI THẺ</th>
            <th>MỆNH GIÁ</th>
            <th>THỰC NHẬN</th>
            <th>SERI</th>
            <th>PIN</th>
            <th>THỜI GIAN</th>
            <th>CẬP NHẬT</th>
            <th>TRẠNG THÁI</th>
            <th>GHI CHÚ</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0; foreach($CMSNT->get_list(" SELECT * FROM `card_auto` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row) { ?>
        <tr>
            <td><?=$i++;?></td>
            <td><?=$row['loaithe'];?></td>
            <td><b style="color: green;"><?=format_cash($row['menhgia']);?></b>
            </td>
            <td><b style="color: red;"><?=format_cash($row['thucnhan']);?></b>
            </td>
            <td><?=$row['seri'];?></td>
            <td><?=$row['pin'];?></td>
            <td><span class="label label-danger"><?=$row['thoigian'];?></span>
            </td>
            <td><span class="label label-primary"><?=$row['capnhat'];?></span>
            </td>
            <td><?=status($row['trangthai']);?></td>
            <td><?=$row['ghichu'];?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
<script>
$(document).ready(function() {
    $('#datatable2').DataTable();
});
</script>