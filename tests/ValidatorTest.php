<?php

use Blacktrue\CfdiValidator\Validator;

class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Validator
     */
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testSetRfcEmisor()
    {
        $instance = $this->validator->setRfcEmisor('BMN930209927');
        $this->assertInstanceOf(Validator::class, $instance);
    }

    public function testSetRfcReceptor()
    {
        $instance = $this->validator->setRfcRecpetor('AUAC920422D38');
        $this->assertInstanceOf(Validator::class, $instance);
    }

    public function testSetUuid()
    {
        $instance = $this->validator->setUuid('B80052EB-3C91-4842-BA3C-DAEEDAC51F31');
        $this->assertInstanceOf(Validator::class, $instance);
    }

    public function testSetPhantomBin()
    {
        $instance = $this->validator->setPhantomBin('phantomjs');
        $this->assertInstanceOf(Validator::class, $instance);
    }

    public function testSetPathExists()
    {
        $instance = $this->validator->setPath('./tests/images');
        $this->assertInstanceOf(Validator::class, $instance);
    }

    public function testSetPathNotExists()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El directorio especificado no existe');
        $this->validator->setPath('./algo');
    }

    public function testValidateWithoutParameter ()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->validator->setRfcEmisor('BMN930209927')
            ->setRfcRecpetor('AUAC920422D38')
            ->setPhantomBin('phantomjs')
            ->validate();
    }

    public function testValidateCfdiVigenteSuccess ()
    {
        $response = $this->validator->setRfcEmisor('BMN930209927')
            ->setRfcRecpetor('AUAC920422D38')
            ->setUuid('B80052EB-3C91-4842-BA3C-DAEEDAC51F31')
            ->setPhantomBin('phantomjs')
            ->validate();

        $this->assertInstanceOf(\Blacktrue\CfdiValidator\Response::class, $response);
        $this->assertEquals('Comprobante obtenido satisfactoriamente', $response->getMessage());
        $this->assertEquals('Vigente', $response->getEstate());
        $this->assertNull($response->getFechaCancelacion());
    }

    public function testValidateGenerateImage ()
    {
        $image = $this->validator->setRfcEmisor('BMN930209927')
            ->setRfcRecpetor('AUAC920422D38')
            ->setUuid('B80052EB-3C91-4842-BA3C-DAEEDAC51F31')
            ->setPhantomBin('phantomjs')
            ->setPath('./tests/images')
            ->generateImage();

        $this->assertNotEmpty($image);
    }
}