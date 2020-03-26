<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Behat\Page\Admin\ShippingMethod;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Channel\UpdatePage as BaseUpdatePage;

final class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
	public function ceskaPostaBalikomatyDownloadButtonIsOnPage(): NodeElement
	{
		return $this->getElement('ceskaPostaBalikomatyDownloadButton');
	}

	public function clickToCeskaPostaBalikomatyDownloadButton(): void
	{
		$this->getElement('ceskaPostaBalikomatyDownloadButton')->click();
	}

	public function enableCeskaPostaBalikomaty(): void
	{
		$this->getElement('balikCheckbox')->setValue(true);
	}

	public function disableCeskaPostaBalikomaty(): void
	{
		$this->getElement('balikCheckbox')->setValue(false);
	}

	public function isSingleResourceOnPage(string $elementName)
	{
		return $this->getElement($elementName)->getValue();
	}

	public function iSeeceskaPostaBalikomatInsteadOfShippingAddress(string $name): bool
	{
		$shippingAddress = $this->getElement('shippingAddress')->getText();

		return false !== strpos($shippingAddress, $name);
	}

	protected function getDefinedElements(): array
	{
		return array_merge(parent::getDefinedElements(), [
			'balikCheckbox' => '#sylius_shipping_method_balikomatShippingMethod',
			'ceskaPostaBalikomatyDownloadButton' => '#ceskaPostaBalikomatyDownloadButton',
			'shippingAddress' => '#shipping-address',
		]);
	}
}
