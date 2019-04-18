<?php

/**
 * Created by PhpStorm.
 * Author: mingbai
 * Date: 19-4-11
 * Time: 下午5:29
 */

namespace DynamicQrCode;

class DynamicQrCode
{
    /**
     * 在生成的二维码中加上logo(生成图片文件)
     * @param string $url
     * @param string $path
     * @param string $logo
     * @return string
     */
    public function toErWeiMa($url = '', $path = '', $logo = '')
    {
        require_once 'phpqrcode.php';
        $value = $url;         //二维码内容
        $errorCorrectionLevel = 'H';  //容错级别
        $matrixPointSize = 6;      //生成图片大小
        //生成二维码图片
        $filename = preg_replace('#/$#', '', $path) . '/qrcode.png';
        \QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        $QR = $filename;      //已经生成的原始二维码图
        $QR = imagecreatefromstring(file_get_contents($QR));    //目标图象连接资源。
        if (file_exists($logo)) {
            $logo = imagecreatefromstring(file_get_contents($logo));  //源图象连接资源。
            $QR_width = imagesx($QR);      //二维码图片宽度
            $logo_width = imagesx($logo);    //logo图片宽度
            $logo_height = imagesy($logo);   //logo图片高度
            $logo_qr_width = $QR_width / 4;   //组合之后logo的宽度(占二维码的1/5)
            $scale = $logo_width / $logo_qr_width;  //logo的宽度缩放比(本身宽度/组合后的宽度)
            $logo_qr_height = $logo_height / $scale; //组合之后logo的高度
            $from_width = ($QR_width - $logo_qr_width) / 2;  //组合之后logo左上角所在坐标点
            //重新组合图片并调整大小
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
            imagedestroy($logo);
        }
        //输出图片
        imagepng($QR, $filename);
        imagedestroy($QR);
        return '<img src="' . $filename . '" alt="">';
    }

    /**
     * 生成二维码（不带文件）
     * @param $url
     * @return array
     */
    public function toErWeiMaNotFile($url = '')
    {
        require_once 'phpqrcode.php';
        $value = $url;         //二维码内容
        $errorCorrectionLevel = 'H';  //容错级别
        $matrixPointSize = 6;      //生成图片大小
        //打开缓冲区
        ob_start();
        //生成二维码图片
        \QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize, 2);
        //这里就是把生成的图片流从缓冲区保存到内存对象上，使用base64_encode变成编码字符串，通过json返回给页面。
        $imageString = base64_encode(ob_get_contents());
        //关闭缓冲区
        ob_end_clean();
        $base64 = "data:image/png;base64," . $imageString;
        $result['code'] = 0;
        $result['msg'] = 'ok';
        $result['data'] = $base64;
        return $result;
    }
}
