<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'CTV | '.$CMSNT->site('tenweb');
    if($CMSNT->site('status_ref') != 'ON')
    {
        die('Chức năng này đang bảo trì!');
    }
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
                <a itemprop="item" href="<?=BASE_URL('Referral');?>"><span itemprop="name">REFERRAL</span></a>
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
                    <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    LƯU Ý</div>
                                <div class="panel-body">
                                    <?=$CMSNT->site('luuy_ref');?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    CHIA SẺ VỚI BẠN BÈ NGAY</div>
                                <div class="panel-body">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Liên kết chia sẻ:</td>
                                                <td><input type="text" class="form-control copy" id="urlRef"
                                                        data-clipboard-target="#urlRef"
                                                        value="<?=BASE_URL('?ref='.$getUser['id']);?>" readonly>
                                                    <small class="text-danger">Sao chép liên kết này và chia sẻ đến bạn
                                                        bè của bạn.</small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Hoa hồng:</td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            value="<?=$CMSNT->site('ck_ref');?>%" readonly>
                                                        <small class="text-danger">Bạn sẽ nhận được
                                                            <?=format_cash(100000*$CMSNT->site('ck_ref')/100);?>đ khi bạn
                                                            bè bạn nạp thẻ 100.000đ.</small>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Lượt click:</td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            value="<?=$getUser['ref_click'];?>" readonly>
                                                        <small class="text-danger">Tổng lượt nhấn vào liên kết giới thiệu của bạn.</small>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <i>Mẹo: bạn có thể chia sẻ liên kết này lên mạng xã hội để thu hút người click.</i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    DANH SÁCH BẠN BÈ CỦA BẠN</div>
                                <div class="panel-body">
                                    <table id="datatable" class="table table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th width="10%">#</th>
                                                <th>USERNAME</th>
                                                <th>TỔNG NẠP</th>
                                                <th>THỜI GIAN THAM GIA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `users` WHERE `ref` = '".$getUser['id']."' ORDER BY id DESC ") as $row){
                                    ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$row['username'];?></td>
                                                <td><?=format_cash($row['total_money']);?></td>
                                                <td><span class="label label-danger"><?=$row['createdate'];?></span>
                                                </td>
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
        "responsive": true,
        "autoWidth": false,
    });
});
</script>


<?php 
    require_once("../../public/client/Footer.php");
?>