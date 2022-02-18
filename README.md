# Saml2 Bearer Client CAS Library

This Package Is Laravel CAS Configuration Based Saml2 for Single Sign On Purpose

## Installation - Composer

You can install the package via composer:

```
composer require conf09/saml2-bearer
```

Or manually add this to your composer.json:

**composer.json**

```json
"conf09/saml2-bearer": "*"
```

If you are using Laravel 5.5 and up, the service provider will automatically get registered.

For older versions of Laravel (<5.5), you have to add the service provider:

**config/app.php**

```php
'providers' => [
        ...
    	Saml\Bearer\Saml2BearerProvider::class,
]
```

#### Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="Saml\Bearer\Saml2BearerProvider"
```

#### Configuration .env files

```
SAML2_CAS_IDP_HOST= // contain about cas url “https://<host>/cas”
SAML2_CAS_IDP_x509= // contain of public x509 # contact developer of cas for this information
```

Configuration Middleware For Authentication

```PHP
//this enable authentication if not authenticate in application

$saml2Bearer = Saml2Bearer::make();

return $saml2Bearer->getSamlAuth()->login(URL::full());
```

we need to configure event when the cas server is back for authentication Token And Data We Get

#### Configuration Event On EventServiceProvider.php in boot() function

```php
Event::listen(Saml2LoginEvent::class, function (Saml2LoginEvent $event) {
    // your logic application here
});

```

Done
