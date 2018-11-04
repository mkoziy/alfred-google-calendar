<?php

namespace App\Events\Data;

use Katapoka\Katapoka\Dto;

/**
 * @property string date
 * @property string calendarId
 */
class EventsListRequest
{
    use Dto;
}