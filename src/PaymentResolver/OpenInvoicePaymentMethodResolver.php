<?php

declare(strict_types=1);

namespace MangoSylius\OpenInvoicePlugin\PaymentResolver;

use MangoSylius\OpenInvoicePlugin\Form\Type\OpenInvoiceConfigurationType;
use Payum\Core\Model\GatewayConfigInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
use Sylius\Component\Payment\Model\PaymentInterface as BasePaymentInterface;
use Sylius\Component\Payment\Resolver\PaymentMethodsResolverInterface;
use Webmozart\Assert\Assert;

class OpenInvoicePaymentMethodResolver implements PaymentMethodsResolverInterface
{
	/**
	 * @var PaymentMethodRepositoryInterface
	 */
	private $paymentMethodRepository;

	public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository)
	{
		$this->paymentMethodRepository = $paymentMethodRepository;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSupportedMethods(BasePaymentInterface $payment): array
	{
		assert($payment instanceof PaymentInterface);
		Assert::true($this->supports($payment), 'This payment method is not supported by resolver');

		$order = $payment->getOrder();
		assert($order instanceof OrderInterface);

		$channel = $order->getChannel();
		assert($channel instanceof ChannelInterface);

		$customer = $order->getCustomer();
		assert($customer instanceof CustomerInterface);

		$enabledForChannel = $this->paymentMethodRepository->findEnabledForChannel($channel);
		$result = [];
		foreach ($enabledForChannel as $paymentMethod) {
			if ($this->isPaymentMethodAllowedForCustomer($paymentMethod, $customer)) {
				$result[] = $paymentMethod;
			}
		}

		return $result;
	}

	/**
	 * {@inheritdoc}
	 */
	public function supports(BasePaymentInterface $payment): bool
	{
		if (
			!$payment instanceof PaymentInterface ||
			$payment->getOrder() === null ||
			$payment->getMethod() === null
		) {
			return false;
		}

		$method = $payment->getMethod();
		$order = $payment->getOrder();

		return
			$order instanceof OrderInterface &&
			$order->getChannel() !== null &&
			$method instanceof PaymentMethodInterface &&
			$method->getGatewayConfig() !== null;
	}

	private function isPaymentMethodAllowedForCustomer(
		PaymentMethodInterface $paymentMethod, CustomerInterface $customer
	): bool {
		$gatewayConfigProvider = $paymentMethod->getGatewayConfig();
		assert($gatewayConfigProvider instanceof GatewayConfigInterface);

		if ($gatewayConfigProvider->getFactoryName() !== 'open_invoice') {
			return true;
		}

		$customerSuccessOrderCount = $customer->getOrders()->filter(function (OrderInterface $order) {
			return $order->getState() === OrderInterface::STATE_FULFILLED;
		})->count();

		$gatewayConfig = $gatewayConfigProvider->getConfig();

		if (
			$gatewayConfig[OpenInvoiceConfigurationType::OPEN_INVOICE_SUCCESS_ORDERS_LIMIT_KEY] > $customerSuccessOrderCount
			|| ($gatewayConfig[OpenInvoiceConfigurationType::IS_OPEN_INVOICE_ONLY_FOR_REGISTERED_KEY] && $customer->getUser() === null)
		) {
			return false;
		}

		return true;
	}
}
