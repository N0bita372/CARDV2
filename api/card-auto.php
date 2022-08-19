<?php 
    require_once("../config/config.php");
    require_once("../config/function.php");

    if (isset($_GET['type']) && isset($_GET['menhgia']) && isset($_GET['seri']) && isset($_GET['pin']) && isset($_GET['APIKey']) && isset($_GET['callback']) )
    {
        $type = check_string($_GET['type']);
        $loaithe = $type;
        $menhgia = check_string($_GET['menhgia']);
        $seri = check_string($_GET['seri']);
        $pin = check_string($_GET['pin']);
        $APIKey = check_string($_GET['APIKey']);
        $content = check_string($_GET['content']);
        $callback = check_string($_GET['callback']);
        $code = random('qwertyuiopasdfghklzxcvbnm1234567890',4).time();
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '$APIKey' ");
        
        if($CMSNT->site('baotri') == 'OFF')
        {
            $data['data'] = [
                "status"    =>  'error',
                "msg"       =>  'API nạp thẻ đang bảo trì '
                ];
            die(json_encode($data, JSON_PRETTY_PRINT));
        }
        if(!$getUser)
        {
            $data['data'] = [
                "status"    =>  'error',
                "msg"       =>  'API Key nạp thẻ không hợp lệ, vui lòng báo Admin !'
                ];
                die(json_encode($data, JSON_PRETTY_PRINT));
        }
        $array_checkFormatCard = checkFormatCard($type, $seri, $pin);
        if($array_checkFormatCard['status'] != true){
            $data['data'] = [
                "status"    =>  'error',
                "msg"       =>  $array_checkFormatCard['msg']
                ];
            die(json_encode($data, JSON_PRETTY_PRINT));
        }
        if($CMSNT->num_rows("SELECT * FROM `card_auto` WHERE `trangthai` = 'xuly' AND `username` = '".$getUser['username']."'  ") >= 30)
        {
            $data['data'] = [
                "status"    =>  'error',
                "msg"       =>  'Hệ thống đang có nhiều thẻ đang chờ xử lý, vui lòng đợi 1 lát rồi thử lại'
                ];
            die(json_encode($data, JSON_PRETTY_PRINT));
        }
        // if(
        //     $CMSNT->num_rows("SELECT * FROM `card_auto` WHERE `trangthai` = 'thatbai' AND `username` = '".$getUser['username']."' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY  ") - 
        //     $CMSNT->num_rows("SELECT * FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `username` = '".$getUser['username']."' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY  ") >= 50)
        // {
        //     $data['data'] = [
        //         "status"    =>  'error',
        //         "msg"       =>  'API bị chặn sử dụng chức năng này trong 24h!'
        //         ];
        //     die(json_encode($data, JSON_PRETTY_PRINT));
        // }
        $ck = $CMSNT->get_row("SELECT * FROM `".myGroupExCard($getUser['username'])."` WHERE `loaithe` = '$loaithe' AND `menhgia` = '$menhgia'  ");
        $ck = is_array($ck) ? $ck['ck'] : false;
        if($ck === false)
        {
            $data['data'] = [
                "status"    =>  'error',
                "msg"       =>  'Dữ liệu không hợp lệ'
                ];
            die(json_encode($data, JSON_PRETTY_PRINT));
        }
        if($ck == 0)
        {
            $data['data'] = [
                "status"    =>  'error',
                "msg"       =>  'Thẻ đang bảo trì, vui lòng đợi'
                ];
            die(json_encode($data, JSON_PRETTY_PRINT));
        }
        $thucnhan = $menhgia - $menhgia * $ck / 100;


        /* CARDVIP.VN
        if($CMSNT->site('status_cardvip') == 'ON')
        {
            $result = cardvip($loaithe, $pin, $seri, $menhgia, $code);
            if($result['status'] == 200)
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => 'cardvip'
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            else
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['message']
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        if($CMSNT->site('status_trumthe') == 'ON')
        {
            $result = trumthe($loaithe, $pin, $seri, $menhgia, $code);
            if($result['status'] == 100)
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['message']
                    ];
                    die(json_encode($data, JSON_PRETTY_PRINT));
            }
            if($result['status'] == 1)
            {
                $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$getUser['username']."' ");
                $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$getUser['username']."' ");
                $CMSNT->insert("dongtien", array(
                    'sotientruoc'   => $getUser['money'],
                    'sotienthaydoi' => $thucnhan,
                    'sotiensau'     => $getUser['money'] + $thucnhan,
                    'thoigian'      => gettime(),
                    'noidung'       => 'Đổi thẻ seri ('.$seri.')',
                    'username'      => $getUser['username']
                ));
                $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'amount'    => $result['amount'],
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'hoantat',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'capnhat'   => gettime(),
                    'callback'  => $callback,
                    'server'    => 'trumthe.vn'
                ]);
                $data['data'] = [
                "status"    =>  'success',
                "msg"       =>  'Nạp thẻ thành công'
                ];
                echo json_encode($data, JSON_PRETTY_PRINT);
                if(isset($callback))
                {
                    curl_get($callback."?content=".$code."&status=hoantat&thucnhan=".$thucnhan."&menhgiathuc=".$menhgia);
                }
                die;
            }
            if($result['status'] == 2)
            {
                $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'request_id' => $content,
                    'thucnhan'  => '0',
                    'username'  => $getUser['username'],
                    'trangthai' => 'thatbai',
                    'ghichu'    => 'Sai mệnh giá',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => 'trumthe'
                ]);
                $data['data'] = [
                "status"    =>  'error',
                "msg"       =>  'Sai mệnh giá'
                ];
                echo json_encode($data, JSON_PRETTY_PRINT);
                if(isset($callback))
                {
                    curl_get($callback."?content=".$code."&status=thatbai&thucnhan=0&menhgiathuc=0");
                }
                die;
            }
            if($result['status'] == 3)
            {
                $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'request_id' => $content,
                    'thucnhan'  => '0',
                    'username'  => $getUser['username'],
                    'trangthai' => 'thatbai',
                    'ghichu'    => 'Thẻ cào không hợp lệ hoặc đã được sử dụng',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => 'trumthe'
                ]);
                $data['data'] = [
                "status"    =>  'error',
                "msg"       =>  'Thẻ cào không hợp lệ hoặc đã được sử dụng'
                ];
                echo json_encode($data, JSON_PRETTY_PRINT);
                if(isset($callback))
                {
                    curl_get($callback."?content=".$code."&status=thatbai&thucnhan=0&menhgiathuc=0");
                }
                die;
            }
            if($result['status'] == 4)
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  'Chức năng này đang bảo trì, vui lòng quay lại sau'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            if($result['status'] == 99)
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => 'trumthe'
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }*/
        // CARDV2
        if($CMSNT->site('status_cardv2') == 'ON')
        {
            $result = cardv2($loaithe, $pin, $seri, $menhgia, $code);
            if($result['data']['status'] == 'success')
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => $CMSNT->site('domain_cardv2')
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            else
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['message']
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        // CARDV3
        if($CMSNT->site('status_cardv3') == 'ON')
        {
            $result = cardv3($loaithe, $pin, $seri, $menhgia, $code);
            if($result['status'] == 100)
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['message']
                    ];
                    die(json_encode($data, JSON_PRETTY_PRINT));
            }
            if($result['status'] == 1)
            {
                $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$getUser['username']."' ");
                $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$getUser['username']."' ");
                /* CẬP NHẬT DÒNG TIỀN */
                $CMSNT->insert("dongtien", array(
                    'sotientruoc'   => $getUser['money'],
                    'sotienthaydoi' => $thucnhan,
                    'sotiensau'     => $getUser['money'] + $thucnhan,
                    'thoigian'      => gettime(),
                    'noidung'       => 'Đổi thẻ seri ('.$seri.')',
                    'username'      => $getUser['username']
                ));
                $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'amount'    => $result['amount'],
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'hoantat',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'capnhat'   => gettime(),
                    'callback'  => $callback,
                    'server'    => $CMSNT->site('domain_cardv3')
                ]);
                $data['data'] = [
                "status"    =>  'success',
                "msg"       =>  'Nạp thẻ thành công'
                ];
                echo json_encode($data, JSON_PRETTY_PRINT);
                if(isset($callback))
                {
                    curl_get($callback."?content=".$code."&status=hoantat&thucnhan=".$thucnhan."&menhgiathuc=".$menhgia);
                }
                die;
            }
            if($result['status'] == 2)
            {
                $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'request_id' => $content,
                    'thucnhan'  => '0',
                    'username'  => $getUser['username'],
                    'trangthai' => 'thatbai',
                    'ghichu'    => 'Sai mệnh giá',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => $CMSNT->site('domain_cardv3')
                ]);
                $data['data'] = [
                "status"    =>  'error',
                "msg"       =>  'Sai mệnh giá'
                ];
                echo json_encode($data, JSON_PRETTY_PRINT);
                if(isset($callback))
                {
                    curl_get($callback."?content=".$code."&status=thatbai&thucnhan=0&menhgiathuc=0");
                }
                die;
            }
            if($result['status'] == 3)
            {
                $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'request_id' => $content,
                    'thucnhan'  => '0',
                    'username'  => $getUser['username'],
                    'trangthai' => 'thatbai',
                    'ghichu'    => 'Thẻ cào không hợp lệ hoặc đã được sử dụng',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => $CMSNT->site('domain_cardv3')
                ]);
                $data['data'] = [
                "status"    =>  'error',
                "msg"       =>  'Thẻ cào không hợp lệ hoặc đã được sử dụng'
                ];
                echo json_encode($data, JSON_PRETTY_PRINT);
                if(isset($callback))
                {
                    curl_get($callback."?content=".$code."&status=thatbai&thucnhan=0&menhgiathuc=0");
                }
                die;
            }
            if($result['status'] == 4)
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  'Chức năng này đang bảo trì, vui lòng quay lại sau'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            if($result['status'] == 99)
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => $CMSNT->site('domain_cardv3')
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        // AUTOCARD365.COM
        if($CMSNT->site('status_autocard365') == 'ON')
        {
            $result = autocard365($loaithe, $pin, $seri, $menhgia, $code);
            if($result['Code'] == 1)
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => 'autocard365.com'
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            else
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['Message']
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        // CARD48.NET
        if($CMSNT->site('status_card48') == 'ON')
        {
            $result = card48($loaithe, $pin, $seri, $menhgia, $code);
            if($result['data']['status'] == 'success')
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => 'card48.net'
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            else
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['message']
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        // THECAO72.COM
        if($CMSNT->site('status_thecao72') == 'ON')
        {
            $result = thecao72($loaithe, $pin, $seri, $menhgia, $code);
            if($result['status'] == 200)
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => 'thecao72.com'
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            else
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['message']
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        // THECAOMMO.COM
        if($CMSNT->site('status_thecaommo') == 'ON')
        {
            $result = thecaommo($loaithe, $pin, $seri, $menhgia, $code);
            if($result['Code'] == 1)
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => 'thecaommo.com'
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            else
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['Message']
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        // DOITHE1S.VN
        if($CMSNT->site('status_doithe1s') == 'ON')
        {
            $result = doithe1s($loaithe, $pin, $seri, $menhgia, $code);
            if($result['data']['status'] == 'success')
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => 'doithe1s.vn'
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            else
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['message']
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        // PAYAS.NET
        if($CMSNT->site('status_payas') == 'ON')
        {
            $result = payas($loaithe, $pin, $seri, $menhgia, $code);
            if($result['data']['status'] == 'success')
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => 'payas.net'
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            else
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['message']
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        // CARDV4
        if($CMSNT->site('status_cardv4') == 'ON')
        {
            $result = cardv4($loaithe, $pin, $seri, $menhgia, $code);
            if($result['Code'] == 1)
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => $CMSNT->site('domain_cardv4')
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            else
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['Message']
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        // DOITHE365.COM
        if($CMSNT->site('status_doithe365') == 'ON')
        {
            $result = doithe365($loaithe, $pin, $seri, $menhgia, $code);
            if($result['status'] == 200)
            {
                $isInsert = $CMSNT->insert("card_auto", [
                    'code'      => $code,
                    'seri'      => $seri,
                    'pin'       => $pin,
                    'loaithe'   => $loaithe,
                    'menhgia'   => $menhgia,
                    'thucnhan'  => $thucnhan,
                    'request_id' => $content,
                    'username'  => $getUser['username'],
                    'trangthai' => 'xuly',
                    'ghichu'    => '',
                    'thoigian'  => gettime(),
                    'callback'  => $callback,
                    'server'    => 'doithe365.com'
                ]);
                $data['data'] = [
                    "status"    =>  'success',
                    "msg"       =>  'Gửi thẻ thành công, vui lòng đợi duyệt!'
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
            else
            {
                $data['data'] = [
                    "status"    =>  'error',
                    "msg"       =>  $result['message']
                    ];
                die(json_encode($data, JSON_PRETTY_PRINT));
            }
        }


        $data['data'] = [
            "status"    =>  'error',
            "msg"       =>  'Hệ thống đang bảo trì, vui lòng quay lại sau.'
            ];
        die(json_encode($data, JSON_PRETTY_PRINT));
    }