<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Controller;

use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\Api\CeskaPostaBalikomatyApiInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SyncBranches
{
	/** @var RouterInterface */
	private $router;

	/** @var FlashBagInterface */
	private $flashBag;

	/** @var TranslatorInterface */
	private $translator;

	/** @var CeskaPostaBalikomatyApiInterface */
	private $api;

	public function __construct(
		TranslatorInterface $translator,
		FlashBagInterface $flashBag,
		RouterInterface $router,
		CeskaPostaBalikomatyApiInterface $api
	) {
		$this->router = $router;
		$this->flashBag = $flashBag;
		$this->translator = $translator;
		$this->api = $api;
	}

	public function __invoke(int $id): RedirectResponse
	{
		$this->api->syncBranches();

		$message = $this->translator->trans('mangoweb.admin.ceskaPostaBalikomaty.success.import');
		$this->flashBag->add('success', $message);

		return new RedirectResponse($this->router->generate('sylius_admin_shipping_method_update', ['id' => $id]));
	}
}
