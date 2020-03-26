<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Command;

use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\Api\CeskaPostaBalikomatyApiInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SyncCeskaPostaBalikomatyCommand extends Command
{
	/** @var CeskaPostaBalikomatyApiInterface */
	private $api;

	public function __construct(
		CeskaPostaBalikomatyApiInterface $api
	) {
		parent::__construct();
		$this->api = $api;
	}

	protected function configure(): void
	{
		$this->setName('mango:ceska-posta-balikomaty:sync');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$io = new SymfonyStyle($input, $output);
		$io->title($this->getName() . ' started at ' . date('Y-m-d H:i:s'));

		$this->api->syncBranches();

		$io->success($this->getName() . ' end at ' . date('Y-m-d H:i:s'));

		return 0;
	}
}
