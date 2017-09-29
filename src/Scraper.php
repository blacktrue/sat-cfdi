<?php

namespace Blacktrue\CfdiValidator;

use Sunra\PhpSimple\HtmlDomParser;

class Scraper
{
    /**
     * @param string $url
     *
     * @return array
     */
    public static function getData(string $url) : array
    {
        $data = [];

        $html = file_get_contents($url);
        $dom = HtmlDomParser::str_get_html($html);

        $data['fechaCancelacion'] = '';

        if (strpos($html, 'ctl00_MainContent_LblFechaCancelacion') !== false) {
            $elements = $dom->find('#ctl00_MainContent_LblFechaCancelacion');
            $fechaCancelacion = trim($elements[0]->text());

            $elements = $dom->find('#ctl00_MainContent_LblEstado');
            $data['estate'] = trim($elements[0]->text());

            if (!empty($fechaCancelacion)) {
                $date = (string) $fechaCancelacion;
                $data['fechaCancelacion'] = \DateTime::createFromFormat('d/m/Y H:i:s', $date)->format('Y-m-d H:i:s');
            }

            $data['message'] = 'Comprobante obtenido satisfactoriamente';

            return $data;
        }

        $data['message'] = 'Recurso no encontrado, intente mas tarde.';
        $data['estate'] = 'No encontrado';

        return $data;
    }
}
