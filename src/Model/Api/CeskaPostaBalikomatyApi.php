<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\Api;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Entity\CeskaPostaBalikomatInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class CeskaPostaBalikomatyApi implements CeskaPostaBalikomatyApiInterface
{
	/** @var string */
	protected $apiUrl;

	/** @var DownloaderInterface */
	protected $downloader;

	/** @var RepositoryInterface */
	private $balikomatRepository;

	/** @var FactoryInterface */
	private $balikomatFactory;

	/** @var EntityManagerInterface */
	private $entityManager;

	public function __construct(
		DownloaderInterface $downloader,
		RepositoryInterface $balikomatRepository,
		FactoryInterface $balikomatFactory,
		EntityManagerInterface $entityManager,
		string $apiUrl
	) {
		$this->downloader = $downloader;
		$this->apiUrl = $apiUrl;
		$this->balikomatRepository = $balikomatRepository;
		$this->balikomatFactory = $balikomatFactory;
		$this->entityManager = $entityManager;
	}

	public function syncBranches(): void
	{
		$responseArray = $this->downloader->downloadBranches($this->apiUrl);

		$branches = $this->getBranches($responseArray);
		$this->updateBranches($branches);
		$this->disableBranches($branches);
	}

	/**
	 * @param array<mixed> $responseArray
	 *
	 * @return array<mixed>
	 */
	protected function getBranches(array $responseArray): array
	{
		$branches = [];
		foreach ($responseArray['row'] as $key => $branch) {
			$branches[$key] = $branch;
			$branches[$key]['hash'] = $this->createHash($branch);
		}

		return $branches;
	}

	/**
	 * @param array<mixed> $branch
	 */
	protected function getBranchValue(array $branch, string $key): ?string
	{
		if (array_key_exists($key, $branch) && !is_array($branch[$key])) {
			return trim($branch[$key]);
		}

		return null;
	}

	/**
	 * @param array<mixed> $branches
	 */
	protected function updateBranches(array $branches): void
	{
		foreach ($branches as $branch) {
			$ceskaPostaBalikomat = $this->balikomatRepository->findOneBy(['hash' => $branch['hash']]);
			if ($ceskaPostaBalikomat === null) {
				$ceskaPostaBalikomat = $this->balikomatFactory->createNew();
				assert($ceskaPostaBalikomat instanceof CeskaPostaBalikomatInterface);
				$ceskaPostaBalikomat->setHash($branch['hash']);
				$ceskaPostaBalikomat->setCreatedAt(new \DateTime());
				$ceskaPostaBalikomat->setZip($this->getBranchValue($branch, 'PSC'));
				$ceskaPostaBalikomat->setName($this->getBranchValue($branch, 'NAZEV'));
				$ceskaPostaBalikomat->setAddress($this->getBranchValue($branch, 'ADRESA'));
				$ceskaPostaBalikomat->setType($this->getBranchValue($branch, 'TYP'));
				$ceskaPostaBalikomat->setGpsX($this->getBranchValue($branch, 'SOUR_X'));
				$ceskaPostaBalikomat->setGpsY($this->getBranchValue($branch, 'SOUR_Y'));
				$ceskaPostaBalikomat->setCity($this->getBranchValue($branch, 'OBEC'));
				$ceskaPostaBalikomat->setCityPart($this->getBranchValue($branch, 'C_OBCE'));
			} else {
				assert($ceskaPostaBalikomat instanceof CeskaPostaBalikomatInterface);
				$ceskaPostaBalikomat->setUpdateAt(new \DateTime());
			}

			$ceskaPostaBalikomat->setOpeningHours($branch['OTEV_DOBY'] ?? null);
			$ceskaPostaBalikomat->setDisabledAt(null);

			$this->entityManager->persist($ceskaPostaBalikomat);
		}

		$this->entityManager->flush();
	}

	/**
	 * @param array<mixed> $branch
	 */
	private function createHash(array $branch): string
	{
		return md5(
			$this->getBranchValue($branch, 'PSC')
			. $this->getBranchValue($branch, 'NAZEV')
			. $this->getBranchValue($branch, 'ADRESA')
			. $this->getBranchValue($branch, 'TYP')
			. $this->getBranchValue($branch, 'SOUR_X')
			. $this->getBranchValue($branch, 'SOUR_Y')
			. $this->getBranchValue($branch, 'OBEC')
			. $this->getBranchValue($branch, 'C_OBCE')
		);
	}

	/**
	 * @param array<mixed> $branches
	 */
	protected function disableBranches(array $branches): void
	{
		if (count($branches) === 0) {
			return;
		}

		$hashes = [];
		foreach ($branches as $branch) {
			$hashes[] = (string) $branch['hash'];
		}

		/** @var EntityRepository $em */
		$em = $this->balikomatRepository;
		$em->createQueryBuilder('e')
			->update()
			->set('e.disabledAt', ':now')
			->where('e.disabledAt IS NULL')
			->andWhere('e.hash NOT IN (:hashes)')
			->setParameter('now', new \DateTime())
			->setParameter('hashes', $hashes)
			->getQuery()
			->execute();
	}
}
