<?php

namespace Saml\Bearer;

use PDO;
use Saml\Bearer\Oauth\OauthTokenManager;

class Saml2Bearer
{

    static function make()
    {
        return \resolve(static::class);
    }

    /**
     * @var OauthTokenManager
     * 
     */
    public $oauthTokenManager;

    /**
     * @var Saml2Auth 
     * 
     */
    private $samlAuth;

    public function __construct(OauthTokenManager $oauthTokenManager, $idpName)
    {
        $this->oauthTokenManager = $oauthTokenManager;

        $this->samlAuth = new Saml2Auth(Saml2Auth::loadOneLoginAuthFromIpdConfig($idpName));
    }

    /**
     * Load the IDP config file and construct a OneLogin\Saml2\Auth (aliased here as OneLogin_Saml2_Auth).
     * Pass the returned value to the Saml2Auth constructor.
     * 
     * @return Saml2Auth
     */
    public function getSamlAuth()
    {
        return $this->samlAuth;
    }
}
