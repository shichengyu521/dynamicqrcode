<?php

/**
 * Created by PhpStorm.
 * Author: mingbai
 * Date: 19-4-11
 * Time: 下午5:29
 */

namespace DynamicQrCode;

include 'phpqrcode/phpqrcode.php';

class DynamicQrCode
{
    /**
     * 生成二维码图片
     * @param string $value 需要写入的内容
     * @param string $logo logo地址
     * @return string
     */
    public static function toDynamicQrCodePng($value = '', $logo = '')
    {
        $errorCorrectionLevel = 'L';//容错级别
        $matrixPointSize = 6;//生成图片大小
        //生成二维码图片
        \QRcode::png($value, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);
        $QR = 'qrcode.png';//已经生成的原始二维码图
        if (!$logo) {
            return '<img src="qrcode.png">';
        }
        $QR = imagecreatefromstring(file_get_contents($QR));
        $logo = imagecreatefromstring(file_get_contents($logo));
        $QR_width = imagesx($QR);//二维码图片宽度
        $logo_width = imagesx($logo);//logo图片宽度
        $logo_height = imagesy($logo);//logo图片高度
        $logo_qr_width = $QR_width / 5;
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;
        $from_width = ($QR_width - $logo_qr_width) / 2;
        //重新组合图片并调整大小
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
            $logo_qr_height, $logo_width, $logo_height);
        //输出图片
        imagepng($QR, 'qr_code.png');
        return '<img src="qr_code.png">';
    }
}
