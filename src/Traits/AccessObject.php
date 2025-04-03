<?php

namespace Slakbal\Gotowebinar\Traits;

use Carbon\Carbon;
use Httpful\Request;
use Illuminate\Support\Facades\Log;
use Slakbal\Gotowebinar\DirectLogin;
use Slakbal\Gotowebinar\Exception\GotoAuthenticateException;


trait AccessObject
{

    private $authObject; //holds all the values returned after auth

    private $tokenExpiryMinutes = 7 * 24 * 60; //expire the authObject every 7 days - re-auth for a new one


    function getOrganizerKey()
    {
        return $this->authObject->organizer_key;
    }


    function getAccountKey()
    {
        return $this->authObject->account_key;
    }


    function getAccessToken()
    {
        return $this->authObject->access_token;
    }


    function refreshToken()
    {
        $this->clearAccessObject(); //clear cached object

        $this->directLogin(); //perform fresh directLogin to get a new authObject

        return $this->authObject;
    }


    function clearAccessObject()
    {
        cache()->forget('GOTO_ACCESS_OBJECT');

        return $this;
    }


    function hasAccessObject()
    {
        return cache()->has('GOTO_ACCESS_OBJECT');
    }


    private function directLogin()
    {
        $directAuth = new DirectLogin();

        try {
            $this->authObject = $directAuth->authenticate(); //the method returns authObject
        } catch (GotoAuthenticateException $e) {
            $this->clearAccessObject(); //make sure the object is cleared from the cache to force a login retry
            throw $e; //bubble the exception up by rethrowing
        }

        $response = Request::get('https://api.getgo.com/admin/rest/v1/me')
            ->addHeader('Authorization', 'Bearer ' . $this->authObject->access_token) // Add the Bearer token
            ->expectsJson() // Expect a JSON response
            ->send();

        if ($response->code == 200) {
            $this->authObject->organizer_key = $response->body->key;
            $this->authObject->account_key = $response->body->accountKey;
        }

        $this->rememberAccessObject($this->authObject); //cache the authObject

        Log::info('GOTOWEBINAR: Successfully renewed AuthenticationObject');

        return $this->authObject;
    }


    private function rememberAccessObject($authObject)
    {
        cache()->put('GOTO_ACCESS_OBJECT', $authObject, Carbon::now()->addSeconds($authObject->expires_in));
    }


    private function checkAccessObject($authType)
    {
        //If no Authenticate Object, perform authentication to receive new access object with fresh tokens, etc.
        if (!$this->hasAccessObject()) {

            switch (strtolower($authType)) {

                case 'direct':

                    $this->directLogin();
                    break;

                case 'oauth2':

                    //not yet implemented
                    break;

                default:

                    $this->directLogin();
                    break;
            }

        } else {
            $this->authObject = $this->getAccessObject();
        }
    }


    private function getAccessObject()
    {
        return cache()->get('GOTO_ACCESS_OBJECT');
    }
}