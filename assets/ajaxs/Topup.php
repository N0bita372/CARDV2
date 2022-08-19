<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    require_once('../../class/class.smtp.php');
    require_once('../../class/PHPMailerAutoload.php');
    require_once('../../class/class.phpmailer.php');
    require_once('../../class/BanThe247.php');


    if($_POST['type'] == 'Topup')
    {
        if(empty($_SESSION['username']))
        {
            msg_error("Vui lòng đăng nhập để tiếp tục !", BASE_URL("Auth/Login"), 2000);
        }
        if($CMSNT->site('status_napdt') != 'ON')
        {
            msg_error2("Chức năng này đang bảo trì !");
        }
        if(empty($CMSNT->site('tk_banthe247')) || empty($CMSNT->site('mk_banthe247')))
        {
            msg_error2("Vui lòng điền tài khoản mật khẩu API!");
        }
        $loai = check_string($_POST['loai']);
        $amount = check_string($_POST['amount']);
        $sdt = check_string($_POST['sdt']);
        if(empty($sdt))
        {
            msg_error2("Vui lòng nhập số điện thoại cần nạp");
        }
        if(empty($amount))
        {
            msg_error2("Vui lòng chọn mệnh giá cần nạp");
        }
        if($amount <= 0)
        {
            msg_error2("Mệnh giá không hợp lệ !");
        }
        if(empty($loai))
        {
            msg_error2("Vui lòng chọn loại thuê bao");
        }
        $password2 = isset($_POST['password2']) ? check_string($_POST['password2']) : '';
        if(checkPassword2($getUser['id'], $password2) == false)
        {
            msg_error2("Mật khẩu cấp 2 không hợp lệ");
        }
        if($amount > $getUser['money'])
        {
            msg_error2("Số dư không đủ vui lòng nạp thêm.");
        }
        // trừ tiền trước r tính gì tính
        $isTru = $CMSNT->tru("users", "money", $amount, " `username` = '".$getUser['username']."' ");
        if($isTru)
        {
            /* CLASS BANTHE247.COM */
            $banthe247 = new BanThe247();
            $banthe247->username = $CMSNT->site('tk_banthe247');
            $banthe247->password = $CMSNT->site('mk_banthe247');
            $banthe247->security = $CMSNT->site('security_banthe247');
            $banthe247->card = $sdt.':'.$amount.':'.$loai;
            $result = json_decode($banthe247->TopupMobile(), True);
            /* CLASS BANTHE247.COM */
            if($result['errorCode'] != 0)
            {
                // refund
                $CMSNT->cong("users", "money", $amount, " `username` = '".$getUser['username']."' ");
                msg_error2($result['message']);
            }
            else
            {
                // Dòng tiền
                $CMSNT->insert("dongtien", array(
                    'sotientruoc'   => $getUser['money'],
                    'sotienthaydoi' => $amount,
                    'sotiensau'     => $getUser['money'] - $amount,
                    'thoigian'      => gettime(),
                    'noidung'       => 'Nạp tiền điện thoại số ('.$sdt.' mệnh giá '.format_cash($amount).')',
                    'username'      => $getUser['username']
                ));
                $CMSNT->insert("topup", [
                    'username'  => $getUser['username'],
                    'sdt'       => $sdt,
                    'amount'    => $amount,
                    'loai'      => $loai,
                    'gettime'   => gettime(),
                    'time'      => time()
                ]);
                msg_success("Giao dịch thành công !", "", 2000);
            }
        }
    }