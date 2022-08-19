<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'MUA THẺ | '.$CMSNT->site('tenweb');
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
                <a itemprop="item" href="<?=BASE_URL('BuyCard');?>"><span itemprop="name">Mua thẻ</span></a>
                <span itemprop="position" content="3"></span>
            </li>
        </ol>
    </div>
</div>
<?php if($CMSNT->site('server_buycard') == 0) {?>
<section class="main">
    <div class="section">
        <div class="container">
            <div class="col-sm-12">
                <div class="row mainpage-wrapper">
                    <section class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    MUA THẺ CÀO TỰ ĐỘNG</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="FormControlSelect">Số dư:</label>
                                        <strong class="text-success"><?=format_cash($getUser['money']);?> VND</strong>
                                        <input name="wallet" type="hidden" value="0015668184">
                                    </div>
                                    <div id="thongbao"></div>
                                    <form>
                                        <div class="form-group">
                                            <label>Chọn loại thẻ</label>
                                            <select id="telco" class="form-control" style="padding: 0px">
                                                <option value="">--Loại thẻ--</option>
                                                <?php foreach($CMSNT->get_list(" SELECT * FROM `type_muathe`  ") as $bank) { ?>
                                                <option value="<?=$bank['type'];?>"><?=$bank['name'];?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Chọn mệnh giá:</label>
                                            <select id="amount" class="charging-amount form-control">
                                                <option value="">--Mệnh giá--</option>
                                                <option value="10000">10,000đ</option>
                                                <option value="20000">20,000đ</option>
                                                <option value="30000">30,000đ</option>
                                                <option value="50000">50,000đ</option>
                                                <option value="100000">100,000đ</option>
                                                <option value="200000">200,000đ</option>
                                                <option value="300000">300,000đ</option>
                                                <option value="500000">500,000đ</option>
                                                <option value="1000000">1,000,000đ</option>
                                                <option value="2000000">2,000,000đ</option>
                                                <option value="5000000">5,000,000đ</option>
                                            </select>
                                        </div>
                                        <?php if(!empty($getUser['password2'])) { ?>
                                        <div class="form-group">
                                            <label for="FormControlSelect">Mật khẩu cấp 2:</label>
                                            <input type="password" class="form-control" id="password2"
                                                placeholder="Nhập mật khẩu cấp 2" value="">
                                        </div>
                                        <?php }?>
                                        <div class="card-footer">
                                            <button type="submit" id="BuyCard" class="btn btn-lg btn-warning">Mua
                                                ngay</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    LỊCH SỬ MUA THẺ</div>
                                <div class="panel-body">
                                    <table id="datatable" class="table table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>LOẠI THẺ</th>
                                                <th>SERI</th>
                                                <th>PIN</th>
                                                <th>MỆNH GIÁ</th>
                                                <th>THỜI GIAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `muathe` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$CMSNT->type_muathe($row['Telco']);?></td>
                                                <td><?=$row['Serial'];?></td>
                                                <td><?=$row['PinCode'];?></td>
                                                <td><?=format_cash($row['Amount']);?></td>
                                                <td><?=$row['gettime'];?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                        $("#BuyCard").on("click", function() {

                            $('#BuyCard').html('ĐANG XỬ LÝ').prop('disabled',
                                true);
                            $.ajax({
                                url: "<?=BASE_URL("assets/ajaxs/BuyCard.php");?>",
                                method: "POST",
                                data: {
                                    type: 'BuyCard',
                                    password2: $("#password2").val(),
                                    telco: $("#telco").val(),
                                    amount: $("#amount").val()
                                },
                                success: function(response) {
                                    $("#thongbao").html(response);
                                    $('#BuyCard').html(
                                            'Mua ngay')
                                        .prop('disabled', false);
                                }
                            });
                        });
                        </script>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } else {?>
<section class="main">
    <div class="section">
        <div class="container">
            <div class="row mainpage-wrapper">
                <div class="col-md-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            MUA THẺ CÀO</div>
                        <div class="panel-body">
                            <div id="thongbao"></div>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td>Loại thẻ cần mua:</td>
                                        <td>
                                            <select class="form-control" onchange="showMenhGia()" id="telco"
                                                style="padding: 0px" required>
                                                <option value="">-- Chọn loại thẻ cần mua --</option>
                                                <?php foreach($CMSNT->get_list("SELECT * FROM `sellcards` WHERE `sellcard_id` = 0 ") as $sellcard) {?>
                                                <option value="<?=$sellcard['id'];?>">Mua thẻ <?=$sellcard['name'];?>
                                                </option>
                                                <?php }?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mệnh giá thẻ:</td>
                                        <td><select class="form-control" style="padding: 0px" id="amount" required>
                                                <option value="">-- Chọn mệnh giá cần mua --</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Số lượng mua:</td>
                                        <td><input type="number" class="form-control" value="1" id="value"
                                                placeholder="Nhập số lượng thẻ cần mua">
                                        </td>
                                    </tr>
                                    <?php if(!empty($getUser['password2'])) { ?>
                                    <tr>
                                        <td>Mật khẩu cấp 2:</td>
                                        <td><input type="password" class="form-control" id="password2"
                                                placeholder="Nhập mật khẩu cấp 2" value="">
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <button type="button" onclick="muathe()" id="btnMuaThe" class="btn btn-info">Mua thẻ
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
                            LƯU Ý</div>
                        <div class="panel-body">
                            <?=$CMSNT->site('notice_buycard');?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            LỊCH SỬ MUA THẺ</div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped dataTable" id="datatable">
                                <thead>
                                    <tr>
                                        <th width='5%;'>#</th>
                                        <th>LOẠI THẺ</th>
                                        <th>MỆNH GIÁ</th>
                                        <th>SERI</th>
                                        <th>PIN</th>
                                        <th>THỜI GIAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `storecards` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><b style="color: green;"><?=getRowRealtime("sellcards", getRowRealtime("sellcards", $row['sellcard_id'], 'sellcard_id'), 'name');?></b></td>
                                        <td><b style="color: blue;"><?=format_cash(getRowRealtime("sellcards", $row['sellcard_id'], 'name'));?></b></td>
                                        <td><?=explode('|', $row['card'])[0];?></td>
                                        <td><?=explode('|', $row['card'])[1];?></td>
                                        <td><span class="label label-danger"><?=$row['updatedate'];?></span></td>
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


<script>
function showMenhGia() {
    $.ajax({
        url: "<?=BASE_URL('assets/ajaxs/menhgiamuathe.php');?>",
        method: "GET",
        data: {
            loaithe: $("#telco").val()
        },
        success: function(response) {
            $("#amount").html(response);
        }
    });
};
</script>
<script type="text/javascript">
function muathe(){
    $('#btnMuaThe').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("assets/ajaxs/BuyCard.php");?>",
        method: "POST",
        data: {
            type: 'BuyCardSv1',
            password2: $("#password2").val(),
            telco: $("#telco").val(),
            value: $("#value").val(),
            amount: $("#amount").val()
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('#btnMuaThe').html(
                    'Mua thẻ ngay')
                .prop('disabled', false);
        }
    });
};
</script>
<?php }?>
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