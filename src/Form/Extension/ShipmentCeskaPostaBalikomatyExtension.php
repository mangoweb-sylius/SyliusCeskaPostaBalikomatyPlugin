<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Form\Extension;

use Doctrine\ORM\EntityRepository;
use MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Model\CeskaPostaBalikomatyShippingMethodInterface;
use Sylius\Bundle\CoreBundle\Form\Type\Checkout\ShipmentType;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Shipping\Resolver\ShippingMethodsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Contracts\Translation\TranslatorInterface;

class ShipmentCeskaPostaBalikomatyExtension extends AbstractTypeExtension
{
	/** @var ShippingMethodsResolverInterface */
	private $shippingMethodsResolver;

	/** @var ShippingMethodRepositoryInterface */
	private $shippingMethodRepository;

	/** @var string[]; */
	private $ceskaPostaBalikomatMethodsCodes = [];

	/** @var RepositoryInterface */
	private $ceskaPostaBalikomatRepository;

	/** @var string */
	private $balikovnaClass;

	/** @var TranslatorInterface */
	private $translator;

	public function __construct(
		ShippingMethodsResolverInterface $shippingMethodsResolver,
		ShippingMethodRepositoryInterface $shippingMethodRepository,
		RepositoryInterface $ceskaPostaBalikomatRepository,
		TranslatorInterface $translator,
		string $balikovnaClass
	) {
		$this->shippingMethodsResolver = $shippingMethodsResolver;
		$this->shippingMethodRepository = $shippingMethodRepository;
		$this->ceskaPostaBalikomatRepository = $ceskaPostaBalikomatRepository;
		$this->balikovnaClass = $balikovnaClass;
		$this->translator = $translator;
	}

	/** @param array<mixed> $options */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('ceskaPostaBalikomat', HiddenType::class)
			->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event): void {
				$orderData = $event->getData();

				assert(array_key_exists('ceskaPostaBalikomat', $orderData));
				assert(array_key_exists('method', $orderData));

				$orderData['ceskaPostaBalikomat'] = null;
				if (array_key_exists('ceskaPostaBalikomat_' . $orderData['method'], $orderData) && in_array($orderData['method'], $this->ceskaPostaBalikomatMethodsCodes, true)) {
					$ceskaPostaBalikomatId = (int) $orderData['ceskaPostaBalikomat_' . $orderData['method']];
					$orderData['ceskaPostaBalikomat'] = $this->ceskaPostaBalikomatRepository->find($ceskaPostaBalikomatId);
				}

				$event->setData($orderData);

				// validation
				$data = $event->getData();
				if (array_key_exists('ceskaPostaBalikomat_' . $data['method'], $data) && !((bool) $orderData['ceskaPostaBalikomat_' . $orderData['method']])) {
					$event->getForm()->addError(new FormError($this->translator->trans('mangoweb.shop.checkout.ceskaPostaBalikomatyBranch', [], 'validators')));
				}
			})
			->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
				$form = $event->getForm();
				$shipment = $event->getData();

				if ($shipment && $this->shippingMethodsResolver->supports($shipment)) {
					$shippingMethods = $this->shippingMethodsResolver->getSupportedMethods($shipment);
				} else {
					$shippingMethods = $this->shippingMethodRepository->findAll();
				}

				foreach ($shippingMethods as $method) {
					assert($method instanceof ShippingMethodInterface);
					assert($method instanceof CeskaPostaBalikomatyShippingMethodInterface);

					if ($method->getBalikomatShippingMethod()) {
						assert($method->getCode() !== null);

						$this->ceskaPostaBalikomatMethodsCodes[] = $method->getCode();
						$form
							->add('ceskaPostaBalikomat_' . $method->getCode(), EntityType::class, [
								'required' => false,
								'mapped' => false,
								'empty_data' => null,
								'placeholder' => 'mangoweb.shop.checkout.shippingStep.chooseCeskaPostaBalikomatBranch',
								'class' => $this->balikovnaClass,
								'query_builder' => function (EntityRepository $er) {
									return $er->createQueryBuilder('z')
										->where('z.disabledAt IS NULL')
										->orderBy('z.name');
								},
							]);
					}
				}
			});
	}

	/** @return array<string> */
	public static function getExtendedTypes(): array
	{
		return [
			ShipmentType::class,
		];
	}
}
