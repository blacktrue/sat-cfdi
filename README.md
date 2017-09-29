
# SAT-CFDI  

Obtiene el estatus de un CFDI ante la autoridad y entrega la evidencia.

## Instalacion por composer

```
composer require blacktrue/sat-cfdi
```

## Ejemplo de uso

```php
require "vendor/autoload.php";

use Blacktrue\CfdiValidator\Validator;

$satValidator = new Validator();

$response = $satValidator->setRfcEmisor('BMN930209927')
    ->setRfcRecpetor('AUAC920422D38')
    ->setUuid('B80052EB-3C91-4842-BA3C-DAEEDAC51F31')
    ->setPhantomBin('phantomjs')
    ->validate();
    
echo $response->getMessage(); //"Comprobante obtenido satisfactoriamente", "Recurso no encontrado, intente mas tarde."
echo $response->getEstate(); //No encontrado, Vigente, Cancelado
echo $response->getImage(); //Imagen en base64
echo $response->getFechaCancelacion(); //Si es cancelacion

```