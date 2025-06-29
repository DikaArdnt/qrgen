<?php
/**
 * QRGen - php QR Code generator
 * index.php
 *
 * PHP version 5.4+
 *
 * @category  PHP
 * @package   QRGen
 * @author    Dika Ardnt. <mail@dikaardnt.com>
 * @copyright 2025 Dika Ardnt.
 * @version   5.3.8
 * @link      https://qr.dikaardnt.com
 */
$version = '5.3.8';

if (version_compare(phpversion(), '5.4', '<')) {
    exit("QRGen requires at least PHP version 5.4");
}

// https://stackoverflow.com/questions/11920026/replace-file-get-contents-with-curl
if (!filter_var(ini_get('allow_url_fopen'), FILTER_VALIDATE_BOOLEAN)) {
    exit("Please enable <code>allow_url_fopen<code>");
}
if (!function_exists('mime_content_type')) {
    exit("Please enable the <code>fileinfo</code> extension");
}
// Update this path if you have a custom relative path inside config.php
require dirname(__FILE__) . "/lib/functions.php";

if (qrcdr()->getConfig('debug_mode')) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL ^ E_NOTICE);
}
$relative = qrcdr()->relativePath();
$absolute = qrcdr()->basePath();

require $absolute . '/include/head.php';
?>
<!doctype html>
<html lang="<?php echo $lang; ?>" dir="<?php echo $rtl['dir']; ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title><?php echo qrcdr()->getString('title'); ?></title>
    <meta name="description" content="<?php echo qrcdr()->getString('description'); ?>">
    <meta name="keywords" content="<?php echo qrcdr()->getString('tags'); ?>">
    
    <meta name="author" content="Dika Ardnt.">
    <meta name="copyright" content="Dika Ardnt.">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="<?php echo qrcdr()->getString('title'); ?>">
    <meta property="og:description" content="<?php echo qrcdr()->getString('description'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?php echo $relative; ?>images/qrgen.png">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?php echo qrcdr()->getString('title'); ?>">
    <meta property="twitter:description" content="<?php echo qrcdr()->getString('description'); ?>">
    <meta property="twitter:image" content="<?php echo $relative; ?>images/qrgen.png">
    
    <link rel="shortcut icon" href="<?php echo $relative; ?>images/favicon.ico">
    <link href="<?php echo $relative; ?>bootstrap/css/bootstrap<?php echo $rtl['css']; ?>.min.css" rel="stylesheet">
    <link href="<?php echo $relative; ?>css/font-awesome.min.css" rel="stylesheet">
    <script src="<?php echo $relative; ?>js/jquery-3.7.1.min.js"></script>
    <?php
    $custom_page = false;
    $body_class = '';
    if (isset($_GET['p'])) {
        $load_page = $absolute . '/template/' . $_GET['p'] . '.html';
        if (file_exists($load_page)) {
            $custom_page = file_get_contents($load_page);
        }
    }
    qrcdr()->loadQRGenCSS($version);
    if (!$custom_page) {
        $body_class = 'qrcdr';
        qrcdr()->loadPluginsCss();
    }
    qrcdr()->setMainColor(qrcdr()->getConfig('color_primary'));
    ?>
</head>

<body class="<?php echo $body_class; ?>">
    <?php
    if (file_exists($absolute . '/template/navbar.php')) {
        include $absolute . '/template/navbar.php';
    }
    if (file_exists($absolute . '/template/header.php')) {
        include $absolute . '/template/header.php';
    }
    if ($custom_page) {
        echo '<div class="container mt-4">' . $custom_page . '</div>';
    } else {
        // Generator
        include $absolute . '/include/generator.php';
    }
    qrcdr()->loadQRGenJS($version);

    if (!$custom_page) {
        qrcdr()->loadPlugins();
    }
    if (file_exists($absolute . '/template/footer.php')) {
        include $absolute . '/template/footer.php';
    }
    ?>
</body>

</html>