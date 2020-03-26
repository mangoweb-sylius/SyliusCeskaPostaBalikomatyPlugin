<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Factory;

use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\Api\CeskaPostaBalikomatyApi;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\Api\CeskaPostaBalikomatyApiInterface;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\Api\DownloaderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class CeskaPostaBalikomatyApiFactory
{
	/** @var DownloaderInterface */
	private $downloader;

	/** @var string */
	private $apiUrl;

	/** @var RepositoryInterface */
	private $balikomatRepository;

	/** @var FactoryInterface */
	private $balikomatFactory;

	public function __construct(
		DownloaderInterface $downloader,
		RepositoryInterface $balikomatRepository,
		FactoryInterface $balikomatFactory,
		string $apiUrl
	) {
		$this->downloader = $downloader;
		$this->apiUrl = $apiUrl;
		$this->balikomatRepository = $balikomatRepository;
		$this->balikomatFactory = $balikomatFactory;
	}

	public function getCeskaPostaBalikomatyApi(): ?CeskaPostaBalikomatyApiInterface
	{
		return new CeskaPostaBalikomatyApi(
			$this->downloader,
			$this->balikomatRepository,
			$this->balikomatFactory,
			$this->apiUrl
		);
	}
}
