<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait CeskaPostaBalikomatyShippingMethodTrait
{
	/**
	 * @var bool|null
	 *
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $balikomatShippingMethod;

	public function getBalikomatShippingMethod(): ?bool
	{
		return $this->balikomatShippingMethod;
	}

	public function setBalikomatShippingMethod(?bool $balikomatShippingMethod): void
	{
		$this->balikomatShippingMethod = $balikomatShippingMethod;
	}
}
