<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface CeskaPostaBalikomatInterface extends ResourceInterface
{
	public function __toString(): string;

	public function getId(): ?int;

	public function getHash(): ?string;

	public function setHash(?string $hash): void;

	public function setId(?int $id): void;

	public function getZip(): ?string;

	public function setZip(?string $zip): void;

	public function getName(): ?string;

	public function setName(?string $name): void;

	public function getAddress(): ?string;

	public function setAddress(?string $address): void;

	public function getType(): ?string;

	public function setType(?string $ype): void;

	public function getGpsX(): ?string;

	public function setGpsX(?string $gpsX): void;

	public function getGpsY(): ?string;

	public function setGpsY(?string $gpsY): void;

	public function getCity(): ?string;

	public function setCity(?string $city): void;

	public function getCityPart(): ?string;

	public function setCityPart(?string $cityPart): void;

	public function getCreatedAt(): ?\DateTime;

	public function setCreatedAt(?\DateTime $createdAt): void;

	public function getUpdateAt(): ?\DateTime;

	public function setUpdateAt(?\DateTime $updateAt): void;

	/**
	 * @return array<mixed>|null
	 */
	public function getOpeningHours(): ?array;

	/**
	 * @param array<mixed>|null $openingHours
	 */
	public function setOpeningHours(?array $openingHours): void;

	public function getDisabledAt(): ?\DateTime;

	public function setDisabledAt(?\DateTime $disabledAt): void;
}
