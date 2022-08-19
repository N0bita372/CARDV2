<?php
    require_once(__DIR__."/config/config.php");
    require_once(__DIR__."/config/function.php");
    $title = 'HOME | '.$CMSNT->site('tenweb');
    require_once(__DIR__."/public/client/Header.php");
    require_once(__DIR__."/public/client/Nav.php");
?>
<?php
if($CMSNT->site('status_ref') == 'ON'){
    if(isset($_GET['ref']) ){
        $ref_id = check_string($_GET['ref']);
        if($CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '$ref_id' ")['ip'] != myip()){
            $CMSNT->cong("users", "ref_click", 1, " `id` = '$ref_id' ");
            $_SESSION['ref'] = check_string($_GET['ref']);
        }
        else{
            $_SESSION['ref'] = NULL;
        }
    }
}

if(empty($_SESSION['ref']))
{
    $_SESSION['ref'] = NULL;
}
?>

<?php if(getSite('display_carousel') == 'ON') { ?>
<div id="myCarousel" class="carousel slider slide" data-ride="carousel"
    style="background: <?=$CMSNT->site('theme_color');?>">
    <div class="container slide">
        <div class="carousel-inner">
            <div class="item active">
                <div class="row">
                    <div class="col-sm-6 pull-right"><img src="<?=BASE_URL('assets/img/');?>support.png"
                            alt="Tích hợp API gạch thẻ tự động cho Shop" /></div>
                    <div class="col-sm-6">
                        <div class="slide-text">
                            <h3 style="color: #ffffff">Tích hợp API gạch thẻ tự động cho Shop</h3>
                            <p class="hidden-xs" style="color: #ffffff">Cam kết không nuốt thẻ, không bảo trì, có nhân
                                viện trực hỗ trợ 24/24, rút tiền sau 1 phút. Hotline: <?=$CMSNT->site('hotline');?></p>
                            <a href="<?=BASE_URL('Ket-noi-api');?>" class="btn btn-warning text-uppercase hidden-xs">
                                Xem ngay </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="row">
                    <div class="col-sm-6 pull-right"><img src="<?=BASE_URL('assets/img/');?>payment.png"
                            alt="Đổi thẻ cào thành tiền mặt nhanh chóng - tiện lợi" /></div>
                    <div class="col-sm-6">
                        <div class="slide-text">
                            <h3 style="color: #ffffff">Đổi thẻ cào thành tiền mặt nhanh chóng - tiện lợi</h3>
                            <p class="hidden-xs" style="color: #ffffff">Gạch thẻ siêu rẻ chiết khấu 15 - 20%. Rút free
                                phí về các ngân hàng Nội địa Việt Nam, Ví điện tử Momo</p>
                            <a href="" class="btn btn-warning text-uppercase hidden-xs"> Đổi Thẻ Ngay </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
<?php }?>

