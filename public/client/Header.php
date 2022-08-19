<!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="content-language" content="vi">
    <meta name="robots" content="index, follow'">
    <!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
    <title><?=$title;?></title>
    <meta name="description" content="<?=$CMSNT->site('mota');?>">
    <meta name="keywords" content="<?=$CMSNT->site('tukhoa');?>">
    <!-- Open Graph data -->
    <meta property="og:title" content="<?=$CMSNT->site('tenweb');?>">
    <meta property="og:type" content="Website">
    <meta property="og:url" content="<?=BASE_URL('');?>">
    <meta property="og:image" content="<?=$CMSNT->site('anhbia');?>">
    <meta property="og:description" content="<?=$CMSNT->site('mota');?>">
    <meta property="og:site_name" content="<?=$CMSNT->site('tenweb');?>">
    <meta property="article:section" content="<?=$CMSNT->site('mota');?>">
    <meta property="article:tag" content="<?=$CMSNT->site('tukhoa');?>">
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="<?=$CMSNT->site('anhbia');?>">
    <meta name="twitter:site" content="@wmt24h">
    <meta name="twitter:title" content="<?=$CMSNT->site('tenweb');?>">
    <meta name="twitter:description" content="<?=$CMSNT->site('mota');?>">
    <meta name="twitter:creator" content="@wmt24h">
    <meta name="twitter:image:src" content="<?=$CMSNT->site('anhbia');?>">
    <link rel="shortcut icon" href="<?=$CMSNT->site('favicon');?>">
    <link rel="stylesheet" href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/font-awesome/css/all.css"
        type="text/css">
    <link rel="stylesheet" href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/ionicons2/css/ionicons.min.css"
        type="text/css">
    <link rel="stylesheet" href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/bootstrap/bootstrap.min.css"
        type="text/css">
    <link rel="stylesheet" href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/font-roboto/roboto.css"
        type="text/css">
    <link rel="stylesheet"
        href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/OwlCarousel2/assets/owl.carousel.min.css"
        type="text/css">
    <link rel="stylesheet"
        href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/OwlCarousel2/assets/owl.theme.default.min.css"
        type="text/css">
    <link rel="stylesheet" href="<?=BASE_URL('template/trumthe/');?>assets/default/css/theme.css" type="text/css">
    <link rel="stylesheet"
        href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/material-design-icons/css/material-icons.min.css">
    <!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default/default.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
    <!-- DataTables -->
    <link rel="stylesheet" href="<?=BASE_URL('template/');?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?=BASE_URL('template/');?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?=BASE_URL('template/');?>plugins/daterangepicker/daterangepicker.css">
    <style>
    body{
        background-color: #f2f2f2;
    }
    .btn {
        border-radius: <?=$CMSNT->site('border_radius');?>px;
    }
    
    .tabpage .nav-tabs > li.active > a {
        cursor: default;
        background-color: #ffffff;
        border: 3px solid <?=$CMSNT->site('theme_color');?>;
        border-bottom-color: transparent;
    }
    .panel-default>.panel-heading {
        color: white;
        border-radius: 0px;
        background-color: <?=$CMSNT->site('theme_color');
        ?>;
        border-color: #ddd;
    }
    
    header.isfixed {
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        width: 100%;
        margin: auto;
        z-index: 999;
        background: #fff;
        box-shadow: 14px 8px 11px 0px rgb(0 0 0 / 20%);
    }

    .panel {
        margin-bottom: 20px;
        background-color: #fff;
        border: 0px solid <?=$CMSNT->site('theme_color');?>;
        border-radius: <?=$CMSNT->site('border_radius');?>px;
        /*-webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
        box-shadow: 16px 20px 20px rgb(0 0 0 / 5%);*/
        
    }

    .panel-footer {
        padding: 10px 15px;
        background-color: #ffffff;
        border-top: 1px solid #ddd;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
    }
    .form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555555;
        background-color: #ffffff;
        background-image: none;
        border: 1px solid #cccccc;
        border-radius: <?=$CMSNT->site('border_radius');?>px;
        -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
        box-shadow: 20px 6px 20px rgb(0 0 0 / 8%);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }

    .nav-pills > li > a {
    border-radius: <?=$CMSNT->site('border_radius');?>px;
    border: 1px solid <?=$CMSNT->site('theme_color');?>;
    }
    .nav-pills > li.active > a, .nav-pills > li.active > a:focus, .nav-pills > li.active > a:hover {
    color: #fff;
    background-color: <?=$CMSNT->site('theme_color');?>;
    }
    .gradient-border {
        margin-bottom: 20px;
        --borderWidth: 3px;
        background: #fff;
        position: relative;
        border-radius: var(--borderWidth);
    }

    .gradient-border:after {
        content: '';
        position: absolute;
        top: calc(-1 * var(--borderWidth));
        left: calc(-1 * var(--borderWidth));
        height: calc(100% + var(--borderWidth) * 2);
        width: calc(100% + var(--borderWidth) * 2);
        background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
        border-radius: calc(2 * var(--borderWidth));
        z-index: -1;
        animation: animatedgradient 3s ease alternate infinite;
        background-size: 300% 300%;
    }


    @keyframes animatedgradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    
    </style>


    <?php
    if(isset($_SESSION['username']))
    {
        if($getUser['banned'] == 1)
        {
            session_destroy();
            die('Tài khoản của bạn đã bị khóa.');
        }
        if($getUser['level'] != 'admin')
        {
            if($CMSNT->site('baotri') == 'OFF')
            {
                die('Hệ thống đang bảo trì, quay lại sau!');
            }
        }
    }
    else
    {
        if($CMSNT->site('baotri') == 'OFF')
        {
            die('Hệ thống đang bảo trì, quay lại sau!');
        }
    }