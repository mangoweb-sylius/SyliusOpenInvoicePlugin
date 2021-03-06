<?php

declare(strict_types=1);

namespace MangoSylius\OpenInvoicePlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MangoSyliusOpenInvoiceExtension extends Extension
{
	/**
	 * {@inheritdoc}
	 */
	public function load(array $config, ContainerBuilder $container): void
	{
		$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.yml');
	}
}
