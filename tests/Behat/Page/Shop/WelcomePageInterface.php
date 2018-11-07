<?php

declare(strict_types=1);

namespace Tests\MangoSylius\OpenInvoicePlugin\Behat\Page\Shop;

use Sylius\Behat\Page\PageInterface;

interface WelcomePageInterface extends PageInterface
{
	/**
	 * @return string
	 */
	public function getGreeting(): string;
}
