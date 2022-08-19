<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    require_once(__DIR__."/../../includes/login-admin.php");
    $title = 'CẤU HÌNH CHIẾT KHẤU | '.$CMSNT->site('tenweb');
    require_once("../../public/admin/Header.php");
    require_once("../../public/admin/Sidebar.php");
    require_once(__DIR__."/../../includes/checkLicense.php");
?>
<?php
if(isset($_POST['btnSaveCk']) && $getUser['level'] == 'admin')
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    foreach ($_POST as $key => $value)
    {
        $CMSNT->update("ck_card_auto", array(
            'ck' => $value
        ), " `id` = '$key' ");
    }
    admin_msg_success('Lưu thành công', '', 500);
}
if(isset($_POST['btnSaveCkplatinum']) && $getUser['level'] == 'admin')
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    foreach ($_POST as $key => $value)
    {
        $CMSNT->update("ck_card_auto_platinum", array(
            'ck' => $value
        ), " `id` = '$key' ");
    }
    admin_msg_success('Lưu thành công', '', 500);
}
if(isset($_POST['btnSaveCkdiamond']) && $getUser['level'] == 'admin')
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    foreach ($_POST as $key => $value)
    {
        $CMSNT->update("ck_card_auto_diamond", array(
            'ck' => $value
        ), " `id` = '$key' ");
    }
    admin_msg_success('Lưu thành công', '', 500);
}
if(isset($_POST['btnSaveOption']) && $getUser['level'] == 'admin')
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    foreach ($_POST as $key => $value)
    {
        $CMSNT->update("options", array(
            'value' => $value
        ), " `name` = '$key' ");
    }
    admin_msg_success('Lưu thành công', '', 500);
}
?>



