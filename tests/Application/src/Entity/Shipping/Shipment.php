<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Application\src\Entity\Shipping;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Table;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShipmentInterface;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShipmentTrait;
use Sylius\Component\Core\Model\Shipment as BaseShipment;

/**
 * @MappedSuperclass
 * @Table(name="sylius_shipment")
 */
class Shipment extends BaseShipment implements CeskaPostaBalikomatyShipmentInterface
{
	use CeskaPostaBalikomatyShipmentTrait;
}
