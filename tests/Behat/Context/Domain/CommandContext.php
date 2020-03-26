<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Behat\Context\Domain;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Entity\CeskaPostaBalikomatInterface;
use Sylius\Bundle\CoreBundle\Command\InstallSampleDataCommand;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

final class CommandContext implements Context
{
	/** @var KernelInterface */
	private $kernel;

	/** @var RepositoryInterface */
	private $ceskaPostaBalikomatyRepository;

	/** @var EntityManagerInterface */
	private $entityManager;

	public function __construct(
		KernelInterface $kernel,
		RepositoryInterface $ceskaPostaBalikomatyRepository,
		EntityManagerInterface $entityManager
	) {
		$this->kernel = $kernel;
		$this->ceskaPostaBalikomatyRepository = $ceskaPostaBalikomatyRepository;
		$this->entityManager = $entityManager;
	}

	/**
	 * @Given I update Česká Pošta Balíkomaty branches
	 */
	public function iUpdateProductPricesOnChannelsAnd()
	{
		$application = new Application($this->kernel);
		$application->add(new InstallSampleDataCommand());
		$command = $application->find('mango:ceska-posta-balikomaty:sync');
		$tester = new CommandTester($command);
		$tester->execute([]);
	}

	/**
	 * @Given the store should has Česká Pošta Balíkomat ":ceskaPostaBalikomatyName"
	 */
	public function theStoreShouldHasCeskaPostaBalikomaty(string $ceskaPostaBalikomatyName): void
	{
		$ceskaPostaBalikomaty = $this->ceskaPostaBalikomatyRepository->findOneBy(['name' => $ceskaPostaBalikomatyName]);
		assert($ceskaPostaBalikomaty instanceof CeskaPostaBalikomatInterface);
		$this->entityManager->refresh($ceskaPostaBalikomaty);

		Assert::eq($ceskaPostaBalikomaty->getName(), $ceskaPostaBalikomatyName);
		Assert::null($ceskaPostaBalikomaty->getDisabledAt());
	}

	/**
	 * @Given the store should has disabled Česká Pošta Balíkomat ":ceskaPostaBalikomatyName"
	 */
	public function theStoreShouldHasDisabledCeskaPostaBalikomatyWithId(string $ceskaPostaBalikomatyName): void
	{
		$ceskaPostaBalikomaty = $this->ceskaPostaBalikomatyRepository->findOneBy(['name' => $ceskaPostaBalikomatyName]);
		assert($ceskaPostaBalikomaty instanceof CeskaPostaBalikomatInterface);
		$this->entityManager->refresh($ceskaPostaBalikomaty);

		Assert::notNull($ceskaPostaBalikomaty->getDisabledAt());
	}
}
