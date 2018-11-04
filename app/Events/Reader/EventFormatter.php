<?php

namespace App\Events\Reader;

use Carbon\Carbon;
use Google_Service_Calendar_Event;

class EventFormatter
{
    /**
     * @param \Google_Service_Calendar_Event $event
     *
     * @return string
     */
    public function format(Google_Service_Calendar_Event $event)
    {
        $summary = $event->getSummary();
        $startDateTime = new Carbon($event->getStart()->getDateTime());
        $endDateTime = new Carbon($event->getEnd()->getDateTime());

        return sprintf(
            '%s - %s %s',
            $startDateTime->format('H:i'),
            $endDateTime->format('H:i'),
            $summary
        );
    }
}