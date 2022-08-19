<?php
    require_once("../config/config.php");
    require_once("../config/function.php");
    $d = date('d', strtotime("0 days"));
    $m = date('m', strtotime("0 days"));
    $y = date('Y', strtotime("0 days"));
    $m = date('F', mktime(0, 0, 0, $m, 10));
    $date = $d. ' ' . $m . ' ' . $y;
    if (! function_exists('imap_open'))
    {
        echo "Vui lòng bật IMAP cho máy chủ.";
        die();
    } 
    else
    {
        $connection = imap_open('{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX', $CMSNT->site('email'), $CMSNT->site('pass_email')) or die('Cannot connect to Gmail: ' . imap_last_error());
        $emailData = imap_search($connection, 'FROM "no-reply@momo.vn" SINCE "'.$date.'"');
        if (!empty($emailData))
        {
            foreach ($emailData as $emailIdent)
            {
                /* SYSTEM AUTO MOMO BY CMSNT.CO */
                $overview = imap_fetch_overview($connection, $emailIdent, 0);
                if(preg_match("/Giao dịch thành công/",imap_utf8($overview[0]->subject))) continue;
                if(!preg_match("/Bạn vừa nhận được tiền từ/",imap_utf8($overview[0]->subject))) continue;
                $message = ((imap_fetchbody($connection, $emailIdent,1)));
                $message = preg_replace( "/\s+/", " ", $message);
                preg_match('/(?<=li= ne-height: 1.2em; font-weight: 500;"> )(.*?)(?= <\/td>)/', $message, $matches);
                $money =  ($matches[0]);
                preg_match('/(?<=height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px; padding-right: 10px;= "> M=C3=A3 giao d=E1=BB=8Bch<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $code =  ($matches[0]);
                preg_match('/(?<=ADi<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $name =  str_replace("=",'%',$matches[0]);
                $name =  str_replace("%\s",'',$name);
                $name =  urldecode($name);
                preg_match('/(?<=tho=E1=BA=A1i ng=C6=B0= =E1=BB=9Di g=E1=BB=ADi<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $phone =  str_replace("=",'%',$matches[1]);
                preg_match('/(?<=gian<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $time =  str_replace("=",'%',$matches[1]);
                preg_match('/(?<=L=E1=BB=9Di nh=E1=BA=AFn<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $content =  str_replace('<div style="color:#3C4043;margin:0px;font-size:12px;li% ne-height:22px; font-weight: normal; font-size: 15px;"> ','',urldecode(str_replace("=",'%',$matches[1])));
                $date = date("d F, Y", strtotime($overview[0]->date));
                $amount         = str_replace('.', '', $money);
                /* SYSTEM AUTO MOMO BY CMSNT.CO */
                $partnerId      = $phone;                   //  SỐ ĐIỆN THOẠI CHUYỂN
                $comment        = $content;                 // NỘI DUNG CHUYỂN TIỀN
                $tranId         = $code;                    // MÃ GIAO DỊCH
                $partnerName    = $name;                    // TÊN CHỦ VÍ
                $id             = parse_order_id($content); // TÁCH NỘI DUNG CHUYỂN TIỀN
                if ($id)
                {
                    $row = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$id' ");
                    if($row['id'])
                    {
                        if($CMSNT->num_rows(" SELECT * FROM `momo` WHERE `tranId` = '$tranId' ") == 0)
                        {
                            $create = $CMSNT->insert("momo", array(
                                'tranId'        => $tranId,
                                'username'      => $row['username'],
                                'comment'       => $comment,
                                'time'          => gettime(),
                                'partnerId'     => $partnerId,
                                'amount'        => $amount,
                                'partnerName'   => $partnerName
                            ));
                            if ($create)
                            {
                                $isCheckMoney = $CMSNT->cong("users", "money", $amount, " `username` = '".$row['username']."' ");

                                if($isCheckMoney)
                                {
                                    $CMSNT->cong("users", "total_money", $amount, " `username` = '".$row['username']."' ");
                                    $CMSNT->insert("dongtien", array(
                                        'sotientruoc'   => $row['money'],
                                        'sotienthaydoi' => $amount,
                                        'sotiensau'     => $row['money'] + $amount,
                                        'thoigian'      => gettime(),
                                        'noidung'       => 'Nạp tiền tự động qua ví MOMO ('.$tranId.')',
                                        'username'      => $row['username']
                                    ));
                                }
                            }
                        }
                    }
                }
            }
        }
        imap_close($connection);
    }
    die('THIẾT KẾ WEB LIÊN HỆ WWW.CMSNT.CO | ZALO: 0947838128');