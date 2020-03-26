<p align="center">
    <a href="https://www.mangoweb.cz/en/" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/38423357?s=200&v=4"/>
    </a>
</p>
<h1 align="center">
    Česká Pošta Balíkomaty Plugin
    <br />
    <a href="https://packagist.org/packages/mangoweb-sylius/sylius-ceska-posta-balikomaty-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/mangoweb-sylius/sylius-ceska-posta-balikomaty-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/mangoweb-sylius/sylius-ceska-posta-balikomaty-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/mangoweb-sylius/sylius-ceska-posta-balikomaty-plugin.svg" />
    </a>
    <a href="https://travis-ci.org/mangoweb-sylius/SyliusCeskaPostaBalikomatyPlugin" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/mangoweb-sylius/SyliusCeskaPostaBalikomatyPlugin/master.svg" />
    </a>
</h1>

## Features

 - Adds shipment type *Česká Pošta Balíkomat* branch which allows sending ordered products to selected Česká Pošta Balíkomat branch.
 - The user can choose the Česká Pošta Balíkomat branch during checkout in the Shipment step.
 - See Česká Pošta Balíkomat branch in final checkout step and also in the admin panel.
 - Export CSV with the Česká Pošta Balíkomat shipments and import it easily into Česká Pošta Balíkomaty's system.

## Installation

1. Run `$ composer require mangoweb-sylius/sylius-ceska-posta-balikomaty-plugin`.
1. Add plugin classes to your `config/bundles.php`:
 
   ```php
   return [
      ...
      MangoSylius\ShipmentExportPlugin\MangoSyliusShipmentExportPlugin::class => ['all' => true],
      MangoSylius\SyliusCeskaPostaBalikomatyPlugin\MangoSyliusCeskaPostaBalikomatyPlugin::class => ['all' => true],
   ];
   ```
  
1. Add resource to `config/packeges/_sylius.yaml`

    ```yaml
    imports:
         ...
         - { resource: "@MangoSyliusCeskaPostaBalikomatyPlugin/Resources/config/resources.yml" }
    ```
   
1. Add routing to `config/_routes.yaml`

    ```yaml
    mango_sylius_ceska_posta_balikomaty_plugin:
        resource: '@MangoSyliusCeskaPostaBalikomatyPlugin/Resources/config/routing.yml'
        prefix: /admin
   
    mango_sylius_shipment_export_plugin:
        resource: '@MangoSyliusShipmentExportPlugin/Resources/config/routing.yml'
        prefix: /admin
    ```
   
1. Your Entity `Shipment` has to implement `\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShipmentInterface`. 
   You can use the trait `\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShipmentTrait`.
 
   ```php
   <?php 
   
   declare(strict_types=1);
   
   namespace App\Entity\Shipping;
   
   use Doctrine\ORM\Mapping as ORM;
   use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShipmentInterface;
   use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShipmentTrait;
   use Sylius\Component\Core\Model\Shipment as BaseShipment;
   
   /**
    * @ORM\Entity
    * @ORM\Table(name="sylius_shipment")
    */
   class Shipment extends BaseShipment implements CeskaPostaBalikomatyShipmentInterface
   {
       use CeskaPostaBalikomatyShipmentTrait;
   }
   ```
   
1. Your Entity `ShippingMethod` has to implement `\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShipmentInterface`. 
   You can use the trait `\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShipmentTrait`.
 
   ```php
   <?php 
   
   declare(strict_types=1);
   
   namespace App\Entity\Shipping;
   
   use Doctrine\ORM\Mapping as ORM;
   use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShippingMethodInterface;
   use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShippingMethodTrait;
   use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;
   
   /**
    * @ORM\Entity
    * @ORM\Table(name="sylius_shipping_method")
    */
   class ShippingMethod extends BaseShippingMethod implements CeskaPostaBalikomatyShippingMethodInterface
   {
       use CeskaPostaBalikomatyShippingMethodTrait;
   }
   ```

1. Include `@MangoSyliusCeskaPostaBalikomatyPlugin/Admin/ShippingMethod/_ceskaPostaBalikomatyForm.html.twig` into `@SyliusAdmin/ShippingMethod/_form.html.twig`.
 
    ```twig
    ...	
   {{ include('@MangoSyliusCeskaPostaBalikomatyPlugin/Admin/ShippingMethod/_ceskaPostaBalikomatyForm.html.twig') }}
    ...
    ```
   
1. Include `@MangoSyliusCeskaPostaBalikomatyPlugin/Shop/Checkout/SelectShipping/_ceskaPostaBalikomatyChoice.html.twig` into `@SyliusShop/Checkout/SelectShipping/_choice.html.twig`.
 
    ```twig
    ...
   {{ include('@MangoSyliusCeskaPostaBalikomatyPlugin/Shop/Checkout/SelectShipping/_ceskaPostaBalikomatyChoice.html.twig') }}
    ```
   
1. Replace `{% include '@SyliusShop/Common/_address.html.twig' with {'address': order.shippingAddress} %}` with `{{ include('@MangoSyliusCeskaPostaBalikomatyPlugin/Shop/Common/Order/_addresses.html.twig') }}` in `@SyliusShop/Common/Order/_addresses.html.twig`

1. Replace `{% include '@SyliusAdmin/Common/_address.html.twig' with {'address': order.shippingAddress} %}` with `{{ include('@MangoSyliusCeskaPostaBalikomatyPlugin/Admin/Common/Order/_addresses.html.twig') }}` in `@SyliusAdmin/Order/Show/_addresses.html.twig`

1. Override the template in `@MangoSyliusShipmentExportPlugin/_row.html.twig`
    ```twig
   {% extends '@!MangoSyliusShipmentExportPlugin/_row.html.twig' %}
   
   {% block address %}
       {% if row.ceskaPostaBalikomat %}
            {{ include('@MangoSyliusCeskaPostaBalikomatyPlugin/_exporterRow.html.twig') }}
       {% else %}
           {{ parent() }}
       {% endif %}
   {% endblock %}
    ```
   
1. Create and run doctrine database migrations.

For the guide how to use your own entity see [Sylius docs - Customizing Models](https://docs.sylius.com/en/1.6/customization/model.html)

## Usage

* Create new shipping method in the admin panel and enable Česká Pošta Balíkomat, save it and click `Sync Česká Pošta Balíkomaty branches` button to load the list of branches into the current database.
* Česká Pošta Balíkomaty CSV export will be generated for shipping method which has the code 'ceska_posta_balikomat', you can change this in parameters, it is an array.
  ```yaml
  parameters:
      shippingMethodsCodes: ['ceska_posta_balikomat']
  ```
* Česká Pošta Balíkomaty branches are updated on their servers. Just call this command (via `cron`) once a day, ideally during the night.

  ```bash
  mango:ceska-posta-balikomaty:sync
  ```

## Development

### Usage

- Develop your plugin in `/src`
- See `bin/` for useful commands

### Testing


After your changes you must ensure that the tests are still passing.

```bash
$ composer install
$ bin/console doctrine:schema:create -e test
$ bin/behat
$ bin/phpstan.sh
$ bin/ecs.sh
```

License
-------
This library is under the MIT license.

Credits
-------
Developed by [manGoweb](https://www.mangoweb.eu/).
