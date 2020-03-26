<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Entity\CeskaPostaBalikomatInterface;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShipmentInterface;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShippingMethodInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class ShippingMethodContext implements Context
{
	/** @var SharedStorageInterface */
	private $sharedStorage;

	/** @var RepositoryInterface */
	private $ceskaPostaBalikomatyRepository;

	/** @var FactoryInterface */
	private $balikomatFactory;

	/** @var EntityManagerInterface */
	private $entityManager;

	public function __construct(
		EntityManagerInterface $entityManager,
		SharedStorageInterface $sharedStorage,
		RepositoryInterface $ceskaPostaBalikomatyRepository,
		FactoryInterface $balikomatFactory
	) {
		$this->sharedStorage = $sharedStorage;
		$this->ceskaPostaBalikomatyRepository = $ceskaPostaBalikomatyRepository;
		$this->balikomatFactory = $balikomatFactory;
		$this->entityManager = $entityManager;
	}

	/**
	 * @Given /^(this shipping method) has Česká Pošta Balíkomaty enabled$/
	 */
	public function thisPaymentMethodHasZone(ShippingMethodInterface $shippingMethod)
	{
		assert($shippingMethod instanceof CeskaPostaBalikomatyShippingMethodInterface);
		$shippingMethod->setBalikomatShippingMethod(true);
		$this->ceskaPostaBalikomatyRepository->add($shippingMethod);
	}

	/**
	 * @Given the store has Česká Pošta Balíkomat ":ceskaPostaBalikomatyName"
	 */
	public function theStoreHasCeskaPostaBalikomatyWithID(string $ceskaPostaBalikomatyName)
	{
		$ceskaPostaBalikomat = $this->balikomatFactory->createNew();
		assert($ceskaPostaBalikomat instanceof CeskaPostaBalikomatInterface);

		$ceskaPostaBalikomat->setZip($ceskaPostaBalikomatyName);
		$ceskaPostaBalikomat->setName($ceskaPostaBalikomatyName);
		$ceskaPostaBalikomat->setAddress($ceskaPostaBalikomatyName);
		$ceskaPostaBalikomat->setType($ceskaPostaBalikomatyName);
		$ceskaPostaBalikomat->setGpsX($ceskaPostaBalikomatyName);
		$ceskaPostaBalikomat->setGpsY($ceskaPostaBalikomatyName);
		$ceskaPostaBalikomat->setCity($ceskaPostaBalikomatyName);
		$ceskaPostaBalikomat->setCityPart($ceskaPostaBalikomatyName);

		$ceskaPostaBalikomat->setHash(md5(
			$ceskaPostaBalikomat->getZip()
			. $ceskaPostaBalikomat->getName()
			. $ceskaPostaBalikomat->getAddress()
			. $ceskaPostaBalikomat->getType()
			. $ceskaPostaBalikomat->getGpsX()
			. $ceskaPostaBalikomat->getGpsY()
			. $ceskaPostaBalikomat->getCity()
			. $ceskaPostaBalikomat->getCityPart()
		));

		$this->ceskaPostaBalikomatyRepository->add($ceskaPostaBalikomat);
	}

	/**
	 * @Given choose Česká Pošta Balíkomat branch ":ceskaPostaBalikomatyName"
	 */
	public function chooseCeskaPostaBalikomatyBranch(string $ceskaPostaBalikomatyName)
	{
		$ceskaPostaBalikomat = $this->ceskaPostaBalikomatyRepository->findOneBy(['name' => $ceskaPostaBalikomatyName]);
		assert($ceskaPostaBalikomat instanceof CeskaPostaBalikomatInterface);

		$order = $this->sharedStorage->get('order');
		assert($order instanceof OrderInterface);

		$shipment = $order->getShipments()->last();
		assert($shipment instanceof CeskaPostaBalikomatyShipmentInterface);
		$shipment->setCeskaPostaBalikomat($ceskaPostaBalikomat);

		$this->entityManager->persist($order);
		$this->entityManager->flush();
	}
}
