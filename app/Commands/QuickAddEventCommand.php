<?php

namespace App\Commands;

use App\Events\Data\QuickAddEventRequest;
use App\Events\EventsFacade;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QuickAddEventCommand extends AbstractCommand
{
    const CALENDAR_ID_ARGUMENT = 'Calendar ID';
    const TEXT_ARGUMENT = 'Text';

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
            ->setName('events:quick-add')
            ->setDescription('Adds an event to the calendar')
            ->addArgument(static::CALENDAR_ID_ARGUMENT, InputArgument::REQUIRED, 'The calendar id')
            ->addArgument(static::TEXT_ARGUMENT, InputArgument::REQUIRED, 'The event description');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $quickAddEventRequest = $this->createRequest($input);
        $response = $this->eventsFacade->quickSave($quickAddEventRequest);

        if (!$response->success) {
            $this->writeError($output, $response->errorMessage);

            return;
        }

        $this->writeInfo($output, 'Done');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @return \App\Events\Data\QuickAddEventRequest
     */
    private function createRequest(InputInterface $input)
    {
        $quickAddEventRequest = new QuickAddEventRequest();
        $quickAddEventRequest->calendarId = $input->getArgument(static::CALENDAR_ID_ARGUMENT);
        $quickAddEventRequest->text = $input->getArgument(static::TEXT_ARGUMENT);

        return $quickAddEventRequest;
    }
}