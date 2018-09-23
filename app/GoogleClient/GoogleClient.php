<?php

namespace App\GoogleClient;

use Google_Client;
use Google_Service_Calendar;

class GoogleClient
{
    const CREDENTIALS_FILE_PATH = ROOT_DIR . DIRECTORY_SEPARATOR . 'credentials.json';
    const ACCESS_TYPE = 'offline';
    const PROMPT = 'select_account consent';
    const CREDENTIALS_FROM_ENV = 'CALENDAR_API_CREDENTIALS';

    public function create()
    {
        $client = new Google_Client();
        $client->setApplicationName('Alfred Google Calendar Manager');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig($this->getCredentials());
        $client->setAccessType(static::ACCESS_TYPE);
        $client->setPrompt(static::PROMPT);

        return $client;
    }

    /**
     * @return array|false|string
     */
    protected function getCredentials()
    {
        $credentialsFromEnvironment = getenv(static::CREDENTIALS_FROM_ENV);

        if ($credentialsFromEnvironment === false) {
            return static::CREDENTIALS_FILE_PATH;
        }

        return json_decode($credentialsFromEnvironment, true);
    }
}