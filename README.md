
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

$data = (new Validator([
    "rfcEmisor" => "XAXX010101000",
    "rfcReceptor" => "XAXX010101000",
    "uuid" => "B0020E00-0C5E-41D5-996B-AB7804E82810"
]))->setPath('./') //Carpeta donde se guardara la imagen
    ->setPhantomBin('phantomjs') //Binario de phantomjs
    ->validate(); // Ejecutar validacion

print_r($data);

```