<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Behat\Page\Shop\CeskaPostaBalikomaty;

use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Entity\CeskaPostaBalikomatInterface;
use Sylius\Behat\Page\Admin\Channel\UpdatePageInterface as BaseUpdatePageInterface;

interface CeskaPostaBalikomatyPagesInterface extends BaseUpdatePageInterface
{
	public function selectCeskaPostaBalikomatyBranch(CeskaPostaBalikomatInterface $ceskaPostaBalikomaty): void;

	public function iSeeCeskaPostaBalikomatyBranchInsteadOfShippingAddress(string $name): bool;
}
