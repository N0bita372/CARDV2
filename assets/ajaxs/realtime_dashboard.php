<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    require_once("../../includes/login-admin.php");
    //require_once("../../config/UsageServer.php");

    $data = json_encode([
        
        'total_money'   => format_cash($CMSNT->get_row("SELECT SUM(`money`) FROM `users` WHERE `money` > 0 ")['SUM(`money`)']).'đ',
        'total_users'   => $CMSNT->num_rows("SELECT * FROM `users` "),
        'the_hop_le'    => format_cash($CMSNT->num_rows("SELECT * FROM `card_auto` WHERE `trangthai` = 'hoantat' ")),
        'tong_tien_the' => format_cash($CMSNT->get_row("SELECT SUM(`menhgia`) FROM `card_auto` WHERE `trangthai` = 'hoantat' ")['SUM(`menhgia`)']).'đ',
        'doanh_thu_today'=> format_cash($CMSNT->get_row("SELECT SUM(`menhgia`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`menhgia`)']).'đ',
        'san_luong_today'=> format_cash($CMSNT->num_rows("SELECT * FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")),
        'total_web_api' => format_cash($CMSNT->num_rows("SELECT DISTINCT `callback` FROM `card_auto` WHERE `callback` IS NOT NULL ")),
        'loi_nhuan_today' => format_cash($CMSNT->get_row("SELECT SUM(`amount`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`amount`)'] - 
        $CMSNT->get_row("SELECT SUM(`thucnhan`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`thucnhan`)'] + 
        $CMSNT->get_row("SELECT SUM(`thanhtoan`) FROM `ruttien` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`thanhtoan`)'] - 
        $CMSNT->get_row("SELECT SUM(`sotien`) FROM `ruttien` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`sotien`)']
        ).'đ'

    ]);
    die($data);

?>
