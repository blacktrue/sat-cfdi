<?php

use Blacktrue\CfdiValidator\ScreenShot as WebShot;

class ScreenShotTest extends \PHPUnit\Framework\TestCase
{
    public function testSuccessScreenShot()
    {
        $file = WebShot::capture('http://google.com', './tests/images', 'phantomjs');
        $this->assertFileExists($file);
    }

    public function testFailedScreenShot()
    {
        $file = WebShot::capture('algo', './tests/images', 'phantomjs');
        $this->assertSame('ERROR_NO_CONTENT', $file);
    }
}