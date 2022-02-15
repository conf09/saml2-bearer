<?php

namespace Saml\Bearer\Oauth;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class OauthTokenManager implements OauthTokenContract
{
    const SESS_KEY = 'oauth_token_parameter';
    const SESS_EXP = 'oauth_token_expired';

    /**
     * This Will be Contain Oauth Token
     */
    private $token;

    /**
     * Expired Time
     * 
     */
    private $expiredTime;

    /**
     * Guzzle Client
     *
     * @var Client
     */
    private $client;

    private $clientId;

    private $clientSecret;


    public function __construct($baseUrl, $verify, $guzzleConfig = [])
    {
        $this->client = new Client(array_merge(['base_uri' => $baseUrl, 'verify' => $verify], $guzzleConfig));

        $this->reloadToken();
    }

    public function setCredentials($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Reload Token From Session To Object
     * 
     */
    public function reloadToken()
    {
        if (session()->has(static::SESS_KEY)) {
            $this->setToken(session()->get(static::SESS_KEY));
            $this->setExpired(session()->get(static::SESS_EXP));
        }
    }

    /**
     * Set Token From Token Repository
     * 
     * @return void
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }


    public function setExpired($time)
    {
        $this->expiredTime = $time;
    }

    public function getExpired()
    {
        return $this->expiredTime;
    }


    /**
     * 
     * @return String
     */
    public function requestNewToken()
    {

        $response = $this->client->post('/oauth2.0/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => 'ikbal',
                'client_secret' => 'mulyadi',
                // 'assertion' => $user->getRawSamlAssertion(),
            ]
        ]);

        $result = (\json_decode((string)$response->getBody()));

        $this->setToken($result->access_token);
        $this->setExpired($result->expired_at);

        session()->put([
            static::SESS_KEY => $result->access_token,
            static::SESS_EXP => $result->expired_at,
        ]);

        return $this->getToken();
    }

    // not implemented
    public function revokeToken()
    {
    }

    public function hasValidToken()
    {

        $profile = (array)$this->getProfileByToken($this->getToken());

        return \array_key_exists('error', $profile) ? false : true;
    }

    /**
     * get Profile Id
     * 
     * @return Object|ResponseInterface 
     */
    public function getProfileByToken($token, $guzzleReturn = false)
    {

        if (!isset($this->token)) return false;

        $response = $this->client->get('/oauth2.0/profile?access_token=' . $this->getToken());

        if ($guzzleReturn) return $response;

        return \json_decode((string)$response->getBody());
    }
}
