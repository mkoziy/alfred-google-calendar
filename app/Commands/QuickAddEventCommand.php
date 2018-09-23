<?php

namespace App\Commands;

use App\Events\Data\QuickAddEventRequest;
use App\Events\EventsFacade;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QuickAddEventCommand extends Command
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

        if (!$response->isSuccess()) {
            $this->writeError($output, $response->getErrorMessage());

            return;
        }

        $this->writeInfo($output, 'Done');
    }

    private function createRequest(InputInterface $input)
    {
        $quickAddEventRequest = new QuickAddEventRequest();
        $quickAddEventRequest->setCalendarId($input->getArgument(static::CALENDAR_ID_ARGUMENT));
        $quickAddEventRequest->setText($input->getArgument(static::TEXT_ARGUMENT));

        return $quickAddEventRequest;
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param string $message
     */
    private function writeError(OutputInterface $output, $message)
    {
        $output->writeln(sprintf('<error>%s</error>', $message));
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param string $message
     */
    private function writeInfo(OutputInterface $output, $message)
    {
        $output->writeln(sprintf('<info>%s</info>', $message));
    }
}