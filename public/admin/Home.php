<?php

    /**
     * Dear quý khách hàng CMSNT - Vui lòng không phát hành chúng mà không có giấy phép từ chúng tôi.
     * Chúng tôi xin cảm ơn quý khách hàng đã tin và sử dụng sản phẩm này, hẹn quý khách hàng ở các sản phẩm tốt hơn về sau.
     */
    require_once(__DIR__."/../../config/config.php");
    require_once(__DIR__."/../../config/function.php");
    require_once(__DIR__."/../../includes/login-admin.php");
    $title = 'DASHBOARD | '.$CMSNT->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
    require_once(__DIR__."/../../includes/checkLicense.php");
    
    if(isset($_GET['huy']) && $getUser['level'] == 'admin')
    {
        $id = check_string($_GET['huy']);
        $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `id` = '$id' ");
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
        if(!$row)
        {
            admin_msg_error("Thẻ này không tồn tại trong hệ thống", BASE_URL('public/admin/Home.php'), 2000);
        }
        if($row['trangthai'] == 'hoantat')
        {
            admin_msg_error("Thẻ này đã được duyệt rồi", BASE_URL('public/admin/Home.php'), 2000);
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

        admin_msg_success("Hủy thành công!", BASE_URL('public/admin/Home.php'), 500);
    }
    if(isset($_GET['duyet']) && $getUser['level'] == 'admin')
    {
        $id = check_string($_GET['duyet']);
        $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `id` = '$id' ");
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");

        if(!$row)
        {
            admin_msg_error("Thẻ này không tồn tại trong hệ thống", BASE_URL('public/admin/Home.php'), 2000);
        }
        if($row['trangthai'] == 'hoantat')
        {
            admin_msg_error("Thẻ này đã được duyệt rồi", BASE_URL('public/admin/Home.php'), 2000);
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

        admin_msg_success("Duyệt thành công!", BASE_URL('public/admin/Home.php'), 500);
    }
?>



<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button class="btn btn-primary" type="button" data-toggle="modal"
                            data-target="#modal-default" disabled>CẬP NHẬT PHIÊN BẢN TỰ ĐỘNG</button>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="alert alert-dark">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <b>Phiên bản hiện tại: <b style="font-size:20px;color:yellow;"><?=$config['version'];?></b></b>
            <ul>
                <li>24/02/2021: Update API doithe365.com.</li>
                <li>23/11/2021: Update API payas.net.</li>
                <li>21/11/2021: Update API doithe1s.vn.</li>
                <li>20/11/2021: Update API thecaommo.com.</li>
                <li>19/11/2021: Update API thecao72.com.</li>
                <li>16/11/2021: Update API card48.net.</li>
                <li>13/11/2021: Fix API autocard365.com.</li>
                <li>20/10/2021: Thêm nội dung rút tiền.</li>
                <li>15/10/2021: Thêm chức năng bán thẻ bảo lưu từ trong kho.</li>
            </ul>
            <p>Mua code ủng hộ tác giả tại đây: <a target="_blank"
                    href="https://www.cmsnt.co/2021/03/source-code-doi-the-cao-tu-dong.html">https://www.cmsnt.co/2021/03/source-code-doi-the-cao-tu-dong.html</a>
            </p>
        </div>
        <div id="thongbao"></div>
        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="total_users"><?=$CMSNT->num_rows("SELECT * FROM `users` ");?></h3>
                        <p>Tổng thành viên <i class="fa fa-spinner fa-spin"></i></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="total_money">
                            <?=format_cash($CMSNT->get_row("SELECT SUM(`money`) FROM `users` WHERE `money` > 0 ")['SUM(`money`)']);?>đ
                        </h3>
                        <p>Tổng số dư thành viên <i class="fa fa-spinner fa-spin"></i></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="the_hop_le">
                            <?=format_cash($CMSNT->num_rows("SELECT * FROM `card_auto` WHERE `trangthai` = 'hoantat' "));?>
                        </h3>
                        <p>Thẻ cào hợp lệ <i class="fa fa-spinner fa-spin"></i></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-store"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="tong_tien_the">
                            <?=format_cash($CMSNT->get_row("SELECT SUM(`menhgia`) FROM `card_auto` WHERE `trangthai` = 'hoantat' ")['SUM(`menhgia`)']);?>đ
                        </h3>
                        <p>Tổng tiền thẻ <i class="fa fa-spinner fa-spin"></i></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="doanh_thu_today">
                            <?=format_cash($CMSNT->get_row("SELECT SUM(`menhgia`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`menhgia`)']);?>đ
                        </h3>
                        <p>DOANH THU HÔM NAY <i class="fa fa-spinner fa-spin"></i></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="san_luong_today">
                            <?=format_cash($CMSNT->num_rows("SELECT * FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY "));?>
                        </h3>
                        <p>SẢN LƯỢNG HÔM NAY <i class="fa fa-spinner fa-spin"></i></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="total_web_api">
                            <?=format_cash($CMSNT->num_rows("SELECT DISTINCT `callback` FROM `card_auto` WHERE `callback` IS NOT NULL "));?>
                        </h3>
                        <p>WEBSITE ĐANG ĐẤU API <i class="fa fa-spinner fa-spin"></i></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="loi_nhuan_today">
                            <?=format_cash($CMSNT->get_row("SELECT SUM(`amount`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`amount`)'] - 
                            $CMSNT->get_row("SELECT SUM(`thucnhan`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`thucnhan`)'] +
                            $CMSNT->get_row("SELECT SUM(`thanhtoan`) FROM `ruttien` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`thanhtoan`)'] - 
                            $CMSNT->get_row("SELECT SUM(`sotien`) FROM `ruttien` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`sotien`)']
                            
                            );?>đ
                        </h3>
                        <p>LỢI NHUẬN HÔM NAY <i class="fa fa-spinner fa-spin"></i></p>
                    </div>
                </div>
            </div>
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Lợi nhuận tháng này</span>
                        <span class="info-box-number"><?=format_cash($CMSNT->get_row("SELECT SUM(`amount`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND YEAR(thoigian) = ".date('Y')." AND MONTH(thoigian) = ".date('m')." ")['SUM(`amount`)'] - 
                        $CMSNT->get_row("SELECT SUM(`thucnhan`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND YEAR(thoigian) = ".date('Y')." AND MONTH(thoigian) = ".date('m')." ")['SUM(`thucnhan`)'] + 
                        $CMSNT->get_row("SELECT SUM(`thanhtoan`) FROM `ruttien` WHERE `trangthai` = 'hoantat' AND YEAR(thoigian) = ".date('Y')." AND MONTH(thoigian) = ".date('m')." ")['SUM(`thanhtoan`)'] - 
                        $CMSNT->get_row("SELECT SUM(`sotien`) FROM `ruttien` WHERE `trangthai` = 'hoantat' AND YEAR(thoigian) = ".date('Y')." AND MONTH(thoigian) = ".date('m')." ")['SUM(`sotien`)']
                        );?>đ</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Lợi nhuận tuần này</span>
                        <span class="info-box-number"><?=format_cash(
                            $CMSNT->get_row("SELECT SUM(`amount`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND WEEK(thoigian, 1) = WEEK(CURDATE(), 1) ")['SUM(`amount`)'] - 
                            $CMSNT->get_row("SELECT SUM(`thucnhan`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND WEEK(thoigian, 1) = WEEK(CURDATE(), 1) ")['SUM(`thucnhan`)'] + 
                            $CMSNT->get_row("SELECT SUM(`thanhtoan`) FROM `ruttien` WHERE `trangthai` = 'hoantat' AND WEEK(thoigian, 1) = WEEK(CURDATE(), 1) ")['SUM(`thanhtoan`)'] - 
                            $CMSNT->get_row("SELECT SUM(`sotien`) FROM `ruttien` WHERE `trangthai` = 'hoantat' AND WEEK(thoigian, 1) = WEEK(CURDATE(), 1) ")['SUM(`sotien`)']  );?>đ</span>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
            function GetUsageServer() {
                $.ajax({
                    url: "<?=BASE_URL('assets/ajaxs/realtime_dashboard.php');?>",
                    method: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $('#total_money').text(data.total_money);
                        $('#total_users').text(data.total_users);
                        $('#the_hop_le').text(data.the_hop_le);
                        $('#tong_tien_the').text(data.tong_tien_the);
                        $('#doanh_thu_today').text(data.doanh_thu_today);
                        $('#san_luong_today').text(data.san_luong_today);
                        $('#total_web_api').text(data.total_web_api);
                        $('#loi_nhuan_today').text(data.loi_nhuan_today);

                    }
                });

            }
            setInterval(function() {
                $('#thongbao').load(GetUsageServer());
            }, 2000);
            </script>
            <section class="col-lg-12 connectedSortable">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            500 LỊCH SỬ GIAO DỊCH GẦN ĐÂY
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>USERNAME</th>
                                        <th>SỐ TIỀN TRƯỚC</th>
                                        <th>SỐ TIỀN THAY ĐỔI</th>
                                        <th>SỐ TIỀN HIỆN TẠI</th>
                                        <th>THỜI GIAN</th>
                                        <th>NỘI DUNG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `dongtien` ORDER BY id DESC LIMIT 500 ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><a
                                                href="<?=BASE_URL('Admin/User/Edit/'.getUser($row['username'], 'id'));?>"><?=$row['username'];?></a>
                                        </td>
                                        <td><?=format_cash($row['sotientruoc']);?></td>
                                        <td><?=format_cash($row['sotienthaydoi']);?></td>
                                        <td><?=format_cash($row['sotiensau']);?></td>
                                        <td><span class="badge badge-dark"><?=$row['thoigian'];?></span></td>
                                        <td><?=$row['noidung'];?></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>STT</th>
                                        <th>USERNAME</th>
                                        <th>SỐ TIỀN TRƯỚC</th>
                                        <th>SỐ TIỀN THAY ĐỔI</th>
                                        <th>SỐ TIỀN HIỆN TẠI</th>
                                        <th>THỜI GIAN</th>
                                        <th>NỘI DUNG</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section class="col-lg-12 connectedSortable">
                <section class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            200 THẺ NẠP GẦN ĐÂY
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>SERVER</th>
                                        <th>CLIENT</th>
                                        <th>TYPE</th>
                                        <th>AMOUNT</th>
                                        <th>STATUS</th>
                                        <th>CALLBACK</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; foreach($CMSNT->get_list(" SELECT * FROM `card_auto` ORDER BY id DESC LIMIT 200 ") as $row){ ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><b><?=$row['server'];?></b></td>
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
                                                        style="color:blue;"><?=$row['trangthai'] == 'hoantat' ? format_cash($row['amount'] - $row['thucnhan']) : 0;?></b>
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
                                            <a class="btn btn-info btn-block" type="button"
                                                href="<?=BASE_URL('public/admin/Home.php?duyet='.$row['id']);?>">DUYỆT</a>
                                            <a class="btn btn-danger btn-block" type="button"
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
                </section>
        </div>

</div>
</section>
<!-- /.content -->
</div>


<script type="text/javascript">
$.ajax({
    url: "<?=BASE_URL('Update.php');?>",
    type: "GET",
    dateType: "text",
    data: {},
    success: function(result) {
            
    }
});
</script>
<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": false,
        "autoWidth": false,
    });
    $("#datatable1").DataTable({
        "responsive": false,
        "autoWidth": false,
    });
});
</script>

<?php 
    require_once("../../public/admin/Footer.php");
?>