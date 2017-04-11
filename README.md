
# SAT-CFDI  

Obtiene el estatus de un CFDI ante la autoridad y entrega la evidencia.

## Instalacion por composer

```
composer require blacktrue/sat-cfdi
```

## Ejemplo de uso

```php
require "vendor/autoload.php";

use Blacktrue\Validator;

print_r((new Validator([
    "rfcEmisor" => "AAXHUI789D34",
    "rfcReceptor" => "AAXXU2789D34",
    "importe" => 1720.00,
    "uuid" => "A841F995-C6AF-4088-8CAC-8D5F5680229B"
]))->setPath('./')->validate());

```