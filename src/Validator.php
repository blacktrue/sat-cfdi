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
     * @var array
     */
    protected $params = [];

    /**
     * @var mixed
     */
    protected $path;

    /**
     * @var
     */
    protected $url;

    /**
     * @var string
     */
    protected $phantomBin;

    /**
     * Validator constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
        $this->phantomBin = ScreenShot::PHANTOM_BIN_DEFAULT;

        if (!isset($this->params['rfcEmisor'])) {
            throw new InvalidArgumentException('RFC Emisor es requerido');
        }
        if (!isset($this->params['rfcReceptor'])) {
            throw new InvalidArgumentException('RFC Receptor es requerido');
        }
        if (!isset($this->params['uuid'])) {
            throw new InvalidArgumentException('UUID es requerido');
        }
    }

    /**
     * @param $path
     *
     * @throws InvalidArgumentException
     *
     * @return $this
     */
    public function setPath($path)
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
     * @return $this
     */
    public function setPhantomBin($phantomBin)
    {
        $this->phantomBin = $phantomBin;

        return $this;
    }

    /**
     * @return array
     */
    public function validate()
    {
        try {
            $rfc_emisor = utf8_encode(@$this->params['rfcEmisor']);
            $rfc_receptor = utf8_encode(@$this->params['rfcReceptor']);
            $uuid = $this->params['uuid'];

            $this->makeUrlScraping($rfc_emisor, $rfc_receptor, $uuid);

            $dataValidation = Scraper::getData($this->url);

            return [
                'success' => true,
                'codeSat' => $dataValidation['message'],
                'estate' => $dataValidation['estate'],
                'fechaCancelacion' => $dataValidation['fechaCancelacion'],
                'img' => $this->getImg(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param $rfcEmisor
     * @param $rfcReceptor
     * @param $uuid
     */
    private function makeUrlScraping($rfcEmisor, $rfcReceptor, $uuid)
    {
        $this->url = str_replace([
            '<%rfcEmisor%>',
            '<%rfcReceptor%>',
            '<%uuid%>',
        ], [
            $rfcEmisor,
            $rfcReceptor,
            $uuid,
        ], self::URL_IMAGE_SAT);
    }

    /**
     * @return mixed
     */
    private function getImg()
    {
        $fileName = ScreenShot::capture($this->url, $this->path, $this->phantomBin);

        return base64_encode(@file_get_contents($fileName));
    }
}
