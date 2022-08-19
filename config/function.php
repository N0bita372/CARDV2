<?php
$CMSNT = new CMSNT;
require_once(__DIR__.'/../vendor/autoload.php');

$config = [
    'project'   => 'CARDV2',
    'url'       => $base_url,
    'version'   => '2.1.0',
    'ip_server' => ''
];

$list_loaithe = [
    'VIETTEL',
    'VINAPHONE',
    'MOBIFONE',
    'ZING',
    'VNMOBI'
];

function checkFormatCard($type, $seri, $pin){
    $seri = strlen($seri);
    $pin = strlen($pin);
    $data = [];
    if($type == 'Viettel' || $type == "viettel" || $type == "VT" || $type == "VIETTEL"){
        if($seri != 11 && $seri != 14){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if($pin != 13 && $pin != 15){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if($type == 'Mobifone' || $type == "mobifone" || $type == "Mobi" || $type == "MOBIFONE"){
        if($seri != 15){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if($pin != 12){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if($type == 'VNMB' || $type == "Vnmb" || $type == "VNM" || $type == "VNMOBI"){
        if($seri != 16){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if($pin != 12){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if($type == 'Vinaphone' || $type == "vinaphone" || $type == "Vina" || $type == "VINAPHONE"){
        if($seri != 14){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if($pin != 14){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if($type == 'Garena' || $type == "garena" || $type == "GARENA"){
        if($seri != 9){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if($pin != 16){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if($type == 'Zing' || $type == "zing" || $type == "ZING"){
        if($seri != 12){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if($pin != 9){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if($type == 'Vcoin' || $type == "VTC" || $type == "VCOIN"){
        if($seri != 12){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if($pin != 12){
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    $data = [
        'status'    => true,
        'msg'       => 'Jss'
    ];
    return $data;
}

function checkPassword2($id_user, $password2)
{
    global $CMSNT;
    $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '$id_user' ");
    if($getUser['password2'] != '')
    {
        if($getUser['password2'] != $password2)
        {
            return false;
        }
        return true;
    }
    return true;
}
function getRowRealtime($table, $id, $row)
{
    global $CMSNT;
    return $CMSNT->get_row("SELECT * FROM `$table` WHERE `id` = '$id' ")[$row];
}
function format_currency($amount)
{
    $currency = 'VND';
    if($currency == 'USD')
    {
        return '$'.number_format($amount / 23000, 2, '.', '');
    }
    else if($currency == 'VND')
    {
        return format_cash($amount).'đ';
    }
}
function myGroupExCard($username)
{
    global $CMSNT;
    if($username != '')
    {
        if($getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '$username' "))
        {
            if($getUser['group_excard'] == 'Bronze')
            {
                return 'ck_card_auto';
            }
            if($getUser['group_excard'] == 'Platinum')
            {
                return 'ck_card_auto_platinum';
            }
            if($getUser['group_excard'] == 'Diamond')
            {
                return 'ck_card_auto_diamond';
            }
        }
    }
    else
    {
        if(isset($_SESSION['username']))
        {
            if($getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."' "))
            {
                if($getUser['group_excard'] == 'Bronze')
                {
                    return 'ck_card_auto';
                }
                if($getUser['group_excard'] == 'Platinum')
                {
                    return 'ck_card_auto_platinum';
                }
                if($getUser['group_excard'] == 'Diamond')
                {
                    return 'ck_card_auto_diamond';
                }
            }
        }
    }
    return 'ck_card_auto';
}
function myRank()
{
    global $CMSNT;
    if(isset($_SESSION['username']))
    {
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."' ");
        if($getUser['group_excard'] == 'Bronze')
        {
            return '<img width="25px" src="'.BASE_URL('assets/img/bronzei.png').'"> <b>Bronze</b>';
        }
        if($getUser['group_excard'] == 'Platinum')
        {
            return '<img width="25px" src="'.BASE_URL('assets/img/bachkim.png').'"> <b>Platinum</b>';
        }
        if($getUser['group_excard'] == 'Diamond')
        {
            return '<img width="25px" src="'.BASE_URL('assets/img/kimcuong.png').'"> <b>Diamond</b>';
        }
    }
    return '<img width="25px" src="'.BASE_URL('assets/img/bronzei.png').'"> <b>Bronze</b>';
}
function getMoney_momo($token)
{
    $result = curl_get("https://api.web2m.com/apigetsodu/$token");
    $result = json_decode($result, true);
    if(isset($result['status']) && $result['status'] == 200)
    {
        return $result['SoDu'];
    }
    else
    {
        return 0;
    }
}
function insert_options($name, $value){
    global $CMSNT;
    if(!$CMSNT->get_row("SELECT * FROM `options` WHERE `name` = '$name' "))
    {
        $CMSNT->insert("options", [
            'name'  => $name,
            'value' => $value
        ]);
    }
}
function sendCallBack($domain, $content, $status, $thucnhan, $menhgiathuc)
{
    if(isset($domain))
    {
        curl_get("$domain?content=$content&status=$status&thucnhan=$thucnhan"."&menhgiathuc=$menhgiathuc");
    }
}
function getSite($name){
    global $CMSNT;
    return $CMSNT->get_row("SELECT * FROM `options` WHERE `name` = '$name' ")['value'];
}
function getUser($username, $row){
    global $CMSNT;
    return $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '$username' ")[$row];
}
function thecaommo($loaithe, $pin, $seri, $menhgia, $code){
    global $CMSNT;
    if($loaithe == 'VNMOBI' || $loaithe == 'vietnamobile'){
        $loaithe = 16;
    }
    if($loaithe == 'VIETTEL' || $loaithe == 'Viettel '){
        $loaithe = 1;
    }
    if($loaithe == 'MOBIFONE' || $loaithe == 'Mobifone'){
        $loaithe = 2;
    }
    if($loaithe == 'VINAPHONE' || $loaithe == 'Vinaphone'){
        $loaithe = 3;
    }
    if($loaithe == 'ZING' || $loaithe == 'Zing'){
        $loaithe = 14;
    }
    $dataPost = array(
        'ApiKey'    => $CMSNT->site('api_thecaommo'),
        'Pin'       => $pin,
        'Seri'      => $seri,
        'CardType'  => $loaithe,
        'CardValue' => $menhgia,
        'requestid' => $code
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://thecaommo.com/api/card',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($dataPost),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}
function thecao72($loaithe, $pin, $seri, $menhgia, $code){  
    global $CMSNT;
    $APIkey = $CMSNT->site('api_thecao72');
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://thecao72.com/chargingws/v2?telco=$loaithe&amount=$menhgia&pin=$pin&seri=$seri&APIKey=$APIkey&request_id=$code",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}
function payas($loaithe, $pin, $seri, $menhgia, $code){  
    global $CMSNT;
    $response = curl_get("https://payas.net/api/card-auto.php?type=$loaithe&menhgia=$menhgia&seri=$seri&pin=$pin&APIKey=".$CMSNT->site('api_payas')."&callback=".BASE_URL('callback.php')."&content=$code");
    return json_decode($response, true);
}
function doithe1s($loaithe, $pin, $seri, $menhgia, $code){  
    global $CMSNT;
    $response = curl_get("https://doithe1s.vn/api/card-auto.php?type=$loaithe&menhgia=$menhgia&seri=$seri&pin=$pin&APIKey=".$CMSNT->site('api_doithe1s')."&callback=".BASE_URL('callback.php')."&content=$code");
    return json_decode($response, true);
}
function card48($loaithe, $pin, $seri, $menhgia, $code){  
    global $CMSNT;
    $response = curl_get("https://card48.net/api/card-auto.php?type=$loaithe&menhgia=$menhgia&seri=$seri&pin=$pin&APIKey=".$CMSNT->site('api_card48')."&callback=".BASE_URL('callback.php')."&content=$code");
    return json_decode($response, true);
}
function doithe365($loaithe, $pin, $seri, $menhgia, $code){  
    global $CMSNT;
    if($loaithe == 'VNMOBI'){
        $loaithe = 'Vietnamobile';
    }
    $response = curl_get("https://api.doithe365.com/api/card-auto?api_key=".$CMSNT->site('api_doithe365')."&card_type=$loaithe&card_amount=$menhgia&card_pin=$pin&card_serial=$seri&request_id=$code&url_callback=".BASE_URL('callback.php'));
    return json_decode($response, true);
}
function cardv2($loaithe, $pin, $seri, $menhgia, $code){  
    global $CMSNT;
    $response = curl_get($CMSNT->site('domain_cardv2')."/api/card-auto.php?type=$loaithe&menhgia=$menhgia&seri=$seri&pin=$pin&APIKey=".$CMSNT->site('api_cardv2')."&callback=".BASE_URL('callback.php')."&content=$code");
    return json_decode($response, true);
}
function cardv3($loaithe, $pin, $seri, $menhgia, $code){
    global $CMSNT;
    $url = $CMSNT->site('domain_cardv3').'/chargingws/v2?sign='.md5($CMSNT->site('partner_key_cardv3').$pin.$seri).'&telco='.$loaithe.'&code='.$pin.'&serial='.$seri.'&amount='.$menhgia.'&request_id='.$code.'&partner_id='.$CMSNT->site('partner_id_cardv3').'&command=charging';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return json_decode($data, true);
}
function cardv5($loaithe, $pin, $seri, $menhgia, $code){  
    global $CMSNT;
    if($loaithe == 'VNMOBI'){
        $loaithe = 'VNMOBILE';
    }
    if($loaithe == 'MOBIFONE'){
        $loaithe = 'MOBI';
    }
    if($loaithe == 'VINAPHONE'){
        $loaithe = 'VINA';
    }
    $menhgia = 100000;


    //MD5(usercode + telco + cardcode + cardseri + amount + refcode + callurl + userpass)
    $sign = md5($CMSNT->site('usercode_cardv5').$loaithe.$pin.$seri.$menhgia.$code.BASE_URL('callback.php').$CMSNT->site('userpass_cardv5'));
    
    
    $dataPost = array(
        'usercode' => $CMSNT->site('usercode_cardv5'),
        'telco' => $loaithe,
        'amount' => $menhgia,
        'cardcode' => $pin,
        'cardseri' => $seri,
        'sign' => $sign,
        'refcode' => $code,
        'callurl' => BASE_URL('callback.php')
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $CMSNT->site('domain_cardv5').'api/v1/sendcard',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($dataPost),
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
    //return $response;
}


function autocard365($loaithe, $pin, $seri, $menhgia, $code){
    global $CMSNT;
    if($loaithe == 'VNMOBI' || $loaithe == 'vietnamobile'){
        $loaithe = 16;
    }
    if($loaithe == 'VIETTEL' || $loaithe == 'Viettel '){
        $loaithe = 1;
    }
    if($loaithe == 'MOBIFONE' || $loaithe == 'Mobifone'){
        $loaithe = 2;
    }
    if($loaithe == 'VINAPHONE' || $loaithe == 'Vinaphone'){
        $loaithe = 3;
    }
    if($loaithe == 'ZING' || $loaithe == 'Zing'){
        $loaithe = 14;
    }
    $dataPost = array(
        'ApiKey'    => $CMSNT->site('api_autocard365'),
        'Pin'       => $pin,
        'Seri'      => $seri,
        'CardType'  => $loaithe,
        'CardValue' => $menhgia,
        'requestid' => $code
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.autocard365.com/api/card',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($dataPost),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}
function cardv4($loaithe, $pin, $seri, $menhgia, $code){
    global $CMSNT;
    if($loaithe == 'VNMOBI' || $loaithe == 'vietnamobile'){
        $loaithe = 18;
    }
    if($loaithe == 'VIETTEL' || $loaithe == 'Viettel '){
        $loaithe = 1;
    }
    if($loaithe == 'MOBIFONE' || $loaithe == 'Mobifone'){
        $loaithe = 15;
    }
    if($loaithe == 'VINAPHONE' || $loaithe == 'Vinaphone'){
        $loaithe = 16;
    }
    if($loaithe == 'ZING' || $loaithe == 'Zing'){
        $loaithe = 19;
    }
    $dataPost = array(
        'ApiKey'    => $CMSNT->site('api_cardv4'),
        'Pin'       => $pin,
        'Seri'      => $seri,
        'CardType'  => $loaithe,
        'CardValue' => $menhgia,
        'Requestid' => $code
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $CMSNT->site('domain_cardv4').'/api/card',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($dataPost),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}
function cardvip($loaithe, $pin, $seri, $menhgia, $code){
    global $CMSNT;
    if($loaithe == 'VNMOBI'){
        $loaithe = 'Vietnamobile';
    }
    if($loaithe == 'VIETTEL'){
        $loaithe = 'Viettel';
    }
    if($loaithe == 'MOBIFONE'){
        $loaithe = 'Mobifone';
    }
    if($loaithe == 'VINAPHONE'){
        $loaithe = 'Vinaphone';
    }
    if($loaithe == 'ZING'){
        $loaithe = 'Zing';
    }
    $dataPost = array(
        'APIKey' => $CMSNT->site('api_cardvip'),
        'NetworkCode' => $loaithe,
        'PricesExchange' => $menhgia,
        'NumberCard' => $pin,
        'SeriCard' => $seri,
        'IsFast' => 'true',
        'RequestId' => $code,
        'UrlCallback' => BASE_URL('callback.php')
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://partner.cardvip.vn/api/createExchange',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($dataPost),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}
function trumthe($loaithe, $pin, $seri, $menhgia, $code){
    global $CMSNT;
    $url = 'https://trumthe.vn/chargingws/v2?sign='.md5($CMSNT->site('partner_key').$pin.$seri).'&telco='.$loaithe.'&code='.$pin.'&serial='.$seri.'&amount='.$menhgia.'&request_id='.$code.'&partner_id='.$CMSNT->site('partner_id').'&command=charging';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return json_decode($data, true);
}
function format_date($time){
    return date("H:i:s d/m/Y", $time);
}
function listbank(){
    $html = '
    <option value="">Chọn ngân hàng</option>
    <option value="MOMO">MOMO</option>
    <option value="VIETTEL PAY">VIETTEL PAY</option>
    <option value="ZALO PAY">ZALO PAY</option>
    <option value="AIRPAY">AIRPAY</option>
    <option value="VIETINBANK">VIETINBANK</option>
    <option value="VIETCOMBANK">VIETCOMBANK</option>
    <option value="AGRIBANK">AGRIBANK</option>
    <option value="TPBANK">TPBANK</option>
    <option value="HDB">HDB</option>
    <option value="VPBANK">VPBANK</option>
    <option value="MBBANK">MBBANK</option>
    <option value="OCEANBANK">OCEANBANK</option>
    <option value="BIDV">BIDV</option>
    <option value="SACOMBANK">SACOMBANK</option>
    <option value="ACB">ACB</option>
    <option value="ABBANK">ABBANK</option>
    <option value="NCB">NCB</option>
    <option value="IBK">IBK</option>
    <option value="CIMB">CIMB</option>
    <option value="EXIMBANK">EXIMBANK</option>
    <option value="SEABANK">SEABANK</option>
    <option value="SCB">SCB</option>
    <option value="DONGABANK">DONGABANK</option>
    <option value="SAIGONBANK">SAIGONBANK</option>
    <option value="PG BANK">PG BANK</option>
    <option value="PVCOMBANK">PVCOMBANK</option>
    <option value="KIENLONGBANK">KIENLONGBANK</option>
    <option value="VIETCAPITAL BANK">VIETCAPITAL BANK</option>
    <option value="OCB">OCB</option>
    <option value="MSB">MSB</option>
    <option value="SHB">SHB</option>
    <option value="VIETBANK">VIETBANK</option>
    <option value="VRB">VRB</option>
    <option value="NAMABANK">NAMABANK</option>
    <option value="SHBVN">SHBVN</option>
    <option value="VIB">VIB</option>
    <option value="TECHCOMBANK">TECHCOMBANK</option>
    ';
    return $html;
}
function daily($data){
    if($data == 0)
    {
        return 'Thành viên';
    }
    else if($data == 1)
    {
        return 'Đại lý';
    }
}
function trangthai($data)
{
    if($data == 'xuly')
    {
        return 'Đang xử lý';
    }
    else if($data == 'hoantat')
    {
        return 'Hoàn tất';
    }
    else if($data == 'thanhcong')
    {
        return 'Thành công';
    }
    else if($data == 'huy')
    {
        return 'Hủy';
    }
    else if($data == 'thatbai')
    {
        return 'Thất bại';
    }
    else
    {
        return 'Khác';
    }
}
function loaithe($data)
{
    if ($data == 'Viettel' || $data == 'viettel')
    {
        $show = 'https://i.imgur.com/xFePMtd.png';
    }
    else if ($data == 'Vinaphone' || $data == 'vinaphone')
    {
        $show = 'https://i.imgur.com/s9Qq3Fz.png';
    }
    else if ($data == 'Mobifone' || $data == 'mobifone')
    {
        $show = 'https://i.imgur.com/qQtcWJW.png';
    }
    else if ($data == 'Vietnamobile' || $data == 'vietnamobile')
    {
        $show = 'https://i.imgur.com/IHm28mq.png';
    }
    else if ($data == 'Zing' || $data == 'zing')
    {
        $show = 'https://i.imgur.com/xkd7kQ0.png';
    }
    else if ($data == 'Garena' || $data == 'garena')
    {
        $show = 'https://i.imgur.com/BLkY5qm.png';
    }
    return '<img style="text-align: center;" src="'.$show.'" width="70px" />';
}

function sendCSM($mail_nhan,$ten_nhan,$chu_de,$noi_dung,$bcc)
{
    global $CMSNT;
        // PHPMailer Modify
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail ->Debugoutput = "html";
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $CMSNT->site('email'); // GMAIL STMP
        $mail->Password = $CMSNT->site('pass_email'); // PASS STMP
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom($CMSNT->site('email'), $bcc);
        $mail->addAddress($mail_nhan, $ten_nhan);
        $mail->addReplyTo($CMSNT->site('email'), $bcc);
        $mail->isHTML(true);
        $mail->Subject = $chu_de;
        $mail->Body    = $noi_dung;
        $mail->CharSet = 'UTF-8';
        $send = $mail->send();
        return $send;
}
function parse_order_id($des)
{
    global $CMSNT;
    $re = '/'.$CMSNT->site('noidung_naptien').'\d+/im';
    preg_match_all($re, $des, $matches, PREG_SET_ORDER, 0);
    if (count($matches) == 0 )
        return null;
    // Print the entire match result
    $orderCode = $matches[0][0];
    $prefixLength = strlen($CMSNT->site('noidung_naptien'));
    $orderId = intval(substr($orderCode, $prefixLength ));
    return $orderId ;
}
function BASE_URL($url)
{
    global $config;
    $a = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
    if($a == 'http://localhost'){
        $a = 'http://localhost/CMSNT.CO/TRUMTHE';
    }
    return $a.'/'.$url;
}
function gettime()
{
    return date('Y/m/d H:i:s', time());
}
function check_string($data)
{
    return trim(htmlspecialchars(addslashes($data)));
    //return str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($data))));
}
function format_cash($price)
{
    return str_replace(",", ".", number_format($price));
}
function curl_get($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    
    curl_close($ch);
    return $data;
}
function random($string, $int)
{  
    return substr(str_shuffle($string), 0, $int);
}
function pheptru($int1, $int2)
{
    return $int1 - $int2;
}
function phepcong($int1, $int2)
{
    return $int1 + $int2;
}
function phepnhan($int1, $int2)
{
    return $int1 * $int2;
}
function phepchia($int1, $int2)
{
    return $int1 / $int2;
}
function check_img($img)
{
    $filename = $_FILES[$img]['name'];
    $ext = explode(".", $filename);
    $ext = end($ext);
    $valid_ext = array("png","jpeg","jpg","PNG","JPEG","JPG","gif","GIF");
    if(in_array($ext, $valid_ext))
    {
        return true;
    }
}
function msg_error3($text)
{
    return '<div class="alert alert-danger alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-badge="close">×</a>'.$text.'</div>';
}
function msg_success3($text)
{
    return '<div class="alert alert-success alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-badge="close">×</a>'.$text.'</div>';
}


function msg_success2($text)
{
    return die('<div class="alert alert-success alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-badge="close">×</a>'.$text.'</div>');
}
function msg_error2($text)
{
    return die('<div class="alert alert-danger alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-badge="close">×</a>'.$text.'</div>');
}
function msg_warning2($text)
{
    return die('<div class="alert alert-warning alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-badge="close">×</a>'.$text.'</div>');
}
function msg_success($text, $url, $time)
{
    return die('<div class="alert alert-success alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-badge="close">×</a>'.$text.'</div><script type="text/javascript">setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function msg_error($text, $url, $time)
{
    return die('<div class="alert alert-danger alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-badge="close">×</a>'.$text.'</div><script type="text/javascript">setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function msg_warning($text, $url, $time)
{
    return die('<div class="alert alert-warning alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-badge="close">×</a>'.$text.'</div><script type="text/javascript">setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function admin_msg_success($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thành Công", "'.$text.'","success");
    setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function admin_msg_error($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thất Bại", "'.$text.'","error");
    setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function admin_msg_warning($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thông Báo", "'.$text.'","warning");
    setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function display_banned($data)
{
    if ($data == 1)
    {
        $show = '<span class="badge badge-danger">Banned</span>';
    }
    else if ($data == 0)
    {
        $show = '<span class="badge badge-success">Hoạt động</span>';
    }
    return $show;
}
function display_loaithe($data)
{
    if ($data == 0)
    {
        $show = '<span class="badge badge-warning">Bảo trì</span>';
    }
    else 
    {
        $show = '<span class="badge badge-success">Hoạt động</span>';
    }
    return $show;
}
function display_ruttien($data)
{
    if ($data == 'xuly')
    {
        $show = '<span class="badge badge-info">Đang xử lý</span>';
    }
    else if ($data == 'hoantat')
    {
        $show = '<span class="badge badge-success">Đã thanh toán</span>';
    }
    else if ($data == 'huy')
    {
        $show = '<span class="badge badge-danger">Hủy</span>';
    }
    return $show;
}
function display_ruttien_user($data)
{
    if ($data == 'xuly')
    {
        $show = '<span class="label label-info">Đang xử lý</span>';
    }
    else if ($data == 'hoantat')
    {
        $show = '<span class="label label-success">Đã thanh toán</span>';
    }
    else if ($data == 'huy')
    {
        $show = '<span class="label label-danger">Hủy</span>';
    }
    return $show;
}
function XoaDauCach($text)
{
    return trim(preg_replace('/\s+/',' ', $text));
}
function display($data)
{
    if ($data == 'HIDE')
    {
        $show = '<span class="badge badge-danger">ẨN</span>';
    }
    else if ($data == 'SHOW')
    {
        $show = '<span class="badge badge-success">HIỂN THỊ</span>';
    }
    return $show;
}
function status($data)
{
    if ($data == 'xuly'){
        $show = '<span class="label label-info">Đang xử lý</span>';
    }
    else if ($data == 'hoantat'){
        $show = '<span class="label label-success">Hoàn tất</span>';
    }
    else if ($data == 'thanhcong'){
        $show = '<span class="label label-success">Thành công</span>';
    }
    else if ($data == 'success'){
        $show = '<span class="label label-success">Success</span>';
    }
    else if ($data == 'thatbai'){
        $show = '<span class="label label-danger">Thất bại</span>';
    }
    else if ($data == 'error'){
        $show = '<span class="label label-danger">Error</span>';
    }
    else if ($data == 'loi'){
        $show = '<span class="label label-danger">Lỗi</span>';
    }
    else if ($data == 'huy'){
        $show = '<span class="label label-danger">Hủy</span>';
    }
    else if ($data == 'dangnap'){
        $show = '<span class="label label-warning">Đang đợi nạp</span>';
    }
    else if ($data == 2){
        $show = '<span class="label label-success">Hoàn tất</span>';
    }
    else if ($data == 1){
        $show = '<span class="label label-info">Đang xử lý</span>';
    }
    else{
        $show = '<span class="label label-warning">Khác</span>';
    }
    return $show;
}
function status_admin($data)
{
    if ($data == 'xuly'){
        $show = '<span class="badge badge-info">Đang xử lý</span>';
    }
    else if ($data == 'hoantat'){
        $show = '<span class="badge badge-success">Hoàn tất</span>';
    }
    else if ($data == 'thanhcong'){
        $show = '<span class="badge badge-success">Thành công</span>';
    }
    else if ($data == 'success'){
        $show = '<span class="badge badge-success">Success</span>';
    }
    else if ($data == 'thatbai'){
        $show = '<span class="badge badge-danger">Thất bại</span>';
    }
    else if ($data == 'error'){
        $show = '<span class="badge badge-danger">Error</span>';
    }
    else if ($data == 'loi'){
        $show = '<span class="badge badge-danger">Lỗi</span>';
    }
    else if ($data == 'huy'){
        $show = '<span class="badge badge-danger">Hủy</span>';
    }
    else if ($data == 'dangnap'){
        $show = '<span class="badge badge-warning">Đang đợi nạp</span>';
    }
    else if ($data == 2){
        $show = '<span class="badge badge-success">Hoàn tất</span>';
    }
    else if ($data == 1){
        $show = '<span class="badge badge-info">Đang xử lý</span>';
    }
    else{
        $show = '<span class="badge badge-warning">Khác</span>';
    }
    return $show;
}
function getHeader(){
    $headers = array();
    $copy_server = array(
        'CONTENT_TYPE'   => 'Content-Type',
        'CONTENT_LENGTH' => 'Content-Length',
        'CONTENT_MD5'    => 'Content-Md5',
    );
    foreach ($_SERVER as $key => $value) {
        if (substr($key, 0, 5) === 'HTTP_') {
            $key = substr($key, 5);
            if (!isset($copy_server[$key]) || !isset($_SERVER[$key])) {
                $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
                $headers[$key] = $value;
            }
        } elseif (isset($copy_server[$key])) {
            $headers[$copy_server[$key]] = $value;
        }
    }
    if (!isset($headers['Authorization'])) {
        if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        } elseif (isset($_SERVER['PHP_AUTH_USER'])) {
            $basic_pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
            $headers['Authorization'] = 'Basic ' . base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $basic_pass);
        } elseif (isset($_SERVER['PHP_AUTH_DIGEST'])) {
            $headers['Authorization'] = $_SERVER['PHP_AUTH_DIGEST'];
        }
    }
    return $headers;
}

function check_username($data)
{
    if (preg_match('/^[a-zA-Z0-9_-]{3,16}$/', $data, $matches))
    {
        return True;
    }
    else
    {
        return False;
    }
}
function check_email($data)
{
    if (preg_match('/^.+@.+$/', $data, $matches))
    {
        return True;
    }
    else
    {
        return False;
    }
}
function check_phone($data)
{
    if (preg_match('/^\+?(\d.*){3,}$/', $data, $matches))
    {
        return True;
    }
    else
    {
        return False;
    }
}
function check_url($url)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_HEADER, 1);
    curl_setopt($c, CURLOPT_NOBODY, 1);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_FRESH_CONNECT, 1);
    if(!curl_exec($c))
    {
        return false;
    }
    else
    {
        return true;
    }
}
function check_zip($img)
{
    $filename = $_FILES[$img]['name'];
    $ext = explode(".", $filename);
    $ext = end($ext);
    $valid_ext = array("zip","ZIP");
    if(in_array($ext, $valid_ext))
    {
        return true;
    }
}
function TypePassword($string)
{
    return md5($string);
}
function phantrang($url, $start, $total, $kmess)
{
    $out[] = '<nav aria-badge="Page navigation example"><ul class="pagination pagination-lg">';
    $neighbors = 2;
    if ($start >= $total) $start = max(0, $total - (($total % $kmess) == 0 ? $kmess : ($total % $kmess)));
    else $start = max(0, (int)$start - ((int)$start % (int)$kmess));
    $base_link = '<li class="page-item"><a class="page-link" href="' . strtr($url, array('%' => '%%')) . 'page=%d' . '">%s</a></li>';
    $out[] = $start == 0 ? '' : sprintf($base_link, $start / $kmess, '<i class="fas fa-angle-left"></i>');
    if ($start > $kmess * $neighbors) $out[] = sprintf($base_link, 1, '1');
    if ($start > $kmess * ($neighbors + 1)) $out[] = '<li class="page-item"><a class="page-link">...</a></li>';
    for ($nCont = $neighbors;$nCont >= 1;$nCont--) if ($start >= $kmess * $nCont) {
        $tmpStart = $start - $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    $out[] = '<li class="page-item active"><a class="page-link">' . ($start / $kmess + 1) . '</a></li>';
    $tmpMaxPages = (int)(($total - 1) / $kmess) * $kmess;
    for ($nCont = 1;$nCont <= $neighbors;$nCont++) if ($start + $kmess * $nCont <= $tmpMaxPages) {
        $tmpStart = $start + $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    if ($start + $kmess * ($neighbors + 1) < $tmpMaxPages) $out[] = '<li class="page-item"><a class="page-link">...</a></li>';
    if ($start + $kmess * $neighbors < $tmpMaxPages) $out[] = sprintf($base_link, $tmpMaxPages / $kmess + 1, $tmpMaxPages / $kmess + 1);
    if ($start + $kmess < $total)
    {
        $display_page = ($start + $kmess) > $total ? $total : ($start / $kmess + 2);
        $out[] = sprintf($base_link, $display_page, '<i class="fas fa-angle-right"></i>');
    }
    $out[] = '</ul></nav>';
    return implode('', $out);
}
function myip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))     
    {  
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))    
    {  
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    else  
    {  
        $ip_address = $_SERVER['REMOTE_ADDR'];  
    }
    return check_string($ip_address);
}
function timeAgo($time_ago)
{
    $time_ago   = date("Y-m-d H:i:s", $time_ago);
    $time_ago   = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60)
    {
        return "$seconds giây trước";
    }
    //Minutes
    else if($minutes <= 60)
    {
        return "$minutes phút trước";
    }
    //Hours
    else if($hours <= 24)
    {
        return "$hours tiếng trước";
    }
    //Days
    else if($days <= 7)
    {
        if($days == 1)
        {
            return "Hôm qua";
        }
        else
        {
            return "$days ngày trước";
        }
    }
    //Weeks
    else if($weeks <= 4.3)
    {
        return "$weeks tuần trước";
    }
    //Months
    else if($months <=12)
    {
        return "$months tháng trước";
    }
    //Years
    else
    {
        return "$years năm trước";
    }
}
/* CMSNT.CO TEAM LEADER - NTTHANH - DEV PHP */