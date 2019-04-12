<?php
/**
 * Created by PhpStorm.
 * Author: mingbai
 * Date: 19-4-12
 * Time: 下午3:10
 */
require_once './vendor/autoload.php';
use DynamicQrCode\DynamicQrCode;
echo DynamicQrCode::toQrCode('https://fx.diancang.site/activity/readbook');