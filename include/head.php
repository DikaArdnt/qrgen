<?php
/**
 * QRGen - php QR Code generator
 * head.php
 *
 * PHP version 5.4+
 *
 * @category  PHP
 * @package   QRGen
 * @author    Dika Ardnt. <mail@dikaardnt.com>
 * @copyright 2025 Dika Ardnt.
 * @link      https://qr.dikaardnt.com
 */
date_default_timezone_set('UTC');

qrcdr()->init();
qrcdr()->setLayout();

$lang = qrcdr()->getLang();

if (file_exists(dirname(dirname(__FILE__)).'/translations/'.$lang.'.php')) {
    include dirname(dirname(__FILE__)).'/translations/'.$lang.'.php';
}

$getsection = qrcdr()->getConfig('default_tab', '#link');
$optionlogo = 'none';

$PNG_TEMP_DIR = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.qrcdr()->getConfig('qrcodes_dir').DIRECTORY_SEPARATOR;
$PNG_WEB_DIR = qrcdr()->relativePath().qrcdr()->getConfig('qrcodes_dir').'/';

if (!file_exists($PNG_TEMP_DIR)) {
    mkdir($PNG_TEMP_DIR);
}

$sizearray = array(
    '200' => 8,
    '300' => 12,
    '400' => 16,
    '500' => 20,
    '600' => 24,
    '700' => 28,
    '800' => 32,
);

// $matrixPointSize = 24; // 8 = 200px, 12 = 300px, 16 = 400px, 20 = 500px, 24 = 600px, 28 = 700px, 32 = 800px
$matrixPointSize = $sizearray[qrcdr()->getConfig('default_size', '800')]; // 8 = 200px, 12 = 300px, 16 = 400px, 20 = 500px, 24 = 600px, 28 = 700px, 32 = 800px

$errorCorrectionLevel = qrcdr()->getConfig('precision', 'Q'); // available: L, M, Q, H
$stringbackcolor = qrcdr()->getConfig('qr_bgcolor');
$stringfrontcolor = qrcdr()->getConfig('qr_color');
$output_data = false;

if (qrcdr()->getConfig('delete_old_files')) {
    $lifetime = qrcdr()->getConfig('file_lifetime');
    qrcdr()->deleteOldFiles($PNG_WEB_DIR, ($lifetime*3600), 'svg');
    qrcdr()->deleteOldFiles($PNG_WEB_DIR, ($lifetime*3600), 'png');
}

$rounded_btn_options = qrcdr()->getConfig('rounded_buttons');
$rounded_btn_options = $rounded_btn_options === true ? '["tabnav", "options", "save"]' : $rounded_btn_options;
$rounded_btn_options = $rounded_btn_options ? json_decode($rounded_btn_options) : array();
$rounded_btn_opt = in_array('options', $rounded_btn_options) ? ' rounded-pill' : '';
$rounded_btn_save = in_array('save', $rounded_btn_options) ? ' rounded-pill' : ' rounded-0';
$rounded_btn_nav = in_array('tabnav', $rounded_btn_options) ? ' rounded-pill' : '';
require dirname(dirname(__FILE__)).'/lib/countrycodes.php';
$rtl = qrcdr()->isRtl();

$active_options = is_array(qrcdr()->getConfig('options')) ? qrcdr()->getConfig('options') : array('colors', 'design', 'logo', 'frame', 'options');

