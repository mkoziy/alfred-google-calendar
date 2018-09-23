<?php

namespace App\Events\QuickSaver;

use App\Events\Data\QuickAddEventRequest;
use App\Events\Data\QuickAddEventResponse;
use App\GoogleClient\GoogleClient;
use Google_Service_Calendar;

class EventQuickSaver
{
    const CONFIRMED_STATUS = 'confirmed';

    /**
     * @var \Google_Service_Calendar
     */
    private $service;

    /**
     * @var \App\GoogleClient\GoogleClient
     */
    private $client;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->service = new Google_Service_Calendar($this->client->create());
    }

    /**
     * @param \App\Events\Data\QuickAddEventRequest $request
     *
     * @return \App\Events\Data\QuickAddEventResponse
     */
    public function save(QuickAddEventRequest $request)
    {
        $response = new QuickAddEventResponse();

        try {
            $event = $this->service
                ->events
                ->quickAdd($request->getCalendarId(), $request->getText());
        } catch (\Google_Service_Exception $exception) {
            $response->setErrorMessage($this->getErrorMessage($exception));

            return $response;
        }

        $response->setSuccess($event->getStatus() === static::CONFIRMED_STATUS);

        return $response;
    }

    /**
     * @param \Google_Service_Exception $exception
     *
     * @return string
     */
    protected function getErrorMessage(\Google_Service_Exception $exception)
    {
        $error = json_decode($exception->getMessage(), true);

        return sprintf('Google Service: %s', $error['error']['message']);
    }
}