<section class="main">
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="gradient-border">
                    <div class="panel-body"><?=$CMSNT->site('thongbao');?></div>
                </div>
            </div>
            <div class="col-md-12">
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="tab" onclick="PlaySound('nap_the_ngay')" href="#doithe">NẠP THẺ
                            NGAY</a></li>
                    <li><a data-toggle="tab" onclick="PlaySound('bang_gia_doi_the_cao')" href="#ckdoithe">BẢNG GIÁ ĐỔI
                            THẺ CÀO</a></li>
                </ul><br>
                <div class="tab-content">
                    <div id="doithe" class="tab-pane fade in active">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                ĐỔI THẺ CÀO TỰ ĐỘNG</div>
                            <div class="panel-body">

                                <div id='loading_box' style='display:none;'>
                                    <center><img src='<?=BASE_URL('assets/img/loading_box.gif');?>' /></center>
                                </div>
                                <div class="row">
                                    <div id="thongbao" class="col-lg-12"></div>
                                    <div id='loading_box' style='display:none;'>
                                        <center><img src='<?=BASE_URL('assets/img/loading_box.gif');?>' /></center>
                                    </div>
                                </div>
                                <div id="divGachthecao">
                                    <div class="gachthe row" data-row="1">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <select id="loaithe" class="telco form-control" data-row="1"></select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <select id="menhgia" class="charging-amount form-control" data-row="1">
                                                    <option value="0">Chọn mệnh giá</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <input id="seri" class="serial form-control" type="text" data-row="1"
                                                    placeholder="Serial">

                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <input id="pin" class="pin form-control" type="text" data-row="1"
                                                    placeholder="Mã thẻ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button id="btnAddChild" class="btn btn-sm"><img
                                                src="<?=BASE_URL('assets/img/add-icon.png');?>" width="20px"> THÊM
                                            NGAY</button>

                                    </div>
                                    <div class="col-sm-6">
                                        <button class="btn btn-sm" onClick="window.location.reload();"
                                            style="float:right"><img
                                                src="<?=BASE_URL('assets/img/delete-all-icon.png');?>" width="20px"> XOÁ
                                            TẤT CẢ</button>
                                    </div>
                                </div>
                                <input type="hidden" id="token"
                                    value="<?=isset($_SESSION['username']) ? $getUser['token'] : '';?>">
                                <center>
                                    <a type="submit" class="btn" id="NapTheAuto">
                                        <img src="<?=BASE_URL('assets/img/button-nap-ngay.gif');?>" width="170px">
                                    </a>
                                </center>
                            </div>



                        </div>
                        <script type="text/javascript">
                        $(document).ready(function() {
                            setTimeout(e => {
                                GetCard24()
                            }, 0)
                        });
                        $('#btnAddChild').click(function() {
                            PlaySound('click');
                            getchildordercardbuy();
                        });

                        function getchildordercardbuy() {
                            var totalRow = $('#divGachthecao .gachthe').length;
                            if (totalRow > 10) {
                                PlaySound('ban_chi_co_the_giu_len_he_thong_toi_da_10_the_1_lan');
                                alert('Bạn chỉ có thể gửi lên hệ thống tối đa 10 thẻ 1 lần');
                            } else {
                                $.ajax({
                                    url: "<?=BASE_URL('assets/ajaxs/divGachthecao.php');?>",
                                    method: "GET",
                                    success: function(response) {
                                        $('#divGachthecao').append(response);
                                    }
                                });
                            }
                        }

                        $(document).on('change', '.telco', function() {
                            var dataRow = $(this).data('row');
                            $('.charging-amount[data-row="' + dataRow + '"]').empty();
                            $.ajax({
                                url: "<?=BASE_URL('assets/ajaxs/menhgia.php');?>",
                                method: "GET",
                                data: {
                                    loaithe: $(this).val(),
                                    type: $(this).find(':selected').data('type')
                                },
                                success: function(response) {
                                    $('.charging-amount[data-row="' + dataRow + '"]').html(
                                        response);
                                }
                            });
                        });
                        $("#NapTheAuto").click(function() {
                            PlaySound('click');
                            proccessListOrderCardBuy();
                        });

                        function proccessListOrderCardBuy() {
                            var lstDataSubmit = [];
                            var i = 1;
                            $('#divGachthecao .gachthe').each(function() {
                                var dataRow = $(this).data('row');
                                var dataOne = {
                                    loaithe: $('select.telco[data-row="' + dataRow + '"] :selected').val(),
                                    menhgia: $('select.charging-amount[data-row="' + dataRow +
                                            '"] :selected').val() != undefined ?
                                        $('select.charging-amount[data-row="' + dataRow + '"] :selected')
                                        .val() : '',
                                    type: $('select.telco[data-row="' + dataRow + '"] :selected').data(
                                        'type'),
                                    pin: $('input.pin[data-row="' + dataRow + '"]').val(),
                                    serial: $('input.serial[data-row="' + dataRow + '"]').val(),
                                };
                                lstDataSubmit.push(dataOne);
                            });
                            if (lstDataSubmit.length > 0) {
                                $("#loading_box").show();
                                $.ajax({
                                    url: "<?=BASE_URL('assets/ajaxs/NapThe2.php');?>",
                                    type: 'POST',
                                    data: {
                                        data: lstDataSubmit,
                                        type: 'NapTheAuto',
                                        token: $("#token").val(),
                                    },
                                    beforeSend: function() {
                                        $('#NapTheAuto').html(
                                            '<img src="<?=BASE_URL('assets/img/loading.gif');?>" width="200px">'
                                            );
                                        $('#NapTheAuto').prop('disabled', true);
                                    },
                                    success: function(res) {
                                        $('#NapTheAuto').html(
                                            '<img src="<?=BASE_URL('assets/img/button-nap-ngay.gif');?>" width="170px">'
                                        );
                                        $('#NapTheAuto').prop('disabled', false);
                                        $("#thongbao").html(res);
                                        var str2 = "alert-success";
                                        if (res.indexOf(str2) != -1) {
                                            setTimeout(function() {
                                                window.location.href =
                                                    '<?=BASE_URL('');?>';
                                            }, 3000);
                                        }
                                        $("#loading_box").hide();
                                    }
                                });
                            }
                        }

                        function GetCard24() {
                            $.ajax({
                                url: "<?=BASE_URL('api/loaithe.php');?>",
                                method: "GET",
                                success: function(response) {
                                    $("#loaithe").html(response);
                                }
                            });
                        }
                        </script>
                    </div>
                    <div id="ckdoithe" class="tab-pane fade">
                        <div class="panel panel-default">
                            <div class="panel-heading"
                                style="color:white; background-color: <?=$CMSNT->site('theme_color');?>;">
                                BIỂU PHÍ ĐỔI THẺ</div>
                            <div class="panel-body">
                                <div class="tabpage" id="bang-phi">
                                    <ul class="nav nav-tabs">
                                        <?php foreach($list_loaithe as $loaithe) { ?>
                                        <li class="<?=$loaithe == 'VIETTEL' ? 'active' : '';?>">
                                            <a data-toggle="tab" onclick="PlaySound('<?=$loaithe;?>')"
                                                href="#discount-<?=$loaithe;?>">
                                                <span class="title"><?=$loaithe;?></span>
                                            </a>
                                        </li>
                                        <?php }?>
                                    </ul>
                                    <div class="tab-content" style="padding-top: 20px;">
                                        <?php foreach($list_loaithe as $loaithe) { ?>
                                        <div class="table-responsive tab-pane fadess in <?=$loaithe == 'VIETTEL' ? 'active' : '';?>"
                                            id="discount-<?=$loaithe;?>">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Nhóm thành
                                                            viên
                                                        </th>
                                                        <th class="text-center">Thẻ 10,000đ
                                                        </th>
                                                        <th class="text-center">Thẻ 20,000đ
                                                        </th>
                                                        <th class="text-center">Thẻ 30,000đ
                                                        </th>
                                                        <th class="text-center">Thẻ 50,000đ
                                                        </th>
                                                        <th class="text-center">Thẻ 100,000đ
                                                        </th>
                                                        <th class="text-center">Thẻ 200,000đ
                                                        </th>
                                                        <th class="text-center">Thẻ 300,000đ
                                                        </th>
                                                        <th class="text-center">Thẻ 500,000đ
                                                        </th>
                                                        <th class="text-center">Thẻ
                                                            1,000,000đ
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <tr style="color: red;">
                                                        <td><img width="25px"
                                                                src="<?=BASE_URL('assets/img/bronzei.png');?>">
                                                            <b>Bronze</b>
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '10000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '20000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '30000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '50000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '100000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '200000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '300000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '500000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '1000000' ")['ck'];?>%
                                                        </td>
                                                    </tr>
                                                    <tr style="color: green;">
                                                        <td><img width="25px"
                                                                src="<?=BASE_URL('assets/img/bachkim.png');?>">
                                                            <b>Platinum</b>
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_platinum` WHERE `loaithe` = '$loaithe' AND `menhgia` = '10000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_platinum` WHERE `loaithe` = '$loaithe' AND `menhgia` = '20000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_platinum` WHERE `loaithe` = '$loaithe' AND `menhgia` = '30000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_platinum` WHERE `loaithe` = '$loaithe' AND `menhgia` = '50000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_platinum` WHERE `loaithe` = '$loaithe' AND `menhgia` = '100000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_platinum` WHERE `loaithe` = '$loaithe' AND `menhgia` = '200000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_platinum` WHERE `loaithe` = '$loaithe' AND `menhgia` = '300000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_platinum` WHERE `loaithe` = '$loaithe' AND `menhgia` = '500000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_platinum` WHERE `loaithe` = '$loaithe' AND `menhgia` = '1000000' ")['ck'];?>%
                                                        </td>
                                                    </tr>
                                                    <tr style="color: blue;">
                                                        <td><img width="25px"
                                                                src="<?=BASE_URL('assets/img/kimcuong.png');?>">
                                                            <b>Diamond</b>
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_diamond` WHERE `loaithe` = '$loaithe' AND `menhgia` = '10000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_diamond` WHERE `loaithe` = '$loaithe' AND `menhgia` = '20000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_diamond` WHERE `loaithe` = '$loaithe' AND `menhgia` = '30000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_diamond` WHERE `loaithe` = '$loaithe' AND `menhgia` = '50000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_diamond` WHERE `loaithe` = '$loaithe' AND `menhgia` = '100000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_diamond` WHERE `loaithe` = '$loaithe' AND `menhgia` = '200000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_diamond` WHERE `loaithe` = '$loaithe' AND `menhgia` = '300000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_diamond` WHERE `loaithe` = '$loaithe' AND `menhgia` = '500000' ")['ck'];?>%
                                                        </td>
                                                        <td><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto_diamond` WHERE `loaithe` = '$loaithe' AND `menhgia` = '1000000' ")['ck'];?>%
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php }?>
                                        <p style="font-size:15px;float:right;">Nhóm của bạn là: <?=myRank();?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(isset($_SESSION['username'])) { ?>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        LỊCH SỬ ĐỔI THẺ</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <p>Quý khách có thể cập nhật trạng thái thẻ bằng tay thông qua <a
                                        href="javascript:location.reload()"><b class="text-danger">
                                            đây </b></a>.
                                </p>

                            </div>
                            <div class="col-sm-6">
                                <p style="font-size:15px;float:right;"><label class="checkbox-inline"><input
                                            type="checkbox" id="UpdateHistory" value="">Tự động cập nhật kết quả mỗi
                                        3s</label></p>
                            </div>
                        </div>
                        <div class="table-responsive" id="loadHistoryCard">
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
                        </div>

                    </div>
                </div>
            </div>
            <script>
            $(document).ready(function() {
                $('#datatable2').DataTable();
            });
            </script>
            <?php }?>

        </div>
    </div>
</section>


<script type="text/javascript">
$("#UpdateHistory").on('change', function() {
    if (document.getElementById('UpdateHistory').checked == true) {
        PlaySound('tu_dong_cap_nhat_ket_qua_dang_duoc_bat');

        function loadHistoryCard() {
            $.ajax({
                url: "<?=BASE_URL('assets/ajaxs/loadHistoryCard.php');?>",
                type: "GET",
                dateType: "text",
                data: {

                },
                success: function(result) {
                    $('#loadHistoryCard').html(result);
                }
            });
        }
        var refreshIntervalId = setInterval(function() {
            $('#loadHistoryCard').load(loadHistoryCard());
        }, 3000);

    } else {
        PlaySound('vui_long_tai_lai_trang');
        clearInterval(refreshIntervalId);
    }
});
</script>

<script>
function PlaySound(type) {
    var audio = new Audio('<?=BASE_URL('assets/sound/click.mp3');?>');
    audio.pause();
    audio.play();
}
</script>
<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": false,
        "autoWidth": false,
    });
});
</script>
<?php 
    require_once(__DIR__."/public/client/Footer.php");
?>