<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cấu hình chiết khấu</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="alert alert-dark">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <p>Liên hệ CMSNT.CO để được báo giá vị trí quảng cáo API.</p>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH AUTOCARD365.COM <i style="color: red;" class="fas fa-star"></i></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">API Key</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="api_autocard365"
                                            value="<?=$CMSNT->site('api_autocard365');?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_autocard365" required>
                                        <option value="<?=$CMSNT->site('status_autocard365');?>">
                                            <?=$CMSNT->site('status_autocard365');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH CARD48.NET <i style="color: red;" class="fas fa-star"></i></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">API Key</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="api_card48"
                                            value="<?=$CMSNT->site('api_card48');?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_card48" required>
                                        <option value="<?=$CMSNT->site('status_card48');?>">
                                            <?=$CMSNT->site('status_card48');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH THECAO72.COM <i style="color: red;" class="fas fa-star"></i></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">API Key</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="api_thecao72"
                                            value="<?=$CMSNT->site('api_thecao72');?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_thecao72" required>
                                        <option value="<?=$CMSNT->site('status_thecao72');?>">
                                            <?=$CMSNT->site('status_thecao72');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH THECAOMMO.COM <i style="color: red;" class="fas fa-star"></i></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">API Key</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="api_thecaommo"
                                            value="<?=$CMSNT->site('api_thecaommo');?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_thecaommo" required>
                                        <option value="<?=$CMSNT->site('status_thecaommo');?>">
                                            <?=$CMSNT->site('status_thecaommo');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH DOITHE1S.VN <i style="color: red;" class="fas fa-star"></i></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">API Key</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="api_doithe1s"
                                            value="<?=$CMSNT->site('api_doithe1s');?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_doithe1s" required>
                                        <option value="<?=$CMSNT->site('status_doithe1s');?>">
                                            <?=$CMSNT->site('status_doithe1s');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH PAYAS.NET <i style="color: red;" class="fas fa-star"></i></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">API Key</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="api_payas"
                                            value="<?=$CMSNT->site('api_payas');?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_payas" required>
                                        <option value="<?=$CMSNT->site('status_payas');?>">
                                            <?=$CMSNT->site('status_payas');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH DOITHE365.COM <i style="color: red;" class="fas fa-star"></i></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <p>Quý Khách Hàng Đấu API DOITHE365.COM Liên Hệ Zalo <b>0399689993</b> Để Được Kích Hoạt API và Được Set Đại Lý</p>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">API Key</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="api_doithe365"
                                            value="<?=$CMSNT->site('api_doithe365');?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_doithe365" required>
                                        <option value="<?=$CMSNT->site('status_doithe365');?>">
                                            <?=$CMSNT->site('status_doithe365');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH API V2 (bao gồm hệ thống <a
                                href="https://www.cmsnt.co/2021/03/source-code-doi-the-cao-tu-dong.html"
                                target="_blank">CARDV2</a> của CMSNT.CO)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Link website cần đấu</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="domain_cardv2"
                                            value="<?=$CMSNT->site('domain_cardv2');?>"
                                            placeholder="Nhập link website cần đấu, họ phải dùng code cardv2 của CMSNT.CO"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">API Key</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="api_cardv2" value="<?=$CMSNT->site('api_cardv2');?>"
                                            placeholder="Nhập API Key" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_cardv2" required>
                                        <option value="<?=$CMSNT->site('status_cardv2');?>">
                                            <?=$CMSNT->site('status_cardv2');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH API V3 (liên hệ CMSNT.CO để được hỗ trợ về API này)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Link website cần đấu</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="domain_cardv3"
                                            value="<?=$CMSNT->site('domain_cardv3');?>"
                                            placeholder="Nhập link website cần đấu, họ phải dùng code giống thesieure"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Partner id</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="partner_id_cardv3" value="<?=$CMSNT->site('partner_id_cardv3');?>"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Partner key</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="partner_key_cardv3" value="<?=$CMSNT->site('partner_key_cardv3');?>"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_cardv3" required>
                                        <option value="<?=$CMSNT->site('status_cardv3');?>">
                                            <?=$CMSNT->site('status_cardv3');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH API V4 (liên hệ CMSNT.CO để được hỗ trợ về API này)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Link website cần đấu</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="domain_cardv4"
                                            value="<?=$CMSNT->site('domain_cardv4');?>"
                                            placeholder="Nhập link website cần đấu, họ phải dùng code giống dtnl"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">API Key</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="api_cardv4" value="<?=$CMSNT->site('api_cardv4');?>"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_cardv4" required>
                                        <option value="<?=$CMSNT->site('status_cardv4');?>">
                                            <?=$CMSNT->site('status_cardv4');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH API V5 (liên hệ CMSNT.CO để được hỗ trợ về API này)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Link website cần đấu</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="domain_cardv5"
                                            value="<?=$CMSNT->site('domain_cardv5');?>"
                                            placeholder="Nhập link website cần đấu, họ phải dùng bộ api cardv5"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Usercode</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="usercode_cardv5" placeholder="Tài khoản kết nối: sẽ cung cấp khi triển khai" value="<?=$CMSNT->site('usercode_cardv5');?>"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Userpass</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="userpass_cardv5" placeholder="userpass: sẽ cung cấp khi triển khai" value="<?=$CMSNT->site('userpass_cardv5');?>"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_cardv5" required>
                                        <option value="<?=$CMSNT->site('status_cardv5');?>">
                                            <?=$CMSNT->site('status_cardv5');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH CHIẾT KHẤU ĐỔI THẺ BRONZE</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <form action="" method="POST">
                            <div class="alert alert-info">
                                Set chiết khấu về 0 nếu bạn muốn bảo trì thẻ đó
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="10%">Loại thẻ</th>
                                            <th width="10%">Mệnh giá</th>
                                            <th width="10%">Trạng thái</th>
                                            <th>Chiết khấu (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;foreach($CMSNT->get_list(" SELECT * FROM `ck_card_auto` ") as $row) { ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><b style="color:blue;"><?=$row['loaithe'];?></b></td>
                                            <td><b style="color: red;"><?=format_cash($row['menhgia']);?>đ</b></td>
                                            <td><?=display_loaithe($row['ck']);?></td>
                                            <td>
                                                <input type="text" name="<?=$row['id'];?>" value="<?=$row['ck'];?>"
                                                    class="form-control">
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" name="btnSaveCk" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH CHIẾT KHẤU ĐỔI THẺ PLATINUM</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <form action="" method="POST">
                            <div class="alert alert-info">
                                Set chiết khấu về 0 nếu bạn muốn bảo trì thẻ đó
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="10%">Loại thẻ</th>
                                            <th width="10%">Mệnh giá</th>
                                            <th width="10%">Trạng thái</th>
                                            <th>Chiết khấu (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;foreach($CMSNT->get_list(" SELECT * FROM `ck_card_auto_platinum` ") as $row) { ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><b style="color:blue;"><?=$row['loaithe'];?></b></td>
                                            <td><b style="color: red;"><?=format_cash($row['menhgia']);?>đ</b></td>
                                            <td><?=display_loaithe($row['ck']);?></td>
                                            <td>
                                                <input type="text" name="<?=$row['id'];?>" value="<?=$row['ck'];?>"
                                                    class="form-control">
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" name="btnSaveCkplatinum" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH CHIẾT KHẤU ĐỔI THẺ DIAMOND</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <form action="" method="POST">
                            <div class="alert alert-info">
                                Set chiết khấu về 0 nếu bạn muốn bảo trì thẻ đó
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="10%">Loại thẻ</th>
                                            <th width="10%">Mệnh giá</th>
                                            <th width="10%">Trạng thái</th>
                                            <th>Chiết khấu (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;foreach($CMSNT->get_list(" SELECT * FROM `ck_card_auto_diamond` ") as $row) { ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><b style="color:blue;"><?=$row['loaithe'];?></b></td>
                                            <td><b style="color: red;"><?=format_cash($row['menhgia']);?>đ</b></td>
                                            <td><?=display_loaithe($row['ck']);?></td>
                                            <td>
                                                <input type="text" name="<?=$row['id'];?>" value="<?=$row['ck'];?>"
                                                    class="form-control">
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" name="btnSaveCkdiamond" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(function() {
    // Summernote
    $('.textarea').summernote()
})
</script>

<?php 
    require_once("../../public/admin/Footer.php");
?>