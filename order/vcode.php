<?php

/**
 *******************************************************************
 ************* ─────────────────── **************
 ************* ──  WFPHP在线订单系统官方正式版 ── **************
 ************* ─────────────────── **************
 ************* 官方网站：http://www.wf1805.cn/        **************
 ************* 官方店铺：http://889889.taobao.com/    **************
 ************* 程序开发：WENFEI                       **************
 ************* 客户服务：[淘宝旺旺] yygynui613        **************
 ************* 技术支持：[腾讯QQ] 183712356           **************
 *******************************************************************
 */

Header("Content-type: image/gif");
$border = 0;
$how = 4;
$w = $how*15;
$h = 20;
$fontsize = 12;
$alpha = "12345";
$number = "67890";
$randcode = "";
srand((double)microtime()*1000000);
$im = ImageCreate($w, $h);
$bgcolor = ImageColorAllocate($im, 255, 255, 255);
ImageFill($im, 0, 0, $bgcolor);
if($border){
    $black = ImageColorAllocate($im, 0, 0, 0);
    ImageRectangle($im, 0, 0, $w-1, $h-1, $black);
}
for($i=0; $i<$how; $i++){   
    $alpha_or_number = mt_rand(0, 1);
    $str = $alpha_or_number ? $alpha : $number;
    $which = mt_rand(0, strlen($str)-1);
    $code = substr($str, $which, 1);
    $j = !$i ? 4 : $j+15;
    $color3 = ImageColorAllocate($im, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
    ImageChar($im, $fontsize, $j, 3, $code, $color3);
    $randcode .= $code;
}
for($i=0; $i<5; $i++){   
    $color1 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
    ImageArc($im, mt_rand(-5,$w), mt_rand(-5,$h), mt_rand(20,300), mt_rand(20,200), 33, 22, $color1);
}   
for($i=0; $i<$how*10; $i++){   
    $color2 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
    ImageSetPixel($im, mt_rand(0,$w), mt_rand(0,$h), $color2);
}
session_start();
$_SESSION['wfcode'] = $randcode;
ImagePNG($im);
ImageDestroy($im);

?>