<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model;

interface CeskaPostaBalikomatyShippingMethodInterface
{
	public function getBalikomatShippingMethod(): ?bool;

	public function setBalikomatShippingMethod(?bool $balikomatShippingMethod): void;
}
