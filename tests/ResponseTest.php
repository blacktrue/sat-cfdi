<?php

use Blacktrue\CfdiValidator\Response;

class ResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Blacktrue\CfdiValidator\Response
     */
    protected $response;

    public function setUp()
    {
        $this->response = new Response([
            'fechaCancelacion' => '',
            'estate' => 'Vigente',
            'message' => 'Comprobante obtenido satisfactoriamente'
        ]);
    }

    public function testGetEmptyFechaCancelacion()
    {
        $fechaCancelacion = $this->response->getFechaCancelacion();
        $this->assertNull($fechaCancelacion);
    }

    public function testGetFillFechaCancelacion()
    {
        $fechaCancelacion = (new Response([
            'fechaCancelacion' => '2016-04-21 14:22:54'
        ]))->getFechaCancelacion();

        $this->assertInstanceOf(DateTime::class, $fechaCancelacion);
    }

    public function testGetEstate()
    {
        $estate = $this->response->getEstate();
        $this->assertSame('Vigente', $estate);
    }

    public function testGetMessage()
    {
        $message = $this->response->getMessage();
        $this->assertSame('Comprobante obtenido satisfactoriamente', $message);
    }
}