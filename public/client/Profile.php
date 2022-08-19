<?php
    require_once(__DIR__."/../../config/config.php");
    require_once(__DIR__."/../../config/function.php");
    require_once(__DIR__."/../../includes/login.php");
    $title = 'THÔNG TIN | '.$CMSNT->site('tenweb');
    require_once(__DIR__."/../../public/client/Header.php");
    require_once(__DIR__."/../../public/client/Nav.php");
    //CheckLogin();
?>

<div class="heading-page">
    <div class="container">
        <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('');?>"><span itemprop="name">Trang chủ</span></a>
                <span itemprop="position" content="1"></span>
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('Auth/Profile');?>"><span itemprop="name">Thông tin</span></a>
                <span itemprop="position" content="2"></span>
            </li>
        </ol>
    </div>
</div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container">

        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row mainpage-wrapper">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            THÔNG TIN TÀI KHOẢN</div>
                        <div class="panel-body">
                            <div id="thongbao"></div>
                            <form action="" method="POST">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Tài khoản:</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly="readonly" class="form-control"
                                            value="<?=$getUser['username'];?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Email:</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly="readonly" class="form-control"
                                            value="<?=$getUser['email'];?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Số dư</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly="readonly" class="form-control"
                                            value="<?=format_cash($getUser['money']);?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Thời gian đăng ký</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly="readonly" class="form-control"
                                            value="<?=$getUser['createdate'];?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Mật khẩu cấp 2</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="password" id="password2" value="<?=$getUser['password2'];?>" class="form-control">
                                        </div>
                                        <i>Mật khẩu cấp 2 sẽ được áp dụng cho các giao dịch rút tiền, nạp dt, mua thẻ.</i>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Mật khẩu mới</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="password" id="password" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nhập lại mật khẩu mới</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="password" id="repassword" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="DoiMatKhau" class="btn btn-primary">
                                    <span>LƯU THÔNG TIN</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mainpage-wrapper">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DÒNG TIỀN</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
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
                                    foreach($CMSNT->get_list(" SELECT * FROM `dongtien` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><b style="color: blue;"><?=format_cash($row['sotientruoc']);?></b></td>
                                        <td><b style="color: red;"><?=format_cash($row['sotienthaydoi']);?></b></td>
                                        <td><b style="color: green;"><?=format_cash($row['sotiensau']);?></b></td>
                                        <td><span class="badge badge-dark"><?=$row['thoigian'];?></span></td>
                                        <td><?=$row['noidung'];?></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>STT</th>
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
            </div>
        </div>
    </div>
</div>
</div>
<!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
<script type="text/javascript">
$("#DoiMatKhau").on("click", function() {
    $('#DoiMatKhau').html('ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("assets/ajaxs/Auth.php");?>",
        method: "POST",
        data: {
            type: 'DoiMatKhau',
            password2: $("#password2").val(),
            password: $("#password").val(),
            repassword: $("#repassword").val()
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('#DoiMatKhau').html(
                    'LƯU THÔNG TIN')
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
    require_once(__DIR__."/../../public/client/Footer.php");
?>