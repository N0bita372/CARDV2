<?php 
    require_once(__DIR__."/../../config/config.php");
    require_once(__DIR__."/../../config/function.php");
    require_once(__DIR__."/../../includes/login.php");

    if(isset($_GET['amount']))
    {
        $sotien = check_string($_GET['amount']);
        // lấy phí rút %
        $phi_rut_tien_ck = $CMSNT->site('phi_rut_tien_ck');
        // lấy phí rút cố định
        $phi_rut_tien = $CMSNT->site('phi_rut_tien');
        // tính số tiền phí khi trừ đi %
        $total_phi_rut_tien = $sotien * $phi_rut_tien_ck / 100;
        // tính tổng số tiền phí % + cố định
        $total_phi = $total_phi_rut_tien + $phi_rut_tien;

        // cộng tổng số tiền phí vào số tiền rút
        $sotien = $sotien + $total_phi;

        $json = json_encode([
            'total_rut' => format_currency($_GET['amount']),
            'total_phi' => format_currency($total_phi),
            'total_thanh_toan' => format_currency($sotien)
        ]);
        die($json);
    }

