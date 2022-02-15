<?php

namespace Saml\Bearer;

use OneLogin\Saml2\Utils as OneLogin_Saml2_Utils;
use Illuminate\Support\ServiceProvider;
use Saml\Bearer\Oauth\OauthTokenManager;

class Saml2BearerProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (config('saml2_settings.useRoutes', false) == true) {
            include __DIR__ . '/routes.php';
        }

        $this->publishes([
            __DIR__ . '/config/saml2_settings.php' => config_path('saml2_settings.php'),
            __DIR__ . '/config/cas_idp_settings.php' => config_path('saml2' . DIRECTORY_SEPARATOR . 'cas_idp_settings.php'),
        ]);

        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'courier-migrations');

        if (config('saml2_settings.proxyVars', false)) {
            OneLogin_Saml2_Utils::setProxyVars(true);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Saml2Auth::class, function ($app) {
            $idpName = env('IDP_NAME', 'cas');
            $auth = Saml2Auth::loadOneLoginAuthFromIpdConfig($idpName);
            return new Saml2Auth($auth);
        });

        $this->app->singleton(Saml2Bearer::class, function ($app) {
            // Set Oauth Token Manager
            $oauthTokenManager = new OauthTokenManager(env('SAML2_CAS_IDP_HOST', ''), env('CAS_VERIFY', false));

            $oauthTokenManager->setCredentials(env('CAS_OAUTH_CLIENT', ''), env('CAS_OAUTH_PASSWORD', ''));

            return new Saml2Bearer($oauthTokenManager, env('IDP_NAME', 'cas'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Saml2Auth::class];
    }
}
