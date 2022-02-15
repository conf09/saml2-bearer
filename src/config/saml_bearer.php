<?php

return [

    /**
     * |--------------------------------------------------------------------------
     * | OAUTH2 CONFGURATION
     * |--------------------------------------------------------------------------
     * 
     * this will configuration the saml bearer Authentication Request
     * 
     */

    /**
     *  The Client ID From Cas Configuration
     * 
     */
    'client_id' => '',

    /**
     * The Client Secret From Cas Configuration 
     * 
     */
    'client_secret' => '',

    /**
     * This Will Be Verify The Cert On Guzzle Request
     * 
     */
    'verify' => false,

    /**
     *  Application Aliases That WillBe Assertation On Saml Bearer
     * 
     *  For Example This will be Scope Validated
     */
    'app_alias' => 'My App',

    /**
     * Saml Guard Auth User
     * 
     */
    'saml_guard' => 'web',
];
