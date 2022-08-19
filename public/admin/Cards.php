<?php
    /**
     * Dear quý khách hàng CMSNT - Vui lòng không phát hành chúng mà không có giấy phép từ chúng tôi.
     * Chúng tôi xin cảm ơn quý khách hàng đã tin và sử dụng sản phẩm này, hẹn quý khách hàng ở các sản phẩm tốt hơn về sau.
     */
    require_once(__DIR__."/../../config/config.php");
    require_once(__DIR__."/../../config/function.php");
    require_once(__DIR__."/../../includes/login-admin.php");
    $title = 'DANH SÁCH ĐƠN HÀNG | '.$CMSNT->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
    require_once(__DIR__."/../../includes/checkLicense.php");


?>
<?php
if(isset($_GET['huy']) && $getUser['level'] == 'admin')
{
    $id = check_string($_GET['huy']);
    $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `id` = '$id' ");
    $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
    if(!$row)
    {
        admin_msg_error("Thẻ này không tồn tại trong hệ thống", BASE_URL('public/admin/Cards.php'), 2000);
    }
    if($row['trangthai'] == 'hoantat')
    {
        admin_msg_error("Thẻ này đã được duyệt rồi", BASE_URL('public/admin/Cards.php'), 2000);
    }
    $CMSNT->update("card_auto", [
        'trangthai' => 'thatbai',
        'ghichu'    => 'Thẻ cào không hợp lệ hoặc đã được sử dụng',
        'capnhat'   => gettime()
    ], " `id` = '$id' ");
    if(isset($row['callback']))
    {
        curl_get($row['callback']."?content=".$row['request_id']."&status=thatbai&thucnhan=0"."&menhgiathuc=0");
    }

    admin_msg_success("Hủy thành công!", BASE_URL('public/admin/Cards.php'), 500);
}

