<?php


if(isset($_SESSION['username']))
{
    $getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."' ");
    if(!$getUser)
    {
        header("location: ".BASE_URL('Auth/Logout'));
        exit();
    }
    if($getUser['banned'] != 0)
    {
        echo 'Tài khoản của bạn đã bị khóa bởi quản trị viên !';
        header("location: ".BASE_URL('Auth/Logout'));
        exit();
    }
    if($getUser['money'] < 0)
    {
        $CMSNT->update("users", array(
            'banned' => 1
        ), "username = '".$getUser['username']."' ");
        die('Tài khoản của bạn đã bị khóa tự động bởi hệ thống');
    }
}
else
{
    header("location: ".BASE_URL('Auth/Login'));
    exit();
}