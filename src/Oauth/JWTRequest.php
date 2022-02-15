<?php

namespace Saml\Bearer\Oauth;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JWTRequest
{
    /**
     * 
     * @var Request
     */
    private $request;

    public function bearerToken()
    {
        $header = $this->request->header('Authorization', false);

        if (!$header) return false;

        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }
}
