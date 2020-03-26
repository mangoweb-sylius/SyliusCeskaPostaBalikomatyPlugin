<?php

declare(strict_types=1);

namespace MangoSylius\SyliusCeskaPostaBalikomatyPlugin\Form\Extension;

use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class AdminCeskaPostaBalikomatyShippingMethodExtension extends AbstractTypeExtension
{
	/** @param array<mixed> $options */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('balikomatShippingMethod', CheckboxType::class, [
				'label' => 'mangoweb.admin.balikomat.form.balikomatShippingMethod',
				'required' => false,
			]);
	}

	/** @return array<string> */
	public static function getExtendedTypes(): array
	{
		return [
			ShippingMethodType::class,
		];
	}
}
