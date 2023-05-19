<?php

namespace Slakbal\Gotowebinar\Entity;

use Illuminate\Support\Arr;

class EntityAbstract
{
    public function determineLocale()
    {
        switch (strtolower(config('app.locale'))) {
            case "en":
                return "en_US";
                break;
            case "de":
                return "de_DE";
                break;
            default:
                return null;
        }
    }

    public function toArray()
    {
        //list of variables to be filtered
        $blacklist = [
            'webinarKey',
            'registrationUrl',
            'participants',
        ];

        return Arr::where(get_object_vars($this), function ($value, $key) use ($blacklist) {

            if (!in_array($key, $blacklist)) {
                return !empty($value);
            }

        });
    }
}
