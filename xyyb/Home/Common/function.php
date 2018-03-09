<?php
/**
 * Created by PhpStorm.
 * User: 沈磊
 * Date: 2018/3/8
 * Time: 14:21
 */


function checkIsLogin(){

    //是否存在token
    if (empty($_SESSION['token'])) {
      return false;
    }
    else {
        import('Vendor.phpjwt.src.JWT','','.php');
        $v=new \Firebase\JWT\JWT();
        $jwt=$v::decode($_SESSION['token'],C('JWT_KEY'),array(C('JWT_ALG')));
        if ($jwt) {
            return true;
        }
        else {
            return false;
        }

    }


}