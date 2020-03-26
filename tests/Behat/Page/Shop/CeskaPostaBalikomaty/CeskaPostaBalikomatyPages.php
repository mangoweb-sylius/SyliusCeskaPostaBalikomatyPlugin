<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Behat\Page\Shop\CeskaPostaBalikomaty;

use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Entity\CeskaPostaBalikomatInterface;
use Sylius\Behat\Page\Admin\Channel\UpdatePage as BaseUpdatePage;

final class CeskaPostaBalikomatyPages extends BaseUpdatePage implements CeskaPostaBalikomatyPagesInterface
{
	public function selectCeskaPostaBalikomatyBranch(CeskaPostaBalikomatInterface $ceskaPostaBalikomat): void
	{
		$ceskaPostaBalikomatySelect = $this->getElement('ceskaPostaBalikomaty_select');
		$ceskaPostaBalikomatySelect->selectOption($ceskaPostaBalikomat->getId());
	}

	public function iSeeCeskaPostaBalikomatyBranchInsteadOfShippingAddress(string $name): bool
	{
		$shippingAddress = $this->getElement('shippingAddress')->getText();

		return false !== strpos($shippingAddress, $name);
	}

	protected function getDefinedElements(): array
	{
		return array_merge(parent::getDefinedElements(), [
			'ceskaPostaBalikomaty_select' => '.ceskaPostaBalikomatySelectDiv select',
			'shippingAddress' => '#sylius-shipping-address',
		]);
	}
}
