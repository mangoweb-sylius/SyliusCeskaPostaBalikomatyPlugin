<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\ElementNotFoundException;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Behat\Page\Admin\ShippingMethod\UpdatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingShippingMethodContext implements Context
{
	/** @var UpdatePageInterface */
	private $updatePage;

	/** @var NotificationCheckerInterface */
	private $notificationChecker;

	public function __construct(
		UpdatePageInterface $updatePage,
		NotificationCheckerInterface $notificationChecker
	) {
		$this->updatePage = $updatePage;
		$this->notificationChecker = $notificationChecker;
	}

	/**
	 * @Then click to action download and update Česká Pošta Balíkomaty branches
	 */
	public function clickToActionDownloadAndUpdateCeskaPostaBalikomatyBranches()
	{
		$this->updatePage->clickToCeskaPostaBalikomatyDownloadButton();
	}

	/**
	 * @Then I should be notified that Česká Pošta Balíkomaty branches has been successfully updated
	 */
	public function iShouldBeNotifiedThatCeskaPostaBalikomatyBranchesHasBeenSuccessfullyUpdated()
	{
		$this->notificationChecker->checkNotification('Česká Pošta Balíkomat branches synchronization was successful.', NotificationType::success());
	}

	/**
	 * @Then action download and update Česká Pošta Balíkomaty branches is not available
	 */
	public function actionDownloadAndUpdateCeskaPostaBalikomatyBranchesIsDisabled()
	{
		Assert::throws(function () {
			$this->updatePage->ceskaPostaBalikomatyDownloadButtonIsOnPage();
		}, ElementNotFoundException::class);
	}

	/**
	 * @Then action download and update ceskaPostaBalikomaty branches is available
	 */
	public function actionDownloadAndUpdateCeskaPostaBalikomatyBranchesIsEnabled()
	{
		Assert::notNull($this->updatePage->ceskaPostaBalikomatyDownloadButtonIsOnPage());
	}

	/**
	 * @Then it should be shipped to Česká Pošta Balíkomat ":name"
	 */
	public function ttShouldBeShippedToPplParcelshop(string $name)
	{
		Assert::true($this->updatePage->iSeeceskaPostaBalikomatInsteadOfShippingAddress($name));
	}

	/**
	 * @When I enable PPL parcelshops
	 */
	public function iEnablePplParcelshops()
	{
		$this->updatePage->enableCeskaPostaBalikomaty();
	}

	/**
	 * @Then the PPL parcelshops shoul be enabled
	 */
	public function thePplParcelshopsShoulBeEnabled()
	{
		Assert::true((bool) $this->updatePage->isSingleResourceOnPage('balikCheckbox'));
	}

	/**
	 * @When I disable PPL parcelshops
	 */
	public function iDisablePplParcelshops()
	{
		$this->updatePage->disableCeskaPostaBalikomaty();
	}

	/**
	 * @Then the PPL parcelshops shoul be disabled
	 */
	public function thePplParcelshopsShoulBeDisabled()
	{
		Assert::false((bool) $this->updatePage->isSingleResourceOnPage('balikCheckbox'));
	}
}
