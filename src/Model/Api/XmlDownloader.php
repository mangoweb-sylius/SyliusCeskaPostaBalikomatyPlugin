<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\Api;

class XmlDownloader implements DownloaderInterface
{
	/**
	 * @return array<mixed>
	 */
	public function downloadBranches(string $apiUrl): array
	{
		$url = $apiUrl . '/balikovny.xml';

		$content = file_get_contents($url);
		assert($content !== false);

		$xml = simplexml_load_string($content);
		$json = json_encode($xml, \JSON_THROW_ON_ERROR, 512);

		return json_decode($json, true, 512, \JSON_THROW_ON_ERROR);
	}
}
