<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Entity\CeskaPostaBalikomatInterface;
use Sylius\Behat\Context\Ui\Shop\Checkout\CheckoutShippingContext;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Behat\Page\Shop\CeskaPostaBalikomaty\CeskaPostaBalikomatyPagesInterface;
use Webmozart\Assert\Assert;

final class ManagingCeskaPostaBalikomatContext implements Context
{
	/** @var CeskaPostaBalikomatyPagesInterface */
	private $ceskaPostaBalikomatPages;

	/** @var CheckoutShippingContext */
	private $checkoutShippingContext;

	/** @var RepositoryInterface */
	private $ceskaPostaBalikomatRepository;

	public function __construct(
		CeskaPostaBalikomatyPagesInterface $ceskaPostaBalikomatPages,
		CheckoutShippingContext $checkoutShippingContext,
		RepositoryInterface $ceskaPostaBalikomatRepository
	) {
		$this->ceskaPostaBalikomatPages = $ceskaPostaBalikomatPages;
		$this->checkoutShippingContext = $checkoutShippingContext;
		$this->ceskaPostaBalikomatRepository = $ceskaPostaBalikomatRepository;
	}

	/**
	 * @Then I should not be able to go to the payment step again
	 */
	public function iShouldNotBeAbleToGoToThePaymentStepAgain()
	{
		Assert::throws(function () {
			$this->checkoutShippingContext->iShouldBeAbleToGoToThePaymentStepAgain();
		}, UnexpectedPageException::class);
	}

	/**
	 * @Then I select :ceskaPostaBalikomatName Česká Pošta Balíkomaty branch
	 */
	public function iSelectceskaPostaBalikomatBranch(string $ceskaPostaBalikomatName)
	{
		$ceskaPostaBalikomat = $this->ceskaPostaBalikomatRepository->findOneBy(['name' => $ceskaPostaBalikomatName]);

		assert($ceskaPostaBalikomat instanceof CeskaPostaBalikomatInterface);

		$this->ceskaPostaBalikomatPages->selectCeskaPostaBalikomatyBranch($ceskaPostaBalikomat);
	}

	/**
	 * @Then I can not see :ceskaPostaBalikomatName Česká Pošta Balíkomaty branch in the list of Česká Pošta Balíkomaty branches
	 */
	public function iCanNotSeeceskaPostaBalikomatBranchInTheListOfceskaPostaBalikomatBranches(string $ceskaPostaBalikomatName)
	{
		$ceskaPostaBalikomat = $this->ceskaPostaBalikomatRepository->findOneBy(['name' => $ceskaPostaBalikomatName]);

		assert($ceskaPostaBalikomat instanceof CeskaPostaBalikomatInterface);

		Assert::throws(function () use ($ceskaPostaBalikomat) {
			$this->ceskaPostaBalikomatPages->selectCeskaPostaBalikomatyBranch($ceskaPostaBalikomat);
		}, ElementNotFoundException::class);
	}

	/**
	 * @Given I see Česká Pošta Balíkomaty branch :name instead of shipping address
	 */
	public function iSeeceskaPostaBalikomatBranchInsteadOfShippingAddress(string $name)
	{
		Assert::true($this->ceskaPostaBalikomatPages->iSeeCeskaPostaBalikomatyBranchInsteadOfShippingAddress($name));
	}
}
