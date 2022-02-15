<?php

namespace Saml\Bearer\Middleware;

use Closure;
use Illuminate\Http\Request;
use Saml\Bearer\Oauth\JWTRequest;
use Saml\Bearer\Saml2Bearer;

class ApiPermissionOauth
{

    public function errRes()
    {
        return response(['error' => 'Your Not Authorization To This Server !!!'], 401);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, Saml2Bearer $saml2Bearer, JWTRequest $jwtRequest)
    {

        // check Has Auth Header Or Not
        if (!($token = $jwtRequest->bearerToken())) return $this->errRes();

        // Set Oauth Token
        $saml2Bearer->oauthTokenManager->setToken($token);

        // check validate of token
        if ($saml2Bearer->oauthTokenManager->hasValidToken()) return $next($request);

        // error response
        return $this->errRes();
    }
}
