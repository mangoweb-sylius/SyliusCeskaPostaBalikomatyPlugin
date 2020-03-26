<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Application\src\Entity\Shipping;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Table;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShippingMethodInterface;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShippingMethodTrait;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;

/**
 * @MappedSuperclass
 * @Table(name="sylius_shipping_method")
 */
class ShippingMethod extends BaseShippingMethod implements CeskaPostaBalikomatyShippingMethodInterface
{
	use CeskaPostaBalikomatyShippingMethodTrait;
}
