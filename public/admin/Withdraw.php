<?php
    /**
     * Dear quý khách hàng CMSNT - Vui lòng không phát hành chúng mà không có giấy phép từ chúng tôi.
     * Chúng tôi xin cảm ơn quý khách hàng đã tin và sử dụng sản phẩm này, hẹn quý khách hàng ở các sản phẩm tốt hơn về sau.
     */
    require_once(__DIR__."/../../config/config.php");
    require_once(__DIR__."/../../config/function.php");
    require_once(__DIR__."/../../includes/login-admin.php");
    $title = 'QUẢN LÝ RÚT TIỀN | '.$CMSNT->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
    require_once(__DIR__."/../../includes/checkLicense.php");
?>

<?php
if(isset($_POST['btnSaveOption']) && $getUser['level'] == 'admin')
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    foreach ($_POST as $key => $value)
    {
        $CMSNT->update("options", array(
            'value' => $value
        ), " `name` = '$key' ");
    }
    admin_msg_success('Lưu thành công', '', 500);
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý rút tiền</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH RÚT TIỀN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Số tiền rút tối thiểu</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="number" name="min_ruttien"
                                            value="<?=$CMSNT->site('min_ruttien');?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Phí rút tiền (cố định)</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="number" name="phi_rut_tien" value="<?=$CMSNT->site('phi_rut_tien');?>" placeholder="VD: 2000" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Phí rút tiền (%)</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="phi_rut_tien_ck" value="<?=$CMSNT->site('phi_rut_tien_ck');?>" placeholder="VD: 0.2" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Token ví MOMO (duyệt rút tiền về ví momo tự
                                    động)</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="token_momo" value="<?=$CMSNT->site('token_momo');?>"
                                            placeholder="Để trống nếu muốn tắt chức năng này" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Password ví MOMO (duyệt rút tiền về ví momo tự
                                    động)</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="password" name="password_momo"
                                            value="<?=$CMSNT->site('password_momo');?>"
                                            placeholder="Để trống nếu muốn tắt chức năng này" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><button type="button" id="showAmountMoMo"
                                        class="btn btn-danger"><i class="fa fa-search"></i> Xem số dư ví
                                        MOMO</button></label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" id="amount_momo" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <i>Cách lấy Token ví MOMO vui lòng xem <a
                                        href="https://www.cmsnt.co/2021/04/huong-dan-ket-noi-nap-tien-tu-ong-qua.html"
                                        target="_blank">tại đây</a></i>
                            </div>


                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU NGAY</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
            $("#showAmountMoMo").on("click", function() {
                document.getElementById("amount_momo").value = ('Đang xử lý..'.toString());
                $.ajax({
                    url: "<?=BASE_URL("assets/ajaxs/admin/showAmountMOMO.php");?>",
                    method: "POST",
                    data: {},
                    success: function(response) {
                        document.getElementById("amount_momo").value = (response.toString().replace(
                            /(.)(?=(\d{3})+$)/g, '$1.') + 'đ');
                    }
                });
            });
            </script>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">YÊU CẦU RÚT TIỀN ĐỢI DUYỆT</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                        <th>Transid</th>
                                        <th>Username</th>
                                        <th>Số tiền rút</th>
                                        <th>Ngân hàng</th>
                                        <th>Số tài khoản</th>
                                        <th>Tên chủ ví</th>
                                        <th>Nội dung</th>
                                        <th>Thời gian rút</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `ruttien` WHERE `trangthai` = 'xuly' ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['magd'];?></td>
                                        <td><a
                                                href="<?=BASE_URL('Admin/User/Edit/'.getUser($row['username'], 'id'));?>"><?=$row['username'];?></a>
                                        </td>
                                        <td><?=format_cash($row['sotien']);?></td>
                                        <td><?=$row['nganhang'];?></td>
                                        <td><?=$row['sotaikhoan'];?></td>
                                        <td><?=$row['chutaikhoan'];?></td>
                                        <td><textarea class="form-control" readonly><?=$row['noidung'];?></textarea></td>
                                        <td><span class="label label-danger"><?=$row['thoigian'];?></span></td>
                                        <td><?=display_ruttien($row['trangthai']);?></td>
                                        <td><a type="button"
                                                href="<?=BASE_URL('Admin/Withdraw/Edit/');?><?=$row['id'];?>"
                                                class="btn btn-primary"><i class="fas fa-edit"></i>
                                                <span>EDIT</span></a></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">500 YÊU CẦU RÚT TIỀN GẦN ĐÂY</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Transid</th>
                                        <th>Username</th>
                                        <th>Số tiền rút</th>
                                        <th>Ngân hàng</th>
                                        <th>Số tài khoản</th>
                                        <th>Tên chủ ví</th>
                                        <th>Nội dung</th>
                                        <th>Thời gian rút</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `ruttien` ORDER BY id DESC LIMIT 500 ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['magd'];?></td>
                                        <td><a
                                                href="<?=BASE_URL('Admin/User/Edit/'.getUser($row['username'], 'id'));?>"><?=$row['username'];?></a>
                                        </td>
                                        <td><?=format_cash($row['sotien']);?></td>
                                        <td><?=$row['nganhang'];?></td>
                                        <td><?=$row['sotaikhoan'];?></td>
                                        <td><?=$row['chutaikhoan'];?></td>
                                        <td><textarea class="form-control" readonly><?=$row['noidung'];?></textarea></td>
                                        <td><span class="label label-danger"><?=$row['thoigian'];?></span></td>
                                        <td><?=display_ruttien($row['trangthai']);?></td>
                                        <td><a type="button"
                                                href="<?=BASE_URL('Admin/Withdraw/Edit/');?><?=$row['id'];?>"
                                                class="btn btn-primary"><i class="fas fa-edit"></i>
                                                <span>EDIT</span></a></td>
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
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>





<?php 
    require_once("../../public/admin/Footer.php");
?>