<?php

namespace App\Events;

use App\Events\QuickSaver\EventQuickSaver;

class EventsFacade
{
    /**
     * @var \App\Events\QuickSaver\EventQuickSaver
     */
    private $quickSaver;

    public function __construct()
    {
        $this->quickSaver = new EventQuickSaver();
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
}