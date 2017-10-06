<?php

use Blacktrue\CfdiValidator\Scraper;

class ScraperTest extends \PHPUnit\Framework\TestCase
{
    public function testVigente()
    {
        $data = Scraper::getData('./tests/resources/cfdivigente.html');
        $this->assertSame('Vigente', $data['estate']);
        $this->assertSame('Comprobante obtenido satisfactoriamente', $data['message']);
    }

    public function testCancelado()
    {
        $data = Scraper::getData('./tests/resources/cfdicancelado.html');
        $this->assertSame('2016-08-01 13:24:10', $data['fechaCancelacion']);
        $this->assertSame('Cancelado', $data['estate']);
        $this->assertSame('Comprobante obtenido satisfactoriamente', $data['message']);
    }

    public function testNoEncontrado()
    {
        $data = Scraper::getData('./tests/resources/cfdinoencontrado.html');
        $this->assertSame('No encontrado', $data['estate']);
        $this->assertSame('Recurso no encontrado, intente mas tarde.', $data['message']);
    }
}