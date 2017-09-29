<?php

class CfdiValidator extends \PHPUnit\Framework\TestCase
{
    public function testCfdiValidatorWithoutParameter ()
    {
        $this->expectException(InvalidArgumentException::class);
        $satValidator = new \Blacktrue\CfdiValidator\Validator();

        $satValidator->setRfcEmisor('BMN930209927')
            ->setRfcRecpetor('AUAC920422D38')
            ->setPhantomBin('phantomjs')
            ->validate();
    }

    public function testCfdiValidatorSuccess ()
    {
        $satValidator = new \Blacktrue\CfdiValidator\Validator();

        $response = $satValidator->setRfcEmisor('BMN930209927')
            ->setRfcRecpetor('AUAC920422D38')
            ->setUuid('B80052EB-3C91-4842-BA3C-DAEEDAC51F31')
            ->setPhantomBin('phantomjs')
            ->validate();

        $this->assertInstanceOf(\Blacktrue\CfdiValidator\Response::class, $response);
        $this->assertEquals('Comprobante obtenido satisfactoriamente', $response->getMessage());
        $this->assertEquals('Vigente', $response->getEstate());
    }

    public function testCfdiValidatorImage ()
    {
        $satValidator = new \Blacktrue\CfdiValidator\Validator();

        $response = $satValidator->setRfcEmisor('BMN930209927')
            ->setRfcRecpetor('AUAC920422D38')
            ->setUuid('B80052EB-3C91-4842-BA3C-DAEEDAC51F31')
            ->setPhantomBin('phantomjs')
            ->setPath('./tests/images')
            ->validate();

        $this->assertNotEmpty($response->getImage());
    }
}