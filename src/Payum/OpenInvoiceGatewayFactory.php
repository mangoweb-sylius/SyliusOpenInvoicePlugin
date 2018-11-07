<?php

declare(strict_types=1);

namespace MangoSylius\OpenInvoicePlugin\Payum;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class OpenInvoiceGatewayFactory extends GatewayFactory
{
	protected function populateConfig(ArrayObject $config)
	{
		$config->defaults([
			'payum.factory_name' => 'open_invoice',
			'payum.factory_title' => 'Open Invoice',
		]);

		$config['payum.default_options'] = [
			'isOpenInvoiceOnlyForRegistered' => true,
			'openInvoiceSuccessOrdersLimit' => 3,
		];

		$config->defaults($config['payum.default_options']);

		$config['payum.required_options'] = [
			'isOpenInvoiceOnlyForRegistered',
			'openInvoiceSuccessOrdersLimit',
		];
	}
}
