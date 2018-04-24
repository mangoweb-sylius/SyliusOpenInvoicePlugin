<?php

declare(strict_types=1);

namespace MangoSylius\SyliusOpenInvoicePlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;

final class OpenInvoiceConfigurationType extends AbstractType
{
    public const IS_OPEN_INVOICE_ONLY_FOR_REGISTERED_KEY = 'isOpenInvoiceOnlyForRegistered';

    public const OPEN_INVOICE_SUCCESS_ORDERS_LIMIT_KEY = 'openInvoiceSuccessOrdersLimit';

    /**
     * {@inheritdoc}
     *
     * @throws \Symfony\Component\Validator\Exception\ConstraintDefinitionException
     * @throws \Symfony\Component\Validator\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Validator\Exception\MissingOptionsException
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::IS_OPEN_INVOICE_ONLY_FOR_REGISTERED_KEY, CheckboxType::class, [
                'label' => 'mango.open_invoice.admin.form.channel.is_open_invoice_only_for_registered.label',
            ])
            ->add(self::OPEN_INVOICE_SUCCESS_ORDERS_LIMIT_KEY, IntegerType::class, [
                'label' => 'mango.open_invoice.admin.form.channel.success_orders_limit.label',
                'empty_data' => 0,
                'attr' => [
                    'min' => 0,
                    'max' => 32767,
                ],
                'constraints' => [
                    new Range([
                        'groups' => 'sylius',
                        'min' => 0,
                        'max' => 32767,
                    ]),
                ],
            ]);
    }
}
