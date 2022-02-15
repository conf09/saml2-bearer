<?php

namespace Saml\Bearer\Events;

use Illuminate\Database\Eloquent\Model;
use Saml\Bearer\Saml2User;
use Saml\Bearer\Saml2Auth;

class Saml2LoginEvent extends Saml2Event
{

    protected $user;
    protected $auth;
    protected $model;

    function __construct($idp, Saml2User $user, Saml2Auth $auth, $model)
    {
        parent::__construct($idp);
        $this->user = $user;
        $this->auth = $auth;
        $this->model = $model;
    }

    public function getSaml2User()
    {
        return $this->user;
    }

    public function getSaml2Auth()
    {
        return $this->auth;
    }

    public function getSamlId()
    {
        return $this->user->getAttribute('id')[0];
    }

    public function getModel()
    {
        return $this->model;
    }
}
