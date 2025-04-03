<?php

namespace Slakbal\Gotowebinar;

use Slakbal\Gotowebinar\Traits\GotoClient;

class DirectLogin
{

    use GotoClient;

    protected $path = 'oauth/token';


    public function authenticate()
    {
        return $this->getAuthObject($this->path, $this->getParameters());
    }


    private function getParameters()
    {
        return [
            'grant_type' => "password",
            'username'    => config('goto.direct.username'),
            'password'   => config('goto.direct.password')
        ];
    }
}
