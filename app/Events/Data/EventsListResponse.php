<?php

namespace App\Events\Data;

use Katapoka\Katapoka\Dto;

/**
 * @property boolean success
 * @property array events
 * @property string errorMessage
 */
class EventsListResponse
{
    use Dto;
}