<?php
/**
 * QRGen - php QR Code generator
 * ajax/create.php
 *
 * PHP version 5.4+
 *
 * @category  PHP
 * @package   QRGen
 * @author    Dika Ardnt. <mail@dikaardnt.com>
 * @copyright 2025 Dika Ardnt.
 * @link      https://qr.dikaardnt.com
 */
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
) {
    exit;
}

$data = isset($_POST['create']) ? $_POST['create'] : false;

if ($data) {
    require dirname(dirname(__FILE__)).'/lib/functions.php';
    $qrcodes_dir = qrcdr()->getConfig('qrcodes_dir');
    $decoded = json_decode($data);
    $svgheader = '<?xml version="1.0" encoding="utf-8"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
    $precontent = $svgheader.$decoded->content;
    
    if (class_exists('DOMDocument') && class_exists('XSLTProcessor')) {
        $xsl = new DOMDocument;
        $xsl->load('sanitize.xsl');
        $proc = new XSLTProcessor;
        $proc->importStyleSheet($xsl);
        $xml = simplexml_load_string($precontent);
        $content = $proc->transformToXML($xml);
    } else {
        $content = $precontent;
    }

    $basename = filter_var($decoded->basename, FILTER_SANITIZE_SPECIAL_CHARS);

    if ($content && $basename) {
        $filedir = $qrcodes_dir;
        $filename_path = '../'.$filedir.'/'.$basename.'.svg';
        try {
            $handle = fopen($filename_path, "w");
            fwrite($handle, $content);
            fclose($handle);
        } catch (Exception $e) {
            $response = array('error' => 'Exception: ', $e->getMessage());
            echo json_encode($response);
            exit;
        }
        $response = array(
            'basename' => $basename,
            'filedir' => qrcdr()->relativePath().$qrcodes_dir,
        );
        echo json_encode($response);
    } else {
        $response = array('error' => 'Creation failed');
        echo json_encode($response);
    }
}
exit;
