<?php

namespace App\Commands;

use App\Events\Data\EventsListRequest;
use App\Events\EventsFacade;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EventsDailyListCommand extends AbstractCommand
{
    const CALENDAR_ID_ARGUMENT = 'Calendar ID';
    const DATE_ARGUMENT = 'Date';
    const DATE_VALIDATION_ERROR_MESSAGE = 'Date is in wrong format';

    /**
     * @var \App\Events\EventsFacade
     */
    private $eventsFacade;

    public function __construct()
    {
        parent::__construct();

        $this->eventsFacade = new EventsFacade();
    }

    /**
     * @return void
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('events:daily-list')
            ->setDescription('Show the list of events for the specific date')
            ->addArgument(static::CALENDAR_ID_ARGUMENT, InputArgument::REQUIRED, 'The calendar id')
            ->addArgument(static::DATE_ARGUMENT, InputArgument::OPTIONAL, 'The date to get events', 'today');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $eventsListRequest = $this->createRequest($input);

        if (!$this->validDate($eventsListRequest)) {
            $this->writeError($output, static::DATE_VALIDATION_ERROR_MESSAGE);

            return;
        }

        $response = $this->eventsFacade->getDailyList($eventsListRequest);

        if (!$response->success) {
            $this->writeError($output, $response->errorMessage);

            return;
        }

        $this->writeList($output, $response->events);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return \App\Events\Data\EventsListRequest
     */
    private function createRequest(InputInterface $input)
    {
        $quickAddEventRequest = new EventsListRequest();
        $quickAddEventRequest->calendarId = $input->getArgument(static::CALENDAR_ID_ARGUMENT);
        $quickAddEventRequest->date = $input->getArgument(static::DATE_ARGUMENT);

        return $quickAddEventRequest;
    }

    /**
     * @param \App\Events\Data\EventsListRequest $request
     * @return bool
     */
    private function validDate(EventsListRequest $request)
    {
        return strtotime($request->date) !== false;
    }
}