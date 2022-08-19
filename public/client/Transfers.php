<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'CHUYỂN TIỀN | '.$CMSNT->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    CheckLogin();
?>

<div class="heading-page">
    <div class="container">
        <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('');?>"><span itemprop="name">Trang chủ</span></a>
                <span itemprop="position" content="1"></span>
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('Transfers');?>"><span itemprop="name">Chuyển tiền</span></a>
                <span itemprop="position" content="3"></span>
            </li>
        </ol>
    </div>
</div>
<section class="main">
    <div class="section">
        <div class="container">
            <div class="row mainpage-wrapper">
                <div class="col-md-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            CHUYỂN SỐ DƯ</div>
                        <div class="panel-body">
                            <div id="thongbao"></div>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td>Chọn quỹ:</td>
                                        <td><select class="form-control" style="padding: 0px">
                                                <option value="">Số dư - <?=format_cash($getUser['money']);?>đ</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tài khoản nhận:</td>
                                        <td><input id="nguoinhan" type="text" placeholder="Nhập tài khoản người nhận"
                                                class="form-control" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền chuyển:</td>
                                        <td><input type="number" class="form-control" id="sotien"
                                                placeholder="Nhập số tiền cần chuyển">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nội dung:</td>
                                        <td>
                                            <textarea id="lydo" class="form-control"
                                                placeholder="Nội dung chuyển nếu có"></textarea>
                                        </td>
                                    </tr>
                                    <?php if(!empty($getUser['password2'])) { ?>
                                    <tr>
                                        <td>Mật khẩu cấp 2:</td>
                                        <td><input type="password" class="form-control" id="password2" placeholder="Nhập mật khẩu cấp 2" value="">
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <button type="button" id="ChuyenTien" class="btn btn-info">Chuyển tiền
                                                ngay</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            PHÍ CHUYỂN TIỀN</div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Loại</th>
                                        <th>VND</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Phí cố định</td>
                                        <td><?=$CMSNT->site('phi_chuyentien');?> VND</td>
                                    </tr>
                                    <tr>
                                        <td>Phí %</td>
                                        <td>0%</td>
                                    </tr>
                                    <tr>
                                        <td>Tổng chuyển tối đa trong ngày</td>
                                        <td>Không giới hạn</td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền chuyển tối thiểu</td>
                                        <td>10,000 VND</td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền chuyển tối đa</td>
                                        <td>20,000,000 VND</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            LỊCH SỬ CHUYỂN TIỀN</div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped dataTable" id="datatable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>NGƯỜI NHẬN</th>
                                    <th>SỐ TIỀN</th>
                                    <th>THỜI GIAN</th>
                                    <th>LÝ DO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `chuyentien` WHERE `nguoichuyen` = '".$getUser['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                <tr>
                                    <td><?=$i++;?></td>
                                    <td><?=$row['nguoinhan'];?></td>
                                    <td><?=format_cash($row['sotien']);?></td>
                                    <td><span class="label label-danger"><?=$row['thoigian'];?></span></td>
                                    <td><?=$row['lydo'];?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
<script type="text/javascript">
$("#ChuyenTien").on("click", function() {
    $('#ChuyenTien').html('ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("assets/ajaxs/Transfers.php");?>",
        method: "POST",
        data: {
            type: 'ChuyenTien',
            password2: $("#password2").val(),
            sotien: $("#sotien").val(),
            lydo: $("#lydo").val(),
            nguoinhan: $("#nguoinhan").val()
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('#ChuyenTien').html(
                    'Chuyển tiền ngay')
                .prop('disabled', false);
        }
    });
});
</script>
<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>

<?php 
    require_once("../../public/client/Footer.php");
?>