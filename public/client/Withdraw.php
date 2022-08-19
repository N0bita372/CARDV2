<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'RÚT TIỀN | '.$CMSNT->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    CheckLogin();
?>

<div class="heading-page">
    <div class="container">
        <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('');?>"><span itemprop="name">TRANG CHỦ</span></a>
                <span itemprop="position" content="1"></span>
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('Withdraw');?>"><span itemprop="name">RÚT TIỀN</span></a>
                <span itemprop="position" content="3"></span>
            </li>
        </ol>
    </div>
</div>
<section class="main">
    <div class="section">
        <div class="container">
            <div class="col-sm-12">
                <div class="row mainpage-wrapper">
                    <section class="row">
                        <div class="col-md-7">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    RÚT TIỀN</div>
                                <div class="panel-body">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Chọn ví:</td>
                                                <td><select class="form-control" style="padding: 0px">
                                                        <option value="">Số dư <?=$getUser['username'];?> -
                                                            <?=format_cash($getUser['money']);?>đ</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Thông tin nhận tiền:</td>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Chọn ngân hàng (<a
                                                                href="<?=BASE_URL('Localbank');?>">Thêm ngân
                                                                hàng</a>)</label>
                                                        <select id="listbank" class="form-control" style="padding: 0px">
                                                            <option value="">Chọn ngân hàng</option>
                                                            <?php foreach($CMSNT->get_list(" SELECT * FROM `listbank` WHERE `username` = '".$getUser['username']."' ") as $bank) { ?>
                                                            <option value="<?=$bank['id'];?>"><?=$bank['nganhang'];?> |
                                                                <?=$bank['sotaikhoan'];?> | <?=$bank['chinhanh'];?>
                                                            </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Số tiền cần rút:</td>
                                                <td><input type="number" class="form-control" id="sotien" onkeyup="getPhiRutTien()"
                                                        placeholder="Số tiền cần rút" value="">
                                                    <small class="text-danger">Tối thiểu
                                                        <?=format_cash($CMSNT->site('min_ruttien'));?>
                                                        VND</small>
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
                                                <td>Nội dung rút tiền:</td>
                                                <td><textarea class="form-control" id="noidung" placeholder="Nhập nội dung rút tiền nếu có, ngắn gọn và không dấu"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-size:18px;"><center>Số tiền rút <b id="total_rut" style="color: blue;">0đ</b> - Phí <b id="total_phi" style="color:red;">0đ</b> - Tổng thanh toán <b id="total_thanh_toan" style="color: green;">0đ</b></center></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="thongbao"></div>
                                    <div id='loading_box' style='display:none;'>
                                        <center><img src='<?=BASE_URL('assets/img/loading_box.gif');?>' /></center>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button type="button" id="Withdraw" class="btn btn-info"><i
                                            class="fa fa-paper-plane" aria-hidden="true"></i> RÚT TIỀN NGAY</button>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                        function getPhiRutTien() {
                            $.ajax({
                                url: "<?=BASE_URL('assets/ajaxs/getPhiRutTien.php');?>",
                                method: "GET",
                                data: {
                                    amount: $("#sotien").val()
                                },
                                dataType: "JSON",
                                success: function(response){
                                    $("#total_rut").html(response.total_rut);
                                    $("#total_phi").html(response.total_phi);
                                    $("#total_thanh_toan").html(response.total_thanh_toan);
                                    //document.getElementById("total_rut").value = (response.total_rut.toString());
                                }
                            });
                        }
                        </script>
                        <script type="text/javascript">
                        $("#Withdraw").on("click", function() {
                            $("#loading_box").show();
                            $('#Withdraw').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled',
                                true);
                            $.ajax({
                                url: "<?=BASE_URL("assets/ajaxs/Withdraw.php");?>",
                                method: "POST",
                                data: {
                                    type: 'Withdraw',
                                    password2: $("#password2").val(),
                                    sotien: $("#sotien").val(),
                                    noidung: $("#noidung").val(),
                                    listbank: $("#listbank").val()
                                },
                                success: function(response) {
                                    $("#loading_box").hide();
                                    $("#thongbao").html(response);
                                    $('#Withdraw').html(
                                            '<i class="fa fa-paper-plane" aria-hidden="true"></i> RÚT TIỀN NGAY'
                                        )
                                        .prop('disabled', false);
                                }
                            });
                        });
                        </script>
                        <div class="col-md-5">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    PHÍ RÚT TIỀN</div>
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
                                                <td><?=$CMSNT->site('phi_rut_tien');?> VND</td>
                                            </tr>
                                            <tr>
                                                <td>Phí %</td>
                                                <td><?=$CMSNT->site('phi_rut_tien_ck');?>%</td>
                                            </tr>
                                            <tr>
                                                <td>Tối đa số tiền rút trong ngày</td>
                                                <td>Không giới hạn</td>
                                            </tr>
                                            <tr>
                                                <td>Số tiền rút tối thiểu</td>
                                                <td><?=format_cash(getSite('min_ruttien'));?> VND</td>
                                            </tr>
                                            <tr>
                                                <td>Số tiền rút tối đa</td>
                                                <td>Không giới hạn</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    LỊCH SỬ RÚT TIỀN CỦA BẠN</div>
                                <div class="panel-body">
                                    <table id="datatable" class="table table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>MÃ GD</th>
                                                <th>SỐ TIỀN RÚT</th>
                                                <th>NGÂN HÀNG</th>
                                                <th>SỐ TÀI KHOẢN</th>
                                                <th>TÊN CHỦ TK</th>
                                                <th>THỜI GIAN TẠO</th>
                                                <th>TRẠNG THÁI</th>
                                                <th>GHI CHÚ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `ruttien` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$row['magd'];?></td>
                                                <td><?=format_cash($row['sotien']);?></td>
                                                <td><?=$row['nganhang'];?></td>
                                                <td><?=$row['sotaikhoan'];?></td>
                                                <td><?=$row['chutaikhoan'];?></td>
                                                <td><span class="label label-danger"><?=$row['thoigian'];?></span></td>
                                                <td><?=display_ruttien_user($row['trangthai']);?></td>
                                                <td><?=$row['ghichu'];?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(function() {
    $("#datatable").DataTable({
        "autoWidth": false,
    });
});
</script>


<?php 
    require_once("../../public/client/Footer.php");
?>