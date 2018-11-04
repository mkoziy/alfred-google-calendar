<?php

namespace App\Events;

use App\Events\Data\EventsListRequest;
use App\Events\QuickSaver\EventQuickSaver;
use App\Events\Reader\EventsDailyReader;

class EventsFacade
{
    /**
     * @var \App\Events\QuickSaver\EventQuickSaver
     */
    private $quickSaver;

    /**
     * @var \App\Events\Reader\EventsDailyReader
     */
    private $dailyReader;

    public function __construct()
    {
        $this->quickSaver = new EventQuickSaver();
        $this->dailyReader = new EventsDailyReader();
    }

    /**
     * @param $parameters
     *
     * @return \App\Events\Data\QuickAddEventResponse
     */
    public function quickSave($parameters)
    {
        return $this->quickSaver->save($parameters);
    }

    /**
     * @param \App\Events\Data\EventsListRequest $request
     *
     * @return \App\Events\Data\EventsListResponse
     */
    public function getDailyList(EventsListRequest $request)
    {
        return $this->dailyReader->getList($request);
    }
}