if(isset($_GET['duyet']) && $getUser['level'] == 'admin')
{
    $id = check_string($_GET['duyet']);
    $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `id` = '$id' ");
    $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");

    if(!$row)
    {
        admin_msg_error("Thẻ này không tồn tại trong hệ thống", BASE_URL('public/admin/Cards.php'), 2000);
    }
    if($row['trangthai'] == 'hoantat')
    {
        admin_msg_error("Thẻ này đã được duyệt rồi", BASE_URL('public/admin/Cards.php'), 2000);
    }

    $CMSNT->update("card_auto", [
        'trangthai' => 'hoantat',
        'capnhat'   => gettime()
    ], " `id` = '$id' ");

    $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
    $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
    /* CẬP NHẬT DÒNG TIỀN */
    $CMSNT->insert("dongtien", array(
        'sotientruoc'   => $getUser['money'],
        'sotienthaydoi' => $row['thucnhan'],
        'sotiensau'     => $getUser['money'] + $row['thucnhan'],
        'thoigian'      => gettime(),
        'noidung'       => 'Đổi thẻ seri ('.$row['seri'].')',
        'username'      => $getUser['username']
    ));
    if(isset($row['callback']))
    {
        curl_get($row['callback']."?content=".$row['request_id']."&status=hoantat&thucnhan=".$row['thucnhan']."&menhgiathuc=".$row['menhgia']);
    }

    admin_msg_success("Duyệt thành công!", BASE_URL('public/admin/Cards.php'), 500);
}
if(isset($_POST['btnSaveOption']) && $getUser['level'] == 'admin')
{
    foreach ($_POST as $key => $value)
    {
        $CMSNT->update("options", array(
            'value' => $value
        ), " `name` = '$key' ");
    }
    admin_msg_success('Lưu thành công', '', 500);
}
if(isset($_POST['btnTimKiem']))
{
    $daterangepicker = check_string($_POST['daterangepicker']);
    $daterangepicker = explode(' - ', $daterangepicker);
    //admin_msg_error($daterangepicker[0], "", 5000);
    $total_card = $CMSNT->num_rows(" SELECT * FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= '".$daterangepicker[0]."' AND `thoigian` <= '".$daterangepicker[1]."' ORDER BY id DESC ");
    $total_menhgia = $CMSNT->get_row(" SELECT SUM(`menhgia`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= '".$daterangepicker[0]."' AND `thoigian` <= '".$daterangepicker[1]."' ORDER BY id DESC ")['SUM(`menhgia`)'];
    $total_thucnhan = $CMSNT->get_row(" SELECT SUM(`thucnhan`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= '".$daterangepicker[0]."' AND `thoigian` <= '".$daterangepicker[1]."' ORDER BY id DESC ")['SUM(`thucnhan`)'];
    $list_cardauto = $CMSNT->get_list(" SELECT * FROM `card_auto` WHERE `thoigian` >= '".$daterangepicker[0]."' AND `thoigian` <= '".$daterangepicker[1]."' ORDER BY id DESC ");
}  
else
{
    $total_card = $CMSNT->num_rows(" SELECT * FROM `card_auto` WHERE `trangthai` = 'hoantat' ORDER BY id DESC ");
    $total_menhgia = $CMSNT->get_row(" SELECT SUM(`menhgia`) FROM `card_auto` WHERE `trangthai` = 'hoantat' ORDER BY id DESC ")['SUM(`menhgia`)'];
    $total_thucnhan = $CMSNT->get_row(" SELECT SUM(`thucnhan`) FROM `card_auto` WHERE `trangthai` = 'hoantat' ORDER BY id DESC ")['SUM(`thucnhan`)'];
    $list_cardauto = $CMSNT->get_list(" SELECT * FROM `card_auto` ORDER BY id DESC ");
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý thẻ nạp</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">DANH SÁCH 2.000 THẺ GẦN ĐÂY</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="daterangepicker" class="form-control float-right"
                                                id="reservationtime">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <button type="submit" name="btnTimKiem" class="btn btn-primary">
                                        <span>TÌM KIẾM</span></button>
                                </div>
                            </div>
                        </form>
                        <ul>
                            <li>Tổng thẻ hợp lệ: <b style="green: red;"><?=format_cash($total_card);?></b></li>
                            <li>Tổng sản lượng thẻ: <b style="color: blue;"><?=format_cash($total_menhgia);?>đ</b></li>
                            <li>Tổng thực nhận: <b style="color: red;"><?=format_cash($total_thucnhan);?>đ</b></li>
                        </ul>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="10%">SERVER API</th>
                                        <th width="20%">CLIENT</th>
                                        <th>TYPE</th>
                                        <th>AMOUNT</th>
                                        <th>STATUS</th>
                                        <th width="10%">CALLBACK</th>
                                        <th width="10%">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; foreach($CMSNT->get_list(" SELECT * FROM `card_auto` ORDER BY id DESC LIMIT 2000 ") as $row){ ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td>
                                            <ul>
                                                <li>Request ID: <b><?=$row['request_id'];?></b></li>
                                                <li>Server: <b><?=$row['server'];?></b></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <li>Username: <b><a
                                                            href="<?=BASE_URL('Admin/User/Edit/'.getUser($row['username'], 'id'));?>"><?=$row['username'];?></a></b>
                                                </li>
                                                <li>Email: <b><?=getUser($row['username'], 'email');?></b></li>
                                                <li>Phone: <b><?=getUser($row['username'], 'phone');?></b></li>
                                                <li>IP: <b><?=getUser($row['username'], 'ip');?></b></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <li>Type: <b><?=$row['loaithe'];?></b></li>
                                                <li>Seri: <b><?=$row['seri'];?></b></li>
                                                <li>Pin: <b><?=$row['pin'];?></b></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <li>Mệnh giá: <b
                                                        style="color: green;"><?=format_cash($row['menhgia']);?></b>
                                                </li>
                                                <li>Thực nhận: <b
                                                        style="color: red;"><?=format_cash($row['thucnhan']);?></b></li>
                                                <li>Lợi nhuận: <b
                                                        style="color:blue;"><?=format_cash($row['amount'] - $row['thucnhan']);?></b>
                                                </li>
                                            </ul>

                                        </td>
                                        <td>
                                            <ul>
                                                <li>Trạng thái: <?=status_admin($row['trangthai']);?></li>
                                                <li>Lý do: <?=$row['ghichu'];?></li>
                                                <li>Thời gian nạp thẻ: <b
                                                        class="label label-danger"><?=$row['thoigian'];?></b></li>
                                                <li>Thời gian xử lý: <b
                                                        class="label label-info"><?=$row['capnhat'];?></b></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <li>Request ID: <b><?=$row['code'];?></b></li>
                                                <li>Callback: <b><?=$row['callback'];?></b></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <a class="btn btn-info" type="button"
                                                href="<?=BASE_URL('public/admin/Home.php?duyet='.$row['id']);?>">DUYỆT</a>
                                            <a class="btn btn-danger" type="button"
                                                href="<?=BASE_URL('public/admin/Home.php?huy='.$row['id']);?>">HỦY</a>
                                            <?php if($row['server'] == '') { ?><a class="btn btn-primary" type="button"
                                                href="<?=BASE_URL('public/admin/EditCard.php?id='.$row['id']);?>">EDIT</a><?php }?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>


<script>
$(function() {
    $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'YYYY/MM/DD/ hh:mm:ss'
        }
    })
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>




<?php 
    require_once("../../public/admin/Footer.php");
?>