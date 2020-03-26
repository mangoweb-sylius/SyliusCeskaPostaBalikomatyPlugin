<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\Api;

interface DownloaderInterface
{
	/**
	 * @return array<mixed>
	 */
	public function downloadBranches(string $apiUrl): array;
}
