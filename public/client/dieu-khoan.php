<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'ĐIỀU KHOẢN | '.$CMSNT->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
?>

<div class="heading-page">
    <div class="container">
        <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('');?>"><span itemprop="name">Trang chủ</span></a>
                <span itemprop="position" content="1"></span>
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('dieu-khoan-dich-vu');?>"><span itemprop="name">Điều
                        khoản</span></a>
                <span itemprop="position" content="2"></span>
            </li>
        </ol>
    </div>
</div>


<section class="main">
    <div class="section">
        <div class="container">
            <div class="col-sm-12">
                <div class="row mainpage-wrapper">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                ĐIỀU KHOẢN SỬ DỤNG DỊCH VỤ</div>
                            <div class="panel-body">
                                <?=$CMSNT->site('dieu_khoan');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php 
    require_once("../../public/client/Footer.php");
?>