<?php

/**
 * Created by PhpStorm.
 * Author: mingbai
 * Date: 19-4-11
 * Time: 下午5:29
 */

namespace DynamicQrCode;

use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;

class DynamicQrCode
{
    protected $_qr;
    protected $_encoding = 'UTF-8';
    protected $_size = 300;
    protected $_logo = false;
    protected $_logo_url = '';
    protected $_logo_size = 80;
    protected $_title = false;
    protected $_title_content = '';
    const MARGIN = 10;
    const WRITE_NAME = 'png';
    const FOREGROUND_COLOR = ['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0];
    const BACKGROUND_COLOR = ['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0];

    public function __construct($config = array())
    {
        isset($config['encoding']) && $this->_encoding = $config['encoding'];
        isset($config['size']) && $this->_size = $config['size'];
        isset($config['display']) && $this->_size = $config['size'];
        isset($config['logo']) && $this->_logo = $config['logo'];
        isset($config['logo_url']) && $this->_logo_url = $config['logo_url'];
        isset($config['logo_size']) && $this->_logo_size = $config['logo_size'];
        isset($config['title']) && $this->_title = $config['title'];
        isset($config['title_content']) && $this->_title_content = $config['title_content'];
    }

    /**
     * 生成二维码
     * @param string $content 需要写入的内容
     * @return string
     */
    public function toDynamicQrCode($content = '')
    {
        $this->_qr = new QrCode($content);
        $this->_qr->setSize($this->_size);
        $this->_qr->setWriterByName(self::WRITE_NAME);
        $this->_qr->setMargin(self::MARGIN);
        $this->_qr->setEncoding($this->_encoding);
        $this->_qr->setForegroundColor(self::FOREGROUND_COLOR);
        $this->_qr->setBackgroundColor(self::BACKGROUND_COLOR);
        if ($this->_title) {
            $this->_qr->setLabel($this->_title_content, 16, '字体地址', LabelAlignment::CENTER);
        }
        if ($this->_logo) {
            $this->_qr->setLogoPath($this->_logo_url);
            $this->_qr->setLogoWidth($this->_logo_size);
            $this->_qr->setRoundBlockSize(true);
        }
        $this->_qr->setValidateResult(false);

        header('Content-Type: ' . $this->_qr->getContentType());
        return $this->_qr->writeString();
    }
}