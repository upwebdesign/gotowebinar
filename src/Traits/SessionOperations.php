<?php

namespace Slakbal\Gotowebinar\Traits;


trait SessionOperations
{

    /*
         * Retrieves details for all past sessions of a specific webinar.
         */
    function getSessions($webinarKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/sessions', $webinarKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Retrieves attendance details for a specific webinar session that has ended.
     * If attendees attended the session ('registrantsAttended'), specific attendance details, such as
     * attendenceTime for a registrant, will also be retrieved. For technical reasons, this call cannot
     * be executed from this documentation. Please use the curl command to execute it.
     */
    function getSession($webinarKey, $sessionKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/sessions/%s', $webinarKey, $sessionKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /*
     * Get performance details for a session. For technical reasons, this call cannot be executed from
     * this documentation. Please use the curl command to execute it.
     */
    function getSessionPerformance($webinarKey, $sessionKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/sessions/%s/performance', $webinarKey, $sessionKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }


    /**
     * [getSessionPolls description]
     *
     * @param  [type] $webinarKey [description]
     * @param  [type] $sessionKey [description]
     *
     * @return [type]             [description]
     */
    public function getSessionPolls($webinarKey, $sessionKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/sessions/%s/polls', $webinarKey, $sessionKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }

    /**
     * [getSessionQuestions description]
     *
     * @param  [type] $webinarKey [description]
     * @param  [type] $sessionKey [description]
     *
     * @return [type]             [description]
     */
    public function getSessionQuestions($webinarKey, $sessionKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/sessions/%s/questions', $webinarKey, $sessionKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }

    /**
     * [getSessionSurveys description]
     *
     * @param  string $webinarKey
     * @param  string $sessionKey
     */
    public function getSessionSurveys($webinarKey, $sessionKey)
    {
        $path = $this->getPathRelativeToOrganizer(sprintf('webinars/%s/sessions/%s/surveys', $webinarKey, $sessionKey));

        return $this->sendRequest('GET', $path, $parameters = null, $payload = null);
    }
}
