<?php

namespace App\Events\Reader;

use App\Events\Data\EventsListRequest;
use App\Events\Data\EventsListResponse;
use App\GoogleClient\GoogleClient;
use Carbon\Carbon;
use Google_Service_Calendar;

class EventsDailyReader
{
    const ORDER_BY_START_TIME = 'startTime';
    const NO_EVENTS_FOUND_MESSAGE = 'No events were found';

    /**
     * @var \Google_Service_Calendar
     */
    private $service;

    /**
     * @var \App\GoogleClient\GoogleClient
     */
    private $client;

    /**
     * @var \App\Events\Reader\EventFormatter
     */
    private $formatter;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->service = new Google_Service_Calendar($this->client->create());
        $this->formatter = new EventFormatter();
    }

    /**
     * @param \App\Events\Data\EventsListRequest $request
     *
     * @return \App\Events\Data\EventsListResponse
     */
    public function getList(EventsListRequest $request)
    {
        $results = $this->service
            ->events
            ->listEvents($request->calendarId, $this->getOptions($request));

        return $this->createResponse($results->getItems());
    }

    /**
     * @param \App\Events\Data\EventsListRequest $request
     * @return string
     */
    private function getMinimumTime(EventsListRequest $request)
    {
        $dateTime = new Carbon();
        $dateTime->setDateFrom($request->date);

        return $dateTime->startOfDay()->toRfc3339String();
    }

    /**
     * @param \App\Events\Data\EventsListRequest $request
     * @return string
     */
    private function getMaximumTime(EventsListRequest $request)
    {
        $dateTime = new Carbon();
        $dateTime->setDateFrom($request->date);

        return $dateTime->endOfDay()->toRfc3339String();
    }

    /**
     * @param \App\Events\Data\EventsListRequest $request
     *
     * @return array
     */
    private function getOptions(EventsListRequest $request)
    {
        return [
            'orderBy' => static::ORDER_BY_START_TIME,
            'singleEvents' => true,
            'timeMin' => $this->getMinimumTime($request),
            'timeMax' => $this->getMaximumTime($request),
        ];
    }

    /**
     * @param \Google_Service_Calendar_Event[] $events
     *
     * @return \App\Events\Data\EventsListResponse
     */
    private function createResponse($events)
    {
        $response = new EventsListResponse();

        if (count($events) === 0) {
            $response->success = false;
            $response->errorMessage = static::NO_EVENTS_FOUND_MESSAGE;

            return $response;
        }

        $response->success = true;
        $response->events = $this->formatEvents($events);

        return $response;
    }

    /**
     * @param \Google_Service_Calendar_Event[] $events
     *
     * @return array
     */
    private function formatEvents($events)
    {
        $result = [];

        foreach ($events as $event) {
            $result[] = $this->formatter->format($event);
        }

        return $result;
    }
}