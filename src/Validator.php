<?php

namespace Blacktrue\CfdiValidator;

use InvalidArgumentException;

/**
 * Class Validator.
 */
class Validator
{
    const URL_IMAGE_SAT = 'https://verificacfdi.facturaelectronica.sat.gob.mx/?ctl00%24ScriptManager1=ctl00%24MainContent%24UpnlBusqueda%7Cctl00%24MainContent%24BtnBusqueda&__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=oOVGK5DcCmE63Ir1voYI3TTrH17eLaKCNV0sifrNM%2Ftirsq%2F%2Bbt1k%2FhJK5s0%2FLAq%2FrG06rMeea%2FiTp75mKD61DAMo1l8WrazG%2BWFdIeiHtDJnUM37rVvxvOkyhL%2FkE68z9IbnQqgAOG4eUYTahgUuIordYZcpLqKJFSeW%2FBNG4p94HuE5k2m%2BNCf3vKLI5cXBa0ke7lK0hFo6HbgZkWNlrXd7QoOYTyMTldd8Ks9iCDMLgxRH%2BXK4yarZ0k5s7MWM5Q6gx0xDdofTKTHyxG%2F9c3s31LgpKl7IYK0pklkNUkaktypYXqDK8bG4TTtbY7ZlepiW8k0zOcdDaRHd6X7JnZRmFO258HzrKDazUnhk63z4bhc&__VIEWSTATEGENERATOR=CA0B0334&__VIEWSTATEENCRYPTED=&ctl00%24MainContent%24TxtUUID=<%uuid%>&ctl00%24MainContent%24TxtRfcEmisor=<%rfcEmisor%>&ctl00%24MainContent%24TxtRfcReceptor=<%rfcReceptor%>&ctl00%24MainContent%24TxTCaptchaNumbers=20255&__ASYNCPOST=true&ctl00%24MainContent%24BtnBusqueda=Verificar%20CFDI';

    /**
     * @var
     */
    protected $fechaCancelacion;

    /**
     * @var
     */
    protected $message;

    /**
     * @var
     */
    protected $estate;

    /**
     * @var
     */
    protected $rfcEmisor;

    /**
     * @var
     */
    protected $rfcReceptor;

    /**
     * @var
     */
    protected $uuid;

    /**
     * @var mixed
     */
    protected $path;

    /**
     * @var string
     */
    protected $phantomBin;

    /**
     * @param string $rfcEmisor
     *
     * @return Validator
     */
    public function setRfcEmisor(string $rfcEmisor): Validator
    {
        $this->rfcEmisor = @utf8_encode($rfcEmisor);

        return $this;
    }

    /**
     * @param string $rfcReceptor
     *
     * @return Validator
     */
    public function setRfcRecpetor(string $rfcReceptor): Validator
    {
        $this->rfcReceptor = @utf8_encode($rfcReceptor);

        return $this;
    }

    /**
     * @param string $uuid
     *
     * @return Validator
     */
    public function setUuid(string $uuid): Validator
    {
        $this->uuid = $uuid;

        return $this;
    }



    /**
     * @param $path
     *
     * @return Validator
     */
    public function setPath($path) : Validator
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException('El directorio especificado no existe');
        }

        $this->path = $path;

        return $this;
    }

    /**
     * @param $phantomBin
     *
     * @return Validator
     */
    public function setPhantomBin(string $phantomBin) : Validator
    {
        $this->phantomBin = $phantomBin;

        return $this;
    }

    /**
     * @return string
     */
    public function getFechaCancelacion(): string
    {
        return $this->fechaCancelacion;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getEstate(): string
    {
        return $this->estate;
    }

    private function validateParams() : void
    {
        $params = ['rfcEmisor', 'rfcReceptor', 'uuid'];
        foreach ($params as $param) {
            if (empty($this->{$param}) || !$this->{$param}) {
                throw new InvalidArgumentException("El atributo {$param} es requerido");
            }
        }
    }

    /**
     * @return Response
     */
    public function validate() : Response
    {
        $this->validateParams();
        $data = Scraper::getData($this->generateUrl());
        $this->message = $data['message'];
        $this->estate = $data['estate'];
        $this->fechaCancelacion = $data['fechaCancelacion'];

        return new Response($this);
    }

    /**
     * @return string
     */
    public function generateUrl() : string
    {
        return str_replace(
            ['<%rfcEmisor%>', '<%rfcReceptor%>', '<%uuid%>'],
            [$this->rfcEmisor, $this->rfcReceptor, $this->uuid],
            Validator::URL_IMAGE_SAT
        );
    }

    /**
     * @return string
     */
    public function generateImage() : string
    {
        $fileName = ScreenShot::capture($this->generateUrl(), $this->path, $this->phantomBin);

        return base64_encode(@file_get_contents($fileName));
    }
}
