<?php 
    require_once(__DIR__."/../../../config/config.php");
    require_once(__DIR__."/../../../config/function.php");
    require_once(__DIR__."/../../../includes/login-admin.php");

    echo getMoney_momo($CMSNT->site('token_momo'));