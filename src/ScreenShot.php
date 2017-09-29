<?php

namespace Blacktrue\CfdiValidator;

use hotrush\Webshotter\Webshot;

/**
 * Class ScreenShot.
 */
class ScreenShot
{
    const PHANTOM_BIN_DEFAULT = '/usr/local/bin/phantomjs';

    /**
     * @param string $url
     * @param string $path
     * @param string $phantomBin
     *
     * @return string
     */
    public static function capture($url, $path, $phantomBin)
    {
        try {
            $browser = new Webshot($phantomBin);

            return $browser
                ->setUrl($url)
                ->setWidth(800)
                ->setHeight(600)
                ->setTimeout(300)
                ->setFullPage(true)
                ->saveToPng(md5($url), $path);
        } catch (\Exception $e) {
            return 'ERROR_NO_CONTENT';
        }
    }
}
