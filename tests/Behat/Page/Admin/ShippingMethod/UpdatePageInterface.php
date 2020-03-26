<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Behat\Page\Admin\ShippingMethod;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Channel\UpdatePageInterface as BaseUpdatePageInterface;

interface UpdatePageInterface extends BaseUpdatePageInterface
{
	public function ceskaPostaBalikomatyDownloadButtonIsOnPage(): NodeElement;

	public function clickToCeskaPostaBalikomatyDownloadButton(): void;

	public function enableCeskaPostaBalikomaty(): void;

	public function disableCeskaPostaBalikomaty(): void;

	public function isSingleResourceOnPage(string $elementName);

	public function iSeeceskaPostaBalikomatInsteadOfShippingAddress(string $name): bool;
}
