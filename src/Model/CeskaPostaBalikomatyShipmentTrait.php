<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model;

use Doctrine\ORM\Mapping as ORM;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Entity\CeskaPostaBalikomatInterface;

trait CeskaPostaBalikomatyShipmentTrait
{
	/**
	 * @var CeskaPostaBalikomatInterface|null
	 * @ORM\ManyToOne(targetEntity="MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Entity\CeskaPostaBalikomat")
	 */
	private $ceskaPostaBalikomat;

	public function getCeskaPostaBalikomat(): ?CeskaPostaBalikomatInterface
	{
		return $this->ceskaPostaBalikomat;
	}

	public function setCeskaPostaBalikomat(?CeskaPostaBalikomatInterface $ceskaPostaBalikomat): void
	{
		$this->ceskaPostaBalikomat = $ceskaPostaBalikomat;
	}
}
