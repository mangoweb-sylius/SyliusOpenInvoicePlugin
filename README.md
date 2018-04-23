<p align="center">
    <a href="https://www.mangoweb.cz/en/" target="_blank">
        <img src="https://scontent-frt3-1.cdninstagram.com/vp/26bfb179e047c1712d684c8a40422b54/5B99250B/t51.2885-19/s150x150/12394163_769607056476857_462554822_a.jpg" height="75"/>
    </a>
    <a href="http://sylius.com" title="Sylius" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" width="300" />
    </a>
</p>
<h1 align="center">Open Invoice Plugin</h1>


## Installation

1. Run `$ composer require mangoweb-sylius/sylius-open-invoice-plugin`.

2. Add plugin dependencies to your AppKernel.php

```php
public function registerBundles()
{
	...
	$bundles[] = new \MangoSylius\SyliusOpenInvoicePlugin\MangoSyliusOpenInvoicePlugin();
}
```
