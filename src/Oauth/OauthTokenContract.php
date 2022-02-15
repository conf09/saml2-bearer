<?php

namespace Saml\Bearer\Oauth;

interface OauthTokenContract
{

    /**
     * Get Fresh Token From The CAS Server
     * 
     * @return void
     */
    public function requestNewToken();

    /**
     * Get Token From Repository
     * 
     * @return String
     */
    public function getToken();

    /**
     * Revoke Token Deleted Token
     * 
     * @return void
     */
    public function revokeToken();

    /**
     * Validate Token If The Token Was Not Exists Or The Token Was Exipred
     * 
     * @return bool
     */
    public function hasValidToken();

    /**
     * Get Profile From Cas Vertification
     * 
     * @return Object
     */
    public function getProfileByToken($token);
}
