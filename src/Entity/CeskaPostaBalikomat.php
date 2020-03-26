<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="mangoweb_ceska_posta_balikomat")
 * @ORM\Entity
 */
class CeskaPostaBalikomat implements CeskaPostaBalikomatInterface
{
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @ORM\Column(type="integer", nullable=false)
	 */
	protected $id;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $hash;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $zip;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $name;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $address;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $type;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $gpsX;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $gpsY;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $city;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $cityPart;

	/**
	 * @var array<string>|null
	 * @ORM\Column(type="json", nullable=true)
	 */
	protected $openingHours;

	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $disabledAt;

	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $createdAt;

	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $updateAt;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): void
	{
		$this->id = $id;
	}

	public function getZip(): ?string
	{
		return $this->zip;
	}

	public function setZip(?string $zip): void
	{
		$this->zip = $zip;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(?string $name): void
	{
		$this->name = $name;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function setAddress(?string $address): void
	{
		$this->address = $address;
	}

	public function getType(): ?string
	{
		return $this->type;
	}

	public function setType(?string $type): void
	{
		$this->type = $type;
	}

	public function getGpsX(): ?string
	{
		return $this->gpsX;
	}

	public function setGpsX(?string $gpsX): void
	{
		$this->gpsX = $gpsX;
	}

	public function getGpsY(): ?string
	{
		return $this->gpsY;
	}

	public function setGpsY(?string $gpsY): void
	{
		$this->gpsY = $gpsY;
	}

	public function getCity(): ?string
	{
		return $this->city;
	}

	public function setCity(?string $city): void
	{
		$this->city = $city;
	}

	public function getCityPart(): ?string
	{
		return $this->cityPart;
	}

	public function setCityPart(?string $cityPart): void
	{
		$this->cityPart = $cityPart;
	}

	/**
	 * @return array<mixed>|null
	 */
	public function getOpeningHours(): ?array
	{
		return $this->openingHours;
	}

	/**
	 * @param array<mixed>|null $openingHours
	 */
	public function setOpeningHours(?array $openingHours): void
	{
		$this->openingHours = $openingHours;
	}

	public function getDisabledAt(): ?\DateTime
	{
		return $this->disabledAt;
	}

	public function setDisabledAt(?\DateTime $disabledAt): void
	{
		$this->disabledAt = $disabledAt;
	}

	public function getHash(): ?string
	{
		return $this->hash;
	}

	public function setHash(?string $hash): void
	{
		$this->hash = $hash;
	}

	public function getCreatedAt(): ?\DateTime
	{
		return $this->createdAt;
	}

	public function setCreatedAt(?\DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
	}

	public function getUpdateAt(): ?\DateTime
	{
		return $this->updateAt;
	}

	public function setUpdateAt(?\DateTime $updateAt): void
	{
		$this->updateAt = $updateAt;
	}

	public function __toString(): string
	{
		$nameArray = [];
		if ($this->name !== null) {
			$nameArray[] = $this->name;
		}
		if ($this->address !== null) {
			$nameArray[] = $this->address;
		}
		if ($this->city !== null) {
			$nameArray[] = $this->city;
		}
		if ($this->zip !== null) {
			$nameArray[] = $this->zip;
		}

		return implode(', ', $nameArray);
	}
}
