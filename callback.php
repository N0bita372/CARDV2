<?php 
    require_once(__DIR__."/config/config.php");
    require_once(__DIR__."/config/function.php");


    // CARDVIP.VN
    if(isset($_GET['status']) && isset($_GET['requestid'])){
        $status = check_string($_GET['status']);
        //$message = check_string($_GET['message']);
        $request_id = check_string($_GET['requestid']);
        $declared_value = check_string($_GET['pricesvalue']); //Giá trị khai báo
        $value = check_string($_GET['value_receive']); //Giá trị thực của thẻ
        $amount = check_string($_GET['value_customer_receive']); //Số tiền nhận được
        $code = check_string($_GET['card_code']);
        $serial = check_string($_GET['card_seri']);
        //$trans_id = check_string($_GET['trans_id']); //Mã giao dịch bên chúng tôi
        $callback_sign = check_string($_GET['callback_sign']);
        $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `code` = '$request_id' ");
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
        $telco = $row['loaithe'];
        
        if($row['loaithe'] == 'Vietnamobile')
        {
            $telco = 'VNMOBI';
        }
        if(!$row)
        {
            exit('Request ID không tồn tại');
        }
        if($row['trangthai'] != 'xuly')
        {
            exit('Thẻ này đã được xử lý rồi');
        }
        if($status == 200)
        {
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'hoantat',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            /**
             * CỘNG TIỀN CHO USER
             */
            $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $row['thucnhan'],
                'sotiensau'     => $getUser['money'] + $row['thucnhan'],
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'hoantat', $row['thucnhan'], $value);
            exit('Thẻ đúng !');
        }
        else if($status == 201)
        {
            $ck = $CMSNT->get_row("SELECT * FROM `".myGroupExCard($getUser['username'])."` WHERE `loaithe` = '$telco' AND `menhgia` = '$value'  ")['ck'];
            $thucnhan = $value - $value * $ck / 100;
            $thucnhan = $thucnhan / 2;
            $CMSNT->update("card_auto", [
                'trangthai' => 'hoantat',
                'thucnhan'  => $thucnhan,
                'amount'    => $amount,
                'ghichu'    => 'Sai mệnh giá -50%, mệnh giá thực '.format_cash($value),
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$row['username']."' ");
            /* CẬP NHẬT DÒNG TIỀN */
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $thucnhan,
                'sotiensau'     => $getUser['money'] + $thucnhan,
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'thatbai', $thucnhan, $value);
            exit('Thẻ sai mệnh giá !');
        }
        else
        {
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'thatbai',
                'ghichu'    => 'Thẻ không hợp lệ hoặc đã được sử dụng.',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");

            sendCallBack($row['callback'], $row['request_id'], 'thatbai', 0, $value);
            exit('Thẻ không hợp lệ !');
        }
    }

    // TRUMTHE.VN - CARD V3
    if(isset($_GET['request_id']) && isset($_GET['callback_sign'])){
        $status = check_string($_GET['status']);
        $message = check_string($_GET['message']);
        $request_id = check_string($_GET['request_id']); // request id
        $declared_value = check_string($_GET['declared_value']); //Giá trị khai báo
        $value = check_string($_GET['value']); //Giá trị thực của thẻ
        $amount = check_string($_GET['amount']); //Số tiền nhận được
        $code = check_string($_GET['code']);
        $serial = check_string($_GET['serial']);
        $telco = check_string($_GET['telco']);
        $trans_id = check_string($_GET['trans_id']); //Mã giao dịch bên chúng tôi
        $callback_sign = check_string($_GET['callback_sign']);
        $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `code` = '$request_id' ");
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
        if(!$row){
            exit('Request ID không tồn tại');
        }
        if($row['trangthai'] != 'xuly'){
            exit('Thẻ này đã được xử lý rồi');
        }
        if($status == 1){
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'hoantat',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            /**
             * CỘNG TIỀN CHO USER
             */
            $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $row['thucnhan'],
                'sotiensau'     => $getUser['money'] + $row['thucnhan'],
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL){
                if($CMSNT->site('status_ref') == 'ON'){
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'hoantat', $row['thucnhan'], $value);
            die('Thẻ đúng !');
        }
        else if($status == 2)
        {
            $ck = $CMSNT->get_row("SELECT * FROM `".myGroupExCard($getUser['username'])."` WHERE `loaithe` = '$telco' AND `menhgia` = '$value'  ")['ck'];
            $thucnhan = $value - $value * $ck / 100;
            $thucnhan = $thucnhan / 2;
            $CMSNT->update("card_auto", [
                'trangthai' => 'hoantat',
                'thucnhan'  => $thucnhan,
                'amount'    => $amount,
                'ghichu'    => 'Sai mệnh giá -50%, mệnh giá thực '.format_cash($value),
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$row['username']."' ");
            /* CẬP NHẬT DÒNG TIỀN */
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $thucnhan,
                'sotiensau'     => $getUser['money'] + $thucnhan,
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'thatbai', $thucnhan, $value);
            exit('Thẻ sai mệnh giá !');
        }
        else
        {
            $CMSNT->update("card_auto", [
                'amount'    => 0,
                'trangthai' => 'thatbai',
                'ghichu'    => $message,
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");

            
            sendCallBack($row['callback'], $row['request_id'], 'thatbai', 0, $value);
            exit('Thẻ không hợp lệ !');
        }
    }

    // CARD V2 CARD48 - DOITHE1S
    if(isset($_GET['status']) && isset($_GET['content']))
    {
        $status = check_string($_GET['status']);
        //$message = check_string($_GET['message']);
        $request_id = check_string($_GET['content']);
        $value = check_string($_GET['menhgiathuc']); //Giá trị thực của thẻ
        $amount = check_string($_GET['thucnhan']); //Số tiền nhận được
        $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `code` = '$request_id' ");
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
        $telco = $row['loaithe'];
        if(!$row)
        {
            exit('Request ID không tồn tại');
        }
        if($row['trangthai'] != 'xuly')
        {
            exit('Thẻ này đã được xử lý rồi');
        }
        if($status == 'hoantat')
        {
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'hoantat',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            /**
             * CỘNG TIỀN CHO USER
             */
            $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $row['thucnhan'],
                'sotiensau'     => $getUser['money'] + $row['thucnhan'],
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }
 
            sendCallBack($row['callback'], $row['request_id'], 'hoantat', $row['thucnhan'], $value);
            exit('Thẻ đúng !');
        }
        if($status == 'hoantat' && $row['menhgia'] != $value)
        {
            $ck = $CMSNT->get_row("SELECT * FROM `".myGroupExCard($getUser['username'])."` WHERE `loaithe` = '$telco' AND `menhgia` = '$value'  ")['ck'];
            $thucnhan = $value - $value * $ck / 100;
            $thucnhan = $thucnhan / 2;
            $CMSNT->update("card_auto", [
                'trangthai' => 'hoantat',
                'thucnhan'  => $thucnhan,
                'amount'    => $amount,
                'ghichu'    => 'Sai mệnh giá -50%, mệnh giá thực '.format_cash($value),
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$row['username']."' ");
            /* CẬP NHẬT DÒNG TIỀN */
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $thucnhan,
                'sotiensau'     => $getUser['money'] + $thucnhan,
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'thatbai', $thucnhan, $value);
            exit('Thẻ sai mệnh giá !');
        }
        $CMSNT->update("card_auto", [
            'amount'    => $amount,
            'trangthai' => 'thatbai',
            'ghichu'    => 'Thẻ không hợp lệ hoặc đã được sử dụng.',
            'capnhat'   => gettime()
        ], " `code` = '$request_id' ");

        sendCallBack($row['callback'], $row['request_id'], 'thatbai', 0, $value);
        exit('Thẻ không hợp lệ !');
    }

    // THECAO72.COM
    if(isset($_GET['status']) && isset($_GET['request_id']))
    {
        $status = check_string($_GET['status']);
        //$message = check_string($_GET['message']);
        $request_id = check_string($_GET['request_id']);
        $value = check_string($_GET['card_value']); //Giá trị thực của thẻ
        $amount = check_string($_GET['amount']); //Số tiền nhận được
        $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `code` = '$request_id' ");
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
        $telco = $row['loaithe'];
        if(!$row)
        {
            exit('Request ID không tồn tại');
        }
        if($row['trangthai'] != 'xuly')
        {
            exit('Thẻ này đã được xử lý rồi');
        }
        if($status == 'hoantat')
        {
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'hoantat',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            /**
             * CỘNG TIỀN CHO USER
             */
            $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $row['thucnhan'],
                'sotiensau'     => $getUser['money'] + $row['thucnhan'],
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }
 
            sendCallBack($row['callback'], $row['request_id'], 'hoantat', $row['thucnhan'], $value);
            exit('Thẻ đúng !');
        }
        if($status == 'saimenhgia' && $row['menhgia'] != $value)
        {
            $ck = $CMSNT->get_row("SELECT * FROM `".myGroupExCard($getUser['username'])."` WHERE `loaithe` = '$telco' AND `menhgia` = '$value'  ")['ck'];
            $thucnhan = $value - $value * $ck / 100;
            $thucnhan = $thucnhan / 2;
            $CMSNT->update("card_auto", [
                'trangthai' => 'hoantat',
                'thucnhan'  => $thucnhan,
                'amount'    => $amount,
                'ghichu'    => 'Sai mệnh giá -50%, mệnh giá thực '.format_cash($value),
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$row['username']."' ");
            /* CẬP NHẬT DÒNG TIỀN */
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $thucnhan,
                'sotiensau'     => $getUser['money'] + $thucnhan,
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'thatbai', $thucnhan, $value);
            exit('Thẻ sai mệnh giá !');
        }
        $CMSNT->update("card_auto", [
            'amount'    => $amount,
            'trangthai' => 'thatbai',
            'ghichu'    => 'Thẻ không hợp lệ hoặc đã được sử dụng.',
            'capnhat'   => gettime()
        ], " `code` = '$request_id' ");

        sendCallBack($row['callback'], $row['request_id'], 'thatbai', 0, $value);
        exit('Thẻ không hợp lệ !');
    }   
    
    if($CMSNT->site('status_cardv5') == 'ON'){
        // CARDV5
        $txtBody = file_get_contents('php://input');
        $jsonBody = json_decode($txtBody); //convert JSON into array
        if($txtBody || $jsonBody)
        {
            $status = check_string($jsonBody->status); // trạng thái
            $request_id = check_string($jsonBody->refcode); // request id đưa lên
            $declared_value = check_string($jsonBody->amount); // mệnh giá đưa lên
            $value = check_string($jsonBody->amoureal); // mệnh giá thực
            $amount = check_string($jsonBody->amount); // thực nhận của thẻ
            $code = check_string($jsonBody->cardcode);
            $serial = check_string($jsonBody->cardseri);
            $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `code` = '$request_id' ");
            $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
            $telco = $row['loaithe'];
            if(!$row)
            {
                exit('Request ID không tồn tại');
            }
            if($row['trangthai'] != 'xuly')
            {
                exit('Thẻ này đã được xử lý rồi');
            }
            // xử lý sai mệnh giá
            if($status == 3){
                if($value < $declared_value)
                {
                    $menhgia = $value;
                }
                else
                {
                    $menhgia = $declared_value;
                }
                $ck = $CMSNT->get_row("SELECT * FROM `".myGroupExCard($getUser['username'])."` WHERE `loaithe` = '$telco' AND `menhgia` = '$menhgia'  ")['ck'];
                $thucnhan = $menhgia - $menhgia * $ck / 100;
                $thucnhan = $thucnhan / 2;
                $CMSNT->update("card_auto", [
                    'trangthai' => 'hoantat',
                    'thucnhan'  => $thucnhan,
                    'amount'    => $amount,
                    'ghichu'    => 'Sai mệnh giá -50%, mệnh giá thực '.format_cash($value),
                    'capnhat'   => gettime()
                ], " `code` = '$request_id' ");
                $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$row['username']."' ");
                $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$row['username']."' ");
                /* CẬP NHẬT DÒNG TIỀN */
                $CMSNT->insert("dongtien", array(
                    'sotientruoc'   => $getUser['money'],
                    'sotienthaydoi' => $thucnhan,
                    'sotiensau'     => $getUser['money'] + $thucnhan,
                    'thoigian'      => gettime(),
                    'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                    'username'      => $getUser['username']
                ));
                /**
                 * XỬ LÝ HOA HỒNG CHO BẠN BÈ
                 */
                if($getUser['ref'] != NULL)
                {
                    if($CMSNT->site('status_ref') == 'ON')
                    {
                        $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                        $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                        /**
                         * CỘNG TIỀN CHO REFERRAL
                         */
                        $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                        $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                        $CMSNT->insert("dongtien", array(
                            'sotientruoc'   => $getUser_ref['money'],
                            'sotienthaydoi' => $hoahong,
                            'sotiensau'     => $getUser_ref['money'] + $hoahong,
                            'thoigian'      => gettime(),
                            'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                            'username'      => $getUser_ref['username']
                        ));
                    }
                }
                sendCallBack($row['callback'], $row['request_id'], 'thatbai', $thucnhan, $value);
                exit('Thẻ sai mệnh giá !');
            }
            if($status == 2)
            {
                
                $CMSNT->update("card_auto", [
                    'amount'    => $amount,
                    'trangthai' => 'hoantat',
                    'capnhat'   => gettime()
                ], " `code` = '$request_id' ");
                /**
                 * CỘNG TIỀN CHO USER
                 */
                $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
                $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
                $CMSNT->insert("dongtien", array(
                    'sotientruoc'   => $getUser['money'],
                    'sotienthaydoi' => $row['thucnhan'],
                    'sotiensau'     => $getUser['money'] + $row['thucnhan'],
                    'thoigian'      => gettime(),
                    'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                    'username'      => $getUser['username']
                ));
                /**
                 * XỬ LÝ HOA HỒNG CHO BẠN BÈ
                 */
                if($getUser['ref'] != NULL)
                {
                    if($CMSNT->site('status_ref') == 'ON')
                    {
                        $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                        $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                        /**
                         * CỘNG TIỀN CHO REFERRAL
                         */
                        $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                        $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                        $CMSNT->insert("dongtien", array(
                            'sotientruoc'   => $getUser_ref['money'],
                            'sotienthaydoi' => $hoahong,
                            'sotiensau'     => $getUser_ref['money'] + $hoahong,
                            'thoigian'      => gettime(),
                            'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                            'username'      => $getUser_ref['username']
                        ));
                    }
                }
                sendCallBack($row['callback'], $row['request_id'], 'hoantat', $row['thucnhan'], $value);
                exit('Thẻ đúng !');
            }
            $CMSNT->update("card_auto", [
                'amount'    => 0,
                'trangthai' => 'thatbai',
                'ghichu'    => 'Thẻ không hợp lệ hoặc đã được sử dụng.',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            sendCallBack($row['callback'], $row['request_id'], 'thatbai', 0, $value);
            exit('Thẻ không hợp lệ !');
        }
        die();
    }

    // AUTOCARD365.COM - THECAOMMO.COM - CARD V4
    $txtBody = file_get_contents('php://input');
    $jsonBody = json_decode($txtBody); //convert JSON into array
    if($txtBody || $jsonBody)
    {
        $status = check_string($jsonBody->Success); // trạng thái
        $request_id = check_string($jsonBody->requestid); // request id đưa lên
        //$declared_value = check_string($jsonBody->declared_value); // mệnh giá đưa lên
        $value = check_string($jsonBody->CardValue); // mệnh giá thực
        $amount = check_string($jsonBody->amount); // thực nhận của thẻ
        $code = check_string($jsonBody->Pin);
        $serial = check_string($jsonBody->Seri);
        $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `code` = '$request_id' ");
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
        $telco = $row['loaithe'];
        if(!$row)
        {
            exit('Request ID không tồn tại');
        }
        if($row['trangthai'] != 'xuly')
        {
            exit('Thẻ này đã được xử lý rồi');
        }
        if($status == true)
        {
            // xử lý sai mệnh giá
            if($value != $row['menhgia']){
                if($value < $declared_value)
                {
                    $menhgia = $value;
                }
                else
                {
                    $menhgia = $declared_value;
                }
                $ck = $CMSNT->get_row("SELECT * FROM `".myGroupExCard($getUser['username'])."` WHERE `loaithe` = '$telco' AND `menhgia` = '$menhgia'  ")['ck'];
                $thucnhan = $menhgia - $menhgia * $ck / 100;
                $thucnhan = $thucnhan / 2;
                $CMSNT->update("card_auto", [
                    'trangthai' => 'hoantat',
                    'thucnhan'  => $thucnhan,
                    'amount'    => $amount,
                    'ghichu'    => 'Sai mệnh giá -50%, mệnh giá thực '.format_cash($value),
                    'capnhat'   => gettime()
                ], " `code` = '$request_id' ");
                $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$row['username']."' ");
                $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$row['username']."' ");
                /* CẬP NHẬT DÒNG TIỀN */
                $CMSNT->insert("dongtien", array(
                    'sotientruoc'   => $getUser['money'],
                    'sotienthaydoi' => $thucnhan,
                    'sotiensau'     => $getUser['money'] + $thucnhan,
                    'thoigian'      => gettime(),
                    'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                    'username'      => $getUser['username']
                ));
                /**
                 * XỬ LÝ HOA HỒNG CHO BẠN BÈ
                 */
                if($getUser['ref'] != NULL)
                {
                    if($CMSNT->site('status_ref') == 'ON')
                    {
                        $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                        $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                        /**
                         * CỘNG TIỀN CHO REFERRAL
                         */
                        $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                        $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                        $CMSNT->insert("dongtien", array(
                            'sotientruoc'   => $getUser_ref['money'],
                            'sotienthaydoi' => $hoahong,
                            'sotiensau'     => $getUser_ref['money'] + $hoahong,
                            'thoigian'      => gettime(),
                            'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                            'username'      => $getUser_ref['username']
                        ));
                    }
                }
                sendCallBack($row['callback'], $row['request_id'], 'thatbai', $thucnhan, $value);
                exit('Thẻ sai mệnh giá !');
            }
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'hoantat',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            /**
             * CỘNG TIỀN CHO USER
             */
            $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $row['thucnhan'],
                'sotiensau'     => $getUser['money'] + $row['thucnhan'],
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }
            sendCallBack($row['callback'], $row['request_id'], 'hoantat', $row['thucnhan'], $value);
            exit('Thẻ đúng !');
        }
        $CMSNT->update("card_auto", [
            'amount'    => 0,
            'trangthai' => 'thatbai',
            'ghichu'    => 'Thẻ không hợp lệ hoặc đã được sử dụng.',
            'capnhat'   => gettime()
        ], " `code` = '$request_id' ");
        sendCallBack($row['callback'], $row['request_id'], 'thatbai', 0, $value);
        exit('Thẻ không hợp lệ !');
    }


    // DOITHE365.COM
    if($CMSNT->site('status_doithe365') == 'ON')
    {
        if(isset($_GET['status']) && isset($_GET['requestid']))
        {
            $status = check_string($_GET['status']);
            //$message = check_string($_GET['message']);
            $request_id = check_string($_GET['requestid']);
            $value = check_string($_GET['value_receive']); //Giá trị thực của thẻ
            $amount = check_string($_GET['guests_receive']); //Số tiền nhận được
            $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `code` = '$request_id' ");
            $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
            $telco = $row['loaithe'];
            if(!$row)
            {
                exit('Request ID không tồn tại');
            }
            if($row['trangthai'] != 'xuly')
            {
                exit('Thẻ này đã được xử lý rồi');
            }
            if($status == 200)
            {
                $CMSNT->update("card_auto", [
                    'amount'    => $amount,
                    'trangthai' => 'hoantat',
                    'capnhat'   => gettime()
                ], " `code` = '$request_id' ");
                /**
                 * CỘNG TIỀN CHO USER
                 */
                $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
                $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
                $CMSNT->insert("dongtien", array(
                    'sotientruoc'   => $getUser['money'],
                    'sotienthaydoi' => $row['thucnhan'],
                    'sotiensau'     => $getUser['money'] + $row['thucnhan'],
                    'thoigian'      => gettime(),
                    'noidung'       => 'Đổi thẻ seri ('.$row['seri'].')',
                    'username'      => $getUser['username']
                ));
                /**
                 * XỬ LÝ HOA HỒNG CHO BẠN BÈ
                 */
                if($getUser['ref'] != NULL)
                {
                    if($CMSNT->site('status_ref') == 'ON')
                    {
                        $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                        $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                        /**
                         * CỘNG TIỀN CHO REFERRAL
                         */
                        $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                        $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                        $CMSNT->insert("dongtien", array(
                            'sotientruoc'   => $getUser_ref['money'],
                            'sotienthaydoi' => $hoahong,
                            'sotiensau'     => $getUser_ref['money'] + $hoahong,
                            'thoigian'      => gettime(),
                            'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                            'username'      => $getUser_ref['username']
                        ));
                    }
                }
    
                sendCallBack($row['callback'], $row['request_id'], 'hoantat', $row['thucnhan'], $value);
                exit('Thẻ đúng !');
            }
            if($status == 201)
            {
                $ck = $CMSNT->get_row("SELECT * FROM `".myGroupExCard($getUser['username'])."` WHERE `loaithe` = '$telco' AND `menhgia` = '$value'  ")['ck'];
                $thucnhan = $value - $value * $ck / 100;
                $thucnhan = $thucnhan / 2;
                $CMSNT->update("card_auto", [
                    'trangthai' => 'hoantat',
                    'thucnhan'  => $thucnhan,
                    'amount'    => $amount,
                    'ghichu'    => 'Sai mệnh giá -50%, mệnh giá thực '.format_cash($value),
                    'capnhat'   => gettime()
                ], " `code` = '$request_id' ");
                $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$row['username']."' ");
                $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$row['username']."' ");
                /* CẬP NHẬT DÒNG TIỀN */
                $CMSNT->insert("dongtien", array(
                    'sotientruoc'   => $getUser['money'],
                    'sotienthaydoi' => $thucnhan,
                    'sotiensau'     => $getUser['money'] + $thucnhan,
                    'thoigian'      => gettime(),
                    'noidung'       => 'Đổi thẻ seri ('.$row['seri'].')',
                    'username'      => $getUser['username']
                ));
                /**
                 * XỬ LÝ HOA HỒNG CHO BẠN BÈ
                 */
                if($getUser['ref'] != NULL)
                {
                    if($CMSNT->site('status_ref') == 'ON')
                    {
                        $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                        $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                        /**
                         * CỘNG TIỀN CHO REFERRAL
                         */
                        $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                        $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                        $CMSNT->insert("dongtien", array(
                            'sotientruoc'   => $getUser_ref['money'],
                            'sotienthaydoi' => $hoahong,
                            'sotiensau'     => $getUser_ref['money'] + $hoahong,
                            'thoigian'      => gettime(),
                            'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                            'username'      => $getUser_ref['username']
                        ));
                    }
                }

                sendCallBack($row['callback'], $row['request_id'], 'thatbai', $thucnhan, $value);
                exit('Thẻ sai mệnh giá !');
            }
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'thatbai',
                'ghichu'    => 'Thẻ không hợp lệ hoặc đã được sử dụng.',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");

            sendCallBack($row['callback'], $row['request_id'], 'thatbai', 0, $value);
            exit('Thẻ không hợp lệ !');
        }  
    }
