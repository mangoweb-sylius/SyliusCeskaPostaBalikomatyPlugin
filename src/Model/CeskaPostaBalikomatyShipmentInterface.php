<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model;

use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Entity\CeskaPostaBalikomatInterface;

interface CeskaPostaBalikomatyShipmentInterface
{
	public function getCeskaPostaBalikomat(): ?CeskaPostaBalikomatInterface;

	public function setCeskaPostaBalikomat(?CeskaPostaBalikomatInterface $ceskaPostaBalikomat): void;
}
