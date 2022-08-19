<?php 
    require_once(__DIR__."/../../../config/config.php");
    require_once(__DIR__."/../../../config/function.php");
    require_once(__DIR__."/../../../includes/login-admin.php");

    if(isset($_POST['id']))
    {
        $id = check_string($_POST['id']);
        $data = $CMSNT->get_row("SELECT * FROM `storecards` WHERE `id` = '$id' ");
        if(!$data)
        {
            $data = json_encode([
                'status'    => 'error',
                'msg'       => 'Thẻ này không tồn tại trong hệ thống'
            ]);
            die($data);
        }
        $isRemove = $CMSNT->remove("storecards", " `id` = '$id' ");
        if($isRemove)
        {
            $data = json_encode([
                'status'    => 'success',
                'msg'       => 'Xóa thẻ thành công.'
            ]);
            die($data);
        }
    }
    else
    {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'Xóa thẻ thất bại.'
        ]);
        die($data);
    }