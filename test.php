<?php
/**
 * Created by PhpStorm.
 * Author: mingbai
 * Date: 19-4-12
 * Time: 下午3:10
 */
require_once './vendor/autoload.php';
use DynamicQrCode\DynamicQrCode;
$result =  DynamicQrCode::toDynamicQrCodePng('https://fx.diancang.site/activity/readbook');
echo '<img src="'.$result.'"/>';