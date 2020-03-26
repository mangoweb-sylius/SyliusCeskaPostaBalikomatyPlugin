<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\Api;

interface CeskaPostaBalikomatyApiInterface
{
	public function syncBranches(): void;
}
